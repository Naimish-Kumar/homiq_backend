<?php

namespace Tests\Feature;

use App\Models\User;
use App\Models\Property;
use App\Models\PropertyRequest;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class OwnerAcquisitionTest extends TestCase
{
    use RefreshDatabase;

    protected User $owner;
    protected User $renter;
    protected Property $property;

    protected function setUp(): void
    {
        parent::setUp();

        $this->owner = User::create([
            'name' => 'Aditya Sharma',
            'email' => 'aditya.owner@example.com',
            'password' => bcrypt('password123'),
            'phone' => '9876543210',
            'is_admin' => false,
            'subscription_plan' => 'standard',
            'email_verified_at' => now(),
        ]);

        $this->renter = User::create([
            'name' => 'Kavita Singh',
            'email' => 'kavita.renter@example.com',
            'password' => bcrypt('password123'),
            'phone' => '9811223344',
            'is_admin' => false,
            'email_verified_at' => now(),
        ]);

        $this->property = Property::create([
            'owner_id' => $this->owner->id,
            'title' => '2 BHK Luxury Apartment in Sector 137 Noida',
            'description' => 'Spacious modern home close to metro station with pool facing balcony.',
            'price' => 25000,
            'security_deposit' => 50000,
            'address' => 'Paras Tierea, Sector 137, Noida',
            'category' => 'Apartment',
            'listing_type' => 'rent',
            'status' => 'approved',
            'views_count' => 10,
            'impressions_count' => 100,
            'inquiries_count' => 2,
            'whatsapp_clicks' => 3,
            'saves_count' => 5,
            'verified_at' => now()->subDay(),
            'expires_at' => now()->addDays(29),
        ]);
    }

    /**
     * Test dedicated owner landing pages render correctly with 6-step breakdown and benefits.
     */
    public function test_owner_landing_pages_render_successfully()
    {
        $urls = ['/list-property', '/owners', '/list-your-property'];

        foreach ($urls as $url) {
            $response = $this->get($url);
            $response->assertStatus(200);
            $response->assertSee('Rent or Sell Your Property Without Unnecessary Brokerage');
            $response->assertSee('How Listing on HomiQ Works for Owners');
            $response->assertSee('Add Property Details');
            $response->assertSee('Upload Authentic Photos');
            $response->assertSee('Complete Verification');
            $response->assertSee('Publish Listing');
            $response->assertSee('Receive Inquiries');
            $response->assertSee('Connect &amp; Finalize', false);
            $response->assertSee('List Your Property Free');
        }
    }

    /**
     * Test homepage contains the redesigned Have a Property to Rent or Sell section.
     */
    public function test_homepage_shows_redesigned_owner_acquisition_section()
    {
        $response = $this->get('/');
        $response->assertStatus(200);
        $response->assertSee('Have a Property to');
        $response->assertSee('Rent or Sell?');
        $response->assertSee('Free Listing');
        $response->assertSee('Direct Inquiries');
        $response->assertSee('Track Analytics');
        $response->assertSee('List Your Property Free');
    }

    /**
     * Test visiting property details increments views_count.
     */
    public function test_property_view_increments_views_count()
    {
        $initialViews = $this->property->views_count;

        $response = $this->get('/properties/' . $this->property->id);
        $response->assertStatus(200);

        $this->property->refresh();
        $this->assertEquals($initialViews + 1, $this->property->views_count);
    }

    /**
     * Test tracking WhatsApp clicks increments whatsapp_clicks.
     */
    public function test_track_whatsapp_contact_increments_metric()
    {
        $initialClicks = $this->property->whatsapp_clicks;

        $response = $this->postJson('/properties/' . $this->property->id . '/track-contact', [
            'type' => 'whatsapp',
        ]);

        $response->assertStatus(200);
        $response->assertJson([
            'success' => true,
            'whatsapp_clicks' => $initialClicks + 1,
        ]);

        $this->property->refresh();
        $this->assertEquals($initialClicks + 1, $this->property->whatsapp_clicks);
    }

    /**
     * Test tracking in-app inquiry increments inquiries_count.
     */
    public function test_track_inquiry_contact_increments_metric()
    {
        $initialInquiries = $this->property->inquiries_count;

        $response = $this->postJson('/properties/' . $this->property->id . '/track-contact', [
            'type' => 'inquiry',
        ]);

        $response->assertStatus(200);
        $response->assertJson([
            'success' => true,
            'inquiries_count' => $initialInquiries + 1,
        ]);

        $this->property->refresh();
        $this->assertEquals($initialInquiries + 1, $this->property->inquiries_count);
    }

    /**
     * Test tracking property saves increments saves_count.
     */
    public function test_track_save_increments_saves_count()
    {
        $initialSaves = $this->property->saves_count;

        $response = $this->postJson('/properties/' . $this->property->id . '/track-save');

        $response->assertStatus(200);
        $response->assertJson([
            'success' => true,
            'saves_count' => $initialSaves + 1,
        ]);

        $this->property->refresh();
        $this->assertEquals($initialSaves + 1, $this->property->saves_count);
    }

    /**
     * Test Owner Dashboard displays performance analytics and metrics.
     */
    public function test_owner_dashboard_shows_analytics_overview()
    {
        $response = $this->actingAs($this->owner)->get('/dashboard');
        $response->assertStatus(200);
        $response->assertSee('Owner Dashboard &amp; Analytics', false);
        $response->assertSee('Property Views');
        $response->assertSee('Direct Inquiries');
        $response->assertSee('Saves &amp; Shortlists', false);
        $response->assertSee('Listing Performance');
        $response->assertSee('98% response rate');
    }
}
