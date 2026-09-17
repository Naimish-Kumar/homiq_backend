@extends('layouts.app')

@section('title', 'Real Estate Guides, Rental Tips & Noida Market Insights | HomiQ')
@section('meta_description', 'Expert guides on renting, buying, PG accommodation, UP tenancy laws, and security deposit regulations in Noida, Delhi NCR, and Bangalore.')
@section('canonical_url', url('/guides'))

@section('structured_data')
<script type="application/ld+json">
{
  "@@context": "https://schema.org",
  "@@type": "CollectionPage",
  "name": "HomiQ Real Estate & Rental Guides",
  "description": "Comprehensive advice, legal checklists, and neighborhood guides for tenants and property owners in Noida, Delhi NCR and Bangalore.",
  "url": "{{ url('/guides') }}",
  "breadcrumb": {
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
        "name": "Guides & Insights",
        "item": "{{ url('/guides') }}"
      }
    ]
  }
}
</script>
@endsection

@section('content')
<div class="bg-slate-50 min-h-screen py-10">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        
        <!-- Breadcrumbs -->
        <nav class="flex mb-6 text-sm text-slate-500" aria-label="Breadcrumb">
            <ol class="inline-flex items-center space-x-2">
                <li>
                    <a href="{{ url('/') }}" class="hover:text-primary transition flex items-center gap-1">
                        <span class="material-symbols-outlined text-[18px]">home</span>
                        <span>Home</span>
                    </a>
                </li>
                <li>
                    <span class="text-slate-400">/</span>
                </li>
                <li class="font-medium text-slate-800">Guides & Market Insights</li>
            </ol>
        </nav>

        <!-- Hero Header -->
        <div class="bg-gradient-to-r from-slate-900 via-primary/95 to-slate-900 rounded-3xl p-8 sm:p-12 text-white mb-12 relative overflow-hidden shadow-xl">
            <div class="absolute -right-20 -bottom-20 w-96 h-96 bg-primary/20 rounded-full blur-3xl pointer-events-none"></div>
            <div class="relative z-10 max-w-3xl">
                <div class="inline-flex items-center gap-2 px-3 py-1.5 rounded-full bg-white/10 backdrop-blur border border-white/20 text-xs font-semibold text-white tracking-wide uppercase mb-4">
                    <span class="material-symbols-outlined text-sm text-emerald-400">verified</span>
                    HomiQ Knowledge Hub
                </div>
                <h1 class="text-3xl sm:text-5xl font-black tracking-tight leading-tight mb-4">
                    Real Estate &amp; Rental Guides for Delhi NCR
                </h1>
                <p class="text-slate-200 text-base sm:text-lg leading-relaxed">
                    Practical, transparent advice to help you rent, buy, and negotiate directly with verified landlords — without losing money to broker fees or phantom listings.
                </p>
            </div>
        </div>

        <!-- Guides Grid -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8 mb-16">
            @foreach($guides as $guide)
                <article class="bg-white rounded-2xl border border-slate-200 overflow-hidden hover:shadow-xl transition-all duration-300 flex flex-col group">
                    <div class="relative aspect-video overflow-hidden bg-slate-100">
                        <img src="{{ $guide['image'] }}" alt="{{ $guide['title'] }}" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500" loading="lazy">
                        <span class="absolute top-4 left-4 bg-slate-900/80 backdrop-blur text-white text-xs font-bold px-3 py-1 rounded-full">
                            {{ $guide['category'] }}
                        </span>
                        <span class="absolute bottom-4 right-4 bg-white/90 backdrop-blur text-slate-800 text-[11px] font-semibold px-2.5 py-0.5 rounded-md flex items-center gap-1 shadow-sm">
                            <span class="material-symbols-outlined text-xs">schedule</span>
                            {{ $guide['read_time'] }}
                        </span>
                    </div>

                    <div class="p-6 flex-1 flex flex-col justify-between">
                        <div>
                            <div class="text-xs text-slate-400 font-medium mb-2">{{ $guide['published_at'] }}</div>
                            <h2 class="text-lg font-bold text-slate-900 group-hover:text-primary transition line-clamp-2 leading-snug mb-2">
                                <a href="{{ url('/guides/' . $guide['slug']) }}">
                                    {{ $guide['title'] }}
                                </a>
                            </h2>
                            <p class="text-slate-600 text-sm line-clamp-3 mb-4 leading-relaxed">
                                {{ $guide['summary'] }}
                            </p>
                        </div>

                        <div class="pt-4 border-t border-slate-100 flex items-center justify-between">
                            <a href="{{ url('/guides/' . $guide['slug']) }}" class="text-sm font-bold text-primary hover:text-primary-dark inline-flex items-center gap-1 group-hover:underline">
                                Read Guide
                                <span class="material-symbols-outlined text-sm transition-transform group-hover:translate-x-1">arrow_forward</span>
                            </a>
                        </div>
                    </div>
                </article>
            @endforeach
        </div>

        <!-- Explore Verified Listings CTA Section -->
        <div class="bg-white rounded-3xl border border-slate-200 p-8 sm:p-10 mb-12 shadow-sm">
            <div class="flex flex-col md:flex-row md:items-center justify-between gap-6 mb-8">
                <div>
                    <h2 class="text-2xl font-black text-slate-900 mb-1">Featured Verified Listings</h2>
                    <p class="text-slate-600 text-sm">Browse 100% on-site verified apartments and homes in active micro-markets</p>
                </div>
                <a href="{{ url('/') }}" class="inline-flex items-center justify-center gap-2 px-6 py-3 bg-primary text-white font-bold rounded-xl hover:bg-primary-dark transition text-sm">
                    <span>Explore All Listings</span>
                    <span class="material-symbols-outlined text-base">arrow_forward</span>
                </a>
            </div>

            @if(isset($activeProperties) && $activeProperties->isNotEmpty())
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                    @foreach($activeProperties as $property)
                        <x-property-card :property="$property" />
                    @endforeach
                </div>
            @endif
        </div>

        <!-- Quick SEO Locality Hubs -->
        <div class="bg-slate-100/70 rounded-2xl p-6 sm:p-8 border border-slate-200">
            <h3 class="text-sm font-bold text-slate-900 uppercase tracking-wider mb-4 flex items-center gap-2">
                <span class="material-symbols-outlined text-primary text-base">near_me</span>
                Popular Rental & Buy Hubs in Delhi NCR
            </h3>
            <div class="flex flex-wrap gap-2 text-xs">
                <a href="{{ url('/rent/noida') }}" class="bg-white border border-slate-200 px-3 py-1.5 rounded-lg text-slate-700 hover:text-primary hover:border-primary transition font-medium">Rent in Noida</a>
                <a href="{{ url('/rent/flats/noida') }}" class="bg-white border border-slate-200 px-3 py-1.5 rounded-lg text-slate-700 hover:text-primary hover:border-primary transition font-medium">Flats for Rent in Noida</a>
                <a href="{{ url('/rent/pg/noida') }}" class="bg-white border border-slate-200 px-3 py-1.5 rounded-lg text-slate-700 hover:text-primary hover:border-primary transition font-medium">PGs & Rooms in Noida</a>
                <a href="{{ url('/rent/flats/sector-137-noida') }}" class="bg-white border border-slate-200 px-3 py-1.5 rounded-lg text-slate-700 hover:text-primary hover:border-primary transition font-medium">Sector 137 Noida Flats</a>
                <a href="{{ url('/buy/flats/noida') }}" class="bg-white border border-slate-200 px-3 py-1.5 rounded-lg text-slate-700 hover:text-primary hover:border-primary transition font-medium">Flats for Sale in Noida</a>
                <a href="{{ url('/explore/near-metro-noida') }}" class="bg-white border border-slate-200 px-3 py-1.5 rounded-lg text-slate-700 hover:text-primary hover:border-primary transition font-medium">Flats Near Metro Noida</a>
                <a href="{{ url('/explore/owner-flats-noida') }}" class="bg-white border border-slate-200 px-3 py-1.5 rounded-lg text-slate-700 hover:text-primary hover:border-primary transition font-medium">Zero Brokerage Owner Flats</a>
                <a href="{{ url('/list-property') }}" class="bg-emerald-50 border border-emerald-200 px-3 py-1.5 rounded-lg text-emerald-800 hover:bg-emerald-100 transition font-bold">List Property Free</a>
            </div>
        </div>

    </div>
</div>
@endsection
