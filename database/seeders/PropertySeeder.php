<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Property;

class PropertySeeder extends Seeder
{
    public function run(): void
    {
        $ownerIds = \App\Models\User::pluck('id')->toArray();
        if (empty($ownerIds)) {
            $user = \App\Models\User::create([
                'name' => 'Default Owner',
                'email' => 'owner@homiq.com',
                'password' => bcrypt('password123'),
                'phone' => '1234567890',
                'subscription_plan' => 'unlimited',
                'is_admin' => false,
                'email_verified_at' => now(),
            ]);
            $ownerIds = [$user->id];
        }

        $properties = [
            // ── Apartment (5) ─────────────────────────────────────
            [
                'title' => 'Skyline 2BHK Premium Flat',
                'description' => 'Fully furnished 2BHK apartment with stunning city views, modular kitchen, and 24/7 security.',
                'price' => 2500, 'address' => 'Tower B, Skyline Residency, Sector 62, Noida',
                'latitude' => 28.6273, 'longitude' => 77.3714, 'category' => 'Apartment',
                'bedrooms' => 2, 'bathrooms' => 2, 'is_furnished' => true, 'has_parking' => true, 'is_pet_friendly' => false,
                'amenities' => ['WiFi','AC','Gym','Swimming Pool','Power Backup','Lift'],
                'images' => ['https://images.unsplash.com/photo-1522708323590-d24dbb6b0267?auto=format&fit=crop&w=800&q=80'],
            ],
            [
                'title' => 'Green Valley 3BHK Apartment',
                'description' => 'Spacious 3BHK apartment in a gated community with lush green surroundings and club house access.',
                'price' => 3500, 'address' => 'A-Block, Green Valley Township, Whitefield, Bangalore',
                'latitude' => 12.9698, 'longitude' => 77.7500, 'category' => 'Apartment',
                'bedrooms' => 3, 'bathrooms' => 2, 'is_furnished' => true, 'has_parking' => true, 'is_pet_friendly' => true,
                'amenities' => ['WiFi','AC','Gym','Garden','CCTV','Intercom'],
                'images' => ['https://images.unsplash.com/photo-1502672260266-1c1ef2d93688?auto=format&fit=crop&w=800&q=80'],
            ],
            [
                'title' => 'Riverside 1BHK Modern Flat',
                'description' => 'Compact modern 1BHK flat overlooking the river. Ideal for young professionals.',
                'price' => 1500, 'address' => '12th Floor, Riverside Towers, Andheri West, Mumbai',
                'latitude' => 19.1368, 'longitude' => 72.8337, 'category' => 'Apartment',
                'bedrooms' => 1, 'bathrooms' => 1, 'is_furnished' => true, 'has_parking' => false, 'is_pet_friendly' => false,
                'amenities' => ['WiFi','AC','Lift','Security','Power Backup'],
                'images' => ['https://images.unsplash.com/photo-1560448204-e02f11c3d0e2?auto=format&fit=crop&w=800&q=80'],
            ],
            [
                'title' => 'Lotus Garden 2BHK Flat',
                'description' => 'Well-maintained 2BHK apartment in a serene locality with spacious balcony and parking.',
                'price' => 2000, 'address' => 'Lotus Garden Complex, Koramangala, Bangalore',
                'latitude' => 12.9352, 'longitude' => 77.6245, 'category' => 'Apartment',
                'bedrooms' => 2, 'bathrooms' => 2, 'is_furnished' => false, 'has_parking' => true, 'is_pet_friendly' => true,
                'amenities' => ['Lift','Security','Garden','Playground'],
                'images' => ['https://images.unsplash.com/photo-1567496898669-ee935f5f647a?auto=format&fit=crop&w=800&q=80'],
            ],
            [
                'title' => 'Harmony Heights 2BHK',
                'description' => 'Newly built 2BHK apartment with Italian marble flooring and modular kitchen.',
                'price' => 2800, 'address' => 'Harmony Heights, Hinjewadi Phase 2, Pune',
                'latitude' => 18.5912, 'longitude' => 73.7389, 'category' => 'Apartment',
                'bedrooms' => 2, 'bathrooms' => 2, 'is_furnished' => true, 'has_parking' => true, 'is_pet_friendly' => false,
                'amenities' => ['WiFi','AC','Gym','Clubhouse','Jogging Track'],
                'images' => ['https://images.unsplash.com/photo-1554995207-c18c203602cb?auto=format&fit=crop&w=800&q=80'],
            ],

            // ── House (4) ─────────────────────────────────────────
            [
                'title' => 'Heritage Bungalow with Garden',
                'description' => 'Beautiful heritage-style bungalow with large garden and traditional architecture.',
                'price' => 5000, 'address' => '45, Civil Lines, Jaipur, Rajasthan',
                'latitude' => 26.9124, 'longitude' => 75.7873, 'category' => 'House',
                'bedrooms' => 4, 'bathrooms' => 3, 'is_furnished' => true, 'has_parking' => true, 'is_pet_friendly' => true,
                'amenities' => ['Garden','Parking','Servant Quarter','Terrace','Store Room'],
                'images' => ['https://images.unsplash.com/photo-1568605114967-8130f3a36994?auto=format&fit=crop&w=800&q=80'],
            ],
            [
                'title' => 'Modern Duplex House',
                'description' => 'Stylish 3-storey duplex with rooftop terrace and smart home automation.',
                'price' => 7500, 'address' => 'DLF Phase 4, Gurugram, Haryana',
                'latitude' => 28.4595, 'longitude' => 77.0266, 'category' => 'House',
                'bedrooms' => 5, 'bathrooms' => 4, 'is_furnished' => true, 'has_parking' => true, 'is_pet_friendly' => true,
                'amenities' => ['Smart Home','Home Theater','Rooftop','CCTV','Modular Kitchen'],
                'images' => ['https://images.unsplash.com/photo-1564013799919-ab600027ffc6?auto=format&fit=crop&w=800&q=80'],
            ],
            [
                'title' => 'Cozy Cottage in Hills',
                'description' => 'Peaceful cottage surrounded by pine trees with a fireplace and mountain views.',
                'price' => 3000, 'address' => 'Mall Road, Shimla, Himachal Pradesh',
                'latitude' => 31.1048, 'longitude' => 77.1734, 'category' => 'House',
                'bedrooms' => 3, 'bathrooms' => 2, 'is_furnished' => true, 'has_parking' => true, 'is_pet_friendly' => true,
                'amenities' => ['Fireplace','Mountain View','Garden','Kitchen','Hot Water'],
                'images' => ['https://images.unsplash.com/photo-1518780664697-55e3ad937233?auto=format&fit=crop&w=800&q=80'],
            ],
            [
                'title' => 'Suburban Family Home',
                'description' => 'Spacious independent house in quiet residential locality with lawn and car porch.',
                'price' => 4000, 'address' => 'Jubilee Hills, Hyderabad, Telangana',
                'latitude' => 17.4319, 'longitude' => 78.4067, 'category' => 'House',
                'bedrooms' => 4, 'bathrooms' => 3, 'is_furnished' => false, 'has_parking' => true, 'is_pet_friendly' => true,
                'amenities' => ['Lawn','Car Porch','Servant Room','Terrace','Bore Well'],
                'images' => ['https://images.unsplash.com/photo-1583608205776-bfd35f0d9f83?auto=format&fit=crop&w=800&q=80'],
            ],

            // ── Villa (4) ─────────────────────────────────────────
            [
                'title' => 'Luxury Poolside Villa',
                'description' => 'Exclusive luxury villa with private pool, landscaped garden, and ocean views.',
                'price' => 15000, 'address' => 'Candolim Beach Road, North Goa',
                'latitude' => 15.5175, 'longitude' => 73.7624, 'category' => 'Villa',
                'bedrooms' => 5, 'bathrooms' => 5, 'is_furnished' => true, 'has_parking' => true, 'is_pet_friendly' => false,
                'amenities' => ['Private Pool','Jacuzzi','Beach Access','BBQ','Chef Service','WiFi'],
                'images' => ['https://images.unsplash.com/photo-1512917774080-9991f1c4c750?auto=format&fit=crop&w=800&q=80'],
            ],
            [
                'title' => 'Hilltop Retreat Villa',
                'description' => 'Serene hilltop villa with 360° views, infinity pool, and dedicated caretaker.',
                'price' => 12000, 'address' => 'Coonoor, Nilgiris, Tamil Nadu',
                'latitude' => 11.3530, 'longitude' => 76.7959, 'category' => 'Villa',
                'bedrooms' => 4, 'bathrooms' => 4, 'is_furnished' => true, 'has_parking' => true, 'is_pet_friendly' => true,
                'amenities' => ['Infinity Pool','Garden','Bonfire Area','Caretaker','Mountain View'],
                'images' => ['https://images.unsplash.com/photo-1613490493576-7fde63acd811?auto=format&fit=crop&w=800&q=80'],
            ],
            [
                'title' => 'Royal Heritage Villa',
                'description' => 'Heritage villa with courtyard, antique furnishings, and Rajasthani architecture.',
                'price' => 10000, 'address' => 'Near City Palace, Udaipur, Rajasthan',
                'latitude' => 24.5854, 'longitude' => 73.6825, 'category' => 'Villa',
                'bedrooms' => 6, 'bathrooms' => 5, 'is_furnished' => true, 'has_parking' => true, 'is_pet_friendly' => false,
                'amenities' => ['Courtyard','Lake View','Heritage Architecture','Room Service','WiFi'],
                'images' => ['https://images.unsplash.com/photo-1600596542815-ffad4c1539a9?auto=format&fit=crop&w=800&q=80'],
            ],
            [
                'title' => 'Beachfront Paradise Villa',
                'description' => 'Stunning beachfront villa with open-air shower, hammocks, and sunset lounge.',
                'price' => 18000, 'address' => 'Ashwem Beach, North Goa',
                'latitude' => 15.6341, 'longitude' => 73.7270, 'category' => 'Villa',
                'bedrooms' => 3, 'bathrooms' => 3, 'is_furnished' => true, 'has_parking' => true, 'is_pet_friendly' => false,
                'amenities' => ['Beach Access','Hammocks','Sunset Lounge','Outdoor Shower','BBQ'],
                'images' => ['https://images.unsplash.com/photo-1580587771525-78b9dba3b914?auto=format&fit=crop&w=800&q=80'],
            ],

            // ── Studio (4) ────────────────────────────────────────
            [
                'title' => 'Downtown Micro Studio',
                'description' => 'Compact studio in the heart of the city. Perfect for digital nomads.',
                'price' => 1200, 'address' => 'Connaught Place, New Delhi',
                'latitude' => 28.6315, 'longitude' => 77.2167, 'category' => 'Studio',
                'bedrooms' => 1, 'bathrooms' => 1, 'is_furnished' => true, 'has_parking' => false, 'is_pet_friendly' => false,
                'amenities' => ['WiFi','AC','Smart TV','Kitchenette','Laundry'],
                'images' => ['https://images.unsplash.com/photo-1536376072261-38c75010e6c9?auto=format&fit=crop&w=800&q=80'],
            ],
            [
                'title' => 'Artist Loft Studio',
                'description' => 'Open-plan loft with exposed brick walls and creative workspace.',
                'price' => 1800, 'address' => 'Hauz Khas Village, New Delhi',
                'latitude' => 28.5494, 'longitude' => 77.2001, 'category' => 'Studio',
                'bedrooms' => 1, 'bathrooms' => 1, 'is_furnished' => true, 'has_parking' => false, 'is_pet_friendly' => true,
                'amenities' => ['WiFi','Work Desk','Natural Light','Kitchenette','Balcony'],
                'images' => ['https://images.unsplash.com/photo-1493809842364-78817add7ffb?auto=format&fit=crop&w=800&q=80'],
            ],
            [
                'title' => 'Tech Park Studio Condo',
                'description' => 'Modern studio near IT parks with gym, rooftop cafe, and co-working space.',
                'price' => 1600, 'address' => 'Electronic City Phase 1, Bangalore',
                'latitude' => 12.8456, 'longitude' => 77.6603, 'category' => 'Studio',
                'bedrooms' => 1, 'bathrooms' => 1, 'is_furnished' => true, 'has_parking' => true, 'is_pet_friendly' => false,
                'amenities' => ['WiFi','Gym','Rooftop Cafe','Co-working','AC','Power Backup'],
                'images' => ['https://images.unsplash.com/photo-1505691938895-1758d7feb511?auto=format&fit=crop&w=800&q=80'],
            ],
            [
                'title' => 'Lakeside Studio Retreat',
                'description' => 'Peaceful studio with lake views and meditation garden access.',
                'price' => 1400, 'address' => 'Fateh Sagar Lake Area, Udaipur',
                'latitude' => 24.5967, 'longitude' => 73.6784, 'category' => 'Studio',
                'bedrooms' => 1, 'bathrooms' => 1, 'is_furnished' => true, 'has_parking' => false, 'is_pet_friendly' => false,
                'amenities' => ['Lake View','WiFi','Meditation Garden','AC','Kitchenette'],
                'images' => ['https://images.unsplash.com/photo-1507089947368-19c1da9775ae?auto=format&fit=crop&w=800&q=80'],
            ],

            // ── PG (10) ──────────────────────────────────────────
            [
                'title' => 'Blossom Girls PG - AC Rooms',
                'description' => 'Safe and secure PG for girls with AC rooms, home-cooked meals, WiFi, and 24/7 CCTV surveillance. Near metro station.',
                'price' => 800, 'address' => 'Sector 18, Noida, Uttar Pradesh',
                'latitude' => 28.5707, 'longitude' => 77.3219, 'category' => 'PG',
                'bedrooms' => 1, 'bathrooms' => 1, 'is_furnished' => true, 'has_parking' => false, 'is_pet_friendly' => false,
                'amenities' => ['WiFi','AC','Meals Included','CCTV','Laundry','Hot Water'],
                'images' => ['https://images.unsplash.com/photo-1555854877-bab0e564b8d5?auto=format&fit=crop&w=800&q=80'],
            ],
            [
                'title' => 'SafeNest Ladies PG',
                'description' => 'Premium girls PG with single and double occupancy, attached washroom, study area, and home food. Warden on premises.',
                'price' => 900, 'address' => 'HSR Layout, Bangalore, Karnataka',
                'latitude' => 12.9141, 'longitude' => 77.6501, 'category' => 'PG',
                'bedrooms' => 1, 'bathrooms' => 1, 'is_furnished' => true, 'has_parking' => false, 'is_pet_friendly' => false,
                'amenities' => ['WiFi','Meals','Study Area','Warden','CCTV','Water Purifier'],
                'images' => ['https://images.unsplash.com/photo-1595526114035-0d45ed16cfbf?auto=format&fit=crop&w=800&q=80'],
            ],
            [
                'title' => 'Royal Girls PG - Furnished',
                'description' => 'Well-furnished girls PG near IT corridor with refrigerator, washing machine, and biometric entry.',
                'price' => 750, 'address' => 'Marathahalli, Bangalore, Karnataka',
                'latitude' => 12.9591, 'longitude' => 77.6974, 'category' => 'PG',
                'bedrooms' => 1, 'bathrooms' => 1, 'is_furnished' => true, 'has_parking' => false, 'is_pet_friendly' => false,
                'amenities' => ['WiFi','AC','Fridge','Washing Machine','Biometric Lock','Power Backup'],
                'images' => ['https://images.unsplash.com/photo-1631049307264-da0ec9d70304?auto=format&fit=crop&w=800&q=80'],
            ],
            [
                'title' => 'Pink Nest PG for Working Women',
                'description' => 'Exclusive PG for working women with hygienic meals, housekeeping, and community lounge.',
                'price' => 850, 'address' => 'Andheri East, Mumbai, Maharashtra',
                'latitude' => 19.1197, 'longitude' => 72.8464, 'category' => 'PG',
                'bedrooms' => 1, 'bathrooms' => 1, 'is_furnished' => true, 'has_parking' => false, 'is_pet_friendly' => false,
                'amenities' => ['WiFi','Meals','Housekeeping','Community Lounge','CCTV','Lift'],
                'images' => ['https://images.unsplash.com/photo-1609766857041-ed402ea8069a?auto=format&fit=crop&w=800&q=80'],
            ],
            [
                'title' => 'Grace PG - Premium Girls Hostel',
                'description' => 'Top-rated girls hostel with gym, rooftop hangout, Netflix lounge, and weekly room cleaning.',
                'price' => 1000, 'address' => 'Koregaon Park, Pune, Maharashtra',
                'latitude' => 18.5362, 'longitude' => 73.8929, 'category' => 'PG',
                'bedrooms' => 1, 'bathrooms' => 1, 'is_furnished' => true, 'has_parking' => false, 'is_pet_friendly' => false,
                'amenities' => ['WiFi','Gym','Rooftop','Netflix Lounge','Housekeeping','AC'],
                'images' => ['https://images.unsplash.com/photo-1600585154340-be6161a56a0c?auto=format&fit=crop&w=800&q=80'],
            ],
            [
                'title' => 'Sunflower Girls PG - Triple Share',
                'description' => 'Affordable triple sharing PG for girls with daily tiffin, iron, and common TV room. Walking distance to bus stop.',
                'price' => 550, 'address' => 'Ameerpet, Hyderabad, Telangana',
                'latitude' => 17.4375, 'longitude' => 78.4483, 'category' => 'PG',
                'bedrooms' => 1, 'bathrooms' => 1, 'is_furnished' => true, 'has_parking' => false, 'is_pet_friendly' => false,
                'amenities' => ['WiFi','Tiffin Service','Iron','TV Room','CCTV','Geyser'],
                'images' => ['https://images.unsplash.com/photo-1600607687939-ce8a6c25118c?auto=format&fit=crop&w=800&q=80'],
            ],
            [
                'title' => 'Cloud9 PG for Girls - Premium',
                'description' => 'Ultra-premium PG with queen bed, mini fridge, microwave, and personal locker. Rooftop yoga sessions every morning.',
                'price' => 1200, 'address' => 'Indiranagar, Bangalore, Karnataka',
                'latitude' => 12.9784, 'longitude' => 77.6408, 'category' => 'PG',
                'bedrooms' => 1, 'bathrooms' => 1, 'is_furnished' => true, 'has_parking' => false, 'is_pet_friendly' => false,
                'amenities' => ['WiFi','AC','Mini Fridge','Microwave','Yoga','Locker','Queen Bed'],
                'images' => ['https://images.unsplash.com/photo-1560185007-cde436f6a4d0?auto=format&fit=crop&w=800&q=80'],
            ],
            [
                'title' => 'Orchid PG - Near IT Hub',
                'description' => 'Girls-only PG with power backup, purified water, two meals daily, and dedicated night watchman.',
                'price' => 700, 'address' => 'Whitefield Main Road, Bangalore',
                'latitude' => 12.9698, 'longitude' => 77.7499, 'category' => 'PG',
                'bedrooms' => 1, 'bathrooms' => 1, 'is_furnished' => true, 'has_parking' => false, 'is_pet_friendly' => false,
                'amenities' => ['WiFi','Meals','Power Backup','RO Water','Night Watchman','Fan'],
                'images' => ['https://images.unsplash.com/photo-1586023492125-27b2c045efd7?auto=format&fit=crop&w=800&q=80'],
            ],
            [
                'title' => 'Venus Ladies PG - Deluxe',
                'description' => 'Deluxe PG accommodation for girls with attached balcony, wardrobe, and in-house laundry service included in rent.',
                'price' => 950, 'address' => 'Sector 15, Gurugram, Haryana',
                'latitude' => 28.4650, 'longitude' => 77.0370, 'category' => 'PG',
                'bedrooms' => 1, 'bathrooms' => 1, 'is_furnished' => true, 'has_parking' => false, 'is_pet_friendly' => false,
                'amenities' => ['WiFi','AC','Balcony','Wardrobe','Laundry Service','CCTV','Meals'],
                'images' => ['https://images.unsplash.com/photo-1505691938895-1758d7feb511?auto=format&fit=crop&w=800&q=80'],
            ],
            [
                'title' => 'Daisy PG - Budget Friendly',
                'description' => 'No-frills budget PG for girls with clean rooms, 3 meals a day, and excellent location near metro and market.',
                'price' => 500, 'address' => 'Laxmi Nagar, New Delhi',
                'latitude' => 28.6306, 'longitude' => 77.2773, 'category' => 'PG',
                'bedrooms' => 1, 'bathrooms' => 1, 'is_furnished' => true, 'has_parking' => false, 'is_pet_friendly' => false,
                'amenities' => ['WiFi','3 Meals','Geyser','Fan','Near Metro','Market Nearby'],
                'images' => ['https://images.unsplash.com/photo-1540518614846-7eded433c457?auto=format&fit=crop&w=800&q=80'],
            ],

            // ── Room (10) ─────────────────────────────────────────
            [
                'title' => 'Budget Single Room - AC',
                'description' => 'Clean and affordable single room with AC, attached bathroom, and basic furniture. Ideal for students.',
                'price' => 500, 'address' => 'Rajouri Garden, New Delhi',
                'latitude' => 28.6491, 'longitude' => 77.1212, 'category' => 'Room',
                'bedrooms' => 1, 'bathrooms' => 1, 'is_furnished' => true, 'has_parking' => false, 'is_pet_friendly' => false,
                'amenities' => ['AC','Attached Bathroom','Bed','Wardrobe','Table'],
                'images' => ['https://images.unsplash.com/photo-1540518614846-7eded433c457?auto=format&fit=crop&w=800&q=80'],
            ],
            [
                'title' => 'Independent Room Near College',
                'description' => 'Independent single room with separate entry, kitchen access, and peaceful environment near IIT campus.',
                'price' => 450, 'address' => 'Near IIT Gate, Powai, Mumbai',
                'latitude' => 19.1334, 'longitude' => 72.9133, 'category' => 'Room',
                'bedrooms' => 1, 'bathrooms' => 1, 'is_furnished' => false, 'has_parking' => false, 'is_pet_friendly' => false,
                'amenities' => ['Separate Entry','Kitchen Access','Hot Water','WiFi'],
                'images' => ['https://images.unsplash.com/photo-1505693416388-ac5ce068fe85?auto=format&fit=crop&w=800&q=80'],
            ],
            [
                'title' => 'Furnished Room with Balcony',
                'description' => 'Spacious furnished room with balcony, study desk, and wardrobe. Close to bus stop.',
                'price' => 600, 'address' => 'BTM Layout 2nd Stage, Bangalore',
                'latitude' => 12.9166, 'longitude' => 77.6101, 'category' => 'Room',
                'bedrooms' => 1, 'bathrooms' => 1, 'is_furnished' => true, 'has_parking' => false, 'is_pet_friendly' => false,
                'amenities' => ['Balcony','Study Desk','Wardrobe','WiFi','Fan'],
                'images' => ['https://images.unsplash.com/photo-1586023492125-27b2c045efd7?auto=format&fit=crop&w=800&q=80'],
            ],
            [
                'title' => 'Deluxe Single Room - Shared Kitchen',
                'description' => 'Deluxe single room with premium mattress, charging points, and shared modern kitchen.',
                'price' => 550, 'address' => 'Viman Nagar, Pune, Maharashtra',
                'latitude' => 18.5679, 'longitude' => 73.9143, 'category' => 'Room',
                'bedrooms' => 1, 'bathrooms' => 1, 'is_furnished' => true, 'has_parking' => false, 'is_pet_friendly' => false,
                'amenities' => ['WiFi','Shared Kitchen','Reading Lamp','Charging Points','Locker'],
                'images' => ['https://images.unsplash.com/photo-1560185007-cde436f6a4d0?auto=format&fit=crop&w=800&q=80'],
            ],
            [
                'title' => 'Pocket-Friendly Room for Students',
                'description' => 'Super affordable room near university with free WiFi, water, and electricity included.',
                'price' => 400, 'address' => 'Near Manipal University, Jaipur',
                'latitude' => 26.8465, 'longitude' => 75.5653, 'category' => 'Room',
                'bedrooms' => 1, 'bathrooms' => 1, 'is_furnished' => true, 'has_parking' => false, 'is_pet_friendly' => false,
                'amenities' => ['WiFi','Water Included','Electricity Included','Bed','Fan'],
                'images' => ['https://images.unsplash.com/photo-1555854877-bab0e564b8d5?auto=format&fit=crop&w=800&q=80'],
            ],
            [
                'title' => 'Terrace Room with City View',
                'description' => 'Independent terrace room with panoramic city views, private entrance, and rooftop sitting area.',
                'price' => 700, 'address' => 'Aundh, Pune, Maharashtra',
                'latitude' => 18.5581, 'longitude' => 73.8078, 'category' => 'Room',
                'bedrooms' => 1, 'bathrooms' => 1, 'is_furnished' => true, 'has_parking' => false, 'is_pet_friendly' => false,
                'amenities' => ['City View','Private Entry','Rooftop Sitting','WiFi','AC','Geyser'],
                'images' => ['https://images.unsplash.com/photo-1502672260266-1c1ef2d93688?auto=format&fit=crop&w=800&q=80'],
            ],
            [
                'title' => 'AC Room Near Metro Station',
                'description' => 'Fully furnished AC room just 2 minutes walk from metro station. Includes bed, table, chair and cupboard.',
                'price' => 650, 'address' => 'Dwarka Sector 21, New Delhi',
                'latitude' => 28.5531, 'longitude' => 77.0588, 'category' => 'Room',
                'bedrooms' => 1, 'bathrooms' => 1, 'is_furnished' => true, 'has_parking' => false, 'is_pet_friendly' => false,
                'amenities' => ['AC','Near Metro','Bed','Table','Chair','Cupboard','WiFi'],
                'images' => ['https://images.unsplash.com/photo-1522708323590-d24dbb6b0267?auto=format&fit=crop&w=800&q=80'],
            ],
            [
                'title' => 'Garden-Facing Room - Ground Floor',
                'description' => 'Bright ground floor room facing the garden. Quiet and peaceful. Attached bathroom with 24hr water supply.',
                'price' => 550, 'address' => 'Jayanagar 4th Block, Bangalore',
                'latitude' => 12.9255, 'longitude' => 77.5835, 'category' => 'Room',
                'bedrooms' => 1, 'bathrooms' => 1, 'is_furnished' => true, 'has_parking' => false, 'is_pet_friendly' => true,
                'amenities' => ['Garden View','Attached Bath','24hr Water','WiFi','Fan','Natural Light'],
                'images' => ['https://images.unsplash.com/photo-1493809842364-78817add7ffb?auto=format&fit=crop&w=800&q=80'],
            ],
            [
                'title' => 'Cozy Room in Family House',
                'description' => 'Homely room in a family house with home-cooked food available. Safe neighbourhood, ideal for girls and students.',
                'price' => 480, 'address' => 'Kothrud, Pune, Maharashtra',
                'latitude' => 18.5074, 'longitude' => 73.8077, 'category' => 'Room',
                'bedrooms' => 1, 'bathrooms' => 1, 'is_furnished' => true, 'has_parking' => false, 'is_pet_friendly' => false,
                'amenities' => ['Home Food Available','WiFi','Safe Area','Geyser','Fan','Cupboard'],
                'images' => ['https://images.unsplash.com/photo-1507089947368-19c1da9775ae?auto=format&fit=crop&w=800&q=80'],
            ],
            [
                'title' => 'Modern Room with Workspace',
                'description' => 'Sleek modern room designed for remote workers with ergonomic chair, standing desk, and high-speed fiber internet.',
                'price' => 800, 'address' => 'Baner Road, Pune, Maharashtra',
                'latitude' => 18.5590, 'longitude' => 73.7868, 'category' => 'Room',
                'bedrooms' => 1, 'bathrooms' => 1, 'is_furnished' => true, 'has_parking' => false, 'is_pet_friendly' => false,
                'amenities' => ['Fiber WiFi','Standing Desk','Ergonomic Chair','AC','Power Backup','Kitchenette'],
                'images' => ['https://images.unsplash.com/photo-1536376072261-38c75010e6c9?auto=format&fit=crop&w=800&q=80'],
            ],

            // ── Shop (4) ──────────────────────────────────────────
            [
                'title' => 'Prime Retail Shop - Main Road',
                'description' => 'High-footfall retail shop on main road with glass facade and ample storage.',
                'price' => 5000, 'address' => 'MG Road, Bangalore, Karnataka',
                'latitude' => 12.9716, 'longitude' => 77.5946, 'category' => 'Shop',
                'bedrooms' => 0, 'bathrooms' => 1, 'is_furnished' => false, 'has_parking' => true, 'is_pet_friendly' => false,
                'amenities' => ['AC','Glass Facade','Storage','Power Backup','Washroom'],
                'images' => ['https://images.unsplash.com/photo-1441986300917-64674bd600d8?auto=format&fit=crop&w=800&q=80'],
            ],
            [
                'title' => 'Mall Kiosk Space',
                'description' => 'Ready-to-use kiosk space inside a popular mall with central AC.',
                'price' => 3500, 'address' => 'Select Citywalk, Saket, New Delhi',
                'latitude' => 28.5285, 'longitude' => 77.2193, 'category' => 'Shop',
                'bedrooms' => 0, 'bathrooms' => 1, 'is_furnished' => true, 'has_parking' => true, 'is_pet_friendly' => false,
                'amenities' => ['Central AC','Escalator Access','Security','Common Washroom'],
                'images' => ['https://images.unsplash.com/photo-1567449303078-57ad995bd329?auto=format&fit=crop&w=800&q=80'],
            ],
            [
                'title' => 'Corner Shop - Market Area',
                'description' => 'Spacious corner shop in a busy market with visibility from two sides.',
                'price' => 2500, 'address' => 'Lajpat Nagar Market, New Delhi',
                'latitude' => 28.5699, 'longitude' => 77.2403, 'category' => 'Shop',
                'bedrooms' => 0, 'bathrooms' => 1, 'is_furnished' => false, 'has_parking' => false, 'is_pet_friendly' => false,
                'amenities' => ['Corner Location','Two-Side Visibility','Shutter','Electricity'],
                'images' => ['https://images.unsplash.com/photo-1604719312566-8912e9227c6a?auto=format&fit=crop&w=800&q=80'],
            ],
            [
                'title' => 'IT Park Office Shop',
                'description' => 'Commercial shop space in an IT park with fiber internet and conference room access.',
                'price' => 4500, 'address' => 'HITEC City, Hyderabad, Telangana',
                'latitude' => 17.4435, 'longitude' => 78.3772, 'category' => 'Shop',
                'bedrooms' => 0, 'bathrooms' => 1, 'is_furnished' => true, 'has_parking' => true, 'is_pet_friendly' => false,
                'amenities' => ['Fiber Internet','Conference Room','Cafeteria','AC','Lift'],
                'images' => ['https://images.unsplash.com/photo-1497366216548-37526070297c?auto=format&fit=crop&w=800&q=80'],
            ],

            // ── Hall (4) ──────────────────────────────────────────
            [
                'title' => 'Grand Celebration Banquet Hall',
                'description' => 'Luxurious banquet hall for 500+ guests with stage, DJ console, and valet parking.',
                'price' => 25000, 'address' => 'GT Karnal Road, Delhi',
                'latitude' => 28.7180, 'longitude' => 77.1525, 'category' => 'Hall',
                'bedrooms' => 0, 'bathrooms' => 4, 'is_furnished' => true, 'has_parking' => true, 'is_pet_friendly' => false,
                'amenities' => ['Stage','DJ Console','Bridal Room','Valet Parking','Catering Kitchen','AC'],
                'images' => ['https://images.unsplash.com/photo-1519167758481-83f550bb49b3?auto=format&fit=crop&w=800&q=80'],
            ],
            [
                'title' => 'Corporate Conference Center',
                'description' => 'State-of-the-art conference hall with projector, video conferencing, and 120 seats.',
                'price' => 8000, 'address' => 'BKC, Mumbai, Maharashtra',
                'latitude' => 19.0596, 'longitude' => 72.8656, 'category' => 'Hall',
                'bedrooms' => 0, 'bathrooms' => 2, 'is_furnished' => true, 'has_parking' => true, 'is_pet_friendly' => false,
                'amenities' => ['Projector','Video Conferencing','WiFi','Mic System','AC','Whiteboard'],
                'images' => ['https://images.unsplash.com/photo-1517457373958-b7bdd4587205?auto=format&fit=crop&w=800&q=80'],
            ],
            [
                'title' => 'Community Event Space',
                'description' => 'Versatile community hall for cultural events and exhibitions. Capacity 200.',
                'price' => 5000, 'address' => 'Shivaji Nagar, Pune, Maharashtra',
                'latitude' => 18.5308, 'longitude' => 73.8475, 'category' => 'Hall',
                'bedrooms' => 0, 'bathrooms' => 2, 'is_furnished' => false, 'has_parking' => true, 'is_pet_friendly' => false,
                'amenities' => ['Stage','Sound System','Chairs','Tables','Pantry','Parking'],
                'images' => ['https://images.unsplash.com/photo-1540575467063-178a50c2df87?auto=format&fit=crop&w=800&q=80'],
            ],
            [
                'title' => 'Rooftop Party Venue',
                'description' => 'Stunning rooftop event space with city skyline views, bar setup, and ambient lighting.',
                'price' => 12000, 'address' => 'Bandra West, Mumbai, Maharashtra',
                'latitude' => 19.0596, 'longitude' => 72.8295, 'category' => 'Hall',
                'bedrooms' => 0, 'bathrooms' => 2, 'is_furnished' => true, 'has_parking' => true, 'is_pet_friendly' => false,
                'amenities' => ['Skyline View','Bar Setup','Lounge Seating','Ambient Lighting','DJ Area','Lift'],
                'images' => ['https://images.unsplash.com/photo-1478147427282-58a87a120781?auto=format&fit=crop&w=800&q=80'],
            ],
        ];

        // Ensure 10 properties of each category (retrieved dynamically from the database/API)
        $categoriesList = \App\Models\Category::pluck('name')->toArray();
        if (empty($categoriesList)) {
            $categoriesList = ['Apartment', 'House', 'Villa', 'Studio', 'PG', 'Room', 'Shop', 'Hall'];
        }

        $byCategory = [];
        foreach ($properties as $p) {
            $byCategory[$p['category']][] = $p;
        }

        $finalProperties = [];
        foreach ($categoriesList as $cat) {
            $existing = $byCategory[$cat] ?? [];
            $count = count($existing);
            
            // Add existing first
            foreach ($existing as $p) {
                $finalProperties[] = $p;
            }

            // Fill up to 10
            for ($i = $count; $i < 10; $i++) {
                if ($count > 0) {
                    $base = $existing[$i % $count];
                    $newProperty = $base;
                    $newProperty['title'] = $base['title'] . " - Option " . ($i - $count + 2);
                    $newProperty['address'] = $base['address'] . " (Suite " . ($i - $count + 2) . ")";
                    $newProperty['price'] = $base['price'] + ($i * 45);
                } else {
                    $newProperty = [
                        'title' => "Premium $cat Space (Unit " . ($i + 1) . ")",
                        'description' => "Excellent high quality $cat located in prime location with all modern amenities.",
                        'price' => 1500 + ($i * 120),
                        'address' => "Street " . ($i + 1) . ", Prime Zone, HomiQ Town (Suite " . ($i + 1) . ")",
                        'latitude' => 28.6 + (0.01 * $i),
                        'longitude' => 77.2 + (0.01 * $i),
                        'category' => $cat,
                        'bedrooms' => in_array($cat, ['Shop', 'Hall']) ? 0 : 2,
                        'bathrooms' => 2,
                        'is_furnished' => true,
                        'has_parking' => true,
                        'is_pet_friendly' => false,
                        'amenities' => ['WiFi', 'AC', 'Parking'],
                        'images' => ['https://images.unsplash.com/photo-1564013799919-ab600027ffc6?auto=format&fit=crop&w=800&q=80'],
                    ];
                }
                $finalProperties[] = $newProperty;
            }
        }

        foreach ($finalProperties as $index => $property) {
            $ownerId = $ownerIds[$index % count($ownerIds)];
            Property::create(array_merge($property, [
                'owner_id' => $ownerId,
                'status' => 'approved',
            ]));
        }
    }
}
