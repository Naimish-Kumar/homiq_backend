@extends('layouts.app')

@section('title', 'HomiQ Verification Standards - Physical Audits & Trust Protocol')
@section('meta_description', 'Learn how HomiQ validates property listings with physical audits, ownership checks, and ID validation. What is checked, what is not checked, SLAs, and fraud reporting.')

@section('content')
<div class="bg-slate-50/50 min-h-screen">

    <!-- ═══════════════════════════════════════════════════════════════════ -->
    <!-- HEADER -->
    <!-- ═══════════════════════════════════════════════════════════════════ -->
    <section class="pt-12 pb-16 bg-gradient-to-b from-white via-slate-50 to-slate-100/60 border-b border-slate-200">
        <div class="site-shell px-6 sm:px-8">
            <!-- Breadcrumbs -->
            <nav class="flex items-center gap-2 text-xs font-semibold text-slate-500 mb-8" aria-label="Breadcrumb">
                <a href="/" class="hover:text-emerald-700 transition flex items-center gap-1">
                    <span class="material-symbols-outlined text-sm">home</span>
                    Home
                </a>
                <span class="material-symbols-outlined text-xs text-slate-300">chevron_right</span>
                <span class="text-slate-900 font-bold">Verification Standards</span>
            </nav>

            <div class="max-w-3xl">
                <span class="px-3.5 py-1.5 rounded-full bg-emerald-50 text-emerald-800 text-xs font-bold border border-emerald-200 uppercase tracking-wider inline-flex items-center gap-1.5 mb-4 shadow-2xs">
                    <span class="material-symbols-outlined text-sm text-emerald-600">verified_user</span>
                    Trust &amp; Audit Architecture
                </span>
                <h1 class="text-3xl sm:text-5xl font-black text-slate-900 tracking-tight leading-tight mb-4">
                    HomiQ Verification Standards &amp; Quality Protocol
                </h1>
                <p class="text-sm sm:text-base text-slate-600 leading-relaxed font-medium">
                    Because we make strong verification claims on our marketplace, we believe in complete transparency about what our on-site verification guarantees, how inspections are conducted, and where legal boundaries lie.
                </p>
            </div>
        </div>
    </section>

    <!-- ═══════════════════════════════════════════════════════════════════ -->
    <!-- WHAT IS CHECKED VS WHAT IS NOT CHECKED -->
    <!-- ═══════════════════════════════════════════════════════════════════ -->
    <section class="py-16">
        <div class="site-shell px-6 sm:px-8">
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
                <!-- What IS Checked -->
                <div class="p-6 sm:p-8 rounded-3xl bg-white border border-emerald-200 shadow-soft space-y-6">
                    <div class="flex items-center gap-3">
                        <div class="h-10 w-10 rounded-2xl bg-emerald-50 text-emerald-600 border border-emerald-200 flex items-center justify-center shrink-0">
                            <span class="material-symbols-outlined text-2xl">check_circle</span>
                        </div>
                        <div>
                            <h2 class="text-xl font-black text-slate-900 tracking-tight">What Is Checked &amp; Validated</h2>
                            <p class="text-xs text-slate-500">Rigorous 5-point physical &amp; document audit</p>
                        </div>
                    </div>

                    <div class="space-y-4 text-xs sm:text-sm">
                        <div class="p-4 rounded-2xl bg-emerald-50/40 border border-emerald-100 flex items-start gap-3">
                            <span class="material-symbols-outlined text-emerald-600 text-lg shrink-0 mt-0.5">badge</span>
                            <div>
                                <strong class="text-slate-900 block font-bold">1. Landlord Identity Verification</strong>
                                <span class="text-slate-600 text-xs">Government photo ID validation (Aadhaar/PAN/Passport) and mobile OTP ownership verification.</span>
                            </div>
                        </div>

                        <div class="p-4 rounded-2xl bg-emerald-50/40 border border-emerald-100 flex items-start gap-3">
                            <span class="material-symbols-outlined text-emerald-600 text-lg shrink-0 mt-0.5">pin_drop</span>
                            <div>
                                <strong class="text-slate-900 block font-bold">2. Geotagged GPS &amp; Locality Audit</strong>
                                <span class="text-slate-600 text-xs">Physical coordinates, society name, tower registry, and floor verification on-site.</span>
                            </div>
                        </div>

                        <div class="p-4 rounded-2xl bg-emerald-50/40 border border-emerald-100 flex items-start gap-3">
                            <span class="material-symbols-outlined text-emerald-600 text-lg shrink-0 mt-0.5">photo_camera</span>
                            <div>
                                <strong class="text-slate-900 block font-bold">3. Visual Photographic Audit</strong>
                                <span class="text-slate-600 text-xs">100% authentic on-site photos of bedrooms, living area, kitchen, and washrooms. Zero stock photos allowed.</span>
                            </div>
                        </div>

                        <div class="p-4 rounded-2xl bg-emerald-50/40 border border-emerald-100 flex items-start gap-3">
                            <span class="material-symbols-outlined text-emerald-600 text-lg shrink-0 mt-0.5">policy</span>
                            <div>
                                <strong class="text-slate-900 block font-bold">4. Ownership &amp; Authorization Check</strong>
                                <span class="text-slate-600 text-xs">Recent electricity bill in owner's name, property tax challan, or registered builder allotment letter.</span>
                            </div>
                        </div>

                        <div class="p-4 rounded-2xl bg-emerald-50/40 border border-emerald-100 flex items-start gap-3">
                            <span class="material-symbols-outlined text-emerald-600 text-lg shrink-0 mt-0.5">payments</span>
                            <div>
                                <strong class="text-slate-900 block font-bold">5. Financial &amp; Brokerage Transparency</strong>
                                <span class="text-slate-600 text-xs">Published monthly rent, security deposit terms, and confirmation of 0% brokerage fees.</span>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- What is NOT Checked -->
                <div class="p-6 sm:p-8 rounded-3xl bg-white border border-slate-200 shadow-soft space-y-6">
                    <div class="flex items-center gap-3">
                        <div class="h-10 w-10 rounded-2xl bg-slate-100 text-slate-700 border border-slate-200 flex items-center justify-center shrink-0">
                            <span class="material-symbols-outlined text-2xl">cancel</span>
                        </div>
                        <div>
                            <h2 class="text-xl font-black text-slate-900 tracking-tight">What Is NOT Checked</h2>
                            <p class="text-xs text-slate-500">Legal limits &amp; non-scope elements</p>
                        </div>
                    </div>

                    <div class="space-y-4 text-xs sm:text-sm">
                        <div class="p-4 rounded-2xl bg-slate-50 border border-slate-100 flex items-start gap-3">
                            <span class="material-symbols-outlined text-slate-400 text-lg shrink-0 mt-0.5">domain_disabled</span>
                            <div>
                                <strong class="text-slate-900 block font-bold">1. Structural Engineering &amp; Sub-Surface Defects</strong>
                                <span class="text-slate-500 text-xs">We do not conduct non-destructive structural integrity tests or inspect subsurface plumbing.</span>
                            </div>
                        </div>

                        <div class="p-4 rounded-2xl bg-slate-50 border border-slate-100 flex items-start gap-3">
                            <span class="material-symbols-outlined text-slate-400 text-lg shrink-0 mt-0.5">balance</span>
                            <div>
                                <strong class="text-slate-900 block font-bold">2. Hidden Title Litigation Outside Public Records</strong>
                                <span class="text-slate-500 text-xs">Private family disputes, unrecorded inheritance claims, or non-public court litigation are outside scope.</span>
                            </div>
                        </div>

                        <div class="p-4 rounded-2xl bg-slate-50 border border-slate-100 flex items-start gap-3">
                            <span class="material-symbols-outlined text-slate-400 text-lg shrink-0 mt-0.5">record_voice_over</span>
                            <div>
                                <strong class="text-slate-900 block font-bold">3. Tenant-Landlord Interpersonal Conflicts</strong>
                                <span class="text-slate-500 text-xs">We cannot predict behavioral friction, house rule disagreements, or post-occupancy relationship issues.</span>
                            </div>
                        </div>

                        <div class="p-4 rounded-2xl bg-slate-50 border border-slate-100 flex items-start gap-3">
                            <span class="material-symbols-outlined text-slate-400 text-lg shrink-0 mt-0.5">credit_score</span>
                            <div>
                                <strong class="text-slate-900 block font-bold">4. Financial Solvency Guarantees</strong>
                                <span class="text-slate-500 text-xs">HomiQ does not guarantee timely monthly rental payment transfers or tenant credit score underwriting.</span>
                            </div>
                        </div>

                        <div class="p-4 rounded-2xl bg-amber-50/50 border border-amber-200 flex items-start gap-3">
                            <span class="material-symbols-outlined text-amber-600 text-lg shrink-0 mt-0.5">info</span>
                            <div>
                                <strong class="text-slate-900 block font-bold">Our Recommendation:</strong>
                                <span class="text-slate-600 text-xs">Always execute a registered lease agreement and never transfer advance deposits before seeing the keys in person.</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- ═══════════════════════════════════════════════════════════════════ -->
    <!-- VERIFICATION SLA & RE-VERIFICATION CYCLE -->
    <!-- ═══════════════════════════════════════════════════════════════════ -->
    <section class="py-16 bg-white border-y border-slate-200">
        <div class="site-shell px-6 sm:px-8">
            <div class="max-w-3xl mx-auto text-center mb-12">
                <span class="text-xs font-bold text-emerald-700 uppercase tracking-widest block mb-2">Audit Timelines</span>
                <h2 class="text-2xl sm:text-4xl font-black text-slate-900 tracking-tight">
                    Verification Timeline &amp; Freshness Policy
                </h2>
                <p class="text-sm text-slate-600 mt-2">
                    How listings are audited from the moment of submission to ongoing 30-day lifecycle checks.
                </p>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                <div class="p-6 rounded-3xl bg-slate-50 border border-slate-200 space-y-3">
                    <div class="h-10 w-10 rounded-xl bg-brandNavy text-white flex items-center justify-center font-black text-sm">
                        01
                    </div>
                    <h3 class="text-base font-black text-slate-900">Submission &amp; Document Review</h3>
                    <p class="text-xs text-slate-600 leading-relaxed">
                        Landlord uploads property photos, price, address, and ownership document. Our digital verification team verifies IDs within <strong>4 hours</strong>.
                    </p>
                </div>

                <div class="p-6 rounded-3xl bg-slate-50 border border-slate-200 space-y-3">
                    <div class="h-10 w-10 rounded-xl bg-emerald-600 text-white flex items-center justify-center font-black text-sm">
                        02
                    </div>
                    <h3 class="text-base font-black text-slate-900">Physical On-Site Inspection</h3>
                    <p class="text-xs text-slate-600 leading-relaxed">
                        A certified HomiQ field inspector conducts an in-person visit within <strong>24 – 48 business hours</strong> to audit layout, amenities, and take geotagged photos.
                    </p>
                </div>

                <div class="p-6 rounded-3xl bg-slate-50 border border-slate-200 space-y-3">
                    <div class="h-10 w-10 rounded-xl bg-indigo-600 text-white flex items-center justify-center font-black text-sm">
                        03
                    </div>
                    <h3 class="text-base font-black text-slate-900">30-Day Freshness Re-check</h3>
                    <p class="text-xs text-slate-600 leading-relaxed">
                        Every listing is valid for <strong>30 days</strong>. If the landlord does not confirm vacancy and active status, the listing is automatically unlisted to prevent dead inventory.
                    </p>
                </div>
            </div>
        </div>
    </section>

    <!-- ═══════════════════════════════════════════════════════════════════ -->
    <!-- BADGE MEANINGS & HIERARCHY -->
    <!-- ═══════════════════════════════════════════════════════════════════ -->
    <section class="py-16">
        <div class="site-shell px-6 sm:px-8">
            <div class="max-w-3xl mx-auto text-center mb-12">
                <span class="text-xs font-bold text-emerald-700 uppercase tracking-widest block mb-2">Visual Transparency</span>
                <h2 class="text-2xl sm:text-4xl font-black text-slate-900 tracking-tight">
                    What Do HomiQ Badges Mean?
                </h2>
                <p class="text-sm text-slate-600 mt-2">
                    Every badge on our cards represents verified ground proof, not a paid marketing upgrade.
                </p>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                <div class="p-6 rounded-3xl bg-white border border-slate-200 shadow-2xs space-y-3">
                    <span class="px-3 py-1 rounded-full bg-emerald-50 text-emerald-800 text-xs font-bold border border-emerald-300 inline-flex items-center gap-1">
                        <span class="material-symbols-outlined text-sm text-emerald-600">verified</span>
                        Verified Listing
                    </span>
                    <h3 class="text-base font-black text-slate-900">Verified Listing</h3>
                    <p class="text-xs text-slate-600 leading-relaxed">
                        Indicates that the listing has passed HomiQ's full 4-point verification protocol (Identity, Physical GPS, Photos, and Utility/Title check).
                    </p>
                </div>

                <div class="p-6 rounded-3xl bg-white border border-slate-200 shadow-2xs space-y-3">
                    <span class="px-3 py-1 rounded-full bg-emerald-700 text-white text-xs font-bold inline-flex items-center gap-1">
                        <span class="material-symbols-outlined text-sm">verified_user</span>
                        Listed by Owner
                    </span>
                    <h3 class="text-base font-black text-slate-900">Listed by Owner</h3>
                    <p class="text-xs text-slate-600 leading-relaxed">
                        Direct landlord posting. Seekers deal directly with the genuine title holder with zero intermediary broker fees.
                    </p>
                </div>

                <div class="p-6 rounded-3xl bg-white border border-slate-200 shadow-2xs space-y-3">
                    <span class="px-3 py-1 rounded-full bg-blue-700 text-white text-xs font-bold inline-flex items-center gap-1">
                        <span class="material-symbols-outlined text-sm">business</span>
                        Verified Agent
                    </span>
                    <h3 class="text-base font-black text-slate-900">Verified Agent</h3>
                    <p class="text-xs text-slate-600 leading-relaxed">
                        Authorized property representative or builder channel partner with verified authorization letter and RERA compliance credentials.
                    </p>
                </div>
            </div>
        </div>
    </section>

    <!-- ═══════════════════════════════════════════════════════════════════ -->
    <!-- REPORT FRAUD WORKFLOW -->
    <!-- ═══════════════════════════════════════════════════════════════════ -->
    <section class="py-16 bg-slate-900 text-white">
        <div class="site-shell px-6 sm:px-8">
            <div class="grid grid-cols-1 lg:grid-cols-12 gap-10 items-center">
                <div class="lg:col-span-8 space-y-4">
                    <span class="px-3 py-1 rounded-full bg-rose-500/20 text-rose-400 border border-rose-500/30 text-xs font-bold uppercase tracking-wider inline-flex items-center gap-1.5">
                        <span class="material-symbols-outlined text-sm">flag</span>
                        Zero Tolerance Policy
                    </span>
                    <h2 class="text-2xl sm:text-4xl font-black tracking-tight">
                        Found a Suspicious Listing? We Investigate in 4 Hours.
                    </h2>
                    <p class="text-xs sm:text-sm text-slate-300 leading-relaxed max-w-2xl">
                        If a landlord asks for unexpected brokerage, demands upfront money before physical visit, or the flat doesn't match the photos, report it immediately. Reported properties are suspended pending re-audit.
                    </p>
                </div>

                <div class="lg:col-span-4 flex flex-col sm:flex-row lg:flex-col gap-3">
                    <a href="/contact" class="px-6 py-3.5 rounded-full bg-rose-500 hover:bg-rose-600 text-white font-bold text-xs text-center shadow-lg shadow-rose-500/20 transition">
                        Report a Listing / Fraud
                    </a>
                    <a href="/safety" class="px-6 py-3.5 rounded-full bg-white/10 hover:bg-white/20 text-white font-bold text-xs text-center border border-white/20 transition">
                        View Safety Guidelines
                    </a>
                </div>
            </div>
        </div>
    </section>

</div>
@endsection

