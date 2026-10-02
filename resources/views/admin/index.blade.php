@extends('admin.layout')

@section('page_title', 'Overview')

@section('content')
<!-- Header & Welcome Banner -->
<div class="flex flex-col md:flex-row md:items-center justify-between gap-4 mb-8">
    <div>
        <div class="flex items-center gap-2.5 mb-1">
            <h1 class="text-2xl font-black text-slate-900 tracking-tight font-heading">System Overview</h1>
            <span class="inline-flex items-center gap-1.5 px-2.5 py-0.5 rounded-full text-[11px] font-semibold bg-emerald-50 text-emerald-700 border border-emerald-200">
                <span class="h-1.5 w-1.5 rounded-full bg-emerald-500 animate-pulse"></span> Live System
            </span>
        </div>
        <p class="text-xs text-slate-500 font-medium">Welcome back, <strong class="text-slate-700 font-semibold">{{ Auth::user()->name }}</strong>. Operational performance summary for {{ now()->format('l, d M Y') }}.</p>
    </div>
    
    <!-- Action buttons -->
    <div class="flex items-center gap-2.5 flex-wrap">
        @if($pendingProperties > 0)
            <a href="/admin/properties?status=pending" class="px-4 py-2.5 bg-emerald-600 hover:bg-emerald-700 text-white rounded-xl text-xs font-bold transition shadow-sm flex items-center gap-2">
                <span class="flex h-2 w-2 relative">
                    <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-white opacity-75"></span>
                    <span class="relative inline-flex rounded-full h-2 w-2 bg-white"></span>
                </span>
                <span>Review Spaces</span>
                <span class="px-1.5 py-0.5 bg-white/20 rounded-md text-[10px] font-extrabold">{{ $pendingProperties }}</span>
            </a>
        @else
            <a href="/admin/properties" class="px-4 py-2.5 bg-emerald-600 hover:bg-emerald-700 text-white rounded-xl text-xs font-bold transition shadow-sm flex items-center gap-2">
                <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.75" d="M2.25 21h19.5m-18-18v18m10.5-18v18m6-13.5V21M6.75 6.75h.75m-.75 3h.75m-.75 3h.75m3-6h.75m-.75 3h.75m-.75 3h.75M6.75 21v-3.75a1.5 1.5 0 011.5-1.5h1.5a1.5 1.5 0 011.5 1.5V21m6-9h.75m-.75 3h.75m-.75 3h.75" />
                </svg>
                <span>Browse Listings</span>
            </a>
        @endif
        
        <a href="/admin/users" class="px-4 py-2.5 bg-white hover:bg-slate-50 text-slate-700 rounded-xl text-xs font-bold transition border border-slate-200 shadow-2xs flex items-center gap-2">
            <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4 text-slate-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.75" d="M15 19.128a9.38 9.38 0 002.625.372 9.337 9.337 0 004.121-.952 4.125 4.125 0 00-7.533-2.493M15 19.128v-.003c0-1.113-.285-2.16-.786-3.07M15 19.128v.106A12.318 12.318 0 018.624 21c-2.331 0-4.512-.645-6.374-1.766l-.001-.109a6.375 6.375 0 0111.964-3.07M12 6.375a3.375 3.375 0 11-6.75 0 3.375 3.375 0 016.75 0zm8.25 2.25a2.625 2.625 0 11-5.25 0 2.625 2.625 0 015.25 0z" />
            </svg>
            <span>User Database</span>
        </a>
    </div>
</div>

