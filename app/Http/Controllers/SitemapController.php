<?php

namespace App\Http\Controllers;

use App\Models\Property;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Cache;

class SitemapController extends Controller
{
    /**
     * Master Sitemap Index linking all sub-sitemaps.
     */
    public function index(): Response
    {
        $latestProperty = Property::where('status', 'approved')->latest('updated_at')->first();
        $latestDate = $latestProperty?->updated_at?->toAtomString() ?? now()->toAtomString();

        $content = view('sitemaps.index', [
            'latestPropertyDate' => $latestDate,
        ])->render();

        return response($content, 200, [
            'Content-Type' => 'application/xml; charset=utf-8',
            'Cache-Control' => 'public, max-age=21600', // 6 hours
        ]);
    }

    /**
     * Static Institutional & Core Pages Sitemap.
     */
    public function pages(): Response
    {
        $pages = [
            ['url' => url('/'), 'priority' => '1.0', 'changefreq' => 'daily'],
            ['url' => url('/owners'), 'priority' => '0.9', 'changefreq' => 'weekly'],
            ['url' => url('/list-property'), 'priority' => '0.9', 'changefreq' => 'weekly'],
            ['url' => url('/about'), 'priority' => '0.8', 'changefreq' => 'monthly'],
            ['url' => url('/verification-standards'), 'priority' => '0.8', 'changefreq' => 'monthly'],
            ['url' => url('/safety'), 'priority' => '0.8', 'changefreq' => 'monthly'],
            ['url' => url('/support'), 'priority' => '0.7', 'changefreq' => 'monthly'],
            ['url' => url('/demand-board'), 'priority' => '0.8', 'changefreq' => 'daily'],
        ];

        $content = view('sitemaps.pages', ['pages' => $pages])->render();

        return response($content, 200, [
            'Content-Type' => 'application/xml; charset=utf-8',
            'Cache-Control' => 'public, max-age=21600',
        ]);
    }

    /**
     * High-Intent Location & Category Landing Pages Sitemap.
     * Only indexes locations and intent hubs with active inventory.
     */
    public function locations(): Response
    {
        $locations = [
            ['url' => url('/rent/noida'), 'priority' => '0.9', 'changefreq' => 'daily'],
            ['url' => url('/rent/flats/noida'), 'priority' => '0.9', 'changefreq' => 'daily'],
            ['url' => url('/rent/pg/noida'), 'priority' => '0.8', 'changefreq' => 'daily'],
            ['url' => url('/rent/rooms/noida'), 'priority' => '0.8', 'changefreq' => 'daily'],
            ['url' => url('/rent/flats/sector-137-noida'), 'priority' => '0.9', 'changefreq' => 'daily'],
            ['url' => url('/buy/property/noida'), 'priority' => '0.9', 'changefreq' => 'daily'],
            ['url' => url('/buy/flats/noida'), 'priority' => '0.9', 'changefreq' => 'daily'],
            ['url' => url('/buy/noida'), 'priority' => '0.9', 'changefreq' => 'daily'],
            ['url' => url('/rent/gurugram'), 'priority' => '0.8', 'changefreq' => 'daily'],
            ['url' => url('/rent/bangalore'), 'priority' => '0.8', 'changefreq' => 'daily'],
        ];

        // Also dynamically add any other cities with approved inventory from address field
        $knownCities = ['noida', 'gurugram', 'bangalore', 'delhi', 'mumbai', 'pune', 'hyderabad', 'jaipur', 'chennai', 'kolkata'];
        $approvedAddresses = Property::where('status', 'approved')->pluck('address');

        foreach ($knownCities as $city) {
            if ($approvedAddresses->contains(fn($addr) => stripos((string)$addr, $city) !== false)) {
                $cityUrl = url('/rent/' . $city);
                if (!collect($locations)->contains('url', $cityUrl)) {
                    $locations[] = [
                        'url' => $cityUrl,
                        'priority' => '0.8',
                        'changefreq' => 'daily',
                    ];
                }
            }
        }

        $content = view('sitemaps.locations', ['locations' => $locations])->render();

        return response($content, 200, [
            'Content-Type' => 'application/xml; charset=utf-8',
            'Cache-Control' => 'public, max-age=21600',
        ]);
    }

    /**
     * Active Approved Property Listings Sitemap.
     */
    public function properties(): Response
    {
        $properties = Property::where('status', 'approved')
            ->latest('updated_at')
            ->get();

        $content = view('sitemaps.properties', ['properties' => $properties])->render();

        return response($content, 200, [
            'Content-Type' => 'application/xml; charset=utf-8',
            'Cache-Control' => 'public, max-age=21600',
        ]);
    }

    /**
     * Blog & Guides Sitemap.
     */
    public function blog(): Response
    {
        $articles = [
            ['url' => url('/about'), 'priority' => '0.7', 'changefreq' => 'monthly'],
            ['url' => url('/safety'), 'priority' => '0.7', 'changefreq' => 'monthly'],
            ['url' => url('/verification-standards'), 'priority' => '0.7', 'changefreq' => 'monthly'],
        ];

        $content = view('sitemaps.blog', ['articles' => $articles])->render();

        return response($content, 200, [
            'Content-Type' => 'application/xml; charset=utf-8',
            'Cache-Control' => 'public, max-age=21600',
        ]);
    }
}
