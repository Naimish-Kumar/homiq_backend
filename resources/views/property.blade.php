@extends('layouts.app')

@section('content')
<style>
    .property-img-card {
        transition: transform 0.5s cubic-bezier(0.16, 1, 0.3, 1);
    }
    .property-img-card:hover {
        transform: scale(1.02);
    }
    .info-chip {
        transition: transform 0.3s ease, box-shadow 0.3s ease;
    }
    .info-chip:hover {
        transform: translateY(-2px);
        box-shadow: 0 6px 16px -4px rgba(26, 68, 124, 0.1);
    }
    .amenity-tag {
        transition: background-color 0.3s ease, color 0.3s ease, transform 0.2s ease;
    }
    .amenity-tag:hover {
        background-color: #1A447C;
        color: #fff;
        transform: translateY(-1px);
    }
    .sidebar-card {
        transition: box-shadow 0.4s ease;
    }
    .sidebar-card:hover {
        box-shadow: 0 12px 32px -8px rgba(26, 68, 124, 0.12);
    }
</style>

<div class="max-w-7xl mx-auto px-6 py-10">
    <!-- Breadcrumb -->
    <nav class="flex items-center gap-2 text-xs font-semibold text-slate-400 mb-8">
        <a href="/" class="hover:text-steelAzure transition flex items-center gap-1">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-3.5 w-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6" /></svg>
            Home
        </a>
        <svg xmlns="http://www.w3.org/2000/svg" class="h-3 w-3 text-slate-300" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" /></svg>
        <span class="text-slate-500">{{ $property->category }}</span>
        <svg xmlns="http://www.w3.org/2000/svg" class="h-3 w-3 text-slate-300" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" /></svg>
        <span class="text-slate-700 truncate max-w-[200px]">{{ $property->title }}</span>
    </nav>

    <!-- Layout Grid -->
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
        <!-- Main Content -->
        <div class="lg:col-span-2 space-y-6">
            <!-- Hero Image -->
            <div class="property-img-card h-80 md:h-[420px] bg-slate-100 rounded-2xl overflow-hidden relative group">
                <img src="{{ !empty($property->images) && is_array($property->images) ? $property->images[0] : 'https://images.unsplash.com/photo-1564013799919-ab600027ffc6?auto=format&fit=crop&w=1200&q=80' }}" 
                     alt="{{ $property->title }}" class="h-full w-full object-cover transition-transform duration-700 group-hover:scale-105">
                <!-- Category Badge -->
                <span class="absolute top-5 left-5 px-3 py-1.5 bg-steelAzure text-white text-[10px] font-bold rounded-lg uppercase tracking-wider">
                    {{ $property->category }}
                </span>
                <!-- Furnished Badge -->
                @if($property->is_furnished)
                <span class="absolute top-5 right-5 px-3 py-1.5 bg-white/90 backdrop-blur-sm text-seaGreen text-[10px] font-bold rounded-lg uppercase tracking-wider">
                    Furnished
                </span>
                @endif
            </div>

            <!-- Title & Price Header -->
            <div class="bg-white p-7 rounded-2xl border border-slate-100 shadow-sm">
                <div class="flex flex-wrap items-start justify-between gap-4 mb-5">
                    <div class="flex-1 min-w-0">
                        <h1 class="text-2xl md:text-3xl font-extrabold text-slate-800 tracking-tight leading-tight">{{ $property->title }}</h1>
                        <p class="text-sm text-slate-400 font-medium mt-2 flex items-center gap-1.5">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-steelAzure flex-shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" />
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" />
                            </svg>
                            {{ $property->address }}
                        </p>
                    </div>
                    <div class="text-right flex-shrink-0">
                        <span class="text-3xl font-extrabold text-steelAzure block">{{ $property->currency_symbol }}{{ number_format($property->price, 0) }}</span>
                        <span class="text-[11px] text-slate-400 font-bold uppercase tracking-wider">{{ $property->billing_frequency_label }}</span>
                    </div>
                </div>

                <!-- Property Quick Info -->
                <div class="grid grid-cols-2 sm:grid-cols-4 gap-3">
                    <div class="info-chip bg-slate-50 rounded-xl p-4 text-center border border-slate-100">
                        <div class="flex items-center justify-center gap-1.5 mb-1">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-steelAzure" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6" /></svg>
                        </div>
                        <span class="text-lg font-extrabold text-slate-800 block">{{ $property->bedrooms }}</span>
                        <span class="text-[10px] text-slate-400 font-bold uppercase tracking-wider">Bedrooms</span>
                    </div>
                    <div class="info-chip bg-slate-50 rounded-xl p-4 text-center border border-slate-100">
                        <div class="flex items-center justify-center gap-1.5 mb-1">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-seaGreen" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 14v3m4-3v3m4-3v3M3 21h18M3 10h18M3 7l9-4 9 4M4 10h16v11H4V10z" /></svg>
                        </div>
                        <span class="text-lg font-extrabold text-slate-800 block">{{ $property->bathrooms }}</span>
                        <span class="text-[10px] text-slate-400 font-bold uppercase tracking-wider">Bathrooms</span>
                    </div>
                    <div class="info-chip bg-slate-50 rounded-xl p-4 text-center border border-slate-100">
                        <div class="flex items-center justify-center gap-1.5 mb-1">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-turfGreen" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4" /></svg>
                        </div>
                        <span class="text-lg font-extrabold text-slate-800 block">{{ $property->is_furnished ? 'Yes' : 'No' }}</span>
                        <span class="text-[10px] text-slate-400 font-bold uppercase tracking-wider">Furnished</span>
                    </div>
                    <div class="info-chip bg-slate-50 rounded-xl p-4 text-center border border-slate-100">
                        <div class="flex items-center justify-center gap-1.5 mb-1">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-rose-500" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z" /></svg>
                        </div>
                        <span class="text-lg font-extrabold text-slate-800 block">{{ $property->is_pet_friendly ? 'Yes' : 'No' }}</span>
                        <span class="text-[10px] text-slate-400 font-bold uppercase tracking-wider">Pet Friendly</span>
                    </div>
                </div>
            </div>

            <!-- About Section -->
            <div class="bg-white p-7 rounded-2xl border border-slate-100 shadow-sm">
                <h3 class="text-lg font-bold text-slate-800 mb-1">About This Property</h3>
                <p class="text-xs text-slate-400 mb-4">Detailed description provided by the property owner</p>
                <div class="text-slate-600 text-sm leading-relaxed whitespace-pre-line border-t border-slate-50 pt-4">{{ $property->description }}</div>
            </div>

            <!-- Amenities -->
            @if (!empty($property->amenities) && is_array($property->amenities))
                <div class="bg-white p-7 rounded-2xl border border-slate-100 shadow-sm">
                    <h3 class="text-lg font-bold text-slate-800 mb-1">Amenities & Features</h3>
                    <p class="text-xs text-slate-400 mb-4">What this property offers</p>
                    <div class="flex flex-wrap gap-2.5">
                        @foreach ($property->amenities as $amenity)
                            <span class="amenity-tag px-4 py-2 bg-slate-50 border border-slate-100 rounded-lg text-xs font-bold text-slate-600 cursor-default">
                                {{ $amenity }}
                            </span>
                        @endforeach
                    </div>
                </div>
            @endif

            <!-- Property Highlights -->
            <div class="bg-white p-7 rounded-2xl border border-slate-100 shadow-sm">
                <h3 class="text-lg font-bold text-slate-800 mb-4">Property Highlights</h3>
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                    <div class="flex items-center gap-3">
                        <div class="h-9 w-9 rounded-lg bg-steelAzure/10 text-steelAzure flex items-center justify-center flex-shrink-0">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z" /></svg>
                        </div>
                        <div>
                            <span class="text-xs font-bold text-slate-700 block">Verified Listing</span>
                            <span class="text-[10px] text-slate-400">Authenticated by HomiQ</span>
                        </div>
                    </div>
                    <div class="flex items-center gap-3">
                        <div class="h-9 w-9 rounded-lg bg-seaGreen/10 text-seaGreen flex items-center justify-center flex-shrink-0">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>
                        </div>
                        <div>
                            <span class="text-xs font-bold text-slate-700 block">Instant Booking</span>
                            <span class="text-[10px] text-slate-400">Quick approval process</span>
                        </div>
                    </div>
                    <div class="flex items-center gap-3">
                        <div class="h-9 w-9 rounded-lg bg-turfGreen/10 text-turfGreen flex items-center justify-center flex-shrink-0">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.94.725l.548 2.2a1 1 0 01-.321.988l-1.305.98a10.582 10.582 0 004.872 4.872l.98-1.305a1 1 0 01.988-.321l2.2.548a1 1 0 01.725.94V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z" /></svg>
                        </div>
                        <div>
                            <span class="text-xs font-bold text-slate-700 block">Owner Contact</span>
                            <span class="text-[10px] text-slate-400">Direct communication</span>
                        </div>
                    </div>
                    <div class="flex items-center gap-3">
                        <div class="h-9 w-9 rounded-lg bg-rose-500/10 text-rose-500 flex items-center justify-center flex-shrink-0">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z" /></svg>
                        </div>
                        <div>
                            <span class="text-xs font-bold text-slate-700 block">Secure Payments</span>
                            <span class="text-[10px] text-slate-400">End-to-end encryption</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Booking Sidebar -->
        <div class="lg:col-span-1">
            <div class="sidebar-card bg-white p-7 rounded-2xl border border-slate-100 shadow-sm sticky top-24 space-y-6">
                <!-- Price Summary -->
                <div class="text-center pb-5 border-b border-slate-100">
                    <span class="text-3xl font-extrabold text-steelAzure">{{ $property->currency_symbol }}{{ number_format($property->price, 0) }}</span>
                    <span class="text-xs text-slate-400 font-bold block mt-1">{{ $property->billing_frequency_label }}</span>
                </div>

                <h3 class="text-base font-bold text-slate-800">Inquire About This Space</h3>
                <p class="text-xs text-slate-400 font-medium">To book or ask questions, initiate a direct chat room with the owner of this property.</p>

                @auth
                    @if (Auth::id() === $property->owner_id)
                        <div class="p-4 bg-steelAzure/5 border border-steelAzure/15 text-steelAzure text-xs font-semibold rounded-xl flex items-center gap-2">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 flex-shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>
                            You are the owner of this property listing.
                        </div>
                    @else
                        <a href="/chat?property_id={{ $property->id }}" class="block w-full py-3.5 bg-steelAzure hover:bg-steelAzure/90 text-white font-bold rounded-lg shadow-md shadow-steelAzure/10 transition duration-200 text-sm text-center flex items-center justify-center gap-2">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z" /></svg>
                            Contact Owner
                        </a>
                    @endif
                @else
                    <div class="text-center py-2 space-y-4">
                        <a href="/login" class="block w-full py-3.5 bg-steelAzure hover:bg-steelAzure/90 text-white font-bold rounded-lg shadow-md shadow-steelAzure/10 transition text-sm text-center">
                            Sign In to Contact Owner
                        </a>
                    </div>
                @endauth

                <!-- Owner Profile -->
                <div class="border-t border-slate-100 pt-5 flex items-center justify-between gap-3">
                    <div class="flex items-center gap-3">
                        <div class="h-11 w-11 bg-steelAzure/10 text-steelAzure rounded-full flex items-center justify-center font-bold text-base">
                            {{ substr($property->owner->name, 0, 1) }}
                        </div>
                        <div>
                            <span class="text-[10px] text-slate-400 font-bold uppercase tracking-wider block">Property Owner</span>
                            <p class="text-sm font-bold text-slate-800">{{ $property->owner->name }}</p>
                        </div>
                    </div>
                    @auth
                        @if (Auth::id() !== $property->owner_id)
                            <a href="/chat?property_id={{ $property->id }}" class="px-3.5 py-2 bg-slate-50 hover:bg-steelAzure hover:text-white border border-slate-100 rounded-xl text-xs font-bold text-slate-600 transition flex items-center gap-1.5 shadow-sm">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-3.5 w-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z" /></svg>
                                Chat
                            </a>
                        @endif
                    @endauth
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
