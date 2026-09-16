<?php

namespace Tests\Feature;

use App\Models\Property;
use App\Models\PropertyRequest;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class PropertyRequestTest extends TestCase
{
    use RefreshDatabase;

    public function test_home_page_loads_with_demand_board_and_search_dock()
    {
        PropertyRequest::create([
            'seeker_name' => 'Rahul Sharma',
            'seeker_phone' => '9876543210',
            'city' => 'Noida',
            'locality' => 'Sector 137',
            'property_type' => 'Apartment',
            'bedrooms' => '2 BHK',
            'max_budget' => 25000,
            'status' => 'active',
        ]);

        $response = $this->get('/');

        $response->assertOk();
        $response->assertSee('Find Your Next Home');
        $response->assertSee('Search flats, rooms, PGs and properties directly from owners.');
        $response->assertSee('Tenant &amp; Buyer Demand Board', false);
        $response->assertSee('Sector 137, Noida');
        $response->assertSee('Why HomiQ?');
        $response->assertSee('List Your Property Free');
    }

    public function test_seeker_can_post_property_request()
    {
        $response = $this->postJson('/property-requests', [
            'seeker_name' => 'Priya Nair',
            'seeker_phone' => '9811223344',
            'city' => 'Bangalore',
            'locality' => 'HSR Layout',
            'property_type' => 'Apartment',
            'bedrooms' => '1 BHK',
            'min_budget' => 15000,
            'max_budget' => 22000,
            'purpose' => 'rent',
            'move_in_date' => 'Immediate',
            'description' => 'Looking for clean 1 BHK in HSR Sector 2',
        ]);

        $response->assertOk();
        $response->assertJson([
            'success' => true,
        ]);

        $this->assertDatabaseHas('property_requests', [
            'seeker_name' => 'Priya Nair',
            'city' => 'Bangalore',
            'locality' => 'HSR Layout',
            'property_type' => 'Apartment',
            'max_budget' => 22000,
        ]);
    }
}

