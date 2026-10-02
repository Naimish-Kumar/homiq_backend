@php
    $action = $formAction ?? url('/dashboard/listings');
    $categories = $categories ?? \App\Models\Category::all();
    $amenities = $amenities ?? \App\Models\Amenity::all();
    $specifications = $specifications ?? \App\Models\Specification::all();
    $features = $features ?? \App\Models\KeyFeature::all();
@endphp

<form action="{{ $action }}" method="POST" enctype="multipart/form-data" class="space-y-5" id="homiq-property-listing-form">
    @csrf

    <!-- Property Title -->
    <div>
        <label class="block text-[10px] font-bold text-slate-500 uppercase tracking-wider mb-2">Property Title <span class="text-rose-500">*</span></label>
        <input type="text" name="title" required placeholder="e.g. Luxury 3BHK Apartment in Downtown"
            value="{{ old('title') }}"
            class="w-full px-4 py-3 bg-white border border-slate-200 rounded-xl text-slate-800 text-xs focus:outline-none focus:border-steelAzure focus:ring-1 focus:ring-steelAzure/20 transition shadow-xs">
    </div>

    <!-- Description -->
    <div>
        <label class="block text-[10px] font-bold text-slate-500 uppercase tracking-wider mb-2">Description <span class="text-rose-500">*</span></label>
        <textarea name="description" required rows="3" placeholder="Describe key features, furnishing, nearby landmarks, and highlights..."
            class="w-full px-4 py-3 bg-white border border-slate-200 rounded-xl text-slate-800 text-xs focus:outline-none focus:border-steelAzure focus:ring-1 focus:ring-steelAzure/20 transition shadow-xs">{{ old('description') }}</textarea>
    </div>

    <!-- Address & Auto Geolocation -->
    <div class="space-y-2">
        <div class="flex items-center justify-between">
            <label class="block text-[10px] font-bold text-slate-500 uppercase tracking-wider">Address <span class="text-rose-500">*</span></label>
            <button type="button" onclick="fetchCurrentLocationWeb()" class="flex items-center gap-1.5 text-[11px] font-bold text-steelAzure hover:text-emerald-600 transition bg-transparent border-0 p-0 cursor-pointer">
                <span class="material-symbols-outlined text-[15px] text-emerald-600">my_location</span>
                <span>Fetch Current Location</span>
            </button>
        </div>
        <input type="text" name="address" id="listing-address" required placeholder="Street address, locality, city"
            value="{{ old('address') }}"
            class="w-full px-4 py-3 bg-white border border-slate-200 rounded-xl text-slate-800 text-xs focus:outline-none focus:border-steelAzure focus:ring-1 focus:ring-steelAzure/20 transition shadow-xs">
        <span id="loc-loading" class="text-[10px] font-bold text-emerald-600 hidden animate-pulse flex items-center gap-1">
            <span class="material-symbols-outlined text-[13px] animate-spin">sync</span> Locating & Resolving Coordinates...
        </span>
    </div>

    <!-- Latitude & Longitude -->
    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
        <div>
            <label class="block text-[10px] font-bold text-slate-500 uppercase tracking-wider mb-2">Latitude <span class="text-rose-500">*</span></label>
            <input type="number" step="any" name="latitude" id="listing-latitude" required placeholder="e.g. 28.6273"
                value="{{ old('latitude', '28.6139') }}"
                class="w-full px-4 py-3 bg-white border border-slate-200 rounded-xl text-slate-800 text-xs focus:outline-none focus:border-steelAzure transition shadow-xs">
        </div>
        <div>
            <label class="block text-[10px] font-bold text-slate-500 uppercase tracking-wider mb-2">Longitude <span class="text-rose-500">*</span></label>
            <input type="number" step="any" name="longitude" id="listing-longitude" required placeholder="e.g. 77.3714"
                value="{{ old('longitude', '77.2090') }}"
                class="w-full px-4 py-3 bg-white border border-slate-200 rounded-xl text-slate-800 text-xs focus:outline-none focus:border-steelAzure transition shadow-xs">
        </div>
    </div>

    <input type="hidden" name="country" id="listing-country" value="{{ old('country', 'India') }}">

    <!-- Listing Type, Price, Currency & Frequency -->
    <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-4 gap-4">
        <div>
            <label class="block text-[10px] font-bold text-slate-500 uppercase tracking-wider mb-2">Listing Type <span class="text-rose-500">*</span></label>
            <select name="listing_type" id="listing_type_select" required
                class="w-full px-4 py-3 bg-white border border-slate-200 rounded-xl text-slate-800 text-xs focus:outline-none focus:border-steelAzure transition shadow-xs font-semibold">
                <option value="rent" {{ old('listing_type', 'rent') === 'rent' ? 'selected' : '' }}>For Rent</option>
                <option value="sale" {{ old('listing_type') === 'sale' ? 'selected' : '' }}>For Sale</option>
            </select>
        </div>
        <div>
            <label class="block text-[10px] font-bold text-slate-500 uppercase tracking-wider mb-2">Price Amount <span class="text-rose-500">*</span></label>
            <input type="number" name="price" required min="0" placeholder="100"
                value="{{ old('price') }}"
                class="w-full px-4 py-3 bg-white border border-slate-200 rounded-xl text-slate-800 text-xs focus:outline-none focus:border-steelAzure transition shadow-xs font-semibold">
        </div>
        <div>
            <label class="block text-[10px] font-bold text-slate-500 uppercase tracking-wider mb-2">Currency <span class="text-rose-500">*</span></label>
            <select name="currency" required
                class="w-full px-4 py-3 bg-white border border-slate-200 rounded-xl text-slate-800 text-xs focus:outline-none focus:border-steelAzure transition shadow-xs font-semibold">
                <option value="INR" {{ old('currency', 'INR') === 'INR' ? 'selected' : '' }}>INR (₹)</option>
                <option value="USD" {{ old('currency') === 'USD' ? 'selected' : '' }}>USD ($)</option>
                <option value="EUR" {{ old('currency') === 'EUR' ? 'selected' : '' }}>EUR (€)</option>
                <option value="GBP" {{ old('currency') === 'GBP' ? 'selected' : '' }}>GBP (£)</option>
            </select>
        </div>
        <div id="billing_freq_container">
            <label class="block text-[10px] font-bold text-slate-500 uppercase tracking-wider mb-2">Pricing Frequency <span class="text-rose-500">*</span></label>
            <select name="billing_frequency" id="billing_frequency_select" required
                class="w-full px-4 py-3 bg-white border border-slate-200 rounded-xl text-slate-800 text-xs focus:outline-none focus:border-steelAzure transition shadow-xs font-semibold">
                <option value="monthly" {{ old('billing_frequency', 'monthly') === 'monthly' ? 'selected' : '' }}>Monthly</option>
                <option value="per_day" {{ old('billing_frequency') === 'per_day' ? 'selected' : '' }}>Per Day</option>
                <option value="hourly" {{ old('billing_frequency') === 'hourly' ? 'selected' : '' }}>Hourly</option>
            </select>
        </div>
    </div>

    <!-- Rent-specific Additional Fields -->
    <div class="rent-only-field grid grid-cols-1 md:grid-cols-3 gap-4">
        <div>
            <label class="block text-[10px] font-bold text-slate-500 uppercase tracking-wider mb-2">Security Deposit</label>
            <input type="number" name="security_deposit" min="0" placeholder="e.g. 5000"
                value="{{ old('security_deposit') }}"
                class="w-full px-4 py-3 bg-white border border-slate-200 rounded-xl text-slate-800 text-xs focus:outline-none focus:border-steelAzure transition shadow-xs">
        </div>
        <div>
            <label class="block text-[10px] font-bold text-slate-500 uppercase tracking-wider mb-2">Lease Duration</label>
            <select name="lease_duration"
                class="w-full px-4 py-3 bg-white border border-slate-200 rounded-xl text-slate-800 text-xs focus:outline-none focus:border-steelAzure transition shadow-xs">
                <option value="">Flexible</option>
                <option value="1 month" {{ old('lease_duration') === '1 month' ? 'selected' : '' }}>1 Month</option>
                <option value="3 months" {{ old('lease_duration') === '3 months' ? 'selected' : '' }}>3 Months</option>
                <option value="6 months" {{ old('lease_duration') === '6 months' ? 'selected' : '' }}>6 Months</option>
                <option value="1 year" {{ old('lease_duration') === '1 year' ? 'selected' : '' }}>1 Year</option>
                <option value="2 years" {{ old('lease_duration') === '2 years' ? 'selected' : '' }}>2 Years</option>
            </select>
        </div>
        <div>
            <label class="block text-[10px] font-bold text-slate-500 uppercase tracking-wider mb-2">Preferred Tenant</label>
            <select name="preferred_tenant"
                class="w-full px-4 py-3 bg-white border border-slate-200 rounded-xl text-slate-800 text-xs focus:outline-none focus:border-steelAzure transition shadow-xs">
                <option value="Any" selected>Any</option>
                <option value="Family">Family</option>
                <option value="Bachelors">Bachelors</option>
                <option value="Company Lease">Company Lease</option>
            </select>
        </div>
    </div>

    <!-- Rent Group Renting Option -->
    <div class="rent-only-field bg-slate-50 p-4 rounded-xl border border-slate-200/70 space-y-3">
        <div class="flex items-center justify-between">
            <div>
                <label class="block text-xs font-bold text-slate-800">Enable Group Renting</label>
                <span class="text-[10px] text-slate-400 block mt-0.5">Allow multiple roommates to split rent collaboratively</span>
            </div>
            <input type="checkbox" name="supports_group_renting" value="1" id="supports_group_renting_check" class="w-4 h-4 rounded border-slate-300 text-steelAzure focus:ring-steelAzure">
        </div>
        <div id="group_size_container" style="display: none;">
            <label class="block text-[10px] font-bold text-slate-500 uppercase tracking-wider mb-2">Maximum Group Size Limit</label>
            <select name="group_max_size"
                class="w-full px-4 py-3 bg-white border border-slate-200 rounded-xl text-slate-800 text-xs focus:outline-none focus:border-steelAzure transition shadow-xs">
                <option value="2">2 Roommates</option>
                <option value="3" selected>3 Roommates</option>
                <option value="4">4 Roommates</option>
                <option value="5">5 Roommates</option>
            </select>
        </div>
    </div>

    <!-- Category, Bedrooms, Bathrooms & Sale Details -->
    <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
        <div>
            <label class="block text-[10px] font-bold text-slate-500 uppercase tracking-wider mb-2">Category <span class="text-rose-500">*</span></label>
            <select name="category" id="category_select" required
                class="w-full px-4 py-3 bg-white border border-slate-200 rounded-xl text-slate-800 text-xs focus:outline-none focus:border-steelAzure transition shadow-xs font-semibold">
                @foreach ($categories as $cat)
                    <option value="{{ $cat->name }}" {{ old('category') === $cat->name ? 'selected' : '' }}>{{ $cat->name }}</option>
                @endforeach
            </select>
        </div>
        
        <div class="non-land-field">
            <label class="block text-[10px] font-bold text-slate-500 uppercase tracking-wider mb-2">Bedrooms <span class="text-rose-500">*</span></label>
            <input type="number" name="bedrooms" min="0" value="{{ old('bedrooms', 1) }}"
                class="w-full px-4 py-3 bg-white border border-slate-200 rounded-xl text-slate-800 text-xs focus:outline-none focus:border-steelAzure transition shadow-xs">
        </div>
        <div class="non-land-field">
            <label class="block text-[10px] font-bold text-slate-500 uppercase tracking-wider mb-2">Bathrooms <span class="text-rose-500">*</span></label>
            <input type="number" name="bathrooms" min="0" value="{{ old('bathrooms', 1) }}"
                class="w-full px-4 py-3 bg-white border border-slate-200 rounded-xl text-slate-800 text-xs focus:outline-none focus:border-steelAzure transition shadow-xs">
        </div>

        <!-- SALE ONLY FIELDS -->
        <div class="sale-only-field" style="display: none;">
            <label class="block text-[10px] font-bold text-slate-500 uppercase tracking-wider mb-2">Built-up Area (sq ft)</label>
            <input type="number" name="built_up_area" id="built_up_area_input" min="0" value="{{ old('built_up_area') }}"
                class="w-full px-4 py-3 bg-white border border-slate-200 rounded-xl text-slate-800 text-xs focus:outline-none focus:border-steelAzure transition shadow-xs">
        </div>
        <div class="sale-only-field" style="display: none;">
            <label class="block text-[10px] font-bold text-slate-500 uppercase tracking-wider mb-2">Property Age (years)</label>
            <input type="number" name="property_age" id="property_age_input" min="0" value="{{ old('property_age') }}"
                class="w-full px-4 py-3 bg-white border border-slate-200 rounded-xl text-slate-800 text-xs focus:outline-none focus:border-steelAzure transition shadow-xs">
        </div>
        <div class="sale-only-field" style="display: none;">
            <label class="block text-[10px] font-bold text-slate-500 uppercase tracking-wider mb-2">Ownership Type</label>
            <select name="ownership_type" id="ownership_type_input"
                class="w-full px-4 py-3 bg-white border border-slate-200 rounded-xl text-slate-800 text-xs focus:outline-none focus:border-steelAzure transition shadow-xs">
                <option value="Freehold" selected>Freehold</option>
                <option value="Leasehold">Leasehold</option>
                <option value="Cooperative Society">Cooperative Society</option>
                <option value="Power of Attorney">Power of Attorney</option>
            </select>
        </div>
    </div>

    <!-- Land/Plot Only Fields -->
    <div class="land-only-field grid grid-cols-1 sm:grid-cols-2 gap-4" style="display: none;">
        <div>
            <label class="block text-[10px] font-bold text-slate-500 uppercase tracking-wider mb-2">Plot Area (sq yards / sq ft)</label>
            <input type="number" name="plot_area" min="0" placeholder="e.g. 1500" value="{{ old('plot_area') }}"
                class="w-full px-4 py-3 bg-white border border-slate-200 rounded-xl text-slate-800 text-xs focus:outline-none focus:border-steelAzure transition shadow-xs">
        </div>
        <div class="flex items-center gap-2 pt-6">
            <label class="flex items-center gap-2 text-xs font-semibold text-slate-700 cursor-pointer hover:text-slate-900">
                <input type="checkbox" name="boundary_wall" value="1" class="w-4 h-4 rounded border-slate-300 text-steelAzure focus:ring-steelAzure">
                Has Boundary Wall Constructed
            </label>
        </div>
    </div>

    <!-- Carpet Area, Floor & Facing Direction -->
    <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-4 gap-4">
        <div>
            <label class="block text-[10px] font-bold text-slate-500 uppercase tracking-wider mb-2">Carpet Area (sq ft)</label>
            <input type="number" name="carpet_area" min="0" placeholder="e.g. 850" value="{{ old('carpet_area') }}"
                class="w-full px-4 py-3 bg-white border border-slate-200 rounded-xl text-slate-800 text-xs focus:outline-none focus:border-steelAzure transition shadow-xs">
        </div>
        <div class="non-land-field">
            <label class="block text-[10px] font-bold text-slate-500 uppercase tracking-wider mb-2">Floor Number</label>
            <input type="number" name="floor_number" placeholder="e.g. 2" value="{{ old('floor_number') }}"
                class="w-full px-4 py-3 bg-white border border-slate-200 rounded-xl text-slate-800 text-xs focus:outline-none focus:border-steelAzure transition shadow-xs">
        </div>
        <div class="non-land-field">
            <label class="block text-[10px] font-bold text-slate-500 uppercase tracking-wider mb-2">Total Floors</label>
            <input type="number" name="total_floors" placeholder="e.g. 4" value="{{ old('total_floors') }}"
                class="w-full px-4 py-3 bg-white border border-slate-200 rounded-xl text-slate-800 text-xs focus:outline-none focus:border-steelAzure transition shadow-xs">
        </div>
        <div>
            <label class="block text-[10px] font-bold text-slate-500 uppercase tracking-wider mb-2">Facing Direction</label>
            <select name="facing_direction"
                class="w-full px-4 py-3 bg-white border border-slate-200 rounded-xl text-slate-800 text-xs focus:outline-none focus:border-steelAzure transition shadow-xs">
                <option value="" selected>Select Direction</option>
                <option value="North">North</option>
                <option value="South">South</option>
                <option value="East">East</option>
                <option value="West">West</option>
                <option value="North-East">North-East</option>
                <option value="North-West">North-West</option>
                <option value="South-East">South-East</option>
                <option value="South-West">South-West</option>
            </select>
        </div>
    </div>

    <!-- Available From & Toggles -->
    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
        <div>
            <label class="block text-[10px] font-bold text-slate-500 uppercase tracking-wider mb-2">Available From</label>
            <input type="date" name="available_from" value="{{ old('available_from') }}"
                class="w-full px-4 py-3 bg-white border border-slate-200 rounded-xl text-slate-800 text-xs focus:outline-none focus:border-steelAzure transition shadow-xs">
        </div>
        <div class="flex items-center gap-4 pt-6">
            <label class="flex items-center gap-2 text-xs font-semibold text-slate-700 cursor-pointer hover:text-slate-900">
                <input type="checkbox" name="is_negotiable" value="1" class="w-4 h-4 rounded border-slate-300 text-steelAzure focus:ring-steelAzure">
                Price Negotiable
            </label>
            <label class="flex items-center gap-2 text-xs font-semibold text-slate-700 cursor-pointer hover:text-slate-900 sale-only-field" style="display: none;">
                <input type="checkbox" name="is_rera_approved" value="1" class="w-4 h-4 rounded border-slate-300 text-steelAzure focus:ring-steelAzure">
                RERA Approved
            </label>
        </div>
    </div>

    <!-- Key Specifications -->
    <div class="bg-slate-50 p-4 rounded-xl border border-slate-200/70 space-y-2 non-land-field">
        <label class="block text-[10px] font-bold text-slate-500 uppercase tracking-wider mb-1">Key Specifications</label>
        <div class="grid grid-cols-3 gap-4">
            <label class="flex items-center gap-2 text-xs font-semibold text-slate-700 cursor-pointer hover:text-slate-900">
                <input type="checkbox" name="is_furnished" value="1" class="w-4 h-4 rounded border-slate-300 text-steelAzure focus:ring-steelAzure">
                Furnished
            </label>
            <label class="flex items-center gap-2 text-xs font-semibold text-slate-700 cursor-pointer hover:text-slate-900">
                <input type="checkbox" name="has_parking" value="1" class="w-4 h-4 rounded border-slate-300 text-steelAzure focus:ring-steelAzure">
                Has Parking
            </label>
            <label class="flex items-center gap-2 text-xs font-semibold text-slate-700 cursor-pointer hover:text-slate-900">
                <input type="checkbox" name="is_pet_friendly" value="1" class="w-4 h-4 rounded border-slate-300 text-steelAzure focus:ring-steelAzure">
                Pet Friendly
            </label>
        </div>
    </div>

    <!-- Dynamic Amenities -->
    <div class="non-land-field">
        <label class="block text-[10px] font-bold text-slate-500 uppercase tracking-wider mb-2">Included Amenities</label>
        <div class="grid grid-cols-2 sm:grid-cols-4 gap-3 bg-white p-4 rounded-xl border border-slate-200">
            @foreach ($amenities as $am)
                <label class="flex items-center gap-2 text-xs text-slate-700 cursor-pointer hover:text-slate-900">
                    <input type="checkbox" name="amenities[]" value="{{ $am->name }}" class="w-4 h-4 rounded border-slate-300 text-steelAzure focus:ring-steelAzure">
                    {{ $am->name }}
                </label>
            @endforeach
        </div>
    </div>

    <!-- Multiple Photos Upload with Drag & Drop & Live Previews -->
    <div class="space-y-3">
        <label class="block text-[10px] font-bold text-slate-500 uppercase tracking-wider mb-1">Upload Photos (Select Multiple, Max 5) <span class="text-rose-500">*</span></label>
        
        <input type="file" id="property-images-picker" multiple accept="image/*" class="hidden">
        <input type="file" name="images[]" id="property-images-submit" multiple class="hidden" required>
        
        <div id="image-upload-zone" class="border-2 border-dashed border-slate-200 hover:border-steelAzure rounded-2xl p-6 text-center cursor-pointer transition bg-slate-50/50 hover:bg-slate-50 flex flex-col items-center justify-center space-y-2">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-9 w-9 text-slate-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
            </svg>
            <span class="text-xs font-bold text-slate-700">Drag & drop photos here or click to browse</span>
            <span class="text-[10px] text-slate-400 font-medium">Select files multiple times if needed (Max 5 total, up to 10MB each)</span>
        </div>

        <div id="image-previews-container" class="grid grid-cols-2 sm:grid-cols-5 gap-3 hidden">
            <!-- Previews injected via JS -->
        </div>

        <p id="image-error" class="text-rose-600 text-[10px] font-bold mt-1.5 hidden">You can upload a maximum of 5 images.</p>
    </div>

    <!-- Submit Button -->
    <button type="submit" class="w-full py-4 bg-steelAzure hover:bg-slate-900 text-white font-bold rounded-xl shadow-lg shadow-steelAzure/15 transition-all duration-200 transform active:scale-98 text-xs flex items-center justify-center gap-2 cursor-pointer">
        <span>Submit Property Space Listing</span>
        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3" /></svg>
    </button>
