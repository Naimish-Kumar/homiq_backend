<?php

namespace Tests\Feature;

use App\Models\User;
use App\Models\Property;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class PropertyUploadTest extends TestCase
{
    use RefreshDatabase;

    public function test_user_can_create_property_with_multiple_images()
    {
        // Fake public disk for uploads
        Storage::fake('public');

        // Create a test user
        $user = User::create([
            'name' => 'Host User',
            'email' => 'host@example.com',
            'password' => bcrypt('password123'),
        ]);
        $user->email_verified_at = now();
        $user->save();

        // Authenticate the user
        $this->actingAs($user);

        // Prepare fake image files
        $file1 = UploadedFile::fake()->image('villa1.jpg');
        $file2 = UploadedFile::fake()->image('villa2.jpg');
        $file3 = UploadedFile::fake()->image('villa3.jpg');

        // Submit form data
        $response = $this->post('/dashboard/listings', [
            'title' => 'Ocean Breeze Beach House',
            'description' => 'A cozy beachfront cottage with scenic views.',
            'price' => 199.99,
            'currency' => 'USD',
            'billing_frequency' => 'per_day',
            'address' => '456 Oceanfront Way, Malibu, CA',
            'latitude' => 34.0259,
            'longitude' => -118.7798,
            'category' => 'House',
            'bedrooms' => 3,
            'bathrooms' => 2,
            'is_furnished' => 1,
            'has_parking' => 1,
            'is_pet_friendly' => 1,
            'images' => [$file1, $file2, $file3],
        ]);

        // Assert no validation errors
        $response->assertSessionHasNoErrors();

        // Assert response is redirect back
        $response->assertStatus(302);

        // Assert database has property with correct details
        $this->assertDatabaseHas('properties', [
            'title' => 'Ocean Breeze Beach House',
            'currency' => 'USD',
            'billing_frequency' => 'per_day',
            'price' => 199.99,
        ]);

        // Get created property and assert images list is processed and serialized
        $property = Property::latest()->first();
        $this->assertCount(3, $property->images);
        $this->assertStringContainsString('uploads/properties/', $property->images[0]);
    }
}
