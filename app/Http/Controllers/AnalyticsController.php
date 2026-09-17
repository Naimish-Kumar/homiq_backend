<?php

namespace App\Http\Controllers;

use App\Services\AnalyticsService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class AnalyticsController extends Controller
{
    public function __construct(protected AnalyticsService $analytics)
    {
    }

    /**
     * Ingest an analytics event from frontend beacons or direct API.
     */
    public function recordEvent(Request $request): JsonResponse
    {
        $validated = $request->validate([
            'event_name' => 'required|string|max:100',
            'funnel_type' => 'nullable|string|max:50',
            'funnel_step' => 'nullable|string|max:50',
            'property_id' => 'nullable|integer|exists:properties,id',
            'metadata' => 'nullable|array',
        ]);

        $event = $this->analytics->track(
            eventName: $validated['event_name'],
            params: $validated['metadata'] ?? [],
            funnelType: $validated['funnel_type'] ?? null,
            funnelStep: $validated['funnel_step'] ?? null,
            userId: $request->user()?->id,
            propertyId: $validated['property_id'] ?? null,
            sessionId: $request->session()->getId()
        );

        return response()->json([
            'success' => true,
            'event_id' => $event->id,
            'event_name' => $event->event_name,
        ]);
    }

    /**
     * Retrieve Seeker & Owner Conversion Funnel metrics.
     */
    public function funnels(Request $request): JsonResponse
    {
        $from = $request->query('from');
        $to = $request->query('to');

        $seekerFunnel = $this->analytics->getSeekerFunnelMetrics($from, $to);
        $ownerFunnel = $this->analytics->getOwnerFunnelMetrics($from, $to);
        $topEvents = $this->analytics->getTopEventsSummary();

        return response()->json([
            'success' => true,
            'seeker_funnel' => $seekerFunnel,
            'owner_funnel' => $ownerFunnel,
            'top_events' => $topEvents,
        ]);
    }
}

