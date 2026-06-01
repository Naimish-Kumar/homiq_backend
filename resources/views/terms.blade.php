@extends('layouts.app')

@section('content')
<style>
    .dynamic-content h1 {
        font-size: 1.5rem;
        font-weight: 850;
        color: #1f2937;
        margin-top: 2.25rem;
        margin-bottom: 1rem;
        border-bottom: 1px solid #f1f5f9;
        padding-bottom: 0.5rem;
    }
    .dynamic-content h2 {
        font-size: 1.25rem;
        font-weight: 700;
        color: #374151;
        margin-top: 1.75rem;
        margin-bottom: 0.75rem;
    }
    .dynamic-content h3 {
        font-size: 1.1rem;
        font-weight: 600;
        color: #4b5563;
        margin-top: 1.5rem;
        margin-bottom: 0.5rem;
    }
    .dynamic-content p {
        font-size: 0.875rem;
        color: #4b5563;
        line-height: 1.75;
        margin-bottom: 1.25rem;
    }
    .dynamic-content ul {
        list-style-type: disc;
        padding-left: 1.5rem;
        font-size: 0.875rem;
        color: #4b5563;
        margin-bottom: 1.25rem;
    }
    .dynamic-content li {
        margin-bottom: 0.5rem;
    }
    .dynamic-content strong {
        color: #1f2937;
        font-weight: 700;
    }
</style>

<div class="max-w-4xl mx-auto px-6 py-16 scroll-reveal">
    <div class="bg-white rounded-3xl p-8 md:p-12 shadow-sm border border-slate-100">
        <h1 class="text-3xl font-black text-slate-800 mb-2">{{ $page->title }}</h1>
        <div class="h-1.5 w-16 bg-steelAzure rounded-full mb-8"></div>
        
        <div class="dynamic-content">
            {!! $page->content !!}
        </div>
    </div>
</div>
@endsection
