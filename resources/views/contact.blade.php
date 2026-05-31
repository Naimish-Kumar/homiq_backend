@extends('layouts.app')

@section('content')
<style>
    /* Contact page animations */
    .contact-card {
        transition: transform 0.4s cubic-bezier(0.16, 1, 0.3, 1), box-shadow 0.4s ease;
    }
    .contact-card:hover {
        transform: translateY(-6px);
        box-shadow: 0 20px 40px -12px rgba(26, 68, 124, 0.15);
    }
    .contact-icon-pulse {
        animation: iconPulse 2.5s ease-in-out infinite;
    }
    @keyframes iconPulse {
        0%, 100% { transform: scale(1); }
        50% { transform: scale(1.08); }
    }
    .form-input-animate {
        transition: border-color 0.3s ease, box-shadow 0.3s ease, transform 0.2s ease;
    }
    .form-input-animate:focus {
        transform: translateY(-1px);
        box-shadow: 0 4px 20px -4px rgba(26, 68, 124, 0.15);
    }
    .submit-btn {
        position: relative;
        overflow: hidden;
    }
    .submit-btn::before {
        content: '';
        position: absolute;
        top: 0;
        left: -100%;
        width: 100%;
        height: 100%;
        background: linear-gradient(90deg, transparent, rgba(255,255,255,0.15), transparent);
        transition: left 0.5s ease;
    }
    .submit-btn:hover::before {
        left: 100%;
    }
    .glow-dot {
        position: absolute;
        border-radius: 50%;
        filter: blur(60px);
        opacity: 0.12;
        pointer-events: none;
    }
    .stagger-1 { animation-delay: 0.1s; }
    .stagger-2 { animation-delay: 0.2s; }
    .stagger-3 { animation-delay: 0.3s; }
</style>

<div class="max-w-7xl mx-auto px-6 py-12 md:py-16 space-y-16 md:space-y-20">

    <!-- Contact Info Cards -->
    <section class="grid grid-cols-1 md:grid-cols-3 gap-6 scroll-reveal">
        <!-- Email Card -->
        <div class="contact-card bg-white border border-slate-100 p-7 rounded-xl shadow-sm text-center space-y-3">
            <div class="h-12 w-12 rounded-xl bg-steelAzure/10 text-steelAzure flex items-center justify-center mx-auto contact-icon-pulse">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" /></svg>
            </div>
            <h3 class="font-bold text-slate-800 text-base">Email Us</h3>
            <p class="text-xs text-slate-400 leading-relaxed">We typically respond within 24 hours.</p>
            <a href="mailto:support@homiq.com" class="inline-block text-sm font-semibold text-steelAzure hover:text-turfGreen transition">support@homiq.com</a>
        </div>

        <!-- Phone Card -->
        <div class="contact-card bg-white border border-slate-100 p-7 rounded-xl shadow-sm text-center space-y-3">
            <div class="h-12 w-12 rounded-xl bg-seaGreen/10 text-seaGreen flex items-center justify-center mx-auto contact-icon-pulse stagger-2">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.94.725l.548 2.2a1 1 0 01-.321.988l-1.305.98a10.582 10.582 0 004.872 4.872l.98-1.305a1 1 0 01.988-.321l2.2.548a1 1 0 01.725.94V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z" /></svg>
            </div>
            <h3 class="font-bold text-slate-800 text-base">Call Us</h3>
            <p class="text-xs text-slate-400 leading-relaxed">Mon – Fri, 9 AM – 6 PM EST.</p>
            <span class="inline-block text-sm font-semibold text-seaGreen">+91 1800-HOMIQ-01</span>
        </div>

        <!-- Location Card -->
        <div class="contact-card bg-white border border-slate-100 p-7 rounded-xl shadow-sm text-center space-y-3">
            <div class="h-12 w-12 rounded-xl bg-turfGreen/10 text-turfGreen flex items-center justify-center mx-auto contact-icon-pulse stagger-3">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" /><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" /></svg>
            </div>
            <h3 class="font-bold text-slate-800 text-base">Visit Us</h3>
            <p class="text-xs text-slate-400 leading-relaxed">Come say hello at our headquarters.</p>
            <span class="inline-block text-sm font-semibold text-turfGreen">Plot 42, Sector 18, Cyber Hub<br>Gurugram, HR 122015</span>
        </div>
    </section>

    <!-- Contact Form & Sidebar -->
    <section class="grid grid-cols-1 lg:grid-cols-12 gap-10 scroll-reveal delay-100">
        
        <!-- Contact Form -->
        <div class="lg:col-span-7">
            <div class="bg-white border border-slate-100 rounded-2xl p-8 md:p-10 shadow-sm">
                <div class="space-y-2 mb-8">
                    <span class="text-[11px] font-bold text-steelAzure uppercase tracking-widest block">Send a Message</span>
                    <h2 class="text-2xl md:text-3xl font-extrabold text-slate-800">Let's Start a Conversation</h2>
                    <p class="text-sm text-slate-400">Fill out the form and our team will get back to you shortly.</p>
                </div>

                <form action="#" method="POST" class="space-y-5">
                    @csrf
                    <!-- Name & Email -->
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                        <div class="space-y-1.5">
                            <label for="contact-name" class="block text-[11px] font-bold text-slate-500 uppercase tracking-wider">Full Name</label>
                            <input 
                                type="text" id="contact-name" name="name" placeholder="John Doe" required
                                class="form-input-animate w-full px-4 py-3 bg-slate-50/80 border border-slate-200 rounded-lg text-sm text-slate-700 placeholder-slate-300 focus:outline-none focus:border-steelAzure focus:ring-2 focus:ring-steelAzure/10"
                            >
                        </div>
                        <div class="space-y-1.5">
                            <label for="contact-email" class="block text-[11px] font-bold text-slate-500 uppercase tracking-wider">Email Address</label>
                            <input 
                                type="email" id="contact-email" name="email" placeholder="john@example.com" required
                                class="form-input-animate w-full px-4 py-3 bg-slate-50/80 border border-slate-200 rounded-lg text-sm text-slate-700 placeholder-slate-300 focus:outline-none focus:border-steelAzure focus:ring-2 focus:ring-steelAzure/10"
                            >
                        </div>
                    </div>

                    <!-- Phone & Subject -->
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                        <div class="space-y-1.5">
                            <label for="contact-phone" class="block text-[11px] font-bold text-slate-500 uppercase tracking-wider">Phone <span class="text-slate-300 normal-case">(optional)</span></label>
                            <input 
                                type="tel" id="contact-phone" name="phone" placeholder="+1 (555) 000-0000"
                                class="form-input-animate w-full px-4 py-3 bg-slate-50/80 border border-slate-200 rounded-lg text-sm text-slate-700 placeholder-slate-300 focus:outline-none focus:border-steelAzure focus:ring-2 focus:ring-steelAzure/10"
                            >
                        </div>
                        <div class="space-y-1.5">
                            <label for="contact-subject" class="block text-[11px] font-bold text-slate-500 uppercase tracking-wider">Subject</label>
                            <select 
                                id="contact-subject" name="subject" required
                                class="form-input-animate w-full px-4 py-3 bg-slate-50/80 border border-slate-200 rounded-lg text-sm text-slate-700 focus:outline-none focus:border-steelAzure focus:ring-2 focus:ring-steelAzure/10 appearance-none"
                            >
                                <option value="" disabled selected>Select a topic</option>
                                <option value="general">General Inquiry</option>
                                <option value="support">Technical Support</option>
                                <option value="listing">Listing Help</option>
                                <option value="billing">Billing & Subscriptions</option>
                                <option value="partnership">Partnership Opportunities</option>
                                <option value="feedback">Feedback & Suggestions</option>
                            </select>
                        </div>
                    </div>

                    <!-- Message -->
                    <div class="space-y-1.5">
                        <label for="contact-message" class="block text-[11px] font-bold text-slate-500 uppercase tracking-wider">Your Message</label>
                        <textarea 
                            id="contact-message" name="message" rows="5" placeholder="Tell us how we can help you..." required
                            class="form-input-animate w-full px-4 py-3 bg-slate-50/80 border border-slate-200 rounded-lg text-sm text-slate-700 placeholder-slate-300 focus:outline-none focus:border-steelAzure focus:ring-2 focus:ring-steelAzure/10 resize-none"
                        ></textarea>
                    </div>

                    <!-- Submit -->
                    <button 
                        type="submit" 
                        class="submit-btn w-full py-3.5 bg-steelAzure hover:bg-steelAzure/90 text-white rounded-lg text-sm font-bold shadow-lg shadow-steelAzure/15 hover:shadow-xl hover:shadow-steelAzure/25 transition-all duration-300 flex items-center justify-center gap-2"
                    >
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 19l9 2-9-18-9 18 9-2zm0 0v-8" /></svg>
                        Send Message
                    </button>
                </form>
            </div>
        </div>

        <!-- Sidebar -->
        <div class="lg:col-span-5 space-y-6">
            <!-- Response Time Card -->
            <div class="bg-steelAzure text-white p-8 rounded-2xl relative overflow-hidden">
                <div class="glow-dot w-48 h-48 bg-seaGreen top-0 right-0"></div>
                <div class="relative z-10 space-y-4">
                    <div class="h-11 w-11 rounded-xl bg-white/15 backdrop-blur-sm text-white flex items-center justify-center">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>
                    </div>
                    <h3 class="text-lg font-bold">Quick Response Time</h3>
                    <p class="text-sm text-white/75 leading-relaxed">Our support team responds within <span class="text-radioactiveGrass font-bold">24 hours</span> on weekdays. For urgent matters, call us directly.</p>
                    <div class="flex items-center gap-3 pt-1">
                        <div class="flex -space-x-2">
                            <div class="w-8 h-8 rounded-full bg-white/20 backdrop-blur-sm flex items-center justify-center text-[10px] font-bold text-white border-2 border-steelAzure">AK</div>
                            <div class="w-8 h-8 rounded-full bg-seaGreen flex items-center justify-center text-[10px] font-bold text-white border-2 border-steelAzure">SP</div>
                            <div class="w-8 h-8 rounded-full bg-turfGreen flex items-center justify-center text-[10px] font-bold text-white border-2 border-steelAzure">RJ</div>
                        </div>
                        <span class="text-xs text-white/50">Our Support Team</span>
                    </div>
                </div>
            </div>

            <!-- Quick Links -->
            <div class="bg-white border border-slate-100 p-7 rounded-2xl shadow-sm space-y-4">
                <h3 class="font-bold text-slate-800 text-base">Helpful Links</h3>
                <div class="space-y-2.5">
                    <a href="/terms" class="flex items-center gap-3 p-3 rounded-xl bg-slate-50/80 hover:bg-steelAzure/5 transition group">
                        <div class="h-9 w-9 rounded-lg bg-steelAzure/10 text-steelAzure flex items-center justify-center flex-shrink-0 group-hover:bg-steelAzure group-hover:text-white transition">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" /></svg>
                        </div>
                        <div>
                            <span class="text-sm font-semibold text-slate-700 block">Terms & Conditions</span>
                            <span class="text-[11px] text-slate-400">Platform rules & policies</span>
                        </div>
                    </a>
                    <a href="/privacy" class="flex items-center gap-3 p-3 rounded-xl bg-slate-50/80 hover:bg-seaGreen/5 transition group">
                        <div class="h-9 w-9 rounded-lg bg-seaGreen/10 text-seaGreen flex items-center justify-center flex-shrink-0 group-hover:bg-seaGreen group-hover:text-white transition">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z" /></svg>
                        </div>
                        <div>
                            <span class="text-sm font-semibold text-slate-700 block">Privacy Policy</span>
                            <span class="text-[11px] text-slate-400">Data protection details</span>
                        </div>
                    </a>
                    <a href="/about" class="flex items-center gap-3 p-3 rounded-xl bg-slate-50/80 hover:bg-turfGreen/5 transition group">
                        <div class="h-9 w-9 rounded-lg bg-turfGreen/10 text-turfGreen flex items-center justify-center flex-shrink-0 group-hover:bg-turfGreen group-hover:text-white transition">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4" /></svg>
                        </div>
                        <div>
                            <span class="text-sm font-semibold text-slate-700 block">About HomiQ</span>
                            <span class="text-[11px] text-slate-400">Our mission & story</span>
                        </div>
                    </a>
                </div>
            </div>
        </div>
    </section>
</div>
@endsection
