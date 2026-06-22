<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Tests\TestCase;

class AuthApiTest extends TestCase
{
    use RefreshDatabase;

    /**
     * Test registration API.
     */
    public function test_user_can_register()
    {
        $response = $this->postJson('/api/register', [
            'name' => 'John Doe',
            'email' => 'john@example.com',
            'phone' => '1234567890',
            'password' => 'password123',
            'is_host' => false,
        ]);

        $response->assertStatus(201);
        $response->assertJsonStructure([
            'user' => ['id', 'name', 'email', 'phone'],
            'token'
        ]);

        $this->assertDatabaseHas('users', [
            'email' => 'john@example.com',
            'name' => 'John Doe',
        ]);
    }

    /**
     * Test login API.
     */
    public function test_user_can_login_with_correct_credentials()
    {
        $user = User::create([
            'name' => 'Jane Doe',
            'email' => 'jane@example.com',
            'password' => Hash::make('password123'),
        ]);

        $response = $this->postJson('/api/login', [
            'email' => 'jane@example.com',
            'password' => 'password123',
        ]);

        $response->assertStatus(200);
        $response->assertJsonStructure([
            'user',
            'token'
        ]);
    }

    /**
     * Test login with invalid credentials fails.
     */
    public function test_user_cannot_login_with_incorrect_password()
    {
        $user = User::create([
            'name' => 'Jane Doe',
            'email' => 'jane@example.com',
            'password' => Hash::make('password123'),
        ]);

        $response = $this->postJson('/api/login', [
            'email' => 'jane@example.com',
            'password' => 'wrongpassword',
        ]);

        $response->assertStatus(401);
        $response->assertJsonFragment([
            'message' => 'Invalid email or password credentials',
        ]);
    }

    /**
     * Test logout API.
     */
    public function test_user_can_logout()
    {
        $user = User::create([
            'name' => 'Jane Doe',
            'email' => 'jane@example.com',
            'password' => Hash::make('password123'),
        ]);

        $token = $user->createToken('test_token')->plainTextToken;

        $response = $this->postJson('/api/logout', [], [
            'Authorization' => 'Bearer ' . $token,
        ]);

        $response->assertStatus(200);
        $response->assertJsonFragment([
            'message' => 'Successfully logged out',
        ]);
    }

    /**
     * Test forgot password API generates code.
     */
    public function test_forgot_password_generates_verification_code()
    {
        $user = User::create([
            'name' => 'Jane Doe',
            'email' => 'jane@example.com',
            'password' => Hash::make('password123'),
        ]);

        $response = $this->postJson('/api/forgot-password', [
            'email' => 'jane@example.com',
        ]);

        $response->assertStatus(200);
        $response->assertJsonStructure([
            'message',
            'code'
        ]);

        $this->assertDatabaseHas('password_reset_tokens', [
            'email' => 'jane@example.com',
        ]);
    }

    /**
     * Test password reset using code.
     */
    public function test_user_can_reset_password_with_valid_code()
    {
        $user = User::create([
            'name' => 'Jane Doe',
            'email' => 'jane@example.com',
            'password' => Hash::make('password123'),
        ]);

        // Request code
        $forgotResponse = $this->postJson('/api/forgot-password', [
            'email' => 'jane@example.com',
        ]);
        $code = $forgotResponse['code'];

        // Reset password
        $resetResponse = $this->postJson('/api/reset-password', [
            'email' => 'jane@example.com',
            'token' => $code,
            'password' => 'newpassword123',
            'password_confirmation' => 'newpassword123',
        ]);

        $resetResponse->assertStatus(200);
        $resetResponse->assertJsonFragment([
            'message' => 'Your password has been successfully reset.',
        ]);

        // Attempt login with new password
        $loginResponse = $this->postJson('/api/login', [
            'email' => 'jane@example.com',
            'password' => 'newpassword123',
        ]);
        $loginResponse->assertStatus(200);
    }

    /**
     * Test referral system registration.
     */
    public function test_user_can_register_with_referral_code()
    {
        // 1. Create a user who will be the referrer
        $referrer = User::create([
            'name' => 'Referrer User',
            'email' => 'referrer@example.com',
            'password' => Hash::make('password123'),
        ]);

        $this->assertNotEmpty($referrer->referral_code);

        // 2. Register a new user using referrer's code
        $response = $this->postJson('/api/register', [
            'name' => 'Referred User',
            'email' => 'referred@example.com',
            'password' => 'password123',
            'referral_code' => $referrer->referral_code,
        ]);

        $response->assertStatus(201);
        $this->assertDatabaseHas('users', [
            'email' => 'referred@example.com',
            'referred_by_id' => $referrer->id,
        ]);
    }

    /**
     * Test post-registration referral application.
     */
    public function test_user_can_apply_referral_code_after_registration()
    {
        $referrer = User::create([
            'name' => 'Referrer User',
            'email' => 'referrer@example.com',
            'password' => Hash::make('password123'),
        ]);

        $referred = User::create([
            'name' => 'Referred User',
            'email' => 'referred@example.com',
            'password' => Hash::make('password123'),
        ]);

        $token = $referred->createToken('test_token')->plainTextToken;

        $response = $this->postJson('/api/referral/apply', [
            'referral_code' => $referrer->referral_code,
        ], [
            'Authorization' => 'Bearer ' . $token,
        ]);

        $response->assertStatus(200);
        $response->assertJsonFragment([
            'message' => 'Referral code applied successfully!',
        ]);

        $this->assertEquals($referrer->id, $referred->fresh()->referred_by_id);
    }
}
