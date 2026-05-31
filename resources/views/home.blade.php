@extends('layouts.app')

@section('content')
<style>
    /* Advanced Card and Icon Animations */
    .premium-card {
        position: relative;
        overflow: hidden;
        border-radius: 12px; /* Strict professional low radius */
        border: 1px solid #f1f5f9;
        background-color: #ffffff;
        transform-style: preserve-3d;
        perspective: 1000px;
        transition: transform 0.8s cubic-bezier(0.16, 1, 0.3, 1), 
                    box-shadow 0.8s cubic-bezier(0.16, 1, 0.3, 1), 
                    border-color 0.8s cubic-bezier(0.16, 1, 0.3, 1);
    }
    
    .premium-card.dark-theme {
        border-color: #334155;
        background-color: #1e293b;
    }
    
    /* Shimmer Sweep Animation on Hover */
    .premium-card::after {
        content: '';
        position: absolute;
        top: 0;
        left: -150%;
        width: 100%;
        height: 100%;
        background: linear-gradient(
            90deg,
            transparent,
            rgba(255, 255, 255, 0.35),
            transparent
        );
        transform: skewX(-20deg);
        z-index: 10;
        pointer-events: none;
    }
    
    .premium-card:hover::after {
        left: 150%;
        transition: all 0.9s cubic-bezier(0.16, 1, 0.3, 1);
    }
    
    .premium-card:hover {
        transform: translateY(-8px) scale(1.02) rotateX(1deg) rotateY(-1deg);
        box-shadow: 0 30px 60px -15px rgba(26, 68, 124, 0.16), 0 10px 22px -10px rgba(0, 0, 0, 0.08);
        border-color: rgba(26, 68, 124, 0.35);
    }
    
    .premium-card.dark-theme:hover {
        border-color: rgba(52, 211, 153, 0.35);
        box-shadow: 0 30px 60px -15px rgba(52, 211, 153, 0.16), 0 10px 22px -10px rgba(0, 0, 0, 0.18);
    }

    /* Icon Spring Bounce Effect */
    .category-btn {
        transition: transform 0.5s cubic-bezier(0.175, 0.885, 0.32, 1.275), 
                    box-shadow 0.5s cubic-bezier(0.16, 1, 0.3, 1),
                    background-color 0.4s ease;
    }
    .category-btn:hover {
        transform: translateY(-6px);
    }
    .category-btn:hover .icon-wrapper {
        transform: scale(1.08);
    }
    .icon-wrapper {
        transition: transform 0.5s cubic-bezier(0.175, 0.885, 0.32, 1.275);
    }

    /* Hero Floating Showcase Animation */
    @keyframes heroFloat {
        0% { transform: translateY(0px) rotate(0deg); }
        50% { transform: translateY(-15px) rotate(0.5deg); }
        100% { transform: translateY(0px) rotate(0deg); }
    }
    .hero-floating-card {
        animation: heroFloat 6s ease-in-out infinite;
    }

    /* Infinite Marquee Scroll for Space Providers */
    @keyframes marquee {
        0% { transform: translateX(0); }
        100% { transform: translateX(-50%); }
    }
</style>

<!-- Search Bar Section -->
<section class="max-w-4xl mx-auto px-6 pt-12 pb-6">
    <form action="/" method="GET" class="w-full bg-white p-2.5 rounded-xl flex flex-col md:flex-row items-center gap-2 shadow-md border border-slate-100">
        <div class="flex items-center w-full px-3">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-slate-400 mr-2 flex-shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
            </svg>
            <input type="text" name="search" placeholder="Search address, city, space title..." value="{{ $search }}"
                class="w-full py-3 text-slate-800 text-sm focus:outline-none placeholder-slate-400 bg-transparent">
        </div>
        <button type="submit" class="w-full md:w-auto px-8 py-3.5 bg-steelAzure hover:bg-steelAzure/95 text-white rounded-lg text-xs font-bold transition-all duration-200 whitespace-nowrap flex-shrink-0">
            Search Spaces
        </button>
    </form>
</section>

