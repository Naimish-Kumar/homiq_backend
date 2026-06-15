<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Property;
use Illuminate\Http\Request;

class PropertyController extends Controller
{
    /**
     * Display a listing of properties (with filtering).
     */
    public function index(Request $request)
    {
        $query = Property::with('owner');

        // Apply filters
        if ($request->has('category') && $request->category !== 'All') {
            $query->where('category', $request->category);
        }

        if ($request->has('listing_type') && $request->listing_type !== 'All') {
            $query->where('listing_type', $request->listing_type);
        }

        if ($request->has('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('title', 'like', "%{$search}%")
                  ->orWhere('address', 'like', "%{$search}%");
            });
        }

        if ($request->has('min_price')) {
            $query->where('price', '>=', $request->min_price);
        }

        if ($request->has('max_price')) {
            $query->where('price', '<=', $request->max_price);
        }

        if ($request->has('bedrooms')) {
            $query->where('bedrooms', '>=', $request->bedrooms);
        }

        if ($request->has('bathrooms')) {
            $query->where('bathrooms', '>=', $request->bathrooms);
        }

        if ($request->has('is_furnished')) {
            $query->where('is_furnished', $request->boolean('is_furnished'));
        }

        if ($request->has('has_parking')) {
            $query->where('has_parking', $request->boolean('has_parking'));
        }

        if ($request->has('is_pet_friendly')) {
            $query->where('is_pet_friendly', $request->boolean('is_pet_friendly'));
        }

        // Only show approved properties to general public/renters
        // Unless they specifically filter for their own listings
        if ($request->has('owner_id')) {
            $query->where('owner_id', $request->owner_id);
        } else {
            $query->where('status', 'approved');
        }

        // Filter by country
        if ($request->has('country') && $request->country !== 'All') {
            $query->where('country', $request->country);
        } elseif (!$request->has('owner_id')) {
            // Auto-detect country based on user IP address
            $userIp = $request->ip();
            $detectedCountry = \App\Helpers\LocationHelper::detectCountryFromIp($userIp);
            if ($detectedCountry) {
                // Check if any listings exist in this country before filtering (fallback strategy)
                $exists = (clone $query)->where('country', $detectedCountry)->exists();
                if ($exists) {
                    $query->where('country', $detectedCountry);
                }
            }
        }

        $properties = $query->latest()->get();

