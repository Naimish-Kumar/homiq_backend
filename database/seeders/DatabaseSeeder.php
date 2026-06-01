<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Property;
use App\Models\Booking;
use App\Models\Chat;
use App\Models\Message;
use App\Models\Notification;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // 1. Create a Customer who lists properties (Unlimited subscription to fit seeded listings)
        $lister = User::create([
            'name' => 'John Lister',
            'email' => 'customer@example.com',
            'phone' => '9876543210',
            'password' => Hash::make('password'),
            'subscription_plan' => 'unlimited',
            'email_verified_at' => now(),
        ]);

        // 2. Create another Customer who rents properties (Free starter plan)
        $renter = User::create([
            'name' => 'Alice Renter',
            'email' => 'renter@example.com',
            'phone' => '1234567890',
            'password' => Hash::make('password'),
            'subscription_plan' => 'free',
            'email_verified_at' => now(),
        ]);

        // 3. Create a System Admin User
        User::create([
            'name' => 'System Admin',
            'email' => 'admin@homiq.com',
            'phone' => '0000000000',
            'password' => Hash::make('password'),
            'is_admin' => true,
            'email_verified_at' => now(),
        ]);

        // 4. Seed Properties listed by John Lister
        $properties = [
            [
                'title' => 'Luxury Beachfront Villa',
                'description' => 'A stunning 4-bedroom beachfront villa with a private pool, panoramic ocean views, and state-of-the-art kitchen. Perfect for family vacations.',
                'price' => 350.00,
                'address' => '102 Ocean Drive, Miami, FL',
                'latitude' => 25.7617,
                'longitude' => -80.1918,
                'category' => 'Villa',
                'bedrooms' => 4,
                'bathrooms' => 3,
                'is_furnished' => true,
                'has_parking' => true,
                'is_pet_friendly' => true,
                'amenities' => ['Pool', 'WiFi', 'Beach Access', 'AC', 'Kitchen', 'Gym'],
                'images' => [
                    'https://images.unsplash.com/photo-1512917774080-9991f1c4c750?auto=format&fit=crop&w=800&q=80',
                    'https://images.unsplash.com/photo-1580587771525-78b9dba3b914?auto=format&fit=crop&w=800&q=80'
                ],
                'status' => 'approved',
            ],
            [
                'title' => 'Modern Downtown Apartment',
                'description' => 'Sleek 1-bedroom apartment in the heart of downtown. Fully furnished with high-speed internet, steps away from restaurants and public transit.',
                'price' => 120.00,
                'address' => '742 Broadway, New York, NY',
                'latitude' => 40.7128,
                'longitude' => -74.0060,
                'category' => 'Apartment',
                'bedrooms' => 1,
                'bathrooms' => 1,
                'is_furnished' => true,
                'has_parking' => false,
                'is_pet_friendly' => false,
                'amenities' => ['WiFi', 'AC', 'Elevator', 'Washing Machine', 'Heating'],
                'images' => [
                    'https://images.unsplash.com/photo-1522708323590-d24dbb6b0267?auto=format&fit=crop&w=800&q=80'
                ],
                'status' => 'approved',
            ],
            [
                'title' => 'Cosy Suburban House',
                'description' => 'Charming 3-bedroom family house with a spacious backyard, patio, and two-car garage. Located in a quiet, safe family neighborhood.',
                'price' => 200.00,
                'address' => '505 Maple Avenue, Austin, TX',
                'latitude' => 30.2672,
                'longitude' => -97.7431,
                'category' => 'House',
                'bedrooms' => 3,
                'bathrooms' => 2,
                'is_furnished' => false,
                'has_parking' => true,
                'is_pet_friendly' => true,
                'amenities' => ['Backyard', 'Garage', 'WiFi', 'AC', 'Fireplace'],
                'images' => [
                    'https://images.unsplash.com/photo-1568605114967-8130f3a36994?auto=format&fit=crop&w=800&q=80'
                ],
                'status' => 'approved',
            ],
            [
                'title' => 'Spacious Commercial Shop',
                'description' => 'Highly visible commercial storefront space. Excellent foot traffic location, perfect for retail, coffee shop, or office space.',
                'price' => 450.00,
                'address' => '12 Market Square, Seattle, WA',
                'latitude' => 47.6062,
                'longitude' => -122.3321,
                'category' => 'Shop',
                'bedrooms' => 0,
                'bathrooms' => 1,
                'is_furnished' => false,
                'has_parking' => true,
                'is_pet_friendly' => false,
                'amenities' => ['Security System', 'Restroom', 'AC', 'Storage'],
                'images' => [
                    'https://images.unsplash.com/photo-1441986300917-64674bd600d8?auto=format&fit=crop&w=800&q=80'
                ],
                'status' => 'approved',
            ],
            [
                'title' => 'Penthouse Sky Studio',
                'description' => 'A breathtaking studio apartment located on the 42nd floor, offering panoramic views of the city skyline. Furnished with high-end appliances.',
                'price' => 180.00,
                'address' => '500 N Michigan Ave, Chicago, IL',
                'latitude' => 41.8781,
                'longitude' => -87.6298,
                'category' => 'Studio',
                'bedrooms' => 1,
                'bathrooms' => 1,
                'is_furnished' => true,
                'has_parking' => true,
                'is_pet_friendly' => true,
                'amenities' => ['AC', 'WiFi', 'Gym', 'Concierge Service'],
                'images' => [
                    'https://images.unsplash.com/photo-1502672260266-1c1ef2d93688?auto=format&fit=crop&w=800&q=80'
                ],
                'status' => 'approved',
            ],
            [
                'title' => 'Elegant Wedding & Event Hall',
                'description' => 'Beautifully decorated event hall suitable for weddings, corporate gatherings, and large functions. Includes audio-visual setups and catering prep space.',
                'price' => 850.00,
                'address' => '808 Wilshire Blvd, Los Angeles, CA',
                'latitude' => 34.0522,
                'longitude' => -118.2437,
                'category' => 'Hall',
                'bedrooms' => 0,
                'bathrooms' => 4,
                'is_furnished' => true,
                'has_parking' => true,
                'is_pet_friendly' => false,
                'amenities' => ['AC', 'WiFi', 'Sound System', 'Valet Parking', 'Stage'],
                'images' => [
                    'https://images.unsplash.com/photo-1519167758481-83f550bb49b3?auto=format&fit=crop&w=800&q=80'
                ],
                'status' => 'approved',
            ],
            [
                'title' => 'Minimalist Urban Loft',
                'description' => 'A double-height industrial loft with exposed brick walls and hardwood floors. Steps away from local art galleries and coffee shops.',
                'price' => 160.00,
                'address' => '45 Newbury St, Boston, MA',
                'latitude' => 42.3601,
                'longitude' => -71.0589,
                'category' => 'Apartment',
                'bedrooms' => 2,
                'bathrooms' => 1.5,
                'is_furnished' => true,
                'has_parking' => false,
                'is_pet_friendly' => true,
                'amenities' => ['WiFi', 'Washing Machine', 'AC', 'Dishwasher'],
                'images' => [
                    'https://images.unsplash.com/photo-1560448204-e02f11c3d0e2?auto=format&fit=crop&w=800&q=80'
                ],
                'status' => 'approved',
            ],
            [
                'title' => 'Vintage Creative Office Space',
                'description' => 'Inspirational shared office area with high ceilings, plenty of natural lighting, and private conference tables. Ideal for remote teams and designers.',
                'price' => 300.00,
                'address' => '220 Montgomery St, San Francisco, CA',
                'latitude' => 37.7749,
                'longitude' => -122.4194,
                'category' => 'Shop',
                'bedrooms' => 0,
                'bathrooms' => 2,
                'is_furnished' => true,
                'has_parking' => true,
                'is_pet_friendly' => true,
                'amenities' => ['Conference Room', 'WiFi', 'AC', 'Coffee Bar', 'Printer Access'],
                'images' => [
                    'https://images.unsplash.com/photo-1497366216548-37526070297c?auto=format&fit=crop&w=800&q=80'
                ],
                'status' => 'approved',
            ],
            [
                'title' => 'Serene Lakeside Cottage',
                'description' => 'Escape the city rush in this peaceful lakeside cottage. Offers private dock access, a stone fireplace, and fully equipped kitchen.',
                'price' => 220.00,
                'address' => '88 Lakeshore Rd, Orlando, FL',
                'latitude' => 28.5383,
                'longitude' => -81.3792,
                'category' => 'House',
                'bedrooms' => 2,
                'bathrooms' => 1,
                'is_furnished' => true,
                'has_parking' => true,
                'is_pet_friendly' => true,
                'amenities' => ['Lake View', 'WiFi', 'Kitchen', 'Fireplace', 'Outdoor Grill'],
                'images' => [
                    'https://images.unsplash.com/photo-1507089947368-19c1da9775ae?auto=format&fit=crop&w=800&q=80'
                ],
                'status' => 'approved',
            ],
            [
                'title' => 'Rustic Event Barn Space',
                'description' => 'Authentic timber frame barn transformed into an elegant event venue. Great for country-style parties, gatherings, and retreats.',
                'price' => 500.00,
                'address' => '1024 Foothill Road, Denver, CO',
                'latitude' => 39.7392,
                'longitude' => -104.9903,
                'category' => 'Hall',
                'bedrooms' => 0,
                'bathrooms' => 2,
                'is_furnished' => false,
                'has_parking' => true,
                'is_pet_friendly' => true,
                'amenities' => ['Parking', 'Mountain View', 'Patio Area', 'Barbecue Pit'],
                'images' => [
                    'https://images.unsplash.com/photo-1503174971373-b1f69850bded?auto=format&fit=crop&w=800&q=80'
                ],
                'status' => 'approved',
            ],
            [
                'title' => 'Cozy Urban Art Gallery',
                'description' => 'Bright gallery room with white tracks, track spotlights, and adjustable layouts. Fits nicely for exhibitions, launch parties, and photo sessions.',
                'price' => 250.00,
                'address' => '312 Pearl St, Portland, OR',
                'latitude' => 45.5152,
                'longitude' => -122.6784,
                'category' => 'Shop',
                'bedrooms' => 0,
                'bathrooms' => 1,
                'is_furnished' => false,
                'has_parking' => false,
                'is_pet_friendly' => false,
                'amenities' => ['WiFi', 'Spotlights', 'AC', 'Storage Room'],
                'images' => [
                    'https://images.unsplash.com/photo-1531058020387-3be344559be6?auto=format&fit=crop&w=800&q=80'
                ],
                'status' => 'approved',
            ],
            [
                'title' => 'Luxury Stripview Condo',
                'description' => 'Elegant highrise condo overlooking the Las Vegas Strip. Includes access to a rooftop pool, private balcony, and state of the art sound system.',
                'price' => 400.00,
                'address' => '3131 Las Vegas Blvd S, Las Vegas, NV',
                'latitude' => 36.1699,
                'longitude' => -115.1398,
                'category' => 'Apartment',
                'bedrooms' => 2,
                'bathrooms' => 2,
                'is_furnished' => true,
                'has_parking' => true,
                'is_pet_friendly' => false,
                'amenities' => ['Rooftop Pool', 'WiFi', 'Balcony', 'AC', '24/7 Security'],
                'images' => [
                    'https://images.unsplash.com/photo-1545324418-cc1a3fa10c00?auto=format&fit=crop&w=800&q=80'
                ],
                'status' => 'approved',
            ]
        ];

        foreach ($properties as $propData) {
            $property = Property::create(array_merge($propData, [
                'owner_id' => $lister->id,
            ]));

            // Seed a booking for the modern apartment by Renter
            if ($propData['category'] === 'Apartment' && $propData['title'] === 'Modern Downtown Apartment') {
                Booking::create([
                    'property_id' => $property->id,
                    'renter_id' => $renter->id,
                    'check_in' => now()->addDays(2)->format('Y-m-d'),
                    'check_out' => now()->addDays(5)->format('Y-m-d'),
                    'base_rent' => 360.00,
                    'taxes' => 36.00,
                    'platform_fee' => 18.00,
                    'total_price' => 414.00,
                    'status' => 'approved',
                ]);
            }
        }

        // 5. Seed Welcome Notifications for Users
        Notification::create([
            'user_id' => $lister->id,
            'title' => 'Welcome to HomiQ!',
            'message' => 'Thank you for choosing HomiQ. Start listing your beachfront villas, apartments, or halls.',
            'type' => 'info',
            'is_read' => false,
        ]);

        Notification::create([
            'user_id' => $lister->id,
            'title' => 'New Reservation Request',
            'message' => 'Alice Renter requested a booking for your Modern Downtown Apartment.',
            'type' => 'booking',
            'is_read' => false,
        ]);

        Notification::create([
            'user_id' => $renter->id,
            'title' => 'Booking Approved',
            'message' => 'Your reservation request for Modern Downtown Apartment has been approved by the landlord.',
            'type' => 'booking',
            'is_read' => false,
        ]);

        // 6. Seed Chat conversations
        $beachVilla = Property::where('category', 'Villa')->first();
        if ($beachVilla) {
            $chat = Chat::create([
                'user_one_id' => $renter->id, // seeker
                'user_two_id' => $lister->id, // owner
                'property_id' => $beachVilla->id,
            ]);

            Message::create([
                'chat_id' => $chat->id,
                'sender_id' => $renter->id,
                'message' => "Hi John! Is the beachfront villa available for an event next Friday?",
                'type' => 'text',
            ]);

            Message::create([
                'chat_id' => $chat->id,
                'sender_id' => $lister->id,
                'message' => "Hello Alice! Yes, it is available. We support hosting up to 25 guests inside.",
                'type' => 'text',
            ]);

            Notification::create([
                'user_id' => $lister->id,
                'title' => 'New Message from Alice Renter',
                'message' => 'Regarding Luxury Beachfront Villa: "Hi John! Is the beachfront villa available..."',
                'type' => 'chat',
                'is_read' => false,
            ]);
        }

        // 7. Seed Dynamic Pages with clean styled defaults
        $aboutHtml = '<h1>About HomiQ</h1><p>HomiQ is a cutting-edge space rental marketplace built for the modern sharing economy. We bridge the gap between property owners looking to list spaces and renters seeking high-quality, verified, and flexible rental accommodations.</p><h2>Our Mission</h2><p>Our mission is to simplify property management and space rental by providing secure, transparent, and responsive digital pipelines. From beachfront villas to urban co-working desks, we ensure that locating and leasing a property is as simple as a few taps on your mobile device.</p><h2>Why Choose HomiQ?</h2><ul><li><strong>Verified Spaces:</strong> Every listing goes through a comprehensive administrative review process before going live.</li><li><strong>Integrated Messaging:</strong> Landlords and renters can communicate securely using our real-time messaging pipeline.</li><li><strong>Simple Subscriptions:</strong> Simple tiers designed to scale with your listing requirements.</li></ul><p>Thank you for choosing HomiQ as your trusted space partner.</p>';

        $privacyHtml = '<h1>Privacy Policy for HomiQ</h1><p><strong>Last Updated:</strong> June 2026</p><p>Welcome to <strong>HomiQ (&quot;we,&quot; &quot;our,&quot; or &quot;us&quot;)</strong>. We are committed to protecting your privacy and ensuring transparency about how your information is collected, used, and shared.</p><p>This Privacy Policy explains how HomiQ collects, uses, stores, and protects your information when you use our mobile application, website, and related services (collectively, the &quot;Services&quot;).</p><p>By using HomiQ, you agree to the practices described in this Privacy Policy.</p><h1>1. Information We Collect</h1><h2>A. Information You Provide</h2><p>When you create an account or use our Services, we may collect:</p><ul><li>Full name</li><li>Email address</li><li>Phone number</li><li>Profile photo</li><li>Date of birth</li><li>Gender (optional)</li><li>Property listing information</li><li>Messages exchanged with other users</li><li>Reviews and ratings</li><li>Support requests and feedback</li></ul><h2>B. Property &amp; Listing Information</h2><p>If you are a property owner or host, we may collect:</p><ul><li>Property title</li><li>Property description</li><li>Address and location</li><li>Property photos</li><li>Amenities and pricing information</li><li>Availability information</li><li>Verification documents (if applicable)</li></ul><h2>C. Payment Information</h2><p>When you make payments through HomiQ:</p><ul><li>Payment details are processed by secure third-party payment providers.</li><li>We do not store complete credit card, debit card, or banking information on our servers.</li><li>We may receive transaction confirmations and payment status information.</li></ul><h2>D. Automatically Collected Information</h2><p>We may automatically collect:</p><ul><li>Device type</li><li>Device identifiers</li><li>Operating system version</li><li>App version</li><li>IP address</li><li>Language settings</li><li>Crash logs</li><li>Usage statistics</li><li>Referral information</li></ul><h2>E. Location Information</h2><p>With your permission, we may collect:</p><ul><li>Precise location</li><li>Approximate location</li></ul><p>Location data helps users:</p><ul><li>Discover nearby properties</li><li>Improve search results</li><li>Display property locations on maps</li></ul><p>You can disable location access anytime from your device settings.</p>';

        $termsHtml = '<h1>Terms & Conditions</h1><p>Welcome to HomiQ. By accessing our mobile application, website, and related services, you agree to comply with and be bound by the following terms and conditions. Please read them carefully.</p><h2>1. Acceptance of Terms</h2><p>By creating an account, posting listings, or booking properties through HomiQ, you signify your acceptance of these Terms and Conditions. If you do not agree, you must immediately discontinue using our services.</p><h2>2. Listing & Moderation</h2><p>Property hosts must provide accurate and truthful details regarding their listed spaces. HomiQ retains the right to approve, reject, or remove any listing at its sole discretion if it violates our quality standards or listing policies.</p><h2>3. Booking Contracts & Payments</h2><p>All rental bookings made through the platform are contracts between the respective host and renter. Payments are processed securely via third-party providers. Platform fees collected by HomiQ are non-refundable unless specified otherwise.</p><h2>4. Account Suspension</h2><p>We reserve the right to suspend or terminate accounts that engage in fraudulent actions, spam, or behaviors that degrade the safety and experience of the community.</p><h2>5. Amendments</h2><p>HomiQ reserves the right to modify these Terms & Conditions at any time. Continued use of the platform constitutes agreement to the updated terms.</p>';

        \App\Models\Page::updateOrCreate(
            ['slug' => 'about'],
            ['title' => 'About Us', 'content' => $aboutHtml]
        );

        \App\Models\Page::updateOrCreate(
            ['slug' => 'privacy'],
            ['title' => 'Privacy Policy', 'content' => $privacyHtml]
        );

        \App\Models\Page::updateOrCreate(
            ['slug' => 'terms'],
            ['title' => 'Terms & Conditions', 'content' => $termsHtml]
        );
    }
}
