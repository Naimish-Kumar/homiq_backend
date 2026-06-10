@extends('layouts.app')

@section('content')
<style>
    /* Premium Visual Design Tokens & Keyframe Animations */
    :root {
        --primary-glow: radial-gradient(rgba(26, 68, 124, 0.12), rgba(50, 139, 96, 0.03));
        --accent-glow: radial-gradient(rgba(99, 102, 241, 0.15), rgba(99, 102, 241, 0));
    }

    /* Soft Animated Background Blobs */
    .glow-blob-1 {
        filter: blur(80px);
        background: radial-gradient(circle, rgba(26,68,124,0.15) 0%, rgba(99,102,241,0.05) 50%, rgba(255,255,255,0) 100%);
        animation: blobFloat 12s ease-in-out infinite alternate;
    }
    .glow-blob-2 {
        filter: blur(80px);
        background: radial-gradient(circle, rgba(50,139,96,0.12) 0%, rgba(52,211,153,0.04) 60%, rgba(255,255,255,0) 100%);
        animation: blobFloat2 15s ease-in-out infinite alternate;
    }

    @keyframes blobFloat {
        0% { transform: translate(0px, 0px) scale(1); }
        50% { transform: translate(30px, -40px) scale(1.1); }
        100% { transform: translate(-20px, 20px) scale(0.95); }
    }
    @keyframes blobFloat2 {
        0% { transform: translate(0px, 0px) scale(1); }
        50% { transform: translate(-40px, 30px) scale(1.05); }
        100% { transform: translate(30px, -20px) scale(0.9); }
    }

    /* Hero Glass Search Card */
    .search-glass-card {
        background: rgba(255, 255, 255, 0.85);
        backdrop-filter: blur(20px);
        -webkit-backdrop-filter: blur(20px);
        border: 1px solid rgba(255, 255, 255, 0.6);
        box-shadow: 0 20px 50px rgba(15, 23, 42, 0.05);
    }

    /* Premium Listing Card Styling */
    .listing-premium-card {
        transition: transform 0.6s cubic-bezier(0.16, 1, 0.3, 1),
                    box-shadow 0.6s cubic-bezier(0.16, 1, 0.3, 1),
                    border-color 0.6s cubic-bezier(0.16, 1, 0.3, 1);
        border: 1px solid rgba(241, 245, 249, 0.8);
    }
    .listing-premium-card:hover {
        transform: translateY(-8px) scale(1.01);
        box-shadow: 0 30px 60px -15px rgba(15, 23, 42, 0.08), 0 10px 22px -10px rgba(0, 0, 0, 0.04);
        border-color: rgba(26, 68, 124, 0.15);
    }

    /* Category Buttons spring zoom */
    .premium-category-btn {
        transition: transform 0.4s cubic-bezier(0.175, 0.885, 0.32, 1.2),
                    box-shadow 0.4s cubic-bezier(0.16, 1, 0.3, 1),
                    background-color 0.3s ease;
    }
    .premium-category-btn:hover {
        transform: translateY(-5px);
        box-shadow: 0 16px 32px -8px rgba(26, 68, 124, 0.08);
    }

    /* Floating Hero Visual Animations */
    @keyframes floatCard {
        0% { transform: translateY(0px) rotate(0deg); }
        50% { transform: translateY(-12px) rotate(0.5deg); }
        100% { transform: translateY(0px) rotate(0deg); }
    }
    @keyframes floatBadge {
        0% { transform: translateY(0px) scale(1); }
        50% { transform: translateY(-6px) scale(1.03); }
        100% { transform: translateY(0px) scale(1); }
    }
    .hero-float-card {
        animation: floatCard 6s ease-in-out infinite;
    }
    .hero-float-badge {
        animation: floatBadge 4s ease-in-out infinite;
    }

    /* Custom scroll indicator reveal style */
    .scroll-indicator {
        animation: bounceIndicator 2s infinite;
    }
    @keyframes bounceIndicator {
        0%, 20%, 50%, 80%, 100% { transform: translateY(0); }
        40% { transform: translateY(-6px); }
        60% { transform: translateY(-3px); }
    }

    /* Horizontal categories limit helper */
    .category-btn-wrapper:nth-child(n+7) {
        display: none;
    }
    .categories-expanded .category-btn-wrapper:nth-child(n+7) {
        display: flex;
    }

    /* Shimmer Effect on Images */
    @keyframes shimmerSweep {
        0% { left: -150%; }
        50% { left: 150%; }
        100% { left: 150%; }
    }
    .shimmer-hover::after {
        content: '';
        position: absolute;
        top: 0;
        left: -150%;
        width: 100%;
        height: 100%;
        background: linear-gradient(90deg, transparent, rgba(255, 255, 255, 0.25), transparent);
        transform: skewX(-20deg);
        z-index: 10;
        pointer-events: none;
    }
    .shimmer-hover:hover::after {
        animation: shimmerSweep 1.2s cubic-bezier(0.16, 1, 0.3, 1);
    }
</style>

<!-- Background Ambient Glow Blobs -->
<div class="absolute top-20 left-10 w-96 h-96 glow-blob-1 rounded-full pointer-events-none z-0"></div>
<div class="absolute top-80 right-20 w-[450px] h-[450px] glow-blob-2 rounded-full pointer-events-none z-0"></div>

