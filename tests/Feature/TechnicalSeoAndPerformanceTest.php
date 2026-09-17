<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\User;
use App\Models\Property;
use App\Helpers\SeoHelper;
use Illuminate\Foundation\Testing\RefreshDatabase;

class TechnicalSeoAndPerformanceTest extends TestCase
{
    use RefreshDatabase;

    protected User $owner;
    protected Property $property;

    protected function setUp(): void
    {
        parent::setUp();

        $this->owner = User::factory()->create([
            'name' => 'Sanjay Verma',
            'email' => 'sanjay.owner@homiq.test',
            'phone' => '+91 98111 55667',
            'is_admin' => false,
            'is_verified' => true,
        ]);

        $this->property = Property::create([
            'owner_id' => $this->owner->id,
            'title' => 'Exquisite 3 BHK Highrise in Sector 137 Noida',
            'slug' => 'exquisite-3-bhk-highrise-in-sector-137-noida',
            'description' => 'Direct from owner, luxury 3 BHK apartment near metro station with pool, gym, zero brokerage.',
            'category' => 'Apartment',
            'listing_type' => 'rent',
            'price' => 35000,
            'security_deposit' => 70000,
            'maintenance_charges' => 2500,
            'brokerage_amount' => 0,
            'bedrooms' => 3,
            'bathrooms' => 3,
            'area_sqft' => 1750,
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
            'available_from' => now()->addDays(2)->toDateString(),
            'images' => [
                'https://images.unsplash.com/photo-1545324418-cc1a3fa10c00?auto=format&fit=crop&w=800&q=80',
                'https://images.unsplash.com/photo-1560448204-e02f11c3d0e2?auto=format&fit=crop&w=800&q=80',
            ],
        ]);
    }

    /**
     * Task 50: Page Speed & Performance Optimizations
     */
    public function test_performance_assets_and_loading_attributes(): void
    {
        $response = $this->get('/');
        $response->assertStatus(200);

        // Preconnect & DNS-Prefetch
        $response->assertSee('rel="preconnect" href="https://fonts.googleapis.com"', false);
        $response->assertSee('rel="preconnect" href="https://fonts.gstatic.com"', false);
        $response->assertSee('display=swap', false);

        // Lazy & Async Loading on Cards
        $response->assertSee('loading="lazy"', false);
        $response->assertSee('decoding="async"', false);

        // Aspect ratio container preventing Cumulative Layout Shift (CLS)
        $response->assertSee('aspect-[16/10]', false);
    }

    /**
     * Task 51: Server-Side Rendering (SSR) & Crawlability
     */
    public function test_property_and_landing_pages_are_fully_server_side_rendered(): void
    {
        // 1. Property Details SSR
        $propResponse = $this->get($this->property->seo_url);
        $propResponse->assertStatus(200);

        // Critical search crawler metadata present directly in initial HTML payload
        $propResponse->assertSee($this->property->title);
        $propResponse->assertSee($this->property->formatted_price);
        $propResponse->assertSee($this->property->address);
        $propResponse->assertSee('0% Brokerage');
        $propResponse->assertSee('Listed by Owner');
        $propResponse->assertSee('SingleFamilyResidence', false); // JSON-LD Schema
        $propResponse->assertSee('BreadcrumbList', false);

        // 2. Location Landing Hub SSR
        $locResponse = $this->get('/rent/noida');
        $locResponse->assertStatus(200);
        $locResponse->assertSee('Noida');
        $locResponse->assertSee('Verified');
        $locResponse->assertSee($this->property->title);
    }

    /**
     * Task 52: Modular XML Sitemap Strategy
     */
    public function test_xml_sitemap_index_and_sub_sitemaps(): void
    {
        // 1. Master Sitemap Index
        $indexResponse = $this->get('/sitemap.xml');
        $indexResponse->assertStatus(200);
        $this->assertStringContainsString('application/xml', $indexResponse->headers->get('Content-Type'));
        $indexResponse->assertSee('<sitemapindex', false);
        $indexResponse->assertSee(url('/sitemap-pages.xml'));
        $indexResponse->assertSee(url('/sitemap-locations.xml'));
        $indexResponse->assertSee(url('/sitemap-properties.xml'));
        $indexResponse->assertSee(url('/sitemap-blog.xml'));

        // 2. Sitemap Pages
        $pagesResponse = $this->get('/sitemap-pages.xml');
        $pagesResponse->assertStatus(200);
        $this->assertStringContainsString('application/xml', $pagesResponse->headers->get('Content-Type'));
        $pagesResponse->assertSee('<urlset', false);
        $pagesResponse->assertSee(url('/'));
        $pagesResponse->assertSee(url('/owners'));
        $pagesResponse->assertSee(url('/about'));
        $pagesResponse->assertSee(url('/safety'));

        // 3. Sitemap Locations
        $locResponse = $this->get('/sitemap-locations.xml');
        $locResponse->assertStatus(200);
        $this->assertStringContainsString('application/xml', $locResponse->headers->get('Content-Type'));
        $locResponse->assertSee(url('/rent/noida'));
        $locResponse->assertSee(url('/buy/noida'));

        // 4. Sitemap Properties
        $propSitemapResponse = $this->get('/sitemap-properties.xml');
        $propSitemapResponse->assertStatus(200);
        $this->assertStringContainsString('application/xml', $propSitemapResponse->headers->get('Content-Type'));
        $propSitemapResponse->assertSee($this->property->seo_url);
        $propSitemapResponse->assertSee('<image:image>', false);
        $propSitemapResponse->assertSee($this->property->images[0]);

        // 5. Sitemap Blog
        $blogResponse = $this->get('/sitemap-blog.xml');
        $blogResponse->assertStatus(200);
        $this->assertStringContainsString('application/xml', $blogResponse->headers->get('Content-Type'));
        $blogResponse->assertSee('<urlset', false);
    }

    /**
     * Task 53: Canonical URL Normalization
     */
    public function test_canonical_urls_strip_duplicate_filter_and_sort_parameters(): void
    {
        // 1. SeoHelper unit checks
        $rawUrl = 'https://homiq.in/rent/noida?sort=price&furnished=true&bedrooms=2&page=2';
        $canonical = SeoHelper::canonicalUrl($rawUrl);
        $this->assertEquals('https://homiq.in/rent/noida', $canonical);

        // 2. Homepage with query filters canonicalizes to clean homepage
        $homeFilteredResponse = $this->get('/?search=noida&bedrooms=2&sort=price');
        $homeFilteredResponse->assertStatus(200);
        $homeFilteredResponse->assertSee('<link rel="canonical" href="' . url('/') . '">', false);

        // 3. Location landing with filters canonicalizes to clean location hub
        $locFilteredResponse = $this->get('/rent/noida?sort=price&max_price=30000');
        $locFilteredResponse->assertStatus(200);
        $locFilteredResponse->assertSee('<link rel="canonical" href="' . url('/rent/noida') . '">', false);
    }
}
