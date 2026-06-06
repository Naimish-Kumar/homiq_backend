<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Property;
use App\Models\Booking;
use App\Models\Configuration;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AdminDashboardController extends Controller
{
    public function showLogin()
    {
        if (Auth::check()) {
            return Auth::user()->is_admin ? redirect('/admin') : redirect('/dashboard');
        }
        return view('auth.login');
    }

    /**
     * Generate and store a 6-digit email verification OTP.
     */
    private function generateAndStoreOtp(string $email): string
    {
        $code = strval(rand(100000, 999999));

        \Illuminate\Support\Facades\DB::table('email_verification_tokens')->updateOrInsert(
            ['email' => $email],
            [
                'token' => \Illuminate\Support\Facades\Hash::make($code),
                'created_at' => now(),
            ]
        );

        \Illuminate\Support\Facades\Log::info("Web Email verification OTP for {$email}: {$code}");

        // Send actual email OTP
        try {
            \Illuminate\Support\Facades\Mail::raw("Your HomiQ email verification code is: {$code}. This code is valid for 15 minutes.", function ($message) use ($email) {
                $message->to($email)->subject("HomiQ - Email Verification OTP");
            });
        } catch (\Exception $e) {
            \Illuminate\Support\Facades\Log::error("Failed to send OTP email to {$email}: " . $e->getMessage());
        }

        return $code;
    }

    /**
     * Handle authentication attempt.
     */
    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email' => 'required|email',
            'password' => 'required|string',
        ]);

        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();
            $user = Auth::user();

            if ($user->is_admin) {
                return redirect()->intended('/admin');
            }

            if (is_null($user->email_verified_at)) {
                $otp = $this->generateAndStoreOtp($user->email);
                return redirect('/verify-email')->with('success', 'Please verify your email. Code: ' . $otp);
            }

            return redirect()->intended('/dashboard');
        }

        return back()->withErrors([
            'email' => 'The provided credentials do not match our records.',
        ]);
    }

    public function showRegister()
    {
        if (Auth::check()) {
            return Auth::user()->is_admin ? redirect('/admin') : redirect('/dashboard');
        }
        return view('auth.register');
    }

    public function register(Request $request)
    {
        $fields = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users,email',
            'phone' => 'nullable|string|max:20',
            'password' => 'required|string|min:6|confirmed',
        ]);

        $user = User::create([
            'name' => $fields['name'],
            'email' => $fields['email'],
            'phone' => $fields['phone'] ?? null,
            'password' => \Illuminate\Support\Facades\Hash::make($fields['password']),
        ]);

        Auth::login($user);

        $otp = $this->generateAndStoreOtp($user->email);

        return redirect('/verify-email')->with('success', 'Registration successful. Verify your email with OTP: ' . $otp);
    }

    public function showVerifyOtp()
    {
        if (!Auth::check()) {
            return redirect('/login');
        }
        if (Auth::user()->email_verified_at) {
            return redirect('/dashboard');
        }
        return view('auth.verify');
    }

    public function verifyOtp(Request $request)
    {
        $fields = $request->validate([
            'otp' => 'required|string|size:6',
        ]);

        $user = Auth::user();
        $record = \Illuminate\Support\Facades\DB::table('email_verification_tokens')
            ->where('email', $user->email)
            ->first();

        if (!$record) {
            return back()->withErrors(['otp' => 'No verification code found. Please request a new one.']);
        }

        if (now()->diffInMinutes($record->created_at) > 15) {
            \Illuminate\Support\Facades\DB::table('email_verification_tokens')
                ->where('email', $user->email)
                ->delete();
            return back()->withErrors(['otp' => 'Verification code has expired. Please request a new one.']);
        }

        if (!\Illuminate\Support\Facades\Hash::check($fields['otp'], $record->token)) {
            return back()->withErrors(['otp' => 'Invalid verification code.']);
        }

        $user->email_verified_at = now();
        $user->save();

        \Illuminate\Support\Facades\DB::table('email_verification_tokens')
            ->where('email', $user->email)
            ->delete();

        return redirect('/dashboard')->with('success', 'Your email has been verified successfully!');
    }

    public function resendOtpWeb()
    {
        $user = Auth::user();
        if (!$user) {
            return redirect('/login');
        }
        if ($user->email_verified_at) {
            return redirect('/dashboard');
        }

        $otp = $this->generateAndStoreOtp($user->email);
        return back()->with('success', 'A new verification code has been sent. Code: ' . $otp);
    }

    /**
     * Display dashboard stats overview.
     */
    public function index()
    {
        $totalUsers = User::count();
        $totalBookings = Booking::count();
        $totalProperties = Property::count();
        
        $pendingProperties = Property::where('status', 'pending')->count();
        $approvedProperties = Property::where('status', 'approved')->count();
        $rejectedProperties = Property::where('status', 'rejected')->count();

        // Platform fee total
        $totalRevenue = Booking::whereIn('status', ['approved', 'completed'])->sum('platform_fee');

        // Recent bookings
        $recentBookings = Booking::with(['property', 'renter'])->latest()->take(5)->get();

        // Listing volume for the last 7 days
        $listingVolume = [];
        $maxCount = 0;
        $tempVolume = [];
        
        for ($i = 6; $i >= 0; $i--) {
            $date = now()->subDays($i);
            $dayLetter = $date->format('D')[0]; // S, M, T, W, T, F, S
            $count = Property::whereDate('created_at', $date->toDateString())->count();
            
            if ($count > $maxCount) {
                $maxCount = $count;
            }
            
            $tempVolume[] = [
                'letter' => $dayLetter,
                'count' => $count,
            ];
        }

        $divisor = $maxCount > 0 ? $maxCount : 1;
        foreach ($tempVolume as $item) {
            $percentage = round(($item['count'] / $divisor) * 100);
            // Height mapping from 16px to 110px
            $height = $item['count'] > 0 ? (16 + round(($percentage / 100) * 94)) : 0;
            
            $listingVolume[] = [
                'letter' => $item['letter'],
                'count' => $item['count'],
                'percentage' => $percentage,
                'height' => $height,
                'is_max' => $maxCount > 0 && $item['count'] === $maxCount,
            ];
        }

        // Latest users for active administrators / users panel
        $latestUsers = User::latest()->take(3)->get()->map(function ($user) {
            $initials = '';
            $parts = explode(' ', $user->name);
            foreach ($parts as $part) {
                if (!empty($part)) {
                    $initials .= strtoupper($part[0]);
                }
            }
            $user->initials = !empty($initials) ? substr($initials, 0, 2) : 'U';
            
            if ($user->is_admin) {
                $user->display_role = 'Admin';
                $user->role_desc = 'Working on properties moderation';
                $user->badge_class = 'bg-emerald-50 text-emerald-700 border-emerald-100';
            } elseif ($user->is_host) {
                $user->display_role = 'Lister';
                $user->role_desc = 'Active landlord lister profile';
                $user->badge_class = 'bg-slate-100 text-slate-500 border-slate-200';
            } else {
                $user->display_role = 'Renter';
                $user->role_desc = 'Active renter customer profile';
                $user->badge_class = 'bg-slate-100 text-slate-500 border-slate-200';
            }
            return $user;
        });

        return view('admin.index', compact(
            'totalUsers',
            'totalBookings',
            'totalProperties',
            'pendingProperties',
            'approvedProperties',
            'rejectedProperties',
            'totalRevenue',
            'recentBookings',
            'listingVolume',
            'latestUsers'
        ));
    }

    /**
     * Display listings management screen.
     */
    public function properties(Request $request)
    {
        $status = $request->query('status');
        
        $query = Property::with('owner');
        if ($status) {
            $query->where('status', $status);
        }

        $properties = $query->latest()->get();

        return view('admin.properties', compact('properties', 'status'));
    }

    /**
     * Show property details page.
     */
    public function showProperty($id)
    {
        $property = Property::with('owner')->findOrFail($id);
        return view('admin.property-details', compact('property'));
    }

    /**
     * Update status of property listing.
     */
    public function updatePropertyStatus(Request $request, $id)
    {
        $request->validate([
            'status' => 'required|in:approved,rejected,pending',
        ]);

        $property = Property::with('owner')->findOrFail($id);
        $oldStatus = $property->status;
        $property->update([
            'status' => $request->status,
        ]);

        if ($oldStatus !== $request->status && in_array($request->status, ['approved', 'rejected'])) {
            $notificationService = app(\App\Services\NotificationService::class);
            $title = 'Property Listing ' . ucfirst($request->status);
            $message = 'Your property listing "' . $property->title . '" has been ' . $request->status . ' by the administrator.';
            
            $notificationService->notify(
                $property->owner,
                $title,
                $message,
                'info', // notification type
                true, // send email
                \App\Mail\PropertyStatusMail::class,
                [$property->owner->name, $property->title, $request->status]
            );
        }

        return back()->with('success', 'Property status updated to ' . $request->status);
    }

    /**
     * Display users management screen.
     */
    public function users()
    {
        $users = User::withCount(['properties', 'bookings'])->latest()->get();
        return view('admin.users', compact('users'));
    }

    /**
     * Toggle administrator role.
     */
    public function toggleAdmin($id)
    {
        $user = User::findOrFail($id);
        
        // Prevent self-demotion
        if ($user->id === Auth::id()) {
            return back()->withErrors(['error' => 'You cannot change your own admin privileges.']);
        }

        $user->update([
            'is_admin' => !$user->is_admin,
        ]);

        return back()->with('success', 'User privileges updated successfully.');
    }

    /**
     * Change user subscription plan.
     */
    public function changeUserPlan(Request $request, $id)
    {
        $request->validate([
            'subscription_plan' => 'required|in:free,standard,unlimited',
        ]);

        $user = User::findOrFail($id);
        $user->update([
            'subscription_plan' => $request->subscription_plan,
        ]);

        return back()->with('success', 'User subscription plan updated to ' . ucfirst($request->subscription_plan) . ' successfully.');
    }

    /**
     * Delete user account.
     */
    public function deleteUser($id)
    {
        $user = User::findOrFail($id);

        if ($user->id === Auth::id()) {
            return back()->withErrors(['error' => 'You cannot delete your own admin account.']);
        }

        // Cascade delete properties and bookings manually
        $user->properties()->delete();
        $user->bookings()->delete();
        $user->delete();

        return back()->with('success', 'User account and all associated data deleted successfully.');
    }

    /**
     * Store new user.
     */
    public function storeUser(Request $request)
    {
        $fields = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users,email',
            'phone' => 'nullable|string|max:20',
            'subscription_plan' => 'required|in:free,standard,unlimited',
            'is_admin' => 'required|boolean',
            'password' => 'required|string|min:6|confirmed',
        ]);

        User::create([
            'name' => $fields['name'],
            'email' => $fields['email'],
            'phone' => $fields['phone'] ?? null,
            'subscription_plan' => $fields['subscription_plan'],
            'is_admin' => $fields['is_admin'],
            'password' => \Illuminate\Support\Facades\Hash::make($fields['password']),
            'email_verified_at' => now(), // Auto verify admin-created users
        ]);

        return back()->with('success', 'User account created successfully.');
    }

    /**
     * Update user details.
     */
    public function updateUser(Request $request, $id)
    {
        $user = User::findOrFail($id);
        $fields = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users,email,' . $user->id,
            'phone' => 'nullable|string|max:20',
            'subscription_plan' => 'required|in:free,standard,unlimited',
            'is_admin' => 'required|boolean',
            'password' => 'nullable|string|min:6|confirmed',
        ]);

        // Prevent self-demotion via updates
        if ($user->id === Auth::id() && !$fields['is_admin']) {
            return back()->withErrors(['error' => 'You cannot demote yourself from Administrator.']);
        }

        $updateData = [
            'name' => $fields['name'],
            'email' => $fields['email'],
            'phone' => $fields['phone'] ?? null,
            'subscription_plan' => $fields['subscription_plan'],
            'is_admin' => $fields['is_admin'],
        ];

        if (!empty($fields['password'])) {
            $updateData['password'] = \Illuminate\Support\Facades\Hash::make($fields['password']);
        }

        $user->update($updateData);

        return back()->with('success', 'User account updated successfully.');
    }

    /**
     * Display settings list.
     */
    public function settings()
    {
        $pages = \App\Models\Page::all();
        return view('admin.settings.index', compact('pages'));
    }

    /**
     * Edit page screen.
     */
    public function editPage($slug)
    {
        $page = \App\Models\Page::where('slug', $slug)->firstOrFail();
        return view('admin.settings.edit', compact('page'));
    }

    /**
     * Update page content.
     */
    public function updatePage(Request $request, $slug)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'content' => 'nullable|string',
        ]);

        $page = \App\Models\Page::where('slug', $slug)->firstOrFail();
        $page->update([
            'title' => $request->title,
            'content' => $request->content,
        ]);

        return redirect('/admin/settings')->with('success', 'Page content updated successfully.');
    }

    /**
     * Show admin profile edit form.
     */
    public function profile()
    {
        $user = Auth::user();
        return view('admin.profile', compact('user'));
    }

    /**
     * Update admin profile details.
     */
    public function updateProfile(Request $request)
    {
        $user = Auth::user();
        $fields = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users,email,' . $user->id,
            'phone' => 'nullable|string|max:20',
            'profile_photo' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'password' => 'nullable|string|min:6|confirmed',
        ]);

        $updateData = [
            'name' => $fields['name'],
            'email' => $fields['email'],
            'phone' => $fields['phone'] ?? null,
        ];

        if ($request->hasFile('profile_photo')) {
            $file = $request->file('profile_photo');
            $filename = time() . '_' . $file->getClientOriginalName();
            
            // Ensure directory exists
            if (!file_exists(public_path('uploads/avatars'))) {
                mkdir(public_path('uploads/avatars'), 0755, true);
            }
            
            $file->move(public_path('uploads/avatars'), $filename);
            $updateData['profile_photo'] = '/uploads/avatars/' . $filename;
        }

        if (!empty($fields['password'])) {
            $updateData['password'] = \Illuminate\Support\Facades\Hash::make($fields['password']);
        }

        $user->update($updateData);

        return back()->with('success', 'Profile updated successfully.');
    }

    /**
     * Handle logout.
     */
    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/login');
    }

    /**
     * Display configuration settings.
     */
    public function config()
    {
        $configs = Configuration::all();
        $groups = $configs->groupBy('group');
        return view('admin.config', compact('groups'));
    }

    /**
     * Update configuration settings.
     */
    public function updateConfig(Request $request)
    {
        $configs = Configuration::all();
        
        foreach ($configs as $config) {
            if ($request->has($config->key)) {
                $config->update([
                    'value' => $request->input($config->key)
                ]);
            }
        }

        return back()->with('success', 'Configurations updated successfully.');
    }

    /**
     * Delete property listing.
     */
    public function deleteProperty($id)
    {
        $property = Property::findOrFail($id);

        // Delete associated bookings
        $property->bookings()->delete();

        // Delete property
        $property->delete();

        return redirect('/admin/properties')->with('success', 'Property listing deleted successfully.');
    }

    /**
     * Show edit property form.
     */
    public function editProperty($id)
    {
        $property = Property::findOrFail($id);
        
        // Fetch categories dynamically from database configurations
        $configs = Configuration::where('group', 'listing')->pluck('value', 'key');
        
        $categoriesList = array_map('trim', explode(',', $configs->get('listing_categories', 'Apartment,House,Villa,Studio,PG,Room,Shop,Hall')));
        
        return view('admin.property-edit', compact('property', 'categoriesList'));
    }

    /**
     * Update property details.
     */
    public function updateProperty(Request $request, $id)
    {
        $property = Property::findOrFail($id);

        $fields = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'price' => 'required|numeric|min:0',
            'address' => 'required|string|max:255',
            'bedrooms' => 'required|integer|min:0',
            'bathrooms' => 'required|integer|min:0',
            'category' => 'required|string',
            'is_furnished' => 'required|boolean',
            'has_parking' => 'required|boolean',
            'is_pet_friendly' => 'required|boolean',
        ]);

        $property->update($fields);

        return redirect('/admin/properties/' . $id)->with('success', 'Property details updated successfully.');
    }
}