<!-- SECTION 1: HERO CONTAINER -->
<section class="relative max-w-7xl mx-auto px-6 pt-10 pb-14 z-10">
    <div class="w-full">
        
        <!-- Search widget & text introduction -->
        <div class="space-y-8">
            <div class="space-y-4 text-center">
                <div class="inline-flex items-center gap-2 px-3 py-1.5 rounded-full bg-steelAzure/10 border border-steelAzure/20 text-steelAzure text-xs font-bold tracking-wide uppercase">
                    <span class="flex h-2 w-2 relative">
                        <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-emerald-400 opacity-75"></span>
                        <span class="relative inline-flex rounded-full h-2 w-2 bg-emerald-500"></span>
                    </span>
                    Real-time space verification active
                </div>
                <h1 class="text-4xl sm:text-5xl lg:text-6xl font-extrabold text-slate-900 tracking-tight leading-[1.1]">
                    Find Your Next
                    <span class="bg-gradient-to-r from-steelAzure via-indigo-600 to-emerald-600 bg-clip-text text-transparent"> Perfect Space</span>,
                    <br>Seamlessly.
                </h1>
                <p class="text-base sm:text-lg text-slate-500 max-w-2xl mx-auto font-medium leading-relaxed">
                    Verify, book, and chat directly with premium landlords. HomiQ connects thousands of studios, flats, villas, and commercial spaces.
                </p>
            </div>

            <!-- Custom Interactive Tabbed Search Widget -->
            <div class="search-glass-card rounded-[24px] p-6 shadow-2xl relative">
                <!-- Tabs -->
                <div class="flex gap-2 border-b border-slate-200/60 pb-4 mb-4 justify-center">
                    <button type="button" id="tab-all" onclick="selectSearchTab('all')" 
                            class="px-4 py-2 text-xs font-extrabold tracking-wide uppercase rounded-xl transition-all duration-300 search-tab-btn bg-steelAzure text-white shadow-sm">
                        All Spaces
                    </button>
                    <button type="button" id="tab-villa" onclick="selectSearchTab('Villa')" 
                            class="px-4 py-2 text-xs font-extrabold tracking-wide uppercase rounded-xl transition-all duration-300 search-tab-btn text-slate-500 hover:text-slate-800 hover:bg-slate-100">
                        Villas
                    </button>
                    <button type="button" id="tab-apartment" onclick="selectSearchTab('Apartment')" 
                            class="px-4 py-2 text-xs font-extrabold tracking-wide uppercase rounded-xl transition-all duration-300 search-tab-btn text-slate-500 hover:text-slate-800 hover:bg-slate-100">
                        Apartments
                    </button>
                    <button type="button" id="tab-studio" onclick="selectSearchTab('Studio')" 
                            class="px-4 py-2 text-xs font-extrabold tracking-wide uppercase rounded-xl transition-all duration-300 search-tab-btn text-slate-500 hover:text-slate-800 hover:bg-slate-100">
                        PG / Rooms
                    </button>
                </div>

                <!-- Form -->
                <form action="/" method="GET" id="hero-search-form" class="grid grid-cols-1 md:grid-cols-12 gap-4 md:items-end items-stretch">
                    <input type="hidden" name="search_type" id="hidden-search-type" value="{{ request('search_type', 'all') }}">
                    
                    <div class="md:col-span-5 relative">
                        <label class="block text-[10px] font-extrabold text-slate-400 uppercase tracking-wider mb-1">Where to?</label>
                        <div class="relative">
                            <span class="absolute left-3.5 top-1/2 -translate-y-1/2 text-slate-400">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" />
                                </svg>
                            </span>
                            <input type="text" name="search" placeholder="Search cities, areas, titles..." value="{{ request('search') }}"
                                   class="w-full pl-10 pr-4 py-3 bg-slate-50/80 border border-slate-200/80 rounded-xl text-sm font-semibold text-slate-800 placeholder-slate-400 focus:outline-none focus:border-steelAzure focus:bg-white transition-all">
                        </div>
                    </div>

                    <div class="md:col-span-4 relative border-t md:border-t-0 md:border-l border-slate-200/60 pt-3 md:pt-0 md:pl-4">
                        <label class="block text-[10px] font-extrabold text-slate-400 uppercase tracking-wider mb-1">Budget Target</label>
                        <select name="max_price" class="w-full bg-slate-50/80 border border-slate-200/80 rounded-xl px-3 py-3 text-sm font-semibold text-slate-800 focus:outline-none focus:border-steelAzure focus:bg-white transition-all">
                            <option value="" {{ request('max_price') == '' ? 'selected' : '' }}>Any Budget</option>
                            <option value="5000" {{ request('max_price') == '5000' ? 'selected' : '' }}>Under ₹5,000</option>
                            <option value="10000" {{ request('max_price') == '10000' ? 'selected' : '' }}>Under ₹10,000</option>
                            <option value="25000" {{ request('max_price') == '25000' ? 'selected' : '' }}>Under ₹25,000</option>
                            <option value="50000" {{ request('max_price') == '50000' ? 'selected' : '' }}>Under ₹50,000</option>
                            <option value="100000" {{ request('max_price') == '100000' ? 'selected' : '' }}>Under ₹100,000</option>
                        </select>
                    </div>

                    <div class="md:col-span-3 pt-2 md:pt-0 flex flex-col">
                        <label class="block text-[10px] font-extrabold text-transparent uppercase tracking-wider mb-1 select-none hidden md:block" aria-hidden="true">&nbsp;</label>
                        <button type="submit" class="w-full py-3 bg-steelAzure hover:bg-steelAzure/95 text-white font-extrabold text-xs tracking-wider uppercase rounded-xl shadow-lg shadow-steelAzure/20 transition-all flex items-center justify-center gap-2 group">
                            Search
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 group-hover:translate-x-1 transition-transform" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M14 5l7 7m0 0l-7 7m7-7H3" />
                            </svg>
                        </button>
                    </div>
                </form>
            </div>

            <!-- Inline Trust badges -->
            <div class="flex items-center justify-center gap-8 text-slate-400 font-bold text-xs pt-2">
                <div class="flex items-center gap-1.5">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-steelAzure" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z" />
                    </svg>
                    <span>100% Secured Leases</span>
                </div>
                <div class="flex items-center gap-1.5">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-emerald-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.2" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z" />
                    </svg>
                    <span>Realtime Landlord Chat</span>
                </div>
            </div>
        </div>

    </div>
</section>


