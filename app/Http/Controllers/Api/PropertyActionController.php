<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Property;
use App\Models\PropertyView;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;

class PropertyActionController extends Controller
{
    public function logView(Request $request, $id)
    {
        $property = Property::findOrFail($id);
        
        $viewerId = $request->user() ? $request->user()->id : md5($request->ip());
        
        // Log to DB if authenticated
        if ($request->user()) {
            // Avoid duplicate logging within a short timeframe (e.g., 1 hour)
            $recentView = PropertyView::where('user_id', $request->user()->id)
                ->where('property_id', $id)
                ->where('created_at', '>=', now()->subHour())
                ->first();
                
            if (!$recentView) {
                PropertyView::create([
                    'user_id' => $request->user()->id,
                    'property_id' => $id,
                ]);
            }
        }
        
        // Track active viewers in Cache for Urgency Indicators
        $cacheKey = "property_{$id}_active_viewers";
        $viewers = Cache::get($cacheKey, []);
        
        // Remove expired viewers (older than 5 minutes)
        $now = now()->timestamp;
        $viewers = array_filter($viewers, function($timestamp) use ($now) {
            return ($now - $timestamp) < 300; // 5 minutes
        });
        
        // Add current viewer
        $viewers[$viewerId] = $now;
        
        Cache::put($cacheKey, $viewers, now()->addMinutes(10));
        
        return response()->json(['message' => 'View logged successfully']);
    }

    public function recommended(Request $request)
    {
        $user = $request->user();
        
        if ($user) {
            // Get user's most viewed categories
            $favoriteCategories = PropertyView::where('user_id', $user->id)
                ->join('properties', 'property_views.property_id', '=', 'properties.id')
                ->select('properties.category', DB::raw('count(*) as count'))
                ->groupBy('properties.category')
                ->orderByDesc('count')
                ->limit(3)
                ->pluck('category');
                
            if ($favoriteCategories->isNotEmpty()) {
                $viewedIds = PropertyView::where('user_id', $user->id)
                    ->pluck('property_id')
                    ->unique();
                    
                $recommended = Property::with('owner')
                    ->whereIn('category', $favoriteCategories)
                    ->whereNotIn('id', $viewedIds)
                    ->where('status', 'approved')
                    ->latest()
                    ->limit(10)
                    ->get();
                    
                if ($recommended->count() > 0) {
                    return response()->json($recommended);
                }
            }
        }
        
        // Fallback: just return latest approved properties
        $fallback = Property::with('owner')
            ->where('status', 'approved')
            ->latest()
            ->limit(10)
            ->get();
            
        return response()->json($fallback);
    }
}
