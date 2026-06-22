<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Chat;
use App\Models\Message;
use App\Models\Property;
use App\Models\Notification;
use Illuminate\Http\Request;

class ChatController extends Controller
{
    /**
     * Display a listing of the chats for the authenticated user.
     */
    public function index(Request $request)
    {
        $user = $request->user();

        // Get chats where user is either user_one or user_two
        $chats = Chat::where('user_one_id', $user->id)
            ->orWhere('user_two_id', $user->id)
            ->with(['userOne', 'userTwo', 'property', 'messages' => function ($q) {
                $q->latest();
            }])
            ->latest('updated_at')
            ->get();

        // Map chats to append latest message and unread count
        $formattedChats = $chats->map(function ($chat) use ($user) {
            $latestMessage = $chat->messages->first();
            $unreadCount = $chat->messages()
                ->where('sender_id', '!=', $user->id)
                ->where('is_read', false)
                ->count();

            return [
                'id' => $chat->id,
                'user_one' => $chat->userOne,
                'user_two' => $chat->userTwo,
                'property' => $chat->property,
                'latest_message' => $latestMessage,
                'unread_count' => $unreadCount,
                'created_at' => $chat->created_at,
                'updated_at' => $chat->updated_at,
            ];
        });

        return response($formattedChats, 200);
    }

    /**
     * Start a new chat room or retrieve the existing one for a property.
     */
    public function store(Request $request)
    {
        $fields = $request->validate([
            'property_id' => 'required|exists:properties,id',
        ]);

        $user = $request->user();
        $property = Property::findOrFail($fields['property_id']);

        if ($property->owner_id === $user->id) {
            return response([
                'message' => 'You cannot chat with yourself about your own listing'
            ], 400);
        }

        // Find or create chat room specifically for this property and seeker
        $chat = Chat::firstOrCreate([
            'user_one_id' => $user->id,
            'user_two_id' => $property->owner_id,
            'property_id' => $property->id,
        ]);

        // Pre-populate with welcome message if empty
        if ($chat->messages()->count() === 0) {
            Message::create([
                'chat_id' => $chat->id,
                'sender_id' => $property->owner_id,
                'message' => "Hello! Thanks for your interest in my space '{$property->title}'. How can I help you?",
                'type' => 'text',
            ]);
        }

        return response($chat->load(['userOne', 'userTwo', 'property']), 201);
    }

    /**
     * Display a specific chat room detail and messages.
     */
    public function show(Request $request, $id)
    {
        $user = $request->user();
        $chat = Chat::with(['userOne', 'userTwo', 'property'])->find($id);

        if (!$chat) {
            return response(['message' => 'Chat room not found'], 404);
        }

        if ($chat->user_one_id !== $user->id && $chat->user_two_id !== $user->id) {
            return response(['message' => 'Unauthorized'], 403);
        }

        // Mark incoming messages as read
        $updatedCount = Message::where('chat_id', $chat->id)
            ->where('sender_id', '!=', $user->id)
            ->where('is_read', false)
            ->update(['is_read' => true]);

        if ($updatedCount > 0) {
            try {
                broadcast(new \App\Events\MessageRead($chat->id, $user->id));
            } catch (\Throwable $e) {
                \Illuminate\Support\Facades\Log::error('Pusher Broadcast Error: ' . $e->getMessage());
            }
        }

        // Broadcast presence safely
        try {
            broadcast(new \App\Events\UserPresence($chat->id, $user->id, true));
        } catch (\Throwable $e) {
            \Illuminate\Support\Facades\Log::error('Pusher Broadcast Error: ' . $e->getMessage());
        }

        $messages = Message::where('chat_id', $chat->id)
            ->with('sender')
            ->orderBy('created_at', 'asc')
            ->get();

        return response([
            'chat' => $chat,
            'messages' => $messages
        ], 200);
    }

    /**
     * Mark unread messages as read while in chat.
     */
    public function markAsRead(Request $request, $id)
    {
        $chat = Chat::find($id);
        if (!$chat) {
            return response(['message' => 'Chat room not found'], 404);
        }

        $user = $request->user();
        if ($chat->user_one_id !== $user->id && $chat->user_two_id !== $user->id) {
            return response(['message' => 'Unauthorized'], 403);
        }

        $updatedCount = Message::where('chat_id', $chat->id)
            ->where('sender_id', '!=', $user->id)
            ->where('is_read', false)
            ->update(['is_read' => true]);

        if ($updatedCount > 0) {
            try {
                broadcast(new \App\Events\MessageRead($chat->id, $user->id));
            } catch (\Throwable $e) {
                \Illuminate\Support\Facades\Log::error('Pusher Broadcast Error: ' . $e->getMessage());
            }
        }

        return response(['success' => true], 200);
    }

