@extends('admin.layout')

@section('page_title', 'Push Notifications & Broadcasts')

@section('content')
<div class="space-y-6">

    <!-- Header Area -->
    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 pb-5 border-b border-slate-200/80">
        <div>
            <h1 class="text-xl font-bold text-slate-900 tracking-tight flex items-center gap-2.5">
                <span class="p-2 rounded-xl bg-emerald-50 text-emerald-600 border border-emerald-100/60">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9" />
                    </svg>
                </span>
                Push Notifications & Broadcast Engine
            </h1>
            <p class="text-xs text-slate-500 mt-1">Compose and dispatch Firebase Cloud Messaging (FCM) push alerts and in-app system announcements to mobile users.</p>
        </div>
        
        <div class="flex items-center gap-3">
            <div class="px-3 py-1.5 bg-emerald-50 text-emerald-800 rounded-xl border border-emerald-200/70 text-xs font-semibold flex items-center gap-2">
                <span class="h-2 w-2 rounded-full bg-emerald-500 animate-pulse"></span>
                <span>FCM Device Reach: <strong>{{ number_format($registeredDevicesCount) }} Active</strong></span>
            </div>
        </div>
    </div>

    @if(session('success'))
        <div class="p-4 bg-emerald-50 border border-emerald-200 text-emerald-800 rounded-xl text-xs flex items-center gap-3 shadow-xs">
            <svg class="w-5 h-5 text-emerald-600 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
            </svg>
            <span class="font-medium">{{ session('success') }}</span>
        </div>
    @endif

    @if ($errors->any())
        <div class="p-4 bg-rose-50 border border-rose-200 text-rose-800 rounded-xl text-xs space-y-1">
            <div class="font-bold flex items-center gap-1.5">
                <svg class="w-4 h-4 text-rose-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                <span>Please fix the following validation errors:</span>
            </div>
            <ul class="list-disc pl-5">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <!-- 4 Key Telemetry Metrics -->
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4">
        
        <!-- Total Campaigns -->
        <div class="bg-white rounded-2xl p-5 border border-slate-200/80 shadow-xs">
            <div class="flex items-center justify-between mb-2">
                <span class="text-[11px] font-semibold text-slate-500 uppercase tracking-wider">Total Broadcasts</span>
                <div class="h-9 w-9 rounded-xl bg-slate-100 text-slate-600 flex items-center justify-center">
                    <svg class="w-4.5 h-4.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.75" d="M11 5.882V19.24a1.76 1.76 0 01-3.417.592l-2.147-6.15M18 13a3 3 0 100-6M5.436 13.683A4.001 4.001 0 017 6h1.832c4.1 0 7.625-1.234 9.168-3v14c-1.543-1.766-5.067-3-9.168-3H7a3.988 3.988 0 01-1.564-.317z" />
                    </svg>
                </div>
            </div>
            <div class="text-2xl font-bold text-slate-900 tracking-tight font-mono">{{ number_format($totalBroadcasts) }}</div>
            <div class="text-[11px] text-slate-400 mt-0.5">Campaigns dispatched</div>
        </div>

        <!-- In-App Notifications -->
        <div class="bg-white rounded-2xl p-5 border border-slate-200/80 shadow-xs">
            <div class="flex items-center justify-between mb-2">
                <span class="text-[11px] font-semibold text-slate-500 uppercase tracking-wider">In-App Delivered</span>
                <div class="h-9 w-9 rounded-xl bg-blue-50 text-blue-600 flex items-center justify-center">
                    <svg class="w-4.5 h-4.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.75" d="M8 10h.01M12 10h.01M16 10h.01M9 16H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-5l-5 5v-5z" />
                    </svg>
                </div>
            </div>
            <div class="text-2xl font-bold text-slate-900 tracking-tight font-mono">{{ number_format($totalInAppDelivered) }}</div>
            <div class="text-[11px] text-slate-400 mt-0.5">Total in-app inbox logs</div>
        </div>

        <!-- FCM Pushes Sent -->
        <div class="bg-white rounded-2xl p-5 border border-slate-200/80 shadow-xs">
            <div class="flex items-center justify-between mb-2">
                <span class="text-[11px] font-semibold text-slate-500 uppercase tracking-wider">FCM Pushes Sent</span>
                <div class="h-9 w-9 rounded-xl bg-emerald-50 text-emerald-600 flex items-center justify-center">
                    <svg class="w-4.5 h-4.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.75" d="M13 10V3L4 14h7v7l9-11h-7z" />
                    </svg>
                </div>
            </div>
            <div class="text-2xl font-bold text-emerald-700 tracking-tight font-mono">{{ number_format($totalFcmPushesSent) }}</div>
            <div class="text-[11px] text-emerald-600 font-medium mt-0.5">Delivered to mobile devices</div>
        </div>

        <!-- Active Device Reach -->
        <div class="bg-white rounded-2xl p-5 border border-slate-200/80 shadow-xs">
            <div class="flex items-center justify-between mb-2">
                <span class="text-[11px] font-semibold text-slate-500 uppercase tracking-wider">Device Coverage</span>
                <div class="h-9 w-9 rounded-xl bg-purple-50 text-purple-600 flex items-center justify-center">
                    <svg class="w-4.5 h-4.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.75" d="M12 18h.01M8 21h8a2 2 0 002-2V5a2 2 0 00-2-2H8a2 2 0 00-2 2v14a2 2 0 002 2z" />
                    </svg>
                </div>
            </div>
            @php
                $coveragePct = $totalUsersCount > 0 ? round(($registeredDevicesCount / $totalUsersCount) * 100, 1) : 0;
            @endphp
            <div class="text-2xl font-bold text-slate-900 tracking-tight font-mono">{{ $coveragePct }}%</div>
            <div class="text-[11px] text-slate-400 mt-0.5">{{ number_format($registeredDevicesCount) }} of {{ number_format($totalUsersCount) }} users reachable</div>
        </div>
    </div>

    <!-- Main Workspace: Compose Studio (Left) + Interactive Device Preview (Right) -->
    <div class="grid grid-cols-1 lg:grid-cols-12 gap-6">

        <!-- Compose Form Studio (7 Cols) -->
        <div class="lg:col-span-7 bg-white rounded-2xl border border-slate-200/80 shadow-xs p-6 md:p-7 space-y-6">
            <div class="flex items-center justify-between border-b border-slate-100 pb-4">
                <div>
                    <h2 class="text-sm font-bold text-slate-900">Compose New Broadcast</h2>
                    <p class="text-xs text-slate-500 mt-0.5">Select audience segmentation, notification urgency, and deep link destination.</p>
                </div>
                <div class="flex items-center gap-1.5">
                    <span class="px-2 py-0.5 bg-slate-100 text-slate-600 text-[10px] font-semibold rounded-md uppercase tracking-wider">Live Composer</span>
                </div>
            </div>

            <!-- Quick Template Presets -->
            <div class="space-y-1.5">
                <label class="block text-[11px] font-semibold text-slate-700">Quick Fill Template Presets</label>
                <div class="flex flex-wrap gap-2">
                    <button type="button" onclick="applyTemplate('feature')" class="px-2.5 py-1 bg-slate-50 hover:bg-emerald-50 hover:text-emerald-700 hover:border-emerald-200 text-slate-600 text-xs font-medium rounded-lg border border-slate-200 transition">
                        ✨ New Feature
                    </button>
                    <button type="button" onclick="applyTemplate('promo')" class="px-2.5 py-1 bg-slate-50 hover:bg-emerald-50 hover:text-emerald-700 hover:border-emerald-200 text-slate-600 text-xs font-medium rounded-lg border border-slate-200 transition">
                        🏷️ Discount Promo
                    </button>
                    <button type="button" onclick="applyTemplate('maintenance')" class="px-2.5 py-1 bg-slate-50 hover:bg-emerald-50 hover:text-emerald-700 hover:border-emerald-200 text-slate-600 text-xs font-medium rounded-lg border border-slate-200 transition">
                        ⚙️ Maintenance Notice
                    </button>
                    <button type="button" onclick="applyTemplate('demand')" class="px-2.5 py-1 bg-slate-50 hover:bg-emerald-50 hover:text-emerald-700 hover:border-emerald-200 text-slate-600 text-xs font-medium rounded-lg border border-slate-200 transition">
                        🎯 New Demand Lead
                    </button>
                </div>
            </div>

            <form action="{{ route('admin.notifications.send') }}" method="POST" id="broadcastForm" class="space-y-5">
                @csrf

                <!-- Target Audience Segment Selector -->
                <div class="space-y-2">
                    <label class="block text-[11px] font-semibold text-slate-700">Target Audience Segment <span class="text-rose-500">*</span></label>
                    <div class="grid grid-cols-2 sm:grid-cols-3 gap-2.5">
                        <label class="audience-card relative border border-slate-200 rounded-xl p-3 cursor-pointer hover:border-emerald-500 transition flex flex-col justify-between bg-slate-50/50">
                            <input type="radio" name="target_audience" value="all" checked onchange="toggleAudienceOptions(this.value)" class="sr-only">
                            <div class="flex items-center justify-between mb-1.5">
                                <span class="text-xs font-bold text-slate-900">All Members</span>
                                <div class="audience-indicator h-3.5 w-3.5 rounded-full border-2 border-slate-300 flex items-center justify-center"></div>
                            </div>
                            <span class="text-[11px] text-slate-500">{{ number_format($totalUsersCount) }} registered users</span>
                        </label>

                        <label class="audience-card relative border border-slate-200 rounded-xl p-3 cursor-pointer hover:border-emerald-500 transition flex flex-col justify-between bg-slate-50/50">
                            <input type="radio" name="target_audience" value="hosts" onchange="toggleAudienceOptions(this.value)" class="sr-only">
                            <div class="flex items-center justify-between mb-1.5">
                                <span class="text-xs font-bold text-slate-900">Landlords & Hosts</span>
                                <div class="audience-indicator h-3.5 w-3.5 rounded-full border-2 border-slate-300 flex items-center justify-center"></div>
                            </div>
                            <span class="text-[11px] text-slate-500">{{ number_format($hostsCount) }} property owners</span>
                        </label>

                        <label class="audience-card relative border border-slate-200 rounded-xl p-3 cursor-pointer hover:border-emerald-500 transition flex flex-col justify-between bg-slate-50/50">
                            <input type="radio" name="target_audience" value="tenants" onchange="toggleAudienceOptions(this.value)" class="sr-only">
                            <div class="flex items-center justify-between mb-1.5">
                                <span class="text-xs font-bold text-slate-900">Tenants & Seekers</span>
                                <div class="audience-indicator h-3.5 w-3.5 rounded-full border-2 border-slate-300 flex items-center justify-center"></div>
                            </div>
                            <span class="text-[11px] text-slate-500">{{ number_format($tenantsCount) }} active renters</span>
                        </label>

                        <label class="audience-card relative border border-slate-200 rounded-xl p-3 cursor-pointer hover:border-emerald-500 transition flex flex-col justify-between bg-slate-50/50">
                            <input type="radio" name="target_audience" value="pro" onchange="toggleAudienceOptions(this.value)" class="sr-only">
                            <div class="flex items-center justify-between mb-1.5">
                                <span class="text-xs font-bold text-slate-900">Pro Subscribers</span>
                                <div class="audience-indicator h-3.5 w-3.5 rounded-full border-2 border-slate-300 flex items-center justify-center"></div>
                            </div>
                            <span class="text-[11px] text-slate-500">Paid Pro tier</span>
                        </label>

                        <label class="audience-card relative border border-slate-200 rounded-xl p-3 cursor-pointer hover:border-emerald-500 transition flex flex-col justify-between bg-slate-50/50">
                            <input type="radio" name="target_audience" value="business" onchange="toggleAudienceOptions(this.value)" class="sr-only">
                            <div class="flex items-center justify-between mb-1.5">
                                <span class="text-xs font-bold text-slate-900">Business Tier</span>
                                <div class="audience-indicator h-3.5 w-3.5 rounded-full border-2 border-slate-300 flex items-center justify-center"></div>
                            </div>
                            <span class="text-[11px] text-slate-500">Enterprise agencies</span>
                        </label>

                        <label class="audience-card relative border border-slate-200 rounded-xl p-3 cursor-pointer hover:border-emerald-500 transition flex flex-col justify-between bg-slate-50/50">
                            <input type="radio" name="target_audience" value="individual" onchange="toggleAudienceOptions(this.value)" class="sr-only">
                            <div class="flex items-center justify-between mb-1.5">
                                <span class="text-xs font-bold text-slate-900">Single User</span>
                                <div class="audience-indicator h-3.5 w-3.5 rounded-full border-2 border-slate-300 flex items-center justify-center"></div>
                            </div>
                            <span class="text-[11px] text-slate-500">Direct recipient</span>
                        </label>
                    </div>
                </div>

                <!-- Individual User Search Dropdown (Hidden by default) -->
                <div id="individualUserContainer" class="hidden space-y-1.5 p-4 bg-slate-50 border border-slate-200 rounded-xl">
                    <label class="block text-[11px] font-semibold text-slate-700">Select Target User <span class="text-rose-500">*</span></label>
                    <select name="target_user_id" id="targetUserIdSelect" class="w-full px-3.5 py-2.5 bg-white border border-slate-200 rounded-lg text-slate-900 text-xs font-medium focus:outline-none focus:border-emerald-500 focus:ring-2 focus:ring-emerald-500/10 transition shadow-xs">
                        <option value="">-- Choose recipient user --</option>
                        @foreach($recentUsers as $u)
                            <option value="{{ $u->id }}">
                                {{ $u->name }} ({{ $u->email }}) {{ !empty($u->fcm_token) ? '📱 [Push Enabled]' : '✉️ [In-App only]' }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <!-- Notification Title -->
                <div class="space-y-1.5">
                    <div class="flex items-center justify-between">
                        <label class="block text-[11px] font-semibold text-slate-700">Notification Title <span class="text-rose-500">*</span></label>
                        <span id="titleCharCount" class="text-[10px] text-slate-400 font-mono">0 / 80</span>
                    </div>
                    <input type="text" name="title" id="notificationTitleInput" required maxlength="80" placeholder="e.g. Exclusive Weekend Deal Available!"
                           oninput="updatePreview(); updateCharCount('notificationTitleInput', 'titleCharCount', 80);"
                           class="w-full px-3.5 py-2.5 bg-white border border-slate-200 rounded-lg text-slate-900 text-xs font-bold focus:outline-none focus:border-emerald-500 focus:ring-2 focus:ring-emerald-500/10 transition shadow-xs">
                </div>

                <!-- Notification Message Body -->
                <div class="space-y-1.5">
                    <div class="flex items-center justify-between">
                        <label class="block text-[11px] font-semibold text-slate-700">Message Body Content <span class="text-rose-500">*</span></label>
                        <span id="bodyCharCount" class="text-[10px] text-slate-400 font-mono">0 / 250</span>
                    </div>
                    <textarea name="message" id="notificationBodyInput" rows="3" required maxlength="250" placeholder="e.g. Discover newly verified 2BHK and 3BHK listings in your favorite neighborhood with zero brokerage fee."
                              oninput="updatePreview(); updateCharCount('notificationBodyInput', 'bodyCharCount', 250);"
                              class="w-full px-3.5 py-2.5 bg-white border border-slate-200 rounded-lg text-slate-900 text-xs font-medium focus:outline-none focus:border-emerald-500 focus:ring-2 focus:ring-emerald-500/10 transition shadow-xs leading-relaxed"></textarea>
                </div>

                <!-- Type & Deep Link Row -->
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                    
                    <!-- Notification Type -->
                    <div class="space-y-1.5">
                        <label class="block text-[11px] font-semibold text-slate-700">Urgency / Category Type <span class="text-rose-500">*</span></label>
                        <select name="type" id="notificationTypeSelect" required onchange="updatePreview()"
                                class="w-full px-3.5 py-2.5 bg-white border border-slate-200 rounded-lg text-slate-900 text-xs font-medium focus:outline-none focus:border-emerald-500 focus:ring-2 focus:ring-emerald-500/10 transition shadow-xs">
                            <option value="announcement">📢 Announcement (Standard)</option>
                            <option value="promotion">🏷️ Promotion & Marketing</option>
                            <option value="alert">⚠️ Urgent Alert</option>
                            <option value="system">⚙️ System Update</option>
                            <option value="info">ℹ️ General Info</option>
                        </select>
                    </div>

                    <!-- Deep Link Action Route -->
                    <div class="space-y-1.5">
                        <label class="block text-[11px] font-semibold text-slate-700">Action Link / Route Slug</label>
                        <input type="text" name="action_url" id="notificationActionUrl" placeholder="e.g. /properties, /pricing, or URL"
                               class="w-full px-3.5 py-2.5 bg-white border border-slate-200 rounded-lg text-slate-900 text-xs font-mono focus:outline-none focus:border-emerald-500 focus:ring-2 focus:ring-emerald-500/10 transition shadow-xs">
                    </div>
                </div>

                <!-- Channels Checkboxes -->
                <div class="p-4 bg-slate-50 border border-slate-200/80 rounded-xl space-y-2.5">
                    <div class="text-[11px] font-bold text-slate-800 uppercase tracking-wider">Delivery Channels</div>
                    
                    <div class="flex items-center justify-between">
                        <label class="flex items-center gap-2.5 cursor-pointer">
                            <input type="checkbox" name="send_push" value="1" checked class="h-4 w-4 rounded border-slate-300 text-emerald-600 focus:ring-emerald-500">
                            <span class="text-xs font-semibold text-slate-800">Deliver FCM Push Notification</span>
                        </label>
                        <span class="text-[11px] text-slate-400">iOS & Android devices</span>
                    </div>

                    <div class="flex items-center justify-between">
                        <label class="flex items-center gap-2.5 cursor-not-allowed opacity-90">
                            <input type="checkbox" checked disabled class="h-4 w-4 rounded border-slate-300 text-emerald-600">
                            <span class="text-xs font-semibold text-slate-800">Save In-App Inbox Notification</span>
                        </label>
                        <span class="text-[11px] text-emerald-600 font-semibold">Always active</span>
                    </div>
                </div>

                <!-- Action Button -->
                <div class="flex items-center justify-end gap-3 pt-2">
                    <button type="reset" onclick="setTimeout(updatePreview, 50)" class="px-4 py-2.5 bg-white hover:bg-slate-100 text-slate-700 text-xs font-semibold rounded-xl border border-slate-200 transition">
                        Reset Form
                    </button>
                    <button type="submit" onclick="return confirm('Are you sure you want to dispatch this push notification broadcast to the selected audience?');" class="px-5 py-2.5 bg-emerald-600 hover:bg-emerald-700 text-white text-xs font-bold rounded-xl shadow-sm transition flex items-center gap-2">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 19l9 2-9-18-9 18 9-2zm0 0v-8"/></svg>
                        <span>Dispatch Broadcast Now</span>
                    </button>
                </div>
            </form>
        </div>

        <!-- Interactive Mobile Device Preview (5 Cols) -->
        <div class="lg:col-span-5 space-y-4">
            
            <div class="bg-white rounded-2xl border border-slate-200/80 shadow-xs p-6 space-y-4">
                <div class="flex items-center justify-between border-b border-slate-100 pb-3">
                    <h3 class="text-xs font-bold text-slate-900 uppercase tracking-wider flex items-center gap-1.5">
                        <svg class="w-4 h-4 text-emerald-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 18h.01M8 21h8a2 2 0 002-2V5a2 2 0 00-2-2H8a2 2 0 00-2 2v14a2 2 0 002 2z"/></svg>
                        <span>Mobile Device Preview</span>
                    </h3>
                    <span class="text-[10px] text-slate-400 font-mono">Live Rendering</span>
                </div>

                <!-- Phone Mockup Container -->
                <div class="w-full max-w-sm mx-auto bg-slate-950 rounded-[36px] p-3 shadow-xl border-4 border-slate-800 relative">
                    
                    <!-- Dynamic Island / Speaker notch -->
                    <div class="h-4 w-28 bg-slate-900 rounded-full mx-auto mb-3 flex items-center justify-center">
                        <div class="h-1.5 w-1.5 bg-slate-700 rounded-full"></div>
                    </div>

                    <!-- Phone Screen Surface -->
                    <div class="bg-gradient-to-b from-slate-900 via-slate-850 to-[#0A2540] rounded-[26px] p-4 min-h-[360px] flex flex-col justify-between text-white relative overflow-hidden">
                        
                        <!-- Status Bar -->
                        <div class="flex items-center justify-between text-[10px] text-slate-400 font-medium px-1 mb-6">
                            <span>9:41</span>
                            <div class="flex items-center gap-1">
                                <span>5G</span>
                                <svg class="w-3.5 h-3.5 inline" fill="currentColor" viewBox="0 0 24 24"><path d="M12 3c-4.97 0-9 4.03-9 9 0 2.12.74 4.07 1.97 5.61L4.35 18.25A9.957 9.957 0 012 12C2 6.48 6.48 2 12 2s10 4.48 10 10c0 2.32-.8 4.45-2.14 6.14l-.62-.62A8.966 8.966 0 0021 12c0-4.97-4.03-9-9-9z"/></svg>
                                <svg class="w-4 h-4 inline" fill="currentColor" viewBox="0 0 24 24"><path d="M15.67 4H14V2h-4v2H8.33C7.6 4 7 4.6 7 5.33v15.33C7 21.4 7.6 22 8.33 22h7.33c.74 0 1.34-.6 1.34-1.33V5.33C17 4.6 16.4 4 15.67 4z"/></svg>
                            </div>
                        </div>

                        <!-- Push Notification Banner Card (Interactive Preview) -->
                        <div class="space-y-4">
                            <div id="previewCard" class="bg-white/10 backdrop-blur-xl border border-white/20 rounded-2xl p-3.5 shadow-2xl text-white space-y-2 transition duration-200 hover:scale-[1.02]">
                                <div class="flex items-center justify-between">
                                    <div class="flex items-center gap-2">
                                        <div class="h-5 w-5 rounded-lg bg-emerald-500 p-0.5 flex items-center justify-center">
                                            <img src="/logo.png" class="h-3.5 w-auto" alt="logo">
                                        </div>
                                        <span class="text-[11px] font-bold text-slate-200 tracking-tight">HomiQ</span>
                                        <span class="text-[9px] px-1.5 py-0.2 rounded bg-emerald-500/20 text-emerald-300 font-semibold" id="previewTypeBadge">ANNOUNCEMENT</span>
                                    </div>
                                    <span class="text-[10px] text-slate-400 font-mono">now</span>
                                </div>

                                <div>
                                    <div class="text-xs font-bold text-white leading-tight" id="previewTitle">
                                        Exclusive Weekend Deal Available!
                                    </div>
                                    <div class="text-[11px] text-slate-300 mt-1 leading-snug line-clamp-3" id="previewBody">
                                        Discover newly verified 2BHK and 3BHK listings in your favorite neighborhood with zero brokerage fee.
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Phone Lock Screen Bottom Bar -->
                        <div class="text-center pt-8">
                            <div class="h-1 w-24 bg-white/40 rounded-full mx-auto mb-2"></div>
                            <span class="text-[9px] text-slate-500 font-medium">Swipe up to open</span>
                        </div>
                    </div>
                </div>
            </div>

            <!-- FCM Configuration Quick Card -->
            <div class="bg-slate-900 text-white rounded-2xl p-5 border border-slate-800 space-y-2.5">
                <div class="flex items-center justify-between">
                    <span class="text-xs font-bold text-emerald-400 uppercase tracking-wider flex items-center gap-1.5">
                        <span class="h-2 w-2 rounded-full bg-emerald-400"></span>
                        Firebase Cloud Messaging
                    </span>
                    <a href="/admin/config" class="text-[10px] text-slate-400 hover:text-white underline">Edit API Keys</a>
                </div>
                <p class="text-xs text-slate-300 leading-relaxed">
                    Uses Google OAuth2 Service Account and HTTP v1 API with APNs & Android High-Priority channels for sub-second push delivery.
                </p>
            </div>
        </div>
    </div>

    <!-- Broadcast History & Delivery Logs Table -->
    <div class="bg-white rounded-2xl border border-slate-200/80 shadow-xs overflow-hidden">
        <div class="p-5 border-b border-slate-100 flex flex-col sm:flex-row sm:items-center justify-between gap-3">
            <div>
                <h3 class="text-sm font-bold text-slate-900">Campaign History & Delivery Logs</h3>
                <p class="text-xs text-slate-500 mt-0.5">Audit log of all notifications dispatched through the admin control center.</p>
            </div>
            <span class="px-2.5 py-1 bg-slate-100 text-slate-700 text-xs font-semibold rounded-lg border border-slate-200">
                Total Logs: <strong class="text-slate-900">{{ $broadcasts->total() }}</strong>
            </span>
        </div>

        @if($broadcasts->isEmpty())
            <div class="py-14 text-center">
                <div class="w-12 h-12 bg-slate-100 rounded-2xl flex items-center justify-center mx-auto text-slate-400 mb-3">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.75" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9" />
                    </svg>
                </div>
                <h3 class="text-sm font-bold text-slate-800">No push broadcasts sent yet</h3>
                <p class="text-xs text-slate-500 mt-1 max-w-sm mx-auto">Compose your first push notification above to engage with mobile users.</p>
            </div>
        @else
            <div class="overflow-x-auto">
                <table class="w-full text-left text-xs border-collapse">
                    <thead>
                        <tr class="bg-slate-50/75 border-b border-slate-200/80 text-[11px] font-semibold text-slate-500 uppercase tracking-wider">
                            <th class="px-5 py-3.5">Sent Time</th>
                            <th class="px-5 py-3.5">Notification Content</th>
                            <th class="px-5 py-3.5">Target Audience</th>
                            <th class="px-5 py-3.5">Type & Action</th>
                            <th class="px-5 py-3.5">Delivered</th>
                            <th class="px-5 py-3.5">FCM Push Sent</th>
                            <th class="px-5 py-3.5 text-right">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100">
                        @foreach($broadcasts as $item)
                            <tr class="hover:bg-slate-50/60 transition">
                                <td class="px-5 py-4 whitespace-nowrap text-slate-500 font-medium">
                                    <div class="font-bold text-slate-800">{{ $item->created_at->format('M d, Y') }}</div>
                                    <div class="text-[11px] text-slate-400">{{ $item->created_at->format('h:i A') }} ({{ $item->created_at->diffForHumans() }})</div>
                                </td>

                                <td class="px-5 py-4 max-w-xs">
                                    <div class="font-bold text-slate-900 leading-tight">{{ $item->title }}</div>
                                    <div class="text-[11px] text-slate-500 mt-1 line-clamp-2 leading-relaxed">{{ $item->message }}</div>
                                </td>

                                <td class="px-5 py-4 whitespace-nowrap">
                                    <span class="inline-flex items-center px-2 py-0.5 rounded-md text-[10px] font-semibold bg-slate-100 text-slate-700 border border-slate-200">
                                        {{ $item->audience_label }}
                                    </span>
                                </td>

                                <td class="px-5 py-4 whitespace-nowrap">
                                    <div>
                                        <span class="inline-flex items-center px-2 py-0.5 rounded-md text-[10px] font-semibold uppercase tracking-wider
                                            @if($item->type === 'alert') bg-rose-50 text-rose-700 border border-rose-200
                                            @elseif($item->type === 'promotion') bg-blue-50 text-blue-700 border border-blue-200
                                            @elseif($item->type === 'system') bg-amber-50 text-amber-700 border border-amber-200
                                            @else bg-emerald-50 text-emerald-700 border border-emerald-200
                                            @endif">
                                            {{ $item->type }}
                                        </span>
                                        @if($item->action_url)
                                            <div class="text-[10px] font-mono text-slate-400 mt-1 truncate max-w-[120px]">
                                                {{ $item->action_url }}
                                            </div>
                                        @endif
                                    </div>
                                </td>

                                <td class="px-5 py-4 whitespace-nowrap font-mono font-bold text-slate-800">
                                    {{ number_format($item->recipients_count) }}
                                </td>

                                <td class="px-5 py-4 whitespace-nowrap">
                                    <span class="font-mono font-bold text-emerald-700 bg-emerald-50 px-2 py-0.5 rounded-md border border-emerald-100">
                                        {{ number_format($item->fcm_sent_count) }}
                                    </span>
                                </td>

                                <td class="px-5 py-4 whitespace-nowrap text-right">
                                    <form action="{{ route('admin.notifications.delete', $item->id) }}" method="POST" onsubmit="return confirm('Delete this broadcast campaign record?');" class="m-0 inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="p-1.5 text-slate-400 hover:text-rose-600 hover:bg-rose-50 rounded-lg transition" title="Delete record">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
                                        </button>
                                    </form>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            @if($broadcasts->hasPages())
                <div class="p-4 border-t border-slate-100">
                    {{ $broadcasts->links() }}
                </div>
            @endif
        @endif
    </div>
</div>

<script>
    // Live Mobile Preview sync
    function updatePreview() {
        const titleInput = document.getElementById('notificationTitleInput');
        const bodyInput = document.getElementById('notificationBodyInput');
        const typeSelect = document.getElementById('notificationTypeSelect');

        const previewTitle = document.getElementById('previewTitle');
        const previewBody = document.getElementById('previewBody');
        const previewTypeBadge = document.getElementById('previewTypeBadge');

        previewTitle.textContent = titleInput.value.trim() || 'Notification Title Preview';
        previewBody.textContent = bodyInput.value.trim() || 'Your message body will appear here in real-time as you compose your push broadcast...';
        previewTypeBadge.textContent = typeSelect.value.toUpperCase();
    }

    function updateCharCount(inputId, countId, max) {
        const input = document.getElementById(inputId);
        const count = document.getElementById(countId);
        count.textContent = input.value.length + ' / ' + max;
    }

    function toggleAudienceOptions(val) {
        const individualContainer = document.getElementById('individualUserContainer');
        const select = document.getElementById('targetUserIdSelect');

        if (val === 'individual') {
            individualContainer.classList.remove('hidden');
            select.setAttribute('required', 'required');
        } else {
            individualContainer.classList.add('hidden');
            select.removeAttribute('required');
        }

        // Highlight selected audience card
        document.querySelectorAll('.audience-card').forEach(card => {
            const input = card.querySelector('input');
            const indicator = card.querySelector('.audience-indicator');
            if (input.checked) {
                card.classList.add('border-emerald-500', 'bg-emerald-50/40');
                card.classList.remove('border-slate-200', 'bg-slate-50/50');
                indicator.classList.add('border-emerald-600', 'bg-emerald-600');
                indicator.classList.remove('border-slate-300');
            } else {
                card.classList.remove('border-emerald-500', 'bg-emerald-50/40');
                card.classList.add('border-slate-200', 'bg-slate-50/50');
                indicator.classList.remove('border-emerald-600', 'bg-emerald-600');
                indicator.classList.add('border-slate-300');
            }
        });
    }

    // Template Presets
    const templates = {
        feature: {
            title: '✨ Discover the New Demand Board',
            body: 'Post your rental or buying requirements and get matched with verified property owners instantly on HomiQ.',
            type: 'announcement',
            action: '/demand-board'
        },
        promo: {
            title: '🏷️ 20% Off Pro Landlord Subscriptions',
            body: 'Upgrade your host account this week to unlock unlimited verified listings and premium seeker matching.',
            type: 'promotion',
            action: '/pricing'
        },
        maintenance: {
            title: '⚙️ Scheduled System Maintenance',
            body: 'HomiQ services will undergo a brief scheduled database optimization tonight at 2:00 AM IST for ~10 minutes.',
            type: 'system',
            action: ''
        },
        demand: {
            title: '🎯 New Seeker Match in Your Area',
            body: 'A tenant is actively looking for a 2BHK apartment matching your listed properties. Tap to connect now.',
            type: 'alert',
            action: '/dashboard'
        }
    };

    function applyTemplate(key) {
        const t = templates[key];
        if (!t) return;

        document.getElementById('notificationTitleInput').value = t.title;
        document.getElementById('notificationBodyInput').value = t.body;
        document.getElementById('notificationTypeSelect').value = t.type;
        document.getElementById('notificationActionUrl').value = t.action;

        updateCharCount('notificationTitleInput', 'titleCharCount', 80);
        updateCharCount('notificationBodyInput', 'bodyCharCount', 250);
        updatePreview();
    }

    // Initial setup on page load
    document.addEventListener('DOMContentLoaded', () => {
        toggleAudienceOptions('all');
        updateCharCount('notificationTitleInput', 'titleCharCount', 80);
        updateCharCount('notificationBodyInput', 'bodyCharCount', 250);
    });
</script>
@endsection
