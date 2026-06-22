@extends('admin.layout')

@section('page_title', '')

@section('content')
<!-- Header Section (Donezo Style) -->
<div class="flex flex-col md:flex-row md:items-center justify-between gap-4 mb-8 relative z-10">
    <div>
        <h1 class="text-2xl font-black text-slate-800">Dashboard</h1>
        <p class="text-xs text-slate-400 font-semibold mt-1">Manage listings, approve reservation requests, and moderate user accounts with ease.</p>
    </div>
    <div class="flex gap-2.5">
        <a href="/admin/properties?status=pending" class="px-4 py-2.5 bg-donezoGreen hover:bg-emerald-800 text-white rounded-lg text-xs font-bold transition shadow-sm flex items-center gap-1.5">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 4v16m8-8H4" />
            </svg>
            Moderate Spaces
        </a>
        <a href="/admin/users" class="px-4 py-2.5 bg-white hover:bg-slate-50 text-slate-700 rounded-lg text-xs font-bold transition border border-slate-200 shadow-sm flex items-center gap-1.5">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z" />
            </svg>
            User Database
        </a>
    </div>
</div>

<!-- Donezo-Style Metrics Grid -->
<div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-8 relative z-10">
    <!-- Card 1: Platform Revenue (Solid Green) -->
    <div class="bg-donezoGreen p-5 rounded-2xl text-white shadow-sm flex flex-col justify-between h-36 border border-emerald-800 relative group overflow-hidden">
        <!-- SVG background accent line -->
        <div class="absolute inset-0 bg-gradient-to-tr from-transparent to-white/5 pointer-events-none"></div>
        <div class="flex items-center justify-between z-10">
            <span class="text-[10px] font-bold text-emerald-250 uppercase tracking-widest block">Total Revenue</span>
            <div class="h-7 w-7 bg-white rounded-full flex items-center justify-center text-donezoGreen shadow group-hover:rotate-45 transition duration-300 cursor-pointer">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M14 5l7 7m0 0l-7 7m7-7H3" />
                </svg>
            </div>
        </div>
        <div class="mt-2 z-10">
            <span class="text-3xl font-extrabold block">₹{{ number_format($totalRevenue, 2) }}</span>
            <span class="text-[9px] text-emerald-200 bg-emerald-800/60 border border-emerald-700/50 px-2 py-0.5 rounded-md mt-2 inline-block font-semibold">
                +5% Platform commission active
            </span>
        </div>
    </div>

    <!-- Card 2: Total Members -->
    <div class="bg-white p-5 rounded-2xl border border-slate-100 shadow-sm flex flex-col justify-between h-36 relative group">
        <div class="flex items-center justify-between">
            <span class="text-[10px] font-bold text-slate-400 uppercase tracking-widest block">Total Members</span>
            <div class="h-7 w-7 border border-slate-200 hover:bg-slate-50 rounded-full flex items-center justify-center text-slate-600 shadow-sm group-hover:rotate-45 transition duration-300 cursor-pointer">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M14 5l7 7m0 0l-7 7m7-7H3" />
                </svg>
            </div>
        </div>
        <div class="mt-2">
            <span class="text-3xl font-extrabold text-slate-800 block">{{ $totalUsers }}</span>
            <span class="text-[9px] text-slate-400 bg-slate-50 border border-slate-100 px-2 py-0.5 rounded-md mt-2 inline-block font-semibold">
                Unified customer profiles
            </span>
        </div>
    </div>

    <!-- Card 3: Total Bookings -->
    <div class="bg-white p-5 rounded-2xl border border-slate-100 shadow-sm flex flex-col justify-between h-36 relative group">
        <div class="flex items-center justify-between">
            <span class="text-[10px] font-bold text-slate-400 uppercase tracking-widest block">Total Bookings</span>
            <div class="h-7 w-7 border border-slate-200 hover:bg-slate-50 rounded-full flex items-center justify-center text-slate-600 shadow-sm group-hover:rotate-45 transition duration-300 cursor-pointer">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M14 5l7 7m0 0l-7 7m7-7H3" />
                </svg>
            </div>
        </div>
        <div class="mt-2">
            <span class="text-3xl font-extrabold text-slate-800 block">{{ $totalBookings }}</span>
            <span class="text-[9px] text-slate-400 bg-slate-50 border border-slate-100 px-2 py-0.5 rounded-md mt-2 inline-block font-semibold">
                Approved rental contracts
            </span>
        </div>
    </div>

    <!-- Card 4: Total Properties -->
    <div class="bg-white p-5 rounded-2xl border border-slate-100 shadow-sm flex flex-col justify-between h-36 relative group">
        <div class="flex items-center justify-between">
            <span class="text-[10px] font-bold text-slate-400 uppercase tracking-widest block">Total Properties</span>
            <div class="h-7 w-7 border border-slate-200 hover:bg-slate-50 rounded-full flex items-center justify-center text-slate-600 shadow-sm group-hover:rotate-45 transition duration-300 cursor-pointer">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M14 5l7 7m0 0l-7 7m7-7H3" />
                </svg>
            </div>
        </div>
        <div class="mt-2">
            <span class="text-3xl font-extrabold text-slate-800 block">{{ $totalProperties }}</span>
            <span class="text-[9px] text-slate-400 bg-slate-50 border border-slate-100 px-2 py-0.5 rounded-md mt-2 inline-block font-semibold">
                Live search index directory
            </span>
        </div>
    </div>
