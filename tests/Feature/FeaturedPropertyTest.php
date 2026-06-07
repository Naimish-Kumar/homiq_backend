<?php

namespace Tests\Feature;

use App\Models\User;
use App\Models\Property;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class FeaturedPropertyTest extends TestCase
{
    use RefreshDatabase;

    /**
     * Test Host can toggle their own property featured status.
     */
    public function test_host_can_toggle_own_property_featured_status()
    {
        $host = User::create([
            'name' => 'John Host',
            'email' => 'host@example.com',
            'password' => bcrypt('password'),
        ]);
        $host->email_verified_at = now();
        $host->save();

        $property = Property::create([
            'owner_id' => $host->id,
            'title' => 'My Lovely Villa',
            'description' => 'A wonderful place to stay.',
            'price' => 200,
            'address' => '123 Main St',
            'latitude' => 12.34,
            'longitude' => 56.78,
            'category' => 'Villa',
            'bedrooms' => 2,
            'bathrooms' => 1,
            'is_furnished' => true,
            'has_parking' => true,
            'is_pet_friendly' => true,
            'amenities' => ['WiFi'],
            'images' => ['http://example.com/image.jpg'],
            'status' => 'approved',
            'is_featured' => false,
        ]);

        $this->actingAs($host);

        // First toggle to true
        $response = $this->post("/dashboard/listings/{$property->id}/toggle-featured");
        $response->assertStatus(302); // redirects back
        $this->assertTrue($property->fresh()->is_featured);

        // Second toggle to false
        $response = $this->post("/dashboard/listings/{$property->id}/toggle-featured");
        $response->assertStatus(302); // redirects back
        $this->assertFalse($property->fresh()->is_featured);
    }

    /**
     * Test Host cannot toggle featured status of someone else's property.
     */
    public function test_host_cannot_toggle_other_property_featured_status()
    {
        $host1 = User::create([
            'name' => 'John Host',
            'email' => 'host1@example.com',
            'password' => bcrypt('password'),
        ]);
        $host1->email_verified_at = now();
        $host1->save();

        $host2 = User::create([
            'name' => 'Jane Host',
            'email' => 'host2@example.com',
            'password' => bcrypt('password'),
        ]);
        $host2->email_verified_at = now();
        $host2->save();

        $property = Property::create([
            'owner_id' => $host1->id,
            'title' => 'Johns Villa',
            'description' => 'A wonderful place to stay.',
            'price' => 200,
            'address' => '123 Main St',
            'latitude' => 12.34,
            'longitude' => 56.78,
            'category' => 'Villa',
            'bedrooms' => 2,
            'bathrooms' => 1,
            'is_furnished' => true,
            'has_parking' => true,
            'is_pet_friendly' => true,
            'amenities' => ['WiFi'],
            'images' => ['http://example.com/image.jpg'],
            'status' => 'approved',
            'is_featured' => false,
        ]);

        $this->actingAs($host2);

        $response = $this->post("/dashboard/listings/{$property->id}/toggle-featured");
        $response->assertStatus(404); // Not found for this host
        $this->assertFalse($property->fresh()->is_featured);
    }

    /**
     * Test Admin can toggle featured status of any property.
     */
    public function test_admin_can_toggle_any_property_featured_status()
    {
        $admin = User::create([
            'name' => 'Admin User',
            'email' => 'admin@homiq.com',
            'password' => bcrypt('password'),
            'is_admin' => true,
        ]);
        $admin->email_verified_at = now();
        $admin->save();

        $host = User::create([
            'name' => 'John Host',
            'email' => 'host@example.com',
            'password' => bcrypt('password'),
        ]);
        $host->email_verified_at = now();
        $host->save();

        $property = Property::create([
            'owner_id' => $host->id,
            'title' => 'Host Villa',
            'description' => 'A wonderful place to stay.',
            'price' => 200,
            'address' => '123 Main St',
            'latitude' => 12.34,
            'longitude' => 56.78,
            'category' => 'Villa',
            'bedrooms' => 2,
            'bathrooms' => 1,
            'is_furnished' => true,
            'has_parking' => true,
            'is_pet_friendly' => true,
            'amenities' => ['WiFi'],
            'images' => ['http://example.com/image.jpg'],
            'status' => 'approved',
            'is_featured' => false,
        ]);

        $this->actingAs($admin);

        // First toggle to true
        $response = $this->post("/admin/properties/{$property->id}/toggle-featured");
        $response->assertStatus(302); // redirects back
        $this->assertTrue($property->fresh()->is_featured);

        // Second toggle to false
        $response = $this->post("/admin/properties/{$property->id}/toggle-featured");
        $response->assertStatus(302); // redirects back
        $this->assertFalse($property->fresh()->is_featured);
    }
}