<!-- Primary Metric KPI Cards Grid -->
<div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-5 mb-8">
    
    <!-- Card 1: Total Platform Revenue -->
    <div class="bg-white p-5 rounded-2xl border border-slate-200/80 shadow-2xs hover:border-emerald-300 transition flex flex-col justify-between h-40 group">
        <div class="flex items-center justify-between">
            <span class="text-[10px] font-extrabold text-slate-400 uppercase tracking-wider">Total Platform Revenue</span>
            <div class="h-9 w-9 rounded-xl bg-emerald-50 border border-emerald-100 flex items-center justify-center text-emerald-600 transition duration-200">
                <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.75" d="M2.25 18.75a60.07 60.07 0 0115.797 2.101c.727.198 1.453-.342 1.453-1.096V18.75M3.75 4.5v.75A.75.75 0 013 6h-.75m0 0v-.375c0-.621.504-1.125 1.125-1.125H20.25M2.25 6v9m18-10.5v.75c0 .414.336.75.75.75h.75m-1.5-1.5h.375c.621 0 1.125.504 1.125 1.125v9.75c0 .621-.504 1.125-1.125 1.125h-.375m1.5-1.5H21a.75.75 0 00-.75.75v.75m0 0H3.75m0 0h-.375a1.125 1.125 0 01-1.125-1.125V15m1.5 1.5v-.75A.75.75 0 003 15h-.75M15 10.5a3 3 0 11-6 0 3 3 0 016 0zm3 0h.008v.008H18V10.5zm-12 0h.008v.008H6V10.5z" />
                </svg>
            </div>
        </div>
        <div class="mt-2">
            <span class="text-2xl lg:text-3xl font-black text-slate-900 tracking-tight block">₹{{ number_format($totalRevenue, 2) }}</span>
            <div class="flex items-center gap-1.5 mt-2">
                <span class="text-[10px] text-emerald-700 bg-emerald-50 border border-emerald-100 px-2 py-0.5 rounded-md font-semibold">
                    +5% Platform Commission
                </span>
            </div>
        </div>
    </div>

    <!-- Card 2: Total Members -->
    <div class="bg-white p-5 rounded-2xl border border-slate-200/80 shadow-2xs hover:border-emerald-300 transition flex flex-col justify-between h-40 group">
        <div class="flex items-center justify-between">
            <span class="text-[10px] font-extrabold text-slate-400 uppercase tracking-wider">Registered Members</span>
            <div class="h-9 w-9 rounded-xl bg-slate-50 border border-slate-100 flex items-center justify-center text-slate-600 transition duration-200">
                <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.75" d="M15 19.128a9.38 9.38 0 002.625.372 9.337 9.337 0 004.121-.952 4.125 4.125 0 00-7.533-2.493M15 19.128v-.003c0-1.113-.285-2.16-.786-3.07M15 19.128v.106A12.318 12.318 0 018.624 21c-2.331 0-4.512-.645-6.374-1.766l-.001-.109a6.375 6.375 0 0111.964-3.07M12 6.375a3.375 3.375 0 11-6.75 0 3.375 3.375 0 016.75 0zm8.25 2.25a2.625 2.625 0 11-5.25 0 2.625 2.625 0 015.25 0z" />
                </svg>
            </div>
        </div>
        <div class="mt-2">
            <span class="text-2xl lg:text-3xl font-black text-slate-900 tracking-tight block">{{ number_format($totalUsers) }}</span>
            <div class="flex items-center gap-1.5 mt-2">
                <span class="text-[10px] text-slate-500 bg-slate-100 px-2 py-0.5 rounded-md font-semibold">
                    Renters & Property Owners
                </span>
            </div>
        </div>
    </div>

    <!-- Card 3: Total Bookings -->
    <div class="bg-white p-5 rounded-2xl border border-slate-200/80 shadow-2xs hover:border-emerald-300 transition flex flex-col justify-between h-40 group">
        <div class="flex items-center justify-between">
            <span class="text-[10px] font-extrabold text-slate-400 uppercase tracking-wider">Bookings & Deals</span>
            <div class="h-9 w-9 rounded-xl bg-slate-50 border border-slate-100 flex items-center justify-center text-slate-600 transition duration-200">
                <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.75" d="M6.75 3v2.25M17.25 3v2.25M3 18.75V7.5a2.25 2.25 0 012.25-2.25h13.5A2.25 2.25 0 0121 7.5v11.25m-18 0A2.25 2.25 0 005.25 21h13.5A2.25 2.25 0 0021 18.75m-18 0v-7.5A2.25 2.25 0 015.25 9h13.5A2.25 2.25 0 0121 11.25v7.5m-9-6h.008v.008H12v-.008zM12 15h.008v.008H12V15zm0 2.25h.008v.008H12v-.008zM9.75 15h.008v.008H9.75V15zm0 2.25h.008v.008H9.75v-.008zM7.5 15h.008v.008H7.5V15zm0 2.25h.008v.008H7.5v-.008zm6.75-4.5h.008v.008h-.008v-.008zm0 2.25h.008v.008h-.008V15zm0 2.25h.008v.008h-.008v-.008zm2.25-4.5h.008v.008H16.5v-.008zm0 2.25h.008v.008H16.5V15z" />
                </svg>
            </div>
        </div>
        <div class="mt-2">
            <span class="text-2xl lg:text-3xl font-black text-slate-900 tracking-tight block">{{ number_format($totalBookings) }}</span>
            <div class="flex items-center gap-1.5 mt-2">
                <span class="text-[10px] text-slate-600 bg-slate-100 border border-slate-200/60 px-2 py-0.5 rounded-md font-semibold">
                    Finalized Deals & Reservations
                </span>
            </div>
        </div>
    </div>

    <!-- Card 4: Total Properties -->
    <div class="bg-white p-5 rounded-2xl border border-slate-200/80 shadow-2xs hover:border-emerald-300 transition flex flex-col justify-between h-40 group">
        <div class="flex items-center justify-between">
            <span class="text-[10px] font-extrabold text-slate-400 uppercase tracking-wider">Property Inventory</span>
            <div class="h-9 w-9 rounded-xl bg-slate-50 border border-slate-100 flex items-center justify-center text-slate-600 transition duration-200">
                <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.75" d="M2.25 21h19.5m-18-18v18m10.5-18v18m6-13.5V21M6.75 6.75h.75m-.75 3h.75m-.75 3h.75m3-6h.75m-.75 3h.75m-.75 3h.75M6.75 21v-3.75a1.5 1.5 0 011.5-1.5h1.5a1.5 1.5 0 011.5 1.5V21m6-9h.75m-.75 3h.75m-.75 3h.75" />
                </svg>
            </div>
        </div>
        <div class="mt-2">
            <span class="text-2xl lg:text-3xl font-black text-slate-900 tracking-tight block">{{ number_format($totalProperties) }}</span>
            <div class="flex items-center gap-1.5 mt-2">
                <span class="text-[10px] text-emerald-700 bg-emerald-50 border border-emerald-100 px-2 py-0.5 rounded-md font-semibold">
                    {{ $approvedProperties }} Active & Live
                </span>
            </div>
        </div>
    </div>