</div>

<!-- Middle Section: Analytics Chart + Reminders + Recent Listings -->
<div class="grid grid-cols-1 lg:grid-cols-12 gap-6 mb-8 relative z-10">
    <!-- Chart Column (5 cols) -->
    <div class="bg-white p-6 rounded-2xl border border-slate-100 shadow-sm lg:col-span-5 flex flex-col justify-between min-h-[300px]">
        <div>
            <h3 class="text-xs font-bold text-slate-800 uppercase tracking-widest">Listing Volume</h3>
            <p class="text-[10px] text-slate-400 mt-1 font-semibold">Weekly listings review statistics</p>
        </div>

        <!-- Custom CSS bar chart matching reference layout style -->
        <div class="flex items-end justify-between h-36 px-4">
            @foreach ($listingVolume as $vol)
                <div class="flex flex-col items-center gap-2">
                    @if ($vol['count'] == 0)
                        <div class="w-7 bg-slate-100 rounded-full h-4 relative overflow-hidden" style="background-image: repeating-linear-gradient(45deg, #cbd5e1, #cbd5e1 3px, #e2e8f0 3px, #e2e8f0 6px)" title="0 listings"></div>
                    @else
                        <div class="w-7 rounded-full relative {{ $vol['is_max'] ? 'bg-[#1e483b]' : 'bg-emerald-400' }}" style="height: {{ $vol['height'] }}px;" title="{{ $vol['count'] }} listings">
                            @if ($vol['is_max'])
                                <span class="absolute -top-6 left-1/2 -translate-x-1/2 bg-slate-900 text-white font-extrabold text-[8px] px-1.5 py-0.5 rounded-sm">{{ $vol['count'] }}</span>
                            @endif
                        </div>
                    @endif
                    <span class="text-[10px] font-bold text-slate-400">{{ $vol['letter'] }}</span>
                </div>
            @endforeach
        </div>
    </div>

    <!-- Reminders Column (3 cols) -->
    <div class="bg-white p-6 rounded-2xl border border-slate-100 shadow-sm lg:col-span-3 flex flex-col justify-between min-h-[300px]">
        <div>
            <h3 class="text-xs font-bold text-slate-800 uppercase tracking-widest">Reminders</h3>
            <span class="text-[9px] text-slate-400 font-bold tracking-widest block mt-1 uppercase">Pending Alerts</span>
        </div>

        <div class="space-y-3.5">
            <div class="border-b border-slate-50 pb-2">
                <h4 class="font-extrabold text-donezoGreen text-xs leading-snug">Review Pending Listings</h4>
                <p class="text-[10px] text-slate-500 mt-1 leading-normal">There are <strong class="text-slate-800 font-bold">{{ $pendingProperties }}</strong> properties pending review.</p>
            </div>
            <div>
                <h4 class="font-extrabold text-amber-600 text-xs leading-snug">Pending KYC Verifications</h4>
                <p class="text-[10px] text-slate-500 mt-1 leading-normal">There are <strong class="text-slate-800 font-bold">{{ $pendingKycCount }}</strong> KYC uploads awaiting moderation.</p>
            </div>
        </div>

        <a href="/admin/properties?status=pending" class="block w-full py-3 bg-donezoGreen hover:bg-emerald-800 text-white text-center rounded-xl text-[10px] font-extrabold transition shadow-sm flex items-center justify-center gap-1.5">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M14.752 11.168l-3.197-2.132A1 1 0 0010 9.87v4.263a1 1 0 001.555.832l3.197-2.132a1 1 0 000-1.664z" />
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
            </svg>
            Start Moderating
        </a>
    </div>

    <!-- Recent Reservation Log (4 cols) -->
    <div class="bg-white p-6 rounded-2xl border border-slate-100 shadow-sm lg:col-span-4 flex flex-col justify-between min-h-[300px]">
        <div class="flex items-center justify-between border-b border-slate-50 pb-3 mb-2.5">
            <span class="text-xs font-bold text-slate-850 uppercase tracking-widest">Recent Activity</span>
            <span class="px-2 py-0.5 bg-donezoLightGreen text-donezoGreen border border-emerald-100 rounded-md text-[8px] font-extrabold uppercase">Live Feed</span>
        </div>

        @if ($recentBookings->isEmpty())
            <p class="text-xs text-slate-400 py-12 text-center font-bold">No active reservations.</p>
        @else
            <div class="space-y-3.5 flex-1 overflow-y-auto pr-1">
                @foreach ($recentBookings->take(4) as $booking)
                    <div class="flex items-center justify-between border-b border-slate-50 pb-2.5 last:border-0 last:pb-0">
                        <div class="overflow-hidden pr-2">
                            <span class="text-xs font-black text-slate-800 block truncate leading-none mb-1">{{ $booking->property->title }}</span>
                            <span class="text-[9px] text-slate-400 block truncate leading-none">Renter: {{ $booking->renter->name }}</span>
                        </div>
                        <div class="text-right flex-shrink-0">
                            <span class="text-xs font-black text-slate-800 block mb-0.5">₹{{ number_format($booking->total_price, 0) }}</span>
                            <span class="text-[8px] px-1.5 py-0.5 rounded font-extrabold uppercase tracking-wider {{ $booking->status === 'approved' ? 'bg-emerald-50 text-emerald-700' : 'bg-amber-50 text-amber-700' }}">
                                {{ $booking->status }}
                            </span>
                        </div>
                    </div>
                @endforeach
            </div>
        @endif
    </div>