<!-- SECTION 3: CORE UTILITIES ROW -->
<section class="max-w-7xl mx-auto px-6 py-8">
    <div class="grid grid-cols-1 md:grid-cols-4 gap-6">
        <!-- Feature 1 -->
        <div class="p-6 bg-white border border-slate-100 rounded-2xl shadow-sm flex gap-4 hover:border-steelAzure/20 transition-all duration-300">
            <div class="h-10 w-10 rounded-xl bg-steelAzure/10 text-steelAzure flex items-center justify-center flex-shrink-0">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z" />
                </svg>
            </div>
            <div>
                <h4 class="text-sm font-black text-slate-800 uppercase tracking-wide">VERIFIED SPACES</h4>
                <p class="text-xs text-slate-400 mt-1 leading-relaxed">Direct identity & property documentation checks.</p>
            </div>
        </div>
        <!-- Feature 2 -->
        <div class="p-6 bg-white border border-slate-100 rounded-2xl shadow-sm flex gap-4 hover:border-emerald-500/20 transition-all duration-300">
            <div class="h-10 w-10 rounded-xl bg-emerald-50 text-emerald-600 flex items-center justify-center flex-shrink-0">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z" />
                </svg>
            </div>
            <div>
                <h4 class="text-sm font-black text-slate-800 uppercase tracking-wide">DIRECT CHAT</h4>
                <p class="text-xs text-slate-400 mt-1 leading-relaxed">Message space providers instantly to resolve queries.</p>
            </div>
        </div>
        <!-- Feature 3 -->
        <div class="p-6 bg-white border border-slate-100 rounded-2xl shadow-sm flex gap-4 hover:border-indigo-500/20 transition-all duration-300">
            <div class="h-10 w-10 rounded-xl bg-indigo-50 text-indigo-600 flex items-center justify-center flex-shrink-0">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z" />
                </svg>
            </div>
            <div>
                <h4 class="text-sm font-black text-slate-800 uppercase tracking-wide">FAST LEASING</h4>
                <p class="text-xs text-slate-400 mt-1 leading-relaxed">Submit bookings and receive instant status alerts.</p>
            </div>
        </div>
        <!-- Feature 4 -->
        <div class="p-6 bg-white border border-slate-100 rounded-2xl shadow-sm flex gap-4 hover:border-rose-500/20 transition-all duration-300">
            <div class="h-10 w-10 rounded-xl bg-rose-50 text-rose-600 flex items-center justify-center flex-shrink-0">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z" />
                </svg>
            </div>
            <div>
                <h4 class="text-sm font-black text-slate-800 uppercase tracking-wide">SECURE RENT</h4>
                <p class="text-xs text-slate-400 mt-1 leading-relaxed">Secured digital payments via integrated Razorpay.</p>
            </div>
        </div>
    </div>
</section>

<!-- SECTION 4: EXPLORE CATEGORIES -->
<section class="max-w-7xl mx-auto px-6 py-10 scroll-reveal categories-container-wrapper">
    <div class="mb-10 text-center max-w-xl mx-auto space-y-2">
        <h2 class="text-3xl font-black text-slate-800 tracking-tight">Explore Spaces by Category</h2>
        <p class="text-sm text-slate-450 leading-relaxed">Browse verified spots tailored to your functional requirements.</p>
    </div>
    
    <div id="categories-grid" class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 lg:grid-cols-6 gap-6">
        @foreach ($categories as $cat)
            <div class="category-btn-wrapper flex">
                <a href="/category/{{ $cat['name'] }}" 
                   class="premium-category-btn w-full group bg-white border border-slate-100 rounded-2xl p-4 text-center flex flex-col items-center gap-4">
                    <div class="h-24 w-full rounded-xl overflow-hidden border border-slate-50 relative group-hover:border-steelAzure/20 transition-colors duration-300">
                        <img src="{{ $cat['image'] }}" alt="{{ $cat['name'] }}" class="w-full h-full object-cover group-hover:scale-108 transition-transform duration-500">
                    </div>
                    <span class="text-xs font-black text-slate-700 uppercase tracking-widest transition group-hover:text-steelAzure">{{ $cat['name'] }}</span>
                </a>
            </div>
        @endforeach
    </div>
    
    <div class="view-more-btn-wrapper justify-center mt-8">
        <button onclick="document.getElementById('categories-grid').classList.add('categories-expanded')" 
                class="px-6 py-3 bg-white border border-slate-200 hover:border-steelAzure hover:text-steelAzure text-slate-600 font-extrabold rounded-xl text-xs shadow-sm transition duration-150 flex items-center gap-2">
            View More Categories
            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 animate-bounce" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M19 9l-7 7-7-7" /></svg>
        </button>
    </div>
</section>

<!-- SECTION 4.5: FEATURED DIRECTORY -->
@php
    $featuredListings = $properties->where('is_featured', true);
    if ($featuredListings->isEmpty()) {
        $featuredListings = $properties->take(4);
    }
@endphp

