@extends('layouts.app')

@section('title', 'About HomiQ - India’s Transparent, 0% Brokerage Real Estate Platform')
@section('meta_description', 'Learn about HomiQ, our mission to eliminate broker commissions, our physical on-site verification protocol, and our vision for honest real estate across Delhi NCR and India.')

@section('content')
<div class="bg-slate-50/50 min-h-screen">

    <!-- ═══════════════════════════════════════════════════════════════════ -->
    <!-- HERO SECTION -->
    <!-- ═══════════════════════════════════════════════════════════════════ -->
    <section class="relative pt-12 pb-20 overflow-hidden bg-gradient-to-b from-white via-slate-50 to-slate-100/50 border-b border-slate-200/80">
        <div class="site-shell px-4 sm:px-6 lg:px-8 relative z-10">
            <!-- Breadcrumbs -->
            <nav class="flex items-center gap-2 text-xs font-semibold text-slate-500 mb-8" aria-label="Breadcrumb">
                <a href="/" class="hover:text-emerald-700 transition flex items-center gap-1">
                    <span class="material-symbols-outlined text-sm">home</span>
                    Home
                </a>
                <span class="material-symbols-outlined text-xs text-slate-300">chevron_right</span>
                <span class="text-slate-900 font-bold">About HomiQ</span>
            </nav>

            <div class="max-w-3xl">
                <span class="px-3.5 py-1.5 rounded-full bg-emerald-50 text-emerald-800 text-xs font-bold border border-emerald-200 uppercase tracking-wider inline-flex items-center gap-1.5 mb-4 shadow-2xs">
                    <span class="material-symbols-outlined text-sm text-emerald-600">verified</span>
                    Our Story &amp; Purpose
                </span>
                <h1 class="text-3xl sm:text-5xl font-black text-slate-900 tracking-tight leading-tight mb-6">
                    Fixing India's Real Estate Marketplace Through Radical Transparency.
                </h1>
                <p class="text-base sm:text-lg text-slate-600 leading-relaxed font-medium">
                    HomiQ was created to solve a deep structural problem in urban housing: excessive broker commissions, unverified bait-and-switch listings, and opaque security deposit terms. We connect direct property owners with genuine seekers backed by physical on-site audits.
                </p>
            </div>

            <!-- Fast Stats Grid -->
            <div class="grid grid-cols-2 sm:grid-cols-4 gap-4 mt-12 pt-8 border-t border-slate-200">
                <div class="p-4 sm:p-5 rounded-2xl bg-white border border-slate-200 shadow-2xs">
                    <span class="text-2xl sm:text-3xl font-black text-emerald-600 block mb-0.5">0%</span>
                    <span class="text-xs font-bold text-slate-900 block">Commission Model</span>
                    <span class="text-[11px] text-slate-500">Zero broker fees for seekers</span>
                </div>
                <div class="p-4 sm:p-5 rounded-2xl bg-white border border-slate-200 shadow-2xs">
                    <span class="text-2xl sm:text-3xl font-black text-slate-900 block mb-0.5">100%</span>
                    <span class="text-xs font-bold text-slate-900 block">Physically Audited</span>
                    <span class="text-[11px] text-slate-500">On-site verified photos &amp; GPS</span>
                </div>
                <div class="p-4 sm:p-5 rounded-2xl bg-white border border-slate-200 shadow-2xs">
                    <span class="text-2xl sm:text-3xl font-black text-slate-900 block mb-0.5">30-Day</span>
                    <span class="text-xs font-bold text-slate-900 block">Freshness Guarantee</span>
                    <span class="text-[11px] text-slate-500">Expired listings delisted automatically</span>
                </div>
                <div class="p-4 sm:p-5 rounded-2xl bg-white border border-slate-200 shadow-2xs">
                    <span class="text-2xl sm:text-3xl font-black text-slate-900 block mb-0.5">{{ number_format($activeListingsCount ?? 150) }}+</span>
                    <span class="text-xs font-bold text-slate-900 block">Active Verified Spaces</span>
                    <span class="text-[11px] text-slate-500">Across Delhi NCR &amp; Bangalore</span>
                </div>
            </div>
        </div>
    </section>

    <!-- ═══════════════════════════════════════════════════════════════════ -->
    <!-- THE PROBLEM & WHAT HOMIQ SOLVES -->
    <!-- ═══════════════════════════════════════════════════════════════════ -->
    <section class="py-16 sm:py-20">
        <div class="site-shell px-4 sm:px-6 lg:px-8">
            <div class="text-center max-w-2xl mx-auto mb-14">
                <span class="text-xs font-bold text-emerald-700 uppercase tracking-widest block mb-2">The Rental Reality</span>
                <h2 class="text-2xl sm:text-4xl font-black text-slate-900 tracking-tight">
                    What Traditional Real Estate Portals Get Wrong
                </h2>
                <p class="text-sm text-slate-600 mt-2">
                    Finding a home in Indian metro cities is frequently stressful and expensive. Here is how HomiQ is fundamentally changing the experience.
                </p>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                <!-- Card 1 -->
                <div class="p-6 sm:p-8 rounded-3xl bg-white border border-slate-200 shadow-2xs hover:shadow-soft transition space-y-4">
                    <div class="h-12 w-12 rounded-2xl bg-rose-50 text-rose-600 border border-rose-200 flex items-center justify-center">
                        <span class="material-symbols-outlined text-2xl">money_off</span>
                    </div>
                    <h3 class="text-lg font-black text-slate-900">Unnecessary 1-Month Brokerage</h3>
                    <p class="text-xs text-slate-600 leading-relaxed">
                        Traditional brokers charge a full month's rent just for opening a door and showing a flat. HomiQ eliminates the broker middleman, connecting renters directly with verified landlords with <strong>0% brokerage fees</strong>.
                    </p>
                    <div class="pt-3 border-t border-slate-100 flex items-center gap-1.5 text-xs font-bold text-emerald-700">
                        <span class="material-symbols-outlined text-sm">check_circle</span>
                        <span>Save ₹25,000 – ₹60,000 per lease</span>
                    </div>
                </div>

                <!-- Card 2 -->
                <div class="p-6 sm:p-8 rounded-3xl bg-white border border-slate-200 shadow-2xs hover:shadow-soft transition space-y-4">
                    <div class="h-12 w-12 rounded-2xl bg-indigo-50 text-indigo-700 border border-indigo-200 flex items-center justify-center">
                        <span class="material-symbols-outlined text-2xl">verified</span>
                    </div>
                    <h3 class="text-lg font-black text-slate-900">Fake &amp; Bait-and-Switch Listings</h3>
                    <p class="text-xs text-slate-600 leading-relaxed">
                        Classifieds are polluted with duplicate posts, non-existent cheap flats, and downloaded stock photos designed to capture phone numbers. Every verified property on HomiQ undergoes on-site photographic inspection.
                    </p>
                    <div class="pt-3 border-t border-slate-100 flex items-center gap-1.5 text-xs font-bold text-indigo-700">
                        <span class="material-symbols-outlined text-sm">check_circle</span>
                        <span>100% Real on-site photos &amp; geotag</span>
                    </div>
                </div>

                <!-- Card 3 -->
                <div class="p-6 sm:p-8 rounded-3xl bg-white border border-slate-200 shadow-2xs hover:shadow-soft transition space-y-4">
                    <div class="h-12 w-12 rounded-2xl bg-amber-50 text-amber-700 border border-amber-200 flex items-center justify-center">
                        <span class="material-symbols-outlined text-2xl">receipt_long</span>
                    </div>
                    <h3 class="text-lg font-black text-slate-900">Opaque Pricing &amp; Hidden Charges</h3>
                    <p class="text-xs text-slate-600 leading-relaxed">
                        Surprise society maintenance costs, inflated security deposit demands, and hidden documentation charges confuse seekers. HomiQ provides a transparent breakdown of all costs upfront before visit scheduling.
                    </p>
                    <div class="pt-3 border-t border-slate-100 flex items-center gap-1.5 text-xs font-bold text-amber-700">
                        <span class="material-symbols-outlined text-sm">check_circle</span>
                        <span>Total move-in estimate published upfront</span>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- ═══════════════════════════════════════════════════════════════════ -->
    <!-- OUR VERIFICATION PHILOSOPHY -->
    <!-- ═══════════════════════════════════════════════════════════════════ -->
    <section class="py-16 bg-white border-y border-slate-200">
        <div class="site-shell px-4 sm:px-6 lg:px-8">
            <div class="grid grid-cols-1 lg:grid-cols-12 gap-12 items-center">
                <div class="lg:col-span-6 space-y-6">
                    <span class="px-3.5 py-1.5 rounded-full bg-emerald-50 text-emerald-800 text-xs font-bold border border-emerald-200 uppercase tracking-wider inline-flex items-center gap-1.5">
                        <span class="material-symbols-outlined text-sm text-emerald-600">gavel</span>
                        Verification Approach
                    </span>
                    <h2 class="text-2xl sm:text-4xl font-black text-slate-900 tracking-tight leading-tight">
                        We Don't Just Aggregate Listings. We Audit Them.
                    </h2>
                    <p class="text-sm text-slate-600 leading-relaxed">
                        Most platforms are digital pinboards where anyone can copy photos from Google and list a fake flat. At HomiQ, our field operations team inspects inventory on the ground in high-density corridors like Sector 137 Noida, Golf Course Road, and HSR Layout.
                    </p>

                    <div class="space-y-3.5 text-xs text-slate-700 font-semibold">
                        <div class="flex items-start gap-3 p-3.5 rounded-2xl bg-slate-50 border border-slate-100">
                            <span class="material-symbols-outlined text-emerald-600 text-lg shrink-0 mt-0.5">badge</span>
                            <div>
                                <strong class="text-slate-900 block font-bold">1. Landlord Identity &amp; Contact Validation</strong>
                                <span class="text-slate-500 font-normal">Government photo ID and direct mobile phone verification.</span>
                            </div>
                        </div>
                        <div class="flex items-start gap-3 p-3.5 rounded-2xl bg-slate-50 border border-slate-100">
                            <span class="material-symbols-outlined text-emerald-600 text-lg shrink-0 mt-0.5">pin_drop</span>
                            <div>
                                <strong class="text-slate-900 block font-bold">2. Geotagged GPS &amp; Locality Verification</strong>
                                <span class="text-slate-500 font-normal">Physical coordinates and tower/block registry confirmed.</span>
                            </div>
                        </div>
                        <div class="flex items-start gap-3 p-3.5 rounded-2xl bg-slate-50 border border-slate-100">
                            <span class="material-symbols-outlined text-emerald-600 text-lg shrink-0 mt-0.5">photo_camera</span>
                            <div>
                                <strong class="text-slate-900 block font-bold">3. Authentic Photo &amp; Furnishing Inspection</strong>
                                <span class="text-slate-500 font-normal">Real photos reflecting current physical condition and appliances.</span>
                            </div>
                        </div>
                        <div class="flex items-start gap-3 p-3.5 rounded-2xl bg-slate-50 border border-slate-100">
                            <span class="material-symbols-outlined text-emerald-600 text-lg shrink-0 mt-0.5">policy</span>
                            <div>
                                <strong class="text-slate-900 block font-bold">4. Ownership &amp; Authorization Check</strong>
                                <span class="text-slate-500 font-normal">Electricity bill, title deed, or authorized allotment letter reviewed.</span>
                            </div>
                        </div>
                    </div>

                    <div class="pt-2">
                        <a href="/verification-standards" class="inline-flex items-center gap-1.5 text-xs font-bold text-brandNavy hover:text-emerald-700 transition">
                            <span>Read our complete Verification Standards</span>
                            <span class="material-symbols-outlined text-xs">arrow_forward</span>
                        </a>
                    </div>
                </div>

                <div class="lg:col-span-6">
                    <div class="p-8 sm:p-10 rounded-3xl bg-gradient-to-br from-slate-900 via-brandNavy to-slate-950 text-white shadow-xl relative overflow-hidden space-y-6">
                        <div class="h-12 w-12 rounded-2xl bg-emerald-500/20 text-emerald-400 border border-emerald-500/30 flex items-center justify-center">
                            <span class="material-symbols-outlined text-2xl">shield_locked</span>
                        </div>
                        <h3 class="text-2xl font-black tracking-tight">The 30-Day Freshness Cycle</h3>
                        <p class="text-xs sm:text-sm text-slate-300 leading-relaxed">
                            Rental demand in cities like Noida moves fast. If a flat gets rented out, it shouldn't stay active online. HomiQ automatically expires listings after 30 days unless the owner explicitly confirms current availability.
                        </p>
                        <div class="p-4 rounded-2xl bg-white/5 border border-white/10 flex items-center justify-between text-xs">
                            <span class="text-slate-400">Average Verification SLA:</span>
                            <strong class="text-emerald-400 font-bold">24 – 48 Hours</strong>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- ═══════════════════════════════════════════════════════════════════ -->
    <!-- OPERATING GEOGRAPHY -->
    <!-- ═══════════════════════════════════════════════════════════════════ -->
    <section class="py-16 sm:py-20">
        <div class="site-shell px-4 sm:px-6 lg:px-8">
            <div class="text-center max-w-2xl mx-auto mb-12">
                <span class="text-xs font-bold text-emerald-700 uppercase tracking-widest block mb-2">Coverage</span>
                <h2 class="text-2xl sm:text-4xl font-black text-slate-900 tracking-tight">
                    Where We Operate
                </h2>
                <p class="text-sm text-slate-600 mt-2">
                    We focus on high-density residential and commercial micro-markets with verified ground teams.
                </p>
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
                <!-- Hub 1: Noida -->
                <div class="p-6 rounded-3xl bg-white border border-slate-200 shadow-2xs hover:border-emerald-300 transition">
                    <div class="h-10 w-10 rounded-xl bg-indigo-50 text-indigo-700 border border-indigo-200 flex items-center justify-center mb-4">
                        <span class="material-symbols-outlined text-xl">location_city</span>
                    </div>
                    <h3 class="text-base font-black text-slate-900 mb-1">Noida Micro-Markets</h3>
                    <p class="text-xs text-slate-500 mb-3 leading-relaxed">Active clusters across Sector 137, Sector 62, Sector 75, 78, 18, and Noida Expressway.</p>
                    <a href="/rent/noida" class="text-xs font-bold text-emerald-700 hover:text-emerald-800 flex items-center gap-1">
                        <span>Explore Noida</span>
                        <span class="material-symbols-outlined text-xs">arrow_forward</span>
                    </a>
                </div>

                <!-- Hub 2: Greater Noida -->
                <div class="p-6 rounded-3xl bg-white border border-slate-200 shadow-2xs hover:border-emerald-300 transition">
                    <div class="h-10 w-10 rounded-xl bg-blue-50 text-blue-700 border border-blue-200 flex items-center justify-center mb-4">
                        <span class="material-symbols-outlined text-xl">apartment</span>
                    </div>
                    <h3 class="text-base font-black text-slate-900 mb-1">Greater Noida &amp; Extension</h3>
                    <p class="text-xs text-slate-500 mb-3 leading-relaxed">Noida Extension, Knowledge Park student PGs and flats, and Pari Chowk residential corridors.</p>
                    <a href="/rent/noida" class="text-xs font-bold text-emerald-700 hover:text-emerald-800 flex items-center gap-1">
                        <span>Explore Greater Noida</span>
                        <span class="material-symbols-outlined text-xs">arrow_forward</span>
                    </a>
                </div>

                <!-- Hub 3: Gurugram -->
                <div class="p-6 rounded-3xl bg-white border border-slate-200 shadow-2xs hover:border-emerald-300 transition">
                    <div class="h-10 w-10 rounded-xl bg-emerald-50 text-emerald-700 border border-emerald-200 flex items-center justify-center mb-4">
                        <span class="material-symbols-outlined text-xl">business_center</span>
                    </div>
                    <h3 class="text-base font-black text-slate-900 mb-1">Gurugram (NCR)</h3>
                    <p class="text-xs text-slate-500 mb-3 leading-relaxed">Cyber Hub, Golf Course Road, Sohna Road, and Sector 56 working professional hubs.</p>
                    <a href="/rent/gurugram" class="text-xs font-bold text-emerald-700 hover:text-emerald-800 flex items-center gap-1">
                        <span>Explore Gurugram</span>
                        <span class="material-symbols-outlined text-xs">arrow_forward</span>
                    </a>
                </div>

                <!-- Hub 4: Bangalore -->
                <div class="p-6 rounded-3xl bg-white border border-slate-200 shadow-2xs hover:border-emerald-300 transition">
                    <div class="h-10 w-10 rounded-xl bg-amber-50 text-amber-700 border border-amber-200 flex items-center justify-center mb-4">
                        <span class="material-symbols-outlined text-xl">hub</span>
                    </div>
                    <h3 class="text-base font-black text-slate-900 mb-1">Bangalore Expansion</h3>
                    <p class="text-xs text-slate-500 mb-3 leading-relaxed">HSR Layout, Koramangala, Bellandur, and Electronic City tech corridor co-living and flats.</p>
                    <a href="/rent/bangalore" class="text-xs font-bold text-emerald-700 hover:text-emerald-800 flex items-center gap-1">
                        <span>Explore Bangalore</span>
                        <span class="material-symbols-outlined text-xs">arrow_forward</span>
                    </a>
                </div>
            </div>
        </div>
    </section>

    <!-- ═══════════════════════════════════════════════════════════════════ -->
    <!-- TEAM & IDENTITY -->
    <!-- ═══════════════════════════════════════════════════════════════════ -->
    <section class="py-16 bg-white border-t border-slate-200">
        <div class="site-shell px-4 sm:px-6 lg:px-8">
            <div class="max-w-3xl mx-auto text-center space-y-4">
                <span class="px-3.5 py-1.5 rounded-full bg-slate-100 text-slate-800 text-xs font-bold uppercase tracking-wider inline-flex items-center gap-1.5">
                    <span class="material-symbols-outlined text-sm">groups</span>
                    Team &amp; Transparency
                </span>
                <h2 class="text-2xl sm:text-4xl font-black text-slate-900 tracking-tight">
                    Built by Engineers &amp; Ground Ops Specialists
                </h2>
                <p class="text-sm text-slate-600 leading-relaxed">
                    HomiQ is developed with love in India by software engineers, real estate legal advisors, and boots-on-the-ground property inspectors dedicated to ending the dark ages of broker extortion.
                </p>
            </div>

            <!-- Contact & HQ Info Card -->
            <div class="max-w-4xl mx-auto mt-12 p-6 sm:p-8 rounded-3xl bg-slate-50 border border-slate-200 grid grid-cols-1 sm:grid-cols-3 gap-6 text-center sm:text-left">
                <div class="space-y-1">
                    <span class="text-[11px] font-bold uppercase tracking-wider text-slate-400 block">General Inquiries</span>
                    <a href="mailto:support@homiq.com" class="font-bold text-slate-900 text-sm hover:text-emerald-700 transition">support@homiq.com</a>
                    <span class="text-slate-500 text-xs block">Average reply: &lt; 4 hours</span>
                </div>
                <div class="space-y-1">
                    <span class="text-[11px] font-bold uppercase tracking-wider text-slate-400 block">Toll-Free Support</span>
                    <span class="font-bold text-slate-900 text-sm block">+91 1800-HOMIQ-01</span>
                    <span class="text-slate-500 text-xs block">Mon – Sat, 9 AM – 8 PM IST</span>
                </div>
                <div class="space-y-1">
                    <span class="text-[11px] font-bold uppercase tracking-wider text-slate-400 block">Headquarters</span>
                    <span class="font-bold text-slate-900 text-sm block">Sector 137 &amp; Sector 62</span>
                    <span class="text-slate-500 text-xs block">Noida, NCR, Uttar Pradesh 201305</span>
                </div>
            </div>

            <div class="flex flex-wrap items-center justify-center gap-4 mt-8">
                <a href="/contact" class="px-6 py-3 rounded-full bg-brandNavy hover:bg-slate-900 text-white font-bold text-xs shadow-xs transition">
                    Contact Support
                </a>
                <a href="/safety" class="px-6 py-3 rounded-full bg-white hover:bg-slate-50 border border-slate-200 text-slate-700 font-bold text-xs shadow-xs transition">
                    Safety &amp; Anti-Fraud Guidelines
                </a>
                <a href="/list-property" class="px-6 py-3 rounded-full bg-emerald-600 hover:bg-emerald-700 text-white font-bold text-xs shadow-xs transition">
                    List Your Property Free
                </a>
            </div>
        </div>
    </section>

</div>
@endsection
