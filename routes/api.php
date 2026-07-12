<?php

use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\PropertyController;
use App\Http\Controllers\Api\BookingController;
use App\Http\Controllers\Api\DashboardController;
use App\Http\Controllers\Api\ChatController;
use App\Http\Controllers\Api\NotificationController;
use App\Http\Controllers\Api\MetadataController;
use App\Http\Controllers\Api\FeedbackController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

// Public Auth routes
Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);
Route::post('/verify-email', [AuthController::class, 'verifyEmail']);
Route::post('/resend-otp', [AuthController::class, 'resendOtp']);
Route::post('/forgot-password', [AuthController::class, 'forgotPassword']);
Route::post('/reset-password', [AuthController::class, 'resetPassword']);
Route::post('/social-login', [AuthController::class, 'socialLogin']);
Route::post('/subscription/revenuecat-webhook', [\App\Http\Controllers\Api\RevenueCatWebhookController::class, 'handleWebhook']);

// Public Property browse routes
Route::get('/properties', [PropertyController::class, 'index']);
Route::post('/properties/map-search', [\App\Http\Controllers\MapSearchController::class, 'search']);
Route::get('/properties/{id}', [PropertyController::class, 'show']);
Route::get('/properties/{id}/insights', [\App\Http\Controllers\NeighborhoodInsightController::class, 'getInsights']);
Route::get('/properties/{id}/questions', [\App\Http\Controllers\PropertyQuestionController::class, 'index']);
Route::get('/metadata', [MetadataController::class, 'index']);
Route::get('/app-version', function() {
    $configs = \App\Models\Configuration::where('group', 'app')->pluck('value', 'key');
    return response()->json([
        'min_version' => $configs->get('app_min_version', '1.0.0'),
        'latest_version' => $configs->get('app_latest_version', '1.0.0'),
        'force_update' => $configs->get('app_force_update', '0') === '1',
        'update_url' => $configs->get('app_update_url', 'https://play.google.com/store/apps/details?id=com.homiq.acrocoder'),
    ]);
});
// Dashboards
Route::get('/dashboard/renter', [DashboardController::class, 'renterDashboard']);