@if (!$featuredListings->isEmpty())
<section class="max-w-7xl mx-auto px-6 py-10 scroll-reveal">
    <div class="mb-10 pb-6 border-b border-slate-100">
        <span class="text-xs font-black text-amber-500 uppercase tracking-widest block mb-2">★ PREMIUM SELECTION</span>
        <h2 class="text-3xl font-black text-slate-800 tracking-tight">Featured Listings</h2>
        <p class="text-sm text-slate-450 mt-1">Explore our most premium and highly recommended verified spaces.</p>
    </div>

    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-8">
        @foreach ($featuredListings as $prop)
            <div class="listing-premium-card group bg-white rounded-[20px] overflow-hidden flex flex-col h-full relative border border-amber-200/80 shadow-md">
                <!-- Image Area -->
                <div class="h-56 bg-slate-100 overflow-hidden relative shimmer-hover">
                    <img src="{{ !empty($prop->images) && is_array($prop->images) ? $prop->images[0] : 'https://images.unsplash.com/photo-1564013799919-ab600027ffc6?auto=format&fit=crop&w=600&q=80' }}" 
                         alt="{{ $prop->title }}" class="h-full w-full object-cover group-hover:scale-106 transition-transform duration-700 ease-out">
                    
                    <!-- Featured Glass Tag Overlay -->
                    <span class="absolute top-4 left-4 px-2.5 py-1 bg-gradient-to-r from-amber-500 to-orange-500 text-[9px] font-black text-white rounded-lg uppercase tracking-wider shadow-sm flex items-center gap-1">
                        ★ FEATURED
                    </span>

                    <!-- Overlay Category Glass Tag -->
                    <span class="absolute top-4 right-4 px-2.5 py-1 bg-white/90 backdrop-blur-md text-[9px] font-black text-steelAzure rounded-lg uppercase tracking-wider border border-white/20">
                        {{ $prop->category }}
                    </span>

                    @if(in_array($prop->listing_type, ['rent', 'sale']))
                        <span class="absolute bottom-4 right-4 px-2.5 py-1 bg-amber-500 text-white text-[9px] font-black rounded-lg uppercase tracking-wider shadow-sm">
                            FOR {{ strtoupper($prop->listing_type) }}
                        </span>
                    @endif

                    <!-- Host Avatar Badge Overlay -->
                    @if($prop->owner)
                        <div class="absolute bottom-4 left-4 flex items-center gap-2 bg-slate-900/80 backdrop-blur-md px-2.5 py-1 rounded-xl border border-white/10" title="Listed by {{ $prop->owner->name }}">
                            <div class="h-5 w-5 rounded-full overflow-hidden border border-white bg-slate-100 flex-shrink-0">
                                <img src="https://ui-avatars.com/api/?name={{ urlencode($prop->owner->name) }}&background=1A447C&color=fff" alt="owner" class="h-full w-full object-cover">
                            </div>
                            <span class="text-[9px] font-bold text-white max-w-[70px] truncate">{{ $prop->owner->name }}</span>
                        </div>
                    @endif
                </div>

                <!-- Details Area -->
                <div class="p-5 flex-1 flex flex-col justify-between space-y-4">
                    <div class="space-y-2">
                        <h3 class="font-extrabold text-slate-800 text-base leading-snug truncate group-hover:text-amber-500 transition-colors duration-200">
                            <a href="/properties/{{ $prop->id }}">{{ $prop->title }}</a>
                        </h3>
                        <div class="flex items-center gap-1.5 text-xs font-semibold text-slate-400">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-3.5 w-3.5 text-slate-300" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" />
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" />
                            </svg>
                            <span class="truncate">{{ $prop->address }}</span>
                        </div>
                    </div>

                    <div class="border-t border-slate-50 pt-4 flex items-center justify-between">
                        <div>
                            <span class="text-[9px] font-extrabold text-slate-400 block uppercase tracking-wider">{{ strtoupper($prop->listing_type) }} PRICE</span>
                            <span class="text-lg font-black text-amber-500">{{ $prop->formatted_price }}</span>
                        </div>
                        <div class="text-right">
                            <span class="text-[9px] font-extrabold text-slate-400 block uppercase tracking-wider">
                                @if($prop->listing_type === 'sale') SPACE @else AMENITIES @endif
                            </span>
                            <span class="text-xs font-black text-slate-700">
                                @if($prop->listing_type === 'sale')
                                    {{ $prop->built_up_area ?? 0 }} sq ft
                                @else
                                    {{ $prop->bedrooms }} bd • {{ $prop->bathrooms }} ba
                                @endif
                            </span>
                        </div>
                    </div>
                </div>
            </div>
        @endforeach
    </div>
</section>
@endif

<!-- SECTION 5: RECOMMENDED DIRECTORY -->
<section class="max-w-7xl mx-auto px-6 py-10 scroll-reveal">
    <div class="flex flex-col md:flex-row md:items-end justify-between mb-10 pb-6 border-b border-slate-100 gap-4">
        <div>
            <h2 class="text-3xl font-black text-slate-800 tracking-tight">
                @if ($search)
                    Search Results for "{{ $search }}"
                @else
                    Recommended Spaces to Lease
                @endif
            </h2>
            <p class="text-sm text-slate-450 mt-1">Hand-picked verified spots with updated pricing schedules.</p>
        </div>
        <div class="flex-shrink-0">
            <a href="/" class="inline-flex items-center gap-2 px-5 py-2.5 bg-slate-100 hover:bg-steelAzure text-slate-700 hover:text-white font-extrabold text-xs uppercase tracking-wider rounded-xl transition-all duration-300">
                View All Listings
                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.2" d="M9 5l7 7-7 7" />
                </svg>
            </a>
        </div>
    </div>

    @if ($properties->isEmpty())
        <div class="bg-white rounded-2xl border border-slate-100 p-16 text-center text-slate-400 shadow-sm max-w-xl mx-auto space-y-4">
            <div class="h-16 w-16 bg-slate-50 text-slate-400 rounded-full flex items-center justify-center mx-auto">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8 text-slate-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6" />
                </svg>
            </div>
            <div>
                <p class="font-extrabold text-slate-700">No Listings Found</p>
                <p class="text-xs text-slate-400 mt-1 max-w-xs mx-auto">Try clearing search parameters or adjusting budget limit dropdown filters.</p>
            </div>
            <a href="/" class="inline-block px-4 py-2 bg-steelAzure text-white text-xs font-bold rounded-lg hover:bg-steelAzure/90 transition">
                Reset Filters
            </a>
        </div>
    @else
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-8">
            @foreach ($properties->take(8) as $prop)
                <div class="listing-premium-card group bg-white rounded-[20px] overflow-hidden flex flex-col h-full relative">
                    <!-- Image Area -->
                    <div class="h-56 bg-slate-100 overflow-hidden relative shimmer-hover">
                        <img src="{{ !empty($prop->images) && is_array($prop->images) ? $prop->images[0] : 'https://images.unsplash.com/photo-1564013799919-ab600027ffc6?auto=format&fit=crop&w=600&q=80' }}" 
                             alt="{{ $prop->title }}" class="h-full w-full object-cover group-hover:scale-106 transition-transform duration-700 ease-out">
                        
                        <!-- Overlay Category Glass Tag -->
                        <span class="absolute top-4 right-4 px-2.5 py-1 bg-white/90 backdrop-blur-md text-[9px] font-black text-steelAzure rounded-lg uppercase tracking-wider border border-white/20">
                            {{ $prop->category }}
                        </span>

                        @if(in_array($prop->listing_type, ['rent', 'sale']))
                            <span class="absolute top-4 left-4 px-2.5 py-1 bg-amber-500 text-white text-[9px] font-black rounded-lg uppercase tracking-wider shadow-sm">
                                FOR {{ strtoupper($prop->listing_type) }}
                            </span>
                        @endif

                        <!-- Host Avatar Badge Overlay -->
                        @if($prop->owner)
                            <div class="absolute bottom-4 left-4 flex items-center gap-2 bg-slate-900/80 backdrop-blur-md px-2.5 py-1 rounded-xl border border-white/10" title="Listed by {{ $prop->owner->name }}">
                                <div class="h-5 w-5 rounded-full overflow-hidden border border-white bg-slate-100 flex-shrink-0">
                                    <img src="https://ui-avatars.com/api/?name={{ urlencode($prop->owner->name) }}&background=1A447C&color=fff" alt="owner" class="h-full w-full object-cover">
                                </div>
                                <span class="text-[9px] font-bold text-white max-w-[70px] truncate">{{ $prop->owner->name }}</span>
                            </div>
                        @endif

                        <!-- Heart Action Button (Wishlist Placeholder) -->
                        <button type="button" class="absolute top-4 right-4 h-8 w-8 rounded-full bg-white/90 backdrop-blur-sm flex items-center justify-center text-slate-400 hover:text-rose-500 hover:scale-110 transition-all shadow-sm">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z" />
                            </svg>
                        </button>
                    </div>

                    <!-- Details Area -->
                    <div class="p-5 flex-1 flex flex-col justify-between space-y-4">
                        <div class="space-y-2">
                            <h3 class="font-extrabold text-slate-800 text-base leading-snug truncate group-hover:text-steelAzure transition-colors duration-200">
                                <a href="/properties/{{ $prop->id }}">{{ $prop->title }}</a>
                            </h3>
                            <div class="flex items-center gap-1.5 text-xs font-semibold text-slate-400">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-3.5 w-3.5 text-slate-300" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" />
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" />
                                </svg>
                                <span class="truncate">{{ $prop->address }}</span>
                            </div>
                        </div>

                        <div class="border-t border-slate-50 pt-4 flex items-center justify-between">
                            <div>
                                <span class="text-[9px] font-extrabold text-slate-400 block uppercase tracking-wider">{{ strtoupper($prop->listing_type) }} PRICE</span>
                                <span class="text-lg font-black text-steelAzure">{{ $prop->formatted_price }}</span>
                            </div>
                            <div class="text-right">
                                <span class="text-[9px] font-extrabold text-slate-400 block uppercase tracking-wider">
                                    @if($prop->listing_type === 'sale') SPACE @else AMENITIES @endif
                                </span>
                                <span class="text-xs font-black text-slate-700">
                                    @if($prop->listing_type === 'sale')
                                        {{ $prop->built_up_area ?? 0 }} sq ft
                                    @else
                                        {{ $prop->bedrooms }} bd • {{ $prop->bathrooms }} ba
                                    @endif
                                </span>
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    @endif
</section>

