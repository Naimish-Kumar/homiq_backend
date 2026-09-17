<?php

namespace Tests\Feature;

use App\Models\Property;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class BrandingAndCopyImprovementsTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();
    }

    public function test_homepage_contains_value_driven_and_localized_copy(): void
    {
        $owner = User::factory()->create([
            'is_verified' => true,
        ]);

        Property::create([
            'owner_id' => $owner->id,
            'title' => '2 BHK Luxury Flat in Sector 137',
            'slug' => '2-bhk-luxury-flat-in-sector-137',
            'description' => 'Direct from owner flat near metro.',
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

        $response = $this->get('/');

        $response->assertStatus(200);

        // Task 54: High-impact, value-driven copy
        $response->assertSee('Find Verified Properties Without Brokerage', false);
        $response->assertSee('Real Listings. Direct Owners. Clear Pricing.', false);
        $response->assertSee('Search Flats, PGs and Rooms That Match Your Budget', false);
        $response->assertSee('Built for direct, zero-brokerage renting', false);

        // Task 55: Indian terminology
        $response->assertSee('Flat', false);
        $response->assertSee('PG', false);
        $response->assertSee('Room', false);
        $response->assertSee('BHK', false);
        $response->assertSee('0% Brokerage', false);
        $response->assertSee('Listed by Owner', false);

        // Check that generic phrases are NOT present
        $response->assertDontSee('Find the home where your life happens', false);
        $response->assertDontSee('authentic residences', false);
        $response->assertDontSee('modern tenants', false);
    }

    public function test_inr_price_formatting_for_rentals_and_sales(): void
    {
        $owner = User::factory()->create(['is_verified' => true]);

        // Rental property
        $rental = Property::create([
            'owner_id' => $owner->id,
            'title' => 'Rental Flat',
            'slug' => 'rental-flat',
            'description' => 'Test rental flat description.',
            'category' => 'Apartment',
            'city' => 'Noida',
            'locality' => 'Sector 137',
            'address' => 'Sector 137, Noida',
            'price' => 25000,
            'security_deposit' => 50000,
            'listing_type' => 'rent',
            'currency_symbol' => '₹',
            'is_active' => true,
        ]);

        $this->assertEquals('₹25,000/mo', $rental->formatted_price);
        $this->assertEquals('₹50,000 Deposit', $rental->formatted_deposit);

        // Sale property in Lakhs
        $saleLakh = Property::create([
            'owner_id' => $owner->id,
            'title' => 'Sale Flat in Lakhs',
            'slug' => 'sale-flat-in-lakhs',
            'description' => 'Test sale flat description.',
            'category' => 'Apartment',
            'city' => 'Noida',
            'locality' => 'Sector 137',
            'address' => 'Sector 137, Noida',
            'price' => 8500000, // 85 Lakh
            'listing_type' => 'sale',
            'currency_symbol' => '₹',
            'is_active' => true,
        ]);

        $this->assertEquals('₹85.00 Lakh', $saleLakh->formatted_price);

        // Sale property in Crores
        $saleCr = Property::create([
            'owner_id' => $owner->id,
            'title' => 'Sale Villa in Crores',
            'slug' => 'sale-villa-in-crores',
            'description' => 'Test sale villa description.',
            'category' => 'Villa',
            'city' => 'Noida',
            'locality' => 'Sector 128',
            'address' => 'Sector 128, Noida',
            'price' => 12500000, // 1.25 Cr
            'listing_type' => 'sale',
            'currency_symbol' => '₹',
            'is_active' => true,
        ]);

        $this->assertEquals('₹1.25 Cr', $saleCr->formatted_price);
    }

    public function test_property_detail_page_contains_indian_cost_breakdown_and_badges(): void
    {
        $owner = User::factory()->create([
            'is_verified' => true,
        ]);

        $property = Property::create([
            'owner_id' => $owner->id,
            'title' => 'Spacious 3 BHK in Sector 62',
            'slug' => 'spacious-3-bhk-in-sector-62',
            'description' => 'Direct owner 3 BHK flat with all modern amenities.',
            'category' => 'Apartment',
            'city' => 'Noida',
            'locality' => 'Sector 62',
            'address' => 'Sector 62, Noida',
            'bedrooms' => 3,
            'bathrooms' => 3,
            'price' => 32000,
            'security_deposit' => 64000,
            'maintenance_fee' => 3000,
            'listing_type' => 'rent',
            'furnishing_status' => 'semi_furnished',
            'is_active' => true,
        ]);

        $response = $this->get('/properties/' . $property->id);

        $response->assertStatus(200);

        // India-focused cost breakdown terms
        $response->assertSee('Complete Rental Cost Breakdown', false);
        $response->assertSee('Monthly Rent', false);
        $response->assertSee('Security Deposit', false);
        $response->assertSee('Society Maintenance', false);
        $response->assertSee('Brokerage Fee', false);
        $response->assertSee('Zero Brokerage Guarantee', false);
        $response->assertSee('₹32,000', false);
        $response->assertSee('₹64,000', false);
        $response->assertSee('₹2,000/mo', false);
    }
}
