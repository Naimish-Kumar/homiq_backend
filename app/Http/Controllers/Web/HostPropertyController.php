<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Models\Property;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class HostPropertyController extends Controller
{
    /**
     * Show the form for creating a new property.
     */
    public function create()
    {
        return view('host.add-property');
    }

    /**
     * Store a newly created property in storage.
     */
    public function store(Request $request)
    {
        $fields = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'price' => 'required|numeric|min:0',
            'address' => 'required|string|max:255',
            'latitude' => 'nullable|numeric',
            'longitude' => 'nullable|numeric',
            'amenities' => 'nullable|array',
            'images.*' => 'nullable|image|max:10240', // 10MB max per image
            'category' => 'required|string|max:255',
            'bedrooms' => 'required|integer|min:0',
            'bathrooms' => 'required|integer|min:0',
            'is_furnished' => 'boolean',
            'has_parking' => 'boolean',
            'is_pet_friendly' => 'boolean',
            'currency' => 'nullable|string|in:INR,USD,EUR,GBP',
            'billing_frequency' => 'nullable|string|in:monthly,per_day,hourly',
            'country' => 'nullable|string|max:255',
            'listing_type' => 'nullable|string|in:rent,sale',
            'property_age' => 'nullable|string|max:255',
            'ownership_type' => 'nullable|string|max:255',
            'built_up_area' => 'nullable|integer|min:0',
            'is_negotiable' => 'boolean',
            'is_rera_approved' => 'boolean',
            'price_unit' => 'nullable|string|max:255',
            'plot_area' => 'nullable|numeric|min:0',
            'boundary_wall' => 'boolean',
            'preferred_tenant' => 'nullable|string|max:255',
            'supports_group_renting' => 'boolean',
            'group_max_size' => 'nullable|integer|min:2|max:10',
            'security_deposit' => 'nullable|numeric|min:0',
            'lease_duration' => 'nullable|string|max:255',
            'available_from' => 'nullable|date',
            'floor_number' => 'nullable|integer',
            'total_floors' => 'nullable|integer',
            'facing_direction' => 'nullable|string|max:255',
            'carpet_area' => 'nullable|integer|min:0',
        ]);

        $fields['listing_type'] = $request->input('listing_type') ?: 'rent';
        $fields['currency'] = $request->input('currency') ?: 'INR';
        $fields['billing_frequency'] = $request->input('billing_frequency') ?: 'monthly';
        $fields['country'] = $request->input('country') ?: 'India';

        $user = Auth::user();

        // Enforce subscription listing limits
        $currentCount = Property::where('owner_id', $user->id)->count();
        $baseLimit = 10;
        if ($user->subscription_plan === 'standard') {
            $baseLimit = 50;
        } elseif ($user->subscription_plan === 'unlimited') {
            $baseLimit = 999999;
        }

        $referredBonus = !empty($user->referred_by_id) ? 2 : 0;
        $referralBonus = \App\Models\User::where('referred_by_id', $user->id)->count() * 2;
        $limit = $baseLimit + $referredBonus + $referralBonus;

        if ($currentCount >= $limit) {
            return back()->with('error', "You have reached the maximum listings limit for your plan. ($limit properties).");
        }

        // Process file uploads for property images
        $imageUrls = [];
        if ($request->hasFile('images')) {
            $files = $request->file('images');
            foreach ($files as $file) {
                $fileName = time() . '_' . uniqid() . '.' . $file->getClientOriginalExtension();
                $file->move(public_path('uploads/properties'), $fileName);
                $imageUrls[] = asset('uploads/properties/' . $fileName);
            }
        }

        $fields['images'] = $imageUrls;

        // Default missing booleans
        $booleans = ['is_furnished', 'has_parking', 'is_pet_friendly', 'is_negotiable', 'is_rera_approved', 'boundary_wall', 'supports_group_renting'];
        foreach ($booleans as $bool) {
            if (!isset($fields[$bool])) {
                $fields[$bool] = false;
            }
        }

        // Create property listing as pending approval by default
        $property = Property::create(array_merge($fields, [
            'owner_id' => $user->id,
            'status' => 'pending',
        ]));

        // Notify admins
        try {
            $admins = \App\Models\User::where('is_admin', true)->get();
            $notificationService = app(\App\Services\NotificationService::class);
            foreach ($admins as $admin) {
                $notificationService->notify(
                    $admin,
                    'New Property Listed',
                    'A new property listing "' . $property->title . '" has been submitted by ' . $user->name . ' and is pending approval.',
                    [
                        'property_id' => $property->id,
                        'owner_id' => $user->id,
                    ]
                );
            }
        } catch (\Exception $e) {
            // Ignore notification failure
        }

        return redirect()->route('dashboard')->with('success', 'Your property has been submitted and is pending admin approval.');
    }
}
