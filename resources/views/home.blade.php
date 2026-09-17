<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta content="width=device-width, initial-scale=1.0" name="viewport">
    
    <!-- Primary SEO Meta Tags -->
    <title>HomiQ - Verified Flats, PGs &amp; Properties for Rent, Buy and Sell</title>
    <meta name="title" content="HomiQ - Verified Flats, PGs & Properties for Rent, Buy and Sell">
    <meta name="description" content="Find verified flats, rooms, PGs and properties for rent or sale. Connect directly with owners, explore real listings and avoid unnecessary brokerage with HomiQ.">
    <meta name="keywords" content="flats for rent, no brokerage homes, PGs in Noida, verified rentals, apartments for sale, 2 BHK in Noida, rooms for rent, direct owner properties, commercial properties">
    <meta name="robots" content="index, follow">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="google-site-verification" content="{{ config('services.google.site_verification', 'google-site-verification-homiq-growth-2026') }}">
    <link rel="canonical" href="{{ \App\Helpers\SeoHelper::canonicalUrl(url()->current()) }}">
    <link rel="icon" type="image/png" href="{{ asset('logo.png') }}">

    <!-- Open Graph / Facebook -->
    <meta property="og:type" content="website">
    <meta property="og:url" content="{{ \App\Helpers\SeoHelper::canonicalUrl(url()->current()) }}">
    <meta property="og:title" content="HomiQ - Verified Flats, PGs & Properties for Rent, Buy and Sell">
    <meta property="og:description" content="Find verified flats, rooms, PGs and properties for rent or sale. Connect directly with owners, explore real listings and avoid unnecessary brokerage with HomiQ.">
    <meta property="og:image" content="{{ asset('logo.png') }}">

    <!-- Twitter / X -->
    <meta property="twitter:card" content="summary_large_image">
    <meta property="twitter:url" content="{{ \App\Helpers\SeoHelper::canonicalUrl(url()->current()) }}">
    <meta property="twitter:title" content="HomiQ - Verified Flats, PGs & Properties for Rent, Buy and Sell">
    <meta property="twitter:description" content="Find verified flats, rooms, PGs and properties for rent or sale. Connect directly with owners, explore real listings and avoid unnecessary brokerage with HomiQ.">
    <meta property="twitter:image" content="{{ asset('logo.png') }}">

    <!-- Structured Data (JSON-LD): Organization & WebSite with SearchAction -->
    <script type="application/ld+json">
    {
      "@@context": "https://schema.org",
      "@@graph": [
        {
          "@@type": "Organization",
          "@@id": "{{ url('/') }}/#organization",
          "name": "HomiQ",
          "url": "{{ url('/') }}",
          "logo": {
            "@@type": "ImageObject",
            "url": "{{ asset('logo.png') }}"
          },
          "description": "Verified residential and commercial real estate platform connecting owners and seekers with 0% brokerage.",
          "contactPoint": {
            "@@type": "ContactPoint",
            "contactType": "Customer Support",
            "availableLanguage": ["English", "Hindi"]
          }
        },
        {
          "@@type": "WebSite",
          "@@id": "{{ url('/') }}/#website",
          "url": "{{ url('/') }}",
          "name": "HomiQ",
          "publisher": {
            "@@id": "{{ url('/') }}/#organization"
          },
          "potentialAction": {
            "@@type": "SearchAction",
            "target": "{{ url('/') }}/?search={search_term_string}",
            "query-input": "required name=search_term_string"
          }
        }
      ]
    }
    </script>

    <!-- Google Fonts & Material Symbols -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&family=Plus+Jakarta+Sans:wght@500;600;700;800;900&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@20..48,100..700,0..1,-50..200" rel="stylesheet">

    <style>
        @layer base {
            html, body { margin: 0; padding: 0; scroll-behavior: smooth; }
            body { overscroll-behavior: none; }
            main > :first-child { margin-top: 0 !important; }
            main > :last-child { margin-bottom: 0 !important; }
        }
        ::-webkit-scrollbar { display: none; }
        .no-scrollbar::-webkit-scrollbar { display: none; }
        .no-scrollbar { -ms-overflow-style: none; scrollbar-width: none; }
        input:focus, select:focus, textarea:focus { outline: none !important; }
        .material-symbols-outlined {
            font-family: 'Material Symbols Outlined' !important;
            font-weight: normal;
            font-style: normal;
            font-size: 24px;
            line-height: 1;
            letter-spacing: normal;
            text-transform: none;
            display: inline-block;
            white-space: nowrap;
            word-wrap: normal;
            direction: ltr;
            vertical-align: middle;
        }
        [x-cloak] { display: none !important; }
    </style>

    <!-- Alpine.js -->
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>

    <script src="https://cdn.tailwindcss.com?plugins=forms,container-queries"></script>
    <script id="tailwind-config">
        tailwind.config = {
            darkMode: "class",
            theme: {
                extend: {
                    colors: {
                        "brandNavy": "#0A2540",
                        "brandEmerald": "#10B981",
                        "primary": "#0A2540",
                        "secondary": "#10B981",
                        "surface": "#ffffff",
                    },
                    fontFamily: {
                        "sans": ["Plus Jakarta Sans", "Inter", "sans-serif"],
                        "headline": ["Plus Jakarta Sans", "sans-serif"],
                        "body": ["Inter", "sans-serif"]
                    }
                }
            }
        };
    </script>

    <!-- HomiQ Analytics & Clarity Infrastructure -->
    @include('partials.analytics')
