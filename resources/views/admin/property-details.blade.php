@extends('admin.layout')

@section('page_title', 'Space Specifications')

@section('content')
<div class="mb-6 max-w-4xl mx-auto flex items-center justify-between relative z-10">
    <a href="/admin/properties" class="inline-flex items-center gap-1.5 text-xs font-extrabold text-slate-500 hover:text-slate-800 transition">
        &larr; Back to Listings
    </a>
    <span class="text-[10px] text-slate-400 font-extrabold">Listing ID: #{{ $property->id }}</span>
</div>

<div class="max-w-4xl mx-auto bg-white rounded-2xl border border-slate-200/60 shadow-sm overflow-hidden relative z-10">
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
    
    <div class="h-80 w-full relative overflow-hidden bg-slate-900 border-b border-slate-200/50">
        <img src="{{ $imgUrl }}" class="h-full w-full object-cover" alt="Space Hero Image">
        <div class="absolute inset-0 bg-gradient-to-t from-slate-950/60 to-transparent"></div>
        <div class="absolute bottom-6 left-6 right-6 flex items-end justify-between text-white">
            <div>
                <span class="px-2.5 py-1 bg-[#187053] text-white rounded-md font-extrabold text-[9px] uppercase tracking-wider block w-max mb-2">
                    {{ $property->category }}
                </span>
                <h2 class="text-xl font-black leading-snug drop-shadow-sm">{{ $property->title }}</h2>
                <span class="text-[10px] text-slate-200 block mt-1 font-semibold tracking-wide">{{ $property->address }}</span>
            </div>
            
            <div class="text-right bg-slate-900/60 backdrop-blur-md border border-slate-800/50 p-4 rounded-xl">
                <span class="text-[8px] text-slate-400 font-extrabold uppercase tracking-widest block mb-0.5">Monthly Rate</span>
                <span class="text-lg font-black text-emerald-400">₹{{ number_format($property->price, 2) }}</span>
            </div>
        </div>
    </div>

    <!-- Details Grid -->
    <div class="p-8 space-y-8">
        <!-- Key Metrics Cards -->
        <div class="grid grid-cols-3 gap-4">
            <div class="bg-slate-50 p-4 rounded-xl border border-slate-200/60 flex flex-col justify-between">
                <span class="text-[9px] font-extrabold text-slate-400 uppercase tracking-widest">Bedrooms</span>
                <span class="text-sm font-black text-slate-800 mt-1">{{ $property->bedrooms ?? 0 }} Beds</span>
            </div>
            <div class="bg-slate-50 p-4 rounded-xl border border-slate-200/60 flex flex-col justify-between">
                <span class="text-[9px] font-extrabold text-slate-400 uppercase tracking-widest">Bathrooms</span>
                <span class="text-sm font-black text-slate-800 mt-1">{{ $property->bathrooms ?? 0 }} Baths</span>
            </div>
            <div class="bg-slate-50 p-4 rounded-xl border border-slate-200/60 flex flex-col justify-between">
                <span class="text-[9px] font-extrabold text-slate-400 uppercase tracking-widest">Listing Status</span>
                @if ($property->status == 'approved')
                    <span class="px-2.5 py-0.5 bg-emerald-50 text-emerald-700 rounded-full font-extrabold text-[9px] uppercase border border-emerald-250/50 w-max mt-1 text-center">Approved</span>
                @elseif ($property->status == 'pending')
                    <span class="px-2.5 py-0.5 bg-amber-50 text-amber-700 rounded-full font-extrabold text-[9px] uppercase border border-amber-250/50 w-max mt-1 text-center animate-pulse">Pending</span>
                @else
                    <span class="px-2.5 py-0.5 bg-rose-50 text-rose-700 rounded-full font-extrabold text-[9px] uppercase border border-rose-250/50 w-max mt-1 text-center">Rejected</span>
                @endif
            </div>
        </div>

        <!-- Description -->
        <div class="space-y-2">
            <h4 class="text-[10px] font-extrabold text-[#187053] uppercase tracking-widest">Property Description</h4>
            <p class="text-xs text-slate-650 leading-relaxed bg-slate-50 p-5 rounded-xl border border-slate-200/50">
                {{ $property->description ?? 'No description provided.' }}
            </p>
        </div>

        <!-- Owner Card -->
        <div class="border-t border-slate-100 pt-6">
            <h4 class="text-[10px] font-extrabold text-slate-400 uppercase tracking-widest mb-3">Landlord Details</h4>
            <div class="flex items-center gap-4 bg-slate-50 p-4 rounded-xl border border-slate-200/50">
                <div class="h-10 w-10 rounded-full bg-[#187053] text-white flex items-center justify-center font-bold text-sm uppercase shadow-sm">
                    {{ substr($property->owner->name, 0, 1) }}
                </div>
                <div>
                    <div class="text-xs font-black text-slate-800">{{ $property->owner->name }}</div>
                    <span class="text-[10px] text-slate-400 block mt-0.5 font-medium">{{ $property->owner->email }}</span>
                </div>
            </div>
        </div>

        <!-- Moderation Actions -->
        <div class="border-t border-slate-100 pt-6 flex justify-end gap-3">
            @if ($property->status !== 'approved')
                <form action="/admin/properties/{{ $property->id }}/status" method="POST" class="m-0">
                    @csrf
                    <input type="hidden" name="status" value="approved">
                    <button type="submit" class="px-5 py-2.5 bg-[#187053] hover:bg-[#12563f] text-white text-xs font-extrabold rounded-lg shadow-sm transition">
                        Approve Space
                    </button>
                </form>
            @endif
            
            @if ($property->status !== 'rejected')
                <form action="/admin/properties/{{ $property->id }}/status" method="POST" class="m-0">
                    @csrf
                    <input type="hidden" name="status" value="rejected">
                    <button type="submit" class="px-5 py-2.5 bg-rose-50 hover:bg-rose-100 text-rose-700 border border-rose-200/60 text-xs font-extrabold rounded-lg shadow-sm transition">
                        Reject Space
                    </button>
                </form>
            @endif
        </div>
    </div>
</div>
@endsection
