@extends('admin.layout')

@section('page_title', 'Listing Moderation')

@section('content')
<!-- Header & Filter Grid -->
<div class="mb-6 flex flex-col md:flex-row md:items-center justify-between gap-4">
    <!-- Filter status pills with live counts -->
    <div class="flex flex-wrap bg-white p-1.5 rounded-2xl border border-slate-200/80 shadow-2xs gap-1">
        <a href="/admin/properties" class="px-4 py-2 rounded-xl text-xs font-bold transition flex items-center gap-2 {{ is_null($status) ? 'bg-[#0A2540] text-white shadow-xs' : 'text-slate-600 hover:text-slate-900 hover:bg-slate-50' }}">
            <span>All Spaces</span>
            <span class="px-1.5 py-0.2 rounded-md text-[10px] font-extrabold {{ is_null($status) ? 'bg-white/20 text-white' : 'bg-slate-100 text-slate-500' }}">
                {{ $properties->count() }}
            </span>
        </a>
        <a href="/admin/properties?status=pending" class="px-4 py-2 rounded-xl text-xs font-bold transition flex items-center gap-2 {{ $status === 'pending' ? 'bg-amber-500 text-white shadow-xs' : 'text-slate-600 hover:text-slate-900 hover:bg-slate-50' }}">
            <span>Pending Review</span>
            @php $pendingCount = $properties->where('status', 'pending')->count(); @endphp
            @if($pendingCount > 0)
                <span class="px-1.5 py-0.2 rounded-md text-[10px] font-extrabold {{ $status === 'pending' ? 'bg-white/20 text-white' : 'bg-amber-100 text-amber-700' }}">
                    {{ $pendingCount }}
                </span>
            @endif
        </a>
        <a href="/admin/properties?status=approved" class="px-4 py-2 rounded-xl text-xs font-bold transition flex items-center gap-2 {{ $status === 'approved' ? 'bg-emerald-600 text-white shadow-xs' : 'text-slate-600 hover:text-slate-900 hover:bg-slate-50' }}">
            <span>Approved & Live</span>
        </a>
        <a href="/admin/properties?status=rejected" class="px-4 py-2 rounded-xl text-xs font-bold transition flex items-center gap-2 {{ $status === 'rejected' ? 'bg-rose-600 text-white shadow-xs' : 'text-slate-600 hover:text-slate-900 hover:bg-slate-50' }}">
            <span>Rejected</span>
        </a>
    </div>

    <!-- Search Input -->
    <div class="w-full md:w-80 relative">
        <span class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none text-slate-400">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
            </svg>
        </span>
        <input type="text" id="propertySearchInput" onkeyup="filterProperties()" placeholder="Search title, owner, address, category..." 
               class="w-full pl-10 pr-4 py-2.5 text-xs font-medium rounded-xl border border-slate-200/80 bg-white text-slate-800 placeholder-slate-400 focus:outline-none focus:border-emerald-500 focus:ring-2 focus:ring-emerald-500/20 transition shadow-2xs">
    </div>
</div>

<!-- Listings Table Card -->
@if ($properties->isEmpty())
    <div class="bg-white rounded-2xl border border-slate-200/80 p-16 text-center text-slate-400 font-semibold shadow-xs">
        <div class="h-16 w-16 bg-slate-50 border border-slate-100 rounded-full flex items-center justify-center mx-auto text-slate-300 mb-4">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4" />
            </svg>
        </div>
        <h3 class="text-slate-800 font-extrabold text-sm">No properties found</h3>
        <p class="text-xs text-slate-400 mt-1">There are no listing submissions matching this filter.</p>
    </div>
@else
    <div class="bg-white rounded-2xl border border-slate-200/80 shadow-xs overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-left text-xs border-collapse">
                <thead>
                    <tr class="text-slate-400 font-bold border-b border-slate-100 bg-slate-50/60 uppercase text-[10px] tracking-wider">
                        <th class="p-4 pl-5 w-10">
                            <input type="checkbox" id="selectAllCheckbox" onchange="toggleSelectAll(this)" 
                                   class="h-4 w-4 rounded border-slate-300 text-emerald-600 focus:ring-emerald-500 focus:ring-offset-0 cursor-pointer">
                        </th>
                        <th class="p-4">Property Overview</th>
                        <th class="p-4">Category</th>
                        <th class="p-4">Owner / Host</th>
                        <th class="p-4">Rate & Pricing</th>
                        <th class="p-4">Moderation Status</th>
                        <th class="p-4 pr-6 text-right">Moderation Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100" id="propertyTableBody">
                    @foreach ($properties as $property)
                        @php
                            $primaryImage = !empty($property->images) && is_array($property->images) ? $property->images[0] : 'https://images.unsplash.com/photo-1564013799919-ab600027ffc6?auto=format&fit=crop&w=400&q=80';
                        @endphp
                        <tr class="text-slate-700 font-medium hover:bg-slate-50/60 transition property-row"
                            id="property-row-{{ $property->id }}"
                            data-id="{{ $property->id }}"
                            data-title="{{ $property->title }}" 
                            data-address="{{ $property->address }}"
                            data-category="{{ $property->category }}"
                            data-owner="{{ $property->owner->name }}"
                            data-status="{{ $property->status }}">
                            
                            <!-- Selection Checkbox -->
                            <td class="p-4 pl-5">
                                <input type="checkbox" value="{{ $property->id }}" onchange="handleRowSelect()" 
                                       class="property-checkbox h-4 w-4 rounded border-slate-300 text-emerald-600 focus:ring-emerald-500 focus:ring-offset-0 cursor-pointer">
                            </td>

                            <!-- Property Details with Image Preview -->
                            <td class="p-4">
                                <div class="flex items-center gap-3.5">
                                    <div class="relative h-13 w-16 bg-slate-100 rounded-xl overflow-hidden flex-shrink-0 border border-slate-200/80 shadow-2xs group cursor-pointer"
                                         onclick="openLightbox('{{ $primaryImage }}', '{{ addslashes($property->title) }}')">
                                        <img src="{{ $primaryImage }}" alt="property" class="h-full w-full object-cover group-hover:scale-110 transition duration-300">
                                        <div class="absolute inset-0 bg-black/20 opacity-0 group-hover:opacity-100 transition flex items-center justify-center text-white">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0zM10 7v6m3-3H7" />
                                            </svg>
                                        </div>
                                    </div>
                                    <div class="overflow-hidden">
                                        <div class="font-extrabold text-slate-900 text-xs truncate max-w-xs flex items-center gap-1.5">
                                            <span>{{ $property->title }}</span>
                                            @if($property->is_featured)
                                                <span class="text-amber-500" title="Featured Listing">★</span>
                                            @endif
                                        </div>
                                        <span class="text-[10px] text-slate-400 font-medium block truncate max-w-xs mt-0.5">{{ $property->address }}</span>
                                        <span class="text-[9px] text-slate-400 font-semibold block mt-0.5">ID: #{{ $property->id }} • Added {{ $property->created_at ? $property->created_at->diffForHumans() : 'Recently' }}</span>
                                    </div>
                                </div>
                            </td>

                            <!-- Category -->
                            <td class="p-4">
                                <span class="px-2.5 py-1 bg-slate-100 text-slate-700 rounded-lg font-extrabold text-[10px] uppercase tracking-wider block w-max border border-slate-200">
                                    {{ $property->category }}
                                </span>
                            </td>

                            <!-- Owner -->
                            <td class="p-4">
                                <div class="font-bold text-slate-800 text-xs">{{ $property->owner->name }}</div>
                                <span class="text-[10px] text-slate-400 block mt-0.5">{{ $property->owner->email }}</span>
                            </td>

                            <!-- Rate -->
                            <td class="p-4 font-black text-slate-900 text-sm whitespace-nowrap">
                                {{ $property->currency_symbol }}{{ number_format($property->price, 2) }}{{ $property->billing_frequency_suffix }}
                            </td>

                            <!-- Current Status Pill -->
                            <td class="p-4">
                                @if ($property->status == 'approved')
                                    <span class="inline-flex items-center gap-1.5 px-3 py-1 bg-emerald-50 text-emerald-700 rounded-full font-extrabold text-[10px] uppercase border border-emerald-200">
                                        <span class="h-1.5 w-1.5 rounded-full bg-emerald-500"></span> Approved
                                    </span>
                                @elseif ($property->status == 'pending')
                                    <span class="inline-flex items-center gap-1.5 px-3 py-1 bg-amber-50 text-amber-800 rounded-full font-extrabold text-[10px] uppercase border border-amber-200 animate-pulse">
                                        <span class="h-1.5 w-1.5 rounded-full bg-amber-500"></span> Pending Review
                                    </span>
                                @else
                                    <span class="inline-flex items-center gap-1.5 px-3 py-1 bg-rose-50 text-rose-700 rounded-full font-extrabold text-[10px] uppercase border border-rose-200">
                                        <span class="h-1.5 w-1.5 rounded-full bg-rose-500"></span> Rejected
                                    </span>
                                @endif
                            </td>

                            <!-- Actions & Moderation -->
                            <td class="p-4 pr-6 text-right">
                                <div class="flex gap-1.5 justify-end items-center">
                                    
                                    <!-- 1-Click Approve (if not approved) -->
                                    @if ($property->status !== 'approved')
                                        <form action="/admin/properties/{{ $property->id }}/status" method="POST" class="m-0 inline">
                                            @csrf
                                            <input type="hidden" name="status" value="approved">
                                            <button type="submit" class="p-2 bg-emerald-50 hover:bg-emerald-600 text-emerald-700 hover:text-white rounded-xl border border-emerald-200 transition shadow-2xs" title="Approve Listing">
                                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7" />
                                                </svg>
                                            </button>
                                        </form>
                                    @endif
                                    
                                    <!-- Reject with Reason Modal (if not rejected) -->
                                    @if ($property->status !== 'rejected')
                                        <button type="button" 
                                                onclick="openRejectionModal([{{ $property->id }}], '{{ addslashes($property->title) }}')"
                                                class="p-2 bg-rose-50 hover:bg-rose-600 text-rose-700 hover:text-white rounded-xl border border-rose-200 transition shadow-2xs" 
                                                title="Reject with Reason">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M6 18L18 6M6 6l12 12" />
                                            </svg>
                                        </button>
                                    @endif

                                    <!-- Toggle Featured -->
                                    <form action="/admin/properties/{{ $property->id }}/toggle-featured" method="POST" class="m-0 inline">
                                        @csrf
                                        @if ($property->is_featured)
                                            <button type="submit" class="p-2 bg-amber-500 hover:bg-amber-600 text-white rounded-xl transition shadow-2xs" title="Remove from Featured">
                                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 fill-current" viewBox="0 0 24 24">
                                                    <path d="M12 17.27L18.18 21l-1.64-7.03L22 9.24l-7.19-.61L12 2 9.19 8.63 2 9.24l5.46 4.73L5.82 21z"/>
                                                </svg>
                                            </button>
                                        @else
                                            <button type="submit" class="p-2 bg-slate-50 hover:bg-slate-100 text-slate-400 hover:text-amber-500 rounded-xl border border-slate-200 transition shadow-2xs" title="Make Featured">
                                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 stroke-current fill-none" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" viewBox="0 0 24 24">
                                                    <polygon points="12 2 15.09 8.26 22 9.27 17 14.14 18.18 21.02 12 17.77 5.82 21.02 7 14.14 2 9.27 8.91 8.26 12 2"/>
                                                </svg>
                                            </button>
                                        @endif
                                    </form>

                                    <!-- View Details Page -->
                                    <a href="/admin/properties/{{ $property->id }}" 
                                       class="p-2 bg-slate-50 hover:bg-slate-100 text-slate-600 rounded-xl border border-slate-200 transition shadow-2xs" title="View Full Property Details">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                        </svg>
                                    </a>

                                    <!-- Edit Details Page -->
                                    <a href="/admin/properties/{{ $property->id }}/edit" 
                                       class="p-2 bg-slate-50 hover:bg-slate-100 text-slate-600 rounded-xl border border-slate-200 transition shadow-2xs" title="Edit Listing">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                                        </svg>
                                    </a>

                                    <!-- Delete Property Form -->
                                    <form action="/admin/properties/{{ $property->id }}" method="POST" class="m-0 inline" onsubmit="return confirm('Are you sure you want to permanently delete this property listing? This will also remove associated bookings.')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="p-2 bg-rose-50 hover:bg-rose-100 text-rose-600 border border-rose-200 rounded-xl transition shadow-2xs" title="Delete Listing">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                            </svg>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
@endif

<!-- Floating Sticky Bulk Actions Bar (slides up when properties are selected) -->
<div id="bulkActionsBar" class="fixed bottom-6 left-1/2 -translate-x-1/2 bg-[#0A2540] text-white border border-slate-700 shadow-2xl rounded-2xl p-4 px-6 z-40 flex items-center gap-4 transition-all duration-300 translate-y-32 opacity-0 pointer-events-none max-w-2xl w-full mx-auto">
    <div class="flex items-center gap-2">
        <span id="selectedCountBadge" class="h-7 w-7 rounded-xl bg-emerald-500 text-slate-950 font-black text-xs flex items-center justify-center shadow-xs">
            0
        </span>
        <span class="text-xs font-bold text-slate-200">Selected</span>
    </div>

    <div class="h-6 w-px bg-slate-700"></div>

    <!-- Bulk Action Buttons -->
    <div class="flex items-center gap-2 flex-1 justify-end flex-wrap">
        
        <!-- Bulk Approve Form -->
        <form action="/admin/properties/bulk-status" method="POST" id="bulkApproveForm" class="m-0">
            @csrf
            <input type="hidden" name="action" value="approve">
            <div class="bulk-property-ids-container"></div>
            <button type="submit" class="px-4 py-2 bg-emerald-600 hover:bg-emerald-500 text-white rounded-xl text-xs font-bold transition shadow-sm flex items-center gap-1.5">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7" />
                </svg>
                <span>Approve All</span>
            </button>
        </form>

        <!-- Bulk Reject (Triggers Rejection Modal) -->
        <button type="button" onclick="openBulkRejectionModal()" class="px-4 py-2 bg-rose-600 hover:bg-rose-500 text-white rounded-xl text-xs font-bold transition shadow-sm flex items-center gap-1.5">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M6 18L18 6M6 6l12 12" />
            </svg>
            <span>Reject All</span>
        </button>

        <!-- Bulk Feature -->
        <form action="/admin/properties/bulk-status" method="POST" id="bulkFeatureForm" class="m-0">
            @csrf
            <input type="hidden" name="action" value="feature">
            <div class="bulk-property-ids-container"></div>
            <button type="submit" class="px-3.5 py-2 bg-slate-800 hover:bg-slate-700 text-amber-400 rounded-xl text-xs font-bold transition border border-slate-700" title="Feature Selected">
                ★ Feature
            </button>
        </form>

        <!-- Bulk Delete -->
        <form action="/admin/properties/bulk-status" method="POST" id="bulkDeleteForm" class="m-0" onsubmit="return confirm('Permanently delete all selected properties? This action cannot be undone.')">
            @csrf
            <input type="hidden" name="action" value="delete">
            <div class="bulk-property-ids-container"></div>
            <button type="submit" class="p-2 bg-slate-800 hover:bg-rose-900/60 text-slate-300 hover:text-rose-400 rounded-xl border border-slate-700 transition" title="Delete Selected">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                </svg>
            </button>
        </form>

        <!-- Deselect All -->
        <button type="button" onclick="deselectAll()" class="text-xs text-slate-400 hover:text-white px-2 py-1 transition font-medium">
            Clear
        </button>
    </div>
