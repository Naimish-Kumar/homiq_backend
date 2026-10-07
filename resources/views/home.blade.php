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
    <header x-data="{ mobileMenuOpen: false, cityDropdownOpen: false, userDropdownOpen: false, isScrolled: false }"
            x-init="window.addEventListener('scroll', () => { isScrolled = window.scrollY > 15 })"
            :class="isScrolled ? 'bg-white/95 backdrop-blur-2xl shadow-[0_10px_35px_rgba(15,23,42,0.07)] border-slate-200/90 py-3' : 'bg-white/90 backdrop-blur-xl border-slate-200/60 py-3.5 sm:py-4'"
            class="fixed top-0 left-0 right-0 z-50 border-b transition-all duration-300">
        <div class="max-w-[1440px] mx-auto px-4 sm:px-6 lg:px-8 flex items-center justify-between gap-4">
            
            <!-- Left: Logo & City Micro-Selector -->
            <div class="flex items-center gap-4 lg:gap-6 shrink-0">
                <a class="flex items-center gap-2.5 focus:outline-none group" href="/">
                    <img alt="HomiQ Brand Logo" class="h-8 sm:h-9 w-auto object-contain transition-transform duration-300 group-hover:scale-105" src="{{ asset('logo.png') }}">
                </a>

                <!-- City Selector Badge Dropdown -->
                <div class="relative hidden sm:block" @click.outside="cityDropdownOpen = false">
                    <button type="button" 
                            @click="cityDropdownOpen = !cityDropdownOpen" 
                            class="flex items-center gap-1.5 px-3 py-1.5 rounded-full bg-slate-100/90 hover:bg-slate-200/90 text-slate-800 text-xs font-bold border border-slate-200/80 transition-all cursor-pointer">
                        <span class="material-symbols-outlined text-[16px] text-emerald-600">location_on</span>
                        <span>{{ (!empty($selectedCity) && $selectedCity !== 'All') ? $selectedCity : 'Noida' }}</span>
                        <span class="material-symbols-outlined text-[16px] text-slate-400 transition-transform duration-200" :class="cityDropdownOpen ? 'rotate-180' : ''">expand_more</span>
                    </button>

                    <!-- City Dropdown Menu -->
                    <div x-show="cityDropdownOpen" 
                         x-cloak
                         x-transition:enter="transition ease-out duration-200"
                         x-transition:enter-start="opacity-0 translate-y-2 scale-95"
                         x-transition:enter-end="opacity-100 translate-y-0 scale-100"
                         x-transition:leave="transition ease-in duration-150"
                         x-transition:leave-start="opacity-100 translate-y-0 scale-100"
                         x-transition:leave-end="opacity-0 translate-y-2 scale-95"
                         class="absolute left-0 top-full mt-2 w-48 rounded-2xl bg-white/95 backdrop-blur-xl border border-slate-200 shadow-2xl p-2 z-50">
                        <div class="px-2.5 py-1.5 text-[10px] font-extrabold uppercase tracking-wider text-slate-400">Popular Markets</div>
                        @foreach(['Noida', 'Greater Noida', 'Delhi', 'Gurugram', 'Bangalore', 'Pune'] as $cityOption)
                            <a href="/?city={{ urlencode($cityOption) }}#listings" 
                               @click="cityDropdownOpen = false"
                               class="flex items-center justify-between px-3 py-2 rounded-xl text-xs font-bold text-slate-700 hover:bg-emerald-50 hover:text-emerald-700 transition-colors">
                                <span>{{ $cityOption }}</span>
                                @if(($selectedCity ?? 'Noida') === $cityOption)
                                    <span class="material-symbols-outlined text-emerald-600 text-sm">check</span>
                                @endif
                            </a>
                        @endforeach
                    </div>
                </div>
            </div>

            <!-- Center: Primary Nav Links -->
            <nav class="hidden lg:flex items-center gap-1 xl:gap-2">
                <a class="px-3.5 py-2 rounded-full text-xs font-bold text-slate-700 hover:text-emerald-700 hover:bg-emerald-50/70 transition-all flex items-center gap-1.5 group" href="/buy/noida">
                    <span class="material-symbols-outlined text-[17px] text-slate-400 group-hover:text-emerald-600 transition-colors">real_estate_agent</span>
                    <span>Buy</span>
                </a>
                <a class="px-3.5 py-2 rounded-full text-xs font-bold text-slate-700 hover:text-emerald-700 hover:bg-emerald-50/70 transition-all flex items-center gap-1.5 group" href="/rent/noida">
                    <span class="material-symbols-outlined text-[17px] text-slate-400 group-hover:text-emerald-600 transition-colors">key</span>
                    <span>Rent</span>
                </a>
                <a class="px-3.5 py-2 rounded-full text-xs font-bold text-slate-700 hover:text-emerald-700 hover:bg-emerald-50/70 transition-all flex items-center gap-1.5 group" href="/explore/student_pg">
                    <span class="material-symbols-outlined text-[17px] text-slate-400 group-hover:text-emerald-600 transition-colors">single_bed</span>
                    <span>PG &amp; Rooms</span>
                </a>
                <a class="px-3.5 py-2 rounded-full text-xs font-bold text-slate-700 hover:text-emerald-700 hover:bg-emerald-50/70 transition-all flex items-center gap-1.5 group" href="/explore/commercial">
                    <span class="material-symbols-outlined text-[17px] text-slate-400 group-hover:text-emerald-600 transition-colors">storefront</span>
                    <span>Commercial</span>
                </a>
                @if(isset($propertyRequests) && $propertyRequests->isNotEmpty())
                <a class="px-3.5 py-2 rounded-full text-xs font-bold text-slate-700 hover:text-emerald-700 hover:bg-emerald-50/70 transition-all flex items-center gap-2 group" href="#demand-board">
                    <span class="relative flex h-2 w-2">
                        <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-emerald-400 opacity-75"></span>
                        <span class="relative inline-flex rounded-full h-2 w-2 bg-emerald-500"></span>
                    </span>
                    <span>Demand Board</span>
                </a>
                @endif
                <a class="px-3.5 py-2 rounded-full text-xs font-bold text-slate-700 hover:text-emerald-700 hover:bg-emerald-50/70 transition-all" href="/pricing">Pricing</a>
                <a class="px-3.5 py-2 rounded-full text-xs font-bold text-slate-700 hover:text-emerald-700 hover:bg-emerald-50/70 transition-all" href="/guides">Guides</a>
            </nav>

            <!-- Right: Action Buttons & Auth -->
            <div class="flex items-center gap-2 sm:gap-3 shrink-0">
                <!-- Request Property Button -->
                <button type="button" 
                        @click="requestModalOpen = true" 
                        class="hidden sm:inline-flex items-center justify-center gap-1.5 h-10 px-4 rounded-full bg-slate-100/90 hover:bg-emerald-50 hover:text-emerald-700 hover:border-emerald-200 text-slate-800 font-bold text-xs border border-slate-200 transition-all cursor-pointer shrink-0">
                    <span class="material-symbols-outlined text-[18px] text-emerald-600">post_add</span>
                    <span class="whitespace-nowrap">Post Request</span>
                </button>

                <!-- List Property Free CTA -->
                <a class="inline-flex items-center justify-center gap-2 h-10 px-4 sm:px-5 rounded-full bg-gradient-to-r from-slate-950 via-slate-900 to-emerald-950 hover:from-slate-900 hover:to-emerald-900 text-white font-extrabold text-xs transition-all shadow-md hover:shadow-emerald-500/20 active:scale-95 border border-emerald-500/30" 
                   href="{{ route('host.add-property') }}">
                    <span class="material-symbols-outlined text-[17px] text-emerald-400">add_business</span>
                    <span>List Property Free</span>
                    <span class="hidden xl:inline-block px-1.5 py-0.5 rounded-full bg-emerald-500/20 text-emerald-300 text-[10px] font-black uppercase">0% Fee</span>
                </a>

                <!-- User Profile / Auth State -->
                @auth
                <div class="relative" @click.outside="userDropdownOpen = false">
                    <button type="button" 
                            @click="userDropdownOpen = !userDropdownOpen" 
                            class="flex items-center gap-2 p-1 sm:pl-2 sm:pr-3 rounded-full bg-slate-100 hover:bg-slate-200 border border-slate-200/80 transition-all cursor-pointer">
                        @if(Auth::user()->profile_photo)
                            <img alt="{{ Auth::user()->name }}" class="w-8 h-8 rounded-full object-cover ring-2 ring-emerald-500/30" src="{{ Auth::user()->profile_photo }}">
                        @else
                            <div class="w-8 h-8 rounded-full bg-slate-900 text-white flex items-center justify-center font-bold text-xs shadow-xs">
                                {{ strtoupper(substr(Auth::user()->name, 0, 2)) }}
                            </div>
                        @endif
                        <div class="hidden md:flex flex-col text-left">
                            <span class="text-xs text-slate-900 leading-tight font-bold">{{ Auth::user()->name }}</span>
                            <span class="text-[10px] text-slate-500 font-medium">{{ Auth::user()->is_admin ? 'Admin' : (Auth::user()->is_host ? 'Host' : 'Seeker') }}</span>
                        </div>
                        <span class="material-symbols-outlined text-slate-400 text-[16px] hidden sm:inline">expand_more</span>
                    </button>

                    <!-- User Dropdown Menu -->
                    <div x-show="userDropdownOpen" 
                         x-cloak
                         x-transition:enter="transition ease-out duration-200"
                         x-transition:enter-start="opacity-0 translate-y-2 scale-95"
                         x-transition:enter-end="opacity-100 translate-y-0 scale-100"
                         x-transition:leave="transition ease-in duration-150"
                         x-transition:leave-start="opacity-100 translate-y-0 scale-100"
                         x-transition:leave-end="opacity-0 translate-y-2 scale-95"
                         class="absolute right-0 top-full mt-2 w-52 rounded-2xl bg-white/95 backdrop-blur-xl border border-slate-200 shadow-2xl p-2 z-50">
                        <div class="px-3 py-2 border-b border-slate-100 mb-1">
                            <p class="text-xs font-bold text-slate-900 truncate">{{ Auth::user()->name }}</p>
                            <p class="text-[11px] text-slate-500 truncate">{{ Auth::user()->email }}</p>
                        </div>
                        @if(Auth::user()->is_admin)
                        <a href="{{ route('admin.dashboard') }}" class="flex items-center gap-2 px-3 py-2 rounded-xl text-xs font-bold text-slate-700 hover:bg-slate-100 transition-colors">
                            <span class="material-symbols-outlined text-[17px] text-slate-500">dashboard</span>
                            <span>Admin Portal</span>
                        </a>
                        <a href="{{ route('admin.properties') }}" class="flex items-center gap-2 px-3 py-2 rounded-xl text-xs font-bold text-slate-700 hover:bg-slate-100 transition-colors">
                            <span class="material-symbols-outlined text-[17px] text-slate-500">real_estate_agent</span>
                            <span>Manage Properties</span>
                        </a>
                        <a href="{{ route('admin.profile') }}" class="flex items-center gap-2 px-3 py-2 rounded-xl text-xs font-bold text-slate-700 hover:bg-slate-100 transition-colors">
                            <span class="material-symbols-outlined text-[17px] text-slate-500">account_circle</span>
                            <span>Admin Profile</span>
                        </a>
                        @else
                        <a href="{{ route('dashboard') }}" class="flex items-center gap-2 px-3 py-2 rounded-xl text-xs font-bold text-slate-700 hover:bg-slate-100 transition-colors">
                            <span class="material-symbols-outlined text-[17px] text-slate-500">dashboard</span>
                            <span>Dashboard</span>
                        </a>
                        <a href="{{ route('dashboard') }}?tab=listings" class="flex items-center gap-2 px-3 py-2 rounded-xl text-xs font-bold text-slate-700 hover:bg-slate-100 transition-colors">
                            <span class="material-symbols-outlined text-[17px] text-slate-500">real_estate_agent</span>
                            <span>My Properties</span>
                        </a>
                        <a href="{{ route('dashboard') }}?tab=settings" class="flex items-center gap-2 px-3 py-2 rounded-xl text-xs font-bold text-slate-700 hover:bg-slate-100 transition-colors">
                            <span class="material-symbols-outlined text-[17px] text-slate-500">account_circle</span>
                            <span>Profile & Settings</span>
                        </a>
                        @endif
                        <form method="POST" action="/logout" class="mt-1 pt-1 border-t border-slate-100">
                            @csrf
                            <button type="submit" class="w-full flex items-center gap-2 px-3 py-2 rounded-xl text-xs font-bold text-rose-600 hover:bg-rose-50 transition-colors text-left cursor-pointer">
                                <span class="material-symbols-outlined text-[17px] text-rose-500">logout</span>
                                <span>Sign Out</span>
                            </button>
                        </form>
                    </div>
                </div>
                @else
                <a href="/login" class="inline-flex items-center gap-1.5 text-xs font-bold text-slate-700 hover:text-emerald-700 px-3 py-2 rounded-full hover:bg-slate-100 transition-all">
                    <span class="material-symbols-outlined text-[18px]">login</span>
                    <span>Sign In</span>
                </a>
                @endauth

                <!-- Mobile Hamburger Toggle -->
                <button type="button" 
                        @click="mobileMenuOpen = !mobileMenuOpen" 
                        class="lg:hidden w-10 h-10 rounded-full bg-slate-100 hover:bg-slate-200 flex items-center justify-center text-slate-700 cursor-pointer transition-colors" 
                        aria-label="Toggle Navigation Menu">
                    <span class="material-symbols-outlined text-xl" x-text="mobileMenuOpen ? 'close' : 'menu'"></span>
                </button>
            </div>
        </div>

        <!-- Mobile Drawer / Dropdown Menu -->
        <div x-show="mobileMenuOpen" 
             x-cloak
             x-transition:enter="transition ease-out duration-300 transform"
             x-transition:enter-start="opacity-0 -translate-y-4"
             x-transition:enter-end="opacity-100 translate-y-0"
             x-transition:leave="transition ease-in duration-200 transform"
             x-transition:leave-start="opacity-100 translate-y-0"
             x-transition:leave-end="opacity-0 -translate-y-4"
             class="lg:hidden border-t border-slate-200/80 bg-white/95 backdrop-blur-2xl px-6 py-5 shadow-2xl space-y-4">
            <div class="grid grid-cols-2 gap-2">
                <a href="/buy/noida" @click="mobileMenuOpen = false" class="flex items-center gap-2 p-3 rounded-2xl bg-slate-50 hover:bg-emerald-50 text-xs font-bold text-slate-800 transition-colors">
                    <span class="material-symbols-outlined text-emerald-600 text-[20px]">real_estate_agent</span>
                    <span>Buy Properties</span>
                </a>
                <a href="/rent/noida" @click="mobileMenuOpen = false" class="flex items-center gap-2 p-3 rounded-2xl bg-slate-50 hover:bg-emerald-50 text-xs font-bold text-slate-800 transition-colors">
                    <span class="material-symbols-outlined text-emerald-600 text-[20px]">key</span>
                    <span>Rent Flats & PGs</span>
                </a>
                <a href="/explore/student_pg" @click="mobileMenuOpen = false" class="flex items-center gap-2 p-3 rounded-2xl bg-slate-50 hover:bg-emerald-50 text-xs font-bold text-slate-800 transition-colors">
                    <span class="material-symbols-outlined text-emerald-600 text-[20px]">single_bed</span>
                    <span>PG &amp; Rooms</span>
                </a>
                <a href="/explore/commercial" @click="mobileMenuOpen = false" class="flex items-center gap-2 p-3 rounded-2xl bg-slate-50 hover:bg-emerald-50 text-xs font-bold text-slate-800 transition-colors">
                    <span class="material-symbols-outlined text-emerald-600 text-[20px]">storefront</span>
                    <span>Commercial Spaces</span>
                </a>
            </div>

            <div class="flex items-center gap-2 pt-2">
                <button type="button" @click="mobileMenuOpen = false; requestModalOpen = true" class="flex-1 py-3 px-4 rounded-xl bg-slate-100 hover:bg-slate-200 text-slate-900 font-bold text-xs flex items-center justify-center gap-2 transition-colors cursor-pointer">
                    <span class="material-symbols-outlined text-base text-emerald-600">post_add</span>
                    <span>Post Request</span>
                </button>
                <a href="{{ route('host.add-property') }}" @click="mobileMenuOpen = false" class="flex-1 py-3 px-4 rounded-xl bg-slate-900 hover:bg-slate-800 text-white font-bold text-xs flex items-center justify-center gap-2 transition-colors shadow-sm">
                    <span class="material-symbols-outlined text-base text-emerald-400">add_business</span>
                    <span>List Property Free</span>
                </a>
            </div>
        </div>
    </header>

    <main class="w-full pt-20 bg-white">
        <div class="flex flex-col w-full">

            <!-- ==========================================
                 SECTION 2: IMMERSIVE HERO CAROUSEL & SEARCH
                 ========================================== -->
            @php
                $slidesList = (!empty($heroSlides) && $heroSlides->isNotEmpty()) ? $heroSlides : collect([
                    (object)[
                        'id' => 1,
                        'badge_text' => 'Near Jewar International Airport',
                        'badge_icon' => 'flight_takeoff',
                        'title' => 'Prime Plots & Residential Land near Jewar Airport',
                        'subtitle' => 'Direct Yamuna Expressway Access • Immediate Registry & Possession',
                        'highlights' => ['100% Clear Title', 'Near Jewar International Airport', 'High ROI Potential'],
                        'primary_cta_text' => 'Explore Projects',
                        'primary_cta_link' => '/buy/noida',
                        'secondary_cta_text' => 'Book Site Visit',
                        'secondary_cta_link' => 'javascript:void(0)',
                        'secondary_cta_action' => 'request_modal',
                        'image_url' => asset('images/hero/hero_jewar_airport_plots.jpg'),
                    ],
                    (object)[
                        'id' => 2,
                        'badge_text' => 'Zero Brokerage Verified Living',
                        'badge_icon' => 'verified_user',
                        'title' => 'Luxury Verified Flats in Noida & NCR',
                        'subtitle' => 'Direct Landlord Connection with Transparent Pricing',
                        'highlights' => ['0% Brokerage', 'Physical Audit Passed', 'Immediate Move-In'],
                        'primary_cta_text' => 'Explore Rentals',
                        'primary_cta_link' => '/rent/noida',
                        'secondary_cta_text' => 'Post Requirement',
                        'secondary_cta_link' => 'javascript:void(0)',
                        'secondary_cta_action' => 'request_modal',
                        'image_url' => asset('images/hero/hero_luxury_apartments.jpg'),
                    ],
                    (object)[
                        'id' => 3,
                        'badge_text' => 'Gated Township & Modern Villas',
                        'badge_icon' => 'home_work',
                        'title' => 'Prime Gated Communities & Smart Living',
                        'subtitle' => 'World-Class Amenities, Green Parks & Seamless Expressways',
                        'highlights' => ['100% Legal Ownership', 'Near Metro Expressway', 'Clubhouse & 24x7 Security'],
                        'primary_cta_text' => 'View Townships',
                        'primary_cta_link' => '/buy/noida',
                        'secondary_cta_text' => 'Schedule Visit',
                        'secondary_cta_link' => 'javascript:void(0)',
                        'secondary_cta_action' => 'request_modal',
                        'image_url' => asset('images/hero/hero_gated_villas_township.jpg'),
                    ],
                ]);
            @endphp            <section class="relative w-full bg-slate-900 overflow-hidden min-h-[580px] sm:min-h-[660px] lg:min-h-[740px] flex items-center justify-center" 
                     x-data="{
                        activeSlide: 0,
                        slidesCount: {{ $slidesList->count() }},
                        autoplayTimer: null,
                        startAutoplay() {
                            this.autoplayTimer = setInterval(() => {
                                this.next();
                            }, 5000);
                        },
                        stopAutoplay() {
                            if (this.autoplayTimer) clearInterval(this.autoplayTimer);
                        },
                        next() {
                            this.activeSlide = (this.activeSlide + 1) % this.slidesCount;
                        },
                        prev() {
                            this.activeSlide = (this.activeSlide - 1 + this.slidesCount) % this.slidesCount;
                        },
                        goTo(index) {
                            this.activeSlide = index;
                        }
                     }"
                     x-init="startAutoplay()"
                     @mouseenter="stopAutoplay()"
                     @mouseleave="startAutoplay()"
                     id="hero-carousel">
                     
                <!-- Background Horizontal Sliding Carousel Strip -->
                <div class="absolute inset-0 w-full h-full overflow-hidden pointer-events-none">
                    <div class="flex h-full w-full transition-transform duration-1000 ease-in-out will-change-transform"
                         :style="'transform: translateX(-' + (activeSlide * 100) + '%);'">
                        @foreach($slidesList as $idx => $slide)
                            <div class="relative w-full h-full flex-shrink-0">
                                <!-- Background Image -->
                                <img src="{{ is_object($slide) && method_exists($slide, 'getImageUrlAttribute') ? $slide->image_url : ($slide->image_url ?? (str_starts_with($slide->image ?? '', 'http') ? $slide->image : asset($slide->image ?? 'images/hero/hero_jewar_airport_plots.jpg'))) }}" 
                                     alt="HomiQ Hero Property Background" 
                                     class="w-full h-full object-cover object-center">

                                <!-- Reduced, Subtle Natural Dark Scrim for High Image Clarity and Natural Vibrant Colors -->
                                <div class="absolute inset-0 bg-black/25"></div>
                                <div class="absolute inset-0 bg-gradient-to-t from-black/40 via-transparent to-black/25"></div>
                            </div>
                        @endforeach
                    </div>
                </div>

                <!-- Subtle Previous / Next Navigation Arrows -->
                <button type="button" 
                        @click="prev()" 
                        class="hidden md:flex absolute left-4 lg:left-8 top-1/2 -translate-y-1/2 z-20 w-11 h-11 rounded-full bg-slate-950/40 hover:bg-emerald-500 hover:text-slate-950 text-white border border-white/20 backdrop-blur-md items-center justify-center transition-all duration-200 shadow-xl cursor-pointer" 
                        title="Previous Slide">
                    <span class="material-symbols-outlined text-2xl">chevron_left</span>
                </button>
                <button type="button" 
                        @click="next()" 
                        class="hidden md:flex absolute right-4 lg:right-8 top-1/2 -translate-y-1/2 z-20 w-11 h-11 rounded-full bg-slate-950/40 hover:bg-emerald-500 hover:text-slate-950 text-white border border-white/20 backdrop-blur-md items-center justify-center transition-all duration-200 shadow-xl cursor-pointer" 
                        title="Next Slide">
                    <span class="material-symbols-outlined text-2xl">chevron_right</span>
                </button>

                <!-- Centered Search Bar Container in Hero Section -->
                <div id="hero-search" class="relative z-30 max-w-5xl w-full mx-auto px-4 sm:px-6 py-12 text-left" x-data="{
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
                    <!-- Top 4 Primary Pillars -->
                    <div class="flex items-center justify-center gap-2 mb-4 flex-wrap">
                        <button type="button" @click="setPillar('rent')" :class="activePillar === 'rent' ? 'bg-emerald-500 text-slate-950 font-black shadow-lg ring-2 ring-emerald-400/50 scale-105' : 'bg-slate-950/70 backdrop-blur-md text-white hover:bg-slate-900 border border-white/20 shadow-sm'" class="h-10 sm:h-11 px-5 sm:px-6 rounded-full text-xs sm:text-sm font-bold transition-all cursor-pointer flex items-center justify-center gap-1.5">
                            <span class="material-symbols-outlined text-[18px]">key</span>
                            <span>Rent</span>
                        </button>
                        <button type="button" @click="setPillar('buy')" :class="activePillar === 'buy' ? 'bg-emerald-500 text-slate-950 font-black shadow-lg ring-2 ring-emerald-400/50 scale-105' : 'bg-slate-950/70 backdrop-blur-md text-white hover:bg-slate-900 border border-white/20 shadow-sm'" class="h-10 sm:h-11 px-5 sm:px-6 rounded-full text-xs sm:text-sm font-bold transition-all cursor-pointer flex items-center justify-center gap-1.5">
                            <span class="material-symbols-outlined text-[18px]">real_estate_agent</span>
                            <span>Buy</span>
                        </button>
                        <button type="button" @click="setPillar('pg')" :class="activePillar === 'pg' ? 'bg-emerald-500 text-slate-950 font-black shadow-lg ring-2 ring-emerald-400/50 scale-105' : 'bg-slate-950/70 backdrop-blur-md text-white hover:bg-slate-900 border border-white/20 shadow-sm'" class="h-10 sm:h-11 px-5 sm:px-6 rounded-full text-xs sm:text-sm font-bold transition-all cursor-pointer flex items-center justify-center gap-1.5">
                            <span class="material-symbols-outlined text-[18px]">single_bed</span>
                            <span>PG / Rooms</span>
                        </button>
                        <button type="button" @click="setPillar('commercial')" :class="activePillar === 'commercial' ? 'bg-emerald-500 text-slate-950 font-black shadow-lg ring-2 ring-emerald-400/50 scale-105' : 'bg-slate-950/70 backdrop-blur-md text-white hover:bg-slate-900 border border-white/20 shadow-sm'" class="h-10 sm:h-11 px-5 sm:px-6 rounded-full text-xs sm:text-sm font-bold transition-all cursor-pointer flex items-center justify-center gap-1.5">
                            <span class="material-symbols-outlined text-[18px]">storefront</span>
                            <span>Commercial</span>
                        </button>
                    </div>

                    <!-- Modern Unified Search Bar -->
                    <form action="/#listings" method="GET" id="search-form" class="bg-white rounded-3xl md:rounded-full border border-slate-200/90 shadow-2xl p-2.5 flex flex-col md:flex-row items-stretch md:items-center">
                        <input type="hidden" name="listing_type" id="listing-type-hidden" value="{{ request('listing_type', 'rent') }}">
                        <input type="hidden" name="search_type" id="search-type-hidden" value="{{ request('search_type', '') }}">

                        <!-- 1. Location Input -->
                        <div class="flex-[1.4] px-4 sm:px-5 py-2.5 rounded-2xl md:rounded-l-full hover:bg-slate-50 focus-within:bg-slate-50 transition-colors">
                            <label for="search-input" class="block text-[10px] font-bold uppercase tracking-wider text-slate-400 mb-0.5">Location or Keyword</label>
                            <div class="flex items-center gap-2">
                                <span class="material-symbols-outlined text-slate-400 text-[18px] shrink-0">location_on</span>
                                <input id="search-input" name="search" type="text" class="w-full bg-transparent text-sm font-semibold text-slate-900 border-0 focus:border-0 focus:ring-0 outline-none p-0 placeholder-slate-400" placeholder="e.g. Near Jewar Airport, Sector 137, Noida..." value="{{ request('search', '') }}">
                            </div>
                        </div>

                        <!-- 2. Property Type Dropdown -->
                        <div class="w-full md:w-48 lg:w-52 px-4 py-2.5 rounded-2xl hover:bg-slate-50 focus-within:bg-slate-50 transition-colors border-t md:border-t-0 md:border-l border-slate-200">
                            <label for="type-select" class="block text-[10px] font-bold uppercase tracking-wider text-slate-400 mb-0.5">Property Type</label>
                            <div class="flex items-center gap-2">
                                <span class="material-symbols-outlined text-slate-400 text-[18px] shrink-0">apartment</span>
                                <select id="type-select" onchange="document.getElementById('search-type-hidden').value = this.value" class="w-full bg-transparent text-sm font-semibold text-slate-900 border-0 focus:border-0 focus:ring-0 outline-none p-0 cursor-pointer">
                                    <option value="">All Types</option>
                                    <option value="Apartment" {{ request('search_type') === 'Apartment' ? 'selected' : '' }}>Apartments</option>
                                    <option value="House" {{ request('search_type') === 'House' ? 'selected' : '' }}>Houses &amp; Villas</option>
                                    <option value="Plot" {{ request('search_type') === 'Plot' ? 'selected' : '' }}>Plots &amp; Land</option>
                                    <option value="Studio" {{ request('search_type') === 'Studio' ? 'selected' : '' }}>PGs &amp; Rooms</option>
                                    <option value="Shop" {{ request('search_type') === 'Shop' ? 'selected' : '' }}>Commercial</option>
                                </select>
                            </div>
                        </div>

                        <!-- 3. Bedrooms Dropdown -->
                        <div class="w-full md:w-36 px-4 py-2.5 rounded-2xl hover:bg-slate-50 focus-within:bg-slate-50 transition-colors border-t md:border-t-0 md:border-l border-slate-200">
                            <label for="bedrooms-select" class="block text-[10px] font-bold uppercase tracking-wider text-slate-400 mb-0.5">Bedrooms</label>
                            <div class="flex items-center gap-1.5">
                                <span class="material-symbols-outlined text-slate-400 text-[18px] shrink-0">bed</span>
                                <select id="bedrooms-select" name="bedrooms" class="w-full bg-transparent text-sm font-semibold text-slate-900 border-0 focus:border-0 focus:ring-0 outline-none p-0 cursor-pointer">
                                    <option value="all">Any BHK</option>
                                    <option value="1" {{ request('bedrooms') === '1' ? 'selected' : '' }}>1 BHK</option>
                                    <option value="2" {{ request('bedrooms') === '2' ? 'selected' : '' }}>2 BHK</option>
                                    <option value="3" {{ request('bedrooms') === '3' ? 'selected' : '' }}>3+ BHK</option>
                                </select>
                            </div>
                        </div>

                        <!-- 4. Budget Dropdown -->
                        <div class="w-full md:w-44 px-4 py-2.5 rounded-2xl hover:bg-slate-50 focus-within:bg-slate-50 transition-colors border-t md:border-t-0 md:border-l border-slate-200">
                            <label for="budget-select" class="block text-[10px] font-bold uppercase tracking-wider text-slate-400 mb-0.5">Budget</label>
                            <div class="flex items-center gap-1.5">
                                <span class="material-symbols-outlined text-slate-400 text-[18px] shrink-0">payments</span>
                                <select id="budget-select" name="max_price" class="w-full bg-transparent text-sm font-semibold text-slate-900 border-0 focus:border-0 focus:ring-0 outline-none p-0 cursor-pointer">
                                    <option value="">Any Budget</option>
                                    <option value="15000" {{ request('max_price') == '15000' ? 'selected' : '' }}>Under ₹15,000</option>
                                    <option value="25000" {{ request('max_price') == '25000' ? 'selected' : '' }}>Under ₹25,000</option>
                                    <option value="40000" {{ request('max_price') == '40000' ? 'selected' : '' }}>Under ₹40,000</option>
                                    <option value="60000" {{ request('max_price') == '60000' ? 'selected' : '' }}>Under ₹60,000</option>
                                    <option value="100000" {{ request('max_price') == '100000' ? 'selected' : '' }}>Under ₹1,00,000</option>
                                    <option value="15000000" {{ request('max_price') == '15000000' ? 'selected' : '' }}>Under ₹1.5 Cr (Sale)</option>
                                </select>
                            </div>
                        </div>

                        <!-- 5. Search Button -->
                        <div class="p-1 flex items-center justify-center gap-1.5 shrink-0">
                            <button type="button" @click="filtersModalOpen = true" class="h-11 px-4 rounded-full bg-slate-100 hover:bg-slate-200 text-slate-700 font-bold text-xs flex items-center justify-center gap-1 border border-slate-200 transition-colors cursor-pointer" title="More Filters">
                                <span class="material-symbols-outlined text-[18px] text-slate-500">tune</span>
                                <span class="hidden xl:inline">Filters</span>
                            </button>
                            <button type="submit" class="w-full md:w-auto h-11 px-7 rounded-full bg-emerald-500 hover:bg-emerald-400 text-slate-950 font-black text-xs sm:text-sm flex items-center justify-center gap-1.5 shadow-md transition-all active:scale-98 cursor-pointer shrink-0">
                                <span class="material-symbols-outlined text-[18px]">search</span>
                                <span>Search</span>
                            </button>
                        </div>
                    </form>

                    <!-- Contextual Quick Pills -->
                    <div class="flex items-center justify-center gap-2 mt-4 flex-wrap">
                        <span class="text-[11px] font-semibold text-slate-300 drop-shadow">Quick links:</span>
                        <template x-for="sub in subCategories[activePillar]" :key="sub.label">
                            <a :href="'/?listing_type=' + (activePillar === 'buy' ? 'sale' : (activePillar === 'commercial' ? '' : 'rent')) + (sub.type ? '&search_type=' + encodeURIComponent(sub.type) : '') + '#listings'" 
                               class="h-7 px-3 rounded-full bg-slate-900/80 hover:bg-slate-800 text-slate-200 hover:text-white border border-white/15 backdrop-blur-md text-[11px] font-medium transition-colors flex items-center justify-center shadow-xs">
                                <span x-text="sub.label"></span>
                            </a>
                        </template>
                    </div>
                </div>

                <!-- Indicators / Dots (Bottom Center) -->
                <div class="absolute bottom-4 left-1/2 -translate-x-1/2 z-20 flex items-center gap-2 px-3 py-1 rounded-full bg-black/40 backdrop-blur-md border border-white/10">
                    <template x-for="idx in slidesCount" :key="idx">
                        <button type="button" 
                                @click="goTo(idx - 1)"
                                :class="activeSlide === (idx - 1) ? 'w-6 bg-emerald-400' : 'w-2 bg-white/40 hover:bg-white/80'"
                                class="h-2 rounded-full transition-all duration-300 cursor-pointer" 
                                :title="'Go to slide ' + idx">
                        </button>
                    </template>
                </div>

            </section>

            <!-- ==========================================
                 SECTION 3: POPULAR LOCATIONS
                 ========================================== -->
            <section class="max-w-[1440px] mx-auto px-6 sm:px-8 py-14 w-full" id="popular-locations">
                <div class="flex flex-col md:flex-row md:items-end justify-between gap-4 mb-8">
                    <div>
                        <h2 class="text-2xl sm:text-3xl font-extrabold text-slate-900 tracking-tight">Popular Locations</h2>
                        <p class="text-sm text-slate-500 mt-1">Verified flats, rooms, and PGs across premier residential corridors.</p>
                    </div>
                    <div class="flex items-center gap-2">
                        <a href="/rent/noida" class="text-xs font-bold text-slate-700 hover:text-slate-900 flex items-center gap-1">
                            <span>View all locations</span>
                            <span class="material-symbols-outlined text-xs">arrow_forward</span>
                        </a>
                    </div>
                </div>

                <!-- 5-City High-Impact Grid -->
                <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-5 gap-4 sm:gap-6">
                    <!-- City 1: Noida -->
                    <a href="/rent/noida" class="group relative rounded-3xl overflow-hidden aspect-[4/5] bg-slate-900 border border-slate-200 shadow-sm hover:shadow-md transition-all duration-300 block">
                        <img alt="Noida Expressway & Sector 137" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500 ease-out" src="https://images.unsplash.com/photo-1545324418-cc1a3fa10c00?auto=format&fit=crop&w=600&q=80">
                        <div class="absolute inset-0 bg-gradient-to-t from-slate-950/80 via-slate-950/20 to-transparent"></div>
                        <div class="absolute top-3 left-3">
                            <span class="px-2.5 py-0.5 rounded-full bg-slate-950/70 backdrop-blur-md text-white text-[10px] font-bold uppercase tracking-wider border border-white/10">Top Verified</span>
                        </div>
                        <div class="absolute bottom-4 left-4 right-4 text-white">
                            <h3 class="text-base font-bold tracking-tight leading-tight">Noida</h3>
                            <p class="text-[11px] text-slate-300 mt-0.5 font-normal">Sec 137, 62, 75, 128</p>
                        </div>
                    </a>

                    <!-- City 2: Delhi -->
                    <a href="/?city=Delhi#listings" class="group relative rounded-3xl overflow-hidden aspect-[4/5] bg-slate-900 border border-slate-200 shadow-sm hover:shadow-md transition-all duration-300 block">
                        <img alt="Delhi NCR Homes" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500 ease-out" src="https://images.unsplash.com/photo-1587474260584-136574528ed5?auto=format&fit=crop&w=600&q=80">
                        <div class="absolute inset-0 bg-gradient-to-t from-slate-950/80 via-slate-950/20 to-transparent"></div>
                        <div class="absolute top-3 left-3">
                            <span class="px-2.5 py-0.5 rounded-full bg-slate-950/70 backdrop-blur-md text-white text-[10px] font-bold uppercase tracking-wider border border-white/10">Capital NCR</span>
                        </div>
                        <div class="absolute bottom-4 left-4 right-4 text-white">
                            <h3 class="text-base font-bold tracking-tight leading-tight">Delhi</h3>
                            <p class="text-[11px] text-slate-300 mt-0.5 font-normal">South Delhi, Saket, Rohini</p>
                        </div>
                    </a>

                    <!-- City 3: Gurugram -->
                    <a href="/rent/gurugram" class="group relative rounded-3xl overflow-hidden aspect-[4/5] bg-slate-900 border border-slate-200 shadow-sm hover:shadow-md transition-all duration-300 block">
                        <img alt="Gurugram Cyber Hub" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500 ease-out" src="https://images.unsplash.com/photo-1512917774080-9991f1c4c750?auto=format&fit=crop&w=600&q=80">
                        <div class="absolute inset-0 bg-gradient-to-t from-slate-950/80 via-slate-950/20 to-transparent"></div>
                        <div class="absolute top-3 left-3">
                            <span class="px-2.5 py-0.5 rounded-full bg-slate-950/70 backdrop-blur-md text-white text-[10px] font-bold uppercase tracking-wider border border-white/10">Tech Hub</span>
                        </div>
                        <div class="absolute bottom-4 left-4 right-4 text-white">
                            <h3 class="text-base font-bold tracking-tight leading-tight">Gurugram</h3>
                            <p class="text-[11px] text-slate-300 mt-0.5 font-normal">Cyber City, Golf Course Rd</p>
                        </div>
                    </a>

                    <!-- City 4: Bangalore -->
                    <a href="/rent/bangalore" class="group relative rounded-3xl overflow-hidden aspect-[4/5] bg-slate-900 border border-slate-200 shadow-sm hover:shadow-md transition-all duration-300 block">
                        <img alt="Bangalore Startup Hub" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500 ease-out" src="https://images.unsplash.com/photo-1596176530529-78163a4f7af2?auto=format&fit=crop&w=600&q=80">
                        <div class="absolute inset-0 bg-gradient-to-t from-slate-950/80 via-slate-950/20 to-transparent"></div>
                        <div class="absolute top-3 left-3">
                            <span class="px-2.5 py-0.5 rounded-full bg-slate-950/70 backdrop-blur-md text-white text-[10px] font-bold uppercase tracking-wider border border-white/10">Silicon Valley</span>
                        </div>
                        <div class="absolute bottom-4 left-4 right-4 text-white">
                            <h3 class="text-base font-bold tracking-tight leading-tight">Bangalore</h3>
                            <p class="text-[11px] text-slate-300 mt-0.5 font-normal">HSR, Koramangala, Indiranagar</p>
                        </div>
                    </a>

                    <!-- City 5: Pune -->
                    <a href="/rent/pune" class="group relative rounded-3xl overflow-hidden aspect-[4/5] bg-slate-900 border border-slate-200 shadow-sm hover:shadow-md transition-all duration-300 block col-span-2 sm:col-span-1">
                        <img alt="Pune IT & Education Hub" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500 ease-out" src="https://images.unsplash.com/photo-1600585154340-be6161a56a0c?auto=format&fit=crop&w=600&q=80">
                        <div class="absolute inset-0 bg-gradient-to-t from-slate-950/80 via-slate-950/20 to-transparent"></div>
                        <div class="absolute top-3 left-3">
                            <span class="px-2.5 py-0.5 rounded-full bg-slate-950/70 backdrop-blur-md text-white text-[10px] font-bold uppercase tracking-wider border border-white/10">IT Corridor</span>
                        </div>
                        <div class="absolute bottom-4 left-4 right-4 text-white">
                            <h3 class="text-base font-bold tracking-tight leading-tight">Pune</h3>
                            <p class="text-[11px] text-slate-300 mt-0.5 font-normal">Viman Nagar, Kharadi, Hinjewadi</p>
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
                            <span class="material-symbols-outlined text-[16px] text-emerald-600">verified</span>
                            Active Verified Inventory:
                        </span>
                        @foreach($curatedCollections as $col)
                            @php
                                $isColActive = ($collection === $col['collection']) || (empty($collection) && $col['collection'] === null);
                            @endphp
                            <a href="{{ request()->fullUrlWithQuery(['collection' => $col['collection']]) }}#listings"
                               class="h-9 px-4 rounded-full text-xs font-semibold whitespace-nowrap transition-all flex items-center gap-1.5 shrink-0 {{ $isColActive ? 'bg-slate-900 text-white shadow-xs' : 'bg-white text-slate-700 hover:bg-slate-100 border border-slate-200' }}">
                                <span class="material-symbols-outlined text-[15px] {{ $isColActive ? 'text-white' : 'text-slate-400' }}">{{ $col['icon'] }}</span>
                                <span>{{ $col['label'] }}</span>
                            </a>
                        @endforeach
                    </div>
                </div>

                <!-- 2. Location-First City Selection Tabs -->
                <div class="mb-6">
                    <div class="flex items-center gap-2 overflow-x-auto no-scrollbar pb-1">
                        <span class="text-xs uppercase font-bold tracking-wider text-slate-400 shrink-0 mr-1 flex items-center gap-1">
                            <span class="material-symbols-outlined text-[15px] text-slate-400">location_on</span>
                            City:
                        </span>
                        @foreach($availableCities as $c)
                            @php
                                $isCityActive = (strtolower($selectedCity ?? 'All') === strtolower($c)) || ($c === 'All Cities' && (empty($selectedCity) || in_array(strtolower($selectedCity), ['all', 'all cities'])));
                                $cityParam = ($c === 'All Cities') ? null : $c;
                            @endphp
                            <a href="{{ request()->fullUrlWithQuery(['city' => $cityParam, 'locality' => null]) }}#listings"
                               class="h-9 px-4 rounded-full text-xs font-semibold whitespace-nowrap transition-all flex items-center justify-center shrink-0 {{ $isCityActive ? 'bg-slate-900 text-white shadow-xs' : 'bg-white text-slate-700 hover:bg-slate-100 border border-slate-200' }}">
                                {{ $c }}
                            </a>
                        @endforeach
                    </div>

                    <!-- Micro-Market Quick Hubs for Noida / NCR -->
                    @if(empty($selectedCity) || in_array(strtolower($selectedCity), ['all', 'all cities', 'noida', 'greater noida']))
                    <div class="flex items-center gap-1.5 overflow-x-auto no-scrollbar pb-1 mt-2.5">
                        <span class="text-[11px] uppercase font-bold tracking-wider text-slate-400 shrink-0 mr-1 flex items-center gap-1">
                            <span class="material-symbols-outlined text-[13px] text-slate-400">near_me</span>
                            Hubs:
                        </span>
                        @foreach($noidaMicroMarkets as $micro)
                            @php
                                $isMicroActive = request('locality') === $micro || request('search') === $micro;
                            @endphp
                            <a href="{{ request()->fullUrlWithQuery(['locality' => $micro, 'city' => 'Noida']) }}#listings"
                               class="h-7 px-3 rounded-full text-[11px] font-medium whitespace-nowrap transition-colors flex items-center justify-center shrink-0 {{ $isMicroActive ? 'bg-slate-900 text-white' : 'bg-white text-slate-600 hover:bg-slate-100 border border-slate-200' }}">
                                {{ $micro }}
                            </a>
                        @endforeach
                    </div>
                    @endif
                </div>

                <!-- Section Header with Dynamic Collection Title -->
                <div class="flex flex-col md:flex-row md:items-end justify-between gap-6 mb-8 pt-2">
                    <div>
                        <h2 class="text-2xl sm:text-3xl font-extrabold text-slate-900 tracking-tight flex items-center gap-3">
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
                                <span>Verified Properties</span>
                            @endif
                            <span class="text-sm font-semibold text-slate-400 whitespace-nowrap">({{ $properties->count() }} {{ $properties->count() === 1 ? 'listing' : 'listings' }})</span>
                        </h2>
                        <p class="text-sm text-slate-500 mt-1">100% on-site verified flats, rooms, and PGs with 0% brokerage.</p>
                    </div>

                    <!-- Filter Triggers, Map/List Toggle & Share Search Button -->
                    <div class="flex items-center gap-2 flex-wrap">
                        <!-- Map / List View Toggle -->
                        <div class="inline-flex p-1 bg-slate-100 rounded-full border border-slate-200">
                            <button type="button" @click="viewMode = 'list'" :class="viewMode === 'list' ? 'bg-white text-slate-900 shadow-2xs font-bold' : 'text-slate-600 font-semibold'" class="px-3.5 py-1 rounded-full text-xs flex items-center gap-1.5 transition cursor-pointer">
                                <span class="material-symbols-outlined text-[15px]">view_agenda</span>
                                <span>List</span>
                            </button>
                            <button type="button" @click="viewMode = 'map'" :class="viewMode === 'map' ? 'bg-white text-slate-900 shadow-2xs font-bold' : 'text-slate-600 font-semibold'" class="px-3.5 py-1 rounded-full text-xs flex items-center gap-1.5 transition cursor-pointer">
                                <span class="material-symbols-outlined text-[15px]">map</span>
                                <span>Map</span>
                            </button>
                        </div>

                        <button type="button" @click="filtersModalOpen = true" class="inline-flex items-center gap-1.5 h-9 px-4 rounded-full bg-white hover:bg-slate-100 text-slate-700 text-xs font-semibold border border-slate-200 transition-colors cursor-pointer">
                            <span class="material-symbols-outlined text-[16px] text-slate-500">tune</span>
                            <span>Filters</span>
                        </button>

                        <button type="button" onclick="shareCurrentSearch()" class="inline-flex items-center gap-1.5 h-9 px-4 rounded-full bg-white hover:bg-slate-100 text-slate-700 text-xs font-semibold border border-slate-200 transition-colors cursor-pointer" title="Share search">
                            <span class="material-symbols-outlined text-[16px] text-slate-500">share</span>
                            <span class="hidden sm:inline">Share</span>
                        </button>

                        <button type="button" @click="saveSearchModalOpen = true" class="inline-flex items-center gap-1.5 h-9 px-4 rounded-full bg-slate-900 hover:bg-slate-800 text-white text-xs font-bold transition-all shadow-xs cursor-pointer">
                            <span class="material-symbols-outlined text-[16px]">notifications_active</span>
                            <span>Save Search</span>
                        </button>
                    </div>
                </div>

                <!-- Map View Container -->
                <div x-show="viewMode === 'map'" x-cloak class="mb-10 rounded-3xl overflow-hidden border border-slate-200 shadow-sm h-[440px] bg-slate-100 relative">
                    <iframe 
                        title="Properties Location Map"
                        class="w-full h-full border-0"
                        loading="lazy" 
                        src="https://maps.google.com/maps?q={{ urlencode(($selectedCity ?? 'Noida') . ' India') }}&t=&z=12&ie=UTF8&iwloc=&output=embed">
                    </iframe>
                    <div class="absolute top-4 right-4 bg-white/95 backdrop-blur-md px-3.5 py-1.5 rounded-full shadow-sm border border-slate-200 text-xs font-semibold text-slate-800 flex items-center gap-2">
                        <span class="w-2 h-2 rounded-full bg-emerald-500"></span>
                        <span>Verified coordinates in {{ $selectedCity ?? 'Noida' }}</span>
                    </div>
                </div>

                <!-- Verified Property Grid (List View) -->
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6 sm:gap-8" id="properties-grid">
                    @forelse($properties as $property)
                        <x-property-card :property="$property" />
                    @empty
                    <div class="col-span-full py-16 px-6 text-center bg-slate-50 rounded-3xl border border-dashed border-slate-200">
                        <div class="h-14 w-14 rounded-full bg-slate-100 text-slate-400 mx-auto flex items-center justify-center mb-3">
                            <span class="material-symbols-outlined text-2xl">search_off</span>
                        </div>
                        <h3 class="text-lg font-bold text-slate-900 mb-1">No matching properties found</h3>
                        <p class="text-xs text-slate-500 max-w-sm mx-auto mb-5 font-normal">Try broadening your budget, city, or property type filters.</p>
                        <div class="flex items-center justify-center gap-3 flex-wrap">
                            <a href="/#listings" class="h-10 px-5 rounded-full bg-slate-900 text-white text-xs font-bold hover:bg-slate-800 transition flex items-center gap-1.5 shadow-xs">
                                <span class="material-symbols-outlined text-sm">refresh</span>
                                <span>Reset Filters</span>
                            </a>
                            <button type="button" @click="requestModalOpen = true" class="h-10 px-5 rounded-full bg-white text-slate-800 text-xs font-bold hover:bg-slate-100 border border-slate-200 transition flex items-center gap-1.5 cursor-pointer">
                                <span class="material-symbols-outlined text-sm">post_add</span>
                                <span>Post Request</span>
                            </button>
                        </div>
                    </div>
                    @endforelse
                </div>
            </section>

            @if(isset($recentlyViewedProperties) && $recentlyViewedProperties->isNotEmpty())
            <!-- RECENTLY VIEWED PROPERTIES -->
            <section class="max-w-[1440px] mx-auto px-6 sm:px-8 mb-14 w-full">
                <div class="p-6 sm:p-8 rounded-3xl bg-white border border-slate-200">
                    <div class="flex items-center justify-between mb-6 flex-wrap gap-4">
                        <div>
                            <h2 class="text-xl sm:text-2xl font-bold text-slate-900 tracking-tight">Recently Viewed Properties</h2>
                            <p class="text-xs text-slate-500 mt-0.5">Quickly revisit flats and rooms you previously explored.</p>
                        </div>

                        <form action="{{ route('recently-viewed.clear') }}" method="POST">
                            @csrf
                            <button type="submit" class="px-3.5 py-1.5 rounded-full border border-slate-200 hover:bg-slate-50 bg-white text-slate-600 text-xs font-semibold transition flex items-center gap-1 cursor-pointer">
                                <span class="material-symbols-outlined text-xs text-slate-400">delete_sweep</span>
                                <span>Clear</span>
                            </button>
                        </form>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6 sm:gap-8">
                        @foreach($recentlyViewedProperties->take(3) as $property)
                            <x-property-card :property="$property" />
                        @endforeach
                    </div>
                </div>
            </section>
            @endif

            <!-- ==========================================
                 SECTION 5: BROWSE BY NEED
                 ========================================== -->
            <section class="max-w-[1440px] mx-auto px-6 sm:px-8 py-14 w-full" id="browse-by-need">
                <div class="text-center max-w-xl mx-auto mb-10">
                    <h2 class="text-2xl sm:text-3xl font-extrabold text-slate-900 tracking-tight">Browse by Need</h2>
                    <p class="text-sm text-slate-500 mt-1">Find the exact living space suited to your preferences.</p>
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-5 gap-4 sm:gap-6">
                    <!-- Need 1: Flats & Apartments -->
                    <a href="/category/Apartment" class="group rounded-3xl bg-white p-6 border border-slate-200 hover:border-slate-400 hover:shadow-md transition-all duration-300 flex flex-col justify-between">
                        <div>
                            <div class="w-11 h-11 rounded-2xl bg-slate-100 text-slate-800 flex items-center justify-center mb-4 group-hover:bg-slate-900 group-hover:text-white transition-colors">
                                <span class="material-symbols-outlined text-[22px]">apartment</span>
                            </div>
                            <h3 class="text-base font-bold text-slate-900 mb-1 group-hover:text-slate-900">Flats</h3>
                            <p class="text-xs text-slate-500 leading-relaxed font-normal">1, 2, 3 &amp; 4 BHK society apartments with amenities.</p>
                        </div>
                        <div class="mt-5 pt-3 border-t border-slate-100 flex items-center justify-between text-xs font-semibold text-slate-700">
                            <span>Browse Flats</span>
                            <span class="material-symbols-outlined text-sm group-hover:translate-x-1 transition-transform">arrow_forward</span>
                        </div>
                    </a>

                    <!-- Need 2: PGs & Co-Living -->
                    <a href="/explore/student_pg" class="group rounded-3xl bg-white p-6 border border-slate-200 hover:border-slate-400 hover:shadow-md transition-all duration-300 flex flex-col justify-between">
                        <div>
                            <div class="w-11 h-11 rounded-2xl bg-slate-100 text-slate-800 flex items-center justify-center mb-4 group-hover:bg-slate-900 group-hover:text-white transition-colors">
                                <span class="material-symbols-outlined text-[22px]">single_bed</span>
                            </div>
                            <h3 class="text-base font-bold text-slate-900 mb-1 group-hover:text-slate-900">PGs</h3>
                            <p class="text-xs text-slate-500 leading-relaxed font-normal">Furnished student &amp; professional PGs with meals &amp; WiFi.</p>
                        </div>
                        <div class="mt-5 pt-3 border-t border-slate-100 flex items-center justify-between text-xs font-semibold text-slate-700">
                            <span>Browse PGs</span>
                            <span class="material-symbols-outlined text-sm group-hover:translate-x-1 transition-transform">arrow_forward</span>
                        </div>
                    </a>

                    <!-- Need 3: Private Rooms & Studios -->
                    <a href="/category/Studio" class="group rounded-3xl bg-white p-6 border border-slate-200 hover:border-slate-400 hover:shadow-md transition-all duration-300 flex flex-col justify-between">
                        <div>
                            <div class="w-11 h-11 rounded-2xl bg-slate-100 text-slate-800 flex items-center justify-center mb-4 group-hover:bg-slate-900 group-hover:text-white transition-colors">
                                <span class="material-symbols-outlined text-[22px]">hotel</span>
                            </div>
                            <h3 class="text-base font-bold text-slate-900 mb-1 group-hover:text-slate-900">Rooms</h3>
                            <p class="text-xs text-slate-500 leading-relaxed font-normal">Private single rooms, 1RKs &amp; independent studio units.</p>
                        </div>
                        <div class="mt-5 pt-3 border-t border-slate-100 flex items-center justify-between text-xs font-semibold text-slate-700">
                            <span>Browse Rooms</span>
                            <span class="material-symbols-outlined text-sm group-hover:translate-x-1 transition-transform">arrow_forward</span>
                        </div>
                    </a>

                    <!-- Need 4: Houses & Independent Villas -->
                    <a href="/category/Villa" class="group rounded-3xl bg-white p-6 border border-slate-200 hover:border-slate-400 hover:shadow-md transition-all duration-300 flex flex-col justify-between">
                        <div>
                            <div class="w-11 h-11 rounded-2xl bg-slate-100 text-slate-800 flex items-center justify-center mb-4 group-hover:bg-slate-900 group-hover:text-white transition-colors">
                                <span class="material-symbols-outlined text-[22px]">villa</span>
                            </div>
                            <h3 class="text-base font-bold text-slate-900 mb-1 group-hover:text-slate-900">Houses</h3>
                            <p class="text-xs text-slate-500 leading-relaxed font-normal">Independent builder floors, villas &amp; family homes.</p>
                        </div>
                        <div class="mt-5 pt-3 border-t border-slate-100 flex items-center justify-between text-xs font-semibold text-slate-700">
                            <span>Browse Houses</span>
                            <span class="material-symbols-outlined text-sm group-hover:translate-x-1 transition-transform">arrow_forward</span>
                        </div>
                    </a>

                    <!-- Need 5: Commercial Spaces -->
                    <a href="/explore/commercial" class="group rounded-3xl bg-white p-6 border border-slate-200 hover:border-slate-400 hover:shadow-md transition-all duration-300 flex flex-col justify-between">
                        <div>
                            <div class="w-11 h-11 rounded-2xl bg-slate-100 text-slate-800 flex items-center justify-center mb-4 group-hover:bg-slate-900 group-hover:text-white transition-colors">
                                <span class="material-symbols-outlined text-[22px]">storefront</span>
                            </div>
                            <h3 class="text-base font-bold text-slate-900 mb-1 group-hover:text-slate-900">Commercial</h3>
                            <p class="text-xs text-slate-500 leading-relaxed font-normal">Retail shops, offices, warehouses &amp; showroom spaces.</p>
                        </div>
                        <div class="mt-5 pt-3 border-t border-slate-100 flex items-center justify-between text-xs font-semibold text-slate-700">
                            <span>Browse Commercial</span>
                            <span class="material-symbols-outlined text-sm group-hover:translate-x-1 transition-transform">arrow_forward</span>
                        </div>
                    </a>
                </div>
            </section>

            <!-- ==========================================
                 SECTION 6: WHY HOMIQ?
                 ========================================== -->
            <section class="w-full bg-slate-50 border-y border-slate-200/80 py-16" id="why-homiq">
                <div class="max-w-[1440px] mx-auto px-6 sm:px-8">
                    <div class="text-center max-w-xl mx-auto mb-12">
                        <div class="inline-flex items-center gap-1.5 text-slate-500 font-bold text-xs uppercase tracking-wider mb-2">
                            <span class="material-symbols-outlined text-[16px]">shield</span>
                            Why HomiQ?
                        </div>
                        <h2 class="text-2xl sm:text-3xl font-extrabold text-slate-900 tracking-tight">Built for zero-brokerage renting</h2>
                        <p class="text-sm text-slate-500 mt-1">Direct owner contact and verified inventory without middleman fees.</p>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
                        <!-- Pillar 1: Verified -->
                        <div class="rounded-3xl bg-white p-7 border border-slate-200 shadow-xs flex flex-col justify-between">
                            <div>
                                <div class="w-11 h-11 rounded-2xl bg-slate-100 text-slate-800 flex items-center justify-center mb-4 border border-slate-200">
                                    <span class="material-symbols-outlined text-[22px]">verified</span>
                                </div>
                                <h3 class="text-base font-bold text-slate-900 tracking-tight mb-1.5">100% On-Site Verified</h3>
                                <p class="text-xs leading-relaxed text-slate-500 font-normal">Every listing undergoes geo-location audit and physical photo inspection before going live.</p>
                            </div>
                            <div class="mt-5 pt-3 border-t border-slate-100 flex items-center gap-1.5 text-xs font-semibold text-slate-700">
                                <span class="material-symbols-outlined text-[15px] text-emerald-600">check_circle</span>
                                <span>Zero fake listings</span>
                            </div>
                        </div>

                        <!-- Pillar 2: Direct Owner -->
                        <div class="rounded-3xl bg-white p-7 border border-slate-200 shadow-xs flex flex-col justify-between">
                            <div>
                                <div class="w-11 h-11 rounded-2xl bg-slate-100 text-slate-800 flex items-center justify-center mb-4 border border-slate-200">
                                    <span class="material-symbols-outlined text-[22px]">chat</span>
                                </div>
                                <h3 class="text-base font-bold text-slate-900 tracking-tight mb-1.5">Direct Owner Contact</h3>
                                <p class="text-xs leading-relaxed text-slate-500 font-normal">Message landlords directly through in-app chat or WhatsApp. No broker interference.</p>
                            </div>
                            <div class="mt-5 pt-3 border-t border-slate-100 flex items-center gap-1.5 text-xs font-semibold text-slate-700">
                                <span class="material-symbols-outlined text-[15px] text-emerald-600">check_circle</span>
                                <span>Direct communication</span>
                            </div>
                        </div>

                        <!-- Pillar 3: Zero Brokerage -->
                        <div class="rounded-3xl bg-white p-7 border border-slate-200 shadow-xs flex flex-col justify-between">
                            <div>
                                <div class="w-11 h-11 rounded-2xl bg-slate-100 text-slate-800 flex items-center justify-center mb-4 border border-slate-200">
                                    <span class="material-symbols-outlined text-[22px]">savings</span>
                                </div>
                                <h3 class="text-base font-bold text-slate-900 tracking-tight mb-1.5">Zero Brokerage</h3>
                                <p class="text-xs leading-relaxed text-slate-500 font-normal">Save up to one full month's rent on unnecessary middleman commissions.</p>
                            </div>
                            <div class="mt-5 pt-3 border-t border-slate-100 flex items-center gap-1.5 text-xs font-semibold text-slate-700">
                                <span class="material-symbols-outlined text-[15px] text-emerald-600">check_circle</span>
                                <span>0% Commission</span>
                            </div>
                        </div>

                        <!-- Pillar 4: Transparent Pricing -->
                        <div class="rounded-3xl bg-white p-7 border border-slate-200 shadow-xs flex flex-col justify-between">
                            <div>
                                <div class="w-11 h-11 rounded-2xl bg-slate-100 text-slate-800 flex items-center justify-center mb-4 border border-slate-200">
                                    <span class="material-symbols-outlined text-[22px]">receipt_long</span>
                                </div>
                                <h3 class="text-base font-bold text-slate-900 tracking-tight mb-1.5">Transparent Pricing</h3>
                                <p class="text-xs leading-relaxed text-slate-500 font-normal">Clear breakdown of rent, security deposit, maintenance, and move-in timelines.</p>
                            </div>
                            <div class="mt-5 pt-3 border-t border-slate-100 flex items-center gap-1.5 text-xs font-semibold text-slate-700">
                                <span class="material-symbols-outlined text-[15px] text-emerald-600">check_circle</span>
                                <span>No hidden costs</span>
                            </div>
                        </div>
                    </div>
                </div>
            </section>

            <!-- ==========================================
                 SECTION 7: TENANT / BUYER DEMAND BOARD
                 ========================================== -->
            @if(isset($propertyRequests) && $propertyRequests->isNotEmpty())
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
                        <h2 class="text-2xl sm:text-3xl font-extrabold text-slate-900 tracking-tight">Tenant &amp; Buyer Demand Board</h2>
                        <p class="text-sm text-slate-500 mt-1">Direct requirements posted by verified seekers looking for spaces.</p>
                    </div>

                    <div class="flex flex-wrap items-center gap-2.5">
                        <button type="button" @click="requestModalOpen = true" class="h-10 px-5 rounded-full bg-slate-900 hover:bg-slate-800 text-white font-bold text-xs flex items-center gap-1.5 shadow-xs transition-all cursor-pointer">
                            <span class="material-symbols-outlined text-[17px]">post_add</span>
                            <span>Post Requirement</span>
                        </button>
                        <a href="{{ route('owners.landing') }}" class="h-10 px-4 rounded-full bg-white hover:bg-slate-100 text-slate-700 border border-slate-200 font-semibold text-xs flex items-center gap-1.5 transition-colors">
                            <span class="material-symbols-outlined text-[17px] text-slate-500">home_work</span>
                            <span>Owner Match</span>
                        </a>
                    </div>
                </div>

                <!-- Demand Board Filter Chips -->
                <div class="bg-slate-50 border border-slate-200 rounded-3xl p-3.5 sm:p-4 mb-6 flex flex-wrap items-center justify-between gap-4">
                    <div class="flex flex-wrap items-center gap-2">
                        <span class="text-xs font-bold text-slate-400 uppercase tracking-wider mr-1">Purpose:</span>
                        <button type="button" @click="demandPurpose = 'all'" :class="demandPurpose === 'all' ? 'bg-slate-900 text-white' : 'bg-white text-slate-700 hover:bg-slate-100 border border-slate-200'" class="px-3 py-1 rounded-full text-xs font-semibold transition-all cursor-pointer">
                            All
                        </button>
                        <button type="button" @click="demandPurpose = 'rent'" :class="demandPurpose === 'rent' ? 'bg-slate-900 text-white' : 'bg-white text-slate-700 hover:bg-slate-100 border border-slate-200'" class="px-3 py-1 rounded-full text-xs font-semibold transition-all cursor-pointer">
                            Rent
                        </button>
                        <button type="button" @click="demandPurpose = 'buy'" :class="demandPurpose === 'buy' ? 'bg-slate-900 text-white' : 'bg-white text-slate-700 hover:bg-slate-100 border border-slate-200'" class="px-3 py-1 rounded-full text-xs font-semibold transition-all cursor-pointer">
                            Buy
                        </button>
                    </div>

                    <div class="flex flex-wrap items-center gap-2">
                        <span class="text-xs font-bold text-slate-400 uppercase tracking-wider mr-1">City:</span>
                        <button type="button" @click="demandCity = 'all'" :class="demandCity === 'all' ? 'bg-slate-900 text-white' : 'bg-white text-slate-700 hover:bg-slate-100 border border-slate-200'" class="px-3 py-1 rounded-full text-xs font-semibold transition-all cursor-pointer">
                            All
                        </button>
                        <button type="button" @click="demandCity = 'noida'" :class="demandCity === 'noida' ? 'bg-slate-900 text-white' : 'bg-white text-slate-700 hover:bg-slate-100 border border-slate-200'" class="px-3 py-1 rounded-full text-xs font-semibold transition-all cursor-pointer">
                            Noida
                        </button>
                        <button type="button" @click="demandCity = 'greater noida'" :class="demandCity === 'greater noida' ? 'bg-slate-900 text-white' : 'bg-white text-slate-700 hover:bg-slate-100 border border-slate-200'" class="px-3 py-1 rounded-full text-xs font-semibold transition-all cursor-pointer">
                            Gr. Noida
                        </button>
                        <button type="button" @click="demandCity = 'gurugram'" :class="demandCity === 'gurugram' ? 'bg-slate-900 text-white' : 'bg-white text-slate-700 hover:bg-slate-100 border border-slate-200'" class="px-3 py-1 rounded-full text-xs font-semibold transition-all cursor-pointer">
                            Gurugram
                        </button>
                        <button type="button" @click="demandCity = 'bangalore'" :class="demandCity === 'bangalore' ? 'bg-slate-900 text-white' : 'bg-white text-slate-700 hover:bg-slate-100 border border-slate-200'" class="px-3 py-1 rounded-full text-xs font-semibold transition-all cursor-pointer">
                            Bangalore
                        </button>
                    </div>            </div>

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
                    @foreach($propertyRequests as $req)
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
                    @endforeach
                </div>
            </section>
            @endif

            <!-- ==========================================
                 SECTION 8: LIST YOUR PROPERTY FREE
                 (Owner CTA)
                 ========================================== -->
            <section class="max-w-[1440px] mx-auto px-6 sm:px-8 py-12 w-full" id="list-free">
                <div class="rounded-3xl bg-slate-950 text-white p-8 md:p-12 border border-slate-800 relative overflow-hidden">
                    <div class="absolute -right-24 -bottom-24 w-80 h-80 bg-emerald-500/10 rounded-full blur-3xl pointer-events-none"></div>

                    <div class="grid grid-cols-1 lg:grid-cols-12 gap-8 items-center relative z-10">
                        <div class="lg:col-span-7 space-y-5">
                            <div class="inline-flex items-center gap-2 px-3 py-1 rounded-full bg-emerald-500/15 border border-emerald-500/25 text-emerald-400 text-xs font-bold uppercase tracking-wider">
                                <span class="material-symbols-outlined text-[15px]">add_home</span>
                                For Property Owners
                            </div>
                            <h2 class="text-3xl sm:text-4xl font-extrabold text-white tracking-tight leading-tight">
                                Have a Property to Rent or Sell?
                            </h2>
                            <p class="text-slate-300 text-sm sm:text-base leading-relaxed max-w-xl font-normal">
                                List your property and connect directly with genuine tenants and buyers. Zero broker commission, zero listing fees.
                            </p>

                            <!-- Owner Benefits Grid -->
                            <div class="grid grid-cols-2 sm:grid-cols-4 gap-3 pt-1">
                                <div class="p-3 rounded-2xl bg-white/5 border border-white/10 flex items-start gap-2.5">
                                    <span class="material-symbols-outlined text-emerald-400 text-lg shrink-0 mt-0.5">money_off</span>
                                    <div>
                                        <span class="text-xs font-bold text-white block">Free Listing</span>
                                        <span class="text-[11px] text-slate-400">Zero commission</span>
                                    </div>
                                </div>
                                <div class="p-3 rounded-2xl bg-white/5 border border-white/10 flex items-start gap-2.5">
                                    <span class="material-symbols-outlined text-emerald-400 text-lg shrink-0 mt-0.5">chat</span>
                                    <div>
                                        <span class="text-xs font-bold text-white block">Direct Inquiries</span>
                                        <span class="text-[11px] text-slate-400">Direct WhatsApp</span>
                                    </div>
                                </div>
                                <div class="p-3 rounded-2xl bg-white/5 border border-white/10 flex items-start gap-2.5">
                                    <span class="material-symbols-outlined text-emerald-400 text-lg shrink-0 mt-0.5">verified_user</span>
                                    <div>
                                        <span class="text-xs font-bold text-white block">Verified Hosts</span>
                                        <span class="text-[11px] text-slate-400">Build trust</span>
                                    </div>
                                </div>
                                <div class="p-3 rounded-2xl bg-white/5 border border-white/10 flex items-start gap-2.5">
                                    <span class="material-symbols-outlined text-emerald-400 text-lg shrink-0 mt-0.5">query_stats</span>
                                    <div>
                                        <span class="text-xs font-bold text-white block">Track Analytics</span>
                                        <span class="text-[11px] text-slate-400">Track inquiries</span>
                                    </div>
                                </div>
                            </div>

                            <div class="pt-2 flex items-center gap-3 flex-wrap">
                                <a href="{{ route('owners.landing') }}" class="h-12 px-6 rounded-2xl bg-emerald-600 hover:bg-emerald-500 text-white font-bold text-xs flex items-center gap-2 shadow-sm transition-all active:scale-[0.98]">
                                    <span>List Your Property Free</span>
                                    <span class="material-symbols-outlined text-[16px]">arrow_forward</span>
                                </a>
                                <a href="/owners#how-it-works" class="h-12 px-5 rounded-2xl bg-white/10 hover:bg-white/15 text-white font-bold text-xs flex items-center gap-1.5 border border-white/10 transition-colors">
                                    <span>How It Works</span>
                                </a>
                            </div>
                        </div>

                        <div class="lg:col-span-5">
                            <div class="rounded-2xl bg-white/5 border border-white/10 p-5 space-y-3.5 backdrop-blur-sm">
                                <div class="flex items-center justify-between pb-2.5 border-b border-white/10">
                                    <span class="text-xs font-bold uppercase tracking-wider text-slate-300">Live Seeker Demands</span>
                                    <span class="px-2 py-0.5 rounded-full bg-emerald-500/20 text-emerald-400 text-[11px] font-bold">Matching Now</span>
                                </div>

                                <div class="space-y-2.5">
                                    @foreach($propertyRequests->take(2) as $req)
                                    <div class="p-3 rounded-xl bg-white/5 border border-white/10">
                                        <div class="flex items-center justify-between">
                                            <span class="text-xs font-bold text-white">{{ $req->bedrooms }} in {{ $req->locality ?? $req->city }}</span>
                                            <span class="text-xs font-bold text-emerald-400">{{ $req->formatted_budget }}</span>
                                        </div>
                                        <p class="text-[11px] text-slate-400 mt-1 line-clamp-1 font-normal">{{ $req->description ?? 'Seeking verified home with direct owner contact' }}</p>
                                    </div>
                                    @endforeach
                                </div>

                                <div class="pt-1">
                                    <a href="{{ route('owners.landing') }}" class="w-full h-10 rounded-xl bg-white text-slate-900 font-bold text-xs hover:bg-slate-100 transition-colors flex items-center justify-center gap-1.5 shadow-xs">
                                        <span class="material-symbols-outlined text-[16px] text-slate-900">apartment</span>
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
                 ========================================== -->
            <section class="max-w-[1440px] mx-auto px-6 sm:px-8 py-12 w-full" id="rental-calculator" x-data="{
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
                <div class="rounded-3xl bg-white border border-slate-200 p-8 sm:p-12 shadow-sm">
                    <div class="text-center max-w-xl mx-auto mb-10">
                        <div class="inline-flex items-center gap-1.5 text-slate-500 font-bold text-xs uppercase tracking-wider mb-2">
                            <span class="material-symbols-outlined text-[16px]">calculate</span>
                            Move-In Budget Estimator
                        </div>
                        <h2 class="text-2xl sm:text-3xl font-extrabold text-slate-900 tracking-tight">Rental Cost Calculator</h2>
                        <p class="text-xs sm:text-sm text-slate-500 mt-1">Estimate upfront move-in expenses and see your savings with 0% brokerage.</p>
                    </div>

                    <div class="grid grid-cols-1 lg:grid-cols-12 gap-8 items-start">
                        <!-- Left Controls -->
                        <div class="lg:col-span-7 bg-slate-50 rounded-2xl p-6 border border-slate-200 space-y-5">
                            <!-- Rent Input & Slider -->
                            <div>
                                <div class="flex items-center justify-between mb-2">
                                    <label class="text-xs font-bold uppercase tracking-wider text-slate-700">Monthly Rent</label>
                                    <span class="text-base font-extrabold text-slate-900" x-text="formatInr(rentAmount) + '/mo'"></span>
                                </div>
                                <input type="range" min="8000" max="150000" step="1000" x-model.number="rentAmount" class="w-full h-2 bg-slate-200 rounded-lg appearance-none cursor-pointer accent-slate-900">
                                <div class="flex justify-between text-[11px] font-medium text-slate-400 mt-1">
                                    <span>₹8,000</span>
                                    <span>₹50,000</span>
                                    <span>₹1,50,000</span>
                                </div>
                            </div>

                            <!-- Deposit Multiplier Tabs -->
                            <div>
                                <label class="block text-xs font-bold uppercase tracking-wider text-slate-700 mb-2">Security Deposit (Months)</label>
                                <div class="grid grid-cols-3 gap-2.5">
                                    <button type="button" @click="depositMultiplier = 1" :class="depositMultiplier === 1 ? 'bg-slate-900 text-white' : 'bg-white text-slate-700 hover:bg-slate-100 border border-slate-200'" class="py-2 rounded-xl text-xs font-bold transition-all cursor-pointer">
                                        1 Month
                                    </button>
                                    <button type="button" @click="depositMultiplier = 2" :class="depositMultiplier === 2 ? 'bg-slate-900 text-white' : 'bg-white text-slate-700 hover:bg-slate-100 border border-slate-200'" class="py-2 rounded-xl text-xs font-bold transition-all cursor-pointer">
                                        2 Months (Standard)
                                    </button>
                                    <button type="button" @click="depositMultiplier = 3" :class="depositMultiplier === 3 ? 'bg-slate-900 text-white' : 'bg-white text-slate-700 hover:bg-slate-100 border border-slate-200'" class="py-2 rounded-xl text-xs font-bold transition-all cursor-pointer">
                                        3 Months
                                    </button>
                                </div>
                            </div>

                            <!-- Maintenance Fee -->
                            <div>
                                <div class="flex items-center justify-between mb-2">
                                    <label class="text-xs font-bold uppercase tracking-wider text-slate-700">Estimated Maintenance</label>
                                    <span class="text-xs font-bold text-slate-900" x-text="formatInr(maintenanceAmount) + '/mo'"></span>
                                </div>
                                <input type="range" min="0" max="10000" step="500" x-model.number="maintenanceAmount" class="w-full h-2 bg-slate-200 rounded-lg appearance-none cursor-pointer accent-slate-900">
                            </div>
                        </div>

                        <!-- Right Cost Summary Card -->
                        <div class="lg:col-span-5 bg-white rounded-2xl p-6 border border-slate-200 shadow-sm flex flex-col justify-between">
                            <div>
                                <div class="flex items-center justify-between pb-3 border-b border-slate-100 mb-4">
                                    <span class="text-xs font-bold uppercase tracking-wider text-slate-500">Move-In Breakdown</span>
                                    <span class="px-2.5 py-0.5 rounded-full bg-emerald-50 text-emerald-800 text-[11px] font-bold border border-emerald-200">
                                        0% Brokerage
                                    </span>
                                </div>

                                <div class="space-y-2.5 text-xs font-medium text-slate-600">
                                    <div class="flex items-center justify-between p-2.5 rounded-xl bg-slate-50 border border-slate-100">
                                        <span>First Month Rent:</span>
                                        <span class="font-bold text-slate-900" x-text="formatInr(rentAmount)"></span>
                                    </div>
                                    <div class="flex items-center justify-between p-2.5 rounded-xl bg-slate-50 border border-slate-100">
                                        <span>Security Deposit:</span>
                                        <span class="font-bold text-slate-900" x-text="formatInr(securityDeposit)"></span>
                                    </div>
                                    <div class="flex items-center justify-between p-2.5 rounded-xl bg-slate-50 border border-slate-100">
                                        <span>Society Maintenance:</span>
                                        <span class="font-bold text-slate-900" x-text="formatInr(maintenanceAmount)"></span>
                                    </div>
                                    <div class="flex items-center justify-between p-2.5 rounded-xl bg-emerald-50 border border-emerald-200 text-emerald-900 font-bold">
                                        <div class="flex items-center gap-1.5">
                                            <span class="material-symbols-outlined text-[16px] text-emerald-600">savings</span>
                                            <span>Brokerage on HomiQ:</span>
                                        </div>
                                        <span class="text-emerald-700">₹0 (Free)</span>
                                    </div>
                                </div>

                                <div class="mt-5 pt-4 border-t border-slate-100">
                                    <div class="flex items-baseline justify-between mb-1">
                                        <span class="text-xs font-bold uppercase tracking-wider text-slate-700">Total Move-In:</span>
                                        <span class="text-xl font-extrabold text-slate-900" x-text="formatInr(totalMoveIn)"></span>
                                    </div>
                                    <p class="text-[11px] text-emerald-700 font-semibold flex items-center gap-1">
                                        <span class="material-symbols-outlined text-[14px]">check_circle</span>
                                        <span>You save <span x-text="formatInr(brokerageSaved)"></span> in broker fees!</span>
                                    </p>
                                </div>
                            </div>

                            <div class="mt-5">
                                <a :href="'/?max_price=' + rentAmount + '#listings'" class="w-full h-11 rounded-xl bg-slate-900 hover:bg-slate-800 text-white font-bold text-xs flex items-center justify-center gap-2 shadow-sm transition-all active:scale-98">
                                    <span class="material-symbols-outlined text-[16px]">search</span>
                                    <span>Browse Homes Under <span x-text="formatInr(rentAmount)"></span></span>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </section>

            <!-- ==========================================
                 SECTION 10: POPULAR LOCALITY GUIDES
                 ========================================== -->
            <section class="max-w-[1440px] mx-auto px-6 sm:px-8 py-12 w-full" id="locality-guides">
                <div class="flex flex-col md:flex-row md:items-end justify-between gap-4 mb-8">
                    <div>
                        <div class="inline-flex items-center gap-1.5 text-slate-500 font-bold text-xs uppercase tracking-wider mb-2">
                            <span class="material-symbols-outlined text-[16px]">menu_book</span>
                            Area Intelligence
                        </div>
                        <h2 class="text-2xl sm:text-3xl font-extrabold text-slate-900 tracking-tight">Popular Locality Guides</h2>
                        <p class="text-xs sm:text-sm text-slate-500 mt-1">Key insights on high-demand residential sectors, average rents, and connectivity.</p>
                    </div>
                    <div>
                        <a href="/guides" class="text-xs font-bold text-slate-800 hover:text-emerald-700 flex items-center gap-1 transition-colors">
                            <span>Browse all guides</span>
                            <span class="material-symbols-outlined text-xs">arrow_forward</span>
                        </a>
                    </div>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                    <!-- Guide 1: Sector 137 Noida -->
                    <div class="group rounded-2xl bg-white p-5 border border-slate-200 shadow-sm hover:border-slate-400 transition-all duration-200 flex flex-col justify-between">
                        <div>
                            <div class="relative rounded-xl overflow-hidden aspect-[16/9] mb-3.5 bg-slate-100">
                                <img alt="Sector 137 Noida" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-300" src="https://images.unsplash.com/photo-1545324418-cc1a3fa10c00?auto=format&fit=crop&w=800&q=80">
                                <div class="absolute inset-0 bg-slate-900/30"></div>
                                <div class="absolute bottom-2.5 left-3 right-3 flex items-center justify-between text-white">
                                    <span class="font-bold text-sm drop-shadow-sm">Sector 137, Noida</span>
                                    <span class="px-2 py-0.5 rounded-md bg-slate-900/80 backdrop-blur-sm text-[10px] font-semibold">Expressway</span>
                                </div>
                            </div>
                            <h3 class="text-base font-bold text-slate-900 mb-1">Noida Expressway Corridor</h3>
                            <p class="text-xs text-slate-500 leading-relaxed">Paras Tierea, Supertech, metro connectivity, and corporate IT parks.</p>
                        </div>
                        <a href="/?city=Noida&locality=Sector+137#listings" class="mt-4 w-full h-10 rounded-xl bg-slate-100 hover:bg-slate-900 hover:text-white text-slate-800 font-bold text-xs text-center transition-all flex items-center justify-center gap-1.5 active:scale-98">
                            <span>Explore Sector 137</span>
                            <span class="material-symbols-outlined text-[15px]">arrow_forward</span>
                        </a>
                    </div>

                    <!-- Guide 2: Greater Noida West & Knowledge Park -->
                    <div class="group rounded-2xl bg-white p-5 border border-slate-200 shadow-sm hover:border-slate-400 transition-all duration-200 flex flex-col justify-between">
                        <div>
                            <div class="relative rounded-xl overflow-hidden aspect-[16/9] mb-3.5 bg-slate-100">
                                <img alt="Greater Noida Student PGs & Societies" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-300" src="https://images.unsplash.com/photo-1555854877-bab0e564b8d5?auto=format&fit=crop&w=800&q=80">
                                <div class="absolute inset-0 bg-slate-900/30"></div>
                                <div class="absolute bottom-2.5 left-3 right-3 flex items-center justify-between text-white">
                                    <span class="font-bold text-sm drop-shadow-sm">Greater Noida</span>
                                    <span class="px-2 py-0.5 rounded-md bg-slate-900/80 backdrop-blur-sm text-[10px] font-semibold">Gaur City &amp; KP</span>
                                </div>
                            </div>
                            <h3 class="text-base font-bold text-slate-900 mb-1">Student &amp; Family Corridors</h3>
                            <p class="text-xs text-slate-500 leading-relaxed">Knowledge Park student PGs with meals and Gaur City 2 BHK homes.</p>
                        </div>
                        <a href="/?city=Greater+Noida#listings" class="mt-4 w-full h-10 rounded-xl bg-slate-100 hover:bg-slate-900 hover:text-white text-slate-800 font-bold text-xs text-center transition-all flex items-center justify-center gap-1.5 active:scale-98">
                            <span>Explore Greater Noida</span>
                            <span class="material-symbols-outlined text-[15px]">arrow_forward</span>
                        </a>
                    </div>

                    <!-- Guide 3: Gurugram & Bangalore Hubs -->
                    <div class="group rounded-2xl bg-white p-5 border border-slate-200 shadow-sm hover:border-slate-400 transition-all duration-200 flex flex-col justify-between">
                        <div>
                            <div class="relative rounded-xl overflow-hidden aspect-[16/9] mb-3.5 bg-slate-100">
                                <img alt="Gurugram & Bangalore IT Hubs" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-300" src="https://images.unsplash.com/photo-1512917774080-9991f1c4c750?auto=format&fit=crop&w=800&q=80">
                                <div class="absolute inset-0 bg-slate-900/30"></div>
                                <div class="absolute bottom-2.5 left-3 right-3 flex items-center justify-between text-white">
                                    <span class="font-bold text-sm drop-shadow-sm">Gurugram &amp; Bangalore</span>
                                    <span class="px-2 py-0.5 rounded-md bg-slate-900/80 backdrop-blur-sm text-[10px] font-semibold">Tech Hubs</span>
                                </div>
                            </div>
                            <h3 class="text-base font-bold text-slate-900 mb-1">Tech Corridors &amp; Studios</h3>
                            <p class="text-xs text-slate-500 leading-relaxed">Cyber City studios, DLF Phase 3, and HSR Layout flats with 0% brokerage.</p>
                        </div>
                        <a href="/rent/gurugram" class="mt-4 w-full h-10 rounded-xl bg-slate-100 hover:bg-slate-900 hover:text-white text-slate-800 font-bold text-xs text-center transition-all flex items-center justify-center gap-1.5 active:scale-98">
                            <span>Explore Hubs</span>
                            <span class="material-symbols-outlined text-[15px]">arrow_forward</span>
                        </a>
                    </div>
                </div>
            </section>

            <!-- ==========================================
                 SECTION 11: APP DOWNLOAD
                 ========================================== -->
            <section class="max-w-[1440px] mx-auto px-6 sm:px-8 py-12 w-full" id="download-app">
                <div class="rounded-3xl bg-slate-950 text-white p-8 md:p-12 border border-slate-800 relative overflow-hidden">
                    <div class="grid grid-cols-1 lg:grid-cols-12 gap-8 items-center relative z-10">
                        <div class="lg:col-span-7">
                            <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full bg-white/10 text-emerald-400 text-xs font-bold uppercase tracking-wider mb-4 border border-white/10">
                                <span class="material-symbols-outlined text-[15px]">bolt</span>
                                Real-Time Mobile Engine
                            </span>
                            <h2 class="text-3xl sm:text-4xl font-extrabold text-white tracking-tight leading-tight">
                                Get Faster Property Alerts on the HomiQ App
                            </h2>
                            <p class="text-slate-300 text-sm sm:text-base mt-2.5 mb-6 max-w-xl font-normal leading-relaxed">
                                Never miss an under-market flat. Connect directly with certified landlords and receive instant notifications the moment matching homes are verified.
                            </p>

                            <!-- Key App Benefits Grid -->
                            <div class="grid grid-cols-2 sm:grid-cols-3 gap-2.5 mb-8 max-w-lg">
                                <div class="flex items-center gap-2 p-2.5 rounded-xl bg-white/5 border border-white/10">
                                    <span class="material-symbols-outlined text-emerald-400 text-[18px] shrink-0">chat</span>
                                    <span class="text-xs font-semibold text-slate-200">Instant owner replies</span>
                                </div>
                                <div class="flex items-center gap-2 p-2.5 rounded-xl bg-white/5 border border-white/10">
                                    <span class="material-symbols-outlined text-emerald-400 text-[18px] shrink-0">saved_search</span>
                                    <span class="text-xs font-semibold text-slate-200">Saved searches</span>
                                </div>
                                <div class="flex items-center gap-2 p-2.5 rounded-xl bg-white/5 border border-white/10">
                                    <span class="material-symbols-outlined text-emerald-400 text-[18px] shrink-0">notifications_active</span>
                                    <span class="text-xs font-semibold text-slate-200">New listing alerts</span>
                                </div>
                                <div class="flex items-center gap-2 p-2.5 rounded-xl bg-white/5 border border-white/10">
                                    <span class="material-symbols-outlined text-emerald-400 text-[18px] shrink-0">share</span>
                                    <span class="text-xs font-semibold text-slate-200">Property sharing</span>
                                </div>
                                <div class="flex items-center gap-2 p-2.5 rounded-xl bg-white/5 border border-white/10 sm:col-span-2">
                                    <span class="material-symbols-outlined text-emerald-400 text-[18px] shrink-0">calendar_month</span>
                                    <span class="text-xs font-semibold text-slate-200">Visit scheduling</span>
                                </div>
                            </div>

                            <!-- Download Badges -->
                            <div class="space-y-2.5">
                                <span class="block text-[11px] font-bold tracking-wider uppercase text-slate-400">
                                    Available for iOS &amp; Android
                                </span>
                                <div class="flex flex-col sm:flex-row items-stretch sm:items-center gap-3 flex-wrap">
                                    <!-- Google Play Badge -->
                                    <a href="https://play.google.com/store/apps/details?id=com.homiq.acrocoder&hl=en" target="_blank" class="h-12 px-4 rounded-xl bg-slate-900 hover:bg-slate-800 text-white border border-slate-700 flex items-center gap-3 transition-all">
                                        <svg class="w-6 h-6 shrink-0" viewBox="0 0 512 512">
                                            <path fill="#4285F4" d="M47.7 28.5C43.3 33.2 40.7 39.9 40.7 47.5V464.5c0 7.6 2.6 14.3 7 19L273.1 258 47.7 28.5z"/>
                                            <path fill="#34A853" d="M346.5 184.5L273.1 258 47.7 28.5c4-4.3 9.9-7.2 16.5-7.2 4.1 0 7.9 1.1 11.4 3L346.5 184.5z"/>
                                            <path fill="#EA4335" d="M47.7 483.5c4 4.3 9.9 7.2 16.5 7.2 4.1 0 7.9-1.1 11.4-3l270.9-156.2L273.1 258 47.7 483.5z"/>
                                            <path fill="#FBBC05" d="M464.3 243.6L346.5 175.7 273.1 258l73.4 82.3 117.8-67.9c13.7-7.9 13.7-20.8 0-28.8z"/>
                                        </svg>
                                        <div class="text-left">
                                            <span class="block text-[9px] text-slate-400 font-bold uppercase tracking-wider leading-none">GET IT ON</span>
                                            <span class="text-sm font-bold text-white tracking-tight leading-tight block mt-0.5">Google Play</span>
                                        </div>
                                    </a>

                                    <!-- Apple App Store Badge -->
                                    <a href="https://apps.apple.com/in/app/homiq-real-estate-marketplace/id6779412636" target="_blank" class="h-12 px-4 rounded-xl bg-slate-900 hover:bg-slate-800 text-white border border-slate-700 flex items-center gap-3 transition-all">
                                        <svg class="w-6 h-6 fill-current text-white shrink-0" viewBox="0 0 170 170">
                                            <path d="M150.37 130.25c-2.45 5.66-5.35 10.87-8.71 15.66-4.58 6.53-8.33 11.05-11.22 13.56-4.48 4.12-9.28 6.23-14.42 6.35-3.69 0-8.14-1.05-13.32-3.18-5.19-2.12-9.97-3.17-14.34-3.17-4.58 0-9.49 1.05-14.75 3.17-5.26 2.13-9.5 3.24-12.74 3.35-4.35.13-9.16-1.9-14.42-6.08-3.7-3.04-7.7-7.8-12.01-14.28-5.44-8.15-9.76-17.65-12.96-28.48-3.2-10.84-4.8-21.2-4.8-31.1 0-14.82 3.73-26.65 11.2-35.48 7.46-8.84 16.73-13.35 27.81-13.55 4.8 0 10.14 1.25 16.03 3.75 5.88 2.5 9.73 3.8 11.54 3.9 1.48 0 5.63-1.42 12.44-4.24 6.81-2.83 12.77-4.08 17.87-3.76 13.74.8 24.32 5.92 31.75 15.36-12.07 7.34-18.01 17.51-17.81 30.5.21 10.16 4.17 18.66 11.89 25.48 3.51 3.15 7.44 5.48 11.78 7 1.06 3.71 2.05 7.43 2.97 11.16zm-38.31-105.12c0 3.83-1.07 7.79-3.21 11.89-2.14 4.09-5.11 7.46-8.91 10.11-3.6 2.47-7.42 4.04-11.45 4.7-1.1-.96-1.74-2.58-1.92-4.85-.23-2.92.42-6.1 1.95-9.54 1.53-3.44 3.76-6.49 6.69-9.14 3.15-2.84 6.74-4.83 10.77-5.97 4.03-1.14 7.28-1.54 9.76-1.2.22 1.34.32 2.67.32 4z"/>
                                        </svg>
                                        <div class="text-left">
                                            <span class="block text-[9px] text-slate-400 font-medium leading-none">Download on the</span>
                                            <span class="text-sm font-bold text-white tracking-tight leading-tight block mt-0.5">App Store</span>
                                        </div>
                                    </a>
                                </div>
                            </div>
                        </div>

                        <!-- Right Showcase Card -->
                        <div class="lg:col-span-5 flex justify-center lg:justify-end">
                            <div class="rounded-2xl bg-white/5 border border-white/10 p-6 backdrop-blur-sm text-center max-w-xs w-full space-y-3">
                                <div class="w-12 h-12 rounded-xl bg-emerald-500/20 text-emerald-400 flex items-center justify-center mx-auto">
                                    <span class="material-symbols-outlined text-[24px]">smartphone</span>
                                </div>
                                <h3 class="text-lg font-bold text-white">0% Brokerage App</h3>
                                <p class="text-xs text-slate-300 leading-relaxed font-normal">Browse verified flats across Noida, Bangalore, and Delhi NCR with direct WhatsApp &amp; in-app chats.</p>
                                <div class="pt-1 flex items-center justify-center gap-1.5 text-emerald-400 text-xs font-semibold">
                                    <span class="material-symbols-outlined text-[16px]">verified</span>
                                    <span>Direct Landlord Chat</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </section>

            <!-- ==========================================
                 SECTION 12: SAFETY & VERIFICATION
                 ========================================== -->
            <section class="max-w-[1440px] mx-auto px-6 sm:px-8 py-12 w-full" id="safety-verification">
                <div class="rounded-3xl bg-slate-900 text-white p-8 md:p-12 border border-slate-800 relative overflow-hidden">
                    <div class="flex flex-col md:flex-row md:items-end justify-between gap-6 mb-10 relative z-10">
                        <div>
                            <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full bg-emerald-500/20 text-emerald-400 text-xs font-bold uppercase tracking-wider mb-2.5 border border-emerald-500/30">
                                <span class="material-symbols-outlined text-[15px]">verified</span>
                                Zero Phantom Listings Policy
                            </span>
                            <h2 class="text-2xl sm:text-3xl font-extrabold text-white tracking-tight">
                                How HomiQ Verifies Properties
                            </h2>
                            <p class="text-slate-300 text-xs sm:text-sm mt-1.5 max-w-xl font-normal leading-relaxed">
                                Every approved listing on HomiQ undergoes a 4-step verification protocol to prevent duplicate and fake broker listings.
                            </p>
                        </div>

                        <div class="shrink-0 flex items-center gap-2.5">
                            <a href="/verification-standards" class="h-10 px-4 rounded-xl bg-white/10 hover:bg-white/15 text-white font-semibold text-xs flex items-center justify-center gap-1.5 border border-white/10 transition">
                                <span>Standards</span>
                                <span class="material-symbols-outlined text-sm">verified_user</span>
                            </a>
                            <a href="/safety" class="h-10 px-4 rounded-xl bg-emerald-600 hover:bg-emerald-500 text-white font-bold text-xs flex items-center justify-center gap-1.5 shadow-sm transition">
                                <span>Safety Center</span>
                                <span class="material-symbols-outlined text-sm">shield</span>
                            </a>
                        </div>
                    </div>

                    <!-- 4-Step Process Grid -->
                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4 relative z-10">
                        <!-- Step 1 -->
                        <div class="p-5 rounded-2xl bg-white/5 border border-white/10 flex flex-col justify-between">
                            <div>
                                <div class="h-10 w-10 rounded-xl bg-emerald-500/20 text-emerald-400 flex items-center justify-center mb-3">
                                    <span class="material-symbols-outlined text-xl">badge</span>
                                </div>
                                <span class="text-[10px] font-bold uppercase tracking-widest text-emerald-400 block mb-1">Step 01</span>
                                <h3 class="text-sm font-bold text-white mb-1.5">Host ID &amp; KYC Check</h3>
                                <p class="text-xs text-slate-300 leading-relaxed font-normal">
                                    Hosts complete OTP mobile validation and submit official identification before listing.
                                </p>
                            </div>
                            <div class="mt-3 pt-2.5 border-t border-white/10 flex items-center gap-1.5 text-[11px] font-semibold text-emerald-400">
                                <span class="material-symbols-outlined text-xs">check_circle</span>
                                <span>Verified Hosts</span>
                            </div>
                        </div>

                        <!-- Step 2 -->
                        <div class="p-5 rounded-2xl bg-white/5 border border-white/10 flex flex-col justify-between">
                            <div>
                                <div class="h-10 w-10 rounded-xl bg-emerald-500/20 text-emerald-400 flex items-center justify-center mb-3">
                                    <span class="material-symbols-outlined text-xl">pin_drop</span>
                                </div>
                                <span class="text-[10px] font-bold uppercase tracking-widest text-emerald-400 block mb-1">Step 02</span>
                                <h3 class="text-sm font-bold text-white mb-1.5">Geotagged Location</h3>
                                <p class="text-xs text-slate-300 leading-relaxed font-normal">
                                    Exact building towers, GPS coordinates, and walking distances to metro stations are verified.
                                </p>
                            </div>
                            <div class="mt-3 pt-2.5 border-t border-white/10 flex items-center gap-1.5 text-[11px] font-semibold text-emerald-400">
                                <span class="material-symbols-outlined text-xs">check_circle</span>
                                <span>Exact Landmark</span>
                            </div>
                        </div>

                        <!-- Step 3 -->
                        <div class="p-5 rounded-2xl bg-white/5 border border-white/10 flex flex-col justify-between">
                            <div>
                                <div class="h-10 w-10 rounded-xl bg-emerald-500/20 text-emerald-400 flex items-center justify-center mb-3">
                                    <span class="material-symbols-outlined text-xl">photo_camera</span>
                                </div>
                                <span class="text-[10px] font-bold uppercase tracking-widest text-emerald-400 block mb-1">Step 03</span>
                                <h3 class="text-sm font-bold text-white mb-1.5">Authentic Photo Audit</h3>
                                <p class="text-xs text-slate-300 leading-relaxed font-normal">
                                    We verify submitted images against real room layouts to ensure zero stock photo misrepresentation.
                                </p>
                            </div>
                            <div class="mt-3 pt-2.5 border-t border-white/10 flex items-center gap-1.5 text-[11px] font-semibold text-emerald-400">
                                <span class="material-symbols-outlined text-xs">check_circle</span>
                                <span>Real Photos</span>
                            </div>
                        </div>

                        <!-- Step 4 -->
                        <div class="p-5 rounded-2xl bg-white/5 border border-white/10 flex flex-col justify-between">
                            <div>
                                <div class="h-10 w-10 rounded-xl bg-emerald-500/20 text-emerald-400 flex items-center justify-center mb-3">
                                    <span class="material-symbols-outlined text-xl">schedule</span>
                                </div>
                                <span class="text-[10px] font-bold uppercase tracking-widest text-emerald-400 block mb-1">Step 04</span>
                                <h3 class="text-sm font-bold text-white mb-1.5">Freshness Cycle</h3>
                                <p class="text-xs text-slate-300 leading-relaxed font-normal">
                                    Listings expire after 30 days unless landlords reconfirm availability. Rented units are archived.
                                </p>
                            </div>
                            <div class="mt-3 pt-2.5 border-t border-white/10 flex items-center gap-1.5 text-[11px] font-semibold text-emerald-400">
                                <span class="material-symbols-outlined text-xs">check_circle</span>
                                <span>Genuine Vacancy</span>
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
                 x-transition:enter="ease-out duration-200"
                 x-transition:enter-start="opacity-0"
                 x-transition:enter-end="opacity-100"
                 x-transition:leave="ease-in duration-150"
                 x-transition:leave-start="opacity-100"
                 x-transition:leave-end="opacity-0"
                 class="fixed inset-0 bg-slate-950/60 backdrop-blur-sm transition-opacity" 
                 @click="requestModalOpen = false"></div>

            <span class="hidden sm:inline-block sm:align-middle sm:h-screen" aria-hidden="true">&#8203;</span>

            <div x-show="requestModalOpen" 
                 x-transition:enter="ease-out duration-200"
                 x-transition:enter-start="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
                 x-transition:enter-end="opacity-100 translate-y-0 sm:scale-100"
                 x-transition:leave="ease-in duration-150"
                 x-transition:leave-start="opacity-100 translate-y-0 sm:scale-100"
                 x-transition:leave-end="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
                 class="inline-block align-bottom bg-white rounded-3xl text-left overflow-hidden shadow-2xl transform transition-all sm:my-8 sm:align-middle sm:max-w-lg sm:w-full border border-slate-200 p-6 sm:p-8">
                
                <div class="flex items-center justify-between pb-3.5 border-b border-slate-100 mb-5">
                    <div>
                        <span class="text-[10px] font-bold uppercase tracking-wider text-slate-500">Demand Board</span>
                        <h3 class="text-lg font-bold text-slate-900">Post a Property Request</h3>
                    </div>
                    <button @click="requestModalOpen = false" type="button" class="h-8 w-8 rounded-full bg-slate-100 hover:bg-slate-200 flex items-center justify-center text-slate-600 transition cursor-pointer">
                        <span class="material-symbols-outlined text-sm">close</span>
                    </button>
                </div>

                <form id="property-request-form" onsubmit="submitPropertyRequest(event)" class="space-y-3.5 text-xs font-semibold text-slate-700">
                    @csrf
                    <div>
                        <label class="block text-slate-700 mb-1">Your Name *</label>
                        <input type="text" name="seeker_name" required placeholder="e.g. Rahul Sharma" value="{{ Auth::user()?->name }}" class="w-full px-3.5 py-2.5 rounded-xl bg-slate-50 border border-slate-200 text-slate-900 text-xs font-semibold focus:outline-none focus:ring-1 focus:ring-slate-900 focus:bg-white transition">
                    </div>

                    <div class="grid grid-cols-2 gap-3">
                        <div>
                            <label class="block text-slate-700 mb-1">WhatsApp Phone *</label>
                            <input type="tel" name="seeker_phone" required placeholder="e.g. 9876543210" value="{{ Auth::user()?->phone }}" class="w-full px-3.5 py-2.5 rounded-xl bg-slate-50 border border-slate-200 text-slate-900 text-xs font-semibold focus:outline-none focus:ring-1 focus:ring-slate-900 focus:bg-white transition">
                        </div>
                        <div>
                            <label class="block text-slate-700 mb-1">City *</label>
                            <input type="text" name="city" required placeholder="e.g. Noida, Bangalore" class="w-full px-3.5 py-2.5 rounded-xl bg-slate-50 border border-slate-200 text-slate-900 text-xs font-semibold focus:outline-none focus:ring-1 focus:ring-slate-900 focus:bg-white transition">
                        </div>
                    </div>

                    <div class="grid grid-cols-2 gap-3">
                        <div>
                            <label class="block text-slate-700 mb-1">Locality / Sector</label>
                            <input type="text" name="locality" placeholder="e.g. Sector 137 or HSR Layout" class="w-full px-3.5 py-2.5 rounded-xl bg-slate-50 border border-slate-200 text-slate-900 text-xs font-semibold focus:outline-none focus:ring-1 focus:ring-slate-900 focus:bg-white transition">
                        </div>
                        <div>
                            <label class="block text-slate-700 mb-1">Purpose *</label>
                            <select name="purpose" class="w-full px-3 py-2.5 rounded-xl bg-slate-50 border border-slate-200 text-slate-900 text-xs font-semibold focus:outline-none focus:ring-1 focus:ring-slate-900 focus:bg-white transition">
                                <option value="rent" selected>Rent</option>
                                <option value="buy">Buy</option>
                            </select>
                        </div>
                    </div>

                    <div class="grid grid-cols-3 gap-2.5">
                        <div>
                            <label class="block text-slate-700 mb-1">Type *</label>
                            <select name="property_type" class="w-full px-2 py-2.5 rounded-xl bg-slate-50 border border-slate-200 text-slate-900 text-xs font-semibold">
                                <option value="Apartment">Apartment</option>
                                <option value="PG / Co-living">PG / Co-living</option>
                                <option value="House">House / Villa</option>
                                <option value="Commercial">Commercial</option>
                            </select>
                        </div>
                        <div>
                            <label class="block text-slate-700 mb-1">BHK / Size</label>
                            <select name="bedrooms" class="w-full px-2 py-2.5 rounded-xl bg-slate-50 border border-slate-200 text-slate-900 text-xs font-semibold">
                                <option value="1 BHK">1 BHK</option>
                                <option value="2 BHK" selected>2 BHK</option>
                                <option value="3 BHK">3 BHK</option>
                                <option value="Studio">Studio</option>
                                <option value="N/A">N/A</option>
                            </select>
                        </div>
                        <div>
                            <label class="block text-slate-700 mb-1">Max Budget (₹) *</label>
                            <input type="number" name="max_budget" required placeholder="e.g. 25000" class="w-full px-2 py-2.5 rounded-xl bg-slate-50 border border-slate-200 text-slate-900 text-xs font-semibold focus:outline-none focus:ring-1 focus:ring-slate-900 focus:bg-white transition">
                        </div>
                    </div>

                    <div class="grid grid-cols-2 gap-3">
                        <div>
                            <label class="block text-slate-700 mb-1">Tenant Type</label>
                            <select name="tenant_type" class="w-full px-3 py-2.5 rounded-xl bg-slate-50 border border-slate-200 text-slate-900 text-xs font-semibold">
                                <option value="Family">Family</option>
                                <option value="Bachelors" selected>Bachelors / Working</option>
                                <option value="Students">Students</option>
                                <option value="Company Lease">Company Lease</option>
                            </select>
                        </div>
                        <div>
                            <label class="block text-slate-700 mb-1">Move-in Date</label>
                            <input type="date" name="move_in_date" class="w-full px-3 py-2 rounded-xl bg-slate-50 border border-slate-200 text-slate-900 text-xs font-semibold">
                        </div>
                    </div>

                    <div>
                        <label class="block text-slate-700 mb-1">Specific Requirements</label>
                        <textarea name="description" rows="2" placeholder="e.g. Near metro station, semi-furnished, reserved parking required..." class="w-full px-3.5 py-2 rounded-xl bg-slate-50 border border-slate-200 text-slate-900 text-xs font-semibold focus:outline-none focus:ring-1 focus:ring-slate-900 focus:bg-white transition"></textarea>
                    </div>

                    <div class="pt-2">
                        <button type="submit" id="submit-request-btn" class="w-full py-3 rounded-xl bg-slate-900 hover:bg-slate-800 text-white font-bold text-xs shadow-sm transition-all flex items-center justify-center gap-2 cursor-pointer active:scale-98">
                            <span class="material-symbols-outlined text-[16px]">campaign</span>
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
                 x-transition:enter="ease-out duration-200"
                 x-transition:enter-start="opacity-0"
                 x-transition:enter-end="opacity-100"
                 x-transition:leave="ease-in duration-150"
                 x-transition:leave-start="opacity-100"
                 x-transition:leave-end="opacity-0"
                 class="fixed inset-0 bg-slate-950/60 backdrop-blur-sm transition-opacity" 
                 @click="saveSearchModalOpen = false"></div>

            <span class="hidden sm:inline-block sm:align-middle sm:h-screen" aria-hidden="true">&#8203;</span>

            <div x-show="saveSearchModalOpen" 
                 x-transition:enter="ease-out duration-200"
                 x-transition:enter-start="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
                 x-transition:enter-end="opacity-100 translate-y-0 sm:scale-100"
                 x-transition:leave="ease-in duration-150"
                 x-transition:leave-start="opacity-100 translate-y-0 sm:scale-100"
                 x-transition:leave-end="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
                 class="inline-block align-bottom bg-white rounded-3xl text-left overflow-hidden shadow-2xl transform transition-all sm:my-8 sm:align-middle sm:max-w-md sm:w-full border border-slate-200 p-6 sm:p-8">
                
                <div class="flex items-center justify-between pb-3.5 border-b border-slate-100 mb-5">
                    <div class="flex items-center gap-2.5">
                        <div class="w-8 h-8 rounded-lg bg-slate-100 text-slate-900 flex items-center justify-center">
                            <span class="material-symbols-outlined text-[18px]">notifications_active</span>
                        </div>
                        <div>
                            <h3 class="text-base font-bold text-slate-900">Save Search Alerts</h3>
                            <p class="text-[11px] text-slate-500">Get notified when new matching flats are listed</p>
                        </div>
                    </div>
                    <button @click="saveSearchModalOpen = false" type="button" class="h-8 w-8 rounded-full bg-slate-100 hover:bg-slate-200 flex items-center justify-center text-slate-600 transition cursor-pointer">
                        <span class="material-symbols-outlined text-sm">close</span>
                    </button>
                </div>

                <form id="save-search-form" onsubmit="submitSaveSearch(event)" class="space-y-3.5 text-xs font-semibold text-slate-700">
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
                        <input type="text" name="title" required value="{{ request('search') ? request('search') : ((request('bedrooms') ? request('bedrooms') . ' BHK in ' : '') . ($selectedCity ?? 'Noida') . (request('max_price') ? ' under ₹' . number_format(request('max_price')) : '')) }}" class="w-full px-3.5 py-2.5 rounded-xl bg-slate-50 border border-slate-200 text-slate-900 text-xs font-semibold focus:outline-none focus:ring-1 focus:ring-slate-900 focus:bg-white transition">
                    </div>

                    <div>
                        <label class="block text-slate-700 mb-1">Your Email for Alerts *</label>
                        <input type="email" name="user_email" required value="{{ Auth::user()?->email }}" placeholder="e.g. name@example.com" class="w-full px-3.5 py-2.5 rounded-xl bg-slate-50 border border-slate-200 text-slate-900 text-xs font-semibold focus:outline-none focus:ring-1 focus:ring-slate-900 focus:bg-white transition">
                    </div>

                    <div>
                        <label class="block text-slate-700 mb-1">Alert Frequency</label>
                        <select name="frequency" class="w-full px-3 py-2.5 rounded-xl bg-slate-50 border border-slate-200 text-slate-900 text-xs font-semibold">
                            <option value="instant">Instant (Real-time)</option>
                            <option value="daily" selected>Daily Digest</option>
                            <option value="weekly">Weekly Summary</option>
                        </select>
                    </div>

                    <div class="pt-2">
                        <button type="submit" :disabled="saveSearchSubmitting" class="w-full py-3 rounded-xl bg-slate-900 hover:bg-slate-800 text-white font-bold text-xs shadow-sm transition-all flex items-center justify-center gap-2 cursor-pointer active:scale-98">
                            <span class="material-symbols-outlined text-[16px]">notifications_active</span>
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
                 x-transition:enter="ease-out duration-200"
                 x-transition:enter-start="opacity-0"
                 x-transition:enter-end="opacity-100"
                 x-transition:leave="ease-in duration-150"
                 x-transition:leave-start="opacity-100"
                 x-transition:leave-end="opacity-0"
                 class="fixed inset-0 bg-slate-950/60 backdrop-blur-sm transition-opacity" 
                 @click="shareModalOpen = false"></div>

            <span class="hidden sm:inline-block sm:align-middle sm:h-screen" aria-hidden="true">&#8203;</span>

            <div x-show="shareModalOpen" 
                 x-transition:enter="ease-out duration-200"
                 x-transition:enter-start="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
                 x-transition:enter-end="opacity-100 translate-y-0 sm:scale-100"
                 x-transition:leave="ease-in duration-150"
                 x-transition:leave-start="opacity-100 translate-y-0 sm:scale-100"
                 x-transition:leave-end="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
                 class="inline-block align-bottom bg-white rounded-3xl text-left overflow-hidden shadow-2xl transform transition-all sm:my-8 sm:align-middle sm:max-w-md sm:w-full border border-slate-200 p-6 sm:p-8">
                
                <div class="flex items-center justify-between pb-3.5 border-b border-slate-100 mb-5">
                    <div class="flex items-center gap-2.5">
                        <div class="w-8 h-8 rounded-lg bg-slate-100 text-slate-900 flex items-center justify-center">
                            <span class="material-symbols-outlined text-[18px]">share</span>
                        </div>
                        <div>
                            <h3 class="text-base font-bold text-slate-900">Share Listing</h3>
                            <p class="text-[11px] text-slate-500">Share verified listing with friends or family</p>
                        </div>
                    </div>
                    <button @click="shareModalOpen = false" type="button" class="h-8 w-8 rounded-full bg-slate-100 hover:bg-slate-200 flex items-center justify-center text-slate-600 transition cursor-pointer">
                        <span class="material-symbols-outlined text-sm">close</span>
                    </button>
                </div>

                <div class="space-y-4">
                    <div class="p-3.5 rounded-2xl bg-slate-50 border border-slate-200">
                        <h4 class="text-xs font-bold text-slate-900 line-clamp-1" x-text="shareData.title"></h4>
                        <p class="text-[11px] text-slate-500 line-clamp-1 mt-0.5" x-text="shareData.address"></p>
                        <span class="text-xs font-bold text-slate-900 mt-1 block" x-text="shareData.price"></span>
                    </div>

                    <div class="grid grid-cols-2 gap-3">
                        <a :href="'https://wa.me/?text=' + encodeURIComponent(shareData.title + ' (' + shareData.price + ')\\n' + shareData.address + '\\nVerified 0% Brokerage on HomiQ:\\n' + shareData.url)" target="_blank" class="h-11 rounded-xl bg-emerald-600 hover:bg-emerald-700 text-white font-bold text-xs flex items-center justify-center gap-1.5 shadow-xs transition">
                            <span class="material-symbols-outlined text-base">chat</span>
                            <span>WhatsApp</span>
                        </a>
                        <button type="button" @click="copyToClipboard(shareData.url)" class="h-11 rounded-xl bg-slate-900 hover:bg-slate-800 text-white font-bold text-xs flex items-center justify-center gap-1.5 shadow-xs transition cursor-pointer">
                            <span class="material-symbols-outlined text-base">content_copy</span>
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
                 x-transition:enter="ease-out duration-200"
                 x-transition:enter-start="opacity-0"
                 x-transition:enter-end="opacity-100"
                 x-transition:leave="ease-in duration-150"
                 x-transition:leave-start="opacity-100"
                 x-transition:leave-end="opacity-0"
                 class="fixed inset-0 bg-slate-950/60 backdrop-blur-sm transition-opacity" 
                 @click="filtersModalOpen = false"></div>

            <span class="hidden sm:inline-block sm:align-middle sm:h-screen" aria-hidden="true">&#8203;</span>

            <div x-show="filtersModalOpen" 
                 x-transition:enter="ease-out duration-200"
                 x-transition:enter-start="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
                 x-transition:enter-end="opacity-100 translate-y-0 sm:scale-100"
                 x-transition:leave="ease-in duration-150"
                 x-transition:leave-start="opacity-100 translate-y-0 sm:scale-100"
                 x-transition:leave-end="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
                 class="inline-block align-bottom bg-white rounded-3xl text-left overflow-hidden shadow-2xl transform transition-all sm:my-8 sm:align-middle sm:max-w-lg sm:w-full border border-slate-200 p-6 sm:p-8">
                
                <div class="flex items-center justify-between pb-3.5 border-b border-slate-100 mb-5">
                    <div class="flex items-center gap-2.5">
                        <div class="w-8 h-8 rounded-lg bg-slate-100 text-slate-900 flex items-center justify-center">
                            <span class="material-symbols-outlined text-[18px]">tune</span>
                        </div>
                        <h3 class="text-base font-bold text-slate-900">Advanced Property Filters</h3>
                    </div>
                    <button @click="filtersModalOpen = false" type="button" class="h-8 w-8 rounded-full bg-slate-100 hover:bg-slate-200 flex items-center justify-center text-slate-600 transition cursor-pointer">
                        <span class="material-symbols-outlined text-sm">close</span>
                    </button>
                </div>

                <form action="/#listings" method="GET" class="space-y-4 text-xs font-semibold text-slate-700">
                    <input type="hidden" name="search" value="{{ request('search') }}">
                    <input type="hidden" name="city" value="{{ $selectedCity ?? request('city') }}">

                    <!-- Purpose -->
                    <div>
                        <label class="block text-slate-700 mb-1.5">Listing Purpose</label>
                        <div class="grid grid-cols-2 gap-2.5">
                            <label class="flex items-center justify-center p-2.5 rounded-xl border border-slate-200 cursor-pointer has-[:checked]:border-slate-900 has-[:checked]:bg-slate-900 has-[:checked]:text-white">
                                <input type="radio" name="listing_type" value="rent" class="hidden" {{ request('listing_type', 'rent') === 'rent' ? 'checked' : '' }}>
                                <span>Rent</span>
                            </label>
                            <label class="flex items-center justify-center p-2.5 rounded-xl border border-slate-200 cursor-pointer has-[:checked]:border-slate-900 has-[:checked]:bg-slate-900 has-[:checked]:text-white">
                                <input type="radio" name="listing_type" value="sale" class="hidden" {{ request('listing_type') === 'sale' ? 'checked' : '' }}>
                                <span>Buy / Sale</span>
                            </label>
                        </div>
                    </div>

                    <!-- Bedrooms -->
                    <div>
                        <label class="block text-slate-700 mb-1.5">Bedrooms (BHK)</label>
                        <div class="grid grid-cols-4 gap-2">
                            @foreach(['all' => 'Any BHK', '1' => '1 BHK', '2' => '2 BHK', '3' => '3+ BHK'] as $key => $lbl)
                            <label class="flex items-center justify-center p-2 rounded-xl border border-slate-200 cursor-pointer has-[:checked]:border-slate-900 has-[:checked]:bg-slate-900 has-[:checked]:text-white text-center">
                                <input type="radio" name="bedrooms" value="{{ $key }}" class="hidden" {{ request('bedrooms', 'all') == $key ? 'checked' : '' }}>
                                <span>{{ $lbl }}</span>
                            </label>
                            @endforeach
                        </div>
                    </div>

                    <!-- Budget & Deposit Limits -->
                    <div class="grid grid-cols-2 gap-3">
                        <div>
                            <label class="block text-slate-700 mb-1">Max Budget (₹)</label>
                            <select name="max_price" class="w-full px-3 py-2 rounded-xl bg-slate-50 border border-slate-200 text-slate-900 text-xs font-semibold">
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
                            <label class="block text-slate-700 mb-1">Max Deposit (₹)</label>
                            <select name="max_deposit" class="w-full px-3 py-2 rounded-xl bg-slate-50 border border-slate-200 text-slate-900 text-xs font-semibold">
                                <option value="">Any Deposit</option>
                                <option value="20000" {{ request('max_deposit') == '20000' ? 'selected' : '' }}>Up to ₹20,000</option>
                                <option value="50000" {{ request('max_deposit') == '50000' ? 'selected' : '' }}>Up to ₹50,000</option>
                                <option value="100000" {{ request('max_deposit') == '100000' ? 'selected' : '' }}>Up to ₹1,00,000</option>
                            </select>
                        </div>
                    </div>

                    <!-- Direct Toggles -->
                    <div class="space-y-2 pt-1">
                        <label class="flex items-center gap-3 p-2.5 rounded-xl bg-slate-50 border border-slate-200 cursor-pointer">
                            <input type="checkbox" name="near_metro" value="1" {{ request('near_metro') ? 'checked' : '' }} class="h-4 w-4 rounded text-slate-900 focus:ring-slate-900 border-slate-300">
                            <div>
                                <span class="block text-xs font-bold text-slate-900">Near Metro Station</span>
                                <span class="block text-[10px] text-slate-500 font-normal">Walking distance to metro connectivity</span>
                            </div>
                        </label>

                        <label class="flex items-center gap-3 p-2.5 rounded-xl bg-slate-50 border border-slate-200 cursor-pointer">
                            <input type="checkbox" name="available_now" value="1" {{ request('available_now') ? 'checked' : '' }} class="h-4 w-4 rounded text-slate-900 focus:ring-slate-900 border-slate-300">
                            <div>
                                <span class="block text-xs font-bold text-slate-900">Available Immediately</span>
                                <span class="block text-[10px] text-slate-500 font-normal">Ready to move-in right away</span>
                            </div>
                        </label>

                        <label class="flex items-center gap-3 p-2.5 rounded-xl bg-slate-50 border border-slate-200 cursor-pointer">
                            <input type="checkbox" name="is_furnished" value="1" {{ request('is_furnished') ? 'checked' : '' }} class="h-4 w-4 rounded text-slate-900 focus:ring-slate-900 border-slate-300">
                            <div>
                                <span class="block text-xs font-bold text-slate-900">Furnished / Semi-Furnished</span>
                                <span class="block text-[10px] text-slate-500 font-normal">Includes beds, wardrobes, appliances</span>
                            </div>
                        </label>
                    </div>

                    <div class="pt-3 flex items-center gap-2.5">
                        <a href="/#listings" class="flex-1 py-2.5 text-center rounded-xl border border-slate-200 bg-slate-50 hover:bg-slate-100 text-slate-700 font-semibold text-xs">
                            Reset
                        </a>
                        <button type="submit" class="flex-2 py-2.5 rounded-xl bg-slate-900 hover:bg-slate-800 text-white font-bold text-xs shadow-sm cursor-pointer">
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
