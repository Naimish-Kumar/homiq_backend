<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Models\Property;
use App\Models\Booking;
use App\Models\User;
use App\Models\Chat;
use App\Models\Message;
use App\Models\Notification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class WebHomeController extends Controller
{
    /**
     * Display public landing feed.
     */
    public function index(Request $request)
    {
        $search = $request->query('search');
        $lat = $request->query('latitude');
        $lng = $request->query('longitude');

        $query = Property::with('owner')->where('status', 'approved');

        if ($search) {
            $query->where(function ($q) use ($search) {
                $q->where('title', 'like', "%{$search}%")
                  ->orWhere('address', 'like', "%{$search}%");
            });
        }

        if ($lat && $lng) {
            $query->selectRaw("*, (6371 * acos(cos(radians(?)) * cos(radians(latitude)) * cos(radians(longitude) - radians(?)) + sin(radians(?)) * sin(radians(latitude)))) AS distance", [$lat, $lng, $lat])
                  ->orderBy('distance');
        } else {
            $query->latest();
        }

        $properties = $query->get();
        $categories = \App\Models\Category::all()->map(function ($cat) {
            $image = $cat->image;
            if ($image && !str_starts_with($image, 'http://') && !str_starts_with($image, 'https://')) {
                $image = asset($image);
            }
            return [
                'name' => $cat->name,
                'image' => $image ?? 'https://images.unsplash.com/photo-1564013799919-ab600027ffc6?auto=format&fit=crop&w=350&q=80',
            ];
        })->toArray();

        return view('home', compact('properties', 'categories', 'search'));
    }

    /**
     * Show properties of a specific category.
     */
    public function category($name)
    {
        $properties = Property::with('owner')
            ->where('status', 'approved')
            ->where('category', $name)
            ->latest()
            ->get();

        $categories = \App\Models\Category::all()->map(function ($cat) {
            $image = $cat->image;
            if ($image && !str_starts_with($image, 'http://') && !str_starts_with($image, 'https://')) {
                $image = asset($image);
            }
            return [
                'name' => $cat->name,
                'image' => $image ?? 'https://images.unsplash.com/photo-1564013799919-ab600027ffc6?auto=format&fit=crop&w=350&q=80',
            ];
        })->toArray();

        return view('category', compact('properties', 'name', 'categories'));
    }

    /**
     * Show property details.
     */
    public function property($id)
    {
        $property = Property::with('owner')->findOrFail($id);
        return view('property', compact('property'));
    }

    /**
     * Display subscription packages.
     */
    public function pricing()
    {
        return view('pricing');
    }

    /**
     * Process subscription purchase (mock action).
     */
    public function upgradeSubscription(Request $request)
    {
        $request->validate([
            'plan' => 'required|in:free,standard,unlimited',
        ]);

        $user = Auth::user();
        $user->update([
            'subscription_plan' => $request->plan,
        ]);

        return redirect('/dashboard')->with('success', 'Your subscription has been successfully upgraded to the ' . ucfirst($request->plan) . ' plan!');
    }

    /**
     * Render the chat interface.
     */
    public function chat(Request $request)
    {
        $user = Auth::user();

        // If property_id parameter is passed, find or create the chat between seeker and owner
        $propertyId = $request->query('property_id');
        if ($propertyId) {
            $property = Property::findOrFail($propertyId);
            if ($property->owner_id === $user->id) {
                return redirect('/chat')->withErrors(['error' => 'You cannot chat with yourself about your own listing.']);
            }
            
            // Find or create chat room
            $chat = Chat::firstOrCreate([
                'user_one_id' => $user->id,
                'user_two_id' => $property->owner_id,
                'property_id' => $property->id,
            ]);
            
            // Create a system welcome message if the chat is brand new and empty
            if ($chat->messages()->count() === 0) {
                Message::create([
                    'chat_id' => $chat->id,
                    'sender_id' => $property->owner_id, // welcome/system context
                    'message' => "Hello! Thanks for your interest in my space '{$property->title}'. How can I help you?",
                    'type' => 'text',
                ]);
            }

            return redirect('/chat?chat_id=' . $chat->id);
        }

        // Tab 1: Current user's queries on other's properties (user_one = Auth::id)
        $myQueries = Chat::where('user_one_id', $user->id)
            ->with(['userTwo', 'property', 'messages.sender'])
            ->latest()
            ->get();

        // Tab 2: Other's queries on current user's properties (user_two = Auth::id)
        $othersQueries = Chat::where('user_two_id', $user->id)
            ->with(['userOne', 'property', 'messages.sender'])
            ->latest()
            ->get();

        // Determine active chat
        $activeChat = null;
        $activeChatId = $request->query('chat_id');
        if ($activeChatId) {
            $activeChat = Chat::with(['userOne', 'userTwo', 'property', 'messages.sender'])
                ->where(function ($q) use ($user) {
                    $q->where('user_one_id', $user->id)
                      ->orWhere('user_two_id', $user->id);
                })
                ->find($activeChatId);
        }

        if (!$activeChat) {
            // Default to first chat available
            $activeChat = $myQueries->first() ?? $othersQueries->first();
        }

        // Mark active chat messages as read
        if ($activeChat) {
            Message::where('chat_id', $activeChat->id)
                ->where('sender_id', '!=', $user->id)
                ->update(['is_read' => true]);

            // Broadcast presence safely
            try {
                broadcast(new \App\Events\UserPresence($activeChat->id, $user->id, true));
            } catch (\Throwable $e) {
                \Illuminate\Support\Facades\Log::error('Pusher Broadcast Error: ' . $e->getMessage());
            }
        }

        return view('chat', compact('myQueries', 'othersQueries', 'activeChat'));
    }

    /**
     * Send a chat message.
     */
    public function sendChatMessage(Request $request)
    {
        $request->validate([
            'chat_id' => 'required|exists:chats,id',
            'message' => 'required_without:attachment|nullable|string',
            'attachment' => 'required_without:message|nullable|file|max:10240|mimes:jpg,jpeg,png,gif,webp,pdf',
        ]);

        $chat = Chat::findOrFail($request->chat_id);
        $user = Auth::user();

        if ($chat->user_one_id !== $user->id && $chat->user_two_id !== $user->id) {
            abort(403, 'Unauthorized');
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
            'message' => $request->message ?? '',
            'type' => $type,
            'attachment_url' => $attachmentUrl,
        ]);

        // Touch the updated_at timestamp on chat
        $chat->touch();

        // Create a notification for the other user
        $recipientId = ($chat->user_one_id === $user->id) ? $chat->user_two_id : $chat->user_one_id;
        $recipient = User::find($recipientId);
        if ($recipient) {
            $notificationService = app(\App\Services\NotificationService::class);
            $msgContent = $attachmentUrl ? '[Sent ' . $type . ' attachment]' : substr($request->message, 0, 40) . '...';
            $notificationService->notify(
                $recipient,
                'New Message from ' . $user->name,
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

        if ($request->expectsJson() || $request->wantsJson() || $request->ajax()) {
            return response()->json($message, 201);
        }

        return redirect('/chat?chat_id=' . $chat->id);
    }

    /**
     * Update the authenticated user's typing status.
     */
    public function updateTypingStatus(Request $request, $id)
    {
        $request->validate(['is_typing' => 'required|boolean']);
        $chat = Chat::findOrFail($id);
        $user = Auth::user();

        if ($chat->user_one_id !== $user->id && $chat->user_two_id !== $user->id) {
            return response()->json(['message' => 'Unauthorized'], 403);
        }

        $cacheKey = "chat_{$chat->id}_user_{$user->id}_typing";
        if ($request->is_typing) {
            \Illuminate\Support\Facades\Cache::put($cacheKey, true, now()->addSeconds(5));
        } else {
            \Illuminate\Support\Facades\Cache::forget($cacheKey);
        }

        // Broadcast typing event safely
        try {
            broadcast(new \App\Events\UserTyping($chat->id, $request->is_typing, $user->name));
        } catch (\Throwable $e) {
            \Illuminate\Support\Facades\Log::error('Pusher Broadcast Error: ' . $e->getMessage());
        }

        return response()->json(['success' => true]);
    }

    /**
     * Update the authenticated user's presence status.
     */
    public function updatePresenceStatus(Request $request, $id)
    {
        $request->validate(['is_online' => 'required|boolean']);
        $chat = Chat::findOrFail($id);
        $user = Auth::user();

        if ($chat->user_one_id !== $user->id && $chat->user_two_id !== $user->id) {
            return response()->json(['message' => 'Unauthorized'], 403);
        }

        // Broadcast presence event safely
        try {
            broadcast(new \App\Events\UserPresence($chat->id, $user->id, $request->is_online));
        } catch (\Throwable $e) {
            \Illuminate\Support\Facades\Log::error('Pusher Broadcast Error: ' . $e->getMessage());
        }

        return response()->json(['success' => true]);
    }

    /**
     * Get the typing status of the other user in the chat room.
     */
    public function getTypingStatus($id)
    {
        $chat = Chat::findOrFail($id);
        $user = Auth::user();

        if ($chat->user_one_id !== $user->id && $chat->user_two_id !== $user->id) {
            return response()->json(['message' => 'Unauthorized'], 403);
        }

        $otherUserId = ($chat->user_one_id === $user->id) ? $chat->user_two_id : $chat->user_one_id;
        $cacheKey = "chat_{$chat->id}_user_{$otherUserId}_typing";
        $isTyping = \Illuminate\Support\Facades\Cache::has($cacheKey);

        $otherUser = User::find($otherUserId);

        return response()->json([
            'is_typing' => $isTyping,
            'user_name' => $otherUser ? $otherUser->name : 'Someone',
        ]);
    }

    /**
     * Mark all notifications for the user as read.
     */
    public function readAllNotifications(Request $request)
    {
        Notification::where('user_id', Auth::id())->update(['is_read' => true]);
        return back()->with('success', 'All notifications marked as read!');
    }

    public function about()
    {
        $page = \App\Models\Page::where('slug', 'about')->firstOrFail();
        return view('about', compact('page'));
    }

    public function privacy()
    {
        $page = \App\Models\Page::where('slug', 'privacy')->firstOrFail();
        return view('privacy', compact('page'));
    }

    public function terms()
    {
        $page = \App\Models\Page::where('slug', 'terms')->firstOrFail();
        return view('terms', compact('page'));
    }

    public function showDeleteAccount()
    {
        return view('auth.delete-account');
    }

    public function deleteAccount(Request $request)
    {
        $request->validate([
            'email' => 'required|email|exists:users,email',
            'password' => 'required|string',
        ]);

        $user = User::where('email', $request->email)->first();

        if (!\Illuminate\Support\Facades\Hash::check($request->password, $user->password)) {
            return back()->withErrors(['password' => 'The provided password does not match our records.']);
        }

        // Cascade delete user listings and reservations to avoid integrity issues
        $user->properties()->delete();
        $user->bookings()->delete();

        // Logout if it's the current user
        if (Auth::check() && Auth::id() === $user->id) {
            Auth::logout();
            $request->session()->invalidate();
            $request->session()->regenerateToken();
        }

        $user->delete();

        return redirect('/delete-account')->with('success', 'Your account deleted successfully.');
    }
}
