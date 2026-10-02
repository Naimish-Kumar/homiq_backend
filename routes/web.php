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
Route::middleware(['admin'])->prefix('admin')->group(function () {
    Route::get('/', [AdminDashboardController::class, 'index'])->name('admin.dashboard');
    Route::get('/properties', [AdminDashboardController::class, 'properties'])->name('admin.properties');
    Route::post('/properties/bulk-status', [AdminDashboardController::class, 'bulkPropertyStatus'])->name('admin.properties.bulk-status');
    Route::get('/properties/{id}', [AdminDashboardController::class, 'showProperty'])->name('admin.properties.show');
    Route::get('/properties/{id}/edit', [AdminDashboardController::class, 'editProperty'])->name('admin.properties.edit');
    Route::post('/properties/{id}', [AdminDashboardController::class, 'updateProperty'])->name('admin.properties.update');
    Route::post('/properties/{id}/status', [AdminDashboardController::class, 'updatePropertyStatus'])->name('admin.properties.status');
    Route::post('/properties/{id}/toggle-featured', [AdminDashboardController::class, 'toggleFeatured'])->name('admin.properties.toggle-featured');
    Route::delete('/properties/{id}', [AdminDashboardController::class, 'deleteProperty'])->name('admin.properties.delete');

    Route::get('/users', [AdminDashboardController::class, 'users'])->name('admin.users');
    Route::post('/users', [AdminDashboardController::class, 'storeUser'])->name('admin.users.store');
    Route::post('/users/{id}', [AdminDashboardController::class, 'updateUser'])->name('admin.users.update');
    Route::post('/users/{id}/toggle-admin', [AdminDashboardController::class, 'toggleAdmin'])->name('admin.users.toggle-admin');
    Route::post('/users/{id}/change-plan', [AdminDashboardController::class, 'changeUserPlan'])->name('admin.users.change-plan');
    Route::post('/users/{id}/verify-kyc', [AdminDashboardController::class, 'verifyKyc'])->name('admin.users.verify-kyc');
    Route::post('/users/{id}/reject-kyc', [AdminDashboardController::class, 'rejectKyc'])->name('admin.users.reject-kyc');
    Route::delete('/users/{id}', [AdminDashboardController::class, 'deleteUser'])->name('admin.users.delete');
    Route::get('/feedbacks', [AdminDashboardController::class, 'feedbacks'])->name('admin.feedbacks');
    Route::get('/settings', [AdminDashboardController::class, 'settings'])->name('admin.settings');
    Route::get('/settings/{slug}', [AdminDashboardController::class, 'editPage'])->name('admin.settings.edit');
    Route::post('/settings/{slug}', [AdminDashboardController::class, 'updatePage'])->name('admin.settings.update');
    Route::get('/config', [AdminDashboardController::class, 'config'])->name('admin.config');
    Route::post('/config', [AdminDashboardController::class, 'updateConfig'])->name('admin.config.update');
    Route::get('/withdrawals', [AdminDashboardController::class, 'withdrawals'])->name('admin.withdrawals');
    Route::post('/withdrawals/{id}/approve', [AdminDashboardController::class, 'approveWithdrawal'])->name('admin.withdrawals.approve');
    Route::post('/withdrawals/{id}/reject', [AdminDashboardController::class, 'rejectWithdrawal'])->name('admin.withdrawals.reject');
    Route::get('/profile', [AdminDashboardController::class, 'profile'])->name('admin.profile');
    Route::post('/profile', [AdminDashboardController::class, 'updateProfile'])->name('admin.profile.update');

    Route::get('/financials', [AdminDashboardController::class, 'financials'])->name('admin.financials');
    Route::get('/export/transactions', [AdminDashboardController::class, 'exportTransactionsCsv'])->name('admin.export.transactions');
    Route::get('/export/properties', [AdminDashboardController::class, 'exportPropertiesCsv'])->name('admin.export.properties');
    Route::get('/export/users', [AdminDashboardController::class, 'exportUsersCsv'])->name('admin.export.users');

    // Demand Board & Property Requests
    Route::get('/demands', [AdminDashboardController::class, 'demands'])->name('admin.demands');
    Route::post('/demands/{id}/status', [AdminDashboardController::class, 'updateDemandStatus'])->name('admin.demands.status');
    Route::delete('/demands/{id}', [AdminDashboardController::class, 'deleteDemand'])->name('admin.demands.delete');
    Route::get('/export/demands', [AdminDashboardController::class, 'exportDemandsCsv'])->name('admin.export.demands');

    // Push Notification Broadcasting
    Route::get('/notifications', [AdminDashboardController::class, 'notifications'])->name('admin.notifications');
    Route::post('/notifications/send', [AdminDashboardController::class, 'sendNotification'])->name('admin.notifications.send');
    Route::delete('/notifications/broadcasts/{id}', [AdminDashboardController::class, 'deleteBroadcast'])->name('admin.notifications.delete');

    // Command Palette Quick Search (⌘K)
    Route::get('/quick-search', [AdminDashboardController::class, 'quickSearch'])->name('admin.quick-search');

    // Listing Options Attribute Management
    Route::get('/attributes', [AttributeController::class, 'index'])->name('admin.attributes');
    
    Route::post('/categories', [AttributeController::class, 'storeCategory'])->name('admin.categories.store');
    Route::post('/categories/{id}', [AttributeController::class, 'updateCategory'])->name('admin.categories.update');
    Route::delete('/categories/{id}', [AttributeController::class, 'deleteCategory'])->name('admin.categories.delete');

    Route::post('/specifications', [AttributeController::class, 'storeSpecification'])->name('admin.specifications.store');
    Route::post('/specifications/{id}', [AttributeController::class, 'updateSpecification'])->name('admin.specifications.update');
    Route::delete('/specifications/{id}', [AttributeController::class, 'deleteSpecification'])->name('admin.specifications.delete');

    Route::post('/key-features', [AttributeController::class, 'storeKeyFeature'])->name('admin.key-features.store');
    Route::post('/key-features/{id}', [AttributeController::class, 'updateKeyFeature'])->name('admin.key-features.update');
    Route::delete('/key-features/{id}', [AttributeController::class, 'deleteKeyFeature'])->name('admin.key-features.delete');

    Route::post('/amenities', [AttributeController::class, 'storeAmenity'])->name('admin.amenities.store');
    Route::post('/amenities/{id}', [AttributeController::class, 'updateAmenity'])->name('admin.amenities.update');
    Route::delete('/amenities/{id}', [AttributeController::class, 'deleteAmenity'])->name('admin.amenities.delete');
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




