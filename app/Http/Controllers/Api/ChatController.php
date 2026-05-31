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
        Message::where('chat_id', $chat->id)
            ->where('sender_id', '!=', $user->id)
            ->update(['is_read' => true]);

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
     * Send a message to a chat room.
     */
    public function sendMessage(Request $request, $id)
    {
        $fields = $request->validate([
            'message' => 'required|string',
        ]);

        $chat = Chat::find($id);
        if (!$chat) {
            return response(['message' => 'Chat room not found'], 404);
        }

        $user = $request->user();
        if ($chat->user_one_id !== $user->id && $chat->user_two_id !== $user->id) {
            return response(['message' => 'Unauthorized'], 403);
        }

        $message = Message::create([
            'chat_id' => $chat->id,
            'sender_id' => $user->id,
            'message' => $fields['message'],
            'type' => 'text',
        ]);

        // Touch the updated_at timestamp on chat
        $chat->touch();

        // Create notification for the receiver using NotificationService
        $recipientId = ($chat->user_one_id === $user->id) ? $chat->user_two_id : $chat->user_one_id;
        $recipient = \App\Models\User::find($recipientId);
        
        if ($recipient) {
            $notificationService = app(\App\Services\NotificationService::class);
            $notificationService->notify(
                $recipient,
                'New message from ' . $user->name,
                'Regarding ' . ($chat->property ? $chat->property->title : 'your space') . ': "' . substr($fields['message'], 0, 40) . '..."',
                'chat'
            );
        }

        return response($message->load('sender'), 201);
    }
}
