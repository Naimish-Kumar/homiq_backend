@extends('layouts.app')

@section('content')
<div class="min-h-screen bg-slate-50/50 py-10 px-4 sm:px-6 lg:px-8">
    <div class="max-w-4xl mx-auto space-y-6">
        
        <!-- Header Breadcrumb & Title -->
        <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 bg-white p-6 sm:p-8 rounded-3xl border border-slate-200 shadow-xs">
            <div>
                <div class="flex items-center gap-2 text-[11px] font-bold text-slate-400 uppercase tracking-wider mb-1">
                    <a href="/dashboard" class="hover:text-steelAzure transition">Dashboard</a>
                    <span>/</span>
                    <span class="text-steelAzure">List Space</span>
                </div>
                <h1 class="text-2xl sm:text-3xl font-black text-slate-900 tracking-tight">List Your Property Space</h1>
                <p class="text-xs sm:text-sm text-slate-500 font-medium mt-1">Submit your property for instant discovery with zero brokerage.</p>
            </div>
            <a href="/dashboard" class="inline-flex items-center gap-2 px-4 py-2.5 rounded-xl border border-slate-200 text-xs font-bold text-slate-700 hover:bg-slate-50 transition shadow-2xs self-start sm:self-center">
                <span class="material-symbols-outlined text-[18px]">arrow_back</span>
                <span>Back to Dashboard</span>
            </a>
        </div>

        @if ($errors->any())
            <div class="bg-rose-50 border border-rose-200 text-rose-700 p-4 sm:p-5 rounded-2xl text-xs font-semibold space-y-1">
                <div class="flex items-center gap-1.5 font-bold text-rose-800">
                    <span class="material-symbols-outlined text-sm">error</span>
                    <span>Please correct the following errors:</span>
                </div>
                <ul class="list-disc pl-5 space-y-0.5 mt-1">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <!-- Unified Form Card -->
        <div class="bg-white p-6 sm:p-10 rounded-3xl border border-slate-200 shadow-sm space-y-6">
            <div class="flex items-center justify-between border-b border-slate-100 pb-4">
                <div class="flex items-center gap-2">
                    <span class="h-2.5 w-2.5 rounded-full bg-emerald-500 animate-pulse"></span>
                    <span class="text-xs font-black text-slate-800 uppercase tracking-wider">Submit New Listing</span>
                </div>
                <span class="text-[11px] font-bold text-slate-400">All fields with * are required</span>
            </div>

            @include('partials.property-listing-form', [
                'formAction' => route('host.add-property'),
                'categories' => $categories,
                'amenities' => $amenities,
                'specifications' => $specifications,
                'features' => $features
            ])
        </div>

    </div>
</div>
@endsection
