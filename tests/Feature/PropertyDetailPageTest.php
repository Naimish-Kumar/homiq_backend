<?php

namespace Tests\Feature;

use App\Models\User;
use App\Models\Property;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class PropertyDetailPageTest extends TestCase
{
    use RefreshDatabase;

    protected User $owner;
    protected Property $mainProperty;
    protected Property $similarLocalityProp;
    protected Property $similarPriceProp;
    protected Property $similarBhkProp;

    protected function setUp(): void
    {
        parent::setUp();

        $this->owner = User::create([
            'name' => 'Aditya Sharma',
            'email' => 'aditya.sharma@example.com',
            'password' => bcrypt('password123'),
            'phone' => '9876543210',
            'is_admin' => false,
            'is_verified' => true,
            'email_verified_at' => now(),
        ]);

        // Main Property: 2 BHK Rental in Sector 137 Noida
        $this->mainProperty = Property::create([
            'owner_id' => $this->owner->id,
            'title' => '2 BHK Luxury Apartment in Sector 137 Noida',
            'description' => 'Beautiful sunny apartment facing green park with modern fittings, 5 mins walk to metro.',
            'price' => 25000,
            'security_deposit' => 50000,
            'maintenance_fee' => 2500,
            'address' => 'Sector 137, Noida, Uttar Pradesh',
            'category' => 'Apartment',
            'listing_type' => 'rent',
            'bedrooms' => 2,
            'bathrooms' => 2,
            'carpet_area' => 1150,
            'built_up_area' => 1350,
            'is_furnished' => true,
            'listed_by' => 'owner',
            'status' => 'approved',
            'is_verified' => true,
            'is_physical_verified' => true,
            'verified_at' => now()->subDays(3),
            'available_from' => now()->addDays(15),
            'latitude' => 28.5034,
            'longitude' => 77.4048,
            'photos' => [
                'https://images.unsplash.com/photo-1545324418-cc1a3fa10c00?auto=format&fit=crop&w=800&q=80',
                'https://images.unsplash.com/photo-1512917774080-9991f1c4c750?auto=format&fit=crop&w=800&q=80',
            ],
            'amenities' => ['Power Backup', 'Lift', 'Clubhouse', 'Gym', 'Metro Connectivity'],
        ]);

        // Similar property 1: Same locality (Sector 137)
        $this->similarLocalityProp = Property::create([
            'owner_id' => $this->owner->id,
            'title' => '2 BHK in Paras Tierea Sector 137',
            'description' => 'Great community living in Sector 137 near metro.',
            'price' => 24000,
            'security_deposit' => 48000,
            'address' => 'Sector 137, Noida, Uttar Pradesh',
            'category' => 'Apartment',
            'listing_type' => 'rent',
            'bedrooms' => 2,
            'bathrooms' => 2,
            'area_sqft' => 1100,
            'is_furnished' => true,
            'listed_by' => 'owner',
            'status' => 'approved',
        ]);

        // Similar property 2: In price bracket (₹26,000) in Sector 143
        $this->similarPriceProp = Property::create([
            'owner_id' => $this->owner->id,
            'title' => '3 BHK Apartment in Sector 143',
            'description' => 'Spacious 3 BHK near expressway.',
            'price' => 26000,
            'security_deposit' => 52000,
            'address' => 'Sector 143, Noida, Uttar Pradesh',
            'category' => 'Apartment',
            'listing_type' => 'rent',
            'bedrooms' => 3,
            'bathrooms' => 2,
            'area_sqft' => 1400,
            'is_furnished' => false,
            'listed_by' => 'owner',
            'status' => 'approved',
        ]);

        // Similar property 3: Same BHK (2 BHK) in Sector 75
        $this->similarBhkProp = Property::create([
            'owner_id' => $this->owner->id,
            'title' => '2 BHK Semi-Furnished in Sector 75',
            'description' => 'Close to commercial hubs.',
            'price' => 22000,
            'security_deposit' => 44000,
            'address' => 'Sector 75, Noida, Uttar Pradesh',
            'category' => 'Apartment',
            'listing_type' => 'rent',
            'bedrooms' => 2,
            'bathrooms' => 2,
            'area_sqft' => 1050,
            'is_furnished' => false,
            'listed_by' => 'owner',
            'status' => 'approved',
        ]);
    }

    /**
     * Task 30: Property Detail Page Above-the-fold specs, badges & primary CTA buttons.
     */
    public function test_property_page_renders_above_the_fold_information_and_actions()
    {
        $response = $this->get('/property/' . $this->mainProperty->id);

        $response->assertStatus(200);

        // Core title & price
        $response->assertSee('2 BHK Luxury Apartment in Sector 137 Noida');
        $response->assertSee('25,000');
        $response->assertSee('/month');

        // Specification badges
        $response->assertSee('2 BHK');
        $response->assertSee('1,150 sq ft');
        $response->assertSee('Furnished');
        $response->assertSee('Listed by Owner');
        $response->assertSee('Verified Listing');
        $response->assertSee('0% Brokerage');

        // Primary conversion CTAs
        $response->assertSee('Schedule Physical Visit');
        $response->assertSee('Chat Directly on WhatsApp');
        $response->assertSee('Save');
        $response->assertSee('Share');

        // Verified badge modal trigger
        $response->assertSee('What does Verified mean?');
    }

    /**
     * Task 31: Complete Rental Cost Breakdown table and Move-in Estimate.
     */
    public function test_property_page_renders_complete_rental_cost_breakdown()
    {
        $response = $this->get('/property/' . $this->mainProperty->id);

        $response->assertStatus(200);

        // Section header
        $response->assertSee('Complete Rental Cost Breakdown');
        $response->assertSee('100% Transparent Financials');
        $response->assertSee('Zero Brokerage Guarantee');

        // Individual line items
        $response->assertSee('Monthly Rent');
        $response->assertSee('25,000');

        $response->assertSee('Security Deposit');
        $response->assertSee('50,000');
        $response->assertSee('100% Refundable at lease end');

        $response->assertSee('Society Maintenance');
        $response->assertSee('2,000');

        $response->assertSee('Brokerage Fee');
        $response->assertSee('₹0 (FREE)');

        // Estimated Move-in Total
        $response->assertSee('Estimated Move-In Total');
        // 25000 + 50000 + 2000 = 77,000
        $response->assertSee('77,000');
    }

    /**
     * Task 32: Location Intelligence, Commute times & Privacy-Safe Map.
     */
    public function test_property_page_renders_location_intelligence_and_map()
    {
        $response = $this->get('/property/' . $this->mainProperty->id);

        $response->assertStatus(200);

        // Location Intelligence header
        $response->assertSee('Location &amp; Commute Insights', false);
        $response->assertSee('Micro-Market Intelligence');

        // Commute cards
        $response->assertSee('Metro &amp; Public Transit', false);
        $response->assertSee('Sector 137 Metro Station (Aqua Line)');

        $response->assertSee('Hospitals &amp; Clinics', false);
        $response->assertSee('Felix Hospital');
        $response->assertSee('Jaypee Hospital');

        $response->assertSee('Corporate Tech Parks', false);
        $response->assertSee('Advant Navis');

        $response->assertSee('Daily Needs &amp; Markets', false);

        // Privacy-safe map section
        $response->assertSee('Exact unit &amp; house number confirmed after booking a visit for owner privacy.', false);
        $response->assertSee('Open in Google Maps');
        $response->assertSee('id="property-map"', false);
    }

    /**
     * Task 33: Similar Properties tabbed recommendations.
     */
    public function test_property_page_renders_similar_properties_tabs()
    {
        $response = $this->get('/property/' . $this->mainProperty->id);

        $response->assertStatus(200);

        // Section header
        $response->assertSee('Similar Properties You Might Like');

        // Tab titles
        $response->assertSee('In Sector 137');
        $response->assertSee('Under ₹32,500');
        $response->assertSee('Other 2 BHK');

        // Recommendations from DB
        $response->assertSee('2 BHK in Paras Tierea Sector 137');
        $response->assertSee('3 BHK Apartment in Sector 143');
        $response->assertSee('2 BHK Semi-Furnished in Sector 75');
    }

    /**
     * Visit Scheduling Modal verification.
     */
    public function test_property_page_includes_visit_scheduling_modal()
    {
        $response = $this->get('/property/' . $this->mainProperty->id);

        $response->assertStatus(200);
        $response->assertSee('Schedule a Free Visit');
        $response->assertSee('Preferred Date');
        $response->assertSee('Time Slot');
        $response->assertSee('Confirm Visit Schedule');
    }
}