<!-- Section 3: Interactive Category cards with Big Icons -->
<section class="max-w-7xl mx-auto px-6 py-16 scroll-reveal">
    <div class="mb-10 text-center md:text-left">
        <h2 class="text-2xl font-extrabold text-slate-800 tracking-tight">Browse Spaces by Category</h2>
        <p class="text-sm text-slate-400 mt-1">Select a category to view all properties of that type</p>
    </div>
    <div class="grid grid-cols-2 sm:grid-cols-3 lg:grid-cols-6 gap-6">
        @foreach ($categories as $cat)
            <a href="/category/{{ $cat['name'] }}" 
               class="category-btn group bg-white border border-slate-100 rounded-xl p-6 text-center flex flex-col items-center justify-center gap-4 hover:shadow-[0_25px_50px_rgba(26,68,124,0.08)]">
                <div class="icon-wrapper h-24 w-24 rounded-full overflow-hidden border-2 border-slate-100 group-hover:border-steelAzure/50 transition-all duration-300">
                    <img src="{{ $cat['image'] }}" alt="{{ $cat['name'] }}" class="w-full h-full object-cover transition-transform duration-500 group-hover:scale-110">
                </div>
                <span class="text-xs font-extrabold text-slate-800 tracking-wider uppercase transition group-hover:text-steelAzure">{{ $cat['name'] }}</span>
            </a>
        @endforeach
    </div>
</section>

<!-- Section 4: Recommended Spaces Directory -->
<section class="max-w-7xl mx-auto px-6 py-16 scroll-reveal">
    <div class="flex items-center justify-between mb-10 border-b border-slate-100 pb-6">
        <div>
            <h2 class="text-2xl md:text-3xl font-extrabold text-slate-800 tracking-tight">
                @if ($search)
                    Search Results for "{{ $search }}"
                @else
                    Recommended Spaces to Lease
                @endif
            </h2>
            <p class="text-sm text-slate-400 mt-1">Explore top-tier verified properties, rooms, and spots ready for you.</p>
        </div>
        <div>
            <a href="/" class="text-xs font-bold text-steelAzure hover:underline flex items-center gap-1.5 bg-slate-100 hover:bg-steelAzure hover:text-white px-4 py-2.5 rounded-xl transition-all duration-300">
                View More
                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" /></svg>
            </a>
        </div>
    </div>

    @if ($properties->isEmpty())
        <div class="bg-white rounded-xl border border-slate-100 p-16 text-center text-slate-400 shadow-sm max-w-xl mx-auto">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-12 w-12 text-slate-300 mx-auto mb-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4" />
            </svg>
            <p class="font-bold text-slate-700">No Spaces Available</p>
            <p class="text-xs text-slate-400 mt-1">Try tweaking your search parameters or category filter.</p>
        </div>
    @else
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-8">
            @foreach ($properties->take(8) as $prop)
                <a href="/properties/{{ $prop->id }}" class="premium-card group flex flex-col h-full">
                    <!-- Image -->
                    <div class="h-52 bg-slate-100 overflow-hidden relative">
                        <img src="{{ !empty($prop->images) && is_array($prop->images) ? $prop->images[0] : 'https://images.unsplash.com/photo-1564013799919-ab600027ffc6?auto=format&fit=crop&w=800&q=80' }}" 
                             alt="space" class="h-full w-full object-cover group-hover:scale-110 transition-transform duration-750 ease-in-out">
                        <span class="absolute top-4 right-4 px-2.5 py-1 bg-white/95 backdrop-blur-sm text-[10px] font-extrabold text-steelAzure rounded-lg uppercase tracking-wide">
                            {{ $prop->category }}
                        </span>
                    </div>

                    <!-- Details -->
                    <div class="p-5 flex-1 flex flex-col justify-between">
                        <div>
                            <h3 class="font-bold text-slate-800 text-base mb-1 truncate group-hover:text-steelAzure transition-colors duration-155">{{ $prop->title }}</h3>
                            <div class="flex items-center gap-1.5 text-xs text-slate-400 mb-4">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 flex-shrink-0 text-slate-300" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" />
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" />
                                </svg>
                                <span class="truncate">{{ $prop->address }}</span>
                            </div>
                        </div>

                        <div>
                            <div class="flex items-center justify-between border-t border-slate-50 pt-4">
                                <span class="text-base font-bold text-steelAzure">₹{{ number_format($prop->price, 0) }}<span class="text-[10px] text-slate-400 font-normal">/mo</span></span>
                                <span class="text-xs text-slate-400 font-medium">{{ $prop->bedrooms }} bd • {{ $prop->bathrooms }} ba</span>
                            </div>
                        </div>
                    </div>
                </a>
            @endforeach
        </div>
    @endif
