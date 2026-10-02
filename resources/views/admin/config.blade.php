@extends('admin.layout')

@section('page_title', 'System Settings & Integrations')

@section('content')
<div class="space-y-6">

    <!-- Top Telemetry & Hero Banner -->
    <div class="flex flex-col lg:flex-row lg:items-center justify-between gap-4 pb-5 border-b border-slate-200/80">
        <div>
            <div class="flex items-center gap-2 mb-1">
                <span class="px-2.5 py-0.5 rounded-full text-[10px] font-extrabold bg-emerald-50 text-emerald-700 border border-emerald-200/80 uppercase tracking-wider flex items-center gap-1.5">
                    <span class="h-1.5 w-1.5 rounded-full bg-emerald-500 animate-ping"></span>
                    Live Configuration Engine
                </span>
                <span class="text-slate-300">•</span>
                <span class="text-xs text-slate-400 font-mono">Environment: {{ app()->environment() }}</span>
            </div>
            <h1 class="text-xl font-black text-slate-900 tracking-tight flex items-center gap-2.5">
                <span class="p-2 rounded-xl bg-gradient-to-tr from-emerald-500 to-teal-600 text-white shadow-md shadow-emerald-500/20">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37.996.608 2.296.07 2.572-1.065z" />
                        <path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                    </svg>
                </span>
                System Settings & Integrations
            </h1>
            <p class="text-xs text-slate-500 mt-1">Manage global platform attributes, SMTP email delivery options, and Firebase API service configurations.</p>
        </div>

        <!-- Quick Status Chips -->
        <div class="flex flex-wrap items-center gap-2">
            <div class="px-3 py-1.5 bg-white border border-slate-200/80 rounded-xl shadow-2xs text-xs font-semibold text-slate-700 flex items-center gap-2">
                <span class="h-2 w-2 rounded-full bg-emerald-500"></span>
                <span>Database Synced</span>
            </div>
            <div class="px-3 py-1.5 bg-white border border-slate-200/80 rounded-xl shadow-2xs text-xs font-semibold text-slate-700 flex items-center gap-2">
                <span class="h-2 w-2 rounded-full bg-blue-500"></span>
                <span>5 Modules Active</span>
            </div>
        </div>
    </div>

    @if(session('success'))
        <div class="p-4 bg-emerald-50 border border-emerald-200 text-emerald-800 rounded-2xl text-xs flex items-center gap-3 shadow-xs animate-fadeIn">
            <div class="h-7 w-7 rounded-lg bg-emerald-500 text-white flex items-center justify-center shrink-0">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2.5"><path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7"/></svg>
            </div>
            <div>
                <strong class="font-bold">Settings Saved!</strong>
                <span class="ml-1 font-medium">{{ session('success') }}</span>
            </div>
        </div>
    @endif

    <!-- Main Settings Hub Card -->
    <div class="bg-white border border-slate-200/80 rounded-3xl shadow-xs overflow-hidden flex flex-col lg:flex-row min-h-[620px]">
        
        <!-- Left Navigation Sidebar -->
        <div class="w-full lg:w-72 bg-slate-50/70 border-b lg:border-b-0 lg:border-r border-slate-200/80 p-5 flex flex-col justify-between shrink-0 space-y-6">
            <div class="space-y-2">
                <div class="text-[10px] text-slate-400 font-extrabold uppercase tracking-wider px-3 mb-3">Settings Categories</div>
                
                <!-- Tab: General Settings -->
                <button type="button" onclick="switchTab('general')" id="tab-btn-general" 
                        class="tab-btn w-full flex items-center justify-between p-3 rounded-2xl text-xs font-bold transition text-left bg-white text-[#0A2540] border border-slate-200 shadow-xs">
                    <div class="flex items-center gap-3">
                        <div class="tab-icon-box h-9 w-9 rounded-xl bg-emerald-50 text-emerald-600 flex items-center justify-center shrink-0 transition">
                            <svg class="w-4.5 h-4.5" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="1.75">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M12 21a9.004 9.004 0 008.716-6.747M12 21a9.004 9.004 0 01-8.716-6.747M12 21c2.485 0 4.5-4.03 4.5-9S14.485 3 12 3m0 18c-2.485 0-4.5-4.03-4.5-9S9.515 3 12 3m0 0a8.997 8.997 0 017.843 4.582M12 3a8.997 8.997 0 00-7.843 4.582m15.686 0A11.953 11.953 0 0112 10.5c-2.998 0-5.74-1.1-7.843-2.918m15.686 0A8.959 8.959 0 0121 12c0 .778-.099 1.533-.284 2.253m0 0A17.919 17.919 0 0112 16.5c-3.162 0-6.133-.815-8.716-2.247m0 0A9.015 9.015 0 013 12c0-1.605.42-3.113 1.157-4.418" />
                            </svg>
                        </div>
                        <div>
                            <span class="block leading-tight">General & SEO</span>
                            <span class="text-[10px] text-slate-400 font-normal">Branding, Maps, SEO</span>
                        </div>
                    </div>
                    <span class="h-2 w-2 rounded-full bg-emerald-500"></span>
                </button>

                <!-- Tab: SMTP Setup -->
                <button type="button" onclick="switchTab('smtp')" id="tab-btn-smtp" 
                        class="tab-btn w-full flex items-center justify-between p-3 rounded-2xl text-xs font-semibold transition text-left text-slate-600 hover:bg-white hover:text-slate-900 border border-transparent">
                    <div class="flex items-center gap-3">
                        <div class="tab-icon-box h-9 w-9 rounded-xl bg-slate-100 text-slate-500 flex items-center justify-center shrink-0 transition">
                            <svg class="w-4.5 h-4.5" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="1.75">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M21.75 6.75v10.5a2.25 2.25 0 01-2.25 2.25h-15a2.25 2.25 0 01-2.25-2.25V6.75m19.5 0A2.25 2.25 0 0019.5 4.5h-15a2.25 2.25 0 00-2.25 2.25m19.5 0v.243a2.25 2.25 0 01-1.07 1.916l-7.5 4.615a2.25 2.25 0 01-2.36 0L3.32 8.91a2.25 2.25 0 01-1.07-1.916V6.75" />
                            </svg>
                        </div>
                        <div>
                            <span class="block leading-tight font-bold">SMTP Email Setup</span>
                            <span class="text-[10px] text-slate-400 font-normal">Outbound notifications</span>
                        </div>
                    </div>
                    <span class="h-2 w-2 rounded-full bg-slate-300"></span>
                </button>

                <!-- Tab: Firebase Services -->
                <button type="button" onclick="switchTab('firebase')" id="tab-btn-firebase" 
                        class="tab-btn w-full flex items-center justify-between p-3 rounded-2xl text-xs font-semibold transition text-left text-slate-600 hover:bg-white hover:text-slate-900 border border-transparent">
                    <div class="flex items-center gap-3">
                        <div class="tab-icon-box h-9 w-9 rounded-xl bg-slate-100 text-slate-500 flex items-center justify-center shrink-0 transition">
                            <svg class="w-4.5 h-4.5" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="1.75">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M15.362 5.214A8.252 8.252 0 0112 21 8.25 8.25 0 016.038 7.048 8.287 8.287 0 009 9.6a8.983 8.983 0 013.361-6.867 8.21 8.21 0 003 2.48z" />
                                <path stroke-linecap="round" stroke-linejoin="round" d="M12 18a3.75 3.75 0 00.495-7.467 5.99 5.99 0 00-1.925 3.546 5.974 5.974 0 01-2.133-1A3.75 3.75 0 0012 18z" />
                            </svg>
                        </div>
                        <div>
                            <span class="block leading-tight font-bold">Firebase Cloud</span>
                            <span class="text-[10px] text-slate-400 font-normal">Auth, FCM, Storage</span>
                        </div>
                    </div>
                    <span class="h-2 w-2 rounded-full bg-slate-300"></span>
                </button>

                <!-- Tab: Listing Settings -->
                <button type="button" onclick="switchTab('listing')" id="tab-btn-listing" 
                        class="tab-btn w-full flex items-center justify-between p-3 rounded-2xl text-xs font-semibold transition text-left text-slate-600 hover:bg-white hover:text-slate-900 border border-transparent">
                    <div class="flex items-center gap-3">
                        <div class="tab-icon-box h-9 w-9 rounded-xl bg-slate-100 text-slate-500 flex items-center justify-center shrink-0 transition">
                            <svg class="w-4.5 h-4.5" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="1.75">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M8.25 21v-4.875c0-.621.504-1.125 1.125-1.125h2.25c.621 0 1.125.504 1.125 1.125V21m0 0h4.5V3.545M12.75 21h7.5V10.75M2.25 21h1.5m18 0h-18M2.25 9l4.5-1.636M18.75 3l-1.5.545m0 6.205l3 1.09" />
                            </svg>
                        </div>
                        <div>
                            <span class="block leading-tight font-bold">Listing Rules</span>
                            <span class="text-[10px] text-slate-400 font-normal">Defaults & constraints</span>
                        </div>
                    </div>
                    <span class="h-2 w-2 rounded-full bg-slate-300"></span>
                </button>

                <!-- Tab: App Updates -->
                <button type="button" onclick="switchTab('app')" id="tab-btn-app" 
                        class="tab-btn w-full flex items-center justify-between p-3 rounded-2xl text-xs font-semibold transition text-left text-slate-600 hover:bg-white hover:text-slate-900 border border-transparent">
                    <div class="flex items-center gap-3">
                        <div class="tab-icon-box h-9 w-9 rounded-xl bg-slate-100 text-slate-500 flex items-center justify-center shrink-0 transition">
                            <svg class="w-4.5 h-4.5" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="1.75">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M10.5 1.5H8.25A2.25 2.25 0 006 3.75v16.5a2.25 2.25 0 002.25 2.25h7.5A2.25 2.25 0 0018 20.25V3.75a2.25 2.25 0 00-2.25-2.25H13.5m-3 0V3h3V1.5m-3 0h3m-3 18.75h3" />
                            </svg>
                        </div>
                        <div>
                            <span class="block leading-tight font-bold">Mobile App Updates</span>
                            <span class="text-[10px] text-slate-400 font-normal">Version release flags</span>
                        </div>
                    </div>
                    <span class="h-2 w-2 rounded-full bg-slate-300"></span>
                </button>
            </div>

            <!-- Pro Tip Box in Sidebar -->
            <div class="bg-emerald-50/70 border border-emerald-200/80 rounded-2xl p-4 text-xs">
                <div class="flex items-center gap-2 text-emerald-800 font-bold mb-1">
                    <svg class="w-4 h-4 text-emerald-600 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M13 10V3L4 14h7v7l9-11h-7z"/>
                    </svg>
                    <span>Instant Hot-Reload</span>
                </div>
                <p class="text-[11px] text-emerald-700 leading-relaxed">
                    Values saved here update the mobile app JSON payload & web frontend immediately without restarting servers.
                </p>
            </div>
        </div>

        <!-- Right Content & Form Area -->
        <div class="flex-1 p-6 lg:p-10 bg-white overflow-y-auto">
            <form action="/admin/config" method="POST" id="configMainForm" class="m-0 space-y-8">
                @csrf

                <!-- ════════════ TAB 1: GENERAL SETTINGS ════════════ -->
                <div id="tab-content-general" class="tab-pane space-y-6">
                    <div>
                        <div class="flex items-center gap-2">
                            <h2 class="text-base font-black text-slate-900 font-heading">General Platform Settings</h2>
                            <span class="px-2 py-0.5 rounded-md bg-slate-100 text-slate-600 text-[10px] font-extrabold uppercase">Branding & Maps</span>
                        </div>
                        <p class="text-xs text-slate-400 mt-1">Configure global application branding name, public info, and Google Maps API parameters.</p>
                    </div>

                    @if(isset($groups['general']))
                        <div class="grid grid-cols-1 gap-6 max-w-2xl">
                            @foreach($groups['general'] as $config)
                                <div class="bg-slate-50/70 p-5 rounded-2xl border border-slate-200/70 space-y-2 hover:border-slate-300 transition">
                                    <div class="flex items-center justify-between">
                                        <label class="block text-xs font-bold text-slate-800">{{ $config->label }}</label>
                                        <code class="text-[10px] text-slate-400 font-mono bg-white px-2 py-0.5 rounded border border-slate-200">{{ $config->key }}</code>
                                    </div>

                                    @if($config->type === 'textarea')
                                        <textarea name="{{ $config->key }}" rows="3" 
                                                  class="w-full px-4 py-3 bg-white border border-slate-200 rounded-xl text-slate-900 text-xs font-medium focus:outline-none focus:border-emerald-500 focus:ring-2 focus:ring-emerald-500/10 transition shadow-2xs leading-relaxed">{{ $config->value }}</textarea>
                                    @else
                                        <div class="relative">
                                            <input type="text" name="{{ $config->key }}" value="{{ $config->value }}" 
                                                   class="w-full pl-4 pr-10 py-2.5 bg-white border border-slate-200 rounded-xl text-slate-900 text-xs font-semibold focus:outline-none focus:border-emerald-500 focus:ring-2 focus:ring-emerald-500/10 transition shadow-2xs">
                                            @if(str_contains($config->key, 'key'))
                                                <span class="absolute inset-y-0 right-0 pr-3 flex items-center pointer-events-none text-slate-400">
                                                    <svg class="w-4 h-4 text-emerald-600" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="1.75">
                                                        <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 5.25a3 3 0 013 3m3 0a6 6 0 01-7.029 5.912c-.563-.097-1.159.026-1.563.43L10.5 17.25H8.25v2.25H6v2.25H2.25v-2.818c0-.597.237-1.17.659-1.591l6.499-6.499c.404-.404.527-1 .43-1.563A6 6 0 1121.75 8.25z" />
                                                    </svg>
                                                </span>
                                            @endif
                                        </div>
                                    @endif
                                    
                                    <p class="text-[11px] text-slate-500 leading-normal">{{ $config->description }}</p>
                                </div>
                            @endforeach
                        </div>
                    @endif
                </div>

                <!-- ════════════ TAB 2: SMTP SETUP ════════════ -->
                <div id="tab-content-smtp" class="tab-pane hidden space-y-6">
                    <div class="flex items-center justify-between">
                        <div>
                            <div class="flex items-center gap-2">
                                <h2 class="text-base font-black text-slate-900 font-heading">SMTP Outbound Mail Server</h2>
                                <span class="px-2 py-0.5 rounded-md bg-blue-50 text-blue-700 border border-blue-200 text-[10px] font-extrabold uppercase">Email Relay</span>
                            </div>
                            <p class="text-xs text-slate-400 mt-1">Setup outbound mail server parameters for user notifications, bookings, and password resets.</p>
                        </div>
                    </div>

                    @if(isset($groups['smtp']))
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-5 max-w-3xl">
                            @foreach($groups['smtp'] as $config)
                                <div class="bg-slate-50/70 p-4 rounded-2xl border border-slate-200/70 space-y-1.5 {{ in_array($config->key, ['mail_from_address', 'mail_from_name']) ? 'col-span-1 md:col-span-2' : '' }}">
                                    <div class="flex items-center justify-between">
                                        <label class="block text-xs font-bold text-slate-800">{{ $config->label }}</label>
                                        <span class="text-[10px] font-mono text-slate-400">{{ $config->key }}</span>
                                    </div>
                                    
                                    @if($config->type === 'password')
                                        <div class="relative">
                                            <input type="password" name="{{ $config->key }}" value="{{ $config->value }}" id="input-{{ $config->key }}"
                                                   class="w-full pl-3.5 pr-10 py-2.5 bg-white border border-slate-200 rounded-xl text-slate-900 text-xs font-semibold focus:outline-none focus:border-emerald-500 focus:ring-2 focus:ring-emerald-500/10 transition shadow-2xs">
                                            <button type="button" onclick="togglePasswordVisibility('input-{{ $config->key }}')" class="absolute inset-y-0 right-0 pr-3 flex items-center text-slate-400 hover:text-slate-700">
                                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="1.75">
                                                    <path stroke-linecap="round" stroke-linejoin="round" d="M2.036 12.322a1.012 1.012 0 010-.639C3.423 7.51 7.36 4.5 12 4.5c4.638 0 8.573 3.007 9.963 7.178.07.207.07.431 0 .639C20.577 16.49 16.64 19.5 12 19.5c-4.638 0-8.573-3.007-9.963-7.178z" />
                                                    <path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                                </svg>
                                            </button>
                                        </div>
                                    @else
                                        <input type="text" name="{{ $config->key }}" value="{{ $config->value }}" 
                                               class="w-full px-3.5 py-2.5 bg-white border border-slate-200 rounded-xl text-slate-900 text-xs font-semibold focus:outline-none focus:border-emerald-500 focus:ring-2 focus:ring-emerald-500/10 transition shadow-2xs">
                                    @endif
                                    <p class="text-[10px] text-slate-400">{{ $config->description }}</p>
                                </div>
                            @endforeach
                        </div>
                    @else
                        <div class="p-8 text-center bg-slate-50 rounded-2xl border border-slate-200 text-slate-400">
                            <p class="text-xs font-semibold">No SMTP custom overrides registered. Using standard <code class="bg-white px-2 py-0.5 rounded border font-mono">.env</code> configuration.</p>
                        </div>
                    @endif
                </div>

                <!-- ════════════ TAB 3: FIREBASE SERVICES ════════════ -->
                <div id="tab-content-firebase" class="tab-pane hidden space-y-6">
                    <div>
                        <div class="flex items-center gap-2">
                            <h2 class="text-base font-black text-slate-900 font-heading">Firebase Cloud & Mobile Services</h2>
                            <span class="px-2 py-0.5 rounded-md bg-amber-50 text-amber-700 border border-amber-200 text-[10px] font-extrabold uppercase">FCM Push & Auth</span>
                        </div>
                        <p class="text-xs text-slate-400 mt-1">Link mobile authentication, push notifications token dispatch, and cloud storage backends.</p>
                    </div>

                    @if(isset($groups['firebase']))
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-5 max-w-3xl">
                            @foreach($groups['firebase'] as $config)
                                <div class="bg-slate-50/70 p-4 rounded-2xl border border-slate-200/70 space-y-1.5 {{ $config->key === 'firebase_api_key' || $config->key === 'firebase_app_id' ? 'col-span-1 md:col-span-2' : '' }}">
                                    <div class="flex items-center justify-between">
                                        <label class="block text-xs font-bold text-slate-800">{{ $config->label }}</label>
                                        <span class="text-[10px] font-mono text-slate-400">{{ $config->key }}</span>
                                    </div>
                                    
                                    @if($config->type === 'password')
                                        <div class="relative">
                                            <input type="password" name="{{ $config->key }}" value="{{ $config->value }}" id="input-{{ $config->key }}"
                                                   class="w-full pl-3.5 pr-10 py-2.5 bg-white border border-slate-200 rounded-xl text-slate-900 text-xs font-semibold focus:outline-none focus:border-emerald-500 focus:ring-2 focus:ring-emerald-500/10 transition shadow-2xs">
                                            <button type="button" onclick="togglePasswordVisibility('input-{{ $config->key }}')" class="absolute inset-y-0 right-0 pr-3 flex items-center text-slate-400 hover:text-slate-700">
                                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="1.75">
                                                    <path stroke-linecap="round" stroke-linejoin="round" d="M2.036 12.322a1.012 1.012 0 010-.639C3.423 7.51 7.36 4.5 12 4.5c4.638 0 8.573 3.007 9.963 7.178.07.207.07.431 0 .639C20.577 16.49 16.64 19.5 12 19.5c-4.638 0-8.573-3.007-9.963-7.178z" />
                                                    <path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                                </svg>
                                            </button>
                                        </div>
                                    @else
                                        <input type="text" name="{{ $config->key }}" value="{{ $config->value }}" 
                                               class="w-full px-3.5 py-2.5 bg-white border border-slate-200 rounded-xl text-slate-900 text-xs font-semibold focus:outline-none focus:border-emerald-500 focus:ring-2 focus:ring-emerald-500/10 transition shadow-2xs">
                                    @endif
                                    <p class="text-[10px] text-slate-400">{{ $config->description }}</p>
                                </div>
                            @endforeach
                        </div>
                    @else
                        <div class="p-8 text-center bg-slate-50 rounded-2xl border border-slate-200 text-slate-400">
                            <p class="text-xs font-semibold">Firebase API keys configured in environment files.</p>
                        </div>
                    @endif
                </div>

                <!-- ════════════ TAB 4: LISTING SETTINGS ════════════ -->
                <div id="tab-content-listing" class="tab-pane hidden space-y-6">
                    <div class="flex items-center justify-between">
                        <div>
                            <div class="flex items-center gap-2">
                                <h2 class="text-base font-black text-slate-900 font-heading">Listing Submission Defaults & Policies</h2>
                                <span class="px-2 py-0.5 rounded-md bg-purple-50 text-purple-700 border border-purple-200 text-[10px] font-extrabold uppercase">Moderation Rules</span>
                            </div>
                            <p class="text-xs text-slate-400 mt-1">Control default auto-approval policies, image quotas, and listing categories fallback.</p>
                        </div>
                        <a href="/admin/attributes" class="px-3.5 py-1.5 bg-slate-100 hover:bg-slate-200 text-slate-700 rounded-xl text-xs font-bold transition flex items-center gap-1.5">
                            <svg class="w-4 h-4 text-emerald-600" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="1.75">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10" />
                            </svg>
                            <span>Manage Taxonomy DB</span>
                        </a>
                    </div>

                    @if(isset($groups['listing']))
                        <div class="space-y-4 max-w-2xl">
                            @foreach($groups['listing'] as $config)
                                <div class="bg-slate-50/70 p-5 rounded-2xl border border-slate-200/70 space-y-2">
                                    <div class="flex items-center justify-between">
                                        <label class="block text-xs font-bold text-slate-800">{{ $config->label }}</label>
                                        <code class="text-[10px] text-slate-400 font-mono bg-white px-2 py-0.5 rounded border border-slate-200">{{ $config->key }}</code>
                                    </div>
                                    <input type="text" name="{{ $config->key }}" value="{{ $config->value }}" 
                                           class="w-full px-4 py-2.5 bg-white border border-slate-200 rounded-xl text-slate-900 text-xs font-semibold focus:outline-none focus:border-emerald-500 focus:ring-2 focus:ring-emerald-500/10 transition shadow-2xs">
                                    <p class="text-[11px] text-slate-400">{{ $config->description }}</p>
                                </div>
                            @endforeach
                        </div>
                    @endif
                </div>

                <!-- ════════════ TAB 5: APP UPDATES ════════════ -->
                <div id="tab-content-app" class="tab-pane hidden space-y-6">
                    <div>
                        <div class="flex items-center gap-2">
                            <h2 class="text-base font-black text-slate-900 font-heading">Mobile App Version & Release Engine</h2>
                            <span class="px-2 py-0.5 rounded-md bg-emerald-50 text-emerald-700 border border-emerald-200 text-[10px] font-extrabold uppercase">Flutter App Sync</span>
                        </div>
                        <p class="text-xs text-slate-400 mt-1">Manage minimum required app versions and configure forced or optional update prompts across Android and iOS users.</p>
                    </div>

                    @if(isset($groups['app']))
                        <div class="space-y-4 max-w-2xl">
                            @foreach($groups['app'] as $config)
                                <div class="bg-slate-50/70 p-5 rounded-2xl border border-slate-200/70 space-y-2">
                                    <div class="flex items-center justify-between">
                                        <label class="block text-xs font-bold text-slate-800">{{ $config->label }}</label>
                                        <code class="text-[10px] text-slate-400 font-mono bg-white px-2 py-0.5 rounded border border-slate-200">{{ $config->key }}</code>
                                    </div>

                                    @if($config->type === 'boolean')
                                        <div class="grid grid-cols-2 gap-3">
                                            <label class="flex items-center gap-3 p-3.5 bg-white border border-slate-200 rounded-xl cursor-pointer hover:border-emerald-500 transition">
                                                <input type="radio" name="{{ $config->key }}" value="0" {{ $config->value == '0' ? 'checked' : '' }} class="text-emerald-600 focus:ring-emerald-500 h-4 w-4">
                                                <div>
                                                    <span class="block text-xs font-bold text-slate-900">Optional Update</span>
                                                    <span class="text-[10px] text-slate-400">Users can dismiss prompt</span>
                                                </div>
                                            </label>
                                            <label class="flex items-center gap-3 p-3.5 bg-white border border-slate-200 rounded-xl cursor-pointer hover:border-rose-500 transition">
                                                <input type="radio" name="{{ $config->key }}" value="1" {{ $config->value == '1' ? 'checked' : '' }} class="text-rose-600 focus:ring-rose-500 h-4 w-4">
                                                <div>
                                                    <span class="block text-xs font-bold text-rose-700">Force App Update</span>
                                                    <span class="text-[10px] text-slate-400">Blocks app usage until updated</span>
                                                </div>
                                            </label>
                                        </div>
                                    @else
                                        <div class="relative">
                                            <input type="text" name="{{ $config->key }}" value="{{ $config->value }}" 
                                                   class="w-full px-4 py-2.5 bg-white border border-slate-200 rounded-xl text-slate-900 text-xs font-semibold focus:outline-none focus:border-emerald-500 focus:ring-2 focus:ring-emerald-500/10 transition shadow-2xs">
                                        </div>
                                    @endif
                                    
                                    <p class="text-[11px] text-slate-500">{{ $config->description }}</p>
                                </div>
                            @endforeach
                        </div>
                    @endif
                </div>

                <!-- ════════════ DOCKED LUXURY SAVE BAR ════════════ -->
                <div class="pt-6 border-t border-slate-200/80 flex items-center justify-between gap-4 max-w-3xl">
                    <div class="text-[11px] text-slate-400 flex items-center gap-1.5 font-medium">
                        <kbd class="px-1.5 py-0.5 bg-slate-100 border border-slate-300 rounded font-mono text-[10px] text-slate-600">⌘S</kbd>
                        <span>or Ctrl+S to save immediately</span>
                    </div>

                    <div class="flex items-center gap-3">
                        <button type="reset" class="px-4 py-2 bg-slate-100 hover:bg-slate-200 text-slate-700 text-xs font-bold rounded-xl transition">
                            Discard
                        </button>
                        <button type="submit" class="px-6 py-2.5 bg-gradient-to-r from-emerald-600 to-teal-600 hover:from-emerald-500 hover:to-teal-500 text-white text-xs font-bold rounded-xl shadow-md shadow-emerald-600/20 transition flex items-center gap-2">
                            <svg class="w-4 h-4 text-emerald-200" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M4.5 12.75l6 6 9-13.5"/>
                            </svg>
                            <span>Save Configurations</span>
                        </button>
                    </div>
                </div>
            </form>
        </div>

    </div>
