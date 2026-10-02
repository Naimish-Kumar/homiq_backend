<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Feedback;
use App\Models\Notification;
use App\Models\Property;
use App\Models\PropertyReport;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class ContactApiController extends Controller
{
    /**
     * Submit contact / support form from app.
     */
    public function submitContact(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:100',
            'email' => 'required|email|max:150',
            'phone' => 'nullable|string|max:30',
            'category' => 'required|string|max:100',
            'subject' => 'nullable|string|max:200',
            'message' => 'required|string|max:3000',
            'property_id' => 'nullable|numeric',
        ]);

        $userId = Auth::guard('sanctum')->id();

        // Save into Feedback table for audit record
        $feedback = Feedback::create([
            'user_id' => $userId,
            'type' => $validated['category'],
            'stars' => 5,
            'area' => 'Contact Support Desk: ' . ($validated['subject'] ?? $validated['category']),
            'feedback' => "From: {$validated['name']} ({$validated['email']}, Phone: " . ($validated['phone'] ?? 'N/A') . ")\nCategory: {$validated['category']}\nMessage: {$validated['message']}",
        ]);

        // Send Notification to Admins
        $admins = User::where('is_admin', true)->get();
        foreach ($admins as $admin) {
            Notification::create([
                'user_id' => $admin->id,
                'title' => "New Support Ticket: " . ucfirst(str_replace('_', ' ', $validated['category'])),
                'message' => "From {$validated['name']} ({$validated['email']}): " . Str::limit($validated['message'], 120),
                'type' => 'support_ticket',
                'is_read' => false,
            ]);
        }

        return response()->json([
            'success' => true,
            'message' => 'Thank you for reaching out! Our team has received your request and will get back to you within 24 business hours.',
            'feedback_id' => $feedback->id,
        ], 201);
    }

    /**
     * Report a property listing for violation or fraud.
     */
    public function reportProperty(Request $request, $id)
    {
        $property = Property::findOrFail($id);

        $validated = $request->validate([
            'reason' => 'required|string|in:' . implode(',', array_keys(PropertyReport::REASONS)),
            'details' => 'nullable|string|max:1500',
            'reporter_name' => 'nullable|string|max:100',
            'reporter_contact' => 'nullable|string|max:100',
        ]);

        $user = Auth::guard('sanctum')->user();

        $report = PropertyReport::create([
            'property_id' => $property->id,
            'user_id' => $user?->id,
            'reporter_name' => $validated['reporter_name'] ?? ($user?->name ?? 'Anonymous App User'),
            'reporter_contact' => $validated['reporter_contact'] ?? ($user?->email ?? $user?->phone ?? null),
            'reason' => $validated['reason'],
            'details' => $validated['details'] ?? null,
            'ip_address' => $request->ip(),
            'status' => 'pending',
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Thank you for helping keep HomiQ safe and transparent. Our Trust & Safety team has received your report and will audit this listing within 4 hours.',
            'report' => $report,
        ], 201);
    }
}