        return response($properties, 200);
    }

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
            'images' => 'nullable|array|max:5',
            'existing_images' => 'nullable|array|max:5',
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
        ]);

        $fields['listing_type'] = $request->input('listing_type') ?: 'rent';

        $fields['currency'] = $request->input('currency') ?: 'INR';
        $fields['billing_frequency'] = $request->input('billing_frequency') ?: 'monthly';
        $fields['country'] = $request->input('country') ?: 'India';

        $user = $request->user();

        // Enforce subscription listing limits
        $currentCount = Property::where('owner_id', $user->id)->count();
        $limit = 10; // default free
        if ($user->subscription_plan === 'standard') {
            $limit = 50;
        } elseif ($user->subscription_plan === 'unlimited') {
            $limit = 999999;
        }

        if ($currentCount >= $limit) {
            return response([
                'message' => "You have reached the maximum listings limit for your plan ($limit properties). Please upgrade your subscription.",
            ], 400);
        }

        // Process file uploads for property images
        $imageUrls = [];
        if ($request->hasFile('images')) {
            $files = $request->file('images');
            if (is_array($files)) {
                foreach ($files as $file) {
                    $fileName = time() . '_' . uniqid() . '.' . $file->getClientOriginalExtension();
                    $file->move(public_path('uploads/properties'), $fileName);
                    $imageUrls[] = asset('uploads/properties/' . $fileName);
                }
            } else {
                $fileName = time() . '_' . uniqid() . '.' . $files->getClientOriginalExtension();
                $files->move(public_path('uploads/properties'), $fileName);
                $imageUrls[] = asset('uploads/properties/' . $fileName);
            }
        }

        // Merge any string URLs passed
        if ($request->has('images')) {
            $inputImages = $request->input('images');
            if (is_array($inputImages)) {
                foreach ($inputImages as $img) {
                    if (is_string($img) && !empty($img)) {
                        $imageUrls[] = $img;
                    }
                }
            }
        }
        if ($request->has('existing_images')) {
            $existing = $request->input('existing_images');
            if (is_array($existing)) {
                foreach ($existing as $img) {
                    if (is_string($img) && !empty($img)) {
                        $imageUrls[] = $img;
                    }
                }
            }
        }
        $fields['images'] = $imageUrls;
        unset($fields['existing_images']);

        // Create property listing as pending approval by default
        $property = Property::create(array_merge($fields, [
            'owner_id' => $user->id,
            'status' => 'pending',
        ]));

        // Notify admins about the new property submission
        try {
            $admins = \App\Models\User::where('is_admin', true)->get();
            $notificationService = app(\App\Services\NotificationService::class);
            foreach ($admins as $admin) {
                $notificationService->notify(
                    $admin,
                    'New Property Listed',
                    'A new property listing "' . $property->title . '" has been submitted by ' . $user->name . ' and is pending approval.',
                    'info'
                );
            }
        } catch (\Exception $e) {
            \Illuminate\Support\Facades\Log::error('PropertyController store notification error: ' . $e->getMessage());
        }

        return response($property->load('owner'), 201);
    }

    /**
     * Display the specified property.
     */
    public function show($id)
    {
        $property = Property::with(['owner', 'reviews.booking.renter'])->find($id);

        if (!$property) {
            return response([
                'message' => 'Property not found'
            ], 404);
        }

        return response($property, 200);
    }

    /**
     * Update the specified property.
     */
    public function update(Request $request, $id)
    {
        $property = Property::find($id);

        if (!$property) {
            return response([
                'message' => 'Property not found'
            ], 404);
        }

        // Check ownership
        if ($property->owner_id !== $request->user()->id) {
            return response([
                'message' => 'Unauthorized'
            ], 403);
        }

        // Only allow update when listing is pending or rejected
        if (!in_array($property->status, ['pending', 'rejected'])) {
            return response([
                'message' => 'You can only update properties that are currently pending or rejected.'
            ], 400);
        }

        $fields = $request->validate([
            'title' => 'string|max:255',
            'description' => 'string',
            'price' => 'numeric|min:0',
            'address' => 'string|max:255',
            'latitude' => 'nullable|numeric',
            'longitude' => 'nullable|numeric',
            'amenities' => 'nullable|array',
            'images' => 'nullable|array|max:5',
            'existing_images' => 'nullable|array|max:5',
            'category' => 'string|max:255',
            'bedrooms' => 'integer|min:0',
            'bathrooms' => 'integer|min:0',
            'is_furnished' => 'boolean',
            'has_parking' => 'boolean',
            'is_pet_friendly' => 'boolean',
            'currency' => 'nullable|string|in:INR,USD,EUR,GBP',
            'billing_frequency' => 'nullable|string|in:monthly,per_day,hourly',
            'country' => 'nullable|string|max:255',
            'status' => 'string|in:pending,approved,rejected',
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
        ]);

        $imageUrls = [];
        $hasNewImages = false;

        // Process file uploads
        if ($request->hasFile('images')) {
            $hasNewImages = true;
            $files = $request->file('images');
            if (is_array($files)) {
                foreach ($files as $file) {
                    $fileName = time() . '_' . uniqid() . '.' . $file->getClientOriginalExtension();
                    $file->move(public_path('uploads/properties'), $fileName);
                    $imageUrls[] = asset('uploads/properties/' . $fileName);
                }
            } else {
                $fileName = time() . '_' . uniqid() . '.' . $files->getClientOriginalExtension();
                $files->move(public_path('uploads/properties'), $fileName);
                $imageUrls[] = asset('uploads/properties/' . $fileName);
            }
        }

        // Process existing image URLs
        if ($request->has('images') || $request->has('existing_images')) {
            $hasNewImages = true;
            
            $inputImages = [];
            if ($request->has('images')) {
                $inputImages = array_merge($inputImages, (array)$request->input('images'));
            }
            if ($request->has('existing_images')) {
                $inputImages = array_merge($inputImages, (array)$request->input('existing_images'));
            }

            foreach ($inputImages as $img) {
                if (is_string($img) && !empty($img)) {
                    $imageUrls[] = $img;
                }
            }
        }

        if ($hasNewImages) {
            $fields['images'] = $imageUrls;
        }

        unset($fields['existing_images']);

        $property->update($fields);

        return response($property->load('owner'), 200);
    }

    /**
     * Remove the specified property.
     */
    public function destroy(Request $request, $id)
    {
        $property = Property::find($id);

        if (!$property) {
            return response([
                'message' => 'Property not found'
            ], 404);
        }

        // Check ownership
        if ($property->owner_id !== $request->user()->id) {
            return response([
                'message' => 'Unauthorized'
            ], 403);
        }

        $property->delete();

        return response([
            'message' => 'Property deleted successfully'
        ], 200);
    }
}
