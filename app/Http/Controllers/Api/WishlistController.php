<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Property;
use App\Models\Wishlist;
use Illuminate\Http\Request;

class WishlistController extends Controller
{
    /**
     * Get all properties on the authenticated user's wishlist.
     */
    public function index(Request $request)
    {
        $properties = $request->user()
            ->wishlistProperties()
            ->with('owner')
            ->orderBy('wishlists.created_at', 'desc')
            ->get();

        return response($properties, 200);
    }

    /**
     * Add or remove a property from the user's wishlist.
     */
    public function toggle(Request $request)
    {
        $request->validate([
            'property_id' => 'required|exists:properties,id',
        ]);

        $userId = $request->user()->id;
        $propertyId = $request->property_id;

        $wishlist = Wishlist::where('user_id', $userId)
            ->where('property_id', $propertyId)
            ->first();

        if ($wishlist) {
            $wishlist->delete();
            return response([
                'status' => 'removed',
                'message' => 'Property removed from wishlist'
            ], 200);
        }

        Wishlist::create([
            'user_id' => $userId,
            'property_id' => $propertyId
        ]);

        return response([
            'status' => 'added',
            'message' => 'Property added to wishlist'
        ], 200);
    }
}
