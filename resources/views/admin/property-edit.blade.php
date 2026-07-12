@extends('admin.layout')

@section('page_title', 'Edit Space Details')

@section('content')
<div class="mb-6 max-w-2xl mx-auto flex items-center justify-between">
    <a href="/admin/properties/{{ $property->id }}" class="inline-flex items-center gap-1.5 text-xs font-extrabold text-slate-500 hover:text-slate-800 transition">
        &larr; Back to Details
    </a>
    <span class="text-[10px] text-slate-400 font-extrabold">Editing Listing ID: #{{ $property->id }}</span>
</div>

<div class="max-w-2xl mx-auto bg-white rounded-2xl border border-slate-200/60 shadow-sm overflow-hidden p-8">
    <div class="pb-5 border-b border-slate-100 mb-6">
        <h1 class="text-lg font-black text-slate-800 tracking-tight">Edit Property Listing</h1>
        <p class="text-xs font-semibold text-slate-400 mt-1">Modify property title, price rates, categories, specifications, and availability rules.</p>
    </div>

    @if ($errors->any())
        <div class="p-4 mb-6 bg-red-50 border border-red-200 text-red-700 rounded-lg text-xs">
            <ul class="list-disc pl-4 space-y-1">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="/admin/properties/{{ $property->id }}" method="POST" class="space-y-6">
        @csrf

        <!-- Title field -->
        <div class="space-y-1.5">
            <label class="block text-[9px] font-extrabold text-slate-400 uppercase tracking-widest">Property Title</label>
            <input type="text" name="title" value="{{ old('title', $property->title) }}" required
                   class="w-full px-4 py-3 bg-slate-50 border border-slate-200/60 rounded-md text-slate-850 text-xs font-semibold focus:outline-none focus:border-[#187053] transition-colors">
        </div>

        <!-- Address field -->
        <div class="space-y-1.5">
            <label class="block text-[9px] font-extrabold text-slate-400 uppercase tracking-widest">Address / Location</label>
            <input type="text" name="address" value="{{ old('address', $property->address) }}" required
                   class="w-full px-4 py-3 bg-slate-50 border border-slate-200/60 rounded-md text-slate-850 text-xs font-semibold focus:outline-none focus:border-[#187053] transition-colors">
        </div>

        <div class="grid grid-cols-4 gap-4">
            <!-- Listing Type -->
            <div class="space-y-1.5 col-span-2">
                <label class="block text-[9px] font-extrabold text-slate-400 uppercase tracking-widest">Listing Type</label>
                <select name="listing_type" id="admin_listing_type_select" required
                        class="w-full px-4 py-3 bg-slate-50 border border-slate-200/60 rounded-md text-slate-850 text-xs font-semibold focus:outline-none focus:border-[#187053] transition-colors">
                    <option value="rent" {{ old('listing_type', $property->listing_type) === 'rent' ? 'selected' : '' }}>For Rent</option>
                    <option value="sale" {{ old('listing_type', $property->listing_type) === 'sale' ? 'selected' : '' }}>For Sale</option>
                </select>
            </div>

            <!-- Available From -->
            <div class="space-y-1.5 col-span-2">
                <label class="block text-[9px] font-extrabold text-slate-400 uppercase tracking-widest">Available From</label>
                <input type="date" name="available_from" value="{{ old('available_from', $property->available_from ? $property->available_from->format('Y-m-d') : '') }}"
                       class="w-full px-4 py-3 bg-slate-50 border border-slate-200/60 rounded-md text-slate-850 text-xs font-semibold focus:outline-none focus:border-[#187053] transition-colors">
            </div>
        </div>

        <div class="grid grid-cols-3 gap-4">
            <!-- Price field -->
            <div class="space-y-1.5">
                <label class="block text-[9px] font-extrabold text-slate-400 uppercase tracking-widest">Price Rate</label>
                <input type="number" step="0.01" name="price" value="{{ old('price', $property->price) }}" required
                       class="w-full px-4 py-3 bg-slate-50 border border-slate-200/60 rounded-md text-slate-850 text-xs font-semibold focus:outline-none focus:border-[#187053] transition-colors">
            </div>

            <!-- Currency field -->
            <div class="space-y-1.5">
                <label class="block text-[9px] font-extrabold text-slate-400 uppercase tracking-widest">Currency</label>
                <select name="currency" required
                        class="w-full px-4 py-3 bg-slate-50 border border-slate-200/60 rounded-md text-slate-850 text-xs font-semibold focus:outline-none focus:border-[#187053] transition-colors">
                    <option value="INR" {{ old('currency', $property->currency) === 'INR' ? 'selected' : '' }}>INR (₹)</option>
                    <option value="USD" {{ old('currency', $property->currency) === 'USD' ? 'selected' : '' }}>USD ($)</option>
                    <option value="EUR" {{ old('currency', $property->currency) === 'EUR' ? 'selected' : '' }}>EUR (€)</option>
                    <option value="GBP" {{ old('currency', $property->currency) === 'GBP' ? 'selected' : '' }}>GBP (£)</option>
                </select>
            </div>

            <!-- Frequency field -->
            <div class="space-y-1.5" id="admin_billing_freq_container">
                <label class="block text-[9px] font-extrabold text-slate-400 uppercase tracking-widest">Pricing Frequency</label>
                <select name="billing_frequency" id="admin_billing_frequency_select" required
                        class="w-full px-4 py-3 bg-slate-50 border border-slate-200/60 rounded-md text-slate-850 text-xs font-semibold focus:outline-none focus:border-[#187053] transition-colors">
                    <option value="monthly" {{ old('billing_frequency', $property->billing_frequency) === 'monthly' ? 'selected' : '' }}>Monthly</option>
                    <option value="per_day" {{ old('billing_frequency', $property->billing_frequency) === 'per_day' ? 'selected' : '' }}>Per Day</option>
                    <option value="hourly" {{ old('billing_frequency', $property->billing_frequency) === 'hourly' ? 'selected' : '' }}>Hourly</option>
                </select>
            </div>
        </div>

        <!-- Rent-only Fields section -->
        <div class="admin-rent-only border border-slate-100 p-4 rounded-xl bg-slate-50/50 space-y-4">
            <h4 class="text-[10px] font-extrabold text-slate-400 uppercase tracking-widest">Rent Specifications</h4>
            <div class="grid grid-cols-3 gap-4">
                <div class="space-y-1.5">
                    <label class="block text-[9px] font-extrabold text-slate-400 uppercase tracking-widest">Security Deposit</label>
                    <input type="number" step="0.01" name="security_deposit" value="{{ old('security_deposit', $property->security_deposit) }}"
                           class="w-full px-4 py-3 bg-slate-50 border border-slate-200/60 rounded-md text-slate-850 text-xs font-semibold focus:outline-none focus:border-[#187053] transition-colors">
                </div>
                <div class="space-y-1.5">
                    <label class="block text-[9px] font-extrabold text-slate-400 uppercase tracking-widest">Lease Duration</label>
                    <select name="lease_duration"
                            class="w-full px-4 py-3 bg-slate-50 border border-slate-200/60 rounded-md text-slate-850 text-xs font-semibold focus:outline-none focus:border-[#187053] transition-colors">
                        <option value="" {{ old('lease_duration', $property->lease_duration) === '' ? 'selected' : '' }}>Flexible</option>
                        <option value="1 month" {{ old('lease_duration', $property->lease_duration) === '1 month' ? 'selected' : '' }}>1 Month</option>
                        <option value="3 months" {{ old('lease_duration', $property->lease_duration) === '3 months' ? 'selected' : '' }}>3 Months</option>
                        <option value="6 months" {{ old('lease_duration', $property->lease_duration) === '6 months' ? 'selected' : '' }}>6 Months</option>
                        <option value="1 year" {{ old('lease_duration', $property->lease_duration) === '1 year' ? 'selected' : '' }}>1 Year</option>
                        <option value="2 years" {{ old('lease_duration', $property->lease_duration) === '2 years' ? 'selected' : '' }}>2 Years</option>
                    </select>
                </div>
                <div class="space-y-1.5">
                    <label class="block text-[9px] font-extrabold text-slate-400 uppercase tracking-widest">Preferred Tenant</label>
                    <select name="preferred_tenant"
                            class="w-full px-4 py-3 bg-slate-50 border border-slate-200/60 rounded-md text-slate-850 text-xs font-semibold focus:outline-none focus:border-[#187053] transition-colors">
                        <option value="Any" {{ old('preferred_tenant', $property->preferred_tenant) === 'Any' ? 'selected' : '' }}>Any</option>
                        <option value="Family" {{ old('preferred_tenant', $property->preferred_tenant) === 'Family' ? 'selected' : '' }}>Family</option>
                        <option value="Bachelors" {{ old('preferred_tenant', $property->preferred_tenant) === 'Bachelors' ? 'selected' : '' }}>Bachelors</option>
                        <option value="Company Lease" {{ old('preferred_tenant', $property->preferred_tenant) === 'Company Lease' ? 'selected' : '' }}>Company Lease</option>
                    </select>
                </div>
            </div>
            <div class="grid grid-cols-2 gap-4 pt-2">
                <div class="flex items-center gap-2">
                    <input type="checkbox" name="supports_group_renting" value="1" id="admin_supports_group_renting" class="rounded border-slate-200 text-steelAzure focus:ring-steelAzure" {{ old('supports_group_renting', $property->supports_group_renting) ? 'checked' : '' }}>
                    <label class="text-[10px] font-extrabold text-slate-500 uppercase tracking-widest cursor-pointer" for="admin_supports_group_renting">Enable Group Renting</label>
                </div>
                <div class="space-y-1.5" id="admin_group_size_container" style="display: {{ old('supports_group_renting', $property->supports_group_renting) ? 'block' : 'none' }}">
                    <label class="block text-[9px] font-extrabold text-slate-400 uppercase tracking-widest">Group Max Size</label>
                    <select name="group_max_size"
                            class="w-full px-3 py-2 bg-slate-50 border border-slate-200/60 rounded-md text-slate-850 text-xs font-semibold focus:outline-none focus:border-[#187053] transition-colors">
                        <option value="2" {{ old('group_max_size', $property->group_max_size) == 2 ? 'selected' : '' }}>2 Roommates</option>
                        <option value="3" {{ old('group_max_size', $property->group_max_size) == 3 ? 'selected' : '' }}>3 Roommates</option>
                        <option value="4" {{ old('group_max_size', $property->group_max_size) == 4 ? 'selected' : '' }}>4 Roommates</option>
                        <option value="5" {{ old('group_max_size', $property->group_max_size) == 5 ? 'selected' : '' }}>5 Roommates</option>
                    </select>
                </div>
            </div>
        </div>

        <script>
            document.getElementById('admin_supports_group_renting')?.addEventListener('change', function(e) {
                document.getElementById('admin_group_size_container').style.display = e.target.checked ? 'block' : 'none';
            });
        </script>

        <!-- Category dropdown -->
        <div class="space-y-1.5">
            <label class="block text-[9px] font-extrabold text-slate-400 uppercase tracking-widest">Property Category</label>
            <select name="category" id="admin_category_select" required
                    class="w-full px-4 py-3 bg-slate-50 border border-slate-200/60 rounded-md text-slate-850 text-xs font-semibold focus:outline-none focus:border-[#187053] transition-colors">
                @foreach ($categoriesList as $cat)
                    <option value="{{ $cat }}" {{ old('category', $property->category) === $cat ? 'selected' : '' }}>{{ $cat }}</option>
                @endforeach
            </select>
        </div>

        <div class="grid grid-cols-2 gap-4 admin-non-land">
            <!-- Bedrooms field -->
            <div class="space-y-1.5">
                <label class="block text-[9px] font-extrabold text-slate-400 uppercase tracking-widest">Bedrooms Count</label>
                <input type="number" name="bedrooms" value="{{ old('bedrooms', $property->bedrooms) }}" min="0"
                       class="w-full px-4 py-3 bg-slate-50 border border-slate-200/60 rounded-md text-slate-850 text-xs font-semibold focus:outline-none focus:border-[#187053] transition-colors">
            </div>

            <!-- Bathrooms field -->
            <div class="space-y-1.5">
                <label class="block text-[9px] font-extrabold text-slate-400 uppercase tracking-widest">Bathrooms Count</label>
                <input type="number" name="bathrooms" value="{{ old('bathrooms', $property->bathrooms) }}" min="0"
                       class="w-full px-4 py-3 bg-slate-50 border border-slate-200/60 rounded-md text-slate-850 text-xs font-semibold focus:outline-none focus:border-[#187053] transition-colors">
            </div>
        </div>

        <!-- Sale-only Fields section -->
        <div class="admin-sale-only border border-slate-100 p-4 rounded-xl bg-slate-50/50 space-y-4" style="display: none;">
            <h4 class="text-[10px] font-extrabold text-slate-400 uppercase tracking-widest">Sale Specifications</h4>
            <div class="grid grid-cols-3 gap-4">
                <div class="space-y-1.5">
                    <label class="block text-[9px] font-extrabold text-slate-400 uppercase tracking-widest">Built-up Area (sq ft)</label>
                    <input type="number" name="built_up_area" value="{{ old('built_up_area', $property->built_up_area) }}"
                           class="w-full px-4 py-3 bg-slate-50 border border-slate-200/60 rounded-md text-slate-850 text-xs font-semibold focus:outline-none focus:border-[#187053] transition-colors">
                </div>
                <div class="space-y-1.5">
                    <label class="block text-[9px] font-extrabold text-slate-400 uppercase tracking-widest">Property Age (years)</label>
                    <input type="number" name="property_age" value="{{ old('property_age', $property->property_age) }}"
                           class="w-full px-4 py-3 bg-slate-50 border border-slate-200/60 rounded-md text-slate-850 text-xs font-semibold focus:outline-none focus:border-[#187053] transition-colors">
                </div>
                <div class="space-y-1.5">
                    <label class="block text-[9px] font-extrabold text-slate-400 uppercase tracking-widest">Ownership Type</label>
                    <select name="ownership_type"
                            class="w-full px-4 py-3 bg-slate-50 border border-slate-200/60 rounded-md text-slate-850 text-xs font-semibold focus:outline-none focus:border-[#187053] transition-colors">
                        <option value="Freehold" {{ old('ownership_type', $property->ownership_type) === 'Freehold' ? 'selected' : '' }}>Freehold</option>
                        <option value="Leasehold" {{ old('ownership_type', $property->ownership_type) === 'Leasehold' ? 'selected' : '' }}>Leasehold</option>
                        <option value="Cooperative Society" {{ old('ownership_type', $property->ownership_type) === 'Cooperative Society' ? 'selected' : '' }}>Cooperative Society</option>
                        <option value="Power of Attorney" {{ old('ownership_type', $property->ownership_type) === 'Power of Attorney' ? 'selected' : '' }}>Power of Attorney</option>
                    </select>
                </div>
            </div>
            <div class="flex items-center gap-2 pt-2">
                <input type="checkbox" name="is_rera_approved" value="1" id="admin_is_rera_approved" class="rounded border-slate-200 text-[#187053] focus:ring-[#187053]" {{ old('is_rera_approved', $property->is_rera_approved) ? 'checked' : '' }}>
                <label class="text-[10px] font-extrabold text-slate-500 uppercase tracking-widest cursor-pointer" for="admin_is_rera_approved">RERA Approved / Legal Clearance</label>
            </div>
        </div>

        <!-- Land-only Fields section -->
        <div class="admin-land-only border border-slate-100 p-4 rounded-xl bg-slate-50/50 space-y-4" style="display: none;">
            <h4 class="text-[10px] font-extrabold text-slate-400 uppercase tracking-widest">Land Specifications</h4>
            <div class="grid grid-cols-2 gap-4">
                <div class="space-y-1.5">
                    <label class="block text-[9px] font-extrabold text-slate-400 uppercase tracking-widest">Plot Area</label>
                    <input type="number" step="any" name="plot_area" value="{{ old('plot_area', $property->plot_area) }}"
                           class="w-full px-4 py-3 bg-slate-50 border border-slate-200/60 rounded-md text-slate-850 text-xs font-semibold focus:outline-none focus:border-[#187053] transition-colors">
                </div>
                <div class="flex items-center gap-2 pt-6">
                    <input type="checkbox" name="boundary_wall" value="1" id="admin_boundary_wall" class="rounded border-slate-200 text-[#187053] focus:ring-[#187053]" {{ old('boundary_wall', $property->boundary_wall) ? 'checked' : '' }}>
                    <label class="text-[10px] font-extrabold text-slate-500 uppercase tracking-widest cursor-pointer" for="admin_boundary_wall">Boundary Wall</label>
                </div>
            </div>
        </div>

        <!-- Common Real Estate details -->
        <div class="border border-slate-100 p-4 rounded-xl bg-slate-50/50 space-y-4">
            <h4 class="text-[10px] font-extrabold text-slate-400 uppercase tracking-widest">Unit & Building Details</h4>
            <div class="grid grid-cols-4 gap-4">
                <div class="space-y-1.5">
                    <label class="block text-[9px] font-extrabold text-slate-400 uppercase tracking-widest">Carpet Area</label>
                    <input type="number" name="carpet_area" value="{{ old('carpet_area', $property->carpet_area) }}"
                           class="w-full px-3 py-2.5 bg-slate-50 border border-slate-200/60 rounded-md text-slate-850 text-xs font-semibold focus:outline-none focus:border-[#187053] transition-colors">
                </div>
                <div class="space-y-1.5 admin-non-land">
                    <label class="block text-[9px] font-extrabold text-slate-400 uppercase tracking-widest">Floor Number</label>
                    <input type="number" name="floor_number" value="{{ old('floor_number', $property->floor_number) }}"
                           class="w-full px-3 py-2.5 bg-slate-50 border border-slate-200/60 rounded-md text-slate-850 text-xs font-semibold focus:outline-none focus:border-[#187053] transition-colors">
                </div>
                <div class="space-y-1.5 admin-non-land">
                    <label class="block text-[9px] font-extrabold text-slate-400 uppercase tracking-widest">Total Floors</label>
                    <input type="number" name="total_floors" value="{{ old('total_floors', $property->total_floors) }}"
                           class="w-full px-3 py-2.5 bg-slate-50 border border-slate-200/60 rounded-md text-slate-850 text-xs font-semibold focus:outline-none focus:border-[#187053] transition-colors">
                </div>
                <div class="space-y-1.5">
                    <label class="block text-[9px] font-extrabold text-slate-400 uppercase tracking-widest">Facing Direction</label>
                    <select name="facing_direction"
                            class="w-full px-3 py-2.5 bg-slate-50 border border-slate-200/60 rounded-md text-slate-850 text-xs font-semibold focus:outline-none focus:border-[#187053] transition-colors">
                        <option value="" {{ old('facing_direction', $property->facing_direction) === '' ? 'selected' : '' }}>Select</option>
                        <option value="North" {{ old('facing_direction', $property->facing_direction) === 'North' ? 'selected' : '' }}>North</option>
                        <option value="South" {{ old('facing_direction', $property->facing_direction) === 'South' ? 'selected' : '' }}>South</option>
                        <option value="East" {{ old('facing_direction', $property->facing_direction) === 'East' ? 'selected' : '' }}>East</option>
                        <option value="West" {{ old('facing_direction', $property->facing_direction) === 'West' ? 'selected' : '' }}>West</option>
                        <option value="North-East" {{ old('facing_direction', $property->facing_direction) === 'North-East' ? 'selected' : '' }}>North-East</option>
                        <option value="North-West" {{ old('facing_direction', $property->facing_direction) === 'North-West' ? 'selected' : '' }}>North-West</option>
                        <option value="South-East" {{ old('facing_direction', $property->facing_direction) === 'South-East' ? 'selected' : '' }}>South-East</option>
                        <option value="South-West" {{ old('facing_direction', $property->facing_direction) === 'South-West' ? 'selected' : '' }}>South-West</option>
                    </select>
                </div>
            </div>
        </div>

        <!-- Description field -->
        <div class="space-y-1.5">
            <label class="block text-[9px] font-extrabold text-slate-400 uppercase tracking-widest">Detailed Description</label>
            <textarea name="description" rows="5" required
                      class="w-full px-4 py-3 bg-slate-50 border border-slate-200/60 rounded-md text-slate-850 text-xs font-semibold focus:outline-none focus:border-[#187053] transition-colors leading-relaxed">{{ old('description', $property->description) }}</textarea>
        </div>

        <div class="flex items-center gap-4 py-2 border-t border-slate-100 pt-6">
            <div class="flex items-center gap-2">
                <input type="checkbox" name="is_negotiable" value="1" id="admin_is_negotiable" class="rounded border-slate-200 text-[#187053] focus:ring-[#187053]" {{ old('is_negotiable', $property->is_negotiable) ? 'checked' : '' }}>
                <label class="text-[10px] font-extrabold text-slate-500 uppercase tracking-widest cursor-pointer" for="admin_is_negotiable">Price Negotiable</label>
            </div>
        </div>

        <!-- Key Features toggles -->
        <div class="border-t border-slate-100 pt-6 admin-non-land">
            <h4 class="text-[10px] font-extrabold text-slate-400 uppercase tracking-widest mb-4">Key Features & Rules</h4>
            <div class="grid grid-cols-3 gap-4">
                <!-- Furnished Select -->
                <div class="space-y-1.5">
                    <label class="block text-[9px] font-extrabold text-slate-400 uppercase tracking-widest">Furnished status</label>
                    <select name="is_furnished" required
                            class="w-full px-3 py-2.5 bg-slate-50 border border-slate-200/60 rounded-md text-slate-850 text-xs font-semibold focus:outline-none focus:border-[#187053] transition-colors">
                        <option value="0" {{ old('is_furnished', $property->is_furnished) ? '' : 'selected' }}>Unfurnished</option>
                        <option value="1" {{ old('is_furnished', $property->is_furnished) ? 'selected' : '' }}>Furnished</option>
                    </select>
                </div>

                <!-- Parking Select -->
                <div class="space-y-1.5">
                    <label class="block text-[9px] font-extrabold text-slate-400 uppercase tracking-widest">Parking status</label>
                    <select name="has_parking" required
                            class="w-full px-3 py-2.5 bg-slate-50 border border-slate-200/60 rounded-md text-slate-850 text-xs font-semibold focus:outline-none focus:border-[#187053] transition-colors">
                        <option value="0" {{ old('has_parking', $property->has_parking) ? '' : 'selected' }}>No Parking</option>
                        <option value="1" {{ old('has_parking', $property->has_parking) ? 'selected' : '' }}>Parking Included</option>
                    </select>
                </div>

                <!-- Pet Friendly Select -->
                <div class="space-y-1.5">
                    <label class="block text-[9px] font-extrabold text-slate-400 uppercase tracking-widest">Pet Friendly status</label>
                    <select name="is_pet_friendly" required
                            class="w-full px-3 py-2.5 bg-slate-50 border border-slate-200/60 rounded-md text-slate-850 text-xs font-semibold focus:outline-none focus:border-[#187053] transition-colors">
                        <option value="0" {{ old('is_pet_friendly', $property->is_pet_friendly) ? '' : 'selected' }}>No Pets</option>
                        <option value="1" {{ old('is_pet_friendly', $property->is_pet_friendly) ? 'selected' : '' }}>Pet Friendly</option>
                    </select>
                </div>
            </div>
        </div>

        <script>
            function updateAdminFields() {
                const type = document.getElementById('admin_listing_type_select').value;
                const categorySelect = document.getElementById('admin_category_select');
                const category = categorySelect ? categorySelect.value.toLowerCase() : '';
                const isLand = category.includes('land') || category.includes('plot');

                const freqContainer = document.getElementById('admin_billing_freq_container');
                const billingSelect = document.getElementById('admin_billing_frequency_select');
                const rentFields = document.querySelectorAll('.admin-rent-only');
                const saleFields = document.querySelectorAll('.admin-sale-only');
                const landFields = document.querySelectorAll('.admin-land-only');
                const nonLandFields = document.querySelectorAll('.admin-non-land');

                if (type === 'sale') {
                    if (freqContainer) freqContainer.style.display = 'none';
                    if (billingSelect) billingSelect.removeAttribute('required');
                    rentFields.forEach(el => el.style.display = 'none');
                    saleFields.forEach(el => el.style.display = 'block');
                } else {
                    if (freqContainer) freqContainer.style.display = 'block';
                    if (billingSelect) billingSelect.setAttribute('required', 'required');
                    rentFields.forEach(el => el.style.display = 'block');
                    saleFields.forEach(el => el.style.display = 'none');
                }

                if (isLand) {
                    nonLandFields.forEach(el => el.style.display = 'none');
                    landFields.forEach(el => el.style.display = 'block');
                } else {
                    nonLandFields.forEach(el => el.style.display = 'block');
                    landFields.forEach(el => el.style.display = 'none');
                }
            }

            document.getElementById('admin_listing_type_select')?.addEventListener('change', updateAdminFields);
            document.getElementById('admin_category_select')?.addEventListener('change', updateAdminFields);

            document.addEventListener('DOMContentLoaded', () => {
                updateAdminFields();
            });
            // Run immediately in case DOMContentLoaded has already fired
            setTimeout(updateAdminFields, 100);
        </script>

        <!-- Submit Panel -->
        <div class="border-t border-slate-100 pt-6 flex justify-end gap-3">
            <a href="/admin/properties/{{ $property->id }}" class="px-5 py-2.5 bg-slate-100 hover:bg-slate-200 text-slate-700 border border-slate-250 text-xs font-bold rounded-lg transition">
                Cancel
            </a>
            <button type="submit" class="px-5 py-2.5 bg-[#187053] hover:bg-[#12563f] text-white text-xs font-bold rounded-lg shadow-sm transition">
                Save Changes
            </button>
        </div>
    </form>
</div>
@endsection
