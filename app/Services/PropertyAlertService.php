<?php

namespace App\Services;

use App\Models\Property;
use App\Models\User;
use App\Models\SavedSearch;
use App\Models\Booking;
use App\Services\NotificationService;
use Illuminate\Support\Facades\Log;

class PropertyAlertService
{
    protected NotificationService $notificationService;

    public function __construct(NotificationService $notificationService)
    {
        $this->notificationService = $notificationService;
    }

    /**
     * 1. New Property Matching Saved Search Alert.
     */
    public function notifySavedSearchMatches(Property $property): int
    {
        $savedSearches = SavedSearch::where('is_active', true)->with('user')->get();
        $notifiedCount = 0;

        foreach ($savedSearches as $search) {
            $filters = $search->filters ?? [];
            $matches = true;

            // Don't notify the owner about their own property
            if ($search->user_id === $property->owner_id) {
                continue;
            }

            // Category check
            if (!empty($filters['category']) && strtolower($filters['category']) !== 'all') {
                if (strtolower($filters['category']) !== strtolower($property->category ?? '')) {
                    $matches = false;
                }
            }

            // Listing Type check
            if (!empty($filters['listing_type']) && in_array(strtolower($filters['listing_type']), ['rent', 'sale'])) {
                if (strtolower($filters['listing_type']) !== strtolower($property->listing_type ?? '')) {
                    $matches = false;
                }
            }

            // City / Locality check
            if (!empty($filters['city']) && strtolower($filters['city']) !== 'all') {
                $city = strtolower($filters['city']);
                $address = strtolower($property->address ?? '');
                if (!str_contains($address, $city)) {
                    $matches = false;
                }
            }

            // Bedrooms check
            if (!empty($filters['bedrooms']) && strtolower($filters['bedrooms']) !== 'all') {
                $bhk = (int) $filters['bedrooms'];
                if ($bhk >= 3) {
                    if (($property->bedrooms ?? 0) < 3) {
                        $matches = false;
                    }
                } elseif (($property->bedrooms ?? 0) !== $bhk) {
                    $matches = false;
                }
            }

            // Price checks
            if (!empty($filters['min_price']) && (float)$property->price < (float)$filters['min_price']) {
                $matches = false;
            }
            if (!empty($filters['max_price']) && (float)$property->price > (float)$filters['max_price']) {
                $matches = false;
            }

            if ($matches && $search->user) {
                $title = 'New Property Match: ' . ($search->title ?: 'Your Search');
                $priceStr = $property->formatted_price;
                $msg = "A new {$property->category} in {$property->address} is now available for {$priceStr} (0% Brokerage).";

                $this->notificationService->notify(
                    $search->user,
                    $title,
                    $msg,
                    'property_match',
                    false,
                    null,
                    [],
                    [
                        'property_id' => (string) $property->id,
                        'saved_search_id' => (string) $search->id,
                        'url' => $property->seo_url,
                    ]
                );
                $notifiedCount++;
            }
        }

        return $notifiedCount;
    }

    /**
     * 2. Price Reduced Alert (Notify interested seekers & past inquirers/bookers).
     */
    public function notifyPriceDrop(Property $property, float $previousPrice): int
    {
        $dropAmount = $previousPrice - (float) $property->price;
        if ($dropAmount <= 0) {
            return 0;
        }

        // Find seekers who inquired or booked this property
        $interestedUserIds = Booking::where('property_id', $property->id)
            ->where('renter_id', '!=', $property->owner_id)
            ->pluck('renter_id')
            ->unique();

        // Also find users with saved searches where the property now fits their budget
        $searchUserIds = SavedSearch::where('is_active', true)
            ->where('user_id', '!=', $property->owner_id)
            ->pluck('user_id')
            ->unique();

        $targetUserIds = $interestedUserIds->merge($searchUserIds)->unique()->filter();
        $users = User::whereIn('id', $targetUserIds)->get();

        $notifiedCount = 0;
        $title = 'Price Drop Alert: ' . $property->title;
        $formattedDrop = $property->currency_symbol . number_format($dropAmount, 0);
        $newPrice = $property->formatted_price;
        $msg = "Price reduced by {$formattedDrop}! '{$property->title}' is now listed for {$newPrice}.";

        foreach ($users as $user) {
            $this->notificationService->notify(
                $user,
                $title,
                $msg,
                'price_drop',
                false,
                null,
                [],
                [
                    'property_id' => (string) $property->id,
                    'previous_price' => (string) $previousPrice,
                    'new_price' => (string) $property->price,
                    'url' => $property->seo_url,
                ]
            );
            $notifiedCount++;
        }

        return $notifiedCount;
    }

    /**
     * 3. Listing Availability Updated Alert.
     */
    public function notifyAvailabilityUpdate(Property $property, ?string $customMessage = null): int
    {
        $interestedUserIds = Booking::where('property_id', $property->id)
            ->where('renter_id', '!=', $property->owner_id)
            ->pluck('renter_id')
            ->unique();

        $users = User::whereIn('id', $interestedUserIds)->get();
        $notifiedCount = 0;

        $title = 'Availability Update: ' . $property->title;
        $msg = $customMessage ?: "The availability for '{$property->title}' has been updated to: {$property->availability_badge}.";

        foreach ($users as $user) {
            $this->notificationService->notify(
                $user,
                $title,
                $msg,
                'availability_update',
                false,
                null,
                [],
                [
                    'property_id' => (string) $property->id,
                    'url' => $property->seo_url,
                ]
            );
            $notifiedCount++;
        }

        return $notifiedCount;
    }

    /**
     * 4. Owner Responded / Inquiry Update Alert.
     */
    public function notifyOwnerResponse(Property $property, User $seeker, string $responseSnippet): void
    {
        $title = 'Owner Responded: ' . $property->title;
        $msg = "The owner responded: \"{$responseSnippet}\" for property '{$property->title}'.";

        $this->notificationService->notify(
            $seeker,
            $title,
            $msg,
            'owner_response',
            false,
            null,
            [],
            [
                'property_id' => (string) $property->id,
                'owner_id' => (string) $property->owner_id,
                'url' => $property->seo_url,
            ]
        );
    }

    /**
     * 5. Similar Property Added in Favorite Locality Alert.
     */
    public function notifySimilarPropertyAdded(Property $newProperty): int
    {
        // Extract locality
        $parts = array_filter(explode(',', $newProperty->address));
        $locality = trim($parts[0] ?? '');
        if (empty($locality)) {
            return 0;
        }

        // Find seekers who searched or booked in this locality
        $interestedUserIds = Booking::whereHas('property', function ($q) use ($locality) {
            $q->where('address', 'like', "%{$locality}%");
        })->where('renter_id', '!=', $newProperty->owner_id)
          ->pluck('renter_id')
          ->unique();

        $users = User::whereIn('id', $interestedUserIds)->take(15)->get();
        $notifiedCount = 0;

        $title = "New Listing in {$locality}";
        $msg = "A new verified {$newProperty->category} ('{$newProperty->title}') was just listed near {$locality} for {$newProperty->formatted_price}.";

        foreach ($users as $user) {
            $this->notificationService->notify(
                $user,
                $title,
                $msg,
                'similar_property',
                false,
                null,
                [],
                [
                    'property_id' => (string) $newProperty->id,
                    'url' => $newProperty->seo_url,
                ]
            );
            $notifiedCount++;
        }

        return $notifiedCount;
    }
}

