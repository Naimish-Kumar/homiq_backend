<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\Feedback;

class FeedbackController extends Controller
{
    public function store(Request $request)
    {
        $fields = $request->validate([
            'type' => 'required|string|in:issue,suggestion',
            'stars' => 'nullable|integer|min:1|max:5',
            'area' => 'nullable|string|max:255',
            'feedback' => 'required|string',
        ]);

        $feedback = Feedback::create([
            'user_id' => $request->user()->id,
            'type' => $fields['type'],
            'stars' => $fields['stars'] ?? null,
            'area' => $fields['area'] ?? null,
            'feedback' => $fields['feedback'],
        ]);

        return response()->json([
            'message' => 'Feedback submitted successfully',
            'feedback' => $feedback,
        ], 201);
    }
}
