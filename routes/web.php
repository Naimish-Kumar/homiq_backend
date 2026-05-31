<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Web\AdminDashboardController;
use App\Http\Controllers\Web\WebHomeController;
use App\Http\Controllers\Web\CustomerDashboardController;
use App\Http\Controllers\Web\AttributeController;

// Public Pages
Route::get('/', [WebHomeController::class, 'index']);
Route::get('/category/{name}', [WebHomeController::class, 'category']);
Route::get('/properties/{id}', [WebHomeController::class, 'property']);
Route::get('/pricing', [WebHomeController::class, 'pricing']);
Route::get('/about', [WebHomeController::class, 'about']);
Route::get('/privacy', [WebHomeController::class, 'privacy']);
Route::get('/terms', [WebHomeController::class, 'terms']);
Route::view('/contact', 'contact');

// Authentication (Guest)
Route::middleware(['guest'])->group(function () {
    Route::get('/login', [AdminDashboardController::class, 'showLogin'])->name('login');
    Route::post('/login', [AdminDashboardController::class, 'login']);
    Route::get('/register', [AdminDashboardController::class, 'showRegister']);
    Route::post('/register', [AdminDashboardController::class, 'register']);
});

// Authentication (Protected but maybe unverified)
Route::middleware(['auth'])->group(function () {
    Route::post('/logout', [AdminDashboardController::class, 'logout'])->name('logout');
    // OTP Email Verification
    Route::get('/verify-email', [AdminDashboardController::class, 'showVerifyOtp']);
    Route::post('/verify-email', [AdminDashboardController::class, 'verifyOtp']);
    Route::post('/verify-email/resend', [AdminDashboardController::class, 'resendOtpWeb']);
    // Actions requiring verified email (Customer Dashboard & Subscriptions)
    Route::middleware(['verified_otp'])->group(function () {
        Route::get('/dashboard', [CustomerDashboardController::class, 'index']);
        Route::post('/dashboard/listings', [CustomerDashboardController::class, 'storeListing']);
        Route::post('/dashboard/reservations', [CustomerDashboardController::class, 'makeReservation']);
        Route::post('/upgrade-subscription', [WebHomeController::class, 'upgradeSubscription']);
        Route::post('/pricing/razorpay/create-order', [\App\Http\Controllers\Api\RazorpayController::class, 'createOrder']);
        Route::post('/pricing/razorpay/verify', [\App\Http\Controllers\Api\RazorpayController::class, 'verifyPayment']);

        // Profile & Password updates
        Route::post('/dashboard/profile', [CustomerDashboardController::class, 'updateProfile']);
        Route::post('/dashboard/password', [CustomerDashboardController::class, 'updatePassword']);
        // Chat messaging system
        Route::get('/chat', [WebHomeController::class, 'chat']);
        Route::post('/chat/send', [WebHomeController::class, 'sendChatMessage']);
        // Notifications
        Route::post('/notifications/read-all', [WebHomeController::class, 'readAllNotifications']);
        // Landlord Reservation Status Updates
        Route::post('/dashboard/reservations/{id}/status', [CustomerDashboardController::class, 'updateReservationStatus']);
    });
});

// Protected Admin Dashboard Routes
Route::middleware(['admin'])->prefix('admin')->group(function () {
    Route::get('/', [AdminDashboardController::class, 'index']);
    Route::get('/properties', [AdminDashboardController::class, 'properties']);
    Route::get('/properties/{id}', [AdminDashboardController::class, 'showProperty']);
    Route::post('/properties/{id}/status', [AdminDashboardController::class, 'updatePropertyStatus']);
    Route::get('/users', [AdminDashboardController::class, 'users']);
    Route::post('/users', [AdminDashboardController::class, 'storeUser']);
    Route::post('/users/{id}', [AdminDashboardController::class, 'updateUser']);
    Route::post('/users/{id}/toggle-admin', [AdminDashboardController::class, 'toggleAdmin']);
    Route::post('/users/{id}/change-plan', [AdminDashboardController::class, 'changeUserPlan']);
    Route::delete('/users/{id}', [AdminDashboardController::class, 'deleteUser']);
    Route::get('/settings', [AdminDashboardController::class, 'settings']);
    Route::get('/settings/{slug}', [AdminDashboardController::class, 'editPage']);
    Route::post('/settings/{slug}', [AdminDashboardController::class, 'updatePage']);
    Route::get('/config', [AdminDashboardController::class, 'config']);
    Route::post('/config', [AdminDashboardController::class, 'updateConfig']);
    Route::get('/profile', [AdminDashboardController::class, 'profile']);
    Route::post('/profile', [AdminDashboardController::class, 'updateProfile']);

    // Listing Options Attribute Management
    Route::get('/attributes', [AttributeController::class, 'index']);
    
    Route::post('/categories', [AttributeController::class, 'storeCategory']);
    Route::post('/categories/{id}', [AttributeController::class, 'updateCategory']);
    Route::delete('/categories/{id}', [AttributeController::class, 'deleteCategory']);

    Route::post('/specifications', [AttributeController::class, 'storeSpecification']);
    Route::post('/specifications/{id}', [AttributeController::class, 'updateSpecification']);
    Route::delete('/specifications/{id}', [AttributeController::class, 'deleteSpecification']);

    Route::post('/key-features', [AttributeController::class, 'storeKeyFeature']);
    Route::post('/key-features/{id}', [AttributeController::class, 'updateKeyFeature']);
    Route::delete('/key-features/{id}', [AttributeController::class, 'deleteKeyFeature']);

    Route::post('/amenities', [AttributeController::class, 'storeAmenity']);
    Route::post('/amenities/{id}', [AttributeController::class, 'updateAmenity']);
    Route::delete('/amenities/{id}', [AttributeController::class, 'deleteAmenity']);
});


