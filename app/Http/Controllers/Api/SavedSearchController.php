<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\SavedSearch;

class SavedSearchController extends Controller
{
    public function index(Request $request)
    {
        $searches = SavedSearch::where('user_id', $request->user()->id)
            ->latest()
            ->get();
            
        return response()->json($searches);
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'nullable|string|max:255',
            'filters' => 'required|array',
        ]);

        $search = SavedSearch::create([
            'user_id' => $request->user()->id,
            'title' => $request->title ?? 'Saved Search',
            'filters' => $request->filters,
        ]);

        return response()->json($search, 201);
    }

    public function destroy(Request $request, $id)
    {
        $search = SavedSearch::where('user_id', $request->user()->id)->find($id);
        
        if (!$search) {
            return response()->json(['message' => 'Not found'], 404);
        }
        
        $search->delete();
        
        return response()->json(['message' => 'Deleted successfully']);
    }
}
