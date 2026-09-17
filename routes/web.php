<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Web\AdminDashboardController;
use App\Http\Controllers\Web\WebHomeController;
use App\Http\Controllers\Web\CustomerDashboardController;
use App\Http\Controllers\Web\AttributeController;
use App\Http\Controllers\Web\HostPropertyController;
use App\Http\Controllers\Auth\GoogleAuthController;
use App\Http\Controllers\Web\SeoLandingController;
use App\Http\Controllers\Web\BlogController;

// Public Pages
Route::get('/', [WebHomeController::class, 'index']);
Route::get('/category/{name}', [WebHomeController::class, 'category']);

// SEO Property Detail URLs (backward-compatible)
Route::get('/property/{slug}', [WebHomeController::class, 'property'])->name('property.show');
Route::get('/properties/{id}', [WebHomeController::class, 'property']);
Route::post('/properties/{id}/report', [WebHomeController::class, 'reportProperty'])->name('properties.report');
Route::post('/properties/{id}/renew', [WebHomeController::class, 'renewProperty'])->name('properties.renew');
Route::post('/properties/{id}/track-contact', [WebHomeController::class, 'trackContact'])->name('properties.track-contact');
Route::post('/properties/{id}/track-save', [WebHomeController::class, 'trackSave'])->name('properties.track-save');

// SEO Programmatic Landing Pages (Tasks 19 & 20)
Route::get('/rent/{city}', [SeoLandingController::class, 'rentCity'])->name('seo.rent.city');
Route::get('/rent/{category}/{city}', [SeoLandingController::class, 'rentCategoryCity'])->name('seo.rent.category.city');
Route::get('/buy/{city}', [SeoLandingController::class, 'buyCity'])->name('seo.buy.city');
Route::get('/buy/{category}/{city}', [SeoLandingController::class, 'buyCategoryCity'])->name('seo.buy.category.city');
Route::get('/explore/{intent}', [SeoLandingController::class, 'intentLanding'])->name('seo.explore.intent');

// Guides & Blog Knowledge Hub (Task 25)
Route::get('/guides', [BlogController::class, 'index'])->name('guides.index');
Route::get('/guides/{slug}', [BlogController::class, 'show'])->name('guides.show');
Route::get('/blog', [BlogController::class, 'index'])->name('blog.index');
Route::get('/blog/{slug}', [BlogController::class, 'show'])->name('blog.show');

// Dedicated Owner Landing Page & Shortcuts
Route::get('/list-property', [WebHomeController::class, 'ownersLanding'])->name('owners.landing');
Route::get('/owners', [WebHomeController::class, 'ownersLanding']);
Route::get('/list-your-property', [WebHomeController::class, 'ownersLanding']);

Route::get('/pricing', [WebHomeController::class, 'pricing']);
Route::get('/about', [WebHomeController::class, 'about']);
Route::get('/privacy', [WebHomeController::class, 'privacy']);
Route::get('/terms', [WebHomeController::class, 'terms']);
Route::view('/contact', 'contact');
Route::get('/pricing', [WebHomeController::class, 'pricing'])->name('pricing');
Route::get('/about', [WebHomeController::class, 'about'])->name('about');
Route::get('/verification-standards', [WebHomeController::class, 'verificationStandards'])->name('verification.standards');
Route::get('/safety', [WebHomeController::class, 'safety'])->name('safety');
Route::get('/privacy', [WebHomeController::class, 'privacy'])->name('privacy');
Route::get('/terms', [WebHomeController::class, 'terms'])->name('terms');
Route::get('/contact', [WebHomeController::class, 'contact'])->name('contact');
Route::post('/contact', [WebHomeController::class, 'submitContact'])->name('contact.submit');
Route::post('/delete-account', [WebHomeController::class, 'deleteAccount']);
Route::post('/property-requests', [WebHomeController::class, 'storePropertyRequest'])->name('property-requests.store');
Route::post('/recently-viewed/clear', [WebHomeController::class, 'clearRecentlyViewed'])->name('recently-viewed.clear');
Route::post('/saved-searches', [WebHomeController::class, 'saveSearch'])->name('saved-searches.store');
Route::delete('/saved-searches/{id}', [WebHomeController::class, 'deleteSavedSearch'])->name('saved-searches.destroy');
Route::post('/saved-searches/{id}/toggle', [WebHomeController::class, 'toggleSavedSearch'])->name('saved-searches.toggle');

// Authentication (Guest)
Route::middleware(['guest'])->group(function () {
    Route::get('/login', [AdminDashboardController::class, 'showLogin'])->name('login');
    Route::post('/login', [AdminDashboardController::class, 'login']);
    Route::get('/register', [AdminDashboardController::class, 'showRegister']);
    Route::post('/register', [AdminDashboardController::class, 'register']);
});

