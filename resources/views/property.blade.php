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

    <!-- Title & Breadcrumb -->
    <div class="mb-6">
        <h1 class="text-3xl md:text-4xl font-extrabold text-slate-800 tracking-tight leading-tight mb-2">{{ $property->title }}</h1>
        <div class="flex items-center gap-4 text-sm font-semibold text-slate-600">
            <span class="flex items-center gap-1">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-rose-500" viewBox="0 0 20 20" fill="currentColor">
                    <path fill-rule="evenodd" d="M3.172 5.172a4 4 0 015.656 0L10 6.343l1.172-1.171a4 4 0 115.656 5.656L10 17.657l-6.828-6.829a4 4 0 010-5.656z" clip-rule="evenodd" />
                </svg>
                Highly Rated
            </span>
            <span class="flex items-center gap-1 underline underline-offset-2">
                {{ $property->address }}
            </span>
        </div>
    </div>

    <!-- Bento Box Image Gallery -->
    @php
        $images = (!empty($property->images) && is_array($property->images)) ? $property->images : ['https://images.unsplash.com/photo-1564013799919-ab600027ffc6?auto=format&fit=crop&w=1200&q=80'];
        $img1 = $images[0] ?? $images[0];
        $img2 = $images[1] ?? $images[0];
        $img3 = $images[2] ?? $images[0];
        $img4 = $images[3] ?? $images[0];
        $img5 = $images[4] ?? $images[0];
    @endphp
    <div class="grid grid-cols-1 md:grid-cols-4 grid-rows-2 gap-2 h-80 md:h-[480px] rounded-2xl overflow-hidden mb-10">
        <!-- Main Large Image -->
        <div class="md:col-span-2 md:row-span-2 relative group bg-slate-100 cursor-pointer overflow-hidden">
            <img src="{{ $img1 }}" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500" alt="Main image">
            
            <div class="absolute top-4 left-4 flex gap-2">
                <span class="px-3 py-1 bg-white/90 backdrop-blur-sm text-slate-800 text-[10px] font-extrabold uppercase tracking-wider rounded-lg shadow-sm">{{ $property->category }}</span>
                <span class="px-3 py-1 bg-amber-500 text-white text-[10px] font-extrabold uppercase tracking-wider rounded-lg shadow-sm">For {{ ucfirst($property->listing_type) }}</span>
            </div>
        </div>
        
        <!-- Small Image 1 -->
        <div class="hidden md:block relative group bg-slate-100 cursor-pointer overflow-hidden">
            <img src="{{ $img2 }}" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500" alt="Image 2">
        </div>
        <!-- Small Image 2 -->
        <div class="hidden md:block relative group bg-slate-100 cursor-pointer overflow-hidden">
            <img src="{{ $img3 }}" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500" alt="Image 3">
        </div>
        <!-- Small Image 3 -->
        <div class="hidden md:block relative group bg-slate-100 cursor-pointer overflow-hidden">
            <img src="{{ $img4 }}" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500" alt="Image 4">
        </div>
        <!-- Small Image 4 -->
        <div class="hidden md:block relative group bg-slate-100 cursor-pointer overflow-hidden">
            <img src="{{ $img5 }}" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500" alt="Image 5">
            <div class="absolute inset-0 bg-black/20 flex items-center justify-center opacity-0 group-hover:opacity-100 transition-opacity">
                <span class="text-white font-bold text-sm bg-black/50 px-4 py-2 rounded-lg backdrop-blur-sm">View all photos</span>
            </div>
        </div>
    </div>

    <!-- Layout Grid -->
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-12">
        <!-- Main Content -->
        <div class="lg:col-span-2 space-y-10">

            <div class="flex items-start justify-between pb-6 border-b border-slate-200">
                <div>
                    <h2 class="text-xl font-bold text-slate-800">Hosted by {{ $property->owner ? $property->owner->name : 'Verified Host' }}</h2>
                    <p class="text-sm text-slate-500 mt-1">Superhost · 4 years hosting</p>
                </div>
                @if($property->owner)
                <div class="h-12 w-12 rounded-full overflow-hidden border border-slate-200 bg-slate-100">
                    <img src="https://ui-avatars.com/api/?name={{ urlencode($property->owner->name) }}&background=1A447C&color=fff" alt="owner" class="h-full w-full object-cover">
                </div>
                @endif
            </div>

            <!-- Property Quick Info -->
            @php
                $cat = strtolower($property->category);
                $isLand = str_contains($cat, 'land') || str_contains($cat, 'plot');
            @endphp
                <div class="flex flex-wrap gap-3">
                    @if($isLand)
                        <div class="info-chip flex-1 min-w-[120px] bg-slate-50 rounded-xl p-4 text-center border border-slate-100">
                            <span class="text-lg font-extrabold text-slate-800 block">{{ $property->plot_area ?? $property->built_up_area ?? 'N/A' }}</span>
                            <span class="text-[10px] text-slate-400 font-bold uppercase tracking-wider">Plot Area</span>
                        </div>
                        <div class="info-chip flex-1 min-w-[120px] bg-slate-50 rounded-xl p-4 text-center border border-slate-100">
                            <span class="text-lg font-extrabold text-slate-800 block">{{ $property->boundary_wall ? 'Yes' : 'No' }}</span>
                            <span class="text-[10px] text-slate-400 font-bold uppercase tracking-wider">Boundary Wall</span>
                        </div>
                        <div class="info-chip flex-1 min-w-[120px] bg-slate-50 rounded-xl p-4 text-center border border-slate-100">
                            <span class="text-lg font-extrabold text-slate-800 block">{{ $property->ownership_type ?? 'N/A' }}</span>
                            <span class="text-[10px] text-slate-400 font-bold uppercase tracking-wider">Ownership</span>
                        </div>
                    @else
                        @if($property->bedrooms > 0)
                            <div class="info-chip flex-1 min-w-[120px] bg-slate-50 rounded-xl p-4 text-center border border-slate-100">
                                <span class="text-lg font-extrabold text-slate-800 block">{{ $property->bedrooms }}</span>
                                <span class="text-[10px] text-slate-400 font-bold uppercase tracking-wider">Bedrooms</span>
                            </div>
                        @endif
                        @if($property->bathrooms > 0)
                            <div class="info-chip flex-1 min-w-[120px] bg-slate-50 rounded-xl p-4 text-center border border-slate-100">
                                <span class="text-lg font-extrabold text-slate-800 block">{{ $property->bathrooms }}</span>
                                <span class="text-[10px] text-slate-400 font-bold uppercase tracking-wider">Bathrooms</span>
                            </div>
                        @endif
                        @if($property->listing_type === 'sale')
                            <div class="info-chip flex-1 min-w-[120px] bg-slate-50 rounded-xl p-4 text-center border border-slate-100">
                                <span class="text-lg font-extrabold text-slate-800 block">{{ $property->built_up_area ? number_format($property->built_up_area) : 'N/A' }}</span>
                                <span class="text-[10px] text-slate-400 font-bold uppercase tracking-wider">Built-up Area (sq ft)</span>
                            </div>
                            <div class="info-chip flex-1 min-w-[120px] bg-slate-50 rounded-xl p-4 text-center border border-slate-100">
                                <span class="text-lg font-extrabold text-slate-800 block">{{ $property->property_age ?? 'N/A' }}</span>
                                <span class="text-[10px] text-slate-400 font-bold uppercase tracking-wider">Age (Years)</span>
                            </div>
                            <div class="info-chip flex-1 min-w-[120px] bg-slate-50 rounded-xl p-4 text-center border border-slate-100">
                                <span class="text-lg font-extrabold text-slate-800 block">{{ $property->is_rera_approved ? 'Yes' : 'No' }}</span>
                                <span class="text-[10px] text-slate-400 font-bold uppercase tracking-wider">RERA Approved</span>
                            </div>
                        @endif
                        @if($property->listing_type === 'rent')
                            <div class="info-chip flex-1 min-w-[120px] bg-slate-50 rounded-xl p-4 text-center border border-slate-100">
                                <span class="text-lg font-extrabold text-slate-800 block">{{ $property->security_deposit ? $property->currency_symbol . number_format($property->security_deposit, 0) : 'N/A' }}</span>
                                <span class="text-[10px] text-slate-400 font-bold uppercase tracking-wider">Deposit</span>
                            </div>
                            <div class="info-chip flex-1 min-w-[120px] bg-slate-50 rounded-xl p-4 text-center border border-slate-100">
                                <span class="text-lg font-extrabold text-slate-800 block">{{ $property->lease_duration ?: 'Flexible' }}</span>
                                <span class="text-[10px] text-slate-400 font-bold uppercase tracking-wider">Lease Duration</span>
                            </div>
                            <div class="info-chip flex-1 min-w-[120px] bg-slate-50 rounded-xl p-4 text-center border border-slate-100">
                                <span class="text-lg font-extrabold text-slate-800 block">{{ $property->is_furnished ? 'Yes' : 'No' }}</span>
                                <span class="text-[10px] text-slate-400 font-bold uppercase tracking-wider">Furnished</span>
                            </div>
                            @if($property->preferred_tenant)
                                <div class="info-chip flex-1 min-w-[120px] bg-slate-50 rounded-xl p-4 text-center border border-slate-100">
                                    <span class="text-lg font-extrabold text-slate-800 block">{{ $property->preferred_tenant }}</span>
                                    <span class="text-[10px] text-slate-400 font-bold uppercase tracking-wider">Preferred Tenant</span>
                                </div>
                            @endif
                        @endif
                    @endif
                </div>

                <!-- Secondary details row for carpet area, floors, facing, available from -->
                <div class="grid grid-cols-2 sm:grid-cols-4 gap-3 mt-4 pt-4 border-t border-slate-100/60 text-xs">
                    @if($property->carpet_area)
                        <div class="p-2 bg-slate-50/50 rounded-lg">
                            <span class="text-slate-400 block text-[9px] font-bold uppercase">Carpet Area</span>
                            <span class="font-extrabold text-slate-800">{{ number_format($property->carpet_area) }} sq ft</span>
                        </div>
                    @endif
                    @if(!$isLand && $property->floor_number !== null)
                        <div class="p-2 bg-slate-50/50 rounded-lg">
                            <span class="text-slate-400 block text-[9px] font-bold uppercase">Floor</span>
                            <span class="font-extrabold text-slate-800">Floor {{ $property->floor_number }} of {{ $property->total_floors ?: 'Any' }}</span>
                        </div>
                    @endif
                    @if($property->facing_direction)
                        <div class="p-2 bg-slate-50/50 rounded-lg">
                            <span class="text-slate-400 block text-[9px] font-bold uppercase">Facing</span>
                            <span class="font-extrabold text-slate-800">{{ $property->facing_direction }}</span>
                        </div>
                    @endif
                    <div class="p-2 bg-slate-50/50 rounded-lg">
                        <span class="text-slate-400 block text-[9px] font-bold uppercase">Available From</span>
                        <span class="font-extrabold text-slate-800">{{ $property->available_from ? $property->available_from->format('Y-m-d') : 'Immediate' }}</span>
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
            @if (!$isLand && !empty($property->amenities) && is_array($property->amenities))
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
            <div class="bg-white p-7 rounded-[24px] border border-slate-200 shadow-xl shadow-slate-200/50 sticky top-28 space-y-6">
                <!-- Price Summary -->
                <div class="flex items-baseline gap-1">
                    <span class="text-3xl font-extrabold text-slate-800">{{ $property->currency_symbol }}{{ number_format($property->price, 0) }}</span>
                    @if ($property->price_unit)
                    <span class="text-sm text-slate-500 font-medium">{{ $property->price_unit }}</span>
                    @elseif ($property->listing_type === 'rent')
                    <span class="text-sm text-slate-500 font-medium">{{ $property->billing_frequency_label }}</span>
                    @else
                    <span class="text-sm text-slate-500 font-medium">Total Price</span>
                    @endif
                </div>

                <div class="bg-white border border-slate-300 rounded-xl overflow-hidden shadow-sm">
                    <div class="grid grid-cols-2 divide-x divide-slate-300 border-b border-slate-300">
                        <div class="p-3 cursor-pointer hover:bg-slate-50 transition">
                            <span class="block text-[10px] font-extrabold text-slate-800 uppercase">Check-in</span>
                            <span class="text-sm text-slate-500">Add date</span>
                        </div>
                        <div class="p-3 cursor-pointer hover:bg-slate-50 transition">
                            <span class="block text-[10px] font-extrabold text-slate-800 uppercase">Checkout</span>
                            <span class="text-sm text-slate-500">Add date</span>
                        </div>
                    </div>
                    <div class="p-3 cursor-pointer hover:bg-slate-50 transition flex justify-between items-center">
                        <div>
                            <span class="block text-[10px] font-extrabold text-slate-800 uppercase">Guests</span>
                            <span class="text-sm text-slate-500">1 guest</span>
                        </div>
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-slate-400" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" /></svg>
                    </div>
                </div>

                @auth
                    @if (Auth::id() === $property->owner_id)
                        <div class="p-4 bg-steelAzure/5 border border-steelAzure/15 text-steelAzure text-xs font-semibold rounded-xl flex items-center gap-2">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 flex-shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>
                            You are the owner of this property listing.
                        </div>
                    @else
                        <a href="/chat?property_id={{ $property->id }}" class="block w-full py-3.5 bg-gradient-to-r from-[#FF385C] to-[#E61E4D] hover:opacity-90 text-white font-bold rounded-lg shadow-md transition duration-200 text-sm text-center">
                            Contact Owner
                        </a>
                        <p class="text-center text-xs text-slate-500 mt-2">You won't be charged yet</p>
                    @endif
                @else
                    <div class="text-center space-y-3">
                        <a href="/login" class="block w-full py-3.5 bg-gradient-to-r from-[#FF385C] to-[#E61E4D] hover:opacity-90 text-white font-bold rounded-lg shadow-md transition text-sm text-center">
                            Sign In to Contact
                        </a>
                        <p class="text-center text-xs text-slate-500">Log in to view availability and book.</p>
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
                            <p class="text-sm font-bold text-slate-800 mb-0.5">{{ $property->owner->name }}</p>
                            @if ($property->owner->phone)
                                <a href="tel:{{ $property->owner->phone }}" class="text-[11px] text-slate-550 font-semibold hover:text-steelAzure transition flex items-center gap-1.5 mt-0.5">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-3.5 w-3.5 text-steelAzure flex-shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.94.725l.548 2.2a1 1 0 01-.321.988l-1.305.98a10.582 10.582 0 004.872 4.872l.98-1.305a1 1 0 01.988-.321l2.2.548a1 1 0 01.725.94V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z" />
                                    </svg>
                                    {{ $property->owner->phone }}
                                </a>
                            @endif
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

    <!-- Related Properties -->
    @if(isset($relatedProperties) && $relatedProperties->count() > 0)
    <div class="mt-16">
        <div class="flex items-center justify-between mb-8">
            <h2 class="text-2xl font-extrabold text-slate-800 tracking-tight">Similar Spaces You Might Like</h2>
            <a href="/category/{{ $property->category }}" class="hidden sm:inline-flex px-4 py-2.5 bg-white hover:bg-steelAzure hover:text-white border border-slate-200 rounded-xl text-xs font-bold text-slate-700 transition items-center gap-2 shadow-sm group">
                View More {{ $property->category }}
                <svg xmlns="http://www.w3.org/2000/svg" class="h-3.5 w-3.5 group-hover:translate-x-0.5 transition-transform" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M9 5l7 7-7 7" /></svg>
            </a>
        </div>
        
        <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
            @foreach ($relatedProperties as $related)
                <x-property-card :property="$related" />
            @endforeach
        </div>
    </div>
    @endif
</div>
@endsection
