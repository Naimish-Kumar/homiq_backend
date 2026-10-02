@extends('admin.layout')

@section('page_title', 'Financial Analytics & Revenue')

@section('content')
<div class="space-y-6">

    <!-- Top Action Header Banner -->
    <div class="bg-gradient-to-r from-[#0A2540] via-[#0F365E] to-[#0A2540] rounded-3xl p-6 lg:p-8 text-white shadow-xl shadow-slate-900/10 border border-slate-700/50 relative overflow-hidden">
        <!-- Abstract Background Orbs -->
        <div class="absolute -right-10 -top-10 w-64 h-64 bg-emerald-500/10 rounded-full blur-3xl pointer-events-none"></div>
        <div class="absolute right-40 -bottom-10 w-48 h-48 bg-blue-500/10 rounded-full blur-2xl pointer-events-none"></div>

        <div class="relative z-10 flex flex-col lg:flex-row lg:items-center justify-between gap-6">
            <div class="space-y-2">
                <div class="inline-flex items-center gap-2 px-3 py-1 rounded-full bg-emerald-500/20 border border-emerald-400/30 text-emerald-300 text-[11px] font-extrabold uppercase tracking-wider">
                    <span class="h-2 w-2 rounded-full bg-emerald-400 animate-pulse"></span> Live Financial Intelligence
                </div>
                <h1 class="text-2xl lg:text-3xl font-extrabold tracking-tight font-heading">
                    Financial Performance & Revenue Engine
                </h1>
                <p class="text-xs lg:text-sm text-slate-300 max-w-2xl leading-relaxed">
                    Real-time monetization metrics, deal flow analytics, recurring SaaS subscription tracking, and transactional CSV exports.
                </p>
            </div>

            <!-- Export Hub Dropdown / Action Buttons -->
            <div class="flex flex-wrap items-center gap-3">
                <a href="{{ route('admin.export.transactions') }}" class="inline-flex items-center gap-2 px-4 py-2.5 bg-emerald-500 hover:bg-emerald-600 text-slate-950 font-bold text-xs rounded-xl shadow-lg shadow-emerald-500/25 transition">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4" />
                    </svg>
                    <span>Export Ledger (CSV)</span>
                </a>

                <div class="relative group">
                    <button type="button" class="inline-flex items-center gap-2 px-4 py-2.5 bg-white/10 hover:bg-white/20 text-white font-semibold text-xs rounded-xl border border-white/15 backdrop-blur-sm transition">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                        </svg>
                        <span>More Exports</span>
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-3.5 w-3.5 opacity-70" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                        </svg>
                    </button>
                    <!-- Dropdown Content -->
                    <div class="absolute right-0 mt-2 w-52 bg-white rounded-2xl shadow-xl border border-slate-200 py-2 hidden group-hover:block z-30">
                        <a href="{{ route('admin.export.properties') }}" class="flex items-center gap-2.5 px-4 py-2.5 text-xs text-slate-700 hover:bg-emerald-50 hover:text-emerald-800 transition font-medium">
                            <svg class="w-4 h-4 text-emerald-600 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="1.75">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M2.25 21h19.5m-18-18v18m10.5-18v18m6-13.5V21M6.75 6.75h.75m-.75 3h.75m-.75 3h.75m3-6h.75m-.75 3h.75m-.75 3h.75M6.75 21v-3.375c0-.621.504-1.125 1.125-1.125h2.25c.621 0 1.125.504 1.125 1.125V21M3 3h12m-.75 4.5H21m-3.75 3.75h.008v.008h-.008v-.008zm0 3h.008v.008h-.008v-.008zm0 3h.008v.008h-.008v-.008z" />
                            </svg>
                            <span>Properties Catalog CSV</span>
                        </a>
                        <a href="{{ route('admin.export.users') }}" class="flex items-center gap-2.5 px-4 py-2.5 text-xs text-slate-700 hover:bg-emerald-50 hover:text-emerald-800 transition font-medium">
                            <svg class="w-4 h-4 text-emerald-600 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="1.75">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M15 19.128a9.38 9.38 0 002.625.372 9.337 9.337 0 004.121-.952 4.125 4.125 0 00-7.533-2.493M15 19.128v-.003c0-1.113-.285-2.16-.786-3.07M15 19.128v.106A12.318 12.318 0 018.624 21c-2.331 0-4.512-.645-6.374-1.766l-.001-.109a6.375 6.375 0 0111.964-3.07M12 6.375a3.375 3.375 0 11-6.75 0 3.375 3.375 0 016.75 0zm8.25 2.25a2.625 2.625 0 11-5.25 0 2.625 2.625 0 015.25 0z" />
                            </svg>
                            <span>Members & Users CSV</span>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- 4 Primary Financial KPI Cards -->
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-5">
        
        <!-- Gross Deal Volume (GTV) -->
        <div class="bg-white rounded-2xl p-5 border border-slate-200/80 shadow-xs relative overflow-hidden group hover:border-emerald-300 transition duration-300">
            <div class="flex items-center justify-between mb-3">
                <span class="text-[11px] font-bold uppercase tracking-wider text-slate-500">Gross Transaction Vol.</span>
                <div class="h-10 w-10 rounded-xl bg-blue-50 text-blue-600 flex items-center justify-center shadow-xs">
                    <svg class="w-5 h-5 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="1.75">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M2.25 18.75a60.07 60.07 0 0115.797 2.101c.727.198 1.453-.342 1.453-1.096V18.75M3.75 4.5v.75A.75.75 0 013 6h-.75m0 0v-.375c0-.621.504-1.125 1.125-1.125H20.25M2.25 6v9m18-10.5v.75c0 .414.336.75.75.75h.75m-1.5-1.5h.375c.621 0 1.125.504 1.125 1.125v9.75c0 .621-.504 1.125-1.125 1.125h-.375m1.5-1.5H21a.75.75 0 00-.75.75v.75m0 0H3.75m0 0h-.375a1.125 1.125 0 01-1.125-1.125V15m1.5 1.5v-.75A.75.75 0 003 15h-.75M15 10.5a3 3 0 11-6 0 3 3 0 016 0zm3 0h.008v.008H18V10.5zm-12 0h.008v.008H6V10.5z" />
                    </svg>
                </div>
            </div>
            <div class="space-y-1">
                <div class="text-2xl font-black text-slate-900 tracking-tight">
                    ₹{{ number_format($grossVolume, 2) }}
                </div>
                <div class="flex items-center gap-1.5 text-[11px] text-slate-500 font-medium">
                    <span class="text-emerald-600 font-bold flex items-center">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-3 w-3 inline" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6" />
                        </svg> Total GTV
                    </span>
                    <span>across {{ $totalBookingsCount }} bookings</span>
                </div>
            </div>
        </div>

        <!-- Net Platform Revenue (Commission + SaaS) -->
        <div class="bg-white rounded-2xl p-5 border border-slate-200/80 shadow-xs relative overflow-hidden group hover:border-emerald-300 transition duration-300">
            <div class="flex items-center justify-between mb-3">
                <span class="text-[11px] font-bold uppercase tracking-wider text-slate-500">Net Platform Revenue</span>
                <div class="h-10 w-10 rounded-xl bg-emerald-50 text-emerald-600 flex items-center justify-center shadow-xs">
                    <svg class="w-5 h-5 text-emerald-600" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="1.75">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M21 12a2.25 2.25 0 00-2.25-2.25H15a3 3 0 11-6 0H5.25A2.25 2.25 0 003 12m18 0v6a2.25 2.25 0 01-2.25 2.25H5.25A2.25 2.25 0 013 18v-6m18 0V9M3 12V9m18 0a2.25 2.25 0 00-2.25-2.25H5.25A2.25 2.25 0 003 9m18 0V6a2.25 2.25 0 00-2.25-2.25H5.25A2.25 2.25 0 003 6v3" />
                    </svg>
                </div>
            </div>
            <div class="space-y-1">
                <div class="text-2xl font-black text-emerald-700 tracking-tight">
                    ₹{{ number_format($netRevenue, 2) }}
                </div>
                <div class="flex items-center gap-1.5 text-[11px] text-slate-500 font-medium">
                    <span class="text-slate-600 font-bold">5% Take-rate</span>
                    <span>+ Plan Subscriptions</span>
                </div>
            </div>
        </div>

        <!-- Subscription MRR / ARR -->
        <div class="bg-white rounded-2xl p-5 border border-slate-200/80 shadow-xs relative overflow-hidden group hover:border-emerald-300 transition duration-300">
            <div class="flex items-center justify-between mb-3">
                <span class="text-[11px] font-bold uppercase tracking-wider text-slate-500">Subscription MRR</span>
                <div class="h-10 w-10 rounded-xl bg-purple-50 text-purple-600 flex items-center justify-center shadow-xs">
                    <svg class="w-5 h-5 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="1.75">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M9.813 15.904L9 18.75l-.813-2.846a4.5 4.5 0 00-3.09-3.09L2.25 12l2.846-.813a4.5 4.5 0 003.09-3.09L9 5.25l.813 2.846a4.5 4.5 0 003.09 3.09L15.75 12l-2.846.813a4.5 4.5 0 00-3.09 3.09zM18.259 8.715L18 9.75l-.259-1.035a3.375 3.375 0 00-2.455-2.456L14.25 6l1.036-.259a3.375 3.375 0 002.455-2.456L18 2.25l.259 1.035a3.375 3.375 0 002.456 2.456L21.75 6l-1.035.259a3.375 3.375 0 00-2.456 2.456zM16.894 20.567L16.5 21.75l-.394-1.183a2.25 2.25 0 00-1.423-1.423L13.5 18.75l1.183-.394a2.25 2.25 0 001.423-1.423l.394-1.183.394 1.183a2.25 2.25 0 001.423 1.423l1.183.394-1.183.394a2.25 2.25 0 00-1.423 1.423z" />
                    </svg>
                </div>
            </div>
            <div class="space-y-1">
                <div class="text-2xl font-black text-slate-900 tracking-tight">
                    ₹{{ number_format($subscriptionRevenue, 2) }}
                </div>
                <div class="flex items-center gap-2 text-[11px] text-slate-500 font-medium">
                    <span class="px-1.5 py-0.5 rounded bg-purple-50 text-purple-700 font-bold text-[10px]">{{ $standardUsersCount }} Growth</span>
                    <span class="px-1.5 py-0.5 rounded bg-emerald-50 text-emerald-700 font-bold text-[10px]">{{ $unlimitedUsersCount }} Pro</span>
                </div>
            </div>
        </div>

        <!-- Average Deal Size -->
        <div class="bg-white rounded-2xl p-5 border border-slate-200/80 shadow-xs relative overflow-hidden group hover:border-emerald-300 transition duration-300">
            <div class="flex items-center justify-between mb-3">
                <span class="text-[11px] font-bold uppercase tracking-wider text-slate-500">Avg Deal Size</span>
                <div class="h-10 w-10 rounded-xl bg-amber-50 text-amber-600 flex items-center justify-center shadow-xs">
                    <svg class="w-5 h-5 text-amber-600" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="1.75">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M10.5 6a7.5 7.5 0 107.5 7.5h-7.5V6z" />
                        <path stroke-linecap="round" stroke-linejoin="round" d="M13.5 10.5H21A7.5 7.5 0 0013.5 3v7.5z" />
                    </svg>
                </div>
            </div>
            <div class="space-y-1">
                <div class="text-2xl font-black text-slate-900 tracking-tight">
                    ₹{{ number_format($avgDealValue, 2) }}
                </div>
                <div class="flex items-center gap-1.5 text-[11px] text-slate-500 font-medium">
                    <span>Per finalized rental / booking</span>
                </div>
            </div>
        </div>

    </div>

    <!-- Visual Charts Grid (Interactive Chart.js) -->
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        
        <!-- Chart 1: Revenue Timeline (Monthly GTV & Net Revenue) -->
        <div class="lg:col-span-2 bg-white rounded-2xl p-6 border border-slate-200/80 shadow-xs">
            <div class="flex items-center justify-between mb-6">
                <div>
                    <h3 class="text-sm font-extrabold text-slate-900 uppercase tracking-wider flex items-center gap-2">
                        <span class="h-2 w-2 rounded-full bg-emerald-500"></span>
                        Revenue Growth & Monthly GTV
                    </h3>
                    <p class="text-xs text-slate-400 mt-0.5">6-month trend for Gross Transaction Volume vs Net Platform Take</p>
                </div>
                <div class="flex items-center gap-3 text-xs font-semibold">
                    <span class="inline-flex items-center gap-1.5 text-slate-600">
                        <span class="h-2.5 w-2.5 rounded-full bg-blue-500"></span> Gross (₹)
                    </span>
                    <span class="inline-flex items-center gap-1.5 text-emerald-600">
                        <span class="h-2.5 w-2.5 rounded-full bg-emerald-500"></span> Net 5% (₹)
                    </span>
                </div>
            </div>

            <div class="h-72 w-full relative">
                <canvas id="monthlyRevenueChart"></canvas>
            </div>
        </div>

        <!-- Chart 2: Revenue Streams Breakdown Donut -->
        <div class="bg-white rounded-2xl p-6 border border-slate-200/80 shadow-xs flex flex-col justify-between">
            <div>
                <div class="flex items-center justify-between mb-4">
                    <h3 class="text-sm font-extrabold text-slate-900 uppercase tracking-wider">
                        Revenue Streams
                    </h3>
                    <span class="text-[10px] font-bold px-2 py-0.5 bg-slate-100 text-slate-600 rounded-md">Live Split</span>
                </div>
                <p class="text-xs text-slate-400 mb-4">Brokerage commissions vs SaaS recurring tiers.</p>
                
                <div class="h-56 w-full relative flex items-center justify-center">
                    <canvas id="revenueStreamChart"></canvas>
                </div>
            </div>

            <div class="mt-4 pt-4 border-t border-slate-100 space-y-2 text-xs">
                <div class="flex items-center justify-between">
                    <span class="flex items-center gap-2 text-slate-600">
                        <span class="h-2 w-2 rounded-full bg-emerald-500"></span> 5% Brokerage Commission
                    </span>
                    <span class="font-bold text-slate-900">₹{{ number_format($commissionRevenue, 2) }}</span>
                </div>
                <div class="flex items-center justify-between">
                    <span class="flex items-center gap-2 text-slate-600">
                        <span class="h-2 w-2 rounded-full bg-purple-500"></span> Growth Plan (₹499/mo)
                    </span>
                    <span class="font-bold text-slate-900">₹{{ number_format($standardUsersCount * 499, 2) }}</span>
                </div>
                <div class="flex items-center justify-between">
                    <span class="flex items-center gap-2 text-slate-600">
                        <span class="h-2 w-2 rounded-full bg-blue-500"></span> Pro Unlimited (₹999/mo)
                    </span>
                    <span class="font-bold text-slate-900">₹{{ number_format($unlimitedUsersCount * 999, 2) }}</span>
                </div>
            </div>
        </div>

    </div>

    <!-- City Performance Breakdown -->
    @if(count($cityStats) > 0)
    <div class="bg-white rounded-2xl p-6 border border-slate-200/80 shadow-xs">
        <div class="flex items-center justify-between mb-4">
            <div>
                <h3 class="text-sm font-extrabold text-slate-900 uppercase tracking-wider flex items-center gap-2">
                    <svg class="w-4.5 h-4.5 text-emerald-600" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="1.75">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M15 10.5a3 3 0 11-6 0 3 3 0 016 0z" />
                        <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 10.5c0 7.142-7.5 11.25-7.5 11.25S4.5 17.642 4.5 10.5a7.5 7.5 0 1115 0z" />
                    </svg>
                    Top Performing Locations & Cities
                </h3>
                <p class="text-xs text-slate-400 mt-0.5">Locations contributing highest transactional deal volume</p>
            </div>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
            @foreach($cityStats as $city)
                <div class="p-4 rounded-xl bg-slate-50 border border-slate-200/60 flex items-center justify-between">
                    <div class="space-y-1">
                        <p class="text-xs font-bold text-slate-800 line-clamp-1" title="{{ $city->address }}">{{ $city->address }}</p>
                        <p class="text-[11px] text-slate-500">{{ $city->bookings_count }} completed deals</p>
                    </div>
                    <div class="text-right">
                        <span class="text-xs font-black text-emerald-700 block">₹{{ number_format($city->city_volume, 2) }}</span>
                        <span class="text-[10px] text-slate-400 font-semibold">Volume</span>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
    @endif

    <!-- Transaction Ledger Table -->
    <div class="bg-white rounded-2xl border border-slate-200/80 shadow-xs overflow-hidden">
        
        <!-- Table Header & Filter Toolbar -->
        <div class="p-5 lg:p-6 border-b border-slate-100 flex flex-col md:flex-row md:items-center justify-between gap-4">
            <div>
                <h3 class="text-base font-extrabold text-slate-900 font-heading flex items-center gap-2">
                    <svg class="w-5 h-5 text-emerald-600" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="1.75">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 14.25v-2.625a3.375 3.375 0 00-3.375-3.375h-1.5A1.125 1.125 0 0113.5 7.125v-1.5a3.375 3.375 0 00-3.375-3.375H8.25m0 12.75h7.5m-7.53-4.5h7.5m-7.5-4.5h7.5m-7.5-4.5h7.5m-7.5-4.5h7.5M5.625 3.75h12.75c.621 0 1.125.504 1.125 1.125v17.25c0 .621-.504 1.125-1.125 1.125H5.625a1.125 1.125 0 01-1.125-1.125V4.875c0-.621.504-1.125 1.125-1.125z" />
                    </svg>
                    Financial Transactions Ledger
                </h3>
                <p class="text-xs text-slate-400 mt-0.5">Itemized transaction audit logs, platform commissions, and member billing</p>
            </div>

            <!-- Status Filter Pills -->
            <div class="flex flex-wrap items-center gap-1.5 bg-slate-100/80 p-1 rounded-xl border border-slate-200">
                <a href="{{ route('admin.financials') }}" class="px-3 py-1.5 rounded-lg text-xs font-bold transition {{ !request('status') ? 'bg-white text-slate-900 shadow-xs' : 'text-slate-500 hover:text-slate-900' }}">
                    All
                </a>
                <a href="{{ route('admin.financials', ['status' => 'approved']) }}" class="px-3 py-1.5 rounded-lg text-xs font-bold transition {{ request('status') === 'approved' ? 'bg-emerald-600 text-white shadow-xs' : 'text-slate-500 hover:text-slate-900' }}">
                    Approved
                </a>
                <a href="{{ route('admin.financials', ['status' => 'completed']) }}" class="px-3 py-1.5 rounded-lg text-xs font-bold transition {{ request('status') === 'completed' ? 'bg-blue-600 text-white shadow-xs' : 'text-slate-500 hover:text-slate-900' }}">
                    Completed
                </a>
                <a href="{{ route('admin.financials', ['status' => 'pending']) }}" class="px-3 py-1.5 rounded-lg text-xs font-bold transition {{ request('status') === 'pending' ? 'bg-amber-500 text-white shadow-xs' : 'text-slate-500 hover:text-slate-900' }}">
                    Pending
                </a>
                <a href="{{ route('admin.financials', ['status' => 'rejected']) }}" class="px-3 py-1.5 rounded-lg text-xs font-bold transition {{ request('status') === 'rejected' ? 'bg-rose-600 text-white shadow-xs' : 'text-slate-500 hover:text-slate-900' }}">
                    Rejected
                </a>
            </div>
        </div>

        <!-- Table Container -->
        <div class="overflow-x-auto">
            <table class="w-full text-left text-xs text-slate-600">
                <thead class="bg-slate-50/75 border-b border-slate-200 text-[11px] uppercase tracking-wider text-slate-400 font-extrabold">
                    <tr>
                        <th class="py-3.5 px-4 pl-6">ID & Reference</th>
                        <th class="py-3.5 px-4">Property & Host</th>
                        <th class="py-3.5 px-4">Renter</th>
                        <th class="py-3.5 px-4 text-right">Gross Amount</th>
                        <th class="py-3.5 px-4 text-right">5% Commission</th>
                        <th class="py-3.5 px-4 text-center">Status</th>
                        <th class="py-3.5 px-4 pr-6 text-right">Date</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100">
                    @forelse($transactions as $tx)
                        <tr class="hover:bg-slate-50/80 transition duration-150">
                            <!-- Booking ID -->
                            <td class="py-4 px-4 pl-6 font-mono font-bold text-slate-900">
                                #BK-{{ str_pad($tx->id, 5, '0', STR_PAD_LEFT) }}
                            </td>

                            <!-- Property & Host -->
                            <td class="py-4 px-4">
                                <div class="space-y-0.5 max-w-xs">
                                    <span class="font-bold text-slate-900 block truncate" title="{{ $tx->property->title ?? 'N/A' }}">
                                        {{ $tx->property->title ?? 'Property Deleted' }}
                                    </span>
                                    <span class="text-[11px] text-slate-400 flex items-center gap-1.5">
                                        <svg class="w-3.5 h-3.5 text-slate-400 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="1.75">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 6a3.75 3.75 0 11-7.5 0 3.75 3.75 0 017.5 0zM4.501 20.118a7.5 7.5 0 0114.998 0A17.933 17.933 0 0112 21.75c-2.676 0-5.216-.584-7.499-1.632z" />
                                        </svg>
                                        Host: {{ $tx->property->owner->name ?? 'N/A' }}
                                    </span>
                                </div>
                            </td>

                            <!-- Renter -->
                            <td class="py-4 px-4">
                                <div class="space-y-0.5">
                                    <span class="font-bold text-slate-800 block">{{ $tx->renter->name ?? 'Guest User' }}</span>
                                    <span class="text-[11px] text-slate-400">{{ $tx->renter->email ?? 'N/A' }}</span>
                                </div>
                            </td>

                            <!-- Gross Amount -->
                            <td class="py-4 px-4 text-right font-black text-slate-900">
                                ₹{{ number_format($tx->total_price, 2) }}
                                <div class="text-[10px] font-normal text-slate-400">Rent: ₹{{ number_format($tx->base_rent, 0) }}</div>
                            </td>

                            <!-- Commission -->
                            <td class="py-4 px-4 text-right font-bold text-emerald-700 bg-emerald-50/40">
                                +₹{{ number_format($tx->total_price * 0.05, 2) }}
                            </td>

                            <!-- Status Badge -->
                            <td class="py-4 px-4 text-center">
                                @if($tx->status === 'approved' || $tx->status === 'completed')
                                    <span class="inline-flex items-center px-2.5 py-1 rounded-full text-[10px] font-extrabold bg-emerald-50 text-emerald-700 border border-emerald-200">
                                        {{ ucfirst($tx->status) }}
                                    </span>
                                @elseif($tx->status === 'pending')
                                    <span class="inline-flex items-center px-2.5 py-1 rounded-full text-[10px] font-extrabold bg-amber-50 text-amber-700 border border-amber-200">
                                        Pending
                                    </span>
                                @elseif($tx->status === 'rejected' || $tx->status === 'cancelled')
                                    <span class="inline-flex items-center px-2.5 py-1 rounded-full text-[10px] font-extrabold bg-rose-50 text-rose-700 border border-rose-200">
                                        {{ ucfirst($tx->status) }}
                                    </span>
                                @else
                                    <span class="inline-flex items-center px-2.5 py-1 rounded-full text-[10px] font-extrabold bg-slate-100 text-slate-600">
                                        {{ ucfirst($tx->status) }}
                                    </span>
                                @endif
                            </td>

                            <!-- Date -->
                            <td class="py-4 px-4 pr-6 text-right text-slate-500 font-medium">
                                {{ $tx->created_at ? $tx->created_at->format('M d, Y') : 'N/A' }}
                                <div class="text-[10px] text-slate-400">{{ $tx->created_at ? $tx->created_at->format('h:i A') : '' }}</div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="py-12 text-center text-slate-400">
                                <div class="flex flex-col items-center justify-center space-y-2">
                                    <svg class="w-10 h-10 text-slate-300" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="1.5">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 14.25v-2.625a3.375 3.375 0 00-3.375-3.375h-1.5A1.125 1.125 0 0113.5 7.125v-1.5a3.375 3.375 0 00-3.375-3.375H8.25m0 12.75h7.5m-7.53-4.5h7.5m-7.5-4.5h7.5m-7.5-4.5h7.5m-7.5-4.5h7.5M5.625 3.75h12.75c.621 0 1.125.504 1.125 1.125v17.25c0 .621-.504 1.125-1.125 1.125H5.625a1.125 1.125 0 01-1.125-1.125V4.875c0-.621.504-1.125 1.125-1.125z" />
                                    </svg>
                                    <p class="text-xs font-semibold">No transaction records found matching the criteria.</p>
                                </div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <!-- Pagination Bar -->
        @if($transactions->hasPages())
        <div class="p-4 border-t border-slate-100 bg-slate-50/50">
            {{ $transactions->links() }}
        </div>
        @endif

    </div>

