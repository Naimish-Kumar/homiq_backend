<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\User;
use App\Models\Property;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Mail;
use App\Mail\PropertyStatusMail;

class BulkPropertyModerationTest extends TestCase
{
    use RefreshDatabase;

    private User $admin;
    private User $host;

    protected function setUp(): void
    {
        parent::setUp();

        $this->admin = User::create([
            'name' => 'Admin User',
            'email' => 'admin@homiq.com',
            'password' => bcrypt('password'),
            'is_admin' => true,
        ]);
        $this->admin->email_verified_at = now();
        $this->admin->save();

        $this->host = User::create([
            'name' => 'Host User',
            'email' => 'host@homiq.com',
            'password' => bcrypt('password'),
        ]);
        $this->host->email_verified_at = now();
        $this->host->save();
    }

    public function test_admin_can_bulk_approve_properties()
    {
        Mail::fake();

        $p1 = Property::create([
            'owner_id' => $this->host->id,
            'title' => 'Penthouse 1',
            'description' => 'Test Penthouse',
            'price' => 1000,
            'address' => 'Delhi',
            'latitude' => 28.61,
            'longitude' => 77.20,
            'category' => 'Apartment',
            'bedrooms' => 3,
            'bathrooms' => 2,
            'is_furnished' => true,
            'has_parking' => true,
            'is_pet_friendly' => true,
            'amenities' => ['AC'],
            'images' => ['http://example.com/img1.jpg'],
            'status' => 'pending',
        ]);

        $p2 = Property::create([
            'owner_id' => $this->host->id,
            'title' => 'Penthouse 2',
            'description' => 'Test Penthouse 2',
            'price' => 1200,
            'address' => 'Gurgaon',
            'latitude' => 28.45,
            'longitude' => 77.02,
            'category' => 'Apartment',
            'bedrooms' => 2,
            'bathrooms' => 2,
            'is_furnished' => true,
            'has_parking' => true,
            'is_pet_friendly' => true,
            'amenities' => ['AC'],
            'images' => ['http://example.com/img2.jpg'],
            'status' => 'pending',
        ]);

        $this->actingAs($this->admin);

        $response = $this->post('/admin/properties/bulk-status', [
            'action' => 'approve',
            'property_ids' => [$p1->id, $p2->id],
            'notify_owner' => true,
        ]);

        $response->assertStatus(302);
        $this->assertEquals('approved', $p1->fresh()->status);
        $this->assertEquals('approved', $p2->fresh()->status);

        Mail::assertSent(PropertyStatusMail::class, 2);
    }

    public function test_admin_can_bulk_reject_properties_with_reason()
    {
        Mail::fake();

        $p1 = Property::create([
            'owner_id' => $this->host->id,
            'title' => 'Studio Apt',
            'description' => 'Studio',
            'price' => 500,
            'address' => 'Noida',
            'latitude' => 28.53,
            'longitude' => 77.39,
            'category' => 'Studio',
            'bedrooms' => 1,
            'bathrooms' => 1,
            'is_furnished' => false,
            'has_parking' => false,
            'is_pet_friendly' => false,
            'amenities' => ['WiFi'],
            'images' => ['http://example.com/img3.jpg'],
            'status' => 'pending',
        ]);

        $this->actingAs($this->admin);

        $response = $this->post('/admin/properties/bulk-status', [
            'action' => 'reject',
            'property_ids' => [$p1->id],
            'rejection_reason' => 'Low quality, blurry, or insufficient photos',
            'rejection_notes' => 'Please upload at least 3 high-resolution photos of the living room and bathroom.',
            'notify_owner' => true,
        ]);

        $response->assertStatus(302);
        $this->assertEquals('rejected', $p1->fresh()->status);

        Mail::assertSent(PropertyStatusMail::class, function ($mail) {
            return $mail->status === 'rejected' &&
                   $mail->reason === 'Low quality, blurry, or insufficient photos' &&
                   str_contains($mail->notes, 'high-resolution photos');
        });
    }

    public function test_admin_can_bulk_delete_and_feature_properties()
    {
        $p1 = Property::create([
            'owner_id' => $this->host->id,
            'title' => 'Villa A',
            'description' => 'Villa Description',
            'price' => 2500,
            'address' => 'South Delhi',
            'latitude' => 28.50,
            'longitude' => 77.20,
            'category' => 'Villa',
            'bedrooms' => 4,
            'bathrooms' => 4,
            'is_furnished' => true,
            'has_parking' => true,
            'is_pet_friendly' => true,
            'amenities' => ['Pool'],
            'images' => ['http://example.com/img4.jpg'],
            'status' => 'approved',
            'is_featured' => false,
        ]);

        $this->actingAs($this->admin);

        // Feature
        $this->post('/admin/properties/bulk-status', [
            'action' => 'feature',
            'property_ids' => [$p1->id],
        ]);
        $this->assertTrue($p1->fresh()->is_featured);

        // Delete
        $this->post('/admin/properties/bulk-status', [
            'action' => 'delete',
            'property_ids' => [$p1->id],
        ]);
        $this->assertNull(Property::find($p1->id));
    }
}
