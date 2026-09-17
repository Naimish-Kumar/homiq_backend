@extends('layouts.app')

@section('title', 'Contact HomiQ Support - Real Estate Help Desk & Trust Team')
@section('meta_description', 'Get in touch with HomiQ customer support, report fraudulent listings, request verification assistance, or speak with our property onboarding advisors.')

@section('content')
<div class="bg-slate-50/50 min-h-screen">

    <!-- ═══════════════════════════════════════════════════════════════════ -->
    <!-- HEADER -->
    <!-- ═══════════════════════════════════════════════════════════════════ -->
    <section class="pt-12 pb-16 bg-gradient-to-b from-white via-slate-50 to-slate-100/60 border-b border-slate-200">
        <div class="site-shell px-4 sm:px-6 lg:px-8">
            <!-- Breadcrumbs -->
            <nav class="flex items-center gap-2 text-xs font-semibold text-slate-500 mb-8" aria-label="Breadcrumb">
                <a href="/" class="hover:text-emerald-700 transition flex items-center gap-1">
                    <span class="material-symbols-outlined text-sm">home</span>
                    Home
                </a>
                <span class="material-symbols-outlined text-xs text-slate-300">chevron_right</span>
                <span class="text-slate-900 font-bold">Contact Support</span>
            </nav>

            <div class="max-w-3xl">
                <span class="px-3.5 py-1.5 rounded-full bg-emerald-50 text-emerald-800 text-xs font-bold border border-emerald-200 uppercase tracking-wider inline-flex items-center gap-1.5 mb-4 shadow-2xs">
                    <span class="material-symbols-outlined text-sm text-emerald-600">headset_mic</span>
                    Customer Support &amp; Trust Desk
                </span>
                <h1 class="text-3xl sm:text-5xl font-black text-slate-900 tracking-tight leading-tight mb-4">
                    We’re Here to Help You Find &amp; Rent Spaces Safely.
                </h1>
                <p class="text-sm sm:text-base text-slate-600 leading-relaxed font-medium">
                    Whether you need help scheduling a property inspection, want to report a fraudulent landlord, or need assistance listing your flat, our dedicated team is at your service.
                </p>
            </div>
        </div>
    </section>

    <!-- ═══════════════════════════════════════════════════════════════════ -->
    <!-- CONTACT CHANNELS -->
    <!-- ═══════════════════════════════════════════════════════════════════ -->
    <section class="py-12 -mt-6">
        <div class="site-shell px-4 sm:px-6 lg:px-8">
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4">
                <!-- Channel 1: Email Support -->
                <div class="p-6 rounded-3xl bg-white border border-slate-200 shadow-2xs space-y-2">
                    <div class="h-10 w-10 rounded-2xl bg-indigo-50 text-indigo-700 border border-indigo-200 flex items-center justify-center mb-3">
                        <span class="material-symbols-outlined text-xl">mail</span>
                    </div>
                    <span class="text-[11px] font-bold uppercase tracking-wider text-slate-400 block">General Support</span>
                    <a href="mailto:support@homiq.com" class="font-bold text-slate-900 text-sm hover:text-emerald-700 block transition truncate">support@homiq.com</a>
                    <span class="text-slate-500 text-xs block">Response within 4 hours</span>
                </div>

                <!-- Channel 2: Phone Hotline -->
                <div class="p-6 rounded-3xl bg-white border border-slate-200 shadow-2xs space-y-2">
                    <div class="h-10 w-10 rounded-2xl bg-emerald-50 text-emerald-700 border border-emerald-200 flex items-center justify-center mb-3">
                        <span class="material-symbols-outlined text-xl">call</span>
                    </div>
                    <span class="text-[11px] font-bold uppercase tracking-wider text-slate-400 block">Toll-Free Phone</span>
                    <span class="font-bold text-slate-900 text-sm block">+91 1800-HOMIQ-01</span>
                    <span class="text-slate-500 text-xs block">Mon – Sat, 9 AM – 8 PM IST</span>
                </div>

                <!-- Channel 3: WhatsApp Support -->
                <div class="p-6 rounded-3xl bg-white border border-slate-200 shadow-2xs space-y-2">
                    <div class="h-10 w-10 rounded-2xl bg-emerald-50 text-emerald-700 border border-emerald-200 flex items-center justify-center mb-3">
                        <svg class="w-5 h-5 fill-current text-emerald-600" viewBox="0 0 24 24">
                            <path d="M12.031 6.172c-3.181 0-5.767 2.586-5.768 5.766-.001 1.298.38 2.27 1.019 3.287l-.582 2.128 2.182-.573c.978.58 1.911.928 3.145.929 3.178 0 5.767-2.587 5.768-5.766 0-3.18-2.587-5.771-5.764-5.771zm3.392 8.244c-.144.405-.837.774-1.17.824-.312.045-.634.072-1.808-.415-1.428-.593-2.34-2.035-2.411-2.13-.071-.095-.579-.771-.579-1.47 0-.7.367-1.044.498-1.187.13-.143.286-.179.381-.179.095 0 .19.002.273.006.09.004.21-.034.329.252.122.293.418 1.019.454 1.093.036.074.06.16.012.255-.048.095-.072.155-.143.238-.071.084-.15.187-.215.251-.072.072-.147.15-.063.294.084.143.372.614.798.993.548.488 1.01.639 1.153.71.144.071.227.06.31-.036.084-.095.357-.417.452-.56.096-.143.191-.119.322-.071.131.048.834.393.977.464.143.072.238.107.274.167.035.06.035.345-.109.75z"/>
                        </svg>
                    </div>
                    <span class="text-[11px] font-bold uppercase tracking-wider text-slate-400 block">WhatsApp Helpdesk</span>
                    <a href="https://wa.me/919876543210?text=Hello%20HomiQ%20Support%2C%20I%20need%20help%20with%20a%20property" target="_blank" rel="noopener noreferrer" class="font-bold text-emerald-700 text-sm hover:underline block truncate">Chat with Support</a>
                    <span class="text-slate-500 text-xs block">Fastest for instant queries</span>
                </div>

                <!-- Channel 4: Trust & Fraud Desk -->
                <div class="p-6 rounded-3xl bg-white border border-slate-200 shadow-2xs space-y-2">
                    <div class="h-10 w-10 rounded-2xl bg-rose-50 text-rose-700 border border-rose-200 flex items-center justify-center mb-3">
                        <span class="material-symbols-outlined text-xl">security</span>
                    </div>
                    <span class="text-[11px] font-bold uppercase tracking-wider text-slate-400 block">Fraud &amp; Safety Desk</span>
                    <a href="mailto:safety@homiq.com" class="font-bold text-rose-700 text-sm hover:underline block truncate">safety@homiq.com</a>
                    <span class="text-slate-500 text-xs block">High priority incident review</span>
                </div>
            </div>
        </div>
    </section>

    <!-- ═══════════════════════════════════════════════════════════════════ -->
    <!-- MAIN INTERACTIVE SUPPORT FORM & QUICK ROUTING -->
    <!-- ═══════════════════════════════════════════════════════════════════ -->
    <section class="py-12">
        <div class="site-shell px-4 sm:px-6 lg:px-8">
            <div class="grid grid-cols-1 lg:grid-cols-12 gap-10">

                <!-- Left Column: Support Form -->
                <div class="lg:col-span-7">
                    <div class="bg-white rounded-3xl p-6 sm:p-10 border border-slate-200 shadow-soft">
                        <div class="mb-6">
                            <h2 class="text-xl sm:text-2xl font-black text-slate-900 tracking-tight">
                                Send a Message to the HomiQ Team
                            </h2>
                            <p class="text-xs sm:text-sm text-slate-500 mt-1">
                                Complete this form and our support operations team will get back to you with resolution.
                            </p>
                        </div>

                        @if(session('success'))
                            <div class="p-4 rounded-2xl bg-emerald-50 border border-emerald-200 text-emerald-800 text-xs font-semibold flex items-center gap-2 mb-6">
                                <span class="material-symbols-outlined text-emerald-600 text-lg shrink-0">check_circle</span>
                                <span>{{ session('success') }}</span>
                            </div>
                        @endif

                        @if($errors->any())
                            <div class="p-4 rounded-2xl bg-rose-50 border border-rose-200 text-rose-800 text-xs font-semibold space-y-1 mb-6">
                                <span class="font-bold block">Please resolve the following issues:</span>
                                <ul class="list-disc pl-5">
                                    @foreach($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif

                        <form action="/contact" method="POST" class="space-y-4 text-xs">
                            @csrf

                            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                                <div>
                                    <label class="block text-[11px] font-bold uppercase tracking-wider text-slate-600 mb-1.5">Your Full Name *</label>
                                    <input type="text" name="name" value="{{ old('name', Auth::user()?->name) }}" required placeholder="e.g. Rahul Sharma" class="w-full rounded-2xl border border-slate-200 p-3 text-xs font-medium text-slate-900 focus:outline-none focus:border-emerald-500">
                                </div>
                                <div>
                                    <label class="block text-[11px] font-bold uppercase tracking-wider text-slate-600 mb-1.5">Email Address *</label>
                                    <input type="email" name="email" value="{{ old('email', Auth::user()?->email) }}" required placeholder="name@example.com" class="w-full rounded-2xl border border-slate-200 p-3 text-xs font-medium text-slate-900 focus:outline-none focus:border-emerald-500">
                                </div>
                            </div>

                            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                                <div>
                                    <label class="block text-[11px] font-bold uppercase tracking-wider text-slate-600 mb-1.5">Phone Number (Optional)</label>
                                    <input type="tel" name="phone" value="{{ old('phone', Auth::user()?->phone) }}" placeholder="+91 98765 43210" class="w-full rounded-2xl border border-slate-200 p-3 text-xs font-medium text-slate-900 focus:outline-none focus:border-emerald-500">
                                </div>
                                <div>
                                    <label class="block text-[11px] font-bold uppercase tracking-wider text-slate-600 mb-1.5">Inquiry Category *</label>
                                    <select name="category" required class="w-full rounded-2xl border border-slate-200 p-3 text-xs font-medium text-slate-900 focus:outline-none focus:border-emerald-500">
                                        <option value="general" {{ old('category') === 'general' ? 'selected' : '' }}>General Question</option>
                                        <option value="fraud_report" {{ old('category') === 'fraud_report' ? 'selected' : '' }}>Report Fraud / Suspicious Listing</option>
                                        <option value="verification" {{ old('category') === 'verification' ? 'selected' : '' }}>Verification Status Assistance</option>
                                        <option value="owner_support" {{ old('category') === 'owner_support' ? 'selected' : '' }}>Property Owner Listing Help</option>
                                        <option value="visit_help" {{ old('category') === 'visit_help' ? 'selected' : '' }}>Tenant Visit Scheduling Help</option>
                                        <option value="account_support" {{ old('category') === 'account_support' ? 'selected' : '' }}>Account &amp; Privacy Support</option>
                                    </select>
                                </div>
                            </div>

                            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                                <div>
                                    <label class="block text-[11px] font-bold uppercase tracking-wider text-slate-600 mb-1.5">Subject</label>
                                    <input type="text" name="subject" value="{{ old('subject') }}" placeholder="Brief topic of your inquiry" class="w-full rounded-2xl border border-slate-200 p-3 text-xs font-medium text-slate-900 focus:outline-none focus:border-emerald-500">
                                </div>
                                <div>
                                    <label class="block text-[11px] font-bold uppercase tracking-wider text-slate-600 mb-1.5">Property ID (If applicable)</label>
                                    <input type="number" name="property_id" value="{{ old('property_id') }}" placeholder="e.g. 104" class="w-full rounded-2xl border border-slate-200 p-3 text-xs font-medium text-slate-900 focus:outline-none focus:border-emerald-500">
                                </div>
                            </div>

                            <div>
                                <label class="block text-[11px] font-bold uppercase tracking-wider text-slate-600 mb-1.5">Message / Details *</label>
                                <textarea name="message" rows="5" required placeholder="Please describe how we can help you with maximum detail..." class="w-full rounded-2xl border border-slate-200 p-3 text-xs font-medium text-slate-900 focus:outline-none focus:border-emerald-500">{{ old('message') }}</textarea>
                            </div>

                            <div class="pt-2">
                                <button type="submit" class="w-full sm:w-auto px-8 py-3.5 rounded-full bg-brandNavy hover:bg-slate-900 text-white font-bold text-xs shadow-xs transition flex items-center justify-center gap-2 cursor-pointer">
                                    <span class="material-symbols-outlined text-base text-emerald-400">send</span>
                                    <span>Submit Support Ticket</span>
                                </button>
                            </div>
                        </form>
                    </div>
                </div>

                <!-- Right Column: Quick Support Hub -->
                <div class="lg:col-span-5 space-y-4">
                    <div class="p-6 rounded-3xl bg-white border border-slate-200 shadow-2xs space-y-4">
                        <h3 class="text-base font-black text-slate-900">Self-Service &amp; Quick Routing</h3>
                        
                        <div class="space-y-3">
                            <a href="/safety" class="p-3.5 rounded-2xl bg-slate-50 hover:bg-slate-100 border border-slate-100 transition flex items-center justify-between group">
                                <div class="flex items-center gap-3">
                                    <div class="h-9 w-9 rounded-xl bg-rose-50 text-rose-600 flex items-center justify-center shrink-0">
                                        <span class="material-symbols-outlined text-lg">shield</span>
                                    </div>
                                    <div>
                                        <strong class="text-xs font-bold text-slate-900 block group-hover:text-emerald-800">Safety Center</strong>
                                        <span class="text-[11px] text-slate-500">Anti-scam tips &amp; token advice</span>
                                    </div>
                                </div>
                                <span class="material-symbols-outlined text-xs text-slate-400 group-hover:text-slate-700">arrow_forward</span>
                            </a>

                            <a href="/verification-standards" class="p-3.5 rounded-2xl bg-slate-50 hover:bg-slate-100 border border-slate-100 transition flex items-center justify-between group">
                                <div class="flex items-center gap-3">
                                    <div class="h-9 w-9 rounded-xl bg-emerald-50 text-emerald-600 flex items-center justify-center shrink-0">
                                        <span class="material-symbols-outlined text-lg">verified_user</span>
                                    </div>
                                    <div>
                                        <strong class="text-xs font-bold text-slate-900 block group-hover:text-emerald-800">Verification Standards</strong>
                                        <span class="text-[11px] text-slate-500">How properties are audited</span>
                                    </div>
                                </div>
                                <span class="material-symbols-outlined text-xs text-slate-400 group-hover:text-slate-700">arrow_forward</span>
                            </a>

                            <a href="/list-property" class="p-3.5 rounded-2xl bg-slate-50 hover:bg-slate-100 border border-slate-100 transition flex items-center justify-between group">
                                <div class="flex items-center gap-3">
                                    <div class="h-9 w-9 rounded-xl bg-indigo-50 text-indigo-600 flex items-center justify-center shrink-0">
                                        <span class="material-symbols-outlined text-lg">real_estate_agent</span>
                                    </div>
                                    <div>
                                        <strong class="text-xs font-bold text-slate-900 block group-hover:text-emerald-800">Owner Free Listing</strong>
                                        <span class="text-[11px] text-slate-500">Post your property in 3 minutes</span>
                                    </div>
                                </div>
                                <span class="material-symbols-outlined text-xs text-slate-400 group-hover:text-slate-700">arrow_forward</span>
                            </a>

                            <a href="/delete-account" class="p-3.5 rounded-2xl bg-slate-50 hover:bg-slate-100 border border-slate-100 transition flex items-center justify-between group">
                                <div class="flex items-center gap-3">
                                    <div class="h-9 w-9 rounded-xl bg-slate-200 text-slate-700 flex items-center justify-center shrink-0">
                                        <span class="material-symbols-outlined text-lg">person_remove</span>
                                    </div>
                                    <div>
                                        <strong class="text-xs font-bold text-slate-900 block group-hover:text-rose-700">Delete Account &amp; Data</strong>
                                        <span class="text-[11px] text-slate-500">Privacy &amp; GDPR compliance</span>
                                    </div>
                                </div>
                                <span class="material-symbols-outlined text-xs text-slate-400 group-hover:text-slate-700">arrow_forward</span>
                            </a>
                        </div>
                    </div>

                    <!-- Headquarters Card -->
                    <div class="p-6 rounded-3xl bg-slate-900 text-white space-y-3">
                        <span class="text-[11px] font-bold uppercase tracking-wider text-slate-400 block">Physical Headquarters</span>
                        <h4 class="text-base font-black text-white">HomiQ Technologies Pvt. Ltd.</h4>
                        <p class="text-xs text-slate-300 leading-relaxed">
                            Logix Techno Park, Tower B, Sector 127 / Sector 137 Expressway Corridor, Noida, Uttar Pradesh 201305, India.
                        </p>
                    </div>
                </div>

            </div>
        </div>
    </section>

</div>
@endsection
