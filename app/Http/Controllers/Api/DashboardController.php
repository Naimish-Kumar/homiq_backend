<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Booking;
use App\Models\Property;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    /**
     * Renter Dashboard Metrics & Feed.
     */
    public function renterDashboard(Request $request)
    {
        $user = $request->user('sanctum');

        $categoriesList = \App\Models\Category::select('name', 'image')->get()->map(function ($cat) {
            $image = $cat->image;
            if ($image && !str_starts_with($image, 'http://') && !str_starts_with($image, 'https://')) {
                $image = asset($image);
            }
            return [
                'name' => $cat->name,
                'image' => $image,
            ];
        })->toArray();
        $categories = array_merge([[
            'name' => 'All',
            'image' => 'https://images.unsplash.com/photo-1564013799919-ab600027ffc6?w=500&auto=format&fit=crop&q=80',
        ]], $categoriesList);

        $specifications = \App\Models\Specification::pluck('name')->toArray();
        $features = \App\Models\KeyFeature::pluck('name')->toArray();
        $amenities = \App\Models\Amenity::pluck('name')->toArray();

        // Base query scope for approved properties not owned by user
        $baseQuery = function() use ($user) {
            $query = Property::where('status', 'approved')->with('owner');
            if ($user) {
                $query->where('owner_id', '!=', $user->id);
            }
            return $query;
        };

        // Fetch featured properties (auto-approved in our database)
        $featured = $baseQuery()->latest()->take(5)->get();

        // Fetch recommended properties
        $recommended = $baseQuery()->inRandomOrder()->take(10)->get();

        // ── Curated Home Sections ──────────────────────────────
        // Top Flats Nearby You
        $topFlatsQuery = $baseQuery()->where('category', 'Apartment');
        if ($request->has(['latitude', 'longitude'])) {
            $lat = $request->latitude;
            $lng = $request->longitude;
            $topFlatsQuery->selectRaw("*, (6371 * acos(cos(radians(?)) * cos(radians(latitude)) * cos(radians(longitude) - radians(?)) + sin(radians(?)) * sin(radians(latitude)))) AS distance", [$lat, $lng, $lat])
                          ->orderBy('distance');
        } else {
            $topFlatsQuery->latest();
        }
        $topFlats = $topFlatsQuery->take(8)->get();

        // Best PG for Girls
        $bestPg = $baseQuery()
            ->where('category', 'PG')
            ->latest()
            ->take(8)
            ->get();

        // Single Rooms Nearby You
        $singleRooms = $baseQuery()
            ->where('category', 'Room')
            ->latest()
            ->take(8)
            ->get();

        // Elite Business & Event Venues
        $eliteVenues = $baseQuery()
            ->whereIn('category', ['Hall', 'Shop'])
            ->latest()
            ->take(8)
            ->get();

        // Urban Studios & Condos
        $urbanStudios = $baseQuery()
            ->where('category', 'Studio')
            ->latest()
            ->take(8)
            ->get();

        // Count active bookings (pending or approved)
        $activeBookingsCount = 0;
        if ($user) {
            $activeBookingsCount = Booking::where('renter_id', $user->id)
                ->whereIn('status', ['pending', 'approved'])
                ->count();
        }

        return response([
            'categories' => $categories,
            'specifications' => $specifications,
            'key_features' => $features,
            'amenities' => $amenities,
            'featured' => $featured,
            'recommended' => $recommended,
            'active_bookings_count' => $activeBookingsCount,
            'sections' => [
                [
                    'key' => 'top_flats',
                    'title' => 'Top Flats Nearby You',
                    'subtitle' => 'Handpicked apartments',
                    'icon' => 'apartment',
                    'properties' => $topFlats,
                ],
                [
                    'key' => 'best_pg',
                    'title' => 'Best PG for Girls',
                    'subtitle' => 'Safe & verified PGs',
                    'icon' => 'female',
                    'properties' => $bestPg,
                ],
                [
                    'key' => 'single_rooms',
                    'title' => 'Single Rooms Nearby You',
                    'subtitle' => 'Budget-friendly rooms',
                    'icon' => 'hotel',
                    'properties' => $singleRooms,
                ],
                [
                    'key' => 'elite_venues',
                    'title' => 'Elite Business & Event Venues',
                    'subtitle' => 'Premium halls & spaces',
                    'icon' => 'business',
                    'properties' => $eliteVenues,
                ],
                [
                    'key' => 'urban_studios',
                    'title' => 'Urban Studios & Condos',
                    'subtitle' => 'Compact modern living',
                    'icon' => 'location_city',
                    'properties' => $urbanStudios,
                ],
            ],
        ], 200);
    }

    /**
     * Host Dashboard Metrics & Recent requests.
     */
    public function hostDashboard(Request $request)
    {
        $user = $request->user();

        // Verify user is a host
        if (!$user->is_host) {
            return response([
                'message' => 'User is not registered as a Host'
            ], 403);
        }

        $totalListings = Property::where('owner_id', $user->id)->count();

        $activeBookings = Booking::whereHas('property', function ($query) use ($user) {
            $query->where('owner_id', $user->id);
        })->whereIn('status', ['approved', 'pending'])->count();

        // Earnings from completed bookings
        $totalEarnings = Booking::whereHas('property', function ($query) use ($user) {
            $query->where('owner_id', $user->id);
        })->where('status', 'completed')->sum('total_price');

        // Recent booking requests
        $recentRequests = Booking::whereHas('property', function ($query) use ($user) {
            $query->where('owner_id', $user->id);
        })->with(['property', 'renter'])
          ->latest()
          ->take(5)
          ->get();

        return response([
            'total_listings' => $totalListings,
            'active_bookings' => $activeBookings,
            'total_earnings' => doubleval($totalEarnings),
            'recent_requests' => $recentRequests,
        ], 200);
    }
}
