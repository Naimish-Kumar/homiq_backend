<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class KycController extends Controller
{
    public function upload(Request $request)
    {
        $request->validate([
            'document' => 'required|image|max:5120',
        ]);

        try {
            $user = $request->user();

            if ($request->hasFile('document')) {
                $path = $request->file('document')->store('kyc_documents', 'public');
                $user->kyc_document = '/storage/' . $path;
                
                // Set status to pending upon document upload
                $user->kyc_status = 'pending';
                $user->is_verified = false;
                $user->save();

                return response()->json([
                    'message' => 'KYC Document uploaded successfully.',
                    'user' => $user
                ], 200);
            }

            return response()->json(['message' => 'No document uploaded.'], 400);

        } catch (\Exception $e) {
            Log::error('KYC Upload Error: ' . $e->getMessage());
            return response()->json(['message' => 'Failed to upload document.'], 500);
        }
    }
}
