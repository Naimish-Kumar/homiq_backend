<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\HeroSlide;

class HeroSlideSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $slides = [
            [
                'badge_text' => 'Near Jewar International Airport',
                'badge_icon' => 'location_on',
                'title' => 'Premium Plots Near Jewar Airport',
                'subtitle' => 'Invest in Your Future Today',
                'highlights' => ['High ROI', 'Government Approved', '100% Secure'],
                'primary_cta_text' => 'Explore Projects',
                'primary_cta_link' => '/buy/noida',
                'secondary_cta_text' => 'Contact Us',
                'secondary_cta_link' => 'javascript:void(0)',
                'secondary_cta_action' => 'request_modal',
                'image' => 'images/hero/hero_jewar_airport_plots.jpg',
                'order' => 1,
                'is_active' => true,
            ],
            [
                'badge_text' => 'Zero Brokerage Verified Living',
                'badge_icon' => 'verified_user',
                'title' => 'Luxury Verified Flats in Noida & NCR',
                'subtitle' => 'Direct Landlord Connection with Transparent Pricing',
                'highlights' => ['0% Brokerage', 'Physical Audit Passed', 'Immediate Move-In'],
                'primary_cta_text' => 'Explore Rentals',
                'primary_cta_link' => '/rent/noida',
                'secondary_cta_text' => 'Post Requirement',
                'secondary_cta_link' => 'javascript:void(0)',
                'secondary_cta_action' => 'request_modal',
                'image' => 'images/hero/hero_luxury_apartments.jpg',
                'order' => 2,
                'is_active' => true,
            ],
            [
                'badge_text' => 'Gated Township & Modern Villas',
                'badge_icon' => 'home_work',
                'title' => 'Prime Gated Communities & Smart Living',
                'subtitle' => 'World-Class Amenities, Green Parks & Seamless Expressways',
                'highlights' => ['100% Legal Ownership', 'Near Metro Expressway', 'Clubhouse & 24x7 Security'],
                'primary_cta_text' => 'View Townships',
                'primary_cta_link' => '/buy/noida',
                'secondary_cta_text' => 'Schedule Visit',
                'secondary_cta_link' => 'javascript:void(0)',
                'secondary_cta_action' => 'request_modal',
                'image' => 'images/hero/hero_gated_villas_township.jpg',
                'order' => 3,
                'is_active' => true,
            ],
        ];

        foreach ($slides as $slideData) {
            HeroSlide::updateOrCreate(
                ['title' => $slideData['title']],
                $slideData
            );
        }
    }
}
