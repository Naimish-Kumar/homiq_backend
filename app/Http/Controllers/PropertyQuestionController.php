<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\PropertyQuestion;
use App\Models\Property;

class PropertyQuestionController extends Controller
{
    public function index($propertyId)
    {
        $questions = PropertyQuestion::with('user:id,name,profile_photo')
            ->where('property_id', $propertyId)
            ->orderBy('created_at', 'desc')
            ->get();

        return response()->json($questions);
    }

    public function store(Request $request, $propertyId)
    {
        $request->validate([
            'question' => 'required|string|max:1000',
        ]);

        $property = Property::findOrFail($propertyId);

        $question = PropertyQuestion::create([
            'property_id' => $property->id,
            'user_id' => $request->user()->id,
            'question' => $request->question,
        ]);

        return response()->json([
            'message' => 'Question submitted successfully',
            'question' => $question->load('user:id,name,profile_photo'),
        ], 201);
    }

    public function answer(Request $request, $questionId)
    {
        $request->validate([
            'answer' => 'required|string|max:1000',
        ]);

        $question = PropertyQuestion::findOrFail($questionId);
        $property = $question->property;

        if ($property->owner_id !== $request->user()->id) {
            return response()->json(['message' => 'Unauthorized'], 403);
        }

        $question->update([
            'answer' => $request->answer,
        ]);

        return response()->json([
            'message' => 'Answer submitted successfully',
            'question' => $question->load('user:id,name,profile_photo'),
        ]);
    }
}
