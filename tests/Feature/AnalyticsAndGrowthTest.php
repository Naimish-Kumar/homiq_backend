<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\User;
use App\Models\Property;
use App\Models\AnalyticsEvent;
use App\Services\AnalyticsService;
use Illuminate\Foundation\Testing\RefreshDatabase;

class AnalyticsAndGrowthTest extends TestCase
{
    use RefreshDatabase;

    protected User $user;
    protected User $owner;
    protected Property $property;
    protected AnalyticsService $analyticsService;

    protected function setUp(): void
    {
        parent::setUp();

        $this->analyticsService = app(AnalyticsService::class);

        $this->owner = User::factory()->create([
            'name' => 'Kavita Agarwal',
            'email' => 'kavita.owner@homiq.test',
            'phone' => '+91 98111 22334',
            'is_admin' => false,
            'is_verified' => true,
        ]);

        $this->user = User::factory()->create([
            'name' => 'Vikram Malhotra',
            'email' => 'vikram.seeker@homiq.test',
            'phone' => '+91 98222 33445',
            'is_admin' => false,
        ]);

        $this->property = Property::create([
            'owner_id' => $this->owner->id,
            'title' => 'Sunlit 2 BHK in Sector 137 Noida',
            'slug' => 'sunlit-2-bhk-in-sector-137-noida',
            'description' => 'Beautiful flat near metro station, 0% brokerage.',
            'category' => 'Apartment',
            'listing_type' => 'rent',
            'price' => 25000,
            'security_deposit' => 50000,
            'maintenance_charges' => 2000,
            'brokerage_amount' => 0,
            'bedrooms' => 2,
            'bathrooms' => 2,
            'area_sqft' => 1200,
            'furnishing_status' => 'Semi-Furnished',
            'address' => 'Sector 137',
            'city' => 'Noida',
            'locality' => 'Sector 137',
            'state' => 'Uttar Pradesh',
            'country' => 'India',
            'status' => 'approved',
            'is_featured' => true,
            'listed_by' => 'owner',
        ]);
    }

    /**
     * Task 46: Proper Event Tracking
     * Tests that all 16 core events can be tracked and persisted.
     */
    public function test_all_sixteen_growth_events_can_be_tracked_via_api_and_service(): void
    {
        $eventsToTest = [
            'homepage_view',
            'search_started',
            'search_completed',
            'property_viewed',
            'property_saved',
            'property_shared',
            'contact_owner_clicked',
            'whatsapp_clicked',
            'visit_requested',
            'signup_started',
            'signup_completed',
            'listing_started',
            'listing_completed',
            'listing_verified',
            'demand_request_created',
            'app_download_clicked',
        ];

        foreach ($eventsToTest as $eventName) {
            $response = $this->postJson('/analytics/events', [
                'event_name' => $eventName,
                'property_id' => $this->property->id,
                'metadata' => [
                    'source' => 'test_suite',
                    'test_event' => $eventName,
                ],
            ]);

            $response->assertStatus(200)
                ->assertJson([
                    'success' => true,
                    'event_name' => $eventName,
                ]);

            $this->assertDatabaseHas('analytics_events', [
                'event_name' => $eventName,
                'property_id' => $this->property->id,
            ]);
        }

        $this->assertEquals(16, AnalyticsEvent::count());
    }

