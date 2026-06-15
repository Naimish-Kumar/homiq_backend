<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\JsonResponse;

class MetadataController extends Controller
{
    /**
     * Get system metadata for the app.
     */
    public function index(): JsonResponse
    {
        return response()->json([
            'categories' => [
                'sale' => [
                    'Apartment', 'House', 'Villa', 'Builder Floor', 'Land/Plot', 'Commercial Space', 'Commercial Office', 'Commercial Shop', 'Warehouse'
                ],
                'rent' => [
                    'Apartment', 'House', 'Villa', 'Builder Floor', 'Studio', 'PG', 'Room', 'Commercial Space', 'Office Space', 'Shop', 'Warehouse'
                ],
            ],
            'area_units' => [
                'Sq. Ft.', 'Sq. Yards', 'Sq. m.', 'Acres', 'Hectares'
            ],
            'property_age' => [
                'Under Construction', 'New Build', '1-5 Years', '5-10 Years', '10+ Years'
            ],
            'ownership_type' => [
                'Freehold', 'Leasehold', 'Co-operative Society', 'Power of Attorney'
            ],
            'currencies' => [
                'INR', 'USD', 'EUR', 'GBP', 'CAD', 'AUD', 'AED', 'SAR', 'JPY', 'CNY'
            ],
            'billing_frequencies' => [
                'monthly', 'per_day', 'hourly'
            ],
            'preferred_tenant' => [
                'Any', 'Family', 'Bachelors', 'Company'
            ]
        ]);
    }
}
