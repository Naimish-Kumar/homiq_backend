@extends('layouts.app')

@section('content')
<div class="min-h-screen bg-gradient-to-b from-[#f5f8fc] to-white py-20 px-6">
    <div class="max-w-7xl mx-auto text-center">
        <span class="text-xs font-black uppercase tracking-widest text-[#133e74] bg-[#133e74]/10 px-4 py-1.5 rounded-full mb-4 inline-block">Pricing Plans</span>
        <h1 class="text-4xl md:text-6xl font-black text-[#1a2d42] tracking-tight mb-4">Subscription Packages</h1>
        <p class="text-slate-500 text-sm md:text-base max-w-xl mx-auto mb-20 leading-relaxed">
            All customers can rent spaces by default. If you want to lease or list your own properties, choose a plan below.
        </p>

        <!-- Pricing Grid -->
        <div class="grid grid-cols-1 md:grid-cols-3 gap-8 max-w-5xl mx-auto items-stretch">
            
            <!-- Free Plan -->
            <div class="bg-white border border-slate-100 rounded-[32px] p-8 md:p-10 flex flex-col justify-between shadow-[0_15px_30px_rgba(0,0,0,0.01)] relative overflow-hidden transition-all duration-500 hover:-translate-y-2 hover:shadow-[0_30px_60px_rgba(0,0,0,0.04)] group">
                <div class="absolute inset-0 bg-gradient-to-b from-slate-50/50 to-transparent opacity-0 group-hover:opacity-100 transition-opacity duration-500"></div>
                <div class="relative z-10">
                    <span class="text-xs font-black text-slate-400 uppercase tracking-widest block mb-5">Free Starter</span>
                    <span class="text-7xl font-black text-[#1a2d42] block mb-2 tracking-tight">₹0</span>
                    <span class="text-xs text-slate-400 font-bold block mb-10">Free Forever</span>
                    
                    <div class="space-y-8 my-8">
                        <!-- Feature 1 -->
                        <div class="flex items-center gap-5">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="#00b074" stroke-width="5" stroke-linecap="round" stroke-linejoin="round" class="w-10 h-10 text-[#00b074] shrink-0">
                                <path d="M20 6L9 17l-5-5" />
                            </svg>
                            <div class="text-left text-sm text-slate-600 font-semibold leading-snug">
                                List <strong class="text-slate-900 font-extrabold text-base">10</strong><br>up to <strong class="text-slate-900 font-extrabold text-base">Properties</strong>
                            </div>
                        </div>
                        <!-- Feature 2 -->
                        <div class="flex items-center gap-5">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="#00b074" stroke-width="5" stroke-linecap="round" stroke-linejoin="round" class="w-10 h-10 text-[#00b074] shrink-0">
                                <path d="M20 6L9 17l-5-5" />
                            </svg>
                            <div class="text-left text-sm text-slate-600 font-semibold leading-snug">
                                Rent unlimited<br>spaces
                            </div>
                        </div>
                    </div>
                </div>
                
                <div class="mt-12 relative z-10">
                    @auth
                        @if(Auth::user()->subscription_plan === 'free')
                            <button disabled class="w-full py-4 bg-[#ebf0f6] text-[#8ea4be] font-bold text-sm rounded-2xl cursor-default transition duration-300">
                                Active Package
                            </button>
                        @else
                            <form action="/upgrade-subscription" method="POST" class="m-0">
                                @csrf
                                <input type="hidden" name="plan" value="free">
                                <button type="submit" class="w-full py-4 border border-[#dce4ec] hover:bg-[#133e74]/5 text-[#133e74] font-bold text-sm rounded-2xl transition duration-300">
                                    Downgrade to Free
                                </button>
                            </form>
                        @endif
                    @else
                        <a href="/login" class="block w-full py-4 border border-[#dce4ec] hover:bg-slate-50 text-slate-700 font-bold text-sm rounded-2xl transition duration-300">
                            Sign In
                        </a>
                    @endauth
                </div>
            </div>

            <!-- Standard Plan -->
            <div class="bg-white border-2 border-[#133e74] rounded-[32px] p-8 md:p-10 flex flex-col justify-between shadow-[0_20px_40px_rgba(19,62,116,0.03)] relative transition-all duration-500 hover:-translate-y-2 hover:shadow-[0_30px_60px_rgba(19,62,116,0.08)] group">
                <div class="absolute -top-3.5 left-1/2 -translate-x-1/2 bg-[#133e74] text-white text-[10px] font-black uppercase tracking-widest px-6 py-2 rounded-full shadow-md z-20">
                    Best Value
                </div>
                <div class="absolute inset-0 bg-gradient-to-b from-[#133e74]/5 to-transparent opacity-0 group-hover:opacity-100 transition-opacity duration-500 rounded-[30px]"></div>
                <div class="relative z-10">
                    <span class="text-xs font-black text-[#133e74] uppercase tracking-widest block mb-5 mt-2">Standard Growth</span>
                    <span class="text-7xl font-black text-[#1a2d42] block mb-2 tracking-tight">₹499</span>
                    <span class="text-xs text-slate-400 font-bold block mb-10">Per Month</span>
                    
                    <div class="space-y-8 my-8">
                        <!-- Feature 1 -->
                        <div class="flex items-center gap-5">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="#00b074" stroke-width="5" stroke-linecap="round" stroke-linejoin="round" class="w-10 h-10 text-[#00b074] shrink-0">
                                <path d="M20 6L9 17l-5-5" />
                            </svg>
                            <div class="text-left text-sm text-slate-600 font-semibold leading-snug">
                                List <strong class="text-slate-900 font-extrabold text-base">50</strong><br>up to <strong class="text-slate-900 font-extrabold text-base">Properties</strong>
                            </div>
                        </div>
                        <!-- Feature 2 -->
                        <div class="flex items-center gap-5">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="#00b074" stroke-width="5" stroke-linecap="round" stroke-linejoin="round" class="w-10 h-10 text-[#00b074] shrink-0">
                                <path d="M20 6L9 17l-5-5" />
                            </svg>
                            <div class="text-left text-sm text-slate-600 font-semibold leading-snug">
                                Standard<br>Support response
                            </div>
                        </div>
                        <!-- Feature 3 -->
                        <div class="flex items-center gap-5">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="#00b074" stroke-width="5" stroke-linecap="round" stroke-linejoin="round" class="w-10 h-10 text-[#00b074] shrink-0">
                                <path d="M20 6L9 17l-5-5" />
                            </svg>
                            <div class="text-left text-sm text-slate-600 font-semibold leading-snug">
                                Rent unlimited<br>spaces
                            </div>
                        </div>
                    </div>
                </div>
                
                <div class="mt-12 relative z-10">
                    @auth
                        @if(Auth::user()->subscription_plan === 'standard')
                            <button disabled class="w-full py-4 bg-[#ebf0f6] text-[#8ea4be] font-bold text-sm rounded-2xl cursor-default transition duration-300">
                                Active Package
                            </button>
                        @else
                            <button type="button" onclick="payWithRazorpay('standard')" class="w-full py-4 bg-[#133e74] hover:bg-[#0f325e] text-white font-bold text-sm rounded-2xl transition duration-300 shadow-md shadow-[#133e74]/15">
                                Buy Standard
                            </button>
                        @endif
                    @else
                        <a href="/login" class="block w-full py-4 bg-[#133e74] hover:bg-[#0f325e] text-white font-bold text-sm rounded-2xl transition duration-300 shadow-md shadow-[#133e74]/15">
                            Sign In to Buy
                        </a>
                    @endauth
                </div>
            </div>

            <!-- Unlimited Plan -->
            <div class="bg-white border border-slate-100 rounded-[32px] p-8 md:p-10 flex flex-col justify-between shadow-[0_15px_30px_rgba(0,0,0,0.01)] relative overflow-hidden transition-all duration-500 hover:-translate-y-2 hover:shadow-[0_30px_60px_rgba(0,0,0,0.04)] group">
                <div class="absolute inset-0 bg-gradient-to-b from-slate-50/50 to-transparent opacity-0 group-hover:opacity-100 transition-opacity duration-500"></div>
                <div class="relative z-10">
                    <span class="text-xs font-black text-slate-400 uppercase tracking-widest block mb-5">Unlimited Pro</span>
                    <span class="text-7xl font-black text-[#1a2d42] block mb-2 tracking-tight">₹999</span>
                    <span class="text-xs text-slate-400 font-bold block mb-10">Per Month</span>
                    
                    <div class="space-y-8 my-8">
                        <!-- Feature 1 -->
                        <div class="flex items-center gap-5">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="#00b074" stroke-width="5" stroke-linecap="round" stroke-linejoin="round" class="w-10 h-10 text-[#00b074] shrink-0">
                                <path d="M20 6L9 17l-5-5" />
                            </svg>
                            <div class="text-left text-sm text-slate-600 font-semibold leading-snug">
                                List <strong class="text-slate-900 font-extrabold text-base">Unlimited</strong><br><strong class="text-slate-900 font-extrabold text-base">Properties</strong>
                            </div>
                        </div>
                        <!-- Feature 2 -->
                        <div class="flex items-center gap-5">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="#00b074" stroke-width="5" stroke-linecap="round" stroke-linejoin="round" class="w-10 h-10 text-[#00b074] shrink-0">
                                <path d="M20 6L9 17l-5-5" />
                            </svg>
                            <div class="text-left text-sm text-slate-600 font-semibold leading-snug">
                                24/7 Priority<br>Support line
                            </div>
                        </div>
                        <!-- Feature 3 -->
                        <div class="flex items-center gap-5">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="#00b074" stroke-width="5" stroke-linecap="round" stroke-linejoin="round" class="w-10 h-10 text-[#00b074] shrink-0">
                                <path d="M20 6L9 17l-5-5" />
                            </svg>
                            <div class="text-left text-sm text-slate-600 font-semibold leading-snug">
                                Rent unlimited<br>spaces
                            </div>
                        </div>
                    </div>
                </div>
                
                <div class="mt-12 relative z-10">
                    @auth
                        @if(Auth::user()->subscription_plan === 'unlimited')
                            <button disabled class="w-full py-4 bg-[#ebf0f6] text-[#8ea4be] font-bold text-sm rounded-2xl cursor-default transition duration-300">
                                Active Package
                            </button>
                        @else
                            <button type="button" onclick="payWithRazorpay('unlimited')" class="w-full py-4 border border-[#dce4ec] hover:bg-[#133e74]/5 text-[#133e74] font-bold text-sm rounded-2xl transition duration-300">
                                Buy Unlimited
                            </button>
                        @endif
                    @else
                        <a href="/login" class="block w-full py-4 border border-[#dce4ec] hover:bg-[#133e74]/5 text-[#133e74] font-bold text-sm rounded-2xl transition duration-300">
                            Sign In to Buy
                        </a>
                    @endauth
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
                "image": "https://images.unsplash.com/photo-1560518883-ce09059eeffa?auto=format&fit=crop&w=100&h=100&q=80",
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
                    "color": "#4A6FA5"
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