<!-- SECTION 6: CATEGORY VILLAS CAROUSEL GRID -->
@if ($properties->where('category', 'Villa')->isNotEmpty())
<section class="bg-slate-50/50 border-y border-slate-100/80 py-12 px-6 scroll-reveal">
    <div class="max-w-7xl mx-auto">
        <div class="flex flex-col md:flex-row items-baseline justify-between mb-12 gap-4">
            <div>
                <span class="text-xs font-black text-steelAzure uppercase tracking-widest block mb-2">Exquisite Escapes</span>
                <h2 class="text-3xl font-black text-slate-800 tracking-tight">Premium Beachfront Villas</h2>
            </div>
            <div>
                <a href="/category/Villa" class="inline-flex items-center gap-1.5 text-xs font-bold text-steelAzure hover:underline">
                    View All Villas 
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M9 5l7 7-7 7" /></svg>
                </a>
            </div>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
            @foreach ($properties->where('category', 'Villa')->take(3) as $villa)
                <div class="listing-premium-card group bg-white rounded-2xl overflow-hidden flex flex-col">
                    <div class="h-52 overflow-hidden relative shimmer-hover">
                        <img src="{{ !empty($villa->images) && is_array($villa->images) ? $villa->images[0] : 'https://images.unsplash.com/photo-1512917774080-9991f1c4c750?auto=format&fit=crop&w=600&q=80' }}" alt="villa" class="h-full w-full object-cover group-hover:scale-106 transition-transform duration-500">
                    </div>
                    <div class="p-6 space-y-3">
                        <h3 class="font-extrabold text-slate-800 text-base leading-snug truncate group-hover:text-steelAzure transition-colors">
                            <a href="/properties/{{ $villa->id }}">{{ $villa->title }}</a>
                        </h3>
                        <p class="text-xs font-semibold text-slate-400 truncate flex items-center gap-1">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-3.5 w-3.5 text-slate-300" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" />
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" />
                            </svg>
                            <span>{{ $villa->address }}</span>
                        </p>
                        <div class="flex items-center justify-between border-t border-slate-50 pt-4">
                            <div>
                                <span class="text-[9px] font-extrabold text-slate-400 block uppercase tracking-wider">{{ strtoupper($villa->listing_type) }} PRICE</span>
                                <span class="text-base font-black text-steelAzure">{{ $villa->formatted_price }}</span>
                            </div>
                            <span class="text-xs font-extrabold text-slate-500 uppercase tracking-wider">
                                @if($villa->listing_type === 'sale')
                                    {{ $villa->built_up_area ?? 0 }} sq ft
                                @else
                                    {{ $villa->bedrooms }} Bedrooms
                                @endif
                            </span>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
</section>
@endif

