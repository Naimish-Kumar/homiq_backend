<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\User;
use App\Models\Property;
use App\Models\PropertyReport;
use Illuminate\Foundation\Testing\RefreshDatabase;

class TrustAndVerificationTest extends TestCase
{
    use RefreshDatabase;

    protected User $owner;
    protected User $renter;
    protected Property $property;

    protected function setUp(): void
    {
        parent::setUp();

        $this->owner = User::factory()->create([
            'email' => 'landlord@homiq.space',
            'name' => 'Amit Sharma',
            'phone' => '9876543210',
            'is_admin' => false,
        ]);

        $this->renter = User::factory()->create([
            'email' => 'seeker@homiq.space',
            'name' => 'Pooja Verma',
            'phone' => '9811223344',
            'is_admin' => false,
        ]);

        $this->property = Property::create([
            'owner_id' => $this->owner->id,
            'title' => '2 BHK Society Flat in Sector 137',
            'description' => 'Bright and modern 2 BHK apartment near metro.',
            'price' => 25000,
            'security_deposit' => 50000,
            'address' => 'Paras Tierea, Sector 137, Noida',
            'category' => 'Apartment',
            'listing_type' => 'rent',
            'listed_by' => 'owner',
            'status' => 'approved',
            'verified_at' => now()->subDays(2),
            'expires_at' => now()->addDays(28),
            'last_renewed_at' => now()->subDays(2),
            'is_identity_verified' => true,
            'is_location_verified' => true,
            'is_photos_verified' => true,
            'is_ownership_verified' => true,
        ]);
    }

    /**
     * Test verification checklist and helper accessors.
     */
    public function test_property_has_verification_checklist_and_dates()
    {
        $this->assertFalse($this->property->is_expired);
        $this->assertGreaterThanOrEqual(27, $this->property->days_until_expiry);
        $this->assertEquals(now()->subDays(2)->format('d M Y'), $this->property->formatted_verified_date);

        $checklist = $this->property->verification_checklist;
        $this->assertCount(4, $checklist);
        $this->assertTrue($checklist[0]['verified']); // identity
        $this->assertTrue($checklist[1]['verified']); // location
        $this->assertTrue($checklist[2]['verified']); // photos
        $this->assertTrue($checklist[3]['verified']); // ownership
    }

    /**
     * Test property page displays transparent verification details & report listing trigger.
     */
    public function test_property_details_page_renders_verification_details_and_modals()
    {
        $response = $this->get('/properties/' . $this->property->id);

        $response->assertStatus(200);
        $response->assertSee('HomiQ Verification Details');
        $response->assertSee('Owner Identity Verified');
        $response->assertSee('Property Location Verified');
        $response->assertSee('Property Photos Verified');
        $response->assertSee('Ownership / Authorization Checked');
        $response->assertSee('What does Verified mean?');
        $response->assertSee('Report Listing');
    }

    /**
     * Test reporting a listing with a valid reason.
     */
    public function test_user_can_submit_listing_report()
    {
        $response = $this->actingAs($this->renter)
            ->postJson('/properties/' . $this->property->id . '/report', [
                'reason' => 'incorrect_price',
                'details' => 'Owner asked for higher rent than listed upon WhatsApp inquiry.',
                'reporter_name' => 'Pooja Verma',
                'reporter_contact' => '9811223344',
            ]);

        $response->assertStatus(200);
        $response->assertJson([
            'success' => true,
        ]);

        $this->assertDatabaseHas('property_reports', [
            'property_id' => $this->property->id,
            'user_id' => $this->renter->id,
            'reason' => 'incorrect_price',
            'status' => 'pending',
        ]);
    }

    /**
     * Test reporting a listing validates reason against allowed list.
     */
    public function test_report_listing_rejects_invalid_reason()
    {
        $response = $this->postJson('/properties/' . $this->property->id . '/report', [
            'reason' => 'invalid_random_reason',
            'details' => 'Some details',
        ]);

        $response->assertStatus(422);
        $response->assertJsonStructure([
            'errors' => ['reason'],
        ]);
    }

    /**
     * Test 30-day listing expiry excludes unconfirmed properties from active search feed.
     */
    public function test_expired_properties_are_hidden_from_public_feed()
    {
        $expiredProperty = Property::create([
            'owner_id' => $this->owner->id,
            'title' => 'Expired 1 BHK Studio in Noida',
            'description' => 'Test expired unit',
            'price' => 12000,
            'address' => 'Sector 62, Noida',
            'category' => 'Studio',
            'listing_type' => 'rent',
            'status' => 'approved',
            'expires_at' => now()->subDay(), // Expired yesterday
        ]);

        $response = $this->get('/');
        $response->assertStatus(200);
        $response->assertSee($this->property->title);
        $response->assertDontSee($expiredProperty->title);
    }

    /**
     * Test console command expires unconfirmed listings.
     */
    public function test_artisan_command_expires_unconfirmed_properties()
    {
        $expiredProperty = Property::create([
            'owner_id' => $this->owner->id,
            'title' => 'Stale Unconfirmed Penthouse',
            'description' => 'Test unconfirmed penthouse',
            'price' => 60000,
            'address' => 'Sector 78, Noida',
            'category' => 'Apartment',
            'listing_type' => 'rent',
            'status' => 'approved',
            'expires_at' => now()->subHour(),
        ]);

        $this->artisan('properties:expire-unconfirmed')
            ->expectsOutput("Scanning properties for expired availability windows...")
            ->assertExitCode(0);

        $expiredProperty->refresh();
        $this->assertEquals('temporarily_unavailable', $expiredProperty->status);
    }

    /**
     * Test owner 1-click availability confirmation & renewal.
     */
    public function test_owner_can_renew_listing_for_30_days()
    {
        $staleProperty = Property::create([
            'owner_id' => $this->owner->id,
            'title' => 'Cozy Room in Sector 15',
            'description' => 'Ready for occupancy',
            'price' => 9000,
            'address' => 'Sector 15, Noida',
            'category' => 'Studio',
            'listing_type' => 'rent',
            'status' => 'temporarily_unavailable',
            'expires_at' => now()->subDays(5),
        ]);

        // Owner renews
        $response = $this->actingAs($this->owner)
            ->postJson('/properties/' . $staleProperty->id . '/renew');

        $response->assertStatus(200);
        $response->assertJson([
            'success' => true,
        ]);

        $staleProperty->refresh();
        $this->assertEquals('approved', $staleProperty->status);
        $this->assertFalse($staleProperty->is_expired);
        $this->assertGreaterThanOrEqual(29, $staleProperty->days_until_expiry);
    }

    /**
     * Test non-owner cannot renew another user's listing.
     */
    public function test_unauthorized_user_cannot_renew_other_properties()
    {
        $response = $this->actingAs($this->renter)
            ->postJson('/properties/' . $this->property->id . '/renew');

        $response->assertStatus(403);
    }
}
