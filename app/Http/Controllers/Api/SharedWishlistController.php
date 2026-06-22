<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\SharedWishlist;
use App\Models\SharedWishlistProperty;
use App\Models\SharedWishlistVote;
use App\Models\User;
use Illuminate\Http\Request;

class SharedWishlistController extends Controller
{
    /**
     * Get all shared wishlists for the authenticated user (owned and shared with).
     */
    public function index(Request $request)
    {
        $user = $request->user();

        $wishlists = SharedWishlist::where('owner_id', $user->id)
            ->orWhereHas('users', function ($q) use ($user) {
                $q->where('user_id', $user->id);
            })
            ->with(['owner', 'users', 'properties.property', 'properties.votes'])
            ->get();

        return response($wishlists, 200);
    }

    /**
     * Create a new shared wishlist.
     */
    public function store(Request $request)
    {
        $fields = $request->validate([
            'title' => 'required|string|max:255',
        ]);

        $wishlist = SharedWishlist::create([
            'title' => $fields['title'],
            'owner_id' => $request->user()->id,
        ]);

        // Add owner to users list as well for easier querying if needed, or just rely on owner_id
        $wishlist->users()->attach($request->user()->id);

        return response($wishlist->load(['owner', 'users', 'properties']), 201);
    }

    /**
     * Invite a user to a shared wishlist via email.
     */
    public function invite(Request $request, $id)
    {
        $fields = $request->validate([
            'email' => 'required|email|exists:users,email',
        ]);

        $wishlist = SharedWishlist::findOrFail($id);

        if ($wishlist->owner_id !== $request->user()->id) {
            return response(['message' => 'Only the owner can invite users.'], 403);
        }

        $invitee = User::where('email', $fields['email'])->first();

        if ($wishlist->users()->where('user_id', $invitee->id)->exists()) {
            return response(['message' => 'User is already a collaborator.'], 400);
        }

        $wishlist->users()->attach($invitee->id);

        return response(['message' => 'User invited successfully.', 'wishlist' => $wishlist->load(['owner', 'users', 'properties'])], 200);
    }

    /**
     * Add or remove a property from a shared wishlist.
     */
    public function toggleProperty(Request $request, $id)
    {
        $fields = $request->validate([
            'property_id' => 'required|exists:properties,id',
        ]);

        $wishlist = SharedWishlist::findOrFail($id);

        // Check if user has access
        if ($wishlist->owner_id !== $request->user()->id && !$wishlist->users()->where('user_id', $request->user()->id)->exists()) {
            return response(['message' => 'Unauthorized'], 403);
        }

        $property = SharedWishlistProperty::where('shared_wishlist_id', $id)
            ->where('property_id', $fields['property_id'])
            ->first();

        if ($property) {
            $property->delete();
            return response(['status' => 'removed', 'message' => 'Property removed.'], 200);
        }

        SharedWishlistProperty::create([
            'shared_wishlist_id' => $id,
            'property_id' => $fields['property_id'],
        ]);

        return response(['status' => 'added', 'message' => 'Property added.'], 201);
    }

    /**
     * Update notes for a property in a shared wishlist.
     */
    public function updateNote(Request $request, $id, $propertyId)
    {
        $fields = $request->validate([
            'notes' => 'nullable|string',
        ]);

        $wishlist = SharedWishlist::findOrFail($id);

        if ($wishlist->owner_id !== $request->user()->id && !$wishlist->users()->where('user_id', $request->user()->id)->exists()) {
            return response(['message' => 'Unauthorized'], 403);
        }

        $property = SharedWishlistProperty::where('shared_wishlist_id', $id)
            ->where('property_id', $propertyId)
            ->firstOrFail();

        $property->update(['notes' => $fields['notes']]);

        return response($property, 200);
    }

    /**
     * Upvote or downvote a property in a shared wishlist.
     */
    public function vote(Request $request, $id, $propertyId)
    {
        $fields = $request->validate([
            'vote_type' => 'required|in:1,-1', // 1 for upvote, -1 for downvote
        ]);

        $wishlist = SharedWishlist::findOrFail($id);
        $user = $request->user();

        if ($wishlist->owner_id !== $user->id && !$wishlist->users()->where('user_id', $user->id)->exists()) {
            return response(['message' => 'Unauthorized'], 403);
        }

        $property = SharedWishlistProperty::where('shared_wishlist_id', $id)
            ->where('property_id', $propertyId)
            ->firstOrFail();

        $vote = SharedWishlistVote::where('shared_wishlist_property_id', $property->id)
            ->where('user_id', $user->id)
            ->first();

        if ($vote) {
            if ($vote->vote_type == $fields['vote_type']) {
                // If clicking the same vote again, remove the vote (toggle off)
                $vote->delete();
                return response(['message' => 'Vote removed.', 'vote' => null], 200);
            } else {
                // Change vote
                $vote->update(['vote_type' => $fields['vote_type']]);
                return response(['message' => 'Vote updated.', 'vote' => $vote], 200);
            }
        }

        $vote = SharedWishlistVote::create([
            'shared_wishlist_property_id' => $property->id,
            'user_id' => $user->id,
            'vote_type' => $fields['vote_type'],
        ]);

        return response(['message' => 'Vote cast.', 'vote' => $vote], 201);
    }
}