<!-- SECTION 7: APARTMENTS & FLATS -->
@if ($properties->where('category', 'Apartment')->isNotEmpty())
<section class="max-w-7xl mx-auto px-6 py-10 scroll-reveal">
    <div class="flex flex-col md:flex-row items-baseline justify-between mb-12 gap-4">
        <div>
            <span class="text-xs font-black text-indigo-600 uppercase tracking-widest block mb-2">Prime Living</span>
            <h2 class="text-3xl font-black text-slate-800 tracking-tight">Top Flats Nearby You</h2>
        </div>
        <div>
            <a href="/category/Apartment" class="inline-flex items-center gap-1.5 text-xs font-bold text-indigo-600 hover:underline">
                Explore Flats
                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M9 5l7 7-7 7" /></svg>
            </a>
        </div>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
        @foreach ($properties->where('category', 'Apartment')->take(3) as $flat)
            <div class="listing-premium-card group bg-white rounded-2xl overflow-hidden flex flex-col">
                <div class="h-52 overflow-hidden relative shimmer-hover">
                    <img src="{{ !empty($flat->images) && is_array($flat->images) ? $flat->images[0] : 'https://images.unsplash.com/photo-1522708323590-d24dbb6b0267?auto=format&fit=crop&w=600&q=80' }}" alt="flat" class="h-full w-full object-cover group-hover:scale-106 transition-transform duration-500">
                </div>
                <div class="p-6 space-y-3">
                    <h3 class="font-extrabold text-slate-800 text-base leading-snug truncate group-hover:text-indigo-600 transition-colors">
                        <a href="/properties/{{ $flat->id }}">{{ $flat->title }}</a>
                    </h3>
                    <p class="text-xs font-semibold text-slate-400 truncate flex items-center gap-1">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-3.5 w-3.5 text-slate-300" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" />
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" />
                        </svg>
                        <span>{{ $flat->address }}</span>
                    </p>
                    <div class="flex items-center justify-between border-t border-slate-50 pt-4">
                            <div>
                                <span class="text-[9px] font-extrabold text-slate-400 block uppercase tracking-wider">{{ strtoupper($flat->listing_type) }} PRICE</span>
                                <span class="text-base font-black text-slate-800">{{ $flat->formatted_price }}</span>
                            </div>
                        <span class="text-xs font-extrabold text-slate-500 uppercase tracking-wider">
                            @if($flat->listing_type === 'sale')
                                {{ $flat->built_up_area ?? 0 }} sq ft
                            @else
                                {{ $flat->bedrooms }} Bedrooms
                            @endif
                        </span>
                    </div>
                </div>
            </div>
        @endforeach
    </div>
</section>
@endif

<!-- SECTION 8: POPULAR LOCATIONS -->
<section class="max-w-7xl mx-auto px-6 pb-12 scroll-reveal">
    <div class="text-center mb-16 max-w-xl mx-auto space-y-2">
        <h2 class="text-3xl font-black text-slate-800 tracking-tight">Popular Locations</h2>
        <p class="text-sm text-slate-450 leading-relaxed">Discover listing hotspots curated by local demand metrics.</p>
    </div>

    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
        <!-- Location 1 -->
        <div class="group relative rounded-2xl overflow-hidden h-72 shadow-sm border border-slate-100 shimmer-hover">
            <img src="https://images.unsplash.com/photo-1507525428034-b723cf961d3e?auto=format&fit=crop&w=400&q=80" alt="Miami" class="absolute inset-0 w-full h-full object-cover group-hover:scale-106 transition-transform duration-500">
            <div class="absolute inset-0 bg-gradient-to-t from-slate-950/80 via-slate-900/20 to-transparent"></div>
            <div class="absolute bottom-6 left-6 text-white z-10 space-y-1">
                <h3 class="font-extrabold text-lg">Miami Beach</h3>
                <p class="text-[10px] text-slate-300 font-bold uppercase tracking-wider">Beachfront Villas & Studios</p>
            </div>
        </div>
        <!-- Location 2 -->
        <div class="group relative rounded-2xl overflow-hidden h-72 shadow-sm border border-slate-100 shimmer-hover">
            <img src="https://images.unsplash.com/photo-1496442226666-8d4d0e62e6e9?auto=format&fit=crop&w=400&q=80" alt="New York" class="absolute inset-0 w-full h-full object-cover group-hover:scale-106 transition-transform duration-500">
            <div class="absolute inset-0 bg-gradient-to-t from-slate-950/80 via-slate-900/20 to-transparent"></div>
            <div class="absolute bottom-6 left-6 text-white z-10 space-y-1">
                <h3 class="font-extrabold text-lg">New York City</h3>
                <p class="text-[10px] text-slate-300 font-bold uppercase tracking-wider">Downtown Luxury Apartments</p>
            </div>
        </div>
        <!-- Location 3 -->
        <div class="group relative rounded-2xl overflow-hidden h-72 shadow-sm border border-slate-100 shimmer-hover">
            <img src="https://images.unsplash.com/photo-1531842477197-54f8c4b8b209?auto=format&fit=crop&w=400&q=80" alt="Austin" class="absolute inset-0 w-full h-full object-cover group-hover:scale-106 transition-transform duration-500">
            <div class="absolute inset-0 bg-gradient-to-t from-slate-950/80 via-slate-900/20 to-transparent"></div>
            <div class="absolute bottom-6 left-6 text-white z-10 space-y-1">
                <h3 class="font-extrabold text-lg">Austin Town</h3>
                <p class="text-[10px] text-slate-300 font-bold uppercase tracking-wider">Cosy Family Houses</p>
            </div>
        </div>
        <!-- Location 4 -->
        <div class="group relative rounded-2xl overflow-hidden h-72 shadow-sm border border-slate-100 shimmer-hover">
            <img src="https://images.unsplash.com/photo-1502082553048-f009c37129b9?auto=format&fit=crop&w=400&q=80" alt="Seattle" class="absolute inset-0 w-full h-full object-cover group-hover:scale-106 transition-transform duration-500">
            <div class="absolute inset-0 bg-gradient-to-t from-slate-950/80 via-slate-900/20 to-transparent"></div>
            <div class="absolute bottom-6 left-6 text-white z-10 space-y-1">
                <h3 class="font-extrabold text-lg">Seattle Square</h3>
                <p class="text-[10px] text-slate-300 font-bold uppercase tracking-wider">Commercial Storefront Shops</p>
            </div>
        </div>
    </div>
</section>