</div>

<!-- Bottom Section: Active Users + Project Progress + Time Tracker -->
<div class="grid grid-cols-1 lg:grid-cols-12 gap-6 relative z-10">
    <!-- Active Users list (5 cols) -->
    <div class="bg-white p-6 rounded-2xl border border-slate-100 shadow-sm lg:col-span-5 flex flex-col justify-between min-h-[300px]">
        <div class="flex items-center justify-between border-b border-slate-50 pb-3 mb-2.5">
            <span class="text-xs font-bold text-slate-800 uppercase tracking-widest">Active Administrators</span>
            <a href="/admin/users" class="text-[10px] font-bold text-donezoGreen hover:underline">View database</a>
        </div>

        <div class="space-y-3.5">
            @foreach ($latestUsers as $user)
                <div class="flex items-center justify-between bg-slate-50/50 p-3 rounded-xl border border-slate-100">
                    <div class="flex items-center gap-3">
                        <div class="h-8.5 w-8.5 rounded-lg {{ $user->is_admin ? 'bg-donezoLightGreen text-[#187053]' : 'bg-slate-100 text-slate-500' }} flex items-center justify-center font-bold text-xs">
                            {{ $user->initials }}
                        </div>
                        <div>
                            <h4 class="text-xs font-bold text-slate-800">{{ $user->name }}</h4>
                            <span class="text-[9px] text-slate-400 block mt-0.5">{{ $user->role_desc }}</span>
                        </div>
                    </div>
                    <span class="px-2 py-0.5 {{ $user->badge_class }} border rounded-md text-[8px] font-extrabold uppercase">{{ $user->display_role }}</span>
                </div>
            @endforeach
        </div>
    </div>

    <!-- Project Progress Half Donut SVG Gauge (3 cols) -->
    <div class="bg-white p-6 rounded-2xl border border-slate-100 shadow-sm lg:col-span-3 flex flex-col justify-between min-h-[300px]">
        <div>
            <h3 class="text-xs font-bold text-slate-800 uppercase tracking-widest">Moderation Progress</h3>
            <span class="text-[9px] text-slate-400 font-bold block mt-1 uppercase">Directory Ratio</span>
        </div>

        <!-- Custom SVG Half Donut Chart matching layout -->
        <div class="flex flex-col items-center justify-center relative mt-2">
            @php
                $total = max(1, $totalProperties);
                $approvedPercentage = round(($approvedProperties / $total) * 100);
            @endphp
            <svg class="w-32 h-20" viewBox="0 0 100 60">
                <!-- Background gray stroke path -->
                <path d="M 10 50 A 40 40 0 0 1 90 50" fill="none" stroke="#e2e8f0" stroke-width="12" stroke-linecap="round"/>
                <!-- Approved green stroke path -->
                <path d="M 10 50 A 40 40 0 0 1 90 50" fill="none" stroke="#187053" stroke-width="12" stroke-linecap="round"
                      stroke-dasharray="125.6" stroke-dashoffset="{{ 125.6 - (125.6 * ($approvedPercentage / 100)) }}"/>
            </svg>
            <div class="absolute bottom-2 text-center">
                <span class="text-2xl font-black text-slate-800">{{ $approvedPercentage }}%</span>
                <p class="text-[9px] text-slate-400 font-bold uppercase mt-0.5">Approved Ratio</p>
            </div>
        </div>

        <div class="flex justify-between text-[9px] text-slate-400 font-bold border-t border-slate-50 pt-2 px-1">
            <span class="flex items-center gap-1.5"><span class="h-2 w-2 rounded-full bg-donezoGreen block"></span> Live</span>
            <span class="flex items-center gap-1.5"><span class="h-2 w-2 rounded-full bg-amber-400 block"></span> Pending</span>
            <span class="flex items-center gap-1.5"><span class="h-2 w-2 rounded-full bg-rose-500 block"></span> Denied</span>
        </div>
    </div>

    <!-- Time Tracker Widget Card (4 cols) -->
    <div class="bg-gradient-to-tr from-emerald-950 via-[#0e3b2b] to-slate-950 p-6 rounded-2xl border border-emerald-900/50 shadow-sm lg:col-span-4 flex flex-col justify-between text-white min-h-[300px] relative overflow-hidden">
        <div class="absolute inset-0 bg-[radial-gradient(ellipse_at_top_right,_var(--tw-gradient-stops))] from-emerald-800/10 via-transparent to-transparent pointer-events-none"></div>
        <div class="z-10">
            <h3 class="text-xs font-bold text-emerald-400 uppercase tracking-widest">Live Time Tracker</h3>
            <span class="text-[8px] text-emerald-300/70 block mt-1 uppercase">Live System Watch</span>
        </div>

        <div class="my-6 text-center z-10">
            <span id="dashboardClock" class="text-4xl font-extrabold tracking-widest font-mono text-emerald-400">00:00:00</span>
            <p class="text-[9px] text-emerald-300/50 uppercase mt-1 tracking-widest font-semibold">Active Administration session</p>
        </div>

        <div class="flex items-center justify-center gap-4 z-10">
            <button class="h-10 w-10 rounded-full bg-emerald-500/15 border border-emerald-500/20 flex items-center justify-center text-emerald-400 hover:bg-emerald-500/35 transition">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 9v6m4-6v6m7-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                </svg>
            </button>
            <button class="h-10 w-10 rounded-full bg-rose-500/15 border border-rose-500/20 flex items-center justify-center text-rose-450 hover:bg-rose-500/35 transition">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 10a1 1 0 011-1h4a1 1 0 011 1v4a1 1 0 01-1 1H10a1 1 0 01-1-1v-4z" />
                </svg>
            </button>
        </div>
    </div>
