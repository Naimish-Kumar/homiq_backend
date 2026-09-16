<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Hash;
use Tests\TestCase;

class AdminLoginTest extends TestCase
{
    use RefreshDatabase;

    public function test_admin_user_logging_in_via_web_login_redirects_to_admin_panel()
    {
        $admin = User::create([
            'name' => 'System Admin',
            'email' => 'admin@homiq.com',
            'password' => Hash::make('password'),
            'is_admin' => true,
            'email_verified_at' => now(),
        ]);

        $response = $this->post('/login', [
            'email' => 'admin@homiq.com',
            'password' => 'password',
        ]);

        $response->assertRedirect('/admin');
        $this->assertAuthenticatedAs($admin);
    }

    public function test_regular_user_logging_in_via_web_login_redirects_to_dashboard()
    {
        $user = User::create([
            'name' => 'Regular User',
            'email' => 'customer@example.com',
            'password' => Hash::make('password'),
            'is_admin' => false,
            'email_verified_at' => now(),
        ]);

        $response = $this->post('/login', [
            'email' => 'customer@example.com',
            'password' => 'password',
        ]);

        $response->assertRedirect('/dashboard');
        $this->assertAuthenticatedAs($user);
    }

    public function test_firebase_google_login_redirects_admin_to_admin_panel()
    {
        $admin = User::create([
            'name' => 'System Admin',
            'email' => 'admin@homiq.com',
            'password' => Hash::make('password'),
            'is_admin' => true,
            'email_verified_at' => now(),
        ]);

        $response = $this->postJson('/auth/firebase-login', [
            'email' => 'admin@homiq.com',
            'name' => 'System Admin',
            'uid' => 'test-firebase-uid-admin',
        ]);

        $response->assertOk();
        $response->assertJson([
            'success' => true,
            'is_admin' => true,
            'redirect' => '/admin',
        ]);
    }

    public function test_firebase_google_login_redirects_regular_user_to_dashboard()
    {
        $response = $this->postJson('/auth/firebase-login', [
            'email' => 'newuser@example.com',
            'name' => 'New User',
            'uid' => 'test-firebase-uid-new',
        ]);

        $response->assertOk();
        $response->assertJson([
            'success' => true,
            'is_admin' => false,
            'redirect' => '/dashboard',
        ]);
    }
}
