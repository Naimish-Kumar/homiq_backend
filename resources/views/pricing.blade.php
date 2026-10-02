@extends('layouts.app')

@section('content')
<div class="min-h-screen bg-slate-50/70 py-16 sm:py-24 px-4 sm:px-6 lg:px-8">
    <div class="max-w-6xl mx-auto">
        
        <!-- Header Section -->
        <div class="text-center max-w-2xl mx-auto mb-16 sm:mb-20">
            <div class="inline-flex items-center gap-2 px-3.5 py-1 rounded-full bg-white shadow-xs border border-slate-200 mb-4">
                <span class="w-2 h-2 rounded-full bg-emerald-500"></span>
                <span class="text-xs font-semibold text-slate-800">Direct Owners &amp; Hosts</span>
                <span class="text-slate-300">&bull;</span>
                <span class="text-xs font-bold text-emerald-700">0% Commission</span>
            </div>
            
            <h1 class="text-3xl sm:text-5xl font-extrabold text-slate-900 tracking-tight leading-tight mb-4">
                Simple, Transparent Owner Packages
            </h1>
            
            <p class="text-slate-600 text-sm sm:text-base font-normal leading-relaxed">
                Tenants and buyers browse 100% free forever. If you are an owner, builder, or host listing properties, choose the right package to scale your reach.
            </p>
        </div>

        <!-- Pricing Cards Grid -->
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8 items-stretch max-w-5xl mx-auto mb-20">
            
            <!-- Tier 1: Free Starter -->
            <div class="bg-white rounded-3xl border border-slate-200 hover:border-slate-300 p-8 sm:p-9 flex flex-col justify-between shadow-xs hover:shadow-md transition-all duration-300">
                <div>
                    <div class="flex items-center justify-between mb-4">
                        <span class="text-xs font-extrabold text-slate-500 uppercase tracking-wider">Free Starter</span>
                    </div>
                    
                    <div class="flex items-baseline gap-1 mb-2">
                        <span class="text-4xl sm:text-5xl font-extrabold text-slate-900 tracking-tight">₹0</span>
                        <span class="text-xs font-semibold text-slate-500">/ forever</span>
                    </div>
                    <p class="text-xs text-slate-500 mb-8 font-normal">Ideal for individual owners with a single rental home or PG room.</p>
                    
                    <div class="space-y-4 pt-6 border-t border-slate-100">
                        <div class="flex items-start gap-3">
                            <span class="material-symbols-outlined text-emerald-600 text-[18px] shrink-0 mt-0.5">check_circle</span>
                            <span class="text-xs font-medium text-slate-700 leading-relaxed">List up to <strong class="text-slate-900 font-bold">10 Properties</strong></span>
                        </div>
                        <div class="flex items-start gap-3">
                            <span class="material-symbols-outlined text-emerald-600 text-[18px] shrink-0 mt-0.5">check_circle</span>
                            <span class="text-xs font-medium text-slate-700 leading-relaxed">Direct WhatsApp &amp; In-App Inquiries</span>
                        </div>
                        <div class="flex items-start gap-3">
                            <span class="material-symbols-outlined text-emerald-600 text-[18px] shrink-0 mt-0.5">check_circle</span>
                            <span class="text-xs font-medium text-slate-700 leading-relaxed">Browse Unlimited Tenant Requests</span>
                        </div>
                        <div class="flex items-start gap-3">
                            <span class="material-symbols-outlined text-emerald-600 text-[18px] shrink-0 mt-0.5">check_circle</span>
                            <span class="text-xs font-medium text-slate-700 leading-relaxed">Standard Verification Review</span>
                        </div>
                    </div>
                </div>

                <div class="mt-10 pt-6">
                    @auth
                        @if(Auth::user()->subscription_plan === 'free')
                            <div class="w-full py-3.5 bg-slate-100 text-slate-500 font-bold text-xs rounded-xl text-center cursor-default border border-slate-200">
                                Active Package
                            </div>
                        @else
                            <form action="/upgrade-subscription" method="POST" class="m-0">
                                @csrf
                                <input type="hidden" name="plan" value="free">
                                <button type="submit" class="w-full py-3.5 bg-white hover:bg-slate-50 text-slate-700 font-bold text-xs rounded-xl border border-slate-200 transition-colors cursor-pointer">
                                    Downgrade to Free
                                </button>
                            </form>
                        @endif
                    @else
                        <a href="/login" class="block w-full py-3.5 bg-white hover:bg-slate-50 text-slate-700 font-bold text-xs rounded-xl border border-slate-200 text-center transition-colors">
                            Sign In to Choose
                        </a>
                    @endauth
                </div>
            </div>

            <!-- Tier 2: Standard Growth (Most Popular) -->
            <div class="bg-white rounded-3xl border-2 border-slate-900 p-8 sm:p-9 flex flex-col justify-between shadow-xl shadow-slate-900/5 relative transform lg:-translate-y-2">
                <!-- Floating Popular Badge -->
                <div class="absolute -top-3.5 left-1/2 -translate-x-1/2 bg-slate-900 text-white text-[10px] font-extrabold uppercase tracking-wider px-4 py-1 rounded-full shadow-sm flex items-center gap-1.5 border border-slate-800">
                    <span class="w-1.5 h-1.5 rounded-full bg-emerald-400"></span>
                    <span>Most Popular</span>
                </div>

                <div>
                    <div class="flex items-center justify-between mb-4 mt-2">
                        <span class="text-xs font-extrabold text-slate-900 uppercase tracking-wider">Standard Growth</span>
                        <span class="px-2 py-0.5 rounded-full bg-emerald-50 text-emerald-700 text-[10px] font-bold border border-emerald-200">Save 20%</span>
                    </div>
                    
                    <div class="flex items-baseline gap-1 mb-2">
                        <span class="text-4xl sm:text-5xl font-extrabold text-slate-900 tracking-tight">₹499</span>
                        <span class="text-xs font-semibold text-slate-500">/ month</span>
                    </div>
                    <p class="text-xs text-slate-500 mb-8 font-normal">Best for active landlords and property managers seeking rapid occupancy.</p>
                    
                    <div class="space-y-4 pt-6 border-t border-slate-100">
                        <div class="flex items-start gap-3">
                            <span class="material-symbols-outlined text-emerald-600 text-[18px] shrink-0 mt-0.5">check_circle</span>
                            <span class="text-xs font-medium text-slate-700 leading-relaxed">List up to <strong class="text-slate-900 font-bold">50 Properties</strong></span>
                        </div>
                        <div class="flex items-start gap-3">
                            <span class="material-symbols-outlined text-emerald-600 text-[18px] shrink-0 mt-0.5">check_circle</span>
                            <span class="text-xs font-medium text-slate-700 leading-relaxed"><strong class="text-slate-900 font-bold">Verified Owner Badge</strong> on all spaces</span>
                        </div>
                        <div class="flex items-start gap-3">
                            <span class="material-symbols-outlined text-emerald-600 text-[18px] shrink-0 mt-0.5">check_circle</span>
                            <span class="text-xs font-medium text-slate-700 leading-relaxed">Direct Priority Broadcast in <strong class="text-slate-900 font-bold">Demand Board</strong></span>
                        </div>
                        <div class="flex items-start gap-3">
                            <span class="material-symbols-outlined text-emerald-600 text-[18px] shrink-0 mt-0.5">check_circle</span>
                            <span class="text-xs font-medium text-slate-700 leading-relaxed">Instant WhatsApp Contact Lead Notifications</span>
                        </div>
                        <div class="flex items-start gap-3">
                            <span class="material-symbols-outlined text-emerald-600 text-[18px] shrink-0 mt-0.5">check_circle</span>
                            <span class="text-xs font-medium text-slate-700 leading-relaxed">Standard Support Response (Within 2h)</span>
                        </div>
                    </div>
                </div>

                <div class="mt-10 pt-6">
                    @auth
                        @if(Auth::user()->subscription_plan === 'standard')
                            <div class="w-full py-3.5 bg-slate-100 text-slate-500 font-bold text-xs rounded-xl text-center cursor-default border border-slate-200">
                                Active Package
                            </div>
                        @else
                            <button type="button" onclick="payWithRazorpay('standard')" class="w-full py-3.5 bg-slate-900 hover:bg-slate-800 text-white font-bold text-xs rounded-xl shadow-sm transition-all duration-200 cursor-pointer">
                                Buy Standard Package
                            </button>
                        @endif
                    @else
                        <a href="/login" class="block w-full py-3.5 bg-slate-900 hover:bg-slate-800 text-white font-bold text-xs rounded-xl text-center shadow-sm transition-all duration-200">
                            Sign In to Buy Standard
                        </a>
                    @endauth
                </div>
            </div>

            <!-- Tier 3: Unlimited Pro -->
            <div class="bg-white rounded-3xl border border-slate-200 hover:border-slate-300 p-8 sm:p-9 flex flex-col justify-between shadow-xs hover:shadow-md transition-all duration-300">
                <div>
                    <div class="flex items-center justify-between mb-4">
                        <span class="text-xs font-extrabold text-slate-500 uppercase tracking-wider">Unlimited Pro</span>
                        <span class="px-2 py-0.5 rounded-full bg-slate-100 text-slate-700 text-[10px] font-bold">Portfolios &amp; Brokers</span>
                    </div>
                    
                    <div class="flex items-baseline gap-1 mb-2">
                        <span class="text-4xl sm:text-5xl font-extrabold text-slate-900 tracking-tight">₹999</span>
                        <span class="text-xs font-semibold text-slate-500">/ month</span>
                    </div>
                    <p class="text-xs text-slate-500 mb-8 font-normal">Designed for commercial builders, co-living operators, and real estate agencies.</p>
                    
                    <div class="space-y-4 pt-6 border-t border-slate-100">
                        <div class="flex items-start gap-3">
                            <span class="material-symbols-outlined text-emerald-600 text-[18px] shrink-0 mt-0.5">check_circle</span>
                            <span class="text-xs font-medium text-slate-700 leading-relaxed"><strong class="text-slate-900 font-bold">Unlimited Property Listings</strong></span>
                        </div>
                        <div class="flex items-start gap-3">
                            <span class="material-symbols-outlined text-emerald-600 text-[18px] shrink-0 mt-0.5">check_circle</span>
                            <span class="text-xs font-medium text-slate-700 leading-relaxed"><strong class="text-slate-900 font-bold">Top Featured Placement</strong> on Search &amp; Locality Pages</span>
                        </div>
                        <div class="flex items-start gap-3">
                            <span class="material-symbols-outlined text-emerald-600 text-[18px] shrink-0 mt-0.5">check_circle</span>
                            <span class="text-xs font-medium text-slate-700 leading-relaxed">Automated Multi-Tenant Lead Matching</span>
                        </div>
                        <div class="flex items-start gap-3">
                            <span class="material-symbols-outlined text-emerald-600 text-[18px] shrink-0 mt-0.5">check_circle</span>
                            <span class="text-xs font-medium text-slate-700 leading-relaxed">24/7 Priority Support &amp; Listing Assistance</span>
                        </div>
                        <div class="flex items-start gap-3">
                            <span class="material-symbols-outlined text-emerald-600 text-[18px] shrink-0 mt-0.5">check_circle</span>
                            <span class="text-xs font-medium text-slate-700 leading-relaxed">Advanced Impression &amp; Inquiry Analytics</span>
                        </div>
                    </div>
                </div>

                <div class="mt-10 pt-6">
                    @auth
                        @if(Auth::user()->subscription_plan === 'unlimited')
                            <div class="w-full py-3.5 bg-slate-100 text-slate-500 font-bold text-xs rounded-xl text-center cursor-default border border-slate-200">
                                Active Package
                            </div>
                        @else
                            <button type="button" onclick="payWithRazorpay('unlimited')" class="w-full py-3.5 bg-white hover:bg-slate-50 text-slate-900 font-bold text-xs rounded-xl border border-slate-300 transition-colors cursor-pointer">
                                Buy Unlimited Pro
                            </button>
                        @endif
                    @else
                        <a href="/login" class="block w-full py-3.5 bg-white hover:bg-slate-50 text-slate-900 font-bold text-xs rounded-xl border border-slate-300 text-center transition-colors">
                            Sign In to Buy Pro
                        </a>
                    @endauth
                </div>
            </div>

        </div>

        <!-- Trust & Guarantee Grid -->
        <div class="bg-white rounded-3xl border border-slate-200 p-8 sm:p-10 max-w-5xl mx-auto mb-16 shadow-xs">
            <h3 class="text-lg font-bold text-slate-900 text-center mb-8">Why List on HomiQ?</h3>
            
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
                <div class="flex flex-col items-center text-center">
                    <div class="w-10 h-10 rounded-2xl bg-slate-100 text-slate-800 flex items-center justify-center mb-3">
                        <span class="material-symbols-outlined text-[20px]">money_off</span>
                    </div>
                    <h4 class="text-xs font-bold text-slate-900 mb-1">0% Brokerage</h4>
                    <p class="text-[11px] text-slate-500 font-normal leading-relaxed">Direct connection between landlords and verified tenants.</p>
                </div>

                <div class="flex flex-col items-center text-center">
                    <div class="w-10 h-10 rounded-2xl bg-slate-100 text-slate-800 flex items-center justify-center mb-3">
                        <span class="material-symbols-outlined text-[20px]">bolt</span>
                    </div>
                    <h4 class="text-xs font-bold text-slate-900 mb-1">Instant Activation</h4>
                    <p class="text-[11px] text-slate-500 font-normal leading-relaxed">Package limits and verified badges take effect immediately.</p>
                </div>

                <div class="flex flex-col items-center text-center">
                    <div class="w-10 h-10 rounded-2xl bg-slate-100 text-slate-800 flex items-center justify-center mb-3">
                        <span class="material-symbols-outlined text-[20px]">chat</span>
                    </div>
                    <h4 class="text-xs font-bold text-slate-900 mb-1">Direct WhatsApp Leads</h4>
                    <p class="text-[11px] text-slate-500 font-normal leading-relaxed">Real seekers message you directly without intermediaries.</p>
                </div>

                <div class="flex flex-col items-center text-center">
                    <div class="w-10 h-10 rounded-2xl bg-slate-100 text-slate-800 flex items-center justify-center mb-3">
                        <span class="material-symbols-outlined text-[20px]">cancel</span>
                    </div>
                    <h4 class="text-xs font-bold text-slate-900 mb-1">Cancel Anytime</h4>
                    <p class="text-[11px] text-slate-500 font-normal leading-relaxed">No lock-ins or contracts. Switch plans whenever you need.</p>
                </div>
            </div>
        </div>

        <!-- FAQ Section -->
        <div class="max-w-3xl mx-auto text-left">
            <h3 class="text-xl font-extrabold text-slate-900 text-center mb-8">Frequently Asked Questions</h3>
            
            <div class="space-y-4">
                <div class="p-5 rounded-2xl bg-white border border-slate-200">
                    <h4 class="text-xs font-bold text-slate-900 mb-1.5">Do tenants or buyers have to pay for a subscription?</h4>
                    <p class="text-xs text-slate-600 font-normal leading-relaxed">No. Browsing, scheduling physical visits, and contacting owners on HomiQ is 100% free with 0% brokerage.</p>
                </div>

                <div class="p-5 rounded-2xl bg-white border border-slate-200">
                    <h4 class="text-xs font-bold text-slate-900 mb-1.5">How does the Tenant Demand Board matching work?</h4>
                    <p class="text-xs text-slate-600 font-normal leading-relaxed">When verified seekers post their specific BHK, budget, and locality requirements, standard and pro hosts can view and match their vacant properties instantly.</p>
                </div>

                <div class="p-5 rounded-2xl bg-white border border-slate-200">
                    <h4 class="text-xs font-bold text-slate-900 mb-1.5">Which payment methods are supported?</h4>
                    <p class="text-xs text-slate-600 font-normal leading-relaxed">We support all major payment options via Razorpay including UPI (Google Pay, PhonePe, Paytm), Credit/Debit Cards, and Net Banking.</p>
                </div>
            </div>
        </div>

    </div>
