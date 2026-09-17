<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="scroll-smooth">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>List Your Property Free | 0% Brokerage Landlord &amp; Owner Portal - HomiQ</title>
    <meta name="description" content="Rent or sell your flat, house, PG, or commercial space on HomiQ without brokerage. Connect directly with verified tenants and buyers. Free listing and real-time analytics.">

    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="google-site-verification" content="{{ config('services.google.site_verification', 'google-site-verification-homiq-growth-2026') }}">

    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=plus-jakarta-sans:400,500,600,700,800,900&display=swap" rel="stylesheet" />
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@20..48,100..700,0..1,-50..200" />

    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
    <script src="https://unpkg.com/@tailwindcss/browser@4"></script>
    <style type="text/tailwindcss">
        @theme {
            --font-sans: 'Plus Jakarta Sans', system-ui, -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, Oxygen, Ubuntu, Cantarell, 'Open Sans', 'Helvetica Neue', sans-serif;
            --color-brandNavy: #0b1528;
            --color-steelAzure: #1e3a8a;
        }
    </style>

    <!-- HomiQ Analytics & Clarity Infrastructure (Tasks 46, 47, 49) -->
    @include('partials.analytics')
</head>
<body class="bg-slate-50 text-slate-900 font-sans antialiased min-h-screen flex flex-col justify-between selection:bg-emerald-500 selection:text-white" x-data="{ activeFaq: null }">

    <!-- Header Navigation -->
    <header class="sticky top-0 z-40 bg-white/90 backdrop-blur-md border-b border-slate-200">
        <div class="max-w-[1440px] mx-auto px-6 sm:px-8 h-20 flex items-center justify-between">
            <div class="flex items-center gap-8">
                <a href="/" class="flex items-center gap-2.5 group">
                    <div class="h-10 w-10 rounded-xl bg-brandNavy text-white flex items-center justify-center font-black text-xl group-hover:scale-105 transition shadow-sm">
                        H
                    </div>
                    <div class="flex flex-col">
                        <span class="text-xl font-black tracking-tight text-brandNavy leading-none">HomiQ</span>
                        <span class="text-[10px] font-extrabold uppercase tracking-widest text-emerald-600">Owner Portal</span>
                    </div>
                <a href="/" class="flex items-center group">
                    <img src="{{ asset('logo.png') }}" alt="HomiQ" class="h-9 w-auto object-contain transition-transform duration-300 group-hover:scale-105">
                </a>

                <nav class="hidden md:flex items-center gap-6 text-xs font-bold text-slate-600">
                    <a href="#why-homiq" class="hover:text-emerald-700 transition">Why HomiQ</a>
                    <a href="#how-it-works" class="hover:text-emerald-700 transition">How It Works</a>
                    <a href="#verification" class="hover:text-emerald-700 transition">Verification</a>
                    <a href="#analytics" class="hover:text-emerald-700 transition">Owner Analytics</a>
                    <a href="#faqs" class="hover:text-emerald-700 transition">FAQs</a>
                </nav>
            </div>

            <div class="flex items-center gap-3">
                @auth
                    <a href="/dashboard" class="h-11 px-5 rounded-full bg-slate-100 hover:bg-slate-200 text-slate-900 font-bold text-xs flex items-center gap-2 transition">
                        <span class="material-symbols-outlined text-[17px] text-emerald-600">dashboard</span>
                        <span>My Dashboard</span>
                    </a>
                    <a href="{{ route('host.add-property') }}" class="h-11 px-5 rounded-full bg-emerald-600 hover:bg-emerald-700 text-white font-bold text-xs flex items-center gap-1.5 transition shadow-sm">
                        <span class="material-symbols-outlined text-[17px]">add_home</span>
                        <span>List Property</span>
                    </a>
                @else
                    <a href="/login" class="h-11 px-5 rounded-full text-slate-700 hover:text-slate-900 font-bold text-xs transition">Log In</a>
                    <a href="{{ route('host.add-property') }}" class="h-11 px-6 rounded-full bg-emerald-600 hover:bg-emerald-700 text-white font-bold text-xs flex items-center gap-1.5 transition shadow-sm active:scale-95">
                        <span class="material-symbols-outlined text-[17px]">add_home</span>
                        <span>List Free</span>
                    </a>
                @endauth
            </div>
        </div>
    </header>

    <main>
        <!-- HERO SECTION -->
        <section class="relative bg-brandNavy text-white overflow-hidden py-16 sm:py-24 border-b border-slate-800">
            <div class="absolute -right-20 -top-20 w-96 h-96 bg-emerald-500/15 rounded-full blur-3xl pointer-events-none"></div>
            <div class="absolute -left-20 bottom-0 w-80 h-80 bg-blue-500/10 rounded-full blur-3xl pointer-events-none"></div>

            <div class="max-w-[1440px] mx-auto px-6 sm:px-8 relative z-10">
                <div class="grid grid-cols-1 lg:grid-cols-12 gap-12 items-center">
                    
                    <div class="lg:col-span-7 space-y-6">
                        <div class="inline-flex items-center gap-2 px-3.5 py-1.5 rounded-full bg-emerald-500/20 border border-emerald-500/30 text-emerald-300 text-xs font-bold uppercase tracking-wider">
                            <span class="material-symbols-outlined text-[16px]">verified</span>
                            Direct Landlord &amp; Owner Marketplace
                        </div>

                        <h1 class="text-3xl sm:text-5xl lg:text-6xl font-black text-white tracking-tight leading-[1.15]">
                            Rent or Sell Your Property Without Unnecessary Brokerage
                        </h1>

                        <p class="text-slate-300 text-base sm:text-lg leading-relaxed max-w-2xl font-medium">
                            Join verified homeowners and landlords listing residential flats, villas, PGs, and commercial spaces on HomiQ. Connect directly with genuine renters and buyers — 100% free with 0% brokerage.
                        </p>

                        <!-- Key Value Metrics -->
                        <div class="grid grid-cols-2 sm:grid-cols-4 gap-3 pt-2">
                            <div class="p-4 rounded-2xl bg-white/10 border border-white/15">
                                <span class="block text-2xl font-black text-emerald-400">₹0</span>
                                <span class="text-xs text-slate-300 font-bold mt-0.5 block">Listing Fees</span>
                            </div>
                            <div class="p-4 rounded-2xl bg-white/10 border border-white/15">
                                <span class="block text-2xl font-black text-white">0%</span>
                                <span class="text-xs text-slate-300 font-bold mt-0.5 block">Broker Commission</span>
                            </div>
                            <div class="p-4 rounded-2xl bg-white/10 border border-white/15">
                                <span class="block text-2xl font-black text-amber-300">100%</span>
                                <span class="text-xs text-slate-300 font-bold mt-0.5 block">Direct Inquiries</span>
                            </div>
                            <div class="p-4 rounded-2xl bg-white/10 border border-white/15">
                                <span class="block text-2xl font-black text-emerald-400">3 Mins</span>
                                <span class="text-xs text-slate-300 font-bold mt-0.5 block">Fast Setup</span>
                            </div>
                        </div>

                        <!-- CTA Actions -->
                        <div class="pt-4 flex items-center gap-4 flex-wrap">
                            <a href="{{ route('host.add-property') }}" class="h-14 px-8 rounded-full bg-emerald-600 hover:bg-emerald-500 text-white font-bold text-sm flex items-center gap-2 shadow-lg transition transform hover:scale-105 active:scale-95">
                                <span class="material-symbols-outlined text-[19px]">add_home</span>
                                <span>List Your Property Free</span>
                            </a>
                            <a href="#how-it-works" class="h-14 px-6 rounded-full bg-white/10 hover:bg-white/20 text-white font-bold text-sm flex items-center gap-2 border border-white/15 transition">
                                <span class="material-symbols-outlined text-[19px]">play_circle</span>
                                <span>See How It Works</span>
                            </a>
                        </div>
                    </div>

                    <!-- Live Seeker Demands Card -->
                    <div class="lg:col-span-5">
                        <div class="rounded-3xl bg-white/10 border border-white/20 p-6 sm:p-8 backdrop-blur-sm space-y-5">
                            <div class="flex items-center justify-between pb-3 border-b border-white/15">
                                <div>
                                    <span class="text-xs font-bold uppercase tracking-wider text-emerald-400 block">Live Seeker Demands</span>
                                    <span class="text-xs text-slate-300 font-medium">Ready tenants &amp; buyers in your city</span>
                                </div>
                                <span class="px-2.5 py-1 rounded-full bg-emerald-500/20 text-emerald-400 text-[11px] font-bold">Active Demand</span>
                            </div>

                            <div class="space-y-3">
                                @forelse($recentRequests as $req)
                                <div class="p-4 rounded-2xl bg-white/10 border border-white/10 hover:border-emerald-500/40 transition">
                                    <div class="flex items-center justify-between mb-1">
                                        <span class="text-xs font-bold text-white">{{ $req->bedrooms }} in {{ $req->locality ?? $req->city }}</span>
                                        <span class="text-xs font-bold text-emerald-400">{{ $req->formatted_budget }}</span>
                                    </div>
                                    <p class="text-[11px] text-slate-300 line-clamp-2 leading-relaxed">
                                        {{ $req->description ?? 'Verified tenant ready to move in immediately with family.' }}
                                    </p>
                                    <div class="mt-2.5 flex items-center justify-between text-[10px] text-slate-400 font-semibold">
                                        <span>Looking for: {{ $req->occupancy_type ?? 'Rent' }}</span>
                                        <span class="text-emerald-400 font-bold">Direct Match Available</span>
                                    </div>
                                </div>
                                @empty
                                <div class="p-4 rounded-2xl bg-white/10 border border-white/10 text-center text-xs text-slate-300">
                                    Over 1,200+ monthly searches for homes and flats in NCR and top cities.
                                </div>
                                @endforelse
                            </div>

                            <a href="{{ route('host.add-property') }}" class="w-full h-12 rounded-xl bg-white hover:bg-slate-100 text-slate-900 font-bold text-xs transition flex items-center justify-center gap-2 shadow-sm">
                                <span class="material-symbols-outlined text-[18px] text-emerald-600">post_add</span>
                                <span>I Have a Matching Property</span>
                            </a>
                        </div>
                    </div>

                </div>
            </div>
        </section>

        <!-- SECTION 1: WHY LIST ON HOMIQ? -->
        <section class="max-w-[1440px] mx-auto px-6 sm:px-8 py-20" id="why-homiq">
            <div class="text-center max-w-3xl mx-auto mb-16">
                <span class="inline-flex items-center gap-1.5 text-emerald-700 font-black text-xs uppercase tracking-wider mb-2">
                    <span class="material-symbols-outlined text-[16px]">military_tech</span>
                    Built for Direct Ownership
                </span>
                <h2 class="text-3xl sm:text-4xl font-black text-slate-900 tracking-tight">
                    Why Smart Landlords &amp; Owners Choose HomiQ
                </h2>
                <p class="text-sm sm:text-base font-semibold text-slate-600 mt-2">
                    Avoid broker harassment, unfair commission deductions, and unverified inquiries with our direct owner platform.
                </p>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                <!-- Advantage 1 -->
                <div class="bg-white p-8 rounded-3xl border border-slate-200 shadow-sm hover:border-emerald-500 transition-all duration-300 space-y-4">
                    <div class="h-12 w-12 rounded-2xl bg-emerald-50 text-emerald-700 flex items-center justify-center font-bold">
                        <span class="material-symbols-outlined text-2xl">savings</span>
                    </div>
                    <h3 class="text-xl font-bold text-slate-900">Zero Brokerage Forever</h3>
                    <p class="text-xs sm:text-sm text-slate-600 leading-relaxed font-medium">
                        Never surrender 15–30 days of rental earnings to middlemen. Keep 100% of your rent and sale proceeds in your pocket.
                    </p>
                </div>

                <!-- Advantage 2 -->
                <div class="bg-white p-8 rounded-3xl border border-slate-200 shadow-sm hover:border-emerald-500 transition-all duration-300 space-y-4">
                    <div class="h-12 w-12 rounded-2xl bg-blue-50 text-blue-700 flex items-center justify-center font-bold">
                        <span class="material-symbols-outlined text-2xl">chat</span>
                    </div>
                    <h3 class="text-xl font-bold text-slate-900">Direct WhatsApp &amp; Inquiries</h3>
                    <p class="text-xs sm:text-sm text-slate-600 leading-relaxed font-medium">
                        Receive instant inquiries from genuine seekers directly on your WhatsApp or in-app chat with zero middleman filtering.
                    </p>
                </div>

                <!-- Advantage 3 -->
                <div class="bg-white p-8 rounded-3xl border border-slate-200 shadow-sm hover:border-emerald-500 transition-all duration-300 space-y-4">
                    <div class="h-12 w-12 rounded-2xl bg-amber-50 text-amber-700 flex items-center justify-center font-bold">
                        <span class="material-symbols-outlined text-2xl">verified_user</span>
                    </div>
                    <h3 class="text-xl font-bold text-slate-900">Verified Owner Badge</h3>
                    <p class="text-xs sm:text-sm text-slate-600 leading-relaxed font-medium">
                        Get our official verified checkmark that elevates your property in search results and signals authentic ownership to quality tenants.
                    </p>
                </div>

                <!-- Advantage 4 -->
                <div class="bg-white p-8 rounded-3xl border border-slate-200 shadow-sm hover:border-emerald-500 transition-all duration-300 space-y-4">
                    <div class="h-12 w-12 rounded-2xl bg-purple-50 text-purple-700 flex items-center justify-center font-bold">
                        <span class="material-symbols-outlined text-2xl">monitoring</span>
                    </div>
                    <h3 class="text-xl font-bold text-slate-900">Real-Time Performance Analytics</h3>
                    <p class="text-xs sm:text-sm text-slate-600 leading-relaxed font-medium">
                        Track views, saves, impressions, and lead clicks in your live dashboard so you know exactly how your listing is performing.
                    </p>
                </div>

                <!-- Advantage 5 -->
                <div class="bg-white p-8 rounded-3xl border border-slate-200 shadow-sm hover:border-emerald-500 transition-all duration-300 space-y-4">
                    <div class="h-12 w-12 rounded-2xl bg-rose-50 text-rose-700 flex items-center justify-center font-bold">
                        <span class="material-symbols-outlined text-2xl">security</span>
                    </div>
                    <h3 class="text-xl font-bold text-slate-900">Zero Spam &amp; Privacy Shield</h3>
                    <p class="text-xs sm:text-sm text-slate-600 leading-relaxed font-medium">
                        Control how you get contacted. No third-party marketing calls or fake broker scraping.
                    </p>
                </div>

                <!-- Advantage 6 -->
                <div class="bg-white p-8 rounded-3xl border border-slate-200 shadow-sm hover:border-emerald-500 transition-all duration-300 space-y-4">
                    <div class="h-12 w-12 rounded-2xl bg-teal-50 text-teal-700 flex items-center justify-center font-bold">
                        <span class="material-symbols-outlined text-2xl">published_with_changes</span>
                    </div>
                    <h3 class="text-xl font-bold text-slate-900">1-Click Availability Updates</h3>
                    <p class="text-xs sm:text-sm text-slate-600 leading-relaxed font-medium">
                        Easily renew your 30-day listing with 1 click or pause inquiries once your flat is rented to avoid unwanted calls.
                    </p>
                </div>
            </div>
        </section>

        <!-- SECTION 2: HOW IT WORKS (TASK 17 - 6-STEP BREAKDOWN) -->
        <section class="bg-white py-20 border-y border-slate-200" id="how-it-works">
            <div class="max-w-[1440px] mx-auto px-6 sm:px-8">
                <div class="text-center max-w-3xl mx-auto mb-16">
                    <span class="inline-flex items-center gap-1.5 text-emerald-700 font-black text-xs uppercase tracking-wider mb-2">
                        <span class="material-symbols-outlined text-[16px]">route</span>
                        Simple 6-Step Pathway
                    </span>
                    <h2 class="text-3xl sm:text-4xl font-black text-slate-900 tracking-tight">
                        How Listing on HomiQ Works for Owners
                    </h2>
                    <p class="text-sm sm:text-base font-semibold text-slate-600 mt-2">
                        From drafting details to handing over keys — zero confusion, complete control.
                    </p>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                    <!-- Step 1 -->
                    <div class="p-6 rounded-3xl bg-slate-50 border border-slate-200 relative space-y-3">
                        <div class="flex items-center justify-between">
                            <span class="h-10 w-10 rounded-xl bg-brandNavy text-white font-black text-sm flex items-center justify-center">1</span>
                            <span class="text-[11px] font-bold text-slate-400 uppercase tracking-wider">Estimated: 1 min</span>
                        </div>
                        <h3 class="text-lg font-bold text-slate-900">Add Property Details</h3>
                        <p class="text-xs text-slate-600 leading-relaxed font-medium">
                            Enter your address, property category (flat, house, PG, shop), rent amount, deposit, and key amenities.
                        </p>
                    </div>

                    <!-- Step 2 -->
                    <div class="p-6 rounded-3xl bg-slate-50 border border-slate-200 relative space-y-3">
                        <div class="flex items-center justify-between">
                            <span class="h-10 w-10 rounded-xl bg-brandNavy text-white font-black text-sm flex items-center justify-center">2</span>
                            <span class="text-[11px] font-bold text-slate-400 uppercase tracking-wider">Estimated: 1 min</span>
                        </div>
                        <h3 class="text-lg font-bold text-slate-900">Upload Authentic Photos</h3>
                        <p class="text-xs text-slate-600 leading-relaxed font-medium">
                            Add authentic room photos of the bedroom, hall, kitchen, and balcony to showcase your space honestly.
                        </p>
                    </div>

                    <!-- Step 3 -->
                    <div class="p-6 rounded-3xl bg-slate-50 border border-slate-200 relative space-y-3">
                        <div class="flex items-center justify-between">
                            <span class="h-10 w-10 rounded-xl bg-emerald-600 text-white font-black text-sm flex items-center justify-center">3</span>
                            <span class="text-[11px] font-bold text-emerald-600 uppercase tracking-wider">Trust Boost</span>
                        </div>
                        <h3 class="text-lg font-bold text-slate-900">Complete Verification</h3>
                        <p class="text-xs text-slate-600 leading-relaxed font-medium">
                            Complete fast OTP mobile validation and submit property ownership proof for your Verified Badge.
                        </p>
                    </div>

                    <!-- Step 4 -->
                    <div class="p-6 rounded-3xl bg-slate-50 border border-slate-200 relative space-y-3">
                        <div class="flex items-center justify-between">
                            <span class="h-10 w-10 rounded-xl bg-brandNavy text-white font-black text-sm flex items-center justify-center">4</span>
                            <span class="text-[11px] font-bold text-slate-400 uppercase tracking-wider">Instant</span>
                        </div>
                        <h3 class="text-lg font-bold text-slate-900">Publish Listing</h3>
                        <p class="text-xs text-slate-600 leading-relaxed font-medium">
                            Your listing is published on HomiQ's active public search feed and matched to relevant seeker demands.
                        </p>
                    </div>

                    <!-- Step 5 -->
                    <div class="p-6 rounded-3xl bg-slate-50 border border-slate-200 relative space-y-3">
                        <div class="flex items-center justify-between">
                            <span class="h-10 w-10 rounded-xl bg-brandNavy text-white font-black text-sm flex items-center justify-center">5</span>
                            <span class="text-[11px] font-bold text-slate-400 uppercase tracking-wider">Live</span>
                        </div>
                        <h3 class="text-lg font-bold text-slate-900">Receive Inquiries</h3>
                        <p class="text-xs text-slate-600 leading-relaxed font-medium">
                            Get direct WhatsApp messages and chat requests from pre-screened tenants and buyers with zero middleman interference.
                        </p>
                    </div>

                    <!-- Step 6 -->
                    <div class="p-6 rounded-3xl bg-slate-50 border border-slate-200 relative space-y-3">
                        <div class="flex items-center justify-between">
                            <span class="h-10 w-10 rounded-xl bg-emerald-600 text-white font-black text-sm flex items-center justify-center">6</span>
                            <span class="text-[11px] font-bold text-emerald-600 uppercase tracking-wider">Final Step</span>
                        </div>
                        <h3 class="text-lg font-bold text-slate-900">Connect &amp; Finalize</h3>
                        <p class="text-xs text-slate-600 leading-relaxed font-medium">
                            Schedule in-person visits, agree on terms, and finalize your rent agreement directly with 0% commission.
                        </p>
                    </div>
                </div>

                <div class="mt-12 text-center">
                    <a href="{{ route('host.add-property') }}" class="inline-flex items-center gap-2 h-14 px-8 rounded-full bg-emerald-600 hover:bg-emerald-700 text-white font-bold text-sm shadow-md transition transform hover:scale-105 active:scale-95">
                        <span class="material-symbols-outlined text-[19px]">add_home</span>
                        <span>Start Listing Free (3 Mins)</span>
                    </a>
                </div>
            </div>
        </section>

        <!-- SECTION 3: OWNER ANALYTICS & DASHBOARD (TASK 18) -->
        <section class="max-w-[1440px] mx-auto px-6 sm:px-8 py-20" id="analytics">
            <div class="rounded-3xl bg-slate-900 text-white p-8 md:p-14 shadow-xl border border-slate-800 relative overflow-hidden">
                <div class="absolute -right-20 -top-20 w-80 h-80 bg-emerald-500/10 rounded-full blur-3xl pointer-events-none"></div>

                <div class="grid grid-cols-1 lg:grid-cols-12 gap-10 items-center relative z-10">
                    <div class="lg:col-span-6 space-y-6">
                        <span class="inline-flex items-center gap-1.5 px-3.5 py-1.5 rounded-full bg-emerald-500/20 text-emerald-400 text-xs font-bold uppercase tracking-wider border border-emerald-500/30">
                            <span class="material-symbols-outlined text-[16px]">query_stats</span>
                            Data-Driven Host Dashboard
                        </span>
                        <h2 class="text-3xl sm:text-4xl font-black text-white tracking-tight">
                            Track Every View, Save &amp; Lead in Real Time
                        </h2>
                        <p class="text-slate-300 text-sm sm:text-base leading-relaxed font-medium">
                            Take the guesswork out of renting or selling. Our owner analytics dashboard keeps you informed with transparent metrics updated live as seekers discover your home.
                        </p>

                        <!-- Analytics Highlights -->
                        <div class="space-y-3 pt-2">
                            <div class="flex items-center gap-3 p-3 rounded-xl bg-white/5 border border-white/10">
                                <span class="material-symbols-outlined text-emerald-400 text-xl">visibility</span>
                                <span class="text-xs sm:text-sm font-semibold text-slate-200">Track total property views and search appearances</span>
                            </div>
                            <div class="flex items-center gap-3 p-3 rounded-xl bg-white/5 border border-white/10">
                                <span class="material-symbols-outlined text-emerald-400 text-xl">chat</span>
                                <span class="text-xs sm:text-sm font-semibold text-slate-200">Monitor WhatsApp clicks and direct contact requests</span>
                            </div>
                            <div class="flex items-center gap-3 p-3 rounded-xl bg-white/5 border border-white/10">
                                <span class="material-symbols-outlined text-emerald-400 text-xl">update</span>
                                <span class="text-xs sm:text-sm font-semibold text-slate-200">30-day freshness countdown with 1-click renewal</span>
                            </div>
                        </div>

                        <div class="pt-2">
                            <a href="{{ route('host.add-property') }}" class="h-12 px-6 rounded-full bg-emerald-600 hover:bg-emerald-500 text-white font-bold text-xs inline-flex items-center gap-2 shadow-sm transition">
                                <span>Get Your Owner Dashboard</span>
                                <span class="material-symbols-outlined text-base">arrow_forward</span>
                            </a>
                        </div>
                    </div>

                    <!-- Visual Analytics Preview Card -->
                    <div class="lg:col-span-6">
                        <div class="rounded-2xl bg-white text-slate-900 p-6 sm:p-8 shadow-2xl border border-slate-100 space-y-6">
                            <!-- Summary Banner -->
                            <div class="p-4 rounded-xl bg-emerald-50 border border-emerald-200 flex items-start gap-3">
                                <span class="material-symbols-outlined text-emerald-700 text-2xl mt-0.5">trending_up</span>
                                <div>
                                    <span class="text-xs font-bold text-emerald-900 block">Weekly Performance Insight</span>
                                    <span class="text-xs font-semibold text-emerald-700">"Your property received 42 views and 5 direct inquiries this week."</span>
                                </div>
                            </div>

                            <!-- Metrics Grid Preview -->
                            <div class="grid grid-cols-2 sm:grid-cols-3 gap-3">
                                <div class="p-3.5 rounded-xl bg-slate-50 border border-slate-200">
                                    <span class="text-[11px] font-bold text-slate-500 uppercase block">Views</span>
                                    <span class="text-2xl font-black text-slate-900">142</span>
                                    <span class="text-[10px] font-bold text-emerald-600">+18% this week</span>
                                </div>
                                <div class="p-3.5 rounded-xl bg-slate-50 border border-slate-200">
                                    <span class="text-[11px] font-bold text-slate-500 uppercase block">Inquiries</span>
                                    <span class="text-2xl font-black text-emerald-600">9</span>
                                    <span class="text-[10px] font-bold text-emerald-600">Direct WhatsApp</span>
                                </div>
                                <div class="p-3.5 rounded-xl bg-slate-50 border border-slate-200">
                                    <span class="text-[11px] font-bold text-slate-500 uppercase block">Saves</span>
                                    <span class="text-2xl font-black text-slate-900">28</span>
                                    <span class="text-[10px] font-bold text-slate-500">Shortlisted</span>
                                </div>
                                <div class="p-3.5 rounded-xl bg-slate-50 border border-slate-200">
                                    <span class="text-[11px] font-bold text-slate-500 uppercase block">Impressions</span>
                                    <span class="text-2xl font-black text-slate-900">850</span>
                                    <span class="text-[10px] font-bold text-slate-500">Search results</span>
                                </div>
                                <div class="p-3.5 rounded-xl bg-slate-50 border border-slate-200">
                                    <span class="text-[11px] font-bold text-slate-500 uppercase block">Response Rate</span>
                                    <span class="text-2xl font-black text-blue-600">98%</span>
                                    <span class="text-[10px] font-bold text-emerald-600">Top 5% Host</span>
                                </div>
                                <div class="p-3.5 rounded-xl bg-slate-50 border border-slate-200">
                                    <span class="text-[11px] font-bold text-slate-500 uppercase block">Listing Status</span>
                                    <span class="text-xs font-black text-emerald-700 uppercase block mt-1">Verified Active</span>
                                    <span class="text-[10px] font-bold text-slate-500">28d remaining</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <!-- SECTION 4: COMPARISON MATRIX -->
        <section class="max-w-[1440px] mx-auto px-6 sm:px-8 py-20">
            <div class="text-center max-w-3xl mx-auto mb-16">
                <span class="inline-flex items-center gap-1.5 text-emerald-700 font-black text-xs uppercase tracking-wider mb-2">
                    <span class="material-symbols-outlined text-[16px]">balance</span>
                    The HomiQ Difference
                </span>
                <h2 class="text-3xl sm:text-4xl font-black text-slate-900 tracking-tight">
                    HomiQ vs. Traditional Portals &amp; Brokers
                </h2>
            </div>

            <div class="overflow-x-auto">
                <table class="w-full bg-white rounded-3xl border border-slate-200 overflow-hidden shadow-sm text-left">
                    <thead>
                        <tr class="bg-slate-900 text-white text-xs font-bold uppercase tracking-wider">
                            <th class="p-5">Feature</th>
                            <th class="p-5 bg-emerald-600 text-white">HomiQ</th>
                            <th class="p-5 text-slate-400">Traditional Brokers</th>
                            <th class="p-5 text-slate-400">Legacy Classified Portals</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100 text-xs sm:text-sm font-semibold text-slate-700">
                        <tr>
                            <td class="p-5 font-bold text-slate-900">Brokerage &amp; Commission</td>
                            <td class="p-5 font-black text-emerald-700 bg-emerald-50/50">0% (Completely Free)</td>
                            <td class="p-5 text-rose-600">15 to 30 days rent</td>
                            <td class="p-5 text-slate-600">Paid lead charges</td>
                        </tr>
                        <tr>
                            <td class="p-5 font-bold text-slate-900">Direct Tenant Contact</td>
                            <td class="p-5 font-black text-emerald-700 bg-emerald-50/50">Direct WhatsApp &amp; In-App</td>
                            <td class="p-5 text-slate-600">Controlled by agent</td>
                            <td class="p-5 text-slate-600">Filtered behind paywall</td>
                        </tr>
                        <tr>
                            <td class="p-5 font-bold text-slate-900">Listing Freshness</td>
                            <td class="p-5 font-black text-emerald-700 bg-emerald-50/50">Strict 30-Day Freshness Cycle</td>
                            <td class="p-5 text-slate-600">N/A</td>
                            <td class="p-5 text-rose-600">Flooded with stale/dead ads</td>
                        </tr>
                        <tr>
                            <td class="p-5 font-bold text-slate-900">Performance Analytics</td>
                            <td class="p-5 font-black text-emerald-700 bg-emerald-50/50">Live Views, Inquiries &amp; Saves</td>
                            <td class="p-5 text-slate-400">None</td>
                            <td class="p-5 text-slate-600">Basic or paid only</td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </section>

        <!-- SECTION 5: FREQUENTLY ASKED QUESTIONS -->
        <section class="bg-slate-100 py-20 border-t border-slate-200" id="faqs">
            <div class="max-w-4xl mx-auto px-6 sm:px-8">
                <div class="text-center mb-14">
                    <span class="inline-flex items-center gap-1.5 text-emerald-700 font-black text-xs uppercase tracking-wider mb-2">
                        <span class="material-symbols-outlined text-[16px]">quiz</span>
                        Common Questions
                    </span>
                    <h2 class="text-3xl sm:text-4xl font-black text-slate-900 tracking-tight">
                        Frequently Asked Questions for Owners
                    </h2>
                </div>

                <div class="space-y-4">
                    <!-- FAQ 1 -->
                    <div class="bg-white rounded-2xl border border-slate-200 overflow-hidden shadow-sm">
                        <button type="button" @click="activeFaq = (activeFaq === 1 ? null : 1)" class="w-full p-6 text-left flex items-center justify-between gap-4 font-bold text-slate-900 text-sm sm:text-base">
                            <span>Is it genuinely 100% free to list my property on HomiQ?</span>
                            <span class="material-symbols-outlined text-slate-400 transition-transform duration-200" :class="activeFaq === 1 ? 'rotate-180 text-emerald-600' : ''">expand_more</span>
                        </button>
                        <div x-show="activeFaq === 1" x-collapse class="px-6 pb-6 text-xs sm:text-sm text-slate-600 leading-relaxed font-medium">
                            Yes! Listing your property on HomiQ is completely free with zero listing fees and 0% brokerage upon closing. You deal directly with genuine buyers and renters.
                        </div>
                    </div>

                    <!-- FAQ 2 -->
                    <div class="bg-white rounded-2xl border border-slate-200 overflow-hidden shadow-sm">
                        <button type="button" @click="activeFaq = (activeFaq === 2 ? null : 2)" class="w-full p-6 text-left flex items-center justify-between gap-4 font-bold text-slate-900 text-sm sm:text-base">
                            <span>How long does the verification process take?</span>
                            <span class="material-symbols-outlined text-slate-400 transition-transform duration-200" :class="activeFaq === 2 ? 'rotate-180 text-emerald-600' : ''">expand_more</span>
                        </button>
                        <div x-show="activeFaq === 2" x-collapse class="px-6 pb-6 text-xs sm:text-sm text-slate-600 leading-relaxed font-medium">
                            Mobile OTP and initial automated validation happen instantly. Physical audit checks and documentation verification typically complete within 4 to 24 hours.
                        </div>
                    </div>

                    <!-- FAQ 3 -->
                    <div class="bg-white rounded-2xl border border-slate-200 overflow-hidden shadow-sm">
                        <button type="button" @click="activeFaq = (activeFaq === 3 ? null : 3)" class="w-full p-6 text-left flex items-center justify-between gap-4 font-bold text-slate-900 text-sm sm:text-base">
                            <span>How do interested tenants and buyers contact me?</span>
                            <span class="material-symbols-outlined text-slate-400 transition-transform duration-200" :class="activeFaq === 3 ? 'rotate-180 text-emerald-600' : ''">expand_more</span>
                        </button>
                        <div x-show="activeFaq === 3" x-collapse class="px-6 pb-6 text-xs sm:text-sm text-slate-600 leading-relaxed font-medium">
                            Interested seekers connect directly via our integrated WhatsApp chat button or in-app messaging. You can respond at your convenience without giving your number to marketing callers.
                        </div>
                    </div>

                    <!-- FAQ 4 -->
                    <div class="bg-white rounded-2xl border border-slate-200 overflow-hidden shadow-sm">
                        <button type="button" @click="activeFaq = (activeFaq === 4 ? null : 4)" class="w-full p-6 text-left flex items-center justify-between gap-4 font-bold text-slate-900 text-sm sm:text-base">
                            <span>How does the 30-day listing cycle work?</span>
                            <span class="material-symbols-outlined text-slate-400 transition-transform duration-200" :class="activeFaq === 4 ? 'rotate-180 text-emerald-600' : ''">expand_more</span>
                        </button>
                        <div x-show="activeFaq === 4" x-collapse class="px-6 pb-6 text-xs sm:text-sm text-slate-600 leading-relaxed font-medium">
                            To maintain 100% active inventory on HomiQ, listings remain active for 30 days. You can renew for another 30 days with a single tap in your dashboard or pause the listing once rented.
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <!-- FINAL CTA BANNER -->
        <section class="max-w-[1440px] mx-auto px-6 sm:px-8 py-20">
            <div class="rounded-3xl bg-brandNavy text-white p-10 md:p-16 shadow-xl border border-slate-800 text-center relative overflow-hidden">
                <div class="max-w-2xl mx-auto space-y-6 relative z-10">
                    <h2 class="text-3xl sm:text-5xl font-black text-white tracking-tight">
                        Ready to Find Your Next Tenant or Buyer?
                    </h2>
                    <p class="text-slate-300 text-sm sm:text-base font-medium leading-relaxed">
                        Join verified landlords and property owners saving thousands on brokerage. List your property in under 3 minutes.
                    </p>
                    <div class="pt-2 flex items-center justify-center gap-4 flex-wrap">
                        <a href="{{ route('host.add-property') }}" class="h-14 px-8 rounded-full bg-emerald-600 hover:bg-emerald-500 text-white font-bold text-sm inline-flex items-center gap-2 shadow-lg transition transform hover:scale-105 active:scale-95">
                            <span class="material-symbols-outlined text-[19px]">add_home</span>
                            <span>List Your Property Free</span>
                        </a>
                    </div>
                </div>
            </div>
        </section>
    </main>

    <!-- Footer -->
    <footer class="bg-white border-t border-slate-200 py-12">
        <div class="max-w-[1440px] mx-auto px-6 sm:px-8 flex flex-col sm:flex-row items-center justify-between gap-4 text-xs font-semibold text-slate-500">
            <div class="flex items-center gap-2">
                <div class="h-6 w-6 rounded-md bg-brandNavy text-white flex items-center justify-center font-black text-xs">H</div>
                <img src="{{ asset('logo.png') }}" alt="HomiQ" class="h-6 w-auto object-contain">
                <span>&copy; {{ date('Y') }} HomiQ. 0% Brokerage Property Network.</span>
            </div>
            <div class="flex items-center gap-6">
                <a href="/" class="hover:text-slate-900 transition">Home</a>
                <a href="/owners" class="hover:text-slate-900 transition">Owner Portal</a>
                <a href="/pricing" class="hover:text-slate-900 transition">Pricing</a>
                <a href="/privacy" class="hover:text-slate-900 transition">Privacy</a>
                <a href="/terms" class="hover:text-slate-900 transition">Terms</a>
            </div>
        </div>
    </footer>

</body>
</html>

