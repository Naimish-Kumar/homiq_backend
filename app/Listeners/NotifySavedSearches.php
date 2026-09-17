<?php

namespace App\Listeners;

use App\Events\PropertyApproved;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use App\Services\PropertyAlertService;

class NotifySavedSearches implements ShouldQueue
{
    use InteractsWithQueue;

    public function handle(PropertyApproved $event): void
    {
        $property = $event->property;
        $alertService = app(PropertyAlertService::class);
        $alertService->notifySavedSearchMatches($property);
        $alertService->notifySimilarPropertyAdded($property);
    }
}
