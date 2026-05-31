@extends('admin.layout')

@section('page_title', 'Page Settings')

@section('content')
<div class="mb-6 max-w-3xl mx-auto relative z-10">
    <p class="text-xs text-slate-650 leading-relaxed font-semibold">
        Manage the content of HomiQ's public-facing static pages. Click "Edit Content" on any page to open the interactive HTML editor and customize the details instantly.
    </p>
</div>

<!-- Pages Management Panel -->
<div class="bg-white rounded-2xl border border-slate-200/60 shadow-sm overflow-hidden max-w-4xl mx-auto relative z-10">
    <div class="overflow-x-auto">
        <table class="w-full text-left text-xs border-collapse">
            <thead>
                <tr class="text-slate-400 font-bold border-b border-slate-100 bg-slate-50/50">
                    <th class="p-4 pl-6">Page Title</th>
                    <th class="p-4">Route Slug</th>
                    <th class="p-4">Public URL</th>
                    <th class="p-4">Last Modified</th>
                    <th class="p-4 pr-6 text-right">Actions</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-slate-100/70">
                @foreach ($pages as $page)
                    <tr class="text-slate-650 font-medium hover:bg-slate-50/30 transition">
                        <td class="p-4 pl-6">
                            <div class="flex items-center gap-3">
                                <div class="h-8 w-8 rounded-lg bg-emerald-50 border border-emerald-100 text-[#187053] flex items-center justify-center font-bold text-xs">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4.5 w-4.5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                                    </svg>
                                </div>
                                <span class="font-extrabold text-slate-800 text-xs">{{ $page->title }}</span>
                            </div>
                        </td>
                        <td class="p-4">
                            <span class="px-2 py-0.5 bg-slate-100 text-slate-650 rounded font-mono text-[10px] border border-slate-200/50">
                                {{ $page->slug }}
                            </span>
                        </td>
                        <td class="p-4">
                            <a href="/{{ $page->slug }}" target="_blank" class="text-[#187053] hover:underline flex items-center gap-1 font-bold">
                                <span>/{{ $page->slug }}</span>
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-3 w-3" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14" />
                                </svg>
                            </a>
                        </td>
                        <td class="p-4 text-slate-400">
                            {{ $page->updated_at->diffForHumans() }}
                        </td>
                        <td class="p-4 pr-6 text-right">
                            <a href="/admin/settings/{{ $page->slug }}" class="inline-block px-3.5 py-2 bg-[#187053] hover:bg-[#12563f] text-white text-[10px] font-extrabold rounded-lg shadow transition">
                                Edit Content
                            </a>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
@endsection

