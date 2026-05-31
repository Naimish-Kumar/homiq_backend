@extends('admin.layout')

@section('content')
<div class="space-y-6">
    <!-- Header Area -->
    <div class="flex items-center justify-between pb-5 border-b border-slate-100">
        <div>
            <h1 class="text-xl font-black text-slate-800 tracking-tight">Listing Attributes Management</h1>
            <p class="text-xs font-semibold text-slate-400 mt-1">Configure and organize Categories, Specifications, Key Features, and Amenities on your mobile application with local file uploads and real-time image previews.</p>
        </div>
    </div>

    <!-- Attributes Tab Panel -->
    <div class="bg-white border border-slate-200/60 rounded-2xl shadow-sm overflow-hidden flex flex-col md:flex-row min-h-[580px]">
        
        <!-- Sidebar Navigation Tabs -->
        <div class="w-full md:w-64 bg-slate-50 border-r border-slate-100 p-5 space-y-1.5 flex-shrink-0">
            <div class="text-[9px] text-slate-400 font-extrabold uppercase tracking-widest px-3 mb-2.5">Attribute types</div>
            
            <button onclick="switchTab('categories')" id="tab-btn-categories" 
                    class="tab-btn w-full flex items-center gap-3 px-3.5 py-3 rounded-xl text-xs font-bold transition text-left text-donezoGreen bg-donezoLightGreen/50">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 10h16M4 14h16M4 18h16" />
                </svg>
                Categories
            </button>

            <button onclick="switchTab('specifications')" id="tab-btn-specifications" 
                    class="tab-btn w-full flex items-center gap-3 px-3.5 py-3 rounded-xl text-xs font-bold transition text-left text-slate-500 hover:bg-slate-100 hover:text-slate-700">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 7h6m0 10v-3m-3 3h.01M9 17h.01M9 14h.01M12 14h.01M15 11h.01M12 11h.01M9 11h.01M7 21h10a2 2 0 002-2V5a2 2 0 00-2-2H7a2 2 0 00-2 2v14a2 2 0 002 2z" />
                </svg>
                Specifications
            </button>

            <button onclick="switchTab('features')" id="tab-btn-features" 
                    class="tab-btn w-full flex items-center gap-3 px-3.5 py-3 rounded-xl text-xs font-bold transition text-left text-slate-500 hover:bg-slate-100 hover:text-slate-700">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                </svg>
                Key Features
            </button>

            <button onclick="switchTab('amenities')" id="tab-btn-amenities" 
                    class="tab-btn w-full flex items-center gap-3 px-3.5 py-3 rounded-xl text-xs font-bold transition text-left text-slate-500 hover:bg-slate-100 hover:text-slate-700">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19.428 15.428a2 2 0 00-1.022-.547l-2.387-.477a6 6 0 00-3.86.517l-.318.158a6 6 0 01-3.86.517L6.05 15.21a2 2 0 00-1.806.547M8 4h8l-1 1v5.172a2 2 0 00.586 1.414l5 5c1.26 1.26.367 3.414-1.415 3.414H4.828c-1.782 0-2.674-2.154-1.414-3.414l5-5A2 2 0 009 10.172V5L8 4z" />
                </svg>
                Amenities
            </button>
        </div>

        <!-- Forms & Lists Display Area -->
        <div class="flex-1 p-8">
            
            <!-- ── CATEGORIES TAB CONTENT ── -->
            <div id="tab-content-categories" class="tab-pane space-y-6">
                <div class="flex items-center justify-between border-b border-slate-100 pb-3">
                    <div>
                        <h2 class="text-sm font-extrabold text-[#187053] uppercase tracking-widest">Categories</h2>
                        <p class="text-[10px] font-semibold text-slate-400 mt-0.5">Manage housing and property category types.</p>
                    </div>
                    <button onclick="toggleForm('category-add-form')" class="px-3.5 py-1.5 bg-[#187053] hover:bg-[#12563f] text-white text-[11px] font-extrabold rounded-md shadow-sm transition">
                        + Add Category
                    </button>
                </div>

                <!-- Add Category Form -->
                <div id="category-add-form" class="hidden bg-slate-50 border border-slate-200/50 p-6 rounded-2xl max-w-xl shadow-inner">
                    <form action="/admin/categories" method="POST" enctype="multipart/form-data" class="m-0 space-y-4">
                        @csrf
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <div class="space-y-1.5">
                                <label class="block text-[9px] font-extrabold text-slate-400 uppercase tracking-widest">Category Name</label>
                                <input type="text" name="name" required placeholder="e.g. Villa, Penthouse"
                                       class="w-full px-4 py-2.5 bg-white border border-slate-200/60 rounded-xl text-slate-850 text-xs font-semibold focus:outline-none focus:border-[#187053] transition-colors shadow-sm">
                            </div>
                            <div class="space-y-1.5">
                                <label class="block text-[9px] font-extrabold text-slate-400 uppercase tracking-widest">Icon Identifier</label>
                                <input type="text" name="icon" placeholder="e.g. apartment, home, gite"
                                       class="w-full px-4 py-2.5 bg-white border border-slate-200/60 rounded-xl text-slate-850 text-xs font-semibold focus:outline-none focus:border-[#187053] transition-colors shadow-sm">
                            </div>
                        </div>

                        <!-- Stylized File Upload Button -->
                        <div class="space-y-1.5">
                            <label class="block text-[9px] font-extrabold text-slate-400 uppercase tracking-widest">Upload Cover Image</label>
                            {!! renderUploadCard('add-cat-img', 'image') !!}
                        </div>

                        <div class="flex justify-end gap-2 pt-2">
                            <button type="button" onclick="toggleForm('category-add-form')" class="px-3.5 py-1.5 bg-slate-250 hover:bg-slate-300 text-slate-700 text-[11px] font-bold rounded-xl transition">Cancel</button>
                            <button type="submit" class="px-4 py-1.5 bg-[#187053] hover:bg-[#12563f] text-white text-[11px] font-bold rounded-xl shadow-sm transition">Save Option</button>
                        </div>
                    </form>
                </div>

                <!-- Categories Grid List -->
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4 max-w-3xl">
                    @foreach($categories as $cat)
                        <div class="border border-slate-200/60 rounded-2xl p-4 flex items-center justify-between hover:border-slate-350 transition bg-white shadow-sm hover:shadow transition-all duration-200">
                            <div class="flex items-center gap-3">
                                @if($cat->image)
                                    <div class="h-10 w-12 rounded-xl bg-slate-100 overflow-hidden border border-slate-200/80 flex-shrink-0">
                                        <img src="{{ $cat->image }}" class="h-full w-full object-cover" alt="{{ $cat->name }}">
                                    </div>
                                @else
                                    <div class="p-2.5 bg-emerald-50 text-[#187053] rounded-xl flex items-center justify-center">
                                        <span class="text-xs font-extrabold uppercase">{{ $cat->icon ?? 'home' }}</span>
                                    </div>
                                @endif
                                <div>
                                    <div class="text-xs font-extrabold text-slate-800">{{ $cat->name }}</div>
                                    <div class="text-[9px] text-slate-400 font-bold mt-0.5 uppercase tracking-wide">Icon: {{ $cat->icon ?? 'none' }}</div>
                                </div>
                            </div>
                            
                            <div class="flex items-center gap-1.5">
                                <button onclick="openEditModal('category', '{{ $cat->id }}', '{{ $cat->name }}', '{{ $cat->icon }}', '{{ $cat->image }}')" 
                                        class="px-2.5 py-1.5 text-slate-500 hover:bg-slate-100 hover:text-slate-800 text-[11px] font-extrabold rounded-md transition">
                                    Edit
                                </button>
                                <form action="/admin/categories/{{ $cat->id }}" method="POST" onsubmit="return confirm('Are you sure you want to delete this category?');" class="m-0">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="px-2.5 py-1.5 text-rose-500 hover:bg-rose-50 text-[11px] font-extrabold rounded-md transition">Delete</button>
                                </form>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>

            <!-- ── SPECIFICATIONS TAB CONTENT ── -->
            <div id="tab-content-specifications" class="tab-pane hidden space-y-6">
                <div class="flex items-center justify-between border-b border-slate-100 pb-3">
                    <div>
                        <h2 class="text-sm font-extrabold text-[#187053] uppercase tracking-widest">Specifications</h2>
                        <p class="text-[10px] font-semibold text-slate-400 mt-0.5">Numeric specification counters for listings.</p>
                    </div>
                    <button onclick="toggleForm('spec-add-form')" class="px-3.5 py-1.5 bg-[#187053] hover:bg-[#12563f] text-white text-[11px] font-extrabold rounded-md shadow-sm transition">
                        + Add Spec
                    </button>
                </div>

                <!-- Add Spec Form -->
                <div id="spec-add-form" class="hidden bg-slate-50 border border-slate-200/50 p-6 rounded-2xl max-w-xl shadow-inner">
                    <form action="/admin/specifications" method="POST" enctype="multipart/form-data" class="m-0 space-y-4">
                        @csrf
                        <div class="space-y-1.5">
                            <label class="block text-[9px] font-extrabold text-slate-400 uppercase tracking-widest">Spec Counter Name</label>
                            <input type="text" name="name" required placeholder="e.g. Bedrooms, Bathrooms, Kitchens"
                                   class="w-full px-4 py-2.5 bg-white border border-slate-200/60 rounded-xl text-slate-850 text-xs font-semibold focus:outline-none focus:border-[#187053] transition-colors shadow-sm">
                        </div>
                        <div class="space-y-1.5">
                            <label class="block text-[9px] font-extrabold text-slate-400 uppercase tracking-widest">Upload Icon Image</label>
                            {!! renderUploadCard('add-spec-img', 'image') !!}
                        </div>
                        <div class="flex justify-end gap-2 pt-2">
                            <button type="button" onclick="toggleForm('spec-add-form')" class="px-3.5 py-1.5 bg-slate-250 hover:bg-slate-300 text-slate-700 text-[11px] font-bold rounded-xl transition">Cancel</button>
                            <button type="submit" class="px-4 py-1.5 bg-[#187053] hover:bg-[#12563f] text-white text-[11px] font-bold rounded-xl shadow-sm transition">Save Option</button>
                        </div>
                    </form>
                </div>

                <!-- Specs List -->
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4 max-w-3xl">
                    @foreach($specifications as $spec)
                        <div class="border border-slate-200/60 rounded-2xl p-4 flex items-center justify-between hover:border-slate-350 transition bg-white shadow-sm hover:shadow transition-all duration-200">
                            <div class="flex items-center gap-3">
                                @if($spec->image)
                                    <div class="h-10 w-12 rounded-xl bg-slate-100 overflow-hidden border border-slate-200/80 flex-shrink-0">
                                        <img src="{{ $spec->image }}" class="h-full w-full object-cover" alt="{{ $spec->name }}">
                                    </div>
                                @endif
                                <div class="text-xs font-extrabold text-slate-800">{{ $spec->name }}</div>
                            </div>
                            <div class="flex items-center gap-1.5">
                                <button onclick="openEditModal('specification', '{{ $spec->id }}', '{{ $spec->name }}', '', '{{ $spec->image }}')" 
                                        class="px-2.5 py-1.5 text-slate-500 hover:bg-slate-100 hover:text-slate-800 text-[11px] font-extrabold rounded-md transition">
                                    Edit
                                </button>
                                <form action="/admin/specifications/{{ $spec->id }}" method="POST" onsubmit="return confirm('Are you sure you want to delete this spec counter?');" class="m-0">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="px-2.5 py-1.5 text-rose-500 hover:bg-rose-50 text-[11px] font-extrabold rounded-md transition">Delete</button>
                                </form>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>

            <!-- ── KEY FEATURES TAB CONTENT ── -->
            <div id="tab-content-features" class="tab-pane hidden space-y-6">
                <div class="flex items-center justify-between border-b border-slate-100 pb-3">
                    <div>
                        <h2 class="text-sm font-extrabold text-[#187053] uppercase tracking-widest">Key Features</h2>
                        <p class="text-[10px] font-semibold text-slate-400 mt-0.5">Toggle switch choices (yes/no) for listings.</p>
                    </div>
                    <button onclick="toggleForm('feature-add-form')" class="px-3.5 py-1.5 bg-[#187053] hover:bg-[#12563f] text-white text-[11px] font-extrabold rounded-md shadow-sm transition">
                        + Add Feature
                    </button>
                </div>

                <!-- Add Feature Form -->
                <div id="feature-add-form" class="hidden bg-slate-50 border border-slate-200/50 p-6 rounded-2xl max-w-xl shadow-inner">
                    <form action="/admin/key-features" method="POST" enctype="multipart/form-data" class="m-0 space-y-4">
                        @csrf
                        <div class="space-y-1.5">
                            <label class="block text-[9px] font-extrabold text-slate-400 uppercase tracking-widest">Feature Toggle Name</label>
                            <input type="text" name="name" required placeholder="e.g. Allows Pets, Semi Furnished"
                                   class="w-full px-4 py-2.5 bg-white border border-slate-200/60 rounded-xl text-slate-850 text-xs font-semibold focus:outline-none focus:border-[#187053] transition-colors shadow-sm">
                        </div>
                        <div class="space-y-1.5">
                            <label class="block text-[9px] font-extrabold text-slate-400 uppercase tracking-widest">Upload Icon Image</label>
                            {!! renderUploadCard('add-feat-img', 'image') !!}
                        </div>
                        <div class="flex justify-end gap-2 pt-2">
                            <button type="button" onclick="toggleForm('feature-add-form')" class="px-3.5 py-1.5 bg-slate-250 hover:bg-slate-300 text-slate-700 text-[11px] font-bold rounded-xl transition">Cancel</button>
                            <button type="submit" class="px-4 py-1.5 bg-[#187053] hover:bg-[#12563f] text-white text-[11px] font-bold rounded-xl shadow-sm transition">Save Option</button>
                        </div>
                    </form>
                </div>

                <!-- Features List -->
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4 max-w-3xl">
                    @foreach($features as $feat)
                        <div class="border border-slate-200/60 rounded-2xl p-4 flex items-center justify-between hover:border-slate-350 transition bg-white shadow-sm hover:shadow transition-all duration-200">
                            <div class="flex items-center gap-3">
                                @if($feat->image)
                                    <div class="h-10 w-12 rounded-lg bg-slate-100 overflow-hidden border border-slate-200/80 flex-shrink-0">
                                        <img src="{{ $feat->image }}" class="h-full w-full object-cover" alt="{{ $feat->name }}">
                                    </div>
                                @endif
                                <div class="text-xs font-extrabold text-slate-800">{{ $feat->name }}</div>
                            </div>
                            <div class="flex items-center gap-1.5">
                                <button onclick="openEditModal('feature', '{{ $feat->id }}', '{{ $feat->name }}', '', '{{ $feat->image }}')" 
                                        class="px-2.5 py-1.5 text-slate-500 hover:bg-slate-100 hover:text-slate-800 text-[11px] font-extrabold rounded-md transition">
                                    Edit
                                </button>
                                <form action="/admin/key-features/{{ $feat->id }}" method="POST" onsubmit="return confirm('Are you sure you want to delete this feature option?');" class="m-0">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="px-2.5 py-1.5 text-rose-500 hover:bg-rose-50 text-[11px] font-extrabold rounded-md transition">Delete</button>
                                </form>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>

            <!-- ── AMENITIES TAB CONTENT ── -->
            <div id="tab-content-amenities" class="tab-pane hidden space-y-6">
                <div class="flex items-center justify-between border-b border-slate-100 pb-3">
                    <div>
                        <h2 class="text-sm font-extrabold text-[#187053] uppercase tracking-widest">Amenities</h2>
                        <p class="text-[10px] font-semibold text-slate-400 mt-0.5">Multi-select tag options for property listings.</p>
                    </div>
                    <button onclick="toggleForm('amenity-add-form')" class="px-3.5 py-1.5 bg-[#187053] hover:bg-[#12563f] text-white text-[11px] font-extrabold rounded-md shadow-sm transition">
                        + Add Amenity
                    </button>
                </div>

                <!-- Add Amenity Form -->
                <div id="amenity-add-form" class="hidden bg-slate-50 border border-slate-200/50 p-6 rounded-2xl max-w-xl shadow-inner">
                    <form action="/admin/amenities" method="POST" enctype="multipart/form-data" class="m-0 space-y-4">
                        @csrf
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <div class="space-y-1.5">
                                <label class="block text-[9px] font-extrabold text-slate-400 uppercase tracking-widest">Amenity Tag Name</label>
                                <input type="text" name="name" required placeholder="e.g. WiFi, Air Conditioning, Pool"
                                       class="w-full px-4 py-2.5 bg-white border border-slate-200/60 rounded-xl text-slate-850 text-xs font-semibold focus:outline-none focus:border-[#187053] transition-colors shadow-sm">
                            </div>
                            <div class="space-y-1.5">
                                <label class="block text-[9px] font-extrabold text-slate-400 uppercase tracking-widest">Icon Identifier</label>
                                <input type="text" name="icon" placeholder="e.g. wifi, ac_unit, pool"
                                       class="w-full px-4 py-2.5 bg-white border border-slate-200/60 rounded-xl text-slate-850 text-xs font-semibold focus:outline-none focus:border-[#187053] transition-colors shadow-sm">
                            </div>
                        </div>
                        <div class="space-y-1.5">
                            <label class="block text-[9px] font-extrabold text-slate-400 uppercase tracking-widest">Upload Icon Image</label>
                            {!! renderUploadCard('add-am-img', 'image') !!}
                        </div>
                        <div class="flex justify-end gap-2 pt-2">
                            <button type="button" onclick="toggleForm('amenity-add-form')" class="px-3.5 py-1.5 bg-slate-250 hover:bg-slate-300 text-slate-700 text-[11px] font-bold rounded-xl transition">Cancel</button>
                            <button type="submit" class="px-4 py-1.5 bg-[#187053] hover:bg-[#12563f] text-white text-[11px] font-bold rounded-xl shadow-sm transition">Save Option</button>
                        </div>
                    </form>
                </div>

                <!-- Amenities Grid List -->
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4 max-w-3xl">
                    @foreach($amenities as $am)
                        <div class="border border-slate-200/60 rounded-2xl p-4 flex items-center justify-between hover:border-slate-350 transition bg-white shadow-sm hover:shadow transition-all duration-200">
                            <div class="flex items-center gap-3">
                                @if($am->image)
                                    <div class="h-10 w-12 rounded-lg bg-slate-100 overflow-hidden border border-slate-200/80 flex-shrink-0">
                                        <img src="{{ $am->image }}" class="h-full w-full object-cover" alt="{{ $am->name }}">
                                    </div>
                                @else
                                    <div class="p-2.5 bg-emerald-50 text-[#187053] rounded-xl flex items-center justify-center">
                                        <span class="text-xs font-extrabold uppercase">{{ $am->icon ?? 'done' }}</span>
                                    </div>
                                @endif
                                <div>
                                    <div class="text-xs font-extrabold text-slate-800">{{ $am->name }}</div>
                                    <div class="text-[9px] text-slate-400 font-bold mt-0.5 uppercase tracking-wide">Icon: {{ $am->icon ?? 'none' }}</div>
                                </div>
                            </div>
                            
                            <div class="flex items-center gap-1.5">
                                <button onclick="openEditModal('amenity', '{{ $am->id }}', '{{ $am->name }}', '{{ $am->icon }}', '{{ $am->image }}')" 
                                        class="px-2.5 py-1.5 text-slate-500 hover:bg-slate-100 hover:text-slate-800 text-[11px] font-extrabold rounded-md transition">
                                    Edit
                                </button>
                                <form action="/admin/amenities/{{ $am->id }}" method="POST" onsubmit="return confirm('Are you sure you want to delete this amenity?');" class="m-0">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="px-2.5 py-1.5 text-rose-500 hover:bg-rose-50 text-[11px] font-extrabold rounded-md transition">Delete</button>
                                </form>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>

        </div>
    </div>
