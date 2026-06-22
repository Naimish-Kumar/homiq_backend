<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Property;
use App\Models\RoommateGroup;
use Illuminate\Http\Request;

class RoommateGroupController extends Controller
{
    /**
     * List active roommate groups looking for roommates for a property.
     */
    public function index($propertyId)
    {
        $groups = RoommateGroup::where('property_id', $propertyId)
            ->whereIn('status', ['searching', 'ready'])
            ->with(['creator', 'members'])
            ->get();

        return response($groups, 200);
    }

    /**
     * Start a new roommate group for a property.
     */
    public function store(Request $request, $propertyId)
    {
        $property = Property::find($propertyId);

        if (!$property) {
            return response(['message' => 'Property not found'], 404);
        }

        if (!$property->supports_group_renting) {
            return response(['message' => 'This property does not support group renting.'], 400);
        }

        $user = $request->user();

        // Check if user is already in an active (searching or ready) group for this property
        $existingGroup = RoommateGroup::where('property_id', $propertyId)
            ->whereIn('status', ['searching', 'ready'])
            ->whereHas('members', function ($query) use ($user) {
                $query->where('user_id', $user->id);
            })
            ->exists();

        if ($existingGroup) {
            return response(['message' => 'You are already in a roommate group for this property.'], 400);
        }

        // Create roommate group
        $group = RoommateGroup::create([
            'property_id' => $property->id,
            'creator_id' => $user->id,
            'status' => 'searching',
            'max_roommates' => $property->group_max_size ?: 3,
        ]);

        // Attach creator as a member
        $group->members()->attach($user->id);

        return response($group->load(['creator', 'members']), 201);
    }

    /**
     * Join an existing roommate group.
     */
    public function join(Request $request, $id)
    {
        $group = RoommateGroup::find($id);

        if (!$group) {
            return response(['message' => 'Roommate group not found'], 404);
        }

        if ($group->status !== 'searching') {
            return response(['message' => 'This group is not accepting new roommates.'], 400);
        }

        $user = $request->user();

        // Check if user is already in this group
        if ($group->members()->where('user_id', $user->id)->exists()) {
            return response(['message' => 'You are already a member of this group.'], 400);
        }

        // Check if user is in any active group for this property
        $alreadyInActive = RoommateGroup::where('property_id', $group->property_id)
            ->whereIn('status', ['searching', 'ready'])
            ->whereHas('members', function ($query) use ($user) {
                $query->where('user_id', $user->id);
            })
            ->exists();

        if ($alreadyInActive) {
            return response(['message' => 'You are already in another roommate group for this property.'], 400);
        }

        // Check if full
        if ($group->members()->count() >= $group->max_roommates) {
            return response(['message' => 'This group is already full.'], 400);
        }

        // Attach user
        $group->members()->attach($user->id);

        // Check if group is now full
        if ($group->members()->count() >= $group->max_roommates) {
            $group->update(['status' => 'ready']);
        }

        return response($group->load(['creator', 'members']), 200);
    }

    /**
     * Leave a roommate group.
     */
    public function leave(Request $request, $id)
    {
        $group = RoommateGroup::find($id);

        if (!$group) {
            return response(['message' => 'Roommate group not found'], 404);
        }

        $user = $request->user();

        if (!$group->members()->where('user_id', $user->id)->exists()) {
            return response(['message' => 'You are not a member of this group.'], 403);
        }

        if (!in_array($group->status, ['searching', 'ready'])) {
            return response(['message' => 'Cannot leave a group after it has been booked.'], 400);
        }

        // If creator leaves, dissolve group entirely
        if ($group->creator_id === $user->id) {
            $group->members()->detach();
            $group->delete();
            return response(['message' => 'Roommate group dissolved successfully.'], 200);
        }

        // Otherwise detach member
        $group->members()->detach($user->id);

        // If status was ready, it is now searching again
        if ($group->status === 'ready') {
            $group->update(['status' => 'searching']);
        }

        return response($group->load(['creator', 'members']), 200);
    }
}
