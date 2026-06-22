@extends('admin.layout')

@section('page_title', 'User Feedback')

@section('content')
<div class="flex flex-col md:flex-row md:items-center justify-between gap-4 mb-8 relative z-10">
    <div>
        <h1 class="text-2xl font-black text-slate-800">User Feedback & Bugs</h1>
        <p class="text-xs text-slate-400 font-semibold mt-1">Inspect bug reports and feature suggestions submitted by HomiQ mobile app users.</p>
    </div>
</div>

<div class="bg-white rounded-2xl border border-slate-100 shadow-sm overflow-hidden animate-fade-in">
    <div class="p-6 border-b border-slate-50 flex items-center justify-between">
        <span class="text-xs font-bold text-slate-850 uppercase tracking-widest">Feedback Messages</span>
        <span class="px-2.5 py-0.5 bg-donezoLightGreen text-donezoGreen border border-emerald-100 rounded-md text-[10px] font-extrabold">{{ $feedbacks->count() }} Submissions</span>
    </div>

    @if($feedbacks->isEmpty())
        <div class="p-16 text-center">
            <div class="h-16 w-16 bg-slate-50 border border-slate-100 rounded-full flex items-center justify-center mx-auto text-slate-300 mb-4">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z" />
                </svg>
            </div>
            <h3 class="text-slate-800 font-extrabold text-sm">No feedback received yet</h3>
            <p class="text-[11px] text-slate-450 font-semibold mt-1">Feedback and bug reports submitted from the mobile app settings will appear here.</p>
        </div>
    @else
        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse">
                <thead>
                    <tr class="bg-slate-50 border-b border-slate-100 text-[9px] font-extrabold text-slate-400 uppercase tracking-widest">
                        <th class="px-6 py-4">User</th>
                        <th class="px-6 py-4">Type</th>
                        <th class="px-6 py-4">Rating / Area</th>
                        <th class="px-6 py-4 w-1/2">Feedback / Bug Description</th>
                        <th class="px-6 py-4">Submitted At</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-50">
                    @foreach($feedbacks as $feedback)
                        <tr class="hover:bg-slate-50/50 transition">
                            <!-- User -->
                            <td class="px-6 py-4">
                                <div class="flex items-center gap-2.5">
                                    <div class="h-8 w-8 rounded-full bg-slate-100 border border-slate-200/60 flex items-center justify-center font-bold text-xs text-slate-500">
                                        {{ substr($feedback->user->name ?? 'G', 0, 1) }}
                                    </div>
                                    <div>
                                        <span class="text-xs font-bold text-slate-855 block leading-none mb-0.5">{{ $feedback->user->name ?? 'Guest User' }}</span>
                                        <span class="text-[10px] font-semibold text-slate-400 block leading-none">{{ $feedback->user->email ?? 'N/A' }}</span>
                                    </div>
                                </div>
                            </td>

                            <!-- Type -->
                            <td class="px-6 py-4">
                                @if($feedback->type === 'issue')
                                    <span class="inline-flex px-2 py-0.5 bg-rose-50 text-rose-700 border border-rose-100 rounded-md text-[9px] font-extrabold uppercase tracking-wider">
                                        Bug/Issue
                                    </span>
                                @else
                                    <span class="inline-flex px-2 py-0.5 bg-emerald-50 text-emerald-700 border border-emerald-100 rounded-md text-[9px] font-extrabold uppercase tracking-wider">
                                        Suggestion
                                    </span>
                                @endif
                            </td>

                            <!-- Rating / Affected Area -->
                            <td class="px-6 py-4">
                                @if($feedback->type === 'issue')
                                    <span class="text-xs font-bold text-slate-600 block leading-none">
                                        Area: <span class="text-slate-800 font-extrabold">{{ $feedback->area ?? 'General' }}</span>
                                    </span>
                                @else
                                    <div class="flex items-center gap-0.5">
                                        @for($i = 1; $i <= 5; $i++)
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-3.5 w-3.5 {{ $i <= $feedback->stars ? 'text-amber-400 fill-amber-400' : 'text-slate-200' }}" viewBox="0 0 20 20" fill="currentColor">
                                                <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z" />
                                            </svg>
                                        @endfor
                                    </div>
                                @endif
                            </td>

                            <!-- Message -->
                            <td class="px-6 py-4 w-1/2">
                                <p class="text-xs text-slate-650 font-semibold leading-relaxed whitespace-pre-line">{{ $feedback->feedback }}</p>
                            </td>

                            <!-- Submitted At -->
                            <td class="px-6 py-4">
                                <span class="text-xs text-slate-500 font-semibold leading-none">{{ $feedback->created_at->format('M d, Y h:i A') }}</span>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    @endif
</div>
@endsection
