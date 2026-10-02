@extends('admin.layout')

@section('page_title', 'Listing Inspection')

@section('content')
<div class="space-y-6 max-w-4xl">
    <!-- Header Navigation -->
    <div class="flex items-center justify-between pb-2">
        <a href="/admin/properties" class="inline-flex items-center gap-1.5 text-xs font-semibold text-slate-500 hover:text-slate-900 transition">
            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/></svg>
            Back to Listings
        </a>
        <span class="text-xs text-slate-400 font-mono">Listing ID: #{{ $property->id }}</span>
    </div>

    <div class="bg-white rounded-2xl border border-slate-200/80 shadow-xs overflow-hidden">
        <!-- Header Block / Banner Image -->
        @php
            $imgUrl = 'https://images.unsplash.com/photo-1564013799919-ab600027ffc6?auto=format&fit=crop&w=1200&q=80';
            if ($property->images && is_array($property->images) && count($property->images) > 0) {
                $imgUrl = $property->images[0];
            } elseif (is_string($property->images) && !empty($property->images)) {
                try {
                    $parsed = json_decode($property->images, true);
                    if (is_array($parsed) && count($parsed) > 0) {
                        $imgUrl = $parsed[0];
                    }
                } catch (\Exception $e) {}
            }
        @endphp
        
        <div class="h-72 w-full relative overflow-hidden bg-slate-900 border-b border-slate-200/80">
            <img src="{{ $imgUrl }}" class="h-full w-full object-cover opacity-90" alt="{{ $property->title }}">
            <div class="absolute inset-0 bg-gradient-to-t from-slate-950/80 via-slate-950/30 to-transparent"></div>
            <div class="absolute bottom-6 left-6 right-6 flex items-end justify-between text-white">
                <div class="space-y-1.5 max-w-xl">
                    <div class="flex items-center gap-2">
                        <span class="px-2.5 py-0.5 bg-white/20 backdrop-blur-md text-white rounded-md font-semibold text-[11px] uppercase tracking-wider">
                            {{ $property->category }}
                        </span>
                        <span class="px-2.5 py-0.5 {{ $property->listing_type === 'sale' ? 'bg-amber-500/80' : 'bg-emerald-500/80' }} backdrop-blur-md text-white rounded-md font-semibold text-[11px] uppercase tracking-wider">
                            For {{ ucfirst($property->listing_type) }}
                        </span>
                    </div>
                    <h2 class="text-xl font-bold leading-tight drop-shadow-xs">{{ $property->title }}</h2>
                    <p class="text-xs text-slate-200 flex items-center gap-1.5">
                        <svg class="w-3.5 h-3.5 text-slate-300 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                        <span>{{ $property->address }}</span>
                    </p>
                </div>
                
                <div class="text-right bg-slate-900/80 backdrop-blur-md border border-slate-700/60 px-4 py-3 rounded-xl shadow-lg">
                    <span class="text-[10px] text-slate-400 font-semibold uppercase tracking-wider block mb-0.5">{{ $property->listing_type === 'sale' ? 'Total Asking Price' : $property->billing_frequency_label }}</span>
                    <span class="text-xl font-black text-emerald-400 font-mono">{{ $property->currency_symbol }}{{ number_format($property->price, 2) }}</span>
                </div>
            </div>
        </div>

        <!-- Details Grid -->
        <div class="p-6 md:p-8 space-y-6">
            <!-- Key Metrics Cards -->
            <div class="grid grid-cols-2 sm:grid-cols-4 gap-3">
                <div class="bg-slate-50/75 p-3.5 rounded-xl border border-slate-200/80">
                    <span class="text-[10px] font-semibold text-slate-400 uppercase tracking-wider block">Bedrooms</span>
                    <span class="text-sm font-bold text-slate-900 mt-0.5 block">{{ $property->bedrooms ?? 0 }} Beds</span>
                </div>
                <div class="bg-slate-50/75 p-3.5 rounded-xl border border-slate-200/80">
                    <span class="text-[10px] font-semibold text-slate-400 uppercase tracking-wider block">Bathrooms</span>
                    <span class="text-sm font-bold text-slate-900 mt-0.5 block">{{ $property->bathrooms ?? 0 }} Baths</span>
                </div>
                <div class="bg-slate-50/75 p-3.5 rounded-xl border border-slate-200/80">
                    <span class="text-[10px] font-semibold text-slate-400 uppercase tracking-wider block">Available From</span>
                    <span class="text-sm font-bold text-slate-900 mt-0.5 block">{{ $property->available_from ? $property->available_from->format('M d, Y') : 'Immediate' }}</span>
                </div>
                <div class="bg-slate-50/75 p-3.5 rounded-xl border border-slate-200/80">
                    <span class="text-[10px] font-semibold text-slate-400 uppercase tracking-wider block">Listing Status</span>
                    <div class="mt-1">
                        @if ($property->status == 'approved')
                            <span class="px-2 py-0.5 bg-emerald-50 text-emerald-700 rounded-md font-semibold text-[10px] uppercase border border-emerald-200">Live & Approved</span>
                        @elseif ($property->status == 'pending')
                            <span class="px-2 py-0.5 bg-amber-50 text-amber-700 rounded-md font-semibold text-[10px] uppercase border border-amber-200">Pending Review</span>
                        @else
                            <span class="px-2 py-0.5 bg-rose-50 text-rose-700 rounded-md font-semibold text-[10px] uppercase border border-rose-200">Rejected</span>
                        @endif
                    </div>
                </div>
            </div>

            @php
                $cat = strtolower($property->category);
                $isLand = str_contains($cat, 'land') || str_contains($cat, 'plot');
            @endphp

            <!-- Listing Type Specific Details -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                @if($property->listing_type === 'rent')
                    <div class="bg-slate-50/60 p-4 rounded-xl border border-slate-200/80 space-y-3">
                        <h5 class="text-xs font-bold text-slate-900 uppercase tracking-wider border-b border-slate-200/80 pb-2">Rental & Lease Details</h5>
                        <div class="grid grid-cols-2 gap-3 text-xs">
                            <div>
                                <span class="text-slate-400 block text-[11px] font-medium">Security Deposit</span>
                                <span class="font-semibold text-slate-800">{{ $property->security_deposit ? $property->currency_symbol . number_format($property->security_deposit, 0) : 'Not specified' }}</span>
                            </div>
                            <div>
                                <span class="text-slate-400 block text-[11px] font-medium">Lease Duration</span>
                                <span class="font-semibold text-slate-800">{{ $property->lease_duration ?: 'Flexible' }}</span>
                            </div>
                            <div>
                                <span class="text-slate-400 block text-[11px] font-medium">Preferred Tenant</span>
                                <span class="font-semibold text-slate-800">{{ $property->preferred_tenant ?: 'Any' }}</span>
                            </div>
                            <div>
                                <span class="text-slate-400 block text-[11px] font-medium">Group Renting</span>
                                <span class="font-semibold text-slate-800">{{ $property->supports_group_renting ? 'Allowed (Max ' . $property->group_max_size . ' roommates)' : 'Not Allowed' }}</span>
                            </div>
                        </div>
                    </div>
                @else
                    <div class="bg-slate-50/60 p-4 rounded-xl border border-slate-200/80 space-y-3">
                        <h5 class="text-xs font-bold text-slate-900 uppercase tracking-wider border-b border-slate-200/80 pb-2">Sale Details</h5>
                        <div class="grid grid-cols-2 gap-3 text-xs">
                            @if(!$isLand)
                                <div>
                                    <span class="text-slate-400 block text-[11px] font-medium">Built-up Area</span>
                                    <span class="font-semibold text-slate-800">{{ $property->built_up_area ? number_format($property->built_up_area) . ' sq ft' : 'Not specified' }}</span>
                                </div>
                                <div>
                                    <span class="text-slate-400 block text-[11px] font-medium">Property Age</span>
                                    <span class="font-semibold text-slate-800">{{ $property->property_age ? $property->property_age . ' years' : 'Not specified' }}</span>
                                </div>
                                <div>
                                    <span class="text-slate-400 block text-[11px] font-medium">RERA Approved</span>
                                    <span class="font-semibold text-slate-800">{{ $property->is_rera_approved ? 'Yes' : 'No' }}</span>
                                </div>
                            @else
                                <div>
                                    <span class="text-slate-400 block text-[11px] font-medium">Plot Area</span>
                                    <span class="font-semibold text-slate-800">{{ $property->plot_area ? number_format($property->plot_area) . ' sq m' : 'Not specified' }}</span>
                                </div>
                                <div>
                                    <span class="text-slate-400 block text-[11px] font-medium">Boundary Wall</span>
                                    <span class="font-semibold text-slate-800">{{ $property->boundary_wall ? 'Yes' : 'No' }}</span>
                                </div>
                            @endif
                            <div>
                                <span class="text-slate-400 block text-[11px] font-medium">Ownership Type</span>
                                <span class="font-semibold text-slate-800">{{ $property->ownership_type ?: 'Not specified' }}</span>
                            </div>
                        </div>
                    </div>
                @endif

                <!-- Unit Details -->
                <div class="bg-slate-50/60 p-4 rounded-xl border border-slate-200/80 space-y-3">
                    <h5 class="text-xs font-bold text-slate-900 uppercase tracking-wider border-b border-slate-200/80 pb-2">Unit Specifications</h5>
                    <div class="grid grid-cols-2 gap-3 text-xs">
                        <div>
                            <span class="text-slate-400 block text-[11px] font-medium">Carpet Area</span>
                            <span class="font-semibold text-slate-800">{{ $property->carpet_area ? number_format($property->carpet_area) . ' sq ft' : 'Not specified' }}</span>
                        </div>
                        @if(!$isLand)
                            <div>
                                <span class="text-slate-400 block text-[11px] font-medium">Floor Detail</span>
                                <span class="font-semibold text-slate-800">{{ $property->floor_number !== null ? 'Floor ' . $property->floor_number . ' of ' . ($property->total_floors ?: 'Any') : 'Not specified' }}</span>
                            </div>
                        @endif
                        <div>
                            <span class="text-slate-400 block text-[11px] font-medium">Facing Direction</span>
                            <span class="font-semibold text-slate-800">{{ $property->facing_direction ?: 'Not specified' }}</span>
                        </div>
                        <div>
                            <span class="text-slate-400 block text-[11px] font-medium">Price Negotiable</span>
                            <span class="font-semibold text-slate-800">{{ $property->is_negotiable ? 'Yes' : 'No' }}</span>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Description -->
            <div class="space-y-2">
                <h4 class="text-xs font-bold text-slate-900 uppercase tracking-wider">Property Description</h4>
                <p class="text-xs text-slate-700 leading-relaxed bg-slate-50/60 p-4 rounded-xl border border-slate-200/80 whitespace-pre-line">
                    {{ $property->description ?? 'No description provided.' }}
                </p>
            </div>

            <!-- Owner Card -->
            <div class="border-t border-slate-100 pt-5">
                <h4 class="text-xs font-bold text-slate-900 uppercase tracking-wider mb-2.5">Landlord & Host Profile</h4>
                <div class="flex items-center gap-3.5 bg-slate-50/60 p-3.5 rounded-xl border border-slate-200/80">
                    <div class="h-10 w-10 rounded-full bg-slate-900 text-white flex items-center justify-center font-bold text-sm uppercase">
                        {{ substr($property->owner->name, 0, 1) }}
                    </div>
                    <div>
                        <div class="text-xs font-bold text-slate-900">{{ $property->owner->name }}</div>
                        <span class="text-[11px] text-slate-500 block">{{ $property->owner->email }}</span>
                    </div>
                </div>
            </div>

            <!-- Moderation Actions -->
            <div class="border-t border-slate-100 pt-5 flex flex-wrap items-center justify-end gap-2.5">
                <a href="/admin/properties/{{ $property->id }}/edit" class="px-3.5 py-1.5 bg-white hover:bg-slate-100 text-slate-700 border border-slate-200 text-xs font-semibold rounded-lg shadow-xs transition inline-flex items-center gap-1.5">
                    <svg class="w-3.5 h-3.5 text-slate-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/></svg>
                    <span>Edit Listing</span>
                </a>
                
                <!-- Delete Property Form -->
                <form action="/admin/properties/{{ $property->id }}" method="POST" class="m-0" onsubmit="return confirm('Are you sure you want to permanently delete this property listing? This will also cancel all associated bookings.')">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="px-3.5 py-1.5 bg-rose-50 hover:bg-rose-100 text-rose-700 border border-rose-200 text-xs font-semibold rounded-lg shadow-xs transition">
                        Delete Listing
                    </button>
                </form>

                @if ($property->status !== 'approved')
                    <form action="/admin/properties/{{ $property->id }}/status" method="POST" class="m-0">
                        @csrf
                        <input type="hidden" name="status" value="approved">
                        <button type="submit" class="px-4 py-1.5 bg-emerald-600 hover:bg-emerald-700 text-white text-xs font-semibold rounded-lg shadow-xs transition">
                            Approve Listing
                        </button>
                    </form>
                @endif
                
                @if ($property->status !== 'rejected')
                    <form action="/admin/properties/{{ $property->id }}/status" method="POST" class="m-0">
                        @csrf
                        <input type="hidden" name="status" value="rejected">
                        <button type="submit" class="px-4 py-1.5 bg-white hover:bg-rose-50 text-rose-600 border border-rose-200 text-xs font-semibold rounded-lg shadow-xs transition">
                            Reject Listing
                        </button>
                    </form>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection
