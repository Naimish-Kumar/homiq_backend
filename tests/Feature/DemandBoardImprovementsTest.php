<?php

namespace Tests\Feature;

use App\Models\Notification;
use App\Models\Property;
use App\Models\PropertyRequest;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class DemandBoardImprovementsTest extends TestCase
{
    use RefreshDatabase;

    public function test_demand_board_displays_active_requests_with_details()
    {
        PropertyRequest::create([
            'seeker_name' => 'Aditya Verma',
            'seeker_phone' => '9811002233',
            'city' => 'Noida',
            'locality' => 'Sector 137',
            'property_type' => 'Apartment',
            'bedrooms' => '2 BHK',
            'purpose' => 'rent',
            'tenant_type' => 'working_professional',
            'furnishing_preference' => 'semi_furnished',
            'max_budget' => 28000,
            'move_in_date' => 'Within 15 Days',
            'description' => 'Working in Sector 135 IT SEZ.',
            'status' => 'active',
        ]);

        $response = $this->get('/');
        $response->assertOk();
        $response->assertSee('Tenant &amp; Buyer Demand Board', false);
        $response->assertSee('Sector 137, Noida');
        $response->assertSee('₹28,000/mo');
        $response->assertSee('Working Pro');
        $response->assertSee('Semi Furnished');
    }

    public function test_demand_board_supports_filter_parameters()
    {
        PropertyRequest::create([
            'seeker_name' => 'Noida Seeker',
            'seeker_phone' => '9811002233',
            'city' => 'Noida',
            'locality' => 'Sector 62',
            'property_type' => 'Apartment',
            'bedrooms' => '2 BHK',
            'purpose' => 'rent',
            'max_budget' => 25000,
            'status' => 'active',
        ]);

        PropertyRequest::create([
            'seeker_name' => 'Bangalore Seeker',
            'seeker_phone' => '9811002244',
            'city' => 'Bangalore',
            'locality' => 'HSR Layout',
            'property_type' => 'Apartment',
            'bedrooms' => '3 BHK',
            'purpose' => 'rent',
            'max_budget' => 45000,
            'status' => 'active',
        ]);

        // Filter by City = Noida
        $response = $this->get('/?demand_city=Noida');
        $response->assertOk();
        $response->assertSee('Noida Seeker');
        $response->assertDontSee('Bangalore Seeker');

        // Filter demand only via AJAX
        $ajaxResponse = $this->getJson('/?filter_demand_only=1&demand_city=Bangalore');
        $ajaxResponse->assertOk();
        $ajaxResponse->assertJsonFragment(['seeker_name' => 'Bangalore Seeker']);
    }

    public function test_posting_request_notifies_matching_landlords()
    {
        $landlord = User::factory()->create([
            'email_verified_at' => now(),
        ]);

        $property = Property::create([
            'owner_id' => $landlord->id,
            'title' => '2 BHK High-Rise Apartment in Sector 137',
            'description' => 'Beautiful flat close to metro.',
            'price' => 24000,
            'address' => 'Sector 137, Expressway, Noida, UP',
            'latitude' => 28.5035,
            'longitude' => 77.4042,
            'category' => 'Apartment',
            'bedrooms' => 2,
            'bathrooms' => 2,
            'listing_type' => 'rent',
            'status' => 'approved',
        ]);

        $response = $this->postJson('/property-requests', [
            'seeker_name' => 'Kunal Kapoor',
            'seeker_phone' => '9988776655',
            'city' => 'Noida',
            'locality' => 'Sector 137',
            'property_type' => 'Apartment',
            'bedrooms' => '2 BHK',
            'purpose' => 'rent',
            'tenant_type' => 'working_professional',
            'furnishing_preference' => 'semi_furnished',
            'max_budget' => 26000,
            'move_in_date' => 'Immediate',
            'description' => 'Need 2 BHK immediately in Sector 137.',
        ]);

        $response->assertOk();
        $response->assertJson(['success' => true]);

        // Verify request was stored
        $this->assertDatabaseHas('property_requests', [
            'seeker_name' => 'Kunal Kapoor',
            'city' => 'Noida',
            'locality' => 'Sector 137',
            'tenant_type' => 'working_professional',
        ]);

        // Verify matching landlord received demand_match in-app alert
        $this->assertDatabaseHas('notifications', [
            'user_id' => $landlord->id,
            'type' => 'demand_match',
        ]);

        $notification = Notification::where('user_id', $landlord->id)->first();
        $this->assertStringContainsString('Kunal Kapoor', $notification->message);
        $this->assertStringContainsString('Sector 137', $notification->message);
    }

    public function test_owner_can_fetch_matching_demands_for_listing()
    {
        $landlord = User::factory()->create([
            'email_verified_at' => now(),
        ]);

        $property = Property::create([
            'owner_id' => $landlord->id,
            'title' => 'Sunny 2 BHK in Sector 62',
            'description' => 'Spacious flat near corporate tech hub.',
            'price' => 22000,
            'address' => 'Sector 62, Noida, Uttar Pradesh',
            'latitude' => 28.6280,
            'longitude' => 77.3649,
            'category' => 'Apartment',
            'bedrooms' => 2,
            'bathrooms' => 2,
            'listing_type' => 'rent',
            'status' => 'approved',
        ]);

        PropertyRequest::create([
            'seeker_name' => 'Matching Seeker',
            'seeker_phone' => '9876543210',
            'city' => 'Noida',
            'locality' => 'Sector 62',
            'property_type' => 'Apartment',
            'bedrooms' => '2 BHK',
            'purpose' => 'rent',
            'tenant_type' => 'family',
            'max_budget' => 25000,
            'status' => 'active',
        ]);

        PropertyRequest::create([
            'seeker_name' => 'Unmatched Seeker',
            'seeker_phone' => '9876543211',
            'city' => 'Gurugram',
            'locality' => 'Cyber City',
            'property_type' => 'Apartment',
            'bedrooms' => '1 BHK',
            'purpose' => 'rent',
            'max_budget' => 35000,
            'status' => 'active',
        ]);

        $response = $this->actingAs($landlord)->getJson("/dashboard/listings/{$property->id}/matching-demands");
        $response->assertOk();
        $response->assertJson(['success' => true]);
        $response->assertJsonCount(1, 'matches');
        $response->assertJsonFragment(['name' => 'Matching Seeker']);
        $response->assertJsonMissing(['name' => 'Unmatched Seeker']);
    }
}
