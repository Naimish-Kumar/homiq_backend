@props(['property'])

<a href="/properties/{{ $property->id }}" class="group block bg-white rounded-3xl border border-slate-100 shadow-[0_4px_20px_-8px_rgba(0,0,0,0.08)] hover:shadow-[0_20px_40px_-12px_rgba(26,68,124,0.15)] hover:border-slate-200 transition-all duration-300 overflow-hidden transform hover:-translate-y-1 h-full flex flex-col">
    <!-- Image Container -->
    <div class="relative h-60 overflow-hidden flex-shrink-0">
        <img src="{{ !empty($property->images) && is_array($property->images) ? $property->images[0] : 'https://images.unsplash.com/photo-1564013799919-ab600027ffc6?auto=format&fit=crop&w=600&q=80' }}" alt="{{ $property->title }}" class="w-full h-full object-cover transition-transform duration-700 group-hover:scale-110">
        <div class="absolute inset-0 bg-gradient-to-t from-slate-900/80 via-slate-900/20 to-transparent opacity-80 group-hover:opacity-100 transition-opacity duration-300"></div>
        
        <div class="absolute top-4 left-4 flex gap-2">
            <span class="px-3 py-1 bg-white/95 backdrop-blur-sm text-slate-800 text-[10px] font-extrabold uppercase tracking-wider rounded-lg shadow-sm">
                {{ $property->category }}
            </span>
            <span class="px-3 py-1 bg-amber-500 text-white text-[10px] font-extrabold uppercase tracking-wider rounded-lg shadow-sm">
                For {{ ucfirst($property->listing_type) }}
            </span>
            @if($property->is_featured)
            <span class="px-3 py-1 bg-gradient-to-r from-amber-500 to-orange-500 text-white text-[10px] font-extrabold uppercase tracking-wider rounded-lg shadow-sm flex items-center gap-1">
                ★ Featured
            </span>
            @endif
        </div>

        @if($property->owner)
        <div class="absolute top-4 right-4 h-8 w-8 rounded-full overflow-hidden border-2 border-white bg-slate-100 shadow-md z-10" title="Listed by {{ $property->owner->name }}">
            <img src="https://ui-avatars.com/api/?name={{ urlencode($property->owner->name) }}&background=1A447C&color=fff" alt="owner" class="h-full w-full object-cover">
        </div>
        @endif
        
        <div class="absolute bottom-5 left-5 right-5">
            <span class="text-white font-extrabold text-2xl shadow-sm tracking-tight">{{ $property->currency_symbol }}{{ number_format($property->price, 0) }}<span class="text-[10px] font-bold text-white/80 ml-1 uppercase tracking-wider">{{ $property->price_unit ? $property->price_unit : ($property->listing_type === 'rent' ? $property->billing_frequency_suffix : '') }}</span></span>
        </div>
    </div>
    
    <!-- Content Container -->
    <div class="p-6 flex-1 flex flex-col justify-between">
        <div>
            <h3 class="font-extrabold text-slate-800 text-lg mb-1.5 line-clamp-1 group-hover:text-steelAzure transition-colors">{{ $property->title }}</h3>
            <p class="text-xs text-slate-500 flex items-center gap-1.5 mb-5 truncate font-medium">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-slate-400 flex-shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" /><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" /></svg>
                {{ $property->address }}
            </p>
        </div>
        
        <div class="flex items-center gap-3 text-xs font-bold text-slate-600 border-t border-slate-50 pt-5">
            @php
                $relCat = strtolower($property->category);
                $relIsLand = str_contains($relCat, 'land') || str_contains($relCat, 'plot');
            @endphp
            
            @if($relIsLand)
                <div class="flex-1 flex items-center justify-center gap-2 bg-slate-50/80 hover:bg-slate-100 py-2.5 rounded-xl transition-colors">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-steelAzure" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 8V4m0 0h4M4 4l5 5m11-1V4m0 0h-4m4 0l-5 5M4 16v4m0 0h4m-4 0l5-5m11 5l-5-5m5 5v-4m0 4h-4" /></svg>
                    {{ $property->plot_area ?? $property->built_up_area ?? 'N/A' }} sqft
                </div>
            @else
                <div class="flex-1 flex items-center justify-center gap-2 bg-slate-50/80 hover:bg-slate-100 py-2.5 rounded-xl transition-colors">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-steelAzure" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6" /></svg>
                    {{ $property->bedrooms }} Beds
                </div>
                <div class="flex-1 flex items-center justify-center gap-2 bg-slate-50/80 hover:bg-slate-100 py-2.5 rounded-xl transition-colors">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-seaGreen" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 14v3m4-3v3m4-3v3M3 21h18M3 10h18M3 7l9-4 9 4M4 10h16v11H4V10z" /></svg>
                    {{ $property->bathrooms }} Baths
                </div>
            @endif
        </div>
    </div>
</a>
