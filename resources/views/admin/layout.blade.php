<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>HomiQ - Admin Control Panel</title>
    <!-- Google Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@300;400;500;600;700;800;900&display=swap" rel="stylesheet">
    <!-- Tailwind CSS CDN -->
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        donezoGreen: '#187053', // Donezo Accent Green
                        donezoLightGreen: '#e6f3ef', // Light accent tint
                        donezoDark: '#0f172a', // Text color
                    },
                    fontFamily: {
                        sans: ['Outfit', 'sans-serif'],
                    },
                    fontSize: {
                        'xs': '13px',
                        'sm': '15px',
                        'base': '17px',
                        'lg': '19px',
                        'xl': '21px',
                        '2xl': '26px',
                        '3xl': '32px',
                    }
                }
            }
        }
    </script>
    <style>
        body {
            font-family: 'Outfit', sans-serif;
            background-color: #e2e8f0; /* Outer canvas background */
        }
        
        /* Premium Custom Scrollbars */
        ::-webkit-scrollbar {
            width: 6px;
            height: 6px;
        }
        ::-webkit-scrollbar-track {
            background: transparent;
        }
        ::-webkit-scrollbar-thumb {
            background: rgba(0, 0, 0, 0.06);
            border-radius: 9999px;
        }
        ::-webkit-scrollbar-thumb:hover {
            background: rgba(0, 0, 0, 0.12);
        }

        /* Page load animations */
        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(6px); }
            to { opacity: 1; transform: translateY(0); }
        }
        .animate-fade-in {
            animation: fadeIn 0.35s cubic-bezier(0.16, 1, 0.3, 1) forwards;
        }
    </style>
