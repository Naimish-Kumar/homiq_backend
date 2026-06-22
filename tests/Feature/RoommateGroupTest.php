<?php

namespace Tests\Feature;

use App\Models\User;
use App\Models\Property;
use App\Models\RoommateGroup;
use App\Models\Booking;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class RoommateGroupTest extends TestCase
{
    use RefreshDatabase;

    private $owner;
    private $property;
    private $user1;
    private $user2;
    private $user3;

    protected function setUp(): void
    {
        parent::setUp();

        $this->owner = User::create([
            'name' => 'Owner Name',
            'email' => 'owner@example.com',
            'password' => bcrypt('password123'),
        ]);

        $this->property = Property::create([
            'owner_id' => $this->owner->id,
            'title' => 'Large Apartment in Noida',
            'description' => 'Perfect for shared living.',
            'price' => 30000.00,
            'address' => 'Noida IT Park',
            'category' => 'Apartment',
            'bedrooms' => 3,
            'bathrooms' => 2,
            'is_furnished' => true,
            'has_parking' => true,
            'is_pet_friendly' => true,
            'supports_group_renting' => true,
            'group_max_size' => 3,
            'status' => 'approved',
        ]);

        $this->user1 = User::create([
            'name' => 'Renter One',
            'email' => 'renter1@example.com',
            'password' => bcrypt('password123'),
        ]);

        $this->user2 = User::create([
            'name' => 'Renter Two',
            'email' => 'renter2@example.com',
            'password' => bcrypt('password123'),
        ]);

        $this->user3 = User::create([
            'name' => 'Renter Three',
            'email' => 'renter3@example.com',
            'password' => bcrypt('password123'),
        ]);
    }

    public function test_user_can_start_roommate_group()
    {
        $response = $this->actingAs($this->user1)
            ->postJson("/api/properties/{$this->property->id}/roommate-groups");

        $response->assertStatus(201);
        $response->assertJsonFragment([
            'property_id' => $this->property->id,
            'creator_id' => $this->user1->id,
            'status' => 'searching',
            'max_roommates' => 3,
        ]);

        $this->assertDatabaseHas('roommate_groups', [
            'property_id' => $this->property->id,
            'creator_id' => $this->user1->id,
        ]);

        $this->assertDatabaseHas('roommate_group_members', [
            'user_id' => $this->user1->id,
        ]);
    }

    public function test_user_cannot_start_group_if_property_does_not_support_it()
    {
        $this->property->update(['supports_group_renting' => false]);

        $response = $this->actingAs($this->user1)
            ->postJson("/api/properties/{$this->property->id}/roommate-groups");

        $response->assertStatus(400);
        $response->assertJsonFragment([
            'message' => 'This property does not support group renting.',
        ]);
    }

    public function test_user_can_join_active_roommate_group_and_transition_to_ready()
    {
        // User1 starts group
        $group = RoommateGroup::create([
            'property_id' => $this->property->id,
            'creator_id' => $this->user1->id,
            'status' => 'searching',
            'max_roommates' => 3,
        ]);
        $group->members()->attach($this->user1->id);

        // User2 joins group
        $response = $this->actingAs($this->user2)
            ->postJson("/api/roommate-groups/{$group->id}/join");

        $response->assertStatus(200);
        $this->assertDatabaseHas('roommate_group_members', [
            'roommate_group_id' => $group->id,
            'user_id' => $this->user2->id,
        ]);

        // Group status should still be searching
        $this->assertEquals('searching', $group->fresh()->status);

        // User3 joins group
        $response2 = $this->actingAs($this->user3)
            ->postJson("/api/roommate-groups/{$group->id}/join");

        $response2->assertStatus(200);
        // Group status should transition to ready
        $this->assertEquals('ready', $group->fresh()->status);
    }

    public function test_user_can_leave_roommate_group()
    {
        $group = RoommateGroup::create([
            'property_id' => $this->property->id,
            'creator_id' => $this->user1->id,
            'status' => 'searching',
            'max_roommates' => 3,
        ]);
        $group->members()->attach([$this->user1->id, $this->user2->id]);

        // User2 leaves
        $response = $this->actingAs($this->user2)
            ->postJson("/api/roommate-groups/{$group->id}/leave");

        $response->assertStatus(200);
        $this->assertDatabaseMissing('roommate_group_members', [
            'roommate_group_id' => $group->id,
            'user_id' => $this->user2->id,
        ]);

        // User1 leaves (creator) -> dissolves group
        $response2 = $this->actingAs($this->user1)
            ->postJson("/api/roommate-groups/{$group->id}/leave");

        $response2->assertStatus(200);
        $this->assertDatabaseMissing('roommate_groups', [
            'id' => $group->id,
        ]);
    }

    public function test_user_can_book_property_with_ready_roommate_group()
    {
        $group = RoommateGroup::create([
            'property_id' => $this->property->id,
            'creator_id' => $this->user1->id,
            'status' => 'ready',
            'max_roommates' => 3,
        ]);
        $group->members()->attach([$this->user1->id, $this->user2->id, $this->user3->id]);

        $bookingData = [
            'property_id' => $this->property->id,
            'check_in' => now()->addDays(2)->toDateString(),
            'check_out' => now()->addDays(10)->toDateString(),
            'base_rent' => 30000.00,
            'taxes' => 500.00,
            'platform_fee' => 100.00,
            'total_price' => 30600.00,
            'roommate_group_id' => $group->id,
        ];

        // Renter1 books
        $response = $this->actingAs($this->user1)
            ->postJson('/api/bookings', $bookingData);

        $response->assertStatus(201);
        $this->assertDatabaseHas('bookings', [
            'property_id' => $this->property->id,
            'renter_id' => $this->user1->id,
            'roommate_group_id' => $group->id,
            'status' => 'pending',
        ]);

        // Group status should change to booked
        $this->assertEquals('booked', $group->fresh()->status);
    }
}
