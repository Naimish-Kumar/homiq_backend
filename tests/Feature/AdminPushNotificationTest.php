<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\User;
use App\Models\Property;
use App\Models\Notification;
use App\Models\NotificationBroadcast;
use App\Services\FcmService;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Mockery;

class AdminPushNotificationTest extends TestCase
{
    use RefreshDatabase;

    private User $admin;
    private User $hostUser;
    private User $tenantUser;
    private User $proUser;

    protected function setUp(): void
    {
        parent::setUp();

        $this->admin = User::factory()->create([
            'email' => 'admin@homiq.test',
            'is_admin' => true,
            'email_verified_at' => now(),
            'fcm_token' => 'admin_fcm_token_123',
        ]);

        $this->hostUser = User::factory()->create([
            'email' => 'host@homiq.test',
            'is_admin' => false,
            'email_verified_at' => now(),
            'fcm_token' => 'host_fcm_token_456',
        ]);

        Property::create([
            'owner_id' => $this->hostUser->id,
            'title' => 'Host Villa',
            'description' => 'Beautiful villa in suburb',
            'price' => 30000,
            'address' => '123 Marine Drive, Mumbai',
            'latitude' => 18.92,
            'longitude' => 72.82,
            'category' => 'Villa',
            'bedrooms' => 3,
            'bathrooms' => 2,
            'is_furnished' => true,
            'has_parking' => true,
            'is_pet_friendly' => true,
            'status' => 'approved',
        ]);

        $this->tenantUser = User::factory()->create([
            'email' => 'tenant@homiq.test',
            'is_admin' => false,
            'email_verified_at' => now(),
            'fcm_token' => 'tenant_fcm_token_789',
        ]);

        $this->proUser = User::factory()->create([
            'email' => 'pro@homiq.test',
            'is_admin' => false,
            'subscription_plan' => 'pro',
            'email_verified_at' => now(),
            'fcm_token' => 'pro_fcm_token_999',
        ]);
    }

    public function test_guest_and_non_admin_cannot_access_notifications_page(): void
    {
        $response = $this->get(route('admin.notifications'));
        $response->assertRedirect('/login');

        $response = $this->actingAs($this->tenantUser)->get(route('admin.notifications'));
        $response->assertRedirect('/login');
    }

    public function test_admin_can_view_notifications_broadcast_page(): void
    {
        $response = $this->actingAs($this->admin)->get(route('admin.notifications'));

        $response->assertStatus(200);
        $response->assertViewIs('admin.notifications');
        $response->assertSeeText('Push Notifications & Broadcast Engine');
        $response->assertSee('Compose New Broadcast');
    }

    public function test_admin_can_broadcast_notification_to_all_users(): void
    {
        // Mock FcmService
        $mockFcm = Mockery::mock(FcmService::class);
        $mockFcm->shouldReceive('sendToUser')
            ->atLeast()->once()
            ->andReturn(true);
        $this->app->instance(FcmService::class, $mockFcm);

        $payload = [
            'title' => 'Platform Update Available',
            'message' => 'Explore the newest features now live on HomiQ mobile app.',
            'target_audience' => 'all',
            'type' => 'announcement',
            'action_url' => '/dashboard',
            'send_push' => '1',
        ];

        $response = $this->actingAs($this->admin)->post(route('admin.notifications.send'), $payload);

        $response->assertRedirect(route('admin.notifications'));
        $response->assertSessionHas('success');

        // Check broadcast campaign record
        $this->assertDatabaseHas('notification_broadcasts', [
            'title' => 'Platform Update Available',
            'target_audience' => 'all',
            'type' => 'announcement',
            'status' => 'sent',
        ]);

        // Check in-app notifications created for users
        $this->assertDatabaseHas('notifications', [
            'user_id' => $this->hostUser->id,
            'title' => 'Platform Update Available',
            'type' => 'announcement',
        ]);

        $this->assertDatabaseHas('notifications', [
            'user_id' => $this->tenantUser->id,
            'title' => 'Platform Update Available',
            'type' => 'announcement',
        ]);
    }

    public function test_admin_can_broadcast_notification_to_specific_audience_segment(): void
    {
        // Mock FcmService
        $mockFcm = Mockery::mock(FcmService::class);
        $mockFcm->shouldReceive('sendToUser')->andReturn(true);
        $this->app->instance(FcmService::class, $mockFcm);

        $payload = [
            'title' => 'Special Host Promotion',
            'message' => 'List a new property this weekend for priority ranking.',
            'target_audience' => 'hosts',
            'type' => 'promotion',
            'action_url' => '/list-property',
            'send_push' => '1',
        ];

        $response = $this->actingAs($this->admin)->post(route('admin.notifications.send'), $payload);

        $response->assertRedirect(route('admin.notifications'));

        // Host received notification
        $this->assertDatabaseHas('notifications', [
            'user_id' => $this->hostUser->id,
            'title' => 'Special Host Promotion',
        ]);

        // Tenant did NOT receive host notification
        $this->assertDatabaseMissing('notifications', [
            'user_id' => $this->tenantUser->id,
            'title' => 'Special Host Promotion',
        ]);
    }

    public function test_admin_can_send_notification_to_individual_user(): void
    {
        $mockFcm = Mockery::mock(FcmService::class);
        $mockFcm->shouldReceive('sendToUser')->once()->andReturn(true);
        $this->app->instance(FcmService::class, $mockFcm);

        $payload = [
            'title' => 'KYC Verification Approved',
            'message' => 'Your landlord identity documents have been approved by HomiQ Admin.',
            'target_audience' => 'individual',
            'target_user_id' => $this->hostUser->id,
            'type' => 'info',
            'action_url' => '/dashboard/profile',
            'send_push' => '1',
        ];

        $response = $this->actingAs($this->admin)->post(route('admin.notifications.send'), $payload);

        $response->assertRedirect(route('admin.notifications'));

        $this->assertDatabaseHas('notification_broadcasts', [
            'title' => 'KYC Verification Approved',
            'target_audience' => 'individual',
            'target_user_id' => $this->hostUser->id,
            'recipients_count' => 1,
        ]);

        $this->assertDatabaseHas('notifications', [
            'user_id' => $this->hostUser->id,
            'title' => 'KYC Verification Approved',
        ]);

        $this->assertDatabaseMissing('notifications', [
            'user_id' => $this->tenantUser->id,
            'title' => 'KYC Verification Approved',
        ]);
    }

    public function test_validation_fails_for_invalid_notification_payload(): void
    {
        $response = $this->actingAs($this->admin)->post(route('admin.notifications.send'), [
            'title' => '',
            'message' => '',
            'target_audience' => 'invalid_audience',
        ]);

        $response->assertSessionHasErrors(['title', 'message', 'target_audience', 'type']);
    }

    public function test_admin_can_delete_broadcast_campaign_history(): void
    {
        $broadcast = NotificationBroadcast::create([
            'title' => 'Old Campaign',
            'message' => 'Old Message Body',
            'target_audience' => 'all',
            'type' => 'info',
            'recipients_count' => 5,
            'fcm_sent_count' => 3,
            'sent_by_user_id' => $this->admin->id,
            'status' => 'sent',
        ]);

        $response = $this->actingAs($this->admin)->delete(route('admin.notifications.delete', $broadcast->id));

        $response->assertRedirect(route('admin.notifications'));
        $this->assertDatabaseMissing('notification_broadcasts', ['id' => $broadcast->id]);
    }
}