<!-- SECTION 9: PARTNER LANDLORDS TICKER -->
<section class="max-w-7xl mx-auto px-6 py-10 overflow-hidden relative scroll-reveal">
    <div class="text-center mb-12 max-w-xl mx-auto space-y-2">
        <span class="text-xs font-black text-steelAzure uppercase tracking-widest block">Space Partners</span>
        <h2 class="text-3xl font-black text-slate-800 tracking-tight">Top Rated Space Lister Partners</h2>
        <p class="text-sm text-slate-450 leading-relaxed">Verified landlords maintaining premium spaces with prompt reply records.</p>
    </div>

    <!-- Infinite Marquee Ticker -->
    <div class="relative w-full overflow-hidden py-6">
        <!-- Gradient overlays -->
        <div class="absolute inset-y-0 left-0 w-24 bg-gradient-to-r from-[#f8fafc] to-transparent z-10 pointer-events-none"></div>
        <div class="absolute inset-y-0 right-0 w-24 bg-gradient-to-l from-[#f8fafc] to-transparent z-10 pointer-events-none"></div>
        
        <div class="flex w-max gap-8 animate-[marquee_30s_linear_infinite] hover:[animation-play-state:paused]">
            <!-- Loop 1 -->
            <div class="flex gap-8">
                <div class="flex flex-col items-center justify-center bg-white border border-slate-100 p-6 rounded-2xl w-48 shadow-sm hover:shadow-lg hover:border-steelAzure/30 transition-all duration-350 flex-shrink-0">
                    <div class="h-20 w-20 rounded-full overflow-hidden border-2 border-slate-100 mb-3">
                        <img src="https://images.unsplash.com/photo-1472099645785-5658abf4ff4e?auto=format&fit=facearea&facepad=2&w=256&h=256&q=80" alt="John" class="h-full w-full object-cover">
                    </div>
                    <h4 class="font-bold text-slate-800 text-sm">John Lister</h4>
                    <p class="text-[10px] text-slate-400 mt-1">12 Listed Properties</p>
                </div>
                <div class="flex flex-col items-center justify-center bg-white border border-slate-100 p-6 rounded-2xl w-48 shadow-sm hover:shadow-lg hover:border-steelAzure/30 transition-all duration-350 flex-shrink-0">
                    <div class="h-20 w-20 rounded-full overflow-hidden border-2 border-slate-100 mb-3">
                        <img src="https://images.unsplash.com/photo-1494790108377-be9c29b29330?auto=format&fit=facearea&facepad=2&w=256&h=256&q=80" alt="Sarah" class="h-full w-full object-cover">
                    </div>
                    <h4 class="font-bold text-slate-800 text-sm">Sarah Host</h4>
                    <p class="text-[10px] text-slate-400 mt-1">8 Spaces Verified</p>
                </div>
                <div class="flex flex-col items-center justify-center bg-white border border-slate-100 p-6 rounded-2xl w-48 shadow-sm hover:shadow-lg hover:border-steelAzure/30 transition-all duration-350 flex-shrink-0">
                    <div class="h-20 w-20 rounded-full overflow-hidden border-2 border-slate-100 mb-3">
                        <img src="https://images.unsplash.com/photo-1507003211169-0a1dd7228f2d?auto=format&fit=facearea&facepad=2&w=256&h=256&q=80" alt="Mark" class="h-full w-full object-cover">
                    </div>
                    <h4 class="font-bold text-slate-800 text-sm">Mark King</h4>
                    <p class="text-[10px] text-slate-400 mt-1">Unlimited Tier Lister</p>
                </div>
                <div class="flex flex-col items-center justify-center bg-white border border-slate-100 p-6 rounded-2xl w-48 shadow-sm hover:shadow-lg hover:border-steelAzure/30 transition-all duration-350 flex-shrink-0">
                    <div class="h-20 w-20 rounded-full overflow-hidden border-2 border-slate-100 mb-3">
                        <img src="https://images.unsplash.com/photo-1517841905240-472988babdf9?auto=format&fit=facearea&facepad=2&w=256&h=256&q=80" alt="Alice" class="h-full w-full object-cover">
                    </div>
                    <h4 class="font-bold text-slate-800 text-sm">Alice Green</h4>
                    <p class="text-[10px] text-slate-400 mt-1">Top Rated Host</p>
                </div>
                <div class="flex flex-col items-center justify-center bg-white border border-slate-100 p-6 rounded-2xl w-48 shadow-sm hover:shadow-lg hover:border-steelAzure/30 transition-all duration-350 flex-shrink-0">
                    <div class="h-20 w-20 rounded-full overflow-hidden border-2 border-slate-100 mb-3">
                        <img src="https://images.unsplash.com/photo-1500648767791-00dcc994a43e?auto=format&fit=facearea&facepad=2&w=256&h=256&q=80" alt="David" class="h-full w-full object-cover">
                    </div>
                    <h4 class="font-bold text-slate-800 text-sm">David Rent</h4>
                    <p class="text-[10px] text-slate-400 mt-1">Premium Partner</p>
                </div>
                <div class="flex flex-col items-center justify-center bg-white border border-slate-100 p-6 rounded-2xl w-48 shadow-sm hover:shadow-lg hover:border-steelAzure/30 transition-all duration-350 flex-shrink-0">
                    <div class="h-20 w-20 rounded-full overflow-hidden border-2 border-slate-100 mb-3">
                        <img src="https://images.unsplash.com/photo-1438761681033-6461ffad8d80?auto=format&fit=facearea&facepad=2&w=256&h=256&q=80" alt="Emily" class="h-full w-full object-cover">
                    </div>
                    <h4 class="font-bold text-slate-800 text-sm">Emily Space</h4>
                    <p class="text-[10px] text-slate-400 mt-1">Verified Host</p>
                </div>
            </div>
            <!-- Loop 2 (identical for seamless scroller) -->
            <div class="flex gap-8">
                <div class="flex flex-col items-center justify-center bg-white border border-slate-100 p-6 rounded-2xl w-48 shadow-sm hover:shadow-lg hover:border-steelAzure/30 transition-all duration-350 flex-shrink-0">
                    <div class="h-20 w-20 rounded-full overflow-hidden border-2 border-slate-100 mb-3">
                        <img src="https://images.unsplash.com/photo-1472099645785-5658abf4ff4e?auto=format&fit=facearea&facepad=2&w=256&h=256&q=80" alt="John" class="h-full w-full object-cover">
                    </div>
                    <h4 class="font-bold text-slate-800 text-sm">John Lister</h4>
                    <p class="text-[10px] text-slate-400 mt-1">12 Listed Properties</p>
                </div>
                <div class="flex flex-col items-center justify-center bg-white border border-slate-100 p-6 rounded-2xl w-48 shadow-sm hover:shadow-lg hover:border-steelAzure/30 transition-all duration-350 flex-shrink-0">
                    <div class="h-20 w-20 rounded-full overflow-hidden border-2 border-slate-100 mb-3">
                        <img src="https://images.unsplash.com/photo-1494790108377-be9c29b29330?auto=format&fit=facearea&facepad=2&w=256&h=256&q=80" alt="Sarah" class="h-full w-full object-cover">
                    </div>
                    <h4 class="font-bold text-slate-800 text-sm">Sarah Host</h4>
                    <p class="text-[10px] text-slate-400 mt-1">8 Spaces Verified</p>
                </div>
                <div class="flex flex-col items-center justify-center bg-white border border-slate-100 p-6 rounded-2xl w-48 shadow-sm hover:shadow-lg hover:border-steelAzure/30 transition-all duration-350 flex-shrink-0">
                    <div class="h-20 w-20 rounded-full overflow-hidden border-2 border-slate-100 mb-3">
                        <img src="https://images.unsplash.com/photo-1507003211169-0a1dd7228f2d?auto=format&fit=facearea&facepad=2&w=256&h=256&q=80" alt="Mark" class="h-full w-full object-cover">
                    </div>
                    <h4 class="font-bold text-slate-800 text-sm">Mark King</h4>
                    <p class="text-[10px] text-slate-400 mt-1">Unlimited Tier Lister</p>
                </div>
                <div class="flex flex-col items-center justify-center bg-white border border-slate-100 p-6 rounded-2xl w-48 shadow-sm hover:shadow-lg hover:border-steelAzure/30 transition-all duration-350 flex-shrink-0">
                    <div class="h-20 w-20 rounded-full overflow-hidden border-2 border-slate-100 mb-3">
                        <img src="https://images.unsplash.com/photo-1517841905240-472988babdf9?auto=format&fit=facearea&facepad=2&w=256&h=256&q=80" alt="Alice" class="h-full w-full object-cover">
                    </div>
                    <h4 class="font-bold text-slate-800 text-sm">Alice Green</h4>
                    <p class="text-[10px] text-slate-400 mt-1">Top Rated Host</p>
                </div>
                <div class="flex flex-col items-center justify-center bg-white border border-slate-100 p-6 rounded-2xl w-48 shadow-sm hover:shadow-lg hover:border-steelAzure/30 transition-all duration-350 flex-shrink-0">
                    <div class="h-20 w-20 rounded-full overflow-hidden border-2 border-slate-100 mb-3">
                        <img src="https://images.unsplash.com/photo-1500648767791-00dcc994a43e?auto=format&fit=facearea&facepad=2&w=256&h=256&q=80" alt="David" class="h-full w-full object-cover">
                    </div>
                    <h4 class="font-bold text-slate-800 text-sm">David Rent</h4>
                    <p class="text-[10px] text-slate-400 mt-1">Premium Partner</p>
                </div>
                <div class="flex flex-col items-center justify-center bg-white border border-slate-100 p-6 rounded-2xl w-48 shadow-sm hover:shadow-lg hover:border-steelAzure/30 transition-all duration-350 flex-shrink-0">
                    <div class="h-20 w-20 rounded-full overflow-hidden border-2 border-slate-100 mb-3">
                        <img src="https://images.unsplash.com/photo-1438761681033-6461ffad8d80?auto=format&fit=facearea&facepad=2&w=256&h=256&q=80" alt="Emily" class="h-full w-full object-cover">
                    </div>
                    <h4 class="font-bold text-slate-800 text-sm">Emily Space</h4>
                    <p class="text-[10px] text-slate-400 mt-1">Verified Host</p>
                </div>
            </div>
        </div>
    </div>
