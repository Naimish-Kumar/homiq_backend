<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\User;
use App\Models\Property;
use App\Models\SavedSearch;
use App\Models\Booking;
use App\Models\Notification;
use App\Services\PropertyAlertService;
use App\Events\PropertyApproved;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ConversionAndRetentionTest extends TestCase
{
    use RefreshDatabase;

    protected User $user;
    protected User $owner;

    protected function setUp(): void
    {
        parent::setUp();

        $this->user = User::factory()->create([
            'email' => 'seeker@homiq.test',
            'is_admin' => false,
            'email_verified_at' => now(),
        ]);

        $this->owner = User::factory()->create([
            'email' => 'owner@homiq.test',
            'is_admin' => false,
            'email_verified_at' => now(),
        ]);
    }

    /**
     * Test 38: Saved Searches - Creation, Toggle, Deletion, and Dashboard Display
     */
    public function test_user_can_save_search_and_manage_in_dashboard(): void
    {
        // 1. Guest redirected / prompted
        $guestResponse = $this->postJson('/saved-searches', [
            'city' => 'Noida',
            'category' => 'Apartment',
            'max_price' => 30000,
        ]);
        $guestResponse->assertStatus(401)
            ->assertJson(['auth_required' => true]);

        // 2. Authenticated user saves search
        $response = $this->actingAs($this->user)->postJson('/saved-searches', [
            'title' => '2 BHK in Noida under ₹30,000',
            'city' => 'Noida',
            'category' => 'Apartment',
            'bedrooms' => '2',
            'max_price' => 30000,
            'listing_type' => 'rent',
        ]);

        $response->assertStatus(200)
            ->assertJson(['success' => true]);

        $this->assertDatabaseHas('saved_searches', [
            'user_id' => $this->user->id,
            'title' => '2 BHK in Noida under ₹30,000',
            'is_active' => true,
        ]);

        $savedSearch = SavedSearch::where('user_id', $this->user->id)->first();
        $this->assertNotNull($savedSearch);
        $this->assertEquals('Noida', $savedSearch->filters['city']);
        $this->assertEquals(30000, $savedSearch->filters['max_price']);

        // 3. Appears in Dashboard
        $dashResponse = $this->actingAs($this->user)->get('/dashboard');
        $dashResponse->assertStatus(200);
        $dashResponse->assertSee('2 BHK in Noida under ₹30,000');
        $dashResponse->assertSee('Saved Searches &amp; Alerts', false);

        // 4. Toggle active status
        $toggleResponse = $this->actingAs($this->user)->postJson("/saved-searches/{$savedSearch->id}/toggle");
        $toggleResponse->assertStatus(200)
            ->assertJson(['success' => true, 'is_active' => false]);
        $this->assertFalse($savedSearch->fresh()->is_active);

        // 5. Delete saved search
        $delResponse = $this->actingAs($this->user)->deleteJson("/saved-searches/{$savedSearch->id}");
        $delResponse->assertStatus(200)
            ->assertJson(['success' => true]);
        $this->assertDatabaseMissing('saved_searches', ['id' => $savedSearch->id]);
    }

    /**
     * Test 39: Property Alerts - Multi-Type Notifications (Saved Search Match, Price Drop, Availability, Owner Response, Similar Property)
     */
    public function test_property_alert_service_dispatches_multi_type_notifications(): void
    {
        // A. Setup a saved search for user
        $search = SavedSearch::create([
            'user_id' => $this->user->id,
            'title' => '2 BHK Noida Rent',
            'filters' => [
                'city' => 'Noida',
                'category' => 'Apartment',
                'bedrooms' => '2',
                'max_price' => 30000,
                'listing_type' => 'rent',
            ],
            'is_active' => true,
        ]);

        // Create matching property
        $matchingProperty = Property::create([
            'owner_id' => $this->owner->id,
            'title' => 'Paras Tierea 2 BHK',
            'description' => 'Beautiful 2 BHK flat near metro.',
            'price' => 25000,
            'original_price' => 28000,
            'address' => 'Sector 137, Noida',
            'category' => 'Apartment',
            'bedrooms' => 2,
            'bathrooms' => 2,
            'currency' => 'INR',
            'billing_frequency' => 'per_month',
            'status' => 'approved',
            'listing_type' => 'rent',
            'images' => ['https://images.unsplash.com/photo-1564013799919-ab600027ffc6'],
        ]);

        $alertService = app(PropertyAlertService::class);

        // 1. Test Saved Search Match Notification
        $matchesNotified = $alertService->notifySavedSearchMatches($matchingProperty);
        $this->assertEquals(1, $matchesNotified);
        $this->assertDatabaseHas('notifications', [
            'user_id' => $this->user->id,
            'type' => 'property_match',
        ]);

        // 2. Test Price Drop Notification
        $priceDropNotified = $alertService->notifyPriceDrop($matchingProperty, 28000);
        $this->assertGreaterThanOrEqual(1, $priceDropNotified);
        $this->assertDatabaseHas('notifications', [
            'user_id' => $this->user->id,
            'type' => 'price_drop',
        ]);

        // 3. Test Availability Update Notification
        // Create booking/inquiry link
        Booking::create([
            'property_id' => $matchingProperty->id,
            'renter_id' => $this->user->id,
            'check_in' => now()->addDays(5),
            'check_out' => now()->addDays(10),
            'base_rent' => 25000,
            'taxes' => 0,
            'platform_fee' => 0,
            'total_price' => 25000,
            'status' => 'confirmed',
        ]);

        $availNotified = $alertService->notifyAvailabilityUpdate($matchingProperty, 'Now ready for immediate occupancy!');
        $this->assertEquals(1, $availNotified);
        $this->assertDatabaseHas('notifications', [
            'user_id' => $this->user->id,
            'type' => 'availability_update',
        ]);

        // 4. Test Owner Response Notification
        $alertService->notifyOwnerResponse($matchingProperty, $this->user, 'Visit confirmed for Sunday 11 AM.');
        $this->assertDatabaseHas('notifications', [
            'user_id' => $this->user->id,
            'type' => 'owner_response',
        ]);

        // 5. Test Similar Property Added Notification
        $similarNotified = $alertService->notifySimilarPropertyAdded($matchingProperty);
        $this->assertGreaterThanOrEqual(1, $similarNotified);
        $this->assertDatabaseHas('notifications', [
            'user_id' => $this->user->id,
            'type' => 'similar_property',
        ]);
    }

    /**
     * Test 40: Price Drop Badges and Calculation
     */
    public function test_price_drop_badges_and_model_accessors(): void
    {
        $droppedProperty = Property::create([
            'owner_id' => $this->owner->id,
            'title' => 'Express Zenith 3 BHK',
            'description' => 'Luxury flat with reduced rent.',
            'price' => 32000,
            'original_price' => 35000,
            'address' => 'Sector 77, Noida',
            'category' => 'Apartment',
            'bedrooms' => 3,
            'bathrooms' => 3,
            'currency' => 'INR',
            'billing_frequency' => 'per_month',
            'status' => 'approved',
            'listing_type' => 'rent',
            'images' => ['https://images.unsplash.com/photo-1564013799919-ab600027ffc6'],
        ]);

        $regularProperty = Property::create([
            'owner_id' => $this->owner->id,
            'title' => 'Supertech Capetown 2 BHK',
            'description' => 'Standard rental flat.',
            'price' => 22000,
            'original_price' => null,
            'address' => 'Sector 74, Noida',
            'category' => 'Apartment',
            'bedrooms' => 2,
            'bathrooms' => 2,
            'currency' => 'INR',
            'billing_frequency' => 'per_month',
            'status' => 'approved',
            'listing_type' => 'rent',
            'images' => ['https://images.unsplash.com/photo-1564013799919-ab600027ffc6'],
        ]);

        // Check model accessors
        $this->assertTrue($droppedProperty->has_price_drop);
        $this->assertEquals(3000.0, $droppedProperty->price_drop_amount);
        $this->assertEquals('Price reduced by ₹3,000', $droppedProperty->formatted_price_drop_badge);
        $this->assertEquals(9, $droppedProperty->price_drop_percent);
        $this->assertEquals('₹35,000/mo', $droppedProperty->formatted_original_price);

        $this->assertFalse($regularProperty->has_price_drop);
        $this->assertEquals(0.0, $regularProperty->price_drop_amount);
        $this->assertNull($regularProperty->formatted_price_drop_badge);

        // Check view rendering for price drop badge and strikethrough price
        $response = $this->get('/property/' . $droppedProperty->slug);
        $response->assertStatus(200);
        $response->assertSee('Price reduced by ₹3,000');
        $response->assertSee('₹35,000/mo');

        // Check homepage contains price drop badge on the card
        $homeResponse = $this->get('/');
        $homeResponse->assertStatus(200);
        $homeResponse->assertSee('Price reduced by ₹3,000');
    }

    /**
     * Test 41: Recently Viewed Tracking and Display
     */
    public function test_recently_viewed_properties_tracking_and_clearing(): void
    {
        $property1 = Property::create([
            'owner_id' => $this->owner->id,
            'title' => 'Property One',
            'description' => 'First property viewed.',
            'price' => 20000,
            'address' => 'Sector 62, Noida',
            'category' => 'Apartment',
            'bedrooms' => 1,
            'bathrooms' => 1,
            'currency' => 'INR',
            'status' => 'approved',
            'listing_type' => 'rent',
            'images' => ['https://images.unsplash.com/photo-1564013799919-ab600027ffc6'],
        ]);

        $property2 = Property::create([
            'owner_id' => $this->owner->id,
            'title' => 'Property Two',
            'description' => 'Second property viewed.',
            'price' => 30000,
            'address' => 'Sector 137, Noida',
            'category' => 'Apartment',
            'bedrooms' => 2,
            'bathrooms' => 2,
            'currency' => 'INR',
            'status' => 'approved',
            'listing_type' => 'rent',
            'images' => ['https://images.unsplash.com/photo-1564013799919-ab600027ffc6'],
        ]);

        // 1. Visit property 1
        $res1 = $this->get('/property/' . $property1->slug);
        $res1->assertStatus(200);
        $this->assertEquals([$property1->id], session('recently_viewed'));

        // 2. Visit property 2
        $res2 = $this->get('/property/' . $property2->slug);
        $res2->assertStatus(200);
        $this->assertEquals([$property2->id, $property1->id], session('recently_viewed'));

        // Property 2's page should show Property 1 in recently viewed section
        $res2->assertSee('Recently Viewed Properties');
        $res2->assertSee('Property One');

        // 3. Homepage should render recently viewed section
        $homeRes = $this->get('/');
        $homeRes->assertStatus(200);
        $homeRes->assertSee('Recently Viewed Properties');
        $homeRes->assertSee('Property Two');
        $homeRes->assertSee('Property One');

        // 4. Clear recently viewed
        $clearRes = $this->post('/recently-viewed/clear');
        $clearRes->assertRedirect();
        $this->assertNull(session('recently_viewed'));

        // Verify section is gone after clear
        $homeResAfter = $this->get('/');
        $homeResAfter->assertStatus(200);
        $homeResAfter->assertDontSee('Your Browsing History');
    }

    /**
     * Test 42: Shareable Property Pages and Open Graph Metadata
     */
    public function test_property_page_renders_rich_open_graph_metadata(): void
    {
        $property = Property::create([
            'owner_id' => $this->owner->id,
            'title' => 'Paras Tierea 3 BHK Luxury Flat',
            'description' => 'Spacious 3 BHK with premium modular kitchen, wooden flooring and panoramic balcony view in Sector 137.',
            'price' => 38000,
            'address' => 'Sector 137, Noida',
            'category' => 'Apartment',
            'bedrooms' => 3,
            'bathrooms' => 3,
            'currency' => 'INR',
            'billing_frequency' => 'per_month',
            'status' => 'approved',
            'listing_type' => 'rent',
            'images' => ['https://images.unsplash.com/photo-1564013799919-ab600027ffc6'],
        ]);

        $response = $this->get('/property/' . $property->slug);
        $response->assertStatus(200);

        // Verify Open Graph meta tags
        $response->assertSee('<meta property="og:site_name" content="HomiQ"', false);
        $response->assertSee('<meta property="og:type" content="place"', false);
        $response->assertSee('content="Paras Tierea 3 BHK Luxury Flat (₹38,000/mo) - 0% Brokerage | HomiQ"', false);
        $response->assertSee('content="3 BHK Apartment in Sector 137, Noida. Verified listing, 0% brokerage on HomiQ.', false);
        $response->assertSee('<meta name="twitter:card" content="summary_large_image"', false);
        $response->assertSee('<meta property="og:image" content="https://images.unsplash.com/photo-1564013799919-ab600027ffc6"', false);
    }
}
