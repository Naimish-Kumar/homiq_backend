@extends('layouts.app')

@section('content')

<!-- Page Header / Breadcrumbs -->
<section class="max-w-7xl mx-auto px-6 pt-10 pb-6">
    <nav class="flex items-center gap-2 text-xs text-slate-400 font-semibold mb-6">
        <a href="/" class="hover:text-steelAzure flex items-center gap-1 transition">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-3.5 w-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6" />
            </svg>
            Home
        </a>
        <svg xmlns="http://www.w3.org/2000/svg" class="h-3 w-3 text-slate-300" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M9 5l7 7-7 7" />
        </svg>
        <span class="text-slate-300">Category</span>
        <svg xmlns="http://www.w3.org/2000/svg" class="h-3 w-3 text-slate-300" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M9 5l7 7-7 7" />
        </svg>
        <span class="text-steelAzure uppercase tracking-wider">{{ $name }}</span>
    </nav>

    <div class="border-b border-slate-100 pb-8">
        <h1 class="text-3xl md:text-4xl font-extrabold text-slate-800 tracking-tight">
            {{ $name }} Spaces
        </h1>
        <p class="text-sm text-slate-400 mt-2">Explore the finest, verified {{ strtolower($name) }}s listed in our network.</p>
    </div>
</section>


<!-- Listings Section -->
<section class="max-w-7xl mx-auto px-6 py-12">
    @if ($properties->isEmpty())
        <div class="text-center py-20 bg-white border border-slate-100 rounded-2xl">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-16 w-16 text-slate-200 mx-auto mb-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4" />
            </svg>
            <h3 class="font-extrabold text-slate-700 text-lg">No Listings Found</h3>
            <p class="text-xs text-slate-400 mt-1 max-w-sm mx-auto">There are currently no approved properties listed under the {{ $name }} category. Check back later or explore other spaces.</p>
        </div>
    @else
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-8">
            @foreach ($properties as $prop)
                <x-property-card :property="$prop" />
            @endforeach
        </div>
    @endif
</section>
@endsection
