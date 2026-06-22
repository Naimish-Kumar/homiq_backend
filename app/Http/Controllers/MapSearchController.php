<?php

namespace App\Http\Controllers;

use App\Models\Property;
use Illuminate\Http\Request;

class MapSearchController extends Controller
{
    public function search(Request $request)
    {
        $request->validate([
            'polygon' => 'required|array',
            'polygon.*.lat' => 'required|numeric',
            'polygon.*.lng' => 'required|numeric',
        ]);

        $polygon = $request->input('polygon');

        // Fast Database Pre-Filter using Bounding Box
        $minLat = min(array_column($polygon, 'lat'));
        $maxLat = max(array_column($polygon, 'lat'));
        $minLng = min(array_column($polygon, 'lng'));
        $maxLng = max(array_column($polygon, 'lng'));

        $query = Property::query()
            ->where('status', 'approved')
            ->whereBetween('latitude', [$minLat, $maxLat])
            ->whereBetween('longitude', [$minLng, $maxLng]);

        // Apply any other filters from request (e.g. price, category)
        if ($request->filled('category') && $request->category !== 'All') {
            $query->where('category', $request->category);
        }
        if ($request->filled('min_price')) {
            $query->where('price', '>=', $request->min_price);
        }
        if ($request->filled('max_price')) {
            $query->where('price', '<=', $request->max_price);
        }
        if ($request->filled('bedrooms')) {
            $query->where('bedrooms', '>=', $request->bedrooms);
        }

        $properties = $query->with('owner:id,name,email,profile_photo_path')->get();

        // Exact Filter using Ray-Casting Algorithm in PHP
        $filtered = $properties->filter(function ($property) use ($polygon) {
            return $this->isPointInPolygon(
                ['lat' => $property->latitude, 'lng' => $property->longitude],
                $polygon
            );
        });

        return response()->json($filtered->values());
    }

    /**
     * Ray-Casting Algorithm to check if a point is inside a polygon.
     */
    private function isPointInPolygon($point, $polygon)
    {
        $x = $point['lat'];
        $y = $point['lng'];

        $inside = false;
        $count = count($polygon);

        for ($i = 0, $j = $count - 1; $i < $count; $j = $i++) {
            $xi = $polygon[$i]['lat'];
            $yi = $polygon[$i]['lng'];
            $xj = $polygon[$j]['lat'];
            $yj = $polygon[$j]['lng'];

            // Handle edge case of division by zero
            if ($yj == $yi) {
                continue;
            }

            $intersect = (($yi > $y) != ($yj > $y))
                && ($x < ($xj - $xi) * ($y - $yi) / ($yj - $yi) + $xi);

            if ($intersect) {
                $inside = !$inside;
            }
        }

        return $inside;
    }
}
