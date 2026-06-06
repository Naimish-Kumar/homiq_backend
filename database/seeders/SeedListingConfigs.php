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
            [
                'key' => 'app_min_version',
                'value' => '1.0.0',
                'type' => 'text',
                'group' => 'app',
                'label' => 'Minimum Required App Version',
                'description' => 'The oldest allowed app version. Any users below this version will be forced to update to use the app (e.g. 1.0.0).',
            ],
            [
                'key' => 'app_latest_version',
                'value' => '1.0.0',
                'type' => 'text',
                'group' => 'app',
                'label' => 'Latest App Version',
                'description' => 'The latest published version. Users on older versions will receive a suggestion to update (e.g. 1.0.0).',
            ],
            [
                'key' => 'app_force_update',
                'value' => '0',
                'type' => 'boolean',
                'group' => 'app',
                'label' => 'Force App Update',
                'description' => 'Force all users to update if their app version is below the latest version.',
            ],
            [
                'key' => 'app_update_url',
                'value' => 'https://play.google.com/store/apps/details?id=com.homiq.acrocoder',
                'type' => 'text',
                'group' => 'app',
                'label' => 'App Store / Play Store Update Link',
                'description' => 'Direct link to redirect users when they tap the update button.',
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
