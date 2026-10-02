@extends('admin.layout')

@section('page_title', 'CMS & Legal Pages')

@section('content')
<div class="space-y-6">

    <!-- Top Telemetry & Hero Banner -->
    <div class="flex flex-col lg:flex-row lg:items-center justify-between gap-4 pb-5 border-b border-slate-200/80">
        <div>
            <div class="flex items-center gap-2 mb-1">
                <span class="px-2.5 py-0.5 rounded-full text-[10px] font-extrabold bg-emerald-50 text-emerald-700 border border-emerald-200/80 uppercase tracking-wider flex items-center gap-1.5">
                    <span class="h-1.5 w-1.5 rounded-full bg-emerald-500"></span>
                    Legal & Policy CMS
                </span>
                <span class="text-slate-300">•</span>
                <span class="text-xs text-slate-400 font-medium">Public web & mobile in-app webviews</span>
            </div>
            <h1 class="text-xl font-black text-slate-900 tracking-tight flex items-center gap-2.5">
                <span class="p-2 rounded-xl bg-gradient-to-tr from-emerald-500 to-teal-600 text-white shadow-md shadow-emerald-500/20">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 14.25v-2.625a3.375 3.375 0 00-3.375-3.375h-1.5A1.125 1.125 0 0113.5 7.125v-1.5a3.375 3.375 0 00-3.375-3.375H8.25m0 12.75h7.5m-7.53-4.5h7.5m-7.5-4.5h7.5m-7.5-4.5h7.5m-7.5-4.5h7.5M5.625 3.75h12.75c.621 0 1.125.504 1.125 1.125v17.25c0 .621-.504 1.125-1.125 1.125H5.625a1.125 1.125 0 01-1.125-1.125V4.875c0-.621.504-1.125 1.125-1.125z" />
                    </svg>
                </span>
                Static Pages & Content Management
            </h1>
            <p class="text-xs text-slate-500 mt-1">Manage public-facing policy documents, terms of service, and in-app legal compliance guidelines.</p>
        </div>

        <div class="flex items-center gap-3">
            <span class="px-3.5 py-1.5 bg-white border border-slate-200/80 rounded-xl shadow-2xs text-xs font-bold text-slate-700 flex items-center gap-2">
                <span class="h-2 w-2 rounded-full bg-emerald-500"></span>
                <span>{{ $pages->count() }} Live Endpoints</span>
            </span>
        </div>
    </div>

    @if(session('success'))
        <div class="p-4 bg-emerald-50 border border-emerald-200 text-emerald-800 rounded-2xl text-xs flex items-center gap-3 shadow-xs animate-fadeIn">
            <div class="h-7 w-7 rounded-lg bg-emerald-500 text-white flex items-center justify-center shrink-0">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2.5"><path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7"/></svg>
            </div>
            <div>
                <strong class="font-bold">Published!</strong>
                <span class="ml-1 font-medium">{{ session('success') }}</span>
            </div>
        </div>
    @endif

    <!-- 4 Key CMS Metric Cards -->
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4">
        
        <!-- Total Documents -->
        <div class="bg-white rounded-2xl p-5 border border-slate-200/80 shadow-xs relative overflow-hidden group hover:border-emerald-300 transition duration-300">
            <div class="flex items-center justify-between mb-2">
                <span class="text-[11px] font-bold uppercase tracking-wider text-slate-500">Published Pages</span>
                <div class="h-9 w-9 rounded-xl bg-emerald-50 text-emerald-600 flex items-center justify-center shadow-xs">
                    <svg class="w-4.5 h-4.5" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="1.75">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                    </svg>
                </div>
            </div>
            <div class="text-2xl font-black text-slate-900 tracking-tight">{{ $pages->count() }} Documents</div>
            <div class="text-[11px] text-emerald-600 font-medium mt-0.5">100% Active & Routable</div>
        </div>

        <!-- Compliance & Legal Status -->
        <div class="bg-white rounded-2xl p-5 border border-slate-200/80 shadow-xs relative overflow-hidden group hover:border-emerald-300 transition duration-300">
            <div class="flex items-center justify-between mb-2">
                <span class="text-[11px] font-bold uppercase tracking-wider text-slate-500">Legal Compliance</span>
                <div class="h-9 w-9 rounded-xl bg-blue-50 text-blue-600 flex items-center justify-center shadow-xs">
                    <svg class="w-4.5 h-4.5" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="1.75">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75L11.25 15 15 9.75m-3-7.036A11.959 11.959 0 013.598 6 11.99 11.99 0 003 9.749c0 5.592 3.824 10.29 9 11.623 5.176-1.332 9-6.03 9-11.622 0-1.31-.21-2.571-.598-3.751h-.152c-3.196 0-6.1-1.248-8.25-3.285z" />
                    </svg>
                </div>
            </div>
            <div class="text-2xl font-black text-slate-900 tracking-tight">Standard</div>
            <div class="text-[11px] text-slate-400 font-medium mt-0.5">Privacy, Terms & About Ready</div>
        </div>

        <!-- Mobile WebView Integration -->
        <div class="bg-white rounded-2xl p-5 border border-slate-200/80 shadow-xs relative overflow-hidden group hover:border-emerald-300 transition duration-300">
            <div class="flex items-center justify-between mb-2">
                <span class="text-[11px] font-bold uppercase tracking-wider text-slate-500">App Sync</span>
                <div class="h-9 w-9 rounded-xl bg-purple-50 text-purple-600 flex items-center justify-center shadow-xs">
                    <svg class="w-4.5 h-4.5" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="1.75">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M10.5 1.5H8.25A2.25 2.25 0 006 3.75v16.5a2.25 2.25 0 002.25 2.25h7.5A2.25 2.25 0 0018 20.25V3.75a2.25 2.25 0 00-2.25-2.25H13.5m-3 0V3h3V1.5m-3 0h3m-3 18.75h3" />
                    </svg>
                </div>
            </div>
            <div class="text-2xl font-black text-slate-900 tracking-tight">Connected</div>
            <div class="text-[11px] text-slate-400 font-medium mt-0.5">Rendered in Flutter app views</div>
        </div>

        <!-- Editor Mode -->
        <div class="bg-white rounded-2xl p-5 border border-slate-200/80 shadow-xs relative overflow-hidden group hover:border-emerald-300 transition duration-300">
            <div class="flex items-center justify-between mb-2">
                <span class="text-[11px] font-bold uppercase tracking-wider text-slate-500">Editor Engine</span>
                <div class="h-9 w-9 rounded-xl bg-amber-50 text-amber-600 flex items-center justify-center shadow-xs">
                    <svg class="w-4.5 h-4.5" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="1.75">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M16.862 4.487l1.687-1.688a1.875 1.875 0 112.652 2.652L10.582 16.07a4.5 4.5 0 01-1.897 1.13L6 18l.8-2.685a4.5 4.5 0 011.13-1.897l8.932-8.931zm0 0L19.5 7.125M18 14v4.75A2.25 2.25 0 0115.75 21H5.25A2.25 2.25 0 013 18.75V8.25A2.25 2.25 0 015.25 6H10" />
                    </svg>
                </div>
            </div>
            <div class="text-2xl font-black text-slate-900 tracking-tight">Quill & HTML</div>
            <div class="text-[11px] text-slate-400 font-medium mt-0.5">WYSIWYG & Raw Code Mode</div>
        </div>

    </div>

    <!-- Pages Management Table Card -->
    <div class="bg-white rounded-3xl border border-slate-200/80 shadow-xs overflow-hidden">
        
        <!-- Table Header & Search -->
        <div class="p-6 border-b border-slate-100 flex flex-col sm:flex-row sm:items-center justify-between gap-4">
            <div>
                <h3 class="text-base font-black text-slate-900 font-heading flex items-center gap-2">
                    <svg class="w-5 h-5 text-emerald-600" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="1.75">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 14.25v-2.625a3.375 3.375 0 00-3.375-3.375h-1.5A1.125 1.125 0 0113.5 7.125v-1.5a3.375 3.375 0 00-3.375-3.375H8.25m0 12.75h7.5m-7.53-4.5h7.5m-7.5-4.5h7.5m-7.5-4.5h7.5m-7.5-4.5h7.5M5.625 3.75h12.75c.621 0 1.125.504 1.125 1.125v17.25c0 .621-.504 1.125-1.125 1.125H5.625a1.125 1.125 0 01-1.125-1.125V4.875c0-.621.504-1.125 1.125-1.125z" />
                    </svg>
                    Legal & Information Pages Directory
                </h3>
                <p class="text-xs text-slate-400 mt-0.5">Review, edit, and audit live public policy pages and user agreement documents.</p>
            </div>
            
            <div class="w-full sm:w-72 relative">
                <span class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none text-slate-400">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                    </svg>
                </span>
                <input type="text" id="pageFilterInput" onkeyup="filterPagesTable()" placeholder="Search documents..." 
                       class="w-full pl-10 pr-4 py-2 bg-slate-50 border border-slate-200 rounded-xl text-xs font-semibold text-slate-800 placeholder-slate-400 focus:outline-none focus:border-emerald-500 focus:bg-white transition">
            </div>
        </div>

        <!-- Table Container -->
        <div class="overflow-x-auto">
            <table class="w-full text-left text-xs border-collapse" id="pagesTable">
                <thead>
                    <tr class="bg-slate-50/75 border-b border-slate-200/80 text-[11px] font-extrabold text-slate-400 uppercase tracking-wider">
                        <th class="py-4 px-6">Document Title</th>
                        <th class="py-4 px-4">Endpoint Slug</th>
                        <th class="py-4 px-4">Public Live URL</th>
                        <th class="py-4 px-4">Status</th>
                        <th class="py-4 px-4">Last Updated</th>
                        <th class="py-4 px-6 text-right">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100">
                    @foreach ($pages as $page)
                        @php
                            $slug = strtolower($page->slug);
                            $iconColor = 'bg-slate-100 text-slate-700';
                            if (str_contains($slug, 'privacy')) {
                                $iconColor = 'bg-blue-50 text-blue-600 border border-blue-100';
                            } elseif (str_contains($slug, 'terms')) {
                                $iconColor = 'bg-purple-50 text-purple-600 border border-purple-100';
                            } elseif (str_contains($slug, 'about')) {
                                $iconColor = 'bg-emerald-50 text-emerald-600 border border-emerald-100';
                            } elseif (str_contains($slug, 'contact')) {
                                $iconColor = 'bg-amber-50 text-amber-600 border border-amber-100';
                            }
                        @endphp
                        <tr class="hover:bg-slate-50/80 transition page-row" data-title="{{ strtolower($page->title) }}" data-slug="{{ strtolower($page->slug) }}">
                            
                            <!-- Document Title -->
                            <td class="py-4 px-6">
                                <div class="flex items-center gap-3.5">
                                    <div class="h-10 w-10 rounded-xl {{ $iconColor }} flex items-center justify-center shrink-0 shadow-2xs">
                                        @if(str_contains($slug, 'privacy'))
                                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="1.75">
                                                <path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75L11.25 15 15 9.75m-3-7.036A11.959 11.959 0 013.598 6 11.99 11.99 0 003 9.749c0 5.592 3.824 10.29 9 11.623 5.176-1.332 9-6.03 9-11.622 0-1.31-.21-2.571-.598-3.751h-.152c-3.196 0-6.1-1.248-8.25-3.285z" />
                                            </svg>
                                        @elseif(str_contains($slug, 'terms'))
                                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="1.75">
                                                <path stroke-linecap="round" stroke-linejoin="round" d="M12 3v17.25m0 0c-1.472 0-2.882.265-4.185.75M12 20.25c1.472 0 2.882.265 4.185.75M18.75 4.97A48.416 48.416 0 0012 4.5c-2.291 0-4.545.16-6.75.47m13.5 0c1.01.143 2.01.317 3 .52m-3-.52l2.62 10.726c.122.499-.106 1.028-.589 1.202a5.988 5.988 0 01-2.031.352 5.988 5.988 0 01-2.031-.352c-.483-.174-.711-.703-.59-1.202L18.75 4.971zm-16.5.52c.99-.203 1.99-.377 3-.52m0 0l2.62 10.726c.122.499-.106 1.028-.589 1.202a5.989 5.989 0 01-2.031.352 5.989 5.989 0 01-2.031-.352c-.483-.174-.711-.703-.59-1.202L5.25 4.971z" />
                                            </svg>
                                        @elseif(str_contains($slug, 'contact'))
                                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="1.75">
                                                <path stroke-linecap="round" stroke-linejoin="round" d="M2.25 6.75c0 8.284 6.716 15 15 15h2.25a2.25 2.25 0 002.25-2.25v-1.372c0-.516-.351-.966-.852-1.091l-4.423-1.106c-.44-.11-.902.055-1.173.417l-.97 1.293c-.282.376-.769.542-1.21.38a12.035 12.035 0 01-7.143-7.143c-.162-.441.004-.928.38-1.21l1.293-.97c.363-.271.527-.734.417-1.173L6.963 3.102a1.125 1.125 0 00-1.091-.852H4.5A2.25 2.25 0 002.25 4.5v2.25z" />
                                            </svg>
                                        @else
                                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="1.75">
                                                <path stroke-linecap="round" stroke-linejoin="round" d="M12 21a9.004 9.004 0 008.716-6.747M12 21a9.004 9.004 0 01-8.716-6.747M12 21c2.485 0 4.5-4.03 4.5-9S14.485 3 12 3m0 18c-2.485 0-4.5-4.03-4.5-9S9.515 3 12 3m0 0a8.997 8.997 0 017.843 4.582M12 3a8.997 8.997 0 00-7.843 4.582" />
                                            </svg>
                                        @endif
                                    </div>
                                    <div>
                                        <a href="/admin/settings/{{ $page->slug }}" class="font-bold text-slate-900 text-xs hover:text-emerald-600 transition block">
                                            {{ $page->title }}
                                        </a>
                                        <span class="text-[11px] text-slate-400 font-medium block mt-0.5">Public Policy & Compliance Document</span>
                                    </div>
                                </div>
                            </td>

                            <!-- Route Slug -->
                            <td class="py-4 px-4">
                                <div class="flex items-center gap-1.5">
                                    <code class="px-2.5 py-1 bg-slate-100 text-slate-800 rounded-lg font-mono text-[11px] font-bold border border-slate-200/80">
                                        /{{ $page->slug }}
                                    </code>
                                    <button type="button" onclick="copySlugToClipboard('{{ url('/' . $page->slug) }}')" class="p-1 text-slate-400 hover:text-slate-600 transition" title="Copy URL">
                                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M15.666 3.888A2.25 2.25 0 0013.5 2.25h-3c-1.03 0-1.9.693-2.166 1.638m7.332 0c.055.194.084.4.084.612v0a.75.75 0 01-.75.75H9a.75.75 0 01-.75-.75v0c0-.212.03-.418.084-.612m7.332 0c.646.049 1.288.11 1.927.184 1.1.128 1.907 1.077 1.907 2.185V19.5a2.25 2.25 0 01-2.25 2.25H6.75A2.25 2.25 0 014.5 19.5V6.257c0-1.108.806-2.057 1.907-2.185a48.208 48.208 0 011.927-.184" />
                                        </svg>
                                    </button>
                                </div>
                            </td>

                            <!-- Public Live Link -->
                            <td class="py-4 px-4">
                                <a href="/{{ $page->slug }}" target="_blank" class="inline-flex items-center gap-1.5 px-3 py-1.5 bg-emerald-50 text-emerald-700 hover:bg-emerald-100 rounded-xl text-xs font-bold transition border border-emerald-200/60">
                                    <span>Preview Live</span>
                                    <svg class="w-3 h-3 text-emerald-600" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2.5">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M13.5 6H5.25A2.25 2.25 0 003 8.25v10.5A2.25 2.25 0 005.25 21h10.5A2.25 2.25 0 0018 18.75V10.5m-10.5 6L21 3m0 0h-5.25M21 3v5.25" />
                                    </svg>
                                </a>
                            </td>

                            <!-- Status -->
                            <td class="py-4 px-4">
                                <span class="inline-flex items-center gap-1.5 px-2.5 py-1 bg-emerald-50 text-emerald-700 border border-emerald-200/80 rounded-full text-[10px] font-extrabold uppercase">
                                    <span class="h-1.5 w-1.5 rounded-full bg-emerald-500"></span>
                                    Published
                                </span>
                            </td>

                            <!-- Last Updated -->
                            <td class="py-4 px-4">
                                <div class="text-xs font-semibold text-slate-700">{{ $page->updated_at->diffForHumans() }}</div>
                                <span class="text-[10px] text-slate-400 font-medium">{{ $page->updated_at->format('M d, Y h:i A') }}</span>
                            </td>

                            <!-- Action -->
                            <td class="py-4 px-6 text-right">
                                <a href="/admin/settings/{{ $page->slug }}" class="inline-flex items-center gap-1.5 px-4 py-2 bg-gradient-to-r from-emerald-600 to-teal-600 hover:from-emerald-500 hover:to-teal-500 text-white text-xs font-bold rounded-xl shadow-md shadow-emerald-600/20 transition">
                                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M16.862 4.487l1.687-1.688a1.875 1.875 0 112.652 2.652L10.582 16.07a4.5 4.5 0 01-1.897 1.13L6 18l.8-2.685a4.5 4.5 0 011.13-1.897l8.932-8.931zm0 0L19.5 7.125M18 14v4.75A2.25 2.25 0 0115.75 21H5.25A2.25 2.25 0 013 18.75V8.25A2.25 2.25 0 015.25 6H10" />
                                    </svg>
                                    <span>Edit Document</span>
                                </a>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

    </div>
</div>

<script>
    function filterPagesTable() {
        const query = document.getElementById('pageFilterInput').value.toLowerCase().trim();
        const rows = document.querySelectorAll('.page-row');
        
        rows.forEach(row => {
            const title = row.getAttribute('data-title') || '';
            const slug = row.getAttribute('data-slug') || '';
            if (title.includes(query) || slug.includes(query)) {
                row.style.display = '';
            } else {
                row.style.display = 'none';
            }
        });
    }

    function copySlugToClipboard(url) {
        navigator.clipboard.writeText(url).then(() => {
            alert('Live page URL copied to clipboard: ' + url);
        });
    }
</script>
@endsection
