@extends('admin.layout')

@section('page_title', 'Listing Attributes & Taxonomy')

@section('content')
<div class="space-y-6">

    <!-- Header & Taxonomy Summary Banner -->
    <div class="flex flex-col lg:flex-row lg:items-center justify-between gap-4 pb-5 border-b border-slate-200/80">
        <div>
            <div class="flex items-center gap-2 mb-1">
                <span class="px-2.5 py-0.5 rounded-full text-[10px] font-extrabold bg-emerald-50 text-emerald-700 border border-emerald-200/80 uppercase tracking-wider flex items-center gap-1.5">
                    <span class="h-1.5 w-1.5 rounded-full bg-emerald-500"></span>
                    Property Taxonomy Registry
                </span>
                <span class="text-slate-300">•</span>
                <span class="text-xs text-slate-400 font-medium">Real-time classification sync</span>
            </div>
            <h1 class="text-xl font-black text-slate-900 tracking-tight flex items-center gap-2.5">
                <span class="p-2 rounded-xl bg-gradient-to-tr from-emerald-500 to-teal-600 text-white shadow-md shadow-emerald-500/20">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10" />
                    </svg>
                </span>
                Listing Attributes & Taxonomy
            </h1>
            <p class="text-xs text-slate-500 mt-1">Configure property categories, numeric specifications, key feature flags, and searchable amenity tags.</p>
        </div>

        <!-- Telemetry Counts & Action -->
        <div class="flex flex-wrap items-center gap-2.5">
            <div class="flex items-center gap-2 bg-slate-50 p-1.5 rounded-2xl border border-slate-200/80 text-xs font-semibold text-slate-600">
                <span class="px-2.5 py-1 rounded-xl bg-white text-slate-900 font-bold shadow-2xs border border-slate-200/60">{{ count($categories) }} Categories</span>
                <span class="px-2.5 py-1 rounded-xl bg-white text-slate-900 font-bold shadow-2xs border border-slate-200/60">{{ count($specifications) }} Specs</span>
                <span class="px-2.5 py-1 rounded-xl bg-white text-slate-900 font-bold shadow-2xs border border-slate-200/60">{{ count($features) }} Features</span>
                <span class="px-2.5 py-1 rounded-xl bg-white text-slate-900 font-bold shadow-2xs border border-slate-200/60">{{ count($amenities) }} Amenities</span>
            </div>
        </div>
    </div>

    @if(session('success'))
        <div class="p-4 bg-emerald-50 border border-emerald-200 text-emerald-800 rounded-2xl text-xs flex items-center gap-3 shadow-xs animate-fadeIn">
            <div class="h-7 w-7 rounded-lg bg-emerald-500 text-white flex items-center justify-center shrink-0">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2.5"><path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7"/></svg>
            </div>
            <div>
                <strong class="font-bold">Success!</strong>
                <span class="ml-1 font-medium">{{ session('success') }}</span>
            </div>
        </div>
    @endif

    <!-- Attributes Main Workspace Container -->
    <div class="bg-white border border-slate-200/80 rounded-3xl shadow-xs overflow-hidden flex flex-col lg:flex-row min-h-[620px]">
        
        <!-- Left Sidebar Navigation -->
        <div class="w-full lg:w-72 bg-slate-50/70 border-b lg:border-b-0 lg:border-r border-slate-200/80 p-5 flex flex-col justify-between shrink-0 space-y-6">
            <div class="space-y-2">
                <div class="text-[10px] text-slate-400 font-extrabold uppercase tracking-wider px-3 mb-3">Attribute Types</div>
                
                <!-- Tab: Categories -->
                <button type="button" onclick="switchTab('categories')" id="tab-btn-categories" 
                        class="tab-btn w-full flex items-center justify-between p-3 rounded-2xl text-xs font-bold transition text-left bg-white text-[#0A2540] border border-slate-200 shadow-xs">
                    <div class="flex items-center gap-3">
                        <div class="tab-icon-box h-9 w-9 rounded-xl bg-emerald-50 text-emerald-600 flex items-center justify-center shrink-0 transition">
                            <svg class="w-4.5 h-4.5" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="1.75">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M2.25 21h19.5m-18-18v18m10.5-18v18m6-13.5V21M6.75 6.75h.75m-.75 3h.75m-.75 3h.75m3-6h.75m-.75 3h.75m-.75 3h.75M6.75 21v-3.375c0-.621.504-1.125 1.125-1.125h2.25c.621 0 1.125.504 1.125 1.125V21M3 3h12m-.75 4.5H21m-3.75 3.75h.008v.008h-.008v-.008zm0 3h.008v.008h-.008v-.008zm0 3h.008v.008h-.008v-.008z" />
                            </svg>
                        </div>
                        <div>
                            <span class="block leading-tight">Categories</span>
                            <span class="text-[10px] text-slate-400 font-normal">Primary property types</span>
                        </div>
                    </div>
                    <span class="text-[10px] px-2.5 py-1 rounded-lg bg-emerald-50 text-emerald-700 border border-emerald-200/60 font-extrabold">{{ count($categories) }}</span>
                </button>

                <!-- Tab: Specifications -->
                <button type="button" onclick="switchTab('specifications')" id="tab-btn-specifications" 
                        class="tab-btn w-full flex items-center justify-between p-3 rounded-2xl text-xs font-semibold transition text-left text-slate-600 hover:bg-white hover:text-slate-900 border border-transparent">
                    <div class="flex items-center gap-3">
                        <div class="tab-icon-box h-9 w-9 rounded-xl bg-slate-100 text-slate-500 flex items-center justify-center shrink-0 transition">
                            <svg class="w-4.5 h-4.5" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="1.75">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M12 6v12m-3-2.818l.879.659c1.171.879 3.07.879 4.242 0 1.172-.879 1.172-2.303 0-3.182C13.536 12.219 12.768 12 12 12c-.725 0-1.45-.22-2.003-.659-1.106-.879-1.106-2.303 0-3.182s2.9-.879 4.006 0l.415.33M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                        </div>
                        <div>
                            <span class="block leading-tight font-bold">Specifications</span>
                            <span class="text-[10px] text-slate-400 font-normal">Counters (Beds, Baths)</span>
                        </div>
                    </div>
                    <span class="text-[10px] px-2.5 py-1 rounded-lg bg-slate-100 text-slate-600 font-extrabold">{{ count($specifications) }}</span>
                </button>

                <!-- Tab: Key Features -->
                <button type="button" onclick="switchTab('features')" id="tab-btn-features" 
                        class="tab-btn w-full flex items-center justify-between p-3 rounded-2xl text-xs font-semibold transition text-left text-slate-600 hover:bg-white hover:text-slate-900 border border-transparent">
                    <div class="flex items-center gap-3">
                        <div class="tab-icon-box h-9 w-9 rounded-xl bg-slate-100 text-slate-500 flex items-center justify-center shrink-0 transition">
                            <svg class="w-4.5 h-4.5" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="1.75">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75L11.25 15 15 9.75M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                        </div>
                        <div>
                            <span class="block leading-tight font-bold">Key Features</span>
                            <span class="text-[10px] text-slate-400 font-normal">Boolean toggle flags</span>
                        </div>
                    </div>
                    <span class="text-[10px] px-2.5 py-1 rounded-lg bg-slate-100 text-slate-600 font-extrabold">{{ count($features) }}</span>
                </button>

                <!-- Tab: Amenities -->
                <button type="button" onclick="switchTab('amenities')" id="tab-btn-amenities" 
                        class="tab-btn w-full flex items-center justify-between p-3 rounded-2xl text-xs font-semibold transition text-left text-slate-600 hover:bg-white hover:text-slate-900 border border-transparent">
                    <div class="flex items-center gap-3">
                        <div class="tab-icon-box h-9 w-9 rounded-xl bg-slate-100 text-slate-500 flex items-center justify-center shrink-0 transition">
                            <svg class="w-4.5 h-4.5" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="1.75">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M9.813 15.904L9 18.75l-.813-2.846a4.5 4.5 0 00-3.09-3.09L2.25 12l2.846-.813a4.5 4.5 0 003.09-3.09L9 5.25l.813 2.846a4.5 4.5 0 003.09 3.09L15.75 12l-2.846.813a4.5 4.5 0 00-3.09 3.09z" />
                            </svg>
                        </div>
                        <div>
                            <span class="block leading-tight font-bold">Amenities</span>
                            <span class="text-[10px] text-slate-400 font-normal">Multi-select filter tags</span>
                        </div>
                    </div>
                    <span class="text-[10px] px-2.5 py-1 rounded-lg bg-slate-100 text-slate-600 font-extrabold">{{ count($amenities) }}</span>
                </button>
            </div>

            <!-- Taxonomy Helper Hint Card -->
            <div class="bg-gradient-to-br from-slate-900 to-[#0A2540] text-white rounded-2xl p-4 text-xs space-y-1 shadow-md">
                <div class="flex items-center gap-2 text-emerald-400 font-bold">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M11.25 11.25l.041-.02a.75.75 0 011.063.852l-.708 2.836a.75.75 0 001.063.853l.041-.021M21 12a9 9 0 11-18 0 9 9 0 0118 0zm-9-3.75h.008v.008H12V8.25z" />
                    </svg>
                    <span>App Sync Info</span>
                </div>
                <p class="text-[11px] text-slate-300 leading-relaxed">
                    Categories & Amenities created here appear dynamically in mobile search filters, host listing creator, and web explore pages.
                </p>
            </div>
        </div>

        <!-- Right Content & Item Grids Area -->
        <div class="flex-1 p-6 lg:p-10 bg-white overflow-y-auto">

            <!-- ════════════ TAB 1: CATEGORIES ════════════ -->
            <div id="tab-content-categories" class="tab-pane space-y-6">
                
                <!-- Section Header + Add Button -->
                <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 pb-4 border-b border-slate-100">
                    <div>
                        <div class="flex items-center gap-2">
                            <h2 class="text-base font-black text-slate-900 font-heading">Property Categories</h2>
                            <span class="px-2 py-0.5 rounded-md bg-emerald-50 text-emerald-700 border border-emerald-200 text-[10px] font-extrabold uppercase">{{ count($categories) }} Registered</span>
                        </div>
                        <p class="text-xs text-slate-400 mt-0.5">Primary classification types for real estate listings and search exploration.</p>
                    </div>
                    <button type="button" onclick="toggleForm('category-add-form')" 
                            class="px-4 py-2 bg-gradient-to-r from-emerald-600 to-teal-600 hover:from-emerald-500 hover:to-teal-500 text-white text-xs font-bold rounded-xl shadow-md shadow-emerald-600/20 transition flex items-center gap-2 w-max">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2.5"><path stroke-linecap="round" stroke-linejoin="round" d="M12 4v16m8-8H4"/></svg>
                        <span>New Category</span>
                    </button>
                </div>

                <!-- Add Category Modern Card Form -->
                <div id="category-add-form" class="hidden bg-slate-50/80 border border-emerald-200/80 p-6 rounded-2xl max-w-2xl shadow-sm animate-fadeIn">
                    <div class="flex items-center justify-between mb-4 pb-3 border-b border-slate-200">
                        <div class="flex items-center gap-2">
                            <span class="h-2 w-2 rounded-full bg-emerald-500"></span>
                            <h3 class="text-xs font-bold text-slate-900 uppercase tracking-wider">Create New Category</h3>
                        </div>
                        <button type="button" onclick="toggleForm('category-add-form')" class="text-slate-400 hover:text-slate-600 p-1">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
                        </button>
                    </div>

                    <form action="/admin/categories" method="POST" enctype="multipart/form-data" class="m-0 space-y-4">
                        @csrf
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <div class="space-y-1.5">
                                <label class="block text-[11px] font-bold text-slate-700">Category Name <span class="text-rose-500">*</span></label>
                                <input type="text" name="name" required placeholder="e.g. Villa, Penthouse, Duplex"
                                       class="w-full px-3.5 py-2 bg-white border border-slate-200 rounded-xl text-slate-900 text-xs font-semibold focus:outline-none focus:border-emerald-500 focus:ring-2 focus:ring-emerald-500/10 transition shadow-2xs">
                            </div>
                            <div class="space-y-1.5">
                                <label class="block text-[11px] font-bold text-slate-700">Icon Identifier</label>
                                <input type="text" name="icon" placeholder="e.g. apartment, home, gite"
                                       class="w-full px-3.5 py-2 bg-white border border-slate-200 rounded-xl text-slate-900 text-xs font-semibold focus:outline-none focus:border-emerald-500 focus:ring-2 focus:ring-emerald-500/10 transition shadow-2xs">
                            </div>
                        </div>

                        <div class="space-y-1.5">
                            <label class="block text-[11px] font-bold text-slate-700">Cover Thumbnail</label>
                            {!! renderUploadCard('add-cat-img', 'image') !!}
                        </div>

                        <div class="flex items-center justify-end gap-2.5 pt-3 border-t border-slate-200">
                            <button type="button" onclick="toggleForm('category-add-form')" class="px-4 py-2 bg-white hover:bg-slate-100 text-slate-700 text-xs font-bold rounded-xl border border-slate-200 transition">Cancel</button>
                            <button type="submit" class="px-5 py-2 bg-emerald-600 hover:bg-emerald-700 text-white text-xs font-bold rounded-xl shadow-xs transition">Save Category</button>
                        </div>
                    </form>
                </div>

                <!-- Modern Categories Cards Grid -->
                <div class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-3 gap-4">
                    @forelse($categories as $cat)
                        <div class="group relative bg-white border border-slate-200/80 rounded-2xl p-4 shadow-2xs hover:shadow-md hover:border-emerald-300 transition duration-200 flex items-center justify-between gap-3">
                            <div class="flex items-center gap-3.5 overflow-hidden">
                                @if($cat->image)
                                    <div class="h-14 w-14 rounded-xl bg-slate-100 overflow-hidden border border-slate-200 shrink-0 shadow-2xs group-hover:scale-105 transition duration-300">
                                        <img src="{{ $cat->image }}" class="h-full w-full object-cover" alt="{{ $cat->name }}">
                                    </div>
                                @else
                                    <div class="h-14 w-14 rounded-xl bg-gradient-to-tr from-[#0A2540] to-[#0F365E] text-emerald-400 font-black text-sm uppercase flex items-center justify-center shrink-0 border border-slate-800 shadow-2xs">
                                        {{ substr($cat->name, 0, 2) }}
                                    </div>
                                @endif

                                <div class="overflow-hidden">
                                    <h4 class="text-xs font-bold text-slate-900 truncate group-hover:text-emerald-700 transition">{{ $cat->name }}</h4>
                                    <div class="flex items-center gap-1.5 mt-1">
                                        <span class="px-2 py-0.5 rounded-md bg-slate-100 text-slate-600 text-[10px] font-mono border border-slate-200/60 truncate">
                                            {{ $cat->icon ?: 'icon:default' }}
                                        </span>
                                    </div>
                                </div>
                            </div>
                            
                            <!-- Actions -->
                            <div class="flex items-center gap-1 shrink-0">
                                <button type="button" onclick="openEditModal('category', '{{ $cat->id }}', '{{ $cat->name }}', '{{ $cat->icon }}', '{{ $cat->image }}')" 
                                        class="p-2 text-slate-500 hover:text-emerald-700 hover:bg-emerald-50 rounded-xl transition" title="Edit Category">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="1.75">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M16.862 4.487l1.687-1.688a1.875 1.875 0 112.652 2.652L10.582 16.07a4.5 4.5 0 01-1.897 1.13L6 18l.8-2.685a4.5 4.5 0 011.13-1.897l8.932-8.931zm0 0L19.5 7.125M18 14v4.75A2.25 2.25 0 0115.75 21H5.25A2.25 2.25 0 013 18.75V8.25A2.25 2.25 0 015.25 6H10" />
                                    </svg>
                                </button>
                                <form action="/admin/categories/{{ $cat->id }}" method="POST" onsubmit="return confirm('Are you sure you want to delete this category?');" class="m-0 inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="p-2 text-slate-400 hover:text-rose-600 hover:bg-rose-50 rounded-xl transition" title="Delete Category">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="1.75">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M14.74 9l-.346 9m-4.788 0L9.26 9m9.968-3.21c.342.052.682.107 1.022.166m-1.022-.165L18.16 19.673a2.25 2.25 0 01-2.244 2.077H8.084a2.25 2.25 0 01-2.244-2.077L4.772 5.79m14.456 0a48.108 48.108 0 00-3.478-.397m-12 .562c.34-.059.68-.114 1.022-.165m0 0a48.11 48.11 0 013.478-.397m7.5 0v-.916c0-1.18-.91-2.164-2.09-2.201a51.964 51.964 0 00-3.32 0c-1.18.037-2.09 1.022-2.09 2.201v.916m7.5 0a48.667 48.667 0 00-7.5 0" />
                                        </svg>
                                    </button>
                                </form>
                            </div>
                        </div>
                    @empty
                        <div class="col-span-full py-12 text-center text-slate-400">
                            <p class="text-xs font-semibold">No property categories defined yet.</p>
                        </div>
                    @endforelse
                </div>
            </div>

            <!-- ════════════ TAB 2: SPECIFICATIONS ════════════ -->
            <div id="tab-content-specifications" class="tab-pane hidden space-y-6">
                <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 pb-4 border-b border-slate-100">
                    <div>
                        <div class="flex items-center gap-2">
                            <h2 class="text-base font-black text-slate-900 font-heading">Property Specifications</h2>
                            <span class="px-2 py-0.5 rounded-md bg-blue-50 text-blue-700 border border-blue-200 text-[10px] font-extrabold uppercase">{{ count($specifications) }} Specs</span>
                        </div>
                        <p class="text-xs text-slate-400 mt-0.5">Numeric specification counters (e.g. Bedrooms, Bathrooms, Floor Level).</p>
                    </div>
                    <button type="button" onclick="toggleForm('spec-add-form')" 
                            class="px-4 py-2 bg-gradient-to-r from-emerald-600 to-teal-600 hover:from-emerald-500 hover:to-teal-500 text-white text-xs font-bold rounded-xl shadow-md shadow-emerald-600/20 transition flex items-center gap-2 w-max">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2.5"><path stroke-linecap="round" stroke-linejoin="round" d="M12 4v16m8-8H4"/></svg>
                        <span>New Specification</span>
                    </button>
                </div>

                <!-- Add Spec Form -->
                <div id="spec-add-form" class="hidden bg-slate-50/80 border border-emerald-200/80 p-6 rounded-2xl max-w-2xl shadow-sm animate-fadeIn">
                    <form action="/admin/specifications" method="POST" enctype="multipart/form-data" class="m-0 space-y-4">
                        @csrf
                        <div class="space-y-1.5">
                            <label class="block text-[11px] font-bold text-slate-700">Counter Metric Name <span class="text-rose-500">*</span></label>
                            <input type="text" name="name" required placeholder="e.g. Bedrooms, Bathrooms, Kitchens, Balconies"
                                   class="w-full px-3.5 py-2 bg-white border border-slate-200 rounded-xl text-slate-900 text-xs font-semibold focus:outline-none focus:border-emerald-500 focus:ring-2 focus:ring-emerald-500/10 transition shadow-2xs">
                        </div>
                        <div class="space-y-1.5">
                            <label class="block text-[11px] font-bold text-slate-700">Icon Thumbnail</label>
                            {!! renderUploadCard('add-spec-img', 'image') !!}
                        </div>
                        <div class="flex items-center justify-end gap-2.5 pt-3 border-t border-slate-200">
                            <button type="button" onclick="toggleForm('spec-add-form')" class="px-4 py-2 bg-white hover:bg-slate-100 text-slate-700 text-xs font-bold rounded-xl border border-slate-200 transition">Cancel</button>
                            <button type="submit" class="px-5 py-2 bg-emerald-600 hover:bg-emerald-700 text-white text-xs font-bold rounded-xl shadow-xs transition">Save Specification</button>
                        </div>
                    </form>
                </div>

                <!-- Specs Grid List -->
                <div class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-3 gap-4">
                    @forelse($specifications as $spec)
                        <div class="group bg-white border border-slate-200/80 rounded-2xl p-4 shadow-2xs hover:shadow-md hover:border-emerald-300 transition duration-200 flex items-center justify-between gap-3">
                            <div class="flex items-center gap-3.5 overflow-hidden">
                                @if($spec->image)
                                    <div class="h-12 w-12 rounded-xl bg-slate-100 overflow-hidden border border-slate-200 shrink-0">
                                        <img src="{{ $spec->image }}" class="h-full w-full object-cover" alt="{{ $spec->name }}">
                                    </div>
                                @else
                                    <div class="h-12 w-12 rounded-xl bg-blue-50 text-blue-700 font-black text-xs uppercase flex items-center justify-center shrink-0 border border-blue-100">
                                        {{ substr($spec->name, 0, 2) }}
                                    </div>
                                @endif
                                <div>
                                    <h4 class="text-xs font-bold text-slate-900 group-hover:text-emerald-700 transition">{{ $spec->name }}</h4>
                                    <span class="text-[10px] text-slate-400 font-medium">Numeric Counter Metric</span>
                                </div>
                            </div>
                            <div class="flex items-center gap-1 shrink-0">
                                <button type="button" onclick="openEditModal('specification', '{{ $spec->id }}', '{{ $spec->name }}', '', '{{ $spec->image }}')" 
                                        class="p-2 text-slate-500 hover:text-emerald-700 hover:bg-emerald-50 rounded-xl transition" title="Edit Spec">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="1.75">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M16.862 4.487l1.687-1.688a1.875 1.875 0 112.652 2.652L10.582 16.07a4.5 4.5 0 01-1.897 1.13L6 18l.8-2.685a4.5 4.5 0 011.13-1.897l8.932-8.931zm0 0L19.5 7.125M18 14v4.75A2.25 2.25 0 0115.75 21H5.25A2.25 2.25 0 013 18.75V8.25A2.25 2.25 0 015.25 6H10" />
                                    </svg>
                                </button>
                                <form action="/admin/specifications/{{ $spec->id }}" method="POST" onsubmit="return confirm('Are you sure you want to delete this spec counter?');" class="m-0 inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="p-2 text-slate-400 hover:text-rose-600 hover:bg-rose-50 rounded-xl transition" title="Delete Spec">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="1.75">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M14.74 9l-.346 9m-4.788 0L9.26 9m9.968-3.21c.342.052.682.107 1.022.166m-1.022-.165L18.16 19.673a2.25 2.25 0 01-2.244 2.077H8.084a2.25 2.25 0 01-2.244-2.077L4.772 5.79m14.456 0a48.108 48.108 0 00-3.478-.397m-12 .562c.34-.059.68-.114 1.022-.165m0 0a48.11 48.11 0 013.478-.397m7.5 0v-.916c0-1.18-.91-2.164-2.09-2.201a51.964 51.964 0 00-3.32 0c-1.18.037-2.09 1.022-2.09 2.201v.916m7.5 0a48.667 48.667 0 00-7.5 0" />
                                        </svg>
                                    </button>
                                </form>
                            </div>
                        </div>
                    @empty
                        <div class="col-span-full py-12 text-center text-slate-400">
                            <p class="text-xs font-semibold">No specifications registered.</p>
                        </div>
                    @endforelse
                </div>
            </div>

            <!-- ════════════ TAB 3: KEY FEATURES ════════════ -->
            <div id="tab-content-features" class="tab-pane hidden space-y-6">
                <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 pb-4 border-b border-slate-100">
                    <div>
                        <div class="flex items-center gap-2">
                            <h2 class="text-base font-black text-slate-900 font-heading">Key Features & Amenities Flags</h2>
                            <span class="px-2 py-0.5 rounded-md bg-purple-50 text-purple-700 border border-purple-200 text-[10px] font-extrabold uppercase">{{ count($features) }} Features</span>
                        </div>
                        <p class="text-xs text-slate-400 mt-0.5">Boolean toggle switches (yes/no) for furnished status, parking, pet allowance, etc.</p>
                    </div>
                    <button type="button" onclick="toggleForm('feature-add-form')" 
                            class="px-4 py-2 bg-gradient-to-r from-emerald-600 to-teal-600 hover:from-emerald-500 hover:to-teal-500 text-white text-xs font-bold rounded-xl shadow-md shadow-emerald-600/20 transition flex items-center gap-2 w-max">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2.5"><path stroke-linecap="round" stroke-linejoin="round" d="M12 4v16m8-8H4"/></svg>
                        <span>New Feature</span>
                    </button>
                </div>

                <!-- Add Feature Form -->
                <div id="feature-add-form" class="hidden bg-slate-50/80 border border-emerald-200/80 p-6 rounded-2xl max-w-2xl shadow-sm animate-fadeIn">
                    <form action="/admin/key-features" method="POST" enctype="multipart/form-data" class="m-0 space-y-4">
                        @csrf
                        <div class="space-y-1.5">
                            <label class="block text-[11px] font-bold text-slate-700">Feature Label <span class="text-rose-500">*</span></label>
                            <input type="text" name="name" required placeholder="e.g. Allows Pets, Semi Furnished, Covered Parking"
                                   class="w-full px-3.5 py-2 bg-white border border-slate-200 rounded-xl text-slate-900 text-xs font-semibold focus:outline-none focus:border-emerald-500 focus:ring-2 focus:ring-emerald-500/10 transition shadow-2xs">
                        </div>
                        <div class="space-y-1.5">
                            <label class="block text-[11px] font-bold text-slate-700">Icon Thumbnail</label>
                            {!! renderUploadCard('add-feat-img', 'image') !!}
                        </div>
                        <div class="flex items-center justify-end gap-2.5 pt-3 border-t border-slate-200">
                            <button type="button" onclick="toggleForm('feature-add-form')" class="px-4 py-2 bg-white hover:bg-slate-100 text-slate-700 text-xs font-bold rounded-xl border border-slate-200 transition">Cancel</button>
                            <button type="submit" class="px-5 py-2 bg-emerald-600 hover:bg-emerald-700 text-white text-xs font-bold rounded-xl shadow-xs transition">Save Feature</button>
                        </div>
                    </form>
                </div>

                <!-- Features Grid List -->
                <div class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-3 gap-4">
                    @forelse($features as $feat)
                        <div class="group bg-white border border-slate-200/80 rounded-2xl p-4 shadow-2xs hover:shadow-md hover:border-emerald-300 transition duration-200 flex items-center justify-between gap-3">
                            <div class="flex items-center gap-3.5 overflow-hidden">
                                @if($feat->image)
                                    <div class="h-12 w-12 rounded-xl bg-slate-100 overflow-hidden border border-slate-200 shrink-0">
                                        <img src="{{ $feat->image }}" class="h-full w-full object-cover" alt="{{ $feat->name }}">
                                    </div>
                                @else
                                    <div class="h-12 w-12 rounded-xl bg-purple-50 text-purple-700 font-black text-xs uppercase flex items-center justify-center shrink-0 border border-purple-100">
                                        {{ substr($feat->name, 0, 2) }}
                                    </div>
                                @endif
                                <div>
                                    <h4 class="text-xs font-bold text-slate-900 group-hover:text-emerald-700 transition">{{ $feat->name }}</h4>
                                    <span class="text-[10px] text-slate-400 font-medium">Toggle Switch Flag</span>
                                </div>
                            </div>
                            <div class="flex items-center gap-1 shrink-0">
                                <button type="button" onclick="openEditModal('feature', '{{ $feat->id }}', '{{ $feat->name }}', '', '{{ $feat->image }}')" 
                                        class="p-2 text-slate-500 hover:text-emerald-700 hover:bg-emerald-50 rounded-xl transition" title="Edit Feature">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="1.75">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M16.862 4.487l1.687-1.688a1.875 1.875 0 112.652 2.652L10.582 16.07a4.5 4.5 0 01-1.897 1.13L6 18l.8-2.685a4.5 4.5 0 011.13-1.897l8.932-8.931zm0 0L19.5 7.125M18 14v4.75A2.25 2.25 0 0115.75 21H5.25A2.25 2.25 0 013 18.75V8.25A2.25 2.25 0 015.25 6H10" />
                                    </svg>
                                </button>
                                <form action="/admin/key-features/{{ $feat->id }}" method="POST" onsubmit="return confirm('Are you sure you want to delete this feature option?');" class="m-0 inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="p-2 text-slate-400 hover:text-rose-600 hover:bg-rose-50 rounded-xl transition" title="Delete Feature">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="1.75">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M14.74 9l-.346 9m-4.788 0L9.26 9m9.968-3.21c.342.052.682.107 1.022.166m-1.022-.165L18.16 19.673a2.25 2.25 0 01-2.244 2.077H8.084a2.25 2.25 0 01-2.244-2.077L4.772 5.79m14.456 0a48.108 48.108 0 00-3.478-.397m-12 .562c.34-.059.68-.114 1.022-.165m0 0a48.11 48.11 0 013.478-.397m7.5 0v-.916c0-1.18-.91-2.164-2.09-2.201a51.964 51.964 0 00-3.32 0c-1.18.037-2.09 1.022-2.09 2.201v.916m7.5 0a48.667 48.667 0 00-7.5 0" />
                                        </svg>
                                    </button>
                                </form>
                            </div>
                        </div>
                    @empty
                        <div class="col-span-full py-12 text-center text-slate-400">
                            <p class="text-xs font-semibold">No key features registered.</p>
                        </div>
                    @endforelse
                </div>
            </div>

            <!-- ════════════ TAB 4: AMENITIES ════════════ -->
            <div id="tab-content-amenities" class="tab-pane hidden space-y-6">
                <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 pb-4 border-b border-slate-100">
                    <div>
                        <div class="flex items-center gap-2">
                            <h2 class="text-base font-black text-slate-900 font-heading">Amenities & Lifestyle Tags</h2>
                            <span class="px-2 py-0.5 rounded-md bg-amber-50 text-amber-700 border border-amber-200 text-[10px] font-extrabold uppercase">{{ count($amenities) }} Tags</span>
                        </div>
                        <p class="text-xs text-slate-400 mt-0.5">Multi-select searchable amenity tags for user explore filters.</p>
                    </div>
                    <button type="button" onclick="toggleForm('amenity-add-form')" 
                            class="px-4 py-2 bg-gradient-to-r from-emerald-600 to-teal-600 hover:from-emerald-500 hover:to-teal-500 text-white text-xs font-bold rounded-xl shadow-md shadow-emerald-600/20 transition flex items-center gap-2 w-max">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2.5"><path stroke-linecap="round" stroke-linejoin="round" d="M12 4v16m8-8H4"/></svg>
                        <span>New Amenity</span>
                    </button>
                </div>

                <!-- Add Amenity Form -->
                <div id="amenity-add-form" class="hidden bg-slate-50/80 border border-emerald-200/80 p-6 rounded-2xl max-w-2xl shadow-sm animate-fadeIn">
                    <form action="/admin/amenities" method="POST" enctype="multipart/form-data" class="m-0 space-y-4">
                        @csrf
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <div class="space-y-1.5">
                                <label class="block text-[11px] font-bold text-slate-700">Amenity Name <span class="text-rose-500">*</span></label>
                                <input type="text" name="name" required placeholder="e.g. High-speed WiFi, Swimming Pool, Gym"
                                       class="w-full px-3.5 py-2 bg-white border border-slate-200 rounded-xl text-slate-900 text-xs font-semibold focus:outline-none focus:border-emerald-500 focus:ring-2 focus:ring-emerald-500/10 transition shadow-2xs">
                            </div>
                            <div class="space-y-1.5">
                                <label class="block text-[11px] font-bold text-slate-700">Icon Identifier</label>
                                <input type="text" name="icon" placeholder="e.g. wifi, pool, fitness_center"
                                       class="w-full px-3.5 py-2 bg-white border border-slate-200 rounded-xl text-slate-900 text-xs font-semibold focus:outline-none focus:border-emerald-500 focus:ring-2 focus:ring-emerald-500/10 transition shadow-2xs">
                            </div>
                        </div>
                        <div class="space-y-1.5">
                            <label class="block text-[11px] font-bold text-slate-700">Icon Thumbnail</label>
                            {!! renderUploadCard('add-am-img', 'image') !!}
                        </div>
                        <div class="flex items-center justify-end gap-2.5 pt-3 border-t border-slate-200">
                            <button type="button" onclick="toggleForm('amenity-add-form')" class="px-4 py-2 bg-white hover:bg-slate-100 text-slate-700 text-xs font-bold rounded-xl border border-slate-200 transition">Cancel</button>
                            <button type="submit" class="px-5 py-2 bg-emerald-600 hover:bg-emerald-700 text-white text-xs font-bold rounded-xl shadow-xs transition">Save Amenity</button>
                        </div>
                    </form>
                </div>

                <!-- Amenities Grid List -->
                <div class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-3 gap-4">
                    @forelse($amenities as $am)
                        <div class="group bg-white border border-slate-200/80 rounded-2xl p-4 shadow-2xs hover:shadow-md hover:border-emerald-300 transition duration-200 flex items-center justify-between gap-3">
                            <div class="flex items-center gap-3.5 overflow-hidden">
                                @if($am->image)
                                    <div class="h-12 w-12 rounded-xl bg-slate-100 overflow-hidden border border-slate-200 shrink-0">
                                        <img src="{{ $am->image }}" class="h-full w-full object-cover" alt="{{ $am->name }}">
                                    </div>
                                @else
                                    <div class="h-12 w-12 rounded-xl bg-amber-50 text-amber-700 font-black text-xs uppercase flex items-center justify-center shrink-0 border border-amber-100">
                                        {{ substr($am->name, 0, 2) }}
                                    </div>
                                @endif
                                <div class="overflow-hidden">
                                    <h4 class="text-xs font-bold text-slate-900 group-hover:text-emerald-700 transition truncate">{{ $am->name }}</h4>
                                    <span class="px-2 py-0.5 rounded-md bg-slate-100 text-slate-600 text-[10px] font-mono border border-slate-200/60 truncate block w-max mt-0.5">
                                        {{ $am->icon ?: 'tag:amenity' }}
                                    </span>
                                </div>
                            </div>
                            <div class="flex items-center gap-1 shrink-0">
                                <button type="button" onclick="openEditModal('amenity', '{{ $am->id }}', '{{ $am->name }}', '{{ $am->icon }}', '{{ $am->image }}')" 
                                        class="p-2 text-slate-500 hover:text-emerald-700 hover:bg-emerald-50 rounded-xl transition" title="Edit Amenity">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="1.75">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M16.862 4.487l1.687-1.688a1.875 1.875 0 112.652 2.652L10.582 16.07a4.5 4.5 0 01-1.897 1.13L6 18l.8-2.685a4.5 4.5 0 011.13-1.897l8.932-8.931zm0 0L19.5 7.125M18 14v4.75A2.25 2.25 0 0115.75 21H5.25A2.25 2.25 0 013 18.75V8.25A2.25 2.25 0 015.25 6H10" />
                                    </svg>
                                </button>
                                <form action="/admin/amenities/{{ $am->id }}" method="POST" onsubmit="return confirm('Are you sure you want to delete this amenity?');" class="m-0 inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="p-2 text-slate-400 hover:text-rose-600 hover:bg-rose-50 rounded-xl transition" title="Delete Amenity">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="1.75">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M14.74 9l-.346 9m-4.788 0L9.26 9m9.968-3.21c.342.052.682.107 1.022.166m-1.022-.165L18.16 19.673a2.25 2.25 0 01-2.244 2.077H8.084a2.25 2.25 0 01-2.244-2.077L4.772 5.79m14.456 0a48.108 48.108 0 00-3.478-.397m-12 .562c.34-.059.68-.114 1.022-.165m0 0a48.11 48.11 0 013.478-.397m7.5 0v-.916c0-1.18-.91-2.164-2.09-2.201a51.964 51.964 0 00-3.32 0c-1.18.037-2.09 1.022-2.09 2.201v.916m7.5 0a48.667 48.667 0 00-7.5 0" />
                                        </svg>
                                    </button>
                                </form>
                            </div>
                        </div>
                    @empty
                        <div class="col-span-full py-12 text-center text-slate-400">
                            <p class="text-xs font-semibold">No amenities registered.</p>
                        </div>
                    @endforelse
                </div>
            </div>

        </div>
    </div>
