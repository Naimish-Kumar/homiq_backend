<?php

use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\PropertyController;
use App\Http\Controllers\Api\BookingController;
use App\Http\Controllers\Api\DashboardController;
use App\Http\Controllers\Api\ChatController;
use App\Http\Controllers\Api\NotificationController;
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

// Public Property browse routes
Route::get('/properties', [PropertyController::class, 'index']);
Route::get('/properties/{id}', [PropertyController::class, 'show']);

// Protected routes
Route::middleware('auth:sanctum')->group(function () {
    Route::get('/user', function (Request $request) {
        return $request->user();
    });
    Route::post('/logout', [AuthController::class, 'logout']);
    Route::put('/profile', [AuthController::class, 'updateProfile']);
    Route::put('/change-password', [AuthController::class, 'changePassword']);
    Route::put('/fcm-token', [AuthController::class, 'updateFcmToken']);

    // Notifications
    Route::get('/notifications', [NotificationController::class, 'index']);
    Route::put('/notifications/{id}/read', [NotificationController::class, 'markAsRead']);
    Route::put('/notifications/read-all', [NotificationController::class, 'markAllAsRead']);

    // Wishlist
    Route::get('/wishlist', [\App\Http\Controllers\Api\WishlistController::class, 'index']);
    Route::post('/wishlist/toggle', [\App\Http\Controllers\Api\WishlistController::class, 'toggle']);

    // Properties host actions
    Route::post('/properties', [PropertyController::class, 'store']);
    Route::put('/properties/{id}', [PropertyController::class, 'update']);
    Route::delete('/properties/{id}', [PropertyController::class, 'destroy']);

    // Bookings
    Route::get('/bookings', [BookingController::class, 'index']);
    Route::post('/bookings', [BookingController::class, 'store']);
    Route::put('/bookings/{id}/status', [BookingController::class, 'updateStatus']);

    // Chats & Messages
    Route::get('/chats', [ChatController::class, 'index']);
    Route::post('/chats', [ChatController::class, 'store']);
    Route::get('/chats/{id}', [ChatController::class, 'show']);
    Route::post('/chats/{id}/messages', [ChatController::class, 'sendMessage']);

    // Dashboards
    Route::get('/dashboard/renter', [DashboardController::class, 'renterDashboard']);
    Route::get('/dashboard/host', [DashboardController::class, 'hostDashboard']);

    // Subscriptions
    Route::post('/subscription/sync', [\App\Http\Controllers\Api\SubscriptionSyncController::class, 'sync']);
    Route::post('/subscription/razorpay/create-order', [\App\Http\Controllers\Api\RazorpayController::class, 'createOrder']);
    Route::post('/subscription/razorpay/verify', [\App\Http\Controllers\Api\RazorpayController::class, 'verifyPayment']);
});


