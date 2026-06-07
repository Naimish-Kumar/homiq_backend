@extends('layouts.app')

@section('content')
<style>
    /* Premium Dashboard Styles */
    .dashboard-nav-item.active {
        background-color: #1e3a8a; /* Slate Blue primary */
        color: #ffffff;
    }
    .dashboard-nav-item:not(.active):hover {
        background-color: #f1f5f9;
        color: #0f172a;
    }
    .glass-card {
        background: rgba(255, 255, 255, 0.7);
        backdrop-filter: blur(8px);
        border: 1px solid rgba(226, 232, 240, 0.8);
    }
</style>

<div class="max-w-7xl mx-auto px-6 py-10">
    <!-- Feedback Messages -->


    @if($errors->any())
        <div class="mb-6 p-4 bg-rose-50 border border-rose-100 text-rose-800 text-xs font-bold rounded-2xl">
            <ul class="list-disc pl-4 space-y-1">
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <!-- Top Dashboard Header with Stats -->
    <div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-10">
        <!-- Stat Card 1 -->
        <div class="bg-white p-5 rounded-2xl border border-slate-100 shadow-sm flex items-center gap-4">
            <div class="p-3 bg-blue-50 text-steelAzure rounded-xl">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" /></svg>
            </div>
            <div>
                <span class="text-[10px] text-slate-400 font-bold uppercase tracking-wider block">My Bookings</span>
                <span class="text-xl font-extrabold text-slate-800">{{ $bookings->count() }} Active</span>
            </div>
        </div>

        <!-- Stat Card 2 -->
        <div class="bg-white p-5 rounded-2xl border border-slate-100 shadow-sm flex items-center gap-4">
            <div class="p-3 bg-emerald-50 text-seaGreen rounded-xl">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6" /></svg>
            </div>
            <div>
                <span class="text-[10px] text-slate-400 font-bold uppercase tracking-wider block">Listed Spaces</span>
                <span class="text-xl font-extrabold text-slate-800">{{ $currentListingsCount }} Active</span>
            </div>
        </div>

        <!-- Stat Card 3 -->
        <div class="bg-white p-5 rounded-2xl border border-slate-100 shadow-sm flex items-center gap-4">
            <div class="p-3 bg-amber-50 text-amber-600 rounded-xl">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01" /></svg>
            </div>
            <div>
                <span class="text-[10px] text-slate-400 font-bold uppercase tracking-wider block">Space Requests</span>
                <span class="text-xl font-extrabold text-slate-800">{{ $bookingRequests->count() }} Pending</span>
            </div>
        </div>

        <!-- Stat Card 4 -->
        <div class="bg-white p-5 rounded-2xl border border-slate-100 shadow-sm flex items-center gap-4">
            <div class="p-3 bg-slate-50 text-slate-600 rounded-xl">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z" /></svg>
            </div>
            <div>
                <span class="text-[10px] text-slate-400 font-bold uppercase tracking-wider block">Active Plan</span>
                <span class="text-xl font-extrabold text-slate-800 uppercase tracking-tight">{{ Auth::user()->subscription_plan }}</span>
            </div>
        </div>
    </div>

    <!-- Layout Grid: Sidebar Tabs + Content Area -->
    <div class="grid grid-cols-1 lg:grid-cols-12 gap-8">
        
        <!-- Sidebar Navigation (3 cols) -->
        <div class="lg:col-span-3 space-y-6">
            <div class="bg-white p-4 rounded-3xl border border-slate-100 shadow-sm flex flex-col gap-1.5">
                <button onclick="changeTab('overview')" id="nav-overview" class="dashboard-nav-item active flex items-center gap-3 px-4 py-3 rounded-xl text-xs font-bold transition duration-150 text-left">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6a2 2 0 012-2h2a2 2 0 012 2v4a2 2 0 01-2 2H6a2 2 0 01-2-2V6zM14 6a2 2 0 012-2h2a2 2 0 012 2v4a2 2 0 01-2 2h-2a2 2 0 01-2-2V6zM4 16a2 2 0 012-2h2a2 2 0 012 2v4a2 2 0 01-2 2H6a2 2 0 01-2-2v-4zM14 16a2 2 0 012-2h2a2 2 0 012 2v4a2 2 0 01-2 2h-2a2 2 0 01-2-2v-4z" /></svg>
                    Dashboard Overview
                </button>
                <button onclick="changeTab('bookings')" id="nav-bookings" class="dashboard-nav-item flex items-center gap-3 px-4 py-3 rounded-xl text-xs font-bold transition duration-150 text-left text-slate-500">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" /></svg>
                    My Bookings
                </button>
                <button onclick="changeTab('listings')" id="nav-listings" class="dashboard-nav-item flex items-center gap-3 px-4 py-3 rounded-xl text-xs font-bold transition duration-150 text-left text-slate-500">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6" /></svg>
                    My Listings & Creation
                </button>
                <button onclick="changeTab('requests')" id="nav-requests" class="dashboard-nav-item flex items-center gap-3 px-4 py-3 rounded-xl text-xs font-bold transition duration-150 text-left text-slate-500">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01" /></svg>
                    Space Requests
                </button>
                <button onclick="changeTab('settings')" id="nav-settings" class="dashboard-nav-item flex items-center gap-3 px-4 py-3 rounded-xl text-xs font-bold transition duration-150 text-left text-slate-500">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z" /><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" /></svg>
                    Profile & Security
                </button>
            </div>

            <!-- Compact Subscriptions Widget -->
            <div class="bg-gradient-to-tr from-slate-900 via-blue-950 to-slate-900 p-6 rounded-3xl text-white space-y-4">
                <span class="text-[9px] text-blue-300 font-bold uppercase tracking-widest block">Limits & Subscriptions</span>
                <div class="flex items-baseline gap-2">
                    <span class="text-2xl font-extrabold capitalize">{{ Auth::user()->subscription_plan }}</span>
                    <span class="text-xs text-blue-200">tier</span>
                </div>
                <div class="space-y-1.5">
                    <div class="flex justify-between text-[10px] text-blue-200">
                        <span>Listings created</span>
                        <span class="font-bold">{{ $currentListingsCount }} / {{ $limit == 999999 ? 'Unlimited' : $limit }}</span>
                    </div>
                    <div class="w-full bg-white/10 h-1.5 rounded-full overflow-hidden">
                        <div class="bg-blue-400 h-full rounded-full" style="width: {{ $limit == 999999 ? 100 : ($currentListingsCount / $limit) * 100 }}%"></div>
                    </div>
                </div>
                <a href="/pricing" class="block w-full py-2.5 bg-blue-600 hover:bg-blue-500 text-white text-center rounded-xl text-xs font-bold transition">
                    Upgrade Account
                </a>
            </div>
        </div>

        <!-- Content Area (9 cols) -->
        <div class="lg:col-span-9 bg-white p-8 border border-slate-100 rounded-3xl shadow-sm min-h-[500px]">
            
            <!-- TAB: OVERVIEW -->
            <div id="tabcontent-overview" class="space-y-8">
                <div>
                    <h2 class="text-xl font-bold text-slate-800">Dashboard Overview</h2>
                    <p class="text-xs text-slate-400 mt-1">Hello, {{ Auth::user()->name }}. Welcome to your dashboard hub.</p>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <!-- Bookings Preview -->
                    <div class="border border-slate-100 rounded-2xl p-5 space-y-3 bg-slate-50/20">
                        <div class="flex items-center justify-between">
                            <span class="text-xs font-extrabold text-slate-700 uppercase tracking-wider">Bookings Summary</span>
                            <button onclick="changeTab('bookings')" class="text-[10px] font-bold text-steelAzure hover:underline">View All</button>
                        </div>
                        @if($bookings->isEmpty())
                            <p class="text-xs text-slate-400 py-6 text-center">No active bookings found.</p>
                        @else
                            <div class="space-y-2.5">
                                @foreach($bookings->take(2) as $b)
                                    <div class="flex justify-between items-center bg-white p-3 rounded-xl border border-slate-100">
                                        <div>
                                            <span class="text-xs font-bold text-slate-800 block truncate max-w-[200px]">{{ $b->property->title }}</span>
                                            <span class="text-[9px] text-slate-400">{{ $b->check_in->format('Y-m-d') }} to {{ $b->check_out->format('Y-m-d') }}</span>
                                        </div>
                                        <span class="text-[9px] font-bold px-2 py-0.5 rounded-full {{ $b->status === 'approved' ? 'bg-emerald-50 text-emerald-600' : 'bg-amber-50 text-amber-600' }}">{{ $b->status }}</span>
                                    </div>
                                @endforeach
                            </div>
                        @endif
                    </div>

                    <!-- Listings Preview -->
                    <div class="border border-slate-100 rounded-2xl p-5 space-y-3 bg-slate-50/20">
                        <div class="flex items-center justify-between">
                            <span class="text-xs font-extrabold text-slate-700 uppercase tracking-wider">My Listings</span>
                            <button onclick="changeTab('listings')" class="text-[10px] font-bold text-steelAzure hover:underline">Manage</button>
                        </div>
                        @if($myListings->isEmpty())
                            <p class="text-xs text-slate-400 py-6 text-center">No listed spaces found.</p>
                        @else
                            <div class="space-y-2.5">
                                @foreach($myListings->take(2) as $l)
                                    <div class="flex justify-between items-center bg-white p-3 rounded-xl border border-slate-100">
                                        <div>
                                            <span class="text-xs font-bold text-slate-800 block truncate max-w-[200px]">{{ $l->title }}</span>
                                            <span class="text-[9px] text-slate-400">{{ $l->address }}</span>
                                        </div>
                                        <span class="text-xs font-bold text-steelAzure">{{ $l->formatted_price }}</span>
                                    </div>
                                @endforeach
                            </div>
                        @endif
                    </div>
                </div>

                <!-- Recent Activity/Guidance widget -->
                <div class="p-6 bg-slate-50 rounded-2xl flex items-start gap-4">
                    <div class="text-blue-500 mt-1">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>
                    </div>
                    <div class="space-y-1">
                        <h4 class="font-bold text-slate-800 text-sm">Need help listing your properties?</h4>
                        <p class="text-xs text-slate-500 leading-relaxed">Ensure you input descriptive titles and address lines. Approved spaces will automatically populate the HomiQ global search feed so seekers can contact you immediately.</p>
                    </div>
                </div>
            </div>

            <!-- TAB: BOOKINGS -->
            <div id="tabcontent-bookings" class="hidden space-y-6">
                <div>
                    <h2 class="text-xl font-bold text-slate-800">My Stay Bookings</h2>
                    <p class="text-xs text-slate-400 mt-1">Your reservation requests and active stays.</p>
                </div>

                @if ($bookings->isEmpty())
                    <div class="py-20 text-center text-slate-400 text-xs font-semibold bg-slate-50/50 rounded-2xl border border-dashed border-slate-100">
                        You have not made any stay reservations yet.
                    </div>
                @else
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        @foreach ($bookings as $b)
                            <div class="bg-white rounded-2xl border border-slate-100 p-5 space-y-4 hover:shadow-sm transition">
                                <div class="flex justify-between items-start gap-2">
                                    <div>
                                        <h4 class="font-bold text-slate-800 text-sm truncate max-w-[220px]">{{ $b->property->title }}</h4>
                                        <span class="text-[9px] font-bold text-slate-400 uppercase tracking-wider block mt-1">{{ $b->property->category }}</span>
                                    </div>
                                    <span class="px-2.5 py-0.5 rounded-full text-[9px] font-bold uppercase tracking-wider {{ $b->status === 'approved' ? 'bg-emerald-50 text-emerald-700' : ($b->status === 'pending' ? 'bg-amber-50 text-amber-700' : 'bg-rose-50 text-rose-700') }}">
                                        {{ $b->status }}
                                    </span>
                                </div>
                                <div class="border-t border-slate-50 pt-3 flex justify-between text-[10px] text-slate-500">
                                    <span>Check-in: <strong>{{ $b->check_in->format('Y-m-d') }}</strong></span>
                                    <span>Check-out: <strong>{{ $b->check_out->format('Y-m-d') }}</strong></span>
                                </div>
                                <div class="bg-slate-50 p-3 rounded-xl flex justify-between items-center text-xs">
                                    <span class="text-slate-400 font-semibold">Total Price Paid</span>
                                    <span class="font-extrabold text-slate-800">₹{{ number_format($b->total_price, 2) }}</span>
                                </div>
                            </div>
                        @endforeach
                    </div>
                @endif
            </div>

            <!-- TAB: LISTINGS -->
            <div id="tabcontent-listings" class="hidden space-y-8">
                <div class="flex flex-col md:flex-row md:items-center justify-between gap-4">
                    <div>
                        <h2 class="text-xl font-bold text-slate-800">My Listed Spaces</h2>
                        <p class="text-xs text-slate-400 mt-1">Manage listed spaces or add a new space instantly.</p>
                    </div>
                    @if ($currentListingsCount < $limit)
                        <button onclick="toggleAddSpaceForm()" class="px-4 py-2.5 bg-steelAzure hover:bg-steelAzure/95 text-white rounded-xl text-xs font-bold transition flex items-center gap-1.5">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 4v16m8-8H4" /></svg>
                            Add New Space
                        </button>
                    @endif
                </div>

                <!-- Add Space Modal Form Drawer -->
                <div id="add-space-form-wrapper" class="hidden p-6 bg-slate-50/50 border border-slate-100 rounded-2xl space-y-4">
                    <div class="flex justify-between items-center border-b border-slate-100 pb-3">
                        <span class="text-xs font-bold text-slate-700 uppercase tracking-wider">Submit New Listing</span>
                        <button onclick="toggleAddSpaceForm()" class="text-slate-400 hover:text-slate-600">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M6 18L18 6M6 6l12 12" /></svg>
                        </button>
                    </div>
                    <form action="/dashboard/listings" method="POST" enctype="multipart/form-data" class="space-y-4">
                        @csrf
                        <div>
                            <label class="block text-[10px] font-bold text-slate-400 uppercase mb-2">Property Title</label>
                            <input type="text" name="title" required placeholder="e.g. Cozy City Room"
                                class="w-full px-4 py-3 bg-white border border-slate-100 rounded-xl text-slate-800 focus:outline-none focus:border-steelAzure transition text-xs">
                        </div>

                        <div>
                            <label class="block text-[10px] font-bold text-slate-400 uppercase mb-2">Description</label>
                            <textarea name="description" required rows="3" placeholder="Describe the space features..."
                                class="w-full px-4 py-3 bg-white border border-slate-100 rounded-xl text-slate-800 focus:outline-none focus:border-steelAzure transition text-xs"></textarea>
                        </div>

                        <div class="space-y-2">
                            <div class="flex items-center justify-between">
                                <label class="block text-[10px] font-bold text-slate-400 uppercase">Address</label>
                                <button type="button" onclick="fetchCurrentLocationWeb()" class="flex items-center gap-1 text-[10px] font-extrabold text-steelAzure hover:text-steelAzure/80 transition bg-transparent border-0 p-0 cursor-pointer">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" /><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" /></svg>
                                    Fetch Current Location
                                </button>
                            </div>
                            <input type="text" name="address" id="listing-address" required placeholder="Street address, city"
                                class="w-full px-4 py-3 bg-white border border-slate-100 rounded-xl text-slate-800 focus:outline-none focus:border-steelAzure transition text-xs">
                            <span id="loc-loading" class="text-[10px] font-bold text-slate-450 hidden animate-pulse">Locating & Resolving Address...</span>
                        </div>

                        <div class="grid grid-cols-2 gap-4">
                            <div>
                                <label class="block text-[10px] font-bold text-slate-400 uppercase mb-2">Latitude</label>
                                <input type="number" step="any" name="latitude" id="listing-latitude" required placeholder="e.g. 28.6273"
                                    class="w-full px-4 py-3 bg-white border border-slate-100 rounded-xl text-slate-800 focus:outline-none focus:border-steelAzure transition text-xs">
                            </div>
                            <div>
                                <label class="block text-[10px] font-bold text-slate-400 uppercase mb-2">Longitude</label>
                                <input type="number" step="any" name="longitude" id="listing-longitude" required placeholder="e.g. 77.3714"
                                    class="w-full px-4 py-3 bg-white border border-slate-100 rounded-xl text-slate-800 focus:outline-none focus:border-steelAzure transition text-xs">
                            </div>
                        </div>

                        <!-- Hidden Country Input -->
                        <input type="hidden" name="country" id="listing-country" value="India">

                        <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                            <div>
                                <label class="block text-[10px] font-bold text-slate-400 uppercase mb-2">Price Amount</label>
                                <input type="number" name="price" required min="0" placeholder="100"
                                    class="w-full px-4 py-3 bg-white border border-slate-100 rounded-xl text-slate-800 focus:outline-none focus:border-steelAzure transition text-xs">
                            </div>
                            <div>
                                <label class="block text-[10px] font-bold text-slate-400 uppercase mb-2">Currency</label>
                                <select name="currency" required
                                    class="w-full px-4 py-3 bg-white border border-slate-100 rounded-xl text-slate-800 focus:outline-none focus:border-steelAzure transition text-xs">
                                    <option value="INR" selected>INR (₹)</option>
                                    <option value="USD">USD ($)</option>
                                    <option value="EUR">EUR (€)</option>
                                    <option value="GBP">GBP (£)</option>
                                </select>
                            </div>
                            <div>
                                <label class="block text-[10px] font-bold text-slate-400 uppercase mb-2">Pricing Frequency</label>
                                <select name="billing_frequency" required
                                    class="w-full px-4 py-3 bg-white border border-slate-100 rounded-xl text-slate-800 focus:outline-none focus:border-steelAzure transition text-xs">
                                    <option value="monthly" selected>Monthly</option>
                                    <option value="per_day">Per Day</option>
                                    <option value="hourly">Hourly</option>
                                </select>
                            </div>
                        </div>

                        <div class="grid grid-cols-3 gap-4">
                            <div>
                                <label class="block text-[10px] font-bold text-slate-400 uppercase mb-2">Category</label>
                                <select name="category" required
                                    class="w-full px-4 py-3 bg-white border border-slate-100 rounded-xl text-slate-800 focus:outline-none focus:border-steelAzure transition text-xs">
                                    @foreach ($categories as $cat)
                                        <option value="{{ $cat->name }}">{{ $cat->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div>
                                <label class="block text-[10px] font-bold text-slate-400 uppercase mb-2">Bedrooms</label>
                                <input type="number" name="bedrooms" required min="0" value="1"
                                    class="w-full px-4 py-3 bg-white border border-slate-100 rounded-xl text-slate-800 focus:outline-none focus:border-steelAzure transition text-xs">
                            </div>
                            <div>
                                <label class="block text-[10px] font-bold text-slate-400 uppercase mb-2">Bathrooms</label>
                                <input type="number" name="bathrooms" required min="0" value="1"
                                    class="w-full px-4 py-3 bg-white border border-slate-100 rounded-xl text-slate-800 focus:outline-none focus:border-steelAzure transition text-xs">
                            </div>
                        </div>

                        <!-- Key Options -->
                        <div class="bg-slate-50 p-4 rounded-xl border border-slate-100 space-y-2">
                            <label class="block text-[10px] font-bold text-slate-400 uppercase mb-1">Key Specifications</label>
                            <div class="grid grid-cols-3 gap-4">
                                <label class="flex items-center gap-2 text-xs font-semibold text-slate-600 cursor-pointer hover:text-slate-800">
                                    <input type="checkbox" name="is_furnished" value="1" class="rounded border-slate-200 text-steelAzure focus:ring-steelAzure">
                                    Furnished
                                </label>
                                <label class="flex items-center gap-2 text-xs font-semibold text-slate-600 cursor-pointer hover:text-slate-800">
                                    <input type="checkbox" name="has_parking" value="1" class="rounded border-slate-200 text-steelAzure focus:ring-steelAzure">
                                    Parking
                                </label>
                                <label class="flex items-center gap-2 text-xs font-semibold text-slate-600 cursor-pointer hover:text-slate-800">
                                    <input type="checkbox" name="is_pet_friendly" value="1" class="rounded border-slate-200 text-steelAzure focus:ring-steelAzure">
                                    Allows Pets
                                </label>
                            </div>
                        </div>

                        <!-- Dynamic Amenities checkboxes -->
                        <div>
                            <label class="block text-[10px] font-bold text-slate-400 uppercase mb-2">Included Amenities</label>
                            <div class="grid grid-cols-2 sm:grid-cols-4 gap-3 bg-white p-4 rounded-xl border border-slate-100">
                                @foreach ($amenities as $am)
                                    <label class="flex items-center gap-2 text-xs text-slate-600 cursor-pointer hover:text-slate-800">
                                        <input type="checkbox" name="amenities[]" value="{{ $am->name }}" class="rounded border-slate-200 text-steelAzure focus:ring-steelAzure">
                                        {{ $am->name }}
                                    </label>
                                @endforeach
                            </div>
                        </div>

                        <!-- Upload Space Photos (Multiple Files) -->
                        <div class="space-y-3">
                            <label class="block text-[10px] font-bold text-slate-400 uppercase mb-1">Upload Photos (Select Multiple, Max 5)</label>
                            
                            <!-- Hidden File Input for browser selection -->
                            <input type="file" id="property-images-picker" multiple accept="image/*" class="hidden">
                            
                            <!-- Real Hidden Input submitted to backend -->
                            <input type="file" name="images[]" id="property-images-submit" multiple class="hidden" required>
                            
                            <!-- Custom Drag & Drop Area -->
                            <div id="image-upload-zone" class="border-2 border-dashed border-slate-200 hover:border-steelAzure rounded-xl p-5 text-center cursor-pointer transition bg-white/50 hover:bg-slate-50/50 flex flex-col items-center justify-center space-y-2">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8 text-slate-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                </svg>
                                <span class="text-xs font-bold text-slate-600">Drag & drop photos here or click to browse</span>
                                <span class="text-[9px] text-slate-400 font-bold">Select files multiple times if needed (Max 5 total, up to 4MB each)</span>
                            </div>

                            <!-- Image Preview Grid -->
                            <div id="image-previews-container" class="grid grid-cols-2 sm:grid-cols-5 gap-3 hidden">
                                <!-- Previews will be dynamically appended here -->
                            </div>

                            <p id="image-error" class="text-rose-600 text-[10px] font-bold mt-1.5 hidden">You can upload a maximum of 5 images.</p>
                        </div>

                        <button type="submit" class="w-full py-3.5 bg-steelAzure hover:bg-steelAzure/95 text-white font-bold rounded-xl shadow-md transition duration-150 text-xs">
                            Submit Property Space Listing
                        </button>
                    </form>
                </div>

                <!-- Active Listings Grid -->
                @if ($myListings->isEmpty())
                    <div class="py-20 text-center text-slate-400 text-xs font-semibold bg-slate-50/50 rounded-2xl border border-dashed border-slate-100">
                        You have not listed any property spaces yet.
                    </div>
                @else
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        @foreach ($myListings as $listing)
                            <div class="bg-white rounded-2xl border border-slate-100 p-5 space-y-4 hover:shadow-sm transition">
                                <div class="flex justify-between items-start gap-2">
                                    <div>
                                        <h4 class="font-bold text-slate-800 text-sm truncate max-w-[200px]">{{ $listing->title }}</h4>
                                        <span class="text-[9px] text-slate-400 font-bold uppercase tracking-wider block mt-1">{{ $listing->address }}</span>
                                    </div>
                                    <span class="px-2.5 py-0.5 rounded-full text-[8px] font-extrabold uppercase tracking-wider {{ $listing->status === 'approved' ? 'bg-emerald-50 text-emerald-700' : 'bg-amber-50 text-amber-700' }}">
                                        {{ $listing->status }}
                                    </span>
                                </div>
                                <div class="bg-slate-50/50 p-3 rounded-xl flex justify-between items-center text-xs">
                                    <span class="text-slate-400 font-semibold">Listed Price</span>
                                    <span class="font-extrabold text-slate-800">{{ $listing->formatted_price }}</span>
                                </div>
                                <div class="flex justify-between items-center border-t border-slate-50 pt-3">
                                    <form action="/dashboard/listings/{{ $listing->id }}/toggle-featured" method="POST" class="m-0">
                                        @csrf
                                        @if($listing->is_featured)
                                            <button type="submit" class="px-3 py-1.5 bg-amber-500 hover:bg-amber-600 text-white rounded-lg font-bold text-[9px] uppercase shadow-sm transition flex items-center gap-1">
                                                ★ Featured
                                            </button>
                                        @else
                                            <button type="submit" class="px-3 py-1.5 bg-slate-100 hover:bg-slate-200 text-slate-650 rounded-lg font-bold text-[9px] uppercase transition flex items-center gap-1">
                                                ☆ Make Featured
                                            </button>
                                        @endif
                                    </form>
                                    <a href="/properties/{{ $listing->id }}" class="text-[10px] font-bold text-steelAzure hover:underline">View Page &rarr;</a>
                                </div>
                            </div>
                        @endforeach
                    </div>
                @endif
            </div>

            <!-- TAB: REQUESTS -->
            <div id="tabcontent-requests" class="hidden space-y-6">
                <div>
                    <h2 class="text-xl font-bold text-slate-800">Reservation Requests on My Spaces</h2>
                    <p class="text-xs text-slate-400 mt-1">Review requests sent by guests wanting to book your spaces.</p>
                </div>

                @if ($bookingRequests->isEmpty())
                    <div class="py-20 text-center text-slate-400 text-xs font-semibold bg-slate-50/50 rounded-2xl border border-dashed border-slate-100">
                        No incoming stay booking requests on your spaces.
                    </div>
                @else
                    <div class="space-y-4">
                        @foreach ($bookingRequests as $req)
                            <div class="p-5 bg-white rounded-2xl border border-slate-100 flex flex-col md:flex-row items-baseline md:items-center justify-between gap-4 hover:shadow-sm transition">
                                <div>
                                    <h4 class="font-bold text-slate-800 text-sm">{{ $req->property->title }}</h4>
                                    <span class="text-[9px] text-slate-400 font-bold block mt-1">Guest: {{ $req->renter->name }} ({{ $req->renter->email }})</span>
                                    <p class="text-[10px] text-slate-500 mt-1.5 font-medium">Dates: {{ $req->check_in->format('Y-m-d') }} to {{ $req->check_out->format('Y-m-d') }}</p>
                                </div>
                                <div class="text-left md:text-right space-y-2 w-full md:w-auto flex flex-col items-start md:items-end">
                                    <span class="font-extrabold text-slate-800 text-sm block">{{ $req->property->currency_symbol }}{{ number_format($req->total_price, 2) }}</span>
                                    
                                    @if ($req->status === 'pending')
                                        <div class="flex gap-2 mt-1 justify-end">
                                            <form action="/dashboard/reservations/{{ $req->id }}/status" method="POST" class="m-0">
                                                @csrf
                                                <input type="hidden" name="status" value="approved">
                                                <button type="submit" class="px-3 py-1.5 bg-emerald-500 hover:bg-emerald-600 text-white rounded-lg font-bold text-[9px] uppercase shadow-sm transition">Approve</button>
                                            </form>
                                            <form action="/dashboard/reservations/{{ $req->id }}/status" method="POST" class="m-0">
                                                @csrf
                                                <input type="hidden" name="status" value="rejected">
                                                <button type="submit" class="px-3 py-1.5 bg-rose-500 hover:bg-rose-600 text-white rounded-lg font-bold text-[9px] uppercase shadow-sm transition">Reject</button>
                                            </form>
                                        </div>
                                    @else
                                        <span class="inline-block px-2.5 py-0.5 rounded-full text-[8px] font-extrabold uppercase tracking-wider {{ $req->status === 'approved' ? 'bg-emerald-50 text-emerald-700' : ($req->status === 'pending' ? 'bg-amber-50 text-amber-700' : 'bg-rose-50 text-rose-700') }}">
                                            {{ $req->status }}
                                        </span>
                                    @endif
                                </div>
                            </div>
                        @endforeach
                    </div>
                @endif
            </div>

            <!-- TAB: SETTINGS & SECURITY -->
            <div id="tabcontent-settings" class="hidden space-y-8">
                <div>
                    <h2 class="text-xl font-bold text-slate-800">Profile & Security Settings</h2>
                    <p class="text-xs text-slate-400 mt-1">Update profile information and keep your credentials secure.</p>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                    <!-- Profile Form -->
                    <div class="border border-slate-100 rounded-2xl p-6 space-y-4 bg-slate-50/20">
                        <h3 class="text-xs font-extrabold text-slate-700 uppercase tracking-wider mb-2">Update Account Profile</h3>
                        <form action="/dashboard/profile" method="POST" enctype="multipart/form-data" class="space-y-4">
                            @csrf
                            @if(Auth::user()->profile_photo)
                                <div class="flex items-center gap-3 mb-2">
                                    <img src="{{ Auth::user()->profile_photo }}" class="w-12 h-12 rounded-full object-cover border border-slate-100" alt="Profile picture">
                                    <span class="text-[10px] text-slate-400 font-semibold">Current Profile Photo</span>
                                </div>
                            @endif
                            <div>
                                <label class="block text-[10px] font-bold text-slate-400 uppercase mb-2">Profile Photo</label>
                                <input type="file" name="profile_photo" 
                                       class="w-full px-4 py-2.5 bg-white border border-slate-100 rounded-xl text-slate-800 focus:outline-none focus:border-steelAzure transition text-xs">
                            </div>

                            <div>
                                <label class="block text-[10px] font-bold text-slate-400 uppercase mb-2">Full Name</label>
                                <input type="text" name="name" required value="{{ Auth::user()->name }}"
                                       class="w-full px-4 py-3 bg-white border border-slate-100 rounded-xl text-slate-800 focus:outline-none focus:border-steelAzure transition text-xs">
                            </div>

                            <div>
                                <label class="block text-[10px] font-bold text-slate-400 uppercase mb-2">Email Address</label>
                                <input type="email" name="email" required value="{{ Auth::user()->email }}"
                                       class="w-full px-4 py-3 bg-white border border-slate-100 rounded-xl text-slate-800 focus:outline-none focus:border-steelAzure transition text-xs">
                            </div>

                            <div>
                                <label class="block text-[10px] font-bold text-slate-400 uppercase mb-2">Phone Number</label>
                                <input type="text" name="phone" required value="{{ Auth::user()->phone }}"
                                       class="w-full px-4 py-3 bg-white border border-slate-100 rounded-xl text-slate-800 focus:outline-none focus:border-steelAzure transition text-xs">
                            </div>

                            <button type="submit" class="w-full py-3.5 bg-steelAzure hover:bg-steelAzure/95 text-white font-bold rounded-xl shadow-md transition duration-150 text-xs">
                                Save Profile Info
                            </button>
                        </form>
                    </div>

                    <!-- Password Form -->
                    <div class="border border-slate-100 rounded-2xl p-6 space-y-4 bg-slate-50/20">
                        <h3 class="text-xs font-extrabold text-slate-700 uppercase tracking-wider mb-2">Change Password</h3>
                        <form action="/dashboard/password" method="POST" class="space-y-4">
                            @csrf
                            <div>
                                <label class="block text-[10px] font-bold text-slate-400 uppercase mb-2">Current Password</label>
                                <input type="password" name="current_password" required placeholder="••••••••"
                                       class="w-full px-4 py-3 bg-white border border-slate-100 rounded-xl text-slate-800 focus:outline-none focus:border-steelAzure transition text-xs">
                            </div>

                            <div>
                                <label class="block text-[10px] font-bold text-slate-400 uppercase mb-2">New Password</label>
                                <input type="password" name="new_password" required placeholder="Min. 8 characters"
                                       class="w-full px-4 py-3 bg-white border border-slate-100 rounded-xl text-slate-800 focus:outline-none focus:border-steelAzure transition text-xs">
                            </div>

                            <div>
                                <label class="block text-[10px] font-bold text-slate-400 uppercase mb-2">Confirm New Password</label>
                                <input type="password" name="new_password_confirmation" required placeholder="Confirm password"
                                       class="w-full px-4 py-3 bg-white border border-slate-100 rounded-xl text-slate-800 focus:outline-none focus:border-steelAzure transition text-xs">
                            </div>

                            <button type="submit" class="w-full py-3.5 bg-slate-800 hover:bg-slate-900 text-white font-bold rounded-xl shadow-md transition duration-150 text-xs">
                                Change Password
                            </button>
                        </form>
                    </div>
                </div>
            </div>

        </div>
    </div>
</div>

<script>
    // Tab switching engine
    function changeTab(tabId) {
        // Hide all contents
        const contents = ['overview', 'bookings', 'listings', 'requests', 'settings'];
        contents.forEach(id => {
            const el = document.getElementById('tabcontent-' + id);
            if (el) el.classList.add('hidden');
            
            const btn = document.getElementById('nav-' + id);
            if (btn) {
                btn.classList.remove('active', 'text-white');
                btn.classList.add('text-slate-500');
            }
        });

        // Show selected content
        const targetEl = document.getElementById('tabcontent-' + tabId);
        if (targetEl) targetEl.classList.remove('hidden');

        // Select active link
        const activeBtn = document.getElementById('nav-' + tabId);
        if (activeBtn) {
            activeBtn.classList.add('active', 'text-white');
            activeBtn.classList.remove('text-slate-500');
        }
        
        localStorage.setItem('active_dashboard_tab', tabId);
    }

    // Toggle add space form visibility
    function toggleAddSpaceForm() {
        const el = document.getElementById('add-space-form-wrapper');
        if (el) el.classList.toggle('hidden');
    }

    // Multiple Images Uploader Logic
    let selectedImageFiles = [];

    const uploadZone = document.getElementById('image-upload-zone');
    const imagePicker = document.getElementById('property-images-picker');
    const imageSubmitInput = document.getElementById('property-images-submit');
    const previewsContainer = document.getElementById('image-previews-container');
    const imageError = document.getElementById('image-error');

    if (uploadZone && imagePicker) {
        // Trigger file input click when clicking the zone
        uploadZone.addEventListener('click', () => imagePicker.click());

        // Drag and drop handlers
        ['dragenter', 'dragover'].forEach(eventName => {
            uploadZone.addEventListener(eventName, (e) => {
                e.preventDefault();
                uploadZone.classList.add('border-steelAzure', 'bg-slate-50/50');
            }, false);
        });

        ['dragleave', 'drop'].forEach(eventName => {
            uploadZone.addEventListener(eventName, (e) => {
                e.preventDefault();
                uploadZone.classList.remove('border-steelAzure', 'bg-slate-50/50');
            }, false);
        });

        uploadZone.addEventListener('drop', (e) => {
            const dt = e.dataTransfer;
            const files = dt.files;
            handleImageFilesSelection(files);
        });

        imagePicker.addEventListener('change', (e) => {
            handleImageFilesSelection(e.target.files);
        });
    }

    function handleImageFilesSelection(files) {
        imageError.classList.add('hidden');
        
        if (selectedImageFiles.length + files.length > 5) {
            imageError.innerText = 'You can upload a maximum of 5 images.';
            imageError.classList.remove('hidden');
            return;
        }

        for (let i = 0; i < files.length; i++) {
            const file = files[i];
            
            // Check type
            if (!file.type.match('image.*')) {
                imageError.innerText = 'Only image files are allowed.';
                imageError.classList.remove('hidden');
                continue;
            }

            // Check size (max 4MB)
            if (file.size > 4 * 1024 * 1024) {
                imageError.innerText = 'Each image must be smaller than 4MB.';
                imageError.classList.remove('hidden');
                continue;
            }

            selectedImageFiles.push(file);
        }

        updateImagePreviews();
        updateHiddenSubmitInput();
        
        // Reset picker so the same file can be chosen again
        imagePicker.value = '';
    }

    function updateImagePreviews() {
        if (!previewsContainer) return;

        previewsContainer.innerHTML = '';
        
        if (selectedImageFiles.length === 0) {
            previewsContainer.classList.add('hidden');
            return;
        }

        previewsContainer.classList.remove('hidden');

        selectedImageFiles.forEach((file, index) => {
            const reader = new FileReader();
            
            // Create a preview item wrapper
            const itemWrapper = document.createElement('div');
            itemWrapper.className = 'relative aspect-square bg-slate-100 rounded-xl overflow-hidden border border-slate-200 group';
            
            // Image element
            const imgEl = document.createElement('img');
            imgEl.className = 'w-full h-full object-cover';
            itemWrapper.appendChild(imgEl);

            // Delete badge / overlay
            const deleteBtn = document.createElement('button');
            deleteBtn.type = 'button';
            deleteBtn.className = 'absolute top-1 right-1 bg-rose-600 text-white rounded-full p-1 opacity-90 hover:opacity-100 transition shadow-md cursor-pointer border-0';
            deleteBtn.innerHTML = `<svg xmlns="http://www.w3.org/2050/svg" class="h-3 w-3" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M6 18L18 6M6 6l12 12" /></svg>`;
            deleteBtn.onclick = (e) => {
                e.stopPropagation();
                removeSelectedImage(index);
            };
            itemWrapper.appendChild(deleteBtn);

            reader.onload = (e) => {
                imgEl.src = e.target.result;
            };
            
            reader.readAsDataURL(file);
            previewsContainer.appendChild(itemWrapper);
        });
    }

    function removeSelectedImage(index) {
        selectedImageFiles.splice(index, 1);
        updateImagePreviews();
        updateHiddenSubmitInput();
    }

    function updateHiddenSubmitInput() {
        if (!imageSubmitInput) return;

        // Use DataTransfer API to assign Javascript File objects back to hidden input
        const dataTransfer = new DataTransfer();
        selectedImageFiles.forEach(file => {
            dataTransfer.items.add(file);
        });
        
        imageSubmitInput.files = dataTransfer.files;
    }

    // Fetch browser location and reverse geocode
    function fetchCurrentLocationWeb() {
        const addressInput = document.getElementById('listing-address');
        const latInput = document.getElementById('listing-latitude');
        const lngInput = document.getElementById('listing-longitude');
        const loadingSpan = document.getElementById('loc-loading');

        if (navigator.geolocation) {
            loadingSpan.classList.remove('hidden');
            navigator.geolocation.getCurrentPosition((position) => {
                const lat = position.coords.latitude;
                const lng = position.coords.longitude;
                latInput.value = lat;
                lngInput.value = lng;

                // Reverse geocode via OpenStreetMap Nominatim
                fetch(`https://nominatim.openstreetmap.org/reverse?lat=${lat}&lon=${lng}&format=json`)
                    .then(response => response.json())
                    .then(data => {
                        loadingSpan.classList.add('hidden');
                        if (data && data.display_name) {
                            addressInput.value = data.display_name;
                        }
                        if (data && data.address && data.address.country) {
                            const countryInput = document.getElementById('listing-country');
                            if (countryInput) {
                                countryInput.value = data.address.country;
                            }
                        }
                    })
                    .catch(err => {
                        console.error('Error resolving address:', err);
                        loadingSpan.classList.add('hidden');
                    });
            }, (error) => {
                alert('Failed to access location: ' + error.message);
                loadingSpan.classList.add('hidden');
            });
        } else {
            alert('Geolocation not supported by this browser.');
        }
    }

    // Restore last active tab on page load
    document.addEventListener('DOMContentLoaded', () => {
        const activeTab = localStorage.getItem('active_dashboard_tab') || 'overview';
        changeTab(activeTab);
    });
</script>
@endsection