</div>

<script>
    function switchTab(tabId) {
        // Hide all tab panes
        document.querySelectorAll('.tab-pane').forEach(pane => pane.classList.add('hidden'));

        // Reset all tab button styles
        document.querySelectorAll('.tab-btn').forEach(btn => {
            btn.classList.remove('bg-white', 'text-[#0A2540]', 'border-slate-200', 'shadow-xs', 'font-bold');
            btn.classList.add('text-slate-600', 'hover:bg-white', 'hover:text-slate-900', 'border-transparent', 'font-semibold');
            
            const iconBox = btn.querySelector('.tab-icon-box');
            if (iconBox) {
                iconBox.classList.remove('bg-emerald-50', 'text-emerald-600');
                iconBox.classList.add('bg-slate-100', 'text-slate-500');
            }

            const indicator = btn.querySelector('span:last-child');
            if (indicator && indicator.classList.contains('rounded-full')) {
                indicator.classList.remove('bg-emerald-500');
                indicator.classList.add('bg-slate-300');
            }
        });

        // Show active tab pane
        const activePane = document.getElementById('tab-content-' + tabId);
        if (activePane) activePane.classList.remove('hidden');

        // Highlight active tab button
        const activeBtn = document.getElementById('tab-btn-' + tabId);
        if (activeBtn) {
            activeBtn.classList.remove('text-slate-600', 'hover:bg-white', 'hover:text-slate-900', 'border-transparent', 'font-semibold');
            activeBtn.classList.add('bg-white', 'text-[#0A2540]', 'border-slate-200', 'shadow-xs', 'font-bold');

            const iconBox = activeBtn.querySelector('.tab-icon-box');
            if (iconBox) {
                iconBox.classList.remove('bg-slate-100', 'text-slate-500');
                iconBox.classList.add('bg-emerald-50', 'text-emerald-600');
            }

            const indicator = activeBtn.querySelector('span:last-child');
            if (indicator && indicator.classList.contains('rounded-full')) {
                indicator.classList.remove('bg-slate-300');
                indicator.classList.add('bg-emerald-500');
            }
        }
    }

    function togglePasswordVisibility(inputId) {
        const input = document.getElementById(inputId);
        if (!input) return;
        input.type = input.type === "password" ? "text" : "password";
    }

    // Keyboard shortcut ⌘S / Ctrl+S to save
    document.addEventListener('keydown', function(e) {
        if ((e.metaKey || e.ctrlKey) && e.key === 's') {
            e.preventDefault();
            document.getElementById('configMainForm').submit();
        }
    });
</script>
@endsection
