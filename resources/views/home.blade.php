<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta content="width=device-width, initial-scale=1.0" name="viewport">
    
    <!-- Primary SEO Meta Tags -->
    <title>HomiQ - Real Estate Marketplace | Verified Flats, Rooms &amp; PGs Direct from Owners</title>
    <meta name="title" content="HomiQ - Real Estate Marketplace | Verified Flats, Rooms &amp; PGs Direct from Owners">
    <meta name="description" content="Discover verified rental homes, flats, rooms, PGs and properties with 0% brokerage and direct owner contact on HomiQ. 100% on-site audited listings.">
    <meta name="keywords" content="flats for rent, no brokerage homes, PGs near me, verified rentals, apartments for sale, 2 BHK in Noida, rooms for rent, direct owner properties">
    <meta name="robots" content="index, follow">
    <link rel="canonical" href="{{ url()->current() }}">
    <link rel="icon" type="image/png" href="{{ asset('logo.png') }}">

    <!-- Open Graph / Facebook -->
    <meta property="og:type" content="website">
    <meta property="og:url" content="{{ url()->current() }}">
    <meta property="og:title" content="HomiQ - Find Your Next Home Direct from Owners">
    <meta property="og:description" content="Search flats, rooms, PGs and properties with 0% brokerage and direct landlord chat.">
    <meta property="og:image" content="{{ asset('logo.png') }}">

    <!-- Twitter / X -->
    <meta property="twitter:card" content="summary_large_image">
    <meta property="twitter:url" content="{{ url()->current() }}">
    <meta property="twitter:title" content="HomiQ - 0% Brokerage Verified Property Marketplace">
    <meta property="twitter:description" content="Search flats, rooms, PGs and properties with 0% brokerage and direct landlord chat.">
    <meta property="twitter:image" content="{{ asset('logo.png') }}">

    <!-- Google Structured Data (JSON-LD) for Search Action & RealEstateAgent -->
    <script type="application/ld+json">
    {
      "@@context": "https://schema.org",
      "@@type": "RealEstateAgent",
      "name": "HomiQ",
      "url": "{{ url('/') }}",
      "logo": "{{ asset('logo.png') }}",
      "description": "Verified residential real estate marketplace with 0% brokerage and direct landlord chat.",
      "potentialAction": {
        "@@type": "SearchAction",
        "target": "{{ url('/') }}/?search={search_term_string}",
        "query-input": "required name=search_term_string"
      }
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
</head>
<body class="bg-white font-body text-slate-900 antialiased" x-data="{ 
    requestModalOpen: false, 
    shareModalOpen: false,
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

    <!-- Header Navigation -->
    <header class="fixed top-0 left-0 right-0 z-40 bg-white border-b border-slate-200">
        <div class="h-20 max-w-[1440px] mx-auto px-6 sm:px-8 flex items-center justify-between gap-6">
            <div class="flex items-center gap-10">
                <a class="flex items-center gap-3 focus:outline-none" href="/">
                    <img alt="HomiQ Brand Logo" class="h-9 w-auto object-contain" src="{{ asset('logo.png') }}">
                </a>
                <nav class="hidden lg:flex items-center gap-8">
                    <a class="text-sm font-bold text-slate-700 hover:text-brandNavy transition-colors" href="#listings">Verified Homes</a>
                    <a class="text-sm font-bold text-slate-700 hover:text-brandNavy transition-colors" href="#demand-board">Demand Board</a>
                    <a class="text-sm font-bold text-slate-700 hover:text-brandNavy transition-colors" href="#why-homiq">Why HomiQ</a>
                    <a class="text-sm font-bold text-slate-700 hover:text-brandNavy transition-colors" href="/pricing">Pricing</a>
                </nav>
            </div>
            <div class="flex items-center gap-3">
                <!-- Request Property Button -->
                <button type="button" @click="requestModalOpen = true" class="hidden sm:inline-flex items-center justify-center gap-1.5 h-11 px-5 rounded-full bg-emerald-50 hover:bg-emerald-100 text-emerald-800 font-bold text-xs border border-emerald-300 transition-colors cursor-pointer">
                    <span class="material-symbols-outlined text-[17px] text-emerald-700">post_add</span>
                    <span>Post Request</span>
                </button>

                <!-- List Property Free -->
                <a class="hidden sm:inline-flex items-center justify-center h-11 px-6 rounded-full bg-brandNavy text-white font-bold text-xs hover:bg-slate-900 transition-all shadow-sm" href="{{ route('host.add-property') }}">
                    List Property Free
                </a>

                <!-- App Dropdown -->
                <div x-data="{ open: false }" class="relative inline-block text-left" @click.outside="open = false">
                    <button @click="open = !open" type="button" class="h-11 px-4.5 rounded-full border border-slate-300 hover:bg-slate-100 text-slate-800 font-bold text-xs flex items-center gap-1.5 transition-colors cursor-pointer">
                        <span class="material-symbols-outlined text-[18px] text-emerald-600">phone_iphone</span>
                        <span>Get App</span>
                        <span class="material-symbols-outlined text-xs">expand_more</span>
                    </button>
                    <div x-show="open" 
                         x-cloak
                         x-transition:enter="transition ease-out duration-150" 
                         x-transition:enter-start="opacity-0 scale-95" 
                         x-transition:enter-end="opacity-100 scale-100" 
                         class="absolute right-0 mt-2 w-56 bg-white rounded-2xl shadow-xl border border-slate-200 p-2 z-50">
                        <a href="https://apps.apple.com/in/app/homiq-real-estate-marketplace/id6779412636" target="_blank" class="flex items-center gap-2.5 px-3 py-2.5 rounded-xl hover:bg-slate-50 transition text-slate-900 text-xs font-bold">
                            <svg class="w-4 h-4 fill-current text-slate-900 shrink-0" viewBox="0 0 24 24"><path d="M18.71 19.5c-.83 1.24-1.71 2.45-3.05 2.47-1.34.03-1.77-.79-3.29-.79-1.53 0-2 .77-3.27.82-1.31.05-2.3-1.32-3.14-2.53C4.25 17 2.94 12.45 4.7 9.39c.87-1.52 2.43-2.48 4.12-2.51 1.28-.02 2.5.87 3.29.87.78 0 2.26-1.07 3.81-.91.65.03 2.47.26 3.64 1.98-.09.06-2.17 1.28-2.15 3.81.03 3.02 2.65 4.03 2.68 4.04-.03.07-.42 1.44-1.38 2.83M15.97 6.37c.62-.75 1.04-1.8 0.93-2.85-.9.04-1.99.6-2.63 1.35-.57.66-.99 1.73-.86 2.76 1.01.08 2.04-.51 2.56-1.26z"/></svg>
                            <div>
                                <span class="block leading-tight font-black">iOS App Store</span>
                                <span class="text-[10px] text-slate-500 font-semibold">For iPhone &amp; iPad</span>
                            </div>
                        </a>
                        <a href="https://play.google.com/store/apps/details?id=com.homiq.acrocoder&hl=en" target="_blank" class="flex items-center gap-2.5 px-3 py-2.5 rounded-xl hover:bg-slate-50 transition text-slate-900 text-xs font-bold">
                            <span class="material-symbols-outlined text-[18px] text-emerald-600 shrink-0">android</span>
                            <div>
                                <span class="block leading-tight font-black">Google Play</span>
                                <span class="text-[10px] text-slate-500 font-semibold">For Android Devices</span>
                            </div>
                        </a>
                    </div>
                </div>

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
                <a href="/register" class="inline-flex items-center justify-center h-11 px-5 rounded-full bg-emerald-600 text-white font-bold text-xs hover:bg-emerald-700 transition-all shadow-sm">Get Started</a>
                @endauth
            </div>
        </div>
    </header>

    <main class="w-full pt-20 bg-white">
        <div class="flex flex-col w-full">

            <!-- ==========================================
                 ABOVE THE FOLD: HERO & CLEAN UNIFIED SEARCH BAR
                 ========================================== -->
            <section class="w-full bg-slate-50 border-b border-slate-200 py-16 sm:py-20">
                <div class="max-w-5xl mx-auto px-6 sm:px-8 text-center">
                    
                    <!-- Trust Pill -->
                    <div class="inline-flex items-center gap-2.5 px-4 py-1.5 rounded-full bg-white shadow-xs border border-slate-200 mb-6">
                        <span class="w-2 h-2 rounded-full bg-emerald-500 animate-pulse"></span>
                        <span class="text-xs font-bold text-slate-800">100% On-Site Verified</span>
                        <span class="text-slate-300">•</span>
                        <span class="text-xs font-bold text-emerald-700">0% Brokerage</span>
                        <span class="text-slate-300">•</span>
                        <span class="text-xs font-bold text-slate-700">Direct Owner Contact</span>
                    </div>

                    <!-- Main Headline & Subtitle -->
                    <h1 class="text-4xl sm:text-5xl lg:text-6xl font-black text-slate-900 tracking-tight leading-tight mb-4">
                        Find Your Next Home
                    </h1>
                    <p class="text-lg sm:text-xl font-semibold text-slate-600 max-w-2xl mx-auto mb-10">
                        Search flats, rooms, PGs and properties directly from owners.
                    </p>

                    <!-- Clean Search Container -->
                    <div class="w-full max-w-4xl mx-auto text-left">
                        
                        <!-- Top Purpose Tabs (Rent / Buy / PG / Commercial) -->
                        <div class="flex items-center justify-center gap-1.5 sm:gap-2 mb-3.5">
                            <button type="button" onclick="setListingPurpose('rent', this)" class="purpose-tab h-11 px-6 rounded-full text-xs font-bold transition-all cursor-pointer flex items-center justify-center {{ (request('listing_type', 'rent') === 'rent' && request('search_type') !== 'Studio' && request('search_type') !== 'Shop') ? 'bg-brandNavy text-white shadow-sm' : 'bg-white text-slate-700 border border-slate-200 hover:bg-slate-100' }}">
                                Rent
                            </button>
                            <button type="button" onclick="setListingPurpose('sale', this)" class="purpose-tab h-11 px-6 rounded-full text-xs font-bold transition-all cursor-pointer flex items-center justify-center {{ request('listing_type') === 'sale' ? 'bg-brandNavy text-white shadow-sm' : 'bg-white text-slate-700 border border-slate-200 hover:bg-slate-100' }}">
                                Buy
                            </button>
                            <button type="button" onclick="setListingPurpose('pg', this)" class="purpose-tab h-11 px-6 rounded-full text-xs font-bold transition-all cursor-pointer flex items-center justify-center {{ request('search_type') === 'Studio' ? 'bg-brandNavy text-white shadow-sm' : 'bg-white text-slate-700 border border-slate-200 hover:bg-slate-100' }}">
                                PG / Co-living
                            </button>
                            <button type="button" onclick="setListingPurpose('commercial', this)" class="purpose-tab h-11 px-6 rounded-full text-xs font-bold transition-all cursor-pointer flex items-center justify-center {{ request('search_type') === 'Shop' ? 'bg-brandNavy text-white shadow-sm' : 'bg-white text-slate-700 border border-slate-200 hover:bg-slate-100' }}">
                                Commercial
                            </button>
                        </div>

                        <!-- Modern Unified Search Bar -->
                        <form action="/#listings" method="GET" id="search-form" class="bg-white rounded-3xl md:rounded-full border border-slate-300 shadow-md hover:shadow-lg transition-all p-1.5 sm:p-2 flex flex-col md:flex-row items-stretch md:items-center">
                            <input type="hidden" name="listing_type" id="listing-type-hidden" value="{{ request('listing_type', 'rent') }}">
                            <input type="hidden" name="search_type" id="search-type-hidden" value="{{ request('search_type', '') }}">

                            <!-- 1. Location Input -->
                            <div class="flex-1 px-4 py-3 md:py-2.5 rounded-2xl md:rounded-l-full hover:bg-slate-50 focus-within:bg-slate-50 transition-colors">
                                <label for="search-input" class="block text-[11px] font-extrabold uppercase tracking-wider text-slate-500 mb-0.5">Location</label>
                                <div class="flex items-center gap-2">
                                    <span class="material-symbols-outlined text-emerald-600 text-[20px] shrink-0">location_on</span>
                                    <input id="search-input" name="search" type="text" class="w-full bg-transparent text-sm font-bold text-slate-900 border-0 focus:border-0 focus:ring-0 outline-none focus:outline-none p-0 placeholder-slate-400" placeholder="e.g. Sector 137, HSR Layout, Mumbai..." value="{{ request('search', '') }}">
                                </div>
                            </div>

                            <!-- 2. Property Type Dropdown -->
                            <div class="flex-1 px-4 py-3 md:py-2.5 rounded-2xl hover:bg-slate-50 focus-within:bg-slate-50 transition-colors border-t md:border-t-0 md:border-l border-slate-200">
                                <label for="type-select" class="block text-[11px] font-extrabold uppercase tracking-wider text-slate-500 mb-0.5">Property Type</label>
                                <div class="flex items-center gap-2">
                                    <span class="material-symbols-outlined text-slate-500 text-[20px] shrink-0">apartment</span>
                                    <select id="type-select" onchange="document.getElementById('search-type-hidden').value = this.value" class="w-full bg-transparent text-sm font-bold text-slate-900 border-0 focus:border-0 focus:ring-0 outline-none focus:outline-none p-0 cursor-pointer">
                                        <option value="">All Types</option>
                                        <option value="Apartment" {{ request('search_type') === 'Apartment' ? 'selected' : '' }}>Flats &amp; Apartments</option>
                                        <option value="Villa" {{ request('search_type') === 'Villa' ? 'selected' : '' }}>Villas &amp; Houses</option>
                                        <option value="Studio" {{ request('search_type') === 'Studio' ? 'selected' : '' }}>PGs &amp; Rooms</option>
                                        <option value="Shop" {{ request('search_type') === 'Shop' ? 'selected' : '' }}>Commercial / Shop</option>
                                    </select>
                                </div>
                            </div>

                            <!-- 3. Bedrooms / BHK Dropdown -->
                            <div class="w-full md:w-36 px-4 py-3 md:py-2.5 rounded-2xl hover:bg-slate-50 focus-within:bg-slate-50 transition-colors border-t md:border-t-0 md:border-l border-slate-200">
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
                            <div class="w-full md:w-44 px-4 py-3 md:py-2.5 rounded-2xl hover:bg-slate-50 focus-within:bg-slate-50 transition-colors border-t md:border-t-0 md:border-l border-slate-200">
                                <label for="budget-select" class="block text-[11px] font-extrabold uppercase tracking-wider text-slate-500 mb-0.5">Budget</label>
                                <div class="flex items-center gap-1.5">
                                    <span class="material-symbols-outlined text-slate-500 text-[20px] shrink-0">payments</span>
                                    <select id="budget-select" name="max_price" class="w-full bg-transparent text-sm font-bold text-slate-900 border-0 focus:border-0 focus:ring-0 outline-none focus:outline-none p-0 cursor-pointer">
                                        <option value="">Any Budget</option>
                                        <option value="15000" {{ request('max_price') == '15000' ? 'selected' : '' }}>Under ₹15,000</option>
                                        <option value="25000" {{ request('max_price') == '25000' ? 'selected' : '' }}>Under ₹25,000</option>
                                        <option value="40000" {{ request('max_price') == '40000' ? 'selected' : '' }}>Under ₹40,000</option>
                                        <option value="60000" {{ request('max_price') == '60000' ? 'selected' : '' }}>Under ₹60,000</option>
                                        <option value="100000" {{ request('max_price') == '100000' ? 'selected' : '' }}>Under ₹1,00,000</option>
                                    </select>
                                </div>
                            </div>

                            <!-- 5. Search Button -->
                            <div class="p-1.5 flex justify-center">
                                <button type="submit" class="w-full md:w-auto h-11 px-6 rounded-full bg-brandNavy hover:bg-slate-900 text-white font-bold text-sm flex items-center justify-center gap-2 shadow-sm transition-all active:scale-95 cursor-pointer">
                                    <span class="material-symbols-outlined text-[18px] text-emerald-400">search</span>
                                    <span>Search</span>
                                </button>
                            </div>
                        </form>

                        <!-- Clean Trending Keywords Line -->
                        <div class="flex items-center justify-center flex-wrap gap-2 mt-4 text-xs font-semibold text-slate-600">
                            <span class="text-slate-400 font-bold uppercase text-[10px]">Trending:</span>
                            @foreach($popularCities as $city)
                            <a href="/?search={{ urlencode($city) }}#listings" class="hover:text-emerald-700 underline decoration-slate-300 hover:decoration-emerald-500">{{ $city }}</a>
                            <span class="text-slate-300">•</span>
                            @endforeach
                            <a href="/?search_type=Studio#listings" class="hover:text-emerald-700 underline decoration-slate-300 hover:decoration-emerald-500">Student PGs</a>
                            <span class="text-slate-300">•</span>
                            <a href="/?bedrooms=2#listings" class="hover:text-emerald-700 underline decoration-slate-300 hover:decoration-emerald-500">2 BHK Flats</a>
                        </div>
                    </div>
                </div>
            </section>

            <!-- ==========================================
                 SECTION 2: EXPLORE PROPERTIES NEAR YOU
                 ========================================== -->
            <section class="max-w-[1440px] mx-auto px-6 sm:px-8 py-14 w-full" id="listings">
                <!-- Section Header -->
                <div class="flex flex-col md:flex-row md:items-end justify-between gap-6 mb-8">
                    <div>
                        <div class="inline-flex items-center gap-1.5 text-emerald-700 font-black text-xs uppercase tracking-wider mb-2">
                            <span class="material-symbols-outlined text-[16px]">travel_explore</span>
                            Active Verified Inventory
                        </div>
                        <h2 class="text-2xl sm:text-3xl lg:text-4xl font-black text-slate-900 tracking-tight flex flex-wrap items-baseline gap-x-3 gap-y-1">
                            <span>Explore Properties Near You</span>
                            <span class="text-base sm:text-lg font-bold text-slate-500 whitespace-nowrap">({{ $properties->count() }} available)</span>
                        </h2>
                        <p class="text-sm font-semibold text-slate-600 mt-1">100% on-site audited residences with zero brokerage and direct owner contact.</p>
                    </div>

                    <!-- Category Filter Pills & Share Search Button -->
                    <div class="flex items-center gap-2.5 flex-wrap">
                        <button type="button" onclick="shareCurrentSearch()" class="inline-flex items-center gap-1.5 h-11 px-5 rounded-full bg-white hover:bg-slate-100 text-slate-800 text-xs font-bold border border-slate-300 transition-all shadow-xs cursor-pointer" title="Share this search on WhatsApp or Copy Link">
                            <span class="material-symbols-outlined text-[17px] text-emerald-600">share</span>
                            <span>Share Search</span>
                        </button>

                        <a href="/?search_type=all#listings" class="inline-flex items-center justify-center h-11 px-5 rounded-full {{ request('search_type', 'all') === 'all' ? 'bg-brandNavy text-white shadow-sm font-bold' : 'bg-white text-slate-800 border border-slate-300 hover:bg-slate-100 font-bold' }} text-xs transition-all">
                            All ({{ $properties->count() }})
                        </a>
                        @foreach($categories as $cat)
                        <a href="/?search_type={{ urlencode($cat['name']) }}#listings" class="inline-flex items-center justify-center h-11 px-5 rounded-full {{ request('search_type') === $cat['name'] ? 'bg-brandNavy text-white shadow-sm font-bold' : 'bg-white text-slate-800 border border-slate-300 hover:bg-slate-100 font-bold' }} text-xs transition-all">
                            {{ $cat['name'] }}
                        </a>
                        @endforeach
                    </div>
                </div>

                <!-- Active Filter Removal Bar -->
                @if(request()->hasAny(['search', 'search_type', 'bedrooms', 'max_price', 'listing_type']) && (request('search') || (request('search_type') && request('search_type') !== 'all') || (request('bedrooms') && request('bedrooms') !== 'all') || request('max_price') || (request('listing_type') && request('listing_type') !== 'rent')))
                <div class="mb-8 p-4 rounded-2xl bg-slate-50 border border-slate-200 flex flex-wrap items-center justify-between gap-3">
                    <div class="flex items-center gap-2 flex-wrap">
                        <span class="text-xs uppercase font-bold text-slate-600 mr-1 flex items-center gap-1">
                            <span class="material-symbols-outlined text-[16px] text-emerald-600">tune</span>
                            Active Filters:
                        </span>
                        @if(request('search'))
                        <a href="{{ request()->fullUrlWithQuery(['search' => null]) }}#listings" class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full bg-white text-slate-900 text-xs font-bold hover:bg-rose-50 hover:text-rose-600 border border-slate-200 transition-colors group">
                            <span>Location: {{ request('search') }}</span>
                            <span class="material-symbols-outlined text-[14px] text-slate-400 group-hover:text-rose-600">close</span>
                        </a>
                        @endif
                        @if(request('search_type') && request('search_type') !== 'all')
                        <a href="{{ request()->fullUrlWithQuery(['search_type' => null]) }}#listings" class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full bg-white text-slate-900 text-xs font-bold hover:bg-rose-50 hover:text-rose-600 border border-slate-200 transition-colors group">
                            <span>Type: {{ request('search_type') }}</span>
                            <span class="material-symbols-outlined text-[14px] text-slate-400 group-hover:text-rose-600">close</span>
                        </a>
                        @endif
                        @if(request('bedrooms') && request('bedrooms') !== 'all')
                        <a href="{{ request()->fullUrlWithQuery(['bedrooms' => null]) }}#listings" class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full bg-white text-slate-900 text-xs font-bold hover:bg-rose-50 hover:text-rose-600 border border-slate-200 transition-colors group">
                            <span>Bedrooms: {{ request('bedrooms') >= 3 ? '3+ BHK' : request('bedrooms') . ' BHK' }}</span>
                            <span class="material-symbols-outlined text-[14px] text-slate-400 group-hover:text-rose-600">close</span>
                        </a>
                        @endif
                        @if(request('max_price'))
                        <a href="{{ request()->fullUrlWithQuery(['max_price' => null]) }}#listings" class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full bg-white text-slate-900 text-xs font-bold hover:bg-rose-50 hover:text-rose-600 border border-slate-200 transition-colors group">
                            <span>Max: ₹{{ number_format(request('max_price')) }}</span>
                            <span class="material-symbols-outlined text-[14px] text-slate-400 group-hover:text-rose-600">close</span>
                        </a>
                        @endif
                    </div>
                    <a href="/#listings" class="inline-flex items-center gap-1.5 px-3.5 py-1.5 rounded-full bg-rose-50 text-rose-700 hover:bg-rose-100 text-xs font-bold border border-rose-200 transition-colors shrink-0">
                        <span class="material-symbols-outlined text-[16px]">restart_alt</span>
                        <span>Reset All Filters</span>
                    </a>
                </div>
                @endif

                <!-- Dynamic Property Cards Grid -->
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                    @forelse($properties as $property)
                        <x-property-card :property="$property" />
                    @empty
                    <!-- Empty State & Request Hook -->
                    <div class="col-span-full py-16 px-6 text-center bg-slate-50 rounded-3xl border border-slate-200">
                        <div class="w-16 h-16 rounded-full bg-white flex items-center justify-center mx-auto mb-4 text-slate-400 border border-slate-200">
                            <span class="material-symbols-outlined text-[32px]">search_off</span>
                        </div>
                        <h3 class="text-2xl font-black text-slate-900 tracking-tight">No Matching Properties Found</h3>
                        <p class="text-sm font-semibold text-slate-600 max-w-md mx-auto mt-2 mb-6">
                            We couldn't find an approved property for this exact criteria right now. Post a request on our Demand Board and matching property owners will reach out directly!
                        </p>
                        <div class="flex items-center justify-center gap-3 flex-wrap">
                            <button type="button" @click="requestModalOpen = true" class="inline-flex items-center gap-2 px-6 py-3 rounded-full bg-emerald-600 text-white font-bold text-xs hover:bg-emerald-700 transition-colors shadow-sm cursor-pointer">
                                <span class="material-symbols-outlined text-[18px]">post_add</span>
                                <span>Post a Property Request</span>
                            </button>
                            <a href="/#listings" class="inline-flex items-center gap-2 px-5 py-3 rounded-full bg-white hover:bg-slate-100 text-slate-800 font-bold text-xs border border-slate-300 transition-colors">
                                <span class="material-symbols-outlined text-[18px]">refresh</span>
                                <span>Reset Filters</span>
                            </a>
                        </div>
                    </div>
                    @endforelse
                </div>
            </section>

            <!-- ==========================================
                 SECTION 3: WHY HOMIQ?
                 ========================================== -->
            <section class="w-full bg-slate-50 border-y border-slate-200 py-16" id="why-homiq">
                <div class="max-w-[1440px] mx-auto px-6 sm:px-8">
                    <div class="text-center max-w-2xl mx-auto mb-14">
                        <span class="text-xs uppercase tracking-wider text-emerald-700 font-black">Why HomiQ?</span>
                        <h2 class="text-3xl sm:text-4xl font-black text-slate-900 tracking-tight mt-1">Built for transparent, direct renting</h2>
                        <p class="text-sm font-semibold text-slate-600 mt-2">Eliminate middleman friction and discover authentic residences with confidence.</p>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
                        <!-- Pillar 1 -->
                        <div class="rounded-3xl bg-white p-7 border border-slate-200 shadow-sm flex flex-col justify-between">
                            <div>
                                <div class="w-12 h-12 rounded-2xl bg-emerald-50 text-emerald-700 flex items-center justify-center mb-5 border border-emerald-100">
                                    <span class="material-symbols-outlined text-[24px]">chat</span>
                                </div>
                                <h3 class="text-lg font-black text-slate-900 tracking-tight mb-2">Direct Owner Communication</h3>
                                <p class="text-xs leading-relaxed text-slate-600 font-medium">Message landlords directly through in-app chat. Agree on terms and schedule in-person tours without unwanted spam calls.</p>
                            </div>
                            <div class="mt-6 pt-4 border-t border-slate-100 flex items-center gap-1.5 text-xs font-bold text-emerald-700">
                                <span class="material-symbols-outlined text-[16px]">verified</span>
                                <span>Direct Chat In-App</span>
                            </div>
                        </div>

                        <!-- Pillar 2 -->
                        <div class="rounded-3xl bg-white p-7 border border-slate-200 shadow-sm flex flex-col justify-between">
                            <div>
                                <div class="w-12 h-12 rounded-2xl bg-blue-50 text-blue-700 flex items-center justify-center mb-5 border border-blue-100">
                                    <span class="material-symbols-outlined text-[24px]">fact_check</span>
                                </div>
                                <h3 class="text-lg font-black text-slate-900 tracking-tight mb-2">Verified Listings</h3>
                                <p class="text-xs leading-relaxed text-slate-600 font-medium">Every property undergoes on-site physical auditing, ownership title checks, and government ID validation before being published.</p>
                            </div>
                            <div class="mt-6 pt-4 border-t border-slate-100 flex items-center gap-1.5 text-xs font-bold text-blue-700">
                                <span class="material-symbols-outlined text-[16px]">verified_user</span>
                                <span>100% On-Site Audited</span>
                            </div>
                        </div>

                        <!-- Pillar 3 -->
                        <div class="rounded-3xl bg-white p-7 border border-slate-200 shadow-sm flex flex-col justify-between">
                            <div>
                                <div class="w-12 h-12 rounded-2xl bg-amber-50 text-amber-700 flex items-center justify-center mb-5 border border-amber-100">
                                    <span class="material-symbols-outlined text-[24px]">savings</span>
                                </div>
                                <h3 class="text-lg font-black text-slate-900 tracking-tight mb-2">No Unnecessary Brokerage</h3>
                                <p class="text-xs leading-relaxed text-slate-600 font-medium">Never pay 1 to 2 months' rent in agent commissions. Save ₹15,000 to ₹50,000 on every move with our strict zero brokerage policy.</p>
                            </div>
                            <div class="mt-6 pt-4 border-t border-slate-100 flex items-center gap-1.5 text-xs font-bold text-amber-700">
                                <span class="material-symbols-outlined text-[16px]">currency_rupee</span>
                                <span>₹0 Broker Commission</span>
                            </div>
                        </div>

                        <!-- Pillar 4 -->
                        <div class="rounded-3xl bg-white p-7 border border-slate-200 shadow-sm flex flex-col justify-between">
                            <div>
                                <div class="w-12 h-12 rounded-2xl bg-indigo-50 text-indigo-700 flex items-center justify-center mb-5 border border-indigo-100">
                                    <span class="material-symbols-outlined text-[24px]">travel_explore</span>
                                </div>
                                <h3 class="text-lg font-black text-slate-900 tracking-tight mb-2">Easy Property Discovery</h3>
                                <p class="text-xs leading-relaxed text-slate-600 font-medium">Filter precisely by micro-districts, budget, BHK size, furnishing, and pet-friendliness to find your ideal home in seconds.</p>
                            </div>
                            <div class="mt-6 pt-4 border-t border-slate-100 flex items-center gap-1.5 text-xs font-bold text-indigo-700">
                                <span class="material-symbols-outlined text-[16px]">speed</span>
                                <span>High-Precision Filters</span>
                            </div>
                        </div>
                    </div>
                </div>
            </section>

            <!-- ==========================================
                 SECTION 4: LIST YOUR PROPERTY FREE
                 ========================================== -->
            <section class="max-w-[1440px] mx-auto px-6 sm:px-8 py-12 w-full" id="list-free">
                <div class="rounded-3xl bg-brandNavy text-white p-8 md:p-14 shadow-sm border border-slate-800">
                    <div class="grid grid-cols-1 lg:grid-cols-12 gap-10 items-center">
                        <div class="lg:col-span-7 space-y-6">
                            <div class="inline-flex items-center gap-2 px-3.5 py-1.5 rounded-full bg-emerald-500/20 border border-emerald-500/30 text-emerald-300 text-xs font-bold uppercase tracking-wider">
                                <span class="material-symbols-outlined text-[16px]">add_home</span>
                                For Landlords &amp; Property Owners
                            </div>
                            <h2 class="text-3xl sm:text-5xl font-black text-white tracking-tight leading-tight">
                                List Your Property Free<br>in Under 3 Minutes.
                            </h2>
                            <p class="text-slate-200 text-base leading-relaxed max-w-xl font-medium">
                                Join hundreds of verified owners connecting directly with quality tenants. Enjoy zero listing fees, zero broker commissions, and manage inquiries seamlessly.
                            </p>

                            <!-- Owner Value Grid -->
                            <div class="grid grid-cols-1 sm:grid-cols-3 gap-4 pt-2">
                                <div class="p-4 rounded-2xl bg-white/10 border border-white/15">
                                    <span class="block text-2xl font-black text-emerald-400">1,200+</span>
                                    <span class="text-xs text-slate-200 font-bold mt-0.5 block">Active Tenant Searches</span>
                                </div>
                                <div class="p-4 rounded-2xl bg-white/10 border border-white/15">
                                    <span class="block text-2xl font-black text-white">0%</span>
                                    <span class="text-xs text-slate-200 font-bold mt-0.5 block">Commission Charged</span>
                                </div>
                                <div class="p-4 rounded-2xl bg-white/10 border border-white/15">
                                    <span class="block text-2xl font-black text-amber-300">&lt; 3 Min</span>
                                    <span class="text-xs text-slate-200 font-bold mt-0.5 block">Fast Listing Process</span>
                                </div>
                            </div>

                            <div class="pt-4 flex items-center gap-4 flex-wrap">
                                <a href="{{ route('host.add-property') }}" class="h-14 px-8 rounded-full bg-emerald-600 hover:bg-emerald-700 text-white font-bold text-sm flex items-center gap-2 shadow-sm transition-all active:scale-[0.98]">
                                    <span>List Your Property Free</span>
                                    <span class="material-symbols-outlined text-[18px]">arrow_forward</span>
                                </a>
                                <a href="#demand-board" class="h-14 px-6 rounded-full bg-white/15 hover:bg-white/25 text-white font-bold text-sm flex items-center gap-2 border border-white/20 transition-colors">
                                    <span class="material-symbols-outlined text-[18px]">group</span>
                                    <span>View Tenant Demands</span>
                                </a>
                            </div>
                        </div>

                        <div class="lg:col-span-5">
                            <div class="rounded-3xl bg-white/10 border border-white/20 p-6 space-y-4">
                                <div class="flex items-center justify-between pb-3 border-b border-white/15">
                                    <span class="text-xs font-bold uppercase tracking-wider text-emerald-300">Live Demand Nearby</span>
                                    <span class="px-2.5 py-0.5 rounded-full bg-emerald-500/20 text-emerald-300 text-[11px] font-bold">High Intent</span>
                                </div>

                                <div class="space-y-3">
                                    @foreach($propertyRequests->take(2) as $req)
                                    <div class="p-3.5 rounded-2xl bg-white/10 border border-white/10">
                                        <div class="flex items-center justify-between">
                                            <span class="text-xs font-bold text-white">{{ $req->bedrooms }} in {{ $req->locality ?? $req->city }}</span>
                                            <span class="text-xs font-bold text-emerald-400">{{ $req->formatted_budget }}</span>
                                        </div>
                                        <p class="text-[11px] text-slate-200 mt-1 line-clamp-1 font-medium">{{ $req->description ?? 'Tenant ready to move in' }}</p>
                                    </div>
                                    @endforeach
                                </div>

                                <button type="button" @click="requestModalOpen = true" class="w-full h-11 rounded-xl bg-white text-slate-900 font-bold text-xs hover:bg-slate-100 transition-colors flex items-center justify-center gap-1.5 cursor-pointer shadow-xs">
                                    <span class="material-symbols-outlined text-[17px] text-emerald-600">add_circle</span>
                                    <span>Post a Request (Seekers)</span>
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </section>

            <!-- ==========================================
                 SECTION 5: PROPERTY REQUEST MARKETPLACE
                 ========================================== -->
            <section class="max-w-[1440px] mx-auto px-6 sm:px-8 py-16 w-full" id="demand-board">
                <div class="flex flex-col md:flex-row md:items-end justify-between gap-6 mb-10">
                    <div>
                        <div class="inline-flex items-center gap-1.5 text-emerald-700 font-black text-xs uppercase tracking-wider mb-2">
                            <span class="material-symbols-outlined text-[16px]">campaign</span>
                            Two-Sided Liquidity Board
                        </div>
                        <h2 class="text-3xl sm:text-4xl font-black text-slate-900 tracking-tight">Tenant &amp; Buyer Demand Board</h2>
                        <p class="text-sm font-semibold text-slate-600 mt-1">Can't find what you need? Post what you're looking for, or owners can view active demand and connect.</p>
                    </div>

                    <div class="flex items-center gap-3">
                        <button type="button" @click="requestModalOpen = true" class="h-12 px-6 rounded-full bg-emerald-600 hover:bg-emerald-700 text-white font-bold text-xs flex items-center gap-2 shadow-sm transition-all cursor-pointer">
                            <span class="material-symbols-outlined text-[18px]">post_add</span>
                            <span>Post Your Request</span>
                        </button>
                    </div>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                    @forelse($propertyRequests as $req)
                    <div class="group rounded-3xl bg-white p-6 border border-slate-200 shadow-sm hover:border-emerald-500 transition-all duration-300 flex flex-col justify-between">
                        <div>
                            <div class="flex items-start justify-between gap-2 mb-3">
                                <span class="px-2.5 py-1 rounded-full bg-slate-900 text-white text-[10px] font-extrabold uppercase tracking-wider">
                                    Wanted: {{ $req->bedrooms ?? $req->property_type }}
                                </span>
                                <span class="px-2.5 py-1 rounded-full bg-emerald-50 text-emerald-800 border border-emerald-300 text-[10px] font-bold">
                                    {{ $req->responses_count }} Responses
                                </span>
                            </div>

                            <h3 class="text-lg font-black text-slate-900 group-hover:text-emerald-700 transition-colors">
                                {{ $req->locality ? $req->locality . ', ' . $req->city : $req->city }}
                            </h3>

                            <div class="mt-3 space-y-2 bg-slate-50 p-3.5 rounded-2xl text-xs text-slate-700 border border-slate-200">
                                <div class="flex items-center justify-between">
                                    <span class="text-slate-500 font-bold">Budget:</span>
                                    <span class="font-black text-slate-900">{{ $req->formatted_budget }}</span>
                                </div>
                                <div class="flex items-center justify-between">
                                    <span class="text-slate-500 font-bold">Move-in:</span>
                                    <span class="font-bold text-emerald-700">{{ $req->move_in_date ?? 'Immediate' }}</span>
                                </div>
                                <div class="flex items-center justify-between">
                                    <span class="text-slate-500 font-bold">Posted By:</span>
                                    <span class="font-bold text-slate-900">{{ $req->seeker_name }}</span>
                                </div>
                            </div>

                            @if($req->description)
                            <p class="text-xs text-slate-600 mt-3 line-clamp-2 leading-relaxed font-medium">
                                "{{ $req->description }}"
                            </p>
                            @endif
                        </div>

                        <div class="mt-6 pt-4 border-t border-slate-100 flex items-center justify-between">
                            <a href="{{ route('host.add-property') }}" class="w-full h-12 rounded-2xl bg-brandNavy hover:bg-slate-900 text-white font-bold text-xs text-center transition-all flex items-center justify-center gap-2 shadow-sm active:scale-98">
                                <span class="material-symbols-outlined text-[17px] text-emerald-400">add_home</span>
                                <span>I Have a Matching Home</span>
                            </a>
                        </div>
                    </div>
                    @empty
                    <div class="col-span-full py-10 px-6 text-center bg-white rounded-3xl border border-slate-200">
                        <p class="text-sm font-bold text-slate-700">Be the first to post a property request!</p>
                        <button type="button" @click="requestModalOpen = true" class="mt-3 h-11 px-6 rounded-full bg-emerald-600 text-white text-xs font-bold cursor-pointer inline-flex items-center justify-center">Post Request</button>
                    </div>
                    @endforelse
                </div>
            </section>

            <!-- ==========================================
                 SECTION 6: POPULAR LOCATIONS & LOCAL SEO HUBS
                 ========================================== -->
            <section class="max-w-[1440px] mx-auto px-6 sm:px-8 py-16 w-full" id="popular-locations">
                <div class="flex flex-col md:flex-row md:items-end justify-between gap-4 mb-10">
                    <div>
                        <div class="inline-flex items-center gap-1.5 text-emerald-700 font-black text-xs uppercase tracking-wider mb-2">
                            <span class="material-symbols-outlined text-[16px]">location_city</span>
                            High-Demand Micro-Districts
                        </div>
                        <h2 class="text-3xl sm:text-4xl font-black text-slate-900 tracking-tight">Popular Locations &amp; Hubs</h2>
                        <p class="text-sm font-semibold text-slate-600 mt-1">Browse verified properties across premier student corridors and IT tech parks.</p>
                    </div>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                    <!-- Location 1: Sector 137 Noida -->
                    <div class="group rounded-3xl bg-white p-6 border border-slate-200 shadow-sm hover:border-emerald-500 transition-all duration-300 flex flex-col justify-between">
                        <div>
                            <div class="relative rounded-2xl overflow-hidden aspect-[16/9] mb-4 bg-slate-100">
                                <img alt="Sector 137 Noida" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500" src="https://images.unsplash.com/photo-1545324418-cc1a3fa10c00?auto=format&fit=crop&w=800&q=80">
                                <div class="absolute inset-0 bg-slate-900/40"></div>
                                <div class="absolute bottom-3 left-3 right-3 flex items-center justify-between text-white">
                                    <span class="font-black text-base drop-shadow-md">Sector 137, Noida</span>
                                    <span class="px-2.5 py-0.5 rounded-full bg-slate-900/80 text-[11px] font-bold">2 BHK &amp; PGs</span>
                                </div>
                            </div>
                            <h3 class="text-lg font-black text-slate-900 mb-1">Noida Expressway Corridor</h3>
                            <p class="text-xs text-slate-600 leading-relaxed font-medium">Near metro station, corporate tech hubs, and gated societies.</p>
                        </div>
                        <a href="/?search=Sector 137#listings" class="mt-5 w-full h-12 rounded-2xl bg-slate-100 hover:bg-brandNavy hover:text-white text-slate-900 font-bold text-xs text-center transition-all flex items-center justify-center gap-1.5 active:scale-98">
                            <span>Explore Sector 137</span>
                            <span class="material-symbols-outlined text-[16px]">arrow_forward</span>
                        </a>
                    </div>

                    <!-- Location 2: Bangalore HSR Layout -->
                    <div class="group rounded-3xl bg-white p-6 border border-slate-200 shadow-sm hover:border-emerald-500 transition-all duration-300 flex flex-col justify-between">
                        <div>
                            <div class="relative rounded-2xl overflow-hidden aspect-[16/9] mb-4 bg-slate-100">
                                <img alt="HSR Layout Bangalore" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500" src="https://images.unsplash.com/photo-1512917774080-9991f1c4c750?auto=format&fit=crop&w=800&q=80">
                                <div class="absolute inset-0 bg-slate-900/40"></div>
                                <div class="absolute bottom-3 left-3 right-3 flex items-center justify-between text-white">
                                    <span class="font-black text-base drop-shadow-md">HSR Layout, Bangalore</span>
                                    <span class="px-2.5 py-0.5 rounded-full bg-slate-900/80 text-[11px] font-bold">Startup Hub</span>
                                </div>
                            </div>
                            <h3 class="text-lg font-black text-slate-900 mb-1">Tech &amp; Startup Capital</h3>
                            <p class="text-xs text-slate-600 leading-relaxed font-medium">Premium 1 &amp; 2 BHK flats, co-living spaces with 0% brokerage.</p>
                        </div>
                        <a href="/?search=HSR Layout#listings" class="mt-5 w-full h-12 rounded-2xl bg-slate-100 hover:bg-brandNavy hover:text-white text-slate-900 font-bold text-xs text-center transition-all flex items-center justify-center gap-1.5 active:scale-98">
                            <span>Explore HSR Layout</span>
                            <span class="material-symbols-outlined text-[16px]">arrow_forward</span>
                        </a>
                    </div>

                    <!-- Location 3: Amity University Corridor -->
                    <div class="group rounded-3xl bg-white p-6 border border-slate-200 shadow-sm hover:border-emerald-500 transition-all duration-300 flex flex-col justify-between">
                        <div>
                            <div class="relative rounded-2xl overflow-hidden aspect-[16/9] mb-4 bg-slate-100">
                                <img alt="Amity University Student PGs" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500" src="https://images.unsplash.com/photo-1522708323590-d24dbb6b0267?auto=format&fit=crop&w=800&q=80">
                                <div class="absolute inset-0 bg-slate-900/40"></div>
                                <div class="absolute bottom-3 left-3 right-3 flex items-center justify-between text-white">
                                    <span class="font-black text-base drop-shadow-md">Student PGs &amp; Rooms</span>
                                    <span class="px-2.5 py-0.5 rounded-full bg-slate-900/80 text-[11px] font-bold">Under ₹15,000</span>
                                </div>
                            </div>
                            <h3 class="text-lg font-black text-slate-900 mb-1">University Student Housing</h3>
                            <p class="text-xs text-slate-600 leading-relaxed font-medium">Furnished rooms with WiFi, food, and housekeeping near campuses.</p>
                        </div>
                        <a href="/?search_type=Studio#listings" class="mt-5 w-full h-12 rounded-2xl bg-slate-100 hover:bg-brandNavy hover:text-white text-slate-900 font-bold text-xs text-center transition-all flex items-center justify-center gap-1.5 active:scale-98">
                            <span>Explore Student PGs</span>
                            <span class="material-symbols-outlined text-[16px]">arrow_forward</span>
                        </a>
                    </div>
                </div>
            </section>

            <!-- ==========================================
                 SECTION 7: DOWNLOAD THE APP
                 ========================================== -->
            <section class="max-w-[1440px] mx-auto px-6 sm:px-8 py-16 w-full" id="download-app">
                <div class="rounded-3xl bg-brandNavy text-white p-10 md:p-16 shadow-sm border border-slate-800">
                    <div class="grid grid-cols-1 lg:grid-cols-12 gap-10 items-center">
                        <div class="lg:col-span-7">
                            <span class="inline-flex items-center gap-1.5 px-3.5 py-1.5 rounded-full bg-white/10 text-emerald-400 text-xs font-bold uppercase tracking-wider mb-4 border border-white/15">
                                <span class="material-symbols-outlined text-[16px]">phone_iphone</span>
                                Mobile Experience
                            </span>
                            <h2 class="text-3xl sm:text-5xl font-black text-white tracking-tight leading-tight">
                                Take HomiQ With You Everywhere.
                            </h2>
                            <p class="text-slate-200 text-base mt-3 mb-8 max-w-xl font-medium">
                                Real-time chat notifications, instant visit scheduling, and saved search alerts right on your phone.
                            </p>

                            <!-- DOWNLOAD OUR APP Container -->
                            <div class="space-y-3">
                                <span class="block text-xs font-black tracking-widest uppercase text-slate-300">
                                    DOWNLOAD OUR APP
                                </span>
                                <div class="flex flex-col sm:flex-row items-stretch sm:items-center gap-4 flex-wrap">
                                    <!-- Google Play Badge -->
                                    <a href="https://play.google.com/store/apps/details?id=com.homiq.acrocoder&hl=en" target="_blank" class="h-14 px-5 rounded-2xl bg-black hover:bg-slate-900 text-white border border-slate-700/80 hover:border-slate-500 flex items-center gap-3.5 shadow-lg transition-all hover:scale-[1.02] active:scale-[0.98]">
                                        <svg class="w-7 h-7 shrink-0" viewBox="0 0 512 512">
                                            <path fill="#4285F4" d="M47.7 28.5C43.3 33.2 40.7 39.9 40.7 47.5V464.5c0 7.6 2.6 14.3 7 19L273.1 258 47.7 28.5z"/>
                                            <path fill="#34A853" d="M346.5 184.5L273.1 258 47.7 28.5c4-4.3 9.9-7.2 16.5-7.2 4.1 0 7.9 1.1 11.4 3L346.5 184.5z"/>
                                            <path fill="#EA4335" d="M47.7 483.5c4 4.3 9.9 7.2 16.5 7.2 4.1 0 7.9-1.1 11.4-3l270.9-156.2L273.1 258 47.7 483.5z"/>
                                            <path fill="#FBBC05" d="M464.3 243.6L346.5 175.7 273.1 258l73.4 82.3 117.8-67.9c13.7-7.9 13.7-20.8 0-28.8z"/>
                                        </svg>
                                        <div class="text-left">
                                            <span class="block text-[9px] text-slate-300 font-bold uppercase tracking-wider leading-none">GET IT ON</span>
                                            <span class="text-base font-bold text-white tracking-tight leading-tight block mt-0.5">Google Play</span>
                                        </div>
                                    </a>

                                    <!-- Apple App Store Badge -->
                                    <a href="https://apps.apple.com/in/app/homiq-real-estate-marketplace/id6779412636" target="_blank" class="h-14 px-5 rounded-2xl bg-black hover:bg-slate-900 text-white border border-slate-700/80 hover:border-slate-500 flex items-center gap-3.5 shadow-lg transition-all hover:scale-[1.02] active:scale-[0.98]">
                                        <svg class="w-7 h-7 fill-current text-white shrink-0" viewBox="0 0 170 170">
                                            <path d="M150.37 130.25c-2.45 5.66-5.35 10.87-8.71 15.66-4.58 6.53-8.33 11.05-11.22 13.56-4.48 4.12-9.28 6.23-14.42 6.35-3.69 0-8.14-1.05-13.32-3.18-5.19-2.12-9.97-3.17-14.34-3.17-4.58 0-9.49 1.05-14.75 3.17-5.26 2.13-9.5 3.24-12.74 3.35-4.35.13-9.16-1.9-14.42-6.08-3.7-3.04-7.7-7.8-12.01-14.28-5.44-8.15-9.76-17.65-12.96-28.48-3.2-10.84-4.8-21.2-4.8-31.1 0-14.82 3.73-26.65 11.2-35.48 7.46-8.84 16.73-13.35 27.81-13.55 4.8 0 10.14 1.25 16.03 3.75 5.88 2.5 9.73 3.8 11.54 3.9 1.48 0 5.63-1.42 12.44-4.24 6.81-2.83 12.77-4.08 17.87-3.76 13.74.8 24.32 5.92 31.75 15.36-12.07 7.34-18.01 17.51-17.81 30.5.21 10.16 4.17 18.66 11.89 25.48 3.51 3.15 7.44 5.48 11.78 7 1.06 3.71 2.05 7.43 2.97 11.16zm-38.31-105.12c0 3.83-1.07 7.79-3.21 11.89-2.14 4.09-5.11 7.46-8.91 10.11-3.6 2.47-7.42 4.04-11.45 4.7-1.1-.96-1.74-2.58-1.92-4.85-.23-2.92.42-6.1 1.95-9.54 1.53-3.44 3.76-6.49 6.69-9.14 3.15-2.84 6.74-4.83 10.77-5.97 4.03-1.14 7.28-1.54 9.76-1.2.22 1.34.32 2.67.32 4z"/>
                                        </svg>
                                        <div class="text-left">
                                            <span class="block text-[9px] text-slate-300 font-medium leading-none">Download on the</span>
                                            <span class="text-base font-bold text-white tracking-tight leading-tight block mt-0.5">App Store</span>
                                        </div>
                                    </a>
                                </div>
                            </div>
                        </div>

                        <!-- Right Visual Badge Showcase -->
                        <div class="lg:col-span-5 flex justify-center lg:justify-end">
                            <div class="rounded-3xl bg-white/10 border border-white/20 p-6 sm:p-8 backdrop-blur-sm text-center max-w-sm w-full space-y-4">
                                <div class="w-16 h-16 rounded-2xl bg-emerald-500/20 border border-emerald-500/30 text-emerald-400 flex items-center justify-center mx-auto shadow-inner">
                                    <span class="material-symbols-outlined text-[32px]">devices</span>
                                </div>
                                <h3 class="text-xl font-black text-white">Instant Notifications</h3>
                                <p class="text-xs text-slate-200 leading-relaxed font-medium">Get real-time alerts when landlords respond or matching properties are listed near you.</p>
                                <div class="pt-2 flex items-center justify-center gap-2 text-emerald-300 text-xs font-bold">
                                    <span class="material-symbols-outlined text-[18px]">verified</span>
                                    <span>iOS &amp; Android Compatible</span>
                                </div>
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
                            <label class="block text-slate-700 mb-1">Phone Number *</label>
                            <input type="tel" name="seeker_phone" required placeholder="e.g. 9876543210" value="{{ Auth::user()?->phone }}" class="w-full px-3.5 py-2.5 rounded-xl bg-white border border-slate-300 text-slate-900 text-xs font-bold focus:ring-2 focus:ring-emerald-500">
                        </div>
                        <div>
                            <label class="block text-slate-700 mb-1">City *</label>
                            <input type="text" name="city" required placeholder="e.g. Noida, Bangalore" class="w-full px-3.5 py-2.5 rounded-xl bg-white border border-slate-300 text-slate-900 text-xs font-bold focus:ring-2 focus:ring-emerald-500">
                        </div>
                    </div>

                    <div>
                        <label class="block text-slate-700 mb-1">Locality / Sector</label>
                        <input type="text" name="locality" placeholder="e.g. Sector 137 or HSR Layout" class="w-full px-3.5 py-2.5 rounded-xl bg-white border border-slate-300 text-slate-900 text-xs font-bold focus:ring-2 focus:ring-emerald-500">
                    </div>

                    <div class="grid grid-cols-3 gap-2">
                        <div>
                            <label class="block text-slate-700 mb-1">Type *</label>
                            <select name="property_type" class="w-full px-2 py-2.5 rounded-xl bg-white border border-slate-300 text-slate-900 text-xs font-bold">
                                <option value="Apartment">Apartment</option>
                                <option value="PG / Co-living">PG / Co-living</option>
                                <option value="House">House / Villa</option>
                                <option value="Studio">Studio / Room</option>
                                <option value="Commercial">Commercial</option>
                            </select>
                        </div>
                        <div>
                            <label class="block text-slate-700 mb-1">Bedrooms</label>
                            <select name="bedrooms" class="w-full px-2 py-2.5 rounded-xl bg-white border border-slate-300 text-slate-900 text-xs font-bold">
                                <option value="1 BHK">1 BHK</option>
                                <option value="2 BHK" selected>2 BHK</option>
                                <option value="3+ BHK">3+ BHK</option>
                                <option value="Private Room">Private Room</option>
                            </select>
                        </div>
                        <div>
                            <label class="block text-slate-700 mb-1">Max Budget (₹) *</label>
                            <input type="number" name="max_budget" required placeholder="25000" class="w-full px-2 py-2.5 rounded-xl bg-white border border-slate-300 text-slate-900 text-xs font-bold focus:ring-2 focus:ring-emerald-500">
                        </div>
                    </div>

                    <div>
                        <label class="block text-slate-700 mb-1">Specific Requirements (Optional)</label>
                        <textarea name="description" rows="2" placeholder="e.g. Need semi-furnished flat with dedicated parking near metro station." class="w-full px-3.5 py-2.5 rounded-xl bg-white border border-slate-300 text-slate-900 text-xs font-bold focus:ring-2 focus:ring-emerald-500"></textarea>
                    </div>

                    <div class="pt-2">
                        <button type="submit" id="submit-request-btn" class="w-full h-13 rounded-2xl bg-emerald-600 hover:bg-emerald-700 text-white font-bold text-xs flex items-center justify-center gap-2 shadow-sm transition-all cursor-pointer">
                            <span class="material-symbols-outlined text-[18px]">send</span>
                            <span>Post Request to Demand Board</span>
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Modal 2: Share Property Modal -->
    <div x-show="shareModalOpen" 
         x-cloak
         class="fixed inset-0 z-50 overflow-y-auto"
         role="dialog" aria-modal="true">
        <div class="flex items-center justify-center min-h-screen px-4 text-center">
            <div class="fixed inset-0 bg-slate-900/60 transition-opacity" @click="shareModalOpen = false"></div>

            <div class="inline-block align-bottom bg-white rounded-3xl text-left overflow-hidden shadow-2xl transform transition-all max-w-sm w-full border border-slate-200 p-6 z-10">
                <div class="flex items-center justify-between pb-3 border-b border-slate-200 mb-4">
                    <h3 class="text-base font-black text-slate-900">Share This Property</h3>
                    <button @click="shareModalOpen = false" type="button" class="h-7 w-7 rounded-full bg-slate-100 flex items-center justify-center text-slate-700 cursor-pointer">
                        <span class="material-symbols-outlined text-xs">close</span>
                    </button>
                </div>

                <p class="text-xs text-slate-700 mb-4 font-bold" x-text="shareData.title"></p>

                <div class="space-y-2.5">
                    <!-- WhatsApp -->
                    <a :href="'https://api.whatsapp.com/send?text=' + encodeURIComponent('🏠 *' + shareData.title + '* in ' + shareData.address + ' for *' + shareData.price + '* on HomiQ (0% Brokerage)! Check it out: ' + shareData.url)" target="_blank" class="w-full h-12 px-4 rounded-xl bg-emerald-50 hover:bg-emerald-100 text-emerald-800 font-bold text-xs flex items-center justify-between transition-colors">
                        <span class="flex items-center gap-2">
                            <span class="material-symbols-outlined text-emerald-600 text-[18px]">chat</span>
                            <span>Share on WhatsApp</span>
                        </span>
                        <span class="material-symbols-outlined text-sm">arrow_forward</span>
                    </a>

                    <!-- Copy Link -->
                    <button type="button" @click="copyToClipboard(shareData.url); shareModalOpen = false;" class="w-full h-12 px-4 rounded-xl bg-slate-100 hover:bg-slate-200 text-slate-800 font-bold text-xs flex items-center justify-between transition-colors cursor-pointer">
                        <span class="flex items-center gap-2">
                            <span class="material-symbols-outlined text-slate-700 text-[18px]">content_copy</span>
                            <span>Copy Direct Link</span>
                        </span>
                        <span class="material-symbols-outlined text-sm">link</span>
                    </button>
                </div>
            </div>
        </div>
    </div>

    <!-- Footer -->
    <footer class="w-full bg-white border-t border-slate-200">
        <div class="max-w-[1440px] mx-auto px-6 sm:px-8 pt-12 pb-8">
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-8 mb-12">
                <div>
                    <div class="flex items-center gap-3 mb-4">
                        <img alt="HomiQ Brand Logo" class="h-8 w-auto object-contain" src="{{ asset('logo.png') }}">
                    </div>
                    <p class="text-xs text-slate-600 max-w-xs mb-5 leading-relaxed font-medium">
                        Verified residential marketplace designed for modern tenants and certified landlords. Zero brokerage, transparent pricing.
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
                        <li><a href="/category/Shop" class="hover:text-brandNavy transition-colors">Commercial &amp; Shops</a></li>
                    </ul>
                </div>

                <div>
                    <h4 class="text-xs font-black uppercase tracking-wider text-slate-900 mb-4">For Owners &amp; Seekers</h4>
                    <ul class="flex flex-col gap-2.5 text-xs font-semibold text-slate-600">
                        <li><a href="{{ route('host.add-property') }}" class="hover:text-brandNavy transition-colors">List Your Property Free</a></li>
                        <li><a href="#demand-board" class="hover:text-brandNavy transition-colors">Seeker Demand Board</a></li>
                        <li><a href="/pricing" class="hover:text-brandNavy transition-colors">Subscription Plans</a></li>
                        <li><a href="/about" class="hover:text-brandNavy transition-colors">Verification Standards</a></li>
                    </ul>
                </div>

                <div>
                    <h4 class="text-xs font-black uppercase tracking-wider text-slate-900 mb-4">Company &amp; Legal</h4>
                    <ul class="flex flex-col gap-2.5 text-xs font-semibold text-slate-600">
                        <li><a href="/about" class="hover:text-brandNavy transition-colors">About HomiQ</a></li>
                        <li><a href="/privacy" class="hover:text-brandNavy transition-colors">Privacy Policy</a></li>
                        <li><a href="/terms" class="hover:text-brandNavy transition-colors">Terms of Service</a></li>
                        <li><a href="/contact" class="hover:text-brandNavy transition-colors">Contact Support</a></li>
                    </ul>
                </div>
            </div>

            <div class="pt-6 border-t border-slate-200 flex flex-col md:flex-row items-center justify-between gap-4 text-xs text-slate-500 font-semibold">
                <p>© {{ date('Y') }} HomiQ Marketplace Inc. All rights reserved. 100% Zero-brokerage verified platform.</p>
                <div class="flex items-center gap-2 text-emerald-800 font-bold">
                    <span class="material-symbols-outlined text-[16px] text-emerald-600">verified</span>
                    <span>Admin Certified Network</span>
                </div>
            </div>
        </div>
    </footer>

    <!-- Client-side Interactive Scripts -->
    <script>
        function setListingPurpose(purpose, btn) {
            const listingTypeInput = document.getElementById('listing-type-hidden');
            const searchTypeInput = document.getElementById('search-type-hidden');
            const typeSelect = document.getElementById('type-select');

            document.querySelectorAll('.purpose-tab').forEach(el => {
                el.classList.remove('bg-brandNavy', 'text-white', 'shadow-sm');
                el.classList.add('bg-white', 'text-slate-700', 'border', 'border-slate-200');
            });
            btn.classList.add('bg-brandNavy', 'text-white', 'shadow-sm');
            btn.classList.remove('bg-white', 'text-slate-700', 'border', 'border-slate-200');

            if (purpose === 'pg') {
                listingTypeInput.value = 'rent';
                searchTypeInput.value = 'Studio';
                if (typeSelect) typeSelect.value = 'Studio';
            } else if (purpose === 'commercial') {
                listingTypeInput.value = '';
                searchTypeInput.value = 'Shop';
                if (typeSelect) typeSelect.value = 'Shop';
            } else {
                listingTypeInput.value = purpose;
                if (searchTypeInput.value === 'Studio' || searchTypeInput.value === 'Shop') {
                    searchTypeInput.value = '';
                    if (typeSelect) typeSelect.value = '';
                }
            }
        }

        function copyToClipboard(text) {
            navigator.clipboard.writeText(text).then(() => {
                const alpineEl = document.querySelector('[x-data]');
                if (alpineEl && alpineEl._x_dataStack) {
                    alpineEl._x_dataStack[0].showToast('Link copied to clipboard!');
                }
            });
        }

        function shareProperty(title, address, price, url) {
            if (navigator.share) {
                navigator.share({
                    title: title + ' on HomiQ',
                    text: '🏠 ' + title + ' in ' + address + ' for ' + price + ' on HomiQ (0% Brokerage)!',
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
            const text = '🔍 Check out verified ' + searchVal + ' with 0% Brokerage on HomiQ: ' + currentUrl;
            
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
    </script>
</body>
</html>