</section>

<!-- Section 5: Premium Beachfront Villas -->
<section class="bg-slate-50/50 border-y border-slate-100 py-20 px-6 scroll-reveal">
    <div class="max-w-7xl mx-auto">
        <div class="flex flex-col md:flex-row items-baseline justify-between mb-12">
            <div>
                <span class="text-xs font-bold text-steelAzure uppercase tracking-widest block mb-2">Exquisite Escapes</span>
                <h2 class="text-2xl md:text-3xl font-extrabold text-slate-800">Premium Beachfront Villas</h2>
            </div>
            <a href="/category/Villa" class="text-xs font-bold text-steelAzure hover:underline flex items-center gap-1.5">
                View All Villas 
                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" /></svg>
            </a>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
            @forelse ($properties->where('category', 'Villa')->take(3) as $villa)
                <a href="/properties/{{ $villa->id }}" class="premium-card group flex flex-col">
                    <div class="h-48 overflow-hidden relative">
                        <img src="{{ !empty($villa->images) && is_array($villa->images) ? $villa->images[0] : 'https://images.unsplash.com/photo-1512917774080-9991f1c4c750?auto=format&fit=crop&w=800&q=80' }}" alt="villa" class="h-full w-full object-cover group-hover:scale-110 transition-transform duration-750 ease-in-out">
                    </div>
                    <div class="p-6">
                        <h3 class="font-bold text-slate-800 text-sm mb-1 truncate group-hover:text-steelAzure transition">{{ $villa->title }}</h3>
                        <p class="text-xs text-slate-400 mb-3 truncate">{{ $villa->address }}</p>
                        <div class="flex items-center justify-between border-t border-slate-50 pt-3">
                            <span class="text-sm font-bold text-steelAzure">₹{{ number_format($villa->price, 0) }}/mo</span>
                            <span class="text-xs text-slate-500">{{ $villa->bedrooms }} Beds</span>
                        </div>
                    </div>
                </a>
            @empty
                <div class="col-span-3 text-center text-xs text-slate-400 py-8 bg-white border border-slate-100 rounded-xl">
                    No premium villas available at the moment.
                </div>
            @endforelse
        </div>
    </div>
</section>

<!-- Section 6: Top Flats Nearby You -->
<section class="max-w-7xl mx-auto px-6 py-20 scroll-reveal">
    <div class="flex flex-col md:flex-row items-baseline justify-between mb-12">
        <div>
            <span class="text-xs font-bold text-indigo-600 uppercase tracking-widest block mb-2">Prime Living</span>
            <h2 class="text-2xl md:text-3xl font-extrabold text-slate-800">Top Flats Nearby You</h2>
        </div>
        <a href="/category/Apartment" class="text-xs font-bold text-indigo-600 hover:underline">Explore Flats</a>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
        @forelse ($properties->where('category', 'Apartment')->take(3) as $flat)
            <a href="/properties/{{ $flat->id }}" class="premium-card group flex flex-col">
                <div class="h-48 overflow-hidden relative">
                    <img src="{{ !empty($flat->images) && is_array($flat->images) ? $flat->images[0] : 'https://images.unsplash.com/photo-1522708323590-d24dbb6b0267?auto=format&fit=crop&w=800&q=80' }}" alt="flat" class="h-full w-full object-cover group-hover:scale-110 transition-transform duration-750 ease-in-out">
                </div>
                <div class="p-6">
                    <h3 class="font-bold text-slate-800 text-sm mb-1 truncate group-hover:text-indigo-600 transition">{{ $flat->title }}</h3>
                    <p class="text-xs text-slate-400 mb-3 truncate">{{ $flat->address }}</p>
                    <div class="flex items-center justify-between border-t border-slate-50 pt-3">
                        <span class="text-sm font-bold text-slate-800">₹{{ number_format($flat->price, 0) }}/mo</span>
                        <span class="text-xs text-slate-500">{{ $flat->bedrooms }} Beds</span>
                    </div>
                </div>
            </a>
        @empty
            <div class="col-span-3 text-center text-xs text-slate-400 py-8 bg-white border border-slate-100 rounded-xl">
                No flats listed in your area currently.
            </div>
        @endforelse
    </div>
</section>

