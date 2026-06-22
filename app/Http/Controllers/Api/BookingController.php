<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Booking;
use App\Models\Property;
use App\Models\RoommateGroup;
use Illuminate\Http\Request;

class BookingController extends Controller
{
    /**
     * Display list of bookings.
     */
    public function index(Request $request)
    {
        $user = $request->user();
        $isHost = $request->boolean('is_host', false);

        if ($isHost) {
            // Find bookings for properties owned by this host
            $bookings = Booking::whereHas('property', function ($query) use ($user) {
                $query->where('owner_id', $user->id);
            })->with(['property', 'renter', 'roommateGroup.members'])->latest()->get();
        } else {
            // Find bookings made by this renter OR where they are a roommate in a group lease
            $bookings = Booking::where(function ($q) use ($user) {
                $q->where('renter_id', $user->id)
                  ->orWhereHas('roommateGroup.members', function ($memberQuery) use ($user) {
                      $memberQuery->where('user_id', $user->id);
                  });
            })->with(['property.owner', 'renter', 'roommateGroup.members'])->latest()->get();
        }

        return response($bookings, 200);
    }

    /**
     * Create a new booking.
     */
    public function store(Request $request)
    {
        $fields = $request->validate([
            'property_id' => 'required|exists:properties,id',
            'check_in' => 'required|date',
            'check_out' => 'required|date|after:check_in',
            'base_rent' => 'required|numeric|min:0',
            'taxes' => 'required|numeric|min:0',
            'platform_fee' => 'required|numeric|min:0',
            'total_price' => 'required|numeric|min:0',
            'roommate_group_id' => 'nullable|exists:roommate_groups,id',
        ]);

        $user = $request->user();
        $property = Property::find($fields['property_id']);

        if ($property->owner_id === $user->id) {
            return response([
                'message' => 'You cannot book your own property'
            ], 400);
        }

        $group = null;
        if (!empty($fields['roommate_group_id'])) {
            $group = RoommateGroup::find($fields['roommate_group_id']);
            if (!$group) {
                return response(['message' => 'Roommate group not found.'], 404);
            }

            if ($group->status !== 'ready') {
                return response(['message' => 'This roommate group is not ready or has already been booked.'], 400);
            }

            if (!$group->members()->where('user_id', $user->id)->exists()) {
                return response(['message' => 'You are not a member of this roommate group.'], 403);
            }

            if ($group->property_id !== $property->id) {
                return response(['message' => 'This roommate group does not match the property.'], 400);
            }
        }

        $booking = Booking::create(array_merge($fields, [
            'renter_id' => $user->id,
            'status' => 'pending',
        ]));

        if ($group) {
            // Update roommate group status to booked
            $group->update(['status' => 'booked']);
        }

        // Notify property owner about the new booking
        $property->load('owner');
        $notificationService = app(\App\Services\NotificationService::class);
        
        $renterName = $user->name;
        if ($group) {
            $renterName = "Roommate Group (led by " . $user->name . ")";
        }

        $notificationService->notify(
            $property->owner,
            'New Booking Request',
            'You have received a new booking request for "' . $property->title . '" from ' . $renterName . '.',
            'booking',
            true, // send email
            \App\Mail\BookingStatusMail::class,
            [$property->owner->name, $property->title, 'pending', $booking->check_in, $booking->check_out, (string) $booking->total_price, $property->currency]
        );

        if ($group) {
            // Also notify all roommates in the group about the booking request
            foreach ($group->members as $member) {
                if ($member->id !== $user->id) {
                    $notificationService->notify(
                        $member,
                        'Group Booking Placed',
                        'A group booking request for "' . $property->title . '" has been placed by ' . $user->name . '. Split Rent: ' . $property->currency_symbol . number_format($booking->total_price / $group->max_roommates, 2) . '/mo.',
                        'booking',
                        false
                    );
                }
            }
        }

        return response($booking->load(['property', 'renter', 'roommateGroup.members']), 201);
    }

    /**
     * Update booking status.
     */
    public function updateStatus(Request $request, $id)
    {
        $fields = $request->validate([
            'status' => 'required|string|in:pending,approved,rejected,cancelled,completed',
        ]);

        $booking = Booking::with(['property.owner', 'renter'])->find($id);

        if (!$booking) {
            return response([
                'message' => 'Booking not found'
            ], 404);
        }

        $user = $request->user();
        $newStatus = $fields['status'];
        $oldStatus = $booking->status;

        // Authorization checks
        $isOwner = ($booking->property->owner_id === $user->id);
        $isRenter = ($booking->renter_id === $user->id);

        if ($newStatus === 'cancelled') {
            // Renter or owner can cancel
            if (!$isOwner && !$isRenter) {
                return response(['message' => 'Unauthorized'], 403);
            }
        } else {
            // Only owner can approve, reject, or mark as completed
            if (!$isOwner) {
                return response(['message' => 'Unauthorized to update to status: ' . $newStatus], 403);
            }
        }

        $booking->update([
            'status' => $newStatus,
        ]);

        // Send notifications if status changed
        if ($oldStatus !== $newStatus) {
            $notificationService = app(\App\Services\NotificationService::class);
            
            if ($newStatus === 'cancelled') {
                // If renter cancelled, notify host. If host cancelled, notify renter.
                $recipient = $isRenter ? $booking->property->owner : $booking->renter;
                $notificationService->notify(
                    $recipient,
                    'Booking Cancelled',
                    'The booking for "' . $booking->property->title . '" has been cancelled.',
                    'booking',
                    true,
                    \App\Mail\BookingStatusMail::class,
                    [$recipient->name, $booking->property->title, 'cancelled', $booking->check_in, $booking->check_out, (string) $booking->total_price, $booking->property->currency]
                );
            } else {
                // Approved, rejected, or completed -> notify renter
                $title = 'Booking ' . ucfirst($newStatus);
                $message = 'Your booking for "' . $booking->property->title . '" has been ' . $newStatus . '.';
                
                // Completed doesn't necessarily need a detailed email compared to approved/rejected
                $sendEmail = in_array($newStatus, ['approved', 'rejected']);
                
                $notificationService->notify(
                    $booking->renter,
                    $title,
                    $message,
                    'booking',
                    $sendEmail,
                    $sendEmail ? \App\Mail\BookingStatusMail::class : null,
                    $sendEmail ? [$booking->renter->name, $booking->property->title, $newStatus, $booking->check_in, $booking->check_out, (string) $booking->total_price, $booking->property->currency] : []
                );
            }
        }

        return response($booking->load(['property', 'renter']), 200);
    }
}
