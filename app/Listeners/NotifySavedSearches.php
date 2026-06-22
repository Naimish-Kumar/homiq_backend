<?php

namespace App\Listeners;

use App\Events\PropertyApproved;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use App\Models\SavedSearch;

class NotifySavedSearches implements ShouldQueue
{
    use InteractsWithQueue;

    public function handle(PropertyApproved $event): void
    {
        $property = $event->property;
        
        // Find saved searches that might match this property
        // For simplicity, we check if the category matches.
        // In a real scenario, you'd check all filters (price, location, etc.)
        
        $savedSearches = SavedSearch::where('is_active', true)->get();
        
        $notificationService = app(\App\Services\NotificationService::class);
        
        foreach ($savedSearches as $search) {
            $filters = $search->filters ?? [];
            $matches = true;
            
            if (isset($filters['category']) && $filters['category'] !== 'All' && $filters['category'] !== $property->category) {
                $matches = false;
            }
            if (isset($filters['min_price']) && $property->price < $filters['min_price']) {
                $matches = false;
            }
            if (isset($filters['max_price']) && $property->price > $filters['max_price']) {
                $matches = false;
            }
            
            if ($matches && $search->user) {
                // Send push notification via NotificationService
                $notificationService->notify(
                    $search->user,
                    'New Property Match!',
                    "A new {$property->category} matching your saved search '{$search->title}' is now available for {$property->currency} {$property->price}.",
                    'info',
                    ['property_id' => $property->id]
                );
            }
        }
    }
}