</div>

<!-- Rejection Reason Modal (for Single & Bulk Property Rejection) -->
<div id="rejectionModal" class="fixed inset-0 bg-slate-900/60 backdrop-blur-sm z-50 flex items-center justify-center hidden opacity-0 transition-opacity duration-300" onclick="closeRejectionModalOutside(event)">
    <div class="bg-white rounded-3xl border border-slate-200/80 p-6 md:p-8 w-full max-w-lg shadow-2xl scale-95 transition-transform duration-300 overflow-hidden" id="rejectionModalContent">
        
        <form action="/admin/properties/bulk-status" method="POST" id="rejectionForm" class="space-y-5 m-0">
            @csrf
            <input type="hidden" name="action" value="reject" id="rejectFormAction">
            <div id="rejectionFormIdsContainer"></div>

            <!-- Header -->
            <div class="flex items-start justify-between border-b border-slate-100 pb-4">
                <div>
                    <div class="flex items-center gap-2">
                        <span class="h-2 w-2 rounded-full bg-rose-500"></span>
                        <h3 class="text-base font-extrabold text-slate-900" id="rejectionModalHeading">Reject Property Listing</h3>
                    </div>
                    <p class="text-xs text-slate-500 mt-1" id="rejectionModalSubheading">Specify why this listing was not approved so the host can fix and resubmit.</p>
                </div>
                <button type="button" onclick="closeRejectionModal()" class="text-slate-400 hover:text-slate-800 p-1.5 rounded-xl hover:bg-slate-100 transition">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>

            <!-- Quick Preset Reason Pills -->
            <div class="space-y-2">
                <label class="block text-[11px] font-bold text-slate-700 uppercase tracking-wider">Primary Rejection Reason</label>
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-2" id="presetReasonsList">
                    <button type="button" onclick="selectReason('Low quality, blurry, or insufficient photos')" 
                            class="reason-pill p-2.5 bg-slate-50 hover:bg-rose-50 text-slate-700 hover:text-rose-700 border border-slate-200 rounded-xl text-xs font-semibold transition text-left">
                        📷 Poor/Blurry Photos
                    </button>
                    <button type="button" onclick="selectReason('Inaccurate or suspicious price/deposit terms')" 
                            class="reason-pill p-2.5 bg-slate-50 hover:bg-rose-50 text-slate-700 hover:text-rose-700 border border-slate-200 rounded-xl text-xs font-semibold transition text-left">
                        💰 Suspicious Price/Terms
                    </button>
                    <button type="button" onclick="selectReason('Incomplete or misleading address details')" 
                            class="reason-pill p-2.5 bg-slate-50 hover:bg-rose-50 text-slate-700 hover:text-rose-700 border border-slate-200 rounded-xl text-xs font-semibold transition text-left">
                        📍 Missing/Vague Address
                    </button>
                    <button type="button" onclick="selectReason('Inadequate property description/specifications')" 
                            class="reason-pill p-2.5 bg-slate-50 hover:bg-rose-50 text-slate-700 hover:text-rose-700 border border-slate-200 rounded-xl text-xs font-semibold transition text-left">
                        📝 Incomplete Specs/Desc
                    </button>
                    <button type="button" onclick="selectReason('Suspected duplicate or unauthorized listing')" 
                            class="reason-pill p-2.5 bg-slate-50 hover:bg-rose-50 text-slate-700 hover:text-rose-700 border border-slate-200 rounded-xl text-xs font-semibold transition text-left">
                        🚫 Duplicate/Unauthorized
                    </button>
                    <button type="button" onclick="selectReason('Custom issue (see feedback notes below)')" 
                            class="reason-pill p-2.5 bg-slate-50 hover:bg-rose-50 text-slate-700 hover:text-rose-700 border border-slate-200 rounded-xl text-xs font-semibold transition text-left">
                        ✏️ Custom Reason
                    </button>
                </div>
                <input type="hidden" name="rejection_reason" id="selectedRejectionReasonInput" value="Low quality, blurry, or insufficient photos">
            </div>

            <!-- Custom Host Feedback Notes -->
            <div class="space-y-1.5">
                <label class="block text-[11px] font-bold text-slate-700 uppercase tracking-wider">Host Guidance / Actionable Notes</label>
                <textarea name="rejection_notes" id="rejectionNotesTextarea" rows="3" placeholder="Explain what the host needs to change to get their listing approved..."
                          class="w-full px-4 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-slate-800 text-xs font-medium focus:outline-none focus:border-rose-500 focus:ring-2 focus:ring-rose-500/20 transition resize-none"></textarea>
            </div>

            <!-- Notify Host Checkbox -->
            <div class="p-3 bg-slate-50 border border-slate-200/80 rounded-xl flex items-center justify-between">
                <div class="flex items-center gap-2.5">
                    <input type="checkbox" name="notify_owner" id="notifyOwnerCheckbox" value="1" checked 
                           class="h-4 w-4 rounded border-slate-300 text-emerald-600 focus:ring-emerald-500 focus:ring-offset-0 cursor-pointer">
                    <label for="notifyOwnerCheckbox" class="text-xs font-bold text-slate-700 cursor-pointer">
                        Send Email & Push Notification to Host
                    </label>
                </div>
                <span class="text-[10px] text-slate-400 font-semibold">Recommended</span>
            </div>

            <!-- Modal Action Buttons -->
            <div class="flex items-center justify-end gap-3 pt-2">
                <button type="button" onclick="closeRejectionModal()" class="px-5 py-2.5 bg-slate-100 hover:bg-slate-200 text-slate-700 text-xs font-bold rounded-xl transition">
                    Cancel
                </button>
                <button type="submit" class="px-6 py-2.5 bg-gradient-to-r from-rose-600 to-rose-700 hover:from-rose-500 hover:to-rose-600 text-white text-xs font-bold rounded-xl shadow-md shadow-rose-600/25 transition flex items-center gap-2">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
                    </svg>
                    <span>Confirm Rejection</span>
                </button>
            </div>
        </form>
    </div>
