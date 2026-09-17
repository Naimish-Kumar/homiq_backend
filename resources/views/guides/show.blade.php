@extends('layouts.app')

@section('title', $guide['title'] . ' | HomiQ Guides')
@section('meta_description', $guide['meta_description'])
@section('canonical_url', url('/guides/' . $guide['slug']))

@section('structured_data')
<script type="application/ld+json">
{
  "@@context": "https://schema.org",
  "@@graph": [
    {
      "@@type": "Article",
      "headline": "{{ $guide['title'] }}",
      "description": "{{ $guide['meta_description'] }}",
      "image": "{{ $guide['image'] }}",
      "datePublished": "2026-09-01T08:00:00+05:30",
      "dateModified": "2026-09-16T12:00:00+05:30",
      "author": {
        "@@type": "Organization",
        "name": "HomiQ Editorial & Research Team",
        "url": "{{ url('/') }}"
      },
      "publisher": {
        "@@type": "Organization",
        "name": "HomiQ Real Estate",
        "logo": {
          "@@type": "ImageObject",
          "url": "{{ asset('logo.png') }}"
        }
      },
      "mainEntityOfPage": {
        "@@type": "WebPage",
        "@@id": "{{ url('/guides/' . $guide['slug']) }}"
      }
    },
    {
      "@@type": "BreadcrumbList",
      "itemListElement": [
        {
          "@@type": "ListItem",
          "position": 1,
          "name": "Home",
          "item": "{{ url('/') }}"
        },
        {
          "@@type": "ListItem",
          "position": 2,
          "name": "Guides",
          "item": "{{ url('/guides') }}"
        },
        {
          "@@type": "ListItem",
          "position": 3,
          "name": "{{ $guide['title'] }}",
          "item": "{{ url('/guides/' . $guide['slug']) }}"
        }
      ]
    }
    @if(!empty($guide['faqs']))
    ,
    {
      "@@type": "FAQPage",
      "mainEntity": [
        @foreach($guide['faqs'] as $index => $faq)
        {
          "@@type": "Question",
          "name": "{{ addslashes($faq['q']) }}",
          "acceptedAnswer": {
            "@@type": "Answer",
            "text": "{{ addslashes($faq['a']) }}"
          }
        }
        @if(!$loop->last),@endif
        @endforeach
      ]
    }
    @endif
  ]
}
</script>
@endsection