</form>

<script>
    // Self-contained dynamic listing fields and photo drag-and-drop
    (function() {
        function updateListingFormFields() {
            const typeSelect = document.getElementById('listing_type_select');
            if (!typeSelect) return;

            const type = typeSelect.value;
            const categorySelect = document.getElementById('category_select');
            const category = categorySelect ? categorySelect.value.toLowerCase() : '';
            const isLand = category.includes('land') || category.includes('plot');

            const freqContainer = document.getElementById('billing_freq_container');
            const freqSelect = document.getElementById('billing_frequency_select');
            const saleFields = document.querySelectorAll('.sale-only-field');
            const rentFields = document.querySelectorAll('.rent-only-field');
            const nonLandFields = document.querySelectorAll('.non-land-field');
            const landOnlyFields = document.querySelectorAll('.land-only-field');
            
            if (type === 'sale') {
                if (freqContainer) freqContainer.style.display = 'none';
                if (freqSelect) freqSelect.removeAttribute('required');
                
                saleFields.forEach(el => el.style.display = 'block');
                rentFields.forEach(el => el.style.display = 'none');
                if (document.getElementById('built_up_area_input')) document.getElementById('built_up_area_input').setAttribute('required', 'required');
                if (document.getElementById('property_age_input')) document.getElementById('property_age_input').setAttribute('required', 'required');
            } else {
                if (freqContainer) freqContainer.style.display = 'block';
                if (freqSelect) freqSelect.setAttribute('required', 'required');
                
                saleFields.forEach(el => el.style.display = 'none');
                rentFields.forEach(el => el.style.display = 'block');
                if (document.getElementById('built_up_area_input')) document.getElementById('built_up_area_input').removeAttribute('required');
                if (document.getElementById('property_age_input')) document.getElementById('property_age_input').removeAttribute('required');
            }

            nonLandFields.forEach(el => {
                el.style.display = isLand ? 'none' : 'block';
            });

            landOnlyFields.forEach(el => {
                el.style.display = isLand ? 'block' : 'none';
            });
        }

        const typeSel = document.getElementById('listing_type_select');
        const catSel = document.getElementById('category_select');
        const groupCheck = document.getElementById('supports_group_renting_check');

        if (typeSel) typeSel.addEventListener('change', updateListingFormFields);
        if (catSel) catSel.addEventListener('change', updateListingFormFields);
        if (groupCheck) {
            groupCheck.addEventListener('change', function(e) {
                const groupSize = document.getElementById('group_size_container');
                if (groupSize) groupSize.style.display = e.target.checked ? 'block' : 'none';
            });
        }

        document.addEventListener('DOMContentLoaded', updateListingFormFields);
        updateListingFormFields();

        // Photo Upload Management with DataTransfer
        let selectedFiles = [];
        const uploadZone = document.getElementById('image-upload-zone');
        const picker = document.getElementById('property-images-picker');
        const submitInput = document.getElementById('property-images-submit');
        const previews = document.getElementById('image-previews-container');
        const errEl = document.getElementById('image-error');

        if (uploadZone && picker && submitInput) {
            uploadZone.addEventListener('click', () => picker.click());

            ['dragenter', 'dragover'].forEach(name => {
                uploadZone.addEventListener(name, (e) => {
                    e.preventDefault();
                    uploadZone.classList.add('border-steelAzure', 'bg-slate-100/60');
                });
            });

            ['dragleave', 'drop'].forEach(name => {
                uploadZone.addEventListener(name, (e) => {
                    e.preventDefault();
                    uploadZone.classList.remove('border-steelAzure', 'bg-slate-100/60');
                });
            });

            uploadZone.addEventListener('drop', (e) => {
                handleSelected(e.dataTransfer.files);
            });

            picker.addEventListener('change', (e) => {
                handleSelected(e.target.files);
            });
        }

        function handleSelected(files) {
            if (!errEl) return;
            errEl.classList.add('hidden');

            if (selectedFiles.length + files.length > 5) {
                errEl.innerText = 'You can upload a maximum of 5 images.';
                errEl.classList.remove('hidden');
                return;
            }

            for (let i = 0; i < files.length; i++) {
                const f = files[i];
                if (!f.type.match('image.*')) {
                    errEl.innerText = 'Only image files are allowed.';
                    errEl.classList.remove('hidden');
                    continue;
                }
                if (f.size > 10 * 1024 * 1024) {
                    errEl.innerText = 'Each image must be smaller than 10MB.';
                    errEl.classList.remove('hidden');
                    continue;
                }
                selectedFiles.push(f);
            }

            renderPreviews();
            syncSubmitInput();
            if (picker) picker.value = '';
        }

        function renderPreviews() {
            if (!previews) return;
            previews.innerHTML = '';
            if (selectedFiles.length === 0) {
                previews.classList.add('hidden');
                return;
            }
            previews.classList.remove('hidden');

            selectedFiles.forEach((file, idx) => {
                const reader = new FileReader();
                const wrap = document.createElement('div');
                wrap.className = 'relative aspect-square bg-slate-100 rounded-xl overflow-hidden border border-slate-200 shadow-xs';

                const img = document.createElement('img');
                img.className = 'w-full h-full object-cover';
                wrap.appendChild(img);

                const del = document.createElement('button');
                del.type = 'button';
                del.className = 'absolute top-1 right-1 bg-rose-600 text-white rounded-full p-1 opacity-90 hover:opacity-100 transition shadow-md border-0 cursor-pointer';
                del.innerHTML = `<svg xmlns="http://www.w3.org/2000/svg" class="h-3 w-3" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M6 18L18 6M6 6l12 12" /></svg>`;
                del.onclick = (e) => {
                    e.stopPropagation();
                    selectedFiles.splice(idx, 1);
                    renderPreviews();
                    syncSubmitInput();
                };
                wrap.appendChild(del);

                reader.onload = (e) => { img.src = e.target.result; };
                reader.readAsDataURL(file);
                previews.appendChild(wrap);
            });
        }

        function syncSubmitInput() {
            if (!submitInput) return;
            const dt = new DataTransfer();
            selectedFiles.forEach(f => dt.items.add(f));
            submitInput.files = dt.files;
        }

        window.fetchCurrentLocationWeb = function() {
            const addressInput = document.getElementById('listing-address');
            const latInput = document.getElementById('listing-latitude');
            const lngInput = document.getElementById('listing-longitude');
            const loadingSpan = document.getElementById('loc-loading');

            if (navigator.geolocation) {
                if (loadingSpan) loadingSpan.classList.remove('hidden');
                navigator.geolocation.getCurrentPosition((pos) => {
                    const lat = pos.coords.latitude;
                    const lng = pos.coords.longitude;
                    if (latInput) latInput.value = lat;
                    if (lngInput) lngInput.value = lng;

                    fetch(`https://nominatim.openstreetmap.org/reverse?lat=${lat}&lon=${lng}&format=json`)
                        .then(r => r.json())
                        .then(data => {
                            if (loadingSpan) loadingSpan.classList.add('hidden');
                            if (data && data.display_name && addressInput) {
                                addressInput.value = data.display_name;
                            }
                            if (data && data.address && data.address.country) {
                                const cInput = document.getElementById('listing-country');
                                if (cInput) cInput.value = data.address.country;
                            }
                        })
                        .catch(err => {
                            console.error('Error resolving address:', err);
                            if (loadingSpan) loadingSpan.classList.add('hidden');
                        });
                }, (err) => {
                    alert('Location access failed: ' + err.message);
                    if (loadingSpan) loadingSpan.classList.add('hidden');
                });
            } else {
                alert('Geolocation is not supported by your browser.');
            }
        };
    })();
</script>
