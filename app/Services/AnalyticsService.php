<?php

namespace App\Services;

use App\Models\AnalyticsEvent;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Request;
use Illuminate\Support\Facades\Session;

class AnalyticsService
{
    /**
     * Track a standard or custom analytics event.
     */
    public function track(
        string $eventName,
        array $params = [],
        ?string $funnelType = null,
        ?string $funnelStep = null,
        ?int $userId = null,
        ?int $propertyId = null,
        ?string $sessionId = null
    ): AnalyticsEvent {
        $userId = $userId ?: Auth::id();
        $sessionId = $sessionId ?: (Session::isStarted() ? Session::getId() : null);

        // Auto-assign funnel type & step if omitted based on standard naming
        if (!$funnelType || !$funnelStep) {
            $inferred = $this->inferFunnelMapping($eventName);
            $funnelType = $funnelType ?: $inferred['funnel_type'];
            $funnelStep = $funnelStep ?: $inferred['funnel_step'];
        }

        return AnalyticsEvent::create([
            'event_name' => $eventName,
            'funnel_type' => $funnelType,
            'funnel_step' => $funnelStep,
            'user_id' => $userId,
            'session_id' => $sessionId,
            'property_id' => $propertyId,
            'metadata' => $params,
            'ip_address' => Request::ip(),
            'user_agent' => Request::userAgent(),
        ]);
    }

    /**
     * Map common event names to corresponding funnel steps.
     */
    protected function inferFunnelMapping(string $eventName): array
    {
        $map = [
            'homepage_view' => ['funnel_type' => 'seeker', 'funnel_step' => 'visitor'],
            'search_started' => ['funnel_type' => 'seeker', 'funnel_step' => 'search'],
            'search_completed' => ['funnel_type' => 'seeker', 'funnel_step' => 'search'],
            'property_viewed' => ['funnel_type' => 'seeker', 'funnel_step' => 'property_view'],
            'property_saved' => ['funnel_type' => 'seeker', 'funnel_step' => 'property_view'],
            'property_shared' => ['funnel_type' => 'seeker', 'funnel_step' => 'property_view'],
            'contact_owner_clicked' => ['funnel_type' => 'seeker', 'funnel_step' => 'contact_owner'],
            'whatsapp_clicked' => ['funnel_type' => 'seeker', 'funnel_step' => 'contact_owner'],
            'visit_requested' => ['funnel_type' => 'seeker', 'funnel_step' => 'contact_owner'],
            'signup_started' => ['funnel_type' => 'general', 'funnel_step' => 'signup'],
            'signup_completed' => ['funnel_type' => 'general', 'funnel_step' => 'signup'],
            'listing_started' => ['funnel_type' => 'owner', 'funnel_step' => 'list_property'],
            'listing_completed' => ['funnel_type' => 'owner', 'funnel_step' => 'listing_created'],
            'listing_verified' => ['funnel_type' => 'owner', 'funnel_step' => 'verification'],
            'demand_request_created' => ['funnel_type' => 'seeker', 'funnel_step' => 'inquiry'],
            'app_download_clicked' => ['funnel_type' => 'general', 'funnel_step' => 'app_download'],
        ];

        return $map[$eventName] ?? ['funnel_type' => 'general', 'funnel_step' => null];
    }

    /**
     * Task 47: Seeker Funnel Metrics
     * Visitor -> Search -> Property View -> Contact Owner -> Signup -> Inquiry
     */
    public function getSeekerFunnelMetrics(?string $from = null, ?string $to = null): array
    {
        $query = AnalyticsEvent::query();
        if ($from) $query->where('created_at', '>=', $from);
        if ($to) $query->where('created_at', '<=', $to);

        $steps = [
            'visitor' => ['label' => '1. Visitor (Homepage / Landing)', 'events' => ['homepage_view']],
            'search' => ['label' => '2. Search Initiated / Completed', 'events' => ['search_started', 'search_completed']],
            'property_view' => ['label' => '3. Property View / Details', 'events' => ['property_viewed']],
            'contact_owner' => ['label' => '4. Contact Owner / WhatsApp / Visit', 'events' => ['contact_owner_clicked', 'whatsapp_clicked', 'visit_requested']],
            'signup' => ['label' => '5. Signup Completed', 'events' => ['signup_completed']],
            'inquiry' => ['label' => '6. Demand Request / In-App Inquiry', 'events' => ['demand_request_created']],
        ];

        $results = [];
        $topCount = null;

        foreach ($steps as $key => $config) {
            $count = (clone $query)->whereIn('event_name', $config['events'])->count();
            if ($topCount === null) {
                $topCount = max($count, 1);
            }

            $conversionRate = round(($count / max($topCount, 1)) * 100, 1);

            $results[$key] = [
                'step' => $key,
                'label' => $config['label'],
                'count' => $count,
                'conversion_rate_pct' => $conversionRate,
            ];
        }

        return [
            'funnel' => 'seeker',
            'title' => 'Tenant & Seeker Conversion Funnel',
            'steps' => array_values($results),
            'total_visitors' => $results['visitor']['count'] ?? 0,
            'total_inquiries' => $results['inquiry']['count'] ?? 0,
        ];
    }

    /**
     * Task 47: Owner Funnel Metrics
     * Visitor -> List Property -> Signup -> Listing Created -> Verification -> Listing Published -> First Inquiry
     */
    public function getOwnerFunnelMetrics(?string $from = null, ?string $to = null): array
    {
        $query = AnalyticsEvent::query();
        if ($from) $query->where('created_at', '>=', $from);
        if ($to) $query->where('created_at', '<=', $to);

        $steps = [
            'visitor' => ['label' => '1. Owner Landing / Homepage View', 'events' => ['homepage_view']],
            'list_property' => ['label' => '2. List Property Started', 'events' => ['listing_started']],
            'signup' => ['label' => '3. Owner Signup Completed', 'events' => ['signup_completed']],
            'listing_created' => ['label' => '4. Listing Form Completed', 'events' => ['listing_completed']],
            'verification' => ['label' => '5. Listing On-Site Verified', 'events' => ['listing_verified']],
            'listing_published' => ['label' => '6. Listing Published / Approved', 'events' => ['listing_verified', 'listing_completed']],
            'first_inquiry' => ['label' => '7. First Tenant Lead / Inquiry', 'events' => ['contact_owner_clicked', 'whatsapp_clicked', 'visit_requested']],
        ];

        $results = [];
        $topCount = null;

        foreach ($steps as $key => $config) {
            $count = (clone $query)->whereIn('event_name', $config['events'])->count();
            if ($topCount === null) {
                $topCount = max($count, 1);
            }

            $conversionRate = round(($count / max($topCount, 1)) * 100, 1);

            $results[$key] = [
                'step' => $key,
                'label' => $config['label'],
                'count' => $count,
                'conversion_rate_pct' => $conversionRate,
            ];
        }

        return [
            'funnel' => 'owner',
            'title' => 'Property Owner Acquisition Funnel',
            'steps' => array_values($results),
            'total_visitors' => $results['visitor']['count'] ?? 0,
            'total_inquiries' => $results['first_inquiry']['count'] ?? 0,
        ];
    }

    /**
     * Summary of top events recorded.
     */
    public function getTopEventsSummary(int $limit = 10): array
    {
        return AnalyticsEvent::selectRaw('event_name, count(*) as total')
            ->groupBy('event_name')
            ->orderByDesc('total')
            ->limit($limit)
            ->get()
            ->toArray();
    }
}

