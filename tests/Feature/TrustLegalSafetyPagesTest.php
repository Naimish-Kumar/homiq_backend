<?php

namespace Tests\Feature;

use App\Models\User;
use App\Models\Property;
use App\Models\Feedback;
use App\Models\Notification;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class TrustLegalSafetyPagesTest extends TestCase
{
    use RefreshDatabase;

    protected User $adminUser;
    protected User $regularUser;

    protected function setUp(): void
    {
        parent::setUp();

        $this->adminUser = User::create([
            'name' => 'Admin Officer',
            'email' => 'admin@homiq.com',
            'password' => bcrypt('password123'),
            'is_admin' => true,
            'email_verified_at' => now(),
        ]);

        $this->regularUser = User::create([
            'name' => 'Rohan Varma',
            'email' => 'rohan.varma@example.com',
            'password' => bcrypt('password123'),
            'phone' => '9811223344',
            'is_admin' => false,
            'email_verified_at' => now(),
        ]);
    }

    /**
     * Task 34: Test About HomiQ Page.
     */
    public function test_about_page_renders_story_mission_and_operating_geography()
    {
        $response = $this->get('/about');

        $response->assertStatus(200);

        // Headline & Mission
        $response->assertSee("Fixing India's Real Estate Marketplace Through Radical Transparency", false);
        $response->assertSee('Our Story &amp; Purpose', false);

        // Core Pillars & Problem Solved
        $response->assertSee('Unnecessary 1-Month Brokerage');
        $response->assertSee('0%');
        $response->assertSee('Commission Model');
        $response->assertSee('100%');
        $response->assertSee('Physically Audited');
        $response->assertSee('30-Day');
        $response->assertSee('Freshness Guarantee');

        // Verification Approach
        $response->assertSee('Landlord Identity &amp; Contact Validation', false);
        $response->assertSee('Geotagged GPS &amp; Locality Verification', false);
        $response->assertSee('Authentic Photo &amp; Furnishing Inspection', false);
        $response->assertSee('Ownership &amp; Authorization Check', false);

        // Operating Geography
        $response->assertSee('Noida Micro-Markets');
        $response->assertSee('Greater Noida &amp; Extension', false);
        $response->assertSee('Gurugram (NCR)');
        $response->assertSee('Bangalore Expansion');

        // Contact & HQ
        $response->assertSee('support@homiq.com');
        $response->assertSee('+91 1800-HOMIQ-01');
    }

    /**
     * Task 35: Test Verification Standards Page.
     */
    public function test_verification_standards_page_renders_full_trust_protocol()
    {
        $response = $this->get('/verification-standards');

        $response->assertStatus(200);

        // Header & Title
        $response->assertSee('HomiQ Verification Standards &amp; Quality Protocol', false);

        // What is checked
        $response->assertSee('What Is Checked &amp; Validated', false);
        $response->assertSee('Landlord Identity Verification');
        $response->assertSee('Geotagged GPS &amp; Locality Audit', false);
        $response->assertSee('Visual Photographic Audit');
        $response->assertSee('Ownership &amp; Authorization Check', false);
        $response->assertSee('Financial &amp; Brokerage Transparency', false);

        // What is NOT checked (Honest limitations & disclaimers)
        $response->assertSee('What Is NOT Checked');
        $response->assertSee('Structural Engineering &amp; Sub-Surface Defects', false);
        $response->assertSee('Hidden Title Litigation Outside Public Records', false);
        $response->assertSee('Tenant-Landlord Interpersonal Conflicts');

        // Audit SLA & 30-Day Policy
        $response->assertSee('Verification Timeline &amp; Freshness Policy', false);
        $response->assertSee('24 – 48 business hours');
        $response->assertSee('30 days');

        // Badge meaning
        $response->assertSee('What Do HomiQ Badges Mean?');
        $response->assertSee('Verified Listing');
        $response->assertSee('Listed by Owner');
        $response->assertSee('Verified Agent');

        // Fraud reporting
        $response->assertSee('Found a Suspicious Listing? We Investigate in 4 Hours.', false);
    }

    /**
     * Task 36: Test Contact Support Page and Support Form Submission.
     */
    public function test_contact_page_renders_channels_and_accepts_submissions()
    {
        $response = $this->get('/contact');

        $response->assertStatus(200);

        // Channels & Business Hours
        $response->assertSee('support@homiq.com');
        $response->assertSee('safety@homiq.com');
        $response->assertSee('+91 1800-HOMIQ-01');
        $response->assertSee('Mon – Sat, 9 AM – 8 PM IST');
        $response->assertSee('WhatsApp Helpdesk');

        // Form elements
        $response->assertSee('Send a Message to the HomiQ Team');
        $response->assertSee('Inquiry Category');
        $response->assertSee('Report Fraud / Suspicious Listing');

        // Test POST submission
        $postResponse = $this->post('/contact', [
            'name' => 'Kavita Rao',
            'email' => 'kavita.rao@example.com',
            'phone' => '9876501234',
            'category' => 'fraud_report',
            'subject' => 'Suspicious token demand on Listing #42',
            'message' => 'The owner contacted me on WhatsApp and asked for a ₹3,000 gate pass token before showing the flat.',
            'property_id' => 42,
        ]);

        $postResponse->assertSessionHas('success');

        // Verify Feedback record created in DB
        $this->assertDatabaseHas('feedback', [
            'type' => 'fraud_report',
        ]);

        // Verify Admin notification created
        $this->assertDatabaseHas('notifications', [
            'user_id' => $this->adminUser->id,
            'type' => 'support_ticket',
        ]);
    }

    /**
     * Task 37: Test Safety Center Page.
     */
    public function test_safety_center_page_renders_rules_scam_anatomy_and_helplines()
    {
        $response = $this->get('/safety');

        $response->assertStatus(200);

        // Header
        $response->assertSee('HomiQ Safety Center &amp; Fraud Prevention', false);

        // 8 Core Safety Rules
        $response->assertSee('1. Never Pay Before Physical Visit');
        $response->assertSee('2. Avoid Suspicious QR Code Scams');
        $response->assertSee('3. Visit in Daylight &amp; Bring a Friend', false);
        $response->assertSee('4. Verify Documents &amp; Utility Bills', false);
        $response->assertSee('5. Beware of "Remote Landlord" Traps', false);
        $response->assertSee('6. Never Share OTPs or Passwords');
        $response->assertSee('7. Sign a Formal Rent Agreement');
        $response->assertSee('8. Report Suspicious Listings');

        // Scam Anatomy
        $response->assertSee('The "Gate Pass / Key Deposit" Scam', false);
        $response->assertSee('The "Urgent Army Transfer" Scam', false);
        $response->assertSee('The "Phantom Broker" Trap', false);

        // Helplines & Cyber Crime Portal
        $response->assertSee('Dial 1930 / cybercrime.gov.in');
        $response->assertSee('safety@homiq.com');

        // Structured Schema
        $response->assertSee('"@type": "WebPage"', false);
    }
}
