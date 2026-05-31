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

        $query = Property::with('owner')->where('status', 'approved');

        if ($search) {
            $query->where(function ($q) use ($search) {
                $q->where('title', 'like', "%{$search}%")
                  ->orWhere('address', 'like', "%{$search}%");
            });
        }

        $properties = $query->latest()->get();
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
            'message' => 'required|string',
        ]);

        $chat = Chat::findOrFail($request->chat_id);
        $user = Auth::user();

        if ($chat->user_one_id !== $user->id && $chat->user_two_id !== $user->id) {
            abort(403, 'Unauthorized');
        }

        $message = Message::create([
            'chat_id' => $chat->id,
            'sender_id' => $user->id,
            'message' => $request->message,
            'type' => 'text',
        ]);

        // Create a notification for the other user
        $recipientId = ($chat->user_one_id === $user->id) ? $chat->user_two_id : $chat->user_one_id;
        Notification::create([
            'user_id' => $recipientId,
            'title' => 'New Message from ' . $user->name,
            'message' => 'Regarding ' . ($chat->property ? $chat->property->title : 'your space') . ': "' . substr($request->message, 0, 40) . '..."',
            'type' => 'chat',
        ]);

        return redirect('/chat?chat_id=' . $chat->id);
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
}
