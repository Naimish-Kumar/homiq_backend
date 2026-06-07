@extends('admin.layout')

@section('page_title', 'Listing Moderation')

@section('content')
<!-- Filter & Search Bar Grid -->
<div class="mb-6 flex flex-col md:flex-row md:items-center justify-between gap-4 relative z-10">
    <!-- Filter status pills -->
    <div class="flex flex-wrap bg-slate-100/80 p-1.5 rounded-xl border border-slate-200/50 w-max gap-1">
        <a href="/admin/properties" class="px-4 py-2 rounded-lg text-xs font-extrabold transition {{ is_null($status) ? 'bg-white text-slate-800 shadow-sm' : 'text-slate-500 hover:text-slate-800' }}">
            All Listings
        </a>
        <a href="/admin/properties?status=pending" class="px-4 py-2 rounded-lg text-xs font-extrabold transition {{ $status === 'pending' ? 'bg-white text-[#187053] shadow-sm' : 'text-slate-500 hover:text-slate-800' }}">
            Pending Review
        </a>
        <a href="/admin/properties?status=approved" class="px-4 py-2 rounded-lg text-xs font-extrabold transition {{ $status === 'approved' ? 'bg-white text-emerald-600 shadow-sm' : 'text-slate-500 hover:text-slate-800' }}">
            Approved
        </a>
        <a href="/admin/properties?status=rejected" class="px-4 py-2 rounded-lg text-xs font-extrabold transition {{ $status === 'rejected' ? 'bg-white text-rose-600 shadow-sm' : 'text-slate-500 hover:text-slate-800' }}">
            Rejected
        </a>
    </div>

    <!-- Search Input -->
    <div class="w-full md:w-80 relative">
        <span class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none text-slate-400">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
            </svg>
        </span>
        <input type="text" id="propertySearchInput" onkeyup="filterProperties()" placeholder="Search spaces, owners, address..." 
               class="w-full pl-10 pr-4 py-2.5 text-xs font-medium rounded-xl border border-slate-200/60 bg-white text-slate-800 focus:outline-none focus:border-[#187053] transition-colors shadow-sm">
    </div>
</div>

<!-- Listings Table/Grid -->
@if ($properties->isEmpty())
    <div class="bg-white rounded-2xl border border-slate-200/60 p-12 text-center text-slate-400 font-medium relative z-10">
        No properties found matching this filter criteria.
    </div>
@else
    <div class="bg-white rounded-2xl border border-slate-200/60 shadow-sm overflow-hidden relative z-10">
        <div class="overflow-x-auto">
            <table class="w-full text-left text-xs border-collapse">
                <thead>
                    <tr class="text-slate-400 font-bold border-b border-slate-100 bg-slate-50/50">
                        <th class="p-4 pl-6">Property Details</th>
                        <th class="p-4">Category</th>
                        <th class="p-4">Owner / Host</th>
                        <th class="p-4">Rate</th>
                        <th class="p-4">Current Status</th>
                        <th class="p-4 pr-6 text-right">Actions & Moderation</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100/70" id="propertyTableBody">
                    @foreach ($properties as $property)
                        <tr class="text-slate-650 font-medium hover:bg-slate-50/30 transition property-row"
                            data-title="{{ $property->title }}" 
                            data-address="{{ $property->address }}"
                            data-category="{{ $property->category }}"
                            data-owner="{{ $property->owner->name }}">
                            <td class="p-4 pl-6">
                                <div class="flex items-center gap-4">
                                    <div class="h-12 w-16 bg-slate-100 rounded-lg overflow-hidden flex-shrink-0 border border-slate-200/50 shadow-sm">
                                        <img src="{{ !empty($property->images) && is_array($property->images) ? $property->images[0] : 'https://images.unsplash.com/photo-1564013799919-ab600027ffc6?auto=format&fit=crop&w=120&q=80' }}" 
                                             alt="property" class="h-full w-full object-cover">
                                    </div>
                                    <div class="overflow-hidden">
                                        <div class="font-extrabold text-slate-800 text-xs truncate max-w-xs">{{ $property->title }}</div>
                                        <span class="text-[10px] text-slate-400 font-medium block truncate max-w-xs mt-0.5">{{ $property->address }}</span>
                                    </div>
                                </div>
                            </td>
                            <td class="p-4">
                                <span class="px-2.5 py-1 bg-slate-100 text-slate-650 rounded-md font-extrabold text-[9px] uppercase tracking-wider block w-max border border-slate-200/50">
                                    {{ $property->category }}
                                </span>
                            </td>
                            <td class="p-4">
                                <div class="font-bold text-slate-800">{{ $property->owner->name }}</div>
                                <span class="text-[9px] text-slate-400 block mt-0.5">{{ $property->owner->email }}</span>
                            </td>
                            <td class="p-4 font-extrabold text-slate-800 text-sm whitespace-nowrap">
                                {{ $property->currency_symbol }}{{ number_format($property->price, 2) }}{{ $property->billing_frequency_suffix }}
                            </td>
                            <td class="p-4">
                                @if ($property->status == 'approved')
                                    <span class="px-2.5 py-1 bg-emerald-50 text-emerald-700 rounded-full font-extrabold text-[9px] uppercase border border-emerald-200/60">Approved</span>
                                @elseif ($property->status == 'pending')
                                    <span class="px-2.5 py-1 bg-amber-50 text-amber-700 rounded-full font-extrabold text-[9px] uppercase border border-amber-200/60 animate-pulse">Pending Review</span>
                                @else
                                    <span class="px-2.5 py-1 bg-rose-50 text-rose-700 rounded-full font-extrabold text-[9px] uppercase border border-rose-200/60">Rejected</span>
                                @endif
                            </td>
                            <td class="p-4 pr-6 text-right">
                                <div class="flex gap-2 justify-end items-center">
                                    <!-- Toggle Featured -->
                                    <form action="/admin/properties/{{ $property->id }}/toggle-featured" method="POST" class="m-0">
                                        @csrf
                                        @if ($property->is_featured)
                                            <button type="submit" class="p-2 bg-amber-500 hover:bg-amber-600 text-white rounded-lg transition block shadow-sm" title="Remove from Featured">
                                                ★
                                            </button>
                                        @else
                                            <button type="submit" class="p-2 bg-slate-50 hover:bg-slate-100 text-slate-400 hover:text-slate-600 rounded-lg border border-slate-200 transition block shadow-sm" title="Make Featured">
                                                ☆
                                            </button>
                                        @endif
                                    </form>

                                    <!-- View Details Page -->
                                    <a href="/admin/properties/{{ $property->id }}" 
                                       class="p-2 bg-slate-50 hover:bg-slate-100 text-slate-650 rounded-lg border border-slate-200 transition block shadow-sm" title="View Details">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                        </svg>
                                    </a>

                                    <!-- Edit Details Page -->
                                    <a href="/admin/properties/{{ $property->id }}/edit" 
                                       class="p-2 bg-slate-50 hover:bg-slate-100 text-slate-650 rounded-lg border border-slate-200 transition block shadow-sm" title="Edit Details">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                                        </svg>
                                    </a>

                                    @if ($property->status !== 'approved')
                                        <form action="/admin/properties/{{ $property->id }}/status" method="POST" class="m-0">
                                            @csrf
                                            <input type="hidden" name="status" value="approved">
                                            <button type="submit" class="p-2 bg-emerald-50 hover:bg-emerald-100 text-[#187053] rounded-lg border border-emerald-250/70 transition shadow-sm" title="Approve Listing">
                                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7" />
                                                </svg>
                                            </button>
                                        </form>
                                    @endif
                                    
                                    @if ($property->status !== 'rejected')
                                        <form action="/admin/properties/{{ $property->id }}/status" method="POST" class="m-0">
                                            @csrf
                                            <input type="hidden" name="status" value="rejected">
                                            <button type="submit" class="p-2 bg-rose-50 hover:bg-rose-100 text-rose-700 border border-rose-200/60 rounded-lg transition shadow-sm" title="Reject Listing">
                                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M6 18L18 6M6 6l12 12" />
                                                </svg>
                                            </button>
                                        </form>
                                    @endif

                                    <!-- Delete Property Form -->
                                    <form action="/admin/properties/{{ $property->id }}" method="POST" class="m-0" onsubmit="return confirm('Are you sure you want to permanently delete this property listing? This will also cancel all associated bookings.')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="p-2 bg-red-50 hover:bg-red-100 text-red-600 border border-red-200 rounded-lg transition shadow-sm" title="Delete Listing">
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

<script>
    // Local filtering engine
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
</script>
@endsection