</div>

<!-- Bottom Widgets Grid (Feedback & KYC) -->
<div class="grid grid-cols-1 lg:grid-cols-2 gap-6 mt-8 relative z-10">
    <!-- Feedback Section -->
    <div class="bg-white p-6 rounded-2xl border border-slate-100 shadow-sm flex flex-col justify-between min-h-[300px]">
        <div>
            <div class="flex items-center justify-between border-b border-slate-50 pb-3 mb-4">
                <div>
                    <h3 class="text-xs font-bold text-slate-800 uppercase tracking-widest">Recent User Feedback</h3>
                    <p class="text-[10px] text-slate-400 mt-1 font-semibold">User feedback and bug submissions from mobile app</p>
                </div>
                <a href="/admin/feedbacks" class="text-[10px] font-bold text-donezoGreen hover:underline">View All Feedback</a>
            </div>

            @if ($recentFeedbacks->isEmpty())
                <p class="text-xs text-slate-400 py-12 text-center font-bold">No feedback received yet.</p>
            @else
                <div class="space-y-4">
                    @foreach ($recentFeedbacks as $feedback)
                        <div class="flex flex-col md:flex-row md:items-center justify-between p-3.5 bg-slate-50/50 border border-slate-100 rounded-xl gap-3">
                            <div class="flex items-start gap-3">
                                <div class="h-8 w-8 rounded-full bg-slate-100 border border-slate-200/60 flex items-center justify-center font-bold text-xs text-slate-500 flex-shrink-0">
                                    {{ substr($feedback->user->name ?? 'G', 0, 1) }}
                                </div>
                                <div>
                                    <div class="flex items-center gap-2">
                                        <span class="text-xs font-black text-slate-800">{{ $feedback->user->name ?? 'Guest' }}</span>
                                        <span class="text-[9px] text-slate-400 font-semibold">({{ $feedback->user->email ?? 'N/A' }})</span>
                                        @if($feedback->type === 'issue')
                                            <span class="px-1.5 py-0.5 bg-rose-50 text-rose-700 border border-rose-100 rounded text-[8px] font-extrabold uppercase tracking-wider">Bug: {{ $feedback->area ?? 'General' }}</span>
                                        @else
                                            <span class="px-1.5 py-0.5 bg-emerald-50 text-emerald-700 border border-emerald-100 rounded text-[8px] font-extrabold uppercase tracking-wider">Suggestion</span>
                                        @endif
                                    </div>
                                    <p class="text-xs text-slate-650 mt-1 font-semibold leading-relaxed">{{ Str::limit($feedback->feedback, 160) }}</p>
                                </div>
                            </div>
                            <div class="flex-shrink-0 text-right flex flex-col items-end gap-1">
                                @if($feedback->type === 'suggestion')
                                    <div class="flex items-center gap-0.5">
                                        @for($i = 1; $i <= 5; $i++)
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-3 w-3 {{ $i <= $feedback->stars ? 'text-amber-400 fill-amber-400' : 'text-slate-200' }}" viewBox="0 0 20 20" fill="currentColor">
                                                <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z" />
                                            </svg>
                                        @endfor
                                    </div>
                                @endif
                                <span class="text-[9px] text-slate-400 font-semibold">{{ $feedback->created_at->diffForHumans() }}</span>
                            </div>
                        </div>
                    @endforeach
                </div>
            @endif
        </div>
    </div>

    <!-- Pending KYC Approvals Section -->
    <div class="bg-white p-6 rounded-2xl border border-slate-100 shadow-sm flex flex-col justify-between min-h-[300px]">
        <div>
            <div class="flex items-center justify-between border-b border-slate-50 pb-3 mb-4">
                <div>
                    <h3 class="text-xs font-bold text-slate-800 uppercase tracking-widest">Pending KYC Approvals</h3>
                    <p class="text-[10px] text-slate-400 mt-1 font-semibold">Verify identity documents uploaded by hosts and users</p>
                </div>
                <span class="px-2.5 py-0.5 bg-amber-50 text-amber-700 border border-amber-200/60 rounded-md text-[8px] font-extrabold uppercase tracking-wider">{{ $pendingKycCount }} Pending</span>
            </div>

            @if ($pendingKycUsers->isEmpty())
                <p class="text-xs text-slate-400 py-12 text-center font-bold">No pending KYC verifications.</p>
            @else
                <div class="space-y-4">
                    @foreach ($pendingKycUsers as $user)
                        <div class="flex flex-col sm:flex-row sm:items-center justify-between p-3.5 bg-slate-50/50 border border-slate-100 rounded-xl gap-3">
                            <div class="flex items-center gap-3">
                                @if($user->profile_photo)
                                    <img src="{{ $user->profile_photo }}" class="h-8.5 w-8.5 rounded-lg object-cover border border-slate-200" alt="avatar">
                                @else
                                    <div class="h-8.5 w-8.5 rounded-lg bg-slate-100 border border-slate-200 flex items-center justify-center font-bold text-xs text-slate-500 uppercase">
                                        {{ substr($user->name, 0, 1) }}
                                    </div>
                                @endif
                                <div>
                                    <h4 class="text-xs font-bold text-slate-800">{{ $user->name }}</h4>
                                    <span class="text-[9px] text-slate-400 block mt-0.5">{{ $user->email }}</span>
                                </div>
                            </div>
                            <div class="flex items-center gap-2 self-end sm:self-auto">
                                @if ($user->kyc_document)
                                    <a href="{{ $user->kyc_document }}" target="_blank" class="px-2.5 py-1.5 bg-slate-100 hover:bg-slate-200 text-slate-700 rounded-lg text-[10px] font-extrabold border border-slate-200 transition">
                                        View ID
                                    </a>
                                @endif
                                <form action="/admin/users/{{ $user->id }}/verify-kyc" method="POST" class="inline m-0">
                                    @csrf
                                    <button type="submit" class="px-2.5 py-1.5 bg-emerald-50 hover:bg-emerald-100 text-emerald-700 border border-emerald-200 rounded-lg text-[10px] font-extrabold transition">
                                        Approve
                                    </button>
                                </form>
                                <form action="/admin/users/{{ $user->id }}/reject-kyc" method="POST" class="inline m-0">
                                    @csrf
                                    <button type="submit" class="px-2.5 py-1.5 bg-rose-50 hover:bg-rose-100 text-rose-700 border border-rose-200 rounded-lg text-[10px] font-extrabold transition">
                                        Reject
                                    </button>
                                </form>
                            </div>
                        </div>
                    @endforeach
                </div>
            @endif
        </div>
        <div class="mt-4 pt-3 border-t border-slate-50 flex justify-end">
            <a href="/admin/users" class="text-[10px] font-bold text-donezoGreen hover:underline">Manage All Users</a>
        </div>
    </div>
</div>

<script>
    // Live ticking clock for Time Tracker card
    function startClock() {
        const clockEl = document.getElementById('dashboardClock');
        if (!clockEl) return;
        
        setInterval(() => {
            const now = new Date();
            const hrs = String(now.getHours()).padStart(2, '0');
            const mins = String(now.getMinutes()).padStart(2, '0');
            const secs = String(now.getSeconds()).padStart(2, '0');
            clockEl.textContent = `${hrs}:${mins}:${secs}`;
        }, 1000);
    }
    
    document.addEventListener('DOMContentLoaded', startClock);
</script>
@endsection
