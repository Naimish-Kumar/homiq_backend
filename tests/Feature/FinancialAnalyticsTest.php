<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\User;
use App\Models\Property;
use App\Models\Booking;
use Illuminate\Foundation\Testing\RefreshDatabase;

class FinancialAnalyticsTest extends TestCase
{
    use RefreshDatabase;

    private User $admin;
    private User $host;
    private User $renter;
    private Property $property;

    protected function setUp(): void
    {
        parent::setUp();

        $this->admin = User::create([
            'name' => 'Finance Admin',
            'email' => 'finance_admin@homiq.com',
            'password' => bcrypt('password'),
            'is_admin' => true,
        ]);
        $this->admin->email_verified_at = now();
        $this->admin->save();

        $this->host = User::create([
            'name' => 'Host User',
            'email' => 'host@homiq.com',
            'password' => bcrypt('password'),
            'subscription_plan' => 'unlimited',
        ]);
        $this->host->email_verified_at = now();
        $this->host->save();

        $this->renter = User::create([
            'name' => 'Renter User',
            'email' => 'renter@homiq.com',
            'password' => bcrypt('password'),
            'subscription_plan' => 'standard',
        ]);
        $this->renter->email_verified_at = now();
        $this->renter->save();

        $this->property = Property::create([
            'owner_id' => $this->host->id,
            'title' => 'Luxury Skyline Suite',
            'description' => 'Spectacular views and modern amenities',
            'price' => 15000,
            'address' => 'Connaught Place, New Delhi',
            'latitude' => 28.63,
            'longitude' => 77.21,
            'category' => 'Apartment',
            'bedrooms' => 2,
            'bathrooms' => 2,
            'is_furnished' => true,
            'has_parking' => true,
            'is_pet_friendly' => true,
            'amenities' => ['WiFi', 'Pool'],
            'images' => ['https://example.com/prop.jpg'],
            'status' => 'approved',
        ]);

        Booking::create([
            'property_id' => $this->property->id,
            'renter_id' => $this->renter->id,
            'base_rent' => 15000,
            'platform_fee' => 750,
            'taxes' => 2700,
            'total_price' => 18450,
            'status' => 'approved',
            'check_in' => now()->addDays(2),
            'check_out' => now()->addDays(5),
        ]);
    }

    public function test_non_admin_cannot_access_financials()
    {
        $this->actingAs($this->renter);

        $response = $this->get('/admin/financials');
        $response->assertRedirect('/login');
    }

    public function test_admin_can_access_financials_and_view_kpis()
    {
        $this->actingAs($this->admin);

        $response = $this->get('/admin/financials');
        $response->assertStatus(200);
        $response->assertSee('Financial Performance & Revenue Engine', false);
        $response->assertSee('Gross Transaction Vol');
        $response->assertSee('Luxury Skyline Suite');
        $response->assertSee('18,450.00');
    }

    public function test_admin_can_export_transactions_csv()
    {
        $this->actingAs($this->admin);

        $response = $this->get('/admin/export/transactions');
        $response->assertStatus(200);
        $response->assertHeader('Content-Type', 'text/csv; charset=UTF-8');
        
        $content = $response->streamedContent();
        $this->assertStringContainsString('Booking ID', $content);
        $this->assertStringContainsString('Property Title', $content);
        $this->assertStringContainsString('Luxury Skyline Suite', $content);
        $this->assertStringContainsString('18450', $content);
    }

    public function test_admin_can_export_properties_csv()
    {
        $this->actingAs($this->admin);

        $response = $this->get('/admin/export/properties');
        $response->assertStatus(200);
        $response->assertHeader('Content-Type', 'text/csv; charset=UTF-8');

        $content = $response->streamedContent();
        $this->assertStringContainsString('Property ID', $content);
        $this->assertStringContainsString('Title', $content);
        $this->assertStringContainsString('Luxury Skyline Suite', $content);
        $this->assertStringContainsString('Host User', $content);
    }

    public function test_admin_can_export_users_csv()
    {
        $this->actingAs($this->admin);

        $response = $this->get('/admin/export/users');
        $response->assertStatus(200);
        $response->assertHeader('Content-Type', 'text/csv; charset=UTF-8');

        $content = $response->streamedContent();
        $this->assertStringContainsString('User ID', $content);
        $this->assertStringContainsString('Email', $content);
        $this->assertStringContainsString('Finance Admin', $content);
        $this->assertStringContainsString('Host User', $content);
        $this->assertStringContainsString('Renter User', $content);
    }
}
