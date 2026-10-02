<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>HomiQ - Admin Control Panel</title>
    <link rel="icon" type="image/png" href="/logo.png">
    
    <!-- Google Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&family=Plus+Jakarta+Sans:wght@400;500;600;700;800&family=Outfit:wght@300;400;500;600;700;800;900&display=swap" rel="stylesheet">
    
    <!-- Tailwind CSS CDN -->
    <script src="https://cdn.tailwindcss.com"></script>
    <!-- Chart.js CDN -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        brandNavy: '#0A2540',
                        brandNavyDeep: '#061826',
                        brandNavySurface: '#0F2942',
                        brandEmerald: '#10B981',
                        brandEmeraldDark: '#059669',
                        brandEmeraldLight: '#34D399',
                        brandEmeraldBg: '#ECFDF5',
                        steelAzure: '#0A2540',
                        seaGreen: '#10B981',
                        radioactiveGrass: '#10B981',
                        turfGreen: '#059669',
                        // Backward compatibility aliases
                        donezoGreen: '#059669',
                        donezoLightGreen: '#ECFDF5',
                        donezoDark: '#0A2540',
                    },
                    fontFamily: {
                        sans: ['Plus Jakarta Sans', 'Outfit', 'Inter', 'sans-serif'],
                        heading: ['Outfit', 'Plus Jakarta Sans', 'sans-serif'],
                    },
                    boxShadow: {
                        soft: '0 20px 40px -15px rgba(10, 37, 64, 0.07)',
                        card: '0 1px 3px 0 rgba(0, 0, 0, 0.05), 0 1px 2px 0 rgba(0, 0, 0, 0.03)',
                        brand: '0 10px 30px -5px rgba(16, 185, 129, 0.25)',
                        brandNavy: '0 10px 30px -5px rgba(10, 37, 64, 0.2)',
                        glass: '0 8px 32px 0 rgba(10, 37, 64, 0.08)',
                    }
                }
            }
        }
    </script>
    <style>
        body {
            font-family: 'Plus Jakarta Sans', 'Outfit', sans-serif;
            background-color: #F8FAFC;
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
            background: rgba(10, 37, 64, 0.12);
            border-radius: 9999px;
        }
        ::-webkit-scrollbar-thumb:hover {
            background: rgba(10, 37, 64, 0.22);
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
<body class="h-screen w-screen bg-[#F8FAFC] overflow-hidden text-slate-800 antialiased selection:bg-emerald-500 selection:text-white">

    <!-- Main Canvas Wrapper: Full screen width and height -->
    <div class="w-full h-full flex relative z-10 overflow-hidden">

        <!-- Mobile Sidebar Backdrop -->
        <div id="mobileSidebarBackdrop" onclick="toggleMobileSidebar()" class="fixed inset-0 bg-slate-900/60 backdrop-blur-sm z-30 hidden lg:hidden transition-opacity"></div>

        <!-- Left Sidebar: Deep Brand Navy matching HomiQ Website Theme -->
        <aside id="mainSidebar" class="w-64 bg-gradient-to-b from-[#0A2540] via-[#081F36] to-[#061826] text-white flex flex-col h-full z-40 flex-shrink-0 justify-between border-r border-slate-800/80 fixed lg:static inset-y-0 left-0 -translate-x-full lg:translate-x-0 transition-transform duration-300 shadow-2xl lg:shadow-none">
            
            <div class="flex flex-col h-full justify-between overflow-y-auto">
                <div>
                    <!-- Brand Logo Container -->
                    <div class="p-5 border-b border-white/10 flex items-center justify-between">
                        <a href="/admin" class="flex items-center gap-3 group">
                            <div class="h-10 w-10 rounded-xl bg-gradient-to-tr from-emerald-500 to-teal-400 p-0.5 shadow-lg shadow-emerald-500/20 flex items-center justify-center">
                                <div class="w-full h-full bg-[#0A2540] rounded-[10px] flex items-center justify-center">
                                    <img src="/logo.png" alt="HomiQ Logo" class="h-6 w-auto object-contain">
                                </div>
                            </div>
                            <div class="leading-tight">
                                <span class="text-base font-black tracking-tight text-white block">Homi<span class="text-emerald-400">Q</span></span>
                                <span class="text-[10px] font-bold text-slate-400 uppercase tracking-widest flex items-center gap-1">
                                    <span class="h-1.5 w-1.5 rounded-full bg-emerald-400 animate-pulse"></span> Control Center
                                </span>
                            </div>
                        </a>
                        <button onclick="toggleMobileSidebar()" class="lg:hidden text-slate-400 hover:text-white p-1 rounded-lg">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                            </svg>
                        </button>
                    </div>

                    <!-- Navigation List -->
                    <nav class="p-3.5 space-y-6">
                        
                        <!-- Group 1: Core Operations -->
                        <div class="space-y-1">
                            <div class="text-[10px] text-slate-400/80 font-extrabold uppercase tracking-widest px-3 mb-2 flex items-center justify-between">
                                <span>Core Operations</span>
                            </div>
                            
                            <!-- Dashboard -->
                            <a href="/admin" class="relative group flex items-center gap-3 px-3.5 py-2.5 rounded-xl transition-all duration-200 {{ Request::is('admin') ? 'text-white font-bold bg-white/10 shadow-sm border border-white/10' : 'text-slate-300 hover:bg-white/5 hover:text-white' }}">
                                @if (Request::is('admin'))
                                    <div class="absolute left-0 top-2 bottom-2 w-1 bg-emerald-400 rounded-r-md shadow-sm shadow-emerald-400"></div>
                                @endif
                                <div class="h-8 w-8 rounded-lg flex items-center justify-center {{ Request::is('admin') ? 'bg-emerald-500/20 text-emerald-400' : 'text-slate-400 group-hover:text-white group-hover:bg-white/5' }} transition">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="w-4.5 h-4.5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.75" d="M3.75 6A2.25 2.25 0 016 3.75h2.25A2.25 2.25 0 0110.5 6v2.25a2.25 2.25 0 01-2.25 2.25H6a2.25 2.25 0 01-2.25-2.25V6zM3.75 15.75A2.25 2.25 0 016 13.5h2.25a2.25 2.25 0 012.25 2.25V18a2.25 2.25 0 01-2.25 2.25H6A2.25 2.25 0 013.75 18v-2.25zM13.5 6a2.25 2.25 0 012.25-2.25H18A2.25 2.25 0 0120.25 6v2.25A2.25 2.25 0 0118 10.5h-2.25a2.25 2.25 0 01-2.25-2.25V6zM13.5 15.75a2.25 2.25 0 012.25-2.25H18a2.25 2.25 0 012.25 2.25V18A2.25 2.25 0 0118 20.25h-2.25A2.25 2.25 0 0113.5 18v-2.25z" />
                                    </svg>
                                </div>
                                <span class="text-xs tracking-wide">Overview</span>
                            </a>

                            <!-- Listing Moderation -->
                            <a href="/admin/properties" class="relative group flex items-center gap-3 px-3.5 py-2.5 rounded-xl transition-all duration-200 {{ Request::is('admin/properties*') ? 'text-white font-bold bg-white/10 shadow-sm border border-white/10' : 'text-slate-300 hover:bg-white/5 hover:text-white' }}">
                                @if (Request::is('admin/properties*'))
                                    <div class="absolute left-0 top-2 bottom-2 w-1 bg-emerald-400 rounded-r-md shadow-sm shadow-emerald-400"></div>
                                @endif
                                <div class="h-8 w-8 rounded-lg flex items-center justify-center {{ Request::is('admin/properties*') ? 'bg-emerald-500/20 text-emerald-400' : 'text-slate-400 group-hover:text-white group-hover:bg-white/5' }} transition">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="w-4.5 h-4.5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.75" d="M2.25 21h19.5m-18-18v18m10.5-18v18m6-13.5V21M6.75 6.75h.75m-.75 3h.75m-.75 3h.75m3-6h.75m-.75 3h.75m-.75 3h.75M6.75 21v-3.75a1.5 1.5 0 011.5-1.5h1.5a1.5 1.5 0 011.5 1.5V21m6-9h.75m-.75 3h.75m-.75 3h.75" />
                                    </svg>
                                </div>
                                <span class="text-xs tracking-wide">Property Moderation</span>
                            </a>

                            <!-- User Manager -->
                            <a href="/admin/users" class="relative group flex items-center gap-3 px-3.5 py-2.5 rounded-xl transition-all duration-200 {{ Request::is('admin/users*') ? 'text-white font-bold bg-white/10 shadow-sm border border-white/10' : 'text-slate-300 hover:bg-white/5 hover:text-white' }}">
                                @if (Request::is('admin/users*'))
                                    <div class="absolute left-0 top-2 bottom-2 w-1 bg-emerald-400 rounded-r-md shadow-sm shadow-emerald-400"></div>
                                @endif
                                <div class="h-8 w-8 rounded-lg flex items-center justify-center {{ Request::is('admin/users*') ? 'bg-emerald-500/20 text-emerald-400' : 'text-slate-400 group-hover:text-white group-hover:bg-white/5' }} transition">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="w-4.5 h-4.5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.75" d="M15 19.128a9.38 9.38 0 002.625.372 9.337 9.337 0 004.121-.952 4.125 4.125 0 00-7.533-2.493M15 19.128v-.003c0-1.113-.285-2.16-.786-3.07M15 19.128v.106A12.318 12.318 0 018.624 21c-2.331 0-4.512-.645-6.374-1.766l-.001-.109a6.375 6.375 0 0111.964-3.07M12 6.375a3.375 3.375 0 11-6.75 0 3.375 3.375 0 016.75 0zm8.25 2.25a2.625 2.625 0 11-5.25 0 2.625 2.625 0 015.25 0z" />
                                    </svg>
                                </div>
                                <span class="text-xs tracking-wide">User Management</span>
                            </a>

                            <!-- Demand Board -->
                            <a href="/admin/demands" class="relative group flex items-center gap-3 px-3.5 py-2.5 rounded-xl transition-all duration-200 {{ Request::is('admin/demands*') ? 'text-white font-bold bg-white/10 shadow-sm border border-white/10' : 'text-slate-300 hover:bg-white/5 hover:text-white' }}">
                                @if (Request::is('admin/demands*'))
                                    <div class="absolute left-0 top-2 bottom-2 w-1 bg-emerald-400 rounded-r-md shadow-sm shadow-emerald-400"></div>
                                @endif
                                <div class="h-8 w-8 rounded-lg flex items-center justify-center {{ Request::is('admin/demands*') ? 'bg-emerald-500/20 text-emerald-400' : 'text-slate-400 group-hover:text-white group-hover:bg-white/5' }} transition">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="w-4.5 h-4.5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.75" d="M9 12h3.75M9 15h3.75M9 18h3.75m3 .75H18a2.25 2.25 0 002.25-2.25V6.108c0-1.135-.845-2.098-1.976-2.192a48.424 48.424 0 00-1.123-.08m-5.801 0c-.065.21-.1.433-.1.664 0 .414.336.75.75.75h4.5a.75.75 0 00.75-.75 2.25 2.25 0 00-.1-.664m-5.8 0A2.251 2.251 0 0113.5 2.25H15c1.012 0 1.867.668 2.15 1.586m-5.8 0c-.376.023-.75.05-1.124.08C9.095 4.01 8.25 4.973 8.25 6.108V8.25m0 0H4.875c-.621 0-1.125.504-1.125 1.125v11.25c0 .621.504 1.125 1.125 1.125h9.75c.621 0 1.125-.504 1.125-1.125V9.375c0-.621-.504-1.125-1.125-1.125H8.25zM6.75 12h.008v.008H6.75V12zm0 3h.008v.008H6.75V15zm0 3h.008v.008H6.75V18z" />
                                    </svg>
                                </div>
                                <span class="text-xs tracking-wide">Demand Board</span>
                            </a>

                            <!-- Financial Analytics -->
                            <a href="/admin/financials" class="relative group flex items-center gap-3 px-3.5 py-2.5 rounded-xl transition-all duration-200 {{ Request::is('admin/financials*') ? 'text-white font-bold bg-white/10 shadow-sm border border-white/10' : 'text-slate-300 hover:bg-white/5 hover:text-white' }}">
                                @if (Request::is('admin/financials*'))
                                    <div class="absolute left-0 top-2 bottom-2 w-1 bg-emerald-400 rounded-r-md shadow-sm shadow-emerald-400"></div>
                                @endif
                                <div class="h-8 w-8 rounded-lg flex items-center justify-center {{ Request::is('admin/financials*') ? 'bg-emerald-500/20 text-emerald-400' : 'text-slate-400 group-hover:text-white group-hover:bg-white/5' }} transition">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="w-4.5 h-4.5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.75" d="M2.25 18.75a60.07 60.07 0 0115.797 2.101c.727.198 1.453-.342 1.453-1.096V18.75M3.75 4.5v.75A.75.75 0 013 6h-.75m0 0v-.375c0-.621.504-1.125 1.125-1.125H20.25M2.25 6v9m18-10.5v.75c0 .414.336.75.75.75h.75m-1.5-1.5h.375c.621 0 1.125.504 1.125 1.125v9.75c0 .621-.504 1.125-1.125 1.125h-.375m1.5-1.5H21a.75.75 0 00-.75.75v.75m0 0H3.75m0 0h-.375a1.125 1.125 0 01-1.125-1.125V15m1.5 1.5v-.75A.75.75 0 003 15h-.75M15 10.5a3 3 0 11-6 0 3 3 0 016 0zm3 0h.008v.008H18V10.5zm-12 0h.008v.008H6V10.5z" />
                                    </svg>
                                </div>
                                <span class="text-xs tracking-wide">Financial Analytics</span>
                            </a>

                            <!-- Referral Payouts & Withdrawals -->
                            <a href="/admin/withdrawals" class="relative group flex items-center gap-3 px-3.5 py-2.5 rounded-xl transition-all duration-200 {{ Request::is('admin/withdrawals*') ? 'text-white font-bold bg-white/10 shadow-sm border border-white/10' : 'text-slate-300 hover:bg-white/5 hover:text-white' }}">
                                @if (Request::is('admin/withdrawals*'))
                                    <div class="absolute left-0 top-2 bottom-2 w-1 bg-emerald-400 rounded-r-md shadow-sm shadow-emerald-400"></div>
                                @endif
                                <div class="h-8 w-8 rounded-lg flex items-center justify-center {{ Request::is('admin/withdrawals*') ? 'bg-emerald-500/20 text-emerald-400' : 'text-slate-400 group-hover:text-white group-hover:bg-white/5' }} transition">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="w-4.5 h-4.5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.75" d="M12 6v12m-3-2.818l.879.659c1.171.879 3.07.879 4.242 0 1.172-.879 1.172-2.303 0-3.182C13.536 12.219 12.768 12 12 12c-.725 0-1.45-.22-2.003-.659-1.106-.879-1.106-2.303 0-3.182s2.9-.879 4.006 0l.415.33M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                    </svg>
                                </div>
                                <span class="text-xs tracking-wide">Referral Payouts</span>
                            </a>

                            <!-- Push Notifications -->
                            <a href="/admin/notifications" class="relative group flex items-center gap-3 px-3.5 py-2.5 rounded-xl transition-all duration-200 {{ Request::is('admin/notifications*') ? 'text-white font-bold bg-white/10 shadow-sm border border-white/10' : 'text-slate-300 hover:bg-white/5 hover:text-white' }}">
                                @if (Request::is('admin/notifications*'))
                                    <div class="absolute left-0 top-2 bottom-2 w-1 bg-emerald-400 rounded-r-md shadow-sm shadow-emerald-400"></div>
                                @endif
                                <div class="h-8 w-8 rounded-lg flex items-center justify-center {{ Request::is('admin/notifications*') ? 'bg-emerald-500/20 text-emerald-400' : 'text-slate-400 group-hover:text-white group-hover:bg-white/5' }} transition">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="w-4.5 h-4.5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.75" d="M14.857 17.082a23.848 23.848 0 005.454-1.31A8.967 8.967 0 0118 9.75v-.7V9A6 6 0 006 9v.75a8.967 8.967 0 01-2.312 6.022c1.733.64 3.56 1.085 5.455 1.31m5.714 0a24.255 24.255 0 01-5.714 0m5.714 0a3 3 0 11-5.714 0M3.124 7.5A8.969 8.969 0 015.292 3m13.416 0a8.969 8.969 0 012.168 4.5" />
                                    </svg>
                                </div>
                                <span class="text-xs tracking-wide">Push Notifications</span>
                            </a>
                        </div>

                        <!-- Group 2: Platform Settings & Attributes -->
                        <div class="space-y-1">
                            <div class="text-[10px] text-slate-400/80 font-extrabold uppercase tracking-widest px-3 mb-2 flex items-center justify-between">
                                <span>Platform System</span>
                            </div>

                            <!-- Page Settings -->
                            <a href="/admin/settings" class="relative group flex items-center gap-3 px-3.5 py-2.5 rounded-xl transition-all duration-200 {{ Request::is('admin/settings*') ? 'text-white font-bold bg-white/10 shadow-sm border border-white/10' : 'text-slate-300 hover:bg-white/5 hover:text-white' }}">
                                @if (Request::is('admin/settings*'))
                                    <div class="absolute left-0 top-2 bottom-2 w-1 bg-emerald-400 rounded-r-md shadow-sm shadow-emerald-400"></div>
                                @endif
                                <div class="h-8 w-8 rounded-lg flex items-center justify-center {{ Request::is('admin/settings*') ? 'bg-emerald-500/20 text-emerald-400' : 'text-slate-400 group-hover:text-white group-hover:bg-white/5' }} transition">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="w-4.5 h-4.5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.75" d="M19.5 14.25v-2.625a3.375 3.375 0 00-3.375-3.375h-1.5A1.125 1.125 0 0113.5 7.125v-1.5a3.375 3.375 0 00-3.375-3.375H8.25m0 12.75h7.5m-7.5 3H12M10.5 2.25H5.625c-.621 0-1.125.504-1.125 1.125v17.25c0 .621.504 1.125 1.125 1.125h12.75c.621 0 1.125-.504 1.125-1.125V11.25a9 9 0 00-9-9z" />
                                    </svg>
                                </div>
                                <span class="text-xs tracking-wide">CMS & Pages</span>
                            </a>

                            <!-- App Configurations -->
                            <a href="/admin/config" class="relative group flex items-center gap-3 px-3.5 py-2.5 rounded-xl transition-all duration-200 {{ Request::is('admin/config*') ? 'text-white font-bold bg-white/10 shadow-sm border border-white/10' : 'text-slate-300 hover:bg-white/5 hover:text-white' }}">
                                @if (Request::is('admin/config*'))
                                    <div class="absolute left-0 top-2 bottom-2 w-1 bg-emerald-400 rounded-r-md shadow-sm shadow-emerald-400"></div>
                                @endif
                                <div class="h-8 w-8 rounded-lg flex items-center justify-center {{ Request::is('admin/config*') ? 'bg-emerald-500/20 text-emerald-400' : 'text-slate-400 group-hover:text-white group-hover:bg-white/5' }} transition">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="w-4.5 h-4.5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.75" d="M10.5 6h9.75M10.5 6a1.5 1.5 0 11-3 0m3 0a1.5 1.5 0 10-3 0M3.75 6H7.5m3 12h9.75m-9.75 0a1.5 1.5 0 01-3 0m3 0a1.5 1.5 0 00-3 0m-3.75 0H7.5m9-6h3.75m-3.75 0a1.5 1.5 0 01-3 0m3 0a1.5 1.5 0 00-3 0m-9.75 0h9.75" />
                                    </svg>
                                </div>
                                <span class="text-xs tracking-wide">Configurations</span>
                            </a>

                            <!-- Listing Attributes -->
                            <a href="/admin/attributes" class="relative group flex items-center gap-3 px-3.5 py-2.5 rounded-xl transition-all duration-200 {{ Request::is('admin/attributes*') ? 'text-white font-bold bg-white/10 shadow-sm border border-white/10' : 'text-slate-300 hover:bg-white/5 hover:text-white' }}">
                                @if (Request::is('admin/attributes*'))
                                    <div class="absolute left-0 top-2 bottom-2 w-1 bg-emerald-400 rounded-r-md shadow-sm shadow-emerald-400"></div>
                                @endif
                                <div class="h-8 w-8 rounded-lg flex items-center justify-center {{ Request::is('admin/attributes*') ? 'bg-emerald-500/20 text-emerald-400' : 'text-slate-400 group-hover:text-white group-hover:bg-white/5' }} transition">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="w-4.5 h-4.5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.75" d="M9.568 3H5.25A2.25 2.25 0 003 5.25v4.318c0 .597.237 1.17.659 1.591l9.581 9.581c.699.699 1.78.872 2.607.386a34.78 34.78 0 003.882-3.882c.486-.827.313-1.908-.386-2.607l-9.581-9.581A2.25 2.25 0 009.568 3z" />
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.75" d="M6 6h.008v.008H6V6z" />
                                    </svg>
                                </div>
                                <span class="text-xs tracking-wide">Attributes & Categories</span>
                            </a>

                            <!-- User Feedback -->
                            <a href="/admin/feedbacks" class="relative group flex items-center gap-3 px-3.5 py-2.5 rounded-xl transition-all duration-200 {{ Request::is('admin/feedbacks*') ? 'text-white font-bold bg-white/10 shadow-sm border border-white/10' : 'text-slate-300 hover:bg-white/5 hover:text-white' }}">
                                @if (Request::is('admin/feedbacks*'))
                                    <div class="absolute left-0 top-2 bottom-2 w-1 bg-emerald-400 rounded-r-md shadow-sm shadow-emerald-400"></div>
                                @endif
                                <div class="h-8 w-8 rounded-lg flex items-center justify-center {{ Request::is('admin/feedbacks*') ? 'bg-emerald-500/20 text-emerald-400' : 'text-slate-400 group-hover:text-white group-hover:bg-white/5' }} transition">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="w-4.5 h-4.5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.75" d="M7.5 8.25h9m-9 3H12m-9.75 1.51c0 1.6 1.123 2.994 2.707 3.227 1.129.166 2.27.293 3.423.379.35.026.67.21.865.501L12 21l2.755-4.133a1.14 1.14 0 01.865-.501 48.172 48.172 0 003.423-.379c1.584-.233 2.707-1.626 2.707-3.228V6.741c0-1.602-1.123-2.995-2.707-3.228A48.394 48.394 0 0012 3c-2.392 0-4.744.175-7.043.513C3.373 3.746 2.25 5.14 2.25 6.741v6.018z" />
                                    </svg>
                                </div>
                                <span class="text-xs tracking-wide">Inquiries & Feedback</span>
                            </a>
                        </div>
                    </nav>
                </div>

                <!-- Bottom Sidebar Widget & Admin Profile -->
                <div class="p-4 space-y-4 border-t border-white/10 bg-black/20">
                    
                    <!-- Quick Portal Card -->
                    <div class="relative bg-gradient-to-br from-[#0F365E]/60 to-[#0A2540]/90 p-3.5 rounded-xl border border-white/10 text-white shadow-inner">
                        <div class="flex items-center gap-2.5 mb-1.5">
                            <span class="h-2 w-2 rounded-full bg-emerald-400 animate-pulse"></span>
                            <span class="text-[10px] font-extrabold uppercase tracking-wider text-emerald-300">Live Website</span>
                        </div>
                        <p class="text-[11px] text-slate-300 leading-snug">Quick access to the main platform.</p>
                        <a href="/" target="_blank" class="mt-2.5 w-full py-1.5 px-3 bg-white/10 hover:bg-emerald-600 hover:text-white text-emerald-300 rounded-lg text-[10px] font-bold transition flex items-center justify-center gap-1.5 border border-white/10">
                            <span>Visit HomiQ.in</span>
                            <svg xmlns="http://www.w3.org/2000/svg" class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.5 6H5.25A2.25 2.25 0 003 8.25v10.5A2.25 2.25 0 005.25 21h10.5A2.25 2.25 0 0018 18.75V10.5m-10.5 6L21 3m0 0h-5.25M21 3v5.25" />
                            </svg>
                        </a>
                    </div>

                    <!-- Admin Session Info & Quick Logout -->
                    <div class="flex items-center justify-between pt-1">
                        <div class="flex items-center gap-2.5 overflow-hidden">
                            @if(Auth::user()->profile_photo)
                                <img src="{{ Auth::user()->profile_photo }}" class="w-8 h-8 rounded-full object-cover border border-emerald-500/30 shadow-sm" alt="Admin avatar">
                            @else
                                <div class="h-8 w-8 rounded-full bg-gradient-to-tr from-emerald-500 to-teal-400 flex items-center justify-center font-bold text-xs text-slate-900 shadow-sm">
                                    {{ substr(Auth::user()->name, 0, 1) }}
                                </div>
                            @endif
                            <div class="overflow-hidden">
                                <p class="text-xs font-bold text-white truncate leading-tight">{{ Auth::user()->name }}</p>
                                <span class="text-[10px] text-slate-400 font-medium">Administrator</span>
                            </div>
                        </div>
                        <button type="button" onclick="openLogoutModal()" title="Sign Out" class="text-slate-400 hover:text-rose-400 p-1.5 rounded-lg hover:bg-white/5 transition">
                            <svg xmlns="http://www.w3.org/2000/svg" class="w-4.5 h-4.5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.75" d="M15.75 9V5.25A2.25 2.25 0 0013.5 3h-6a2.25 2.25 0 00-2.25 2.25v13.5A2.25 2.25 0 007.5 21h6a2.25 2.25 0 002.25-2.25V15M12 9l-3 3m0 0l3 3m-3-3h12.75" />
                            </svg>
                        </button>
                    </div>
                </div>
            </div>
        </aside>

        <!-- Right Content & Header Area -->
        <div class="flex-1 flex flex-col h-full bg-[#F8FAFC] overflow-hidden">
            
            <!-- Top App Header Bar -->
            <header class="h-16 bg-white/90 backdrop-blur-md border-b border-slate-200/80 flex items-center justify-between px-6 lg:px-8 flex-shrink-0 z-20">
                
                <!-- Left: Mobile Menu Toggle + Breadcrumbs / Title -->
                <div class="flex items-center gap-4">
                    <button onclick="toggleMobileSidebar()" class="lg:hidden p-2 rounded-lg text-slate-600 hover:bg-slate-100 transition">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3.75 6.75h16.5M3.75 12h16.5m-16.5 5.25h16.5" />
                        </svg>
                    </button>
                    
                    <div class="hidden sm:flex items-center gap-2 text-xs">
                        <span class="text-slate-400 font-medium">Admin</span>
                        <span class="text-slate-300">/</span>
                        <span class="text-slate-700 font-bold">@yield('page_title', 'Dashboard')</span>
                    </div>
                </div>

                <!-- Center Search bar (Command Palette Trigger) -->
                <div class="w-72 lg:w-96 relative hidden md:block cursor-pointer group" onclick="openCommandPalette()">
                    <span class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none text-slate-400 group-hover:text-emerald-500 transition">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-5.197-5.197m0 0A7.5 7.5 0 105.196 5.196a7.5 7.5 0 0010.607 10.607z" />
                        </svg>
                    </span>
                    <input type="text" placeholder="Search properties, members, shortcuts..." readonly
                           class="w-full pl-10 pr-12 py-2 text-xs font-medium rounded-xl border border-slate-200 bg-slate-50/80 text-slate-600 placeholder-slate-400 cursor-pointer group-hover:border-emerald-500/50 group-hover:bg-white focus:outline-none focus:ring-2 focus:ring-emerald-500/20 focus:border-emerald-500 transition shadow-2xs">
                    <span class="absolute inset-y-0 right-0 pr-3 flex items-center pointer-events-none">
                        <span class="px-1.5 py-0.5 bg-white border border-slate-200 text-[10px] font-bold text-slate-400 rounded-md shadow-2xs group-hover:border-emerald-300 group-hover:text-emerald-600 transition">⌘ K</span>
                    </span>
                </div>

                <!-- Right Navigation utilities and profile card pill -->
                <div class="flex items-center gap-3">
                    
                    <!-- Mobile Search Trigger Button -->
                    <button onclick="openCommandPalette()" class="md:hidden p-2 rounded-lg text-slate-600 hover:bg-slate-100 hover:text-emerald-600 transition" title="Search (⌘K)">
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-4.5 h-4.5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-5.197-5.197m0 0A7.5 7.5 0 105.196 5.196a7.5 7.5 0 0010.607 10.607z" />
                        </svg>
                    </button>

                    <!-- Visit Website Link Pill -->
                    <a href="/" target="_blank" class="hidden sm:inline-flex items-center gap-1.5 px-3 py-1.5 rounded-lg border border-slate-200 text-xs font-semibold text-slate-650 hover:bg-slate-50 hover:text-emerald-600 transition">
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-3.5 h-3.5 text-slate-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.5 6H5.25A2.25 2.25 0 003 8.25v10.5A2.25 2.25 0 005.25 21h10.5A2.25 2.25 0 0018 18.75V10.5m-10.5 6L21 3m0 0h-5.25M21 3v5.25" />
                        </svg>
                        <span>Live Site</span>
                    </a>

                    <!-- Notification Bell -->
                    <a href="/admin/notifications" class="relative h-9 w-9 rounded-xl bg-slate-50 border border-slate-200 flex items-center justify-center text-slate-500 hover:bg-slate-100 hover:text-slate-800 transition" title="Broadcast Notifications">
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-4.5 h-4.5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.75" d="M14.857 17.082a23.848 23.848 0 005.454-1.31A8.967 8.967 0 0118 9.75v-.7V9A6 6 0 006 9v.75a8.967 8.967 0 01-2.312 6.022c1.733.64 3.56 1.085 5.455 1.31m5.714 0a24.255 24.255 0 01-5.714 0m5.714 0a3 3 0 11-5.714 0" />
                        </svg>
                        <span class="absolute top-1.5 right-1.5 h-2 w-2 rounded-full bg-emerald-500 ring-2 ring-white"></span>
                    </a>
 
                    <div class="h-6 w-px bg-slate-200"></div>
 
                    <!-- Profile Pill Dropdown Container -->
                    <div class="relative">
                        <button onclick="toggleProfileDropdown(event)" class="flex items-center gap-2.5 hover:bg-slate-50 p-1.5 rounded-xl border border-transparent hover:border-slate-200 transition focus:outline-none">
                            @if(Auth::user()->profile_photo)
                                <img src="{{ Auth::user()->profile_photo }}" class="w-8 h-8 rounded-full object-cover border border-slate-200 shadow-sm" alt="Admin avatar">
                            @else
                                <div class="h-8 w-8 bg-gradient-to-tr from-emerald-500 to-teal-400 text-slate-900 rounded-full flex items-center justify-center font-bold text-xs shadow-sm">
                                    {{ substr(Auth::user()->name, 0, 1) }}
                                </div>
                            @endif
                            <div class="text-left leading-none hidden md:block">
                                <span class="text-xs font-bold text-slate-800 block mb-0.5">{{ Auth::user()->name }}</span>
                                <span class="text-[10px] text-emerald-600 font-semibold flex items-center gap-1">
                                    <span class="h-1.5 w-1.5 rounded-full bg-emerald-500"></span> Super Admin
                                </span>
                            </div>
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-3.5 w-3.5 text-slate-400 hidden md:block" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19.5 8.25l-7.5 7.5-7.5-7.5" />
                            </svg>
                        </button>
                        
                        <!-- Dropdown Menu -->
                        <div id="profileDropdown" class="absolute right-0 mt-2 w-52 bg-white border border-slate-200/80 rounded-2xl shadow-xl py-2 hidden z-30 transition">
                            <div class="px-4 py-2.5 border-b border-slate-100">
                                <p class="text-xs font-bold text-slate-800">{{ Auth::user()->name }}</p>
                                <p class="text-[10px] text-slate-400 truncate">{{ Auth::user()->email }}</p>
                            </div>
                            <a href="/admin/profile" class="flex items-center gap-2.5 px-4 py-2.5 text-xs text-slate-700 hover:bg-slate-50 hover:text-emerald-700 transition font-semibold">
                                <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4 text-emerald-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.75" d="M15.75 6a3.75 3.75 0 11-7.5 0 3.75 3.75 0 017.5 0zM4.501 20.118a7.5 7.5 0 0114.998 0A17.933 17.933 0 0112 21.75c-2.676 0-5.216-.584-7.499-1.632z" />
                                </svg>
                                <span>Account Settings</span>
                            </a>
                            <a href="/admin/config" class="flex items-center gap-2.5 px-4 py-2.5 text-xs text-slate-700 hover:bg-slate-50 hover:text-emerald-700 transition font-semibold">
                                <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4 text-emerald-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.75" d="M10.5 6h9.75M10.5 6a1.5 1.5 0 11-3 0m3 0a1.5 1.5 0 10-3 0M3.75 6H7.5m3 12h9.75m-9.75 0a1.5 1.5 0 01-3 0m3 0a1.5 1.5 0 00-3 0m-3.75 0H7.5m9-6h3.75m-3.75 0a1.5 1.5 0 01-3 0m3 0a1.5 1.5 0 00-3 0m-9.75 0h9.75" />
                                </svg>
                                <span>Platform Config</span>
                            </a>
                            <hr class="border-slate-100 my-1">
                            <button onclick="openLogoutModal()" class="w-full text-left flex items-center gap-2.5 px-4 py-2.5 text-xs text-rose-600 hover:bg-rose-50 transition font-bold">
                                <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4 text-rose-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.75" d="M15.75 9V5.25A2.25 2.25 0 0013.5 3h-6a2.25 2.25 0 00-2.25 2.25v13.5A2.25 2.25 0 007.5 21h6a2.25 2.25 0 002.25-2.25V15M12 9l-3 3m0 0l3 3m-3-3h12.75" />
                                </svg>
                                <span>Sign Out</span>
                            </button>
                        </div>
                    </div>
                </div>
            </header>

            <!-- Main Body Scroll View -->
            <main class="flex-1 overflow-y-auto p-6 lg:p-8 bg-[#F8FAFC]">
                
                <!-- Feedback toasts -->
                @if (session('success'))
                    <div class="alert-toast mb-6 p-4 bg-emerald-50 text-emerald-900 border border-emerald-200 rounded-2xl flex items-center gap-3 shadow-sm animate-fade-in">
                        <div class="p-1.5 bg-emerald-600 text-white rounded-xl shadow-xs">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" viewBox="0 0 20 20" fill="currentColor">
                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd" />
                            </svg>
                        </div>
                        <span class="text-xs font-bold">{{ session('success') }}</span>
                    </div>
                @endif

                @if ($errors->any())
                    <div class="alert-toast mb-6 p-4 bg-rose-50 text-rose-900 border border-rose-200 rounded-2xl flex flex-col gap-2 shadow-sm animate-fade-in">
                        @foreach ($errors->all() as $error)
                            <div class="flex items-center gap-3">
                                <div class="p-1.5 bg-rose-500 text-white rounded-xl shadow-xs">
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
                <div class="animate-fade-in max-w-[1400px] mx-auto w-full">
                    @yield('content')
                </div>
            </main>
        </div>

    </div>

    <!-- Modern Sign Out Confirmation Modal -->
    <div id="logoutConfirmModal" class="fixed inset-0 bg-slate-900/60 backdrop-blur-sm z-50 flex items-center justify-center hidden opacity-0 transition-opacity duration-300">
        <div class="bg-white rounded-2xl border border-slate-200 p-6 w-full max-w-sm shadow-2xl scale-95 transition-transform duration-300" id="logoutModalContent">
            <div class="flex flex-col items-center text-center space-y-4">
                <!-- Icon -->
                <div class="h-12 w-12 rounded-2xl bg-rose-50 border border-rose-100 flex items-center justify-center text-rose-500 shadow-sm">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.75" d="M15.75 9V5.25A2.25 2.25 0 0013.5 3h-6a2.25 2.25 0 00-2.25 2.25v13.5A2.25 2.25 0 007.5 21h6a2.25 2.25 0 002.25-2.25V15M12 9l-3 3m0 0l3 3m-3-3h12.75" />
                    </svg>
                </div>
                
                <!-- Text -->
                <div class="space-y-1">
                    <h3 class="text-base font-extrabold text-slate-800">Confirm Sign Out</h3>
                    <p class="text-xs text-slate-500 leading-relaxed">Are you sure you want to end your active administrator session?</p>
                </div>

                <!-- Actions -->
                <div class="flex w-full gap-3 pt-2">
                    <button onclick="closeLogoutModal()" class="flex-1 py-2.5 bg-slate-100 hover:bg-slate-200 text-slate-700 text-xs font-bold rounded-xl transition text-center">
                        Cancel
                    </button>
                    <form action="/logout" method="POST" class="flex-1 m-0">
                        @csrf
                        <button type="submit" class="w-full py-2.5 bg-rose-600 hover:bg-rose-700 text-white text-xs font-bold rounded-xl shadow-md shadow-rose-600/20 transition text-center">
                            Sign Out
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Dropdown and Logout logic script -->
    <script>
        function toggleMobileSidebar() {
            const sidebar = document.getElementById('mainSidebar');
            const backdrop = document.getElementById('mobileSidebarBackdrop');
            if (sidebar.classList.contains('-translate-x-full')) {
                sidebar.classList.remove('-translate-x-full');
                backdrop.classList.remove('hidden');
            } else {
                sidebar.classList.add('-translate-x-full');
                backdrop.classList.add('hidden');
            }
        }

        function toggleProfileDropdown(event) {
            event.stopPropagation();
            const dropdown = document.getElementById('profileDropdown');
            dropdown.classList.toggle('hidden');
        }

        function openLogoutModal() {
            const modal = document.getElementById('logoutConfirmModal');
            const content = document.getElementById('logoutModalContent');
            
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

        /* =======================================================
         *  COMMAND PALETTE (⌘K) & AJAX INSTANT SEARCH CONTROLLER
         * ======================================================= */
        let cmdDebounceTimer = null;
        let cmdSelectedIndex = 0;
        let cmdResultsCache = null;

        function openCommandPalette() {
            const modal = document.getElementById('commandPaletteModal');
            const content = document.getElementById('commandPaletteContent');
            const input = document.getElementById('commandPaletteInput');

            modal.classList.remove('hidden');
            setTimeout(() => {
                modal.classList.remove('opacity-0');
                content.classList.remove('scale-95');
                input.focus();
                input.select();
            }, 10);

            // Fetch initial shortcuts if empty
            if (!input.value.trim()) {
                fetchCommandPaletteResults('');
            }
        }

        function closeCommandPalette() {
            const modal = document.getElementById('commandPaletteModal');
            const content = document.getElementById('commandPaletteContent');

            content.classList.add('scale-95');
            modal.classList.add('opacity-0');
            setTimeout(() => {
                modal.classList.add('hidden');
            }, 200);
        }

        function closeCommandPaletteOutside(event) {
            if (event.target.id === 'commandPaletteModal') {
                closeCommandPalette();
            }
        }

        function toggleCommandPalette() {
            const modal = document.getElementById('commandPaletteModal');
            if (modal.classList.contains('hidden')) {
                openCommandPalette();
            } else {
                closeCommandPalette();
            }
        }

        // Global Shortcut Keydown Listener (⌘K / Ctrl+K / Escape)
        document.addEventListener('keydown', function(e) {
            if ((e.metaKey || e.ctrlKey) && e.key.toLowerCase() === 'k') {
                e.preventDefault();
                toggleCommandPalette();
            } else if (e.key === 'Escape') {
                const modal = document.getElementById('commandPaletteModal');
                if (modal && !modal.classList.contains('hidden')) {
                    closeCommandPalette();
                }
            } else {
                // Handle keyboard navigation inside command palette
                const modal = document.getElementById('commandPaletteModal');
                if (modal && !modal.classList.contains('hidden')) {
                    const items = document.querySelectorAll('.cmd-item');
                    if (!items.length) return;

                    if (e.key === 'ArrowDown') {
                        e.preventDefault();
                        cmdSelectedIndex = (cmdSelectedIndex + 1) % items.length;
                        updateSelectedCommandItem(items);
                    } else if (e.key === 'ArrowUp') {
                        e.preventDefault();
                        cmdSelectedIndex = (cmdSelectedIndex - 1 + items.length) % items.length;
                        updateSelectedCommandItem(items);
                    } else if (e.key === 'Enter') {
                        e.preventDefault();
                        if (items[cmdSelectedIndex]) {
                            items[cmdSelectedIndex].click();
                        }
                    }
                }
            }
        });

        function updateSelectedCommandItem(items) {
            items.forEach((item, idx) => {
                if (idx === cmdSelectedIndex) {
                    item.classList.add('bg-emerald-50/80', 'border-emerald-200');
                    item.scrollIntoView({ block: 'nearest', behavior: 'smooth' });
                } else {
                    item.classList.remove('bg-emerald-50/80', 'border-emerald-200');
                }
            });
        }

        // Real-time Input Debounced Search Listener
        const cmdInput = document.getElementById('commandPaletteInput');
        if (cmdInput) {
            cmdInput.addEventListener('input', function(e) {
                clearTimeout(cmdDebounceTimer);
                const query = e.target.value.trim();
                const spinner = document.getElementById('commandPaletteSpinner');
                if (spinner) spinner.classList.remove('hidden');

                cmdDebounceTimer = setTimeout(() => {
                    fetchCommandPaletteResults(query);
                }, 180);
            });
        }

        async function fetchCommandPaletteResults(query) {
            const resultsContainer = document.getElementById('commandPaletteResults');
            const countBadge = document.getElementById('commandPaletteCount');
            const spinner = document.getElementById('commandPaletteSpinner');

            try {
                const res = await fetch(`/admin/quick-search?q=${encodeURIComponent(query)}`);
                const data = await res.json();
                if (spinner) spinner.classList.add('hidden');

                renderCommandPaletteResults(data);
            } catch (err) {
                if (spinner) spinner.classList.add('hidden');
                resultsContainer.innerHTML = `
                    <div class="p-6 text-center text-slate-400 text-xs font-semibold">
                        Unable to fetch instant search results.
                    </div>
                `;
            }
        }

        function renderCommandPaletteResults(data) {
            const container = document.getElementById('commandPaletteResults');
            const countBadge = document.getElementById('commandPaletteCount');
            const res = data.results;
            cmdSelectedIndex = 0;

            if (data.total === 0) {
                container.innerHTML = `
                    <div class="py-12 text-center text-slate-400 space-y-2">
                        <div class="w-12 h-12 bg-slate-100 rounded-2xl flex items-center justify-center mx-auto text-slate-400 mb-2">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.75" d="M21 21l-5.197-5.197m0 0A7.5 7.5 0 105.196 5.196a7.5 7.5 0 0010.607 10.607z"/></svg>
                        </div>
                        <p class="text-xs font-bold text-slate-700">No results found for "${data.query}"</p>
                        <p class="text-[11px] text-slate-400">Try searching for property title, owner, locality, or page name.</p>
                    </div>
                `;
                if (countBadge) countBadge.innerText = '0 Results';
                return;
            }

            let html = '';

            // 1. Navigation & System Shortcuts
            if (res.shortcuts && res.shortcuts.length > 0) {
                html += `
                    <div class="space-y-1">
                        <div class="text-[10px] font-extrabold uppercase tracking-wider text-slate-400 px-3 py-1 flex items-center justify-between">
                            <span>Navigation & Actions</span>
                            <span>${res.shortcuts.length}</span>
                        </div>
                `;
                res.shortcuts.forEach(s => {
                    html += `
                        <a href="${s.url}" class="cmd-item flex items-center justify-between p-2.5 px-3.5 rounded-xl hover:bg-slate-100/80 border border-transparent transition group cursor-pointer">
                            <div class="flex items-center gap-3">
                                <div class="h-8 w-8 rounded-lg bg-emerald-500/10 text-emerald-600 flex items-center justify-center group-hover:bg-emerald-500 group-hover:text-white transition">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.5 4.5L21 12m0 0l-7.5 7.5M21 12H3"/></svg>
                                </div>
                                <div class="text-left">
                                    <p class="text-xs font-bold text-slate-800 group-hover:text-emerald-950 transition">${s.title}</p>
                                    <p class="text-[10px] text-slate-400 line-clamp-1">${s.subtitle}</p>
                                </div>
                            </div>
                            <span class="px-2 py-0.5 rounded text-[10px] font-bold bg-slate-100 text-slate-600 border border-slate-200/60">${s.badge || 'Jump'}</span>
                        </a>
                    `;
                });
                html += `</div>`;
            }

            // 2. Properties Catalog
            if (res.properties && res.properties.length > 0) {
                html += `
                    <div class="space-y-1">
                        <div class="text-[10px] font-extrabold uppercase tracking-wider text-slate-400 px-3 py-1 flex items-center justify-between">
                            <span>Properties Catalog</span>
                            <span>${res.properties.length}</span>
                        </div>
                `;
                res.properties.forEach(p => {
                    html += `
                        <a href="${p.url}" class="cmd-item flex items-center justify-between p-2.5 px-3.5 rounded-xl hover:bg-slate-100/80 border border-transparent transition group cursor-pointer">
                            <div class="flex items-center gap-3 max-w-[80%]">
                                <div class="h-8 w-8 rounded-lg bg-emerald-50 text-emerald-600 flex items-center justify-center group-hover:bg-emerald-600 group-hover:text-white transition flex-shrink-0">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.75" d="M2.25 21h19.5m-18-18v18m10.5-18v18m6-13.5V21M6.75 6.75h.75m-.75 3h.75m-.75 3h.75m3-6h.75m-.75 3h.75m-.75 3h.75M6.75 21v-3.75a1.5 1.5 0 011.5-1.5h1.5a1.5 1.5 0 011.5 1.5V21m6-9h.75m-.75 3h.75m-.75 3h.75"/></svg>
                                </div>
                                <div class="text-left overflow-hidden">
                                    <p class="text-xs font-bold text-slate-800 truncate group-hover:text-slate-900 transition">${p.title}</p>
                                    <p class="text-[10px] text-slate-400 truncate">${p.subtitle}</p>
                                </div>
                            </div>
                            <span class="px-2 py-0.5 rounded-full text-[10px] font-extrabold bg-${p.badge_color}-50 text-${p.badge_color}-700 border border-${p.badge_color}-200">${p.badge}</span>
                        </a>
                    `;
                });
                html += `</div>`;
            }

            // 3. Seeker Demands
            if (res.demands && res.demands.length > 0) {
                html += `
                    <div class="space-y-1">
                        <div class="text-[10px] font-extrabold uppercase tracking-wider text-slate-400 px-3 py-1 flex items-center justify-between">
                            <span>Seeker Inquiries & Demands</span>
                            <span>${res.demands.length}</span>
                        </div>
                `;
                res.demands.forEach(d => {
                    html += `
                        <a href="${d.url}" class="cmd-item flex items-center justify-between p-2.5 px-3.5 rounded-xl hover:bg-slate-100/80 border border-transparent transition group cursor-pointer">
                            <div class="flex items-center gap-3 max-w-[80%]">
                                <div class="h-8 w-8 rounded-lg bg-teal-50 text-teal-600 flex items-center justify-center group-hover:bg-teal-600 group-hover:text-white transition flex-shrink-0">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.75" d="M9 12h3.75M9 15h3.75M9 18h3.75m3 .75H18a2.25 2.25 0 002.25-2.25V6.108c0-1.135-.845-2.098-1.976-2.192a48.424 48.424 0 00-1.123-.08m-5.801 0c-.065.21-.1.433-.1.664 0 .414.336.75.75.75h4.5a.75.75 0 00.75-.75 2.25 2.25 0 00-.1-.664m-5.8 0A2.251 2.251 0 0113.5 2.25H15c1.012 0 1.867.668 2.15 1.586m-5.8 0c-.376.023-.75.05-1.124.08C9.095 4.01 8.25 4.973 8.25 6.108V8.25m0 0H4.875c-.621 0-1.125.504-1.125 1.125v11.25c0 .621.504 1.125 1.125 1.125h9.75c.621 0 1.125-.504 1.125-1.125V9.375c0-.621-.504-1.125-1.125-1.125H8.25zM6.75 12h.008v.008H6.75V12zm0 3h.008v.008H6.75V15zm0 3h.008v.008H6.75V18z"/></svg>
                                </div>
                                <div class="text-left overflow-hidden">
                                    <p class="text-xs font-bold text-slate-800 truncate group-hover:text-teal-950 transition">${d.title}</p>
                                    <p class="text-[10px] text-slate-400 truncate">${d.subtitle}</p>
                                </div>
                            </div>
                            <span class="px-2 py-0.5 rounded text-[10px] font-bold bg-teal-50 text-teal-700 border border-teal-200">${d.badge}</span>
                        </a>
                    `;
                });
                html += `</div>`;
            }

            // 4. Users & Members
            if (res.users && res.users.length > 0) {
                html += `
                    <div class="space-y-1">
                        <div class="text-[10px] font-extrabold uppercase tracking-wider text-slate-400 px-3 py-1 flex items-center justify-between">
                            <span>Members & Accounts</span>
                            <span>${res.users.length}</span>
                        </div>
                `;
                res.users.forEach(u => {
                    html += `
                        <a href="${u.url}" class="cmd-item flex items-center justify-between p-2.5 px-3.5 rounded-xl hover:bg-slate-100/80 border border-transparent transition group cursor-pointer">
                            <div class="flex items-center gap-3 max-w-[80%]">
                                <div class="h-8 w-8 rounded-lg bg-purple-50 text-purple-600 flex items-center justify-center group-hover:bg-purple-600 group-hover:text-white transition flex-shrink-0">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.75" d="M15.75 6a3.75 3.75 0 11-7.5 0 3.75 3.75 0 017.5 0zM4.501 20.118a7.5 7.5 0 0114.998 0A17.933 17.933 0 0112 21.75c-2.676 0-5.216-.584-7.499-1.632z"/></svg>
                                </div>
                                <div class="text-left overflow-hidden">
                                    <p class="text-xs font-bold text-slate-800 truncate group-hover:text-purple-950 transition">${u.title}</p>
                                    <p class="text-[10px] text-slate-400 truncate">${u.subtitle}</p>
                                </div>
                            </div>
                            <span class="px-2 py-0.5 rounded text-[10px] font-bold bg-purple-50 text-purple-700 border border-purple-200">${u.badge}</span>
                        </a>
                    `;
                });
                html += `</div>`;
            }

            container.innerHTML = html;
            if (countBadge) countBadge.innerText = `${data.total} Results Found`;

            const items = document.querySelectorAll('.cmd-item');
            if (items.length) {
                updateSelectedCommandItem(items);
            }
        }
    </script>

    <!-- Command Palette (⌘K) Spotlight Modal -->
    <div id="commandPaletteModal" class="fixed inset-0 bg-slate-900/60 backdrop-blur-md z-[99999] flex items-start justify-center pt-[10vh] px-4 hidden opacity-0 transition-opacity duration-200" onclick="closeCommandPaletteOutside(event)">
        <div id="commandPaletteContent" class="w-full max-w-2xl bg-white rounded-3xl shadow-2xl border border-slate-200/80 overflow-hidden flex flex-col max-h-[75vh] scale-95 transition-transform duration-200" onclick="event.stopPropagation()">
            
            <!-- Search Bar Header -->
            <div class="p-4 border-b border-slate-100 flex items-center gap-3 bg-slate-50/50">
                <div class="h-9 w-9 rounded-xl bg-emerald-50 text-emerald-600 flex items-center justify-center flex-shrink-0">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                    </svg>
                </div>
                <input type="text" id="commandPaletteInput" placeholder="Type a command or search properties, seekers, members..." autocomplete="off"
                       class="w-full bg-transparent text-sm font-semibold text-slate-900 placeholder-slate-400 focus:outline-none border-0 p-0">
                <div id="commandPaletteSpinner" class="hidden flex-shrink-0 text-emerald-600 animate-spin">
                    <svg class="h-4 w-4" viewBox="0 0 24 24" fill="none">
                        <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                        <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8v8H4z"></path>
                    </svg>
                </div>
                <button type="button" onclick="closeCommandPalette()" class="px-2 py-1 rounded-lg bg-slate-100 text-slate-400 hover:text-slate-600 text-[10px] font-bold border border-slate-200">
                    ESC
                </button>
            </div>

            <!-- Results Scrollable Area -->
            <div id="commandPaletteResults" class="p-3 overflow-y-auto flex-1 space-y-4">
                <!-- Dynamically populated via AJAX -->
            </div>

            <!-- Footer Hints -->
            <div class="p-3 px-5 border-t border-slate-100 bg-slate-50/80 flex items-center justify-between text-[11px] text-slate-400 font-medium">
                <div class="flex items-center gap-3">
                    <span class="flex items-center gap-1"><kbd class="px-1.5 py-0.5 rounded bg-white border border-slate-200 font-bold text-[10px]">↑</kbd> <kbd class="px-1.5 py-0.5 rounded bg-white border border-slate-200 font-bold text-[10px]">↓</kbd> Navigate</span>
                    <span class="flex items-center gap-1"><kbd class="px-1.5 py-0.5 rounded bg-white border border-slate-200 font-bold text-[10px]">↵</kbd> Select</span>
                    <span class="flex items-center gap-1"><kbd class="px-1.5 py-0.5 rounded bg-white border border-slate-200 font-bold text-[10px]">ESC</kbd> Close</span>
                </div>
                <div id="commandPaletteCount" class="text-emerald-700 font-semibold text-[10px]">
                    System Ready
                </div>
            </div>

        </div>
    </div>

    @if(Request::is('admin/users*'))
    <!-- Add/Edit User Centered Modal -->
    <div id="userDrawer" class="fixed inset-0 bg-slate-900/60 backdrop-blur-sm z-[9999] flex items-center justify-center hidden opacity-0 transition-opacity duration-300" onclick="closeUserDrawerOutside(event)">
        <div id="userDrawerContent" class="w-full max-w-xl bg-white border border-slate-200 rounded-2xl shadow-2xl scale-95 transition-transform duration-300 overflow-hidden flex flex-col max-h-[90vh]">
            <form action="/admin/users" method="POST" id="userForm" class="flex flex-col h-full m-0 overflow-hidden">
                @csrf
                
                <!-- Header (Sticky) -->
                <div class="flex items-center justify-between border-b border-slate-100 p-6 flex-shrink-0 bg-slate-50/50">
                    <div>
                        <span id="drawerTitle" class="text-sm font-extrabold text-[#0A2540] uppercase tracking-wider block">Create New Member</span>
                        <p class="text-[11px] text-slate-400 mt-0.5">Add a new verified account to the platform.</p>
                    </div>
                    <button type="button" onclick="closeUserDrawer()" class="text-slate-400 hover:text-slate-800 p-2 rounded-xl hover:bg-slate-100 transition">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M6 18L18 6M6 6l12 12" />
                        </svg>
                    </button>
                </div>

                <!-- Fields Container (Scrollable) -->
                <div class="p-6 space-y-4 overflow-y-auto flex-1">
                    <!-- Name -->
                    <div class="space-y-1.5">
                        <label class="block text-[11px] font-bold text-slate-600 uppercase tracking-wider">Full Name</label>
                        <input type="text" name="name" id="field_name" required placeholder="John Doe"
                               class="w-full px-4 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-slate-800 text-xs font-semibold focus:outline-none focus:border-emerald-500 focus:ring-2 focus:ring-emerald-500/20 transition">
                    </div>

                    <!-- Email -->
                    <div class="space-y-1.5">
                        <label class="block text-[11px] font-bold text-slate-600 uppercase tracking-wider">Email Address</label>
                        <input type="email" name="email" id="field_email" required placeholder="john@example.com"
                               class="w-full px-4 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-slate-800 text-xs font-semibold focus:outline-none focus:border-emerald-500 focus:ring-2 focus:ring-emerald-500/20 transition">
                    </div>

                    <!-- Phone -->
                    <div class="space-y-1.5">
                        <label class="block text-[11px] font-bold text-slate-600 uppercase tracking-wider">Phone Number</label>
                        <input type="text" name="phone" id="field_phone" placeholder="+91 98765 43210"
                               class="w-full px-4 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-slate-800 text-xs font-semibold focus:outline-none focus:border-emerald-500 focus:ring-2 focus:ring-emerald-500/20 transition">
                    </div>

                    <!-- Plan & Role Grid -->
                    <div class="grid grid-cols-2 gap-4">
                        <div class="space-y-1.5">
                            <label class="block text-[11px] font-bold text-slate-600 uppercase tracking-wider">Subscription Plan</label>
                            <select name="subscription_plan" id="field_subscription_plan" required
                                    class="w-full px-3 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-slate-800 text-xs font-semibold focus:outline-none focus:border-emerald-500 focus:ring-2 focus:ring-emerald-500/20 transition">
                                <option value="free">Free Starter</option>
                                <option value="standard">Standard Growth</option>
                                <option value="unlimited">Unlimited Pro</option>
                            </select>
                        </div>

                        <div class="space-y-1.5">
                            <label class="block text-[11px] font-bold text-slate-600 uppercase tracking-wider">Access Level</label>
                            <select name="is_admin" id="field_is_admin" required
                                    class="w-full px-3 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-slate-800 text-xs font-semibold focus:outline-none focus:border-emerald-500 focus:ring-2 focus:ring-emerald-500/20 transition">
                                <option value="0">Customer / Member</option>
                                <option value="1">Administrator</option>
                            </select>
                        </div>
                    </div>

                    <!-- Password Info Alert for Edit -->
                    <div id="passwordAlert" class="hidden p-3 bg-amber-50 text-amber-800 border border-amber-200 rounded-xl text-[11px] font-medium">
                        Leave blank if you do not wish to modify the existing password.
                    </div>

                    <!-- Password Fields -->
                    <div class="grid grid-cols-2 gap-4">
                        <div class="space-y-1.5">
                            <label id="passwordLabel" class="block text-[11px] font-bold text-slate-600 uppercase tracking-wider">Password</label>
                            <input type="password" name="password" id="field_password" placeholder="••••••••"
                                   class="w-full px-4 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-slate-800 text-xs font-semibold focus:outline-none focus:border-emerald-500 focus:ring-2 focus:ring-emerald-500/20 transition">
                        </div>

                        <div class="space-y-1.5">
                            <label class="block text-[11px] font-bold text-slate-600 uppercase tracking-wider">Confirm Password</label>
                            <input type="password" name="password_confirmation" id="field_password_confirmation" placeholder="••••••••"
                                   class="w-full px-4 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-slate-800 text-xs font-semibold focus:outline-none focus:border-emerald-500 focus:ring-2 focus:ring-emerald-500/20 transition">
                        </div>
                    </div>
                </div>

                <!-- Footer Actions (Sticky) -->
                <div class="border-t border-slate-100 p-4 px-6 flex justify-end gap-2.5 flex-shrink-0 bg-slate-50/50">
                    <button type="button" onclick="closeUserDrawer()" class="px-4 py-2 bg-slate-100 hover:bg-slate-200 text-slate-700 text-xs font-bold rounded-xl transition">
                        Cancel
                    </button>
                    <button type="submit" id="submitBtn" class="px-5 py-2 bg-emerald-600 hover:bg-emerald-700 text-white text-xs font-bold rounded-xl shadow-md shadow-emerald-600/20 transition">
                        Save Member
                    </button>
                </div>
            </form>
        </div>
    </div>
@endif
</body>
</html>
