<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="scroll-smooth">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    
    <title>{{ $pageTitle }}</title>
    <meta name="description" content="{{ $metaDescription }}">
    <link rel="canonical" href="{{ $canonicalUrl }}">

    <!-- OpenGraph / Social -->
    <meta property="og:type" content="website">
    <meta property="og:title" content="{{ $pageTitle }}">
    <meta property="og:description" content="{{ $metaDescription }}">
    <meta property="og:url" content="{{ $canonicalUrl }}">
    <meta property="og:site_name" content="HomiQ">
    
    <!-- Fonts & Icons -->
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

    <!-- Structured Data: Breadcrumbs -->
    <script type="application/ld+json">
    {
      "@@context": "https://schema.org",
      "@@type": "BreadcrumbList",
      "itemListElement": [
        @foreach($breadcrumbs as $index => $crumb)
        {
          "@@type": "ListItem",
          "position": {{ $index + 1 }},
          "name": "{{ $crumb['name'] }}",
          "item": "{{ $crumb['url'] }}"
        }
        @if(!$loop->last),@endif
        @endforeach
      ]
    }
    </script>

    <!-- Structured Data: ItemList / RealEstateListings -->
    @if($properties->isNotEmpty())
    <script type="application/ld+json">
    {
      "@@context": "https://schema.org",
      "@@type": "ItemList",
      "itemListElement": [
        @foreach($properties->take(10) as $index => $prop)
        {
          "@@type": "ListItem",
          "position": {{ $index + 1 }},
          "url": "{{ $prop->seo_url }}",
          "name": "{{ $prop->title }}"
        }
        @if(!$loop->last),@endif
        @endforeach
      ]
    }
    </script>
    @endif

    <!-- Structured Data: FAQPage -->
    @if(!empty($faqs))
    <script type="application/ld+json">
    {
      "@@context": "https://schema.org",
      "@@type": "FAQPage",
      "mainEntity": [
        @foreach($faqs as $faq)
        {
          "@@type": "Question",
          "name": "{{ $faq['question'] }}",
          "acceptedAnswer": {
            "@@type": "Answer",
            "text": "{{ $faq['answer'] }}"
          }
        }
        @if(!$loop->last),@endif
        @endforeach
      ]
    }
    </script>
    @endif
