@extends('layouts.app')

@section('content')
@php
    $images = (!empty($property->images) && is_array($property->images)) ? $property->images : ['https://images.unsplash.com/photo-1564013799919-ab600027ffc6?auto=format&fit=crop&w=1200&q=80'];
    $imgCount = count($images);
    $addr = $property->address;
    if (is_string($addr) && str_starts_with($addr, '{')) {
        $decoded = json_decode($addr, true);
        if (json_last_error() === JSON_ERROR_NONE && is_array($decoded)) {
            $addrParts = [];
            if (!empty($decoded['street'])) $addrParts[] = $decoded['street'];
            if (!empty($decoded['city'])) $addrParts[] = $decoded['city'];
            if (!empty($decoded['state'])) $addrParts[] = $decoded['state'];
            if (!empty($decoded['country'])) $addrParts[] = $decoded['country'];
            $addr = implode(', ', $addrParts);
        }
    }
    $cat = strtolower($property->category ?? 'property');
    $isLand = str_contains($cat, 'land') || str_contains($cat, 'plot');
@endphp

<div x-data="{
    activeModalImage: 0,
    isModalOpen: false,
    images: {{ json_encode($images) }},
    openModal(index) {
        this.activeModalImage = index;
        this.isModalOpen = true;
        document.body.style.overflow = 'hidden';
    },
    closeModal() {
        this.isModalOpen = false;
        document.body.style.overflow = 'auto';
    },
    nextImage() {
        this.activeModalImage = (this.activeModalImage + 1) % this.images.length;
    },
    prevImage() {
        this.activeModalImage = (this.activeModalImage - 1 + this.images.length) % this.images.length;
    },
    shareProperty() {
        if (navigator.clipboard) {
            navigator.clipboard.writeText(window.location.href);
            alert('Listing link copied to clipboard!');
        }
    }
}" @keydown.escape.window="closeModal()" @keydown.right.window="if(isModalOpen) nextImage()" @keydown.left.window="if(isModalOpen) prevImage()" class="max-w-[1440px] mx-auto px-4 sm:px-6 lg:px-8 py-6 sm:py-10">

    <!-- Top Breadcrumb & Actions Bar -->
    <div class="flex flex-wrap items-center justify-between gap-4 mb-6 text-xs text-slate-500 font-medium">
        <nav class="flex items-center gap-1.5 flex-wrap">
            <a href="/" class="hover:text-brandEmerald transition flex items-center gap-1 text-slate-600 font-semibold">
                <span class="material-symbols-outlined text-sm text-slate-400">home</span>
                Home
            </a>
            <span class="material-symbols-outlined text-xs text-slate-300">chevron_right</span>
            <a href="/?search_type={{ urlencode($property->category) }}" class="hover:text-brandEmerald transition text-slate-600">
                {{ $property->category }}
            </a>
            <span class="material-symbols-outlined text-xs text-slate-300">chevron_right</span>
            <span class="text-slate-900 font-bold truncate max-w-[280px]">{{ $property->title }}</span>
        </nav>

        <div class="flex items-center gap-2">
            <button type="button" @click="shareProperty()" class="px-3 py-1.5 rounded-full border border-slate-200 hover:border-[#0A2540] hover:text-[#0A2540] bg-white text-slate-700 font-semibold flex items-center gap-1.5 shadow-2xs transition">
                <span class="material-symbols-outlined text-base">share</span>
                <span class="hidden sm:inline">Share</span>
            </button>
            <button type="button" onclick="alert('Saved to your favorites!')" class="px-3 py-1.5 rounded-full border border-slate-200 hover:border-rose-300 hover:text-rose-600 bg-white text-slate-700 font-semibold flex items-center gap-1.5 shadow-2xs transition">
                <span class="material-symbols-outlined text-base text-rose-500">favorite</span>
                <span class="hidden sm:inline">Save</span>
            </button>
        </div>
    </div>

    <!-- Title & Verified Badges Header -->
    <div class="mb-8">
        <div class="flex flex-wrap items-center gap-2.5 mb-3">
            <span class="px-3 py-1 rounded-full bg-slate-900 text-white text-[11px] font-bold uppercase tracking-wider shadow-xs">
                {{ $property->category }}
            </span>
            <span class="px-3 py-1 rounded-full bg-[#0A2540] text-white text-[11px] font-bold uppercase tracking-wider shadow-xs">
                For {{ ucfirst($property->listing_type) }}
            </span>
            <span class="px-3 py-1 rounded-full bg-emerald-50 text-emerald-700 border border-emerald-200 text-[11px] font-bold flex items-center gap-1 shadow-xs">
                <span class="material-symbols-outlined text-sm text-emerald-600">verified</span>
                100% On-Site Inspected
            </span>
            <span class="px-3 py-1 rounded-full bg-emerald-500 text-white text-[11px] font-bold uppercase tracking-wider shadow-xs">
                0% Brokerage
            </span>
        </div>

        <h1 class="text-2xl sm:text-3xl lg:text-4xl font-black text-slate-900 tracking-tight leading-tight mb-2">
            {{ $property->title }}
        </h1>

        <div class="flex flex-wrap items-center gap-3 text-sm text-slate-600">
            <span class="flex items-center gap-1.5 font-medium">
                <span class="material-symbols-outlined text-base text-emerald-600">location_on</span>
                {{ $addr }}
            </span>
            <span class="text-slate-300 hidden sm:inline">•</span>
            <span class="flex items-center gap-1 text-slate-500 text-xs">
                <span class="material-symbols-outlined text-sm text-amber-500">star</span>
                <strong class="text-slate-800">4.95</strong> (Verified Quality Score)
            </span>
        </div>
    </div>

    <!-- Interactive Photo Gallery -->
    <div class="mb-12">
        @if($imgCount === 1)
            <!-- Single Image: Full-Width Cinematic Hero -->
            <div class="relative h-[380px] sm:h-[480px] lg:h-[540px] rounded-3xl overflow-hidden shadow-soft group cursor-pointer bg-slate-100" @click="openModal(0)">
                <img src="{{ $images[0] }}" alt="{{ $property->title }}" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-700">
                <div class="absolute inset-0 bg-gradient-to-t from-slate-950/70 via-transparent to-black/20 pointer-events-none"></div>

                <div class="absolute bottom-6 left-6 right-6 flex items-center justify-between text-white pointer-events-none">
                    <div class="space-y-1">
                        <span class="px-3 py-1 rounded-full bg-white/20 backdrop-blur-md text-xs font-semibold uppercase tracking-wider inline-flex items-center gap-1.5">
                            <span class="material-symbols-outlined text-sm">photo_camera</span>
                            1 Verified Property Photograph
                        </span>
                        <p class="text-xs text-white/80 hidden sm:block">Click to view full resolution inspection photo</p>
                    </div>
                    <button type="button" class="pointer-events-auto px-4 py-2 rounded-xl bg-white/90 hover:bg-white text-slate-900 font-bold text-xs backdrop-blur-md flex items-center gap-1.5 shadow-lg transition transform hover:scale-105">
                        <span class="material-symbols-outlined text-base">fullscreen</span>
                        Expand Photo
                    </button>
                </div>
            </div>
        @elseif($imgCount === 2)
            <!-- Two Images: Side-by-Side Dual Hero -->
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-3 h-[380px] sm:h-[460px] rounded-3xl overflow-hidden shadow-soft">
                @foreach($images as $idx => $img)
                    <div class="relative group cursor-pointer overflow-hidden bg-slate-100 h-full" @click="openModal({{ $idx }})">
                        <img src="{{ $img }}" alt="{{ $property->title }} - Photo {{ $idx + 1 }}" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-700">
                        <div class="absolute inset-0 bg-gradient-to-t from-slate-950/50 via-transparent to-transparent opacity-0 group-hover:opacity-100 transition-opacity flex items-end p-6">
                            <span class="px-3 py-1.5 rounded-lg bg-white/90 text-slate-900 font-bold text-xs flex items-center gap-1.5 shadow-md">
                                <span class="material-symbols-outlined text-sm">fullscreen</span> View Photo {{ $idx + 1 }}
                            </span>
                        </div>
                    </div>
                @endforeach
            </div>
        @else
            <!-- 3+ Images: Modern Bento Gallery -->
            <div class="grid grid-cols-1 md:grid-cols-4 grid-rows-2 gap-3 h-[380px] sm:h-[480px] rounded-3xl overflow-hidden shadow-soft relative">
                <!-- Large Primary Photo -->
                <div class="md:col-span-2 md:row-span-2 relative group cursor-pointer overflow-hidden bg-slate-100" @click="openModal(0)">
                    <img src="{{ $images[0] }}" alt="{{ $property->title }} - Main" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-700">
                    <div class="absolute inset-0 bg-gradient-to-t from-slate-950/60 via-transparent to-transparent opacity-0 group-hover:opacity-100 transition-opacity flex items-end p-6">
                        <span class="px-3.5 py-2 rounded-xl bg-white/95 text-slate-900 font-bold text-xs flex items-center gap-1.5 shadow-lg">
                            <span class="material-symbols-outlined text-base">fullscreen</span>
                            View Main Photo
                        </span>
                    </div>
                </div>

                <!-- Secondary Photos -->
                @for($i = 1; $i < min(5, $imgCount); $i++)
                    <div class="hidden md:block relative group cursor-pointer overflow-hidden bg-slate-100" @click="openModal({{ $i }})">
                        <img src="{{ $images[$i] }}" alt="{{ $property->title }} - Photo {{ $i + 1 }}" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-700">
                        @if($i === 4 || ($i === $imgCount - 1 && $imgCount <= 5))
                            <div class="absolute inset-0 bg-slate-950/60 backdrop-blur-xs flex items-center justify-center group-hover:bg-slate-950/70 transition-colors">
                                <span class="px-4 py-2.5 rounded-xl bg-white/95 text-slate-900 font-bold text-xs flex items-center gap-2 shadow-lg">
                                    <span class="material-symbols-outlined text-base">photo_library</span>
                                    View All ({{ $imgCount }})
                                </span>
                            </div>
                        @else
                            <div class="absolute inset-0 bg-slate-950/20 opacity-0 group-hover:opacity-100 transition-opacity flex items-center justify-center">
                                <span class="material-symbols-outlined text-white text-2xl drop-shadow-md">zoom_in</span>
                            </div>
                        @endif
                    </div>
                @endfor

                <!-- Floating All Photos Button (Mobile & Desktop) -->
                <button type="button" @click="openModal(0)" class="absolute bottom-4 right-4 px-4 py-2.5 rounded-xl bg-white/95 hover:bg-white text-slate-900 font-bold text-xs flex items-center gap-2 shadow-lg backdrop-blur-md transition transform hover:scale-105 z-10">
                    <span class="material-symbols-outlined text-base">photo_library</span>
                    <span>All Photos ({{ $imgCount }})</span>
                </button>
            </div>
        @endif
    </div>

    <!-- Main Content & Sticky Booking Grid -->
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-10 lg:gap-12 items-start">
        
        <!-- Left: Specifications, Inspection Guarantee, Description, Amenities, Host -->
        <div class="lg:col-span-2 space-y-10">

            <!-- Specifications Bento Grid -->
            <div class="bg-white rounded-3xl p-6 sm:p-8 border border-slate-200/80 shadow-soft">
                <div class="flex items-center justify-between pb-5 mb-6 border-b border-slate-100">
                    <div>
                        <h2 class="text-xl font-bold text-slate-900">Property Overview</h2>
                        <p class="text-xs text-slate-500 mt-0.5">Key physical specifications and lease terms</p>
                    </div>
                    <span class="px-3 py-1 rounded-full bg-slate-100 text-slate-700 text-xs font-bold uppercase tracking-wider">
                        ID #{{ $property->id }}
                    </span>
                </div>

                <div class="grid grid-cols-2 sm:grid-cols-4 gap-3.5">
                    @if($isLand)
                        <div class="p-4 rounded-2xl bg-slate-50/80 border border-slate-100 flex flex-col justify-center">
                            <span class="material-symbols-outlined text-brandNavy text-2xl mb-1">square_foot</span>
                            <span class="text-lg font-extrabold text-slate-900">{{ $property->plot_area ?? $property->built_up_area ?? 'N/A' }}</span>
                            <span class="text-[10px] font-bold text-slate-400 uppercase tracking-wider">Plot Area</span>
                        </div>
                        <div class="p-4 rounded-2xl bg-slate-50/80 border border-slate-100 flex flex-col justify-center">
                            <span class="material-symbols-outlined text-brandNavy text-2xl mb-1">fence</span>
                            <span class="text-lg font-extrabold text-slate-900">{{ $property->boundary_wall ? 'Yes' : 'No' }}</span>
                            <span class="text-[10px] font-bold text-slate-400 uppercase tracking-wider">Boundary Wall</span>
                        </div>
                    @else
                        @if($property->bedrooms > 0)
                            <div class="p-4 rounded-2xl bg-slate-50/80 border border-slate-100 flex flex-col justify-center">
                                <span class="material-symbols-outlined text-brandNavy text-2xl mb-1">bed</span>
                                <span class="text-lg font-extrabold text-slate-900">{{ $property->bedrooms }} BHK</span>
                                <span class="text-[10px] font-bold text-slate-400 uppercase tracking-wider">Bedrooms</span>
                            </div>
                        @endif
                        @if($property->bathrooms > 0)
                            <div class="p-4 rounded-2xl bg-slate-50/80 border border-slate-100 flex flex-col justify-center">
                                <span class="material-symbols-outlined text-brandNavy text-2xl mb-1">bathtub</span>
                                <span class="text-lg font-extrabold text-slate-900">{{ $property->bathrooms }} Baths</span>
                                <span class="text-[10px] font-bold text-slate-400 uppercase tracking-wider">Bathrooms</span>
                            </div>
                        @endif
                        <div class="p-4 rounded-2xl bg-slate-50/80 border border-slate-100 flex flex-col justify-center">
                            <span class="material-symbols-outlined text-brandNavy text-2xl mb-1">chair</span>
                            <span class="text-lg font-extrabold text-slate-900">{{ $property->is_furnished ? 'Furnished' : 'Unfurnished' }}</span>
                            <span class="text-[10px] font-bold text-slate-400 uppercase tracking-wider">Furnishing</span>
                        </div>
                        <div class="p-4 rounded-2xl bg-slate-50/80 border border-slate-100 flex flex-col justify-center">
                            <span class="material-symbols-outlined text-brandNavy text-2xl mb-1">local_parking</span>
                            <span class="text-lg font-extrabold text-slate-900">{{ $property->has_parking ? 'Dedicated' : 'None' }}</span>
                            <span class="text-[10px] font-bold text-slate-400 uppercase tracking-wider">Parking</span>
                        </div>
                    @endif

                    @if($property->listing_type === 'rent')
                        <div class="p-4 rounded-2xl bg-slate-50/80 border border-slate-100 flex flex-col justify-center">
                            <span class="material-symbols-outlined text-emerald-600 text-2xl mb-1">lock</span>
                            <span class="text-lg font-extrabold text-slate-900">{{ $property->security_deposit ? $property->currency_symbol . number_format($property->security_deposit, 0) : 'Standard' }}</span>
                            <span class="text-[10px] font-bold text-slate-400 uppercase tracking-wider">Deposit</span>
                        </div>
                        <div class="p-4 rounded-2xl bg-slate-50/80 border border-slate-100 flex flex-col justify-center">
                            <span class="material-symbols-outlined text-emerald-600 text-2xl mb-1">timelapse</span>
                            <span class="text-lg font-extrabold text-slate-900">{{ $property->lease_duration ?: 'Flexible' }}</span>
                            <span class="text-[10px] font-bold text-slate-400 uppercase tracking-wider">Lease Term</span>
                        </div>
                    @endif

                    @if($property->listing_type === 'sale')
                        <div class="p-4 rounded-2xl bg-slate-50/80 border border-slate-100 flex flex-col justify-center">
                            <span class="material-symbols-outlined text-emerald-600 text-2xl mb-1">verified_user</span>
                            <span class="text-lg font-extrabold text-slate-900">{{ $property->is_rera_approved ? 'Approved' : 'Verified' }}</span>
                            <span class="text-[10px] font-bold text-slate-400 uppercase tracking-wider">RERA Status</span>
                        </div>
                        <div class="p-4 rounded-2xl bg-slate-50/80 border border-slate-100 flex flex-col justify-center">
                            <span class="material-symbols-outlined text-emerald-600 text-2xl mb-1">calendar_month</span>
                            <span class="text-lg font-extrabold text-slate-900">{{ $property->property_age ? $property->property_age . ' Yrs' : 'New' }}</span>
                            <span class="text-[10px] font-bold text-slate-400 uppercase tracking-wider">Property Age</span>
                        </div>
                    @endif

                    <div class="p-4 rounded-2xl bg-slate-50/80 border border-slate-100 flex flex-col justify-center">
                        <span class="material-symbols-outlined text-slate-600 text-2xl mb-1">pets</span>
                        <span class="text-lg font-extrabold text-slate-900">{{ $property->is_pet_friendly ? 'Allowed' : 'Not Allowed' }}</span>
                        <span class="text-[10px] font-bold text-slate-400 uppercase tracking-wider">Pets</span>
                    </div>

                    <div class="p-4 rounded-2xl bg-slate-50/80 border border-slate-100 flex flex-col justify-center">
                        <span class="material-symbols-outlined text-slate-600 text-2xl mb-1">event_available</span>
                        <span class="text-lg font-extrabold text-slate-900">{{ $property->available_from ? $property->available_from->format('M Y') : 'Immediate' }}</span>
                        <span class="text-[10px] font-bold text-slate-400 uppercase tracking-wider">Available From</span>
                    </div>
                </div>

                @if($property->carpet_area || $property->floor_number !== null || $property->facing_direction)
                <div class="grid grid-cols-2 sm:grid-cols-3 gap-3 pt-4 mt-4 border-t border-slate-100 text-xs">
                    @if($property->carpet_area)
                        <div class="p-3 bg-slate-50 rounded-xl">
                            <span class="text-slate-400 block text-[10px] font-bold uppercase">Carpet Area</span>
                            <span class="font-extrabold text-slate-800 text-sm">{{ number_format($property->carpet_area) }} sq ft</span>
                        </div>
                    @endif
                    @if($property->floor_number !== null)
                        <div class="p-3 bg-slate-50 rounded-xl">
                            <span class="text-slate-400 block text-[10px] font-bold uppercase">Floor Level</span>
                            <span class="font-extrabold text-slate-800 text-sm">Floor {{ $property->floor_number }} of {{ $property->total_floors ?: 'Any' }}</span>
                        </div>
                    @endif
                    @if($property->facing_direction)
                        <div class="p-3 bg-slate-50 rounded-xl">
                            <span class="text-slate-400 block text-[10px] font-bold uppercase">Facing</span>
                            <span class="font-extrabold text-slate-800 text-sm">{{ $property->facing_direction }}</span>
                        </div>
                    @endif
                </div>
                @endif
            </div>

            <!-- Verified Inspection Guarantee Banner -->
            <div class="p-6 sm:p-8 rounded-3xl bg-gradient-to-br from-slate-950 via-slate-900 to-brandNavy text-white shadow-soft relative overflow-hidden">
                <div class="absolute -right-10 -bottom-10 w-60 h-60 bg-emerald-500/10 rounded-full blur-3xl pointer-events-none"></div>

                <div class="flex items-center gap-2 mb-3">
                    <span class="px-3 py-1 rounded-full bg-emerald-500/20 text-emerald-400 border border-emerald-500/30 text-xs font-bold flex items-center gap-1.5">
                        <span class="material-symbols-outlined text-sm">verified</span>
                        100% Quality Standard & Physical Audit
                    </span>
                </div>

                <h3 class="text-xl sm:text-2xl font-black tracking-tight mb-2">
                    Verified On-Site by HomiQ Inspectors
                </h3>
                <p class="text-sm text-slate-300 max-w-xl leading-relaxed mb-6">
                    This residence has undergone on-site physical auditing. Landlord ownership documentation and property specifications have been confirmed before approval.
                </p>

                <div class="grid grid-cols-1 sm:grid-cols-3 gap-4 pt-4 border-t border-white/10 text-xs">
                    <div class="flex items-start gap-2.5">
                        <span class="material-symbols-outlined text-emerald-400 text-lg flex-shrink-0">fact_check</span>
                        <div>
                            <strong class="block text-white font-bold">Audited Ownership</strong>
                            <span class="text-slate-400 text-[11px]">Government ID & property deeds verified</span>
                        </div>
                    </div>
                    <div class="flex items-start gap-2.5">
                        <span class="material-symbols-outlined text-emerald-400 text-lg flex-shrink-0">photo_camera</span>
                        <div>
                            <strong class="block text-white font-bold">100% Authentic Photos</strong>
                            <span class="text-slate-400 text-[11px]">Exact room angles and true dimensions</span>
                        </div>
                    </div>
                    <div class="flex items-start gap-2.5">
                        <span class="material-symbols-outlined text-emerald-400 text-lg flex-shrink-0">handshake</span>
                        <div>
                            <strong class="block text-white font-bold">Zero Brokerage Guarantee</strong>
                            <span class="text-slate-400 text-[11px]">Direct deal with host, pay ₹0 commissions</span>
                        </div>
                    </div>
                </div>
            </div>

            <!-- About This Property Description -->
            <div class="bg-white rounded-3xl p-6 sm:p-8 border border-slate-200/80 shadow-soft">
                <h3 class="text-xl font-bold text-slate-900 mb-1">About This Space</h3>
                <p class="text-xs text-slate-400 mb-6">Detailed property overview provided by the verified host</p>
                <div class="text-slate-700 text-sm sm:text-base leading-relaxed whitespace-pre-line border-t border-slate-100 pt-6">
                    {{ $property->description }}
                </div>
            </div>

            <!-- Amenities & Features -->
            @if (!empty($property->amenities) && is_array($property->amenities))
                <div class="bg-white rounded-3xl p-6 sm:p-8 border border-slate-200/80 shadow-soft">
                    <h3 class="text-xl font-bold text-slate-900 mb-1">Amenities & Features</h3>
                    <p class="text-xs text-slate-400 mb-6">Verified amenities included with this property</p>

                    <div class="grid grid-cols-2 sm:grid-cols-3 gap-3">
                        @foreach ($property->amenities as $amenity)
                            @php
                                $aLower = strtolower($amenity);
                                $icon = 'check_circle';
                                if (str_contains($aLower, 'wifi') || str_contains($aLower, 'internet')) $icon = 'wifi';
                                elseif (str_contains($aLower, 'pool') || str_contains($aLower, 'swim')) $icon = 'pool';
                                elseif (str_contains($aLower, 'ac') || str_contains($aLower, 'air condition')) $icon = 'ac_unit';
                                elseif (str_contains($aLower, 'gym') || str_contains($aLower, 'fitness')) $icon = 'fitness_center';
                                elseif (str_contains($aLower, 'parking')) $icon = 'local_parking';
                                elseif (str_contains($aLower, 'security') || str_contains($aLower, 'guard')) $icon = 'shield';
                                elseif (str_contains($aLower, 'balcony') || str_contains($aLower, 'terrace')) $icon = 'balcony';
                                elseif (str_contains($aLower, 'elevator') || str_contains($aLower, 'lift')) $icon = 'elevator';
                                elseif (str_contains($aLower, 'power') || str_contains($aLower, 'backup')) $icon = 'bolt';
                                elseif (str_contains($aLower, 'garden') || str_contains($aLower, 'park')) $icon = 'yard';
                                elseif (str_contains($aLower, 'cctv')) $icon = 'videocam';
                                elseif (str_contains($aLower, 'water')) $icon = 'water_drop';
                                elseif (str_contains($aLower, 'furnish')) $icon = 'chair';
                            @endphp
                            <div class="flex items-center gap-3 p-3.5 rounded-2xl bg-slate-50/80 border border-slate-100 hover:border-brandEmerald/40 hover:bg-emerald-50/20 transition group">
                                <div class="h-9 w-9 rounded-xl bg-white border border-slate-200/60 shadow-2xs flex items-center justify-center text-brandNavy group-hover:text-emerald-600 transition-colors flex-shrink-0">
                                    <span class="material-symbols-outlined text-lg">{{ $icon }}</span>
                                </div>
                                <span class="text-xs font-bold text-slate-800">{{ $amenity }}</span>
                            </div>
                        @endforeach
                    </div>
                </div>
            @endif

            <!-- Host & Landlord Profile Card -->
            <div class="bg-white rounded-3xl p-6 sm:p-8 border border-slate-200/80 shadow-soft">
                <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-6 pb-6 border-b border-slate-100">
                    <div class="flex items-center gap-4">
                        <div class="h-16 w-16 rounded-2xl bg-gradient-to-br from-[#0A2540] to-emerald-600 text-white font-black text-2xl flex items-center justify-center shadow-md flex-shrink-0">
                            {{ strtoupper(substr($property->owner ? $property->owner->name : 'V', 0, 1)) }}
                        </div>
                        <div>
                            <div class="flex items-center gap-2">
                                <h3 class="text-lg font-black text-slate-900">{{ $property->owner ? $property->owner->name : 'Verified Host' }}</h3>
                                <span class="px-2 py-0.5 rounded-full bg-emerald-50 text-emerald-700 text-[10px] font-bold border border-emerald-200 flex items-center gap-0.5">
                                    <span class="material-symbols-outlined text-xs text-emerald-600">verified</span>
                                    Verified Owner
                                </span>
                            </div>
                            <p class="text-xs text-slate-500 mt-1">Superhost • Direct owner contact • 100% response rate</p>
                        </div>
                    </div>

                    <div class="flex items-center gap-3">
                        @auth
                            @if(Auth::id() !== $property->owner_id)
                                <a href="/chat?property_id={{ $property->id }}" class="px-5 py-2.5 rounded-full bg-[#0A2540] hover:bg-slate-900 text-white font-bold text-xs flex items-center gap-2 shadow-sm transition">
                                    <span class="material-symbols-outlined text-base">chat</span>
                                    Send Direct Message
                                </a>
                            @endif
                        @else
                            <a href="/login" class="px-5 py-2.5 rounded-full bg-[#0A2540] hover:bg-slate-900 text-white font-bold text-xs flex items-center gap-2 shadow-sm transition">
                                <span class="material-symbols-outlined text-base">chat</span>
                                Message Host
                            </a>
                        @endauth

                        @if ($property->owner && $property->owner->phone)
                            <a href="tel:{{ $property->owner->phone }}" class="p-2.5 rounded-full border border-slate-200 hover:border-[#0A2540] hover:text-[#0A2540] text-slate-700 transition" title="Call Landlord">
                                <span class="material-symbols-outlined text-lg">call</span>
                            </a>
                        @endif
                    </div>
                </div>

                <div class="pt-6 grid grid-cols-1 sm:grid-cols-3 gap-4 text-xs text-slate-600">
                    <div class="flex items-center gap-2">
                        <span class="material-symbols-outlined text-emerald-600 text-base">timer</span>
                        <span>Responds within <strong>1 hour</strong></span>
                    </div>
                    <div class="flex items-center gap-2">
                        <span class="material-symbols-outlined text-emerald-600 text-base">badge</span>
                        <span>Government ID Verified</span>
                    </div>
                    <div class="flex items-center gap-2">
                        <span class="material-symbols-outlined text-emerald-600 text-base">shield</span>
                        <span>Direct Communication Policy</span>
                    </div>
                </div>
            </div>

        </div>

        <!-- Right: Sticky Booking & Inquiry Sidebar -->
        <div class="lg:col-span-1">
            <div class="bg-white rounded-3xl p-6 sm:p-7 border border-slate-200 shadow-soft sticky top-28 space-y-6">
                
                <!-- Price Box -->
                <div class="pb-5 border-b border-slate-100 flex items-baseline justify-between">
                    <div>
                        <span class="text-3xl sm:text-4xl font-black text-slate-900 tracking-tight">
                            {{ $property->currency_symbol }}{{ number_format($property->price, 0) }}
                        </span>
                        <span class="text-xs font-bold text-slate-500 ml-1">
                            @if ($property->price_unit)
                                {{ $property->price_unit }}
                            @elseif ($property->listing_type === 'rent')
                                {{ $property->billing_frequency_label }}
                            @else
                                Total Price
                            @endif
                        </span>
                    </div>
                    <span class="px-2.5 py-1 rounded-full bg-emerald-50 text-emerald-700 text-xs font-bold border border-emerald-200">
                        0% Brokerage
                    </span>
                </div>

                <!-- Inquiry / Booking Box -->
                <div class="border border-slate-200 rounded-2xl overflow-hidden divide-y divide-slate-200 bg-slate-50/50">
                    <div class="p-3.5 bg-white">
                        <label class="block text-[10px] font-bold uppercase tracking-wider text-slate-400 mb-1">
                            Preferred Visit / Move-In Date
                        </label>
                        <input type="date" value="{{ date('Y-m-d') }}" class="w-full text-xs font-semibold text-slate-800 bg-transparent focus:outline-none cursor-pointer">
                    </div>
                    <div class="p-3.5 bg-white flex items-center justify-between">
                        <div>
                            <label class="block text-[10px] font-bold uppercase tracking-wider text-slate-400">
                                Occupants / Guests
                            </label>
                            <span class="text-xs font-semibold text-slate-800">1 - 4 Residents</span>
                        </div>
                        <span class="material-symbols-outlined text-slate-400 text-base">group</span>
                    </div>
                </div>

                <!-- Primary CTA Action -->
                @auth
                    @if (Auth::id() === $property->owner_id)
                        <div class="p-4 rounded-2xl bg-slate-50 border border-slate-200 text-slate-700 text-xs font-semibold flex items-center gap-2.5">
                            <span class="material-symbols-outlined text-[#0A2540] text-xl">info</span>
                            <span>You are the registered owner of this listing.</span>
                        </div>
                    @else
                        <a href="/chat?property_id={{ $property->id }}" class="w-full py-4 rounded-2xl bg-gradient-to-r from-slate-950 via-[#0A2540] to-slate-900 hover:from-[#0A2540] hover:to-slate-950 text-white font-bold text-sm text-center flex items-center justify-center gap-2 shadow-soft hover:shadow-lg transition-all duration-300">
                            <span class="material-symbols-outlined text-lg text-emerald-400">chat</span>
                            <span>Contact Landlord via Direct Chat</span>
                        </a>
                        <p class="text-center text-[11px] text-slate-400">100% Free • No Brokerage Fees Charged</p>
                    @endif
                @else
                    <div class="space-y-3">
                        <a href="/login" class="w-full py-4 rounded-2xl bg-gradient-to-r from-slate-950 via-[#0A2540] to-slate-900 hover:from-[#0A2540] hover:to-slate-950 text-white font-bold text-sm text-center flex items-center justify-center gap-2 shadow-soft hover:shadow-lg transition-all duration-300">
                            <span class="material-symbols-outlined text-lg text-emerald-400">chat</span>
                            <span>Sign In to Inquire</span>
                        </a>
                        <p class="text-center text-[11px] text-slate-400">Create a free account to message landlord directly</p>
                    </div>
                @endauth

                <!-- Move-In Budget Breakdown (Rentals) -->
                @if($property->listing_type === 'rent')
                <div class="p-4 rounded-2xl bg-slate-50 border border-slate-100 space-y-2.5 text-xs">
                    <span class="font-extrabold text-slate-800 block text-[11px] uppercase tracking-wider">Transparent Cost Breakdown</span>
                    <div class="flex justify-between text-slate-600">
                        <span>First Month Rent</span>
                        <span class="font-bold text-slate-800">{{ $property->currency_symbol }}{{ number_format($property->price, 0) }}</span>
                    </div>
                    <div class="flex justify-between text-slate-600">
                        <span>Security Deposit</span>
                        <span class="font-bold text-slate-800">{{ $property->currency_symbol }}{{ number_format($property->security_deposit ?? $property->price, 0) }}</span>
                    </div>
                    <div class="flex justify-between text-emerald-700 font-semibold pt-1 border-t border-slate-200/80">
                        <span>HomiQ Brokerage Fee</span>
                        <span class="font-bold">FREE ({{ $property->currency_symbol }}0)</span>
                    </div>
                    <div class="flex justify-between text-slate-900 font-extrabold pt-2 border-t border-slate-200/80 text-sm">
                        <span>Estimated Total Move-In</span>
                        <span>{{ $property->currency_symbol }}{{ number_format($property->price + ($property->security_deposit ?? $property->price), 0) }}</span>
                    </div>
                </div>
                @endif

                <!-- Host Direct Contact Summary -->
                <div class="border-t border-slate-100 pt-5 flex items-center justify-between gap-3 text-xs">
                    <div class="flex items-center gap-2.5">
                        <div class="h-9 w-9 rounded-xl bg-slate-100 border border-slate-200 text-brandNavy font-black flex items-center justify-center">
                            {{ strtoupper(substr($property->owner ? $property->owner->name : 'H', 0, 1)) }}
                        </div>
                        <div>
                            <span class="font-bold text-slate-800 block truncate max-w-[140px]">{{ $property->owner ? $property->owner->name : 'Property Owner' }}</span>
                            <span class="text-[10px] text-slate-400">Verified Landlord</span>
                        </div>
                    </div>
                    @if ($property->owner && $property->owner->phone)
                        <a href="tel:{{ $property->owner->phone }}" class="font-bold text-emerald-700 hover:text-emerald-800 flex items-center gap-1">
                            <span class="material-symbols-outlined text-sm">call</span>
                            Call Host
                        </a>
                    @endif
                </div>

            </div>
        </div>

    </div>

    <!-- Related / Similar Properties Grid -->
    @if(isset($relatedProperties) && $relatedProperties->count() > 0)
        <div class="mt-20 pt-12 border-t border-slate-200">
            <div class="flex items-center justify-between mb-8">
                <div>
                    <h2 class="text-2xl font-black text-slate-900 tracking-tight">Similar Spaces You Might Like</h2>
                    <p class="text-xs text-slate-500 mt-1">Explore other verified {{ $property->category }} spaces with zero brokerage</p>
                </div>
                <a href="/?search_type={{ urlencode($property->category) }}" class="hidden sm:inline-flex px-4 py-2 rounded-full border border-slate-200 hover:border-brandNavy hover:text-brandNavy text-xs font-bold text-slate-700 transition items-center gap-1.5 shadow-2xs">
                    View More {{ $property->category }}
                    <span class="material-symbols-outlined text-sm">arrow_forward</span>
                </a>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                @foreach ($relatedProperties as $related)
                    <x-property-card :property="$related" />
                @endforeach
            </div>
        </div>
    @endif

    <!-- Interactive Lightbox Modal -->
    <div x-show="isModalOpen" x-cloak class="fixed inset-0 z-[100] bg-black/95 backdrop-blur-md flex flex-col justify-between p-4 sm:p-8" x-transition:enter="transition ease-out duration-300" x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100" x-transition:leave="transition ease-in duration-200" x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0">
        <!-- Top Modal Bar -->
        <div class="flex items-center justify-between text-white z-10">
            <div class="flex items-center gap-3">
                <span class="text-xs font-bold px-3 py-1 rounded-full bg-white/20 backdrop-blur-md">
                    <span x-text="activeModalImage + 1"></span> / <span x-text="images.length"></span>
                </span>
                <span class="text-sm font-semibold text-white/80 hidden sm:inline">{{ $property->title }}</span>
            </div>
            <button type="button" @click="closeModal()" class="h-10 w-10 rounded-full bg-white/10 hover:bg-white/20 text-white flex items-center justify-center transition">
                <span class="material-symbols-outlined text-2xl">close</span>
            </button>
        </div>

        <!-- Center Image View -->
        <div class="relative flex-1 flex items-center justify-center my-4 overflow-hidden">
            <img :src="images[activeModalImage]" alt="Full preview" class="max-h-full max-w-full object-contain rounded-2xl shadow-2xl transition-all duration-300">

            <!-- Prev / Next Controls -->
            <button x-show="images.length > 1" type="button" @click="prevImage()" class="absolute left-2 sm:left-6 h-12 w-12 rounded-full bg-white/20 hover:bg-white/30 text-white flex items-center justify-center backdrop-blur-md transition transform hover:scale-110">
                <span class="material-symbols-outlined text-2xl">chevron_left</span>
            </button>
            <button x-show="images.length > 1" type="button" @click="nextImage()" class="absolute right-2 sm:right-6 h-12 w-12 rounded-full bg-white/20 hover:bg-white/30 text-white flex items-center justify-center backdrop-blur-md transition transform hover:scale-110">
                <span class="material-symbols-outlined text-2xl">chevron_right</span>
            </button>
        </div>

        <!-- Bottom Thumbnails Row -->
        <div x-show="images.length > 1" class="flex justify-center gap-2 overflow-x-auto py-2 z-10 max-w-2xl mx-auto">
            <template x-for="(img, idx) in images" :key="idx">
                <button type="button" @click="activeModalImage = idx" :class="activeModalImage === idx ? 'ring-2 ring-emerald-400 opacity-100 scale-105' : 'opacity-50 hover:opacity-80'" class="h-14 w-20 rounded-lg overflow-hidden flex-shrink-0 transition-all duration-200">
                    <img :src="img" alt="thumb" class="w-full h-full object-cover">
                </button>
            </template>
        </div>
    </div>

</div>
@endsection