</div>

<!-- Forms for verification fallback -->
<form id="razorpay-response-form" action="/pricing/razorpay/verify" method="POST" style="display: none;">
    @csrf
    <input type="hidden" name="razorpay_order_id" id="form-order-id">
    <input type="hidden" name="razorpay_payment_id" id="form-payment-id">
    <input type="hidden" name="razorpay_signature" id="form-signature">
    <input type="hidden" name="plan" id="form-plan">
</form>

<!-- Razorpay Script Integration -->
<script src="https://checkout.razorpay.com/v1/checkout.js"></script>
<script>
    function payWithRazorpay(plan) {
        // 1. Fetch Order ID from Backend via AJAX
        fetch('/pricing/razorpay/create-order', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': '{{ csrf_token() }}',
                'Accept': 'application/json'
            },
            body: JSON.stringify({ plan: plan })
        })
        .then(response => {
            if (!response.ok) {
                throw new Error('Order creation failed.');
            }
            return response.json();
        })
        .then(data => {
            // 2. Open Razorpay Billing Sheet Overlay
            var options = {
                "key": "{{ config('services.razorpay.key_id') ?? env('RAZORPAY_KEY_ID') }}",
                "amount": data.amount,
                "currency": data.currency,
                "name": "HomiQ Subscriptions",
                "description": plan.toUpperCase() + " Plan Upgrade",
                "image": "{{ url('/logo.png') }}",
                "order_id": data.id,
                "handler": function (response){
                    // 3. Post verification payload back to verify endpoint
                    document.getElementById('form-order-id').value = response.razorpay_order_id;
                    document.getElementById('form-payment-id').value = response.razorpay_payment_id;
                    document.getElementById('form-signature').value = response.razorpay_signature;
                    document.getElementById('form-plan').value = plan;
                    document.getElementById('razorpay-response-form').submit();
                },
                "prefill": {
                    "name": "{{ Auth::user() ? Auth::user()->name : '' }}",
                    "email": "{{ Auth::user() ? Auth::user()->email : '' }}",
                    "contact": "{{ Auth::user() ? Auth::user()->phone : '' }}"
                },
                "theme": {
                    "color": "#0F172A"
                }
            };
            var rzp = new Razorpay(options);
            rzp.on('payment.failed', function (response){
                alert("Payment Failed! " + response.error.description);
            });
            rzp.open();
        })
        .catch(error => {
            console.error(error);
            alert("Error preparing order details. Please try again.");
        });
    }
</script>
@endsection