<!-- Section 7: Best PG for Girls -->
<section class="bg-rose-50/30 border-y border-rose-100/50 py-20 px-6 scroll-reveal">
    <div class="max-w-7xl mx-auto">
        <div class="flex flex-col md:flex-row items-baseline justify-between mb-12">
            <div>
                <span class="text-xs font-bold text-rose-600 uppercase tracking-widest block mb-2">Safe & Comfortable</span>
                <h2 class="text-2xl md:text-3xl font-extrabold text-slate-800">Best PG for Girls</h2>
            </div>
            <a href="/category/Studio" class="text-xs font-bold text-rose-600 hover:underline">Explore PG Studios</a>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
            @forelse ($properties->where('category', 'Studio')->take(3) as $pg)
                <a href="/properties/{{ $pg->id }}" class="premium-card group flex flex-col">
                    <div class="h-48 overflow-hidden relative">
                        <img src="{{ !empty($pg->images) && is_array($pg->images) ? $pg->images[0] : 'https://images.unsplash.com/photo-1502672260266-1c1ef2d93688?auto=format&fit=crop&w=800&q=80' }}" alt="pg" class="h-full w-full object-cover group-hover:scale-110 transition-transform duration-750 ease-in-out">
                        <span class="absolute top-4 right-4 px-2.5 py-1 bg-rose-500 text-white text-[9px] font-bold rounded-lg uppercase tracking-wide">
                            Women Friendly
                        </span>
                    </div>
                    <div class="p-6">
                        <h3 class="font-bold text-slate-800 text-sm mb-1 truncate group-hover:text-rose-600 transition">{{ $pg->title }}</h3>
                        <p class="text-xs text-slate-400 mb-3 truncate">{{ $pg->address }}</p>
                        <div class="flex items-center justify-between border-t border-slate-50 pt-3">
                            <span class="text-sm font-bold text-rose-600">₹{{ number_format($pg->price, 0) }}/mo</span>
                            <span class="text-xs text-slate-500">24/7 Security</span>
                        </div>
                    </div>
                </a>
            @empty
                <div class="col-span-3 text-center text-xs text-slate-400 py-8 bg-white border border-slate-100 rounded-xl">
                    No girl-friendly PGs listed currently.
                </div>
            @endforelse
        </div>
    </div>
</section>

<!-- Section 8: PG Nearby You -->
<section class="max-w-7xl mx-auto px-6 py-20 scroll-reveal">
    <div class="flex flex-col md:flex-row items-baseline justify-between mb-12">
        <div>
            <span class="text-xs font-bold text-emerald-600 uppercase tracking-widest block mb-2">Budget Stays</span>
            <h2 class="text-2xl md:text-3xl font-extrabold text-slate-800">PG Nearby You</h2>
        </div>
        <a href="/category/Studio" class="text-xs font-bold text-emerald-600 hover:underline">Explore Rooms</a>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
        @forelse ($properties->where('category', 'Studio')->take(3) as $pgRoom)
            <a href="/properties/{{ $pgRoom->id }}" class="premium-card group flex flex-col">
                <div class="h-48 overflow-hidden relative">
                    <img src="{{ !empty($pgRoom->images) && is_array($pgRoom->images) ? $pgRoom->images[0] : 'https://images.unsplash.com/photo-1502672260266-1c1ef2d93688?auto=format&fit=crop&w=800&q=80' }}" alt="pg" class="h-full w-full object-cover group-hover:scale-110 transition-transform duration-750 ease-in-out">
                </div>
                <div class="p-6">
                    <h3 class="font-bold text-slate-800 text-sm mb-1 truncate group-hover:text-emerald-600 transition">{{ $pgRoom->title }}</h3>
                    <p class="text-xs text-slate-400 mb-3 truncate">{{ $pgRoom->address }}</p>
                    <div class="flex items-center justify-between border-t border-slate-50 pt-3">
                        <span class="text-sm font-bold text-emerald-600">₹{{ number_format($pgRoom->price, 0) }}/mo</span>
                        <span class="text-xs text-slate-500">Fully Furnished</span>
                    </div>
                </div>
            </a>
        @empty
            <div class="col-span-3 text-center text-xs text-slate-400 py-8 bg-white border border-slate-100 rounded-xl">
                No budget PG rooms available.
            </div>
        @endforelse
    </div>
</section>

