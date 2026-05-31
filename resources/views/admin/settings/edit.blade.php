@extends('admin.layout')

@section('page_title', 'Edit Page Content')

@section('content')
<!-- Quill editor stylesheets -->
<link href="https://cdn.jsdelivr.net/npm/quill@2.0.0/dist/quill.snow.css" rel="stylesheet">

<div class="mb-6 flex items-center justify-between max-w-4xl mx-auto relative z-10">
    <a href="/admin/settings" class="inline-flex items-center gap-1.5 text-xs font-extrabold text-slate-500 hover:text-slate-800 transition">
        &larr; Back to Page Settings
    </a>
    <span class="text-[10px] text-slate-400 font-extrabold">Slug Endpoint: /{{ $page->slug }}</span>
</div>

<form action="/admin/settings/{{ $page->slug }}" method="POST" id="pageEditorForm" onsubmit="syncEditorContent()" class="max-w-4xl mx-auto space-y-6 relative z-10">
    @csrf

    <!-- Page Title Panel -->
    <div class="bg-white p-6 rounded-2xl border border-slate-200/60 shadow-sm space-y-2.5">
        <label class="block text-[9px] font-extrabold text-[#187053] uppercase tracking-widest">Page Display Title</label>
        <input type="text" name="title" value="{{ $page->title }}" required
               class="w-full px-4 py-3.5 bg-slate-50 border border-slate-200/60 rounded-xl text-slate-800 focus:outline-none focus:border-[#187053] transition-colors font-extrabold text-sm">
    </div>

    <!-- HTML Editor Area -->
    <div class="bg-white p-6 rounded-2xl border border-slate-200/60 shadow-sm space-y-4">
        <div class="flex justify-between items-center border-b border-slate-100 pb-3">
            <label class="block text-[9px] font-extrabold text-[#187053] uppercase tracking-widest">Content Structure</label>
            
            <!-- Editor Mode Toggles -->
            <div class="flex bg-slate-100 border border-slate-200/50 p-1 rounded-lg gap-1">
                <button type="button" id="btnWysiwyg" onclick="switchMode('wysiwyg')" class="px-3 py-1 bg-white text-slate-800 shadow-sm rounded-md text-[9px] font-extrabold transition">
                    Visual Editor
                </button>
                <button type="button" id="btnCode" onclick="switchMode('code')" class="px-3 py-1 text-slate-500 rounded-md text-[9px] font-extrabold transition">
                    Raw HTML Code
                </button>
            </div>
        </div>

        <!-- Hidden input to submit the editor HTML -->
        <input type="hidden" name="content" id="hiddenContent">

        <!-- WYSIWYG Quill Container -->
        <div id="wysiwygEditorWrapper" class="h-96 bg-white rounded-xl overflow-hidden border border-slate-200 flex flex-col">
            <div id="editorToolbar"></div>
            <div id="quillEditor" class="flex-1 overflow-y-auto text-xs text-slate-800">
                {!! $page->content !!}
            </div>
        </div>

        <!-- Raw HTML Textarea -->
        <div id="codeEditorWrapper" class="hidden">
            <textarea id="rawHtmlTextarea" class="w-full h-96 p-4 bg-slate-900 text-slate-200 font-mono text-[11px] rounded-xl border border-slate-200 focus:outline-none focus:border-[#187053] leading-relaxed">{{ $page->content }}</textarea>
        </div>
    </div>

    <!-- Action Buttons -->
    <div class="flex justify-end gap-3">
        <a href="/admin/settings" class="px-5 py-2.5 bg-slate-100 hover:bg-slate-200 text-slate-700 text-xs font-bold rounded-xl border border-slate-200 transition">
            Cancel Changes
        </a>
        <button type="submit" class="px-6 py-2.5 bg-[#187053] hover:bg-[#12563f] text-white text-xs font-bold rounded-xl shadow transition">
            Publish Changes
        </button>
    </div>
</form>

<!-- Quill JS Library -->
<script src="https://cdn.jsdelivr.net/npm/quill@2.0.0/dist/quill.js"></script>

<script>
    // Initialize Quill Rich Text Editor
    let quill = new Quill('#quillEditor', {
        theme: 'snow',
        modules: {
            toolbar: [
                [{ 'header': [1, 2, 3, 4, 5, 6, false] }],
                ['bold', 'italic', 'underline', 'strike'],
                [{ 'color': [] }, { 'background': [] }],
                [{ 'list': 'ordered'}, { 'list': 'bullet' }],
                [{ 'align': [] }],
                ['link', 'clean']
            ]
        }
    });

    let currentMode = 'wysiwyg';

    // Toggle between Rich Editor and Raw Code mode
    function switchMode(mode) {
        if (mode === currentMode) return;
        
        const wysiwygWrapper = document.getElementById('wysiwygEditorWrapper');
        const codeWrapper = document.getElementById('codeEditorWrapper');
        const btnWysiwyg = document.getElementById('btnWysiwyg');
        const btnCode = document.getElementById('btnCode');
        const rawTextarea = document.getElementById('rawHtmlTextarea');

        if (mode === 'code') {
            // Get content from Quill, put it in Textarea
            rawTextarea.value = quill.getSemanticHTML();
            
            // Toggle visibility
            wysiwygWrapper.classList.add('hidden');
            codeWrapper.classList.remove('hidden');

            // Toggle active pill button styles
            btnCode.className = "px-3 py-1 bg-white text-slate-800 shadow-sm rounded-md text-[9px] font-bold transition";
            btnWysiwyg.className = "px-3 py-1 text-slate-500 rounded-md text-[9px] font-bold transition";
            
            currentMode = 'code';
        } else {
            // Get content from Textarea, set it in Quill
            quill.innerHTML = rawTextarea.value;
            // Force quill refresh
            quill.setContents(quill.clipboard.convert({html: rawTextarea.value}));

            // Toggle visibility
            codeWrapper.classList.add('hidden');
            wysiwygWrapper.classList.remove('hidden');

            // Toggle active pill button styles
            btnWysiwyg.className = "px-3 py-1 bg-white text-slate-800 shadow-sm rounded-md text-[9px] font-bold transition";
            btnCode.className = "px-3 py-1 text-slate-500 rounded-md text-[9px] font-bold transition";

            currentMode = 'wysiwyg';
        }
    }

    // Sync content to hidden input before form submit
    function syncEditorContent() {
        const hiddenInput = document.getElementById('hiddenContent');
        const rawTextarea = document.getElementById('rawHtmlTextarea');

        if (currentMode === 'wysiwyg') {
            // Fetch clean semantic HTML from Quill editor
            hiddenInput.value = quill.getSemanticHTML();
        } else {
            // Fetch content directly from code textarea
            hiddenInput.value = rawTextarea.value;
        }
    }
</script>

<style>
    /* Styling adjustments for Quill editor inner container */
    .ql-container.ql-snow {
        border: none !important;
    }
    .ql-toolbar.ql-snow {
        border: none !important;
        border-bottom: 1px solid rgb(226, 232, 240) !important;
        background-color: #f8fafc;
        border-top-left-radius: 0.75rem;
        border-top-right-radius: 0.75rem;
    }
    .ql-editor {
        font-family: 'Outfit', sans-serif !important;
        padding: 1.25rem !important;
        font-size: 13px !important;
        line-height: 1.625 !important;
        border-bottom-left-radius: 0.75rem;
        border-bottom-right-radius: 0.75rem;
    }
</style>
@endsection