@section('content')
<div class="bg-slate-50 min-h-screen py-8">
    <div class="max-w-[1440px] mx-auto px-6 sm:px-8">

        <!-- Breadcrumb Navigation -->
        <nav class="flex mb-6 text-sm text-slate-500" aria-label="Breadcrumb">
            <ol class="inline-flex items-center space-x-2 flex-wrap">
                <li>
                    <a href="{{ url('/') }}" class="hover:text-primary transition flex items-center gap-1">
                        <span class="material-symbols-outlined text-[18px]">home</span>
                        <span>Home</span>
                    </a>
                </li>
                <li><span class="text-slate-400">/</span></li>
                <li>
                    <a href="{{ url('/guides') }}" class="hover:text-primary transition">Guides</a>
                </li>
                <li><span class="text-slate-400">/</span></li>
                <li class="font-medium text-slate-800 line-clamp-1 max-w-xs sm:max-w-md">{{ $guide['title'] }}</li>
            </ol>
        </nav>

        <!-- Main Layout with Sidebar -->
        <div class="grid grid-cols-1 lg:grid-cols-12 gap-10">

            <!-- Main Article Column (8 Cols) -->
            <article class="lg:col-span-8 bg-white rounded-3xl border border-slate-200 p-6 sm:p-10 shadow-sm">
                
                <!-- Category & Read Time -->
                <div class="flex items-center gap-3 mb-4">
                    <span class="bg-primary/10 text-primary font-bold text-xs px-3 py-1 rounded-full uppercase tracking-wider">
                        {{ $guide['category'] }}
                    </span>
                    <span class="text-slate-400 text-xs flex items-center gap-1">
                        <span class="material-symbols-outlined text-xs">schedule</span>
                        {{ $guide['read_time'] }}
                    </span>
                    <span class="text-slate-400 text-xs">Published {{ $guide['published_at'] }}</span>
                </div>

                <!-- Main Title H1 -->
                <h1 class="text-2xl sm:text-4xl font-black text-slate-900 leading-tight mb-6">
                    {{ $guide['title'] }}
                </h1>

                <!-- Hero Image -->
                <div class="aspect-video w-full rounded-2xl overflow-hidden mb-8 bg-slate-100 shadow-inner">
                    <img src="{{ $guide['image'] }}" alt="{{ $guide['title'] }}" class="w-full h-full object-cover">
                </div>

                <!-- Editorial Disclaimer -->
                <div class="bg-slate-50 border-l-4 border-primary p-4 rounded-r-xl mb-8 flex items-start gap-3">
                    <span class="material-symbols-outlined text-primary text-xl mt-0.5">verified_user</span>
                    <div class="text-xs text-slate-600 leading-relaxed">
                        <strong>HomiQ Market Intelligence:</strong> This guide has been verified against current Uttar Pradesh & Delhi NCR urban tenancy rules and live market listings on HomiQ.
                    </div>
                </div>

                <!-- Article Body Content -->
                <div class="prose prose-slate max-w-none prose-headings:font-bold prose-headings:text-slate-900 prose-h2:text-2xl prose-h2:mt-8 prose-h2:mb-4 prose-h3:text-lg prose-h3:mt-6 prose-h3:mb-2 prose-p:text-slate-700 prose-p:leading-relaxed prose-p:mb-4 prose-li:text-slate-700 prose-strong:text-slate-900">
                    {!! $guide['content'] !!}
                </div>

                <!-- Related Location Action Banner -->
                @if(!empty($guide['related_location']))
                    <div class="mt-10 p-6 rounded-2xl bg-gradient-to-r from-primary/10 via-primary/5 to-transparent border border-primary/20 flex flex-col sm:flex-row items-start sm:items-center justify-between gap-4">
                        <div>
                            <div class="text-xs font-bold uppercase tracking-wider text-primary mb-1">Explore Properties</div>
                            <h3 class="text-base font-bold text-slate-900">{{ $guide['related_location_label'] }}</h3>
                        </div>
                        <a href="{{ url($guide['related_location']) }}" class="inline-flex items-center gap-1.5 px-5 py-2.5 bg-primary text-white text-sm font-bold rounded-xl hover:bg-primary-dark transition shrink-0 shadow-sm">
                            <span>Browse Listings</span>
                            <span class="material-symbols-outlined text-sm">arrow_forward</span>
                        </a>
                    </div>
                @endif

                <!-- Frequently Asked Questions Accordion -->
                @if(!empty($guide['faqs']))
                    <div class="mt-12 pt-8 border-t border-slate-100">
                        <h2 class="text-xl font-bold text-slate-900 mb-6 flex items-center gap-2">
                            <span class="material-symbols-outlined text-primary">quiz</span>
                            Frequently Asked Questions
                        </h2>
                        <div class="space-y-4">
                            @foreach($guide['faqs'] as $index => $faq)
                                <details class="group bg-slate-50 border border-slate-200 rounded-xl p-4 transition-all [&_summary::-webkit-details-marker]:hidden" {{ $index === 0 ? 'open' : '' }}>
                                    <summary class="flex items-center justify-between cursor-pointer font-bold text-slate-800 text-sm hover:text-primary">
                                        <span>{{ $faq['q'] }}</span>
                                        <span class="material-symbols-outlined text-slate-400 transition-transform group-open:rotate-180">expand_more</span>
                                    </summary>
                                    <div class="mt-3 text-sm text-slate-600 leading-relaxed pt-3 border-t border-slate-200">
                                        {{ $faq['a'] }}
                                    </div>
                                </details>
                            @endforeach
                        </div>
                    </div>
                @endif

            </article>

            <!-- Sidebar (4 Cols) -->
            <aside class="lg:col-span-4 space-y-8">
                
                <!-- Owner CTA Banner -->
                <div class="bg-gradient-to-br from-slate-900 to-slate-800 text-white rounded-3xl p-6 shadow-md border border-slate-800">
                    <div class="inline-flex items-center gap-1.5 px-2.5 py-1 bg-emerald-500/20 text-emerald-400 text-[11px] font-bold rounded-full mb-3">
                        <span class="material-symbols-outlined text-xs">bolt</span>
                        0% Commission
                    </div>
                    <h3 class="text-lg font-black mb-2">Have a Property in Noida or NCR?</h3>
                    <p class="text-slate-300 text-xs leading-relaxed mb-5">
                        List directly on HomiQ to connect with verified tenants and buyers without paying broker fees.
                    </p>
                    <a href="{{ url('/list-property') }}" class="w-full inline-flex items-center justify-center gap-2 px-4 py-3 bg-primary text-white font-bold rounded-xl hover:bg-primary-dark transition text-sm">
                        <span>List Your Property Free</span>
                        <span class="material-symbols-outlined text-sm">arrow_forward</span>
                    </a>
                </div>

                <!-- Recent Verified Listings -->
                @if(isset($recentProperties) && $recentProperties->isNotEmpty())
                    <div class="bg-white rounded-3xl border border-slate-200 p-6 shadow-sm">
                        <h3 class="text-base font-bold text-slate-900 mb-4 flex items-center gap-2">
                            <span class="material-symbols-outlined text-primary text-lg">verified</span>
                            Verified Listings
                        </h3>
                        <div class="space-y-4">
                            @foreach($recentProperties as $prop)
                                <a href="{{ $prop->seo_url }}" class="flex gap-3 group items-center">
                                    <img src="{{ $prop->featured_image_url }}" alt="{{ $prop->title }}" class="w-16 h-16 rounded-xl object-cover bg-slate-100 group-hover:opacity-90 shrink-0">
                                    <div class="flex-1 min-w-0">
                                        <h4 class="text-xs font-bold text-slate-800 group-hover:text-primary transition truncate">
                                            {{ $prop->title }}
                                        </h4>
                                        <p class="text-[11px] text-slate-500 truncate">{{ $prop->address }}</p>
                                        <p class="text-xs font-extrabold text-primary mt-1">₹{{ number_format($prop->price) }}<span class="text-[10px] font-normal text-slate-400">/mo</span></p>
                                    </div>
                                </a>
                            @endforeach
                        </div>
                        <a href="{{ url('/') }}" class="mt-5 block text-center text-xs font-bold text-primary hover:underline">
                            View all properties →
                        </a>
                    </div>
                @endif

                <!-- Other Guides -->
                @if(isset($relatedGuides) && !empty($relatedGuides))
                    <div class="bg-white rounded-3xl border border-slate-200 p-6 shadow-sm">
                        <h3 class="text-base font-bold text-slate-900 mb-4 flex items-center gap-2">
                            <span class="material-symbols-outlined text-primary text-lg">menu_book</span>
                            More Guides & Insights
                        </h3>
                        <div class="space-y-4">
                            @foreach($relatedGuides as $rGuide)
                                <div class="border-b border-slate-100 pb-3 last:border-0 last:pb-0">
                                    <div class="text-[11px] text-primary font-bold uppercase tracking-wide">{{ $rGuide['category'] }}</div>
                                    <a href="{{ url('/guides/' . $rGuide['slug']) }}" class="text-xs font-bold text-slate-800 hover:text-primary transition line-clamp-2 mt-0.5">
                                        {{ $rGuide['title'] }}
                                    </a>
                                </div>
                            @endforeach
                        </div>
                    </div>
                @endif

            </aside>

        </div>

    </div>
</div>
@endsection