<!-- Section 9: Elite Business & Event Venues -->
<section class="max-w-7xl mx-auto px-6 py-12 scroll-reveal">
    <div class="flex flex-col md:flex-row items-baseline justify-between mb-12">
        <div>
            <span class="text-xs font-bold text-seaGreen uppercase tracking-widest block mb-2">Workspace & Functionality</span>
            <h2 class="text-2xl md:text-3xl font-extrabold text-slate-800">Elite Business & Event Venues</h2>
        </div>
        <div class="flex gap-4">
            <a href="/category/Shop" class="text-xs font-bold text-seaGreen hover:underline">Shops</a>
            <span class="text-slate-300">|</span>
            <a href="/category/Hall" class="text-xs font-bold text-seaGreen hover:underline">Event Halls</a>
        </div>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
        @forelse ($properties->whereIn('category', ['Shop', 'Hall'])->take(3) as $venue)
            <a href="/properties/{{ $venue->id }}" class="premium-card group flex flex-col">
                <div class="h-48 overflow-hidden relative">
                    <img src="{{ !empty($venue->images) && is_array($venue->images) ? $venue->images[0] : 'https://images.unsplash.com/photo-1497366216548-37526070297c?auto=format&fit=crop&w=800&q=80' }}" alt="venue" class="h-full w-full object-cover group-hover:scale-110 transition-transform duration-750 ease-in-out">
                </div>
                <div class="p-6">
                    <span class="px-2 py-0.5 bg-emerald-50 text-seaGreen text-[9px] font-bold rounded uppercase tracking-wider block w-max mb-2">{{ $venue->category }}</span>
                    <h3 class="font-bold text-slate-800 text-sm mb-1 truncate group-hover:text-seaGreen transition">{{ $venue->title }}</h3>
                    <p class="text-xs text-slate-400 mb-3 truncate">{{ $venue->address }}</p>
                    <div class="flex items-center justify-between border-t border-slate-50 pt-3">
                        <span class="text-sm font-bold text-slate-700">₹{{ number_format($venue->price, 0) }}/mo</span>
                        <span class="text-xs text-slate-500">Verified Spot</span>
                    </div>
                </div>
            </a>
        @empty
            <div class="col-span-3 text-center text-xs text-slate-400 py-8 bg-white border border-slate-100 rounded-xl">
                No business or event spaces currently listed.
            </div>
        @endforelse
    </div>
</section>

<!-- Section 10: Exquisite Urban Studios & Condos -->
<section class="bg-slate-900 text-white py-20 px-6 scroll-reveal">
    <div class="max-w-7xl mx-auto">
        <div class="flex flex-col md:flex-row items-baseline justify-between mb-12">
            <div>
                <span class="text-xs font-bold text-emerald-400 uppercase tracking-widest block mb-2">City Skylines</span>
                <h2 class="text-2xl md:text-3xl font-extrabold text-white">Urban Studios & Condos</h2>
            </div>
            <a href="/category/Studio" class="text-xs font-bold text-emerald-400 hover:underline">Explore Studios</a>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
            @forelse ($properties->whereIn('category', ['Studio', 'Apartment'])->take(3) as $studio)
                <a href="/properties/{{ $studio->id }}" class="premium-card dark-theme group flex flex-col">
                    <div class="h-48 overflow-hidden relative">
                        <img src="{{ !empty($studio->images) && is_array($studio->images) ? $studio->images[0] : 'https://images.unsplash.com/photo-1502672260266-1c1ef2d93688?auto=format&fit=crop&w=800&q=80' }}" alt="studio" class="h-full w-full object-cover group-hover:scale-110 transition-transform duration-750 ease-in-out">
                    </div>
                    <div class="p-6">
                        <h3 class="font-bold text-white text-sm mb-1 truncate group-hover:text-emerald-400 transition">{{ $studio->title }}</h3>
                        <p class="text-xs text-slate-400 mb-3 truncate">{{ $studio->address }}</p>
                        <div class="flex items-center justify-between border-t border-slate-700 pt-3">
                            <span class="text-sm font-bold text-emerald-400">₹{{ number_format($studio->price, 0) }}/mo</span>
                            <span class="text-xs text-slate-400">{{ $studio->bedrooms }} Beds</span>
                        </div>
                    </div>
                </a>
            @empty
                <div class="col-span-3 text-center text-xs text-slate-400 py-8 bg-slate-800 border border-slate-700 rounded-xl">
                    No active urban studios available.
                </div>
            @endforelse
        </div>
    </div>
