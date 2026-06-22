<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\RentalAgreement;
use Illuminate\Support\Facades\Log;

class RentalAgreementController extends Controller
{
    public function index(Request $request)
    {
        $userId = $request->user()->id;
        $agreements = RentalAgreement::with(['property', 'owner', 'tenant'])
            ->where('owner_id', $userId)
            ->orWhere('tenant_id', $userId)
            ->get();
        return response()->json($agreements);
    }

    public function store(Request $request)
    {
        $request->validate([
            'property_id' => 'required|exists:properties,id',
            'tenant_id' => 'required|exists:users,id',
            'rent_amount' => 'required|numeric',
            'deposit_amount' => 'required|numeric',
            'start_date' => 'required|date',
            'end_date' => 'required|date|after:start_date',
            'owner_signature' => 'nullable|image|max:2048',
        ]);

        try {
            $agreement = RentalAgreement::create([
                'property_id' => $request->property_id,
                'owner_id' => $request->user()->id,
                'tenant_id' => $request->tenant_id,
                'rent_amount' => $request->rent_amount,
                'deposit_amount' => $request->deposit_amount,
                'start_date' => $request->start_date,
                'end_date' => $request->end_date,
                'status' => 'pending_tenant',
            ]);

            // Save owner signature if provided
            if ($request->hasFile('owner_signature')) {
                $path = $request->file('owner_signature')->store('signatures', 'public');
                $agreement->owner_signature = '/storage/' . $path;
                $agreement->save();
            }

            return response()->json(['message' => 'Rental agreement created successfully.', 'agreement' => $agreement], 201);
        } catch (\Exception $e) {
            Log::error('Rental Agreement Error: ' . $e->getMessage());
            return response()->json(['message' => 'Failed to create agreement.'], 500);
        }
    }

    public function show($id, Request $request)
    {
        $agreement = RentalAgreement::with(['property', 'owner', 'tenant'])->findOrFail($id);
        
        // Ensure user is authorized
        $userId = $request->user()->id;
        if ($agreement->owner_id != $userId && $agreement->tenant_id != $userId) {
            return response()->json(['message' => 'Unauthorized'], 403);
        }

        return response()->json(['agreement' => $agreement]);
    }

    public function sign($id, Request $request)
    {
        $request->validate([
            'signature' => 'required|image|max:2048',
        ]);

        try {
            $agreement = RentalAgreement::findOrFail($id);
            $userId = $request->user()->id;

            if ($userId != $agreement->tenant_id) {
                return response()->json(['message' => 'Only the tenant can sign this step.'], 403);
            }

            if ($request->hasFile('signature')) {
                $path = $request->file('signature')->store('signatures', 'public');
                $agreement->tenant_signature = '/storage/' . $path;
                $agreement->status = 'signed';
                $agreement->save();

                return response()->json(['message' => 'Agreement signed successfully.', 'agreement' => $agreement], 200);
            }

            return response()->json(['message' => 'Signature required.'], 400);
        } catch (\Exception $e) {
            Log::error('Signature Upload Error: ' . $e->getMessage());
            return response()->json(['message' => 'Failed to sign agreement.'], 500);
        }
    }
}
