@extends('layouts.app')

@php
    $pageTitle = $property->title . ' (' . $property->formatted_price . ') | HomiQ';
    $metaDesc = \Illuminate\Support\Str::limit(strip_tags($property->description), 155) . ' 0% Brokerage & direct owner contact on HomiQ.';
    $canonical = $property->seo_url;
@endphp

@section('title', $pageTitle)
@section('meta_description', $metaDesc)
@section('canonical_url', $canonical)

@section('og_tags')
<meta property="og:site_name" content="HomiQ" />
<meta property="og:type" content="place" />
<meta property="og:title" content="{{ $property->title }} ({{ $property->formatted_price }}) - 0% Brokerage | HomiQ" />
<meta property="og:description" content="{{ $property->bedrooms ? $property->bedrooms . ' BHK ' : '' }}{{ $property->category }} in {{ $property->address }}. Verified listing, 0% brokerage on HomiQ. {{ \Illuminate\Support\Str::limit(strip_tags($property->description), 120) }}" />
<meta property="og:url" content="{{ $canonical }}" />
<meta property="og:image" content="{{ (!empty($property->images) && is_array($property->images)) ? $property->images[0] : asset('logo.png') }}" />
<meta name="twitter:card" content="summary_large_image" />
<meta name="twitter:title" content="{{ $property->title }} ({{ $property->formatted_price }}) | HomiQ" />
<meta name="twitter:description" content="{{ $property->bedrooms ? $property->bedrooms . ' BHK ' : '' }}{{ $property->category }} in {{ $property->address }} - 0% Brokerage on HomiQ" />
<meta name="twitter:image" content="{{ (!empty($property->images) && is_array($property->images)) ? $property->images[0] : asset('logo.png') }}" />

<!-- App Deep Linking & Smart App Banners (Task 44) -->
<meta name="apple-itunes-app" content="app-id=6779412636, app-argument={{ $canonical }}" />
<meta property="al:ios:url" content="homiq://property/{{ $property->id }}" />
<meta property="al:ios:app_store_id" content="6779412636" />
<meta property="al:ios:app_name" content="HomiQ" />
<meta property="al:android:url" content="homiq://property/{{ $property->id }}" />
<meta property="al:android:package" content="com.homiq.app" />
<meta property="al:android:app_name" content="HomiQ" />
<meta property="al:web:url" content="{{ $canonical }}" />
<meta name="twitter:app:name:iphone" content="HomiQ" />
<meta name="twitter:app:id:iphone" content="6779412636" />
<meta name="twitter:app:url:iphone" content="homiq://property/{{ $property->id }}" />
<meta name="twitter:app:name:googleplay" content="HomiQ" />
<meta name="twitter:app:id:googleplay" content="com.homiq.app" />
<meta name="twitter:app:url:googleplay" content="homiq://property/{{ $property->id }}" />
@endsection

@section('structured_data')
<script type="application/ld+json">
{
  "@@context": "https://schema.org",
  "@@graph": [
    {
      "@@type": "BreadcrumbList",
      "itemListElement": [
        {
          "@@type": "ListItem",
          "position": 1,
          "name": "Home",
          "item": "{{ url('/') }}"
        },
        {
          "@@type": "ListItem",
          "position": 2,
          "name": "{{ ucfirst($property->listing_type ?? 'Rent') }}",
          "item": "{{ url('/' . ($property->listing_type ?? 'rent') . '/' . strtolower($property->city ?? 'noida')) }}"
        },
        {
          "@@type": "ListItem",
          "position": 3,
          "name": "{{ $property->title }}",
          "item": "{{ $canonical }}"
        }
      ]
    },
    {
      "@@type": "SingleFamilyResidence",
      "@@id": "{{ $canonical }}#residence",
      "name": "{{ $property->title }}",
      "description": "{{ addslashes(\Illuminate\Support\Str::limit(strip_tags($property->description), 200)) }}",
      "url": "{{ $canonical }}",
      @if(!empty($property->images) && is_array($property->images))
      "photo": {{ json_encode($property->images) }},
      @endif
      "address": {
        "@@type": "PostalAddress",
        "streetAddress": "{{ $property->address }}",
        "addressLocality": "{{ $property->city ?? 'Noida' }}",
        "addressRegion": "UP",
        "addressCountry": "IN"
      },
      @if($property->latitude && $property->longitude)
      "geo": {
        "@@type": "GeoCoordinates",
        "latitude": {{ $property->latitude }},
        "longitude": {{ $property->longitude }}
      },
      @endif
      "numberOfBedrooms": {{ $property->bedrooms ?? 1 }},
      "numberOfBathroomsTotal": {{ $property->bathrooms ?? 1 }},
      "offers": {
        "@@type": "Offer",
        "price": "{{ $property->price }}",
        "priceCurrency": "INR",
        "availability": "https://schema.org/InStock",
        "validFrom": "{{ $property->verified_at ? $property->verified_at->format('Y-m-d') : date('Y-m-d') }}"
      }
    }
  ]
}
</script>
@endsection

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
    
    // Cost Calculations (Task 31)
    $monthlyRent = (float) $property->price;
    $securityDeposit = $property->security_deposit ? (float) $property->security_deposit : ($monthlyRent * 2);
    $maintenanceFee = $property->listing_type === 'rent' ? (float) ($property->maintenance_fee ?? 2000) : 0;
    $totalMoveIn = $monthlyRent + $securityDeposit + $maintenanceFee;
@endphp

<script>
function initPropertyDetail() {
    return {
        activeModalImage: 0,
        isModalOpen: false,
        isVerifyModalOpen: false,
        isReportModalOpen: false,
        isScheduleModalOpen: false,
        scheduleDate: @json(date('Y-m-d', strtotime('+1 day'))),
        scheduleTime: '11:00 AM',
        visitorName: @json(Auth::user()?->name ?? ''),
        visitorPhone: @json(Auth::user()?->phone ?? ''),
        scheduleSubmitting: false,
        scheduleSuccess: false,
        reportReason: 'fake_property',
        reportDetails: '',
        reporterName: @json(Auth::user()?->name ?? ''),
        reporterContact: @json(Auth::user()?->email ?? Auth::user()?->phone ?? ''),
        reportSubmitting: false,
        reportSuccess: false,
        reportError: '',
        renewSubmitting: false,
        renewSuccess: false,
        renewMessage: '',
        similarTab: 'locality',
        images: @json($images),
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
            const shareTitle = @json($property->title);
            const shareText = @json(($property->bedrooms ? $property->bedrooms . ' BHK ' : '') . $property->category . ' for ' . ucfirst($property->listing_type) . "\n" . $addr . "\n" . $property->formatted_price . "\nVerified Listing (0% Brokerage)\n") + window.location.href;
            if (typeof window.homiqTrack === 'function') {
                window.homiqTrack('property_shared', { property_id: {{ $property->id }}, title: shareTitle }, 'seeker', 'property_view');
            }
            if (navigator.share) {
                navigator.share({
                    title: shareTitle,
                    text: shareText,
                    url: window.location.href
                }).catch(() => {});
            } else if (navigator.clipboard) {
                navigator.clipboard.writeText(shareText);
                alert('Listing link and formatted preview copied to clipboard!');
            }
        },
        openInApp() {
            if (typeof window.homiqTrack === 'function') {
                window.homiqTrack('app_download_clicked', { property_id: {{ $property->id }}, source: 'property_detail_deep_link' }, 'general', 'app_download');
            }
            const appUrl = 'homiq://property/{{ $property->id }}';
            const isIos = /iPad|iPhone|iPod/.test(navigator.userAgent) && !window.MSStream;
            const storeUrl = isIos 
                ? 'https://apps.apple.com/app/homiq-real-estate/id6779412636' 
                : 'https://play.google.com/store/apps/details?id=com.homiq.app';
            const start = Date.now();
            window.location.href = appUrl;
            setTimeout(() => {
                if (Date.now() - start < 2000 && !document.hidden) {
                    window.location.href = storeUrl;
                }
            }, 1500);
        },
        submitScheduleVisit() {
            this.scheduleSubmitting = true;
            if (typeof window.homiqTrack === 'function') {
                window.homiqTrack('visit_requested', { property_id: {{ $property->id }}, date: this.scheduleDate, time: this.scheduleTime }, 'seeker', 'contact_owner');
            }
            setTimeout(() => {
                this.scheduleSubmitting = false;
                this.scheduleSuccess = true;
                fetch('/properties/{{ $property->id }}/track-contact', {
                    method: 'POST',
                    headers: { 'Content-Type': 'application/json', 'X-CSRF-TOKEN': '{{ csrf_token() }}' },
                    body: JSON.stringify({ type: 'schedule_visit', date: this.scheduleDate, time: this.scheduleTime })
                });
            }, 800);
        },
        async submitReport() {
            this.reportSubmitting = true;
            this.reportError = '';
            try {
                const res = await fetch('{{ route('properties.report', $property->id) }}', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': '{{ csrf_token() }}',
                        'Accept': 'application/json'
                    },
                    body: JSON.stringify({
                        reason: this.reportReason,
                        details: this.reportDetails,
                        reporter_name: this.reporterName,
                        reporter_contact: this.reporterContact
                    })
                });
                const data = await res.json();
                if (res.ok && data.success) {
                    this.reportSuccess = true;
                } else {
                    this.reportError = data.message || 'Failed to submit report. Please try again.';
                }
            } catch (e) {
                this.reportError = 'Network error. Please try again.';
            } finally {
                this.reportSubmitting = false;
            }
        },
        async confirmRenewal() {
            this.renewSubmitting = true;
            try {
                const res = await fetch('{{ route('properties.renew', $property->id) }}', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': '{{ csrf_token() }}',
                        'Accept': 'application/json'
                    }
                });
                const data = await res.json();
                if (res.ok && data.success) {
                    this.renewSuccess = true;
                    this.renewMessage = data.message;
                    setTimeout(() => window.location.reload(), 1500);
                } else {
                    alert(data.error || 'Failed to renew listing.');
                }
            } catch (e) {
                alert('Network error. Please try again.');
            } finally {
                this.renewSubmitting = false;
            }
        }
    };
}
</script>

