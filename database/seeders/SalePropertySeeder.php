<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Property;

class SalePropertySeeder extends Seeder
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

        $saleProperties = [
            [
                'title' => 'Luxury Oceanview Villa for Sale',
                'description' => 'A stunning luxury villa offering panoramic ocean views, private infinity pool, and state-of-the-art smart home features.',
                'price' => 1250000, 
                'address' => 'Palm Jumeirah, Dubai',
                'latitude' => 25.1124, 
                'longitude' => 55.1390, 
                'category' => 'Villa',
                'bedrooms' => 5, // Even though we hide them in mobile, they can exist in DB
                'bathrooms' => 6, 
                'is_furnished' => true, 
                'has_parking' => true, 
                'is_pet_friendly' => true,
                'amenities' => ['Private Pool', 'Gym', 'Smart Home', 'Sea View'],
                'images' => ['https://images.unsplash.com/photo-1512917774080-9991f1c4c750?auto=format&fit=crop&w=800&q=80'],
                'listing_type' => 'sale',
                'built_up_area' => 8500,
                'property_age' => 'New Build',
                'ownership_type' => 'Freehold',
                'is_negotiable' => true,
            ],
            [
                'title' => 'Modern Downtown Apartment',
                'description' => 'A chic and modern apartment situated right in the heart of the city with great connectivity and premium fittings.',
                'price' => 450000, 
                'address' => 'Downtown Avenue, New York',
                'latitude' => 40.7128, 
                'longitude' => -74.0060, 
                'category' => 'Apartment',
                'bedrooms' => 2, 
                'bathrooms' => 2, 
                'is_furnished' => false, 
                'has_parking' => true, 
                'is_pet_friendly' => true,
                'amenities' => ['Gym', 'Lift', 'Security', 'Balcony'],
                'images' => ['https://images.unsplash.com/photo-1522708323590-d24dbb6b0267?auto=format&fit=crop&w=800&q=80'],
                'listing_type' => 'sale',
                'built_up_area' => 1200,
                'property_age' => '1 to 5 years',
                'ownership_type' => 'Co-operative Society',
                'is_negotiable' => false,
            ],
            [
                'title' => 'Spacious Suburban Family House',
                'description' => 'Perfect family home located in a quiet suburban neighborhood featuring a large backyard, newly renovated kitchen, and a double garage.',
                'price' => 680000, 
                'address' => 'Maple Street, Toronto',
                'latitude' => 43.6510, 
                'longitude' => -79.3470, 
                'category' => 'House',
                'bedrooms' => 4, 
                'bathrooms' => 3, 
                'is_furnished' => true, 
                'has_parking' => true, 
                'is_pet_friendly' => true,
                'amenities' => ['Garden', 'Garage', 'Fireplace', 'Heating'],
                'images' => ['https://images.unsplash.com/photo-1568605114967-8130f3a36994?auto=format&fit=crop&w=800&q=80'],
                'listing_type' => 'sale',
                'built_up_area' => 2400,
                'property_age' => '5 to 10 years',
                'ownership_type' => 'Freehold',
                'is_negotiable' => true,
            ]
        ];

        foreach ($saleProperties as $index => $property) {
            $ownerId = $ownerIds[$index % count($ownerIds)];
            Property::create(array_merge($property, [
                'owner_id' => $ownerId,
                'status' => 'approved',
                'currency' => 'USD',
                'billing_frequency' => 'monthly', // though not used for sale
                'country' => 'USA'
            ]));
        }
    }
}