</div>

<!-- ════════════ EDIT ATTRIBUTE MODAL ════════════ -->
<div id="edit-attribute-modal" class="fixed inset-0 bg-slate-950/60 backdrop-blur-xs z-50 flex items-center justify-center hidden p-4">
    <div class="bg-white border border-slate-200 rounded-3xl shadow-2xl w-full max-w-md overflow-hidden animate-in fade-in zoom-in duration-150">
        <div class="border-b border-slate-100 px-6 py-5 flex items-center justify-between">
            <div class="flex items-center gap-2.5">
                <div class="h-8 w-8 rounded-xl bg-emerald-50 text-emerald-600 flex items-center justify-center">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M16.862 4.487l1.687-1.688a1.875 1.875 0 112.652 2.652L10.582 16.07a4.5 4.5 0 01-1.897 1.13L6 18l.8-2.685a4.5 4.5 0 011.13-1.897l8.932-8.931zm0 0L19.5 7.125M18 14v4.75A2.25 2.25 0 0115.75 21H5.25A2.25 2.25 0 013 18.75V8.25A2.25 2.25 0 015.25 6H10" />
                    </svg>
                </div>
                <h3 class="text-sm font-bold text-slate-900 font-heading" id="modal-title">Edit Attribute</h3>
            </div>
            <button onclick="closeEditModal()" class="p-1.5 rounded-xl text-slate-400 hover:text-slate-600 hover:bg-slate-100 transition">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
            </button>
        </div>
        
        <form id="edit-attribute-form" method="POST" enctype="multipart/form-data" class="p-6 m-0 space-y-4">
            @csrf
            
            <div class="space-y-1.5">
                <label class="block text-[11px] font-bold text-slate-700">Display Name <span class="text-rose-500">*</span></label>
                <input type="text" name="name" id="modal-input-name" required
                       class="w-full px-3.5 py-2.5 bg-white border border-slate-200 rounded-xl text-slate-900 text-xs font-semibold focus:outline-none focus:border-emerald-500 focus:ring-2 focus:ring-emerald-500/10 transition shadow-2xs">
            </div>
            
            <div class="space-y-1.5" id="modal-icon-group">
                <label class="block text-[11px] font-bold text-slate-700">Icon Identifier</label>
                <input type="text" name="icon" id="modal-input-icon"
                       class="w-full px-3.5 py-2.5 bg-white border border-slate-200 rounded-xl text-slate-900 text-xs font-semibold focus:outline-none focus:border-emerald-500 focus:ring-2 focus:ring-emerald-500/10 transition shadow-2xs">
            </div>

            <!-- Image Section with current thumbnail -->
            <div class="space-y-1.5">
                <label class="block text-[11px] font-bold text-slate-700">Update Cover Image</label>
                <div class="flex items-center gap-3">
                    <div id="modal-preview-current-container" class="h-16 w-16 rounded-2xl bg-slate-100 border border-slate-200 shrink-0 hidden overflow-hidden shadow-2xs">
                        <img src="" id="modal-preview-current-img" class="h-full w-full object-cover">
                    </div>
                    <div class="flex-1">
                        {!! renderUploadCard('modal-upload-img', 'image') !!}
                    </div>
                </div>
            </div>

            <div class="flex items-center justify-end gap-2.5 pt-4 border-t border-slate-100">
                <button type="button" onclick="closeEditModal()" class="px-4 py-2 bg-white hover:bg-slate-100 text-slate-700 text-xs font-bold rounded-xl border border-slate-200 transition">Cancel</button>
                <button type="submit" class="px-5 py-2 bg-gradient-to-r from-emerald-600 to-teal-600 hover:from-emerald-500 hover:to-teal-500 text-white text-xs font-bold rounded-xl shadow-md shadow-emerald-600/20 transition">Save Changes</button>
            </div>
        </form>
    </div>
