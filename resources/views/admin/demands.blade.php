@extends('admin.layout')

@section('page_title', 'Demand Board & Property Requests')

@section('content')
<div class="space-y-6">

    <!-- Top Action Header Banner -->
    <div class="bg-gradient-to-r from-[#0A2540] via-[#0F365E] to-[#0A2540] rounded-3xl p-6 lg:p-8 text-white shadow-xl shadow-slate-900/10 border border-slate-700/50 relative overflow-hidden">
        <!-- Background Orbs -->
        <div class="absolute -right-10 -top-10 w-64 h-64 bg-emerald-500/10 rounded-full blur-3xl pointer-events-none"></div>
        <div class="absolute right-40 -bottom-10 w-48 h-48 bg-teal-500/10 rounded-full blur-2xl pointer-events-none"></div>

        <div class="relative z-10 flex flex-col lg:flex-row lg:items-center justify-between gap-6">
            <div class="space-y-2">
                <div class="inline-flex items-center gap-2 px-3 py-1 rounded-full bg-emerald-500/20 border border-emerald-400/30 text-emerald-300 text-[11px] font-extrabold uppercase tracking-wider">
                    <span class="h-2 w-2 rounded-full bg-emerald-400 animate-pulse"></span> Seeker Demand Management
                </div>
                <h1 class="text-2xl lg:text-3xl font-extrabold tracking-tight font-heading">
                    Demand Board & Seeker Inquiries
                </h1>
                <p class="text-xs lg:text-sm text-slate-300 max-w-2xl leading-relaxed">
                    Monitor high-intent tenant and buyer requests, match them against live verified inventory, and curate platform lead conversions.
                </p>
            </div>

            <!-- Export Hub / Quick Action -->
            <div class="flex flex-wrap items-center gap-3">
                <a href="{{ route('admin.export.demands') }}" class="inline-flex items-center gap-2 px-4 py-2.5 bg-emerald-500 hover:bg-emerald-600 text-slate-950 font-bold text-xs rounded-xl shadow-lg shadow-emerald-500/25 transition">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4" />
                    </svg>
                    <span>Export Demands (CSV)</span>
                </a>
            </div>
        </div>
    </div>

    <!-- 4 Primary KPI Summary Cards -->
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-5">
        
        <!-- Total Inquiries -->
        <div class="bg-white rounded-2xl p-5 border border-slate-200/80 shadow-xs relative overflow-hidden group hover:border-emerald-300 transition duration-300">
            <div class="flex items-center justify-between mb-3">
                <span class="text-[11px] font-bold uppercase tracking-wider text-slate-500">Total Demands</span>
                <div class="h-10 w-10 rounded-xl bg-blue-50 text-blue-600 flex items-center justify-center shadow-xs">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.75" d="M9 12h3.75M9 15h3.75M9 18h3.75m3 .75H18a2.25 2.25 0 002.25-2.25V6.108c0-1.135-.845-2.098-1.976-2.192a48.424 48.424 0 00-1.123-.08m-5.801 0c-.065.21-.1.433-.1.664 0 .414.336.75.75.75h4.5a.75.75 0 00.75-.75 2.25 2.25 0 00-.1-.664m-5.8 0A2.251 2.251 0 0113.5 2.25H15c1.012 0 1.867.668 2.15 1.586m-5.8 0c-.376.023-.75.05-1.124.08C9.095 4.01 8.25 4.973 8.25 6.108V8.25m0 0H4.875c-.621 0-1.125.504-1.125 1.125v11.25c0 .621.504 1.125 1.125 1.125h9.75c.621 0 1.125-.504 1.125-1.125V9.375c0-.621-.504-1.125-1.125-1.125H8.25zM6.75 12h.008v.008H6.75V12zm0 3h.008v.008H6.75V15zm0 3h.008v.008H6.75V18z"/></svg>
                </div>
            </div>
            <div class="space-y-1">
                <div class="text-2xl font-black text-slate-900 tracking-tight">
                    {{ number_format($totalCount) }}
                </div>
                <div class="text-[11px] text-slate-500 font-medium">
                    Cumulative seeker requests posted
                </div>
            </div>
        </div>

        <!-- Active Market Demands -->
        <div class="bg-white rounded-2xl p-5 border border-slate-200/80 shadow-xs relative overflow-hidden group hover:border-emerald-300 transition duration-300">
            <div class="flex items-center justify-between mb-3">
                <span class="text-[11px] font-bold uppercase tracking-wider text-slate-500">Active In-Market</span>
                <div class="h-10 w-10 rounded-xl bg-emerald-50 text-emerald-600 flex items-center justify-center shadow-xs">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.75" d="M3.75 13.5l10.5-11.25L12 10.5h8.25L9.75 21.75 12 13.5H3.75z"/></svg>
                </div>
            </div>
            <div class="space-y-1">
                <div class="text-2xl font-black text-emerald-700 tracking-tight">
                    {{ number_format($activeCount) }}
                </div>
                <div class="text-[11px] text-emerald-600 font-bold flex items-center gap-1">
                    <span class="h-1.5 w-1.5 rounded-full bg-emerald-500 animate-pulse"></span>
                    Ready for property matching
                </div>
            </div>
        </div>

        <!-- Fulfilled Deals -->
        <div class="bg-white rounded-2xl p-5 border border-slate-200/80 shadow-xs relative overflow-hidden group hover:border-emerald-300 transition duration-300">
            <div class="flex items-center justify-between mb-3">
                <span class="text-[11px] font-bold uppercase tracking-wider text-slate-500">Fulfilled / Closed</span>
                <div class="h-10 w-10 rounded-xl bg-purple-50 text-purple-600 flex items-center justify-center shadow-xs">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.75" d="M9 12.75L11.25 15 15 9.75M21 12c0 1.268-.63 2.39-1.593 3.068a3.745 3.745 0 01-1.043 3.296 3.745 3.745 0 01-3.296 1.043A3.745 3.745 0 0112 21c-1.268 0-2.39-.63-3.068-1.593a3.746 3.746 0 01-3.296-1.043 3.745 3.745 0 01-1.043-3.296A3.745 3.745 0 013 12c0-1.268.63-2.39 1.593-3.068a3.745 3.745 0 011.043-3.296 3.746 3.746 0 013.296-1.043A3.746 3.746 0 0112 3c1.268 0 2.39.63 3.068 1.593a3.746 3.746 0 013.296 1.043 3.746 3.746 0 011.043 3.296A3.745 3.745 0 0121 12z"/></svg>
                </div>
            </div>
            <div class="space-y-1">
                <div class="text-2xl font-black text-slate-900 tracking-tight">
                    {{ number_format($fulfilledCount) }}
                </div>
                <div class="text-[11px] text-slate-500 font-medium">
                    Successfully matched or resolved
                </div>
            </div>
        </div>

        <!-- Purpose Split -->
        <div class="bg-white rounded-2xl p-5 border border-slate-200/80 shadow-xs relative overflow-hidden group hover:border-emerald-300 transition duration-300">
            <div class="flex items-center justify-between mb-3">
                <span class="text-[11px] font-bold uppercase tracking-wider text-slate-500">Demand Category</span>
                <div class="h-10 w-10 rounded-xl bg-amber-50 text-amber-600 flex items-center justify-center shadow-xs">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.75" d="M10.5 6a7.5 7.5 0 107.5 7.5h-7.5V6z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.75" d="M13.5 10.5H21A7.5 7.5 0 0013.5 3v7.5z"/></svg>
                </div>
            </div>
            <div class="space-y-1">
                <div class="text-2xl font-black text-slate-900 tracking-tight">
                    {{ $rentCount }} <span class="text-xs font-normal text-slate-400">Rent</span> / {{ $buyCount }} <span class="text-xs font-normal text-slate-400">Buy</span>
                </div>
                <div class="flex items-center gap-2 text-[11px] text-slate-500 font-medium">
                    <span class="px-1.5 py-0.5 rounded bg-blue-50 text-blue-700 font-bold text-[10px]">{{ $rentCount }} Rentals</span>
                    <span class="px-1.5 py-0.5 rounded bg-emerald-50 text-emerald-700 font-bold text-[10px]">{{ $buyCount }} Purchases</span>
                </div>
            </div>
        </div>

    </div>

    <!-- Search & Filter Controls Card -->
    <div class="bg-white rounded-2xl p-5 border border-slate-200/80 shadow-xs">
        <form action="{{ route('admin.demands') }}" method="GET" class="space-y-4">
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4">
                
                <!-- Keyword Search -->
                <div class="space-y-1.5">
                    <label class="block text-[11px] font-bold text-slate-600 uppercase tracking-wider">Search Keyword</label>
                    <div class="relative">
                        <span class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none text-slate-400">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                            </svg>
                        </span>
                        <input type="text" name="search" value="{{ request('search') }}" placeholder="Seeker name, phone, BHK, locality..."
                               class="w-full pl-10 pr-4 py-2.5 text-xs font-semibold rounded-xl border border-slate-200 bg-slate-50/60 text-slate-800 placeholder-slate-400 focus:outline-none focus:border-emerald-500 focus:ring-2 focus:ring-emerald-500/20 transition">
                    </div>
                </div>

                <!-- Status Filter -->
                <div class="space-y-1.5">
                    <label class="block text-[11px] font-bold text-slate-600 uppercase tracking-wider">Status</label>
                    <select name="status" class="w-full px-3.5 py-2.5 text-xs font-semibold rounded-xl border border-slate-200 bg-slate-50/60 text-slate-800 focus:outline-none focus:border-emerald-500 focus:ring-2 focus:ring-emerald-500/20 transition">
                        <option value="">All Statuses</option>
                        <option value="active" {{ request('status') === 'active' ? 'selected' : '' }}>Active</option>
                        <option value="fulfilled" {{ request('status') === 'fulfilled' ? 'selected' : '' }}>Fulfilled</option>
                        <option value="closed" {{ request('status') === 'closed' ? 'selected' : '' }}>Closed</option>
                        <option value="expired" {{ request('status') === 'expired' ? 'selected' : '' }}>Expired</option>
                    </select>
                </div>

                <!-- Purpose Filter -->
                <div class="space-y-1.5">
                    <label class="block text-[11px] font-bold text-slate-600 uppercase tracking-wider">Purpose</label>
                    <select name="purpose" class="w-full px-3.5 py-2.5 text-xs font-semibold rounded-xl border border-slate-200 bg-slate-50/60 text-slate-800 focus:outline-none focus:border-emerald-500 focus:ring-2 focus:ring-emerald-500/20 transition">
                        <option value="">Rent & Buy (All)</option>
                        <option value="rent" {{ request('purpose') === 'rent' ? 'selected' : '' }}>Rent Only</option>
                        <option value="buy" {{ request('purpose') === 'buy' ? 'selected' : '' }}>Buy / Sale Only</option>
                    </select>
                </div>

                <!-- City Filter -->
                <div class="space-y-1.5">
                    <label class="block text-[11px] font-bold text-slate-600 uppercase tracking-wider">City</label>
                    <select name="city" class="w-full px-3.5 py-2.5 text-xs font-semibold rounded-xl border border-slate-200 bg-slate-50/60 text-slate-800 focus:outline-none focus:border-emerald-500 focus:ring-2 focus:ring-emerald-500/20 transition">
                        <option value="">All Cities</option>
                        @foreach($cities as $city)
                            <option value="{{ $city }}" {{ request('city') === $city ? 'selected' : '' }}>{{ $city }}</option>
                        @endforeach
                    </select>
                </div>

            </div>

            <!-- Submit / Reset Action Buttons -->
            <div class="flex items-center justify-end gap-2.5 pt-1">
                @if(request()->hasAny(['search', 'status', 'purpose', 'city']))
                    <a href="{{ route('admin.demands') }}" class="px-4 py-2 bg-slate-100 hover:bg-slate-200 text-slate-700 text-xs font-bold rounded-xl transition">
                        Reset Filters
                    </a>
                @endif
                <button type="submit" class="px-5 py-2 bg-[#0A2540] hover:bg-[#0F365E] text-white text-xs font-bold rounded-xl shadow-md transition">
                    Apply Filters
                </button>
            </div>
        </form>
    </div>

    <!-- Demand Inquiries Table Card -->
    <div class="bg-white rounded-2xl border border-slate-200/80 shadow-xs overflow-hidden">
        
        <!-- Table Header -->
        <div class="p-5 lg:p-6 border-b border-slate-100 flex items-center justify-between">
            <div>
                <h3 class="text-base font-extrabold text-slate-900 font-heading flex items-center gap-2">
                    <svg class="w-5 h-5 text-emerald-600" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="1.75">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 14.25v-2.625a3.375 3.375 0 00-3.375-3.375h-1.5A1.125 1.125 0 0113.5 7.125v-1.5a3.375 3.375 0 00-3.375-3.375H8.25m5.231 13.481L15 17.25m-4.5-15H5.625c-.621 0-1.125.504-1.125 1.125v17.25c0 .621.504 1.125 1.125 1.125h12.75c.621 0 1.125-.504 1.125-1.125V11.25a9 9 0 00-9-9zm3.75 11.625a2.625 2.625 0 11-5.25 0 2.625 2.625 0 015.25 0z" />
                    </svg>
                    Seeker Property Demand Registry
                </h3>
                <p class="text-xs text-slate-400 mt-0.5">Live requirement requests submitted across mobile app and web platform</p>
            </div>
            <span class="text-xs font-bold text-slate-500 bg-slate-100 px-3 py-1 rounded-lg">
                {{ $demands->total() }} Records
            </span>
        </div>

        <!-- Table Container -->
        <div class="overflow-x-auto">
            <table class="w-full text-left text-xs text-slate-600">
                <thead class="bg-slate-50/75 border-b border-slate-200 text-[11px] uppercase tracking-wider text-slate-400 font-extrabold">
                    <tr>
                        <th class="py-3.5 px-4 pl-6">ID & Timeline</th>
                        <th class="py-3.5 px-4">Seeker Contact</th>
                        <th class="py-3.5 px-4">Requirements</th>
                        <th class="py-3.5 px-4">Target Location</th>
                        <th class="py-3.5 px-4 text-right">Budget Ceiling</th>
                        <th class="py-3.5 px-4 text-center">Matched Inventory</th>
                        <th class="py-3.5 px-4 text-center">Status</th>
                        <th class="py-3.5 px-4 pr-6 text-right">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100">
                    @forelse($demands as $demand)
                        <tr class="hover:bg-slate-50/80 transition duration-150">
                            
                            <!-- ID & Timeline -->
                            <td class="py-4 px-4 pl-6">
                                <div class="space-y-0.5">
                                    <span class="font-mono font-bold text-slate-900">#REQ-{{ str_pad($demand->id, 5, '0', STR_PAD_LEFT) }}</span>
                                    <div class="text-[11px] text-slate-400 font-medium">{{ $demand->time_ago }}</div>
                                </div>
                            </td>

                            <!-- Seeker Contact -->
                            <td class="py-4 px-4">
                                <div class="space-y-1">
                                    <div class="flex items-center gap-1.5">
                                        <span class="font-bold text-slate-900">{{ $demand->seeker_name }}</span>
                                        <span class="px-1.5 py-0.5 bg-slate-100 text-slate-600 rounded text-[10px] font-semibold">
                                            {{ $demand->tenant_badge }}
                                        </span>
                                    </div>
                                    <div class="text-[11px] text-slate-500 font-medium flex flex-col gap-0.5">
                                        @if($demand->seeker_phone)
                                            <span class="flex items-center gap-1.5">
                                                <svg class="w-3.5 h-3.5 text-slate-400 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="1.75">
                                                    <path stroke-linecap="round" stroke-linejoin="round" d="M2.25 6.75c0 8.284 6.716 15 15 15h2.25a2.25 2.25 0 002.25-2.25v-1.372c0-.516-.351-.966-.852-1.091l-4.423-1.106c-.44-.11-.902.055-1.173.417l-.97 1.293c-.282.376-.769.542-1.21.38a12.035 12.035 0 01-7.143-7.143c-.162-.441.004-.928.38-1.21l1.293-.97c.363-.271.527-.734.417-1.173L6.963 3.102a1.125 1.125 0 00-1.091-.852H4.5A2.25 2.25 0 002.25 4.5v2.25z" />
                                                </svg>
                                                {{ $demand->seeker_phone }}
                                            </span>
                                        @endif
                                        @if($demand->seeker_email)
                                            <span class="flex items-center gap-1.5 truncate max-w-xs text-slate-400">
                                                <svg class="w-3.5 h-3.5 text-slate-400 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="1.75">
                                                    <path stroke-linecap="round" stroke-linejoin="round" d="M21.75 6.75v10.5a2.25 2.25 0 01-2.25 2.25h-15a2.25 2.25 0 01-2.25-2.25V6.75m19.5 0A2.25 2.25 0 0019.5 4.5h-15a2.25 2.25 0 00-2.25 2.25m19.5 0v.243a2.25 2.25 0 01-1.07 1.916l-7.5 4.615a2.25 2.25 0 01-2.36 0L3.32 8.91a2.25 2.25 0 01-1.07-1.916V6.75" />
                                                </svg>
                                                {{ $demand->seeker_email }}
                                            </span>
                                        @endif
                                    </div>
                                </div>
                            </td>

                            <!-- Requirements -->
                            <td class="py-4 px-4">
                                <div class="space-y-1">
                                    <div class="flex items-center gap-1.5">
                                        <span class="font-bold text-slate-900">{{ $demand->bedrooms ?: 'Any BHK' }}</span>
                                        <span class="text-slate-400">•</span>
                                        <span class="text-slate-700 font-semibold">{{ $demand->property_type }}</span>
                                    </div>
                                    <div class="flex items-center gap-1.5">
                                        @if($demand->purpose === 'buy')
                                            <span class="px-2 py-0.5 rounded-full text-[10px] font-extrabold bg-blue-50 text-blue-700 border border-blue-200 uppercase">Buy</span>
                                        @else
                                            <span class="px-2 py-0.5 rounded-full text-[10px] font-extrabold bg-emerald-50 text-emerald-700 border border-emerald-200 uppercase">Rent</span>
                                        @endif
                                        <span class="text-[11px] text-slate-400">Move-in: {{ $demand->move_in_timeline }}</span>
                                    </div>
                                </div>
                            </td>

                            <!-- Target Location -->
                            <td class="py-4 px-4">
                                <div class="space-y-0.5 max-w-xs">
                                    <span class="font-bold text-slate-900 block truncate" title="{{ $demand->location }}">
                                        {{ $demand->city }}
                                    </span>
                                    @if($demand->locality)
                                        <span class="text-[11px] text-slate-500 block truncate" title="{{ $demand->locality }}">
                                            {{ $demand->locality }}
                                        </span>
                                    @endif
                                </div>
                            </td>

                            <!-- Budget Ceiling -->
                            <td class="py-4 px-4 text-right font-black text-slate-900">
                                {{ $demand->formatted_budget }}
                                @if($demand->furnishing_preference)
                                    <div class="text-[10px] font-normal text-slate-400">{{ ucfirst($demand->furnishing_preference) }}</div>
                                @endif
                            </td>

                            <!-- Matched Inventory Indicator -->
                            <td class="py-4 px-4 text-center">
                                @if($demand->matching_inventory_count > 0)
                                    <span class="inline-flex items-center gap-1 px-2.5 py-1 rounded-full text-[10px] font-extrabold bg-emerald-50 text-emerald-700 border border-emerald-200 shadow-2xs">
                                        <span class="h-1.5 w-1.5 rounded-full bg-emerald-500 animate-ping"></span>
                                        {{ $demand->matching_inventory_count }} Properties
                                    </span>
                                @else
                                    <span class="inline-flex items-center px-2 py-0.5 rounded text-[10px] font-medium text-slate-400 bg-slate-50">
                                        0 Matched
                                    </span>
                                @endif
                            </td>

                            <!-- Status Dropdown / Badge -->
                            <td class="py-4 px-4 text-center">
                                <form action="{{ route('admin.demands.status', $demand->id) }}" method="POST" class="m-0 inline-block">
                                    @csrf
                                    <select name="status" onchange="this.form.submit()" class="text-[11px] font-bold rounded-lg px-2.5 py-1 border transition cursor-pointer focus:outline-none
                                        {{ $demand->status === 'active' ? 'bg-emerald-50 text-emerald-700 border-emerald-200' : '' }}
                                        {{ $demand->status === 'fulfilled' ? 'bg-purple-50 text-purple-700 border-purple-200' : '' }}
                                        {{ $demand->status === 'closed' ? 'bg-slate-100 text-slate-700 border-slate-200' : '' }}
                                        {{ $demand->status === 'expired' ? 'bg-amber-50 text-amber-700 border-amber-200' : '' }}">
                                        <option value="active" {{ $demand->status === 'active' ? 'selected' : '' }}>Active</option>
                                        <option value="fulfilled" {{ $demand->status === 'fulfilled' ? 'selected' : '' }}>Fulfilled</option>
                                        <option value="closed" {{ $demand->status === 'closed' ? 'selected' : '' }}>Closed</option>
                                        <option value="expired" {{ $demand->status === 'expired' ? 'selected' : '' }}>Expired</option>
                                    </select>
                                </form>
                            </td>

                            <!-- Actions -->
                            <td class="py-4 px-4 pr-6 text-right">
                                <form action="{{ route('admin.demands.delete', $demand->id) }}" method="POST" class="inline-block m-0" onsubmit="return confirm('Are you sure you want to delete this demand request permanently?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" title="Delete Demand" class="p-1.5 text-slate-400 hover:text-rose-600 hover:bg-rose-50 rounded-lg transition">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                        </svg>
                                    </button>
                                </form>
                            </td>

                        </tr>
                    @empty
                        <tr>
                            <td colspan="8" class="py-12 text-center text-slate-400">
                                <div class="flex flex-col items-center justify-center space-y-2">
                                    <svg class="w-10 h-10 text-slate-300" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="1.5">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 14.25v-2.625a3.375 3.375 0 00-3.375-3.375h-1.5A1.125 1.125 0 0113.5 7.125v-1.5a3.375 3.375 0 00-3.375-3.375H8.25m5.231 13.481L15 17.25m-4.5-15H5.625c-.621 0-1.125.504-1.125 1.125v17.25c0 .621.504 1.125 1.125 1.125h12.75c.621 0 1.125-.504 1.125-1.125V11.25a9 9 0 00-9-9zm3.75 11.625a2.625 2.625 0 11-5.25 0 2.625 2.625 0 015.25 0z" />
                                    </svg>
                                    <p class="text-xs font-semibold">No demand requests found matching the criteria.</p>
                                </div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <!-- Pagination Bar -->
        @if($demands->hasPages())
        <div class="p-4 border-t border-slate-100 bg-slate-50/50">
            {{ $demands->links() }}
        </div>
        @endif

    </div>

</div>
@endsection
