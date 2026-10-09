<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Property;
use App\Models\PropertyRequest;
use App\Models\Notification;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PropertyRequestApiController extends Controller
{
    /**
     * List active seeker demands / requests.
     */
    public function index(Request $request)
    {
        $query = PropertyRequest::where('status', 'active');

        if ($request->filled('city')) {
            $query->where('city', 'like', '%' . $request->city . '%');
        }

        if ($request->filled('purpose')) {
            $query->where('purpose', $request->purpose);
        }

        if ($request->filled('property_type')) {
            $query->where('property_type', $request->property_type);
        }

        if ($request->filled('locality')) {
            $query->where('locality', 'like', '%' . $request->locality . '%');
        }

        if ($request->filled('bedrooms')) {
            $query->where('bedrooms', 'like', '%' . $request->bedrooms . '%');
        }

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('locality', 'like', "%{$search}%")
                  ->orWhere('city', 'like', "%{$search}%")
                  ->orWhere('description', 'like', "%{$search}%")
                  ->orWhere('bedrooms', 'like', "%{$search}%")
                  ->orWhere('property_type', 'like', "%{$search}%");
            });
        }

        if ($request->filled('max_budget')) {
            $query->where('max_budget', '<=', $request->max_budget);
        }

        $requests = $query->latest()->paginate($request->input('per_page', 20));

        return response()->json([
            'success' => true,
            'data' => $requests,
        ]);
    }

    /**
     * Store a new property demand request from a seeker.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'seeker_name' => 'required|string|max:100',
            'seeker_phone' => 'required|string|max:20',
            'seeker_email' => 'nullable|email|max:100',
            'city' => 'required|string|max:100',
            'locality' => 'nullable|string|max:150',
            'property_type' => 'required|string|max:50',
            'bedrooms' => 'nullable|string|max:30',
            'min_budget' => 'nullable|numeric|min:0',
            'max_budget' => 'required|numeric|min:500',
            'purpose' => 'nullable|string|in:rent,buy',
            'move_in_date' => 'nullable|string|max:50',
            'tenant_type' => 'nullable|string|max:50',
            'furnishing_preference' => 'nullable|string|max:50',
            'description' => 'nullable|string|max:1000',
        ]);

        $userId = Auth::guard('sanctum')->id();
        $user = Auth::guard('sanctum')->user();

        $propertyRequest = PropertyRequest::create([
            'user_id' => $userId,
            'seeker_name' => $validated['seeker_name'],
            'seeker_phone' => $validated['seeker_phone'],
            'seeker_email' => $validated['seeker_email'] ?? $user?->email,
            'city' => $validated['city'],
            'locality' => $validated['locality'] ?? null,
            'property_type' => $validated['property_type'],
            'bedrooms' => $validated['bedrooms'] ?? 'Any',
            'min_budget' => $validated['min_budget'] ?? null,
            'max_budget' => $validated['max_budget'],
            'purpose' => $validated['purpose'] ?? 'rent',
            'move_in_date' => $validated['move_in_date'] ?? 'Within 15 days',
            'tenant_type' => $validated['tenant_type'] ?? 'Working Professional',
            'furnishing_preference' => $validated['furnishing_preference'] ?? 'Any',
            'description' => $validated['description'] ?? null,
            'status' => 'active',
            'responses_count' => 0,
        ]);

        // Trigger notifications for matching property owners
        $matchingProperties = Property::approvedAndActive()
            ->where('listing_type', $propertyRequest->purpose)
            ->where(function ($q) use ($propertyRequest) {
                $q->where('address', 'like', "%{$propertyRequest->city}%");
                if ($propertyRequest->locality) {
                    $q->orWhere('address', 'like', "%{$propertyRequest->locality}%");
                }
            })
            ->where('price', '<=', $propertyRequest->max_budget * 1.15)
            ->with('owner')
            ->get();

        $notifiedOwnerIds = [];
        foreach ($matchingProperties as $matchedProp) {
            $owner = $matchedProp->owner;
            if ($owner && !in_array($owner->id, $notifiedOwnerIds) && $owner->id !== $userId) {
                $notifiedOwnerIds[] = $owner->id;
                Notification::create([
                    'user_id' => $owner->id,
                    'title' => 'New Matching Seeker Requirement!',
                    'message' => "A seeker is looking for a {$propertyRequest->bedrooms} {$propertyRequest->property_type} in {$propertyRequest->city} matching your listing '{$matchedProp->title}'.",
                    'type' => 'demand_match',
                    'is_read' => false,
                ]);
            }
        }

        return response()->json([
            'success' => true,
            'message' => 'Requirement posted successfully! Matching property owners have been notified.',
            'data' => $propertyRequest,
        ], 201);
    }

    /**
     * Get matching seeker demands for a landlord's property.
     */
    public function matchingDemands(Request $request, $id)
    {
        $user = $request->user();
        $property = Property::where('owner_id', $user->id)->findOrFail($id);

        $demands = PropertyRequest::active()->latest()->get()->filter(function ($demand) use ($property) {
            return $demand->matchesProperty($property);
        })->values();

        return response()->json([
            'success' => true,
            'property' => [
                'id' => $property->id,
                'title' => $property->title,
                'address' => $property->address,
                'price' => $property->price,
                'category' => $property->category,
                'bedrooms' => $property->bedrooms,
            ],
            'matches' => $demands->map(function ($d) {
                $phone = $d->seeker_phone ?? $d->phone ?? '';
                $name = $d->seeker_name ?? $d->name ?? 'Property Seeker';
                return [
                    'id' => $d->id,
                    'name' => $name,
                    'phone' => $phone,
                    'masked_phone' => strlen($phone) > 6 ? substr($phone, 0, 3) . '****' . substr($phone, -3) : $phone,
                    'whatsapp_url' => 'https://wa.me/91' . preg_replace('/[^0-9]/', '', $phone) . '?text=' . urlencode("Hi {$name}, I noticed your requirement on HomiQ for {$d->property_type} in {$d->city}. I have a verified property matching your budget."),
                    'purpose' => ucfirst($d->purpose ?? 'Rent'),
                    'property_type' => $d->property_type,
                    'city' => $d->city,
                    'locality' => $d->locality,
                    'bedrooms' => $d->bedrooms,
                    'min_budget' => $d->min_budget,
                    'max_budget' => $d->max_budget,
                    'tenant_type' => $d->tenant_type ? ucfirst(str_replace('_', ' ', $d->tenant_type)) : 'All Tenants',
                    'furnishing_preference' => $d->furnishing_preference ? ucfirst(str_replace('_', ' ', $d->furnishing_preference)) : 'Any Furnishing',
                    'move_in_date' => $d->move_in_date ?? 'Within 15 days',
                    'description' => $d->description,
                    'created_at' => $d->created_at?->toIso8601String(),
                ];
            }),
        ]);
    }
}
