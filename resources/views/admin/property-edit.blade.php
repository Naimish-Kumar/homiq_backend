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
            <div class="space-y-1.5">
                <label class="block text-[9px] font-extrabold text-slate-400 uppercase tracking-widest">Pricing Frequency</label>
                <select name="billing_frequency" required
                        class="w-full px-4 py-3 bg-slate-50 border border-slate-200/60 rounded-md text-slate-850 text-xs font-semibold focus:outline-none focus:border-[#187053] transition-colors">
                    <option value="monthly" {{ old('billing_frequency', $property->billing_frequency) === 'monthly' ? 'selected' : '' }}>Monthly</option>
                    <option value="per_day" {{ old('billing_frequency', $property->billing_frequency) === 'per_day' ? 'selected' : '' }}>Per Day</option>
                    <option value="hourly" {{ old('billing_frequency', $property->billing_frequency) === 'hourly' ? 'selected' : '' }}>Hourly</option>
                </select>
            </div>
        </div>

        <!-- Category dropdown -->
        <div class="space-y-1.5">
            <label class="block text-[9px] font-extrabold text-slate-400 uppercase tracking-widest">Property Category</label>
            <select name="category" required
                    class="w-full px-4 py-3 bg-slate-50 border border-slate-200/60 rounded-md text-slate-850 text-xs font-semibold focus:outline-none focus:border-[#187053] transition-colors">
                @foreach ($categoriesList as $cat)
                    <option value="{{ $cat }}" {{ old('category', $property->category) === $cat ? 'selected' : '' }}>{{ $cat }}</option>
                @endforeach
            </select>
        </div>

        <div class="grid grid-cols-2 gap-4">
            <!-- Bedrooms field -->
            <div class="space-y-1.5">
                <label class="block text-[9px] font-extrabold text-slate-400 uppercase tracking-widest">Bedrooms Count</label>
                <input type="number" name="bedrooms" value="{{ old('bedrooms', $property->bedrooms) }}" required min="0"
                       class="w-full px-4 py-3 bg-slate-50 border border-slate-200/60 rounded-md text-slate-850 text-xs font-semibold focus:outline-none focus:border-[#187053] transition-colors">
            </div>

            <!-- Bathrooms field -->
            <div class="space-y-1.5">
                <label class="block text-[9px] font-extrabold text-slate-400 uppercase tracking-widest">Bathrooms Count</label>
                <input type="number" name="bathrooms" value="{{ old('bathrooms', $property->bathrooms) }}" required min="0"
                       class="w-full px-4 py-3 bg-slate-50 border border-slate-200/60 rounded-md text-slate-850 text-xs font-semibold focus:outline-none focus:border-[#187053] transition-colors">
            </div>
        </div>

        <!-- Description field -->
        <div class="space-y-1.5">
            <label class="block text-[9px] font-extrabold text-slate-400 uppercase tracking-widest">Detailed Description</label>
            <textarea name="description" rows="5" required
                      class="w-full px-4 py-3 bg-slate-50 border border-slate-200/60 rounded-md text-slate-850 text-xs font-semibold focus:outline-none focus:border-[#187053] transition-colors leading-relaxed">{{ old('description', $property->description) }}</textarea>
        </div>

        <!-- Key Features toggles -->
        <div class="border-t border-slate-100 pt-6">
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