// Firebase Auth Callback
Route::post('/auth/firebase-login', [GoogleAuthController::class, 'handleFirebaseCallback']);

// Authentication (Protected but maybe unverified)
Route::middleware(['auth'])->group(function () {
    Route::post('/logout', function () {
        Auth::logout();
        return redirect('/');
    })->name('logout');
    Route::get('/verify-email', [AdminDashboardController::class, 'showVerifyOtp']);
    Route::post('/verify-email', [AdminDashboardController::class, 'verifyOtp']);
    Route::post('/verify-email/resend', [AdminDashboardController::class, 'resendOtpWeb']);
    // Actions requiring verified email (Customer Dashboard & Subscriptions)
    Route::middleware(['verified_otp'])->group(function () {
        Route::get('/dashboard', [CustomerDashboardController::class, 'index']);
        Route::get('/dashboard/listings/{id}/matching-demands', [CustomerDashboardController::class, 'getMatchingDemands'])->name('dashboard.listings.matching-demands');
        Route::post('/dashboard/listings', [CustomerDashboardController::class, 'storeListing']);
        Route::post('/dashboard/listings/{id}/toggle-featured', [CustomerDashboardController::class, 'toggleFeatured']);
        Route::post('/dashboard/listings/{id}/renew', [WebHomeController::class, 'renewProperty'])->name('dashboard.listings.renew');
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
        Route::post('/chat/{id}/typing', [WebHomeController::class, 'updateTypingStatus']);
        Route::get('/chat/{id}/typing', [WebHomeController::class, 'getTypingStatus']);
        Route::post('/chat/{id}/presence', [WebHomeController::class, 'updatePresenceStatus']);
        // Notifications
        Route::post('/notifications/read-all', [WebHomeController::class, 'readAllNotifications']);
        // Landlord Reservation Status Updates
        Route::post('/dashboard/reservations/{id}/status', [CustomerDashboardController::class, 'updateReservationStatus']);

        // Host Portal (Add Property)
        Route::get('/host/add-property', [HostPropertyController::class, 'create'])->name('host.add-property');
        Route::post('/host/add-property', [HostPropertyController::class, 'store']);
    });
});

// Protected Admin Dashboard Routes
Route::middleware(['admin'])->prefix('old-admin')->group(function () {
    Route::get('/', [AdminDashboardController::class, 'index']);
    Route::get('/properties', [AdminDashboardController::class, 'properties']);
    Route::get('/properties/{id}', [AdminDashboardController::class, 'showProperty']);
    Route::get('/properties/{id}/edit', [AdminDashboardController::class, 'editProperty']);
    Route::post('/properties/{id}', [AdminDashboardController::class, 'updateProperty']);
    Route::post('/properties/{id}/status', [AdminDashboardController::class, 'updatePropertyStatus']);
    Route::post('/properties/{id}/toggle-featured', [AdminDashboardController::class, 'toggleFeatured']);
    Route::delete('/properties/{id}', [AdminDashboardController::class, 'deleteProperty']);

    Route::get('/users', [AdminDashboardController::class, 'users']);
    Route::post('/users', [AdminDashboardController::class, 'storeUser']);
    Route::post('/users/{id}', [AdminDashboardController::class, 'updateUser']);
    Route::post('/users/{id}/toggle-admin', [AdminDashboardController::class, 'toggleAdmin']);
    Route::post('/users/{id}/change-plan', [AdminDashboardController::class, 'changeUserPlan']);
    Route::post('/users/{id}/verify-kyc', [AdminDashboardController::class, 'verifyKyc']);
    Route::post('/users/{id}/reject-kyc', [AdminDashboardController::class, 'rejectKyc']);
    Route::delete('/users/{id}', [AdminDashboardController::class, 'deleteUser']);
    Route::get('/feedbacks', [AdminDashboardController::class, 'feedbacks']);
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

// Analytics & Event Tracking (Tasks 46 & 47)
Route::post('/analytics/events', [\App\Http\Controllers\AnalyticsController::class, 'recordEvent'])->name('analytics.events');
Route::get('/admin/analytics/funnels', [\App\Http\Controllers\AnalyticsController::class, 'funnels'])->name('admin.analytics.funnels');

// XML Sitemap Strategy (Task 52)
Route::get('/sitemap.xml', [\App\Http\Controllers\SitemapController::class, 'index'])->name('sitemap.index');
Route::get('/sitemap-pages.xml', [\App\Http\Controllers\SitemapController::class, 'pages'])->name('sitemap.pages');
Route::get('/sitemap-locations.xml', [\App\Http\Controllers\SitemapController::class, 'locations'])->name('sitemap.locations');
Route::get('/sitemap-properties.xml', [\App\Http\Controllers\SitemapController::class, 'properties'])->name('sitemap.properties');
Route::get('/sitemap-blog.xml', [\App\Http\Controllers\SitemapController::class, 'blog'])->name('sitemap.blog');




