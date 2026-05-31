<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Configuration;

class SeedListingConfigs extends Seeder
{
    public function run(): void
    {
        $configs = [
            [
                'key' => 'google_maps_api_key',
                'value' => 'AIzaSyDummyKey_PleaseReplaceThisInAdminConfig',
                'type' => 'text',
                'group' => 'general',
                'label' => 'Google Maps API Key',
                'description' => 'Google Maps API key used for geocoding, reverse geocoding, and locating properties on both app and website.',
            ],
            [
                'key' => 'listing_categories',
                'value' => 'Apartment,House,Villa,Studio,PG,Room,Shop,Hall',
                'type' => 'text',
                'group' => 'listing',
                'label' => 'Listing Categories',
                'description' => 'Comma-separated categories available for property listings.',
            ],
            [
                'key' => 'listing_specifications',
                'value' => 'Bedrooms,Bathrooms',
                'type' => 'text',
                'group' => 'listing',
                'label' => 'Property Specifications',
                'description' => 'Comma-separated numeric specifications counters (e.g. Bedrooms, Bathrooms, Kitchens).',
            ],
            [
                'key' => 'listing_features',
                'value' => 'Furnished Space,Available Parking,Allows Pets',
                'type' => 'text',
                'group' => 'listing',
                'label' => 'Key Features',
                'description' => 'Comma-separated boolean toggle switches for property listing features.',
            ],
            [
                'key' => 'listing_amenities',
                'value' => 'WiFi,AC,Kitchen,TV,Gym,Pool,Security,Power Backup',
                'type' => 'text',
                'group' => 'listing',
                'label' => 'Amenities Tags',
                'description' => 'Comma-separated multi-select amenity tag choices.',
            ],
        ];

        foreach ($configs as $config) {
            Configuration::updateOrCreate(
                ['key' => $config['key']],
                $config
            );
        }
    }
}
