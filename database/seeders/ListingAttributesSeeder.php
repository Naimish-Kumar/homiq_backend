<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Category;
use App\Models\Specification;
use App\Models\KeyFeature;
use App\Models\Amenity;

class ListingAttributesSeeder extends Seeder
{
    public function run(): void
    {
        // Seed Categories
        $categories = [
            ['name' => 'Apartment', 'icon' => 'apartment', 'image' => 'https://images.unsplash.com/photo-1545324418-cc1a3fa10c00?w=500&auto=format&fit=crop&q=80'],
            ['name' => 'House', 'icon' => 'home', 'image' => 'https://images.unsplash.com/photo-1564013799919-ab600027ffc6?w=500&auto=format&fit=crop&q=80'],
            ['name' => 'Villa', 'icon' => 'gite', 'image' => 'https://images.unsplash.com/photo-1580587771525-78b9dba3b914?w=500&auto=format&fit=crop&q=80'],
            ['name' => 'Studio', 'icon' => 'home_work', 'image' => 'https://images.unsplash.com/photo-1502672260266-1c1ef2d93688?w=500&auto=format&fit=crop&q=80'],
            ['name' => 'PG', 'icon' => 'group', 'image' => 'https://images.unsplash.com/photo-1555854877-bab0e564b8d5?w=500&auto=format&fit=crop&q=80'],
            ['name' => 'Room', 'icon' => 'meeting_room', 'image' => 'https://images.unsplash.com/photo-1522771739844-6a9f6d5f14af?w=500&auto=format&fit=crop&q=80'],
            ['name' => 'Shop', 'icon' => 'storefront', 'image' => 'https://images.unsplash.com/photo-1555529669-e69e7aa0ba9a?w=500&auto=format&fit=crop&q=80'],
            ['name' => 'Hall', 'icon' => 'corporate_fare', 'image' => 'https://images.unsplash.com/photo-1519167758481-83f550bb49b3?w=500&auto=format&fit=crop&q=80'],
        ];
        foreach ($categories as $cat) {
            Category::updateOrCreate(['name' => $cat['name']], $cat);
        }

        // Seed Specifications
        $specs = ['Bedrooms', 'Bathrooms'];
        foreach ($specs as $spec) {
            Specification::updateOrCreate(['name' => $spec]);
        }

        // Seed Key Features
        $features = ['Furnished Space', 'Available Parking', 'Allows Pets'];
        foreach ($features as $feat) {
            KeyFeature::updateOrCreate(['name' => $feat]);
        }

        // Seed Amenities
        $amenities = [
            ['name' => 'WiFi', 'icon' => 'wifi'],
            ['name' => 'AC', 'icon' => 'ac_unit'],
            ['name' => 'Kitchen', 'icon' => 'kitchen'],
            ['name' => 'TV', 'icon' => 'tv'],
            ['name' => 'Gym', 'icon' => 'fitness_center'],
            ['name' => 'Pool', 'icon' => 'pool'],
            ['name' => 'Security', 'icon' => 'security'],
            ['name' => 'Power Backup', 'icon' => 'bolt'],
        ];
        foreach ($amenities as $am) {
            Amenity::updateOrCreate(['name' => $am['name']], $am);
        }
    }
}
