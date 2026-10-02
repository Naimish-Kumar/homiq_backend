<?php

namespace Tests\Feature;

use App\Models\Property;
use App\Models\User;
use App\Models\WithdrawalRequest;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ReferralWalletApiTest extends TestCase
{
    use RefreshDatabase;

    public function test_referrer_earns_5_on_signup_and_20_on_property()
    {
        // 1. Create Referrer
        $referrer = User::factory()->create([
            'referral_code' => 'HQ-REF123',
            'referral_balance' => 0.00,
            'total_referral_earned' => 0.00,
        ]);

        // 2. Register new user with referral code
        $signupResponse = $this->postJson('/api/register', [
            'name' => 'Friend User',
            'email' => 'friend@example.com',
            'password' => 'password123',
            'referral_code' => 'HQ-REF123',
        ]);

        $signupResponse->assertStatus(201);

        $referrer->refresh();
        $this->assertEquals(5.00, (float) $referrer->referral_balance);
        $this->assertEquals(5.00, (float) $referrer->total_referral_earned);

        $newUser = User::where('email', 'friend@example.com')->first();
        $this->assertEquals($referrer->id, $newUser->referred_by_id);

        // 3. New user publishes a property
        $token = $newUser->createToken('test_token')->plainTextToken;
        $propertyResponse = $this->withHeader('Authorization', "Bearer $token")->postJson('/api/properties', [
            'title' => '2 BHK Luxury Apartment',
            'description' => 'Spacious apartment near metro station',
            'price' => 25000,
            'address' => 'Salt Lake, Kolkata',
            'category' => 'Apartment',
            'bedrooms' => 2,
            'bathrooms' => 2,
            'furnishing_status' => 'Semi Furnished',
            'listing_type' => 'rent',
        ]);

        $propertyResponse->assertStatus(201);

        $referrer->refresh();
        $this->assertEquals(25.00, (float) $referrer->referral_balance); // 5 + 20
        $this->assertEquals(25.00, (float) $referrer->total_referral_earned);
    }

    public function test_get_referral_wallet_api()
    {
        $user = User::factory()->create([
            'referral_balance' => 45.00,
            'total_referral_earned' => 120.00,
        ]);

        $token = $user->createToken('test_token')->plainTextToken;

        $response = $this->withHeader('Authorization', "Bearer $token")->getJson('/api/referral/wallet');

        $response->assertStatus(200)
            ->assertJson([
                'success' => true,
                'data' => [
                    'referral_balance' => 45.00,
                    'total_referral_earned' => 120.00,
                    'minimum_withdrawal' => 50.00,
                    'reward_rules' => [
                        'signup_reward' => 5.00,
                        'property_reward' => 20.00,
                    ],
                ],
            ]);
    }

    public function test_withdrawal_enforces_minimum_50_and_balance_limit()
    {
        $user = User::factory()->create([
            'referral_balance' => 40.00,
        ]);

        $token = $user->createToken('test_token')->plainTextToken;

        // Try withdrawing ₹30 (below minimum ₹50)
        $response1 = $this->withHeader('Authorization', "Bearer $token")->postJson('/api/referral/withdraw', [
            'amount' => 30.00,
            'payout_method' => 'upi',
            'upi_id' => 'user@okhdfcbank',
        ]);

        $response1->assertStatus(422);

        // Give user ₹100
        $user->referral_balance = 100.00;
        $user->save();

        // Try withdrawing ₹120 (above balance)
        $response2 = $this->withHeader('Authorization', "Bearer $token")->postJson('/api/referral/withdraw', [
            'amount' => 120.00,
            'payout_method' => 'upi',
            'upi_id' => 'user@okhdfcbank',
        ]);

        $response2->assertStatus(422);

        // Valid withdrawal of ₹60 via UPI
        $response3 = $this->withHeader('Authorization', "Bearer $token")->postJson('/api/referral/withdraw', [
            'amount' => 60.00,
            'payout_method' => 'upi',
            'upi_id' => 'user@okhdfcbank',
        ]);

        $response3->assertStatus(201);
        $user->refresh();
        $this->assertEquals(40.00, (float) $user->referral_balance);

        $this->assertDatabaseHas('withdrawal_requests', [
            'user_id' => $user->id,
            'amount' => 60.00,
            'payout_method' => 'upi',
            'upi_id' => 'user@okhdfcbank',
            'status' => 'pending',
        ]);
    }

    public function test_admin_reject_withdrawal_refunds_wallet()
    {
        $admin = User::factory()->create(['is_admin' => true]);
        $user = User::factory()->create(['referral_balance' => 20.00]);

        $withdrawal = WithdrawalRequest::create([
            'user_id' => $user->id,
            'amount' => 50.00,
            'payout_method' => 'upi',
            'upi_id' => 'wrong@upi',
            'status' => 'pending',
        ]);

        $response = $this->actingAs($admin)->post("/admin/withdrawals/{$withdrawal->id}/reject", [
            'admin_notes' => 'Invalid UPI handle',
        ]);

        $response->assertRedirect();
        $withdrawal->refresh();
        $this->assertEquals('rejected', $withdrawal->status);

        $user->refresh();
        $this->assertEquals(70.00, (float) $user->referral_balance); // 20 + 50 refund
    }
}
