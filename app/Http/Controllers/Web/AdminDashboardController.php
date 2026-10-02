<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Property;
use App\Models\Booking;
use App\Models\Configuration;
use App\Models\PropertyRequest;
use App\Models\Notification;
use App\Models\NotificationBroadcast;
use App\Services\FcmService;
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
            \Illuminate\Support\Facades\Mail::send('emails.email-otp', ['code' => $code], function ($message) use ($email) {
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
            'referral_code' => 'nullable|string|exists:users,referral_code',
        ]);

        $referrer = !empty($fields['referral_code']) ? User::where('referral_code', $fields['referral_code'])->first() : null;

        $user = User::create([
            'name' => $fields['name'],
            'email' => $fields['email'],
            'phone' => $fields['phone'] ?? null,
            'password' => \Illuminate\Support\Facades\Hash::make($fields['password']),
            'referred_by_id' => $referrer?->id,
        ]);

        if ($referrer && $referrer->id !== $user->id) {
            app(\App\Services\ReferralService::class)->rewardSignup($user, $referrer);
        }

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

        $recentFeedbacks = \App\Models\Feedback::with('user')->latest()->take(5)->get();
        $pendingKycCount = User::where('kyc_status', 'pending')->count();
        $pendingKycUsers = User::where('kyc_status', 'pending')->latest()->take(5)->get();

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
            'latestUsers',
            'recentFeedbacks',
            'pendingKycCount',
            'pendingKycUsers'
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
     * Update status of single property listing with optional rejection reason and notes.
     */
    public function updatePropertyStatus(Request $request, $id)
    {
        $request->validate([
            'status' => 'required|in:approved,rejected,pending',
            'rejection_reason' => 'nullable|string|max:255',
            'rejection_notes' => 'nullable|string|max:1000',
            'notify_owner' => 'nullable|boolean',
        ]);

        $property = Property::with('owner')->findOrFail($id);
        $oldStatus = $property->status;
        $newStatus = $request->status;

        $property->update([
            'status' => $newStatus,
        ]);

        $rejectionReason = $request->input('rejection_reason');
        $rejectionNotes = $request->input('rejection_notes');
        $notifyOwner = $request->boolean('notify_owner', true);

        if ($oldStatus !== $newStatus && in_array($newStatus, ['approved', 'rejected'])) {
            if ($notifyOwner && $property->owner) {
                $notificationService = app(\App\Services\NotificationService::class);
                $title = 'Property Listing ' . ucfirst($newStatus);
                $message = ($newStatus === 'approved')
                    ? 'Your property listing "' . $property->title . '" has been approved and is now live on HomiQ.'
                    : 'Your property listing "' . $property->title . '" was rejected: ' . ($rejectionReason ?: 'Please inspect the community guidelines and resubmit.');

                $notificationService->notify(
                    $property->owner,
                    $title,
                    $message,
                    'info',
                    true,
                    \App\Mail\PropertyStatusMail::class,
                    [$property->owner->name, $property->title, $newStatus, $rejectionReason, $rejectionNotes]
                );
            }

            if ($newStatus === 'approved') {
                event(new \App\Events\PropertyApproved($property));
            }
        }

        return back()->with('success', 'Property status updated to ' . $newStatus);
    }

    /**
     * Handle bulk property moderation actions (approve, reject, delete, feature, unfeature).
     */
    public function bulkPropertyStatus(Request $request)
    {
        $request->validate([
            'action' => 'required|in:approve,reject,delete,feature,unfeature',
            'property_ids' => 'required|array|min:1',
            'property_ids.*' => 'exists:properties,id',
            'rejection_reason' => 'nullable|string|max:255',
            'rejection_notes' => 'nullable|string|max:1000',
            'notify_owner' => 'nullable|boolean',
        ]);

        $action = $request->action;
        $propertyIds = $request->property_ids;
        $rejectionReason = $request->input('rejection_reason');
        $rejectionNotes = $request->input('rejection_notes');
        $notifyOwner = $request->boolean('notify_owner', true);
        $count = count($propertyIds);

        if ($action === 'delete') {
            Property::whereIn('id', $propertyIds)->delete();
            return back()->with('success', "{$count} properties deleted successfully.");
        }

        if ($action === 'feature') {
            Property::whereIn('id', $propertyIds)->update(['is_featured' => true]);
            return back()->with('success', "{$count} properties marked as featured.");
        }

        if ($action === 'unfeature') {
            Property::whereIn('id', $propertyIds)->update(['is_featured' => false]);
            return back()->with('success', "{$count} properties removed from featured.");
        }

        $newStatus = ($action === 'approve') ? 'approved' : 'rejected';
        $properties = Property::with('owner')->whereIn('id', $propertyIds)->get();
        $notificationService = app(\App\Services\NotificationService::class);

        foreach ($properties as $property) {
            $oldStatus = $property->status;
            $property->update(['status' => $newStatus]);

            if ($notifyOwner && $property->owner && $oldStatus !== $newStatus) {
                $title = 'Property Listing ' . ucfirst($newStatus);
                $msg = ($newStatus === 'approved')
                    ? 'Your property listing "' . $property->title . '" has been approved and is now live on HomiQ.'
                    : 'Your property listing "' . $property->title . '" was rejected: ' . ($rejectionReason ?: 'Please review the listing guidelines and resubmit.');

                $notificationService->notify(
                    $property->owner,
                    $title,
                    $msg,
                    'info',
                    true,
                    \App\Mail\PropertyStatusMail::class,
                    [$property->owner->name, $property->title, $newStatus, $rejectionReason, $rejectionNotes]
                );

                if ($newStatus === 'approved') {
                    event(new \App\Events\PropertyApproved($property));
                }
            }
        }

        return back()->with('success', "{$count} properties have been {$newStatus} successfully.");
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
     * Approve user KYC document.
     */
    public function verifyKyc($id)
    {
        $user = User::findOrFail($id);
        $user->update([
            'kyc_status' => 'verified',
            'is_verified' => true,
        ]);

        // Notify user via app system notification
        try {
            $notificationService = app(\App\Services\NotificationService::class);
            $notificationService->notify(
                $user,
                'KYC Status: Verified',
                'Congratulations! Your KYC documents have been reviewed and approved by our team.',
                'info',
                false // don't send email
            );
        } catch (\Exception $e) {
            \Illuminate\Support\Facades\Log::warning("Failed to notify user $id of KYC approval: " . $e->getMessage());
        }

        return back()->with('success', 'User KYC has been verified successfully.');
    }

    /**
     * Reject user KYC document.
     */
    public function rejectKyc($id)
    {
        $user = User::findOrFail($id);
        $user->update([
            'kyc_status' => 'rejected',
            'is_verified' => false,
        ]);

        // Notify user via app system notification
        try {
            $notificationService = app(\App\Services\NotificationService::class);
            $notificationService->notify(
                $user,
                'KYC Status: Rejected',
                'Your KYC documents could not be verified. Please re-upload a clear government-issued ID.',
                'warning',
                false
            );
        } catch (\Exception $e) {
            \Illuminate\Support\Facades\Log::warning("Failed to notify user $id of KYC rejection: " . $e->getMessage());
        }

        return back()->with('success', 'User KYC has been rejected.');
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
            'bedrooms' => 'nullable|integer|min:0',
            'bathrooms' => 'nullable|integer|min:0',
            'category' => 'required|string',
            'is_furnished' => 'required|boolean',
            'has_parking' => 'required|boolean',
            'is_pet_friendly' => 'required|boolean',
            'currency' => 'nullable|string|in:INR,USD,EUR,GBP',
            'billing_frequency' => 'nullable|string|in:monthly,per_day,hourly',
            'country' => 'nullable|string|max:255',
            'listing_type' => 'nullable|string|in:rent,sale',
            'property_age' => 'nullable|string|max:255',
            'ownership_type' => 'nullable|string|max:255',
            'built_up_area' => 'nullable|integer|min:0',
            'is_negotiable' => 'required|boolean',
            'is_rera_approved' => 'required|boolean',
            'security_deposit' => 'nullable|numeric|min:0',
            'lease_duration' => 'nullable|string|max:255',
            'available_from' => 'nullable|date',
            'floor_number' => 'nullable|integer',
            'total_floors' => 'nullable|integer',
            'facing_direction' => 'nullable|string|max:255',
            'carpet_area' => 'nullable|integer|min:0',
            'preferred_tenant' => 'nullable|string|max:255',
            'supports_group_renting' => 'required|boolean',
            'group_max_size' => 'nullable|integer|min:2|max:10',
            'boundary_wall' => 'required|boolean',
            'plot_area' => 'nullable|numeric|min:0',
        ]);

        $fields['currency'] = $request->input('currency') ?: 'INR';
        $fields['billing_frequency'] = $request->input('billing_frequency') ?: 'monthly';
        $fields['country'] = $request->input('country') ?: 'India';
        $fields['listing_type'] = $request->input('listing_type') ?: 'rent';

        $property->update($fields);

        return redirect('/admin/properties/' . $id)->with('success', 'Property details updated successfully.');
    }

    /**
     * Toggle the featured status of a property listing by Admin.
     */
    public function toggleFeatured(Request $request, $id)
    {
        $property = Property::findOrFail($id);
        $property->update([
            'is_featured' => !$property->is_featured,
        ]);

        $statusMessage = $property->is_featured ? 'marked as Featured!' : 'removed from Featured!';
        return back()->with('success', "Property '{$property->title}' has been successfully {$statusMessage}");
    }

    /**
     * Display feedbacks list.
     */
    public function feedbacks()
    {
        $feedbacks = \App\Models\Feedback::with('user')->latest()->get();
        return view('admin.feedbacks', compact('feedbacks'));
    }

    /**
     * Display comprehensive Financial Analytics & Revenue Breakdown.
     */
    public function financials(Request $request)
    {
        // 1. Core KPIs
        $totalBookingsCount = Booking::count();
        $approvedBookings = Booking::whereIn('status', ['approved', 'completed']);
        $grossVolume = (clone $approvedBookings)->sum('total_price');
        $commissionRevenue = $grossVolume * 0.05;

        // Subscriptions
        $standardUsersCount = User::where('subscription_plan', 'standard')->count();
        $unlimitedUsersCount = User::where('subscription_plan', 'unlimited')->count();
        $subscriptionRevenue = ($standardUsersCount * 499) + ($unlimitedUsersCount * 999);

        $netRevenue = $commissionRevenue + $subscriptionRevenue;
        $approvedCount = (clone $approvedBookings)->count();
        $avgDealValue = $approvedCount > 0 ? $grossVolume / $approvedCount : 0;

        // 2. Monthly Timeline (Last 6 Months)
        $monthlyLabels = [];
        $monthlyGross = [];
        $monthlyNet = [];

        for ($i = 5; $i >= 0; $i--) {
            $monthStart = now()->subMonths($i)->startOfMonth();
            $monthEnd = now()->subMonths($i)->endOfMonth();
            $monthName = $monthStart->format('M Y');
            
            $monthGtv = Booking::whereIn('status', ['approved', 'completed'])
                ->whereBetween('created_at', [$monthStart, $monthEnd])
                ->sum('total_price');

            $monthNet = $monthGtv * 0.05;

            $monthlyLabels[] = $monthName;
            $monthlyGross[] = round((float) $monthGtv, 2);
            $monthlyNet[] = round((float) $monthNet, 2);
        }

        // 3. Top Generating Cities Breakdown
        $cityStats = Property::join('bookings', 'properties.id', '=', 'bookings.property_id')
            ->whereIn('bookings.status', ['approved', 'completed'])
            ->selectRaw('properties.address, SUM(bookings.total_price) as city_volume, COUNT(bookings.id) as bookings_count')
            ->groupBy('properties.address')
            ->orderByDesc('city_volume')
            ->take(5)
            ->get();

        // 4. Paginated Financial Transactions
        $query = Booking::with(['property.owner', 'renter'])->latest();
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }
        $transactions = $query->paginate(15)->withQueryString();

        return view('admin.financials', compact(
            'grossVolume',
            'netRevenue',
            'commissionRevenue',
            'subscriptionRevenue',
            'standardUsersCount',
            'unlimitedUsersCount',
            'avgDealValue',
            'totalBookingsCount',
            'monthlyLabels',
            'monthlyGross',
            'monthlyNet',
            'cityStats',
            'transactions'
        ));
    }

    /**
     * List all referral withdrawal requests.
     */
    public function withdrawals(Request $request)
    {
        $query = \App\Models\WithdrawalRequest::with('user')->latest();

        if ($request->filled('status') && $request->status !== 'all') {
            $query->where('status', $request->status);
        }

        if ($request->filled('method') && $request->method !== 'all') {
            $query->where('payout_method', $request->method);
        }

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('upi_id', 'like', "%{$search}%")
                  ->orWhere('account_holder_name', 'like', "%{$search}%")
                  ->orWhere('account_number', 'like', "%{$search}%")
                  ->orWhere('transaction_reference', 'like', "%{$search}%")
                  ->orWhereHas('user', function ($uq) use ($search) {
                      $uq->where('name', 'like', "%{$search}%")
                         ->orWhere('email', 'like', "%{$search}%")
                         ->orWhere('phone', 'like', "%{$search}%");
                  });
            });
        }

        $withdrawals = $query->paginate(20)->withQueryString();

        $pendingCount = \App\Models\WithdrawalRequest::where('status', 'pending')->count();
        $approvedCount = \App\Models\WithdrawalRequest::where('status', 'approved')->count();
        $rejectedCount = \App\Models\WithdrawalRequest::where('status', 'rejected')->count();
        $totalPaidAmount = \App\Models\WithdrawalRequest::where('status', 'approved')->sum('amount');

        return view('admin.withdrawals', compact(
            'withdrawals',
            'pendingCount',
            'approvedCount',
            'rejectedCount',
            'totalPaidAmount'
        ));
    }

    /**
     * Approve and mark a referral withdrawal request as paid.
     */
    public function approveWithdrawal(Request $request, $id)
    {
        $withdrawal = \App\Models\WithdrawalRequest::with('user')->findOrFail($id);

        if ($withdrawal->status !== 'pending') {
            return back()->with('error', 'This withdrawal request has already been processed.');
        }

        $ref = $request->input('transaction_reference') ?: 'TXN-' . strtoupper(\Illuminate\Support\Str::random(10));

        $withdrawal->update([
            'status' => 'approved',
            'transaction_reference' => $ref,
            'admin_notes' => $request->input('admin_notes'),
            'processed_at' => now(),
        ]);

        // Update transaction status
        \App\Models\ReferralTransaction::where('withdrawal_request_id', $withdrawal->id)
            ->update(['status' => 'completed']);

        // Send push/in-app notification to user
        try {
            $notificationService = app(\App\Services\NotificationService::class);
            $notificationService->notify(
                $withdrawal->user,
                'Withdrawal Processed! 💸',
                "Your withdrawal request for ₹{$withdrawal->amount} via " . strtoupper($withdrawal->payout_method) . " has been approved and paid. Ref: {$ref}",
                'success'
            );
        } catch (\Exception $e) {
            // fallback
        }

        return back()->with('success', "Withdrawal #{$withdrawal->id} of ₹{$withdrawal->amount} marked as approved.");
    }

    /**
     * Reject a withdrawal request and refund balance to user.
     */
    public function rejectWithdrawal(Request $request, $id)
    {
        $withdrawal = \App\Models\WithdrawalRequest::with('user')->findOrFail($id);

        if ($withdrawal->status !== 'pending') {
            return back()->with('error', 'This withdrawal request has already been processed.');
        }

        $reason = $request->input('admin_notes') ?: 'Details provided were invalid or rejected by bank.';

        \Illuminate\Support\Facades\DB::transaction(function () use ($withdrawal, $reason) {
            // Mark withdrawal rejected
            $withdrawal->update([
                'status' => 'rejected',
                'admin_notes' => $reason,
                'processed_at' => now(),
            ]);

            // Update original debit transaction
            \App\Models\ReferralTransaction::where('withdrawal_request_id', $withdrawal->id)
                ->update(['status' => 'rejected']);

            // Refund balance to user
            $user = $withdrawal->user;
            $user->increment('referral_balance', $withdrawal->amount);

            // Create refund credit transaction
            \App\Models\ReferralTransaction::create([
                'user_id' => $user->id,
                'amount' => $withdrawal->amount,
                'type' => 'refund',
                'description' => "Refund: Withdrawal #{$withdrawal->id} rejected ({$reason})",
                'withdrawal_request_id' => $withdrawal->id,
                'status' => 'completed',
            ]);
        });

        // Send notification to user
        try {
            $notificationService = app(\App\Services\NotificationService::class);
            $notificationService->notify(
                $withdrawal->user,
                'Withdrawal Request Update',
                "Your withdrawal request of ₹{$withdrawal->amount} could not be processed: {$reason}. The amount has been refunded back to your referral wallet.",
                'warning'
            );
        } catch (\Exception $e) {
            // fallback
        }

        return back()->with('success', "Withdrawal #{$withdrawal->id} rejected and ₹{$withdrawal->amount} refunded to user wallet.");
    }

    /**
     * Export all transaction ledgers to CSV.
     */
    public function exportTransactionsCsv(Request $request)
    {
        $fileName = 'homiq-transactions-' . now()->format('Y-m-d_His') . '.csv';

        $headers = [
            'Content-Type' => 'text/csv',
            'Content-Disposition' => "attachment; filename=\"$fileName\"",
            'Pragma' => 'no-cache',
            'Cache-Control' => 'must-revalidate, post-check=0, pre-check=0',
            'Expires' => '0',
        ];

        $callback = function () {
            $file = fopen('php://output', 'w');
            fputcsv($file, [
                'Booking ID',
                'Property Title',
                'Category',
                'Property Address',
                'Renter Name',
                'Renter Email',
                'Renter Phone',
                'Host Name',
                'Host Email',
                'Base Rent (INR)',
                'Platform Fee (INR)',
                'Taxes (INR)',
                'Total Price (INR)',
                'Platform Commission 5% (INR)',
                'Check-in Date',
                'Check-out Date',
                'Status',
                'Created At'
            ]);

            Booking::with(['property.owner', 'renter'])->chunk(200, function ($bookings) use ($file) {
                foreach ($bookings as $b) {
                    $commission = round($b->total_price * 0.05, 2);
                    fputcsv($file, [
                        $b->id,
                        $b->property->title ?? 'N/A',
                        $b->property->category ?? 'N/A',
                        $b->property->address ?? 'N/A',
                        $b->renter->name ?? 'N/A',
                        $b->renter->email ?? 'N/A',
                        $b->renter->phone ?? 'N/A',
                        $b->property->owner->name ?? 'N/A',
                        $b->property->owner->email ?? 'N/A',
                        $b->base_rent,
                        $b->platform_fee,
                        $b->taxes,
                        $b->total_price,
                        $commission,
                        $b->check_in ? $b->check_in->format('Y-m-d') : 'N/A',
                        $b->check_out ? $b->check_out->format('Y-m-d') : 'N/A',
                        ucfirst($b->status),
                        $b->created_at ? $b->created_at->format('Y-m-d H:i:s') : 'N/A',
                    ]);
                }
            });

            fclose($file);
        };

        return response()->stream($callback, 200, $headers);
    }

    /**
     * Export all properties catalog to CSV.
     */
    public function exportPropertiesCsv(Request $request)
    {
        $fileName = 'homiq-properties-' . now()->format('Y-m-d_His') . '.csv';

        $headers = [
            'Content-Type' => 'text/csv',
            'Content-Disposition' => "attachment; filename=\"$fileName\"",
            'Pragma' => 'no-cache',
            'Cache-Control' => 'must-revalidate, post-check=0, pre-check=0',
            'Expires' => '0',
        ];

        $callback = function () {
            $file = fopen('php://output', 'w');
            fputcsv($file, [
                'Property ID',
                'Title',
                'Category',
                'Status',
                'Price (INR)',
                'Currency',
                'Billing Frequency',
                'Listing Type',
                'Owner Name',
                'Owner Email',
                'Address',
                'Bedrooms',
                'Bathrooms',
                'Is Furnished',
                'Is Featured',
                'Created At'
            ]);

            Property::with('owner')->chunk(200, function ($properties) use ($file) {
                foreach ($properties as $p) {
                    fputcsv($file, [
                        $p->id,
                        $p->title,
                        $p->category,
                        ucfirst($p->status),
                        $p->price,
                        $p->currency,
                        $p->billing_frequency,
                        $p->listing_type,
                        $p->owner->name ?? 'N/A',
                        $p->owner->email ?? 'N/A',
                        $p->address,
                        $p->bedrooms,
                        $p->bathrooms,
                        $p->is_furnished ? 'Yes' : 'No',
                        $p->is_featured ? 'Yes' : 'No',
                        $p->created_at ? $p->created_at->format('Y-m-d H:i:s') : 'N/A',
                    ]);
                }
            });

            fclose($file);
        };

        return response()->stream($callback, 200, $headers);
    }

    /**
     * Export all users to CSV.
     */
    public function exportUsersCsv(Request $request)
    {
        $fileName = 'homiq-users-' . now()->format('Y-m-d_His') . '.csv';

        $headers = [
            'Content-Type' => 'text/csv',
            'Content-Disposition' => "attachment; filename=\"$fileName\"",
            'Pragma' => 'no-cache',
            'Cache-Control' => 'must-revalidate, post-check=0, pre-check=0',
            'Expires' => '0',
        ];

        $callback = function () {
            $file = fopen('php://output', 'w');
            fputcsv($file, [
                'User ID',
                'Name',
                'Email',
                'Phone',
                'Role',
                'Subscription Plan',
                'KYC Status',
                'Is Admin',
                'Email Verified',
                'Referral Code',
                'Created At'
            ]);

            User::chunk(200, function ($users) use ($file) {
                foreach ($users as $u) {
                    $role = $u->is_admin ? 'Admin' : ($u->is_host ? 'Host/Landlord' : 'Renter');
                    fputcsv($file, [
                        $u->id,
                        $u->name,
                        $u->email,
                        $u->phone ?? 'N/A',
                        $role,
                        ucfirst($u->subscription_plan ?? 'free'),
                        ucfirst($u->kyc_status ?? 'unverified'),
                        $u->is_admin ? 'Yes' : 'No',
                        $u->email_verified_at ? 'Yes' : 'No',
                        $u->referral_code ?? 'N/A',
                        $u->created_at ? $u->created_at->format('Y-m-d H:i:s') : 'N/A',
                    ]);
                }
            });

            fclose($file);
        };

        return response()->stream($callback, 200, $headers);
    }

    /**
     * Display Demand Board / Property Requests management.
     */
    public function demands(Request $request)
    {
        $totalCount = PropertyRequest::count();
        $activeCount = PropertyRequest::where('status', 'active')->count();
        $fulfilledCount = PropertyRequest::where('status', 'fulfilled')->count();
        $closedCount = PropertyRequest::whereIn('status', ['closed', 'expired'])->count();
        $rentCount = PropertyRequest::where('purpose', 'rent')->count();
        $buyCount = PropertyRequest::where('purpose', 'buy')->count();

        $query = PropertyRequest::with('user')->latest();

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        if ($request->filled('purpose')) {
            $query->where('purpose', $request->purpose);
        }

        if ($request->filled('city')) {
            $query->where('city', $request->city);
        }

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('seeker_name', 'like', "%{$search}%")
                  ->orWhere('seeker_email', 'like', "%{$search}%")
                  ->orWhere('seeker_phone', 'like', "%{$search}%")
                  ->orWhere('city', 'like', "%{$search}%")
                  ->orWhere('locality', 'like', "%{$search}%")
                  ->orWhere('property_type', 'like', "%{$search}%")
                  ->orWhere('bedrooms', 'like', "%{$search}%")
                  ->orWhere('description', 'like', "%{$search}%");
            });
        }

        $demands = $query->paginate(15)->withQueryString();

        // Calculate matching properties count for each demand in current view
        $approvedProperties = Property::where('status', 'approved')->get();
        foreach ($demands as $demand) {
            $matchingCount = $approvedProperties->filter(function ($property) use ($demand) {
                return $demand->matchesProperty($property);
            })->count();
            $demand->matching_inventory_count = $matchingCount;
        }

        $cities = PropertyRequest::select('city')->distinct()->whereNotNull('city')->where('city', '!=', '')->pluck('city');

        return view('admin.demands', compact(
            'demands',
            'totalCount',
            'activeCount',
            'fulfilledCount',
            'closedCount',
            'rentCount',
            'buyCount',
            'cities'
        ));
    }

    /**
     * Update status of property request (demand).
     */
    public function updateDemandStatus(Request $request, $id)
    {
        $request->validate([
            'status' => 'required|in:active,fulfilled,closed,expired',
        ]);

        $demand = PropertyRequest::findOrFail($id);
        $demand->update(['status' => $request->status]);

        return back()->with('success', "Demand request #{$demand->id} status updated to " . ucfirst($request->status));
    }

    /**
     * Delete property request (demand).
     */
    public function deleteDemand($id)
    {
        $demand = PropertyRequest::findOrFail($id);
        $demand->delete();

        return back()->with('success', 'Demand request deleted successfully.');
    }

    /**
     * Export property requests to CSV.
     */
    public function exportDemandsCsv(Request $request)
    {
        $fileName = 'homiq-demands-' . now()->format('Y-m-d_His') . '.csv';

        $headers = [
            'Content-Type' => 'text/csv',
            'Content-Disposition' => "attachment; filename=\"$fileName\"",
            'Pragma' => 'no-cache',
            'Cache-Control' => 'must-revalidate, post-check=0, pre-check=0',
            'Expires' => '0',
        ];

        $callback = function () {
            $file = fopen('php://output', 'w');
            fputcsv($file, [
                'Request ID',
                'Seeker Name',
                'Seeker Email',
                'Seeker Phone',
                'Purpose',
                'Property Type',
                'Bedrooms',
                'City',
                'Locality',
                'Min Budget (INR)',
                'Max Budget (INR)',
                'Move In Date',
                'Tenant Type',
                'Furnishing Preference',
                'Status',
                'Responses Count',
                'Created At'
            ]);

            PropertyRequest::chunk(200, function ($demands) use ($file) {
                foreach ($demands as $d) {
                    fputcsv($file, [
                        $d->id,
                        $d->seeker_name,
                        $d->seeker_email ?? 'N/A',
                        $d->seeker_phone ?? 'N/A',
                        strtoupper($d->purpose),
                        $d->property_type,
                        $d->bedrooms ?? 'Any',
                        $d->city,
                        $d->locality ?? 'N/A',
                        $d->min_budget,
                        $d->max_budget,
                        $d->move_in_date ?? 'Immediate',
                        ucfirst(str_replace('_', ' ', $d->tenant_type ?? 'N/A')),
                        ucfirst(str_replace('_', ' ', $d->furnishing_preference ?? 'N/A')),
                        ucfirst($d->status),
                        $d->responses_count,
                        $d->created_at ? $d->created_at->format('Y-m-d H:i:s') : 'N/A',
                    ]);
                }
            });

            fclose($file);
        };

        return response()->stream($callback, 200, $headers);
    }

    /**
     * AJAX Instant Search endpoint for Admin Command Palette (⌘K).
     */
    public function quickSearch(Request $request)
    {
        $q = trim($request->input('q', ''));

        if (empty($q)) {
            // Return top system shortcuts & navigation suggestions
            $shortcuts = [
                [
                    'title' => 'Property Moderation',
                    'subtitle' => 'Approve, reject, or feature listings',
                    'icon' => 'apartment',
                    'badge' => 'Management',
                    'url' => route('admin.properties'),
                ],
                [
                    'title' => 'Demand Board & Seeker Inquiries',
                    'subtitle' => 'View active seeker tenant and buyer requests',
                    'icon' => 'manage_search',
                    'badge' => 'Leads',
                    'url' => route('admin.demands'),
                ],
                [
                    'title' => 'Financial Analytics & Revenue',
                    'subtitle' => 'Live commission revenue, GTV, and transactions ledger',
                    'icon' => 'payments',
                    'badge' => 'Finance',
                    'url' => route('admin.financials'),
                ],
                [
                    'title' => 'User & Member Directory',
                    'subtitle' => 'Manage user accounts, KYC documents, and roles',
                    'icon' => 'group',
                    'badge' => 'Members',
                    'url' => route('admin.users'),
                ],
                [
                    'title' => 'Export Financial Ledger CSV',
                    'subtitle' => 'Download complete transactions audit log',
                    'icon' => 'download',
                    'badge' => 'Export',
                    'url' => route('admin.export.transactions'),
                ],
                [
                    'title' => 'Platform Settings & Pages',
                    'subtitle' => 'Edit terms, privacy, FAQ, and platform pages',
                    'icon' => 'settings',
                    'badge' => 'CMS',
                    'url' => route('admin.settings'),
                ],
            ];

            return response()->json([
                'query' => '',
                'total' => count($shortcuts),
                'results' => [
                    'shortcuts' => $shortcuts,
                    'properties' => [],
                    'users' => [],
                    'demands' => [],
                ],
            ]);
        }

        // 1. Search Properties
        $properties = Property::with('owner')
            ->where(function ($query) use ($q) {
                $query->where('title', 'like', "%{$q}%")
                      ->orWhere('address', 'like', "%{$q}%")
                      ->orWhere('category', 'like', "%{$q}%")
                      ->orWhere('price', 'like', "%{$q}%")
                      ->orWhereHas('owner', function ($oq) use ($q) {
                          $oq->where('name', 'like', "%{$q}%")
                             ->orWhere('email', 'like', "%{$q}%");
                      });
            })
            ->take(5)
            ->get()
            ->map(function ($p) {
                return [
                    'id' => $p->id,
                    'title' => $p->title,
                    'subtitle' => $p->address . ' • ₹' . number_format($p->price) . ($p->listing_type === 'rent' ? '/mo' : ''),
                    'badge' => ucfirst($p->status),
                    'badge_color' => $p->status === 'approved' ? 'emerald' : ($p->status === 'pending' ? 'amber' : 'rose'),
                    'category' => $p->category,
                    'url' => route('admin.properties.show', $p->id),
                    'owner' => $p->owner->name ?? 'N/A',
                ];
            });

        // 2. Search Users
        $users = User::where(function ($query) use ($q) {
                $query->where('name', 'like', "%{$q}%")
                      ->orWhere('email', 'like', "%{$q}%")
                      ->orWhere('phone', 'like', "%{$q}%");
            })
            ->take(5)
            ->get()
            ->map(function ($u) {
                $role = $u->is_admin ? 'Admin' : ($u->is_host ? 'Host' : 'Member');
                return [
                    'id' => $u->id,
                    'title' => $u->name,
                    'subtitle' => $u->email . ($u->phone ? ' • ' . $u->phone : ''),
                    'badge' => $role,
                    'badge_color' => $u->is_admin ? 'purple' : 'blue',
                    'plan' => ucfirst($u->subscription_plan ?? 'free'),
                    'url' => route('admin.users') . '?search=' . urlencode($u->name),
                ];
            });

        // 3. Search Demands
        $demands = PropertyRequest::where(function ($query) use ($q) {
                $query->where('seeker_name', 'like', "%{$q}%")
                      ->orWhere('city', 'like', "%{$q}%")
                      ->orWhere('locality', 'like', "%{$q}%")
                      ->orWhere('bedrooms', 'like', "%{$q}%")
                      ->orWhere('property_type', 'like', "%{$q}%")
                      ->orWhere('seeker_phone', 'like', "%{$q}%")
                      ->orWhere('seeker_email', 'like', "%{$q}%");
            })
            ->take(5)
            ->get()
            ->map(function ($d) {
                return [
                    'id' => $d->id,
                    'title' => $d->seeker_name . ' (' . ($d->bedrooms ?: 'Any') . ' ' . $d->property_type . ')',
                    'subtitle' => $d->location . ' • Budget: ' . $d->formatted_budget,
                    'badge' => ucfirst($d->status),
                    'badge_color' => $d->status === 'active' ? 'emerald' : 'slate',
                    'url' => route('admin.demands') . '?search=' . urlencode($d->seeker_name),
                ];
            });

        // 4. Search System Shortcuts
        $allShortcuts = [
            ['title' => 'Overview Dashboard', 'subtitle' => 'Main analytics overview', 'keywords' => 'overview home dashboard stats metrics', 'icon' => 'dashboard', 'badge' => 'Nav', 'url' => route('admin.dashboard')],
            ['title' => 'Property Moderation', 'subtitle' => 'Manage listings, approve, reject', 'keywords' => 'properties listings real estate houses villas', 'icon' => 'apartment', 'badge' => 'Nav', 'url' => route('admin.properties')],
            ['title' => 'Demand Board', 'subtitle' => 'Seeker inquiries and tenant requirements', 'keywords' => 'demands requests seekers tenant requirements leads', 'icon' => 'manage_search', 'badge' => 'Nav', 'url' => route('admin.demands')],
            ['title' => 'User Management', 'subtitle' => 'Members, admins, KYC verification', 'keywords' => 'users members customers clients accounts kyc', 'icon' => 'group', 'badge' => 'Nav', 'url' => route('admin.users')],
            ['title' => 'Financial Analytics', 'subtitle' => 'Revenue, commissions, transaction ledger', 'keywords' => 'financials revenue transactions money gtv commissions earnings', 'icon' => 'payments', 'badge' => 'Nav', 'url' => route('admin.financials')],
            ['title' => 'Platform Settings & CMS', 'subtitle' => 'Pages, terms, policies, content', 'keywords' => 'settings pages cms content terms privacy about', 'icon' => 'settings', 'badge' => 'Nav', 'url' => route('admin.settings')],
            ['title' => 'System Configurations', 'subtitle' => 'App configurations and parameters', 'keywords' => 'configurations config system options environment', 'icon' => 'tune', 'badge' => 'Nav', 'url' => route('admin.config')],
            ['title' => 'Categories & Attributes', 'subtitle' => 'Listing amenities, specifications, features', 'keywords' => 'attributes categories amenities specifications features tags', 'icon' => 'category', 'badge' => 'Nav', 'url' => route('admin.attributes')],
            ['title' => 'Inquiries & Feedback', 'subtitle' => 'Customer support feedback and inquiries', 'keywords' => 'feedback inquiries support contact messages complaints', 'icon' => 'feedback', 'badge' => 'Nav', 'url' => route('admin.feedbacks')],
            ['title' => 'Admin Profile Settings', 'subtitle' => 'Your account credentials and photo', 'keywords' => 'profile account password email avatar admin', 'icon' => 'person', 'badge' => 'Nav', 'url' => route('admin.profile')],
            ['title' => 'Push Notifications', 'subtitle' => 'Broadcast announcements and FCM push alerts', 'keywords' => 'push notifications broadcast alerts announcements fcm messages marketing', 'icon' => 'campaign', 'badge' => 'Nav', 'url' => route('admin.notifications')],
            ['title' => 'Export Transactions CSV', 'subtitle' => 'Download all financial transactions', 'keywords' => 'export csv transactions excel ledger download', 'icon' => 'download', 'badge' => 'Export', 'url' => route('admin.export.transactions')],
            ['title' => 'Export Properties CSV', 'subtitle' => 'Download full property catalog', 'keywords' => 'export csv properties catalog excel download', 'icon' => 'download', 'badge' => 'Export', 'url' => route('admin.export.properties')],
            ['title' => 'Export Members CSV', 'subtitle' => 'Download all registered users list', 'keywords' => 'export csv users members excel download', 'icon' => 'download', 'badge' => 'Export', 'url' => route('admin.export.users')],
            ['title' => 'Export Demands CSV', 'subtitle' => 'Download all seeker demand requests', 'keywords' => 'export csv demands requests leads download', 'icon' => 'download', 'badge' => 'Export', 'url' => route('admin.export.demands')],
        ];

        $matchedShortcuts = array_values(array_filter($allShortcuts, function ($s) use ($q) {
            $qLower = strtolower($q);
            return str_contains(strtolower($s['title']), $qLower)
                || str_contains(strtolower($s['subtitle']), $qLower)
                || str_contains(strtolower($s['keywords']), $qLower);
        }));

        $totalCount = count($matchedShortcuts) + count($properties) + count($users) + count($demands);

        return response()->json([
            'query' => $q,
            'total' => $totalCount,
            'results' => [
                'shortcuts' => $matchedShortcuts,
                'properties' => $properties,
                'users' => $users,
                'demands' => $demands,
            ],
        ]);
    }

    /**
     * Display push notifications management and campaign history.
     */
    public function notifications(Request $request)
    {
        $broadcasts = NotificationBroadcast::with(['sender', 'targetUser'])
            ->latest()
            ->paginate(15);

        $totalBroadcasts = NotificationBroadcast::count();
        $totalInAppDelivered = NotificationBroadcast::sum('recipients_count');
        $totalFcmPushesSent = NotificationBroadcast::sum('fcm_sent_count');
        $registeredDevicesCount = User::whereNotNull('fcm_token')->where('fcm_token', '!=', '')->count();
        $totalUsersCount = User::count();
        $hostsCount = User::whereHas('properties')->count();
        $tenantsCount = User::whereDoesntHave('properties')->count();

        // Recent users for the individual recipient selector dropdown
        $recentUsers = User::select('id', 'name', 'email', 'fcm_token')
            ->latest()
            ->take(100)
            ->get();

        return view('admin.notifications', compact(
            'broadcasts',
            'totalBroadcasts',
            'totalInAppDelivered',
            'totalFcmPushesSent',
            'registeredDevicesCount',
            'totalUsersCount',
            'hostsCount',
            'tenantsCount',
            'recentUsers'
        ));
    }

    /**
     * Dispatch notification broadcast to selected audience.
     */
    public function sendNotification(Request $request, FcmService $fcmService)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'message' => 'required|string|max:1000',
            'target_audience' => 'required|in:all,hosts,tenants,pro,business,individual',
            'target_user_id' => 'required_if:target_audience,individual|nullable|exists:users,id',
            'type' => 'required|in:announcement,promotion,alert,system,info',
            'action_url' => 'nullable|string|max:255',
            'send_push' => 'nullable|boolean',
        ]);

        $sendPush = $request->boolean('send_push', true);
        $targetAudience = $validated['target_audience'];

        // Determine recipient query
        $recipientsQuery = match ($targetAudience) {
            'all' => User::query(),
            'hosts' => User::whereHas('properties'),
            'tenants' => User::whereDoesntHave('properties'),
            'pro' => User::where('subscription_plan', 'pro'),
            'business' => User::where('subscription_plan', 'business'),
            'individual' => User::where('id', $validated['target_user_id']),
        };

        $recipients = $recipientsQuery->get();
        $recipientsCount = $recipients->count();
        $fcmSentCount = 0;

        if ($recipientsCount === 0) {
            return back()->withErrors(['target_audience' => 'No active users found matching the selected target segment.']);
        }

        foreach ($recipients as $user) {
            // 1. Create In-App Notification Record
            $notification = Notification::create([
                'user_id' => $user->id,
                'title' => $validated['title'],
                'message' => $validated['message'],
                'type' => $validated['type'],
                'is_read' => false,
            ]);

            // 2. Dispatch FCM Push Notification if enabled and token is present
            if ($sendPush && !empty($user->fcm_token)) {
                try {
                    $pushSuccess = $fcmService->sendToUser(
                        $user,
                        $validated['title'],
                        $validated['message'],
                        [
                            'type' => $validated['type'],
                            'action_url' => $validated['action_url'] ?? '',
                            'notification_id' => (string) $notification->id,
                        ]
                    );
                    if ($pushSuccess) {
                        $fcmSentCount++;
                    }
                } catch (\Exception $e) {
                    \Illuminate\Support\Facades\Log::warning("FCM Broadcast exception for user #{$user->id}: " . $e->getMessage());
                }
            }
        }

        // 3. Record Broadcast Campaign History
        NotificationBroadcast::create([
            'title' => $validated['title'],
            'message' => $validated['message'],
            'target_audience' => $targetAudience,
            'target_user_id' => $targetAudience === 'individual' ? $validated['target_user_id'] : null,
            'type' => $validated['type'],
            'action_url' => $validated['action_url'] ?? null,
            'recipients_count' => $recipientsCount,
            'fcm_sent_count' => $fcmSentCount,
            'sent_by_user_id' => Auth::id(),
            'status' => 'sent',
        ]);

        $pushDetail = $sendPush ? " ({$fcmSentCount} FCM push notifications delivered to active devices)" : " (In-App notifications saved)";

        return redirect()->route('admin.notifications')->with('success', "Notification broadcast sent successfully to {$recipientsCount} recipient(s){$pushDetail}!");
    }

    /**
     * Delete a broadcast campaign history log.
     */
    public function deleteBroadcast($id)
    {
        $broadcast = NotificationBroadcast::findOrFail($id);
        $broadcast->delete();

        return redirect()->route('admin.notifications')->with('success', 'Broadcast campaign record deleted.');
    }
}