    /**
     * Send a message to a chat room.
     */
    public function sendMessage(Request $request, $id)
    {
        $fields = $request->validate([
            'message' => 'required_without:attachment|nullable|string',
            'attachment' => 'required_without:message|nullable|file|max:10240|mimes:jpg,jpeg,png,gif,webp,pdf',
        ]);

        $chat = Chat::find($id);
        if (!$chat) {
            return response(['message' => 'Chat room not found'], 404);
        }

        $user = $request->user();
        if ($chat->user_one_id !== $user->id && $chat->user_two_id !== $user->id) {
            return response(['message' => 'Unauthorized'], 403);
        }

        $attachmentUrl = null;
        $type = 'text';

        if ($request->hasFile('attachment')) {
            $file = $request->file('attachment');
            $fileName = time() . '_' . uniqid() . '.' . $file->getClientOriginalExtension();
            $path = $file->storeAs('attachments', $fileName, 'public');
            $attachmentUrl = asset('storage/' . $path);
            
            $extension = strtolower($file->getClientOriginalExtension());
            if ($extension === 'pdf') {
                $type = 'pdf';
            } else {
                $type = 'image';
            }
        }

        $message = Message::create([
            'chat_id' => $chat->id,
            'sender_id' => $user->id,
            'message' => $fields['message'] ?? '',
            'type' => $type,
            'attachment_url' => $attachmentUrl,
        ]);

        // Touch the updated_at timestamp on chat
        $chat->touch();

        // Create notification for the receiver using NotificationService
        $recipientId = ($chat->user_one_id === $user->id) ? $chat->user_two_id : $chat->user_one_id;
        $recipient = \App\Models\User::find($recipientId);
        
        if ($recipient) {
            $notificationService = app(\App\Services\NotificationService::class);
            $msgContent = $attachmentUrl ? '[Sent ' . $type . ' attachment]' : substr($fields['message'], 0, 40) . '...';
            $notificationService->notify(
                $recipient,
                'New message from ' . $user->name,
                'Regarding ' . ($chat->property ? $chat->property->title : 'your space') . ': "' . $msgContent . '"',
                'chat',
                false,
                null,
                [],
                ['chat_id' => (string) $chat->id]
            );
        }

        // Broadcast to Pusher Channels safely
        try {
            broadcast(new \App\Events\MessageSent($message->load('sender')));
        } catch (\Throwable $e) {
            \Illuminate\Support\Facades\Log::error('Pusher Broadcast Error: ' . $e->getMessage());
        }

        return response($message, 201);
    }

    /**
     * Update the authenticated user's typing status.
     */
    public function updateTypingStatus(Request $request, $id)
    {
        $fields = $request->validate(['is_typing' => 'required|boolean']);
        $chat = Chat::find($id);
        if (!$chat) {
            return response(['message' => 'Chat room not found'], 404);
        }

        $user = $request->user();
        if ($chat->user_one_id !== $user->id && $chat->user_two_id !== $user->id) {
            return response(['message' => 'Unauthorized'], 403);
        }

        $cacheKey = "chat_{$chat->id}_user_{$user->id}_typing";
        if ($fields['is_typing']) {
            \Illuminate\Support\Facades\Cache::put($cacheKey, true, now()->addSeconds(5));
        } else {
            \Illuminate\Support\Facades\Cache::forget($cacheKey);
        }

        // Broadcast typing event safely
        try {
            broadcast(new \App\Events\UserTyping($chat->id, $fields['is_typing'], $user->name));
        } catch (\Throwable $e) {
            \Illuminate\Support\Facades\Log::error('Pusher Broadcast Error: ' . $e->getMessage());
        }

        return response(['success' => true], 200);
    }

    /**
     * Get the typing status of the other user in the chat room.
     */
    public function getTypingStatus(Request $request, $id)
    {
        $chat = Chat::find($id);
        if (!$chat) {
            return response(['message' => 'Chat room not found'], 404);
        }

        $user = $request->user();
        if ($chat->user_one_id !== $user->id && $chat->user_two_id !== $user->id) {
            return response(['message' => 'Unauthorized'], 403);
        }

        $otherUserId = ($chat->user_one_id === $user->id) ? $chat->user_two_id : $chat->user_one_id;
        $cacheKey = "chat_{$chat->id}_user_{$otherUserId}_typing";
        $isTyping = \Illuminate\Support\Facades\Cache::has($cacheKey);

        $otherUser = \App\Models\User::find($otherUserId);

        return response([
            'is_typing' => $isTyping,
            'user_name' => $otherUser ? $otherUser->name : 'Someone',
        ], 200);
    }

    /**
     * Update the authenticated user's presence status.
     */
    public function updatePresenceStatus(Request $request, $id)
    {
        $fields = $request->validate(['is_online' => 'required|boolean']);
        $chat = Chat::find($id);
        if (!$chat) {
            return response(['message' => 'Chat room not found'], 404);
        }

        $user = $request->user();
        if ($chat->user_one_id !== $user->id && $chat->user_two_id !== $user->id) {
            return response(['message' => 'Unauthorized'], 403);
        }

        // Broadcast presence event safely
        try {
            broadcast(new \App\Events\UserPresence($chat->id, $user->id, $fields['is_online']));
        } catch (\Throwable $e) {
            \Illuminate\Support\Facades\Log::error('Pusher Broadcast Error: ' . $e->getMessage());
        }

        return response(['success' => true], 200);
    }
}