</div>

<!-- Middle Analytics Section: Chart + Reminders + Recent Bookings -->
<div class="grid grid-cols-1 lg:grid-cols-12 gap-6 mb-8">
    
    <!-- Chart Column (5 cols) -->
    <div class="bg-white p-6 rounded-2xl border border-slate-200/80 shadow-2xs lg:col-span-5 flex flex-col justify-between min-h-[320px]">
        <div class="flex items-center justify-between">
            <div>
                <h3 class="text-xs font-bold text-slate-900 uppercase tracking-wider font-heading">Listing Ingestion Volume</h3>
                <p class="text-[11px] text-slate-400 mt-0.5">Weekly property submissions distribution</p>
            </div>
            <span class="px-2 py-0.5 bg-slate-100 text-slate-600 rounded-md text-[10px] font-bold">7-Day Scan</span>
        </div>

        <!-- Sleek CSS Bar Chart -->
        <div class="flex items-end justify-between h-40 px-4 pt-6">
            @foreach ($listingVolume as $vol)
                <div class="flex flex-col items-center gap-2 flex-1">
                    @if ($vol['count'] == 0)
                        <div class="w-8 bg-slate-100 rounded-lg h-4 relative overflow-hidden" title="0 listings"></div>
                    @else
                        <div class="w-8 rounded-lg relative transition-all duration-300 {{ $vol['is_max'] ? 'bg-emerald-600 shadow-sm' : 'bg-slate-200 hover:bg-emerald-500' }}" style="height: {{ max(16, $vol['height']) }}px;" title="{{ $vol['count'] }} listings">
                            @if ($vol['is_max'])
                                <span class="absolute -top-6 left-1/2 -translate-x-1/2 bg-[#0A2540] text-white font-extrabold text-[9px] px-2 py-0.5 rounded-md shadow-sm">
                                    {{ $vol['count'] }}
                                </span>
                            @endif
                        </div>
                    @endif
                    <span class="text-[11px] font-bold text-slate-500">{{ $vol['letter'] }}</span>
                </div>
            @endforeach
        </div>

        <div class="pt-3 border-t border-slate-100 flex items-center justify-between text-[11px] text-slate-500">
            <span class="flex items-center gap-1.5"><span class="h-2 w-2 rounded-full bg-emerald-500"></span> Active submissions</span>
            <span class="font-semibold text-slate-700">{{ array_sum(array_column($listingVolume, 'count')) }} Total this week</span>
        </div>
    </div>

    <!-- Action Center Column (3 cols) -->
    <div class="bg-white p-6 rounded-2xl border border-slate-200/80 shadow-2xs lg:col-span-3 flex flex-col justify-between min-h-[320px]">
        <div>
            <div class="flex items-center justify-between mb-3">
                <h3 class="text-xs font-bold text-slate-900 uppercase tracking-wider font-heading">Action Center</h3>
                <span class="h-2 w-2 rounded-full bg-amber-500 animate-pulse"></span>
            </div>
            <p class="text-[11px] text-slate-400">Items requiring administrative attention</p>
        </div>

        <div class="space-y-3 my-3">
            <a href="/admin/properties?status=pending" class="block p-3 rounded-xl bg-slate-50 border border-slate-200/60 hover:border-emerald-300 transition group">
                <div class="flex items-center justify-between">
                    <span class="text-xs font-bold text-slate-800">Pending Listings</span>
                    <span class="px-2 py-0.5 bg-emerald-600 text-white rounded-md text-[10px] font-black">{{ $pendingProperties }}</span>
                </div>
                <p class="text-[11px] text-slate-500 mt-1">Properties awaiting verification and approval.</p>
            </a>

            <a href="/admin/users" class="block p-3 rounded-xl bg-slate-50 border border-slate-200/60 hover:border-amber-300 transition group">
                <div class="flex items-center justify-between">
                    <span class="text-xs font-bold text-slate-800">KYC Verifications</span>
                    <span class="px-2 py-0.5 bg-amber-600 text-white rounded-md text-[10px] font-black">{{ $pendingKycCount }}</span>
                </div>
                <p class="text-[11px] text-slate-500 mt-1">Owner identity documents to be vetted.</p>
            </a>
        </div>

        <a href="/admin/properties?status=pending" class="w-full py-2.5 bg-[#0A2540] hover:bg-[#061826] text-white text-center rounded-xl text-xs font-bold transition shadow-sm flex items-center justify-center gap-2">
            <span>Start Moderating</span>
            <svg xmlns="http://www.w3.org/2000/svg" class="h-3.5 w-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3" />
            </svg>
        </a>
    </div>

    <!-- Recent Activity Log (4 cols) -->
    <div class="bg-white p-6 rounded-2xl border border-slate-200/80 shadow-2xs lg:col-span-4 flex flex-col justify-between min-h-[320px]">
        <div class="flex items-center justify-between border-b border-slate-100 pb-3">
            <span class="text-xs font-bold text-slate-900 uppercase tracking-wider font-heading">Recent Activity</span>
            <span class="px-2 py-0.5 bg-slate-100 text-slate-600 border border-slate-200/60 rounded-md text-[9px] font-extrabold uppercase">Live Feed</span>
        </div>

        @if ($recentBookings->isEmpty())
            <div class="py-10 text-center">
                <p class="text-xs text-slate-400 font-semibold">No recent reservations recorded.</p>
            </div>
        @else
            <div class="space-y-3.5 flex-1 overflow-y-auto pr-1 my-2">
                @foreach ($recentBookings->take(4) as $booking)
                    <div class="flex items-center justify-between border-b border-slate-50 pb-2.5 last:border-0 last:pb-0">
                        <div class="overflow-hidden pr-2">
                            <span class="text-xs font-bold text-slate-800 block truncate leading-tight">{{ $booking->property->title }}</span>
                            <span class="text-[10px] text-slate-400 block truncate mt-0.5">Renter: {{ $booking->renter->name }}</span>
                        </div>
                        <div class="text-right flex-shrink-0">
                            <span class="text-xs font-black text-slate-900 block">₹{{ number_format($booking->total_price, 0) }}</span>
                            <span class="inline-block text-[9px] px-1.5 py-0.5 rounded font-extrabold uppercase tracking-wider {{ $booking->status === 'approved' ? 'bg-emerald-50 text-emerald-700 border border-emerald-200' : 'bg-amber-50 text-amber-700 border border-amber-200' }}">
                                {{ $booking->status }}
                            </span>
                        </div>
                    </div>
                @endforeach
            </div>
        @endif

        <div class="pt-2 border-t border-slate-100 text-right">
            <a href="/admin/financials" class="text-[11px] font-bold text-emerald-600 hover:text-emerald-700 hover:underline">
                View transactions ledger →
            </a>
        </div>
    </div>
