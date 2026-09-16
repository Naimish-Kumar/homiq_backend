@props(['property'])

@php
    $images = (!empty($property->images) && is_array($property->images)) 
        ? $property->images 
        : ['https://images.unsplash.com/photo-1564013799919-ab600027ffc6?auto=format&fit=crop&w=800&q=80'];
    $imgCount = count($images);
    $relCat = strtolower($property->category ?? '');
    $isLandOrCommercial = str_contains($relCat, 'land') || str_contains($relCat, 'plot') || str_contains($relCat, 'shop') || str_contains($relCat, 'commercial');
@endphp

<div x-data="{ activeIndex: 0, total: {{ $imgCount }}, isSaved: false }" class="group bg-white rounded-3xl border border-slate-200/80 hover:border-brandEmerald/40 shadow-soft hover:shadow-xl transition-all duration-300 overflow-hidden flex flex-col justify-between h-full transform hover:-translate-y-1">
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
                     class="absolute inset-0 w-full h-full object-cover transition-transform duration-700 ease-out group-hover:scale-105">
            @endforeach

            <!-- Subtle Gradient Overlay -->
            <div class="absolute inset-0 bg-gradient-to-t from-slate-950/80 via-slate-950/15 to-black/20 pointer-events-none"></div>

            <!-- Top Header Badges & Favorite Button -->
            <div class="absolute top-3.5 left-3.5 right-3.5 flex items-start justify-between z-10 pointer-events-none">
                <div class="flex flex-wrap items-center gap-1.5 pointer-events-auto">
                    <span class="px-2.5 py-1 rounded-full bg-slate-950/70 backdrop-blur-md border border-white/10 text-white text-[10px] font-extrabold uppercase tracking-wider shadow-sm">
                        {{ $property->category }}
                    </span>
                    <span class="px-2.5 py-1 rounded-full bg-brandEmerald text-white text-[10px] font-extrabold uppercase tracking-wider shadow-sm">
                        For {{ ucfirst($property->listing_type) }}
                    </span>
                    @if($property->is_featured)
                        <span class="px-2.5 py-1 rounded-full bg-amber-500 text-white text-[10px] font-extrabold uppercase tracking-wider shadow-sm flex items-center gap-0.5">
                            <span class="material-symbols-outlined text-xs">star</span>
                            Featured
                        </span>
                    @endif
                </div>

                <!-- Favorite / Save Button -->
                <button type="button" 
                        @click.prevent.stop="isSaved = !isSaved" 
                        class="pointer-events-auto h-8 w-8 rounded-full bg-white/85 hover:bg-white text-slate-700 backdrop-blur-md shadow-md flex items-center justify-center transition-all transform hover:scale-110 active:scale-95"
                        :title="isSaved ? 'Remove from Saved' : 'Save to Favorites'">
                    <span class="material-symbols-outlined text-base transition-colors" :class="isSaved ? 'text-rose-500 fill-current' : 'text-slate-700'">favorite</span>
                </button>
            </div>

            <!-- In-Card Photo Navigation Controls (Only if > 1 photo) -->
            @if($imgCount > 1)
                <div class="absolute inset-y-0 left-0 right-0 flex items-center justify-between px-2.5 opacity-0 group-hover:opacity-100 transition-opacity duration-200 z-10 pointer-events-none">
                    <button type="button" 
                            @click.prevent.stop="activeIndex = (activeIndex === 0 ? total - 1 : activeIndex - 1)" 
                            class="pointer-events-auto h-7 w-7 rounded-full bg-black/50 hover:bg-black/80 text-white backdrop-blur-sm flex items-center justify-center transition shadow-md">
                        <span class="material-symbols-outlined text-sm">chevron_left</span>
                    </button>
                    <button type="button" 
                            @click.prevent.stop="activeIndex = (activeIndex === total - 1 ? 0 : activeIndex + 1)" 
                            class="pointer-events-auto h-7 w-7 rounded-full bg-black/50 hover:bg-black/80 text-white backdrop-blur-sm flex items-center justify-center transition shadow-md">
                        <span class="material-symbols-outlined text-sm">chevron_right</span>
                    </button>
                </div>

                <!-- In-Card Dot Indicators -->
                <div class="absolute bottom-14 left-0 right-0 flex justify-center gap-1 z-10 pointer-events-none">
                    <template x-for="i in total" :key="i">
                        <div class="h-1 rounded-full transition-all duration-300"
                             :class="(activeIndex === (i - 1)) ? 'w-4 bg-emerald-400' : 'w-1 bg-white/60'"></div>
                    </template>
                </div>
            @endif

            <!-- Price & Brokerage Tag on Photo Bottom -->
            <div class="absolute bottom-3 left-3.5 right-3.5 flex items-end justify-between text-white pointer-events-none z-10">
                <div class="drop-shadow-md">
                    <span class="font-black text-2xl tracking-tight text-white">
                        {{ $property->currency_symbol }}{{ number_format($property->price, 0) }}
                    </span>
                    <span class="text-[11px] font-semibold text-slate-200 ml-0.5">
                        {{ $property->price_unit ? $property->price_unit : ($property->listing_type === 'rent' ? ($property->billing_frequency_suffix ?? '/mo') : '') }}
                    </span>
                </div>
                <span class="px-2.5 py-1 rounded-full bg-emerald-500/90 backdrop-blur-md text-white text-[10px] font-extrabold uppercase tracking-wider shadow-sm">
                    0% Brokerage
                </span>
            </div>
        </div>

        <!-- Card Content Body -->
        <div class="p-5 flex flex-col justify-between">
            <a href="/properties/{{ $property->id }}" class="block">
                <h3 class="font-black text-slate-900 text-lg line-clamp-1 group-hover:text-brandEmerald transition-colors mb-1 tracking-tight">
                    {{ $property->title }}
                </h3>
                <p class="text-xs text-slate-500 flex items-center gap-1 font-medium truncate mb-4">
                    <span class="material-symbols-outlined text-sm text-emerald-600 shrink-0">location_on</span>
                    <span class="truncate">{{ $property->address }}</span>
                </p>
            </a>

            <!-- Modern Specs Bento Chips -->
            <div class="grid grid-cols-3 gap-2 p-2.5 rounded-2xl bg-slate-50 border border-slate-100 text-xs font-semibold text-slate-700 mb-4">
                @if($isLandOrCommercial)
                    <div class="flex items-center justify-center gap-1">
                        <span class="material-symbols-outlined text-base text-emerald-600">square_foot</span>
                        <span class="truncate">{{ $property->plot_area ?? $property->built_up_area ?? 'N/A' }} sqft</span>
                    </div>
                    <div class="flex items-center justify-center gap-1 border-x border-slate-200">
                        <span class="material-symbols-outlined text-base text-cyan-600">apartment</span>
                        <span class="truncate">{{ $property->floor_no ? 'Floor ' . $property->floor_no : 'Ground' }}</span>
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
    <div class="px-5 pb-5 pt-0">
        <a href="/properties/{{ $property->id }}" class="w-full py-2.5 px-4 rounded-xl bg-slate-100/90 group-hover:bg-brandNavy group-hover:text-white text-slate-800 font-bold text-xs flex items-center justify-between transition-all duration-200 shadow-2xs">
            <span class="inline-flex items-center gap-1.5 text-slate-600 group-hover:text-white">
                <span class="material-symbols-outlined text-sm text-emerald-500">verified</span>
                Verified Inspection
            </span>
            <span class="inline-flex items-center gap-1 text-slate-800 group-hover:text-emerald-400">
                <span>View Details</span>
                <span class="material-symbols-outlined text-sm transform group-hover:translate-x-1 transition-transform">arrow_forward</span>
            </span>
        </a>
    </div>
</div>
