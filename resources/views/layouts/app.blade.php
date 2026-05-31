<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>HomiQ - Rent Spaces, List Properties</title>
    <!-- Google Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <!-- Tailwind CSS CDN -->
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        steelAzure: '#1A447C',
                        seaGreen: '#328B60',
                        radioactiveGrass: '#00E200',
                        turfGreen: '#187053',
                    },
                    fontFamily: {
                        sans: ['Outfit', 'sans-serif'],
                    }
                }
            }
        }
    </script>
    <style>
        body {
            font-family: 'Outfit', sans-serif;
            background-color: #f8fafc;
        }
        /* Scroll Reveal Animations */
        .scroll-reveal {
            opacity: 0;
            transform: translateY(24px);
            filter: blur(3px);
            transition: opacity 1s cubic-bezier(0.16, 1, 0.3, 1),
                        transform 1s cubic-bezier(0.16, 1, 0.3, 1),
                        filter 1s cubic-bezier(0.16, 1, 0.3, 1);
        }
        .scroll-reveal.revealed {
            opacity: 1;
            transform: translateY(0);
            filter: blur(0);
        }
        .delay-75 { transition-delay: 75ms; }
        .delay-100 { transition-delay: 100ms; }
        .delay-150 { transition-delay: 150ms; }
        .delay-200 { transition-delay: 200ms; }
    </style>
</head>
<body class="flex flex-col min-h-screen">

    <!-- Header Navbar -->
    <nav class="bg-white border-b border-slate-100 sticky top-0 z-50 shadow-sm">
        <div class="max-w-7xl mx-auto px-6 h-16 flex items-center justify-between">
            <!-- Brand -->
            <a href="/" class="flex items-center gap-3">
                <img src="/logo.png" alt="HomiQ Logo" class="h-14 w-auto object-contain">
            </a>
            
            <!-- Navigation Links -->
            <div class="hidden lg:flex items-center gap-6 text-[13px] font-semibold text-slate-500">
                <a href="/" class="hover:text-steelAzure transition {{ Request::is('/') ? 'text-steelAzure font-bold border-b-2 border-steelAzure pb-1' : '' }}">Explore Feed</a>
                <a href="/dashboard" class="hover:text-steelAzure transition {{ Request::is('dashboard') ? 'text-steelAzure font-bold border-b-2 border-steelAzure pb-1' : '' }}">List Property</a>
                <a href="/about" class="hover:text-steelAzure transition {{ Request::is('about') ? 'text-steelAzure font-bold border-b-2 border-steelAzure pb-1' : '' }}">About Us</a>
                <a href="/contact" class="hover:text-steelAzure transition {{ Request::is('contact') ? 'text-steelAzure font-bold border-b-2 border-steelAzure pb-1' : '' }}">Contact Us</a>
                <a href="/privacy" class="hover:text-steelAzure transition {{ Request::is('privacy') ? 'text-steelAzure font-bold border-b-2 border-steelAzure pb-1' : '' }}">Privacy Policy</a>
                <a href="/terms" class="hover:text-steelAzure transition {{ Request::is('terms') ? 'text-steelAzure font-bold border-b-2 border-steelAzure pb-1' : '' }}">Terms & Conditions</a>
                @auth
                    @if (Auth::user()->is_admin)
                        <a href="/admin" class="hover:text-steelAzure transition">Admin Panel</a>
                    @else
                        <a href="/dashboard" class="hover:text-steelAzure transition {{ Request::is('dashboard') ? 'text-steelAzure font-bold border-b-2 border-steelAzure pb-1' : '' }}">My Dashboard</a>
                    @endif
                @endauth
            </div>

            <!-- Profile / Actions -->
            <div class="flex items-center gap-4">
                @auth
                    <div class="flex items-center gap-4 relative">
                        <!-- Chat Icon Link -->
                        <a href="/chat" class="text-slate-500 hover:text-steelAzure transition relative p-1.5 rounded-full hover:bg-slate-100/80 flex items-center justify-center" title="Inbox & Queries">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z" />
                            </svg>
                        </a>

                        <!-- Notification Dropdown Toggle -->
                        <div class="relative inline-block text-left" id="notification-dropdown-wrapper">
                            <button onclick="toggleNotifications()" class="text-slate-500 hover:text-steelAzure transition relative p-1.5 rounded-full hover:bg-slate-100/80 flex items-center justify-center focus:outline-none" title="Notifications">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9" />
                                </svg>
                                @if (isset($unreadNotificationsCount) && $unreadNotificationsCount > 0)
                                    <span class="absolute top-1 right-1 flex h-2 w-2">
                                        <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-red-400 opacity-75"></span>
                                        <span class="relative inline-flex rounded-full h-2 w-2 bg-red-500"></span>
                                    </span>
                                @endif
                            </button>

                            <!-- Dropdown Box -->
                            <div id="notification-dropdown" class="hidden absolute right-0 mt-3.5 w-80 bg-white border border-slate-100 rounded-2xl shadow-xl z-50 overflow-hidden transform origin-top-right transition-all duration-200">
                                <div class="p-4 bg-slate-50 border-b border-slate-100 flex items-center justify-between">
                                    <span class="text-xs font-extrabold text-slate-800 uppercase tracking-wider">Notifications</span>
                                    @if (isset($unreadNotificationsCount) && $unreadNotificationsCount > 0)
                                        <form action="/notifications/read-all" method="POST" class="m-0">
                                            @csrf
                                            <button type="submit" class="text-[9px] font-bold text-steelAzure hover:underline uppercase tracking-wide">Mark read</button>
                                        </form>
                                    @endif
                                </div>
                                <div class="max-h-64 overflow-y-auto divide-y divide-slate-50">
                                    @if(isset($notifications) && !$notifications->isEmpty())
                                        @foreach($notifications as $notif)
                                            <div class="p-3.5 hover:bg-slate-50 transition text-left relative {{ !$notif->is_read ? 'bg-blue-50/20' : '' }}">
                                                <div class="flex items-center gap-1.5 mb-1">
                                                    @if($notif->type === 'chat')
                                                        <span class="w-1.5 h-1.5 rounded-full bg-blue-500"></span>
                                                    @elseif($notif->type === 'booking')
                                                        <span class="w-1.5 h-1.5 rounded-full bg-amber-500"></span>
                                                    @else
                                                        <span class="w-1.5 h-1.5 rounded-full bg-slate-400"></span>
                                                    @endif
                                                    <span class="text-[10px] font-extrabold text-slate-700">{{ $notif->title }}</span>
                                                </div>
                                                <p class="text-[10px] text-slate-500 leading-relaxed">{{ $notif->message }}</p>
                                                <span class="text-[8px] font-semibold text-slate-300 block mt-1.5">{{ $notif->created_at->diffForHumans() }}</span>
                                            </div>
                                        @endforeach
                                    @else
                                        <div class="p-8 text-center text-slate-400 text-[10px] font-semibold">
                                            No notifications yet.
                                        </div>
                                    @endif
                                </div>
                            </div>
                        </div>

                        <span class="text-xs font-semibold text-slate-600 ml-2">Hello, {{ Auth::user()->name }}</span>
                        <!-- Logout form -->
                        <form action="/logout" method="POST" class="m-0" onsubmit="return confirm('Are you sure you want to sign out?');">
                            @csrf
                            <button type="submit" class="px-4 py-2 border border-slate-200 rounded-lg text-xs font-bold text-slate-600 hover:bg-slate-50 transition">
                                Sign Out
                            </button>
                        </form>
                    </div>
                @else
                    <a href="/login" class="px-4 py-2 border border-slate-200 hover:border-steelAzure/30 rounded-lg text-xs font-bold text-slate-600 hover:text-steelAzure transition">Login</a>
                    <a href="/register" class="px-5 py-2 bg-gradient-to-r from-steelAzure to-blue-700 hover:from-steelAzure/90 hover:to-blue-600 text-white rounded-lg text-xs font-extrabold shadow-md shadow-steelAzure/10 hover:shadow-lg transition-all duration-300">Register</a>
                @endauth
            </div>
        </div>
    </nav>

    <!-- Main Content -->
    <main class="flex-1">
        @if (session('success'))
            <div id="success-toast" class="fixed top-24 right-6 z-50 transform translate-x-0 opacity-100 transition-all duration-500 ease-out">
                <div class="px-5 py-3.5 bg-white/95 backdrop-blur border border-emerald-100 text-emerald-800 rounded-2xl shadow-xl shadow-emerald-500/5 flex items-center gap-3">
                    <div class="h-7 w-7 rounded-full bg-emerald-500 text-white flex items-center justify-center flex-shrink-0 shadow shadow-emerald-500/20">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4.5 w-4.5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="3">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7" />
                        </svg>
                    </div>
                    <span class="text-xs font-extrabold tracking-wide">{{ session('success') }}</span>
                </div>
            </div>
            <script>
                setTimeout(() => {
                    const toast = document.getElementById('success-toast');
                    if (toast) {
                        toast.style.transform = 'translateX(50px)';
                        toast.style.opacity = '0';
                        setTimeout(() => toast.remove(), 500);
                    }
                }, 2000);
            </script>
        @endif

        @if ($errors->any())
            <div class="max-w-7xl mx-auto px-6 mt-6">
                <div class="p-4 bg-rose-50 text-rose-800 border border-rose-100 rounded-2xl flex flex-col gap-1">
                    @foreach ($errors->all() as $error)
                        <div class="flex items-center gap-3">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-rose-500" viewBox="0 0 20 20" fill="currentColor">
                                <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd" />
                            </svg>
                            <span class="text-sm font-medium">{{ $error }}</span>
                        </div>
                    @endforeach
                </div>
            </div>
        @endif

        @yield('content')
    </main>

    <!-- Footer -->
    <footer class="bg-gradient-to-r from-slate-900 to-slate-800 border-t border-slate-800 pt-16 pb-12 mt-24 relative overflow-hidden text-slate-400">
        <div class="absolute inset-0 bg-[radial-gradient(circle_at_70%_70%,rgba(26,68,124,0.12),transparent_50%)] pointer-events-none"></div>
        <div class="max-w-7xl mx-auto px-6 grid grid-cols-1 md:grid-cols-4 gap-12 text-sm relative z-10 mb-12">
            <!-- Col 1: Bio -->
            <div class="space-y-4">
                <img src="/logo.png" alt="HomiQ Logo" class="h-14 w-auto object-contain">
                <p class="text-xs text-slate-400 leading-relaxed">
                    Connecting property customer listings and flexible rental requests through modern verification pipelines.
                </p>
                <!-- Social Icons -->
                <div class="flex gap-4">
                    <a href="#" class="text-slate-400 hover:text-emerald-400 transition">
                        <svg class="h-5 w-5" fill="currentColor" viewBox="0 0 24 24"><path d="M22 12c0-5.52-4.48-10-10-10S2 6.48 2 12c0 4.84 3.44 8.87 8 9.8V15H8v-3h2V9.5C10 7.57 11.57 6 13.5 6H16v3h-2c-.55 0-1 .45-1 1V12h3l-.5 3h-2.5v6.8c4.56-.93 8-4.96 8-9.8z"/></svg>
                    </a>
                    <a href="#" class="text-slate-400 hover:text-emerald-400 transition">
                        <svg class="h-5 w-5" fill="currentColor" viewBox="0 0 24 24"><path d="M23.953 4.57a10 10 0 01-2.825.775 4.958 4.958 0 002.163-2.723c-.951.555-2.005.959-3.127 1.184a4.92 4.92 0 00-8.384 4.482C7.69 8.095 4.067 6.13 1.64 3.162a4.822 4.822 0 00-.666 2.475c0 1.71.87 3.213 2.188 4.096a4.904 4.904 0 01-2.228-.616v.06a4.923 4.923 0 003.946 4.827 4.996 4.996 0 01-2.212.085 4.936 4.936 0 004.604 3.417 9.867 9.867 0 01-6.102 2.105c-.39 0-.779-.023-1.17-.067a13.995 13.995 0 007.557 2.209c9.053 0 13.998-7.496 13.998-13.985 0-.21 0-.42-.015-.63A9.935 9.935 0 0024 4.59z"/></svg>
                    </a>
                    <a href="#" class="text-slate-400 hover:text-emerald-400 transition">
                        <svg class="h-5 w-5" fill="currentColor" viewBox="0 0 24 24"><path d="M12 2.163c3.204 0 3.584.012 4.85.07 3.252.148 4.771 1.691 4.919 4.919.058 1.265.069 1.645.069 4.849 0 3.205-.012 3.584-.069 4.849-.149 3.225-1.664 4.771-4.919 4.919-1.266.058-1.644.07-4.85.07-3.204 0-3.584-.012-4.849-.07-3.26-.149-4.771-1.699-4.919-4.92-.058-1.265-.07-1.644-.07-4.849 0-3.204.013-3.583.07-4.849.149-3.227 1.664-4.771 4.919-4.919 1.266-.057 1.645-.069 4.849-.069zM12 0C8.741 0 8.333.014 7.053.072 2.695.272.273 2.69.073 7.051.014 8.333 0 8.741 0 12c0 3.259.014 3.668.072 4.948.2 4.358 2.618 6.78 6.98 6.98 1.281.058 1.689.072 4.948.072 3.259 0 3.668-.014 4.948-.072 4.354-.2 6.782-2.618 6.979-6.98.059-1.28.073-1.689.073-4.948 0-3.259-.014-3.667-.072-4.947-.196-4.354-2.617-6.78-6.979-6.98C15.668.014 15.259 0 12 0zm0 5.838a6.162 6.162 0 100 12.324 6.162 6.162 0 000-12.324zM12 16a4 4 0 110-8 4 4 0 010 8zm6.406-11.845a1.44 1.44 0 100 2.881 1.44 1.44 0 000-2.881z"/></svg>
                    </a>
                </div>
            </div>

            <!-- Col 2: Discover -->
            <div class="space-y-4">
                <h4 class="text-xs font-bold text-white uppercase tracking-wider">Discover Spaces</h4>
                <ul class="space-y-2 text-xs">
                    <li><a href="/?category=Apartment" class="hover:text-emerald-400 transition">Apartments</a></li>
                    <li><a href="/?category=House" class="hover:text-emerald-400 transition">Family Houses</a></li>
                    <li><a href="/?category=Villa" class="hover:text-emerald-400 transition">Beachfront Villas</a></li>
                    <li><a href="/?category=Shop" class="hover:text-emerald-400 transition">Commercial Shops</a></li>
                </ul>
            </div>

            <!-- Col 3: Quick Links -->
            <div class="space-y-4">
                <h4 class="text-xs font-bold text-white uppercase tracking-wider">Platform Links</h4>
                <ul class="space-y-2 text-xs">
                    <li><a href="/about" class="hover:text-emerald-400 transition">About Us</a></li>
                    <li><a href="/contact" class="hover:text-emerald-400 transition">Contact Us</a></li>
                    <li><a href="/login" class="hover:text-emerald-400 transition">Sign In Portal</a></li>
                    <li><a href="/register" class="hover:text-emerald-400 transition">Create Account</a></li>
                </ul>
            </div>

            <!-- Col 4: Contact -->
            <div class="space-y-4">
                <h4 class="text-xs font-bold text-white uppercase tracking-wider">Contact Info</h4>
                <ul class="space-y-2 text-xs text-slate-400">
                    <li class="flex items-center gap-2">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-emerald-500" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" /></svg>
                        <span class="hover:text-emerald-400 transition">support@homiq.com</span>
                    </li>
                    <li class="flex items-center gap-2">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-emerald-500" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.94.725l.548 2.2a1 1 0 01-.321.988l-1.305.98a10.582 10.582 0 004.872 4.872l.98-1.305a1 1 0 01.988-.321l2.2.548a1 1 0 01.725.94V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z" /></svg>
                        <span>+91 1800-HOMIQ-01</span>
                    </li>
                </ul>
            </div>
        </div>

        <div class="max-w-7xl mx-auto px-6 border-t border-slate-800 pt-8 flex flex-col md:flex-row items-center justify-between gap-4 text-xs text-slate-500 font-medium relative z-10">
            <p>&copy; 2026 HomiQ Space Rentals. All rights reserved.</p>
            <div class="flex gap-6">
                <a href="/contact" class="hover:text-emerald-400 transition">Contact Us</a>
                <a href="/privacy" class="hover:text-emerald-400 transition">Privacy Policy</a>
                <a href="/terms" class="hover:text-emerald-400 transition">Terms & Conditions</a>
            </div>
        </div>
    </footer>

    <!-- Scroll Reveal Observer Script & Notification Toggles -->
    <script>
        document.addEventListener('DOMContentLoaded', () => {
            const observerOptions = {
                root: null,
                rootMargin: '0px',
                threshold: 0.05
            };
            
            const observer = new IntersectionObserver((entries) => {
                entries.forEach(entry => {
                    if (entry.isIntersecting) {
                        entry.target.classList.add('revealed');
                    }
                });
            }, observerOptions);
            
            document.querySelectorAll('.scroll-reveal').forEach(el => {
                observer.observe(el);
            });
        });

        function toggleNotifications() {
            const dropdown = document.getElementById('notification-dropdown');
            if (dropdown) {
                dropdown.classList.toggle('hidden');
            }
        }

        document.addEventListener('click', function(e) {
            const wrapper = document.getElementById('notification-dropdown-wrapper');
            const dropdown = document.getElementById('notification-dropdown');
            if (wrapper && !wrapper.contains(e.target) && dropdown) {
                dropdown.classList.add('hidden');
            }
        });
    </script>
</body>
</html>
