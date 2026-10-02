@extends('admin.layout')

@section('page_title', 'Edit ' . $page->title)

@section('content')
<!-- Quill editor stylesheets -->
<link href="https://cdn.jsdelivr.net/npm/quill@2.0.0/dist/quill.snow.css" rel="stylesheet">

<div class="space-y-6 max-w-5xl">
    
    <!-- Top Action & Navigation Bar -->
    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 pb-5 border-b border-slate-200/80">
        <div>
            <div class="flex items-center gap-2 mb-1.5">
                <a href="/admin/settings" class="inline-flex items-center gap-1.5 text-xs font-bold text-slate-500 hover:text-emerald-700 transition">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M10.5 19.5L3 12m0 0l7.5-7.5M3 12h18"/></svg>
                    <span>Back to CMS Pages</span>
                </a>
                <span class="text-slate-300">•</span>
                <span class="px-2 py-0.5 rounded-md bg-emerald-50 text-emerald-700 border border-emerald-200 text-[10px] font-mono font-bold">
                    /{{ $page->slug }}
                </span>
            </div>
            <h1 class="text-xl font-black text-slate-900 tracking-tight flex items-center gap-2.5">
                <span>Edit Document: {{ $page->title }}</span>
            </h1>
            <p class="text-xs text-slate-400 mt-0.5">Last modified {{ $page->updated_at->diffForHumans() }} ({{ $page->updated_at->format('M d, Y h:i A') }})</p>
        </div>

        <div class="flex items-center gap-3">
            <a href="/{{ $page->slug }}" target="_blank" class="px-4 py-2 bg-white hover:bg-slate-50 text-slate-700 text-xs font-bold rounded-xl border border-slate-200 shadow-2xs transition flex items-center gap-1.5">
                <span>View Live</span>
                <svg class="w-3.5 h-3.5 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M13.5 6H5.25A2.25 2.25 0 003 8.25v10.5A2.25 2.25 0 005.25 21h10.5A2.25 2.25 0 0018 18.75V10.5m-10.5 6L21 3m0 0h-5.25M21 3v5.25" />
                </svg>
            </a>
            <button type="button" onclick="document.getElementById('pageEditorForm').requestSubmit()" class="px-5 py-2.5 bg-gradient-to-r from-emerald-600 to-teal-600 hover:from-emerald-500 hover:to-teal-500 text-white text-xs font-bold rounded-xl shadow-md shadow-emerald-600/20 transition flex items-center gap-2">
                <svg class="w-4 h-4 text-emerald-200" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M4.5 12.75l6 6 9-13.5"/>
                </svg>
                <span>Save & Publish</span>
            </button>
        </div>
    </div>

    <form action="/admin/settings/{{ $page->slug }}" method="POST" id="pageEditorForm" onsubmit="syncEditorContent()" class="space-y-6">
        @csrf

        <!-- Page Metadata Card -->
        <div class="bg-white p-6 rounded-3xl border border-slate-200/80 shadow-xs space-y-4">
            <div class="flex items-center justify-between pb-3 border-b border-slate-100">
                <h3 class="text-xs font-bold text-slate-900 uppercase tracking-wider flex items-center gap-2">
                    <svg class="w-4 h-4 text-emerald-600" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M16.862 4.487l1.687-1.688a1.875 1.875 0 112.652 2.652L10.582 16.07a4.5 4.5 0 01-1.897 1.13L6 18l.8-2.685a4.5 4.5 0 011.13-1.897l8.932-8.931zm0 0L19.5 7.125M18 14v4.75A2.25 2.25 0 0115.75 21H5.25A2.25 2.25 0 013 18.75V8.25A2.25 2.25 0 015.25 6H10" />
                    </svg>
                    Document Metadata
                </h3>
                <span class="text-[10px] text-slate-400 font-mono">Slug: /{{ $page->slug }}</span>
            </div>

            <div class="space-y-1.5">
                <label class="block text-[11px] font-bold text-slate-700">Page Display Title <span class="text-rose-500">*</span></label>
                <input type="text" name="title" value="{{ $page->title }}" required
                       class="w-full px-4 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-slate-900 focus:outline-none focus:border-emerald-500 focus:bg-white focus:ring-2 focus:ring-emerald-500/10 transition font-bold text-sm shadow-2xs">
            </div>
        </div>

        <!-- Rich Visual Editor Workspace -->
        <div class="bg-white p-6 rounded-3xl border border-slate-200/80 shadow-xs space-y-4">
            <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-3 border-b border-slate-100 pb-3">
                <div class="flex items-center gap-3">
                    <label class="block text-xs font-bold text-slate-900 uppercase tracking-wider">Document Body Content</label>
                    <span id="wordCountBadge" class="px-2.5 py-0.5 rounded-md bg-slate-100 text-slate-600 text-[10px] font-mono font-bold">
                        0 words
                    </span>
                </div>
                
                <!-- Mode Switcher -->
                <div class="flex bg-slate-100 border border-slate-200 p-1 rounded-xl gap-1">
                    <button type="button" id="btnWysiwyg" onclick="switchMode('wysiwyg')" class="px-3.5 py-1.5 bg-white text-slate-900 shadow-2xs rounded-lg text-xs font-bold transition flex items-center gap-1.5">
                        <svg class="w-3.5 h-3.5 text-emerald-600" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M3.75 6.75h16.5M3.75 12h16.5m-16.5 5.25H12"/></svg>
                        <span>Visual Editor</span>
                    </button>
                    <button type="button" id="btnCode" onclick="switchMode('code')" class="px-3.5 py-1.5 text-slate-500 hover:text-slate-900 rounded-lg text-xs font-bold transition flex items-center gap-1.5">
                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M17.25 6.75L22.5 12l-5.25 5.25m-10.5 0L1.5 12l5.25-5.25m7.5-3l-4.5 16.5"/></svg>
                        <span>Raw HTML</span>
                    </button>
                </div>
            </div>

            <!-- Hidden input to submit HTML -->
            <input type="hidden" name="content" id="hiddenContent">

            <!-- WYSIWYG Quill Container -->
            <div id="wysiwygEditorWrapper" class="h-[480px] bg-white rounded-2xl overflow-hidden border border-slate-200 flex flex-col shadow-2xs">
                <div id="editorToolbar"></div>
                <div id="quillEditor" class="flex-1 overflow-y-auto text-xs text-slate-800">
                    {!! $page->content !!}
                </div>
            </div>

            <!-- Raw HTML Textarea -->
            <div id="codeEditorWrapper" class="hidden">
                <textarea id="rawHtmlTextarea" class="w-full h-[480px] p-5 bg-slate-900 text-emerald-400 font-mono text-xs rounded-2xl border border-slate-700 focus:outline-none focus:border-emerald-500 leading-relaxed shadow-inner">{{ $page->content }}</textarea>
            </div>
        </div>

        <!-- Sticky Actions Bar -->
        <div class="flex items-center justify-between gap-4 pt-2">
            <div class="text-[11px] text-slate-400 flex items-center gap-1.5 font-medium">
                <kbd class="px-1.5 py-0.5 bg-slate-100 border border-slate-300 rounded font-mono text-[10px] text-slate-600">⌘S</kbd>
                <span>or Ctrl+S to save immediately</span>
            </div>

            <div class="flex items-center gap-3">
                <a href="/admin/settings" class="px-4 py-2.5 bg-slate-100 hover:bg-slate-200 text-slate-700 text-xs font-bold rounded-xl transition">
                    Cancel
                </a>
                <button type="submit" class="px-6 py-2.5 bg-gradient-to-r from-emerald-600 to-teal-600 hover:from-emerald-500 hover:to-teal-500 text-white text-xs font-bold rounded-xl shadow-md shadow-emerald-600/20 transition flex items-center gap-2">
                    <svg class="w-4 h-4 text-emerald-200" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M4.5 12.75l6 6 9-13.5"/>
                    </svg>
                    <span>Save & Publish Changes</span>
                </button>
            </div>
        </div>
    </form>
