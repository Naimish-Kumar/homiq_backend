<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Models\Property;
use App\Models\Booking;
use App\Models\User;
use App\Models\Chat;
use App\Models\Message;
use App\Models\Notification;
use App\Models\PropertyRequest;
use App\Models\PropertyReport;
use App\Models\Feedback;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class WebHomeController extends Controller
{
    /**
     * Display public landing feed.
     */
    public function index(Request $request)
    {
        $search = $request->query('search');
        $rawSearch = $request->query('search');
        $search = $rawSearch;
        $selectedCity = $request->query('city', 'All');
        $locality = $request->query('locality');
        $searchType = $request->query('search_type');
        $collection = $request->query('collection');
        $listedBy = $request->query('listed_by');
        $nearMetro = $request->boolean('near_metro') || $request->query('near_metro') == '1';
        $availableNow = $request->boolean('available_now') || $request->query('availability') === 'immediate';
        $maxPrice = $request->query('max_price');
        $maxDeposit = $request->query('max_deposit');
        $sort = $request->query('sort', 'newest');
        $lat = $request->query('latitude');
        $lng = $request->query('longitude');

        $query = Property::with('owner')->approvedAndActive();

        // City filter
        // ── 1. NATURAL INTENT SEARCH PARSER ───────────────────────────
        if ($rawSearch) {
            $lowerSearch = strtolower($rawSearch);
            $residualSearch = $rawSearch;

            // Natural BHK Parser: "2 BHK", "3bhk", "1 bedroom", etc.
            if (!$request->filled('bedrooms') && preg_match('/(\d+)\s*(?:bhk|bedroom|bed)/i', $lowerSearch, $bhkMatches)) {
                $parsedBhk = (int) $bhkMatches[1];
                $query->where('bedrooms', $parsedBhk >= 3 ? '>=' : '=', $parsedBhk);
                $residualSearch = preg_replace('/(\d+)\s*(?:bhk|bedroom|bed)/i', '', $residualSearch);
            }

            // Natural Budget Parser: "under 25k", "under 25000", "below 15k", "under 1.5 cr", "max 40k"
            if (!$request->filled('max_price') && preg_match('/(?:under|below|max|within|less than)\s*(?:rs\.?|inr|₹)?\s*(\d+(?:\.\d+)?)\s*(k|lac|lakh|cr)?/i', $lowerSearch, $priceMatches)) {
                $num = (float) $priceMatches[1];
                $unit = strtolower($priceMatches[2] ?? '');
                if ($unit === 'k') {
                    $parsedBudget = $num * 1000;
                } elseif ($unit === 'lac' || $unit === 'lakh') {
                    $parsedBudget = $num * 100000;
                } elseif ($unit === 'cr') {
                    $parsedBudget = $num * 10000000;
                } else {
                    $parsedBudget = ($num < 500) ? $num * 1000 : $num;
                }
                $query->where('price', '<=', $parsedBudget);
                $residualSearch = preg_replace('/(?:under|below|max|within|less than)\s*(?:rs\.?|inr|₹)?\s*(\d+(?:\.\d+)?)\s*(k|lac|lakh|cr)?/i', '', $residualSearch);
            }

            // Natural Near Metro intent
            if (str_contains($lowerSearch, 'metro')) {
                $query->where(function ($q) {
                    $q->whereNotNull('distance_from_metro')
                      ->orWhere('amenities', 'like', '%metro%')
                      ->orWhere('description', 'like', '%metro%')
                      ->orWhere('address', 'like', '%metro%');
                });
                $residualSearch = preg_replace('/\b(near\s+metro|metro)\b/i', '', $residualSearch);
            }

            // Natural Furnished intent
            if (str_contains($lowerSearch, 'furnished') && !str_contains($lowerSearch, 'unfurnished') && !str_contains($lowerSearch, 'semi')) {
                $query->where('is_furnished', true);
                $residualSearch = preg_replace('/\b(fully\s+furnished|furnished)\b/i', '', $residualSearch);
            }

            // Natural Owner/Agent intent
            if (str_contains($lowerSearch, 'owner') || str_contains($lowerSearch, 'direct')) {
                $query->where('listed_by', 'owner');
                $residualSearch = preg_replace('/\b(by\s+owner|owner|direct)\b/i', '', $residualSearch);
            } elseif (str_contains($lowerSearch, 'agent') || str_contains($lowerSearch, 'broker')) {
                $query->where('listed_by', 'agent');
                $residualSearch = preg_replace('/\b(by\s+agent|agent|broker)\b/i', '', $residualSearch);
            }

            // Strip common stop words from residual query
            $residualSearch = preg_replace('/\b(in|near|at|for|rent|buy|sale)\b/i', '', $residualSearch);
            $cleanResidual = trim(preg_replace('/\s+/', ' ', $residualSearch));

            // Broad text match (Location / Title / Society / Category) on residual text if present
            if (strlen($cleanResidual) >= 2) {
                $query->where(function ($q) use ($cleanResidual, $lowerSearch) {
                    $q->where('title', 'like', "%{$cleanResidual}%")
                      ->orWhere('address', 'like', "%{$cleanResidual}%")
                      ->orWhere('category', 'like', "%{$cleanResidual}%")
                      ->orWhere('description', 'like', "%{$cleanResidual}%");

                    // Synonym Category mappings
                    if (str_contains($lowerSearch, 'flat') || str_contains($lowerSearch, 'apartment')) {
                        $q->orWhere('category', 'Apartment');
                    }
                    if (str_contains($lowerSearch, 'villa') || str_contains($lowerSearch, 'bungalow') || str_contains($lowerSearch, 'mansion')) {
                        $q->orWhere('category', 'Villa');
                    }
                    if (str_contains($lowerSearch, 'room') || str_contains($lowerSearch, 'pg') || str_contains($lowerSearch, 'hostel') || str_contains($lowerSearch, 'studio') || str_contains($lowerSearch, 'sharing')) {
                        $q->orWhere('category', 'Studio');
                    }
                    if (str_contains($lowerSearch, 'shop') || str_contains($lowerSearch, 'office') || str_contains($lowerSearch, 'commercial') || str_contains($lowerSearch, 'retail')) {
                        $q->orWhere('category', 'Shop');
                    }
                    if (str_contains($lowerSearch, 'house') || str_contains($lowerSearch, 'home')) {
                        $q->orWhere('category', 'House');
                    }
                });
            }
        }

        // ── 2. CURATED HOMEPAGE COLLECTIONS ───────────────────────────
        if ($collection) {
            match ($collection) {
                'recently_added' => $query->latest(),
                'available_now' => $query->where(function ($q) {
                    $q->whereNull('available_from')->orWhere('available_from', '<=', now());
                }),
                'owner_only' => $query->where('listed_by', 'owner'),
                'popular_rentals' => $query->where('listing_type', 'rent')->where('is_featured', true),
                'budget_friendly' => $query->where('price', '<=', 15000),
                'near_metro' => $query->where(function ($q) {
                    $q->whereNotNull('distance_from_metro')
                      ->orWhere('amenities', 'like', '%metro%')
                      ->orWhere('description', 'like', '%metro%')
                      ->orWhere('address', 'like', '%metro%');
                }),
                'student_pg' => $query->where(function ($q) {
                    $q->where('category', 'Studio')
                      ->orWhere('title', 'like', '%PG%')
                      ->orWhere('description', 'like', '%student%');
                }),
                'commercial' => $query->whereIn('category', ['Shop', 'Office', 'Warehouse', 'Commercial']),
                default => null,
            };
        }

        // ── 3. LOCATION FILTERS ───────────────────────────────────────
        if ($selectedCity && !in_array(strtolower($selectedCity), ['all', 'all cities', ''])) {
            $query->where('address', 'like', "%{$selectedCity}%");
        }

        // Specific locality / micro-market filter
        if ($locality) {
            $query->where('address', 'like', "%{$locality}%");
        }

        // ── 4. CATEGORY & PURPOSE FILTERS ─────────────────────────────
        if ($searchType && $searchType !== 'all') {
            $query->where('category', $searchType);
        }

        // ── 5. ADVANCED STRUCTURED FILTERS ────────────────────────────
        // Listed by Owner / Agent
        if ($listedBy && in_array($listedBy, ['owner', 'agent'])) {
            $query->where('listed_by', $listedBy);
        }

        // Bedrooms
        if ($request->filled('bedrooms') && $request->query('bedrooms') !== 'all') {
            $bedrooms = (int) $request->query('bedrooms');
            if ($bedrooms >= 3) {
                $query->where('bedrooms', '>=', 3);
            } else {
                $query->where('bedrooms', $bedrooms);
            }
        }

        // Filter by listing_type (rent / sale)
        if ($request->filled('listing_type') && in_array($request->query('listing_type'), ['rent', 'sale'])) {
            $query->where('listing_type', $request->query('listing_type'));
        }

        // Budget
        if ($maxPrice) {
            $query->where('price', '<=', $maxPrice);
        }

        // Amenities / Features filters
        if ($request->filled('min_price')) {
            $query->where('price', '>=', $request->query('min_price'));
        }

        // Security Deposit filter
        if ($maxDeposit) {
            $query->where('security_deposit', '<=', $maxDeposit);
        }

        // Near Metro
        if ($nearMetro) {
            $query->where(function ($q) {
                $q->whereNotNull('distance_from_metro')
                  ->orWhere('amenities', 'like', '%metro%')
                  ->orWhere('description', 'like', '%metro%')
                  ->orWhere('address', 'like', '%metro%');
            });
        }

        // Available Now
        if ($availableNow) {
            $query->where(function ($q) {
                $q->whereNull('available_from')->orWhere('available_from', '<=', now());
            });
        }

        // Amenities
        if ($request->boolean('is_furnished') || $request->query('is_furnished') == '1') {
            $query->where('is_furnished', true);
        }
        if ($request->boolean('is_pet_friendly') || $request->query('is_pet_friendly') == '1') {
            $query->where('is_pet_friendly', true);
        }
        if ($request->boolean('has_parking') || $request->query('has_parking') == '1') {
            $query->where('has_parking', true);
        }

        // Filter by country
        if ($request->has('country') && $request->query('country') !== 'All') {
            $query->where('country', $request->query('country'));
        }

        // ── 6. SORTING ────────────────────────────────────────────────
        if ($lat && $lng) {
            $query->selectRaw("*, (6371 * acos(cos(radians(?)) * cos(radians(latitude)) * cos(radians(longitude) - radians(?)) + sin(radians(?)) * sin(radians(latitude)))) AS distance", [$lat, $lng, $lat])
                  ->orderBy('distance');
        } else {
            $query->latest();
            match ($sort) {
                'price_low_high' => $query->orderBy('price', 'asc'),
                'price_high_low' => $query->orderBy('price', 'desc'),
                'featured' => $query->orderByDesc('is_featured')->latest(),
                default => $query->latest(),
            };
        }

        $properties = $query->get();

        // Featured properties for showcase
        // Featured showcase properties
        $featuredProperties = Property::with('owner')
            ->where('status', 'approved')
            ->where('is_featured', true)
            ->latest()
            ->take(6)
            ->get();
        if ($featuredProperties->isEmpty()) {
            $featuredProperties = Property::with('owner')
                ->where('status', 'approved')
                ->latest()
                ->take(6)
                ->get();
        }

        // Curated & Dynamic City lists
        $availableCities = ['All Cities', 'Noida', 'Greater Noida', 'Delhi', 'Gurugram', 'Bangalore'];
        $noidaMicroMarkets = ['Sector 137', 'Sector 62', 'Sector 75', 'Sector 78', 'Noida Extension', 'Knowledge Park', 'Sector 18'];

        $popularCities = ['Noida', 'Greater Noida', 'Gurugram', 'Delhi', 'Bangalore'];

        $categories = \App\Models\Category::all()->map(function ($cat) {
            $image = $cat->image;
            if ($image && !str_starts_with($image, 'http://') && !str_starts_with($image, 'https://')) {
                $image = asset($image);
            }
            return [
                'name' => $cat->name,
                'image' => $image ?? 'https://images.unsplash.com/photo-1564013799919-ab600027ffc6?auto=format&fit=crop&w=350&q=80',
            ];
        })->toArray();
        // ── 7. SIMPLIFIED 4-PILLAR CATEGORIES ARCHITECTURE ───────────
        $simplifiedCategories = [
            'rent' => [
                'id' => 'rent',
                'label' => 'Rent',
                'icon' => 'key',
                'listing_type' => 'rent',
                'sub_categories' => [
                    ['label' => 'Flats', 'search_type' => 'Apartment'],
                    ['label' => 'Houses', 'search_type' => 'House'],
                    ['label' => 'Rooms & PGs', 'search_type' => 'Studio'],
                ],
            ],
            'buy' => [
                'id' => 'buy',
                'label' => 'Buy',
                'icon' => 'real_estate_agent',
                'listing_type' => 'sale',
                'sub_categories' => [
                    ['label' => 'Flats', 'search_type' => 'Apartment'],
                    ['label' => 'Houses & Villas', 'search_type' => 'House'],
                    ['label' => 'Society Apartments', 'search_type' => 'Apartment'],
                ],
            ],
            'pg' => [
                'id' => 'pg',
                'label' => 'PG / Rooms',
                'icon' => 'single_bed',
                'listing_type' => 'rent',
                'search_type' => 'Studio',
                'sub_categories' => [
                    ['label' => 'Student PGs', 'search_type' => 'Studio'],
                    ['label' => 'Co-Living', 'search_type' => 'Studio'],
                    ['label' => 'Private Rooms', 'search_type' => 'Studio'],
                ],
            ],
            'commercial' => [
                'id' => 'commercial',
                'label' => 'Commercial',
                'icon' => 'storefront',
                'search_type' => 'Shop',
                'sub_categories' => [
                    ['label' => 'Retail Shops', 'search_type' => 'Shop'],
                    ['label' => 'Offices', 'search_type' => 'Shop'],
                    ['label' => 'Commercial Spaces', 'search_type' => 'Shop'],
                ],
            ],
        ];

        // Curated Homepage Collections list
        $curatedCollections = [
            ['id' => 'all', 'label' => 'All Listings', 'icon' => 'apps', 'collection' => null],
            ['id' => 'recently_added', 'label' => 'Recently Added', 'icon' => 'schedule', 'collection' => 'recently_added'],
            ['id' => 'available_now', 'label' => 'Available Immediately', 'icon' => 'bolt', 'collection' => 'available_now'],
            ['id' => 'owner_only', 'label' => 'Verified Owners (0% Brokerage)', 'icon' => 'verified_user', 'collection' => 'owner_only'],
            ['id' => 'near_metro', 'label' => 'Near Metro Stations', 'icon' => 'subway', 'collection' => 'near_metro'],
            ['id' => 'budget_friendly', 'label' => 'Budget Friendly (< ₹15k)', 'icon' => 'savings', 'collection' => 'budget_friendly'],
            ['id' => 'student_pg', 'label' => 'Student Housing & PGs', 'icon' => 'school', 'collection' => 'student_pg'],
            ['id' => 'commercial', 'label' => 'Commercial & Shops', 'icon' => 'storefront', 'collection' => 'commercial'],
        ];

        // Active Property Requests (Seeker Demand Board) with Filtering (Tasks 26 & 27)
        $demandQuery = PropertyRequest::where('status', 'active');

        // Demand Filter: City
        $demandCity = $request->query('demand_city');
        if ($demandCity && !in_array(strtolower($demandCity), ['all', 'all cities', ''])) {
            $demandQuery->where(function ($q) use ($demandCity) {
                $q->where('city', 'like', "%{$demandCity}%")
                  ->orWhere('locality', 'like', "%{$demandCity}%");
            });
        }

        // Demand Filter: Property Type
        $demandType = $request->query('demand_type');
        if ($demandType && !in_array(strtolower($demandType), ['all', 'all types', ''])) {
            $demandQuery->where('property_type', $demandType);
        }

        // Demand Filter: BHK
        $demandBhk = $request->query('demand_bhk');
        if ($demandBhk && !in_array(strtolower($demandBhk), ['all', 'any', ''])) {
            $demandQuery->where('bedrooms', 'like', "%{$demandBhk}%");
        }

        // Demand Filter: Purpose (Rent / Buy)
        $demandPurpose = $request->query('demand_purpose');
        if ($demandPurpose && in_array(strtolower($demandPurpose), ['rent', 'buy'])) {
            $demandQuery->where('purpose', strtolower($demandPurpose));
        }

        // Demand Filter: Max Budget
        $demandBudget = $request->query('demand_budget');
        if ($demandBudget && is_numeric($demandBudget)) {
            $demandQuery->where('max_budget', '<=', (float) $demandBudget);
        }

        // Demand Filter: Move-in Timeline
        $demandMoveIn = $request->query('demand_move_in');
        if ($demandMoveIn && !in_array(strtolower($demandMoveIn), ['all', 'any', ''])) {
            $demandQuery->where('move_in_date', 'like', "%{$demandMoveIn}%");
        }

        $propertyRequests = $demandQuery->latest()->take(12)->get();

        if (($request->ajax() || $request->wantsJson()) && $request->has('filter_demand_only')) {
            return response()->json([
                'success' => true,
                'count' => $propertyRequests->count(),
                'requests' => $propertyRequests,
            ]);
        }

        // Recently Viewed Properties (Task 41)
        $recentIds = session()->get('recently_viewed', []);
        $recentlyViewedProperties = collect();
        if (!empty($recentIds) && is_array($recentIds)) {
            $recentlyViewedProperties = Property::whereIn('id', $recentIds)
                ->where('status', 'approved')
                ->get()
                ->sortBy(function ($p) use ($recentIds) {
                    return array_search($p->id, $recentIds);
                })
                ->values();
        }

        return view('home', compact(
            'properties',
            'featuredProperties',
            'categories',
            'simplifiedCategories',
            'curatedCollections',
            'popularCities',
            'availableCities',
            'noidaMicroMarkets',
            'selectedCity',
            'locality',
            'collection',
            'listedBy',
            'nearMetro',
            'availableNow',
            'search',
            'propertyRequests',
            'demandCity',
            'demandType',
            'demandBhk',
            'demandPurpose',
            'demandBudget',
            'recentlyViewedProperties'
        ));
    }

    /**
     * Store a new property demand request from a seeker and alert matching landlords (Task 29).
     */
    public function storePropertyRequest(Request $request)
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

        $propertyRequest = PropertyRequest::create([
            'user_id' => Auth::id(),
            'seeker_name' => $validated['seeker_name'],
            'seeker_phone' => $validated['seeker_phone'],
            'seeker_email' => $validated['seeker_email'] ?? (Auth::user()?->email),
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

        // ── TASK 29: DEMAND ALERTS FOR MATCHING PROPERTY OWNERS ───────
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
            if ($owner && !in_array($owner->id, $notifiedOwnerIds) && $owner->id !== Auth::id()) {
                $notifiedOwnerIds[] = $owner->id;

                $place = $propertyRequest->locality ? $propertyRequest->locality . ', ' . $propertyRequest->city : $propertyRequest->city;
                $bhkInfo = $propertyRequest->bedrooms !== 'Any' ? $propertyRequest->bedrooms . ' ' : '';
                
                Notification::create([
                    'user_id' => $owner->id,
                    'title' => "New Tenant Demand Match in {$place}!",
                    'message' => "{$propertyRequest->seeker_name} is looking for a {$bhkInfo}{$propertyRequest->property_type} (Budget: {$propertyRequest->formatted_budget}). Matches your listing '{$matchedProp->title}'.",
                    'type' => 'demand_match',
                    'is_read' => false,
                ]);
            }
        }

        if ($request->wantsJson() || $request->ajax()) {
            return response()->json([
                'success' => true,
                'message' => 'Your property request has been posted successfully! Verified property owners matching your criteria have been notified.',
                'request' => $propertyRequest,
                'matched_owners_count' => count($notifiedOwnerIds),
            ]);
        }

        return back()->with('success', 'Your property request has been posted to our Demand Board! Verified landlords have been notified.');
    }

    /**
     * Show properties of a specific category.
     */
    public function category($name)
    {
        $properties = Property::with('owner')
            ->where('status', 'approved')
            ->where('category', $name)
            ->latest()
            ->get();

        $categories = \App\Models\Category::all()->map(function ($cat) {
            $image = $cat->image;
            if ($image && !str_starts_with($image, 'http://') && !str_starts_with($image, 'https://')) {
                $image = asset($image);
            }
            return [
                'name' => $cat->name,
                'image' => $image ?? 'https://images.unsplash.com/photo-1564013799919-ab600027ffc6?auto=format&fit=crop&w=350&q=80',
            ];
        })->toArray();

        return view('category', compact('properties', 'name', 'categories'));
    }

    /**
     * Show property details.
     */
    public function property($identifier)
    {
        if (is_numeric($identifier)) {
            $property = Property::with('owner')->findOrFail($identifier);
        } else {
            // Extract numeric ID from end of slug (e.g. 2-bhk-flat-in-paras-tierea-1)
            if (preg_match('/-(\d+)$/', (string) $identifier, $matches)) {
                $property = Property::with('owner')->findOrFail($matches[1]);
            } else {
                $property = Property::with('owner')->where('id', $identifier)->firstOrFail();
            }
        }
        
        // Increment property view analytics
        $property->increment('views_count');

        // Extract primary locality for similar properties (Task 33)
        $localityKeywords = array_filter(explode(',', $property->address));
        $primaryLocality = trim($localityKeywords[0] ?? 'Noida');

        // 1. Similar properties in locality
        $similarInLocality = Property::where('status', 'approved')
            ->where('id', '!=', $property->id)
            ->where('listing_type', $property->listing_type)
            ->where(function ($q) use ($primaryLocality, $property) {
                $q->where('address', 'like', "%{$primaryLocality}%")
                  ->orWhere('category', $property->category);
            })
            ->latest()
            ->take(3)
            ->get();

        // 2. More properties in similar price bracket
        $priceFloor = (float) $property->price * 0.70;
        $priceCap = (float) $property->price * 1.30;
        $similarInPriceBracket = Property::where('status', 'approved')
            ->where('id', '!=', $property->id)
            ->where('listing_type', $property->listing_type)
            ->whereBetween('price', [$priceFloor, $priceCap])
            ->latest()
            ->take(3)
            ->get();

        // 3. Other flats with same BHK
        $similarInBhk = Property::where('status', 'approved')
            ->where('id', '!=', $property->id)
            ->where('listing_type', $property->listing_type)
            ->where('bedrooms', $property->bedrooms)
            ->latest()
            ->take(3)
            ->get();

        $relatedProperties = $similarInLocality->isNotEmpty() ? $similarInLocality : $similarInPriceBracket;

        // ── 4. Recently Viewed Tracking (Task 41) ─────────────────────
        $recentIds = session()->get('recently_viewed', []);
        if (!is_array($recentIds)) {
            $recentIds = [];
        }
        // Prepend current property, remove duplicates, cap at 10
        $recentIds = array_values(array_unique(array_merge([$property->id], $recentIds)));
        if (count($recentIds) > 10) {
            $recentIds = array_slice($recentIds, 0, 10);
        }
        session()->put('recently_viewed', $recentIds);

        // Fetch other recently viewed properties (excluding current)
        $otherRecentIds = array_values(array_diff($recentIds, [$property->id]));
        $recentlyViewedProperties = collect();
        if (!empty($otherRecentIds)) {
            $recentlyViewedProperties = Property::whereIn('id', $otherRecentIds)
                ->where('status', 'approved')
                ->get()
                ->sortBy(function ($p) use ($otherRecentIds) {
                    return array_search($p->id, $otherRecentIds);
                })
                ->values();
        }
            
        return view('property', compact(
            'property',
            'relatedProperties',
            'similarInLocality',
            'similarInPriceBracket',
            'similarInBhk',
            'primaryLocality',
            'recentlyViewedProperties'
        ));
    }

    /**
     * Submit a trust and safety report for a property listing.
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

        $report = PropertyReport::create([
            'property_id' => $property->id,
            'user_id' => Auth::id(),
            'reporter_name' => $validated['reporter_name'] ?? (Auth::user()?->name ?? 'Anonymous'),
            'reporter_contact' => $validated['reporter_contact'] ?? (Auth::user()?->email ?? Auth::user()?->phone ?? null),
            'reason' => $validated['reason'],
            'details' => $validated['details'] ?? null,
            'ip_address' => $request->ip(),
            'status' => 'pending',
        ]);

        if ($request->wantsJson() || $request->ajax()) {
            return response()->json([
                'success' => true,
                'message' => 'Thank you for helping keep HomiQ safe and transparent. Our Trust & Safety team has received your report and will audit this listing within 4 hours.',
                'report' => $report,
            ]);
        }

        return back()->with('success', 'Report submitted successfully. Our Trust & Safety team will inspect this listing.');
    }

    /**
     * 1-Click Availability Confirmation & Listing Renewal for Owners.
     */
    public function renewProperty(Request $request, $id)
    {
        $property = Property::findOrFail($id);

        if (!Auth::check() || (Auth::id() !== $property->owner_id && !Auth::user()->is_admin)) {
            if ($request->wantsJson() || $request->ajax()) {
                return response()->json(['error' => 'Unauthorized action.'], 403);
            }
            return back()->with('error', 'Unauthorized to renew this listing.');
        }

        $property->renewListing(30);

        if ($request->wantsJson() || $request->ajax()) {
            return response()->json([
                'success' => true,
                'message' => 'Listing availability confirmed! Your property is active and verified for the next 30 days.',
                'expires_at' => $property->expires_at->toIso8601String(),
                'days_left' => $property->days_until_expiry,
            ]);
        }

        return back()->with('success', 'Listing availability confirmed and renewed for 30 days!');
    }

    /**
     * Display subscription packages.
     */
    public function pricing()
    {
        return view('pricing');
    }

    /**
     * Process subscription purchase (mock action).
     */
    public function upgradeSubscription(Request $request)
    {
        $request->validate([
            'plan' => 'required|in:free,standard,unlimited',
        ]);

        $user = Auth::user();
        $user->update([
            'subscription_plan' => $request->plan,
        ]);

        return redirect('/dashboard')->with('success', 'Your subscription has been successfully upgraded to the ' . ucfirst($request->plan) . ' plan!');
    }

    /**
     * Render the chat interface.
     */
    public function chat(Request $request)
    {
        $user = Auth::user();

        // If property_id parameter is passed, find or create the chat between seeker and owner
        $propertyId = $request->query('property_id');
        if ($propertyId) {
            $property = Property::findOrFail($propertyId);
            if ($property->owner_id === $user->id) {
                return redirect('/chat')->withErrors(['error' => 'You cannot chat with yourself about your own listing.']);
            }
            
            // Find or create chat room
            $chat = Chat::firstOrCreate([
                'user_one_id' => $user->id,
                'user_two_id' => $property->owner_id,
                'property_id' => $property->id,
            ]);
            
            // Create a system welcome message if the chat is brand new and empty
            if ($chat->messages()->count() === 0) {
                Message::create([
                    'chat_id' => $chat->id,
                    'sender_id' => $property->owner_id, // welcome/system context
                    'message' => "Hello! Thanks for your interest in my space '{$property->title}'. How can I help you?",
                    'type' => 'text',
                ]);
            }

            return redirect('/chat?chat_id=' . $chat->id);
        }

        // Tab 1: Current user's queries on other's properties (user_one = Auth::id)
        $myQueries = Chat::where('user_one_id', $user->id)
            ->with(['userTwo', 'property', 'messages.sender'])
            ->latest()
            ->get();

        // Tab 2: Other's queries on current user's properties (user_two = Auth::id)
        $othersQueries = Chat::where('user_two_id', $user->id)
            ->with(['userOne', 'property', 'messages.sender'])
            ->latest()
            ->get();

        // Determine active chat
        $activeChat = null;
        $activeChatId = $request->query('chat_id');
        if ($activeChatId) {
            $activeChat = Chat::with(['userOne', 'userTwo', 'property', 'messages.sender'])
                ->where(function ($q) use ($user) {
                    $q->where('user_one_id', $user->id)
                      ->orWhere('user_two_id', $user->id);
                })
                ->find($activeChatId);
        }

        if (!$activeChat) {
            // Default to first chat available
            $activeChat = $myQueries->first() ?? $othersQueries->first();
        }

        // Mark active chat messages as read
        if ($activeChat) {
            Message::where('chat_id', $activeChat->id)
                ->where('sender_id', '!=', $user->id)
                ->update(['is_read' => true]);

            // Broadcast presence safely
            try {
                broadcast(new \App\Events\UserPresence($activeChat->id, $user->id, true));
            } catch (\Throwable $e) {
                \Illuminate\Support\Facades\Log::error('Pusher Broadcast Error: ' . $e->getMessage());
            }
        }

        return view('chat', compact('myQueries', 'othersQueries', 'activeChat'));
    }

    /**
     * Send a chat message.
     */
    public function sendChatMessage(Request $request)
    {
        $request->validate([
            'chat_id' => 'required|exists:chats,id',
            'message' => 'required_without:attachment|nullable|string',
            'attachment' => 'required_without:message|nullable|file|max:10240|mimes:jpg,jpeg,png,gif,webp,pdf',
        ]);

        $chat = Chat::findOrFail($request->chat_id);
        $user = Auth::user();

        if ($chat->user_one_id !== $user->id && $chat->user_two_id !== $user->id) {
            abort(403, 'Unauthorized');
        }

        $attachmentUrl = null;
        $type = 'text';

        if ($request->hasFile('attachment')) {
            $file = $request->file('attachment');
            $fileName = time() . '_' . uniqid() . '.' . $file->getClientOriginalExtension();
            $path = $file->storeAs('attachments', $fileName, 'public');
            $attachmentUrl = asset('storage/' . $path);
            
            $extension = strtolower($file->getClientOriginalExtension());
            if ($extension === 'pdf') {
                $type = 'pdf';
            } else {
                $type = 'image';
            }
        }

        $message = Message::create([
            'chat_id' => $chat->id,
            'sender_id' => $user->id,
            'message' => $request->message ?? '',
            'type' => $type,
            'attachment_url' => $attachmentUrl,
        ]);

        // Touch the updated_at timestamp on chat
        $chat->touch();

        // Create a notification for the other user
        $recipientId = ($chat->user_one_id === $user->id) ? $chat->user_two_id : $chat->user_one_id;
        $recipient = User::find($recipientId);
        if ($recipient) {
            $notificationService = app(\App\Services\NotificationService::class);
            $msgContent = $attachmentUrl ? '[Sent ' . $type . ' attachment]' : substr($request->message, 0, 40) . '...';
            $notificationService->notify(
                $recipient,
                'New Message from ' . $user->name,
                'Regarding ' . ($chat->property ? $chat->property->title : 'your space') . ': "' . $msgContent . '"',
                'chat',
                false,
                null,
                [],
                ['chat_id' => (string) $chat->id]
            );
        }

        // Broadcast to Pusher Channels safely
        try {
            broadcast(new \App\Events\MessageSent($message->load('sender')));
        } catch (\Throwable $e) {
            \Illuminate\Support\Facades\Log::error('Pusher Broadcast Error: ' . $e->getMessage());
        }

        if ($request->expectsJson() || $request->wantsJson() || $request->ajax()) {
            return response()->json($message, 201);
        }

        return redirect('/chat?chat_id=' . $chat->id);
    }

    /**
     * Update the authenticated user's typing status.
     */
    public function updateTypingStatus(Request $request, $id)
    {
        $request->validate(['is_typing' => 'required|boolean']);
        $chat = Chat::findOrFail($id);
        $user = Auth::user();

        if ($chat->user_one_id !== $user->id && $chat->user_two_id !== $user->id) {
            return response()->json(['message' => 'Unauthorized'], 403);
        }

        $cacheKey = "chat_{$chat->id}_user_{$user->id}_typing";
        if ($request->is_typing) {
            \Illuminate\Support\Facades\Cache::put($cacheKey, true, now()->addSeconds(5));
        } else {
            \Illuminate\Support\Facades\Cache::forget($cacheKey);
        }

        // Broadcast typing event safely
        try {
            broadcast(new \App\Events\UserTyping($chat->id, $request->is_typing, $user->name));
        } catch (\Throwable $e) {
            \Illuminate\Support\Facades\Log::error('Pusher Broadcast Error: ' . $e->getMessage());
        }

        return response()->json(['success' => true]);
    }

    /**
     * Update the authenticated user's presence status.
     */
    public function updatePresenceStatus(Request $request, $id)
    {
        $request->validate(['is_online' => 'required|boolean']);
        $chat = Chat::findOrFail($id);
        $user = Auth::user();

        if ($chat->user_one_id !== $user->id && $chat->user_two_id !== $user->id) {
            return response()->json(['message' => 'Unauthorized'], 403);
        }

        // Broadcast presence event safely
        try {
            broadcast(new \App\Events\UserPresence($chat->id, $user->id, $request->is_online));
        } catch (\Throwable $e) {
            \Illuminate\Support\Facades\Log::error('Pusher Broadcast Error: ' . $e->getMessage());
        }

        return response()->json(['success' => true]);
    }

    /**
     * Get the typing status of the other user in the chat room.
     */
    public function getTypingStatus($id)
    {
        $chat = Chat::findOrFail($id);
        $user = Auth::user();

        if ($chat->user_one_id !== $user->id && $chat->user_two_id !== $user->id) {
            return response()->json(['message' => 'Unauthorized'], 403);
        }

        $otherUserId = ($chat->user_one_id === $user->id) ? $chat->user_two_id : $chat->user_one_id;
        $cacheKey = "chat_{$chat->id}_user_{$otherUserId}_typing";
        $isTyping = \Illuminate\Support\Facades\Cache::has($cacheKey);

        $otherUser = User::find($otherUserId);

        return response()->json([
            'is_typing' => $isTyping,
            'user_name' => $otherUser ? $otherUser->name : 'Someone',
        ]);
    }

    /**
     * Mark all notifications for the user as read.
     */
    public function readAllNotifications(Request $request)
    {
        Notification::where('user_id', Auth::id())->update(['is_read' => true]);
        return back()->with('success', 'All notifications marked as read!');
    }

    public function about()
    {
        $activeListingsCount = Property::approvedAndActive()->count();
        $verifiedOwnersCount = User::whereHas('properties')->count();
        $citiesCount = Property::approvedAndActive()->distinct('city')->count('city') ?: 4;

        return view('about', compact('activeListingsCount', 'verifiedOwnersCount', 'citiesCount'));
    }

    public function verificationStandards()
    {
        return view('verification-standards');
    }

    public function safety()
    {
        return view('safety');
    }

    public function contact()
    {
        return view('contact');
    }

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

        // Save into Feedback table for audit record
        Feedback::create([
            'user_id' => Auth::id(),
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
                'message' => "From {$validated['name']} ({$validated['email']}): " . \Illuminate\Support\Str::limit($validated['message'], 120),
                'type' => 'support_ticket',
                'is_read' => false,
            ]);
        }

        if ($request->wantsJson() || $request->ajax()) {
            return response()->json([
                'success' => true,
                'message' => 'Thank you for reaching out! Our team has received your request and will get back to you within 24 business hours.',
            ]);
        }

        return back()->with('success', 'Thank you for reaching out! Your support ticket has been received. Our dedicated team will respond within 24 hours.');
    }

    public function privacy()
    {
        $page = \App\Models\Page::where('slug', 'privacy')->first();
        return view('privacy', compact('page'));
    }

    public function terms()
    {
        $page = \App\Models\Page::where('slug', 'terms')->first();
        return view('terms', compact('page'));
    }

    public function showDeleteAccount()
    {
        return view('auth.delete-account');
    }

    public function deleteAccount(Request $request)
    {
        $request->validate([
            'email' => 'required|email|exists:users,email',
            'password' => 'required|string',
        ]);

        $user = User::where('email', $request->email)->first();

        if (!\Illuminate\Support\Facades\Hash::check($request->password, $user->password)) {
            return back()->withErrors(['password' => 'The provided password does not match our records.']);
        }

        // Cascade delete user listings and reservations to avoid integrity issues
        $user->properties()->delete();
        $user->bookings()->delete();

        // Logout if it's the current user
        if (Auth::check() && Auth::id() === $user->id) {
            Auth::logout();
            $request->session()->invalidate();
            $request->session()->regenerateToken();
        }

        $user->delete();

        return redirect('/delete-account')->with('success', 'Your account deleted successfully.');
    }

    /**
     * Dedicated Owner Landing Page (/list-property, /owners, /list-your-property).
     */
    public function ownersLanding()
    {
        $categories = \App\Models\Category::all();
        $recentRequests = \App\Models\PropertyRequest::where('status', 'active')->latest()->take(3)->get();
        $activePropertiesCount = Property::approvedAndActive()->count();
        $verifiedOwnersCount = User::whereHas('properties')->count();

        return view('owners', compact('categories', 'recentRequests', 'activePropertiesCount', 'verifiedOwnersCount'));
    }

    /**
     * Track Direct Contact / WhatsApp Clicks for Property Owner Analytics.
     */
    public function trackContact(Request $request, $id)
    {
        $property = Property::findOrFail($id);
        $type = $request->input('type', 'whatsapp');

        if ($type === 'whatsapp') {
            $property->increment('whatsapp_clicks');
        } else {
            $property->increment('inquiries_count');
        }

        return response()->json([
            'success' => true,
            'whatsapp_clicks' => $property->whatsapp_clicks,
            'inquiries_count' => $property->inquiries_count,
        ]);
    }

    /**
     * Track Property Saves / Favorites for Owner Analytics.
     */
    public function trackSave(Request $request, $id)
    {
        $property = Property::findOrFail($id);
        $property->increment('saves_count');

        return response()->json([
            'success' => true,
            'saves_count' => $property->saves_count,
        ]);
    }

    /**
     * Clear recently viewed history (Task 41).
     */
    public function clearRecentlyViewed(Request $request)
    {
        session()->forget('recently_viewed');
        if ($request->wantsJson() || $request->ajax()) {
            return response()->json(['success' => true, 'message' => 'Recently viewed history cleared']);
        }
        return back()->with('success', 'Recently viewed history cleared');
    }

    /**
     * Save a search query / filters for property alerts (Task 38).
     */
    public function saveSearch(Request $request)
    {
        $validated = $request->validate([
            'title' => 'nullable|string|max:255',
            'city' => 'nullable|string|max:100',
            'locality' => 'nullable|string|max:150',
            'category' => 'nullable|string|max:50',
            'listing_type' => 'nullable|string|in:rent,sale',
            'bedrooms' => 'nullable|string|max:30',
            'min_price' => 'nullable|numeric|min:0',
            'max_price' => 'nullable|numeric|min:0',
            'filters' => 'nullable|array',
        ]);

        if (!Auth::check()) {
            if ($request->wantsJson() || $request->ajax()) {
                return response()->json([
                    'success' => false,
                    'auth_required' => true,
                    'message' => 'Please log in to save this search and receive property alerts.'
                ], 401);
            }
            return redirect('/login')->with('info', 'Please log in to save your search and receive alerts.');
        }

        $filters = $validated['filters'] ?? [];
        if (!empty($validated['city'])) $filters['city'] = $validated['city'];
        if (!empty($validated['locality'])) $filters['locality'] = $validated['locality'];
        if (!empty($validated['category'])) $filters['category'] = $validated['category'];
        if (!empty($validated['listing_type'])) $filters['listing_type'] = $validated['listing_type'];
        if (!empty($validated['bedrooms'])) $filters['bedrooms'] = $validated['bedrooms'];
        if (!empty($validated['min_price'])) $filters['min_price'] = $validated['min_price'];
        if (!empty($validated['max_price'])) $filters['max_price'] = $validated['max_price'];

        $title = $validated['title'] ?? null;
        if (empty($title)) {
            $parts = [];
            if (!empty($filters['bedrooms']) && $filters['bedrooms'] !== 'all') {
                $parts[] = $filters['bedrooms'] . ' BHK';
            }
            if (!empty($filters['category']) && $filters['category'] !== 'All') {
                $parts[] = $filters['category'];
            }
            if (!empty($filters['city']) && $filters['city'] !== 'All') {
                $parts[] = 'in ' . $filters['city'];
            }
            if (!empty($filters['max_price'])) {
                $parts[] = 'under ₹' . number_format($filters['max_price'], 0);
            }
            $title = !empty($parts) ? implode(' ', $parts) : 'Custom Search Alert';
        }

        $savedSearch = \App\Models\SavedSearch::create([
            'user_id' => Auth::id(),
            'title' => $title,
            'filters' => $filters,
            'is_active' => true,
        ]);

        if ($request->wantsJson() || $request->ajax()) {
            return response()->json([
                'success' => true,
                'message' => 'Search saved successfully! You will receive alerts when matching properties are listed.',
                'saved_search' => $savedSearch,
            ]);
        }

        return back()->with('success', "Search '{$title}' saved! We will alert you when matching properties are posted.");
    }

    /**
     * Delete a saved search (Task 38).
     */
    public function deleteSavedSearch(Request $request, $id)
    {
        $savedSearch = \App\Models\SavedSearch::where('user_id', Auth::id())->findOrFail($id);
        $savedSearch->delete();

        if ($request->wantsJson() || $request->ajax()) {
            return response()->json(['success' => true, 'message' => 'Saved search deleted']);
        }
        return back()->with('success', 'Saved search removed');
    }

    /**
     * Toggle saved search active alerts state (Task 38).
     */
    public function toggleSavedSearch(Request $request, $id)
    {
        $savedSearch = \App\Models\SavedSearch::where('user_id', Auth::id())->findOrFail($id);
        $savedSearch->update(['is_active' => !$savedSearch->is_active]);

        if ($request->wantsJson() || $request->ajax()) {
            return response()->json([
                'success' => true,
                'is_active' => $savedSearch->is_active,
                'message' => $savedSearch->is_active ? 'Search alerts enabled' : 'Search alerts paused'
            ]);
        }
        return back()->with('success', 'Alert preferences updated');
    }
}
