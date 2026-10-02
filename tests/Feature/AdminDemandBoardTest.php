<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\User;
use App\Models\Property;
use App\Models\PropertyRequest;
use Illuminate\Foundation\Testing\RefreshDatabase;

class AdminDemandBoardTest extends TestCase
{
    use RefreshDatabase;

    private User $admin;
    private User $seeker;
    private PropertyRequest $demand;

    protected function setUp(): void
    {
        parent::setUp();

        $this->admin = User::create([
            'name' => 'Admin Ops',
            'email' => 'ops_admin@homiq.com',
            'password' => bcrypt('password'),
            'is_admin' => true,
        ]);
        $this->admin->email_verified_at = now();
        $this->admin->save();

        $this->seeker = User::create([
            'name' => 'Rohan Sharma',
            'email' => 'rohan@example.com',
            'phone' => '+91 9876543210',
            'password' => bcrypt('password'),
        ]);
        $this->seeker->email_verified_at = now();
        $this->seeker->save();

        $this->demand = PropertyRequest::create([
            'user_id' => $this->seeker->id,
            'seeker_name' => 'Rohan Sharma',
            'seeker_phone' => '+91 9876543210',
            'seeker_email' => 'rohan@example.com',
            'city' => 'Delhi',
            'locality' => 'Hauz Khas',
            'property_type' => 'Apartment',
            'bedrooms' => '2 BHK',
            'min_budget' => 25000,
            'max_budget' => 35000,
            'purpose' => 'rent',
            'move_in_date' => 'Immediate',
            'tenant_type' => 'working_professional',
            'furnishing_preference' => 'fully_furnished',
            'description' => 'Looking for clean 2 BHK near metro station.',
            'status' => 'active',
        ]);
    }

    public function test_non_admin_cannot_access_demands()
    {
        $this->actingAs($this->seeker);

        $response = $this->get('/admin/demands');
        $response->assertRedirect('/login');
    }

    public function test_admin_can_access_demands_and_view_requests()
    {
        $this->actingAs($this->admin);

        $response = $this->get('/admin/demands');
        $response->assertStatus(200);
        $response->assertSee('Demand Board & Seeker Inquiries', false);
        $response->assertSee('Rohan Sharma');
        $response->assertSee('Hauz Khas');
        $response->assertSee('2 BHK');
        $response->assertSee('₹25,000 - ₹35,000');
    }

    public function test_admin_can_update_demand_status()
    {
        $this->actingAs($this->admin);

        $response = $this->post("/admin/demands/{$this->demand->id}/status", [
            'status' => 'fulfilled',
        ]);

        $response->assertStatus(302);
        $this->assertEquals('fulfilled', $this->demand->fresh()->status);
    }

    public function test_admin_can_delete_demand()
    {
        $this->actingAs($this->admin);

        $response = $this->delete("/admin/demands/{$this->demand->id}");
        $response->assertStatus(302);
        $this->assertNull(PropertyRequest::find($this->demand->id));
    }

    public function test_admin_can_export_demands_csv()
    {
        $this->actingAs($this->admin);

        $response = $this->get('/admin/export/demands');
        $response->assertStatus(200);
        $response->assertHeader('Content-Type', 'text/csv; charset=UTF-8');

        $content = $response->streamedContent();
        $this->assertStringContainsString('Request ID', $content);
        $this->assertStringContainsString('Rohan Sharma', $content);
        $this->assertStringContainsString('Hauz Khas', $content);
        $this->assertStringContainsString('Delhi', $content);
    }
}
