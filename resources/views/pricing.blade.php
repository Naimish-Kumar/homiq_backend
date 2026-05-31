@extends('layouts.app')

@section('content')
<div class="max-w-7xl mx-auto px-6 py-16 text-center">
    <h1 class="text-4xl md:text-5xl font-black text-slate-800 tracking-tight mb-4">Subscription Packages</h1>
    <p class="text-slate-500 text-sm md:text-base max-w-xl mx-auto mb-16">
        All customers can rent spaces by default. If you want to lease or list your own properties, choose a plan below.
    </p>

    <!-- Pricing Grid -->
    <div class="grid grid-cols-1 md:grid-cols-3 gap-8 max-w-5xl mx-auto">
        
        <!-- Free Plan -->
        <div class="bg-white border border-slate-100 rounded-3xl p-8 flex flex-col justify-between shadow-sm relative overflow-hidden transition-all duration-300 hover:-translate-y-1 hover:shadow-md">
            <div>
                <span class="text-xs font-bold text-slate-400 uppercase tracking-widest block mb-4">Free Starter</span>
                <span class="text-4xl font-extrabold text-slate-800 block mb-1">₹0</span>
                <span class="text-xs text-slate-400 font-medium">Free Forever</span>
                
                <div class="border-t border-slate-50 my-6"></div>
                
                <ul class="text-left text-xs text-slate-500 font-medium space-y-4">
                    <li class="flex items-center gap-2">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4.5 w-4.5 text-emerald-500" viewBox="0 0 20 20" fill="currentColor">
                            <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd" />
                        </svg>
                        List up to <strong class="text-slate-800">1 Property</strong>
                    </li>
                    <li class="flex items-center gap-2">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4.5 w-4.5 text-emerald-500" viewBox="0 0 20 20" fill="currentColor">
                            <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd" />
                        </svg>
                        Rent unlimited spaces
                    </li>
                </ul>
            </div>
            
            <div class="mt-8">
                @auth
                    @if(Auth::user()->subscription_plan === 'free')
                        <button disabled class="w-full py-3 bg-slate-100 text-slate-400 font-bold text-xs rounded-xl cursor-default">
                            Active Package
                        </button>
                    @else
                        <form action="/upgrade-subscription" method="POST" class="m-0">
                            @csrf
                            <input type="hidden" name="plan" value="free">
                            <button type="submit" class="w-full py-3 border border-slate-200 hover:bg-slate-50 text-slate-700 font-bold text-xs rounded-xl transition">
                                Downgrade to Free
                            </button>
                        </form>
                    @endif
                @else
                    <a href="/login" class="block w-full py-3 border border-slate-200 hover:bg-slate-50 text-slate-700 font-bold text-xs rounded-xl transition">
                        Sign In
                    </a>
                @endauth
            </div>
        </div>

        <!-- Standard Plan -->
        <div class="bg-white border-2 border-steelAzure rounded-3xl p-8 flex flex-col justify-between shadow-md relative overflow-hidden transition-all duration-300 hover:-translate-y-1 hover:shadow-lg">
            <div class="absolute top-0 right-0 bg-steelAzure text-white text-[9px] font-bold uppercase tracking-widest px-4 py-1.5 rounded-bl-2xl">
                Best Value
            </div>
            <div>
                <span class="text-xs font-bold text-steelAzure uppercase tracking-widest block mb-4">Standard Growth</span>
                <span class="text-4xl font-extrabold text-slate-800 block mb-1">₹499</span>
                <span class="text-xs text-slate-400 font-medium">Per Month</span>
                
                <div class="border-t border-slate-50 my-6"></div>
                
                <ul class="text-left text-xs text-slate-500 font-medium space-y-4">
                    <li class="flex items-center gap-2">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4.5 w-4.5 text-emerald-500" viewBox="0 0 20 20" fill="currentColor">
                            <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd" />
                        </svg>
                        List up to <strong class="text-slate-800">5 Properties</strong>
                    </li>
                    <li class="flex items-center gap-2">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4.5 w-4.5 text-emerald-500" viewBox="0 0 20 20" fill="currentColor">
                            <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd" />
                        </svg>
                        Standard Support response
                    </li>
                    <li class="flex items-center gap-2">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4.5 w-4.5 text-emerald-500" viewBox="0 0 20 20" fill="currentColor">
                            <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd" />
                        </svg>
                        Rent unlimited spaces
                    </li>
                </ul>
            </div>
            
            <div class="mt-8">
                @auth
                    @if(Auth::user()->subscription_plan === 'standard')
                        <button disabled class="w-full py-3 bg-slate-100 text-slate-400 font-bold text-xs rounded-xl cursor-default">
                            Active Package
                        </button>
                    @else
                        <button type="button" onclick="payWithRazorpay('standard')" class="w-full py-3 bg-steelAzure hover:bg-steelAzure/95 text-white font-bold text-xs rounded-xl transition shadow-md shadow-steelAzure/10">
                            Buy Standard
                        </button>
                    @endif
                @else
                    <a href="/login" class="block w-full py-3 bg-steelAzure hover:bg-steelAzure/95 text-white font-bold text-xs rounded-xl transition shadow-md shadow-steelAzure/10">
                        Sign In to Buy
                    </a>
                @endauth
            </div>
        </div>

        <!-- Unlimited Plan -->
        <div class="bg-white border border-slate-100 rounded-3xl p-8 flex flex-col justify-between shadow-sm relative overflow-hidden transition-all duration-300 hover:-translate-y-1 hover:shadow-md">
            <div>
                <span class="text-xs font-bold text-slate-400 uppercase tracking-widest block mb-4">Unlimited Pro</span>
                <span class="text-4xl font-extrabold text-slate-800 block mb-1">₹999</span>
                <span class="text-xs text-slate-400 font-medium">Per Month</span>
                
                <div class="border-t border-slate-50 my-6"></div>
                
                <ul class="text-left text-xs text-slate-500 font-medium space-y-4">
                    <li class="flex items-center gap-2">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4.5 w-4.5 text-emerald-500" viewBox="0 0 20 20" fill="currentColor">
                            <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd" />
                        </svg>
                        List <strong class="text-slate-800">Unlimited Properties</strong>
                    </li>
                    <li class="flex items-center gap-2">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4.5 w-4.5 text-emerald-500" viewBox="0 0 20 20" fill="currentColor">
                            <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd" />
                        </svg>
                        24/7 Priority Support line
                    </li>
                    <li class="flex items-center gap-2">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4.5 w-4.5 text-emerald-500" viewBox="0 0 20 20" fill="currentColor">
                            <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd" />
                        </svg>
                        Rent unlimited spaces
                    </li>
                </ul>
            </div>
            
            <div class="mt-8">
                @auth
                    @if(Auth::user()->subscription_plan === 'unlimited')
                        <button disabled class="w-full py-3 bg-slate-100 text-slate-400 font-bold text-xs rounded-xl cursor-default">
                            Active Package
                        </button>
                    @else
                        <button type="button" onclick="payWithRazorpay('unlimited')" class="w-full py-3 border border-slate-200 hover:bg-slate-50 text-slate-700 font-bold text-xs rounded-xl transition">
                            Buy Unlimited
                        </button>
                    @endif
                @else
                    <a href="/login" class="block w-full py-3 border border-slate-200 hover:bg-slate-50 text-slate-700 font-bold text-xs rounded-xl transition">
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