</div>

<!-- Quill JS Library -->
<script src="https://cdn.jsdelivr.net/npm/quill@2.0.0/dist/quill.js"></script>

<script>
    // Initialize Quill Rich Text Editor
    let quill = new Quill('#quillEditor', {
        theme: 'snow',
        modules: {
            toolbar: [
                [{ 'header': [1, 2, 3, 4, false] }],
                ['bold', 'italic', 'underline', 'strike'],
                [{ 'color': [] }, { 'background': [] }],
                [{ 'list': 'ordered'}, { 'list': 'bullet' }],
                [{ 'align': [] }],
                ['link', 'blockquote', 'code-block', 'clean']
            ]
        }
    });

    let currentMode = 'wysiwyg';

    function updateWordCount() {
        const text = quill.getText().trim();
        const words = text ? text.split(/\s+/).length : 0;
        const readTime = Math.ceil(words / 200);
        document.getElementById('wordCountBadge').textContent = words.toLocaleString() + ' words • ~' + readTime + ' min read';
    }

    quill.on('text-change', updateWordCount);
    updateWordCount();

    // Toggle between Rich Editor and Raw Code mode
    function switchMode(mode) {
        if (mode === currentMode) return;
        
        const wysiwygWrapper = document.getElementById('wysiwygEditorWrapper');
        const codeWrapper = document.getElementById('codeEditorWrapper');
        const btnWysiwyg = document.getElementById('btnWysiwyg');
        const btnCode = document.getElementById('btnCode');
        const rawTextarea = document.getElementById('rawHtmlTextarea');

        if (mode === 'code') {
            rawTextarea.value = quill.getSemanticHTML();
            wysiwygWrapper.classList.add('hidden');
            codeWrapper.classList.remove('hidden');

            btnCode.className = "px-3.5 py-1.5 bg-white text-slate-900 shadow-2xs rounded-lg text-xs font-bold transition flex items-center gap-1.5";
            btnWysiwyg.className = "px-3.5 py-1.5 text-slate-500 hover:text-slate-900 rounded-lg text-xs font-bold transition flex items-center gap-1.5";
            
            currentMode = 'code';
        } else {
            quill.innerHTML = rawTextarea.value;
            quill.setContents(quill.clipboard.convert({html: rawTextarea.value}));

            codeWrapper.classList.add('hidden');
            wysiwygWrapper.classList.remove('hidden');

            btnWysiwyg.className = "px-3.5 py-1.5 bg-white text-slate-900 shadow-2xs rounded-lg text-xs font-bold transition flex items-center gap-1.5";
            btnCode.className = "px-3.5 py-1.5 text-slate-500 hover:text-slate-900 rounded-lg text-xs font-bold transition flex items-center gap-1.5";

            currentMode = 'wysiwyg';
            updateWordCount();
        }
    }

    function syncEditorContent() {
        const hiddenInput = document.getElementById('hiddenContent');
        const rawTextarea = document.getElementById('rawHtmlTextarea');

        if (currentMode === 'wysiwyg') {
            hiddenInput.value = quill.getSemanticHTML();
        } else {
            hiddenInput.value = rawTextarea.value;
        }
    }

    // Keyboard shortcut ⌘S / Ctrl+S to save
    document.addEventListener('keydown', function(e) {
        if ((e.metaKey || e.ctrlKey) && e.key === 's') {
            e.preventDefault();
            syncEditorContent();
            document.getElementById('pageEditorForm').submit();
        }
    });
</script>

<style>
    .ql-container.ql-snow {
        border: none !important;
    }
    .ql-toolbar.ql-snow {
        border: none !important;
        border-bottom: 1px solid rgb(226, 232, 240) !important;
        background-color: #f8fafc;
        border-top-left-radius: 1rem;
        border-top-right-radius: 1rem;
        padding: 0.75rem 1rem !important;
    }
    .ql-editor {
        font-family: inherit !important;
        padding: 1.5rem !important;
        font-size: 14px !important;
        line-height: 1.75 !important;
    }
</style>
@endsection