// Protected routes
Route::middleware('auth:sanctum')->group(function () {
    Route::get('/user', function (Request $request) {
        return $request->user();
    });
    Route::post('/logout', [AuthController::class, 'logout']);
    Route::put('/profile', [AuthController::class, 'updateProfile']);
    Route::put('/change-password', [AuthController::class, 'changePassword']);
    Route::put('/fcm-token', [AuthController::class, 'updateFcmToken']);
    Route::post('/referral/apply', [AuthController::class, 'applyReferralCode']);

    // Notifications
    Route::get('/notifications', [NotificationController::class, 'index']);
    Route::put('/notifications/{id}/read', [NotificationController::class, 'markAsRead']);
    Route::put('/notifications/read-all', [NotificationController::class, 'markAllAsRead']);

    // Wishlist
    Route::get('/wishlist', [\App\Http\Controllers\Api\WishlistController::class, 'index']);
    Route::post('/wishlist/toggle', [\App\Http\Controllers\Api\WishlistController::class, 'toggle']);

    // Shared Wishlists
    Route::get('/shared-wishlists', [\App\Http\Controllers\Api\SharedWishlistController::class, 'index']);
    Route::post('/shared-wishlists', [\App\Http\Controllers\Api\SharedWishlistController::class, 'store']);

    // KYC
    Route::post('/kyc/upload', [\App\Http\Controllers\KycController::class, 'upload']);

    // Rental Agreements
    Route::get('/rental-agreements', [\App\Http\Controllers\RentalAgreementController::class, 'index']);
    Route::post('/rental-agreements', [\App\Http\Controllers\RentalAgreementController::class, 'store']);
    Route::get('/rental-agreements/{id}', [\App\Http\Controllers\RentalAgreementController::class, 'show']);
    Route::post('/rental-agreements/{id}/sign', [\App\Http\Controllers\RentalAgreementController::class, 'sign']);
    Route::post('/shared-wishlists/{id}/invite', [\App\Http\Controllers\Api\SharedWishlistController::class, 'invite']);
    Route::post('/shared-wishlists/{id}/properties', [\App\Http\Controllers\Api\SharedWishlistController::class, 'toggleProperty']);
    Route::put('/shared-wishlists/{id}/properties/{propertyId}/note', [\App\Http\Controllers\Api\SharedWishlistController::class, 'updateNote']);
    Route::post('/shared-wishlists/{id}/properties/{propertyId}/vote', [\App\Http\Controllers\Api\SharedWishlistController::class, 'vote']);

    // Properties host actions
    Route::post('/properties', [PropertyController::class, 'store']);
    Route::put('/properties/{id}', [PropertyController::class, 'update']);
    Route::delete('/properties/{id}', [PropertyController::class, 'destroy']);
    
    // Property Questions
    Route::post('/properties/{id}/questions', [\App\Http\Controllers\PropertyQuestionController::class, 'store']);
    Route::put('/properties/questions/{id}/answer', [\App\Http\Controllers\PropertyQuestionController::class, 'answer']);

    // Property Actions (Views & Recommendations)
    Route::post('/properties/{id}/view', [\App\Http\Controllers\Api\PropertyActionController::class, 'logView']);
    Route::get('/properties-recommended', [\App\Http\Controllers\Api\PropertyActionController::class, 'recommended']);

    // Saved Searches
    Route::get('/saved-searches', [\App\Http\Controllers\Api\SavedSearchController::class, 'index']);
    Route::post('/saved-searches', [\App\Http\Controllers\Api\SavedSearchController::class, 'store']);
    Route::delete('/saved-searches/{id}', [\App\Http\Controllers\Api\SavedSearchController::class, 'destroy']);

    // User Feedback
    Route::post('/feedback', [FeedbackController::class, 'store']);

    // Bookings
    Route::get('/bookings', [BookingController::class, 'index']);
    Route::post('/bookings', [BookingController::class, 'store']);
    Route::put('/bookings/{id}/status', [BookingController::class, 'updateStatus']);

    // Roommate Groups / Community Renting
    Route::get('/properties/{propertyId}/roommate-groups', [\App\Http\Controllers\Api\RoommateGroupController::class, 'index']);
    Route::post('/properties/{propertyId}/roommate-groups', [\App\Http\Controllers\Api\RoommateGroupController::class, 'store']);
    Route::post('/roommate-groups/{id}/join', [\App\Http\Controllers\Api\RoommateGroupController::class, 'join']);
    Route::post('/roommate-groups/{id}/leave', [\App\Http\Controllers\Api\RoommateGroupController::class, 'leave']);

    // Chats & Messages
    Route::get('/chats', [ChatController::class, 'index']);
    Route::post('/chats', [ChatController::class, 'store']);
    Route::get('/chats/{id}', [ChatController::class, 'show']);
    Route::post('/chats/{id}/messages', [ChatController::class, 'sendMessage']);
    Route::post('/chats/{id}/read', [ChatController::class, 'markAsRead']);
    Route::post('/chats/{id}/typing', [ChatController::class, 'updateTypingStatus']);
    Route::get('/chats/{id}/typing', [ChatController::class, 'getTypingStatus']);
    Route::post('/chats/{id}/presence', [ChatController::class, 'updatePresenceStatus']);

    // Dashboards
    Route::get('/dashboard/host', [DashboardController::class, 'hostDashboard']);

    // Subscriptions
    Route::post('/subscription/sync', [\App\Http\Controllers\Api\SubscriptionSyncController::class, 'sync']);
    Route::post('/subscription/razorpay/create-order', [\App\Http\Controllers\Api\RazorpayController::class, 'createOrder']);
    Route::post('/subscription/razorpay/verify', [\App\Http\Controllers\Api\RazorpayController::class, 'verifyPayment']);
});


