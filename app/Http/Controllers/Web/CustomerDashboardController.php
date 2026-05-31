<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Models\Property;
use App\Models\Booking;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class CustomerDashboardController extends Controller
{
    /**
     * Render the customer center page.
     */
    public function index()
    {
        $user = Auth::user();
        
        if ($user->is_admin) {
            return redirect('/admin');
        }

        // 1. Fetch bookings made by the customer
        $bookings = Booking::where('renter_id', $user->id)
            ->with(['property.owner'])
            ->latest()
            ->get();

        // 2. Fetch properties listed by the customer
        $myListings = Property::where('owner_id', $user->id)
            ->latest()
            ->get();

        // 3. Fetch incoming booking requests for their properties
        $bookingRequests = Booking::whereHas('property', function ($query) use ($user) {
            $query->where('owner_id', $user->id);
        })->with(['property', 'renter'])->latest()->get();

        // 4. Calculate subscription limits
        $currentListingsCount = $myListings->count();
        $limit = 1;
        if ($user->subscription_plan === 'standard') {
            $limit = 5;
        } elseif ($user->subscription_plan === 'unlimited') {
            $limit = 999999;
        }

        return view('dashboard', compact('bookings', 'myListings', 'bookingRequests', 'currentListingsCount', 'limit'));
    }

    /**
     * Store new property listing from customer.
     */
    public function storeListing(Request $request)
    {
        $user = Auth::user();
        
        // Count listings
        $currentCount = Property::where('owner_id', $user->id)->count();
        $limit = 1;
        if ($user->subscription_plan === 'standard') {
            $limit = 5;
        } elseif ($user->subscription_plan === 'unlimited') {
            $limit = 999999;
        }

        if ($currentCount >= $limit) {
            return back()->withErrors(['limit' => "You have reached the limit of $limit listings for your plan. Please upgrade your subscription."]);
        }

        $fields = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'price' => 'required|numeric|min:0',
            'address' => 'required|string|max:255',
            'category' => 'required|string',
            'bedrooms' => 'required|integer|min:0',
            'bathrooms' => 'required|integer|min:0',
        ]);

        Property::create(array_merge($fields, [
            'owner_id' => $user->id,
            'status' => 'approved', // Auto-approve for demo convenience
            'amenities' => ['WiFi', 'AC', 'Parking'],
            'images' => ['https://images.unsplash.com/photo-1564013799919-ab600027ffc6?auto=format&fit=crop&w=800&q=80'],
        ]));

        return back()->with('success', 'Your property space has been successfully listed!');
    }

    /**
     * Make a reservation.
     */
    public function makeReservation(Request $request)
    {
        $fields = $request->validate([
            'property_id' => 'required|exists:properties,id',
            'check_in' => 'required|date|after_or_equal:today',
            'check_out' => 'required|date|after:check_in',
        ]);

        $user = Auth::user();
        $property = Property::findOrFail($fields['property_id']);

        if ($property->owner_id === $user->id) {
            return back()->withErrors(['error' => 'You cannot book your own property space.']);
        }

        // Calculate pricing
        $checkIn = new \DateTime($fields['check_in']);
        $checkOut = new \DateTime($fields['check_out']);
        $days = $checkIn->diff($checkOut)->days;
        if ($days < 1) $days = 1;

        $baseRent = $property->price * $days;
        $taxes = $baseRent * 0.10;
        $platformFee = $baseRent * 0.05;
        $total = $baseRent + $taxes + $platformFee;

        Booking::create([
            'property_id' => $property->id,
            'renter_id' => $user->id,
            'check_in' => $fields['check_in'],
            'check_out' => $fields['check_out'],
            'base_rent' => $baseRent,
            'taxes' => $taxes,
            'platform_fee' => $platformFee,
            'total_price' => $total,
            'status' => 'pending',
        ]);

        return redirect('/dashboard')->with('success', 'Your reservation request was sent successfully!');
    }

    public function updateProfile(Request $request)
    {
        $user = Auth::user();
        $fields = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users,email,' . $user->id,
            'phone' => 'required|string|max:20',
            'profile_photo' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        if ($request->hasFile('profile_photo')) {
            $file = $request->file('profile_photo');
            $filename = time() . '_' . $file->getClientOriginalName();
            $file->move(public_path('uploads/profiles'), $filename);
            $fields['profile_photo'] = '/uploads/profiles/' . $filename;
        }

        $user->update($fields);

        return back()->with('success', 'Your profile details have been successfully updated!');
    }

    /**
     * Update customer password.
     */
    public function updatePassword(Request $request)
    {
        $user = Auth::user();
        $request->validate([
            'current_password' => 'required|string',
            'new_password' => 'required|string|min:8|confirmed',
        ]);

        if (!Hash::check($request->current_password, $user->password)) {
            return back()->withErrors(['current_password' => 'The provided password does not match your current password.']);
        }

        $user->update([
            'password' => Hash::make($request->new_password)
        ]);

        return back()->with('success', 'Your password has been successfully changed!');
    }

    /**
     * Update status of stay reservation request.
     */
    public function updateReservationStatus(Request $request, $id)
    {
        $request->validate([
            'status' => 'required|in:approved,rejected',
        ]);

        $user = Auth::user();
        $booking = Booking::whereHas('property', function ($query) use ($user) {
            $query->where('owner_id', $user->id);
        })->findOrFail($id);

        $booking->update([
            'status' => $request->status,
        ]);

        // Send a notification to the customer/renter
        \App\Models\Notification::create([
            'user_id' => $booking->renter_id,
            'title' => 'Stay Reservation Update',
            'message' => "Your reservation request for '{$booking->property->title}' has been " . ucfirst($request->status) . " by the landlord.",
            'type' => 'booking',
        ]);

        return back()->with('success', 'Stay reservation has been successfully ' . $request->status . '!');
    }
}