</div>

<!-- Edit Attributes Modal -->
<div id="edit-attribute-modal" class="fixed inset-0 bg-slate-900/40 backdrop-blur-sm z-50 flex items-center justify-center hidden">
    <div class="bg-white border border-slate-200 rounded-2xl shadow-xl w-full max-w-md overflow-hidden animate-in fade-in zoom-in duration-200">
        <div class="border-b border-slate-100 px-6 py-4 flex items-center justify-between">
            <h3 class="text-xs font-bold text-slate-800 uppercase tracking-wider" id="modal-title">Edit Attribute</h3>
            <button onclick="closeEditModal()" class="text-slate-400 hover:text-slate-655 text-lg">&times;</button>
        </div>
        
        <form id="edit-attribute-form" method="POST" enctype="multipart/form-data" class="p-6 m-0 space-y-5">
            @csrf
            
            <div class="space-y-1.5">
                <label class="block text-[9px] font-extrabold text-slate-400 uppercase tracking-widest">Name</label>
                <input type="text" name="name" id="modal-input-name" required
                       class="w-full px-4 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-slate-850 text-xs font-semibold focus:outline-none focus:border-[#187053]">
            </div>
            
            <div class="space-y-1.5" id="modal-icon-group">
                <label class="block text-[9px] font-extrabold text-slate-400 uppercase tracking-widest">Icon Identifier</label>
                <input type="text" name="icon" id="modal-input-icon"
                       class="w-full px-4 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-slate-850 text-xs font-semibold focus:outline-none focus:border-[#187053]">
            </div>

            <!-- Edit Upload Section with side-by-side preview -->
            <div class="space-y-2">
                <label class="block text-[9px] font-extrabold text-slate-400 uppercase tracking-widest">Update Image</label>
                <div class="flex items-center gap-4">
                    <div id="modal-preview-current-container" class="h-16 w-16 rounded-xl bg-slate-100 border border-slate-250 flex-shrink-0 hidden overflow-hidden">
                        <img src="" id="modal-preview-current-img" class="h-full w-full object-cover">
                    </div>
                    <div class="flex-1">
                        {!! renderUploadCard('modal-upload-img', 'image') !!}
                    </div>
                </div>
            </div>

            <div class="flex justify-end gap-2 pt-4 border-t border-slate-100">
                <button type="button" onclick="closeEditModal()" class="px-4 py-2 bg-slate-100 hover:bg-slate-200 text-slate-700 text-xs font-bold rounded-xl transition">Cancel</button>
                <button type="submit" class="px-4 py-2 bg-[#187053] hover:bg-[#12563f] text-white text-xs font-bold rounded-xl shadow-sm transition">Save Changes</button>
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
         class="group relative flex flex-col items-center justify-center border-2 border-dashed border-slate-250 hover:border-[#187053] rounded-2xl py-6 px-4 bg-slate-50/50 hover:bg-emerald-50/10 cursor-pointer transition-all duration-200">
        
        <input type="file" name="' . $name . '" id="input-file-' . $id . '" accept="image/*" class="hidden" onchange="previewSelectedImage(this, \'' . $id . '\')">
        
        <!-- Preview Cover -->
        <div id="preview-container-' . $id . '" class="absolute inset-0 rounded-2xl overflow-hidden hidden bg-slate-900">
            <img src="" id="preview-img-' . $id . '" class="h-full w-full object-cover opacity-85">
            <div class="absolute inset-0 bg-slate-950/20 group-hover:bg-slate-950/40 transition flex items-center justify-center">
                <span class="px-3 py-1.5 bg-black/60 text-white font-extrabold text-[10px] rounded-lg tracking-wide uppercase transition opacity-0 group-hover:opacity-100">Change Photo</span>
            </div>
        </div>

        <!-- Placeholder Icon & Labels -->
        <div id="placeholder-' . $id . '" class="flex flex-col items-center justify-center">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8 text-slate-400 group-hover:text-[#187053] transition" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
            </svg>
            <div class="text-[11px] font-extrabold text-slate-600 mt-2">Click to select photo</div>
            <p class="text-[9px] font-semibold text-slate-400 mt-0.5">JPEG, PNG, WEBP, or GIF up to 2MB</p>
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
            btn.classList.remove('text-donezoGreen', 'bg-donezoLightGreen/50');
            btn.classList.add('text-slate-500', 'hover:bg-slate-100', 'hover:text-slate-700');
        });

        // Display current pane and highlight current button
        document.getElementById('tab-content-' + tabId).classList.remove('hidden');
        
        const activeBtn = document.getElementById('tab-btn-' + tabId);
        activeBtn.classList.remove('text-slate-500', 'hover:bg-slate-100', 'hover:text-slate-700');
        activeBtn.classList.add('text-donezoGreen', 'bg-donezoLightGreen/50');
    }

    function toggleForm(formId) {
        const form = document.getElementById(formId);
        if (form.classList.contains('hidden')) {
            form.classList.remove('hidden');
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
        document.getElementById('input-file-modal-upload-img').value = '';
        document.getElementById('preview-container-modal-upload-img').classList.add('hidden');
        document.getElementById('placeholder-modal-upload-img').classList.remove('hidden');

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
            title.textContent = 'Edit Category';
        } else if (type === 'specification') {
            form.action = '/admin/specifications/' + id;
            title.textContent = 'Edit Specification';
        } else if (type === 'feature') {
            form.action = '/admin/key-features/' + id;
            title.textContent = 'Edit Key Feature';
        } else if (type === 'amenity') {
            form.action = '/admin/amenities/' + id;
            title.textContent = 'Edit Amenity';
        }

        modal.classList.remove('hidden');
    }

    function closeEditModal() {
        document.getElementById('edit-attribute-modal').classList.add('hidden');
    }
</script>
@endsection