</div>

@php
/**
 * PHP View Helper to render premium upload cards
 */
function renderUploadCard($id, $name) {
    return '
    <div onclick="document.getElementById(\'input-file-' . $id . '\').click()" 
         class="group relative flex flex-col items-center justify-center border-2 border-dashed border-slate-200 hover:border-emerald-500 rounded-2xl py-4 px-4 bg-slate-50/50 hover:bg-emerald-50/20 cursor-pointer transition">
        
        <input type="file" name="' . $name . '" id="input-file-' . $id . '" accept="image/*" class="hidden" onchange="previewSelectedImage(this, \'' . $id . '\')">
        
        <!-- Preview Cover -->
        <div id="preview-container-' . $id . '" class="absolute inset-0 rounded-2xl overflow-hidden hidden bg-slate-900">
            <img src="" id="preview-img-' . $id . '" class="h-full w-full object-cover opacity-90">
            <div class="absolute inset-0 bg-slate-900/40 opacity-0 group-hover:opacity-100 transition flex items-center justify-center">
                <span class="px-3 py-1 bg-white/95 text-slate-900 font-bold text-[10px] rounded-lg shadow-xs uppercase">Change Photo</span>
            </div>
        </div>

        <!-- Placeholder Icon & Labels -->
        <div id="placeholder-' . $id . '" class="flex flex-col items-center justify-center text-center">
            <div class="h-8 w-8 rounded-xl bg-slate-100 text-slate-400 group-hover:text-emerald-600 group-hover:bg-emerald-50 flex items-center justify-center mb-1 transition">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="1.75">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 16.5V9.75m0 0l3 3m-3-3l-3 3M6.75 19.5a4.5 4.5 0 01-1.41-8.775 5.25 5.25 0 0110.233-2.33 3 3 0 013.758 3.848A3.752 3.752 0 0118 19.5H6.75z" />
                </svg>
            </div>
            <div class="text-xs font-bold text-slate-700">Choose image file</div>
            <p class="text-[10px] text-slate-400">PNG, JPG, WEBP (Max 2MB)</p>
        </div>
    </div>';
}
@endphp