</head>
<body class="bg-white font-body text-slate-900 antialiased" x-data="{ 
    requestModalOpen: false, 
    shareModalOpen: false,
    filtersModalOpen: false,
    saveSearchModalOpen: false,
    saveSearchSubmitting: false,
    saveSearchSuccess: false,
    saveSearchMsg: '',
    viewMode: 'list',
    shareData: { title: '', address: '', price: '', url: '' },
    toastMessage: '',
    toastVisible: false,
    showToast(msg) {
        this.toastMessage = msg;
        this.toastVisible = true;
        setTimeout(() => { this.toastVisible = false; }, 3500);
    }
}">

    <!-- Toast Notification -->
    <div x-show="toastVisible" 
         x-cloak
         x-transition:enter="transition ease-out duration-300"
         x-transition:enter-start="opacity-0 translate-y-4 scale-95"
         x-transition:enter-end="opacity-100 translate-y-0 scale-100"
         x-transition:leave="transition ease-in duration-200"
         x-transition:leave-start="opacity-100 translate-y-0 scale-100"
         x-transition:leave-end="opacity-0 translate-y-4 scale-95"
         class="fixed bottom-6 right-6 z-50 flex items-center gap-3 px-5 py-3.5 bg-slate-900 text-white rounded-2xl shadow-2xl border border-slate-700 text-sm font-bold">
        <span class="material-symbols-outlined text-emerald-400 text-[20px]">check_circle</span>
        <span x-text="toastMessage"></span>
    </div>

    <!-- ==========================================
         SECTION 1: HEADER NAVIGATION
         (Logo | Buy | Rent | PG / Rooms | Commercial | List Property | Sign In)
         ========================================== -->
    <header class="fixed top-0 left-0 right-0 z-40 bg-white border-b border-slate-200">
        <div class="h-20 max-w-[1440px] mx-auto px-6 sm:px-8 flex items-center justify-between gap-6">
            <div class="flex items-center gap-8 xl:gap-10">
                <a class="flex items-center gap-3 focus:outline-none" href="/">
                    <img alt="HomiQ Brand Logo" class="h-9 w-auto object-contain" src="{{ asset('logo.png') }}">
                </a>
                <nav class="hidden lg:flex items-center gap-6 xl:gap-8">
                    <a class="text-sm font-bold text-slate-700 hover:text-brandNavy transition-colors flex items-center gap-1" href="/buy/noida">
                        <span>Buy</span>
                    </a>
                    <a class="text-sm font-bold text-slate-700 hover:text-brandNavy transition-colors flex items-center gap-1" href="/rent/noida">
                        <span>Rent</span>
                    </a>
                    <a class="text-sm font-bold text-slate-700 hover:text-brandNavy transition-colors flex items-center gap-1" href="/explore/student_pg">
                        <span>PG / Rooms</span>
                    </a>
                    <a class="text-sm font-bold text-slate-700 hover:text-brandNavy transition-colors flex items-center gap-1" href="/explore/commercial">
                        <span>Commercial</span>
                    </a>
                    <a class="text-sm font-bold text-slate-700 hover:text-brandNavy transition-colors" href="#demand-board">Demand Board</a>
                    <a class="text-sm font-bold text-slate-700 hover:text-brandNavy transition-colors" href="/pricing">Pricing</a>
                </nav>
            </div>
            <div class="flex items-center gap-3">
                <!-- Request Property Button -->
                <button type="button" @click="requestModalOpen = true" class="hidden sm:inline-flex items-center justify-center gap-2 h-11 px-5 rounded-full bg-emerald-50 hover:bg-emerald-100 text-emerald-800 font-bold text-xs border border-emerald-300 transition-all shadow-xs cursor-pointer shrink-0">
                    <span class="material-symbols-outlined text-[18px] text-emerald-700">post_add</span>
                    <span class="whitespace-nowrap">Post Request</span>
                </button>

                <!-- List Property Free -->
                <a class="inline-flex items-center justify-center h-11 px-5 sm:px-6 rounded-full bg-brandNavy text-white font-bold text-xs hover:bg-slate-900 transition-all shadow-sm" href="{{ route('host.add-property') }}">
                    List Property Free
                </a>

                @auth
                <a href="/dashboard" class="flex items-center gap-2.5 pl-2 py-1 pr-3 rounded-full bg-slate-100 hover:bg-slate-200 transition-colors">
                    @if(Auth::user()->profile_photo)
                        <img alt="{{ Auth::user()->name }}" class="w-8 h-8 rounded-full object-cover" src="{{ Auth::user()->profile_photo }}">
                    @else
                        <div class="w-8 h-8 rounded-full bg-emerald-600 text-white flex items-center justify-center font-bold text-xs">
                            {{ strtoupper(substr(Auth::user()->name, 0, 2)) }}
                        </div>
                    @endif
                    <div class="hidden md:flex flex-col text-left">
                        <span class="text-xs text-slate-900 leading-tight font-black">{{ Auth::user()->name }}</span>
                        <span class="text-[10px] text-emerald-700 font-bold">{{ Auth::user()->is_admin ? 'Admin' : (Auth::user()->is_host ? 'Host' : 'Seeker') }}</span>
                    </div>
                </a>
                @else
                <a href="/login" class="text-xs font-bold text-slate-800 hover:text-brandNavy px-2 transition-colors">Sign In</a>
                @endauth
            </div>
        </div>
    </header>

    <main class="w-full pt-20 bg-white">
        <div class="flex flex-col w-full">

            <!-- ==========================================
                 SECTION 2: HERO SEARCH
                 (Find Your Next Home Without Brokerage)
                 ========================================== -->
            <!-- ==========================================
                 SECTION 2: HERO SEARCH
                 (Find Your Next Home Without Brokerage)
                 ========================================== -->
            <section class="w-full bg-slate-50 border-b border-slate-200 py-16 sm:py-20" id="hero-search">
                <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
                    
                    <!-- Trust Pill -->
                    <div class="inline-flex items-center gap-2.5 px-4 py-1.5 rounded-full bg-white shadow-xs border border-slate-200 mb-6">
                        <span class="w-2 h-2 rounded-full bg-emerald-500 animate-pulse"></span>
                        <span class="text-xs font-bold text-slate-800">Find Verified Properties Without Brokerage</span>
                        <span class="text-slate-300">•</span>
                        <span class="text-xs font-bold text-emerald-700">100% On-Site Verified</span>
                        <span class="text-slate-300">•</span>
                        <span class="text-xs font-bold text-slate-700">Direct Owner Contact</span>
                    </div>

                    <!-- Main Headline & Subtitle -->
                    <h1 class="text-4xl sm:text-5xl lg:text-6xl font-black text-slate-900 tracking-tight leading-tight mb-4 max-w-4xl mx-auto">
                        Find Your Next Home Without Brokerage
                    </h1>
                    <p class="text-lg sm:text-xl font-bold text-emerald-700 max-w-2xl mx-auto mb-2">
                        Real Listings. Direct Owners. Clear Pricing.
                    </p>
                    <p class="text-sm sm:text-base font-medium text-slate-600 max-w-2xl mx-auto mb-8">
                        Search Flats, PGs and Rooms That Match Your Budget in Noida, Delhi NCR &amp; Bangalore.
                    </p>

                    <!-- Primary Dual CTAs -->
                    <div class="flex items-center justify-center gap-3 sm:gap-4 mb-10 flex-wrap">
                        <a href="#listings" class="h-12 px-7 rounded-full bg-brandNavy hover:bg-slate-900 text-white font-bold text-sm inline-flex items-center justify-center gap-2 shadow-sm transition-all active:scale-95">
                            <span class="material-symbols-outlined text-[19px] text-emerald-400">search</span>
                            <span>Search Properties</span>
                        </a>
                        <a href="{{ route('host.add-property') }}" class="h-12 px-7 rounded-full bg-white hover:bg-slate-100 text-slate-800 font-bold text-sm inline-flex items-center justify-center gap-2 border border-slate-300 transition-all shadow-xs active:scale-95">
                            <span class="material-symbols-outlined text-[19px] text-emerald-600">add_home</span>
                            <span>List Your Property Free</span>
                        </a>
                    </div>

                    <!-- Intelligent Search Container -->
                    <div class="w-full max-w-6xl mx-auto text-left" x-data="{
                        activePillar: '{{ (request('search_type') === 'Studio') ? 'pg' : ((request('search_type') === 'Shop') ? 'commercial' : (request('listing_type') === 'sale' ? 'buy' : 'rent')) }}',
                        subCategories: {
                            rent: [
                                { label: 'All Rent', type: '' },
                                { label: 'Flats & Apartments', type: 'Apartment' },
                                { label: 'Houses & Villas', type: 'House' },
                                { label: 'Rooms & PGs', type: 'Studio' }
                            ],
                            buy: [
                                { label: 'All Buy', type: '' },
                                { label: 'Flats & Apartments', type: 'Apartment' },
                                { label: 'Houses & Villas', type: 'House' },
                                { label: 'Plots & Land', type: 'Plot' }
                            ],
                            pg: [
                                { label: 'All PGs & Rooms', type: 'Studio' },
                                { label: 'Student Housing', type: 'Studio' },
                                { label: 'Co-Living Spaces', type: 'Studio' }
                            ],
                            commercial: [
                                { label: 'All Commercial', type: 'Shop' },
                                { label: 'Retail Shops', type: 'Shop' },
                                { label: 'Office Spaces', type: 'Office' },
                                { label: 'Warehouses', type: 'Warehouse' }
                            ]
                        },
                        setPillar(p) {
                            this.activePillar = p;
                            if (p === 'rent') {
                                document.getElementById('listing-type-hidden').value = 'rent';
                                document.getElementById('search-type-hidden').value = '';
                            } else if (p === 'buy') {
                                document.getElementById('listing-type-hidden').value = 'sale';
                                document.getElementById('search-type-hidden').value = '';
                            } else if (p === 'pg') {
                                document.getElementById('listing-type-hidden').value = 'rent';
                                document.getElementById('search-type-hidden').value = 'Studio';
                            } else if (p === 'commercial') {
                                document.getElementById('listing-type-hidden').value = '';
                                document.getElementById('search-type-hidden').value = 'Shop';
                            }
                        }
                    }">
                        
                        <!-- Top 4 Primary Pillars (Rent / Buy / PG / Commercial) -->
                        <div class="flex items-center justify-center gap-1.5 sm:gap-2 mb-3 flex-wrap">
                            <button type="button" @click="setPillar('rent')" :class="activePillar === 'rent' ? 'bg-brandNavy text-white shadow-sm' : 'bg-white text-slate-700 border border-slate-200 hover:bg-slate-100'" class="h-11 px-5 sm:px-6 rounded-full text-xs font-bold transition-all cursor-pointer flex items-center justify-center gap-1.5">
                                <span class="material-symbols-outlined text-[17px] text-emerald-400">key</span>
                                <span>Rent</span>
                            </button>
                            <button type="button" @click="setPillar('buy')" :class="activePillar === 'buy' ? 'bg-brandNavy text-white shadow-sm' : 'bg-white text-slate-700 border border-slate-200 hover:bg-slate-100'" class="h-11 px-5 sm:px-6 rounded-full text-xs font-bold transition-all cursor-pointer flex items-center justify-center gap-1.5">
                                <span class="material-symbols-outlined text-[17px] text-emerald-400">real_estate_agent</span>
                                <span>Buy</span>
                            </button>
                            <button type="button" @click="setPillar('pg')" :class="activePillar === 'pg' ? 'bg-brandNavy text-white shadow-sm' : 'bg-white text-slate-700 border border-slate-200 hover:bg-slate-100'" class="h-11 px-5 sm:px-6 rounded-full text-xs font-bold transition-all cursor-pointer flex items-center justify-center gap-1.5">
                                <span class="material-symbols-outlined text-[17px] text-emerald-400">single_bed</span>
                                <span>PG / Rooms</span>
                            </button>
                            <button type="button" @click="setPillar('commercial')" :class="activePillar === 'commercial' ? 'bg-brandNavy text-white shadow-sm' : 'bg-white text-slate-700 border border-slate-200 hover:bg-slate-100'" class="h-11 px-5 sm:px-6 rounded-full text-xs font-bold transition-all cursor-pointer flex items-center justify-center gap-1.5">
                                <span class="material-symbols-outlined text-[17px] text-emerald-400">storefront</span>
                                <span>Commercial</span>
                            </button>
                        </div>

                        <!-- Modern Unified Intelligent Search Bar -->
                        <form action="/#listings" method="GET" id="search-form" class="bg-white rounded-3xl md:rounded-full border border-slate-300 shadow-lg hover:shadow-xl transition-all p-2 sm:p-2.5 flex flex-col md:flex-row items-stretch md:items-center">
                            <input type="hidden" name="listing_type" id="listing-type-hidden" value="{{ request('listing_type', 'rent') }}">
                            <input type="hidden" name="search_type" id="search-type-hidden" value="{{ request('search_type', '') }}">

                            <!-- 1. Location & Natural Query Input -->
                            <div class="flex-[1.4] px-4 sm:px-5 py-3 md:py-2.5 rounded-2xl md:rounded-l-full hover:bg-slate-50 focus-within:bg-slate-50 transition-colors">
                                <label for="search-input" class="block text-[11px] font-extrabold uppercase tracking-wider text-slate-500 mb-0.5">Location or Search Intent</label>
                                <div class="flex items-center gap-2">
                                    <span class="material-symbols-outlined text-emerald-600 text-[20px] shrink-0">location_on</span>
                                    <input id="search-input" name="search" type="text" class="w-full bg-transparent text-sm font-bold text-slate-900 border-0 focus:border-0 focus:ring-0 outline-none focus:outline-none p-0 placeholder-slate-400" placeholder="e.g. 2 BHK in Noida Sector 137, near metro..." value="{{ request('search', '') }}">
                                </div>
                            </div>

                            <!-- 2. Property Type Dropdown -->
                            <div class="w-full md:w-52 lg:w-56 px-4 py-3 md:py-2.5 rounded-2xl hover:bg-slate-50 focus-within:bg-slate-50 transition-colors border-t md:border-t-0 md:border-l border-slate-200">
                                <label for="type-select" class="block text-[11px] font-extrabold uppercase tracking-wider text-slate-500 mb-0.5">Property Type</label>
                                <div class="flex items-center gap-2">
                                    <span class="material-symbols-outlined text-slate-500 text-[20px] shrink-0">apartment</span>
                                    <select id="type-select" onchange="document.getElementById('search-type-hidden').value = this.value" class="w-full bg-transparent text-sm font-bold text-slate-900 border-0 focus:border-0 focus:ring-0 outline-none focus:outline-none p-0 cursor-pointer">
                                        <option value="">All Property Types</option>
                                        <option value="Apartment" {{ request('search_type') === 'Apartment' ? 'selected' : '' }}>Flats &amp; Apartments</option>
                                        <option value="House" {{ request('search_type') === 'House' ? 'selected' : '' }}>Houses &amp; Villas</option>
                                        <option value="Studio" {{ request('search_type') === 'Studio' ? 'selected' : '' }}>PGs &amp; Rooms</option>
                                        <option value="Shop" {{ request('search_type') === 'Shop' ? 'selected' : '' }}>Commercial / Shop</option>
                                    </select>
                                </div>
                            </div>

                            <!-- 3. Bedrooms / BHK Dropdown -->
                            <div class="w-full md:w-36 lg:w-40 px-4 py-3 md:py-2.5 rounded-2xl hover:bg-slate-50 focus-within:bg-slate-50 transition-colors border-t md:border-t-0 md:border-l border-slate-200">
                                <label for="bedrooms-select" class="block text-[11px] font-extrabold uppercase tracking-wider text-slate-500 mb-0.5">Bedrooms</label>
                                <div class="flex items-center gap-1.5">
                                    <span class="material-symbols-outlined text-slate-500 text-[20px] shrink-0">bed</span>
                                    <select id="bedrooms-select" name="bedrooms" class="w-full bg-transparent text-sm font-bold text-slate-900 border-0 focus:border-0 focus:ring-0 outline-none focus:outline-none p-0 cursor-pointer">
                                        <option value="all">Any BHK</option>
                                        <option value="1" {{ request('bedrooms') === '1' ? 'selected' : '' }}>1 BHK</option>
                                        <option value="2" {{ request('bedrooms') === '2' ? 'selected' : '' }}>2 BHK</option>
                                        <option value="3" {{ request('bedrooms') === '3' ? 'selected' : '' }}>3+ BHK</option>
                                    </select>
                                </div>
                            </div>

                            <!-- 4. Budget Dropdown -->
                            <div class="w-full md:w-44 lg:w-48 px-4 py-3 md:py-2.5 rounded-2xl hover:bg-slate-50 focus-within:bg-slate-50 transition-colors border-t md:border-t-0 md:border-l border-slate-200">
                                <label for="budget-select" class="block text-[11px] font-extrabold uppercase tracking-wider text-slate-500 mb-0.5">Max Budget</label>
                                <div class="flex items-center gap-1.5">
                                    <span class="material-symbols-outlined text-slate-500 text-[20px] shrink-0">payments</span>
                                    <select id="budget-select" name="max_price" class="w-full bg-transparent text-sm font-bold text-slate-900 border-0 focus:border-0 focus:ring-0 outline-none focus:outline-none p-0 cursor-pointer">
                                        <option value="">Any Budget</option>
                                        <option value="15000" {{ request('max_price') == '15000' ? 'selected' : '' }}>Under ₹15,000</option>
                                        <option value="25000" {{ request('max_price') == '25000' ? 'selected' : '' }}>Under ₹25,000</option>
                                        <option value="40000" {{ request('max_price') == '40000' ? 'selected' : '' }}>Under ₹40,000</option>
                                        <option value="60000" {{ request('max_price') == '60000' ? 'selected' : '' }}>Under ₹60,000</option>
                                        <option value="100000" {{ request('max_price') == '100000' ? 'selected' : '' }}>Under ₹1,00,000</option>
                                        <option value="15000000" {{ request('max_price') == '15000000' ? 'selected' : '' }}>Under ₹1.50 Cr (Sale)</option>
                                    </select>
                                </div>
                            </div>

                            <!-- 5. Advanced Filter Modal Button & Search Button -->
                            <div class="p-1 sm:p-1.5 flex items-center justify-center gap-1.5 sm:gap-2 shrink-0">
                                <button type="button" @click="filtersModalOpen = true" class="h-11 px-4 rounded-full bg-slate-100 hover:bg-slate-200 text-slate-800 font-bold text-xs flex items-center justify-center gap-1.5 border border-slate-200 transition-colors cursor-pointer" title="More Search Filters">
                                    <span class="material-symbols-outlined text-[18px] text-emerald-600">tune</span>
                                    <span class="hidden xl:inline">Filters</span>
                                </button>
                                <button type="submit" class="w-full md:w-auto h-11 px-7 rounded-full bg-brandNavy hover:bg-slate-900 text-white font-bold text-sm flex items-center justify-center gap-2 shadow-sm transition-all active:scale-95 cursor-pointer shrink-0">
                                    <span class="material-symbols-outlined text-[18px] text-emerald-400">search</span>
                                    <span>Search</span>
                                </button>
                            </div>
                        </form>

                        <!-- Contextual Secondary Subcategory Pills -->
                        <div class="flex items-center justify-center gap-2 mt-3 flex-wrap">
                            <span class="text-[11px] font-bold text-slate-500 uppercase tracking-wider">Quick:</span>
                            <template x-for="sub in subCategories[activePillar]" :key="sub.label">
                                <a :href="'/?listing_type=' + (activePillar === 'buy' ? 'sale' : (activePillar === 'commercial' ? '' : 'rent')) + (sub.type ? '&search_type=' + encodeURIComponent(sub.type) : '') + '#listings'" 
                                   class="h-7 px-3 rounded-full bg-white hover:bg-emerald-50 text-slate-700 hover:text-emerald-800 border border-slate-200 text-[11px] font-bold transition-all flex items-center justify-center shadow-2xs">
                                    <span x-text="sub.label"></span>
                                </a>
                            </template>
                        </div>

                        <!-- Clean Trending Keywords Line -->
                        <div class="flex items-center justify-center flex-wrap gap-2 mt-3 text-xs font-semibold text-slate-600">
                            <span class="text-slate-400 font-bold uppercase text-[10px]">Trending:</span>
                            <a href="/rent/noida" class="hover:text-emerald-700 underline decoration-slate-300 hover:decoration-emerald-500">Noida Flats</a>
                            <span class="text-slate-300">•</span>
                            <a href="/explore/student_pg" class="hover:text-emerald-700 underline decoration-slate-300 hover:decoration-emerald-500">Student PGs</a>
                            <span class="text-slate-300">•</span>
                            <a href="/?collection=near_metro#listings" class="hover:text-emerald-700 underline decoration-slate-300 hover:decoration-emerald-500">Near Metro</a>
                            <span class="text-slate-300">•</span>
                            <a href="/?bedrooms=2#listings" class="hover:text-emerald-700 underline decoration-slate-300 hover:decoration-emerald-500">2 BHK Flats</a>
                            <span class="text-slate-300">•</span>
                            <a href="/?collection=owner_only#listings" class="hover:text-emerald-700 underline decoration-slate-300 hover:decoration-emerald-500">Direct Owner (0% Brokerage)</a>
                        </div>
                    </div>
                </div>
            </section>

            <!-- ==========================================
                 SECTION 3: POPULAR LOCATIONS
                 (Noida | Delhi | Gurugram | Bangalore | Pune)
                 ========================================== -->
            <section class="max-w-[1440px] mx-auto px-6 sm:px-8 py-14 w-full" id="popular-locations">
                <div class="flex flex-col md:flex-row md:items-end justify-between gap-4 mb-8">
                    <div>
                        <div class="inline-flex items-center gap-1.5 text-emerald-700 font-black text-xs uppercase tracking-wider mb-1.5">
                            <span class="material-symbols-outlined text-[16px]">location_city</span>
                            Top Cities &amp; Tech Corridors
                        </div>
                        <h2 class="text-3xl sm:text-4xl font-black text-slate-900 tracking-tight">Popular Locations</h2>
                        <p class="text-sm font-semibold text-slate-600 mt-1">Explore verified flats, rooms, and PGs across premier residential hubs.</p>
                    </div>
                    <div class="flex items-center gap-2">
                        <a href="/rent/noida" class="text-xs font-bold text-emerald-700 hover:text-emerald-800 flex items-center gap-1">
                            <span>View all locations</span>
                            <span class="material-symbols-outlined text-xs">arrow_forward</span>
                        </a>
                    </div>
                </div>

                <!-- 5-City High-Impact Grid -->
                <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-5 gap-4 sm:gap-6">
                    <!-- City 1: Noida -->
                    <a href="/rent/noida" class="group relative rounded-3xl overflow-hidden aspect-[4/5] bg-slate-900 border border-slate-200 shadow-sm hover:shadow-xl transition-all duration-300 transform hover:-translate-y-1 block">
                        <img alt="Noida Expressway & Sector 137" class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-700 ease-out" src="https://images.unsplash.com/photo-1545324418-cc1a3fa10c00?auto=format&fit=crop&w=600&q=80">
                        <div class="absolute inset-0 bg-gradient-to-t from-slate-950/90 via-slate-950/30 to-transparent"></div>
                        <div class="absolute top-3 left-3">
                            <span class="px-2.5 py-0.5 rounded-full bg-emerald-600/90 backdrop-blur-md text-white text-[10px] font-extrabold uppercase tracking-wider">Top Verified</span>
                        </div>
                        <div class="absolute bottom-4 left-4 right-4 text-white">
                            <h3 class="text-lg font-black tracking-tight leading-tight group-hover:text-emerald-400 transition-colors">Noida</h3>
                            <p class="text-[11px] text-slate-300 mt-0.5 font-medium">Sec 137, 62, 75, 128</p>
                            <span class="mt-2 inline-flex items-center gap-1 text-[10px] font-bold text-emerald-400">
                                <span>Explore Noida</span>
                                <span class="material-symbols-outlined text-[12px]">arrow_forward</span>
                            </span>
                        </div>
                    </a>

                    <!-- City 2: Delhi -->
                    <a href="/?city=Delhi#listings" class="group relative rounded-3xl overflow-hidden aspect-[4/5] bg-slate-900 border border-slate-200 shadow-sm hover:shadow-xl transition-all duration-300 transform hover:-translate-y-1 block">
                        <img alt="Delhi NCR Homes" class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-700 ease-out" src="https://images.unsplash.com/photo-1587474260584-136574528ed5?auto=format&fit=crop&w=600&q=80">
                        <div class="absolute inset-0 bg-gradient-to-t from-slate-950/90 via-slate-950/30 to-transparent"></div>
                        <div class="absolute top-3 left-3">
                            <span class="px-2.5 py-0.5 rounded-full bg-brandNavy/90 backdrop-blur-md text-white text-[10px] font-extrabold uppercase tracking-wider">Capital NCR</span>
                        </div>
                        <div class="absolute bottom-4 left-4 right-4 text-white">
                            <h3 class="text-lg font-black tracking-tight leading-tight group-hover:text-emerald-400 transition-colors">Delhi</h3>
                            <p class="text-[11px] text-slate-300 mt-0.5 font-medium">South Delhi, Saket, Rohini</p>
                            <span class="mt-2 inline-flex items-center gap-1 text-[10px] font-bold text-emerald-400">
                                <span>Explore Delhi</span>
                                <span class="material-symbols-outlined text-[12px]">arrow_forward</span>
                            </span>
                        </div>
                    </a>

                    <!-- City 3: Gurugram -->
                    <a href="/rent/gurugram" class="group relative rounded-3xl overflow-hidden aspect-[4/5] bg-slate-900 border border-slate-200 shadow-sm hover:shadow-xl transition-all duration-300 transform hover:-translate-y-1 block">
                        <img alt="Gurugram Cyber Hub" class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-700 ease-out" src="https://images.unsplash.com/photo-1512917774080-9991f1c4c750?auto=format&fit=crop&w=600&q=80">
                        <div class="absolute inset-0 bg-gradient-to-t from-slate-950/90 via-slate-950/30 to-transparent"></div>
                        <div class="absolute top-3 left-3">
                            <span class="px-2.5 py-0.5 rounded-full bg-indigo-600/90 backdrop-blur-md text-white text-[10px] font-extrabold uppercase tracking-wider">Tech Hub</span>
                        </div>
                        <div class="absolute bottom-4 left-4 right-4 text-white">
                            <h3 class="text-lg font-black tracking-tight leading-tight group-hover:text-emerald-400 transition-colors">Gurugram</h3>
                            <p class="text-[11px] text-slate-300 mt-0.5 font-medium">Cyber City, Golf Course Rd</p>
                            <span class="mt-2 inline-flex items-center gap-1 text-[10px] font-bold text-emerald-400">
                                <span>Explore Gurugram</span>
                                <span class="material-symbols-outlined text-[12px]">arrow_forward</span>
                            </span>
                        </div>
                    </a>

                    <!-- City 4: Bangalore -->
                    <a href="/rent/bangalore" class="group relative rounded-3xl overflow-hidden aspect-[4/5] bg-slate-900 border border-slate-200 shadow-sm hover:shadow-xl transition-all duration-300 transform hover:-translate-y-1 block">
                        <img alt="Bangalore Startup Hub" class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-700 ease-out" src="https://images.unsplash.com/photo-1596176530529-78163a4f7af2?auto=format&fit=crop&w=600&q=80">
                        <div class="absolute inset-0 bg-gradient-to-t from-slate-950/90 via-slate-950/30 to-transparent"></div>
                        <div class="absolute top-3 left-3">
                            <span class="px-2.5 py-0.5 rounded-full bg-amber-600/90 backdrop-blur-md text-white text-[10px] font-extrabold uppercase tracking-wider">Silicon Valley</span>
                        </div>
                        <div class="absolute bottom-4 left-4 right-4 text-white">
                            <h3 class="text-lg font-black tracking-tight leading-tight group-hover:text-emerald-400 transition-colors">Bangalore</h3>
                            <p class="text-[11px] text-slate-300 mt-0.5 font-medium">HSR, Koramangala, Indiranagar</p>
                            <span class="mt-2 inline-flex items-center gap-1 text-[10px] font-bold text-emerald-400">
                                <span>Explore Bangalore</span>
                                <span class="material-symbols-outlined text-[12px]">arrow_forward</span>
                            </span>
                        </div>
                    </a>

                    <!-- City 5: Pune -->
                    <a href="/rent/pune" class="group relative rounded-3xl overflow-hidden aspect-[4/5] bg-slate-900 border border-slate-200 shadow-sm hover:shadow-xl transition-all duration-300 transform hover:-translate-y-1 block col-span-2 sm:col-span-1">
                        <img alt="Pune IT & Education Hub" class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-700 ease-out" src="https://images.unsplash.com/photo-1600585154340-be6161a56a0c?auto=format&fit=crop&w=600&q=80">
                        <div class="absolute inset-0 bg-gradient-to-t from-slate-950/90 via-slate-950/30 to-transparent"></div>
                        <div class="absolute top-3 left-3">
                            <span class="px-2.5 py-0.5 rounded-full bg-cyan-600/90 backdrop-blur-md text-white text-[10px] font-extrabold uppercase tracking-wider">IT &amp; Education</span>
                        </div>
                        <div class="absolute bottom-4 left-4 right-4 text-white">
                            <h3 class="text-lg font-black tracking-tight leading-tight group-hover:text-emerald-400 transition-colors">Pune</h3>
                            <p class="text-[11px] text-slate-300 mt-0.5 font-medium">Viman Nagar, Kharadi, Hinjewadi</p>
                            <span class="mt-2 inline-flex items-center gap-1 text-[10px] font-bold text-emerald-400">
                                <span>Explore Pune</span>
                                <span class="material-symbols-outlined text-[12px]">arrow_forward</span>
                            </span>
                        </div>
                    </a>
                </div>
            </section>

            <!-- ==========================================
                 SECTION 4: VERIFIED PROPERTIES NEAR YOU
                 (Real inventory only)
                 ========================================== -->
            <section class="max-w-[1440px] mx-auto px-6 sm:px-8 py-12 w-full" id="listings">
                
                <!-- 1. Curated Homepage Collections Bar -->
                <div class="mb-6">
                    <div class="flex items-center gap-2.5 overflow-x-auto no-scrollbar pb-1">
                        <span class="text-xs uppercase font-extrabold tracking-wider text-slate-400 shrink-0 mr-1 flex items-center gap-1">
                            <span class="material-symbols-outlined text-[16px] text-emerald-600">dashboard</span>
                            Collections:
                        </span>
                        @foreach($curatedCollections as $col)
                            @php
                                $isColActive = ($collection === $col['collection']) || (empty($collection) && $col['collection'] === null);
                            @endphp
                            <a href="{{ request()->fullUrlWithQuery(['collection' => $col['collection']]) }}#listings"
                               class="h-10 px-5 rounded-full text-xs font-bold whitespace-nowrap transition-all flex items-center gap-2 shrink-0 {{ $isColActive ? 'bg-brandNavy text-white shadow-sm' : 'bg-slate-100 text-slate-700 hover:bg-slate-200 border border-slate-200/80' }}">
                                <span class="material-symbols-outlined text-[16px] {{ $isColActive ? 'text-emerald-400' : 'text-slate-500' }}">{{ $col['icon'] }}</span>
                                <span>{{ $col['label'] }}</span>
                            </a>
                        @endforeach
                    </div>
                </div>

                <!-- 2. Location-First City Selection Tabs -->
                <div class="mb-6">
                    <div class="flex items-center gap-2.5 overflow-x-auto no-scrollbar pb-1">
                        <span class="text-xs uppercase font-extrabold tracking-wider text-slate-400 shrink-0 mr-1 flex items-center gap-1">
                            <span class="material-symbols-outlined text-[16px] text-emerald-600">location_on</span>
                            City:
                        </span>
                        @foreach($availableCities as $c)
                            @php
                                $isCityActive = (strtolower($selectedCity ?? 'All') === strtolower($c)) || ($c === 'All Cities' && (empty($selectedCity) || in_array(strtolower($selectedCity), ['all', 'all cities'])));
                                $cityParam = ($c === 'All Cities') ? null : $c;
                            @endphp
                            <a href="{{ request()->fullUrlWithQuery(['city' => $cityParam, 'locality' => null]) }}#listings"
                               class="h-10 px-5 rounded-full text-xs font-bold whitespace-nowrap transition-all flex items-center justify-center shrink-0 {{ $isCityActive ? 'bg-brandNavy text-white shadow-sm' : 'bg-slate-100 text-slate-700 hover:bg-slate-200 border border-slate-200/80' }}">
                                {{ $c }}
                            </a>
                        @endforeach
                    </div>

                    <!-- Micro-Market Quick Hubs for Noida / NCR -->
                    @if(empty($selectedCity) || in_array(strtolower($selectedCity), ['all', 'all cities', 'noida', 'greater noida']))
                    <div class="flex items-center gap-2 overflow-x-auto no-scrollbar pb-1 mt-3">
                        <span class="text-[11px] uppercase font-bold tracking-wider text-slate-500 shrink-0 mr-1 flex items-center gap-1">
                            <span class="material-symbols-outlined text-[14px] text-emerald-600">near_me</span>
                            Local Hubs:
                        </span>
                        @foreach($noidaMicroMarkets as $micro)
                            @php
                                $isMicroActive = request('locality') === $micro || request('search') === $micro;
                            @endphp
                            <a href="{{ request()->fullUrlWithQuery(['locality' => $micro, 'city' => 'Noida']) }}#listings"
                               class="h-8 px-4 rounded-full text-[11px] font-bold whitespace-nowrap transition-all flex items-center justify-center shrink-0 {{ $isMicroActive ? 'bg-emerald-600 text-white shadow-xs' : 'bg-white text-slate-700 hover:bg-emerald-50 hover:text-emerald-800 border border-slate-200' }}">
                                {{ $micro }}
                            </a>
                        @endforeach
                    </div>
                    @endif
                </div>

                <!-- Section Header with Dynamic Collection Title -->
                <div class="flex flex-col md:flex-row md:items-end justify-between gap-6 mb-8 pt-2">
                    <div>
                        <div class="inline-flex items-center gap-1.5 text-emerald-700 font-black text-xs uppercase tracking-wider mb-2">
                            <span class="material-symbols-outlined text-[16px]">travel_explore</span>
                            Active Verified Inventory
                        </div>
                        <h2 class="text-3xl sm:text-4xl font-black text-slate-900 tracking-tight flex items-center gap-3">
                            @if(request('collection') === 'owner_only')
                                <span>Direct Owner Listings (0% Brokerage)</span>
                            @elseif(request('collection') === 'near_metro')
                                <span>Properties Near Metro Stations</span>
                            @elseif(request('collection') === 'budget_friendly')
                                <span>Budget Friendly Homes (&lt; ₹15k)</span>
                            @elseif(request('collection') === 'student_pg')
                                <span>Student Housing &amp; Co-Living PGs</span>
                            @elseif(request('collection') === 'commercial')
                                <span>Commercial Spaces &amp; Retail Shops</span>
                            @elseif(request('locality'))
                                <span>Verified Properties in {{ request('locality') }}</span>
                            @elseif(!empty($selectedCity) && !in_array(strtolower($selectedCity), ['all', 'all cities']))
                                <span>Verified Properties in {{ $selectedCity }}</span>
                            @elseif(request('search'))
                                <span>Verified Properties for "{{ request('search') }}"</span>
                            @else
                                <span>Verified Properties Near You</span>
                            @endif
                            <span class="text-base sm:text-lg font-bold text-slate-500 whitespace-nowrap">({{ $properties->count() }} {{ $properties->count() === 1 ? 'listing' : 'listings' }})</span>
                        </h2>
                        <p class="text-sm font-semibold text-slate-600 mt-1">100% on-site verified flats, rooms, and PGs with 0% brokerage and direct owner contact.</p>
                    </div>

                    <!-- Filter Triggers, Map/List Toggle & Share Search Button -->
                    <div class="flex items-center gap-2.5 flex-wrap">
                        <!-- Map / List View Toggle -->
                        <div class="inline-flex p-1 bg-slate-100 rounded-full border border-slate-200">
                            <button type="button" @click="viewMode = 'list'" :class="viewMode === 'list' ? 'bg-white text-slate-900 shadow-2xs font-bold' : 'text-slate-600 font-semibold'" class="px-3.5 py-1.5 rounded-full text-xs flex items-center gap-1.5 transition cursor-pointer">
                                <span class="material-symbols-outlined text-[16px]">view_agenda</span>
                                <span>List</span>
                            </button>
                            <button type="button" @click="viewMode = 'map'" :class="viewMode === 'map' ? 'bg-white text-slate-900 shadow-2xs font-bold' : 'text-slate-600 font-semibold'" class="px-3.5 py-1.5 rounded-full text-xs flex items-center gap-1.5 transition cursor-pointer">
                                <span class="material-symbols-outlined text-[16px]">map</span>
                                <span>Map</span>
                            </button>
                        </div>

                        <button type="button" @click="filtersModalOpen = true" class="inline-flex items-center gap-1.5 h-11 px-5 rounded-full bg-slate-100 hover:bg-slate-200 text-slate-800 text-xs font-bold border border-slate-200 transition-all shadow-xs cursor-pointer">
                            <span class="material-symbols-outlined text-[17px] text-emerald-600">tune</span>
                            <span>All Filters</span>
                        </button>

                        <button type="button" onclick="shareCurrentSearch()" class="inline-flex items-center gap-1.5 h-11 px-5 rounded-full bg-white hover:bg-slate-100 text-slate-800 text-xs font-bold border border-slate-300 transition-all shadow-xs cursor-pointer" title="Share this search on WhatsApp or Copy Link">
                            <span class="material-symbols-outlined text-[17px] text-emerald-600">share</span>
                            <span class="hidden sm:inline">Share</span>
                        </button>

                        <button type="button" @click="saveSearchModalOpen = true" class="inline-flex items-center gap-1.5 h-11 px-5 rounded-full bg-emerald-600 hover:bg-emerald-700 text-white text-xs font-bold transition-all shadow-xs cursor-pointer">
                            <span class="material-symbols-outlined text-[17px]">notifications_active</span>
                            <span>Save Search</span>
                        </button>
                    </div>
                </div>

                <!-- Map View Container -->
                <div x-show="viewMode === 'map'" x-cloak class="mb-10 rounded-3xl overflow-hidden border border-slate-200 shadow-md h-[460px] bg-slate-100 relative">
                    <iframe 
                        title="Properties Location Map"
                        class="w-full h-full border-0"
                        loading="lazy" 
                        src="https://maps.google.com/maps?q={{ urlencode(($selectedCity ?? 'Noida') . ' India') }}&t=&z=12&ie=UTF8&iwloc=&output=embed">
                    </iframe>
                    <div class="absolute top-4 right-4 bg-white/95 backdrop-blur-md px-4 py-2 rounded-2xl shadow-md border border-slate-200 text-xs font-bold text-slate-800 flex items-center gap-2">
                        <span class="w-2.5 h-2.5 rounded-full bg-emerald-500 animate-pulse"></span>
                        <span>Showing verified coordinates in {{ $selectedCity ?? 'Noida' }}</span>
                    </div>
                </div>

                <!-- Verified Property Grid (List View) -->
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8" id="properties-grid">
                    @forelse($properties as $property)
                        <x-property-card :property="$property" />
                    @empty
                    <div class="col-span-full py-16 px-6 text-center bg-slate-50 rounded-3xl border border-dashed border-slate-300">
                        <div class="h-16 w-16 rounded-full bg-emerald-50 text-emerald-600 mx-auto flex items-center justify-center mb-4">
                            <span class="material-symbols-outlined text-3xl">search_off</span>
                        </div>
                        <h3 class="text-xl font-black text-slate-900 mb-2">No matching properties found</h3>
                        <p class="text-sm text-slate-600 max-w-md mx-auto mb-6 font-medium">We couldn't find active listings matching your exact criteria. Try broadening your budget, city, or property type filters.</p>
                        <div class="flex items-center justify-center gap-3 flex-wrap">
                            <a href="/#listings" class="h-11 px-6 rounded-full bg-brandNavy text-white text-xs font-bold hover:bg-slate-900 transition flex items-center gap-2 shadow-sm">
                                <span class="material-symbols-outlined text-base">refresh</span>
                                <span>Reset Filters</span>
                            </a>
                            <button type="button" @click="requestModalOpen = true" class="h-11 px-6 rounded-full bg-emerald-600 text-white text-xs font-bold hover:bg-emerald-700 transition flex items-center gap-2 shadow-sm cursor-pointer">
                                <span class="material-symbols-outlined text-base">post_add</span>
                                <span>Post Property Request</span>
                            </button>
                        </div>
                    </div>
                    @endforelse
                </div>
            </section>

            @if(isset($recentlyViewedProperties) && $recentlyViewedProperties->isNotEmpty())
            <!-- RECENTLY VIEWED PROPERTIES (Task 41) -->
            <section class="max-w-[1440px] mx-auto px-6 sm:px-8 mb-14 w-full">
                <div class="p-8 rounded-3xl bg-white border border-slate-200 shadow-soft">
                    <div class="flex items-center justify-between mb-8 flex-wrap gap-4">
                        <div>
                            <div class="inline-flex items-center gap-1.5 text-emerald-700 font-bold text-xs uppercase tracking-wider mb-1">
                                <span class="material-symbols-outlined text-[16px]">history</span>
                                Your Browsing History
                            </div>
                            <h2 class="text-2xl sm:text-3xl font-black text-slate-900 tracking-tight">Recently Viewed Properties</h2>
                            <p class="text-xs text-slate-500 mt-1">Easily compare flats and rooms you previously explored with 0% brokerage.</p>
                        </div>

                        <form action="{{ route('recently-viewed.clear') }}" method="POST">
                            @csrf
                            <button type="submit" class="px-4 py-2 rounded-full border border-slate-200 hover:border-slate-300 bg-white text-slate-600 hover:text-slate-900 text-xs font-bold transition flex items-center gap-1.5 shadow-2xs cursor-pointer">
                                <span class="material-symbols-outlined text-sm text-slate-400">delete_sweep</span>
                                <span>Clear History</span>
                            </button>
                        </form>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                        @foreach($recentlyViewedProperties->take(3) as $property)
                            <x-property-card :property="$property" />
                        @endforeach
                    </div>
                </div>
            </section>
            @endif

            <!-- ==========================================
                 SECTION 5: BROWSE BY NEED
                 (Flats | PGs | Rooms | Houses | Commercial)
                 ========================================== -->
            <section class="max-w-[1440px] mx-auto px-6 sm:px-8 py-14 w-full" id="browse-by-need">
                <div class="text-center max-w-2xl mx-auto mb-12">
                    <span class="text-xs uppercase tracking-wider text-emerald-700 font-black">Tailored Categories</span>
                    <h2 class="text-3xl sm:text-4xl font-black text-slate-900 tracking-tight mt-1">Browse by Need</h2>
                    <p class="text-sm font-semibold text-slate-600 mt-2">Find the exact living or commercial space designed for your lifestyle and budget.</p>
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-5 gap-6">
                    <!-- Need 1: Flats & Apartments -->
                    <a href="/category/Apartment" class="group rounded-3xl bg-white p-6 border border-slate-200 shadow-sm hover:border-emerald-500 hover:shadow-lg transition-all duration-300 flex flex-col justify-between transform hover:-translate-y-1">
                        <div>
                            <div class="w-12 h-12 rounded-2xl bg-emerald-50 text-emerald-700 border border-emerald-100 flex items-center justify-center mb-5 group-hover:bg-emerald-600 group-hover:text-white transition-colors">
                                <span class="material-symbols-outlined text-[26px]">apartment</span>
                            </div>
                            <h3 class="text-lg font-black text-slate-900 mb-1 group-hover:text-emerald-700 transition-colors">Flats</h3>
                            <p class="text-xs text-slate-500 leading-relaxed font-medium">1, 2, 3 &amp; 4 BHK society apartments with security &amp; amenities.</p>
                        </div>
                        <div class="mt-6 pt-3 border-t border-slate-100 flex items-center justify-between text-xs font-bold text-emerald-700">
                            <span>Browse Flats</span>
                            <span class="material-symbols-outlined text-[16px] group-hover:translate-x-1 transition-transform">arrow_forward</span>
                        </div>
                    </a>

                    <!-- Need 2: PGs & Co-Living -->
                    <a href="/explore/student_pg" class="group rounded-3xl bg-white p-6 border border-slate-200 shadow-sm hover:border-emerald-500 hover:shadow-lg transition-all duration-300 flex flex-col justify-between transform hover:-translate-y-1">
                        <div>
                            <div class="w-12 h-12 rounded-2xl bg-blue-50 text-blue-700 border border-blue-100 flex items-center justify-center mb-5 group-hover:bg-blue-600 group-hover:text-white transition-colors">
                                <span class="material-symbols-outlined text-[26px]">single_bed</span>
                            </div>
                            <h3 class="text-lg font-black text-slate-900 mb-1 group-hover:text-blue-700 transition-colors">PGs</h3>
                            <p class="text-xs text-slate-500 leading-relaxed font-medium">Fully furnished student &amp; professional PGs with meals &amp; WiFi.</p>
                        </div>
                        <div class="mt-6 pt-3 border-t border-slate-100 flex items-center justify-between text-xs font-bold text-blue-700">
                            <span>Browse PGs</span>
                            <span class="material-symbols-outlined text-[16px] group-hover:translate-x-1 transition-transform">arrow_forward</span>
                        </div>
                    </a>

                    <!-- Need 3: Private Rooms & Studios -->
                    <a href="/category/Studio" class="group rounded-3xl bg-white p-6 border border-slate-200 shadow-sm hover:border-emerald-500 hover:shadow-lg transition-all duration-300 flex flex-col justify-between transform hover:-translate-y-1">
                        <div>
                            <div class="w-12 h-12 rounded-2xl bg-indigo-50 text-indigo-700 border border-indigo-100 flex items-center justify-center mb-5 group-hover:bg-indigo-600 group-hover:text-white transition-colors">
                                <span class="material-symbols-outlined text-[26px]">hotel</span>
                            </div>
                            <h3 class="text-lg font-black text-slate-900 mb-1 group-hover:text-indigo-700 transition-colors">Rooms</h3>
                            <p class="text-xs text-slate-500 leading-relaxed font-medium">Private single rooms, 1RKs &amp; independent studio apartments.</p>
                        </div>
                        <div class="mt-6 pt-3 border-t border-slate-100 flex items-center justify-between text-xs font-bold text-indigo-700">
                            <span>Browse Rooms</span>
                            <span class="material-symbols-outlined text-[16px] group-hover:translate-x-1 transition-transform">arrow_forward</span>
                        </div>
                    </a>

                    <!-- Need 4: Houses & Independent Villas -->
                    <a href="/category/Villa" class="group rounded-3xl bg-white p-6 border border-slate-200 shadow-sm hover:border-emerald-500 hover:shadow-lg transition-all duration-300 flex flex-col justify-between transform hover:-translate-y-1">
                        <div>
                            <div class="w-12 h-12 rounded-2xl bg-amber-50 text-amber-700 border border-amber-100 flex items-center justify-center mb-5 group-hover:bg-amber-600 group-hover:text-white transition-colors">
                                <span class="material-symbols-outlined text-[26px]">villa</span>
                            </div>
                            <h3 class="text-lg font-black text-slate-900 mb-1 group-hover:text-amber-700 transition-colors">Houses</h3>
                            <p class="text-xs text-slate-500 leading-relaxed font-medium">Independent builder floors, luxury villas &amp; family homes.</p>
                        </div>
                        <div class="mt-6 pt-3 border-t border-slate-100 flex items-center justify-between text-xs font-bold text-amber-700">
                            <span>Browse Houses</span>
                            <span class="material-symbols-outlined text-[16px] group-hover:translate-x-1 transition-transform">arrow_forward</span>
                        </div>
                    </a>

                    <!-- Need 5: Commercial Spaces -->
                    <a href="/explore/commercial" class="group rounded-3xl bg-white p-6 border border-slate-200 shadow-sm hover:border-emerald-500 hover:shadow-lg transition-all duration-300 flex flex-col justify-between transform hover:-translate-y-1">
                        <div>
                            <div class="w-12 h-12 rounded-2xl bg-slate-100 text-slate-800 border border-slate-200 flex items-center justify-center mb-5 group-hover:bg-slate-900 group-hover:text-white transition-colors">
                                <span class="material-symbols-outlined text-[26px]">storefront</span>
                            </div>
                            <h3 class="text-lg font-black text-slate-900 mb-1 group-hover:text-slate-900 transition-colors">Commercial</h3>
                            <p class="text-xs text-slate-500 leading-relaxed font-medium">Retail shops, office workstations, warehouses &amp; showroom spaces.</p>
                        </div>
                        <div class="mt-6 pt-3 border-t border-slate-100 flex items-center justify-between text-xs font-bold text-slate-900">
                            <span>Browse Commercial</span>
                            <span class="material-symbols-outlined text-[16px] group-hover:translate-x-1 transition-transform">arrow_forward</span>
                        </div>
                    </a>
                </div>
            </section>

            <!-- ==========================================
                 SECTION 6: WHY HOMIQ?
                 (Verified | Direct Owner | Zero Brokerage | Transparent Pricing)
                 ========================================== -->
            <section class="w-full bg-slate-50 border-y border-slate-200 py-16" id="why-homiq">
                <div class="max-w-[1440px] mx-auto px-6 sm:px-8">
                    <div class="text-center max-w-2xl mx-auto mb-14">
                        <span class="text-xs uppercase tracking-wider text-emerald-700 font-black">Why HomiQ?</span>
                        <h2 class="text-3xl sm:text-4xl font-black text-slate-900 tracking-tight mt-1">Built for direct, zero-brokerage renting</h2>
                        <p class="text-sm font-semibold text-slate-600 mt-2">Connect directly with verified owners and discover authentic flats, rooms, and PGs without middleman fees.</p>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
                        <!-- Pillar 1: Verified -->
                        <div class="rounded-3xl bg-white p-7 border border-slate-200 shadow-sm flex flex-col justify-between">
                            <div>
                                <div class="w-12 h-12 rounded-2xl bg-emerald-50 text-emerald-700 flex items-center justify-center mb-5 border border-emerald-100">
                                    <span class="material-symbols-outlined text-[24px]">verified</span>
                                </div>
                                <h3 class="text-lg font-black text-slate-900 tracking-tight mb-2">100% On-Site Verified</h3>
                                <p class="text-xs leading-relaxed text-slate-600 font-medium">Every approved property undergoes geo-location audit and physical photo inspection before going live.</p>
                            </div>
                            <div class="mt-6 pt-4 border-t border-slate-100 flex items-center gap-1.5 text-xs font-bold text-emerald-700">
                                <span class="material-symbols-outlined text-[16px]">check_circle</span>
                                <span>Zero Phantom Listings</span>
                            </div>
                        </div>

                        <!-- Pillar 2: Direct Owner -->
                        <div class="rounded-3xl bg-white p-7 border border-slate-200 shadow-sm flex flex-col justify-between">
                            <div>
                                <div class="w-12 h-12 rounded-2xl bg-indigo-50 text-indigo-700 flex items-center justify-center mb-5 border border-indigo-100">
                                    <span class="material-symbols-outlined text-[24px]">chat</span>
                                </div>
                                <h3 class="text-lg font-black text-slate-900 tracking-tight mb-2">Direct Owner Contact</h3>
                                <p class="text-xs leading-relaxed text-slate-600 font-medium">Message landlords directly through in-app chat or WhatsApp. Agree on terms without unwanted broker spam.</p>
                            </div>
                            <div class="mt-6 pt-4 border-t border-slate-100 flex items-center gap-1.5 text-xs font-bold text-indigo-700">
                                <span class="material-symbols-outlined text-[16px]">forum</span>
                                <span>Direct Communication</span>
                            </div>
                        </div>

                        <!-- Pillar 3: Zero Brokerage -->
                        <div class="rounded-3xl bg-white p-7 border border-slate-200 shadow-sm flex flex-col justify-between">
                            <div>
                                <div class="w-12 h-12 rounded-2xl bg-amber-50 text-amber-700 flex items-center justify-center mb-5 border border-amber-100">
                                    <span class="material-symbols-outlined text-[24px]">savings</span>
                                </div>
                                <h3 class="text-lg font-black text-slate-900 tracking-tight mb-2">Zero Brokerage</h3>
                                <p class="text-xs leading-relaxed text-slate-600 font-medium">Keep 100% of your money. Save up to one full month's rent (~₹25,000) on unnecessary middleman commissions.</p>
                            </div>
                            <div class="mt-6 pt-4 border-t border-slate-100 flex items-center gap-1.5 text-xs font-bold text-amber-700">
                                <span class="material-symbols-outlined text-[16px]">money_off</span>
                                <span>0% Commission Ever</span>
                            </div>
                        </div>

                        <!-- Pillar 4: Transparent Pricing -->
                        <div class="rounded-3xl bg-white p-7 border border-slate-200 shadow-sm flex flex-col justify-between">
                            <div>
                                <div class="w-12 h-12 rounded-2xl bg-teal-50 text-teal-700 flex items-center justify-center mb-5 border border-teal-100">
                                    <span class="material-symbols-outlined text-[24px]">receipt_long</span>
                                </div>
                                <h3 class="text-lg font-black text-slate-900 tracking-tight mb-2">Transparent Pricing</h3>
                                <p class="text-xs leading-relaxed text-slate-600 font-medium">See the full cost breakdown up-front: Monthly Rent, Security Deposit, Society Maintenance, and move-in availability.</p>
                            </div>
                            <div class="mt-6 pt-4 border-t border-slate-100 flex items-center gap-1.5 text-xs font-bold text-teal-700">
                                <span class="material-symbols-outlined text-[16px]">lock_open</span>
                                <span>No Hidden Charges</span>
                            </div>
                        </div>
                    </div>
                </div>
            </section>

            <!-- ==========================================
                 SECTION 7: TENANT / BUYER DEMAND BOARD
                 (Real demand requests)
                 ========================================== -->
            <section class="max-w-[1440px] mx-auto px-6 sm:px-8 py-16 w-full" id="demand-board" x-data="{
                demandPurpose: 'all',
                demandCity: 'all',
                demandBhk: 'all',
                matchesFilter(purpose, city, bhk) {
                    if (this.demandPurpose !== 'all' && purpose.toLowerCase() !== this.demandPurpose.toLowerCase()) return false;
                    if (this.demandCity !== 'all' && !city.toLowerCase().includes(this.demandCity.toLowerCase())) return false;
                    if (this.demandBhk !== 'all' && !bhk.toLowerCase().includes(this.demandBhk.toLowerCase())) return false;
                    return true;
                }
            }">
                <div class="flex flex-col md:flex-row md:items-end justify-between gap-6 mb-8">
                    <div>
                        <div class="inline-flex items-center gap-1.5 text-emerald-700 font-black text-xs uppercase tracking-wider mb-2">
                            <span class="material-symbols-outlined text-[16px]">campaign</span>
                            Two-Sided Liquidity Board
                        </div>
                        <h2 class="text-3xl sm:text-4xl font-black text-slate-900 tracking-tight">Tenant &amp; Buyer Demand Board</h2>
                        <p class="text-sm font-semibold text-slate-600 mt-1">Direct requirements posted by verified tenants and buyers. Property owners can review demand and connect directly.</p>
                    </div>

                    <div class="flex flex-wrap items-center gap-3">
                        <button type="button" @click="requestModalOpen = true" class="h-12 px-6 rounded-full bg-emerald-600 hover:bg-emerald-700 text-white font-bold text-xs flex items-center gap-2 shadow-sm transition-all cursor-pointer">
                            <span class="material-symbols-outlined text-[18px]">post_add</span>
                            <span>Post Your Requirement</span>
                        </button>
                        <a href="{{ route('owners.landing') }}" class="h-12 px-5 rounded-full bg-slate-900 hover:bg-slate-800 text-white font-bold text-xs flex items-center gap-2 shadow-sm transition-all">
                            <span class="material-symbols-outlined text-[18px] text-emerald-400">home_work</span>
                            <span>Owner Match Portal</span>
                        </a>
                    </div>
                </div>

                <!-- Demand Board Filter Chips -->
                <div class="bg-slate-50 border border-slate-200 rounded-3xl p-4 sm:p-5 mb-8 shadow-xs flex flex-wrap items-center justify-between gap-4">
                    <div class="flex flex-wrap items-center gap-2">
                        <span class="text-xs font-black text-slate-500 uppercase tracking-wider mr-1">Purpose:</span>
                        <button type="button" @click="demandPurpose = 'all'" :class="demandPurpose === 'all' ? 'bg-slate-900 text-white' : 'bg-white text-slate-700 hover:bg-slate-100 border border-slate-200'" class="px-3.5 py-1.5 rounded-full text-xs font-bold transition-all cursor-pointer">
                            All Demand
                        </button>
                        <button type="button" @click="demandPurpose = 'rent'" :class="demandPurpose === 'rent' ? 'bg-slate-900 text-white' : 'bg-white text-slate-700 hover:bg-slate-100 border border-slate-200'" class="px-3.5 py-1.5 rounded-full text-xs font-bold transition-all cursor-pointer">
                            Rent Only
                        </button>
                        <button type="button" @click="demandPurpose = 'buy'" :class="demandPurpose === 'buy' ? 'bg-slate-900 text-white' : 'bg-white text-slate-700 hover:bg-slate-100 border border-slate-200'" class="px-3.5 py-1.5 rounded-full text-xs font-bold transition-all cursor-pointer">
                            Buy Only
                        </button>
                    </div>

                    <div class="flex flex-wrap items-center gap-2">
                        <span class="text-xs font-black text-slate-500 uppercase tracking-wider mr-1">City:</span>
                        <button type="button" @click="demandCity = 'all'" :class="demandCity === 'all' ? 'bg-emerald-600 text-white' : 'bg-white text-slate-700 hover:bg-slate-100 border border-slate-200'" class="px-3 py-1.5 rounded-full text-xs font-bold transition-all cursor-pointer">
                            All Cities
                        </button>
                        <button type="button" @click="demandCity = 'noida'" :class="demandCity === 'noida' ? 'bg-emerald-600 text-white' : 'bg-white text-slate-700 hover:bg-slate-100 border border-slate-200'" class="px-3 py-1.5 rounded-full text-xs font-bold transition-all cursor-pointer">
                            Noida
                        </button>
                        <button type="button" @click="demandCity = 'greater noida'" :class="demandCity === 'greater noida' ? 'bg-emerald-600 text-white' : 'bg-white text-slate-700 hover:bg-slate-100 border border-slate-200'" class="px-3 py-1.5 rounded-full text-xs font-bold transition-all cursor-pointer">
                            Greater Noida
                        </button>
                        <button type="button" @click="demandCity = 'gurugram'" :class="demandCity === 'gurugram' ? 'bg-emerald-600 text-white' : 'bg-white text-slate-700 hover:bg-slate-100 border border-slate-200'" class="px-3 py-1.5 rounded-full text-xs font-bold transition-all cursor-pointer">
                            Gurugram
                        </button>
                        <button type="button" @click="demandCity = 'bangalore'" :class="demandCity === 'bangalore' ? 'bg-emerald-600 text-white' : 'bg-white text-slate-700 hover:bg-slate-100 border border-slate-200'" class="px-3 py-1.5 rounded-full text-xs font-bold transition-all cursor-pointer">
                            Bangalore
                        </button>
                    </div>

                    <div class="flex flex-wrap items-center gap-2">
                        <span class="text-xs font-black text-slate-500 uppercase tracking-wider mr-1">BHK:</span>
                        <select x-model="demandBhk" class="px-3 py-1.5 rounded-full bg-white border border-slate-200 text-xs font-bold text-slate-800 cursor-pointer focus:ring-2 focus:ring-emerald-500">
                            <option value="all">All Sizes</option>
                            <option value="1 BHK">1 BHK</option>
                            <option value="2 BHK">2 BHK</option>
                            <option value="3 BHK">3 BHK</option>
                            <option value="Studio">Studio / Room</option>
                        </select>
                    </div>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                    @forelse($propertyRequests as $req)
                    <div x-show="matchesFilter('{{ $req->purpose ?? 'rent' }}', '{{ addslashes($req->city ?? '') }}', '{{ addslashes($req->bhk ?? $req->property_type ?? '') }}')"
                         class="group rounded-3xl bg-white p-6 border border-slate-200 shadow-sm hover:border-emerald-500 transition-all duration-300 flex flex-col justify-between">
                        <div>
                            <!-- Header Badges -->
                            <div class="flex items-start justify-between gap-2 mb-3">
                                <div class="flex flex-wrap items-center gap-1.5">
                                    <span class="px-2.5 py-1 rounded-full bg-slate-900 text-white text-[10px] font-extrabold uppercase tracking-wider">
                                        Wanted: {{ $req->bhk ?? $req->property_type }}
                                    </span>
                                    <span class="px-2.5 py-1 rounded-full bg-emerald-50 text-emerald-800 border border-emerald-300 text-[10px] font-bold">
                                        {{ ucfirst($req->purpose ?? 'Rent') }}
                                    </span>
                                </div>
                                <span class="text-[11px] font-bold text-slate-500 flex items-center gap-1">
                                    <span class="material-symbols-outlined text-[13px]">schedule</span>
                                    {{ $req->time_ago }}
                                </span>
                            </div>

                            <!-- Location Heading -->
                            <h3 class="text-lg font-black text-slate-900 group-hover:text-emerald-700 transition-colors flex items-center gap-1.5">
                                <span class="material-symbols-outlined text-emerald-600 text-[18px]">location_on</span>
                                <span>{{ $req->location }}</span>
                            </h3>

                            <!-- Seeker profile badge -->
                            <div class="mt-2.5 flex items-center gap-2">
                                <span class="inline-flex items-center gap-1 px-2.5 py-0.5 rounded-md bg-slate-100 text-slate-800 font-bold text-[11px] border border-slate-200">
                                    <span class="material-symbols-outlined text-[13px] text-emerald-600">badge</span>
                                    {{ $req->tenant_badge }}
                                </span>
                                @if($req->furnishing_preference && $req->furnishing_preference !== 'any')
                                <span class="inline-flex items-center gap-1 px-2 py-0.5 rounded-md bg-amber-50 text-amber-800 font-bold text-[11px] border border-amber-200">
                                    <span class="material-symbols-outlined text-[13px] text-amber-600">chair</span>
                                    {{ ucwords(str_replace('_', ' ', $req->furnishing_preference)) }}
                                </span>
                                @endif
                            </div>

                            <!-- Demand Details Box -->
                            <div class="mt-3.5 space-y-2 bg-slate-50 p-4 rounded-2xl text-xs text-slate-700 border border-slate-200">
                                <div class="flex items-center justify-between">
                                    <span class="text-slate-500 font-bold">Max Budget:</span>
                                    <span class="font-black text-emerald-700 text-sm">{{ $req->budget_formatted }}</span>
                                </div>
                                <div class="flex items-center justify-between">
                                    <span class="text-slate-500 font-bold">Move-in Date:</span>
                                    <span class="font-bold text-slate-900">{{ $req->move_in_timeline }}</span>
                                </div>
                                <div class="flex items-center justify-between">
                                    <span class="text-slate-500 font-bold">Seeker:</span>
                                    <span class="font-bold text-slate-900">{{ $req->name }}</span>
                                </div>
                            </div>

                            @if($req->notes)
                            <p class="text-xs text-slate-600 mt-3 line-clamp-2 leading-relaxed font-medium bg-slate-50/50 p-2.5 rounded-xl border border-dashed border-slate-200">
                                "{{ $req->notes }}"
                            </p>
                            @endif
                        </div>

                        <!-- Direct Connect / Match Actions -->
                        <div class="mt-6 pt-4 border-t border-slate-100 flex items-center gap-2">
                            <a href="{{ route('host.add-property') }}" class="flex-1 h-11 rounded-xl bg-brandNavy hover:bg-slate-900 text-white font-bold text-xs text-center transition-all flex items-center justify-center gap-1.5 shadow-sm active:scale-98">
                                <span class="material-symbols-outlined text-[16px] text-emerald-400">add_home</span>
                                <span>I Have Matching Space</span>
                            </a>
                            @if($req->phone)
                            <a href="https://wa.me/91{{ preg_replace('/[^0-9]/', '', $req->phone) }}?text={{ urlencode('Hi ' . $req->name . ', I saw your requirement on HomiQ for ' . $req->property_type . ' in ' . $req->location . '. I have a verified property that matches your criteria.') }}" 
                               target="_blank"
                               title="Connect with seeker on WhatsApp"
                               class="h-11 px-3.5 rounded-xl bg-emerald-50 hover:bg-emerald-100 text-emerald-800 border border-emerald-300 font-bold text-xs flex items-center justify-center gap-1 transition-colors">
                                <span class="material-symbols-outlined text-[17px] text-emerald-600">chat</span>
                                <span class="hidden sm:inline">Connect</span>
                            </a>
                            @endif
                        </div>
                    </div>
                    @empty
                    <div class="col-span-full py-12 px-6 text-center bg-white rounded-3xl border border-slate-200 shadow-sm">
                        <div class="h-12 w-12 rounded-full bg-emerald-50 text-emerald-600 mx-auto flex items-center justify-center mb-3">
                            <span class="material-symbols-outlined text-2xl">campaign</span>
                        </div>
                        <h4 class="text-base font-black text-slate-900">Be the First to Post a Property Request!</h4>
                        <p class="text-xs text-slate-600 mt-1 max-w-md mx-auto font-medium">Tell verified property owners exactly what type of flat, room, PG, or commercial unit you are searching for.</p>
                        <button type="button" @click="requestModalOpen = true" class="mt-4 h-11 px-6 rounded-full bg-emerald-600 hover:bg-emerald-700 text-white text-xs font-bold cursor-pointer inline-flex items-center justify-center gap-1.5 shadow-sm">
                            <span class="material-symbols-outlined text-[17px]">post_add</span>
                            <span>Post Request Free</span>
                        </button>
                    </div>
                    @endforelse
                </div>
            </section>

            <!-- ==========================================
                 SECTION 8: LIST YOUR PROPERTY FREE
                 (Owner CTA)
                 ========================================== -->
            <section class="max-w-[1440px] mx-auto px-6 sm:px-8 py-14 w-full" id="list-free">
                <div class="rounded-3xl bg-brandNavy text-white p-8 md:p-14 shadow-sm border border-slate-800 relative overflow-hidden">
                    <div class="absolute -right-24 -bottom-24 w-80 h-80 bg-emerald-500/10 rounded-full blur-3xl pointer-events-none"></div>

                    <div class="grid grid-cols-1 lg:grid-cols-12 gap-10 items-center relative z-10">
                        <div class="lg:col-span-7 space-y-6">
                            <div class="inline-flex items-center gap-2 px-3.5 py-1.5 rounded-full bg-emerald-500/20 border border-emerald-500/30 text-emerald-300 text-xs font-bold uppercase tracking-wider">
                                <span class="material-symbols-outlined text-[16px]">add_home</span>
                                For Landlords &amp; Property Owners
                            </div>
                            <h2 class="text-3xl sm:text-5xl font-black text-white tracking-tight leading-tight">
                                Have a Property to<br>Rent or Sell?
                            </h2>
                            <p class="text-slate-200 text-base leading-relaxed max-w-xl font-medium">
                                List your property on HomiQ and connect directly with buyers and renters without paying hefty broker commissions or hidden fees.
                            </p>

                            <!-- Comprehensive Owner Benefits Grid -->
                            <div class="grid grid-cols-2 sm:grid-cols-4 gap-3 pt-2">
                                <div class="p-3.5 rounded-2xl bg-white/10 border border-white/15 flex items-start gap-2.5">
                                    <span class="material-symbols-outlined text-emerald-400 text-lg shrink-0 mt-0.5">money_off</span>
                                    <div>
                                        <span class="text-xs font-bold text-white block">Free Listing</span>
                                        <span class="text-[11px] text-slate-300">No listing fee</span>
                                    </div>
                                </div>
                                <div class="p-3.5 rounded-2xl bg-white/10 border border-white/15 flex items-start gap-2.5">
                                    <span class="material-symbols-outlined text-emerald-400 text-lg shrink-0 mt-0.5">chat</span>
                                    <div>
                                        <span class="text-xs font-bold text-white block">Direct Inquiries</span>
                                        <span class="text-[11px] text-slate-300">Zero middleman</span>
                                    </div>
                                </div>
                                <div class="p-3.5 rounded-2xl bg-white/10 border border-white/15 flex items-start gap-2.5">
                                    <span class="material-symbols-outlined text-emerald-400 text-lg shrink-0 mt-0.5">verified_user</span>
                                    <div>
                                        <span class="text-xs font-bold text-white block">Verified Profile</span>
                                        <span class="text-[11px] text-slate-300">Build instant trust</span>
                                    </div>
                                </div>
                                <div class="p-3.5 rounded-2xl bg-white/10 border border-white/15 flex items-start gap-2.5">
                                    <span class="material-symbols-outlined text-emerald-400 text-lg shrink-0 mt-0.5">query_stats</span>
                                    <div>
                                        <span class="text-xs font-bold text-white block">Track Analytics</span>
                                        <span class="text-[11px] text-slate-300">Views &amp; leads</span>
                                    </div>
                                </div>
                            </div>

                            <!-- Benefits Feature Bullets -->
                            <div class="flex flex-wrap items-center gap-x-6 gap-y-2 text-xs font-semibold text-slate-300 pt-1">
                                <span class="flex items-center gap-1.5"><span class="material-symbols-outlined text-emerald-400 text-sm">check_circle</span> Manage leads seamlessly</span>
                                <span class="flex items-center gap-1.5"><span class="material-symbols-outlined text-emerald-400 text-sm">check_circle</span> Receive instant notifications</span>
                                <span class="flex items-center gap-1.5"><span class="material-symbols-outlined text-emerald-400 text-sm">check_circle</span> 1-click availability updates</span>
                            </div>

                            <div class="pt-4 flex items-center gap-4 flex-wrap">
                                <a href="{{ route('owners.landing') }}" class="h-14 px-8 rounded-full bg-emerald-600 hover:bg-emerald-700 text-white font-bold text-sm flex items-center gap-2 shadow-sm transition-all active:scale-[0.98]">
                                    <span>List Your Property Free</span>
                                    <span class="material-symbols-outlined text-[18px]">arrow_forward</span>
                                </a>
                                <a href="/owners#how-it-works" class="h-14 px-6 rounded-full bg-white/15 hover:bg-white/25 text-white font-bold text-sm flex items-center gap-2 border border-white/20 transition-colors">
                                    <span class="material-symbols-outlined text-[18px]">help_outline</span>
                                    <span>How It Works</span>
                                </a>
                            </div>
                        </div>

                        <div class="lg:col-span-5">
                            <div class="rounded-3xl bg-white/10 border border-white/20 p-6 space-y-4">
                                <div class="flex items-center justify-between pb-3 border-b border-white/15">
                                    <span class="text-xs font-bold uppercase tracking-wider text-emerald-300">Live Seeker Requests</span>
                                    <span class="px-2.5 py-0.5 rounded-full bg-emerald-500/20 text-emerald-300 text-[11px] font-bold">Direct Demands</span>
                                </div>

                                <div class="space-y-3">
                                    @foreach($propertyRequests->take(2) as $req)
                                    <div class="p-3.5 rounded-2xl bg-white/10 border border-white/10">
                                        <div class="flex items-center justify-between">
                                            <span class="text-xs font-bold text-white">{{ $req->bedrooms }} in {{ $req->locality ?? $req->city }}</span>
                                            <span class="text-xs font-bold text-emerald-400">{{ $req->formatted_budget }}</span>
                                        </div>
                                        <p class="text-[11px] text-slate-200 mt-1 line-clamp-1 font-medium">{{ $req->description ?? 'Seeking verified home with direct owner contact' }}</p>
                                    </div>
                                    @endforeach
                                </div>

                                <div class="pt-2 flex items-center justify-between gap-3">
                                    <a href="{{ route('owners.landing') }}" class="w-full h-11 rounded-xl bg-white text-slate-900 font-bold text-xs hover:bg-slate-100 transition-colors flex items-center justify-center gap-1.5 cursor-pointer shadow-xs">
                                        <span class="material-symbols-outlined text-[17px] text-emerald-600">apartment</span>
                                        <span>Explore Owner Portal</span>
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </section>

            <!-- ==========================================
                 SECTION 9: RENTAL COST CALCULATOR
                 (Interactive Move-In & Savings Estimator)
                 ========================================== -->
            <section class="max-w-[1440px] mx-auto px-6 sm:px-8 py-16 w-full" id="rental-calculator" x-data="{
                rentAmount: 25000,
                depositMultiplier: 2,
                maintenanceAmount: 2000,
                get securityDeposit() {
                    return this.rentAmount * this.depositMultiplier;
                },
                get totalMoveIn() {
                    return parseInt(this.rentAmount) + parseInt(this.securityDeposit) + parseInt(this.maintenanceAmount);
                },
                get brokerageSaved() {
                    return parseInt(this.rentAmount);
                },
                formatInr(val) {
                    return '₹' + Number(val).toLocaleString('en-IN');
                }
            }">
                <div class="rounded-3xl bg-slate-50 border border-slate-200 p-8 sm:p-12 shadow-soft">
                    <div class="text-center max-w-2xl mx-auto mb-10">
                        <div class="inline-flex items-center gap-1.5 text-emerald-700 font-black text-xs uppercase tracking-wider mb-2">
                            <span class="material-symbols-outlined text-[16px]">calculate</span>
                            Move-In Budget Estimator
                        </div>
                        <h2 class="text-3xl sm:text-4xl font-black text-slate-900 tracking-tight">Rental Cost Calculator</h2>
                        <p class="text-sm font-semibold text-slate-600 mt-1">Estimate your exact upfront move-in expenses and see how much you save with 0% brokerage on HomiQ.</p>
                    </div>

                    <div class="grid grid-cols-1 lg:grid-cols-12 gap-10 items-start">
                        <!-- Left Controls -->
                        <div class="lg:col-span-7 bg-white rounded-3xl p-6 sm:p-8 border border-slate-200 shadow-xs space-y-6">
                            <!-- Rent Input & Slider -->
                            <div>
                                <div class="flex items-center justify-between mb-2">
                                    <label class="text-xs font-black uppercase tracking-wider text-slate-700">Expected Monthly Rent</label>
                                    <span class="text-lg font-black text-emerald-700" x-text="formatInr(rentAmount) + '/mo'"></span>
                                </div>
                                <input type="range" min="8000" max="150000" step="1000" x-model.number="rentAmount" class="w-full h-2 bg-slate-200 rounded-lg appearance-none cursor-pointer accent-emerald-600">
                                <div class="flex justify-between text-[11px] font-bold text-slate-400 mt-1">
                                    <span>₹8,000</span>
                                    <span>₹50,000</span>
                                    <span>₹1,50,000</span>
                                </div>
                            </div>

                            <!-- Deposit Multiplier Tabs -->
                            <div>
                                <label class="block text-xs font-black uppercase tracking-wider text-slate-700 mb-2">Security Deposit (Months of Rent)</label>
                                <div class="grid grid-cols-3 gap-3">
                                    <button type="button" @click="depositMultiplier = 1" :class="depositMultiplier === 1 ? 'bg-brandNavy text-white' : 'bg-slate-50 text-slate-700 hover:bg-slate-100 border border-slate-200'" class="py-2.5 rounded-2xl text-xs font-bold transition-all cursor-pointer">
                                        1 Month
                                    </button>
                                    <button type="button" @click="depositMultiplier = 2" :class="depositMultiplier === 2 ? 'bg-brandNavy text-white' : 'bg-slate-50 text-slate-700 hover:bg-slate-100 border border-slate-200'" class="py-2.5 rounded-2xl text-xs font-bold transition-all cursor-pointer">
                                        2 Months (Standard)
                                    </button>
                                    <button type="button" @click="depositMultiplier = 3" :class="depositMultiplier === 3 ? 'bg-brandNavy text-white' : 'bg-slate-50 text-slate-700 hover:bg-slate-100 border border-slate-200'" class="py-2.5 rounded-2xl text-xs font-bold transition-all cursor-pointer">
                                        3 Months
                                    </button>
                                </div>
                            </div>

                            <!-- Maintenance Fee -->
                            <div>
                                <div class="flex items-center justify-between mb-2">
                                    <label class="text-xs font-black uppercase tracking-wider text-slate-700">Estimated Society Maintenance</label>
                                    <span class="text-sm font-bold text-slate-900" x-text="formatInr(maintenanceAmount) + '/mo'"></span>
                                </div>
                                <input type="range" min="0" max="10000" step="500" x-model.number="maintenanceAmount" class="w-full h-2 bg-slate-200 rounded-lg appearance-none cursor-pointer accent-emerald-600">
                            </div>
                        </div>

                        <!-- Right Cost Summary Card -->
                        <div class="lg:col-span-5 bg-white rounded-3xl p-6 sm:p-8 border border-emerald-200 shadow-md flex flex-col justify-between">
                            <div>
                                <div class="flex items-center justify-between pb-4 border-b border-slate-100 mb-5">
                                    <span class="text-xs font-black uppercase tracking-wider text-slate-500">Move-In Financial Summary</span>
                                    <span class="px-2.5 py-0.5 rounded-full bg-emerald-50 text-emerald-800 text-[11px] font-bold border border-emerald-300">
                                        0% Brokerage
                                    </span>
                                </div>

                                <div class="space-y-3.5 text-xs font-bold text-slate-700">
                                    <div class="flex items-center justify-between p-3 rounded-xl bg-slate-50 border border-slate-100">
                                        <span>First Month Rent:</span>
                                        <span class="font-black text-slate-900 text-sm" x-text="formatInr(rentAmount)"></span>
                                    </div>
                                    <div class="flex items-center justify-between p-3 rounded-xl bg-slate-50 border border-slate-100">
                                        <span>Refundable Deposit:</span>
                                        <span class="font-black text-slate-900 text-sm" x-text="formatInr(securityDeposit)"></span>
                                    </div>
                                    <div class="flex items-center justify-between p-3 rounded-xl bg-slate-50 border border-slate-100">
                                        <span>Society Maintenance:</span>
                                        <span class="font-black text-slate-900 text-sm" x-text="formatInr(maintenanceAmount)"></span>
                                    </div>
                                    <div class="flex items-center justify-between p-3 rounded-xl bg-emerald-50 border border-emerald-200 text-emerald-900">
                                        <div class="flex items-center gap-1.5">
                                            <span class="material-symbols-outlined text-[16px] text-emerald-600">savings</span>
                                            <span>Brokerage Fee on HomiQ:</span>
                                        </div>
                                        <span class="font-black text-emerald-700 text-sm">₹0 (100% Free)</span>
                                    </div>
                                </div>

                                <div class="mt-6 pt-4 border-t border-slate-200">
                                    <div class="flex items-baseline justify-between mb-1">
                                        <span class="text-xs font-black uppercase tracking-wider text-slate-800">Total Move-In Budget:</span>
                                        <span class="text-2xl font-black text-slate-900" x-text="formatInr(totalMoveIn)"></span>
                                    </div>
                                    <p class="text-[11px] text-emerald-700 font-bold flex items-center gap-1">
                                        <span class="material-symbols-outlined text-[14px]">check_circle</span>
                                        <span>You save <span x-text="formatInr(brokerageSaved)"></span> in broker commissions!</span>
                                    </p>
                                </div>
                            </div>

                            <div class="mt-6">
                                <a :href="'/?max_price=' + rentAmount + '#listings'" class="w-full h-12 rounded-2xl bg-brandNavy hover:bg-slate-900 text-white font-bold text-xs flex items-center justify-center gap-2 shadow-sm transition-all active:scale-98">
                                    <span class="material-symbols-outlined text-base text-emerald-400">search</span>
                                    <span>Search Verified Flats Under <span x-text="formatInr(rentAmount)"></span></span>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </section>

            <!-- ==========================================
                 SECTION 10: POPULAR LOCALITY GUIDES
                 (SEO Links & Local Hubs)
                 ========================================== -->
            <section class="max-w-[1440px] mx-auto px-6 sm:px-8 py-16 w-full" id="locality-guides">
                <div class="flex flex-col md:flex-row md:items-end justify-between gap-4 mb-10">
                    <div>
                        <div class="inline-flex items-center gap-1.5 text-emerald-700 font-black text-xs uppercase tracking-wider mb-2">
                            <span class="material-symbols-outlined text-[16px]">menu_book</span>
                            Locality Intelligence
                        </div>
                        <h2 class="text-3xl sm:text-4xl font-black text-slate-900 tracking-tight">Popular Locality Guides</h2>
                        <p class="text-sm font-semibold text-slate-600 mt-1">Deep insights on high-demand residential sectors, average rents, metro stations, and living costs.</p>
                    </div>
                    <div>
                        <a href="/guides" class="text-xs font-bold text-emerald-700 hover:text-emerald-800 flex items-center gap-1">
                            <span>Browse all guides</span>
                            <span class="material-symbols-outlined text-xs">arrow_forward</span>
                        </a>
                    </div>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                    <!-- Guide 1: Sector 137 Noida -->
                    <div class="group rounded-3xl bg-white p-6 border border-slate-200 shadow-sm hover:border-emerald-500 transition-all duration-300 flex flex-col justify-between">
                        <div>
                            <div class="relative rounded-2xl overflow-hidden aspect-[16/9] mb-4 bg-slate-100">
                                <img alt="Sector 137 Noida" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500" src="https://images.unsplash.com/photo-1545324418-cc1a3fa10c00?auto=format&fit=crop&w=800&q=80">
                                <div class="absolute inset-0 bg-slate-900/40"></div>
                                <div class="absolute bottom-3 left-3 right-3 flex items-center justify-between text-white">
                                    <span class="font-black text-base drop-shadow-md">Sector 137, Noida</span>
                                    <span class="px-2.5 py-0.5 rounded-full bg-slate-900/80 text-[11px] font-bold">Expressway Societies</span>
                                </div>
                            </div>
                            <h3 class="text-lg font-black text-slate-900 mb-1">Noida Expressway Corridor</h3>
                            <p class="text-xs text-slate-600 leading-relaxed font-medium">Paras Tierea, Supertech, metro connectivity, and corporate IT parks.</p>
                        </div>
                        <a href="/?city=Noida&locality=Sector+137#listings" class="mt-5 w-full h-12 rounded-2xl bg-slate-100 hover:bg-brandNavy hover:text-white text-slate-900 font-bold text-xs text-center transition-all flex items-center justify-center gap-1.5 active:scale-98">
                            <span>Explore Sector 137</span>
                            <span class="material-symbols-outlined text-[16px]">arrow_forward</span>
                        </a>
                    </div>

                    <!-- Guide 2: Greater Noida West & Knowledge Park -->
                    <div class="group rounded-3xl bg-white p-6 border border-slate-200 shadow-sm hover:border-emerald-500 transition-all duration-300 flex flex-col justify-between">
                        <div>
                            <div class="relative rounded-2xl overflow-hidden aspect-[16/9] mb-4 bg-slate-100">
                                <img alt="Greater Noida Student PGs & Societies" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500" src="https://images.unsplash.com/photo-1555854877-bab0e564b8d5?auto=format&fit=crop&w=800&q=80">
                                <div class="absolute inset-0 bg-slate-900/40"></div>
                                <div class="absolute bottom-3 left-3 right-3 flex items-center justify-between text-white">
                                    <span class="font-black text-base drop-shadow-md">Greater Noida &amp; Extension</span>
                                    <span class="px-2.5 py-0.5 rounded-full bg-slate-900/80 text-[11px] font-bold">PGs &amp; Gaur City</span>
                                </div>
                            </div>
                            <h3 class="text-lg font-black text-slate-900 mb-1">Student Corridors &amp; Family Homes</h3>
                            <p class="text-xs text-slate-600 leading-relaxed font-medium">Knowledge Park student PGs with meals and Gaur City 2 BHK homes.</p>
                        </div>
                        <a href="/?city=Greater+Noida#listings" class="mt-5 w-full h-12 rounded-2xl bg-slate-100 hover:bg-brandNavy hover:text-white text-slate-900 font-bold text-xs text-center transition-all flex items-center justify-center gap-1.5 active:scale-98">
                            <span>Explore Greater Noida</span>
                            <span class="material-symbols-outlined text-[16px]">arrow_forward</span>
                        </a>
                    </div>

                    <!-- Guide 3: Gurugram & Bangalore Hubs -->
                    <div class="group rounded-3xl bg-white p-6 border border-slate-200 shadow-sm hover:border-emerald-500 transition-all duration-300 flex flex-col justify-between">
                        <div>
                            <div class="relative rounded-2xl overflow-hidden aspect-[16/9] mb-4 bg-slate-100">
                                <img alt="Gurugram & Bangalore IT Hubs" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500" src="https://images.unsplash.com/photo-1512917774080-9991f1c4c750?auto=format&fit=crop&w=800&q=80">
                                <div class="absolute inset-0 bg-slate-900/40"></div>
                                <div class="absolute bottom-3 left-3 right-3 flex items-center justify-between text-white">
                                    <span class="font-black text-base drop-shadow-md">Gurugram &amp; Bangalore</span>
                                    <span class="px-2.5 py-0.5 rounded-full bg-slate-900/80 text-[11px] font-bold">Cyber City &amp; HSR</span>
                                </div>
                            </div>
                            <h3 class="text-lg font-black text-slate-900 mb-1">Tech Corridors &amp; Modern Studios</h3>
                            <p class="text-xs text-slate-600 leading-relaxed font-medium">Cyber City studios, DLF Phase 3, and HSR Layout flats with 0% brokerage.</p>
                        </div>
                        <a href="/rent/gurugram" class="mt-5 w-full h-12 rounded-2xl bg-slate-100 hover:bg-brandNavy hover:text-white text-slate-900 font-bold text-xs text-center transition-all flex items-center justify-center gap-1.5 active:scale-98">
                            <span>Explore Cyber Hub &amp; HSR</span>
                            <span class="material-symbols-outlined text-[16px]">arrow_forward</span>
                        </a>
                    </div>
                </div>
            </section>

            <!-- ==========================================
                 SECTION 11: APP DOWNLOAD
                 (Get Faster Property Alerts on App)
                 ========================================== -->
            <section class="max-w-[1440px] mx-auto px-6 sm:px-8 py-16 w-full" id="download-app">
                <div class="rounded-3xl bg-brandNavy text-white p-8 md:p-14 shadow-soft border border-slate-800 relative overflow-hidden">
                    <!-- Background Glow -->
                    <div class="absolute -right-24 -top-24 w-96 h-96 bg-emerald-500/10 rounded-full blur-3xl pointer-events-none"></div>

                    <div class="grid grid-cols-1 lg:grid-cols-12 gap-10 items-center relative z-10">
                        <div class="lg:col-span-7">
                            <span class="inline-flex items-center gap-1.5 px-3.5 py-1.5 rounded-full bg-white/10 text-emerald-400 text-xs font-bold uppercase tracking-wider mb-4 border border-white/15">
                                <span class="material-symbols-outlined text-[16px]">bolt</span>
                                Real-Time Mobile Engine
                            </span>
                            <h2 class="text-3xl sm:text-5xl font-black text-white tracking-tight leading-tight">
                                Get Faster Property Alerts on the HomiQ App
                            </h2>
                            <p class="text-slate-300 text-sm sm:text-base mt-3 mb-6 max-w-xl font-medium leading-relaxed">
                                Never miss an under-market flat. Connect directly with certified landlords and receive instant notifications the moment matching homes are verified.
                            </p>

                            <!-- Key App Benefits Grid -->
                            <div class="grid grid-cols-1 sm:grid-cols-2 gap-3.5 mb-8 max-w-xl">
                                <div class="flex items-center gap-2.5 p-3 rounded-2xl bg-white/5 border border-white/10">
                                    <span class="material-symbols-outlined text-emerald-400 text-[20px] shrink-0">chat</span>
                                    <span class="text-xs font-bold text-slate-100">Instant owner replies</span>
                                </div>
                                <div class="flex items-center gap-2.5 p-3 rounded-2xl bg-white/5 border border-white/10">
                                    <span class="material-symbols-outlined text-emerald-400 text-[20px] shrink-0">saved_search</span>
                                    <span class="text-xs font-bold text-slate-100">Saved searches</span>
                                </div>
                                <div class="flex items-center gap-2.5 p-3 rounded-2xl bg-white/5 border border-white/10">
                                    <span class="material-symbols-outlined text-emerald-400 text-[20px] shrink-0">notifications_active</span>
                                    <span class="text-xs font-bold text-slate-100">New listing alerts</span>
                                </div>
                                <div class="flex items-center gap-2.5 p-3 rounded-2xl bg-white/5 border border-white/10">
                                    <span class="material-symbols-outlined text-emerald-400 text-[20px] shrink-0">share</span>
                                    <span class="text-xs font-bold text-slate-100">Property sharing</span>
                                </div>
                                <div class="flex items-center gap-2.5 p-3 rounded-2xl bg-white/5 border border-white/10 sm:col-span-2">
                                    <span class="material-symbols-outlined text-emerald-400 text-[20px] shrink-0">calendar_month</span>
                                    <span class="text-xs font-bold text-slate-100">Visit scheduling &amp; reminders</span>
                                </div>
                            </div>

                            <!-- Download Badges -->
                            <div class="space-y-3">
                                <span class="block text-[11px] font-black tracking-widest uppercase text-slate-400">
                                    DOWNLOAD FREE FOR IOS &amp; ANDROID
                                </span>
                                <div class="flex flex-col sm:flex-row items-stretch sm:items-center gap-4 flex-wrap">
                                    <!-- Google Play Badge -->
                                    <a href="https://play.google.com/store/apps/details?id=com.homiq.acrocoder&hl=en" target="_blank" class="h-14 px-5 rounded-2xl bg-black hover:bg-slate-900 text-white border border-slate-700 hover:border-slate-500 flex items-center gap-3.5 shadow-lg transition-all hover:scale-[1.02] active:scale-[0.98]">
                                        <svg class="w-7 h-7 shrink-0" viewBox="0 0 512 512">
                                            <path fill="#4285F4" d="M47.7 28.5C43.3 33.2 40.7 39.9 40.7 47.5V464.5c0 7.6 2.6 14.3 7 19L273.1 258 47.7 28.5z"/>
                                            <path fill="#34A853" d="M346.5 184.5L273.1 258 47.7 28.5c4-4.3 9.9-7.2 16.5-7.2 4.1 0 7.9 1.1 11.4 3L346.5 184.5z"/>
                                            <path fill="#EA4335" d="M47.7 483.5c4 4.3 9.9 7.2 16.5 7.2 4.1 0 7.9-1.1 11.4-3l270.9-156.2L273.1 258 47.7 483.5z"/>
                                            <path fill="#FBBC05" d="M464.3 243.6L346.5 175.7 273.1 258l73.4 82.3 117.8-67.9c13.7-7.9 13.7-20.8 0-28.8z"/>
                                        </svg>
                                        <div class="text-left">
                                            <span class="block text-[9px] text-slate-400 font-bold uppercase tracking-wider leading-none">GET IT ON</span>
                                            <span class="text-base font-bold text-white tracking-tight leading-tight block mt-0.5">Google Play</span>
                                        </div>
                                    </a>

                                    <!-- Apple App Store Badge -->
                                    <a href="https://apps.apple.com/in/app/homiq-real-estate-marketplace/id6779412636" target="_blank" class="h-14 px-5 rounded-2xl bg-black hover:bg-slate-900 text-white border border-slate-700 hover:border-slate-500 flex items-center gap-3.5 shadow-lg transition-all hover:scale-[1.02] active:scale-[0.98]">
                                        <svg class="w-7 h-7 fill-current text-white shrink-0" viewBox="0 0 170 170">
                                            <path d="M150.37 130.25c-2.45 5.66-5.35 10.87-8.71 15.66-4.58 6.53-8.33 11.05-11.22 13.56-4.48 4.12-9.28 6.23-14.42 6.35-3.69 0-8.14-1.05-13.32-3.18-5.19-2.12-9.97-3.17-14.34-3.17-4.58 0-9.49 1.05-14.75 3.17-5.26 2.13-9.5 3.24-12.74 3.35-4.35.13-9.16-1.9-14.42-6.08-3.7-3.04-7.7-7.8-12.01-14.28-5.44-8.15-9.76-17.65-12.96-28.48-3.2-10.84-4.8-21.2-4.8-31.1 0-14.82 3.73-26.65 11.2-35.48 7.46-8.84 16.73-13.35 27.81-13.55 4.8 0 10.14 1.25 16.03 3.75 5.88 2.5 9.73 3.8 11.54 3.9 1.48 0 5.63-1.42 12.44-4.24 6.81-2.83 12.77-4.08 17.87-3.76 13.74.8 24.32 5.92 31.75 15.36-12.07 7.34-18.01 17.51-17.81 30.5.21 10.16 4.17 18.66 11.89 25.48 3.51 3.15 7.44 5.48 11.78 7 1.06 3.71 2.05 7.43 2.97 11.16zm-38.31-105.12c0 3.83-1.07 7.79-3.21 11.89-2.14 4.09-5.11 7.46-8.91 10.11-3.6 2.47-7.42 4.04-11.45 4.7-1.1-.96-1.74-2.58-1.92-4.85-.23-2.92.42-6.1 1.95-9.54 1.53-3.44 3.76-6.49 6.69-9.14 3.15-2.84 6.74-4.83 10.77-5.97 4.03-1.14 7.28-1.54 9.76-1.2.22 1.34.32 2.67.32 4z"/>
                                        </svg>
                                        <div class="text-left">
                                            <span class="block text-[9px] text-slate-400 font-medium leading-none">Download on the</span>
                                            <span class="text-base font-bold text-white tracking-tight leading-tight block mt-0.5">App Store</span>
                                        </div>
                                    </a>
                                </div>
                            </div>
                        </div>

                        <!-- Right Visual Badge Showcase -->
                        <div class="lg:col-span-5 flex justify-center lg:justify-end">
                            <div class="rounded-3xl bg-white/10 border border-white/20 p-6 sm:p-8 backdrop-blur-sm text-center max-w-sm w-full space-y-4 shadow-xl">
                                <div class="w-16 h-16 rounded-2xl bg-emerald-500/20 border border-emerald-500/30 text-emerald-400 flex items-center justify-center mx-auto shadow-inner">
                                    <span class="material-symbols-outlined text-[32px]">smartphone</span>
                                </div>
                                <h3 class="text-xl font-black text-white">0% Brokerage Mobile App</h3>
                                <p class="text-xs text-slate-200 leading-relaxed font-medium">Browse 100% on-site verified flats in Noida, Bangalore, and Delhi NCR with direct WhatsApp &amp; in-app landlord chats.</p>
                                <div class="pt-2 flex items-center justify-center gap-2 text-emerald-300 text-xs font-bold">
                                    <span class="material-symbols-outlined text-[18px]">verified</span>
                                    <span>Instant In-App Chat</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </section>

            <!-- ==========================================
                 SECTION 12: SAFETY & VERIFICATION
                 (How HomiQ Verifies Properties)
                 ========================================== -->
            <section class="max-w-[1440px] mx-auto px-6 sm:px-8 py-16 w-full" id="safety-verification">
                <div class="rounded-3xl bg-slate-900 text-white p-8 md:p-14 shadow-xl border border-slate-800 relative overflow-hidden">
                    <div class="absolute -right-20 -top-20 w-96 h-96 bg-emerald-500/10 rounded-full blur-3xl pointer-events-none"></div>

                    <div class="flex flex-col md:flex-row md:items-end justify-between gap-6 mb-12 relative z-10">
                        <div>
                            <span class="inline-flex items-center gap-1.5 px-3.5 py-1.5 rounded-full bg-emerald-500/20 text-emerald-400 text-xs font-bold uppercase tracking-wider mb-3 border border-emerald-500/30">
                                <span class="material-symbols-outlined text-[16px]">verified</span>
                                Zero Phantom Listings Policy
                            </span>
                            <h2 class="text-3xl sm:text-5xl font-black text-white tracking-tight leading-tight">
                                How HomiQ Verifies Properties
                            </h2>
                            <p class="text-slate-300 text-sm sm:text-base mt-2 max-w-2xl font-medium leading-relaxed">
                                Unlike traditional portals flooded with outdated duplicates and fake broker listings, every approved home on HomiQ undergoes a rigorous 4-step verification protocol.
                            </p>
                        </div>

                        <div class="shrink-0 flex items-center gap-3">
                            <a href="/verification-standards" class="h-12 px-6 rounded-full bg-white/10 hover:bg-white/20 text-white font-bold text-xs flex items-center justify-center gap-2 border border-white/20 transition">
                                <span>Verification Standards</span>
                                <span class="material-symbols-outlined text-base">verified_user</span>
                            </a>
                            <a href="/safety" class="h-12 px-6 rounded-full bg-emerald-600 hover:bg-emerald-500 text-white font-bold text-xs flex items-center justify-center gap-2 shadow-lg transition transform hover:scale-105 active:scale-95 cursor-pointer">
                                <span>Safety Center</span>
                                <span class="material-symbols-outlined text-base">shield</span>
                            </a>
                        </div>
                    </div>

                    <!-- 4-Step Process Grid -->
                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 relative z-10">
                        <!-- Step 1 -->
                        <div class="p-6 rounded-2xl bg-white/5 border border-white/10 hover:border-emerald-500/40 transition flex flex-col justify-between">
                            <div>
                                <div class="h-12 w-12 rounded-2xl bg-emerald-500/20 text-emerald-400 flex items-center justify-center font-black text-lg mb-4">
                                    <span class="material-symbols-outlined text-2xl">badge</span>
                                </div>
                                <span class="text-[10px] font-extrabold uppercase tracking-widest text-emerald-400 block mb-1">Step 01</span>
                                <h3 class="text-lg font-black text-white mb-2">Landlord KYC &amp; ID Check</h3>
                                <p class="text-xs text-slate-300 leading-relaxed font-medium">
                                    Every host submits government-issued identification (Aadhaar/PAN) and completes OTP mobile validation before listing.
                                </p>
                            </div>
                            <div class="mt-4 pt-3 border-t border-white/10 flex items-center gap-1.5 text-[11px] font-bold text-emerald-400">
                                <span class="material-symbols-outlined text-sm">check_circle</span>
                                <span>Zero Impersonation</span>
                            </div>
                        </div>

                        <!-- Step 2 -->
                        <div class="p-6 rounded-2xl bg-white/5 border border-white/10 hover:border-emerald-500/40 transition flex flex-col justify-between">
                            <div>
                                <div class="h-12 w-12 rounded-2xl bg-emerald-500/20 text-emerald-400 flex items-center justify-center font-black text-lg mb-4">
                                    <span class="material-symbols-outlined text-2xl">pin_drop</span>
                                </div>
                                <span class="text-[10px] font-extrabold uppercase tracking-widest text-emerald-400 block mb-1">Step 02</span>
                                <h3 class="text-lg font-black text-white mb-2">Physical Location Audit</h3>
                                <p class="text-xs text-slate-300 leading-relaxed font-medium">
                                    Geotagged GPS coordinates, exact building towers, and walk-times to nearest metro stations are verified on the ground.
                                </p>
                            </div>
                            <div class="mt-4 pt-3 border-t border-white/10 flex items-center gap-1.5 text-[11px] font-bold text-emerald-400">
                                <span class="material-symbols-outlined text-sm">check_circle</span>
                                <span>Exact Landmark Geotag</span>
                            </div>
                        </div>

                        <!-- Step 3 -->
                        <div class="p-6 rounded-2xl bg-white/5 border border-white/10 hover:border-emerald-500/40 transition flex flex-col justify-between">
                            <div>
                                <div class="h-12 w-12 rounded-2xl bg-emerald-500/20 text-emerald-400 flex items-center justify-center font-black text-lg mb-4">
                                    <span class="material-symbols-outlined text-2xl">photo_camera</span>
                                </div>
                                <span class="text-[10px] font-extrabold uppercase tracking-widest text-emerald-400 block mb-1">Step 03</span>
                                <h3 class="text-lg font-black text-white mb-2">Authentic Photo Audit</h3>
                                <p class="text-xs text-slate-300 leading-relaxed font-medium">
                                    We match submitted photographs against physical room angles and furnishings to ensure what you see is what you rent.
                                </p>
                            </div>
                            <div class="mt-4 pt-3 border-t border-white/10 flex items-center gap-1.5 text-[11px] font-bold text-emerald-400">
                                <span class="material-symbols-outlined text-sm">check_circle</span>
                                <span>No Stock Photos</span>
                            </div>
                        </div>

                        <!-- Step 4 -->
                        <div class="p-6 rounded-2xl bg-white/5 border border-white/10 hover:border-emerald-500/40 transition flex flex-col justify-between">
                            <div>
                                <div class="h-12 w-12 rounded-2xl bg-emerald-500/20 text-emerald-400 flex items-center justify-center font-black text-lg mb-4">
                                    <span class="material-symbols-outlined text-2xl">schedule</span>
                                </div>
                                <span class="text-[10px] font-extrabold uppercase tracking-widest text-emerald-400 block mb-1">Step 04</span>
                                <h3 class="text-lg font-black text-white mb-2">30-Day Freshness Cycle</h3>
                                <p class="text-xs text-slate-300 leading-relaxed font-medium">
                                    Listings expire after 30 days unless landlords re-confirm vacant availability. Stale and rented units are archived automatically.
                                </p>
                            </div>
                            <div class="mt-4 pt-3 border-t border-white/10 flex items-center gap-1.5 text-[11px] font-bold text-emerald-400">
                                <span class="material-symbols-outlined text-sm">check_circle</span>
                                <span>100% Genuine Availability</span>
                            </div>
                        </div>
                    </div>
                </div>
            </section>

        </div>
    </main>

    <!-- ==========================================
         MODALS & INTERACTIVE OVERLAYS
         ========================================== -->

    <!-- Modal 1: Post a Property Request -->
    <div x-show="requestModalOpen" 
         x-cloak
         class="fixed inset-0 z-50 overflow-y-auto"
         aria-labelledby="modal-title" role="dialog" aria-modal="true">
        <div class="flex items-center justify-center min-h-screen px-4 pt-4 pb-20 text-center sm:block sm:p-0">
            <div x-show="requestModalOpen" 
                 x-transition:enter="ease-out duration-300"
                 x-transition:enter-start="opacity-0"
                 x-transition:enter-end="opacity-100"
                 x-transition:leave="ease-in duration-200"
                 x-transition:leave-start="opacity-100"
                 x-transition:leave-end="opacity-0"
                 class="fixed inset-0 bg-slate-900/60 transition-opacity" 
                 @click="requestModalOpen = false"></div>

            <span class="hidden sm:inline-block sm:align-middle sm:h-screen" aria-hidden="true">&#8203;</span>

            <div x-show="requestModalOpen" 
                 x-transition:enter="ease-out duration-300"
                 x-transition:enter-start="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
                 x-transition:enter-end="opacity-100 translate-y-0 sm:scale-100"
                 x-transition:leave="ease-in duration-200"
                 x-transition:leave-start="opacity-100 translate-y-0 sm:scale-100"
                 x-transition:leave-end="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
                 class="inline-block align-bottom bg-white rounded-3xl text-left overflow-hidden shadow-2xl transform transition-all sm:my-8 sm:align-middle sm:max-w-lg sm:w-full border border-slate-200 p-6 sm:p-8">
                
                <div class="flex items-center justify-between pb-4 border-b border-slate-200 mb-5">
                    <div>
                        <span class="text-[10px] font-black uppercase tracking-wider text-emerald-700">Demand Board</span>
                        <h3 class="text-xl font-black text-slate-900">Post a Property Request</h3>
                    </div>
                    <button @click="requestModalOpen = false" type="button" class="h-8 w-8 rounded-full bg-slate-100 hover:bg-slate-200 flex items-center justify-center text-slate-700 cursor-pointer">
                        <span class="material-symbols-outlined text-sm">close</span>
                    </button>
                </div>

                <form id="property-request-form" onsubmit="submitPropertyRequest(event)" class="space-y-4 text-xs font-bold text-slate-800">
                    @csrf
                    <div>
                        <label class="block text-slate-700 mb-1">Your Name *</label>
                        <input type="text" name="seeker_name" required placeholder="e.g. Rahul Sharma" value="{{ Auth::user()?->name }}" class="w-full px-3.5 py-2.5 rounded-xl bg-white border border-slate-300 text-slate-900 text-xs font-bold focus:ring-2 focus:ring-emerald-500">
                    </div>

                    <div class="grid grid-cols-2 gap-3">
                        <div>
                            <label class="block text-slate-700 mb-1">Phone Number (WhatsApp) *</label>
                            <input type="tel" name="seeker_phone" required placeholder="e.g. 9876543210" value="{{ Auth::user()?->phone }}" class="w-full px-3.5 py-2.5 rounded-xl bg-white border border-slate-300 text-slate-900 text-xs font-bold focus:ring-2 focus:ring-emerald-500">
                        </div>
                        <div>
                            <label class="block text-slate-700 mb-1">City *</label>
                            <input type="text" name="city" required placeholder="e.g. Noida, Bangalore" class="w-full px-3.5 py-2.5 rounded-xl bg-white border border-slate-300 text-slate-900 text-xs font-bold focus:ring-2 focus:ring-emerald-500">
                        </div>
                    </div>

                    <div class="grid grid-cols-2 gap-3">
                        <div>
                            <label class="block text-slate-700 mb-1">Locality / Sector</label>
                            <input type="text" name="locality" placeholder="e.g. Sector 137 or HSR Layout" class="w-full px-3.5 py-2.5 rounded-xl bg-white border border-slate-300 text-slate-900 text-xs font-bold focus:ring-2 focus:ring-emerald-500">
                        </div>
                        <div>
                            <label class="block text-slate-700 mb-1">Purpose *</label>
                            <select name="purpose" class="w-full px-3 py-2.5 rounded-xl bg-white border border-slate-300 text-slate-900 text-xs font-bold focus:ring-2 focus:ring-emerald-500">
                                <option value="rent" selected>Rent</option>
                                <option value="buy">Buy</option>
                            </select>
                        </div>
                    </div>

                    <div class="grid grid-cols-3 gap-2">
                        <div>
                            <label class="block text-slate-700 mb-1">Type *</label>
                            <select name="property_type" class="w-full px-2 py-2.5 rounded-xl bg-white border border-slate-300 text-slate-900 text-xs font-bold">
                                <option value="Apartment">Apartment</option>
                                <option value="PG / Co-living">PG / Co-living</option>
                                <option value="House">House / Villa</option>
                                <option value="Commercial">Commercial</option>
                            </select>
                        </div>
                        <div>
                            <label class="block text-slate-700 mb-1">BHK / Size</label>
                            <select name="bedrooms" class="w-full px-2 py-2.5 rounded-xl bg-white border border-slate-300 text-slate-900 text-xs font-bold">
                                <option value="1 BHK">1 BHK</option>
                                <option value="2 BHK" selected>2 BHK</option>
                                <option value="3 BHK">3 BHK</option>
                                <option value="Studio">Studio</option>
                                <option value="N/A">N/A</option>
                            </select>
                        </div>
                        <div>
                            <label class="block text-slate-700 mb-1">Max Budget (₹) *</label>
                            <input type="number" name="max_budget" required placeholder="e.g. 25000" class="w-full px-2 py-2.5 rounded-xl bg-white border border-slate-300 text-slate-900 text-xs font-bold focus:ring-2 focus:ring-emerald-500">
                        </div>
                    </div>

                    <div class="grid grid-cols-2 gap-3">
                        <div>
                            <label class="block text-slate-700 mb-1">Tenant Type</label>
                            <select name="tenant_type" class="w-full px-3 py-2.5 rounded-xl bg-white border border-slate-300 text-slate-900 text-xs font-bold">
                                <option value="Family">Family</option>
                                <option value="Bachelors" selected>Bachelors / Working</option>
                                <option value="Students">Students</option>
                                <option value="Company Lease">Company Lease</option>
                            </select>
                        </div>
                        <div>
                            <label class="block text-slate-700 mb-1">Move-in Date</label>
                            <input type="date" name="move_in_date" class="w-full px-3 py-2 rounded-xl bg-white border border-slate-300 text-slate-900 text-xs font-bold">
                        </div>
                    </div>

                    <div>
                        <label class="block text-slate-700 mb-1">Specific Requirements / Notes</label>
                        <textarea name="description" rows="2" placeholder="e.g. Near Sector 137 metro, semi-furnished, reserved parking required..." class="w-full px-3.5 py-2 rounded-xl bg-white border border-slate-300 text-slate-900 text-xs font-bold focus:ring-2 focus:ring-emerald-500"></textarea>
                    </div>

                    <div class="pt-2">
                        <button type="submit" id="submit-request-btn" class="w-full py-3.5 rounded-2xl bg-emerald-600 hover:bg-emerald-700 text-white font-extrabold text-sm shadow-md transition-all flex items-center justify-center gap-2 cursor-pointer active:scale-98">
                            <span class="material-symbols-outlined text-[18px]">campaign</span>
                            <span>Post Request to Demand Board</span>
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Modal 2: Save Search Alert Modal -->
    <div x-show="saveSearchModalOpen" 
         x-cloak
         class="fixed inset-0 z-50 overflow-y-auto"
         aria-labelledby="modal-title" role="dialog" aria-modal="true">
        <div class="flex items-center justify-center min-h-screen px-4 pt-4 pb-20 text-center sm:block sm:p-0">
            <div x-show="saveSearchModalOpen" 
                 x-transition:enter="ease-out duration-300"
                 x-transition:enter-start="opacity-0"
                 x-transition:enter-end="opacity-100"
                 x-transition:leave="ease-in duration-200"
                 x-transition:leave-start="opacity-100"
                 x-transition:leave-end="opacity-0"
                 class="fixed inset-0 bg-slate-900/60 transition-opacity" 
                 @click="saveSearchModalOpen = false"></div>

            <span class="hidden sm:inline-block sm:align-middle sm:h-screen" aria-hidden="true">&#8203;</span>

            <div x-show="saveSearchModalOpen" 
                 x-transition:enter="ease-out duration-300"
                 x-transition:enter-start="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
                 x-transition:enter-end="opacity-100 translate-y-0 sm:scale-100"
                 x-transition:leave="ease-in duration-200"
                 x-transition:leave-start="opacity-100 translate-y-0 sm:scale-100"
                 x-transition:leave-end="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
                 class="inline-block align-bottom bg-white rounded-3xl text-left overflow-hidden shadow-2xl transform transition-all sm:my-8 sm:align-middle sm:max-w-md sm:w-full border border-slate-200 p-6 sm:p-8">
                
                <div class="flex items-center justify-between pb-4 border-b border-slate-200 mb-5">
                    <div class="flex items-center gap-2">
                        <div class="w-9 h-9 rounded-xl bg-emerald-50 text-emerald-600 flex items-center justify-center">
                            <span class="material-symbols-outlined text-[20px]">notifications_active</span>
                        </div>
                        <div>
                            <h3 class="text-lg font-black text-slate-900">Save Search &amp; Alerts</h3>
                            <p class="text-[11px] text-slate-500 font-semibold">Get notified when new matching flats are listed</p>
                        </div>
                    </div>
                    <button @click="saveSearchModalOpen = false" type="button" class="h-8 w-8 rounded-full bg-slate-100 hover:bg-slate-200 flex items-center justify-center text-slate-700 cursor-pointer">
                        <span class="material-symbols-outlined text-sm">close</span>
                    </button>
                </div>

                <form id="save-search-form" onsubmit="submitSaveSearch(event)" class="space-y-4 text-xs font-bold text-slate-800">
                    @csrf
                    <input type="hidden" name="search_query" value="{{ request('search', '') }}">
                    <input type="hidden" name="city" value="{{ $selectedCity ?? request('city', '') }}">
                    <input type="hidden" name="locality" value="{{ request('locality', '') }}">
                    <input type="hidden" name="property_type" value="{{ request('search_type', '') }}">
                    <input type="hidden" name="bedrooms" value="{{ request('bedrooms', '') }}">
                    <input type="hidden" name="max_price" value="{{ request('max_price', '') }}">
                    <input type="hidden" name="listing_type" value="{{ request('listing_type', 'rent') }}">

                    <div>
                        <label class="block text-slate-700 mb-1">Search Label</label>
                        <input type="text" name="title" required value="{{ request('search') ? request('search') : ((request('bedrooms') ? request('bedrooms') . ' BHK in ' : '') . ($selectedCity ?? 'Noida') . (request('max_price') ? ' under ₹' . number_format(request('max_price')) : '')) }}" class="w-full px-3.5 py-2.5 rounded-xl bg-white border border-slate-300 text-slate-900 text-xs font-bold focus:ring-2 focus:ring-emerald-500">
                    </div>

                    <div>
                        <label class="block text-slate-700 mb-1">Your Email for Alerts *</label>
                        <input type="email" name="user_email" required value="{{ Auth::user()?->email }}" placeholder="e.g. name@example.com" class="w-full px-3.5 py-2.5 rounded-xl bg-white border border-slate-300 text-slate-900 text-xs font-bold focus:ring-2 focus:ring-emerald-500">
                    </div>

                    <div>
                        <label class="block text-slate-700 mb-1">Alert Frequency</label>
                        <select name="frequency" class="w-full px-3 py-2.5 rounded-xl bg-white border border-slate-300 text-slate-900 text-xs font-bold">
                            <option value="instant">Instant (Real-time notification)</option>
                            <option value="daily" selected>Daily Digest</option>
                            <option value="weekly">Weekly Summary</option>
                        </select>
                    </div>

                    <div class="pt-2">
                        <button type="submit" :disabled="saveSearchSubmitting" class="w-full py-3.5 rounded-2xl bg-emerald-600 hover:bg-emerald-700 text-white font-extrabold text-sm shadow-md transition-all flex items-center justify-center gap-2 cursor-pointer active:scale-98">
                            <span class="material-symbols-outlined text-[18px]">notifications_active</span>
                            <span x-text="saveSearchSubmitting ? 'Saving...' : 'Activate Search Alert'"></span>
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Modal 3: Share Property Modal -->
    <div x-show="shareModalOpen" 
         x-cloak
         class="fixed inset-0 z-50 overflow-y-auto"
         aria-labelledby="modal-title" role="dialog" aria-modal="true">
        <div class="flex items-center justify-center min-h-screen px-4 pt-4 pb-20 text-center sm:block sm:p-0">
            <div x-show="shareModalOpen" 
                 x-transition:enter="ease-out duration-300"
                 x-transition:enter-start="opacity-0"
                 x-transition:enter-end="opacity-100"
                 x-transition:leave="ease-in duration-200"
                 x-transition:leave-start="opacity-100"
                 x-transition:leave-end="opacity-0"
                 class="fixed inset-0 bg-slate-900/60 transition-opacity" 
                 @click="shareModalOpen = false"></div>

            <span class="hidden sm:inline-block sm:align-middle sm:h-screen" aria-hidden="true">&#8203;</span>

            <div x-show="shareModalOpen" 
                 x-transition:enter="ease-out duration-300"
                 x-transition:enter-start="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
                 x-transition:enter-end="opacity-100 translate-y-0 sm:scale-100"
                 x-transition:leave="ease-in duration-200"
                 x-transition:leave-start="opacity-100 translate-y-0 sm:scale-100"
                 x-transition:leave-end="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
                 class="inline-block align-bottom bg-white rounded-3xl text-left overflow-hidden shadow-2xl transform transition-all sm:my-8 sm:align-middle sm:max-w-md sm:w-full border border-slate-200 p-6 sm:p-8">
                
                <div class="flex items-center justify-between pb-4 border-b border-slate-200 mb-5">
                    <div class="flex items-center gap-2">
                        <div class="w-9 h-9 rounded-xl bg-emerald-50 text-emerald-600 flex items-center justify-center">
                            <span class="material-symbols-outlined text-[20px]">share</span>
                        </div>
                        <div>
                            <h3 class="text-lg font-black text-slate-900">Share Listing</h3>
                            <p class="text-[11px] text-slate-500 font-semibold">Share verified listing with friends or family</p>
                        </div>
                    </div>
                    <button @click="shareModalOpen = false" type="button" class="h-8 w-8 rounded-full bg-slate-100 hover:bg-slate-200 flex items-center justify-center text-slate-700 cursor-pointer">
                        <span class="material-symbols-outlined text-sm">close</span>
                    </button>
                </div>

                <div class="space-y-4">
                    <div class="p-3.5 rounded-2xl bg-slate-50 border border-slate-200">
                        <h4 class="text-xs font-black text-slate-900 line-clamp-1" x-text="shareData.title"></h4>
                        <p class="text-[11px] text-slate-500 line-clamp-1 mt-0.5" x-text="shareData.address"></p>
                        <span class="text-xs font-black text-emerald-700 mt-1 block" x-text="shareData.price"></span>
                    </div>

                    <div class="grid grid-cols-2 gap-3">
                        <a :href="'https://wa.me/?text=' + encodeURIComponent(shareData.title + ' (' + shareData.price + ')\\n' + shareData.address + '\\nVerified 0% Brokerage on HomiQ:\\n' + shareData.url)" target="_blank" class="h-12 rounded-2xl bg-emerald-600 hover:bg-emerald-700 text-white font-bold text-xs flex items-center justify-center gap-2 shadow-xs transition">
                            <span class="material-symbols-outlined text-lg">chat</span>
                            <span>WhatsApp</span>
                        </a>
                        <button type="button" @click="copyToClipboard(shareData.url)" class="h-12 rounded-2xl bg-slate-900 hover:bg-slate-800 text-white font-bold text-xs flex items-center justify-center gap-2 shadow-xs transition cursor-pointer">
                            <span class="material-symbols-outlined text-lg">content_copy</span>
                            <span>Copy Link</span>
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal 4: Comprehensive Search Filters Modal -->
    <div x-show="filtersModalOpen" 
         x-cloak
         class="fixed inset-0 z-50 overflow-y-auto"
         aria-labelledby="modal-title" role="dialog" aria-modal="true">
        <div class="flex items-center justify-center min-h-screen px-4 pt-4 pb-20 text-center sm:block sm:p-0">
            <div x-show="filtersModalOpen" 
                 x-transition:enter="ease-out duration-300"
                 x-transition:enter-start="opacity-0"
                 x-transition:enter-end="opacity-100"
                 x-transition:leave="ease-in duration-200"
                 x-transition:leave-start="opacity-100"
                 x-transition:leave-end="opacity-0"
                 class="fixed inset-0 bg-slate-900/60 transition-opacity" 
                 @click="filtersModalOpen = false"></div>

            <span class="hidden sm:inline-block sm:align-middle sm:h-screen" aria-hidden="true">&#8203;</span>

            <div x-show="filtersModalOpen" 
                 x-transition:enter="ease-out duration-300"
                 x-transition:enter-start="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
                 x-transition:enter-end="opacity-100 translate-y-0 sm:scale-100"
                 x-transition:leave="ease-in duration-200"
                 x-transition:leave-start="opacity-100 translate-y-0 sm:scale-100"
                 x-transition:leave-end="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
                 class="inline-block align-bottom bg-white rounded-3xl text-left overflow-hidden shadow-2xl transform transition-all sm:my-8 sm:align-middle sm:max-w-xl sm:w-full border border-slate-200 p-6 sm:p-8">
                
                <div class="flex items-center justify-between pb-4 border-b border-slate-200 mb-6">
                    <div class="flex items-center gap-2">
                        <div class="w-9 h-9 rounded-xl bg-emerald-50 text-emerald-600 flex items-center justify-center">
                            <span class="material-symbols-outlined text-[20px]">tune</span>
                        </div>
                        <h3 class="text-lg font-black text-slate-900">Advanced Property Filters</h3>
                    </div>
                    <button @click="filtersModalOpen = false" type="button" class="h-8 w-8 rounded-full bg-slate-100 hover:bg-slate-200 flex items-center justify-center text-slate-700 cursor-pointer">
                        <span class="material-symbols-outlined text-sm">close</span>
                    </button>
                </div>

                <form action="/#listings" method="GET" class="space-y-6 text-xs font-bold text-slate-800">
                    <input type="hidden" name="search" value="{{ request('search') }}">
                    <input type="hidden" name="city" value="{{ $selectedCity ?? request('city') }}">

                    <!-- Purpose -->
                    <div>
                        <label class="block text-slate-700 mb-2">Listing Purpose</label>
                        <div class="grid grid-cols-2 gap-3">
                            <label class="flex items-center justify-center p-3 rounded-2xl border border-slate-200 cursor-pointer has-[:checked]:border-brandNavy has-[:checked]:bg-brandNavy has-[:checked]:text-white">
                                <input type="radio" name="listing_type" value="rent" class="hidden" {{ request('listing_type', 'rent') === 'rent' ? 'checked' : '' }}>
                                <span>Rent</span>
                            </label>
                            <label class="flex items-center justify-center p-3 rounded-2xl border border-slate-200 cursor-pointer has-[:checked]:border-brandNavy has-[:checked]:bg-brandNavy has-[:checked]:text-white">
                                <input type="radio" name="listing_type" value="sale" class="hidden" {{ request('listing_type') === 'sale' ? 'checked' : '' }}>
                                <span>Buy / Sale</span>
                            </label>
                        </div>
                    </div>

                    <!-- Bedrooms -->
                    <div>
                        <label class="block text-slate-700 mb-2">Bedrooms (BHK)</label>
                        <div class="grid grid-cols-4 gap-2">
                            @foreach(['all' => 'Any BHK', '1' => '1 BHK', '2' => '2 BHK', '3' => '3+ BHK'] as $key => $lbl)
                            <label class="flex items-center justify-center p-2.5 rounded-2xl border border-slate-200 cursor-pointer has-[:checked]:border-emerald-600 has-[:checked]:bg-emerald-600 has-[:checked]:text-white text-center">
                                <input type="radio" name="bedrooms" value="{{ $key }}" class="hidden" {{ request('bedrooms', 'all') == $key ? 'checked' : '' }}>
                                <span>{{ $lbl }}</span>
                            </label>
                            @endforeach
                        </div>
                    </div>

                    <!-- Budget & Deposit Limits -->
                    <div class="grid grid-cols-2 gap-4">
                        <div>
                            <label class="block text-slate-700 mb-1">Max Budget (₹)</label>
                            <select name="max_price" class="w-full px-3 py-2.5 rounded-xl bg-white border border-slate-300 text-slate-900 text-xs font-bold">
                                <option value="">No Max Limit</option>
                                <option value="15000" {{ request('max_price') == '15000' ? 'selected' : '' }}>₹15,000</option>
                                <option value="25000" {{ request('max_price') == '25000' ? 'selected' : '' }}>₹25,000</option>
                                <option value="40000" {{ request('max_price') == '40000' ? 'selected' : '' }}>₹40,000</option>
                                <option value="60000" {{ request('max_price') == '60000' ? 'selected' : '' }}>₹60,000</option>
                                <option value="100000" {{ request('max_price') == '100000' ? 'selected' : '' }}>₹1,00,000</option>
                                <option value="15000000" {{ request('max_price') == '15000000' ? 'selected' : '' }}>₹1.50 Cr</option>
                            </select>
                        </div>
                        <div>
                            <label class="block text-slate-700 mb-1">Max Security Deposit (₹)</label>
                            <select name="max_deposit" class="w-full px-3 py-2.5 rounded-xl bg-white border border-slate-300 text-slate-900 text-xs font-bold">
                                <option value="">Any Deposit</option>
                                <option value="20000" {{ request('max_deposit') == '20000' ? 'selected' : '' }}>Up to ₹20,000</option>
                                <option value="50000" {{ request('max_deposit') == '50000' ? 'selected' : '' }}>Up to ₹50,000</option>
                                <option value="100000" {{ request('max_deposit') == '100000' ? 'selected' : '' }}>Up to ₹1,00,000</option>
                            </select>
                        </div>
                    </div>

                    <!-- Direct Toggles (Near Metro, Available Immediately, Furnished) -->
                    <div class="space-y-3 pt-2">
                        <label class="flex items-center gap-3 p-3 rounded-2xl bg-slate-50 border border-slate-200 cursor-pointer">
                            <input type="checkbox" name="near_metro" value="1" {{ request('near_metro') ? 'checked' : '' }} class="h-4 w-4 rounded text-emerald-600 focus:ring-emerald-500 border-slate-300">
                            <div>
                                <span class="block text-xs font-black text-slate-900">Near Metro Station (&lt; 1 km)</span>
                                <span class="block text-[11px] text-slate-500 font-medium">Walking distance to metro connectivity</span>
                            </div>
                        </label>

                        <label class="flex items-center gap-3 p-3 rounded-2xl bg-slate-50 border border-slate-200 cursor-pointer">
                            <input type="checkbox" name="available_now" value="1" {{ request('available_now') ? 'checked' : '' }} class="h-4 w-4 rounded text-emerald-600 focus:ring-emerald-500 border-slate-300">
                            <div>
                                <span class="block text-xs font-black text-slate-900">Available Immediately</span>
                                <span class="block text-[11px] text-slate-500 font-medium">Ready to move-in right now</span>
                            </div>
                        </label>

                        <label class="flex items-center gap-3 p-3 rounded-2xl bg-slate-50 border border-slate-200 cursor-pointer">
                            <input type="checkbox" name="is_furnished" value="1" {{ request('is_furnished') ? 'checked' : '' }} class="h-4 w-4 rounded text-emerald-600 focus:ring-emerald-500 border-slate-300">
                            <div>
                                <span class="block text-xs font-black text-slate-900">Furnished / Semi-Furnished</span>
                                <span class="block text-[11px] text-slate-500 font-medium">Includes beds, wardrobes, and appliances</span>
                            </div>
                        </label>
                    </div>

                    <div class="pt-4 flex items-center gap-3">
                        <a href="/#listings" class="flex-1 py-3 text-center rounded-2xl border border-slate-200 bg-slate-50 hover:bg-slate-100 text-slate-700 font-bold text-xs">
                            Reset
                        </a>
                        <button type="submit" class="flex-2 py-3 rounded-2xl bg-brandNavy hover:bg-slate-900 text-white font-extrabold text-xs shadow-sm cursor-pointer">
                            Apply Filters
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- ==========================================
         SECTION 13: FOOTER
         ========================================== -->
    <footer class="w-full bg-white border-t border-slate-200">
        <div class="max-w-[1440px] mx-auto px-6 sm:px-8 pt-12 pb-8">
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-8 mb-12">
                <div>
                    <div class="flex items-center gap-3 mb-4">
                        <img alt="HomiQ Brand Logo" class="h-8 w-auto object-contain" src="{{ asset('logo.png') }}">
                    </div>
                    <p class="text-xs text-slate-600 max-w-xs mb-5 leading-relaxed font-medium">
                        Verified residential marketplace designed for home seekers and property owners. 0% brokerage, clear pricing.
                    </p>
                    <div class="flex flex-col gap-2">
                        <span class="text-[10px] uppercase tracking-wider text-slate-500 font-bold">Experience Mobile</span>
                        <div class="flex flex-wrap items-center gap-2">
                            <a href="https://apps.apple.com/in/app/homiq-real-estate-marketplace/id6779412636" target="_blank" class="h-10 px-3.5 rounded-xl bg-black hover:bg-slate-900 text-white flex items-center gap-2 transition-all shadow-xs font-bold active:scale-95 border border-slate-800">
                                <svg class="w-4 h-4 fill-current text-white shrink-0" viewBox="0 0 170 170"><path d="M150.37 130.25c-2.45 5.66-5.35 10.87-8.71 15.66-4.58 6.53-8.33 11.05-11.22 13.56-4.48 4.12-9.28 6.23-14.42 6.35-3.69 0-8.14-1.05-13.32-3.18-5.19-2.12-9.97-3.17-14.34-3.17-4.58 0-9.49 1.05-14.75 3.17-5.26 2.13-9.5 3.24-12.74 3.35-4.35.13-9.16-1.9-14.42-6.08-3.7-3.04-7.7-7.8-12.01-14.28-5.44-8.15-9.76-17.65-12.96-28.48-3.2-10.84-4.8-21.2-4.8-31.1 0-14.82 3.73-26.65 11.2-35.48 7.46-8.84 16.73-13.35 27.81-13.55 4.8 0 10.14 1.25 16.03 3.75 5.88 2.5 9.73 3.8 11.54 3.9 1.48 0 5.63-1.42 12.44-4.24 6.81-2.83 12.77-4.08 17.87-3.76 13.74.8 24.32 5.92 31.75 15.36-12.07 7.34-18.01 17.51-17.81 30.5.21 10.16 4.17 18.66 11.89 25.48 3.51 3.15 7.44 5.48 11.78 7 1.06 3.71 2.05 7.43 2.97 11.16zm-38.31-105.12c0 3.83-1.07 7.79-3.21 11.89-2.14 4.09-5.11 7.46-8.91 10.11-3.6 2.47-7.42 4.04-11.45 4.7-1.1-.96-1.74-2.58-1.92-4.85-.23-2.92.42-6.1 1.95-9.54 1.53-3.44 3.76-6.49 6.69-9.14 3.15-2.84 6.74-4.83 10.77-5.97 4.03-1.14 7.28-1.54 9.76-1.2.22 1.34.32 2.67.32 4z"/></svg>
                                <span class="text-xs font-bold text-white">App Store</span>
                            </a>
                            <a href="https://play.google.com/store/apps/details?id=com.homiq.acrocoder&hl=en" target="_blank" class="h-10 px-3.5 rounded-xl bg-black hover:bg-slate-900 text-white flex items-center gap-2 transition-all shadow-xs font-bold active:scale-95 border border-slate-800">
                                <svg class="w-4 h-4 shrink-0" viewBox="0 0 512 512">
                                    <path fill="#4285F4" d="M47.7 28.5C43.3 33.2 40.7 39.9 40.7 47.5V464.5c0 7.6 2.6 14.3 7 19L273.1 258 47.7 28.5z"/>
                                    <path fill="#34A853" d="M346.5 184.5L273.1 258 47.7 28.5c4-4.3 9.9-7.2 16.5-7.2 4.1 0 7.9 1.1 11.4 3L346.5 184.5z"/>
                                    <path fill="#EA4335" d="M47.7 483.5c4 4.3 9.9 7.2 16.5 7.2 4.1 0 7.9-1.1 11.4-3l270.9-156.2L273.1 258 47.7 483.5z"/>
                                    <path fill="#FBBC05" d="M464.3 243.6L346.5 175.7 273.1 258l73.4 82.3 117.8-67.9c13.7-7.9 13.7-20.8 0-28.8z"/>
                                </svg>
                                <span class="text-xs font-bold text-white">Google Play</span>
                            </a>
                        </div>
                    </div>
                </div>

                <div>
                    <h4 class="text-xs font-black uppercase tracking-wider text-slate-900 mb-4">Discover Categories</h4>
                    <ul class="flex flex-col gap-2.5 text-xs font-semibold text-slate-600">
                        <li><a href="/category/Apartment" class="hover:text-brandNavy transition-colors">Modern Apartments</a></li>
                        <li><a href="/category/Studio" class="hover:text-brandNavy transition-colors">PGs, Rooms &amp; Studios</a></li>
                        <li><a href="/category/Villa" class="hover:text-brandNavy transition-colors">Luxury Villas &amp; Houses</a></li>
                        <li><a href="/explore/commercial" class="hover:text-brandNavy transition-colors">Commercial &amp; Retail Shops</a></li>
                        <li><a href="/pricing" class="hover:text-brandNavy transition-colors">Pricing &amp; Subscriptions</a></li>
                    </ul>
                </div>

                <div>
                    <h4 class="text-xs font-black uppercase tracking-wider text-slate-900 mb-4">Popular Hubs</h4>
                    <ul class="flex flex-col gap-2.5 text-xs font-semibold text-slate-600">
                        <li><a href="/rent/noida" class="hover:text-brandNavy transition-colors">Flats in Noida</a></li>
                        <li><a href="/explore/student_pg" class="hover:text-brandNavy transition-colors">Knowledge Park Student PGs</a></li>
                        <li><a href="/rent/gurugram" class="hover:text-brandNavy transition-colors">Gurugram Tech Corridor</a></li>
                        <li><a href="/rent/bangalore" class="hover:text-brandNavy transition-colors">Bangalore HSR Layout</a></li>
                        <li><a href="/rent/pune" class="hover:text-brandNavy transition-colors">Pune Viman Nagar</a></li>
                    </ul>
                </div>

                <div>
                    <h4 class="text-xs font-black uppercase tracking-wider text-slate-900 mb-4">Trust, Safety &amp; Legal</h4>
                    <ul class="flex flex-col gap-2.5 text-xs font-semibold text-slate-600">
                        <li><a href="/about" class="hover:text-brandNavy transition-colors">About HomiQ</a></li>
                        <li><a href="/verification-standards" class="hover:text-brandNavy transition-colors">Verification Standards</a></li>
                        <li><a href="/safety" class="hover:text-brandNavy transition-colors">Safety Center &amp; Fraud Guide</a></li>
                        <li><a href="/contact" class="hover:text-brandNavy transition-colors">Contact Support</a></li>
                        <li><a href="/terms" class="hover:text-brandNavy transition-colors">Terms of Service</a></li>
                        <li><a href="/privacy" class="hover:text-brandNavy transition-colors">Privacy Policy</a></li>
                    </ul>
                </div>
            </div>

            <div class="border-t border-slate-100 pt-8 flex flex-col md:flex-row items-center justify-between gap-4 text-xs font-semibold text-slate-500">
                <p>&copy; 2026 HomiQ Space Rentals Pvt. Ltd. All rights reserved.</p>
                <div class="flex items-center gap-6">
                    <a href="/privacy" class="hover:text-slate-800">Privacy</a>
                    <a href="/terms" class="hover:text-slate-800">Terms</a>
                    <a href="/safety" class="hover:text-slate-800">Safety</a>
                    <a href="/sitemap.xml" class="hover:text-slate-800">Sitemap</a>
                </div>
            </div>
        </div>
    </footer>

    <!-- Interactive Client Scripts -->
    <script>
        function copyToClipboard(text) {
            navigator.clipboard.writeText(text).then(() => {
                const alpineEl = document.querySelector('[x-data]');
                if (alpineEl && alpineEl._x_dataStack) {
                    alpineEl._x_dataStack[0].showToast('Link copied to clipboard!');
                }
            });
        }

        function shareProperty(title, address, price, url) {
            const text = title + ' (' + price + ')\n' + address + '\nVerified 0% Brokerage on HomiQ\n' + url;
            if (navigator.share) {
                navigator.share({
                    title: title + ' | HomiQ',
                    text: text,
                    url: url
                }).catch(() => {});
            } else {
                const alpineEl = document.querySelector('[x-data]');
                if (alpineEl && alpineEl._x_dataStack) {
                    alpineEl._x_dataStack[0].shareData = { title, address, price, url };
                    alpineEl._x_dataStack[0].shareModalOpen = true;
                }
            }
        }

        function shareCurrentSearch() {
            const currentUrl = window.location.href;
            const searchVal = document.getElementById('search-input')?.value || 'Properties';
            const text = 'Verified ' + searchVal + ' with 0% Brokerage on HomiQ:\n' + currentUrl;
            
            if (navigator.share) {
                navigator.share({
                    title: 'Search results on HomiQ',
                    text: text,
                    url: currentUrl
                }).catch(() => {});
            } else {
                copyToClipboard(currentUrl);
            }
        }

        async function submitSaveSearch(event) {
            event.preventDefault();
            const form = event.target;
            const alpineEl = document.querySelector('[x-data]');
            if (!alpineEl || !alpineEl._x_dataStack) return;
            const stack = alpineEl._x_dataStack[0];

            stack.saveSearchSubmitting = true;
            const formData = new FormData(form);

            try {
                const response = await fetch('{{ route('saved-searches.store') }}', {
                    method: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': '{{ csrf_token() }}',
                        'Accept': 'application/json'
                    },
                    body: formData
                });

                const data = await response.json();
                if (response.ok && data.success) {
                    stack.saveSearchSuccess = true;
                    stack.saveSearchMsg = data.message;
                    stack.showToast('Search alert saved successfully!');
                } else if (data.auth_required) {
                    stack.showToast('Please log in to save searches and receive alerts.');
                    setTimeout(() => {
                        window.location.href = '/login';
                    }, 1200);
                } else {
                    alert(data.message || 'Could not save search alert.');
                }
            } catch (err) {
                console.error(err);
                alert('Something went wrong. Please try again.');
            } finally {
                stack.saveSearchSubmitting = false;
            }
        }

        async function submitPropertyRequest(event) {
            event.preventDefault();
            const form = event.target;
            const btn = document.getElementById('submit-request-btn');
            const originalText = btn.innerHTML;
            btn.disabled = true;
            btn.innerHTML = '<span class="material-symbols-outlined text-[18px] animate-spin">sync</span><span>Submitting...</span>';

            const formData = new FormData(form);

            try {
                const response = await fetch('/property-requests', {
                    method: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': '{{ csrf_token() }}',
                        'Accept': 'application/json'
                    },
                    body: formData
                });

                const data = await response.json();
                if (data.success) {
                    if (typeof window.homiqTrack === 'function') {
                        window.homiqTrack('demand_request_created', {
                            title: form.title?.value || '',
                            locality: form.locality?.value || '',
                            budget: form.max_budget?.value || ''
                        }, 'seeker', 'inquiry');
                    }
                    const alpineEl = document.querySelector('[x-data]');
                    if (alpineEl && alpineEl._x_dataStack) {
                        alpineEl._x_dataStack[0].requestModalOpen = false;
                        alpineEl._x_dataStack[0].showToast('Property Request posted successfully!');
                    }
                    form.reset();
                    setTimeout(() => {
                        window.location.reload();
                    }, 1200);
                } else {
                    alert('Could not submit request. Please verify fields.');
                }
            } catch (err) {
                console.error(err);
                alert('Something went wrong. Please try again.');
            } finally {
                btn.disabled = false;
                btn.innerHTML = originalText;
            }
        }

        // Track Homepage View on load
        document.addEventListener('DOMContentLoaded', () => {
            if (typeof window.homiqTrack === 'function') {
                window.homiqTrack('homepage_view', {
                    url: window.location.href,
                    city: 'All'
                }, 'seeker', 'visitor');
            }
        });
    </script>

    <!-- Mobile Sticky Search & Filter Floating Bar -->
    <div class="md:hidden fixed bottom-4 left-4 right-4 z-40 bg-brandNavy/95 backdrop-blur-xl text-white py-3 px-5 rounded-2xl shadow-2xl border border-white/15 flex items-center justify-between gap-3">
        <a href="#hero-search" class="flex items-center gap-1.5 text-xs font-bold text-slate-200 hover:text-white transition">
            <span class="material-symbols-outlined text-base text-emerald-400">search</span>
            <span>Search</span>
        </a>
        <div class="h-4 w-px bg-white/20"></div>
        <button type="button" @click="filtersModalOpen = true" class="flex items-center gap-1.5 text-xs font-bold text-slate-200 hover:text-white transition cursor-pointer">
            <span class="material-symbols-outlined text-base text-emerald-400">tune</span>
            <span>Filters</span>
        </button>
        <div class="h-4 w-px bg-white/20"></div>
        <button type="button" @click="viewMode = viewMode === 'list' ? 'map' : 'list'" class="flex items-center gap-1.5 text-xs font-bold text-slate-200 hover:text-white transition cursor-pointer">
            <span class="material-symbols-outlined text-base text-emerald-400" x-text="viewMode === 'list' ? 'map' : 'view_agenda'"></span>
            <span x-text="viewMode === 'list' ? 'Map' : 'List'"></span>
        </button>
    </div>
</body>
</html>
