<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\User;
use App\Models\Property;
use Illuminate\Foundation\Testing\RefreshDatabase;

class MobileWebAndAppConversionTest extends TestCase
{
    use RefreshDatabase;

    protected User $owner;
    protected Property $property;

    protected function setUp(): void
    {
        parent::setUp();

        $this->owner = User::factory()->create([
            'name' => 'Aditya Sharma',
            'phone' => '+91 98765 43210',
            'email' => 'aditya.owner@homiq.test',
            'is_admin' => false,
            'is_verified' => true,
        ]);

        $this->property = Property::create([
            'owner_id' => $this->owner->id,
            'title' => 'Luxury 3 BHK Flat in Sector 137',
            'slug' => 'luxury-3-bhk-flat-in-sector-137',
            'description' => 'Spacious 3 BHK apartment with modern amenities, zero brokerage, near metro station.',
            'category' => 'Apartment',
            'listing_type' => 'rent',
            'price' => 32000,
            'security_deposit' => 64000,
            'maintenance_charges' => 2500,
            'brokerage_amount' => 0,
            'bedrooms' => 3,
            'bathrooms' => 3,
            'area_sqft' => 1650,
            'furnishing_status' => 'Furnished',
            'address' => 'Sector 137',
            'city' => 'Noida',
            'locality' => 'Sector 137',
            'state' => 'Uttar Pradesh',
            'country' => 'India',
            'latitude' => 28.5035,
            'longitude' => 77.4042,
            'status' => 'approved',
            'is_featured' => true,
            'listed_by' => 'owner',
            'is_instant_bookable' => true,
            'available_from' => now()->addDays(5)->toDateString(),
            'images' => [
                'https://images.unsplash.com/photo-1545324418-cc1a3fa10c00?auto=format&fit=crop&w=800&q=80',
            ],
            'amenities' => ['Lift', 'Gym', 'Swimming Pool', 'Security', 'Power Backup', 'Near Metro'],
        ]);
    }

    /**
     * Task 43: App Download Section
     * - Headline: "Get Faster Property Alerts on the HomiQ App"
     * - 5 Core Benefits:
     *   1. Instant owner replies
     *   2. Saved searches
     *   3. New listing alerts
     *   4. Property sharing
     *   5. Visit scheduling
     * - App Store and Google Play store download badges
     */
    public function test_homepage_renders_improved_app_download_section_with_five_core_benefits(): void
    {
        $response = $this->get('/');

        $response->assertStatus(200);

        // Headline & Subheading
        $response->assertSee('Get Faster Property Alerts on the HomiQ App');
        $response->assertSee('Never miss an under-market flat. Connect directly with certified landlords and receive instant notifications the moment matching homes are verified.');

        // 5 Core Benefits
        $response->assertSee('Instant owner replies');
        $response->assertSee('Saved searches');
        $response->assertSee('New listing alerts');
        $response->assertSee('Property sharing');
        $response->assertSee('Visit scheduling');

        // App Store & Play Store download links
        $response->assertSee('https://apps.apple.com/in/app/homiq-real-estate-marketplace/id6779412636');
        $response->assertSee('https://play.google.com/store/apps/details?id=com.homiq.acrocoder', false);
        $response->assertSee('Download on the');
        $response->assertSee('App Store');
        $response->assertSee('GET IT ON');
        $response->assertSee('Google Play');
    }

    /**
     * Task 44: App Deep Linking & Smart Banners
     * - Apple Smart App Banner meta tag
     * - Facebook / App Links meta tags (al:ios:url, al:android:url, al:web:url)
     * - Twitter App Card meta tags
     * - Open in App action button and JS helper
     */
    public function test_property_detail_page_includes_app_deep_linking_meta_tags_and_open_in_app_action(): void
    {
        $response = $this->get($this->property->seo_url);

        $response->assertStatus(200);

        // Apple Smart App Banner
        $response->assertSee('<meta name="apple-itunes-app" content="app-id=6779412636, app-argument=' . $this->property->seo_url . '" />', false);

        // App Links (iOS & Android URI schemes)
        $response->assertSee('<meta property="al:ios:url" content="homiq://property/' . $this->property->id . '" />', false);
        $response->assertSee('<meta property="al:ios:app_store_id" content="6779412636" />', false);
        $response->assertSee('<meta property="al:ios:app_name" content="HomiQ" />', false);
        $response->assertSee('<meta property="al:android:url" content="homiq://property/' . $this->property->id . '" />', false);
        $response->assertSee('<meta property="al:android:package" content="com.homiq.app" />', false);
        $response->assertSee('<meta property="al:android:app_name" content="HomiQ" />', false);
        $response->assertSee('<meta property="al:web:url" content="' . $this->property->seo_url . '" />', false);

        // Twitter App Cards
        $response->assertSee('<meta name="twitter:app:id:iphone" content="6779412636" />', false);
        $response->assertSee('<meta name="twitter:app:url:iphone" content="homiq://property/' . $this->property->id . '" />', false);
        $response->assertSee('<meta name="twitter:app:id:googleplay" content="com.homiq.app" />', false);
        $response->assertSee('<meta name="twitter:app:url:googleplay" content="homiq://property/' . $this->property->id . '" />', false);

        // Open in App UI Button & JS trigger
        $response->assertSee('openInApp()', false);
        $response->assertSee('Open in App');
    }

    /**
     * Task 45: Mobile Search UX & Sticky Conversion CTAs
     * - Mobile sticky Contact Owner & WhatsApp bar on property detail page
     * - Mobile sticky Search & Filter floating bar on homepage
     * - Map / List View Toggle chip on homepage
     * - Fast lazy image loading on property cards
     * - Guest access without forced signup walls
     */
    public function test_mobile_ux_sticky_bars_map_toggle_and_fast_loading(): void
    {
        // 1. Property Detail Page Mobile Sticky Bar
        $propResponse = $this->get($this->property->seo_url);
        $propResponse->assertStatus(200);
        $propResponse->assertSee('0% Brokerage · Direct Owner');
        $propResponse->assertSee('WhatsApp');
        $propResponse->assertSee('Visit / Contact');

        // 2. Homepage Mobile Sticky Bar & Map/List Toggle
        $homeResponse = $this->get('/');
        $homeResponse->assertStatus(200);
        $homeResponse->assertSee('viewMode === \'list\' ? \'Map\' : \'List\'', false);
        $homeResponse->assertSee('viewMode === \'list\' ? \'bg-white text-slate-900 shadow-2xs font-bold\' : \'text-slate-600 font-semibold\'', false);

        // 3. Fast Image Loading Attributes
        $homeResponse->assertSee('loading="lazy"', false);
        $homeResponse->assertSee('decoding="async"', false);

        // 4. Non-intrusive Guest Browsing (No blocking auth redirect on viewing details or browsing)
        $this->assertGuest();
        $guestView = $this->get($this->property->seo_url);
        $guestView->assertStatus(200);
        $guestView->assertSee('Schedule Physical Visit');
        $guestView->assertSee('Chat Directly on WhatsApp');
    }
}
