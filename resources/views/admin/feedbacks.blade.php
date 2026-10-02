@extends('admin.layout')

@section('page_title', 'User Feedback')

@section('content')
<div class="space-y-6">
    <!-- Header Area -->
    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 pb-5 border-b border-slate-200/80">
        <div>
            <h1 class="text-xl font-bold text-slate-900 tracking-tight flex items-center gap-2.5">
                <span class="p-2 rounded-xl bg-emerald-50 text-emerald-600 border border-emerald-100/60">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 10h.01M12 10h.01M16 10h.01M9 16H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-5l-5 5v-5z" />
                    </svg>
                </span>
                User Feedback & Bug Reports
            </h1>
            <p class="text-xs text-slate-500 mt-1">Review feedback, suggestions, and reported issues directly submitted by mobile app users.</p>
        </div>
        <div class="flex items-center gap-2">
            <span class="px-3 py-1 bg-slate-100 text-slate-700 rounded-lg text-xs font-semibold border border-slate-200">
                Total Submissions: <strong class="text-slate-900">{{ $feedbacks->count() }}</strong>
            </span>
        </div>
    </div>

    <div class="bg-white rounded-2xl border border-slate-200/80 shadow-xs overflow-hidden">
        @if($feedbacks->isEmpty())
            <div class="py-16 px-4 text-center">
                <div class="w-12 h-12 bg-slate-100 rounded-2xl flex items-center justify-center mx-auto text-slate-400 mb-3">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.75" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z" />
                    </svg>
                </div>
                <h3 class="text-sm font-bold text-slate-800">No feedback received yet</h3>
                <p class="text-xs text-slate-500 mt-1 max-w-sm mx-auto">Feedback and bug reports submitted through mobile app settings will appear here in real-time.</p>
            </div>
        @else
            <div class="overflow-x-auto">
                <table class="w-full text-left border-collapse text-xs">
                    <thead>
                        <tr class="bg-slate-50/75 border-b border-slate-200/80 text-[11px] font-semibold text-slate-500 uppercase tracking-wider">
                            <th class="px-5 py-3.5">User</th>
                            <th class="px-5 py-3.5">Type</th>
                            <th class="px-5 py-3.5">Rating / Scope</th>
                            <th class="px-5 py-3.5 w-1/2">Feedback Description</th>
                            <th class="px-5 py-3.5 whitespace-nowrap">Submitted At</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100 font-normal">
                        @foreach($feedbacks as $feedback)
                            <tr class="hover:bg-slate-50/60 transition">
                                <!-- User -->
                                <td class="px-5 py-4">
                                    <div class="flex items-center gap-3">
                                        <div class="h-8 w-8 rounded-full bg-slate-100 border border-slate-200 flex items-center justify-center font-bold text-xs text-slate-700 flex-shrink-0">
                                            {{ substr($feedback->user->name ?? 'G', 0, 1) }}
                                        </div>
                                        <div>
                                            <span class="font-bold text-slate-900 block leading-tight">{{ $feedback->user->name ?? 'Guest User' }}</span>
                                            <span class="text-[11px] text-slate-400 block mt-0.5">{{ $feedback->user->email ?? 'N/A' }}</span>
                                        </div>
                                    </div>
                                </td>

                                <!-- Type -->
                                <td class="px-5 py-4 whitespace-nowrap">
                                    @if($feedback->type === 'issue')
                                        <span class="inline-flex items-center px-2 py-0.5 bg-rose-50 text-rose-700 border border-rose-200/70 rounded-md text-[10px] font-semibold uppercase tracking-wider">
                                            Bug / Issue
                                        </span>
                                    @else
                                        <span class="inline-flex items-center px-2 py-0.5 bg-emerald-50 text-emerald-700 border border-emerald-200/70 rounded-md text-[10px] font-semibold uppercase tracking-wider">
                                            Suggestion
                                        </span>
                                    @endif
                                </td>

                                <!-- Rating / Scope -->
                                <td class="px-5 py-4 whitespace-nowrap">
                                    @if($feedback->type === 'issue')
                                        <span class="text-xs text-slate-600 font-medium">
                                            Area: <strong class="text-slate-900 font-semibold">{{ $feedback->area ?? 'General' }}</strong>
                                        </span>
                                    @else
                                        <div class="flex items-center gap-0.5">
                                            @for($i = 1; $i <= 5; $i++)
                                                <svg class="w-3.5 h-3.5 {{ $i <= $feedback->stars ? 'text-amber-400 fill-amber-400' : 'text-slate-200' }}" viewBox="0 0 20 20" fill="currentColor">
                                                    <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z" />
                                                </svg>
                                            @endfor
                                        </div>
                                    @endif
                                </td>

                                <!-- Message -->
                                <td class="px-5 py-4 w-1/2">
                                    <p class="text-xs text-slate-700 leading-relaxed whitespace-pre-line">{{ $feedback->feedback }}</p>
                                </td>

                                <!-- Submitted At -->
                                <td class="px-5 py-4 whitespace-nowrap text-slate-500 font-medium">
                                    {{ $feedback->created_at->format('M d, Y h:i A') }}
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        @endif
    </div>
</div>
@endsection
