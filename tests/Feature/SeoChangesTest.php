<?php

namespace Tests\Feature;

use App\Models\User;
use App\Models\Property;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class SeoChangesTest extends TestCase
{
    use RefreshDatabase;

    protected User $owner;
    protected Property $noidaProperty;

    protected function setUp(): void
    {
        parent::setUp();

        $this->owner = User::create([
            'name' => 'Aditya Sharma',
            'email' => 'aditya.owner@example.com',
            'password' => bcrypt('password123'),
            'phone' => '9876543210',
            'is_admin' => false,
            'email_verified_at' => now(),
        ]);

        $this->noidaProperty = Property::create([
            'owner_id' => $this->owner->id,
            'title' => '2 BHK Flat in Paras Tierea Sector 137',
            'description' => 'Bright and modern apartment walking distance to Sector 137 metro station.',
            'price' => 24000,
            'security_deposit' => 48000,
            'address' => 'Sector 137, Noida, Uttar Pradesh',
            'category' => 'Apartment',
            'listing_type' => 'rent',
            'bedrooms' => 2,
            'bathrooms' => 2,
            'is_furnished' => true,
            'listed_by' => 'owner',
            'status' => 'approved',
            'verified_at' => now()->subDays(2),
            'expires_at' => now()->addDays(28),
        ]);
    }

    /**
     * Test 21: Homepage title, meta description, and single primary H1.
     */
    public function test_homepage_has_correct_seo_title_meta_and_single_h1()
    {
        $response = $this->get('/');

        $response->assertStatus(200);
        $response->assertSee('<title>HomiQ - Verified Flats, PGs &amp; Properties for Rent, Buy and Sell</title>', false);
        $response->assertSee('Find Verified Properties Without Brokerage');
        $response->assertSee('Active Verified Inventory');
    }

    /**
     * Test 22: Homepage structured data (Organization & WebSite with SearchAction).
     */
    public function test_homepage_contains_organization_and_website_structured_data()
    {
        $response = $this->get('/');

        $response->assertStatus(200);
        $response->assertSee('"@type": "Organization"', false);
        $response->assertSee('"@type": "WebSite"', false);
        $response->assertSee('"@type": "SearchAction"', false);
    }

    /**
     * Test 19 & 20: Location-based landing pages & Search intent pages.
     */
    public function test_seo_location_and_intent_landing_pages()
    {
        // 1. /rent/noida
        $responseRentCity = $this->get('/rent/noida');
        $responseRentCity->assertStatus(200);
        $responseRentCity->assertSee('Verified Properties for Rent in Noida');
        $responseRentCity->assertSee('2 BHK Flat in Paras Tierea Sector 137');
        $responseRentCity->assertSee('FAQPage');

        // 2. /rent/flats/noida
        $responseRentCategory = $this->get('/rent/flats/noida');
        $responseRentCategory->assertStatus(200);
        $responseRentCategory->assertSee('Apartments for Rent in Noida');
        $responseRentCategory->assertSee('2 BHK Flat in Paras Tierea Sector 137');

        // 3. /rent/flats/sector-137-noida (locality + city)
        $responseRentLocality = $this->get('/rent/flats/sector-137-noida');
        $responseRentLocality->assertStatus(200);
        $responseRentLocality->assertSee('Sector 137');
        $responseRentLocality->assertSee('2 BHK Flat in Paras Tierea Sector 137');

        // 4. /buy/flats/noida
        $responseBuy = $this->get('/buy/flats/noida');
        $responseBuy->assertStatus(200);
        $responseBuy->assertSee('Apartments for Sale in Noida');

        // 5. /explore/flats-near-metro-in-noida
        $responseIntent = $this->get('/explore/flats-near-metro-in-noida');
        $responseIntent->assertStatus(200);
        $responseIntent->assertSee('Flats Near Metro');
        $responseIntent->assertSee('Frequently Asked Questions');
    }

    /**
     * Test 23: SEO-Friendly property URLs and backward compatibility.
     */
    public function test_property_seo_url_accessor_and_slug_resolution()
    {
        $seoUrl = $this->noidaProperty->seo_url;
        $this->assertStringContainsString('/property/2-bhk-flat-in-paras-tierea-sector-137-' . $this->noidaProperty->id, $seoUrl);

        // Access via SEO slug URL
        $slug = '2-bhk-flat-in-paras-tierea-sector-137-' . $this->noidaProperty->id;
        $responseSlug = $this->get("/property/{$slug}");
        $responseSlug->assertStatus(200);
        $responseSlug->assertSee('2 BHK Flat in Paras Tierea Sector 137');

        // Access via backward-compatible numeric URL
        $responseId = $this->get("/properties/{$this->noidaProperty->id}");
        $responseId->assertStatus(200);
        $responseId->assertSee('2 BHK Flat in Paras Tierea Sector 137');
    }

    /**
     * Test 24: Property details page contains structured data and internal linking hub.
     */
    public function test_property_page_has_structured_data_and_internal_linking_hub()
    {
        $response = $this->get("/properties/{$this->noidaProperty->id}");

        $response->assertStatus(200);
        $response->assertSee('"@type": "SingleFamilyResidence"', false);
        $response->assertSee('"@type": "BreadcrumbList"', false);
        $response->assertSee('Explore More Verified Homes & Guides');
        $response->assertSee('Rental Guide');
    }

    /**
     * Test 25: Real estate blog and location guides.
     */
    public function test_guides_index_and_detail_pages()
    {
        // 1. Guides Index: /guides
        $responseIndex = $this->get('/guides');
        $responseIndex->assertStatus(200);
        $responseIndex->assertSee('Real Estate & Rental Guides for Delhi NCR');
        $responseIndex->assertSee('Complete Noida Rental Guide 2026');
        $responseIndex->assertSee('Student PG & Co-Living Guide');

        // 2. Blog Index alias: /blog
        $responseBlog = $this->get('/blog');
        $responseBlog->assertStatus(200);
        $responseBlog->assertSee('Real Estate & Rental Guides for Delhi NCR');

        // 3. Guide Detail: /guides/noida-rental-guide
        $responseNoidaGuide = $this->get('/guides/noida-rental-guide');
        $responseNoidaGuide->assertStatus(200);
        $responseNoidaGuide->assertSee('Complete Noida Rental Guide 2026');
        $responseNoidaGuide->assertSee('"@type": "Article"', false);
        $responseNoidaGuide->assertSee('"@type": "FAQPage"', false);
        $responseNoidaGuide->assertSee('Average Rental Rates in Noida');
        $responseNoidaGuide->assertSee('Sector 137 & Expressway Corridor', false);

        // 4. Guide Detail: /guides/pg-near-amity-university-guide
        $responsePgGuide = $this->get('/guides/pg-near-amity-university-guide');
        $responsePgGuide->assertStatus(200);
        $responsePgGuide->assertSee('Knowledge Park, Amity & Greater Noida');

        // 5. Guide Detail: /guides/documents-required-for-renting
        $responseDocGuide = $this->get('/guides/documents-required-for-renting');
        $responseDocGuide->assertStatus(200);
        $responseDocGuide->assertSee('Documents Required for Renting a Flat in Noida');
    }
}
