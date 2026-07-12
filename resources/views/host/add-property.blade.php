@extends('layouts.app')

@section('content')
<div class="max-w-3xl mx-auto px-6 py-12" x-data="{ step: 1 }">
    <div class="mb-8">
        <h1 class="text-3xl font-extrabold text-slate-800">List Your Property</h1>
        <p class="text-slate-500 mt-2">Become a host and start earning today.</p>
        
        <!-- Progress Bar -->
        <div class="w-full bg-slate-200 h-2 rounded-full mt-6">
            <div class="bg-steelAzure h-2 rounded-full transition-all duration-300" :style="'width: ' + (step * 20) + '%'"></div>
        </div>
    </div>

    @if ($errors->any())
        <div class="bg-red-50 text-red-600 p-4 rounded-xl mb-6 text-sm">
            <ul class="list-disc pl-5">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('host.add-property') }}" method="POST" enctype="multipart/form-data" class="bg-white p-8 rounded-2xl border border-slate-200 shadow-xl shadow-slate-200/50">
        @csrf
        
        <!-- Step 1: Basics -->
        <div x-show="step === 1" x-transition:enter="transition ease-out duration-300" x-transition:enter-start="opacity-0 translate-y-4" x-transition:enter-end="opacity-100 translate-y-0">
            <h2 class="text-xl font-bold text-slate-800 mb-6">1. The Basics</h2>
            <div class="space-y-5">
                <div>
                    <label class="block text-sm font-semibold text-slate-700 mb-1">Title <span class="text-rose-500">*</span></label>
                    <input type="text" name="title" required class="w-full rounded-xl border-slate-300 focus:border-steelAzure focus:ring focus:ring-steelAzure/20 transition" placeholder="e.g. Cozy Beachfront Villa">
                </div>
                <div>
                    <label class="block text-sm font-semibold text-slate-700 mb-1">Category <span class="text-rose-500">*</span></label>
                    <select name="category" required class="w-full rounded-xl border-slate-300 focus:border-steelAzure focus:ring focus:ring-steelAzure/20 transition">
                        <option value="Apartment">Apartment</option>
                        <option value="House">House</option>
                        <option value="Villa">Villa</option>
                        <option value="Cabin">Cabin</option>
                        <option value="Studio">Studio</option>
                    </select>
                </div>
                <div>
                    <label class="block text-sm font-semibold text-slate-700 mb-1">Listing Type <span class="text-rose-500">*</span></label>
                    <div class="flex gap-4">
                        <label class="flex items-center gap-2 bg-slate-50 border border-slate-200 px-4 py-3 rounded-xl cursor-pointer hover:bg-slate-100 flex-1">
                            <input type="radio" name="listing_type" value="rent" checked class="text-steelAzure focus:ring-steelAzure">
                            <span class="font-semibold text-slate-700">For Rent</span>
                        </label>
                        <label class="flex items-center gap-2 bg-slate-50 border border-slate-200 px-4 py-3 rounded-xl cursor-pointer hover:bg-slate-100 flex-1">
                            <input type="radio" name="listing_type" value="sale" class="text-steelAzure focus:ring-steelAzure">
                            <span class="font-semibold text-slate-700">For Sale</span>
                        </label>
                    </div>
                </div>
                <div>
                    <label class="block text-sm font-semibold text-slate-700 mb-1">Description <span class="text-rose-500">*</span></label>
                    <textarea name="description" required rows="4" class="w-full rounded-xl border-slate-300 focus:border-steelAzure focus:ring focus:ring-steelAzure/20 transition" placeholder="Describe your place..."></textarea>
                </div>
            </div>
            <div class="mt-8 flex justify-end">
                <button type="button" @click="step++" class="px-6 py-3 bg-slate-800 hover:bg-slate-700 text-white font-bold rounded-xl transition shadow-md">Next Step &rarr;</button>
            </div>
        </div>

        <!-- Step 2: Location -->
        <div x-show="step === 2" style="display: none;" x-transition:enter="transition ease-out duration-300" x-transition:enter-start="opacity-0 translate-y-4" x-transition:enter-end="opacity-100 translate-y-0">
            <h2 class="text-xl font-bold text-slate-800 mb-6">2. Location</h2>
            <div class="space-y-5">
                <div>
                    <label class="block text-sm font-semibold text-slate-700 mb-1">Country</label>
                    <input type="text" name="country" class="w-full rounded-xl border-slate-300 focus:border-steelAzure focus:ring focus:ring-steelAzure/20 transition" placeholder="e.g. United States">
                </div>
                <div>
                    <label class="block text-sm font-semibold text-slate-700 mb-1">Full Address <span class="text-rose-500">*</span></label>
                    <textarea name="address" required rows="3" class="w-full rounded-xl border-slate-300 focus:border-steelAzure focus:ring focus:ring-steelAzure/20 transition" placeholder="Street, City, State, ZIP"></textarea>
                </div>
                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <label class="block text-sm font-semibold text-slate-700 mb-1">Latitude</label>
                        <input type="number" step="any" name="latitude" class="w-full rounded-xl border-slate-300 focus:border-steelAzure focus:ring focus:ring-steelAzure/20 transition" placeholder="Optional">
                    </div>
                    <div>
                        <label class="block text-sm font-semibold text-slate-700 mb-1">Longitude</label>
                        <input type="number" step="any" name="longitude" class="w-full rounded-xl border-slate-300 focus:border-steelAzure focus:ring focus:ring-steelAzure/20 transition" placeholder="Optional">
                    </div>
                </div>
            </div>
            <div class="mt-8 flex justify-between">
                <button type="button" @click="step--" class="px-6 py-3 bg-slate-100 hover:bg-slate-200 text-slate-700 font-bold rounded-xl transition">&larr; Back</button>
                <button type="button" @click="step++" class="px-6 py-3 bg-slate-800 hover:bg-slate-700 text-white font-bold rounded-xl transition shadow-md">Next Step &rarr;</button>
            </div>
        </div>

        <!-- Step 3: Details -->
        <div x-show="step === 3" style="display: none;" x-transition:enter="transition ease-out duration-300" x-transition:enter-start="opacity-0 translate-y-4" x-transition:enter-end="opacity-100 translate-y-0">
            <h2 class="text-xl font-bold text-slate-800 mb-6">3. Details</h2>
            <div class="space-y-5">
                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <label class="block text-sm font-semibold text-slate-700 mb-1">Bedrooms <span class="text-rose-500">*</span></label>
                        <input type="number" name="bedrooms" required min="0" value="1" class="w-full rounded-xl border-slate-300 focus:border-steelAzure focus:ring focus:ring-steelAzure/20 transition">
                    </div>
                    <div>
                        <label class="block text-sm font-semibold text-slate-700 mb-1">Bathrooms <span class="text-rose-500">*</span></label>
                        <input type="number" name="bathrooms" required min="0" value="1" class="w-full rounded-xl border-slate-300 focus:border-steelAzure focus:ring focus:ring-steelAzure/20 transition">
                    </div>
                </div>
                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <label class="block text-sm font-semibold text-slate-700 mb-1">Built-up Area (sq ft)</label>
                        <input type="number" name="built_up_area" min="0" class="w-full rounded-xl border-slate-300 focus:border-steelAzure focus:ring focus:ring-steelAzure/20 transition">
                    </div>
                </div>
                <div class="pt-4 border-t border-slate-100 space-y-3">
                    <label class="flex items-center gap-3 cursor-pointer">
                        <input type="checkbox" name="is_furnished" value="1" class="w-5 h-5 text-steelAzure rounded focus:ring-steelAzure">
                        <span class="text-slate-700 font-medium">Is Furnished</span>
                    </label>
                    <label class="flex items-center gap-3 cursor-pointer">
                        <input type="checkbox" name="has_parking" value="1" class="w-5 h-5 text-steelAzure rounded focus:ring-steelAzure">
                        <span class="text-slate-700 font-medium">Has Parking</span>
                    </label>
                    <label class="flex items-center gap-3 cursor-pointer">
                        <input type="checkbox" name="is_pet_friendly" value="1" class="w-5 h-5 text-steelAzure rounded focus:ring-steelAzure">
                        <span class="text-slate-700 font-medium">Pet Friendly</span>
                    </label>
                </div>
            </div>
            <div class="mt-8 flex justify-between">
                <button type="button" @click="step--" class="px-6 py-3 bg-slate-100 hover:bg-slate-200 text-slate-700 font-bold rounded-xl transition">&larr; Back</button>
                <button type="button" @click="step++" class="px-6 py-3 bg-slate-800 hover:bg-slate-700 text-white font-bold rounded-xl transition shadow-md">Next Step &rarr;</button>
            </div>
        </div>

        <!-- Step 4: Pricing -->
        <div x-show="step === 4" style="display: none;" x-transition:enter="transition ease-out duration-300" x-transition:enter-start="opacity-0 translate-y-4" x-transition:enter-end="opacity-100 translate-y-0">
            <h2 class="text-xl font-bold text-slate-800 mb-6">4. Pricing</h2>
            <div class="space-y-5">
                <div>
                    <label class="block text-sm font-semibold text-slate-700 mb-1">Price <span class="text-rose-500">*</span></label>
                    <div class="flex gap-2">
                        <select name="currency" class="w-24 rounded-xl border-slate-300 focus:border-steelAzure focus:ring focus:ring-steelAzure/20 transition">
                            <option value="USD">USD</option>
                            <option value="EUR">EUR</option>
                            <option value="GBP">GBP</option>
                            <option value="INR">INR</option>
                        </select>
                        <input type="number" name="price" required min="0" step="any" class="flex-1 rounded-xl border-slate-300 focus:border-steelAzure focus:ring focus:ring-steelAzure/20 transition" placeholder="e.g. 1500">
                    </div>
                </div>
                <div>
                    <label class="block text-sm font-semibold text-slate-700 mb-1">Billing Frequency</label>
                    <select name="billing_frequency" class="w-full rounded-xl border-slate-300 focus:border-steelAzure focus:ring focus:ring-steelAzure/20 transition">
                        <option value="monthly">Monthly</option>
                        <option value="per_day">Per Day / Nightly</option>
                        <option value="hourly">Hourly</option>
                    </select>
                </div>
            </div>
            <div class="mt-8 flex justify-between">
                <button type="button" @click="step--" class="px-6 py-3 bg-slate-100 hover:bg-slate-200 text-slate-700 font-bold rounded-xl transition">&larr; Back</button>
                <button type="button" @click="step++" class="px-6 py-3 bg-slate-800 hover:bg-slate-700 text-white font-bold rounded-xl transition shadow-md">Next Step &rarr;</button>
            </div>
        </div>

        <!-- Step 5: Photos -->
        <div x-show="step === 5" style="display: none;" x-transition:enter="transition ease-out duration-300" x-transition:enter-start="opacity-0 translate-y-4" x-transition:enter-end="opacity-100 translate-y-0">
            <h2 class="text-xl font-bold text-slate-800 mb-6">5. Photos</h2>
            <div class="space-y-5">
                <div>
                    <label class="block text-sm font-semibold text-slate-700 mb-1">Upload Images (Max 5)</label>
                    <div class="mt-2 flex justify-center rounded-2xl border-2 border-dashed border-slate-300 px-6 py-10 hover:bg-slate-50 transition cursor-pointer" onclick="document.getElementById('file-upload').click()">
                        <div class="text-center">
                            <svg class="mx-auto h-12 w-12 text-slate-300" viewBox="0 0 24 24" fill="currentColor" aria-hidden="true">
                                <path fill-rule="evenodd" d="M1.5 6a2.25 2.25 0 012.25-2.25h16.5A2.25 2.25 0 0122.5 6v12a2.25 2.25 0 01-2.25 2.25H3.75A2.25 2.25 0 011.5 18V6zM3 16.06V18c0 .414.336.75.75.75h16.5A.75.75 0 0021 18v-1.94l-2.69-2.689a1.5 1.5 0 00-2.12 0l-.88.879.97.97a.75.75 0 11-1.06 1.06l-5.16-5.159a1.5 1.5 0 00-2.12 0L3 16.061zm10.125-7.81a1.125 1.125 0 112.25 0 1.125 1.125 0 01-2.25 0z" clip-rule="evenodd" />
                            </svg>
                            <div class="mt-4 flex text-sm leading-6 text-slate-600 justify-center">
                                <span class="relative cursor-pointer rounded-md bg-white font-semibold text-steelAzure focus-within:outline-none hover:text-steelAzure/80">
                                    <span>Upload files</span>
                                    <input id="file-upload" name="images[]" type="file" multiple accept="image/*" class="sr-only" onchange="document.getElementById('file-names').textContent = this.files.length + ' file(s) selected'">
                                </span>
                            </div>
                            <p class="text-xs leading-5 text-slate-500 mt-1">PNG, JPG, GIF up to 10MB each</p>
                            <p id="file-names" class="text-sm font-bold text-steelAzure mt-2"></p>
                        </div>
                    </div>
                </div>
            </div>
            
            <div class="mt-8 flex justify-between items-center pt-6 border-t border-slate-100">
                <button type="button" @click="step--" class="px-6 py-3 bg-slate-100 hover:bg-slate-200 text-slate-700 font-bold rounded-xl transition">&larr; Back</button>
                <button type="submit" class="px-8 py-3 bg-gradient-to-r from-steelAzure to-[#1a365d] hover:opacity-90 text-white font-extrabold rounded-xl transition shadow-lg flex items-center gap-2">
                    Submit Listing
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd" />
                    </svg>
                </button>
            </div>
        </div>
    </form>
</div>
@endsection