</div>

<!-- Bottom Row: Team Members + Moderation Health Gauge + Time Tracker -->
<div class="grid grid-cols-1 lg:grid-cols-12 gap-6 mb-8">
    
    <!-- Active Administrators List (5 cols) -->
    <div class="bg-white p-6 rounded-2xl border border-slate-200/80 shadow-2xs lg:col-span-5 flex flex-col justify-between min-h-[300px]">
        <div class="flex items-center justify-between border-b border-slate-100 pb-3 mb-3">
            <div>
                <span class="text-xs font-bold text-slate-900 uppercase tracking-wider block font-heading">Staff & Active Profiles</span>
                <span class="text-[10px] text-slate-400">Recently onboarded users</span>
            </div>
            <a href="/admin/users" class="text-[11px] font-bold text-emerald-600 hover:underline">View All</a>
        </div>

        <div class="space-y-3 flex-1">
            @foreach ($latestUsers as $user)
                <div class="flex items-center justify-between p-3 rounded-xl bg-slate-50 border border-slate-100 hover:bg-slate-100/60 transition">
                    <div class="flex items-center gap-3">
                        <div class="h-9 w-9 rounded-xl {{ $user->is_admin ? 'bg-[#0A2540] text-emerald-400' : 'bg-slate-200 text-slate-600' }} flex items-center justify-center font-extrabold text-xs shadow-2xs">
                            {{ $user->initials }}
                        </div>
                        <div>
                            <h4 class="text-xs font-bold text-slate-800">{{ $user->name }}</h4>
                            <span class="text-[10px] text-slate-400 block mt-0.5">{{ $user->role_desc }}</span>
                        </div>
                    </div>
                    <span class="px-2 py-0.5 {{ $user->badge_class }} border rounded-md text-[9px] font-extrabold uppercase">{{ $user->display_role }}</span>
                </div>
            @endforeach
        </div>
    </div>

    <!-- Moderation Health Gauge (3 cols) -->
    <div class="bg-white p-6 rounded-2xl border border-slate-200/80 shadow-2xs lg:col-span-3 flex flex-col justify-between min-h-[300px]">
        <div>
            <h3 class="text-xs font-bold text-slate-900 uppercase tracking-wider font-heading">Moderation Health</h3>
            <span class="text-[10px] text-slate-400 font-semibold block mt-0.5">Directory Approval Ratio</span>
        </div>

        <!-- Half Donut SVG Gauge -->
        <div class="flex flex-col items-center justify-center relative my-4">
            @php
                $total = max(1, $totalProperties);
                $approvedPercentage = round(($approvedProperties / $total) * 100);
            @endphp
            <svg class="w-36 h-20" viewBox="0 0 100 60">
                <path d="M 10 50 A 40 40 0 0 1 90 50" fill="none" stroke="#E2E8F0" stroke-width="12" stroke-linecap="round"/>
                <path d="M 10 50 A 40 40 0 0 1 90 50" fill="none" stroke="#10B981" stroke-width="12" stroke-linecap="round"
                      stroke-dasharray="125.6" stroke-dashoffset="{{ 125.6 - (125.6 * ($approvedPercentage / 100)) }}"/>
            </svg>
            <div class="absolute bottom-1 text-center">
                <span class="text-2xl font-black text-slate-900">{{ $approvedPercentage }}%</span>
                <p class="text-[9px] text-slate-400 font-bold uppercase">Approved Rate</p>
            </div>
        </div>

        <div class="flex justify-between text-[10px] text-slate-500 font-semibold border-t border-slate-100 pt-2 px-1">
            <span class="flex items-center gap-1"><span class="h-2 w-2 rounded-full bg-emerald-500"></span> Live</span>
            <span class="flex items-center gap-1"><span class="h-2 w-2 rounded-full bg-amber-400"></span> Pending</span>
            <span class="flex items-center gap-1"><span class="h-2 w-2 rounded-full bg-rose-500"></span> Denied</span>
        </div>
    </div>

    <!-- Live System Watch / Time Tracker (4 cols) -->
    <div class="bg-gradient-to-tr from-[#0A2540] via-[#081F36] to-[#061826] p-6 rounded-2xl border border-slate-800 shadow-md lg:col-span-4 flex flex-col justify-between text-white min-h-[300px] relative overflow-hidden">
        <div class="z-10">
            <div class="flex items-center justify-between">
                <h3 class="text-xs font-bold text-emerald-400 uppercase tracking-wider font-heading">System Status</h3>
                <span class="h-2 w-2 rounded-full bg-emerald-400 animate-pulse"></span>
            </div>
            <span class="text-[10px] text-slate-400 block mt-0.5">Admin Session Monitor</span>
        </div>

        <div class="my-6 text-center z-10">
            <span id="dashboardClock" class="text-4xl font-extrabold tracking-widest font-mono text-emerald-400">00:00:00</span>
            <p class="text-[10px] text-slate-400 uppercase mt-1 tracking-widest font-medium">Server Synchronized</p>
        </div>

        <div class="pt-3 border-t border-white/10 flex items-center justify-between text-xs text-slate-300 z-10">
            <span class="flex items-center gap-1.5">
                <span class="h-1.5 w-1.5 rounded-full bg-emerald-400"></span> Operational
            </span>
            <span class="text-[10px] font-bold text-emerald-300 bg-white/10 px-2 py-0.5 rounded-md">HTTP 200 OK</span>
        </div>
    </div>
