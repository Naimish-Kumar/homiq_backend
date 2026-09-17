<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Property;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class SeoLandingController extends Controller
{
    /**
     * Map clean category slugs to category names in database.
     */
    protected const CATEGORY_MAP = [
        'flats' => 'Apartment',
        'flat' => 'Apartment',
        'apartments' => 'Apartment',
        'apartment' => 'Apartment',
        'houses' => 'House',
        'house' => 'House',
        'villas' => 'Villa',
        'villa' => 'Villa',
        'rooms' => 'Room',
        'room' => 'Room',
        'pg' => 'PG',
        'pgs' => 'PG',
        'studios' => 'Studio',
        'studio' => 'Studio',
        'plots' => 'Plot',
        'plot' => 'Plot',
        'shops' => 'Shop',
        'shop' => 'Shop',
        'offices' => 'Office Space',
        'office' => 'Office Space',
        'commercial' => 'Commercial',
        'property' => null,
        'properties' => null,
    ];

    /**
     * Known city names mapping.
     */
    protected const CITY_MAP = [
        'noida' => 'Noida',
        'greater-noida' => 'Greater Noida',
        'greater-noida-west' => 'Greater Noida West',
        'gurugram' => 'Gurugram',
        'gurgaon' => 'Gurugram',
        'delhi' => 'Delhi',
        'bangalore' => 'Bangalore',
        'bengaluru' => 'Bangalore',
        'mumbai' => 'Mumbai',
        'pune' => 'Pune',
        'jaipur' => 'Jaipur',
    ];

    /**
     * Known micro-localities mapping.
     */
    protected const LOCALITY_MAP = [
        'sector-137' => 'Sector 137',
        'sector-62' => 'Sector 62',
        'sector-128' => 'Sector 128',
        'sector-143' => 'Sector 143',
        'sector-150' => 'Sector 150',
        'sector-76' => 'Sector 76',
        'sector-75' => 'Sector 75',
        'gaur-city' => 'Gaur City',
        'knowledge-park' => 'Knowledge Park',
        'pari-chowk' => 'Pari Chowk',
        'cyber-city' => 'Cyber City',
        'dlf-phase-3' => 'DLF Phase 3',
        'hsr-layout' => 'HSR Layout',
        'koramangala' => 'Koramangala',
        'whitefield' => 'Whitefield',
        'indiranagar' => 'Indiranagar',
    ];

    /**
     * Location Landing: /rent/{city}
     */
    public function rentCity(Request $request, string $citySlug)
    {
        return $this->renderLocationLanding([
            'listing_type' => 'rent',
            'city_slug' => $citySlug,
            'category_slug' => null,
            'locality_slug' => null,
        ]);
    }

    /**
     * Location Landing: /rent/{category}/{city}
     */
    public function rentCategoryCity(Request $request, string $categorySlug, string $citySlug)
    {
        // Check if citySlug is actually a locality-city combo e.g. "sector-137-noida"
        $locality = null;
        $city = $citySlug;

        foreach (array_keys(self::LOCALITY_MAP) as $locKey) {
            if (str_starts_with($citySlug, $locKey . '-')) {
                $locality = $locKey;
                $city = substr($citySlug, strlen($locKey) + 1);
                break;
            } elseif ($citySlug === $locKey) {
                $locality = $locKey;
                $city = 'noida'; // fallback default
                break;
            }
        }

        return $this->renderLocationLanding([
            'listing_type' => 'rent',
            'city_slug' => $city,
            'category_slug' => $categorySlug,
            'locality_slug' => $locality,
        ]);
    }

    /**
     * Location Landing: /buy/{city}
     */
    public function buyCity(Request $request, string $citySlug)
    {
        return $this->renderLocationLanding([
            'listing_type' => 'sale',
            'city_slug' => $citySlug,
            'category_slug' => null,
            'locality_slug' => null,
        ]);
    }

    /**
     * Location Landing: /buy/{category}/{city}
     */
    public function buyCategoryCity(Request $request, string $categorySlug, string $citySlug)
    {
        $locality = null;
        $city = $citySlug;

        foreach (array_keys(self::LOCALITY_MAP) as $locKey) {
            if (str_starts_with($citySlug, $locKey . '-')) {
                $locality = $locKey;
                $city = substr($citySlug, strlen($locKey) + 1);
                break;
            }
        }

        return $this->renderLocationLanding([
            'listing_type' => 'sale',
            'city_slug' => $city,
            'category_slug' => $categorySlug,
            'locality_slug' => $locality,
        ]);
    }

    /**
     * Search-Intent Landing: /explore/{intent}
     */
    public function intentLanding(Request $request, string $intentSlug)
    {
        $listingType = 'rent';
        if (str_contains($intentSlug, 'sale') || str_contains($intentSlug, 'buy')) {
            $listingType = 'sale';
        }

        $bedrooms = null;
        if (preg_match('/(\d+)-bhk/', $intentSlug, $bhkMatch)) {
            $bedrooms = (int) $bhkMatch[1];
        }

        $isNearMetro = str_contains($intentSlug, 'near-metro');

        $category = null;
        foreach (['pgs' => 'PG', 'pg' => 'PG', 'rooms' => 'Room', 'flats' => 'Apartment', 'plots' => 'Plot', 'commercial' => 'Commercial'] as $key => $catName) {
            if (str_contains($intentSlug, $key)) {
                $category = $catName;
                break;
            }
        }

        $city = 'Noida';
        foreach (self::CITY_MAP as $slug => $cityName) {
            if (str_contains($intentSlug, $slug)) {
                $city = $cityName;
                break;
            }
        }

        $locality = null;
        foreach (self::LOCALITY_MAP as $slug => $locName) {
            if (str_contains($intentSlug, $slug)) {
                $locality = $locName;
                break;
            }
        }

        $query = Property::approvedAndActive()->where('listing_type', $listingType);

        if ($city) {
            $query->where(function ($q) use ($city) {
                $q->where('address', 'like', '%' . $city . '%')
                  ->orWhere('title', 'like', '%' . $city . '%');
            });
        }

        if ($locality) {
            $query->where(function ($q) use ($locality) {
                $q->where('address', 'like', '%' . $locality . '%')
                  ->orWhere('title', 'like', '%' . $locality . '%');
            });
        }

        if ($category) {
            $query->where('category', $category);
        }

        if ($bedrooms) {
            $query->where('bedrooms', $bedrooms);
        }

        if ($isNearMetro) {
            $query->nearMetro();
        }

        $properties = $query->latest()->get();

        // Human Title & Meta
        $formattedIntent = ucwords(str_replace('-', ' ', $intentSlug));
        $pageTitle = "{$formattedIntent} (0% Brokerage) | HomiQ";
        $metaDescription = "Find 100% verified {$formattedIntent}. Direct owner contact, authentic photos, zero brokerage fees, and transparent deposits on HomiQ.";
        $h1Title = "Verified " . $formattedIntent;

        $canonicalUrl = url('/explore/' . $intentSlug);

        $breadcrumbs = [
            ['name' => 'Home', 'url' => url('/')],
            ['name' => ucfirst($listingType), 'url' => url('/' . $listingType . '/' . Str::slug($city))],
            ['name' => $formattedIntent, 'url' => $canonicalUrl],
        ];

        $faqs = $this->getFaqsForLocation($city, $locality, $listingType);
        $sisterLocations = $this->getSisterLocations($city);

        return view('seo-landing', compact(
            'properties',
            'pageTitle',
            'metaDescription',
            'h1Title',
            'canonicalUrl',
            'breadcrumbs',
            'city',
            'locality',
            'listingType',
            'category',
            'faqs',
            'sisterLocations'
        ));
    }

    /**
     * Core renderer for Location Landing Pages.
     */
    protected function renderLocationLanding(array $params)
    {
        $listingType = $params['listing_type'] ?? 'rent';
        $citySlug = strtolower($params['city_slug'] ?? 'noida');
        $cityName = self::CITY_MAP[$citySlug] ?? ucwords(str_replace('-', ' ', $citySlug));

        $localitySlug = $params['locality_slug'] ?? null;
        $localityName = $localitySlug ? (self::LOCALITY_MAP[$localitySlug] ?? ucwords(str_replace('-', ' ', $localitySlug))) : null;

        $categorySlug = $params['category_slug'] ?? null;
        $categoryName = $categorySlug ? (self::CATEGORY_MAP[$categorySlug] ?? ucwords($categorySlug)) : null;

        // Query active verified properties
        $query = Property::approvedAndActive()->where('listing_type', $listingType);

        if ($cityName) {
            $query->where(function ($q) use ($cityName) {
                $q->where('address', 'like', '%' . $cityName . '%')
                  ->orWhere('title', 'like', '%' . $cityName . '%');
            });
        }

        if ($localityName) {
            $query->where(function ($q) use ($localityName) {
                $q->where('address', 'like', '%' . $localityName . '%')
                  ->orWhere('title', 'like', '%' . $localityName . '%');
            });
        }

        if ($categoryName) {
            $query->where('category', $categoryName);
        }

        $properties = $query->latest()->get();

        // SEO Title & Meta Description Construction
        $typeLabel = $listingType === 'sale' ? 'for Sale' : 'for Rent';
        $catLabel = $categoryName ? Str::plural($categoryName) : 'Properties';
        $placeLabel = $localityName ? "{$localityName}, {$cityName}" : $cityName;

        $pageTitle = "Verified {$catLabel} {$typeLabel} in {$placeLabel} (0% Brokerage) | HomiQ";
        $metaDescription = "Explore {$properties->count()} verified {$catLabel} {$typeLabel} in {$placeLabel}. Connect directly with property owners, enjoy zero brokerage, verified photos, and transparent pricing on HomiQ.";
        $h1Title = "{$catLabel} {$typeLabel} in {$placeLabel}";

        // Canonical URL (Task 53)
        if ($localitySlug) {
            $rawCanonical = url("/{$listingType}/" . ($categorySlug ?: 'flats') . "/{$localitySlug}-{$citySlug}");
        } elseif ($categorySlug) {
            $rawCanonical = url("/{$listingType}/{$categorySlug}/{$citySlug}");
        } else {
            $rawCanonical = url("/{$listingType}/{$citySlug}");
        }
        $canonicalUrl = \App\Helpers\SeoHelper::canonicalUrl($rawCanonical);

        // Breadcrumbs
        $breadcrumbs = [
            ['name' => 'Home', 'url' => url('/')],
            ['name' => ucfirst($listingType), 'url' => url('/' . $listingType . '/' . $citySlug)],
        ];

        if ($categoryName) {
            $breadcrumbs[] = [
                'name' => Str::plural($categoryName),
                'url' => url("/{$listingType}/{$categorySlug}/{$citySlug}"),
            ];
        }

        if ($localityName) {
            $breadcrumbs[] = [
                'name' => $localityName,
                'url' => $canonicalUrl,
            ];
        }

        $faqs = $this->getFaqsForLocation($cityName, $localityName, $listingType);
        $sisterLocations = $this->getSisterLocations($cityName);

        return view('seo-landing', compact(
            'properties',
            'pageTitle',
            'metaDescription',
            'h1Title',
            'canonicalUrl',
            'breadcrumbs',
            'cityName',
            'localityName',
            'listingType',
            'categoryName',
            'faqs',
            'sisterLocations'
        ));
    }

    /**
     * Get tailored SEO FAQs for the location and listing type.
     */
    protected function getFaqsForLocation(string $city, ?string $locality, string $listingType): array
    {
        $place = $locality ? "{$locality}, {$city}" : $city;
        $type = $listingType === 'sale' ? 'buy or sell property' : 'rent a home';

        return [
            [
                'question' => "How do I {$type} in {$place} without paying brokerage?",
                'answer' => "HomiQ connects you directly with verified property owners in {$place}. You can browse authentic photos, inspect verified coordinates, and chat directly on WhatsApp or in-app with 0% broker commission.",
            ],
            [
                'question' => "What is the typical rental price in {$place}?",
                'answer' => "In {$place}, 1 BHK flats typically range between ₹12,000–₹18,000/month, 2 BHK flats range from ₹20,000–₹32,000/month, and premium 3 BHK societies range from ₹35,000–₹55,000/month depending on furnishing and metro proximity.",
            ],
            [
                'question' => "How does HomiQ verify properties in {$place}?",
                'answer' => "Every listing in {$place} undergoes our 4-step verification protocol: Host KYC validation, physical GPS geotag audit, camera photo verification, and 30-day freshness availability checks.",
            ],
            [
                'question' => "Are security deposits standard in {$place}?",
                'answer' => "Yes, landlords in {$place} typically ask for 1 to 2 months rent as security deposit. On HomiQ, exact deposit amounts are transparently listed upfront before you schedule a visit.",
            ],
        ];
    }

    /**
     * Sister location links for strong internal linking architecture.
     */
    protected function getSisterLocations(string $city): array
    {
        return [
            ['name' => 'Sector 137 Noida', 'url' => url('/rent/flats/sector-137-noida'), 'subtitle' => 'Metro Corridor Apartments'],
            ['name' => 'Sector 62 Noida', 'url' => url('/rent/flats/sector-62-noida'), 'subtitle' => 'IT Park & Student Corridors'],
            ['name' => 'Greater Noida West', 'url' => url('/rent/flats/greater-noida'), 'subtitle' => 'Gaur City & Affordable Homes'],
            ['name' => 'Knowledge Park PGs', 'url' => url('/explore/pgs-in-noida'), 'subtitle' => 'Student Housing with Meals'],
            ['name' => 'Cyber City Gurugram', 'url' => url('/rent/flats/gurugram'), 'subtitle' => 'Corporate Tech Hub Studios'],
            ['name' => 'HSR Layout Bangalore', 'url' => url('/rent/flats/bangalore'), 'subtitle' => 'Startup Hub 1 & 2 BHKs'],
        ];
    }
}