<div x-data="initPropertyDetail()" @keydown.escape.window="closeModal(); isVerifyModalOpen = false; isReportModalOpen = false; isScheduleModalOpen = false;" @keydown.right.window="if(isModalOpen) nextImage()" @keydown.left.window="if(isModalOpen) prevImage()">

    <!-- ═══════════════════════════════════════════════════════════════════ -->
    <!-- 1. TOP HERO HEADER BANNER (DEEP EMERALD GREEN THEME) -->
    <!-- ═══════════════════════════════════════════════════════════════════ -->
    <div class="bg-[#0b5e3f] text-white py-8 sm:py-12 border-b border-[#084830]">
        <div class="max-w-[1440px] mx-auto px-6 sm:px-8">
            
            <!-- Breadcrumb Navigation & Action Buttons -->
            <div class="flex flex-wrap items-center justify-between gap-4 mb-4 text-xs font-medium text-emerald-100/90">
                <nav class="flex items-center gap-2 flex-wrap">
                    <a href="/" class="hover:text-white transition flex items-center gap-1 font-semibold">
                        <span class="material-symbols-outlined text-sm">arrow_back</span>
                        Home
                    </a>
                    <span>/</span>
                    <a href="/{{ $property->listing_type ?? 'rent' }}/{{ strtolower($property->city ?? 'noida') }}" class="hover:text-white transition">
                        {{ ucfirst($property->listing_type ?? 'Rent') }} in {{ $property->city ?? 'Noida' }}
                    </a>
                    <span>/</span>
                    <span class="text-white font-bold truncate max-w-[280px]">{{ $property->title }}</span>
                </nav>

                <div class="flex items-center gap-2">
                    <button type="button" @click="openInApp()" class="px-3.5 py-1.5 rounded-full border border-emerald-400/40 hover:border-white bg-emerald-800/60 hover:bg-emerald-800 text-white font-bold flex items-center gap-1.5 shadow-2xs transition cursor-pointer" title="Open directly in HomiQ App">
                        <span class="material-symbols-outlined text-base text-emerald-200">smartphone</span>
                        <span class="hidden sm:inline">Open in App</span>
                    </button>
                    <button type="button" @click="shareProperty()" class="px-3.5 py-1.5 rounded-full border border-emerald-400/40 hover:border-white bg-emerald-800/60 hover:bg-emerald-800 text-white font-semibold flex items-center gap-1.5 shadow-2xs transition cursor-pointer">
                        <span class="material-symbols-outlined text-base">share</span>
                        <span>Share</span>
                    </button>
                    <button type="button" onclick="if(typeof window.homiqTrack === 'function') window.homiqTrack('property_saved', { property_id: {{ $property->id }} }, 'seeker', 'property_view'); fetch('/properties/{{ $property->id }}/track-save', { method: 'POST', headers: { 'X-CSRF-TOKEN': '{{ csrf_token() }}' } }); alert('Saved to your favorites!')" class="px-3.5 py-1.5 rounded-full border border-emerald-400/40 hover:border-rose-300 hover:text-rose-300 bg-emerald-800/60 text-white font-semibold flex items-center gap-1.5 shadow-2xs transition cursor-pointer">
                        <span class="material-symbols-outlined text-base text-rose-300">favorite</span>
                        <span>Save</span>
                    </button>
                    <button type="button" @click="isReportModalOpen = true; reportSuccess = false; reportError = ''" class="px-3.5 py-1.5 rounded-full border border-emerald-400/40 hover:border-rose-300 hover:text-rose-300 bg-emerald-800/60 text-white font-semibold flex items-center gap-1.5 shadow-2xs transition cursor-pointer" title="Report this listing">
                        <span class="material-symbols-outlined text-base text-rose-300">flag</span>
                        <span class="hidden sm:inline">Report</span>
                    </button>
                </div>
            </div>

            <!-- Property Title & Subtitle -->
            <div class="mt-2">
                <h1 class="text-3xl sm:text-4xl lg:text-5xl font-black text-white tracking-tight leading-tight mb-2">
                    {{ $property->title }}
                </h1>
                <p class="text-emerald-100 text-sm sm:text-base font-medium mb-3">
                    {{ $property->bedrooms ? $property->bedrooms . ' BHK ' : '' }}{{ $property->category }} for {{ ucfirst($property->listing_type) }} · 0% Brokerage
                </p>
                <div class="flex flex-wrap items-center gap-4 text-xs sm:text-sm text-emerald-100/90">
                    <span class="flex items-center gap-1.5 font-medium">
                        <span class="material-symbols-outlined text-base text-emerald-300">location_on</span>
                        {{ $addr }}
                    </span>
                    @if($property->distance_from_metro)
                    <span class="text-emerald-300/60 hidden sm:inline">•</span>
                    <span class="inline-flex items-center gap-1 text-xs font-bold text-white bg-emerald-800/80 px-2.5 py-0.5 rounded-full border border-emerald-400/30">
                        <span class="material-symbols-outlined text-xs">subway</span>
                        {{ $property->distance_from_metro }}
                    </span>
                    @endif
                </div>

                <!-- Trust Badges Bar -->
                <div class="flex flex-wrap items-center gap-2 mt-5">
                    @if(($property->listed_by ?? 'owner') === 'owner')
                        <span class="px-3 py-1 rounded-full bg-emerald-900 text-white text-[11px] font-bold uppercase tracking-wider shadow-xs flex items-center gap-1 border border-emerald-400/30">
                            <span class="material-symbols-outlined text-sm">verified_user</span>
                            Listed by Owner
                        </span>
                    @else
                        <span class="px-3 py-1 rounded-full bg-slate-900 text-white text-[11px] font-bold uppercase tracking-wider shadow-xs flex items-center gap-1 border border-slate-700/50">
                            <span class="material-symbols-outlined text-sm">business</span>
                            Verified Agent
                        </span>
                    @endif

                    <span class="px-3 py-1 rounded-full bg-emerald-950/70 text-white text-[11px] font-bold uppercase tracking-wider shadow-xs border border-emerald-500/20">
                        For {{ ucfirst($property->listing_type) }}
                    </span>
                    <span class="px-3 py-1 rounded-full bg-emerald-500 text-white text-[11px] font-bold uppercase tracking-wider shadow-xs">
                        0% Brokerage
                    </span>
                    <button type="button" @click="isVerifyModalOpen = true" class="px-3 py-1 rounded-full bg-white/20 hover:bg-white/30 text-white border border-white/30 text-[11px] font-bold flex items-center gap-1 shadow-xs transition cursor-pointer" title="Click to view what Verified means">
                        <span class="material-symbols-outlined text-sm text-emerald-200">verified</span>
                        <span>Verified Listing</span>
                        <span class="material-symbols-outlined text-xs text-emerald-200">help</span>
                    </button>
                    <span class="px-3 py-1 rounded-full bg-white/10 text-white text-[11px] font-bold flex items-center gap-1 border border-white/20">
                        <span class="material-symbols-outlined text-sm text-emerald-200">schedule</span>
                        {{ $property->freshness_badge }}
                    </span>
                    <span class="px-3 py-1 rounded-full bg-emerald-400/20 text-white text-[11px] font-bold flex items-center gap-1 border border-emerald-400/30">
                        <span class="material-symbols-outlined text-sm text-emerald-300">event_available</span>
                        {{ $property->availability_badge }}
                    </span>
                </div>
            </div>

        </div>
    </div>

    <!-- ═══════════════════════════════════════════════════════════════════ -->
    <!-- 2. MAIN BODY CONTAINER -->
    <!-- ═══════════════════════════════════════════════════════════════════ -->
    <div class="max-w-[1440px] mx-auto px-6 sm:px-8 py-8">

        <!-- Expiration / Availability Warning Banner (If applicable) -->
        @if($property->is_expired || $property->status === 'temporarily_unavailable')
            <div class="mb-6 p-4 sm:p-5 rounded-2xl bg-amber-50 border border-amber-200 text-amber-900 shadow-sm flex flex-col sm:flex-row sm:items-center justify-between gap-4">
                <div class="flex items-start gap-3">
                    <span class="material-symbols-outlined text-amber-600 text-2xl shrink-0 mt-0.5">warning</span>
                    <div>
                        <strong class="block text-sm font-bold text-amber-900">Listing Temporarily Unavailable</strong>
                        <p class="text-xs text-amber-700 mt-0.5">This listing has reached its 30-day verification cycle and is pending availability confirmation from the landlord.</p>
                    </div>
                </div>
                @if(Auth::check() && (Auth::id() === $property->owner_id || Auth::user()->is_admin))
                    <button type="button" @click="confirmRenewal()" :disabled="renewSubmitting" class="px-4 py-2.5 rounded-xl bg-amber-700 hover:bg-amber-800 text-white font-bold text-xs flex items-center justify-center gap-2 shadow-sm transition shrink-0">
                        <span class="material-symbols-outlined text-base">published_with_changes</span>
                        <span x-text="renewSubmitting ? 'Confirming...' : 'Confirm Availability & Renew for 30 Days'"></span>
                    </button>
                @endif
            </div>
        @endif

        <!-- Photo Gallery (Matching Clean 3-Card Layout in Screenshots) -->
        <div class="mb-10">
            @if($imgCount === 1)
                <div class="relative h-[380px] sm:h-[480px] lg:h-[500px] rounded-2xl overflow-hidden shadow-sm group cursor-pointer bg-slate-100" @click="openModal(0)">
                    <img src="{{ $images[0] }}" alt="{{ $property->title }}" class="w-full h-full object-cover group-hover:scale-102 transition-transform duration-500">
                    <div class="absolute bottom-4 right-4 px-4 py-2 rounded-xl bg-white/95 hover:bg-white text-slate-900 font-bold text-xs flex items-center gap-1.5 shadow-md">
                        <span class="material-symbols-outlined text-base">fullscreen</span>
                        <span>Expand Photo</span>
                    </div>
                </div>
            @elseif($imgCount === 2)
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 h-[380px] sm:h-[460px] rounded-2xl overflow-hidden shadow-sm">
                    @foreach($images as $idx => $img)
                        <div class="relative group cursor-pointer overflow-hidden bg-slate-100 h-full" @click="openModal({{ $idx }})">
                            <img src="{{ $img }}" alt="{{ $property->title }} - Photo {{ $idx + 1 }}" class="w-full h-full object-cover group-hover:scale-102 transition-transform duration-500">
                        </div>
                    @endforeach
                </div>
            @else
                <div class="grid grid-cols-1 md:grid-cols-3 gap-4 h-[380px] sm:h-[480px] rounded-2xl overflow-hidden relative">
                    <!-- Large Primary Photo (Left 2 columns) -->
                    <div class="md:col-span-2 relative group cursor-pointer overflow-hidden bg-slate-100 rounded-2xl h-full shadow-xs" @click="openModal(0)">
                        <img src="{{ $images[0] }}" alt="{{ $property->title }} - Main" class="w-full h-full object-cover group-hover:scale-102 transition-transform duration-500">
                    </div>

                    <!-- 2 Stacked Photos (Right 1 column) -->
                    <div class="grid grid-rows-2 gap-4 h-full">
                        <div class="relative group cursor-pointer overflow-hidden bg-slate-100 rounded-2xl h-full shadow-xs" @click="openModal(1)">
                            <img src="{{ $images[1] }}" alt="{{ $property->title }} - Photo 2" class="w-full h-full object-cover group-hover:scale-102 transition-transform duration-500">
                        </div>
                        <div class="relative group cursor-pointer overflow-hidden bg-slate-100 rounded-2xl h-full shadow-xs" @click="openModal(2)">
                            <img src="{{ $images[2] }}" alt="{{ $property->title }} - Photo 3" class="w-full h-full object-cover group-hover:scale-102 transition-transform duration-500">
                            @if($imgCount > 3)
                                <div class="absolute inset-0 bg-slate-950/50 backdrop-blur-xs flex items-center justify-center group-hover:bg-slate-950/60 transition-colors">
                                    <span class="px-4 py-2 rounded-xl bg-white text-slate-900 font-bold text-xs flex items-center gap-1.5 shadow-md">
                                        <span class="material-symbols-outlined text-base">photo_library</span>
                                        View All ({{ $imgCount }})
                                    </span>
                                </div>
                            @endif
                        </div>
                    </div>

                    <button type="button" @click="openModal(0)" class="absolute bottom-4 right-4 px-4 py-2 rounded-xl bg-white/95 hover:bg-white text-slate-900 font-bold text-xs flex items-center gap-1.5 shadow-md backdrop-blur-md transition transform hover:scale-105 z-10">
                        <span class="material-symbols-outlined text-base">photo_library</span>
                        <span>All Photos ({{ $imgCount }})</span>
                    </button>
                </div>
            @endif
        </div>

        <!-- Main Content & Sticky Booking Grid -->
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-10 lg:gap-12 items-start">
            
            <!-- ═══════════════════════════════════════════════════════════════ -->
            <!-- LEFT COLUMN: OVERVIEW, HIGHLIGHTS, AMENITIES, SPECIFICATIONS -->
            <!-- ═══════════════════════════════════════════════════════════════ -->
            <div class="lg:col-span-2 space-y-10">

                <!-- 1. Project Overview -->
                <div>
                    <h2 class="text-2xl font-bold text-slate-900 mb-3">Project Overview</h2>
                    <div class="text-slate-600 text-sm sm:text-base leading-relaxed whitespace-pre-line">
                        {{ $property->description }}
                    </div>
                </div>

                <!-- 2. Key Highlights -->
                <div>
                    <h3 class="text-xl font-bold text-slate-900 mb-4">Key Highlights</h3>
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-3.5">
                        <div class="flex items-center gap-2.5 text-slate-700 text-xs sm:text-sm font-medium">
                            <span class="material-symbols-outlined text-emerald-600 text-lg">check_circle</span>
                            <span>0% Brokerage</span>
                        </div>
                        <div class="flex items-center gap-2.5 text-slate-700 text-xs sm:text-sm font-medium">
                            <span class="material-symbols-outlined text-emerald-600 text-lg">check_circle</span>
                            <span>Listed by Owner</span>
                        </div>
                        <div class="flex items-center gap-2.5 text-slate-700 text-xs sm:text-sm font-medium">
                            <span class="material-symbols-outlined text-emerald-600 text-lg">check_circle</span>
                            <span>Verified Listing</span>
                        </div>
                        <div class="flex items-center gap-2.5 text-slate-700 text-xs sm:text-sm font-medium">
                            <span class="material-symbols-outlined text-emerald-600 text-lg">check_circle</span>
                            <span>{{ $property->bedrooms ? $property->bedrooms . ' BHK' : $property->category }}</span>
                        </div>
                        <div class="flex items-center gap-2.5 text-slate-700 text-xs sm:text-sm font-medium">
                            <span class="material-symbols-outlined text-emerald-600 text-lg">check_circle</span>
                            <span>{{ $property->is_furnished ? 'Furnished' : 'Unfurnished' }}</span>
                        </div>
                        <div class="flex items-center gap-2.5 text-slate-700 text-xs sm:text-sm font-medium">
                            <span class="material-symbols-outlined text-emerald-600 text-lg">check_circle</span>
                            <span>{{ $property->has_parking ? 'Dedicated Parking Space' : 'Standard Society Parking' }}</span>
                        </div>
                        <div class="flex items-center gap-2.5 text-slate-700 text-xs sm:text-sm font-medium">
                            <span class="material-symbols-outlined text-emerald-600 text-lg">check_circle</span>
                            <span>{{ $property->available_from ? 'Available from ' . $property->available_from->format('d M Y') : 'Available Immediately' }}</span>
                        </div>
                        <div class="flex items-center gap-2.5 text-slate-700 text-xs sm:text-sm font-medium">
                            <span class="material-symbols-outlined text-emerald-600 text-lg">check_circle</span>
                            <span>{{ $property->distance_from_metro ?: 'Prime Connectivity & Transit Nearby' }}</span>
                        </div>
                    </div>
                </div>

                <!-- 3. Amenities & Features -->
                <div>
                    <h3 class="text-xl font-bold text-slate-900 mb-4">Amenities &amp; Features</h3>
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-3.5">
                        <div class="p-4 rounded-xl bg-slate-50 border border-slate-100 flex items-start gap-3.5">
                            <div class="h-10 w-10 rounded-xl bg-white border border-slate-200/80 flex items-center justify-center text-emerald-700 shrink-0 shadow-2xs">
                                <span class="material-symbols-outlined text-xl">shield</span>
                            </div>
                            <div>
                                <span class="text-sm font-bold text-slate-900 block">24/7 Security</span>
                                <p class="text-xs text-slate-500 mt-0.5">Round-the-clock security with CCTV surveillance</p>
                            </div>
                        </div>

                        <div class="p-4 rounded-xl bg-slate-50 border border-slate-100 flex items-start gap-3.5">
                            <div class="h-10 w-10 rounded-xl bg-white border border-slate-200/80 flex items-center justify-center text-emerald-700 shrink-0 shadow-2xs">
                                <span class="material-symbols-outlined text-xl">local_parking</span>
                            </div>
                            <div>
                                <span class="text-sm font-bold text-slate-900 block">Dedicated Parking</span>
                                <p class="text-xs text-slate-500 mt-0.5">Dedicated parking space for residents &amp; visitors</p>
                            </div>
                        </div>

                        <div class="p-4 rounded-xl bg-slate-50 border border-slate-100 flex items-start gap-3.5">
                            <div class="h-10 w-10 rounded-xl bg-white border border-slate-200/80 flex items-center justify-center text-emerald-700 shrink-0 shadow-2xs">
                                <span class="material-symbols-outlined text-xl">yard</span>
                            </div>
                            <div>
                                <span class="text-sm font-bold text-slate-900 block">Green Spaces</span>
                                <p class="text-xs text-slate-500 mt-0.5">Landscaped parks and open green areas</p>
                            </div>
                        </div>

                        <div class="p-4 rounded-xl bg-slate-50 border border-slate-100 flex items-start gap-3.5">
                            <div class="h-10 w-10 rounded-xl bg-white border border-slate-200/80 flex items-center justify-center text-emerald-700 shrink-0 shadow-2xs">
                                <span class="material-symbols-outlined text-xl">bolt</span>
                            </div>
                            <div>
                                <span class="text-sm font-bold text-slate-900 block">Modern Infrastructure</span>
                                <p class="text-xs text-slate-500 mt-0.5">Power backup, water supply &amp; maintenance</p>
                            </div>
                        </div>

                        @if(!empty($property->amenities) && is_array($property->amenities))
                            @foreach ($property->amenities as $amenity)
                                @php
                                    $aLower = strtolower($amenity);
                                    $icon = 'check_circle';
                                    if (str_contains($aLower, 'wifi') || str_contains($aLower, 'internet')) $icon = 'wifi';
                                    elseif (str_contains($aLower, 'pool') || str_contains($aLower, 'swim')) $icon = 'pool';
                                    elseif (str_contains($aLower, 'ac') || str_contains($aLower, 'air condition')) $icon = 'ac_unit';
                                    elseif (str_contains($aLower, 'gym') || str_contains($aLower, 'fitness')) $icon = 'fitness_center';
                                    elseif (str_contains($aLower, 'balcony') || str_contains($aLower, 'terrace')) $icon = 'balcony';
                                    elseif (str_contains($aLower, 'elevator') || str_contains($aLower, 'lift')) $icon = 'elevator';
                                    elseif (str_contains($aLower, 'water')) $icon = 'water_drop';
                                @endphp
                                <div class="p-4 rounded-xl bg-slate-50 border border-slate-100 flex items-start gap-3.5">
                                    <div class="h-10 w-10 rounded-xl bg-white border border-slate-200/80 flex items-center justify-center text-emerald-700 shrink-0 shadow-2xs">
                                        <span class="material-symbols-outlined text-xl">{{ $icon }}</span>
                                    </div>
                                    <div>
                                        <span class="text-sm font-bold text-slate-900 block">{{ $amenity }}</span>
                                        <p class="text-xs text-slate-500 mt-0.5">Verified property feature</p>
                                    </div>
                                </div>
                            @endforeach
                        @endif
                    </div>
                </div>

                <!-- 4. Specifications Table (Matching Screenshot 2) -->
                <div>
                    <h3 class="text-xl font-bold text-slate-900 mb-4">Specifications</h3>
                    <div class="bg-white rounded-xl border border-slate-200 divide-y divide-slate-100 overflow-hidden text-xs sm:text-sm">
                        <div class="flex items-center justify-between p-3.5 bg-slate-50/50">
                            <span class="font-semibold text-slate-600">Plot / Built-up Area</span>
                            <span class="font-bold text-slate-900">{{ $property->plot_area ?: ($property->built_up_area ? number_format($property->built_up_area) . ' sq ft' : ($property->carpet_area ? number_format($property->carpet_area) . ' sq ft' : '1,150 sq ft')) }}</span>
                        </div>

                        @if($property->carpet_area)
                        <div class="flex items-center justify-between p-3.5">
                            <span class="font-semibold text-slate-600">Carpet Area</span>
                            <span class="font-bold text-slate-900">{{ number_format($property->carpet_area) }} sq ft</span>
                        </div>
                        @endif

                        @if($property->bedrooms > 0)
                        <div class="flex items-center justify-between p-3.5 bg-slate-50/50">
                            <span class="font-semibold text-slate-600">Configuration</span>
                            <span class="font-bold text-slate-900">{{ $property->bedrooms }} BHK</span>
                        </div>
                        @endif

                        <div class="flex items-center justify-between p-3.5">
                            <span class="font-semibold text-slate-600">Furnishing</span>
                            <span class="font-bold text-slate-900">{{ $property->is_furnished ? 'Furnished' : 'Unfurnished' }}</span>
                        </div>

                        @if($property->floor_number !== null)
                        <div class="flex items-center justify-between p-3.5 bg-slate-50/50">
                            <span class="font-semibold text-slate-600">Floor Level</span>
                            <span class="font-bold text-slate-900">Floor {{ $property->floor_number }} of {{ $property->total_floors ?: 'Any' }}</span>
                        </div>
                        @endif

                        @if($property->facing_direction)
                        <div class="flex items-center justify-between p-3.5">
                            <span class="font-semibold text-slate-600">Facing</span>
                            <span class="font-bold text-slate-900">{{ $property->facing_direction }}</span>
                        </div>
                        @endif

                        <div class="flex items-center justify-between p-3.5 bg-slate-50/50">
                            <span class="font-semibold text-slate-600">Listed By</span>
                            <span class="font-bold text-slate-900">{{ ucfirst($property->listed_by ?? 'owner') }} (0% Brokerage)</span>
                        </div>

                        <div class="flex items-center justify-between p-3.5">
                            <span class="font-semibold text-slate-600">Possession / Available</span>
                            <span class="font-bold text-slate-900">{{ $property->available_from ? $property->available_from->format('d M Y') : 'Immediate' }}</span>
                        </div>
                    </div>
                </div>

                <!-- 5. Location Advantages (Matching Screenshot 2) -->
                <div>
                    <h3 class="text-xl font-bold text-slate-900 mb-4">Location Advantages</h3>
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-3.5">
                        <div class="flex items-center gap-2.5 text-slate-700 text-xs sm:text-sm font-medium">
                            <span class="material-symbols-outlined text-emerald-600 text-lg">location_on</span>
                            <span>{{ $property->distance_from_metro ?: 'Nearest Metro Station (Aqua Line / Blue Line)' }}</span>
                        </div>
                        <div class="flex items-center gap-2.5 text-slate-700 text-xs sm:text-sm font-medium">
                            <span class="material-symbols-outlined text-emerald-600 text-lg">location_on</span>
                            <span>Direct Expressway &amp; Highway Connectivity</span>
                        </div>
                        <div class="flex items-center gap-2.5 text-slate-700 text-xs sm:text-sm font-medium">
                            <span class="material-symbols-outlined text-emerald-600 text-lg">location_on</span>
                            <span>Close to Corporate IT Tech Parks</span>
                        </div>
                        <div class="flex items-center gap-2.5 text-slate-700 text-xs sm:text-sm font-medium">
                            <span class="material-symbols-outlined text-emerald-600 text-lg">location_on</span>
                            <span>Nearby Multi-specialty Healthcare &amp; Hospitals</span>
                        </div>
                        <div class="flex items-center gap-2.5 text-slate-700 text-xs sm:text-sm font-medium">
                            <span class="material-symbols-outlined text-emerald-600 text-lg">location_on</span>
                            <span>Supermarkets &amp; Daily Needs Markets Nearby</span>
                        </div>
                        <div class="flex items-center gap-2.5 text-slate-700 text-xs sm:text-sm font-medium">
                            <span class="material-symbols-outlined text-emerald-600 text-lg">location_on</span>
                            <span>Reputed Schools &amp; Educational Institutions</span>
                        </div>
                    </div>
                </div>

                <!-- 6. Complete Rental Cost Breakdown (Task 31) -->
                @if($property->listing_type === 'rent')
                <div class="bg-white rounded-2xl p-6 sm:p-8 border border-slate-200/80 shadow-soft">
                    <div class="flex items-center justify-between pb-4 mb-5 border-b border-slate-100">
                        <div>
                            <div class="inline-flex items-center gap-1.5 text-emerald-700 font-bold text-xs uppercase tracking-wider mb-1">
                                <span class="material-symbols-outlined text-[16px]">receipt_long</span>
                                100% Transparent Financials
                            </div>
                            <h3 class="text-xl font-bold text-slate-900">Complete Rental Cost Breakdown</h3>
                        </div>
                        <span class="px-3 py-1 rounded-full bg-emerald-50 text-emerald-800 text-xs font-bold border border-emerald-300">
                            Zero Brokerage Guarantee
                        </span>
                    </div>

                    <div class="space-y-3.5 text-sm">
                        <div class="flex items-center justify-between p-3.5 rounded-2xl bg-slate-50 border border-slate-100">
                            <div class="flex items-center gap-2.5">
                                <span class="material-symbols-outlined text-slate-600 text-[18px]">payments</span>
                                <div>
                                    <span class="font-bold text-slate-800 block">Monthly Rent</span>
                                    @if($property->has_price_drop)
                                        <span class="text-[11px] text-rose-600 font-bold flex items-center gap-0.5">
                                            <span class="material-symbols-outlined text-xs">trending_down</span>
                                            {{ $property->formatted_price_drop_badge }}
                                        </span>
                                    @endif
                                </div>
                            </div>
                            <div class="text-right">
                                @if($property->has_price_drop)
                                    <span class="text-xs font-bold text-slate-400 line-through mr-1.5">{{ $property->formatted_original_price }}</span>
                                @endif
                                <span class="font-black text-slate-900 text-base">{{ $property->currency_symbol }}{{ number_format($monthlyRent, 0) }}</span>
                            </div>
                        </div>

                        <div class="flex items-center justify-between p-3.5 rounded-2xl bg-slate-50 border border-slate-100">
                            <div class="flex items-center gap-2.5">
                                <span class="material-symbols-outlined text-slate-600 text-[18px]">lock</span>
                                <div>
                                    <span class="font-bold text-slate-800 block">Security Deposit</span>
                                    <span class="text-[11px] text-slate-400 font-medium">100% Refundable at lease end</span>
                                </div>
                            </div>
                            <span class="font-black text-slate-900 text-base">{{ $property->currency_symbol }}{{ number_format($securityDeposit, 0) }}</span>
                        </div>

                        <div class="flex items-center justify-between p-3.5 rounded-2xl bg-slate-50 border border-slate-100">
                            <div class="flex items-center gap-2.5">
                                <span class="material-symbols-outlined text-slate-600 text-[18px]">cleaning_services</span>
                                <div>
                                    <span class="font-bold text-slate-800 block">Society Maintenance</span>
                                    <span class="text-[11px] text-slate-400 font-medium">Covers security, lift, power backup &amp; common areas</span>
                                </div>
                            </div>
                            <span class="font-bold text-slate-800">{{ $property->currency_symbol }}{{ number_format($maintenanceFee, 0) }}/mo</span>
                        </div>

                        <div class="flex items-center justify-between p-3.5 rounded-2xl bg-emerald-50/70 border border-emerald-200">
                            <div class="flex items-center gap-2.5 text-emerald-800">
                                <span class="material-symbols-outlined text-emerald-600 text-[18px]">money_off</span>
                                <div>
                                    <span class="font-bold block">Brokerage Fee</span>
                                    <span class="text-[11px] text-emerald-700 font-medium">You saved ~₹{{ number_format($monthlyRent, 0) }} in broker commission</span>
                                </div>
                            </div>
                            <span class="font-black text-emerald-700 text-base">₹0 (FREE)</span>
                        </div>

                        <div class="flex items-center justify-between p-4 rounded-2xl bg-slate-900 text-white shadow-sm mt-4">
                            <div>
                                <span class="text-xs font-bold uppercase tracking-wider text-slate-300 block">Estimated Move-In Total</span>
                                <span class="text-[11px] text-slate-400">First month rent + security deposit + maintenance</span>
                            </div>
                            <span class="text-xl sm:text-2xl font-black text-emerald-400">
                                {{ $property->currency_symbol }}{{ number_format($totalMoveIn, 0) }}
                            </span>
                        </div>
                    </div>
                </div>
                @endif

                <!-- 7. Landlord Profile Card -->
                <div class="bg-white rounded-2xl p-6 sm:p-8 border border-slate-200 shadow-sm">
                    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-6 pb-6 border-b border-slate-100">
                        <div class="flex items-center gap-4">
                            <div class="h-16 w-16 rounded-2xl bg-gradient-to-br from-[#0b5e3f] to-emerald-600 text-white font-black text-2xl flex items-center justify-center shadow-md flex-shrink-0">
                                {{ strtoupper(substr($property->owner ? $property->owner->name : 'V', 0, 1)) }}
                            </div>
                            <div>
                                <div class="flex items-center gap-2">
                                    <h3 class="text-lg font-black text-slate-900">{{ $property->owner ? $property->owner->name : 'Verified Host' }}</h3>
                                    <span class="px-2 py-0.5 rounded-full bg-emerald-50 text-emerald-700 text-[10px] font-bold border border-emerald-200 flex items-center gap-0.5">
                                        <span class="material-symbols-outlined text-xs text-emerald-600">verified</span>
                                        Verified Landlord
                                    </span>
                                </div>
                                <p class="text-xs text-slate-500 mt-1">Superhost • Direct owner contact • 100% response rate</p>
                            </div>
                        </div>

                        <div class="flex items-center gap-3">
                            @auth
                                @if(Auth::id() !== $property->owner_id)
                                    <a href="/chat?property_id={{ $property->id }}" class="px-5 py-2.5 rounded-xl bg-[#0b5e3f] hover:bg-[#084830] text-white font-bold text-xs flex items-center gap-2 shadow-sm transition">
                                        <span class="material-symbols-outlined text-base">chat</span>
                                        Send Message
                                    </a>
                                @endif
                            @else
                                <a href="/login" class="px-5 py-2.5 rounded-xl bg-[#0b5e3f] hover:bg-[#084830] text-white font-bold text-xs flex items-center gap-2 shadow-sm transition">
                                    <span class="material-symbols-outlined text-base">chat</span>
                                    Message Host
                                </a>
                            @endauth

                            @if ($property->owner && $property->owner->phone)
                                <a href="tel:{{ $property->owner->phone }}" class="p-2.5 rounded-xl border border-slate-200 hover:border-[#0b5e3f] hover:text-[#0b5e3f] text-slate-700 transition" title="Call Landlord">
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

            <!-- ═══════════════════════════════════════════════════════════════ -->
            <!-- RIGHT COLUMN: STICKY CONVERSION CARDS (MATCHING SCREENSHOTS) -->
            <!-- ═══════════════════════════════════════════════════════════════ -->
            <div class="lg:col-span-1 space-y-6 sticky top-28">
                
                <!-- Card 1: Pricing & Primary Conversion Actions -->
                <div class="bg-white rounded-2xl p-6 sm:p-7 border border-slate-200 shadow-sm space-y-5">
                    
                    <!-- Price Tag & Type -->
                    <div class="text-center pb-5 border-b border-slate-100">
                        <div class="text-3xl sm:text-4xl font-black text-[#0b5e3f] tracking-tight">
                            <span>{{ $property->currency_symbol }}{{ number_format($property->price, 0) }}</span>
                            @if(!empty($property->price_unit))
                                <span class="text-sm sm:text-base font-bold text-slate-600 ml-1">
                                    {{ $property->price_unit }}
                                </span>
                            @elseif($property->listing_type === 'rent')
                                <span class="text-xs sm:text-sm font-bold text-slate-500 ml-1">
                                    {{ $property->billing_frequency === 'per_day' ? '/day' : ($property->billing_frequency === 'hourly' ? '/hr' : '/month') }}
                                </span>
                            @endif
                        </div>
                        <span class="text-xs font-semibold text-slate-500 block mt-1">
                            {{ $property->category }} · 0% Brokerage
                        </span>
                    </div>

                    <!-- Quick Spec List (Area, Size, Status) -->
                    <div class="space-y-2.5 text-xs">
                        <div class="flex justify-between items-center text-slate-600">
                            <span>Area:</span>
                            <span class="font-bold text-slate-900">{{ $property->carpet_area ? number_format($property->carpet_area) . ' sq ft' : ($property->built_up_area ? number_format($property->built_up_area) . ' sq ft' : ($property->plot_area ?: '1,150 sq ft')) }}</span>
                        </div>
                        <div class="flex justify-between items-center text-slate-600">
                            <span>Size:</span>
                            <span class="font-bold text-slate-900">{{ $property->bedrooms ? $property->bedrooms . ' BHK' : $property->category }}</span>
                        </div>
                        <div class="flex justify-between items-center text-slate-600">
                            <span>Status:</span>
                            <span class="font-bold text-emerald-700">Available</span>
                        </div>
                    </div>

                    <!-- CTA Buttons -->
                    <div class="space-y-2.5 pt-2">
                        <!-- 1. Call Now Button -->
                        @if ($property->owner && $property->owner->phone)
                            <a href="tel:{{ $property->owner->phone }}" class="w-full py-3.5 rounded-xl bg-[#0b5e3f] hover:bg-[#084830] text-white font-bold text-xs flex items-center justify-center gap-2 shadow-sm transition-all duration-200 cursor-pointer active:scale-98">
                                <span class="material-symbols-outlined text-[18px]">call</span>
                                <span>Call Now</span>
                            </a>
                        @else
                            <button type="button" @click="isScheduleModalOpen = true; scheduleSuccess = false" class="w-full py-3.5 rounded-xl bg-[#0b5e3f] hover:bg-[#084830] text-white font-bold text-xs flex items-center justify-center gap-2 shadow-sm transition-all duration-200 cursor-pointer active:scale-98">
                                <span class="material-symbols-outlined text-[18px]">call</span>
                                <span>Call Host</span>
                            </button>
                        @endif

                        <!-- 2. Schedule Visit Outline Button -->
                        <button type="button" 
                                @click="isScheduleModalOpen = true; scheduleSuccess = false"
                                class="w-full py-3 rounded-xl border-2 border-[#0b5e3f] text-[#0b5e3f] hover:bg-emerald-50 font-bold text-xs flex items-center justify-center gap-2 transition-all duration-200 cursor-pointer active:scale-98">
                            <span class="material-symbols-outlined text-[18px]">calendar_month</span>
                            <span>Schedule Physical Visit</span>
                        </button>

                        <!-- 3. WhatsApp Direct Chat -->
                        <a href="{{ $property->whatsapp_url }}" 
                           target="_blank" 
                           rel="noopener noreferrer" 
                           onclick="if(typeof window.homiqTrack === 'function') window.homiqTrack('whatsapp_clicked', { property_id: {{ $property->id }} }, 'seeker', 'contact_owner'); fetch('/properties/{{ $property->id }}/track-contact', { method: 'POST', headers: { 'Content-Type': 'application/json', 'X-CSRF-TOKEN': '{{ csrf_token() }}' }, body: JSON.stringify({ type: 'whatsapp' }) })"
                           class="w-full py-3 rounded-xl bg-emerald-600 hover:bg-emerald-700 text-white font-bold text-xs flex items-center justify-center gap-2 shadow-sm transition-all duration-200 cursor-pointer active:scale-98">
                            <svg class="w-4.5 h-4.5 fill-current text-white shrink-0" viewBox="0 0 24 24">
                                <path d="M19.05 4.91A9.816 9.816 0 0 0 12.04 2c-5.46 0-9.91 4.45-9.91 9.91 0 1.75.46 3.45 1.32 4.95L2.05 22l5.25-1.38c1.45.79 3.08 1.21 4.74 1.21 5.46 0 9.91-4.45 9.91-9.91 0-2.65-1.03-5.14-2.9-7.01zm-7.01 15.24c-1.48 0-2.93-.4-4.2-1.15l-.3-.18-3.12.82.83-3.04-.2-.31a8.19 8.19 0 0 1-1.26-4.38c0-4.54 3.7-8.24 8.25-8.24 2.2 0 4.27.86 5.82 2.42a8.18 8.18 0 0 1 2.41 5.83c.02 4.54-3.68 8.23-8.23 8.23zm4.52-6.16c-.25-.12-1.47-.72-1.69-.81-.23-.08-.39-.12-.56.12-.17.25-.64.81-.78.98-.14.17-.29.19-.54.06-.25-.12-1.05-.39-2-1.23-.74-.66-1.23-1.47-1.38-1.72-.14-.25-.02-.38.11-.51.11-.11.25-.29.37-.43.12-.14.17-.25.25-.41.08-.17.04-.31-.02-.43s-.56-1.34-.76-1.84c-.2-.48-.41-.42-.56-.43h-.48c-.17 0-.43.06-.66.31-.22.25-.86.84-.86 2.06 0 1.21.89 2.39 1.01 2.56.12.17 1.75 2.67 4.23 3.74.59.26 1.05.41 1.41.52.59.19 1.13.16 1.56.1.48-.07 1.47-.6 1.67-1.18.21-.58.21-1.07.14-1.18-.06-.12-.22-.19-.47-.32z"/>
                            </svg>
                            <span>Chat Directly on WhatsApp</span>
                        </a>

                        <!-- 4. In-App Direct Message -->
                        @auth
                            @if (Auth::id() === $property->owner_id)
                                <div class="p-3 rounded-xl bg-slate-50 border border-slate-200 text-slate-700 text-xs font-semibold flex items-center gap-2">
                                    <span class="material-symbols-outlined text-slate-800 text-base">info</span>
                                    <span>You are the owner of this space.</span>
                                </div>
                            @else
                                <a href="/chat?property_id={{ $property->id }}" 
                                   onclick="if(typeof window.homiqTrack === 'function') window.homiqTrack('contact_owner_clicked', { property_id: {{ $property->id }}, type: 'in-app' }, 'seeker', 'contact_owner'); fetch('/properties/{{ $property->id }}/track-contact', { method: 'POST', headers: { 'Content-Type': 'application/json', 'X-CSRF-TOKEN': '{{ csrf_token() }}' }, body: JSON.stringify({ type: 'inquiry' }) })"
                                    class="w-full py-2.5 rounded-xl bg-slate-100 hover:bg-slate-200 text-slate-800 font-bold text-xs flex items-center justify-center gap-2 transition cursor-pointer">
                                    <span class="material-symbols-outlined text-base text-slate-700">chat</span>
                                    <span>Message Landlord In-App</span>
                                </a>
                            @endif
                        @else
                            <a href="/login" 
                               onclick="if(typeof window.homiqTrack === 'function') window.homiqTrack('contact_owner_clicked', { property_id: {{ $property->id }}, type: 'in-app' }, 'seeker', 'contact_owner'); fetch('/properties/{{ $property->id }}/track-contact', { method: 'POST', headers: { 'Content-Type': 'application/json', 'X-CSRF-TOKEN': '{{ csrf_token() }}' }, body: JSON.stringify({ type: 'inquiry' }) })"
                               class="w-full py-2.5 rounded-xl bg-slate-100 hover:bg-slate-200 text-slate-800 font-bold text-xs flex items-center justify-center gap-2 transition cursor-pointer">
                                <span class="material-symbols-outlined text-base text-slate-700">chat</span>
                                <span>Sign In to Chat In-App</span>
                            </a>
                        @endauth
                    </div>

                </div>

                <!-- Card 2: Get Expert Advice (Matching Screenshot 1 & 2) -->
                <div class="bg-[#0b5e3f] text-white rounded-2xl p-6 shadow-sm space-y-3">
                    <h4 class="text-lg font-bold text-white">Get Expert Advice</h4>
                    <p class="text-xs text-emerald-100 leading-relaxed">
                        Speak with our real estate experts to get personalized guidance for your investment and home search.
                    </p>
                    <a href="tel:{{ $property->owner?->phone ?: '9876543210' }}" class="block w-full py-3 px-4 rounded-xl bg-white hover:bg-slate-50 text-[#0b5e3f] font-bold text-xs text-center shadow-xs transition cursor-pointer">
                        Contact Expert
                    </a>
                </div>

            </div>

        </div>

        <!-- ═══════════════════════════════════════════════════════════════ -->
        <!-- SIMILAR & RELATED PROPERTIES (TASK 33) -->
        <!-- ═══════════════════════════════════════════════════════════════ -->
        <div class="mt-20 pt-12 border-t border-slate-200">
            <div class="flex flex-col md:flex-row md:items-end justify-between gap-4 mb-8">
                <div>
                    <div class="inline-flex items-center gap-1.5 text-emerald-700 font-bold text-xs uppercase tracking-wider mb-1">
                        <span class="material-symbols-outlined text-[16px]">apartment</span>
                        Compare Verified Inventory
                    </div>
                    <h2 class="text-2xl sm:text-3xl font-black text-slate-900 tracking-tight">Similar Properties You Might Like</h2>
                    <p class="text-xs text-slate-500 mt-1">Explore other verified {{ $property->category }} homes with zero brokerage in {{ $property->city ?? 'Noida' }}</p>
                </div>

                <!-- Tab Switcher (Task 33) -->
                <div class="flex items-center gap-2 bg-slate-100 p-1.5 rounded-full text-xs font-bold">
                    <button type="button" @click="similarTab = 'locality'" :class="similarTab === 'locality' ? 'bg-white text-slate-900 shadow-xs' : 'text-slate-600 hover:text-slate-900'" class="px-4 py-1.5 rounded-full transition cursor-pointer">
                        In {{ $primaryLocality }}
                    </button>
                    <button type="button" @click="similarTab = 'price'" :class="similarTab === 'price' ? 'bg-white text-slate-900 shadow-xs' : 'text-slate-600 hover:text-slate-900'" class="px-4 py-1.5 rounded-full transition cursor-pointer">
                        Under ₹{{ number_format((float)$property->price * 1.30, 0) }}
                    </button>
                    @if($property->bedrooms)
                    <button type="button" @click="similarTab = 'bhk'" :class="similarTab === 'bhk' ? 'bg-white text-slate-900 shadow-xs' : 'text-slate-600 hover:text-slate-900'" class="px-4 py-1.5 rounded-full transition cursor-pointer">
                        Other {{ $property->bedrooms }} BHK
                    </button>
                    @endif
                </div>
            </div>

            <!-- 1. Similar in Locality -->
            <div x-show="similarTab === 'locality'" class="grid grid-cols-1 md:grid-cols-3 gap-8">
                @forelse($similarInLocality as $item)
                    <x-property-card :property="$item" />
                @empty
                    @foreach($relatedProperties as $item)
                        <x-property-card :property="$item" />
                    @endforeach
                @endforelse
            </div>

            <!-- 2. Similar in Price Bracket -->
            <div x-show="similarTab === 'price'" class="grid grid-cols-1 md:grid-cols-3 gap-8" x-cloak>
                @forelse($similarInPriceBracket as $item)
                    <x-property-card :property="$item" />
                @empty
                    @foreach($relatedProperties as $item)
                        <x-property-card :property="$item" />
                    @endforeach
                @endforelse
            </div>

            <!-- 3. Similar in BHK -->
            @if($property->bedrooms)
            <div x-show="similarTab === 'bhk'" class="grid grid-cols-1 md:grid-cols-3 gap-8" x-cloak>
                @forelse($similarInBhk as $item)
                    <x-property-card :property="$item" />
                @empty
                    @foreach($relatedProperties as $item)
                        <x-property-card :property="$item" />
                    @endforeach
                @endforelse
            </div>
            @endif
        </div>

        <!-- Recently Viewed Properties (Task 41) -->
        @if(isset($recentlyViewedProperties) && $recentlyViewedProperties->isNotEmpty())
        <div class="mt-16 pt-10 border-t border-slate-200">
            <div class="flex items-center justify-between mb-8">
                <div>
                    <div class="inline-flex items-center gap-1.5 text-emerald-700 font-bold text-xs uppercase tracking-wider mb-1">
                        <span class="material-symbols-outlined text-[16px]">history</span>
                        Browsing History
                    </div>
                    <h3 class="text-2xl font-black text-slate-900 tracking-tight">Recently Viewed Properties</h3>
                    <p class="text-xs text-slate-500 mt-0.5">Quickly compare other verified homes you inspected earlier</p>
                </div>
                <form action="{{ route('recently-viewed.clear') }}" method="POST">
                    @csrf
                    <button type="submit" class="px-3.5 py-1.5 rounded-full border border-slate-200 hover:border-slate-300 bg-white text-slate-600 hover:text-slate-900 text-xs font-bold transition flex items-center gap-1 cursor-pointer">
                        <span class="material-symbols-outlined text-sm text-slate-400">delete_sweep</span>
                        <span>Clear History</span>
                    </button>
                </form>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                @foreach($recentlyViewedProperties->take(3) as $recentProp)
                    <x-property-card :property="$recentProp" />
                @endforeach
            </div>
        </div>
        @endif

        <!-- Contextual Internal Linking Hub (Task 24 & 33) -->
        <div class="mt-16 pt-10 border-t border-slate-200">
            <h3 class="text-lg font-black text-slate-900 mb-2">Explore More Verified Homes &amp; Guides</h3>
            <p class="text-xs font-semibold text-slate-500 mb-6">Browse curated micro-market pages, metro connectivity hubs, and tenant guides.</p>

            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4">
                <a href="/rent/flats/sector-137-noida" class="p-4 rounded-2xl bg-white hover:bg-emerald-50 border border-slate-200 hover:border-emerald-300 transition group flex flex-col justify-between">
                    <div>
                        <span class="text-xs font-bold text-slate-900 group-hover:text-emerald-900 block">Flats in Sector 137</span>
                        <span class="text-[11px] text-slate-500 font-medium">Paras Tierea &amp; Express corridor</span>
                    </div>
                    <div class="mt-3 flex items-center text-[11px] font-bold text-emerald-700">
                        <span>Explore sector</span>
                        <span class="material-symbols-outlined text-xs ml-1">arrow_forward</span>
                    </div>
                </a>

                <a href="/explore/flats-near-metro-in-noida" class="p-4 rounded-2xl bg-white hover:bg-emerald-50 border border-slate-200 hover:border-emerald-300 transition group flex flex-col justify-between">
                    <div>
                        <span class="text-xs font-bold text-slate-900 group-hover:text-emerald-900 block">Properties Near Metro</span>
                        <span class="text-[11px] text-slate-500 font-medium">Within 500m of Aqua &amp; Blue Line</span>
                    </div>
                    <div class="mt-3 flex items-center text-[11px] font-bold text-emerald-700">
                        <span>View metro homes</span>
                        <span class="material-symbols-outlined text-xs ml-1">arrow_forward</span>
                    </div>
                </a>

                <a href="/guides/noida-rental-guide" class="p-4 rounded-2xl bg-white hover:bg-emerald-50 border border-slate-200 hover:border-emerald-300 transition group flex flex-col justify-between">
                    <div>
                        <span class="text-xs font-bold text-slate-900 group-hover:text-emerald-900 block">Noida Rental Guide</span>
                        <span class="text-[11px] text-slate-500 font-medium">Best sectors &amp; rent price trends</span>
                    </div>
                    <div class="mt-3 flex items-center text-[11px] font-bold text-emerald-700">
                        <span>Read guide</span>
                        <span class="material-symbols-outlined text-xs ml-1">arrow_forward</span>
                    </div>
                </a>

                <a href="/guides/how-to-avoid-rental-scams" class="p-4 rounded-2xl bg-white hover:bg-emerald-50 border border-slate-200 hover:border-emerald-300 transition group flex flex-col justify-between">
                    <div>
                        <span class="text-xs font-bold text-slate-900 group-hover:text-emerald-900 block">Avoid Rental Scams</span>
                        <span class="text-[11px] text-slate-500 font-medium">How to spot fake broker traps</span>
                    </div>
                    <div class="mt-3 flex items-center text-[11px] font-bold text-emerald-700">
                        <span>Safety tips</span>
                        <span class="material-symbols-outlined text-xs ml-1">arrow_forward</span>
                    </div>
                </a>
            </div>
        </div>

    </div>

    <!-- ═══════════════════════════════════════════════════════════════════ -->
    <!-- FLOATING BOTTOM-RIGHT QUICK CONTACT BUTTONS (MATCHING SCREENSHOTS) -->
    <!-- ═══════════════════════════════════════════════════════════════════ -->
    <div class="fixed bottom-6 right-6 z-40 flex flex-col gap-3">
        <!-- Floating WhatsApp Button -->
        <a href="{{ $property->whatsapp_url }}" 
           target="_blank" 
           rel="noopener noreferrer" 
           class="h-12 w-12 rounded-full bg-[#25D366] hover:bg-[#20bd5a] text-white flex items-center justify-center shadow-lg transition transform hover:scale-110" 
           title="WhatsApp Chat">
            <svg class="w-6 h-6 fill-current" viewBox="0 0 24 24">
                <path d="M19.05 4.91A9.816 9.816 0 0 0 12.04 2c-5.46 0-9.91 4.45-9.91 9.91 0 1.75.46 3.45 1.32 4.95L2.05 22l5.25-1.38c1.45.79 3.08 1.21 4.74 1.21 5.46 0 9.91-4.45 9.91-9.91 0-2.65-1.03-5.14-2.9-7.01zm-7.01 15.24c-1.48 0-2.93-.4-4.2-1.15l-.3-.18-3.12.82.83-3.04-.2-.31a8.19 8.19 0 0 1-1.26-4.38c0-4.54 3.7-8.24 8.25-8.24 2.2 0 4.27.86 5.82 2.42a8.18 8.18 0 0 1 2.41 5.83c.02 4.54-3.68 8.23-8.23 8.23zm4.52-6.16c-.25-.12-1.47-.72-1.69-.81-.23-.08-.39-.12-.56.12-.17.25-.64.81-.78.98-.14.17-.29.19-.54.06-.25-.12-1.05-.39-2-1.23-.74-.66-1.23-1.47-1.38-1.72-.14-.25-.02-.38.11-.51.11-.11.25-.29.37-.43.12-.14.17-.25.25-.41.08-.17.04-.31-.02-.43s-.56-1.34-.76-1.84c-.2-.48-.41-.42-.56-.43h-.48c-.17 0-.43.06-.66.31-.22.25-.86.84-.86 2.06 0 1.21.89 2.39 1.01 2.56.12.17 1.75 2.67 4.23 3.74.59.26 1.05.41 1.41.52.59.19 1.13.16 1.56.1.48-.07 1.47-.6 1.67-1.18.21-.58.21-1.07.14-1.18-.06-.12-.22-.19-.47-.32z"/>
            </svg>
        </a>

        <!-- Floating Phone Call Button -->
        @if ($property->owner && $property->owner->phone)
            <a href="tel:{{ $property->owner->phone }}" 
               class="h-12 w-12 rounded-full bg-[#0b5e3f] hover:bg-[#084830] text-white flex items-center justify-center shadow-lg transition transform hover:scale-110" 
               title="Call Now">
                <span class="material-symbols-outlined text-2xl">call</span>
            </a>
        @endif
    </div>

    <!-- ═══════════════════════════════════════════════════════════════════ -->
    <!-- MODAL 1: PHOTO LIGHTBOX -->
    <!-- ═══════════════════════════════════════════════════════════════════ -->
    <div x-show="isModalOpen" x-cloak class="fixed inset-0 z-[100] bg-black/95 backdrop-blur-md flex flex-col justify-between p-4 sm:p-8" x-transition:enter="transition ease-out duration-300" x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100" x-transition:leave="transition ease-in duration-200" x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0">
        <div class="flex items-center justify-between text-white z-10">
            <div class="flex items-center gap-3">
                <span class="text-xs font-bold px-3 py-1 rounded-full bg-white/20 backdrop-blur-md">
                    <span x-text="activeModalImage + 1"></span> / <span x-text="images.length"></span>
                </span>
                <span class="text-sm font-semibold text-white/80 hidden sm:inline">{{ $property->title }}</span>
            </div>
            <button type="button" @click="closeModal()" class="h-10 w-10 rounded-full bg-white/10 hover:bg-white/20 text-white flex items-center justify-center transition cursor-pointer">
                <span class="material-symbols-outlined text-2xl">close</span>
            </button>
        </div>

        <div class="relative flex-1 flex items-center justify-center my-4 overflow-hidden">
            <img :src="images[activeModalImage]" alt="Full preview" class="max-h-full max-w-full object-contain rounded-2xl shadow-2xl transition-all duration-300">

            <button x-show="images.length > 1" type="button" @click="prevImage()" class="absolute left-2 sm:left-6 h-12 w-12 rounded-full bg-white/20 hover:bg-white/30 text-white flex items-center justify-center backdrop-blur-md transition transform hover:scale-110 cursor-pointer">
                <span class="material-symbols-outlined text-2xl">chevron_left</span>
            </button>
            <button x-show="images.length > 1" type="button" @click="nextImage()" class="absolute right-2 sm:right-6 h-12 w-12 rounded-full bg-white/20 hover:bg-white/30 text-white flex items-center justify-center backdrop-blur-md transition transform hover:scale-110 cursor-pointer">
                <span class="material-symbols-outlined text-2xl">chevron_right</span>
            </button>
        </div>

        <div x-show="images.length > 1" class="flex justify-center gap-2 overflow-x-auto py-2 z-10 max-w-2xl mx-auto">
            <template x-for="(img, idx) in images" :key="idx">
                <button type="button" @click="activeModalImage = idx" :class="activeModalImage === idx ? 'ring-2 ring-emerald-400 opacity-100 scale-105' : 'opacity-50 hover:opacity-80'" class="h-14 w-20 rounded-lg overflow-hidden flex-shrink-0 transition-all duration-200">
                    <img :src="img" alt="thumb" class="w-full h-full object-cover">
                </button>
            </template>
        </div>
    </div>

    <!-- ═══════════════════════════════════════════════════════════════════ -->
    <!-- MODAL 2: SCHEDULE VISIT MODAL (TASK 30) -->
    <!-- ═══════════════════════════════════════════════════════════════════ -->
    <div x-show="isScheduleModalOpen" x-cloak class="fixed inset-0 z-[120] bg-black/60 backdrop-blur-xs flex items-center justify-center p-4" x-transition:enter="transition ease-out duration-200" x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100" x-transition:leave="transition ease-in duration-150" x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0">
        <div @click.away="isScheduleModalOpen = false" class="bg-white rounded-3xl max-w-lg w-full p-6 sm:p-8 shadow-2xl border border-slate-200 relative max-h-[90vh] overflow-y-auto">
            <button type="button" @click="isScheduleModalOpen = false" class="absolute top-5 right-5 h-9 w-9 rounded-full bg-slate-100 hover:bg-slate-200 text-slate-700 flex items-center justify-center transition cursor-pointer">
                <span class="material-symbols-outlined text-lg">close</span>
            </button>

            <template x-if="scheduleSuccess">
                <div class="py-6 text-center space-y-4">
                    <div class="h-16 w-16 bg-emerald-50 border border-emerald-200 text-emerald-600 rounded-full flex items-center justify-center mx-auto shadow-xs">
                        <span class="material-symbols-outlined text-3xl">task_alt</span>
                    </div>
                    <div class="space-y-1">
                        <h3 class="text-xl font-black text-slate-900 tracking-tight">Visit Request Confirmed!</h3>
                        <p class="text-xs text-slate-600 max-w-sm mx-auto leading-relaxed">
                            The landlord has been notified of your requested visit on <strong class="text-slate-900" x-text="scheduleDate"></strong> at <strong class="text-slate-900" x-text="scheduleTime"></strong>. Exact unit directions sent to your phone.
                        </p>
                    </div>
                    <button type="button" @click="isScheduleModalOpen = false" class="px-6 py-2.5 rounded-full bg-[#0b5e3f] text-white font-bold text-xs shadow-xs transition cursor-pointer">
                        Done
                    </button>
                </div>
            </template>

            <template x-if="!scheduleSuccess">
                <form @submit.prevent="submitScheduleVisit()" class="space-y-5">
                    <div class="flex items-center gap-3">
                        <div class="h-11 w-11 rounded-2xl bg-emerald-50 text-emerald-600 border border-emerald-200 flex items-center justify-center shrink-0">
                            <span class="material-symbols-outlined text-2xl">calendar_month</span>
                        </div>
                        <div>
                            <h3 class="text-xl font-black text-slate-900 tracking-tight">Schedule a Free Visit</h3>
                            <p class="text-xs text-slate-500">Inspect in person with 0% brokerage</p>
                        </div>
                    </div>

                    <div class="p-3.5 rounded-2xl bg-slate-50 border border-slate-100 text-xs">
                        <span class="font-bold text-slate-900 block truncate">{{ $property->title }}</span>
                        <span class="text-slate-500 block text-[11px] mt-0.5">{{ $addr }}</span>
                    </div>

                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-3 text-xs">
                        <div>
                            <label class="block text-[11px] font-bold uppercase tracking-wider text-slate-500 mb-1">Preferred Date *</label>
                            <input type="date" x-model="scheduleDate" min="{{ date('Y-m-d') }}" required class="w-full rounded-xl border border-slate-200 p-2.5 text-xs font-bold text-slate-800 focus:outline-none focus:border-emerald-500">
                        </div>
                        <div>
                            <label class="block text-[11px] font-bold uppercase tracking-wider text-slate-500 mb-1">Time Slot *</label>
                            <select x-model="scheduleTime" class="w-full rounded-xl border border-slate-200 p-2.5 text-xs font-bold text-slate-800 focus:outline-none focus:border-emerald-500">
                                <option value="10:00 AM">10:00 AM (Morning)</option>
                                <option value="12:00 PM">12:00 PM (Noon)</option>
                                <option value="03:00 PM">03:00 PM (Afternoon)</option>
                                <option value="05:00 PM">05:00 PM (Evening)</option>
                                <option value="07:00 PM">07:00 PM (Late Evening)</option>
                            </select>
                        </div>
                    </div>

                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-3 text-xs">
                        <div>
                            <label class="block text-[11px] font-bold uppercase tracking-wider text-slate-500 mb-1">Your Name *</label>
                            <input type="text" x-model="visitorName" placeholder="Full Name" required class="w-full rounded-xl border border-slate-200 p-2.5 text-xs font-bold text-slate-800 focus:outline-none focus:border-emerald-500">
                        </div>
                        <div>
                            <label class="block text-[11px] font-bold uppercase tracking-wider text-slate-500 mb-1">Phone Number *</label>
                            <input type="tel" x-model="visitorPhone" placeholder="Mobile Number" required class="w-full rounded-xl border border-slate-200 p-2.5 text-xs font-bold text-slate-800 focus:outline-none focus:border-emerald-500">
                        </div>
                    </div>

                    <div class="pt-3 border-t border-slate-100 flex items-center justify-end gap-3">
                        <button type="button" @click="isScheduleModalOpen = false" class="px-4 py-2 rounded-full border border-slate-200 text-slate-600 font-bold text-xs hover:bg-slate-50 transition cursor-pointer">
                            Cancel
                        </button>
                        <button type="submit" :disabled="scheduleSubmitting" class="px-5 py-2.5 rounded-full bg-[#0b5e3f] hover:bg-[#084830] text-white font-bold text-xs shadow-xs transition flex items-center gap-1.5 cursor-pointer">
                            <span class="material-symbols-outlined text-base">check</span>
                            <span x-text="scheduleSubmitting ? 'Confirming...' : 'Confirm Visit Schedule'"></span>
                        </button>
                    </div>
                </form>
            </template>
        </div>
    </div>

    <!-- ═══════════════════════════════════════════════════════════════════ -->
    <!-- MODAL 3: WHAT DOES VERIFIED MEAN? -->
    <!-- ═══════════════════════════════════════════════════════════════════ -->
    <div x-show="isVerifyModalOpen" x-cloak class="fixed inset-0 z-[120] bg-black/60 backdrop-blur-xs flex items-center justify-center p-4" x-transition:enter="transition ease-out duration-200" x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100" x-transition:leave="transition ease-in duration-150" x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0">
        <div @click.away="isVerifyModalOpen = false" class="bg-white rounded-3xl max-w-xl w-full p-6 sm:p-8 shadow-2xl border border-slate-200 relative max-h-[90vh] overflow-y-auto">
            <button type="button" @click="isVerifyModalOpen = false" class="absolute top-5 right-5 h-9 w-9 rounded-full bg-slate-100 hover:bg-slate-200 text-slate-700 flex items-center justify-center transition cursor-pointer">
                <span class="material-symbols-outlined text-lg">close</span>
            </button>

            <div class="flex items-center gap-3 mb-4">
                <div class="h-11 w-11 rounded-2xl bg-emerald-50 text-emerald-600 border border-emerald-200 flex items-center justify-center shrink-0">
                    <span class="material-symbols-outlined text-2xl">verified</span>
                </div>
                <div>
                    <h3 class="text-xl font-black text-slate-900 tracking-tight">What does Verified mean?</h3>
                    <p class="text-xs text-slate-500">HomiQ Quality &amp; Verification Standards</p>
                </div>
            </div>

            <div class="space-y-4 text-xs sm:text-sm text-slate-600 leading-relaxed border-t border-slate-100 pt-4">
                <p>
                    A <strong class="text-slate-900">Verified Listing</strong> on HomiQ has passed our multi-step audit process to ensure high marketplace quality and eliminate phantom or fake inventory.
                </p>

                <div class="p-4 rounded-2xl bg-slate-50 border border-slate-100 space-y-2.5">
                    <span class="text-xs font-bold uppercase tracking-wider text-slate-900 block">What our inspectors verify:</span>
                    
                    <div class="flex items-start gap-2 text-xs">
                        <span class="material-symbols-outlined text-emerald-600 text-base shrink-0 mt-0.5">check_circle</span>
                        <span><strong>Government ID Validation:</strong> Landlord/agent identity and phone verification via OTP and ID records.</span>
                    </div>
                    <div class="flex items-start gap-2 text-xs">
                        <span class="material-symbols-outlined text-emerald-600 text-base shrink-0 mt-0.5">check_circle</span>
                        <span><strong>On-Site Photo Matching:</strong> Real room photographs and layout matching physical inspection.</span>
                    </div>
                    <div class="flex items-start gap-2 text-xs">
                        <span class="material-symbols-outlined text-emerald-600 text-base shrink-0 mt-0.5">check_circle</span>
                        <span><strong>Location Cross-Check:</strong> Exact GPS geotagging, building address, and nearest metro proximity.</span>
                    </div>
                    <div class="flex items-start gap-2 text-xs">
                        <span class="material-symbols-outlined text-emerald-600 text-base shrink-0 mt-0.5">check_circle</span>
                        <span><strong>30-Day Freshness Cycle:</strong> Regular re-verification to ensure the unit is genuinely vacant and available.</span>
                    </div>
                </div>

                <div class="p-4 rounded-2xl bg-amber-50/80 border border-amber-200 text-amber-900 text-xs leading-relaxed space-y-1">
                    <strong class="font-bold flex items-center gap-1 text-amber-950">
                        <span class="material-symbols-outlined text-sm text-amber-600">info</span>
                        Important Notice &amp; Limitations
                    </strong>
                    <p class="text-[11px] text-amber-800">
                        This listing has passed HomiQ's verification process. Verification does not guarantee transaction safety, pricing accuracy beyond the inspection date, or legal ownership beyond the documents reviewed. Always inspect the property in person and verify lease terms before signing or transferring funds.
                    </p>
                </div>
            </div>

            <div class="mt-6 pt-4 border-t border-slate-100 flex items-center justify-end">
                <button type="button" @click="isVerifyModalOpen = false" class="px-5 py-2.5 rounded-full bg-[#0b5e3f] hover:bg-[#084830] text-white font-bold text-xs shadow-xs transition cursor-pointer">
                    Got it, thanks
                </button>
            </div>
        </div>
    </div>

    <!-- ═══════════════════════════════════════════════════════════════════ -->
    <!-- MODAL 4: REPORT LISTING MODAL -->
    <!-- ═══════════════════════════════════════════════════════════════════ -->
    <div x-show="isReportModalOpen" x-cloak class="fixed inset-0 z-[120] bg-black/60 backdrop-blur-xs flex items-center justify-center p-4" x-transition:enter="transition ease-out duration-200" x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100" x-transition:leave="transition ease-in duration-150" x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0">
        <div @click.away="isReportModalOpen = false" class="bg-white rounded-3xl max-w-lg w-full p-6 sm:p-8 shadow-2xl border border-slate-200 relative max-h-[90vh] overflow-y-auto">
            <button type="button" @click="isReportModalOpen = false" class="absolute top-5 right-5 h-9 w-9 rounded-full bg-slate-100 hover:bg-slate-200 text-slate-700 flex items-center justify-center transition cursor-pointer">
                <span class="material-symbols-outlined text-lg">close</span>
            </button>

            <template x-if="reportSuccess">
                <div class="py-6 text-center space-y-4">
                    <div class="h-16 w-16 bg-emerald-50 border border-emerald-200 text-emerald-600 rounded-full flex items-center justify-center mx-auto shadow-xs">
                        <span class="material-symbols-outlined text-3xl">task_alt</span>
                    </div>
                    <div class="space-y-1">
                        <h3 class="text-xl font-black text-slate-900 tracking-tight">Report Received</h3>
                        <p class="text-xs text-slate-500 max-w-sm mx-auto leading-relaxed">
                            Thank you for helping keep HomiQ transparent and reliable. Our Trust &amp; Safety team will inspect this listing within 4 hours.
                        </p>
                    </div>
                    <button type="button" @click="isReportModalOpen = false" class="px-6 py-2.5 rounded-full bg-[#0b5e3f] text-white font-bold text-xs shadow-xs transition cursor-pointer">
                        Close
                    </button>
                </div>
            </template>

            <template x-if="!reportSuccess">
                <form @submit.prevent="submitReport()" class="space-y-5">
                    <div class="flex items-center gap-3">
                        <div class="h-11 w-11 rounded-2xl bg-rose-50 text-rose-600 border border-rose-200 flex items-center justify-center shrink-0">
                            <span class="material-symbols-outlined text-2xl">flag</span>
                        </div>
                        <div>
                            <h3 class="text-xl font-black text-slate-900 tracking-tight">Report This Listing</h3>
                            <p class="text-xs text-slate-500">Help our team maintain marketplace integrity</p>
                        </div>
                    </div>

                    <div x-show="reportError" class="p-3 rounded-xl bg-rose-50 border border-rose-200 text-rose-700 text-xs font-semibold" x-text="reportError"></div>

                    <div class="space-y-1.5">
                        <label class="block text-[11px] font-bold uppercase tracking-wider text-slate-500">
                            What is the issue? <span class="text-rose-500">*</span>
                        </label>
                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-2 text-xs">
                            <label class="p-2.5 rounded-xl border cursor-pointer transition flex items-center gap-2" :class="reportReason === 'fake_property' ? 'bg-rose-50/50 border-rose-400 text-rose-900 font-bold' : 'border-slate-200 text-slate-700 hover:bg-slate-50'">
                                <input type="radio" x-model="reportReason" value="fake_property" class="text-rose-600 focus:ring-0">
                                <span>Fake property / Scam</span>
                            </label>

                            <label class="p-2.5 rounded-xl border cursor-pointer transition flex items-center gap-2" :class="reportReason === 'incorrect_price' ? 'bg-rose-50/50 border-rose-400 text-rose-900 font-bold' : 'border-slate-200 text-slate-700 hover:bg-slate-50'">
                                <input type="radio" x-model="reportReason" value="incorrect_price" class="text-rose-600 focus:ring-0">
                                <span>Incorrect price</span>
                            </label>

                            <label class="p-2.5 rounded-xl border cursor-pointer transition flex items-center gap-2" :class="reportReason === 'wrong_location' ? 'bg-rose-50/50 border-rose-400 text-rose-900 font-bold' : 'border-slate-200 text-slate-700 hover:bg-slate-50'">
                                <input type="radio" x-model="reportReason" value="wrong_location" class="text-rose-600 focus:ring-0">
                                <span>Wrong location</span>
                            </label>

                            <label class="p-2.5 rounded-xl border cursor-pointer transition flex items-center gap-2" :class="reportReason === 'duplicate_listing' ? 'bg-rose-50/50 border-rose-400 text-rose-900 font-bold' : 'border-slate-200 text-slate-700 hover:bg-slate-50'">
                                <input type="radio" x-model="reportReason" value="duplicate_listing" class="text-rose-600 focus:ring-0">
                                <span>Duplicate listing</span>
                            </label>

                            <label class="p-2.5 rounded-xl border cursor-pointer transition flex items-center gap-2" :class="reportReason === 'misleading_photos' ? 'bg-rose-50/50 border-rose-400 text-rose-900 font-bold' : 'border-slate-200 text-slate-700 hover:bg-slate-50'">
                                <input type="radio" x-model="reportReason" value="misleading_photos" class="text-rose-600 focus:ring-0">
                                <span>Misleading photos</span>
                            </label>

                            <label class="p-2.5 rounded-xl border cursor-pointer transition flex items-center gap-2" :class="reportReason === 'owner_not_responding' ? 'bg-rose-50/50 border-rose-400 text-rose-900 font-bold' : 'border-slate-200 text-slate-700 hover:bg-slate-50'">
                                <input type="radio" x-model="reportReason" value="owner_not_responding" class="text-rose-600 focus:ring-0">
                                <span>Owner not responding</span>
                            </label>

                            <label class="p-2.5 rounded-xl border cursor-pointer transition flex items-center gap-2" :class="reportReason === 'already_rented_sold' ? 'bg-rose-50/50 border-rose-400 text-rose-900 font-bold' : 'border-slate-200 text-slate-700 hover:bg-slate-50'">
                                <input type="radio" x-model="reportReason" value="already_rented_sold" class="text-rose-600 focus:ring-0">
                                <span>Already rented / sold</span>
                            </label>

                            <label class="p-2.5 rounded-xl border cursor-pointer transition flex items-center gap-2" :class="reportReason === 'suspicious_activity' ? 'bg-rose-50/50 border-rose-400 text-rose-900 font-bold' : 'border-slate-200 text-slate-700 hover:bg-slate-50'">
                                <input type="radio" x-model="reportReason" value="suspicious_activity" class="text-rose-600 focus:ring-0">
                                <span>Suspicious activity</span>
                            </label>
                        </div>
                    </div>

                    <div class="space-y-1.5">
                        <label class="block text-[11px] font-bold uppercase tracking-wider text-slate-500">
                            Additional Details (Optional)
                        </label>
                        <textarea x-model="reportDetails" rows="3" placeholder="Provide any details to help our inspection team..." class="w-full text-xs rounded-2xl border border-slate-200 p-3 focus:outline-none focus:border-rose-400"></textarea>
                    </div>

                    @guest
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-3 text-xs">
                        <div>
                            <label class="block text-[10px] font-bold uppercase tracking-wider text-slate-400 mb-1">Your Name</label>
                            <input type="text" x-model="reporterName" placeholder="Optional name" class="w-full rounded-xl border border-slate-200 p-2.5 text-xs focus:outline-none focus:border-rose-400">
                        </div>
                        <div>
                            <label class="block text-[10px] font-bold uppercase tracking-wider text-slate-400 mb-1">Your Email / Phone</label>
                            <input type="text" x-model="reporterContact" placeholder="For investigation updates" class="w-full rounded-xl border border-slate-200 p-2.5 text-xs focus:outline-none focus:border-rose-400">
                        </div>
                    </div>
                    @endguest

                    <div class="pt-3 border-t border-slate-100 flex items-center justify-end gap-3">
                        <button type="button" @click="isReportModalOpen = false" class="px-4 py-2 rounded-full border border-slate-200 text-slate-600 font-bold text-xs hover:bg-slate-50 transition cursor-pointer">
                            Cancel
                        </button>
                        <button type="submit" :disabled="reportSubmitting" class="px-5 py-2.5 rounded-full bg-rose-600 hover:bg-rose-700 text-white font-bold text-xs shadow-xs transition flex items-center gap-1.5 cursor-pointer">
                            <span class="material-symbols-outlined text-base">send</span>
                            <span x-text="reportSubmitting ? 'Submitting...' : 'Submit Report'"></span>
                        </button>
                    </div>
                </form>
            </template>
        </div>
    </div>

    <!-- Mobile Sticky Conversion CTA Bar (Task 45) -->
    <div class="md:hidden fixed bottom-0 left-0 right-0 z-40 bg-white/95 backdrop-blur-xl border-t border-slate-200 px-4 py-3 shadow-[0_-10px_30px_rgba(0,0,0,0.12)] flex items-center justify-between gap-2.5">
        <div class="min-w-0">
            <div class="text-base font-black text-slate-900 leading-tight truncate">
                {{ $property->formatted_price }}
            </div>
            <div class="text-[10px] font-bold text-emerald-600 flex items-center gap-0.5">
                <span class="material-symbols-outlined text-[12px]">verified</span>
                <span>0% Brokerage · Direct Owner</span>
            </div>
        </div>

        <div class="flex items-center gap-2 shrink-0">
            <a href="{{ $property->whatsapp_url }}" 
               target="_blank" 
               rel="noopener noreferrer" 
               onclick="fetch('/properties/{{ $property->id }}/track-contact', { method: 'POST', headers: { 'Content-Type': 'application/json', 'X-CSRF-TOKEN': '{{ csrf_token() }}' }, body: JSON.stringify({ type: 'whatsapp' }) })"
               class="h-10 px-3.5 rounded-full bg-emerald-600 hover:bg-emerald-700 text-white font-bold text-xs flex items-center gap-1.5 shadow-sm active:scale-95 transition">
                <svg class="w-4.5 h-4.5 fill-current text-white shrink-0" viewBox="0 0 24 24">
                    <path d="M19.05 4.91A9.816 9.816 0 0 0 12.04 2c-5.46 0-9.91 4.45-9.91 9.91 0 1.75.46 3.45 1.32 4.95L2.05 22l5.25-1.38c1.45.79 3.08 1.21 4.74 1.21 5.46 0 9.91-4.45 9.91-9.91 0-2.65-1.03-5.14-2.9-7.01zm-7.01 15.24c-1.48 0-2.93-.4-4.2-1.15l-.3-.18-3.12.82.83-3.04-.2-.31a8.19 8.19 0 0 1-1.26-4.38c0-4.54 3.7-8.24 8.25-8.24 2.2 0 4.27.86 5.82 2.42a8.18 8.18 0 0 1 2.41 5.83c.02 4.54-3.68 8.23-8.23 8.23zm4.52-6.16c-.25-.12-1.47-.72-1.69-.81-.23-.08-.39-.12-.56.12-.17.25-.64.81-.78.98-.14.17-.29.19-.54.06-.25-.12-1.05-.39-2-1.23-.74-.66-1.23-1.47-1.38-1.72-.14-.25-.02-.38.11-.51.11-.11.25-.29.37-.43.12-.14.17-.25.25-.41.08-.17.04-.31-.02-.43s-.56-1.34-.76-1.84c-.2-.48-.41-.42-.56-.43h-.48c-.17 0-.43.06-.66.31-.22.25-.86.84-.86 2.06 0 1.21.89 2.39 1.01 2.56.12.17 1.75 2.67 4.23 3.74.59.26 1.05.41 1.41.52.59.19 1.13.16 1.56.1.48-.07 1.47-.6 1.67-1.18.21-.58.21-1.07.14-1.18-.06-.12-.22-.19-.47-.32z"/>
                </svg>
                <span>WhatsApp</span>
            </a>

            <button type="button" 
                    @click="isScheduleModalOpen = true; scheduleSuccess = false"
                    class="h-10 px-3.5 rounded-full bg-[#0b5e3f] hover:bg-[#084830] text-white font-bold text-xs flex items-center gap-1.5 shadow-sm active:scale-95 transition">
                <span class="material-symbols-outlined text-[16px] text-emerald-400">calendar_month</span>
                <span>Visit / Contact</span>
            </button>

            <button type="button" 
                    @click="openInApp()"
                    class="h-10 w-10 rounded-full border border-slate-200 bg-slate-100 hover:bg-slate-200 text-slate-700 flex items-center justify-center shadow-xs active:scale-95 transition"
                    title="Open in App">
                <span class="material-symbols-outlined text-[18px]">smartphone</span>
            </button>
        </div>
    </div>

</div>

<!-- Analytics: Track Property Viewed (Task 46 & 47) -->
<script>
    document.addEventListener('DOMContentLoaded', () => {
        if (typeof window.homiqTrack === 'function') {
            window.homiqTrack('property_viewed', {
                property_id: {{ $property->id }},
                price: {{ $property->price }},
                city: '{{ addslashes($property->city ?? '') }}',
                category: '{{ addslashes($property->category ?? '') }}',
                bedrooms: '{{ $property->bedrooms }}'
            }, 'seeker', 'property_view');
        }
    });
</script>
@endsection
