@extends('layouts.app')

@section('title', 'HomiQ Safety Center - Renter & Buyer Protection Guidelines')
@section('meta_description', 'Essential real estate safety tips: how to avoid advance token scams, fake owner traps, verify landlord documents, and rent flats securely in India.')

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
                <span class="text-slate-900 font-bold">Safety Center</span>
            </nav>

            <div class="max-w-3xl">
                <span class="px-3.5 py-1.5 rounded-full bg-emerald-50 text-emerald-800 text-xs font-bold border border-emerald-200 uppercase tracking-wider inline-flex items-center gap-1.5 mb-4 shadow-2xs">
                    <span class="material-symbols-outlined text-sm text-emerald-600">shield</span>
                    Renter &amp; Buyer Protection
                </span>
                <h1 class="text-3xl sm:text-5xl font-black text-slate-900 tracking-tight leading-tight mb-4">
                    HomiQ Safety Center &amp; Fraud Prevention
                </h1>
                <p class="text-sm sm:text-base text-slate-600 leading-relaxed font-medium">
                    Your safety is our highest priority. Follow these fundamental security guidelines to protect yourself from rental scams, fake landlord impersonators, and fraudulent payment traps.
                </p>
            </div>
        </div>
    </section>

    <!-- ═══════════════════════════════════════════════════════════════════ -->
    <!-- 8 CORE SAFETY RULES -->
    <!-- ═══════════════════════════════════════════════════════════════════ -->
    <section class="py-16">
        <div class="site-shell px-6 sm:px-8">
            <div class="text-center max-w-2xl mx-auto mb-14">
                <span class="text-xs font-bold text-emerald-700 uppercase tracking-widest block mb-2">Golden Rules</span>
                <h2 class="text-2xl sm:text-4xl font-black text-slate-900 tracking-tight">
                    8 Essential Rules for Safe Renting &amp; Buying
                </h2>
                <p class="text-sm text-slate-600 mt-2">
                    Never compromise on these rules when searching for flats, rooms, or commercial spaces.
                </p>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
                <!-- Rule 1 -->
                <div class="p-6 rounded-3xl bg-white border border-slate-200 shadow-2xs hover:shadow-soft transition space-y-3">
                    <div class="h-10 w-10 rounded-2xl bg-rose-50 text-rose-600 border border-rose-200 flex items-center justify-center">
                        <span class="material-symbols-outlined text-xl">block</span>
                    </div>
                    <h3 class="text-base font-black text-slate-900">1. Never Pay Before Physical Visit</h3>
                    <p class="text-xs text-slate-600 leading-relaxed">
                        Never transfer token money, booking amounts, or visit fees before meeting the landlord in person and stepping inside the flat.
                    </p>
                </div>

                <!-- Rule 2 -->
                <div class="p-6 rounded-3xl bg-white border border-slate-200 shadow-2xs hover:shadow-soft transition space-y-3">
                    <div class="h-10 w-10 rounded-2xl bg-amber-50 text-amber-700 border border-amber-200 flex items-center justify-center">
                        <span class="material-symbols-outlined text-xl">qr_code_scanner</span>
                    </div>
                    <h3 class="text-base font-black text-slate-900">2. Avoid Suspicious QR Code Scams</h3>
                    <p class="text-xs text-slate-600 leading-relaxed">
                        Beware of fraudsters claiming to send money via UPI QR codes that actually debit your account. Entering your UPI PIN always sends money.
                    </p>
                </div>

                <!-- Rule 3 -->
                <div class="p-6 rounded-3xl bg-white border border-slate-200 shadow-2xs hover:shadow-soft transition space-y-3">
                    <div class="h-10 w-10 rounded-2xl bg-indigo-50 text-indigo-700 border border-indigo-200 flex items-center justify-center">
                        <span class="material-symbols-outlined text-xl">wb_sunny</span>
                    </div>
                    <h3 class="text-base font-black text-slate-900">3. Visit in Daylight &amp; Bring a Friend</h3>
                    <p class="text-xs text-slate-600 leading-relaxed">
                        Always schedule property viewings during daylight hours. If possible, bring a friend, family member, or colleague along for safety.
                    </p>
                </div>

                <!-- Rule 4 -->
                <div class="p-6 rounded-3xl bg-white border border-slate-200 shadow-2xs hover:shadow-soft transition space-y-3">
                    <div class="h-10 w-10 rounded-2xl bg-emerald-50 text-emerald-700 border border-emerald-200 flex items-center justify-center">
                        <span class="material-symbols-outlined text-xl">fact_check</span>
                    </div>
                    <h3 class="text-base font-black text-slate-900">4. Verify Documents &amp; Utility Bills</h3>
                    <p class="text-xs text-slate-600 leading-relaxed">
                        Ask to see a recent electricity bill, maintenance receipt, or property tax challan with the landlord's name before handing over security deposits.
                    </p>
                </div>

                <!-- Rule 5 -->
                <div class="p-6 rounded-3xl bg-white border border-slate-200 shadow-2xs hover:shadow-soft transition space-y-3">
                    <div class="h-10 w-10 rounded-2xl bg-rose-50 text-rose-600 border border-rose-200 flex items-center justify-center">
                        <span class="material-symbols-outlined text-xl">person_alert</span>
                    </div>
                    <h3 class="text-base font-black text-slate-900">5. Beware of "Remote Landlord" Traps</h3>
                    <p class="text-xs text-slate-600 leading-relaxed">
                        Scammers often claim to be "army officers transferred to a remote base" or "NRIs in London" who promise to courier keys upon paying a deposit.
                    </p>
                </div>

                <!-- Rule 6 -->
                <div class="p-6 rounded-3xl bg-white border border-slate-200 shadow-2xs hover:shadow-soft transition space-y-3">
                    <div class="h-10 w-10 rounded-2xl bg-slate-100 text-slate-800 border border-slate-200 flex items-center justify-center">
                        <span class="material-symbols-outlined text-xl">password</span>
                    </div>
                    <h3 class="text-base font-black text-slate-900">6. Never Share OTPs or Passwords</h3>
                    <p class="text-xs text-slate-600 leading-relaxed">
                        HomiQ representatives will never ask for your one-time passwords (OTPs), bank passwords, or debit card CVV numbers under any circumstances.
                    </p>
                </div>

                <!-- Rule 7 -->
                <div class="p-6 rounded-3xl bg-white border border-slate-200 shadow-2xs hover:shadow-soft transition space-y-3">
                    <div class="h-10 w-10 rounded-2xl bg-blue-50 text-blue-700 border border-blue-200 flex items-center justify-center">
                        <span class="material-symbols-outlined text-xl">edit_document</span>
                    </div>
                    <h3 class="text-base font-black text-slate-900">7. Sign a Formal Rent Agreement</h3>
                    <p class="text-xs text-slate-600 leading-relaxed">
                        Always execute an 11-month registered or notarized rent agreement clearly outlining the security deposit refund timeline and maintenance terms.
                    </p>
                </div>

                <!-- Rule 8 -->
                <div class="p-6 rounded-3xl bg-white border border-slate-200 shadow-2xs hover:shadow-soft transition space-y-3">
                    <div class="h-10 w-10 rounded-2xl bg-rose-50 text-rose-700 border border-rose-200 flex items-center justify-center">
                        <span class="material-symbols-outlined text-xl">flag</span>
                    </div>
                    <h3 class="text-base font-black text-slate-900">8. Report Suspicious Listings</h3>
                    <p class="text-xs text-slate-600 leading-relaxed">
                        If a user demands offline broker commission, claims prices lower than market realities, or asks for strange advance fees, report the listing immediately.
                    </p>
                </div>
            </div>
        </div>
    </section>

    <!-- ═══════════════════════════════════════════════════════════════════ -->
    <!-- SCAM ANATOMY: COMMON TRAPS -->
    <!-- ═══════════════════════════════════════════════════════════════════ -->
    <section class="py-16 bg-white border-y border-slate-200">
        <div class="site-shell px-6 sm:px-8">
            <div class="max-w-3xl mx-auto text-center mb-12">
                <span class="text-xs font-bold text-rose-600 uppercase tracking-widest block mb-2">Red Flags</span>
                <h2 class="text-2xl sm:text-4xl font-black text-slate-900 tracking-tight">
                    Common Real Estate Scams to Watch Out For
                </h2>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                <div class="p-6 rounded-3xl bg-slate-50 border border-slate-200 space-y-3">
                    <h3 class="text-base font-black text-slate-900 flex items-center gap-2">
                        <span class="material-symbols-outlined text-rose-600 text-lg">warning</span>
                        The "Gate Pass / Key Deposit" Scam
                    </h3>
                    <p class="text-xs text-slate-600 leading-relaxed">
                        The fraudster tells you that society security requires a ₹2,000 "gate pass registration fee" before showing the flat, promising it will be refunded immediately. <strong>Legitimate societies never charge prospective tenants a gate pass fee.</strong>
                    </p>
                </div>

                <div class="p-6 rounded-3xl bg-slate-50 border border-slate-200 space-y-3">
                    <h3 class="text-base font-black text-slate-900 flex items-center gap-2">
                        <span class="material-symbols-outlined text-rose-600 text-lg">warning</span>
                        The "Urgent Army Transfer" Scam
                    </h3>
                    <p class="text-xs text-slate-600 leading-relaxed">
                        A scammer poses as an Indian Army officer posted to a remote border base, offering a fully-furnished luxury flat in Noida at half the market rent. They send forged military ID cards to gain your trust and ask for advance token money.
                    </p>
                </div>

                <div class="p-6 rounded-3xl bg-slate-50 border border-slate-200 space-y-3">
                    <h3 class="text-base font-black text-slate-900 flex items-center gap-2">
                        <span class="material-symbols-outlined text-rose-600 text-lg">warning</span>
                        The "Phantom Broker" Trap
                    </h3>
                    <p class="text-xs text-slate-600 leading-relaxed">
                        An unauthorized broker copies photos of a direct owner listing, republishes it with their phone number, and demands a 1-month commission upon visit. Always verify that you are connecting with a <strong>Verified Owner</strong> on HomiQ.
                    </p>
                </div>
            </div>
        </div>
    </section>

    <!-- ═══════════════════════════════════════════════════════════════════ -->
    <!-- EMERGENCY & HELPLINE CONTACTS -->
    <!-- ═══════════════════════════════════════════════════════════════════ -->
    <section class="py-16">
        <div class="site-shell px-6 sm:px-8">
            <div class="p-8 sm:p-12 rounded-3xl bg-slate-900 text-white shadow-xl grid grid-cols-1 lg:grid-cols-12 gap-8 items-center">
                <div class="lg:col-span-8 space-y-4">
                    <span class="px-3.5 py-1.5 rounded-full bg-emerald-500/20 text-emerald-400 border border-emerald-500/30 text-xs font-bold uppercase tracking-wider inline-flex items-center gap-1.5">
                        <span class="material-symbols-outlined text-sm">support_agent</span>
                        Emergency &amp; Cyber Crime Helplines
                    </span>
                    <h2 class="text-2xl sm:text-3xl font-black tracking-tight">
                        Encountered Financial Fraud or Identity Theft?
                    </h2>
                    <p class="text-xs sm:text-sm text-slate-300 leading-relaxed max-w-2xl">
                        If you have been targeted by an online financial scam, immediately report it to the National Cyber Crime Reporting Portal and inform the HomiQ Trust &amp; Safety desk.
                    </p>
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 pt-2 text-xs">
                        <div class="p-3.5 rounded-2xl bg-white/5 border border-white/10">
                            <span class="text-slate-400 block text-[11px]">National Cyber Crime Helpline:</span>
                            <strong class="text-emerald-400 text-sm font-bold">Dial 1930 / cybercrime.gov.in</strong>
                        </div>
                        <div class="p-3.5 rounded-2xl bg-white/5 border border-white/10">
                            <span class="text-slate-400 block text-[11px]">HomiQ Safety Desk:</span>
                            <strong class="text-emerald-400 text-sm font-bold">safety@homiq.com</strong>
                        </div>
                    </div>
                </div>

                <div class="lg:col-span-4 flex flex-col gap-3">
                    <a href="/contact" class="px-6 py-3.5 rounded-full bg-emerald-600 hover:bg-emerald-700 text-white font-bold text-xs text-center shadow-md transition">
                        Report an Incident
                    </a>
                    <a href="/verification-standards" class="px-6 py-3.5 rounded-full bg-white/10 hover:bg-white/20 text-white font-bold text-xs text-center border border-white/20 transition">
                        Our Verification Standards
                    </a>
                </div>
            </div>
        </div>
    </section>

</div>

<!-- Structured Data (JSON-LD) -->
<script type="application/ld+json">
{
    "@@context": "https://schema.org",
    "@@type": "WebPage",
    "name": "HomiQ Safety Center - Real Estate Fraud Prevention",
    "description": "Essential guidelines for avoiding real estate rental scams, verifying landlord identity, and secure flat leasing.",
    "publisher": {
        "@@type": "Organization",
        "name": "HomiQ"
    }
}
</script>
@endsection