</section>



<script>
    document.addEventListener('DOMContentLoaded', () => {
        // Initialize active search tab styling based on request parameter
        const activeSearchType = "{{ request('search_type', 'all') }}";
        selectSearchTab(activeSearchType);

        // Automatically request geo location if missing to sort properties
        const urlParams = new URLSearchParams(window.location.search);
        const storedLat = localStorage.getItem('user_latitude');
        const storedLng = localStorage.getItem('user_longitude');

        if (!urlParams.has('latitude') && !urlParams.has('longitude')) {
            if (storedLat && storedLng) {
                urlParams.set('latitude', storedLat);
                urlParams.set('longitude', storedLng);
                window.location.search = urlParams.toString();
            } else if (navigator.geolocation) {
                navigator.geolocation.getCurrentPosition((position) => {
                    const lat = position.coords.latitude;
                    const lng = position.coords.longitude;
                    localStorage.setItem('user_latitude', lat);
                    localStorage.setItem('user_longitude', lng);
                    urlParams.set('latitude', lat);
                    urlParams.set('longitude', lng);
                    window.location.search = urlParams.toString();
                }, (error) => {
                    console.log('Location access denied:', error);
                });
            }
        }
    });

    /**
     * Change search parameters based on active hero tab category
     */
    function selectSearchTab(type) {
        // Update hidden input
        document.getElementById('hidden-search-type').value = type;

        // Toggle button states
        document.querySelectorAll('.search-tab-btn').forEach(btn => {
            btn.classList.remove('bg-steelAzure', 'text-white', 'shadow-sm');
            btn.classList.add('text-slate-500', 'hover:text-slate-800', 'hover:bg-slate-100');
        });

        const activeId = 'tab-' + (type === 'all' ? 'all' : type.toLowerCase());
        const activeBtn = document.getElementById(activeId);
        if (activeBtn) {
            activeBtn.classList.remove('text-slate-500', 'hover:text-slate-800', 'hover:bg-slate-100');
            activeBtn.classList.add('bg-steelAzure', 'text-white', 'shadow-sm');
        }

        // Alter search action parameter dynamically
        const searchInput = document.querySelector('input[name="search"]');
        if (type !== 'all') {
            searchInput.placeholder = `Search for ${type}s, cities...`;
        } else {
            searchInput.placeholder = "Search cities, areas, titles...";
        }
    }
</script>
@endsection
