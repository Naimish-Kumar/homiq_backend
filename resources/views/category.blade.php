@extends('layouts.app')

@section('content')
<style>
    /* Advanced Card and Icon Animations */
    .premium-card {
        position: relative;
        overflow: hidden;
        border-radius: 12px;
        border: 1px solid #f1f5f9;
        background-color: #ffffff;
        transform-style: preserve-3d;
        perspective: 1000px;
        transition: transform 0.8s cubic-bezier(0.16, 1, 0.3, 1), 
                    box-shadow 0.8s cubic-bezier(0.16, 1, 0.3, 1), 
                    border-color 0.8s cubic-bezier(0.16, 1, 0.3, 1);
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
</style>

<!-- Page Header / Breadcrumbs -->
<section class="max-w-7xl mx-auto px-6 pt-10 pb-6">
    <nav class="flex items-center gap-2 text-xs text-slate-400 font-semibold mb-6">
        <a href="/" class="hover:text-steelAzure flex items-center gap-1 transition">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-3.5 w-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6" />
            </svg>
            Home
        </a>
        <svg xmlns="http://www.w3.org/2000/svg" class="h-3 w-3 text-slate-300" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M9 5l7 7-7 7" />
        </svg>
        <span class="text-slate-300">Category</span>
        <svg xmlns="http://www.w3.org/2000/svg" class="h-3 w-3 text-slate-300" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M9 5l7 7-7 7" />
        </svg>
        <span class="text-steelAzure uppercase tracking-wider">{{ $name }}</span>
    </nav>

    <div class="border-b border-slate-100 pb-8">
        <h1 class="text-3xl md:text-4xl font-extrabold text-slate-800 tracking-tight">
            {{ $name }} Spaces
        </h1>
        <p class="text-sm text-slate-400 mt-2">Explore the finest, verified {{ strtolower($name) }}s listed in our network.</p>
    </div>
</section>


<!-- Listings Section -->
<section class="max-w-7xl mx-auto px-6 py-12">
    @if ($properties->isEmpty())
        <div class="text-center py-20 bg-white border border-slate-100 rounded-2xl">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-16 w-16 text-slate-200 mx-auto mb-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4" />
            </svg>
            <h3 class="font-extrabold text-slate-700 text-lg">No Listings Found</h3>
            <p class="text-xs text-slate-400 mt-1 max-w-sm mx-auto">There are currently no approved properties listed under the {{ $name }} category. Check back later or explore other spaces.</p>
        </div>
    @else
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-8">
            @foreach ($properties as $prop)
                <a href="/properties/{{ $prop->id }}" class="premium-card group flex flex-col h-full">
                    <!-- Image -->
                    <div class="h-52 bg-slate-100 overflow-hidden relative">
                        <img src="{{ !empty($prop->images) && is_array($prop->images) ? $prop->images[0] : 'https://images.unsplash.com/photo-1564013799919-ab600027ffc6?auto=format&fit=crop&w=800&q=80' }}" 
                             alt="space" class="h-full w-full object-cover group-hover:scale-110 transition-transform duration-750 ease-in-out">
                        <span class="absolute top-4 right-4 px-2.5 py-1 bg-white/95 backdrop-blur-sm text-[10px] font-extrabold text-steelAzure rounded-lg uppercase tracking-wide">
                            {{ $prop->category }}
                        </span>
                        
                        @if(in_array($prop->listing_type, ['rent', 'sale']))
                            <span class="absolute top-4 left-4 px-2.5 py-1 bg-amber-500 text-white text-[9px] font-black rounded-lg uppercase tracking-wider shadow-sm">
                                FOR {{ strtoupper($prop->listing_type) }}
                            </span>
                        @endif
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
                                <span class="text-base font-bold text-steelAzure">{{ $prop->currency_symbol }}{{ number_format($prop->price, 0) }}<span class="text-[10px] text-slate-400 font-normal">{{ $prop->billing_frequency_suffix }}</span></span>
                                <span class="text-xs text-slate-400 font-medium">
                                    @if($prop->listing_type === 'sale')
                                        {{ $prop->built_up_area ?? 0 }} sq ft
                                    @else
                                        {{ $prop->bedrooms }} bd • {{ $prop->bathrooms }} ba
                                    @endif
                                </span>
                            </div>
                        </div>
                    </div>
                </a>
            @endforeach
        </div>
    @endif
</section>
@endsection