<script>
    function switchTab(tabId) {
        // Hide all tab panes
        document.querySelectorAll('.tab-pane').forEach(p => p.classList.add('hidden'));

        // Reset sidebar button highlights
        document.querySelectorAll('.tab-btn').forEach(btn => {
            btn.classList.remove('bg-white', 'text-[#0A2540]', 'border-slate-200', 'shadow-xs', 'font-bold');
            btn.classList.add('text-slate-600', 'hover:bg-white', 'hover:text-slate-900', 'border-transparent', 'font-semibold');
            
            const iconBox = btn.querySelector('.tab-icon-box');
            if (iconBox) {
                iconBox.classList.remove('bg-emerald-50', 'text-emerald-600');
                iconBox.classList.add('bg-slate-100', 'text-slate-500');
            }
        });

        // Display current pane and highlight current button
        const targetPane = document.getElementById('tab-content-' + tabId);
        if (targetPane) targetPane.classList.remove('hidden');
        
        const activeBtn = document.getElementById('tab-btn-' + tabId);
        if (activeBtn) {
            activeBtn.classList.remove('text-slate-600', 'hover:bg-white', 'hover:text-slate-900', 'border-transparent', 'font-semibold');
            activeBtn.classList.add('bg-white', 'text-[#0A2540]', 'border-slate-200', 'shadow-xs', 'font-bold');
            
            const iconBox = activeBtn.querySelector('.tab-icon-box');
            if (iconBox) {
                iconBox.classList.remove('bg-slate-100', 'text-slate-500');
                iconBox.classList.add('bg-emerald-50', 'text-emerald-600');
            }
        }
    }

    function toggleForm(formId) {
        const form = document.getElementById(formId);
        if (form.classList.contains('hidden')) {
            form.classList.remove('hidden');
            form.scrollIntoView({ behavior: 'smooth', block: 'nearest' });
        } else {
            form.classList.add('hidden');
        }
    }

    /**
     * Image preview utility
     */
    function previewSelectedImage(input, previewId) {
        const file = input.files[0];
        if (file) {
            const reader = new FileReader();
            reader.onload = function(e) {
                document.getElementById('preview-img-' + previewId).src = e.target.result;
                document.getElementById('preview-container-' + previewId).classList.remove('hidden');
                document.getElementById('placeholder-' + previewId).classList.add('hidden');
            }
            reader.readAsDataURL(file);
        }
    }

    function openEditModal(type, id, name, icon = '', image = '') {
        const modal = document.getElementById('edit-attribute-modal');
        const form = document.getElementById('edit-attribute-form');
        const title = document.getElementById('modal-title');
        const inputName = document.getElementById('modal-input-name');
        const inputIcon = document.getElementById('modal-input-icon');
        const iconGroup = document.getElementById('modal-icon-group');

        // Reset any previews inside the modal upload card
        const fileInput = document.getElementById('input-file-modal-upload-img');
        if (fileInput) fileInput.value = '';
        const prevContainer = document.getElementById('preview-container-modal-upload-img');
        if (prevContainer) prevContainer.classList.add('hidden');
        const placeholder = document.getElementById('placeholder-modal-upload-img');
        if (placeholder) placeholder.classList.remove('hidden');

        inputName.value = name;
        
        // Handle current image preview in edit modal
        const currentPreviewContainer = document.getElementById('modal-preview-current-container');
        const currentPreviewImg = document.getElementById('modal-preview-current-img');
        if (image) {
            currentPreviewImg.src = image;
            currentPreviewContainer.classList.remove('hidden');
        } else {
            currentPreviewImg.src = '';
            currentPreviewContainer.classList.add('hidden');
        }

        if (type === 'category' || type === 'amenity') {
            iconGroup.classList.remove('hidden');
            inputIcon.value = icon;
            inputIcon.required = false;
        } else {
            iconGroup.classList.add('hidden');
            inputIcon.value = '';
        }

        // Set action url based on type
        if (type === 'category') {
            form.action = '/admin/categories/' + id;
            title.textContent = 'Edit Category: ' + name;
        } else if (type === 'specification') {
            form.action = '/admin/specifications/' + id;
            title.textContent = 'Edit Specification: ' + name;
        } else if (type === 'feature') {
            form.action = '/admin/key-features/' + id;
            title.textContent = 'Edit Key Feature: ' + name;
        } else if (type === 'amenity') {
            form.action = '/admin/amenities/' + id;
            title.textContent = 'Edit Amenity: ' + name;
        }

        modal.classList.remove('hidden');
    }

    function closeEditModal() {
        document.getElementById('edit-attribute-modal').classList.add('hidden');
    }
</script>
@endsection