</section>



<!-- Section 12: Popular Locations Gallery -->
<section class="max-w-7xl mx-auto px-6 pb-20 scroll-reveal">
    <div class="text-center mb-16">
        <h2 class="text-2xl md:text-3xl font-extrabold text-slate-800">Popular Locations</h2>
        <p class="text-sm text-slate-500 mt-2">Discover premium spaces listed in key destination points</p>
    </div>

    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
        <!-- Card 1 -->
        <div class="group relative rounded-xl overflow-hidden h-72 shadow-sm border border-slate-100">
            <img src="https://images.unsplash.com/photo-1507525428034-b723cf961d3e?auto=format&fit=crop&w=400&q=80" alt="Miami" class="absolute inset-0 w-full h-full object-cover group-hover:scale-105 transition-transform duration-300">
            <div class="absolute inset-0 bg-gradient-to-t from-slate-950/70 via-slate-900/10 to-transparent"></div>
            <div class="absolute bottom-6 left-6 text-white z-10">
                <h3 class="font-bold text-lg">Miami Beach</h3>
                <p class="text-[10px] text-slate-300">Beachfront Villas & Studios</p>
            </div>
        </div>
        <!-- Card 2 -->
        <div class="group relative rounded-xl overflow-hidden h-72 shadow-sm border border-slate-100">
            <img src="https://images.unsplash.com/photo-1496442226666-8d4d0e62e6e9?auto=format&fit=crop&w=400&q=80" alt="New York" class="absolute inset-0 w-full h-full object-cover group-hover:scale-105 transition-transform duration-300">
            <div class="absolute inset-0 bg-gradient-to-t from-slate-950/70 via-slate-900/10 to-transparent"></div>
            <div class="absolute bottom-6 left-6 text-white z-10">
                <h3 class="font-bold text-lg">New York City</h3>
                <p class="text-[10px] text-slate-300">Downtown Luxury Apartments</p>
            </div>
        </div>
        <!-- Card 3 -->
        <div class="group relative rounded-xl overflow-hidden h-72 shadow-sm border border-slate-100">
            <img src="https://images.unsplash.com/photo-1531842477197-54f8c4b8b209?auto=format&fit=crop&w=400&q=80" alt="Austin" class="absolute inset-0 w-full h-full object-cover group-hover:scale-105 transition-transform duration-300">
            <div class="absolute inset-0 bg-gradient-to-t from-slate-950/70 via-slate-900/10 to-transparent"></div>
            <div class="absolute bottom-6 left-6 text-white z-10">
                <h3 class="font-bold text-lg">Austin Town</h3>
                <p class="text-[10px] text-slate-300">Cosy Family Houses</p>
            </div>
        </div>
        <!-- Card 4 -->
        <div class="group relative rounded-xl overflow-hidden h-72 shadow-sm border border-slate-100">
            <img src="https://images.unsplash.com/photo-1502082553048-f009c37129b9?auto=format&fit=crop&w=400&q=80" alt="Seattle" class="absolute inset-0 w-full h-full object-cover group-hover:scale-105 transition-transform duration-300">
            <div class="absolute inset-0 bg-gradient-to-t from-slate-950/70 via-slate-900/10 to-transparent"></div>
            <div class="absolute bottom-6 left-6 text-white z-10">
                <h3 class="font-bold text-lg">Seattle Square</h3>
                <p class="text-[10px] text-slate-300">Commercial Storefront Shops</p>
            </div>
        </div>
    </div>
</section>

<!-- Section 11: Space Providers (Animated Ticker Scrolling below Locations) -->
<section class="max-w-7xl mx-auto px-6 py-20 overflow-hidden relative scroll-reveal">
    <div class="text-center mb-12">
        <span class="text-xs font-bold text-steelAzure uppercase tracking-widest block mb-2">Space Providers</span>
        <h2 class="text-2xl md:text-3xl font-extrabold text-slate-800">Top Rated Space Lister Partners</h2>
        <p class="text-sm text-slate-500 mt-2">Verified landlords and customers maintaining premium properties</p>
    </div>

    <!-- Infinite Marquee Ticker -->
    <div class="relative w-full overflow-hidden py-6">
        <!-- Gradient overlays to fade out the edges -->
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

@endsection
