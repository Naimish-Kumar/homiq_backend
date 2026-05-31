<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Notification;
use Illuminate\Http\Request;

class NotificationController extends Controller
{
    /**
     * Get all notifications for the authenticated user.
     */
    public function index(Request $request)
    {
        $notifications = $request->user()->notifications()
            ->orderBy('created_at', 'desc')
            ->get();

        return response($notifications, 200);
    }

    /**
     * Mark a single notification as read.
     */
    public function markAsRead(Request $request, $id)
    {
        $notification = $request->user()->notifications()->find($id);

        if (!$notification) {
            return response([
                'message' => 'Notification not found'
            ], 404);
        }

        $notification->update(['is_read' => true]);

        return response([
            'message' => 'Notification marked as read',
            'notification' => $notification
        ], 200);
    }

    /**
     * Mark all notifications for the authenticated user as read.
     */
    public function markAllAsRead(Request $request)
    {
        $request->user()->notifications()->where('is_read', false)->update(['is_read' => true]);

        return response([
            'message' => 'All notifications marked as read'
        ], 200);
    }
}
