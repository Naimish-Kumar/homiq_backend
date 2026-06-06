<?php

namespace Tests\Feature;

use App\Models\User;
use App\Models\Property;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Cache;
use Tests\TestCase;

class CountryFilteringTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();
        Cache::clear();
    }

    public function test_listings_filtered_by_detected_ip_country_with_fallback()
    {
        // 1. Create a host user
        $host = User::create([
            'name' => 'Host Owner',
            'email' => 'host@example.com',
            'password' => bcrypt('password123'),
        ]);

        // 2. Create properties in different countries
        Property::create([
            'owner_id' => $host->id,
            'title' => 'Delhi Apartment',
            'description' => 'Apartment in New Delhi',
            'price' => 12000,
            'address' => 'Connaught Place, New Delhi, India',
            'category' => 'Apartment',
            'bedrooms' => 2,
            'bathrooms' => 1,
            'country' => 'India',
            'status' => 'approved',
        ]);

        Property::create([
            'owner_id' => $host->id,
            'title' => 'New York Studio',
            'description' => 'Studio in Manhattan',
            'price' => 2500,
            'address' => '5th Ave, New York, USA',
            'category' => 'Studio',
            'bedrooms' => 1,
            'bathrooms' => 1,
            'country' => 'United States',
            'status' => 'approved',
        ]);

        // Mock IP Geolocation API dynamically based on IP
        Http::fake([
            'ip-api.com/*' => function ($request) {
                if (str_contains($request->url(), '1.1.1.1')) {
                    return Http::response(['status' => 'success', 'country' => 'India'], 200);
                }
                if (str_contains($request->url(), '8.8.8.8')) {
                    return Http::response(['status' => 'success', 'country' => 'United States'], 200);
                }
                return Http::response(['status' => 'success', 'country' => 'Germany'], 200);
            }
        ]);

        // Scenario A: Mock User IP from India -> Should only see Indian properties
        $response = $this->call('GET', '/api/properties', [], [], [], ['REMOTE_ADDR' => '1.1.1.1']);
        $response->assertStatus(200);
        $data = $response->json();
        
        $this->assertCount(1, $data);
        $this->assertEquals('Delhi Apartment', $data[0]['title']);

        // Clear cache for next IP test
        Cache::clear();

        // Scenario B: Mock User IP from United States -> Should only see US properties
        $response = $this->call('GET', '/api/properties', [], [], [], ['REMOTE_ADDR' => '8.8.8.8']);
        $response->assertStatus(200);
        $data = $response->json();
        
        $this->assertCount(1, $data);
        $this->assertEquals('New York Studio', $data[0]['title']);

        // Clear cache for next IP test
        Cache::clear();

        // Scenario C: Mock User IP from Germany -> 0 properties in Germany -> Should fall back to all approved properties (India + US)
        $response = $this->call('GET', '/api/properties', [], [], [], ['REMOTE_ADDR' => '46.112.0.1']);
        $response->assertStatus(200);
        $data = $response->json();
        
        $this->assertCount(2, $data); // Fallback: returns both India and US properties
    }

    public function test_listings_filtered_by_explicit_country_query_parameter()
    {
        $host = User::create([
            'name' => 'Host Owner',
            'email' => 'host@example.com',
            'password' => bcrypt('password123'),
        ]);

        Property::create([
            'owner_id' => $host->id,
            'title' => 'Delhi Apartment',
            'description' => 'Apartment in New Delhi',
            'price' => 12000,
            'address' => 'Connaught Place, New Delhi, India',
            'category' => 'Apartment',
            'bedrooms' => 2,
            'bathrooms' => 1,
            'country' => 'India',
            'status' => 'approved',
        ]);

        Property::create([
            'owner_id' => $host->id,
            'title' => 'New York Studio',
            'description' => 'Studio in Manhattan',
            'price' => 2500,
            'address' => '5th Ave, New York, USA',
            'category' => 'Studio',
            'bedrooms' => 1,
            'bathrooms' => 1,
            'country' => 'United States',
            'status' => 'approved',
        ]);

        // Query with country = United States -> Should only see New York
        $response = $this->get('/api/properties?country=United States');
        $response->assertStatus(200);
        $data = $response->json();
        
        $this->assertCount(1, $data);
        $this->assertEquals('New York Studio', $data[0]['title']);
    }
}