</head>
<body class="h-screen w-screen bg-white overflow-hidden">

    <!-- Main Canvas Wrapper: Full screen width and height -->
    <div class="w-full h-full bg-white flex relative z-10">

        <!-- Left Sidebar: Pure White background, bordered right -->
        <aside class="w-60 bg-white flex flex-col h-full z-20 border-r border-slate-100 flex-shrink-0 justify-between">
            <div>
                <!-- Centered Logo only, no text HomiQ Admin Panel -->
                <div class="p-6 border-b border-slate-50 flex items-center justify-center">
                    <img src="/logo.png" alt="HomiQ Logo" class="h-14 w-auto object-contain">
                </div>

                <!-- Navigation List -->
                <nav class="p-4 space-y-1">
                    <div class="text-[9px] text-slate-400 font-bold uppercase tracking-widest px-4 mb-2.5">Menu</div>
                    
                    <!-- Dashboard -->
                    <a href="/admin" class="relative group flex items-center gap-3.5 px-4 py-3 rounded-md transition {{ Request::is('admin') ? 'text-donezoGreen font-bold bg-donezoLightGreen/50' : 'text-slate-400 hover:bg-slate-50 hover:text-slate-700' }}">
                        @if (Request::is('admin'))
                            <div class="absolute left-0 top-1/4 bottom-1/4 w-1 bg-donezoGreen rounded-r-sm"></div>
                        @endif
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 {{ Request::is('admin') ? 'text-donezoGreen' : 'text-slate-400' }}" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6a2 2 0 012-2h2a2 2 0 012 2v4a2 2 0 01-2 2H6a2 2 0 01-2-2V6zM14 6a2 2 0 012-2h2a2 2 0 012 2v4a2 2 0 01-2 2h-2a2 2 0 01-2-2V6zM4 16a2 2 0 012-2h2a2 2 0 012 2v4a2 2 0 01-2 2H6a2 2 0 01-2-2v-4zM14 16a2 2 0 012-2h2a2 2 0 012 2v4a2 2 0 01-2 2h-2a2 2 0 01-2-2v-4z" />
                        </svg>
                        <span class="text-xs">Dashboard</span>
                    </a>

                    <!-- Listing Moderation -->
                    <a href="/admin/properties" class="relative group flex items-center gap-3.5 px-4 py-3 rounded-md transition {{ Request::is('admin/properties') ? 'text-donezoGreen font-bold bg-donezoLightGreen/50' : 'text-slate-400 hover:bg-slate-50 hover:text-slate-700' }}">
                        @if (Request::is('admin/properties'))
                            <div class="absolute left-0 top-1/4 bottom-1/4 w-1 bg-donezoGreen rounded-r-sm"></div>
                        @endif
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 {{ Request::is('admin/properties') ? 'text-donezoGreen' : 'text-slate-400' }}" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4" />
                        </svg>
                        <span class="text-xs">Moderation</span>
                    </a>

                    <!-- User Manager -->
                    <a href="/admin/users" class="relative group flex items-center gap-3.5 px-4 py-3 rounded-md transition {{ Request::is('admin/users') ? 'text-donezoGreen font-bold bg-donezoLightGreen/50' : 'text-slate-400 hover:bg-slate-50 hover:text-slate-700' }}">
                        @if (Request::is('admin/users'))
                            <div class="absolute left-0 top-1/4 bottom-1/4 w-1 bg-donezoGreen rounded-r-sm"></div>
                        @endif
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 {{ Request::is('admin/users') ? 'text-donezoGreen' : 'text-slate-400' }}" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z" />
                        </svg>
                        <span class="text-xs">User Manager</span>
                    </a>

                    <!-- Page Settings -->
                    <a href="/admin/settings" class="relative group flex items-center gap-3.5 px-4 py-3 rounded-md transition {{ Request::is('admin/settings*') ? 'text-donezoGreen font-bold bg-donezoLightGreen/50' : 'text-slate-400 hover:bg-slate-50 hover:text-slate-700' }}">
                        @if (Request::is('admin/settings*'))
                            <div class="absolute left-0 top-1/4 bottom-1/4 w-1 bg-donezoGreen rounded-r-sm"></div>
                        @endif
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 {{ Request::is('admin/settings*') ? 'text-donezoGreen' : 'text-slate-400' }}" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z" /><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                        </svg>
                        <span class="text-xs">Page Settings</span>
                    </a>

                    <!-- App Configurations -->
                    <a href="/admin/config" class="relative group flex items-center gap-3.5 px-4 py-3 rounded-md transition {{ Request::is('admin/config') ? 'text-donezoGreen font-bold bg-donezoLightGreen/50' : 'text-slate-400 hover:bg-slate-50 hover:text-slate-700' }}">
                        @if (Request::is('admin/config'))
                            <div class="absolute left-0 top-1/4 bottom-1/4 w-1 bg-donezoGreen rounded-r-sm"></div>
                        @endif
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 {{ Request::is('admin/config') ? 'text-donezoGreen' : 'text-slate-400' }}" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6V4m0 2a2 2 0 100 4m0-4a2 2 0 110 4m-6 8a2 2 0 100-4m0 4a2 2 0 110-4m0 4v2m0-6V4m6 6v10m6-2a2 2 0 100-4m0 4a2 2 0 110-4m0 4v2m0-6V4" />
                        </svg>
                        <span class="text-xs">Configurations</span>
                    </a>

                    <!-- Listing Attributes -->
                    <a href="/admin/attributes" class="relative group flex items-center gap-3.5 px-4 py-3 rounded-md transition {{ Request::is('admin/attributes') ? 'text-donezoGreen font-bold bg-donezoLightGreen/50' : 'text-slate-400 hover:bg-slate-50 hover:text-slate-700' }}">
                        @if (Request::is('admin/attributes'))
                            <div class="absolute left-0 top-1/4 bottom-1/4 w-1 bg-donezoGreen rounded-r-sm"></div>
                        @endif
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 {{ Request::is('admin/attributes') ? 'text-donezoGreen' : 'text-slate-400' }}" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 10h16M4 14h16M4 18h16" />
                        </svg>
                        <span class="text-xs">Listing Attributes</span>
                    </a>

                    <!-- User Feedback -->
                    <a href="/admin/feedbacks" class="relative group flex items-center gap-3.5 px-4 py-3 rounded-md transition {{ Request::is('admin/feedbacks*') ? 'text-donezoGreen font-bold bg-donezoLightGreen/50' : 'text-slate-400 hover:bg-slate-50 hover:text-slate-700' }}">
                        @if (Request::is('admin/feedbacks*'))
                            <div class="absolute left-0 top-1/4 bottom-1/4 w-1 bg-donezoGreen rounded-r-sm"></div>
                        @endif
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 {{ Request::is('admin/feedbacks*') ? 'text-donezoGreen' : 'text-slate-400' }}" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 10h.01M12 10h.01M16 10h.01M9 16H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-5l-5 5v-5z" />
                        </svg>
                        <span class="text-xs">User Feedback</span>
                    </a>
                </nav>
            </div>

            <!-- Bottom: Donezo App Banner Card & Profile Box -->
            <div class="p-4 space-y-4">
                <!-- App download card (Donezo layout style) -->
                <div class="relative bg-gradient-to-br from-emerald-950 via-[#0e3b2b] to-slate-950 p-4 rounded-lg overflow-hidden text-white border border-emerald-900/50">
                    <div class="relative z-10 space-y-3">
                        <div class="h-6 w-6 rounded bg-emerald-500/20 border border-emerald-500/30 flex items-center justify-center">
                            <span class="text-[10px] font-black text-emerald-400">Q</span>
                        </div>
                        <div>
                            <h4 class="text-xs font-extrabold leading-tight">Download our Mobile App</h4>
                            <p class="text-[9px] text-emerald-300/70 mt-0.5 leading-normal">Get easy access to moderation and booking alerts.</p>
                        </div>
                        <a href="#" class="block w-full py-1.5 bg-[#187053] hover:bg-[#1f8c69] text-white text-center rounded-md text-[10px] font-bold transition">
                            Download
                        </a>
                    </div>
                </div>

                <!-- Admin Session Info & Logout -->
                <div class="pt-2 border-t border-slate-100 flex items-center justify-between">
                    <div class="flex items-center gap-2 overflow-hidden">
                        @if(Auth::user()->profile_photo)
                            <img src="{{ Auth::user()->profile_photo }}" class="w-8 h-8 rounded-full object-cover border border-slate-200 shadow-sm" alt="Admin avatar">
                        @else
                            <div class="h-8 w-8 rounded-full bg-slate-50 border border-slate-200 flex items-center justify-center font-bold text-[10px] text-slate-500">
                                {{ substr(Auth::user()->name, 0, 1) }}
                            </div>
                        @endif
                        <div class="overflow-hidden">
                            <p class="text-[10px] font-extrabold text-slate-800 truncate leading-none">{{ Auth::user()->name }}</p>
                        </div>
                    </div>
                    <button type="button" onclick="openLogoutModal()" class="text-slate-400 hover:text-rose-500 p-1.5 rounded-md hover:bg-slate-50 transition duration-150">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4.5 w-4.5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1" />
                        </svg>
                    </button>
                </div>
            </div>
        </aside>

        <!-- Right Content & Header Area -->
        <div class="flex-1 flex flex-col h-full bg-[#f8fafc] overflow-hidden">
            <!-- Top Donezo Header Bar -->
            <header class="h-16 bg-white border-b border-slate-100/80 flex items-center justify-between px-8 flex-shrink-0">
                
                <!-- Search bar wrapper -->
                <div class="w-80 relative">
                    <span class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none text-slate-400">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                        </svg>
                    </span>
                    <input type="text" placeholder="Search task..." disabled
                           class="w-full pl-10 pr-12 py-2 text-xs font-semibold rounded-lg border border-slate-100 bg-[#f8fafc] text-slate-550 focus:outline-none">
                    <span class="absolute inset-y-0 right-0 pr-3.5 flex items-center pointer-events-none">
                        <span class="px-1.5 py-0.5 bg-white border border-slate-200 text-[9px] font-bold text-slate-400 rounded-sm">⌘ F</span>
                    </span>
                </div>

                <!-- Navigation utilities and profile card pill -->
                <div class="flex items-center gap-4">
                    <!-- Rounded notification icon -->
                    <button class="h-8 w-8 rounded-full bg-slate-50 border border-slate-100 flex items-center justify-center text-slate-500 hover:bg-slate-100 transition shadow-sm">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9" />
                        </svg>
                    </button>
 
                     <div class="h-8 w-px bg-slate-150"></div>
 
                     <!-- Profile Pill Dropdown Container -->
                     <div class="relative">
                        <button onclick="toggleProfileDropdown(event)" class="flex items-center gap-3 hover:bg-slate-50 p-1.5 rounded-lg transition duration-150 focus:outline-none">
                            @if(Auth::user()->profile_photo)
                                <img src="{{ Auth::user()->profile_photo }}" class="w-9 h-9 rounded-full object-cover border border-slate-200 shadow-sm" alt="Admin avatar">
                            @else
                                <div class="h-9 w-9 bg-donezoLightGreen text-[#187053] rounded-full flex items-center justify-center font-bold text-xs shadow-inner">
                                    {{ substr(Auth::user()->name, 0, 1) }}
                                </div>
                            @endif
                            <div class="text-left leading-none hidden md:block">
                                <span class="text-xs font-bold text-slate-800 block mb-0.5">{{ Auth::user()->name }}</span>
                                <span class="text-[9px] text-slate-400 font-semibold">{{ Auth::user()->email }}</span>
                            </div>
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-3.5 w-3.5 text-slate-400 hidden md:block" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M19 9l-7 7-7-7" />
                            </svg>
                        </button>
                        
                        <!-- Dropdown Menu -->
                        <div id="profileDropdown" class="absolute right-0 mt-2.5 w-48 bg-white border border-slate-200/60 rounded-lg shadow-xl py-2 hidden z-30 transition duration-150">
                            <a href="/admin/profile" class="flex items-center gap-2.5 px-4 py-2.5 text-xs text-slate-650 hover:bg-slate-50 transition font-bold">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-[#187053]" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                                </svg>
                                Update Profile
                            </a>
                            <hr class="border-slate-100 my-1">
                            <button onclick="openLogoutModal()" class="w-full text-left flex items-center gap-2.5 px-4 py-2.5 text-xs text-rose-600 hover:bg-rose-50/50 transition font-bold">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-rose-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1" />
                                </svg>
                                Sign Out
                            </button>
                        </div>
                    </div>
                </div>
            </header>

            <!-- Main Body Scroll View -->
            <main class="flex-1 overflow-y-auto p-8">
                
                <!-- Feedback toasts -->
                @if (session('success'))
                    <div class="alert-toast mb-6 p-4 bg-emerald-50 text-emerald-800 border border-emerald-250/70 rounded-xl flex items-center gap-3 shadow-sm">
                        <div class="p-1.5 bg-[#187053] text-white rounded-lg">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" viewBox="0 0 20 20" fill="currentColor">
                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd" />
                            </svg>
                        </div>
                        <span class="text-xs font-bold">{{ session('success') }}</span>
                    </div>
                @endif

                @if ($errors->any())
                    <div class="alert-toast mb-6 p-4 bg-rose-50 text-rose-800 border border-rose-250/75 rounded-xl flex flex-col gap-2 shadow-sm">
                        @foreach ($errors->all() as $error)
                            <div class="flex items-center gap-3">
                                <div class="p-1.5 bg-rose-500 text-white rounded-lg">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" viewBox="0 0 20 20" fill="currentColor">
                                        <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd" />
                                    </svg>
                                </div>
                                <span class="text-xs font-bold">{{ $error }}</span>
                            </div>
                        @endforeach
                    </div>
                @endif

                <!-- Content Slot wrapper -->
                <div class="animate-fade-in max-w-[1200px] mx-auto w-full">
                    @yield('content')
                </div>
            </main>
        </div>

    </div>

    <!-- Beautiful Logout Confirmation Modal -->
    <div id="logoutConfirmModal" class="fixed inset-0 bg-slate-900/40 backdrop-blur-sm z-50 flex items-center justify-center hidden opacity-0 transition-opacity duration-300">
        <div class="bg-white rounded-xl border border-slate-200/60 p-6 w-full max-w-sm shadow-2xl scale-95 transition-transform duration-300" id="logoutModalContent">
            <div class="flex flex-col items-center text-center space-y-4">
                <!-- Icon -->
                <div class="h-12 w-12 rounded-full bg-rose-50 border border-rose-100 flex items-center justify-center text-rose-500 shadow-sm">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1" />
                    </svg>
                </div>
                
                <!-- Text -->
                <div class="space-y-1">
                    <h3 class="text-sm font-extrabold text-slate-800">Confirm Sign Out</h3>
                    <p class="text-[11px] text-slate-400 leading-normal font-semibold">Are you sure you want to end your active administrator session and log out of the panel?</p>
                </div>

                <!-- Actions -->
                <div class="flex w-full gap-3 pt-2">
                    <button onclick="closeLogoutModal()" class="flex-1 py-2 bg-slate-100 hover:bg-slate-200 text-slate-700 text-xs font-bold rounded-md border border-slate-250 transition text-center">
                        Cancel
                    </button>
                    <form action="/logout" method="POST" class="flex-1 m-0">
                        @csrf
                        <button type="submit" class="w-full py-2 bg-rose-600 hover:bg-rose-700 text-white text-xs font-bold rounded-md shadow-sm transition text-center">
                            Sign Out
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Dropdown and Logout logic script -->
    <script>
        function toggleProfileDropdown(event) {
            event.stopPropagation();
            const dropdown = document.getElementById('profileDropdown');
            dropdown.classList.toggle('hidden');
        }

        function openLogoutModal() {
            const modal = document.getElementById('logoutConfirmModal');
            const content = document.getElementById('logoutModalContent');
            
            // Hide dropdown just in case
            const dropdown = document.getElementById('profileDropdown');
            if (dropdown) dropdown.classList.add('hidden');

            modal.classList.remove('hidden');
            setTimeout(() => {
                modal.classList.remove('opacity-0');
                content.classList.remove('scale-95');
            }, 10);
        }

        function closeLogoutModal() {
            const modal = document.getElementById('logoutConfirmModal');
            const content = document.getElementById('logoutModalContent');

            content.classList.add('scale-95');
            modal.classList.add('opacity-0');
            setTimeout(() => {
                modal.classList.add('hidden');
            }, 300);
        }

        // Close dropdown on click outside
        document.addEventListener('click', function() {
            const dropdown = document.getElementById('profileDropdown');
            if (dropdown) {
                dropdown.classList.add('hidden');
            }
        });
    </script>

    @if(Request::is('admin/users*'))
    <!-- Add/Edit User Centered Modal (No Blur overlay, z-[9999] top-level context) -->
    <div id="userDrawer" class="fixed inset-0 bg-slate-900/50 z-[9999] flex items-center justify-center hidden opacity-0 transition-opacity duration-300" onclick="closeUserDrawerOutside(event)">
        <div id="userDrawerContent" class="w-full max-w-xl bg-white border border-slate-200/60 rounded-xl shadow-2xl scale-95 transition-transform duration-300 overflow-hidden flex flex-col max-h-[85vh]">
            <form action="/admin/users" method="POST" id="userForm" class="flex flex-col h-full m-0 overflow-hidden">
                @csrf
                
                <!-- Header (Sticky) -->
                <div class="flex items-center justify-between border-b border-slate-100 p-6 flex-shrink-0">
                    <span id="drawerTitle" class="text-sm font-extrabold text-[#187053] uppercase tracking-widest">Create New Member</span>
                    <button type="button" onclick="closeUserDrawer()" class="text-slate-400 hover:text-slate-800 p-1.5 rounded-lg hover:bg-slate-50 transition">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M6 18L18 6M6 6l12 12" />
                        </svg>
                    </button>
                </div>

                <!-- Fields Container (Scrollable) -->
                <div class="p-6 space-y-5 overflow-y-auto flex-1">
                    <!-- Name -->
                    <div class="space-y-1.5">
                        <label class="block text-[9px] font-extrabold text-slate-400 uppercase tracking-widest">Full Name</label>
                        <input type="text" name="name" id="field_name" required
                               class="w-full px-4 py-3 bg-slate-50 border border-slate-200/60 rounded-md text-slate-850 text-xs font-semibold focus:outline-none focus:border-[#187053] transition-colors">
                    </div>

                    <!-- Email -->
                    <div class="space-y-1.5">
                        <label class="block text-[9px] font-extrabold text-slate-400 uppercase tracking-widest">Email Address</label>
                        <input type="email" name="email" id="field_email" required
                               class="w-full px-4 py-3 bg-slate-50 border border-slate-200/60 rounded-md text-slate-850 text-xs font-semibold focus:outline-none focus:border-[#187053] transition-colors">
                    </div>

                    <!-- Phone -->
                    <div class="space-y-1.5">
                        <label class="block text-[9px] font-extrabold text-slate-400 uppercase tracking-widest">Phone Number</label>
                        <input type="text" name="phone" id="field_phone" placeholder="e.g. +91 99999 99999"
                               class="w-full px-4 py-3 bg-slate-50 border border-slate-200/60 rounded-md text-slate-850 text-xs font-semibold focus:outline-none focus:border-[#187053] transition-colors">
                    </div>

                    <!-- Plan & Role Grid -->
                    <div class="grid grid-cols-2 gap-4">
                        <div class="space-y-1.5">
                            <label class="block text-[9px] font-extrabold text-slate-400 uppercase tracking-widest">Subscription Plan</label>
                            <select name="subscription_plan" id="field_subscription_plan" required
                                    class="w-full px-3 py-3 bg-slate-50 border border-slate-200/60 rounded-md text-slate-850 text-xs font-semibold focus:outline-none focus:border-[#187053] transition-colors">
                                <option value="free">Free Starter</option>
                                <option value="standard">Standard Growth</option>
                                <option value="unlimited">Unlimited Pro</option>
                            </select>
                        </div>

                        <div class="space-y-1.5">
                            <label class="block text-[9px] font-extrabold text-slate-400 uppercase tracking-widest">Access Level</label>
                            <select name="is_admin" id="field_is_admin" required
                                    class="w-full px-3 py-3 bg-slate-50 border border-slate-200/60 rounded-md text-slate-850 text-xs font-semibold focus:outline-none focus:border-[#187053] transition-colors">
                                <option value="0">Customer</option>
                                <option value="1">Administrator</option>
                            </select>
                        </div>
                    </div>

                    <!-- Password Info Alert for Edit -->
                    <div id="passwordAlert" class="hidden p-3.5 bg-amber-50 text-amber-800 border border-amber-250/50 rounded-md text-[10px] leading-normal font-semibold">
                        Leave blank if you do not want to modify the current user's password.
                    </div>

                    <!-- Password Fields -->
                    <div class="grid grid-cols-2 gap-4">
                        <div class="space-y-1.5">
                            <label id="passwordLabel" class="block text-[9px] font-extrabold text-slate-400 uppercase tracking-widest">Password</label>
                            <input type="password" name="password" id="field_password" placeholder="••••••••"
                                   class="w-full px-4 py-3 bg-slate-50 border border-slate-200/60 rounded-md text-slate-850 text-xs font-semibold focus:outline-none focus:border-[#187053] transition-colors">
                        </div>

                        <div class="space-y-1.5">
                            <label class="block text-[9px] font-extrabold text-slate-400 uppercase tracking-widest">Confirm Password</label>
                            <input type="password" name="password_confirmation" id="field_password_confirmation" placeholder="••••••••"
                                   class="w-full px-4 py-3 bg-slate-50 border border-slate-200/60 rounded-md text-slate-850 text-xs font-semibold focus:outline-none focus:border-[#187053] transition-colors">
                        </div>
                    </div>
                </div>

                <!-- Footer Actions (Sticky) -->
                <div class="border-t border-slate-100 p-6 flex justify-end gap-2 flex-shrink-0">
                    <button type="button" onclick="closeUserDrawer()" class="px-4 py-2 bg-slate-100 hover:bg-slate-200 text-slate-700 text-xs font-bold rounded-md border border-slate-250 transition">
                        Cancel
                    </button>
                    <button type="submit" id="submitBtn" class="px-5 py-2 bg-[#187053] hover:bg-[#12563f] text-white text-xs font-bold rounded-md shadow transition">
                        Save Member
                    </button>
                </div>
            </form>
        </div>
    </div>
@endif
</body>
</html>
