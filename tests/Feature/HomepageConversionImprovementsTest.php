<?php

namespace Tests\Feature;

use App\Models\Property;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class HomepageConversionImprovementsTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();

        $owner = User::factory()->create(['name' => 'Amit Sharma', 'phone' => '9876543210']);
        $agent = User::factory()->create(['name' => 'Prop Realty', 'phone' => '9811223344']);

        // 1. Budget Apartment near metro listed by owner
        Property::create([
            'owner_id' => $owner->id,
            'title' => '2 BHK Sunshine Apartment',
            'description' => 'Spacious 2 BHK near Botanical Garden metro station.',
            'address' => 'Sector 137, Noida, Uttar Pradesh',
            'category' => 'Apartment',
            'listing_type' => 'rent',
            'listed_by' => 'owner',
            'distance_from_metro' => '500m from Sector 137 Metro Station',
            'price' => 22000,
            'security_deposit' => 44000,
            'bedrooms' => 2,
            'bathrooms' => 2,
            'is_furnished' => true,
            'has_parking' => true,
            'is_pet_friendly' => true,
            'status' => 'approved',
            'available_from' => now()->subDay(),
        ]);

        // 2. High budget luxury villa listed by agent
        Property::create([
            'owner_id' => $agent->id,
            'title' => '4 BHK Luxury Jaypee Villa',
            'description' => 'Golf course facing independent bungalow with private lawn.',
            'address' => 'Jaypee Greens, Greater Noida, Uttar Pradesh',
            'category' => 'Villa',
            'listing_type' => 'rent',
            'listed_by' => 'agent',
            'distance_from_metro' => '3.5 km from Pari Chowk Metro',
            'price' => 75000,
            'security_deposit' => 150000,
            'bedrooms' => 4,
            'bathrooms' => 4,
            'is_furnished' => false,
            'has_parking' => true,
            'is_pet_friendly' => true,
            'status' => 'approved',
            'available_from' => now()->addDays(20),
        ]);

        // 3. Student PG in Knowledge Park
        Property::create([
            'owner_id' => $owner->id,
            'title' => 'Single Room PG near Galgotias University',
            'description' => 'Fully furnished student PG with 3-time meals and high speed WiFi.',
            'address' => 'Knowledge Park 3, Greater Noida, Uttar Pradesh',
            'category' => 'Studio',
            'listing_type' => 'rent',
            'listed_by' => 'owner',
            'price' => 11000,
            'security_deposit' => 11000,
            'bedrooms' => 1,
            'bathrooms' => 1,
            'is_furnished' => true,
            'status' => 'approved',
            'available_from' => now()->subDays(5),
        ]);
    }

    public function test_natural_language_intent_search()
    {
        // Query: "2 BHK under 25k"
        $response = $this->get('/?search=2+BHK+under+25k');
        $response->assertOk();
        $response->assertSee('2 BHK Sunshine Apartment');
        $response->assertDontSee('4 BHK Luxury Jaypee Villa');

        // Query: "metro"
        $responseMetro = $this->get('/?search=near+metro');
        $responseMetro->assertOk();
        $responseMetro->assertSee('2 BHK Sunshine Apartment');
    }

    public function test_curated_collections()
    {
        // Owner only collection
        $responseOwner = $this->get('/?collection=owner_only');
        $responseOwner->assertOk();
        $responseOwner->assertSee('2 BHK Sunshine Apartment');
        $responseOwner->assertSee('Single Room PG near Galgotias University');
        $responseOwner->assertDontSee('4 BHK Luxury Jaypee Villa');

        // Budget friendly (< 15k)
        $responseBudget = $this->get('/?collection=budget_friendly');
        $responseBudget->assertOk();
        $responseBudget->assertSee('Single Room PG near Galgotias University');
        $responseBudget->assertDontSee('2 BHK Sunshine Apartment');
        $responseBudget->assertDontSee('4 BHK Luxury Jaypee Villa');

        // Near Metro collection
        $responseMetroCol = $this->get('/?collection=near_metro');
        $responseMetroCol->assertOk();
        $responseMetroCol->assertSee('2 BHK Sunshine Apartment');
    }

    public function test_owner_vs_agent_transparency_badges()
    {
        $response = $this->get('/');
        $response->assertOk();
        $response->assertSee('Listed by Owner');
        $response->assertSee('Verified Agent');
    }

    public function test_property_details_page_renders_freshness_and_whatsapp_cta()
    {
        $property = Property::first();
        
        // Guest view
        $response = $this->get('/properties/' . $property->id);
        $response->assertOk();
        $response->assertSee('Chat Directly on WhatsApp');
        $response->assertSee('Sign In to Chat In-App');
        $response->assertSee($property->freshness_badge);
        $response->assertSee($property->availability_badge);

        // Authenticated seeker view
        $seeker = User::factory()->create();
        $authResponse = $this->actingAs($seeker)->get('/properties/' . $property->id);
        $authResponse->assertOk();
        $authResponse->assertSee('Message Landlord In-App');
    }
}
