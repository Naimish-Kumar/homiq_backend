<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta content="width=device-width, initial-scale=1.0" name="viewport">
    <title>HomiQ - Real Estate &amp; Verified Rental Marketplace</title>
    <meta name="description" content="Discover verified rental homes and apartments with zero brokerage, direct host chat, and transparent pricing on HomiQ.">
    <link rel="icon" type="image/png" href="{{ asset('logo.png') }}">

    <!-- Google Fonts & Material Symbols -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&family=Plus+Jakarta+Sans:wght@500;600;700;800&display=swap" rel="stylesheet">
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
                        "surface-container-high": "#e2e8f0",
                        "tertiary-container": "#002113",
                        "on-tertiary-container": "#009668",
                        "surface": "#f8fafc",
                        "error-container": "#ffdad6",
                        "on-primary-fixed-variant": "#3f465c",
                        "secondary-container": "#059669",
                        "surface-tint": "#0A2540",
                        "outline-variant": "#cbd5e1",
                        "outline": "#64748b",
                        "error": "#ba1a1a",
                        "surface-container-low": "#f8fafc",
                        "tertiary-fixed": "#6ffbbe",
                        "on-surface": "#0A2540",
                        "background": "#f8fafc",
                        "primary-fixed-dim": "#bec6e0",
                        "on-tertiary-fixed": "#002113",
                        "primary-container": "#0F2942",
                        "on-tertiary-fixed-variant": "#005236",
                        "on-secondary-fixed-variant": "#064e3b",
                        "secondary": "#10B981",
                        "on-secondary": "#ffffff",
                        "on-primary": "#ffffff",
                        "on-background": "#0A2540",
                        "on-primary-fixed": "#0A2540",
                        "inverse-on-surface": "#e2e8f0",
                        "surface-container-lowest": "#ffffff",
                        "surface-dim": "#e2e8f0",
                        "surface-bright": "#ffffff",
                        "tertiary-fixed-dim": "#4edea3",
                        "surface-container": "#f1f5f9",
                        "on-secondary-fixed": "#022c22",
                        "on-error": "#ffffff",
                        "on-tertiary": "#ffffff",
                        "on-secondary-container": "#ffffff",
                        "on-error-container": "#93000a",
                        "secondary-fixed": "#d1fae5",
                        "inverse-surface": "#0A2540",
                        "surface-variant": "#e2e8f0",
                        "tertiary": "#059669",
                        "secondary-fixed-dim": "#a7f3d0",
                        "primary": "#0A2540",
                        "primary-fixed": "#dae2fd",
                        "on-surface-variant": "#475569",
                        "inverse-primary": "#bec6e0",
                        "surface-container-highest": "#cbd5e1",
                        "on-primary-container": "#94a3b8",
                        "brand-navy": "#0A2540",
                        "brand-emerald": "#10B981"
                    },
                    borderRadius: {
                        "DEFAULT": "0.25rem",
                        "lg": "0.5rem",
                        "xl": "0.75rem",
                        "full": "9999px"
                    },
                    fontFamily: {
                        "headline-xl": ["Plus Jakarta Sans", "sans-serif"],
                        "headline-lg": ["Plus Jakarta Sans", "sans-serif"],
                        "headline-md": ["Plus Jakarta Sans", "sans-serif"],
                        "headline-sm": ["Plus Jakarta Sans", "sans-serif"],
                        "display-lg": ["Plus Jakarta Sans", "sans-serif"],
                        "title-md": ["Plus Jakarta Sans", "sans-serif"],
                        "label-lg": ["Inter", "sans-serif"],
                        "label-md": ["Inter", "sans-serif"],
                        "label-sm": ["Inter", "sans-serif"],
                        "body-lg": ["Inter", "sans-serif"],
                        "body-md": ["Inter", "sans-serif"],
                        "body-sm": ["Inter", "sans-serif"]
                    }
                }
            }
        };
    </script>
