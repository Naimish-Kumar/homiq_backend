@props(['property'])

@php
    $images = (!empty($property->images) && is_array($property->images)) 
        ? $property->images 
        : ['https://images.unsplash.com/photo-1564013799919-ab600027ffc6?auto=format&fit=crop&w=800&q=80'];
    $imgCount = count($images);
    $relCat = strtolower($property->category ?? '');
    $isLandOrCommercial = str_contains($relCat, 'land') || str_contains($relCat, 'plot') || str_contains($relCat, 'shop') || str_contains($relCat, 'commercial');
    $isOwner = ($property->listed_by ?? 'owner') === 'owner';
@endphp

<div x-data="{ activeIndex: 0, total: {{ $imgCount }}, isSaved: false }" class="group bg-white rounded-3xl border border-slate-200/90 hover:border-emerald-500/60 shadow-sm hover:shadow-xl transition-all duration-300 overflow-hidden flex flex-col justify-between h-full transform hover:-translate-y-1">
    <div>
        <!-- Card Media Container -->
        <div class="relative aspect-[16/10] overflow-hidden bg-slate-100 flex-shrink-0">
            <!-- Photos -->
            @foreach($images as $index => $image)
                <img x-show="activeIndex === {{ $index }}" 
                     x-transition:enter="transition ease-out duration-300"
                     x-transition:enter-start="opacity-0 scale-100"
                     x-transition:enter-end="opacity-100 scale-100"
                     src="{{ $image }}" 
                     alt="{{ $property->title }} - Photo {{ $index + 1 }}" 
                     loading="lazy"
                     decoding="async"
                     class="absolute inset-0 w-full h-full object-cover transition-transform duration-700 ease-out group-hover:scale-105">
            @endforeach

            <!-- Subtle Top Gradient for Badge Readability -->
            <div class="absolute inset-x-0 top-0 h-16 bg-gradient-to-b from-black/40 to-transparent pointer-events-none"></div>

            <!-- Top Header Badges & Actions -->
            <div class="absolute top-3.5 left-3.5 right-3.5 flex items-center justify-between z-10 pointer-events-none">
                <div class="flex items-center gap-1.5 pointer-events-auto">
                    <!-- Listed By Badge -->
                    @if($isOwner)
                        <span class="px-2.5 py-1 rounded-full bg-emerald-600/90 backdrop-blur-md text-white text-[10px] font-extrabold uppercase tracking-wider shadow-sm flex items-center gap-1 border border-emerald-400/30">
                            <span class="material-symbols-outlined text-[13px]">verified_user</span>
                            <span>Listed by Owner</span>
                        </span>
                    @else
                        <span class="px-2.5 py-1 rounded-full bg-blue-600/90 backdrop-blur-md text-white text-[10px] font-extrabold uppercase tracking-wider shadow-sm flex items-center gap-1 border border-blue-400/30">
                            <span class="material-symbols-outlined text-[13px]">business</span>
                            <span>Verified Agent</span>
                        </span>
                    @endif

                    @if($property->has_price_drop)
                        <span class="px-2 py-1 rounded-full bg-rose-600/95 backdrop-blur-md text-white text-[10px] font-extrabold uppercase tracking-wider shadow-sm flex items-center gap-0.5 border border-rose-400/30">
                            <span class="material-symbols-outlined text-[12px]">trending_down</span>
                            <span>{{ $property->formatted_price_drop_badge }}</span>
                        </span>
                    @endif
                </div>

                <!-- Favorite Button -->
                <div class="pointer-events-auto">
                    <button type="button" 
                            @click.prevent.stop="isSaved = !isSaved; showToast(isSaved ? 'Saved to your favorites!' : 'Removed from favorites')" 
                            class="h-8 w-8 rounded-full bg-white/90 hover:bg-white backdrop-blur-md shadow-md flex items-center justify-center transition-all transform hover:scale-110 active:scale-95 cursor-pointer"
                            :title="isSaved ? 'Remove from Saved' : 'Save to Favorites'">
                        <span class="material-symbols-outlined text-[17px] transition-colors" :class="isSaved ? 'text-rose-600 fill-current' : 'text-slate-800'">favorite</span>
                    </button>
                </div>
            </div>

            <!-- In-Card Photo Navigation Controls (If > 1 photo) -->
            @if($imgCount > 1)
                <div class="absolute inset-y-0 left-0 right-0 flex items-center justify-between px-2.5 opacity-0 group-hover:opacity-100 transition-opacity duration-200 z-10 pointer-events-none">
                    <button type="button" 
                            @click.prevent.stop="activeIndex = (activeIndex === 0 ? total - 1 : activeIndex - 1)" 
                            class="pointer-events-auto h-7 w-7 rounded-full bg-black/60 hover:bg-black/90 text-white backdrop-blur-sm flex items-center justify-center transition shadow-md cursor-pointer">
                        <span class="material-symbols-outlined text-sm">chevron_left</span>
                    </button>
                    <button type="button" 
                            @click.prevent.stop="activeIndex = (activeIndex === total - 1 ? 0 : activeIndex + 1)" 
                            class="pointer-events-auto h-7 w-7 rounded-full bg-black/60 hover:bg-black/90 text-white backdrop-blur-sm flex items-center justify-center transition shadow-md cursor-pointer">
                        <span class="material-symbols-outlined text-sm">chevron_right</span>
                    </button>
                </div>

                <!-- In-Card Dot Indicators -->
                <div class="absolute bottom-3 left-0 right-0 flex justify-center gap-1 z-10 pointer-events-none">
                    <template x-for="i in total" :key="i">
                        <div class="h-1 rounded-full transition-all duration-300 shadow-xs"
                             :class="(activeIndex === (i - 1)) ? 'w-4 bg-white' : 'w-1 bg-white/60'"></div>
                    </template>
                </div>
            @endif
        </div>

        <!-- Card Content Body -->
        <div class="p-5 flex flex-col justify-between">
            <!-- Price & 0% Brokerage Header -->
            <div class="flex items-baseline justify-between gap-2 mb-2">
                <div class="flex items-baseline gap-1">
                    @if($property->has_price_drop)
                        <span class="text-xs font-bold text-slate-400 line-through mr-1">{{ $property->formatted_original_price }}</span>
                    @endif
                    <span class="font-black text-2xl text-slate-900 tracking-tight">{{ $property->formatted_price }}</span>
                    @if($property->listing_type === 'rent')
                        <span class="text-xs font-bold text-slate-500">/month</span>
                    @endif
                </div>
                @if($property->listing_type === 'rent')
                    <span class="px-2.5 py-0.5 rounded-full bg-emerald-50 text-emerald-700 text-[10px] font-extrabold uppercase tracking-wider border border-emerald-200">
                        0% Brokerage
                    </span>
                @else
                    <span class="px-2.5 py-0.5 rounded-full bg-blue-50 text-blue-700 text-[10px] font-extrabold uppercase tracking-wider border border-blue-200">
                        For Sale
                    </span>
                @endif
            </div>

            <!-- Title & Location -->
            <a href="{{ $property->seo_url }}" class="block group/link mb-3">
                <h3 class="font-extrabold text-slate-900 text-base line-clamp-1 group-hover/link:text-emerald-700 transition-colors mb-1 tracking-tight">
                    {{ $property->title }}
                </h3>
                <p class="text-xs text-slate-500 flex items-center gap-1 font-medium truncate">
                    <span class="material-symbols-outlined text-[15px] text-emerald-600 shrink-0">location_on</span>
                    <span class="truncate">{{ $property->address }}</span>
                </p>
            </a>

            <!-- Metro Distance Pill (if available) -->
            @if($property->distance_from_metro)
            <div class="mb-3">
                <span class="inline-flex items-center gap-1 text-[11px] font-bold text-indigo-700 bg-indigo-50 px-2.5 py-1 rounded-full border border-indigo-200/70 truncate max-w-full">
                    <span class="material-symbols-outlined text-[13px] shrink-0">subway</span>
                    <span class="truncate">{{ $property->distance_from_metro }}</span>
                </span>
            </div>
            @endif

            <!-- Clean Specs Bento Bar -->
            <div class="grid grid-cols-3 gap-2 p-2.5 rounded-2xl bg-slate-50 border border-slate-200 text-xs font-bold text-slate-700 mb-1">
                @if($isLandOrCommercial)
                    <div class="flex items-center justify-center gap-1">
                        <span class="material-symbols-outlined text-base text-emerald-600">square_foot</span>
                        <span class="truncate">{{ $property->plot_area ?? $property->built_up_area ?? 'N/A' }} sqft</span>
                    </div>
                    <div class="flex items-center justify-center gap-1 border-x border-slate-200">
                        <span class="material-symbols-outlined text-base text-cyan-600">apartment</span>
                        <span class="truncate">{{ $property->floor_number ? 'Floor ' . $property->floor_number : 'Ground' }}</span>
                    </div>
                    <div class="flex items-center justify-center gap-1">
                        <span class="material-symbols-outlined text-base text-amber-600">local_parking</span>
                        <span class="truncate">{{ $property->has_parking ? 'Parking' : 'Standard' }}</span>
                    </div>
                @else
                    <div class="flex items-center justify-center gap-1">
                        <span class="material-symbols-outlined text-base text-emerald-600">bed</span>
                        <span>{{ $property->bedrooms ?? 0 }} BHK</span>
                    </div>
                    <div class="flex items-center justify-center gap-1 border-x border-slate-200">
                        <span class="material-symbols-outlined text-base text-cyan-600">bathtub</span>
                        <span>{{ $property->bathrooms ?? 0 }} Baths</span>
                    </div>
                    <div class="flex items-center justify-center gap-1">
                        <span class="material-symbols-outlined text-base text-amber-600">chair</span>
                        <span>{{ $property->is_furnished ? 'Furnished' : 'Unfurn.' }}</span>
                    </div>
                @endif
            </div>
        </div>
    </div>

    <!-- Card Action Bottom Bar -->
    <div class="px-5 pb-5 pt-3 border-t border-slate-100 flex items-center gap-2">
        <!-- 1. WhatsApp Button with correctly scaled 24x24 SVG -->
        <a href="{{ $property->whatsapp_url }}" 
           target="_blank" 
           rel="noopener noreferrer" 
           onclick="fetch('/properties/{{ $property->id }}/track-contact', { method: 'POST', headers: { 'Content-Type': 'application/json', 'X-CSRF-TOKEN': '{{ csrf_token() }}' }, body: JSON.stringify({ type: 'whatsapp' }) })"
           class="h-11 px-3.5 rounded-full bg-emerald-50 hover:bg-emerald-100 text-emerald-800 font-bold text-xs flex items-center justify-center gap-1.5 border border-emerald-300 transition-all shrink-0 cursor-pointer shadow-2xs" 
           title="Chat directly on WhatsApp">
            <svg class="w-5 h-5 fill-current text-emerald-700 shrink-0" viewBox="0 0 24 24">
                <path d="M19.05 4.91A9.816 9.816 0 0 0 12.04 2c-5.46 0-9.91 4.45-9.91 9.91 0 1.75.46 3.45 1.32 4.95L2.05 22l5.25-1.38c1.45.79 3.08 1.21 4.74 1.21 5.46 0 9.91-4.45 9.91-9.91 0-2.65-1.03-5.14-2.9-7.01zm-7.01 15.24c-1.48 0-2.93-.4-4.2-1.15l-.3-.18-3.12.82.83-3.04-.2-.31a8.19 8.19 0 0 1-1.26-4.38c0-4.54 3.7-8.24 8.25-8.24 2.2 0 4.27.86 5.82 2.42a8.18 8.18 0 0 1 2.41 5.83c.02 4.54-3.68 8.23-8.23 8.23zm4.52-6.16c-.25-.12-1.47-.72-1.69-.81-.23-.08-.39-.12-.56.12-.17.25-.64.81-.78.98-.14.17-.29.19-.54.06-.25-.12-1.05-.39-2-1.23-.74-.66-1.23-1.47-1.38-1.72-.14-.25-.02-.38.11-.51.11-.11.25-.29.37-.43.12-.14.17-.25.25-.41.08-.17.04-.31-.02-.43s-.56-1.34-.76-1.84c-.2-.48-.41-.42-.56-.43h-.48c-.17 0-.43.06-.66.31-.22.25-.86.84-.86 2.06 0 1.21.89 2.39 1.01 2.56.12.17 1.75 2.67 4.23 3.74.59.26 1.05.41 1.41.52.59.19 1.13.16 1.56.1.48-.07 1.47-.6 1.67-1.18.21-.58.21-1.07.14-1.18-.06-.12-.22-.19-.47-.32z"/>
            </svg>
            <span class="hidden sm:inline">WhatsApp</span>
        </a>

        <!-- 2. Direct In-App Chat -->
        <a href="/chat?property_id={{ $property->id }}" 
           class="h-11 px-3.5 rounded-full bg-slate-100 hover:bg-slate-200 text-slate-800 font-bold text-xs flex items-center justify-center gap-1.5 border border-slate-200 transition-all shrink-0 cursor-pointer shadow-2xs" 
           title="In-App Direct Chat with Owner">
            <span class="material-symbols-outlined text-[18px] text-slate-700">chat</span>
            <span class="hidden sm:inline">Chat</span>
        </a>

        <!-- 3. Primary View Details CTA -->
        <a href="{{ $property->seo_url }}" 
           class="flex-1 h-11 px-4 rounded-full bg-[#0A2540] hover:bg-slate-900 text-white font-bold text-xs flex items-center justify-center gap-1.5 transition-all shadow-xs active:scale-95 group/btn cursor-pointer">
            <span>Details</span>
            <span class="material-symbols-outlined text-[16px] group-hover/btn:translate-x-0.5 transition-transform">arrow_forward</span>
        </a>
    </div>
</div>
