<?php

namespace Tests\Feature;

use App\Models\Property;
use App\Models\PropertyRequest;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class HomepageSectionOrderTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();
    }

    public function test_homepage_renders_all_13_sections_in_exact_order(): void
    {
        $owner = User::factory()->create([
            'is_verified' => true,
        ]);

        Property::create([
            'owner_id' => $owner->id,
            'title' => '2 BHK Luxury Apartment in Sector 137',
            'slug' => '2-bhk-luxury-apartment-in-sector-137',
            'description' => 'Direct owner flat near metro.',
            'category' => 'Apartment',
            'city' => 'Noida',
            'locality' => 'Sector 137',
            'address' => 'Sector 137, Noida',
            'bedrooms' => 2,
            'bathrooms' => 2,
            'price' => 25000,
            'security_deposit' => 50000,
            'listing_type' => 'rent',
            'status' => 'approved',
            'is_active' => true,
            'distance_from_metro' => '450m from Metro',
        ]);

        PropertyRequest::create([
            'seeker_name' => 'Aditya Sharma',
            'seeker_phone' => '9876543210',
            'city' => 'Noida',
            'locality' => 'Sector 137',
            'property_type' => 'Apartment',
            'bedrooms' => '2 BHK',
            'max_budget' => 28000,
            'status' => 'active',
        ]);

        $response = $this->get('/');

        $response->assertStatus(200);
        $content = $response->getContent();

        // 1. Header (Logo, Buy, Rent, PG / Rooms, Commercial, List Property, Sign In)
        $response->assertSee('HomiQ Brand Logo', false);
        $response->assertSee('href="/buy/noida"', false);
        $response->assertSee('href="/rent/noida"', false);
        $response->assertSee('href="/explore/student_pg"', false);
        $response->assertSee('href="/explore/commercial"', false);
        $response->assertSee('List Property Free', false);
        $response->assertSee('Sign In', false);

        // 2. Hero Search (Find Your Next Home Without Brokerage)
        $response->assertSee('Find Your Next Home Without Brokerage', false);

        // 3. Popular Locations (Noida, Delhi, Gurugram, Bangalore, Pune)
        $response->assertSee('Popular Locations', false);
        $response->assertSee('Noida', false);
        $response->assertSee('Delhi', false);
        $response->assertSee('Gurugram', false);
        $response->assertSee('Bangalore', false);
        $response->assertSee('Pune', false);

        // 4. Verified Properties Near You (Real inventory only)
        $response->assertSee('Active Verified Inventory', false);

        // 5. Browse by Need (Flats, PGs, Rooms, Houses, Commercial)
        $response->assertSee('Browse by Need', false);
        $response->assertSee('Flats', false);
        $response->assertSee('PGs', false);
        $response->assertSee('Rooms', false);
        $response->assertSee('Houses', false);
        $response->assertSee('Commercial', false);

        // 6. Why HomiQ? (Verified, Direct Owner, Zero Brokerage, Transparent Pricing)
        $response->assertSee('Why HomiQ?', false);
        $response->assertSee('100% On-Site Verified', false);
        $response->assertSee('Direct Owner Contact', false);
        $response->assertSee('Zero Brokerage', false);
        $response->assertSee('Transparent Pricing', false);

        // 7. Tenant / Buyer Demand Board (Real demand requests)
        $response->assertSee('Tenant &amp; Buyer Demand Board', false);

        // 8. List Your Property Free (Owner CTA)
        $response->assertSee('Have a Property to', false);
        $response->assertSee('Rent or Sell?', false);

        // 9. Rental Cost Calculator
        $response->assertSee('Rental Cost Calculator', false);
        $response->assertSee('Move-In Budget Estimator', false);

        // 10. Popular Locality Guides (SEO links)
        $response->assertSee('Popular Locality Guides', false);

        // 11. App Download
        $response->assertSee('Get Faster Property Alerts on the HomiQ App', false);

        // 12. Safety & Verification
        $response->assertSee('How HomiQ Verifies Properties', false);
        $response->assertSee('Zero Phantom Listings Policy', false);

        // 13. Footer
        $response->assertSee('&copy; 2026 HomiQ Space Rentals Pvt. Ltd.', false);

        // Verify Strict Order of IDs in HTML
        $posHeader = strpos($content, '<header');
        $posHero = strpos($content, 'id="hero-search"');
        $posPopular = strpos($content, 'id="popular-locations"');
        $posListings = strpos($content, 'id="listings"');
        $posBrowseNeed = strpos($content, 'id="browse-by-need"');
        $posWhy = strpos($content, 'id="why-homiq"');
        $posDemand = strpos($content, 'id="demand-board"');
        $posListFree = strpos($content, 'id="list-free"');
        $posCalculator = strpos($content, 'id="rental-calculator"');
        $posLocality = strpos($content, 'id="locality-guides"');
        $posApp = strpos($content, 'id="download-app"');
        $posSafety = strpos($content, 'id="safety-verification"');
        $posFooter = strpos($content, '<footer');

        $this->assertNotFalse($posHeader);
        $this->assertNotFalse($posHero);
        $this->assertNotFalse($posPopular);
        $this->assertNotFalse($posListings);
        $this->assertNotFalse($posBrowseNeed);
        $this->assertNotFalse($posWhy);
        $this->assertNotFalse($posDemand);
        $this->assertNotFalse($posListFree);
        $this->assertNotFalse($posCalculator);
        $this->assertNotFalse($posLocality);
        $this->assertNotFalse($posApp);
        $this->assertNotFalse($posSafety);
        $this->assertNotFalse($posFooter);

        $this->assertTrue(
            $posHeader < $posHero &&
            $posHero < $posPopular &&
            $posPopular < $posListings &&
            $posListings < $posBrowseNeed &&
            $posBrowseNeed < $posWhy &&
            $posWhy < $posDemand &&
            $posDemand < $posListFree &&
            $posListFree < $posCalculator &&
            $posCalculator < $posLocality &&
            $posLocality < $posApp &&
            $posApp < $posSafety &&
            $posSafety < $posFooter,
            'Sections must appear in the exact 13-step sequence on the homepage'
        );
    }
}