</head>
<body class="bg-surface font-body-md text-body-md text-on-surface antialiased">
    <!-- Header -->
    <header class="fixed top-0 left-0 right-0 z-50 bg-surface-container-lowest/85 backdrop-blur-md border-b border-surface-container shadow-[0_1px_8px_rgba(0,0,0,0.04)]">
        <div class="h-20 max-w-[1440px] mx-auto px-6 sm:px-8 flex items-center justify-between gap-6">
            <div class="flex items-center gap-10">
                <a class="flex items-center gap-3 focus:outline-none" href="/">
                    <img alt="HomiQ Brand Logo" class="h-8 w-auto object-contain" src="{{ asset('logo.png') }}">
                </a>
                <nav class="hidden lg:flex items-center gap-8">
                    <a class="font-label-lg text-label-lg text-on-surface-variant hover:text-on-surface transition-colors duration-200" href="#listings">Verified Homes</a>
                    <a class="font-label-lg text-label-lg text-on-surface-variant hover:text-on-surface transition-colors duration-200" href="/pricing">Pricing</a>
                </nav>
            </div>
            <div class="flex items-center gap-3">
                <a class="hidden sm:inline-flex items-center justify-center h-11 px-5 rounded-full bg-surface-container text-on-surface font-label-lg text-label-lg hover:bg-surface-container-high transition-colors duration-200" href="{{ route('host.add-property') }}">List Your Home</a>
                <div x-data="{ open: false }" class="relative hidden sm:inline-block text-left" @click.outside="open = false">
                    <button @click="open = !open" type="button" class="h-11 px-4 rounded-full border border-surface-container hover:bg-surface-container text-on-surface font-label-lg text-label-lg flex items-center gap-1.5 transition-colors">
                        <span class="material-symbols-outlined text-[18px] text-secondary">phone_iphone</span>
                        <span>Get App</span>
                        <span class="material-symbols-outlined text-xs">expand_more</span>
                    </button>
                    <div x-show="open" 
                         x-cloak
                         x-transition:enter="transition ease-out duration-150" 
                         x-transition:enter-start="opacity-0 scale-95" 
                         x-transition:enter-end="opacity-100 scale-100" 
                         class="absolute right-0 mt-2 w-56 bg-surface-container-lowest rounded-2xl shadow-xl border border-surface-container p-2 z-50">
                        <a href="https://apps.apple.com/in/app/homiq-real-estate-marketplace/id6779412636" target="_blank" class="flex items-center gap-2.5 px-3 py-2 rounded-xl hover:bg-surface-container-low transition text-on-surface text-xs font-semibold">
                            <svg class="w-4 h-4 fill-current text-on-surface shrink-0" viewBox="0 0 24 24"><path d="M18.71 19.5c-.83 1.24-1.71 2.45-3.05 2.47-1.34.03-1.77-.79-3.29-.79-1.53 0-2 .77-3.27.82-1.31.05-2.3-1.32-3.14-2.53C4.25 17 2.94 12.45 4.7 9.39c.87-1.52 2.43-2.48 4.12-2.51 1.28-.02 2.5.87 3.29.87.78 0 2.26-1.07 3.81-.91.65.03 2.47.26 3.64 1.98-.09.06-2.17 1.28-2.15 3.81.03 3.02 2.65 4.03 2.68 4.04-.03.07-.42 1.44-1.38 2.83M15.97 6.37c.62-.75 1.04-1.8 0.93-2.85-.9.04-1.99.6-2.63 1.35-.57.66-.99 1.73-.86 2.76 1.01.08 2.04-.51 2.56-1.26z"/></svg>
                            <div>
                                <span class="block leading-tight font-bold">iOS App Store</span>
                                <span class="text-[10px] text-on-surface-variant font-normal">For iPhone &amp; iPad</span>
                            </div>
                        </a>
                        <a href="https://play.google.com/store/apps/details?id=com.homiq.acrocoder&hl=en" target="_blank" class="flex items-center gap-2.5 px-3 py-2 rounded-xl hover:bg-surface-container-low transition text-on-surface text-xs font-semibold">
                            <span class="material-symbols-outlined text-[18px] text-secondary shrink-0">android</span>
                            <div>
                                <span class="block leading-tight font-bold">Google Play</span>
                                <span class="text-[10px] text-on-surface-variant font-normal">For Android Devices</span>
                            </div>
                        </a>
                    </div>
                </div>
                @auth
                <a href="/dashboard" class="flex items-center gap-3 pl-2 py-1 pr-3 rounded-full bg-surface-container-low hover:bg-surface-container transition-colors cursor-pointer">
                    @if(Auth::user()->avatar)
                        <img alt="{{ Auth::user()->name }}" class="w-8 h-8 rounded-full object-cover" src="{{ asset(Auth::user()->avatar) }}">
                    @else
                        <div class="w-8 h-8 rounded-full bg-secondary text-white flex items-center justify-center font-bold text-xs">
                            {{ strtoupper(substr(Auth::user()->name, 0, 2)) }}
                        </div>
                    @endif
                    <div class="hidden md:flex flex-col text-left">
                        <span class="font-label-md text-label-md text-on-surface leading-tight font-semibold">{{ Auth::user()->name }}</span>
                        <span class="inline-flex items-center gap-1 font-label-sm text-label-sm text-on-tertiary-container">
                            <span class="material-symbols-outlined text-[13px] text-on-tertiary-container">verified</span>
                            {{ Auth::user()->role === "admin" ? "Admin" : (Auth::user()->role === "landlord" ? "Verified Host" : "Verified Tenant") }}
                        </span>
                    </div>
                    <span class="material-symbols-outlined text-[18px] text-on-surface-variant">expand_more</span>
                </a>
                @else
                <a href="/login" class="font-label-lg text-label-lg text-on-surface-variant hover:text-on-surface px-2 transition-colors">Sign In</a>
                <a href="/register" class="inline-flex items-center justify-center h-10 px-5 rounded-full bg-primary text-on-primary font-label-lg text-label-lg hover:bg-inverse-surface transition-all shadow-sm">Get Started</a>
                @endauth
            </div>
        </div>
    </header>

    <main class="w-full pt-20 bg-surface">
        <div class="flex flex-col w-full">
            <!-- Top Ambient Glow Field & Search Hub (EXPANDED TO FULL 1440px CONTAINER WIDTH) -->
            <div class="relative w-full overflow-hidden bg-gradient-to-b from-surface-container-low via-surface to-surface pb-16 pt-8">
                <div class="absolute -top-32 left-1/2 -translate-x-1/2 w-[1200px] h-[540px] bg-gradient-to-tr from-secondary/15 via-surface-container-high/50 to-emerald-500/10 blur-3xl pointer-events-none rounded-full"></div>
                <div class="relative max-w-[1440px] mx-auto px-6 sm:px-8">
                    <!-- Trust Pill -->
                    <div class="flex items-center justify-center mb-6">
                        <div class="inline-flex items-center gap-2.5 px-4 py-1.5 rounded-full bg-surface-container-lowest/90 backdrop-blur-md shadow-sm border border-surface-container">
                            <span class="w-2 h-2 rounded-full bg-on-tertiary-container animate-pulse"></span>
                            <span class="font-label-md text-label-md text-on-surface">100% On-site Verified Listings</span>
                            <span class="text-outline-variant">•</span>
                            <span class="font-label-md text-label-md text-on-surface-variant">0 Brokerage</span>
                            <span class="text-outline-variant">•</span>
                            <span class="font-label-md text-label-md text-on-tertiary-container font-semibold">Direct Host Chat</span>
                        </div>
                    </div>

                    <!-- Main Headline & Subtitle -->
                    <div class="max-w-4xl mx-auto text-center mb-8">
                        <h1 class="font-display-lg text-display-lg text-on-surface tracking-tight leading-tight mb-4">
                            Find the home <br class="hidden sm:inline">
                            <span class="bg-gradient-to-r from-secondary via-secondary-container to-primary bg-clip-text text-transparent">where your life happens.</span>
                            <span class="block font-headline-xl text-headline-xl text-on-surface-variant font-normal mt-1">Verified homes, 0 brokerage, direct owner connection.</span>
                        </h1>
                        <p class="font-body-lg text-body-lg text-on-surface-variant max-w-2xl mx-auto">
                            Discover authentic residences verified on-site. Browse transparent prices, connect directly with approved owners, and reserve your next space seamlessly.
                        </p>
                    </div>

                    <!-- Search Dock: EXPANDED TO FULL 1440px CONTAINER WIDTH -->
                    <div class="w-full max-w-[1440px] mx-auto">
                        <!-- Top Category Tabs (Real Functional Categories) -->
                        <div class="flex items-center justify-start gap-2 mb-3 px-1 overflow-x-auto no-scrollbar">
                            <button onclick="setSearchType('all', this)" class="mode-tab inline-flex items-center gap-2 px-5 py-2.5 rounded-full {{ request('search_type', 'all') === 'all' ? 'bg-primary text-on-primary shadow-sm' : 'bg-surface-container-lowest text-on-surface border border-surface-container hover:bg-surface-container-high' }} font-label-md text-label-md transition-all shrink-0 cursor-pointer" type="button">
                                <span class="material-symbols-outlined text-[18px]">home</span>
                                <span>All Properties</span>
                            </button>
                            <button onclick="setSearchType('Apartment', this)" class="mode-tab inline-flex items-center gap-2 px-5 py-2.5 rounded-full {{ request('search_type') === 'Apartment' ? 'bg-primary text-on-primary shadow-sm' : 'bg-surface-container-lowest text-on-surface border border-surface-container hover:bg-surface-container-high' }} font-label-md text-label-md transition-all shrink-0 cursor-pointer" type="button">
                                <span class="material-symbols-outlined text-[18px] text-secondary">apartment</span>
                                <span>Apartments &amp; Flats</span>
                            </button>
                            <button onclick="setSearchType('Villa', this)" class="mode-tab inline-flex items-center gap-2 px-5 py-2.5 rounded-full {{ request('search_type') === 'Villa' ? 'bg-primary text-on-primary shadow-sm' : 'bg-surface-container-lowest text-on-surface border border-surface-container hover:bg-surface-container-high' }} font-label-md text-label-md transition-all shrink-0 cursor-pointer" type="button">
                                <span class="material-symbols-outlined text-[18px] text-emerald-600">villa</span>
                                <span>Villas &amp; Houses</span>
                            </button>
                            <button onclick="setSearchType('Studio', this)" class="mode-tab inline-flex items-center gap-2 px-5 py-2.5 rounded-full {{ request('search_type') === 'Studio' ? 'bg-primary text-on-primary shadow-sm' : 'bg-surface-container-lowest text-on-surface border border-surface-container hover:bg-surface-container-high' }} font-label-md text-label-md transition-all shrink-0 cursor-pointer" type="button">
                                <span class="material-symbols-outlined text-[18px] text-amber-600">single_bed</span>
                                <span>Studios &amp; Rooms</span>
                            </button>
                            <button onclick="setSearchType('Shop', this)" class="mode-tab inline-flex items-center gap-2 px-5 py-2.5 rounded-full {{ request('search_type') === 'Shop' ? 'bg-primary text-on-primary shadow-sm' : 'bg-surface-container-lowest text-on-surface border border-surface-container hover:bg-surface-container-high' }} font-label-md text-label-md transition-all shrink-0 cursor-pointer" type="button">
                                <span class="material-symbols-outlined text-[18px] text-cyan-600">storefront</span>
                                <span>Commercial &amp; Shops</span>
                            </button>
                            <button onclick="setSearchType('House', this)" class="mode-tab inline-flex items-center gap-2 px-5 py-2.5 rounded-full {{ request('search_type') === 'House' ? 'bg-primary text-on-primary shadow-sm' : 'bg-surface-container-lowest text-on-surface border border-surface-container hover:bg-surface-container-high' }} font-label-md text-label-md transition-all shrink-0 cursor-pointer" type="button">
                                <span class="material-symbols-outlined text-[18px] text-teal-600">cottage</span>
                                <span>Houses</span>
                            </button>
                            <button onclick="setSearchType('Hall', this)" class="mode-tab inline-flex items-center gap-2 px-5 py-2.5 rounded-full {{ request('search_type') === 'Hall' ? 'bg-primary text-on-primary shadow-sm' : 'bg-surface-container-lowest text-on-surface border border-surface-container hover:bg-surface-container-high' }} font-label-md text-label-md transition-all shrink-0 cursor-pointer" type="button">
                                <span class="material-symbols-outlined text-[18px] text-indigo-600">festival</span>
                                <span>Event Halls</span>
                            </button>
                        </div>

                        <!-- Main Filter Card -->
                        <form action="/#listings" method="GET" id="search-form" class="bg-surface-container-lowest/95 backdrop-blur-xl rounded-3xl p-6 md:p-8 shadow-xl border border-surface-container transition-all">
                            <input type="hidden" name="search_type" id="search-type-hidden" value="{{ request('search_type', 'all') }}">
                            <input type="hidden" name="bedrooms" id="bedrooms-hidden" value="{{ request('bedrooms', 'all') }}">
                            <input type="hidden" name="listing_type" id="listing-type-hidden" value="{{ request('listing_type', '') }}">
                            <input type="hidden" name="max_price" id="max-price-hidden" value="{{ request('max_price', '') }}">

                            <div class="grid grid-cols-1 md:grid-cols-12 gap-5 items-center">
                                <!-- Column 1: Location & Micro-Zone -->
                                <div class="md:col-span-4 p-4 rounded-2xl bg-surface-container-low/70 hover:bg-surface-container-low transition-colors border border-surface-container/60">
                                    <div class="flex items-center justify-between mb-1.5">
                                        <div class="flex items-center gap-2">
                                            <span class="material-symbols-outlined text-secondary text-[20px]">pin_drop</span>
                                            <span class="font-label-sm text-label-sm uppercase text-outline tracking-wider font-semibold">City or Address</span>
                                        </div>
                                        @if(request('search'))
                                        <button type="button" onclick="clearSearchInput()" class="text-xs text-rose-500 hover:text-rose-700 font-semibold flex items-center gap-0.5">
                                            <span class="material-symbols-outlined text-[14px]">close</span> Clear
                                        </button>
                                        @endif
                                    </div>
                                    <input id="search-input" name="search" class="bg-transparent font-title-md text-title-md text-on-surface focus:outline-none w-full truncate font-semibold placeholder-slate-400" placeholder="e.g. New York, Miami, Austin..." type="text" value="{{ request('search', '') }}">
                                    <!-- Dynamic Real Popular Cities -->
                                    <div class="flex items-center gap-1.5 mt-2.5 overflow-x-auto no-scrollbar">
                                        <span class="font-label-sm text-[10px] text-outline uppercase shrink-0">Popular:</span>
                                        @foreach($popularCities as $city)
                                        <button type="button" onclick="setLocality('{{ $city }}')" class="text-[11px] px-2.5 py-0.5 rounded-full {{ strtolower(request('search', '')) === strtolower($city) ? 'bg-secondary text-white font-bold' : 'bg-surface-container-lowest text-on-surface hover:text-secondary hover:border-secondary font-medium' }} shadow-2xs border border-surface-container whitespace-nowrap transition-colors cursor-pointer">{{ $city }}</button>
                                        @endforeach
                                    </div>
                                </div>

                                <!-- Column 2: Real Bedroom / Size Filter -->
                                <div class="md:col-span-3 p-4 rounded-2xl bg-surface-container-low/70 hover:bg-surface-container-low transition-colors border border-surface-container/60">
                                    <div class="flex items-center gap-2 mb-1.5">
                                        <span class="material-symbols-outlined text-on-surface-variant text-[20px]">bed</span>
                                        <span class="font-label-sm text-label-sm uppercase text-outline tracking-wider font-semibold">Bedrooms / BHK</span>
                                    </div>
                                    <div class="flex items-center gap-1.5 mt-2">
                                        <button type="button" onclick="setBedrooms('all', this)" class="bhk-btn flex-1 py-1.5 px-2 rounded-xl {{ request('bedrooms', 'all') === 'all' ? 'bg-secondary text-white font-bold shadow-xs' : 'bg-surface-container text-on-surface-variant hover:bg-surface-container-lowest font-medium' }} font-label-sm text-[11px] text-center transition-colors cursor-pointer">Any</button>
                                        <button type="button" onclick="setBedrooms('1', this)" class="bhk-btn flex-1 py-1.5 px-2 rounded-xl {{ request('bedrooms') === '1' ? 'bg-secondary text-white font-bold shadow-xs' : 'bg-surface-container text-on-surface-variant hover:bg-surface-container-lowest font-medium' }} font-label-sm text-[11px] text-center transition-colors cursor-pointer">1 BHK</button>
                                        <button type="button" onclick="setBedrooms('2', this)" class="bhk-btn flex-1 py-1.5 px-2 rounded-xl {{ request('bedrooms') === '2' ? 'bg-secondary text-white font-bold shadow-xs' : 'bg-surface-container text-on-surface-variant hover:bg-surface-container-lowest font-medium' }} font-label-sm text-[11px] text-center transition-colors cursor-pointer">2 BHK</button>
                                        <button type="button" onclick="setBedrooms('3', this)" class="bhk-btn flex-1 py-1.5 px-2 rounded-xl {{ request('bedrooms') === '3' ? 'bg-secondary text-white font-bold shadow-xs' : 'bg-surface-container text-on-surface-variant hover:bg-surface-container-lowest font-medium' }} font-label-sm text-[11px] text-center transition-colors cursor-pointer">3+ BHK</button>
                                    </div>
                                </div>

                                <!-- Column 3: Real Budget Filter -->
                                @php
                                    $isSaleListing = request('listing_type') === 'sale';
                                    $sliderMin = $isSaleListing ? 100000 : 50;
                                    $sliderMax = $isSaleListing ? 2000000 : 1000;
                                    $sliderStep = $isSaleListing ? 25000 : 25;
                                    $sliderCurrent = request('max_price') ? (float)request('max_price') : $sliderMax;
                                @endphp
                                <div class="md:col-span-3 p-4 rounded-2xl bg-surface-container-low/70 hover:bg-surface-container-low transition-colors border border-surface-container/60">
                                    <div class="flex items-center justify-between mb-1.5">
                                        <div class="flex items-center gap-1.5">
                                            <span class="font-label-sm text-label-sm uppercase text-outline tracking-wider font-semibold">Max Budget</span>
                                            @if(request('max_price'))
                                            <button type="button" onclick="clearBudgetFilter()" class="text-[10px] text-rose-500 hover:text-rose-700 font-semibold cursor-pointer">✕ Reset</button>
                                            @endif
                                        </div>
                                        <span class="font-label-sm text-[11px] text-on-tertiary-container font-semibold bg-tertiary-fixed/30 px-1.5 py-0.2 rounded">{{ $properties->count() }} homes</span>
                                    </div>
                                    <div class="flex items-baseline justify-between mt-0.5">
                                        <span id="hero-budget-val" class="font-title-md text-title-md text-on-surface font-bold">{{ request('max_price') ? 'Up to ₹' . number_format(request('max_price')) : 'Any Price' }}</span>
                                        <span class="text-outline text-xs">{{ $isSaleListing ? 'Total' : '/ mo' }}</span>
                                    </div>
                                    <input type="range" min="{{ $sliderMin }}" max="{{ $sliderMax }}" step="{{ $sliderStep }}" value="{{ $sliderCurrent }}" oninput="updateHeroBudget(this.value)" onchange="submitSearchForm()" class="w-full h-2 bg-surface-container rounded-full accent-secondary cursor-pointer mt-2">
                                </div>

                                <!-- Column 4: Submit Button with Live Database Count -->
                                <div class="md:col-span-2 flex justify-end">
                                    <button type="submit" class="w-full h-20 md:h-[98px] rounded-2xl bg-primary text-on-primary font-title-md text-title-md flex flex-col items-center justify-center gap-1 hover:bg-inverse-surface shadow-lg hover:shadow-xl transition-all active:scale-[0.98] group cursor-pointer">
                                        <div class="flex items-center gap-2">
                                            <span class="material-symbols-outlined text-[22px] group-hover:scale-110 transition-transform">search</span>
                                            <span class="font-bold">Search</span>
                                        </div>
                                        <span class="inline-flex items-center gap-1 px-2.5 py-0.5 rounded-full bg-surface-container-lowest/15 text-[11px] font-medium text-primary-fixed">
                                            <span class="w-1.5 h-1.5 rounded-full bg-emerald-400 animate-pulse"></span>
                                            {{ $properties->count() }} Available
                                        </span>
                                    </button>
                                </div>
                            </div>

                            <!-- Bottom Row: Real Amenity Toggles -->
                            <div class="mt-5 pt-5 border-t border-surface-container flex flex-col lg:flex-row items-center justify-between gap-4">
                                <!-- Listing Type Pills -->
                                <div class="flex items-center gap-2 flex-wrap w-full lg:w-auto">
                                    <span class="font-label-sm text-label-sm uppercase text-outline mr-1 shrink-0 font-medium">Listing:</span>
                                    <button type="button" onclick="setListingType('', this)" class="listing-chip inline-flex items-center gap-1 px-3 py-1.5 rounded-xl {{ request('listing_type', '') === '' ? 'bg-primary text-on-primary font-semibold shadow-xs' : 'bg-surface-container text-on-surface-variant hover:text-on-surface' }} text-body-sm transition-colors cursor-pointer">All Listings</button>
                                    <button type="button" onclick="setListingType('rent', this)" class="listing-chip inline-flex items-center gap-1 px-3 py-1.5 rounded-xl {{ request('listing_type') === 'rent' ? 'bg-secondary text-on-secondary font-semibold shadow-xs' : 'bg-surface-container text-on-surface-variant hover:text-on-surface' }} text-body-sm transition-colors cursor-pointer">For Rent</button>
                                    <button type="button" onclick="setListingType('sale', this)" class="listing-chip inline-flex items-center gap-1 px-3 py-1.5 rounded-xl {{ request('listing_type') === 'sale' ? 'bg-secondary text-on-secondary font-semibold shadow-xs' : 'bg-surface-container text-on-surface-variant hover:text-on-surface' }} text-body-sm transition-colors cursor-pointer">For Sale</button>
                                </div>

                                <!-- Real Amenity Filters -->
                                <div class="flex items-center gap-4 flex-wrap w-full lg:w-auto justify-start lg:justify-end">
                                    <label class="inline-flex items-center gap-2 cursor-pointer text-xs font-semibold text-on-surface hover:text-secondary transition-colors select-none">
                                        <input type="checkbox" name="is_furnished" value="1" {{ request('is_furnished') ? 'checked' : '' }} onchange="submitSearchForm()" class="rounded text-secondary focus:ring-secondary cursor-pointer">
                                        <span class="material-symbols-outlined text-[18px] text-secondary">chair</span>
                                        <span>Fully Furnished</span>
                                    </label>
                                    <label class="inline-flex items-center gap-2 cursor-pointer text-xs font-semibold text-on-surface hover:text-secondary transition-colors select-none">
                                        <input type="checkbox" name="is_pet_friendly" value="1" {{ request('is_pet_friendly') ? 'checked' : '' }} onchange="submitSearchForm()" class="rounded text-secondary focus:ring-secondary cursor-pointer">
                                        <span class="material-symbols-outlined text-[18px] text-amber-600">pets</span>
                                        <span>Pet Friendly</span>
                                    </label>
                                    <label class="inline-flex items-center gap-2 cursor-pointer text-xs font-semibold text-on-surface hover:text-secondary transition-colors select-none">
                                        <input type="checkbox" name="has_parking" value="1" {{ request('has_parking') ? 'checked' : '' }} onchange="submitSearchForm()" class="rounded text-secondary focus:ring-secondary cursor-pointer">
                                        <span class="material-symbols-outlined text-[18px] text-cyan-600">directions_car</span>
                                        <span>Dedicated Parking</span>
                                    </label>
                                    @if(request()->hasAny(['search', 'search_type', 'bedrooms', 'max_price', 'is_furnished', 'is_pet_friendly', 'has_parking', 'listing_type']))
                                    <a href="/#listings" class="inline-flex items-center gap-1 text-xs text-rose-600 hover:text-rose-700 font-semibold transition-colors ml-2">
                                        <span class="material-symbols-outlined text-[16px]">restart_alt</span>
                                        <span>Clear All Filters</span>
                                    </a>
                                    @endif
                                </div>
                            </div>
                        </form>

                        <!-- Quick Filter Tags Linking to Real Filters with Active Highlights -->
                        <div class="flex items-center justify-center flex-wrap gap-2.5 mt-5">
                            <a href="/?listing_type=rent#listings" class="inline-flex items-center gap-1.5 px-4 py-1.5 rounded-full {{ request('listing_type') === 'rent' ? 'bg-primary text-on-primary font-bold shadow-xs' : 'bg-surface-container-lowest hover:bg-surface-container-high text-on-surface' }} font-label-md text-label-md transition-all shadow-2xs border border-surface-container">
                                <span class="material-symbols-outlined text-[16px] {{ request('listing_type') === 'rent' ? 'text-primary-fixed' : 'text-secondary' }}">key</span>
                                <span>Verified Rentals</span>
                            </a>
                            <a href="/?listing_type=sale#listings" class="inline-flex items-center gap-1.5 px-4 py-1.5 rounded-full {{ request('listing_type') === 'sale' ? 'bg-primary text-on-primary font-bold shadow-xs' : 'bg-surface-container-lowest hover:bg-surface-container-high text-on-surface' }} font-label-md text-label-md transition-all shadow-2xs border border-surface-container">
                                <span class="material-symbols-outlined text-[16px] {{ request('listing_type') === 'sale' ? 'text-primary-fixed' : 'text-emerald-600' }}">real_estate_agent</span>
                                <span>Properties For Sale</span>
                            </a>
                            <a href="/?is_pet_friendly=1#listings" class="inline-flex items-center gap-1.5 px-4 py-1.5 rounded-full {{ request('is_pet_friendly') ? 'bg-primary text-on-primary font-bold shadow-xs' : 'bg-surface-container-lowest hover:bg-surface-container-high text-on-surface' }} font-label-md text-label-md transition-all shadow-2xs border border-surface-container">
                                <span class="material-symbols-outlined text-[16px] {{ request('is_pet_friendly') ? 'text-primary-fixed' : 'text-amber-600' }}">pets</span>
                                <span>Pet Friendly</span>
                            </a>
                            <a href="/?is_furnished=1#listings" class="inline-flex items-center gap-1.5 px-4 py-1.5 rounded-full {{ request('is_furnished') ? 'bg-primary text-on-primary font-bold shadow-xs' : 'bg-surface-container-lowest hover:bg-surface-container-high text-on-surface' }} font-label-md text-label-md transition-all shadow-2xs border border-surface-container">
                                <span class="material-symbols-outlined text-[16px] {{ request('is_furnished') ? 'text-primary-fixed' : 'text-secondary' }}">chair</span>
                                <span>Fully Furnished</span>
                            </a>
                            <a href="/?has_parking=1#listings" class="inline-flex items-center gap-1.5 px-4 py-1.5 rounded-full {{ request('has_parking') ? 'bg-primary text-on-primary font-bold shadow-xs' : 'bg-surface-container-lowest hover:bg-surface-container-high text-on-surface' }} font-label-md text-label-md transition-all shadow-2xs border border-surface-container">
                                <span class="material-symbols-outlined text-[16px] {{ request('has_parking') ? 'text-primary-fixed' : 'text-cyan-600' }}">directions_car</span>
                                <span>With Parking</span>
                            </a>
                            <a href="/?search_type=Villa#listings" class="inline-flex items-center gap-1.5 px-4 py-1.5 rounded-full {{ request('search_type') === 'Villa' ? 'bg-primary text-on-primary font-bold shadow-xs' : 'bg-surface-container-lowest hover:bg-surface-container-high text-on-surface' }} font-label-md text-label-md transition-all shadow-2xs border border-surface-container">
                                <span class="material-symbols-outlined text-[16px] {{ request('search_type') === 'Villa' ? 'text-primary-fixed' : 'text-emerald-600' }}">villa</span>
                                <span>Luxury Villas</span>
                            </a>
                            <a href="/?search_type=Apartment#listings" class="inline-flex items-center gap-1.5 px-4 py-1.5 rounded-full {{ request('search_type') === 'Apartment' ? 'bg-primary text-on-primary font-bold shadow-xs' : 'bg-surface-container-lowest hover:bg-surface-container-high text-on-surface' }} font-label-md text-label-md transition-all shadow-2xs border border-surface-container">
                                <span class="material-symbols-outlined text-[16px] {{ request('search_type') === 'Apartment' ? 'text-primary-fixed' : 'text-secondary' }}">apartment</span>
                                <span>Modern Apartments</span>
                            </a>
                        </div>
                    </div>
                </div>
            </div>

            <!-- SECTION A: Explore by City / Micro-Zone (Connected to Real Database Cities) -->
            <section class="max-w-[1440px] mx-auto px-6 sm:px-8 py-14 w-full" id="neighborhood-lifestyle">
                <div class="flex flex-col md:flex-row md:items-end justify-between gap-4 mb-10">
                    <div>
                        <div class="inline-flex items-center gap-1.5 text-secondary font-label-sm text-label-sm uppercase tracking-wider mb-2">
                            <span class="material-symbols-outlined text-[16px]">travel_explore</span>
                            Top Locations &amp; Micro-Districts
                        </div>
                        <h2 class="font-headline-xl text-headline-xl text-on-surface">Explore Available Homes by Location</h2>
                        <p class="font-body-md text-body-md text-on-surface-variant mt-1">Browse verified properties across premier residential neighborhoods with zero brokerage fees.</p>
                    </div>
                    <div class="flex items-center gap-2">
                        <a href="/?listing_type=rent" class="px-4 py-2 rounded-full bg-surface-container-low text-on-surface hover:bg-surface-container text-label-md font-semibold transition-colors flex items-center gap-1.5">
                            <span>Browse All Rentals</span>
                            <span class="material-symbols-outlined text-[16px]">arrow_forward</span>
                        </a>
                    </div>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                    @foreach(array_slice($popularCities, 0, 3) as $city)
                    @php
                        $cityProperties = $properties->filter(function ($p) use ($city) {
                            return str_contains(strtolower($p->address ?? ''), strtolower($city));
                        });
                        $cityCount = $cityProperties->count();
                        $firstCityProp = $cityProperties->first();
                        $coverImg = ($firstCityProp && !empty($firstCityProp->images) && is_array($firstCityProp->images)) ? $firstCityProp->images[0] : 'https://images.unsplash.com/photo-1512917774080-9991f1c4c750?auto=format&fit=crop&w=800&q=80';
                    @endphp
                    <div class="group rounded-3xl bg-surface-container-lowest p-6 border border-surface-container hover:border-secondary/30 shadow-md hover:shadow-xl transition-all duration-300 flex flex-col justify-between">
                        <div>
                            <div class="relative rounded-2xl overflow-hidden aspect-[16/9] mb-4 bg-surface-container">
                                <img alt="{{ $city }}" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500" src="{{ $coverImg }}">
                                <div class="absolute inset-0 bg-gradient-to-t from-slate-900/70 via-transparent to-transparent"></div>
                                <div class="absolute bottom-3 left-3 right-3 flex items-center justify-between text-white">
                                    <span class="font-bold text-lg drop-shadow-md">{{ $city }}</span>
                                    <span class="px-2.5 py-0.5 rounded-full bg-white/20 backdrop-blur-md text-xs font-semibold">{{ $cityCount }} Verified {{ $cityCount === 1 ? 'Home' : 'Homes' }}</span>
                                </div>
                            </div>
                            <div class="flex items-start justify-between mb-3">
                                <div>
                                    <span class="px-3 py-1 rounded-full bg-secondary/10 text-secondary text-xs font-bold uppercase tracking-wider">Prime Location</span>
                                    <h3 class="font-headline-md text-headline-md text-on-surface mt-1.5 font-bold group-hover:text-secondary transition-colors">{{ $city }}</h3>
                                    <p class="text-xs text-on-surface-variant">Verified residences with direct host contact</p>
                                </div>
                            </div>
                            <div class="space-y-2 bg-surface-container-low/70 p-3.5 rounded-2xl mb-6 text-xs text-on-surface-variant">
                                <div class="flex items-center justify-between">
                                    <span class="flex items-center gap-1.5"><span class="material-symbols-outlined text-[16px] text-emerald-600">verified</span> Inspection Guarantee</span>
                                    <span class="font-semibold text-on-surface">100% On-site</span>
                                </div>
                                <div class="flex items-center justify-between">
                                    <span class="flex items-center gap-1.5"><span class="material-symbols-outlined text-[16px] text-secondary">money_off</span> Brokerage Fee</span>
                                    <span class="font-semibold text-emerald-600">0% Direct</span>
                                </div>
                                <div class="flex items-center justify-between">
                                    <span class="flex items-center gap-1.5"><span class="material-symbols-outlined text-[16px] text-amber-500">chat</span> Landlord Chat</span>
                                    <span class="font-semibold text-on-surface">Instant Messaging</span>
                                </div>
                            </div>
                        </div>
                        <a class="w-full py-2.5 rounded-xl bg-surface-container-high/60 hover:bg-secondary hover:text-on-secondary text-on-surface font-label-md text-label-md text-center transition-all flex items-center justify-center gap-2 group/btn" href="/?search={{ urlencode($city) }}">
                            <span>Explore Homes in {{ $city }}</span>
                            <span class="material-symbols-outlined text-[16px] group-hover/btn:translate-x-1 transition-transform">arrow_forward</span>
                        </a>
                    </div>
                    @endforeach
                </div>
            </section>

            <!-- SECTION B: Real Live Verified Properties Showcase (`#listings`) -->
            <section class="max-w-[1440px] mx-auto px-6 sm:px-8 pt-4 pb-16 w-full" id="listings">
                <!-- Section Header with Category Quick Filter -->
                <div class="flex flex-col md:flex-row md:items-end justify-between gap-6 mb-8">
                    <div>
                        <div class="inline-flex items-center gap-1.5 text-secondary font-label-sm text-label-sm uppercase tracking-wider mb-2">
                            <span class="material-symbols-outlined text-[16px]">home_work</span>
                            Active Database Inventory
                        </div>
                        <h2 class="font-headline-xl text-headline-xl text-on-surface flex items-center gap-3">
                            <span>Verified Available Properties</span>
                            <span class="font-headline-sm text-headline-sm font-normal text-on-surface-variant">({{ $properties->count() }} listings)</span>
                        </h2>
                        <p class="font-body-md text-body-md text-on-surface-variant mt-1">Browse all authentic, admin-approved listings with high-resolution photos and transparent pricing.</p>
                    </div>

                    <!-- Category Pills Filter Bar -->
                    <div class="flex items-center gap-2 overflow-x-auto no-scrollbar pb-1">
                        <a href="/?search_type=all#listings" class="px-4 py-2 rounded-full {{ request('search_type', 'all') === 'all' ? 'bg-primary text-on-primary shadow-sm' : 'bg-surface-container text-on-surface-variant hover:text-on-surface hover:bg-surface-container-high' }} text-label-md font-semibold whitespace-nowrap transition-all">
                            All ({{ $properties->count() }})
                        </a>
                        @foreach($categories as $cat)
                        <a href="/?search_type={{ urlencode($cat['name']) }}#listings" class="px-4 py-2 rounded-full {{ request('search_type') === $cat['name'] ? 'bg-primary text-on-primary shadow-sm' : 'bg-surface-container text-on-surface-variant hover:text-on-surface hover:bg-surface-container-high' }} text-label-md font-semibold whitespace-nowrap transition-all">
                            {{ $cat['name'] }}
                        </a>
                        @endforeach
                    </div>
                </div>

                <!-- Active Filters Notification & Removal Bar (Appears when any search/filter is active) -->
                @if(request()->hasAny(['search', 'search_type', 'bedrooms', 'max_price', 'listing_type', 'is_furnished', 'is_pet_friendly', 'has_parking']) && (request('search') || (request('search_type') && request('search_type') !== 'all') || (request('bedrooms') && request('bedrooms') !== 'all') || request('max_price') || request('listing_type') || request('is_furnished') || request('is_pet_friendly') || request('has_parking')))
                <div class="mb-8 p-4 rounded-2xl bg-surface-container-low border border-surface-container flex flex-wrap items-center justify-between gap-3 shadow-2xs">
                    <div class="flex items-center gap-2 flex-wrap">
                        <span class="text-xs uppercase font-bold text-outline mr-1 flex items-center gap-1">
                            <span class="material-symbols-outlined text-[16px] text-secondary">tune</span>
                            Active Filters:
                        </span>
                        @if(request('search'))
                        <a href="{{ request()->fullUrlWithQuery(['search' => null]) }}#listings" class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full bg-surface-container-lowest text-on-surface text-xs font-semibold hover:bg-rose-50 hover:text-rose-600 hover:border-rose-200 border border-surface-container shadow-2xs transition-colors group">
                            <span>Location: {{ request('search') }}</span>
                            <span class="material-symbols-outlined text-[14px] text-outline group-hover:text-rose-600">close</span>
                        </a>
                        @endif
                        @if(request('search_type') && request('search_type') !== 'all')
                        <a href="{{ request()->fullUrlWithQuery(['search_type' => null]) }}#listings" class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full bg-surface-container-lowest text-on-surface text-xs font-semibold hover:bg-rose-50 hover:text-rose-600 hover:border-rose-200 border border-surface-container shadow-2xs transition-colors group">
                            <span>Type: {{ request('search_type') }}</span>
                            <span class="material-symbols-outlined text-[14px] text-outline group-hover:text-rose-600">close</span>
                        </a>
                        @endif
                        @if(request('bedrooms') && request('bedrooms') !== 'all')
                        <a href="{{ request()->fullUrlWithQuery(['bedrooms' => null]) }}#listings" class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full bg-surface-container-lowest text-on-surface text-xs font-semibold hover:bg-rose-50 hover:text-rose-600 hover:border-rose-200 border border-surface-container shadow-2xs transition-colors group">
                            <span>Bedrooms: {{ request('bedrooms') >= 3 ? '3+ BHK' : request('bedrooms') . ' BHK' }}</span>
                            <span class="material-symbols-outlined text-[14px] text-outline group-hover:text-rose-600">close</span>
                        </a>
                        @endif
                        @if(request('max_price'))
                        <a href="{{ request()->fullUrlWithQuery(['max_price' => null]) }}#listings" class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full bg-surface-container-lowest text-on-surface text-xs font-semibold hover:bg-rose-50 hover:text-rose-600 hover:border-rose-200 border border-surface-container shadow-2xs transition-colors group">
                            <span>Max: ₹{{ number_format(request('max_price')) }}</span>
                            <span class="material-symbols-outlined text-[14px] text-outline group-hover:text-rose-600">close</span>
                        </a>
                        @endif
                        @if(request('listing_type'))
                        <a href="{{ request()->fullUrlWithQuery(['listing_type' => null]) }}#listings" class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full bg-surface-container-lowest text-on-surface text-xs font-semibold hover:bg-rose-50 hover:text-rose-600 hover:border-rose-200 border border-surface-container shadow-2xs transition-colors group">
                            <span>For {{ ucfirst(request('listing_type')) }}</span>
                            <span class="material-symbols-outlined text-[14px] text-outline group-hover:text-rose-600">close</span>
                        </a>
                        @endif
                        @if(request('is_furnished'))
                        <a href="{{ request()->fullUrlWithQuery(['is_furnished' => null]) }}#listings" class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full bg-surface-container-lowest text-on-surface text-xs font-semibold hover:bg-rose-50 hover:text-rose-600 hover:border-rose-200 border border-surface-container shadow-2xs transition-colors group">
                            <span>Furnished</span>
                            <span class="material-symbols-outlined text-[14px] text-outline group-hover:text-rose-600">close</span>
                        </a>
                        @endif
                        @if(request('is_pet_friendly'))
                        <a href="{{ request()->fullUrlWithQuery(['is_pet_friendly' => null]) }}#listings" class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full bg-surface-container-lowest text-on-surface text-xs font-semibold hover:bg-rose-50 hover:text-rose-600 hover:border-rose-200 border border-surface-container shadow-2xs transition-colors group">
                            <span>Pet Friendly</span>
                            <span class="material-symbols-outlined text-[14px] text-outline group-hover:text-rose-600">close</span>
                        </a>
                        @endif
                        @if(request('has_parking'))
                        <a href="{{ request()->fullUrlWithQuery(['has_parking' => null]) }}#listings" class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full bg-surface-container-lowest text-on-surface text-xs font-semibold hover:bg-rose-50 hover:text-rose-600 hover:border-rose-200 border border-surface-container shadow-2xs transition-colors group">
                            <span>Parking</span>
                            <span class="material-symbols-outlined text-[14px] text-outline group-hover:text-rose-600">close</span>
                        </a>
                        @endif
                    </div>
                    <a href="/#listings" class="inline-flex items-center gap-1.5 px-3.5 py-1.5 rounded-full bg-rose-50 text-rose-700 hover:bg-rose-100 text-xs font-bold border border-rose-200 transition-colors shrink-0">
                        <span class="material-symbols-outlined text-[16px]">restart_alt</span>
                        <span>Reset All Filters</span>
                    </a>
                </div>
                @endif

                <!-- Featured Property Spotlight (If Available) -->
                @if($featuredProperties->isNotEmpty() && !request()->hasAny(['search', 'bedrooms', 'max_price', 'is_furnished', 'is_pet_friendly', 'has_parking']))
                @php $spotlight = $featuredProperties->first(); @endphp
                <div class="mb-12 rounded-3xl bg-white p-6 md:p-8 border border-slate-200/80 shadow-soft hover:shadow-xl transition-all duration-300">
                    <div class="grid grid-cols-1 lg:grid-cols-12 gap-8 items-center">
                        <div class="lg:col-span-7 relative rounded-2xl overflow-hidden aspect-[16/10] bg-slate-100 group">
                            @php
                                $spotImages = (!empty($spotlight->images) && is_array($spotlight->images)) ? $spotlight->images : ['https://images.unsplash.com/photo-1564013799919-ab600027ffc6?auto=format&fit=crop&w=800&q=80'];
                            @endphp
                            <img alt="{{ $spotlight->title }}" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-700 ease-out" src="{{ $spotImages[0] }}">
                            <div class="absolute inset-0 bg-gradient-to-t from-slate-950/70 via-transparent to-transparent"></div>
                            <div class="absolute top-4 left-4 right-4 flex items-center justify-between pointer-events-none">
                                <div class="inline-flex items-center gap-2 px-3.5 py-1.5 rounded-full bg-slate-900/85 backdrop-blur-md text-white font-bold text-xs shadow-md pointer-events-auto">
                                    <span class="w-2 h-2 rounded-full bg-emerald-400 animate-pulse"></span>
                                    <span>Featured Spotlight</span>
                                </div>
                                <span class="px-3 py-1 rounded-full bg-emerald-500 text-white font-bold text-xs shadow-sm pointer-events-auto">
                                    For {{ ucfirst($spotlight->listing_type) }}
                                </span>
                            </div>
                        </div>
                        <div class="lg:col-span-5 flex flex-col justify-between h-full space-y-6">
                            <div>
                                <div class="flex items-center gap-2 mb-2.5">
                                    <span class="px-3 py-1 rounded-full bg-slate-900 text-white text-xs font-bold uppercase tracking-wider">{{ $spotlight->category }}</span>
                                    <span class="px-3 py-1 rounded-full bg-emerald-50 text-emerald-700 border border-emerald-200 text-xs font-bold">0% Brokerage</span>
                                </div>
                                <h3 class="text-2xl sm:text-3xl font-black text-slate-900 tracking-tight leading-tight">{{ $spotlight->title }}</h3>
                                <p class="text-slate-500 text-sm flex items-center gap-1.5 mt-2 font-medium">
                                    <span class="material-symbols-outlined text-base text-emerald-600">location_on</span>
                                    <span>{{ $spotlight->address }}</span>
                                </p>
                            </div>

                            <div class="grid grid-cols-3 gap-3 p-4 rounded-2xl bg-slate-50 border border-slate-100">
                                <div class="text-center">
                                    <span class="block text-xs uppercase text-slate-400 font-bold">Bedrooms</span>
                                    <span class="text-lg font-black text-slate-900">{{ $spotlight->bedrooms ?? 0 }} BHK</span>
                                </div>
                                <div class="text-center border-x border-slate-200">
                                    <span class="block text-xs uppercase text-slate-400 font-bold">Bathrooms</span>
                                    <span class="text-lg font-black text-slate-900">{{ $spotlight->bathrooms ?? 0 }} Bath</span>
                                </div>
                                <div class="text-center">
                                    <span class="block text-xs uppercase text-slate-400 font-bold">Furnished</span>
                                    <span class="text-lg font-black text-slate-900">{{ $spotlight->is_furnished ? 'Yes' : 'No' }}</span>
                                </div>
                            </div>

                            <div class="pt-4 border-t border-slate-100 flex items-center justify-between">
                                <div>
                                    <span class="block text-xs text-slate-400 font-bold uppercase tracking-wider">Direct Asking Price</span>
                                    <span class="text-3xl font-black text-slate-900">{{ $spotlight->formatted_price }}</span>
                                </div>
                                <a href="/properties/{{ $spotlight->id }}" class="h-12 px-6 rounded-full bg-brandNavy hover:bg-slate-900 text-white font-bold text-sm flex items-center gap-2 shadow-md hover:shadow-lg transition-all active:scale-[0.98]">
                                    <span>View Details</span>
                                    <span class="material-symbols-outlined text-base">arrow_forward</span>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
                @endif

                <!-- Dynamic Grid of Real Properties -->
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                    @forelse($properties as $property)
                        <x-property-card :property="$property" />
                    @empty
                    <!-- Empty State -->
                    <div class="col-span-full py-16 px-6 text-center bg-surface-container-lowest rounded-3xl border border-surface-container">
                        <div class="w-16 h-16 rounded-full bg-surface-container flex items-center justify-center mx-auto mb-4 text-outline">
                            <span class="material-symbols-outlined text-[32px]">search_off</span>
                        </div>
                        <h3 class="font-headline-md text-headline-md font-bold text-on-surface">No Properties Found</h3>
                        <p class="font-body-md text-body-md text-on-surface-variant max-w-md mx-auto mt-2 mb-6">
                            We couldn't find any approved listings matching your selected search criteria. Try clearing some filters or searching for another city.
                        </p>
                        <a href="/" class="inline-flex items-center gap-2 px-6 py-3 rounded-full bg-primary text-on-primary font-label-md text-label-md hover:bg-inverse-surface transition-colors shadow-sm">
                            <span class="material-symbols-outlined text-[18px]">refresh</span>
                            <span>Reset All Filters</span>
                        </a>
                    </div>
                    @endforelse
                </div>
            </section>

            <!-- SECTION C: Verified Property Guarantee & Physical Inspection Standards (Replaces Fictional 3D Laser) -->
            <section class="max-w-[1440px] mx-auto px-6 sm:px-8 py-16 w-full" id="verified-inspection">
                <div class="bg-primary-container text-on-primary rounded-[36px] p-8 md:p-14 shadow-2xl relative overflow-hidden">
                    <div class="absolute -top-24 right-1/4 w-96 h-96 bg-secondary/30 rounded-full blur-3xl pointer-events-none"></div>
                    <div class="absolute bottom-0 right-0 w-80 h-80 bg-emerald-500/20 rounded-full blur-3xl pointer-events-none"></div>

                    <div class="grid grid-cols-1 lg:grid-cols-12 gap-10 items-center relative z-10">
                        <div class="lg:col-span-5">
                            <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full bg-secondary-fixed text-on-secondary-fixed font-label-sm text-label-sm font-bold mb-4">
                                <span class="material-symbols-outlined text-[15px]">verified_user</span>
                                100% Verified Quality Standard
                            </span>
                            <h2 class="font-headline-xl text-headline-xl text-on-primary leading-tight font-bold">Every listing is physically inspected before approval</h2>
                            <p class="font-body-md text-body-md text-primary-fixed-dim mt-4 mb-8">
                                Say goodbye to fake photos and bait-and-switch listings. HomiQ verifies ownership documents, conducts physical on-site audits, and ensures zero brokerage fees for all tenants.
                            </p>
                            <div class="space-y-4">
                                <div class="flex items-start gap-3.5">
                                    <div class="w-9 h-9 rounded-xl bg-surface-container-lowest/10 flex items-center justify-center text-tertiary-fixed shrink-0">
                                        <span class="material-symbols-outlined text-[20px]">fact_check</span>
                                    </div>
                                    <div>
                                        <h4 class="font-title-md text-title-md text-on-primary font-bold">Admin-Audited Ownership</h4>
                                        <p class="text-xs text-primary-fixed-dim mt-0.5">Every host is verified with government ID and legitimate title deeds before posting.</p>
                                    </div>
                                </div>
                                <div class="flex items-start gap-3.5">
                                    <div class="w-9 h-9 rounded-xl bg-surface-container-lowest/10 flex items-center justify-center text-amber-300 shrink-0">
                                        <span class="material-symbols-outlined text-[20px]">photo_library</span>
                                    </div>
                                    <div>
                                        <h4 class="font-title-md text-title-md text-on-primary font-bold">Authentic Photo Galleries</h4>
                                        <p class="text-xs text-primary-fixed-dim mt-0.5">High-resolution multi-angle photographs showing exact room dimensions and conditions.</p>
                                    </div>
                                </div>
                                <div class="flex items-start gap-3.5">
                                    <div class="w-9 h-9 rounded-xl bg-surface-container-lowest/10 flex items-center justify-center text-secondary-fixed-dim shrink-0">
                                        <span class="material-symbols-outlined text-[20px]">chat</span>
                                    </div>
                                    <div>
                                        <h4 class="font-title-md text-title-md text-on-primary font-bold">Direct In-App Host Chat</h4>
                                        <p class="text-xs text-primary-fixed-dim mt-0.5">Communicate directly with landlords to ask questions and schedule visits with no middlemen.</p>
                                    </div>
                                </div>
                            </div>
                            <div class="mt-8 flex flex-wrap items-center gap-4">
                                <a href="#listings" class="px-6 py-3.5 rounded-full bg-secondary hover:bg-secondary-container text-on-secondary font-title-md text-title-md flex items-center gap-2 shadow-lg transition-colors">
                                    <span class="material-symbols-outlined text-[20px]">search</span>
                                    <span>Browse Verified Homes</span>
                                </a>
                                <a href="{{ route('host.add-property') }}" class="px-6 py-3.5 rounded-full bg-surface-container-lowest/15 hover:bg-surface-container-lowest/25 text-on-primary font-title-md text-title-md flex items-center gap-2 transition-colors">
                                    <span class="material-symbols-outlined text-[20px]">add_home</span>
                                    <span>List Your Property</span>
                                </a>
                            </div>
                        </div>

                        <div class="lg:col-span-7">
                            <div class="rounded-3xl overflow-hidden bg-surface-container-lowest/5 border border-surface-container-lowest/15 backdrop-blur-xl p-3 shadow-2xl">
                                <div class="relative rounded-2xl overflow-hidden aspect-[16/10] bg-surface-container-highest">
                                    @php
                                        $tourProperty = $properties->first();
                                        $tourImage = ($tourProperty && !empty($tourProperty->images) && is_array($tourProperty->images)) ? $tourProperty->images[0] : 'https://images.unsplash.com/photo-1512917774080-9991f1c4c750?auto=format&fit=crop&w=800&q=80';
                                    @endphp
                                    <img alt="Verified Property Preview" class="w-full h-full object-cover" src="{{ $tourImage }}">
                                    <div class="absolute inset-0 bg-gradient-to-t from-primary-container/90 via-transparent to-primary-container/40 flex flex-col justify-between p-5">
                                        <div class="flex items-center justify-between">
                                            <span class="px-3 py-1 rounded-full bg-primary-container/85 backdrop-blur-md text-tertiary-fixed text-xs font-bold border border-tertiary-fixed/30 flex items-center gap-1.5">
                                                <span class="w-2 h-2 rounded-full bg-tertiary-fixed animate-pulse"></span>
                                                PHYSICALLY AUDITED
                                            </span>
                                            <span class="px-3 py-1 rounded-full bg-surface-container-lowest/20 backdrop-blur-md text-white text-xs font-semibold">
                                                Zero Brokerage Certified
                                            </span>
                                        </div>

                                        <div class="p-4 rounded-2xl bg-surface-container-lowest/10 backdrop-blur-md border border-white/15 text-white flex items-center justify-between">
                                            <div>
                                                <span class="text-xs uppercase text-primary-fixed-dim">Sample Verified Residence</span>
                                                <h4 class="font-bold text-base">{{ $tourProperty ? $tourProperty->title : 'Luxury Oceanfront Residence' }}</h4>
                                                <p class="text-xs text-primary-fixed-dim">{{ $tourProperty ? $tourProperty->address : '102 Ocean Drive, Miami, FL' }}</p>
                                            </div>
                                            @if($tourProperty)
                                            <a href="/properties/{{ $tourProperty->id }}" class="px-4 py-2 rounded-xl bg-secondary text-white text-xs font-bold hover:bg-secondary-container transition-colors shrink-0">
                                                View Listing
                                            </a>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </section>

            <!-- Innovation Differentiators: Real Platform Pillars -->
            <section class="max-w-[1440px] mx-auto px-6 sm:px-8 py-16 w-full">
                <div class="text-center max-w-2xl mx-auto mb-14">
                    <span class="font-label-sm text-label-sm uppercase tracking-wider text-secondary font-bold">The HomiQ Advantage</span>
                    <h2 class="font-headline-xl text-headline-xl text-on-surface mt-1">Engineered for authentic renting</h2>
                    <p class="font-body-md text-body-md text-on-surface-variant mt-2">Zero middlemen commissions. Direct landlord contact. Safe in-app reservation management.</p>
                </div>
                <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
                    <!-- Module A: Direct Host Messaging -->
                    <div class="rounded-3xl bg-surface-container-lowest p-8 flex flex-col justify-between shadow-md hover:shadow-lg transition-all duration-300 border border-surface-container">
                        <div>
                            <div class="w-12 h-12 rounded-2xl bg-secondary/10 text-secondary flex items-center justify-center mb-6">
                                <span class="material-symbols-outlined text-[26px]">chat</span>
                            </div>
                            <span class="font-label-sm text-label-sm uppercase tracking-wider text-outline font-semibold">Direct Communication</span>
                            <h3 class="font-headline-sm text-headline-sm text-on-surface mt-1 mb-3 font-bold">In-App Host Chat</h3>
                            <p class="font-body-sm text-body-sm text-on-surface-variant">Message verified property owners directly. Discuss lease terms, ask about utilities, and schedule in-person tours without sharing your personal phone number.</p>
                        </div>
                        <div class="mt-8 p-4 rounded-2xl bg-surface-container-low flex items-center justify-between">
                            <span class="font-label-md text-label-md text-on-surface font-semibold">Real-time Host Messaging</span>
                            <a href="/chat" class="px-3 py-1.5 rounded-xl bg-secondary text-white text-xs font-semibold hover:bg-secondary-container transition-colors">Open Chat</a>
                        </div>
                    </div>

                    <!-- Module B: Host Listing Portal -->
                    <div class="rounded-3xl bg-surface-container-lowest p-8 flex flex-col justify-between shadow-md hover:shadow-lg transition-all duration-300 border border-surface-container">
                        <div>
                            <div class="w-12 h-12 rounded-2xl bg-on-tertiary-container/10 text-on-tertiary-container flex items-center justify-center mb-6">
                                <span class="material-symbols-outlined text-[26px]">add_home</span>
                            </div>
                            <span class="font-label-sm text-label-sm uppercase tracking-wider text-outline font-semibold">Owner Portal</span>
                            <h3 class="font-headline-sm text-headline-sm text-on-surface mt-1 mb-3 font-bold">List Your Property Fast</h3>
                            <p class="font-body-sm text-body-sm text-on-surface-variant">Are you a landlord or property manager? Upload photos, set your price, configure amenities, and publish to thousands of verified tenants in under 3 minutes.</p>
                        </div>
                        <div class="mt-8 p-4 rounded-2xl bg-surface-container-low flex items-center justify-between">
                            <span class="font-label-md text-label-md text-on-surface font-semibold">Fast Landlord Onboarding</span>
                            <a href="{{ route('host.add-property') }}" class="px-3 py-1.5 rounded-xl bg-primary text-white text-xs font-semibold hover:bg-inverse-surface transition-colors">List Home</a>
                        </div>
                    </div>

                    <!-- Module C: 100% Zero Brokerage -->
                    <div class="rounded-3xl bg-surface-container-lowest p-8 flex flex-col justify-between shadow-md hover:shadow-lg transition-all duration-300 border border-surface-container">
                        <div>
                            <div class="w-12 h-12 rounded-2xl bg-amber-500/10 text-amber-600 flex items-center justify-center mb-6">
                                <span class="material-symbols-outlined text-[26px]">savings</span>
                            </div>
                            <span class="font-label-sm text-label-sm uppercase tracking-wider text-outline font-semibold">No Hidden Surcharges</span>
                            <h3 class="font-headline-sm text-headline-sm text-on-surface mt-1 mb-3 font-bold">Strict Zero Brokerage</h3>
                            <p class="font-body-sm text-body-sm text-on-surface-variant">Never pay 1 to 2 months rent to an unhelpful broker again. HomiQ connects renters and hosts directly so you save thousands of dollars on every move.</p>
                        </div>
                        <div class="mt-8 p-4 rounded-2xl bg-surface-container-low flex items-center justify-between">
                            <span class="font-label-md text-label-md text-on-surface font-semibold">Average Tenant Savings</span>
                            <span class="font-label-md text-label-md text-on-tertiary-container font-bold">₹15,000 – ₹30,000</span>
                        </div>
                    </div>
                </div>
            </section>

            <!-- SECTION D: Move-in Cost & Zero-Brokerage Savings Calculator -->
            <section class="max-w-[1440px] mx-auto px-6 sm:px-8 py-16 w-full" id="calculator-section">
                <div class="rounded-[36px] bg-gradient-to-br from-surface-container-lowest via-surface-container-low to-surface-container p-8 md:p-14 border border-surface-container shadow-xl">
                    <div class="max-w-3xl mx-auto text-center mb-12">
                        <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full bg-emerald-500/10 text-on-tertiary-container font-label-sm text-xs font-bold uppercase tracking-wider mb-3">
                            <span class="material-symbols-outlined text-[15px]">verified_user</span>
                            100% Financial Transparency
                        </span>
                        <h2 class="font-headline-xl text-headline-xl text-on-surface">Move-In Cost &amp; Savings Calculator</h2>
                        <p class="font-body-md text-body-md text-on-surface-variant mt-2">
                            Estimate your total move-in budget including rent, security deposit, and see how much you save with HomiQ's ₹0 Brokerage policy.
                        </p>
                    </div>

                    <div class="grid grid-cols-1 lg:grid-cols-12 gap-10 items-center max-w-5xl mx-auto">
                        <div class="lg:col-span-6 bg-surface-container-lowest p-6 md:p-8 rounded-3xl border border-surface-container shadow-md space-y-6">
                            <div>
                                <div class="flex items-center justify-between mb-2">
                                    <label class="font-label-md text-label-md text-on-surface font-semibold flex items-center gap-1.5">
                                        <span class="material-symbols-outlined text-secondary text-[18px]">payments</span>
                                        Target Monthly Rent
                                    </label>
                                    <span id="rent-display" class="font-headline-md text-headline-md font-bold text-on-surface">₹25,000</span>
                                </div>
                                <input id="rent-slider" type="range" min="5000" max="150000" step="1000" value="25000" oninput="calculateMoveInCost()" class="w-full h-2 bg-surface-container rounded-full accent-secondary cursor-pointer">
                                <div class="flex justify-between text-[11px] text-outline mt-1 font-medium">
                                    <span>₹5,000</span>
                                    <span>₹50,000</span>
                                    <span>₹1,50,000+</span>
                                </div>
                            </div>

                            <div>
                                <label class="font-label-md text-label-md text-on-surface font-semibold flex items-center gap-1.5 mb-2.5">
                                    <span class="material-symbols-outlined text-amber-500 text-[18px]">shield</span>
                                    Security Deposit Multiplier
                                </label>
                                <div class="grid grid-cols-3 gap-2">
                                    <button type="button" onclick="setDepositMultiplier(1, this)" class="deposit-btn py-2 px-3 rounded-xl border border-surface-container text-xs font-semibold text-on-surface hover:bg-surface-container-low transition-colors">1 Month</button>
                                    <button type="button" onclick="setDepositMultiplier(2, this)" class="deposit-btn py-2 px-3 rounded-xl bg-secondary text-white text-xs font-semibold shadow-sm">2 Months (Standard)</button>
                                    <button type="button" onclick="setDepositMultiplier(3, this)" class="deposit-btn py-2 px-3 rounded-xl border border-surface-container text-xs font-semibold text-on-surface hover:bg-surface-container-low transition-colors">3 Months</button>
                                </div>
                            </div>

                            <div>
                                <label class="font-label-md text-label-md text-on-surface font-semibold flex items-center gap-1.5 mb-2.5">
                                    <span class="material-symbols-outlined text-emerald-600 text-[18px]">bolt</span>
                                    Optional Move-in Add-ons
                                </label>
                                <div class="space-y-2">
                                    <label class="flex items-center justify-between p-3 rounded-xl bg-surface-container-low/70 border border-surface-container/60 cursor-pointer hover:bg-surface-container-low transition-colors">
                                        <span class="text-xs font-medium text-on-surface flex items-center gap-2">
                                            <input type="checkbox" id="addon-deepclean" onchange="calculateMoveInCost()" checked class="rounded text-secondary focus:ring-secondary">
                                            Move-in Deep Clean Service
                                        </span>
                                        <span class="text-xs font-bold text-on-surface">₹2,500</span>
                                    </label>
                                    <label class="flex items-center justify-between p-3 rounded-xl bg-surface-container-low/70 border border-surface-container/60 cursor-pointer hover:bg-surface-container-low transition-colors">
                                        <span class="text-xs font-medium text-on-surface flex items-center gap-2">
                                            <input type="checkbox" id="addon-insurance" onchange="calculateMoveInCost()" checked class="rounded text-secondary focus:ring-secondary">
                                            Tenant Protection &amp; Damage Cover
                                        </span>
                                        <span class="text-xs font-bold text-on-surface">₹499/mo</span>
                                    </label>
                                </div>
                            </div>
                        </div>

                        <div class="lg:col-span-6 bg-primary-container text-on-primary p-6 md:p-8 rounded-3xl shadow-2xl relative overflow-hidden flex flex-col justify-between">
                            <div class="absolute -right-16 -top-16 w-48 h-48 bg-secondary/20 rounded-full blur-2xl pointer-events-none"></div>
                            <div class="relative z-10">
                                <div class="flex items-center justify-between pb-4 border-b border-white/10">
                                    <h4 class="font-headline-sm text-headline-sm text-on-primary font-bold">Move-In Breakdown</h4>
                                    <span class="px-2.5 py-0.5 rounded-full bg-emerald-500/20 text-emerald-300 font-label-sm text-[11px] font-bold">0 Brokerage Guaranteed</span>
                                </div>

                                <div class="space-y-3.5 my-6 text-sm">
                                    <div class="flex justify-between items-center text-primary-fixed-dim">
                                        <span class="flex items-center gap-1.5"><span class="material-symbols-outlined text-[16px]">home</span> First Month Rent</span>
                                        <span id="summary-rent" class="font-semibold text-white">₹25,000</span>
                                    </div>
                                    <div class="flex justify-between items-center text-primary-fixed-dim">
                                        <span class="flex items-center gap-1.5"><span class="material-symbols-outlined text-[16px] text-tertiary-fixed">shield</span> Security Deposit</span>
                                        <span id="summary-deposit" class="font-semibold text-white">₹50,000</span>
                                    </div>
                                    <div class="flex justify-between items-center text-primary-fixed-dim">
                                        <span class="flex items-center gap-1.5"><span class="material-symbols-outlined text-[16px]">money_off</span> HomiQ Brokerage Fee</span>
                                        <span class="font-semibold text-emerald-400">FREE (₹0)</span>
                                    </div>
                                    <div class="flex justify-between items-center text-primary-fixed-dim">
                                        <span class="flex items-center gap-1.5"><span class="material-symbols-outlined text-[16px]">verified</span> Direct Landlord Inquiries</span>
                                        <span class="font-semibold text-emerald-400">FREE (₹0)</span>
                                    </div>
                                    <div class="flex justify-between items-center text-primary-fixed-dim">
                                        <span class="flex items-center gap-1.5"><span class="material-symbols-outlined text-[16px]">tune</span> Selected Move-in Services</span>
                                        <span id="summary-addons" class="font-semibold text-white">₹2,999</span>
                                    </div>
                                </div>

                                <div class="pt-4 border-t border-white/15 flex items-baseline justify-between">
                                    <div>
                                        <span class="block text-xs uppercase tracking-wider text-primary-fixed-dim font-medium">Estimated Total Move-In</span>
                                        <span class="text-[11px] text-emerald-400 font-medium">You save ~₹25,000 in broker fees</span>
                                    </div>
                                    <span id="summary-total" class="font-display-lg text-[34px] font-extrabold text-white">₹77,999</span>
                                </div>
                            </div>

                            <div class="mt-6 pt-4 border-t border-white/10 flex items-center gap-3">
                                <a href="#listings" class="w-full py-3.5 rounded-xl bg-secondary hover:bg-secondary-container text-on-secondary font-label-md text-sm font-semibold flex items-center justify-center gap-2 shadow-md transition-colors">
                                    <span>Browse Verified Homes</span>
                                    <span class="material-symbols-outlined text-[18px]">arrow_forward</span>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </section>

            <!-- SECTION E: Frequently Asked Questions (FAQ) Accordion Module -->
            <section class="max-w-[1440px] mx-auto px-6 sm:px-8 py-16 w-full" id="faq-section">
                <div class="max-w-3xl mx-auto">
                    <div class="text-center mb-12">
                        <span class="font-label-sm text-label-sm uppercase tracking-wider text-secondary font-bold">Answers &amp; Policies</span>
                        <h2 class="font-headline-xl text-headline-xl text-on-surface mt-1">Frequently Asked Questions</h2>
                        <p class="font-body-md text-body-md text-on-surface-variant mt-2">Clear answers about zero brokerage, booking visits, and listing your property on HomiQ.</p>
                    </div>

                    <div class="space-y-4">
                        <details class="group rounded-2xl bg-surface-container-lowest border border-surface-container p-5 transition-all open:shadow-md" open>
                            <summary class="font-title-md text-title-md text-on-surface font-bold flex items-center justify-between cursor-pointer list-none">
                                <span>How does Zero Brokerage work on HomiQ?</span>
                                <span class="material-symbols-outlined text-secondary transition-transform group-open:rotate-180">expand_more</span>
                            </summary>
                            <p class="font-body-md text-body-md text-on-surface-variant mt-3 pt-3 border-t border-surface-container">
                                Unlike traditional real estate agencies that charge 1 to 2 months' rent as brokerage commission, HomiQ connects tenants directly with verified property owners. You pay zero brokerage fees to discover, message landlords, and book visits.
                            </p>
                        </details>

                        <details class="group rounded-2xl bg-surface-container-lowest border border-surface-container p-5 transition-all open:shadow-md">
                            <summary class="font-title-md text-title-md text-on-surface font-bold flex items-center justify-between cursor-pointer list-none">
                                <span>How are properties verified before being approved?</span>
                                <span class="material-symbols-outlined text-secondary transition-transform group-open:rotate-180">expand_more</span>
                            </summary>
                            <p class="font-body-md text-body-md text-on-surface-variant mt-3 pt-3 border-t border-surface-container">
                                Every listing submitted by a landlord must undergo admin review. We verify ownership records, cross-check photos against physical premises, verify landlord identities, and confirm rent transparency before publishing.
                            </p>
                        </details>

                        <details class="group rounded-2xl bg-surface-container-lowest border border-surface-container p-5 transition-all open:shadow-md">
                            <summary class="font-title-md text-title-md text-on-surface font-bold flex items-center justify-between cursor-pointer list-none">
                                <span>How can I message landlords and schedule visits?</span>
                                <span class="material-symbols-outlined text-secondary transition-transform group-open:rotate-180">expand_more</span>
                            </summary>
                            <p class="font-body-md text-body-md text-on-surface-variant mt-3 pt-3 border-t border-surface-container">
                                Simply click on any property card to view its details. From the property page, you can start a real-time chat with the owner via our built-in in-app chat system to ask questions or agree on a visit schedule.
                            </p>
                        </details>

                        <details class="group rounded-2xl bg-surface-container-lowest border border-surface-container p-5 transition-all open:shadow-md">
                            <summary class="font-title-md text-title-md text-on-surface font-bold flex items-center justify-between cursor-pointer list-none">
                                <span>How do I list my property as a landlord or host?</span>
                                <span class="material-symbols-outlined text-secondary transition-transform group-open:rotate-180">expand_more</span>
                            </summary>
                            <p class="font-body-md text-body-md text-on-surface-variant mt-3 pt-3 border-t border-surface-container">
                                Click the "List Your Home" button in the top navigation bar. You can upload photos, set your asking rent and security deposit, specify amenities (parking, pet policy, furnishing), and submit for rapid admin review.
                            </p>
                        </details>
                    </div>
                </div>
            </section>

            <!-- Bottom CTA Banner -->
            <section class="max-w-[1440px] mx-auto px-6 sm:px-8 py-16 w-full">
                <div class="relative overflow-hidden rounded-[32px] bg-primary-container text-on-primary p-10 md:p-16 shadow-2xl">
                    <div class="absolute -right-20 -bottom-20 w-96 h-96 bg-secondary/30 rounded-full blur-3xl pointer-events-none"></div>
                    <div class="absolute -left-20 -top-20 w-80 h-80 bg-tertiary-fixed-dim/20 rounded-full blur-3xl pointer-events-none"></div>
                    <div class="relative z-10 max-w-2xl">
                        <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full bg-surface-container-lowest/10 backdrop-blur-md text-tertiary-fixed font-label-sm text-label-sm mb-4">
                            <span class="w-2 h-2 rounded-full bg-tertiary-fixed"></span>
                            Direct Landlord Connection
                        </span>
                        <h2 class="font-headline-xl text-headline-xl text-on-primary leading-tight font-bold">Ready to find your next verified home?</h2>
                        <p class="font-body-lg text-body-lg text-on-primary-container mt-3 mb-8">
                            Join thousands of tenants renting directly from verified owners with zero brokerage fees.
                        </p>
                        <div class="flex flex-col sm:flex-row items-stretch sm:items-center gap-4 flex-wrap">
                            <a href="#listings" class="h-14 px-8 rounded-full bg-secondary hover:bg-secondary-container text-on-secondary font-title-md text-title-md flex items-center justify-center gap-2 shadow-lg transition-all active:scale-[0.98]">
                                <span class="material-symbols-outlined text-[20px]">explore</span>
                                <span>Browse Available Homes</span>
                            </a>
                            <a href="https://apps.apple.com/in/app/homiq-real-estate-marketplace/id6779412636" target="_blank" class="h-14 px-6 rounded-full bg-surface-container-lowest/15 hover:bg-surface-container-lowest/25 text-on-primary font-title-md text-sm font-bold flex items-center justify-center gap-2.5 backdrop-blur-sm transition-colors border border-white/15">
                                <svg class="w-5 h-5 fill-current text-white" viewBox="0 0 24 24"><path d="M18.71 19.5c-.83 1.24-1.71 2.45-3.05 2.47-1.34.03-1.77-.79-3.29-.79-1.53 0-2 .77-3.27.82-1.31.05-2.3-1.32-3.14-2.53C4.25 17 2.94 12.45 4.7 9.39c.87-1.52 2.43-2.48 4.12-2.51 1.28-.02 2.5.87 3.29.87.78 0 2.26-1.07 3.81-.91.65.03 2.47.26 3.64 1.98-.09.06-2.17 1.28-2.15 3.81.03 3.02 2.65 4.03 2.68 4.04-.03.07-.42 1.44-1.38 2.83M15.97 6.37c.62-.75 1.04-1.8 0.93-2.85-.9.04-1.99.6-2.63 1.35-.57.66-.99 1.73-.86 2.76 1.01.08 2.04-.51 2.56-1.26z"/></svg>
                                <span>App Store (iOS)</span>
                            </a>
                            <a href="https://play.google.com/store/apps/details?id=com.homiq.acrocoder&hl=en" target="_blank" class="h-14 px-6 rounded-full bg-surface-container-lowest/15 hover:bg-surface-container-lowest/25 text-on-primary font-title-md text-sm font-bold flex items-center justify-center gap-2.5 backdrop-blur-sm transition-colors border border-white/15">
                                <span class="material-symbols-outlined text-[20px] text-emerald-400">android</span>
                                <span>Google Play</span>
                            </a>
                        </div>
                    </div>
                </div>
            </section>
        </div>
    </main>

    <!-- Footer -->
    <footer class="w-full bg-surface-container-lowest border-t border-surface-container">
        <div class="max-w-[1440px] mx-auto px-6 sm:px-8 pt-12 pb-8">
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-8 mb-12">
                <div>
                    <div class="flex items-center gap-3 mb-4">
                        <img alt="HomiQ Brand Logo" class="h-7 w-auto object-contain" src="{{ asset('logo.png') }}">
                        <span class="font-headline-sm text-headline-sm text-on-surface tracking-tight font-bold">HomiQ</span>
                    </div>
                    <p class="font-body-sm text-body-sm text-on-surface-variant max-w-xs mb-5">
                        Verified residential marketplace designed for modern tenants and certified landlords. Zero brokerage, transparent pricing.
                    </p>
                    <div class="flex flex-col gap-2">
                        <span class="font-label-sm text-label-sm uppercase tracking-wider text-outline">Experience Mobile</span>
                        <div class="flex flex-wrap items-center gap-2.5">
                            <a href="https://apps.apple.com/in/app/homiq-real-estate-marketplace/id6779412636" target="_blank" class="h-10 px-3.5 rounded-xl bg-surface-container text-on-surface flex items-center gap-2 cursor-pointer hover:bg-surface-container-high transition-colors">
                                <svg class="w-4 h-4 fill-current text-on-surface" viewBox="0 0 24 24"><path d="M18.71 19.5c-.83 1.24-1.71 2.45-3.05 2.47-1.34.03-1.77-.79-3.29-.79-1.53 0-2 .77-3.27.82-1.31.05-2.3-1.32-3.14-2.53C4.25 17 2.94 12.45 4.7 9.39c.87-1.52 2.43-2.48 4.12-2.51 1.28-.02 2.5.87 3.29.87.78 0 2.26-1.07 3.81-.91.65.03 2.47.26 3.64 1.98-.09.06-2.17 1.28-2.15 3.81.03 3.02 2.65 4.03 2.68 4.04-.03.07-.42 1.44-1.38 2.83M15.97 6.37c.62-.75 1.04-1.8 0.93-2.85-.9.04-1.99.6-2.63 1.35-.57.66-.99 1.73-.86 2.76 1.01.08 2.04-.51 2.56-1.26z"/></svg>
                                <span class="font-label-md text-xs font-bold">App Store</span>
                            </a>
                            <a href="https://play.google.com/store/apps/details?id=com.homiq.acrocoder&hl=en" target="_blank" class="h-10 px-3.5 rounded-xl bg-surface-container text-on-surface flex items-center gap-2 cursor-pointer hover:bg-surface-container-high transition-colors">
                                <span class="material-symbols-outlined text-[18px] text-secondary">android</span>
                                <span class="font-label-md text-xs font-bold">Google Play</span>
                            </a>
                        </div>
                    </div>
                </div>
                <div>
                    <h4 class="font-title-md text-title-md text-on-surface mb-4 font-bold">Discover Categories</h4>
                    <ul class="flex flex-col gap-2.5">
                        <li><a href="/category/Apartment" class="font-body-sm text-body-sm text-on-surface-variant hover:text-on-surface transition-colors">Modern Apartments</a></li>
                        <li><a href="/category/Villa" class="font-body-sm text-body-sm text-on-surface-variant hover:text-on-surface transition-colors">Luxury Villas</a></li>
                        <li><a href="/category/House" class="font-body-sm text-body-sm text-on-surface-variant hover:text-on-surface transition-colors">Suburban Houses</a></li>
                        <li><a href="/category/Studio" class="font-body-sm text-body-sm text-on-surface-variant hover:text-on-surface transition-colors">Studios &amp; Rooms</a></li>
                        <li><a href="/category/Shop" class="font-body-sm text-body-sm text-on-surface-variant hover:text-on-surface transition-colors">Commercial &amp; Shops</a></li>
                    </ul>
                </div>
                <div>
                    <h4 class="font-title-md text-title-md text-on-surface mb-4 font-bold">For Owners &amp; Hosts</h4>
                    <ul class="flex flex-col gap-2.5">
                        <li><a href="{{ route('host.add-property') }}" class="font-body-sm text-body-sm text-on-surface-variant hover:text-on-surface transition-colors">List Your Property</a></li>
                        <li><a href="/pricing" class="font-body-sm text-body-sm text-on-surface-variant hover:text-on-surface transition-colors">Subscription Plans</a></li>
                        <li><a href="/about" class="font-body-sm text-body-sm text-on-surface-variant hover:text-on-surface transition-colors">Owner Verification Guide</a></li>
                        <li><a href="/chat" class="font-body-sm text-body-sm text-on-surface-variant hover:text-on-surface transition-colors">Tenant Inquiries</a></li>
                    </ul>
                </div>
                <div>
                    <h4 class="font-title-md text-title-md text-on-surface mb-4 font-bold">Company &amp; Trust</h4>
                    <ul class="flex flex-col gap-2.5">
                        <li><a href="/about" class="font-body-sm text-body-sm text-on-surface-variant hover:text-on-surface transition-colors">About HomiQ</a></li>
                        <li><a href="/privacy" class="font-body-sm text-body-sm text-on-surface-variant hover:text-on-surface transition-colors">Privacy Policy</a></li>
                        <li><a href="/terms" class="font-body-sm text-body-sm text-on-surface-variant hover:text-on-surface transition-colors">Terms of Service</a></li>
                        <li><a href="/contact" class="font-body-sm text-body-sm text-on-surface-variant hover:text-on-surface transition-colors">Contact Support</a></li>
                    </ul>
                </div>
            </div>

            <div class="pt-6 border-t border-surface-container flex flex-col md:flex-row items-center justify-between gap-4">
                <p class="font-body-sm text-body-sm text-on-surface-variant">© {{ date('Y') }} HomiQ Technologies Inc. All rights reserved. Zero-brokerage verified marketplace.</p>
                <div class="flex items-center gap-6">
                    <div class="flex items-center gap-1 text-on-surface-variant font-label-md text-xs">
                        <span class="material-symbols-outlined text-[16px]">verified</span>
                        <span>Admin Verified Platform</span>
                    </div>
                </div>
            </div>
        </div>
    </footer>

    <!-- Client-side Scripts -->
    <script>
        function submitSearchForm() {
            document.getElementById('search-form').submit();
        }

        function setLocality(loc) {
            const input = document.getElementById('search-input');
            input.value = loc;
            submitSearchForm();
        }

        function clearSearchInput() {
            const input = document.getElementById('search-input');
            input.value = '';
            submitSearchForm();
        }

        function setSearchType(cat, btn) {
            document.getElementById('search-type-hidden').value = cat;
            if (btn) {
                document.querySelectorAll('.mode-tab').forEach(el => {
                    el.classList.remove('bg-primary', 'text-on-primary', 'shadow-sm');
                    el.classList.add('bg-surface-container-lowest', 'text-on-surface');
                });
                btn.classList.add('bg-primary', 'text-on-primary', 'shadow-sm');
                btn.classList.remove('bg-surface-container-lowest', 'text-on-surface');
            }
            submitSearchForm();
        }

        function setBedrooms(bhk, btn) {
            document.getElementById('bedrooms-hidden').value = bhk;
            if (btn) {
                document.querySelectorAll('.bhk-btn').forEach(el => {
                    el.classList.remove('bg-secondary', 'text-white', 'font-bold', 'shadow-xs');
                    el.classList.add('bg-surface-container', 'text-on-surface-variant');
                });
                btn.classList.add('bg-secondary', 'text-white', 'font-bold', 'shadow-xs');
                btn.classList.remove('bg-surface-container', 'text-on-surface-variant');
            }
            submitSearchForm();
        }

        function setListingType(type, btn) {
            document.getElementById('listing-type-hidden').value = type;
            if (btn) {
                document.querySelectorAll('.listing-chip').forEach(el => {
                    el.classList.remove('bg-primary', 'bg-secondary', 'text-on-primary', 'text-on-secondary', 'font-semibold', 'shadow-xs');
                    el.classList.add('bg-surface-container', 'text-on-surface-variant');
                });
                btn.classList.add('bg-primary', 'text-on-primary', 'font-semibold', 'shadow-xs');
                btn.classList.remove('bg-surface-container', 'text-on-surface-variant');
            }
            submitSearchForm();
        }

        function updateHeroBudget(val) {
            document.getElementById('hero-budget-val').innerText = 'Up to ₹' + Number(val).toLocaleString();
            document.getElementById('max-price-hidden').value = val;
        }

        function clearBudgetFilter() {
            document.getElementById('max-price-hidden').value = '';
            submitSearchForm();
        }

        let currentDepositMultiplier = 2;

        function setDepositMultiplier(mult, btn) {
            currentDepositMultiplier = mult;
            document.querySelectorAll('.deposit-btn').forEach(b => {
                b.classList.remove('bg-secondary', 'text-white', 'shadow-sm');
                b.classList.add('border', 'border-surface-container', 'text-on-surface');
            });
            btn.classList.remove('border', 'border-surface-container', 'text-on-surface');
            btn.classList.add('bg-secondary', 'text-white', 'shadow-sm');
            calculateMoveInCost();
        }

        function calculateMoveInCost() {
            const rent = parseInt(document.getElementById('rent-slider').value, 10);
            document.getElementById('rent-display').innerText = '₹' + rent.toLocaleString();
            document.getElementById('summary-rent').innerText = '₹' + rent.toLocaleString();

            const deposit = rent * currentDepositMultiplier;
            document.getElementById('summary-deposit').innerText = '₹' + deposit.toLocaleString();

            let addons = 0;
            if (document.getElementById('addon-deepclean').checked) addons += 2500;
            if (document.getElementById('addon-insurance').checked) addons += 499;
            document.getElementById('summary-addons').innerText = '₹' + addons.toLocaleString();

            const total = rent + deposit + addons;
            document.getElementById('summary-total').innerText = '₹' + total.toLocaleString();
        }

        calculateMoveInCost();
    </script>
</body>
</html>