</div>

<!-- Image Lightbox Modal -->
<div id="imageLightboxModal" class="fixed inset-0 bg-slate-950/80 backdrop-blur-md z-50 flex items-center justify-center hidden opacity-0 transition-opacity duration-300" onclick="closeLightbox()">
    <div class="max-w-4xl max-h-[85vh] p-4 flex flex-col items-center" onclick="event.stopPropagation()">
        <img id="lightboxImage" src="" alt="preview" class="max-h-[75vh] w-auto rounded-2xl shadow-2xl object-contain border border-white/10">
        <p id="lightboxCaption" class="text-sm font-bold text-white mt-3 text-center"></p>
    </div>
</div>

<script>
    // --- Local Live Filter ---
    function filterProperties() {
        const query = document.getElementById('propertySearchInput').value.toLowerCase();
        const rows = document.querySelectorAll('.property-row');
        rows.forEach(row => {
            const title = row.getAttribute('data-title').toLowerCase();
            const address = row.getAttribute('data-address').toLowerCase();
            const category = row.getAttribute('data-category').toLowerCase();
            const owner = row.getAttribute('data-owner').toLowerCase();
            
            if (title.includes(query) || address.includes(query) || category.includes(query) || owner.includes(query)) {
                row.style.display = '';
            } else {
                row.style.display = 'none';
            }
        });
    }

    // --- Bulk Selection Engine ---
    function handleRowSelect() {
        const checkboxes = document.querySelectorAll('.property-checkbox:checked');
        const count = checkboxes.length;
        const bar = document.getElementById('bulkActionsBar');
        const badge = document.getElementById('selectedCountBadge');

        if (count > 0) {
            badge.textContent = count;
            bar.classList.remove('translate-y-32', 'opacity-0', 'pointer-events-none');
        } else {
            bar.classList.add('translate-y-32', 'opacity-0', 'pointer-events-none');
        }

        // Sync hidden ID inputs across bulk action forms
        syncBulkFormIds();
    }

    function toggleSelectAll(masterCheckbox) {
        const visibleCheckboxes = document.querySelectorAll('.property-row:not([style*="display: none"]) .property-checkbox');
        visibleCheckboxes.forEach(cb => cb.checked = masterCheckbox.checked);
        handleRowSelect();
    }

    function deselectAll() {
        document.querySelectorAll('.property-checkbox').forEach(cb => cb.checked = false);
        const selectAll = document.getElementById('selectAllCheckbox');
        if (selectAll) selectAll.checked = false;
        handleRowSelect();
    }

    function syncBulkFormIds() {
        const selectedIds = Array.from(document.querySelectorAll('.property-checkbox:checked')).map(cb => cb.value);
        const containers = document.querySelectorAll('.bulk-property-ids-container');
        
        containers.forEach(container => {
            container.innerHTML = '';
            selectedIds.forEach(id => {
                const input = document.createElement('input');
                input.type = 'hidden';
                input.name = 'property_ids[]';
                input.value = id;
                container.appendChild(input);
            });
        });
    }

    // --- Rejection Modal Engine ---
    function selectReason(reasonText) {
        document.getElementById('selectedRejectionReasonInput').value = reasonText;
        document.querySelectorAll('.reason-pill').forEach(pill => {
            if (pill.textContent.includes(reasonText.substring(0, 10))) {
                pill.classList.add('bg-rose-50', 'text-rose-700', 'border-rose-300', 'ring-2', 'ring-rose-500/20');
                pill.classList.remove('bg-slate-50', 'text-slate-700', 'border-slate-200');
            } else {
                pill.classList.remove('bg-rose-50', 'text-rose-700', 'border-rose-300', 'ring-2', 'ring-rose-500/20');
                pill.classList.add('bg-slate-50', 'text-slate-700', 'border-slate-200');
            }
        });
    }

    function openRejectionModal(propertyIds, propertyTitle = null) {
        const modal = document.getElementById('rejectionModal');
        const content = document.getElementById('rejectionModalContent');
        const heading = document.getElementById('rejectionModalHeading');
        const subheading = document.getElementById('rejectionModalSubheading');
        const container = document.getElementById('rejectionFormIdsContainer');

        container.innerHTML = '';
        propertyIds.forEach(id => {
            const input = document.createElement('input');
            input.type = 'hidden';
            input.name = 'property_ids[]';
            input.value = id;
            container.appendChild(input);
        });

        if (propertyIds.length === 1 && propertyTitle) {
            heading.textContent = `Reject Listing: ${propertyTitle}`;
            subheading.textContent = `Provide feedback for the host to correct and resubmit listing #${propertyIds[0]}.`;
        } else {
            heading.textContent = `Bulk Reject (${propertyIds.length} Listings)`;
            subheading.textContent = `All ${propertyIds.length} selected listings will be marked as rejected with this feedback.`;
        }

        // Reset default reason selection
        selectReason('Low quality, blurry, or insufficient photos');

        modal.classList.remove('hidden');
        setTimeout(() => {
            modal.classList.remove('opacity-0');
            content.classList.remove('scale-95');
        }, 10);
    }

    function openBulkRejectionModal() {
        const selectedIds = Array.from(document.querySelectorAll('.property-checkbox:checked')).map(cb => cb.value);
        if (selectedIds.length === 0) return;
        openRejectionModal(selectedIds);
    }

    function closeRejectionModal() {
        const modal = document.getElementById('rejectionModal');
        const content = document.getElementById('rejectionModalContent');

        content.classList.add('scale-95');
        modal.classList.add('opacity-0');
        setTimeout(() => {
            modal.classList.add('hidden');
        }, 300);
    }

    function closeRejectionModalOutside(event) {
        if (event.target.id === 'rejectionModal') {
            closeRejectionModal();
        }
    }

    // --- Image Lightbox ---
    function openLightbox(url, title) {
        const modal = document.getElementById('imageLightboxModal');
        const img = document.getElementById('lightboxImage');
        const caption = document.getElementById('lightboxCaption');
        
        img.src = url;
        caption.textContent = title;

        modal.classList.remove('hidden');
        setTimeout(() => {
            modal.classList.remove('opacity-0');
        }, 10);
    }

    function closeLightbox() {
        const modal = document.getElementById('imageLightboxModal');
        modal.classList.add('opacity-0');
        setTimeout(() => {
            modal.classList.add('hidden');
        }, 300);
    }
</script>
@endsection