</div>

<!-- Chart.js Initialization Script -->
<script>
    document.addEventListener('DOMContentLoaded', function() {
        
        // 1. Monthly Revenue Timeline Chart
        const monthlyCtx = document.getElementById('monthlyRevenueChart');
        if (monthlyCtx) {
            const monthlyLabels = @json($monthlyLabels);
            const monthlyGrossData = @json($monthlyGross);
            const monthlyNetData = @json($monthlyNet);

            new Chart(monthlyCtx, {
                type: 'line',
                data: {
                    labels: monthlyLabels,
                    datasets: [
                        {
                            label: 'Gross Volume (₹)',
                            data: monthlyGrossData,
                            borderColor: '#3B82F6',
                            backgroundColor: 'rgba(59, 130, 246, 0.08)',
                            fill: true,
                            tension: 0.4,
                            borderWidth: 2.5,
                            pointBackgroundColor: '#3B82F6',
                            pointRadius: 4,
                            pointHoverRadius: 6,
                        },
                        {
                            label: 'Net Revenue 5% (₹)',
                            data: monthlyNetData,
                            borderColor: '#10B981',
                            backgroundColor: 'rgba(16, 185, 129, 0.15)',
                            fill: true,
                            tension: 0.4,
                            borderWidth: 2.5,
                            pointBackgroundColor: '#10B981',
                            pointRadius: 4,
                            pointHoverRadius: 6,
                        }
                    ]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    interaction: {
                        mode: 'index',
                        intersect: false,
                    },
                    plugins: {
                        legend: {
                            display: false
                        },
                        tooltip: {
                            backgroundColor: '#0A2540',
                            titleFont: { size: 12, family: 'Plus Jakarta Sans', weight: 'bold' },
                            bodyFont: { size: 11, family: 'Plus Jakarta Sans' },
                            padding: 10,
                            cornerRadius: 10,
                            callbacks: {
                                label: function(context) {
                                    return context.dataset.label + ': ₹' + Number(context.raw).toLocaleString('en-IN');
                                }
                            }
                        }
                    },
                    scales: {
                        x: {
                            grid: {
                                display: false
                            },
                            ticks: {
                                font: { size: 11, family: 'Plus Jakarta Sans' },
                                color: '#64748B'
                            }
                        },
                        y: {
                            grid: {
                                color: '#F1F5F9'
                            },
                            ticks: {
                                font: { size: 11, family: 'Plus Jakarta Sans' },
                                color: '#64748B',
                                callback: function(value) {
                                    return '₹' + (value >= 1000 ? (value / 1000) + 'k' : value);
                                }
                            }
                        }
                    }
                }
            });
        }

        // 2. Revenue Streams Donut Chart
        const streamCtx = document.getElementById('revenueStreamChart');
        if (streamCtx) {
            const commission = {{ $commissionRevenue }};
            const standardSub = {{ $standardUsersCount * 499 }};
            const unlimitedSub = {{ $unlimitedUsersCount * 999 }};
            
            // Fallback default values if totally 0 to draw nice preview
            const hasData = (commission + standardSub + unlimitedSub) > 0;
            const chartData = hasData ? [commission, standardSub, unlimitedSub] : [100, 50, 50];

            new Chart(streamCtx, {
                type: 'doughnut',
                data: {
                    labels: ['5% Brokerage Commission', 'Growth Plan (₹499)', 'Pro Unlimited (₹999)'],
                    datasets: [{
                        data: chartData,
                        backgroundColor: [
                            '#10B981',
                            '#8B5CF6',
                            '#3B82F6'
                        ],
                        borderWidth: 0,
                        hoverOffset: 6
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    cutout: '72%',
                    plugins: {
                        legend: {
                            display: false
                        },
                        tooltip: {
                            backgroundColor: '#0A2540',
                            titleFont: { size: 12, family: 'Plus Jakarta Sans', weight: 'bold' },
                            bodyFont: { size: 11, family: 'Plus Jakarta Sans' },
                            padding: 10,
                            cornerRadius: 10,
                            callbacks: {
                                label: function(context) {
                                    return context.label + ': ₹' + Number(context.raw).toLocaleString('en-IN');
                                }
                            }
                        }
                    }
                }
            });
        }
    });
</script>
@endsection