    /**
     * Task 47: Conversion Funnel Tracking
     * Tests Seeker Funnel (Visitor -> Search -> Property View -> Contact Owner -> Signup -> Inquiry)
     * Tests Owner Funnel (Visitor -> List Property -> Signup -> Listing Created -> Verification -> Listing Published -> First Inquiry)
     */
    public function test_seeker_and_owner_conversion_funnel_calculations(): void
    {
        // 1. Seed Seeker Funnel Events
        $this->analyticsService->track('homepage_view', ['url' => '/']);
        $this->analyticsService->track('homepage_view', ['url' => '/']);
        $this->analyticsService->track('homepage_view', ['url' => '/']);
        $this->analyticsService->track('homepage_view', ['url' => '/']); // 4 Visitors

        $this->analyticsService->track('search_completed', ['query' => 'Sector 137']);
        $this->analyticsService->track('search_completed', ['query' => '2 BHK']); // 2 Searches

        $this->analyticsService->track('property_viewed', ['property_id' => $this->property->id]);
        $this->analyticsService->track('property_viewed', ['property_id' => $this->property->id]); // 2 Views

        $this->analyticsService->track('whatsapp_clicked', ['property_id' => $this->property->id]); // 1 Contact

        $this->analyticsService->track('signup_completed', ['user_id' => $this->user->id]); // 1 Signup

        $this->analyticsService->track('demand_request_created', ['budget' => 25000]); // 1 Inquiry

        // 2. Test Seeker Funnel Aggregation
        $seekerFunnel = $this->analyticsService->getSeekerFunnelMetrics();

        $this->assertEquals('seeker', $seekerFunnel['funnel']);
        $this->assertEquals(4, $seekerFunnel['total_visitors']);
        $this->assertEquals(1, $seekerFunnel['total_inquiries']);

        $steps = collect($seekerFunnel['steps'])->keyBy('step');
        $this->assertEquals(4, $steps['visitor']['count']);
        $this->assertEquals(2, $steps['search']['count']);
        $this->assertEquals(50.0, $steps['search']['conversion_rate_pct']);
        $this->assertEquals(2, $steps['property_view']['count']);
        $this->assertEquals(1, $steps['contact_owner']['count']);
        $this->assertEquals(25.0, $steps['contact_owner']['conversion_rate_pct']);

        // 3. Seed Owner Funnel Events
        $this->analyticsService->track('listing_started', ['source' => 'list_free_cta']);
        $this->analyticsService->track('listing_completed', ['property_id' => $this->property->id]);
        $this->analyticsService->track('listing_verified', ['property_id' => $this->property->id]);

        // 4. Test Owner Funnel Aggregation
        $ownerFunnel = $this->analyticsService->getOwnerFunnelMetrics();
        $this->assertEquals('owner', $ownerFunnel['funnel']);
        $ownerSteps = collect($ownerFunnel['steps'])->keyBy('step');
        $this->assertEquals(1, $ownerSteps['list_property']['count']);
        $this->assertEquals(1, $ownerSteps['listing_created']['count']);
        $this->assertEquals(1, $ownerSteps['verification']['count']);

        // 5. Test Funnel Endpoint
        $apiResponse = $this->getJson('/admin/analytics/funnels');
        $apiResponse->assertStatus(200)
            ->assertJson([
                'success' => true,
                'seeker_funnel' => ['funnel' => 'seeker'],
                'owner_funnel' => ['funnel' => 'owner'],
            ]);
    }

    /**
     * Task 48: Google Search Console Integration
     * Tests site verification meta tag and robots.txt sitemap reference.
     */
    public function test_google_search_console_meta_tag_and_sitemap_declaration(): void
    {
        // 1. Homepage & Layouts include Google Site Verification meta tag
        $homeResponse = $this->get('/');
        $homeResponse->assertStatus(200);
        $homeResponse->assertSee('<meta name="google-site-verification"', false);
        $homeResponse->assertSee('google-site-verification-homiq-growth-2026');

        $propResponse = $this->get($this->property->seo_url);
        $propResponse->assertStatus(200);
        $propResponse->assertSee('<meta name="google-site-verification"', false);

        $ownerResponse = $this->get('/owners');
        $ownerResponse->assertStatus(200);
        $ownerResponse->assertSee('<meta name="google-site-verification"', false);

        // 2. Robots.txt contains Sitemap directive
        $robotsContent = file_get_contents(public_path('robots.txt'));
        $this->assertStringContainsString('Sitemap: https://homiq.in/sitemap.xml', $robotsContent);
    }

    /**
     * Task 49: Microsoft Clarity & Session Recordings with Privacy Masking
     * Tests Clarity initialization script and data-clarity-mask attributes.
     */
    public function test_microsoft_clarity_initialization_and_privacy_masking(): void
    {
        $response = $this->get('/');
        $response->assertStatus(200);

        // Clarity initialization script & project ID
        $response->assertSee('https://www.clarity.ms/tag/', false);
        $response->assertSee('clarity_homiq_prod');

        // Privacy masking script & handler
        $response->assertSee('data-clarity-mask', false);
        $response->assertSee('window.homiqTrack = function', false);

        // Layout includes analytics partial
        $propResponse = $this->get($this->property->seo_url);
        $propResponse->assertStatus(200);
        $propResponse->assertSee('clarity_homiq_prod');
        $propResponse->assertSee('window.homiqTrack', false);
    }
}