</div>

<!-- Bottom Widgets: Feedback & KYC Approval Queue -->
<div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
    
    <!-- User Feedback & Bug Submissions -->
    <div class="bg-white p-6 rounded-2xl border border-slate-200/80 shadow-2xs flex flex-col justify-between min-h-[320px]">
        <div>
            <div class="flex items-center justify-between border-b border-slate-100 pb-3 mb-4">
                <div>
                    <h3 class="text-xs font-bold text-slate-900 uppercase tracking-wider font-heading">Recent User Feedback</h3>
                    <p class="text-[11px] text-slate-400 mt-0.5">Submissions from HomiQ Mobile App</p>
                </div>
                <a href="/admin/feedbacks" class="text-[11px] font-bold text-emerald-600 hover:underline">View All ({{ $recentFeedbacks->count() }})</a>
            </div>

            @if ($recentFeedbacks->isEmpty())
                <p class="text-xs text-slate-400 py-12 text-center font-semibold">No feedback submissions received yet.</p>
            @else
                <div class="space-y-3">
                    @foreach ($recentFeedbacks as $feedback)
                        <div class="p-3.5 bg-slate-50 border border-slate-100 rounded-xl">
                            <div class="flex items-center justify-between mb-1.5">
                                <div class="flex items-center gap-2">
                                    <span class="text-xs font-bold text-slate-900">{{ $feedback->user->name ?? 'Guest User' }}</span>
                                    @if($feedback->type === 'issue')
                                        <span class="px-2 py-0.5 bg-rose-50 text-rose-700 border border-rose-200 rounded-md text-[9px] font-extrabold uppercase">Bug Report</span>
                                    @else
                                        <span class="px-2 py-0.5 bg-emerald-50 text-emerald-700 border border-emerald-200 rounded-md text-[9px] font-extrabold uppercase">Suggestion</span>
                                    @endif
                                </div>
                                <span class="text-[10px] text-slate-400 font-medium">{{ $feedback->created_at->diffForHumans() }}</span>
                            </div>
                            <p class="text-xs text-slate-600 leading-relaxed">{{ Str::limit($feedback->feedback, 140) }}</p>
                        </div>
                    @endforeach
                </div>
            @endif
        </div>
        
        <div class="mt-4 pt-3 border-t border-slate-100 text-right">
            <a href="/admin/feedbacks" class="text-[11px] font-bold text-emerald-600 hover:underline">Open Feedback Management →</a>
        </div>
    </div>

    <!-- Pending KYC Approvals Queue -->
    <div class="bg-white p-6 rounded-2xl border border-slate-200/80 shadow-2xs flex flex-col justify-between min-h-[320px]">
        <div>
            <div class="flex items-center justify-between border-b border-slate-100 pb-3 mb-4">
                <div>
                    <h3 class="text-xs font-bold text-slate-900 uppercase tracking-wider font-heading">Pending KYC Verification</h3>
                    <p class="text-[11px] text-slate-400 mt-0.5">Government ID & Host verification requests</p>
                </div>
                <span class="px-2.5 py-0.5 bg-amber-50 text-amber-700 border border-amber-200 rounded-md text-[10px] font-extrabold uppercase">{{ $pendingKycCount }} Pending</span>
            </div>

            @if ($pendingKycUsers->isEmpty())
                <p class="text-xs text-slate-400 py-12 text-center font-semibold">No pending KYC approvals in queue.</p>
            @else
                <div class="space-y-3">
                    @foreach ($pendingKycUsers as $user)
                        <div class="flex flex-col sm:flex-row sm:items-center justify-between p-3.5 bg-slate-50 border border-slate-100 rounded-xl gap-3">
                            <div class="flex items-center gap-3">
                                @if($user->profile_photo)
                                    <img src="{{ $user->profile_photo }}" class="h-9 w-9 rounded-xl object-cover border border-slate-200 shadow-2xs" alt="avatar">
                                @else
                                    <div class="h-9 w-9 rounded-xl bg-slate-200 border border-slate-300 flex items-center justify-center font-extrabold text-xs text-slate-600 uppercase">
                                        {{ substr($user->name, 0, 1) }}
                                    </div>
                                @endif
                                <div>
                                    <h4 class="text-xs font-bold text-slate-800">{{ $user->name }}</h4>
                                    <span class="text-[10px] text-slate-400 block">{{ $user->email }}</span>
                                </div>
                            </div>
                            <div class="flex items-center gap-2 self-end sm:self-auto">
                                @if ($user->kyc_document)
                                    <a href="{{ $user->kyc_document }}" target="_blank" class="px-3 py-1.5 bg-white hover:bg-slate-100 text-slate-700 rounded-lg text-[11px] font-bold border border-slate-200 transition">
                                        View ID
                                    </a>
                                @endif
                                <form action="/admin/users/{{ $user->id }}/verify-kyc" method="POST" class="inline m-0">
                                    @csrf
                                    <button type="submit" class="px-3 py-1.5 bg-emerald-600 hover:bg-emerald-700 text-white rounded-lg text-[11px] font-bold shadow-2xs transition">
                                        Approve
                                    </button>
                                </form>
                                <form action="/admin/users/{{ $user->id }}/reject-kyc" method="POST" class="inline m-0">
                                    @csrf
                                    <button type="submit" class="px-3 py-1.5 bg-rose-50 hover:bg-rose-100 text-rose-700 border border-rose-200 rounded-lg text-[11px] font-bold transition">
                                        Reject
                                    </button>
                                </form>
                            </div>
                        </div>
                    @endforeach
                </div>
            @endif
        </div>
        
        <div class="mt-4 pt-3 border-t border-slate-100 text-right">
            <a href="/admin/users" class="text-[11px] font-bold text-emerald-600 hover:underline">Manage All Accounts →</a>
        </div>
    </div>
</div>

<script>
    // Live ticking clock
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