</head>
<body class="bg-slate-50 text-slate-900 font-sans antialiased min-h-screen flex flex-col justify-between selection:bg-emerald-500 selection:text-white" x-data="{ activeFaq: null, toastMessage: '', showToast(msg) { this.toastMessage = msg; setTimeout(() => this.toastMessage = '', 3000); } }">

    <!-- Toast Notification -->
    <div x-show="toastMessage" 
         x-transition:enter="transition ease-out duration-300 transform"
         x-transition:enter-start="opacity-0 translate-y-2"
         x-transition:enter-end="opacity-100 translate-y-0"
         x-transition:leave="transition ease-in duration-200"
         x-transition:leave-start="opacity-100"
         x-transition:leave-end="opacity-0"
         class="fixed bottom-6 right-6 z-50 bg-slate-900 text-white px-5 py-3 rounded-2xl shadow-xl border border-slate-800 flex items-center gap-2.5 text-xs font-bold"
         style="display: none;">
        <span class="material-symbols-outlined text-emerald-400 text-base">check_circle</span>
        <span x-text="toastMessage"></span>
    </div>

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
                        <span class="text-[10px] font-extrabold uppercase tracking-widest text-emerald-600">0% Brokerage</span>
                    </div>
                <a href="/" class="flex items-center group">
                    <img src="{{ asset('logo.png') }}" alt="HomiQ" class="h-9 w-auto object-contain transition-transform duration-300 group-hover:scale-105">
                </a>

                <nav class="hidden md:flex items-center gap-6 text-xs font-bold text-slate-600">
                    <a href="/rent/noida" class="hover:text-emerald-700 transition">Rent in Noida</a>
                    <a href="/rent/flats/sector-137-noida" class="hover:text-emerald-700 transition">Sector 137</a>
                    <a href="/explore/pgs-in-noida" class="hover:text-emerald-700 transition">PGs &amp; Rooms</a>
                    <a href="/guides" class="hover:text-emerald-700 transition">Rental Guides</a>
                    <a href="/owners" class="hover:text-emerald-700 transition">For Owners</a>
                </nav>
            </div>

            <div class="flex items-center gap-3">
                <a href="{{ route('owners.landing') }}" class="h-11 px-5 rounded-full bg-emerald-600 hover:bg-emerald-700 text-white font-bold text-xs flex items-center gap-1.5 transition shadow-sm">
                    <span class="material-symbols-outlined text-[17px]">add_home</span>
                    <span>List Free</span>
                </a>
            </div>
        </div>
    </header>

    <main class="max-w-[1440px] mx-auto px-6 sm:px-8 py-8 w-full">
        <!-- Breadcrumbs Navigation -->
        <nav class="flex items-center gap-2 text-xs font-semibold text-slate-500 mb-6 overflow-x-auto no-scrollbar" aria-label="Breadcrumb">
            @foreach($breadcrumbs as $index => $crumb)
                @if(!$loop->last)
                    <a href="{{ $crumb['url'] }}" class="hover:text-emerald-700 transition shrink-0">{{ $crumb['name'] }}</a>
                    <span class="material-symbols-outlined text-sm text-slate-400 shrink-0">chevron_right</span>
                @else
                    <span class="text-slate-900 font-bold truncate">{{ $crumb['name'] }}</span>
                @endif
            @endforeach
        </nav>

        <!-- Page Header (Single Primary H1) -->
        <div class="bg-white rounded-3xl p-8 sm:p-12 border border-slate-200 shadow-sm mb-10">
            <div class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full bg-emerald-50 text-emerald-800 text-xs font-bold uppercase tracking-wider mb-3 border border-emerald-200">
                <span class="material-symbols-outlined text-[16px]">verified</span>
                Verified Listings • 0% Brokerage
            </div>
            <h1 class="text-3xl sm:text-4xl lg:text-5xl font-black text-slate-900 tracking-tight leading-tight">
                {{ $h1Title }}
            </h1>
            <p class="text-sm sm:text-base text-slate-600 mt-2 max-w-3xl font-medium leading-relaxed">
                {{ $metaDescription }}
            </p>

            <!-- Quick Stats -->
            <div class="flex items-center gap-6 mt-6 pt-6 border-t border-slate-100 flex-wrap text-xs font-bold text-slate-700">
                <div class="flex items-center gap-2">
                    <span class="material-symbols-outlined text-emerald-600 text-lg">apartment</span>
                    <span>{{ $properties->count() }} Verified Spaces Available</span>
                </div>
                <div class="flex items-center gap-2">
                    <span class="material-symbols-outlined text-emerald-600 text-lg">money_off</span>
                    <span>Direct Owner Contact (0% Commission)</span>
                </div>
                <div class="flex items-center gap-2">
                    <span class="material-symbols-outlined text-emerald-600 text-lg">schedule</span>
                    <span>30-Day Freshness Audited</span>
                </div>
            </div>
        </div>

        <!-- LISTINGS FEED -->
        <section class="mb-16">
            <div class="flex items-center justify-between mb-6">
                <h2 class="text-xl sm:text-2xl font-black text-slate-900">
                    Available Properties ({{ $properties->count() }})
                </h2>
                <a href="/" class="text-xs font-bold text-emerald-700 hover:underline flex items-center gap-1">
                    <span>Change Filters</span>
                    <span class="material-symbols-outlined text-sm">tune</span>
                </a>
            </div>

            @if($properties->isEmpty())
                <div class="bg-white rounded-3xl p-12 text-center border border-slate-200 space-y-4">
                    <div class="h-16 w-16 bg-slate-100 rounded-full flex items-center justify-center mx-auto text-slate-400">
                        <span class="material-symbols-outlined text-3xl">home_work</span>
                    </div>
                    <h3 class="text-lg font-bold text-slate-800">No properties currently matched in this micro-location</h3>
                    <p class="text-xs text-slate-500 max-w-md mx-auto font-medium">
                        We refresh inventory continuously. You can post a tenant request or explore nearby verified sectors.
                    </p>
                    <div class="pt-2 flex items-center justify-center gap-3">
                        <a href="/" class="h-11 px-6 rounded-full bg-slate-900 text-white font-bold text-xs inline-flex items-center justify-center">Explore All Properties</a>
                        <a href="{{ route('owners.landing') }}" class="h-11 px-6 rounded-full bg-emerald-600 text-white font-bold text-xs inline-flex items-center justify-center">I Have a Flat Here (List Free)</a>
                    </div>
                </div>
            @else
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                    @foreach($properties as $property)
                        <x-property-card :property="$property" />
                    @endforeach
                </div>
            @endif
        </section>

        <!-- SISTER LOCATIONS & INTERNAL LINKING (TASK 24) -->
        <section class="bg-white rounded-3xl p-8 border border-slate-200 shadow-sm mb-16">
            <h2 class="text-xl font-black text-slate-900 mb-2">Explore Related Localities &amp; Hubs</h2>
            <p class="text-xs font-semibold text-slate-600 mb-6">Discover verified homes across popular metro stations, IT corridors, and residential sectors.</p>

            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4">
                @foreach($sisterLocations as $sister)
                <a href="{{ $sister['url'] }}" class="p-4 rounded-2xl bg-slate-50 hover:bg-emerald-50 border border-slate-200 hover:border-emerald-300 transition-all flex items-center justify-between group">
                    <div>
                        <span class="text-xs font-bold text-slate-900 group-hover:text-emerald-900 block">{{ $sister['name'] }}</span>
                        <span class="text-[11px] text-slate-500 font-medium">{{ $sister['subtitle'] }}</span>
                    </div>
                    <span class="material-symbols-outlined text-slate-400 group-hover:text-emerald-700 group-hover:translate-x-1 transition-transform text-lg">arrow_forward</span>
                </a>
                @endforeach
            </div>
        </section>

        <!-- FAQS SECTION WITH JSON-LD GROUNDING -->
        @if(!empty($faqs))
        <section class="bg-white rounded-3xl p-8 border border-slate-200 shadow-sm mb-16" id="location-faqs">
            <div class="mb-8">
                <span class="text-xs font-bold uppercase tracking-wider text-emerald-700 block mb-1">Local Insights</span>
                <h2 class="text-2xl font-black text-slate-900 tracking-tight">Frequently Asked Questions</h2>
            </div>

            <div class="space-y-4">
                @foreach($faqs as $index => $faq)
                <div class="border border-slate-200 rounded-2xl overflow-hidden">
                    <button type="button" @click="activeFaq = (activeFaq === {{ $index }} ? null : {{ $index }})" class="w-full p-5 text-left flex items-center justify-between gap-4 font-bold text-slate-900 text-sm">
                        <span>{{ $faq['question'] }}</span>
                        <span class="material-symbols-outlined text-slate-400 transition-transform" :class="activeFaq === {{ $index }} ? 'rotate-180 text-emerald-600' : ''">expand_more</span>
                    </button>
                    <div x-show="activeFaq === {{ $index }}" x-collapse class="px-5 pb-5 text-xs sm:text-sm text-slate-600 leading-relaxed font-medium">
                        {{ $faq['answer'] }}
                    </div>
                </div>
                @endforeach
            </div>
        </section>
        @endif

        <!-- OWNER ACQUISITION BANNER IN LOCATION PAGE -->
        <section class="rounded-3xl bg-brandNavy text-white p-8 sm:p-12 border border-slate-800 mb-8 flex flex-col md:flex-row items-center justify-between gap-6">
            <div class="space-y-2">
                <span class="text-xs font-bold uppercase tracking-wider text-emerald-400">Landlords &amp; Property Hosts</span>
                <h2 class="text-2xl sm:text-3xl font-black text-white">Own a flat or space in {{ $localityName ?? $cityName ?? 'this area' }}?</h2>
                <p class="text-xs sm:text-sm text-slate-300 font-medium max-w-xl">
                    List your home on HomiQ for free and connect directly with verified buyers and tenants with zero brokerage.
                </p>
            </div>
            <a href="{{ route('owners.landing') }}" class="shrink-0 h-12 px-7 rounded-full bg-emerald-600 hover:bg-emerald-500 text-white font-bold text-xs flex items-center gap-2 shadow-sm transition">
                <span>List Property Free</span>
                <span class="material-symbols-outlined text-base">arrow_forward</span>
            </a>
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
                <a href="/guides" class="hover:text-slate-900 transition">Rental Guides</a>
                <a href="/privacy" class="hover:text-slate-900 transition">Privacy</a>
                <a href="/terms" class="hover:text-slate-900 transition">Terms</a>
            </div>
        </div>
    </footer>

</body>
</html>
