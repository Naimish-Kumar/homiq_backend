@extends('admin.layout')

@section('content')
<div class="space-y-6">
    <!-- Header Area -->
    <div class="flex items-center justify-between pb-5 border-b border-slate-100">
        <div>
            <h1 class="text-xl font-black text-slate-800 tracking-tight">System Configurations</h1>
            <p class="text-xs font-semibold text-slate-400 mt-1">Manage global site attributes, SMTP email delivery options, and Firebase API service configurations.</p>
        </div>
    </div>

    <!-- Configuration Main Card -->
    <div class="bg-white border border-slate-200/60 rounded-xl shadow-sm overflow-hidden flex flex-col md:flex-row min-h-[550px]">
        
        <!-- Sidebar Navigation Tabs -->
        <div class="w-full md:w-64 bg-slate-50 border-r border-slate-100 p-4 space-y-1.5 flex-shrink-0">
            <div class="text-[9px] text-slate-400 font-extrabold uppercase tracking-widest px-3 mb-2">Category Groups</div>
            
            <button onclick="switchTab('general')" id="tab-btn-general" 
                    class="tab-btn w-full flex items-center gap-3 px-3 py-2.5 rounded-md text-xs font-bold transition text-left text-donezoGreen bg-donezoLightGreen/50">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z" /><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                </svg>
                General Settings
            </button>

            <button onclick="switchTab('smtp')" id="tab-btn-smtp" 
                    class="tab-btn w-full flex items-center gap-3 px-3 py-2.5 rounded-md text-xs font-bold transition text-left text-slate-500 hover:bg-slate-100 hover:text-slate-700">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                </svg>
                SMTP Email Setup
            </button>

            <button onclick="switchTab('firebase')" id="tab-btn-firebase" 
                    class="tab-btn w-full flex items-center gap-3 px-3 py-2.5 rounded-md text-xs font-bold transition text-left text-slate-500 hover:bg-slate-100 hover:text-slate-700">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10" />
                </svg>
                Firebase Services
            </button>

            <button onclick="switchTab('listing')" id="tab-btn-listing" 
                    class="tab-btn w-full flex items-center gap-3 px-3 py-2.5 rounded-md text-xs font-bold transition text-left text-slate-500 hover:bg-slate-100 hover:text-slate-700">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 10h16M4 14h16M4 18h16" />
                </svg>
                Listing Settings
            </button>

            <button onclick="switchTab('app')" id="tab-btn-app" 
                    class="tab-btn w-full flex items-center gap-3 px-3 py-2.5 rounded-md text-xs font-bold transition text-left text-slate-500 hover:bg-slate-100 hover:text-slate-700">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 18h.01M8 21h8a2 2 0 002-2V5a2 2 0 00-2-2H8a2 2 0 00-2 2v14a2 2 0 002 2z" />
                </svg>
                App Updates
            </button>
        </div>

        <!-- Form Area -->
        <div class="flex-1 p-8">
            <form action="/admin/config" method="POST" class="m-0 space-y-8">
                @csrf

                <!-- Tab Content: General Settings -->
                <div id="tab-content-general" class="tab-pane space-y-6">
                    <div>
                        <h2 class="text-sm font-extrabold text-[#187053] uppercase tracking-widest">General settings</h2>
                        <p class="text-[11px] font-semibold text-slate-400 mt-1">Configure global application branding name and public details.</p>
                    </div>

                    @if(isset($groups['general']))
                        @foreach($groups['general'] as $config)
                            <div class="space-y-1.5 max-w-xl">
                                <label class="block text-[9px] font-extrabold text-slate-400 uppercase tracking-widest">{{ $config->label }}</label>
                                @if($config->type === 'textarea')
                                    <textarea name="{{ $config->key }}" rows="4" 
                                              class="w-full px-4 py-3 bg-slate-50 border border-slate-200/60 rounded-md text-slate-850 text-xs font-semibold focus:outline-none focus:border-[#187053] transition-colors leading-relaxed">{{ $config->value }}</textarea>
                                @else
                                    <input type="text" name="{{ $config->key }}" value="{{ $config->value }}" 
                                           class="w-full px-4 py-3 bg-slate-50 border border-slate-200/60 rounded-md text-slate-850 text-xs font-semibold focus:outline-none focus:border-[#187053] transition-colors">
                                @endif
                                <p class="text-[10px] text-slate-400 leading-normal">{{ $config->description }}</p>
                            </div>
                        @endforeach
                    @endif
                </div>

                <!-- Tab Content: SMTP Setup -->
                <div id="tab-content-smtp" class="tab-pane hidden space-y-6">
                    <div>
                        <h2 class="text-sm font-extrabold text-[#187053] uppercase tracking-widest">SMTP Email Setup</h2>
                        <p class="text-[11px] font-semibold text-slate-400 mt-1">Setup your email server configuration details for verification and system updates.</p>
                    </div>

                    @if(isset($groups['smtp']))
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6 max-w-3xl">
                            @foreach($groups['smtp'] as $config)
                                <div class="space-y-1.5 col-span-2 {{ in_array($config->key, ['mail_host', 'mail_username', 'mail_password']) ? 'md:col-span-1' : '' }}">
                                    <label class="block text-[9px] font-extrabold text-slate-400 uppercase tracking-widest">{{ $config->label }}</label>
                                    
                                    @if($config->type === 'password')
                                        <div class="relative">
                                            <input type="password" name="{{ $config->key }}" value="{{ $config->value }}" id="input-{{ $config->key }}"
                                                   class="w-full pl-4 pr-10 py-3 bg-slate-50 border border-slate-200/60 rounded-md text-slate-850 text-xs font-semibold focus:outline-none focus:border-[#187053] transition-colors">
                                            <button type="button" onclick="togglePasswordVisibility('input-{{ $config->key }}')" class="absolute inset-y-0 right-0 pr-3.5 flex items-center text-slate-400 hover:text-slate-650">
                                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                                </svg>
                                            </button>
                                        </div>
                                    @else
                                        <input type="text" name="{{ $config->key }}" value="{{ $config->value }}" 
                                               class="w-full px-4 py-3 bg-slate-50 border border-slate-200/60 rounded-md text-slate-850 text-xs font-semibold focus:outline-none focus:border-[#187053] transition-colors">
                                    @endif
                                    <p class="text-[10px] text-slate-400 leading-normal">{{ $config->description }}</p>
                                </div>
                            @endforeach
                        </div>
                    @endif
                </div>

                <!-- Tab Content: Firebase Services -->
                <div id="tab-content-firebase" class="tab-pane hidden space-y-6">
                    <div>
                        <h2 class="text-sm font-extrabold text-[#187053] uppercase tracking-widest">Firebase Services</h2>
                        <p class="text-[11px] font-semibold text-slate-400 mt-1">Configure Firebase parameters to link authentication, messaging, and storage buckets.</p>
                    </div>

                    @if(isset($groups['firebase']))
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6 max-w-3xl">
                            @foreach($groups['firebase'] as $config)
                                <div class="space-y-1.5 col-span-2 {{ $config->key !== 'firebase_api_key' && $config->key !== 'firebase_app_id' ? 'md:col-span-1' : '' }}">
                                    <label class="block text-[9px] font-extrabold text-slate-400 uppercase tracking-widest">{{ $config->label }}</label>
                                    
                                    @if($config->type === 'password')
                                        <div class="relative">
                                            <input type="password" name="{{ $config->key }}" value="{{ $config->value }}" id="input-{{ $config->key }}"
                                                   class="w-full pl-4 pr-10 py-3 bg-slate-50 border border-slate-200/60 rounded-md text-slate-850 text-xs font-semibold focus:outline-none focus:border-[#187053] transition-colors">
                                            <button type="button" onclick="togglePasswordVisibility('input-{{ $config->key }}')" class="absolute inset-y-0 right-0 pr-3.5 flex items-center text-slate-400 hover:text-slate-650">
                                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                                </svg>
                                            </button>
                                        </div>
                                    @else
                                        <input type="text" name="{{ $config->key }}" value="{{ $config->value }}" 
                                               class="w-full px-4 py-3 bg-slate-50 border border-slate-200/60 rounded-md text-slate-850 text-xs font-semibold focus:outline-none focus:border-[#187053] transition-colors">
                                    @endif
                                    <p class="text-[10px] text-slate-400 leading-normal">{{ $config->description }}</p>
                                </div>
                            @endforeach
                        </div>
                    @endif
                </div>

                <!-- Tab Content: Listing Settings -->
                <div id="tab-content-listing" class="tab-pane hidden space-y-6">
                    <div>
                        <h2 class="text-sm font-extrabold text-[#187053] uppercase tracking-widest">Listing Settings</h2>
                        <p class="text-[11px] font-semibold text-slate-400 mt-1">Configure categories, specifications, key features, and amenities available for property listing.</p>
                    </div>

                    @if(isset($groups['listing']))
                        <div class="space-y-6 max-w-xl">
                            @foreach($groups['listing'] as $config)
                                <div class="space-y-1.5">
                                    <label class="block text-[9px] font-extrabold text-slate-400 uppercase tracking-widest">{{ $config->label }}</label>
                                    <input type="text" name="{{ $config->key }}" value="{{ $config->value }}" 
                                           class="w-full px-4 py-3 bg-slate-50 border border-slate-200/60 rounded-md text-slate-850 text-xs font-semibold focus:outline-none focus:border-[#187053] transition-colors">
                                    <p class="text-[10px] text-slate-400 leading-normal">{{ $config->description }}</p>
                                </div>
                            @endforeach
                        </div>
                    @endif
                </div>

                <!-- Tab Content: App Updates -->
                <div id="tab-content-app" class="tab-pane hidden space-y-6">
                    <div>
                        <h2 class="text-sm font-extrabold text-[#187053] uppercase tracking-widest">App Updates</h2>
                        <p class="text-[11px] font-semibold text-slate-400 mt-1">Configure live app version update prompts and store redirect links.</p>
                    </div>

                    @if(isset($groups['app']))
                        <div class="space-y-6 max-w-xl">
                            @foreach($groups['app'] as $config)
                                <div class="space-y-1.5">
                                    <label class="block text-[9px] font-extrabold text-slate-400 uppercase tracking-widest">{{ $config->label }}</label>
                                    @if($config->type === 'boolean')
                                        <select name="{{ $config->key }}" class="w-full px-4 py-3 bg-slate-50 border border-slate-200/60 rounded-md text-slate-850 text-xs font-semibold focus:outline-none focus:border-[#187053] transition-colors">
                                            <option value="0" {{ $config->value == '0' ? 'selected' : '' }}>No (Disable Forced Update)</option>
                                            <option value="1" {{ $config->value == '1' ? 'selected' : '' }}>Yes (Enable Forced Update)</option>
                                        </select>
                                    @else
                                        <input type="text" name="{{ $config->key }}" value="{{ $config->value }}" 
                                               class="w-full px-4 py-3 bg-slate-50 border border-slate-200/60 rounded-md text-slate-850 text-xs font-semibold focus:outline-none focus:border-[#187053] transition-colors">
                                    @endif
                                    <p class="text-[10px] text-slate-400 leading-normal">{{ $config->description }}</p>
                                </div>
                            @endforeach
                        </div>
                    @endif
                </div>

                <!-- Footer Save Bar -->
                <div class="border-t border-slate-100 pt-6 flex justify-end gap-3 max-w-3xl">
                    <button type="reset" class="px-4 py-2 bg-slate-100 hover:bg-slate-200 text-slate-700 text-xs font-bold rounded-md border border-slate-250 transition">
                        Reset Defaults
                    </button>
                    <button type="submit" class="px-5 py-2 bg-[#187053] hover:bg-[#12563f] text-white text-xs font-bold rounded-md shadow transition">
                        Save Configurations
                    </button>
                </div>
            </form>
        </div>

    </div>
</div>

<script>
    function switchTab(tabId) {
        // Hide all tab content panes
        const contents = document.querySelectorAll('.tab-pane');
        contents.forEach(pane => pane.classList.add('hidden'));

        // Reset all tab button styles to unselected slate theme
        const buttons = document.querySelectorAll('.tab-btn');
        buttons.forEach(btn => {
            btn.classList.remove('text-donezoGreen', 'bg-donezoLightGreen/50');
            btn.classList.add('text-slate-500', 'hover:bg-slate-100', 'hover:text-slate-700');
        });

        // Show active tab content
        document.getElementById('tab-content-' + tabId).classList.remove('hidden');

        // Apply selected donezo highlights to active tab button
        const activeBtn = document.getElementById('tab-btn-' + tabId);
        activeBtn.classList.remove('text-slate-500', 'hover:bg-slate-100', 'hover:text-slate-700');
        activeBtn.classList.add('text-donezoGreen', 'bg-donezoLightGreen/50');
    }

    function togglePasswordVisibility(inputId) {
        const input = document.getElementById(inputId);
        if (input.type === "password") {
            input.type = "text";
        } else {
            input.type = "password";
        }
    }
</script>
@endsection
