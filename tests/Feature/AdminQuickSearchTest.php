<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\User;
use App\Models\Property;
use App\Models\PropertyRequest;
use Illuminate\Foundation\Testing\RefreshDatabase;

class AdminQuickSearchTest extends TestCase
{
    use RefreshDatabase;

    private User $admin;
    private User $member;
    private Property $property;
    private PropertyRequest $demand;

    protected function setUp(): void
    {
        parent::setUp();

        $this->admin = User::create([
            'name' => 'Search Super Admin',
            'email' => 'search_admin@homiq.com',
            'password' => bcrypt('password'),
            'is_admin' => true,
        ]);
        $this->admin->email_verified_at = now();
        $this->admin->save();

        $this->member = User::create([
            'name' => 'Aarav Malhotra',
            'email' => 'aarav.malhotra@example.com',
            'phone' => '+91 9988776655',
            'password' => bcrypt('password'),
        ]);
        $this->member->email_verified_at = now();
        $this->member->save();

        $this->property = Property::create([
            'owner_id' => $this->member->id,
            'title' => 'Penthouse Azure View',
            'description' => 'Luxury penthouse with panoramic terrace',
            'price' => 45000,
            'address' => 'Golf Course Road, Gurgaon',
            'latitude' => 28.45,
            'longitude' => 77.08,
            'category' => 'Penthouse',
            'bedrooms' => 4,
            'bathrooms' => 4,
            'is_furnished' => true,
            'has_parking' => true,
            'is_pet_friendly' => true,
            'amenities' => ['Pool', 'Gym'],
            'images' => ['https://example.com/penthouse.jpg'],
            'status' => 'approved',
        ]);

        $this->demand = PropertyRequest::create([
            'user_id' => $this->member->id,
            'seeker_name' => 'Sneha Kapoor',
            'seeker_email' => 'sneha@example.com',
            'seeker_phone' => '+91 9123456789',
            'city' => 'Gurgaon',
            'locality' => 'DLF Phase 5',
            'property_type' => 'Apartment',
            'bedrooms' => '3 BHK',
            'min_budget' => 40000,
            'max_budget' => 50000,
            'purpose' => 'rent',
            'status' => 'active',
        ]);
    }

    public function test_non_admin_cannot_access_quick_search()
    {
        $this->actingAs($this->member);

        $response = $this->getJson('/admin/quick-search?q=test');
        $response->assertStatus(403);
    }

    public function test_admin_empty_query_returns_default_shortcuts()
    {
        $this->actingAs($this->admin);

        $response = $this->getJson('/admin/quick-search');
        $response->assertStatus(200);
        $response->assertJsonStructure([
            'query',
            'total',
            'results' => [
                'shortcuts',
                'properties',
                'users',
                'demands',
            ],
        ]);

        $shortcuts = $response->json('results.shortcuts');
        $this->assertNotEmpty($shortcuts);
        $this->assertContains('Property Moderation', array_column($shortcuts, 'title'));
    }

    public function test_admin_search_finds_matching_properties()
    {
        $this->actingAs($this->admin);

        $response = $this->getJson('/admin/quick-search?q=Azure');
        $response->assertStatus(200);

        $properties = $response->json('results.properties');
        $this->assertCount(1, $properties);
        $this->assertEquals('Penthouse Azure View', $properties[0]['title']);
        $this->assertEquals('Penthouse', $properties[0]['category']);
    }

    public function test_admin_search_finds_matching_users()
    {
        $this->actingAs($this->admin);

        $response = $this->getJson('/admin/quick-search?q=Malhotra');
        $response->assertStatus(200);

        $users = $response->json('results.users');
        $this->assertCount(1, $users);
        $this->assertEquals('Aarav Malhotra', $users[0]['title']);
        $this->assertEquals('aarav.malhotra@example.com', explode(' • ', $users[0]['subtitle'])[0]);
    }

    public function test_admin_search_finds_matching_demands()
    {
        $this->actingAs($this->admin);

        $response = $this->getJson('/admin/quick-search?q=Sneha');
        $response->assertStatus(200);

        $demands = $response->json('results.demands');
        $this->assertCount(1, $demands);
        $this->assertStringContainsString('Sneha Kapoor', $demands[0]['title']);
        $this->assertStringContainsString('DLF Phase 5', $demands[0]['subtitle']);
    }

    public function test_admin_search_finds_system_navigation_shortcuts()
    {
        $this->actingAs($this->admin);

        $response = $this->getJson('/admin/quick-search?q=financials');
        $response->assertStatus(200);

        $shortcuts = $response->json('results.shortcuts');
        $this->assertNotEmpty($shortcuts);
        $this->assertContains('Financial Analytics', array_column($shortcuts, 'title'));
    }
}
