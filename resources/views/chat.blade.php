@extends('layouts.app')

@section('content')
<style>
    .chat-scroll::-webkit-scrollbar {
        width: 6px;
    }
    .chat-scroll::-webkit-scrollbar-track {
        background: transparent;
    }
    .chat-scroll::-webkit-scrollbar-thumb {
        background: #cbd5e1;
        border-radius: 3px;
    }
    .chat-scroll::-webkit-scrollbar-thumb:hover {
        background: #94a3b8;
    }
</style>

<div class="max-w-7xl mx-auto px-6 py-10">
    <div class="mb-6 flex flex-col md:flex-row md:items-center md:justify-between gap-4">
        <div>
            <h1 class="text-2xl font-extrabold text-slate-800 tracking-tight">Inbox & Queries</h1>
            <p class="text-xs text-slate-400 mt-1">Communicate directly with seekers and property owners in real-time.</p>
        </div>
        <a href="/dashboard" class="inline-flex items-center gap-1.5 text-xs font-bold text-steelAzure hover:text-steelAzure/85 bg-slate-50 border border-slate-100 px-4 py-2.5 rounded-xl transition duration-150">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M10 19l-7-7m0 0l7-7m-7 7h18" /></svg>
            Back to Dashboard
        </a>
    </div>

    <!-- Main Grid Layout -->
    <div class="grid grid-cols-1 lg:grid-cols-12 gap-8 bg-white border border-slate-100 rounded-3xl overflow-hidden shadow-sm h-[720px]">
        
        <!-- Sidebar: Chat List (5 cols) -->
        <div class="lg:col-span-4 border-r border-slate-100 flex flex-col h-full bg-slate-50/50">
            <!-- Tabs Navigation -->
            <div class="p-4 bg-white border-b border-slate-100">
                <div class="flex bg-slate-100 p-1 rounded-xl">
                    <button onclick="switchTab('my-queries')" id="btn-my-queries" 
                            class="flex-1 text-center py-2.5 rounded-lg text-xs font-bold transition-all duration-200 bg-white text-slate-800 shadow-sm">
                        My Queries
                    </button>
                    <button onclick="switchTab('others-queries')" id="btn-others-queries" 
                            class="flex-1 text-center py-2.5 rounded-lg text-xs font-bold transition-all duration-200 text-slate-500 hover:text-slate-800">
                        Others' Queries
                    </button>
                </div>
            </div>

            <!-- Tab: My Queries (Queries on other properties) -->
            <div id="tab-my-queries" class="flex-1 overflow-y-auto chat-scroll p-3 space-y-2">
                @if($myQueries->isEmpty())
                    <div class="py-12 text-center text-slate-400 text-xs font-semibold">
                        No sent queries found.
                    </div>
                @else
                    @foreach($myQueries as $chat)
                        @php
                            $lastMsg = $chat->messages->last();
                            $isActive = $activeChat && $activeChat->id === $chat->id;
                        @endphp
                        <a href="/chat?chat_id={{ $chat->id }}" 
                           class="block p-4 rounded-2xl border transition duration-150 {{ $isActive ? 'bg-white border-steelAzure/30 shadow-md shadow-steelAzure/5 ring-1 ring-steelAzure/20' : 'bg-white/60 border-slate-100 hover:bg-white hover:shadow-sm' }}">
                            <div class="flex items-start justify-between gap-2">
                                <h4 class="font-extrabold text-slate-800 text-xs truncate">{{ $chat->property ? $chat->property->title : 'Unknown Property' }}</h4>
                                <span class="text-[9px] font-bold text-slate-400 whitespace-nowrap">{{ $chat->updated_at->diffForHumans(null, true) }}</span>
                            </div>
                            <span class="text-[9px] font-semibold text-steelAzure uppercase tracking-wider block mt-1">{{ $chat->userTwo->name }} (Owner)</span>
                            <p class="text-[10px] text-slate-400 truncate mt-2 leading-relaxed">
                                {{ $lastMsg ? $lastMsg->message : 'No messages yet' }}
                            </p>
                        </a>
                    @endforeach
                @endif
            </div>

            <!-- Tab: Others' Queries (Queries on my properties) -->
            <div id="tab-others-queries" class="hidden flex-1 overflow-y-auto chat-scroll p-3 space-y-2">
                @if($othersQueries->isEmpty())
                    <div class="py-12 text-center text-slate-400 text-xs font-semibold">
                        No received queries yet.
                    </div>
                @else
                    @foreach($othersQueries as $chat)
                        @php
                            $lastMsg = $chat->messages->last();
                            $isActive = $activeChat && $activeChat->id === $chat->id;
                        @endphp
                        <a href="/chat?chat_id={{ $chat->id }}" 
                           class="block p-4 rounded-2xl border transition duration-150 {{ $isActive ? 'bg-white border-steelAzure/30 shadow-md shadow-steelAzure/5 ring-1 ring-steelAzure/20' : 'bg-white/60 border-slate-100 hover:bg-white hover:shadow-sm' }}">
                            <div class="flex items-start justify-between gap-2">
                                <h4 class="font-extrabold text-slate-800 text-xs truncate">{{ $chat->property ? $chat->property->title : 'Unknown Property' }}</h4>
                                <span class="text-[9px] font-bold text-slate-400 whitespace-nowrap">{{ $chat->updated_at->diffForHumans(null, true) }}</span>
                            </div>
                            <span class="text-[9px] font-semibold text-emerald-600 uppercase tracking-wider block mt-1">{{ $chat->userOne->name }} (Seeker)</span>
                            <p class="text-[10px] text-slate-400 truncate mt-2 leading-relaxed">
                                {{ $lastMsg ? $lastMsg->message : 'No messages yet' }}
                            </p>
                        </a>
                    @endforeach
                @endif
            </div>
        </div>

        <!-- Conversation Panel (8 cols) -->
        <div class="lg:col-span-8 flex flex-col h-full bg-white relative">
            @if ($activeChat)
                <!-- Chat Header with Property Info -->
                <div class="p-5 border-b border-slate-100 flex items-center justify-between bg-slate-50/20">
                    <div class="flex items-center gap-3">
                        <div class="h-10 w-10 bg-slate-100 rounded-xl overflow-hidden flex-shrink-0">
                            <img src="{{ !empty($activeChat->property->images) && is_array($activeChat->property->images) ? $activeChat->property->images[0] : 'https://images.unsplash.com/photo-1564013799919-ab600027ffc6?auto=format&fit=crop&w=150&q=80' }}" 
                                 class="h-full w-full object-cover" alt="Property img">
                        </div>
                        <div>
                            <div class="flex items-center gap-1.5">
                                <h3 class="font-bold text-slate-800 text-sm leading-none">{{ $activeChat->property ? $activeChat->property->title : 'Queries Hub' }}</h3>
                                @if ($activeChat->property)
                                    <span class="text-[8px] font-bold bg-steelAzure/10 text-steelAzure px-1.5 py-0.5 rounded uppercase tracking-wider">{{ $activeChat->property->category }}</span>
                                @endif
                            </div>
                            <p class="text-[10px] text-slate-400 mt-1 leading-none">
                                @if ($activeChat->user_one_id === Auth::id())
                                    Chatting with Owner: <strong>{{ $activeChat->userTwo->name }}</strong>
                                @else
                                    Query from Seeker: <strong>{{ $activeChat->userOne->name }}</strong>
                                @endif
                            </p>
                        </div>
                    </div>
                    @if ($activeChat->property)
                        <a href="/properties/{{ $activeChat->property->id }}" class="text-[10px] font-bold text-steelAzure hover:underline transition">
                            View Property details
                        </a>
                    @endif
                </div>

                <!-- Messages Container -->
                <div id="messages-container" class="flex-1 overflow-y-auto chat-scroll p-6 space-y-4">
                    @foreach ($activeChat->messages as $msg)
                        @php
                            $isMe = $msg->sender_id === Auth::id();
                        @endphp
                        <div class="flex {{ $isMe ? 'justify-end' : 'justify-start' }}">
                            <div class="max-w-[70%] space-y-1">
                                <div class="px-4.5 py-3 rounded-2xl text-xs leading-relaxed shadow-sm
                                    {{ $isMe 
                                        ? 'bg-steelAzure text-white rounded-tr-none' 
                                        : 'bg-slate-100 text-slate-700 rounded-tl-none' }}">
                                    {{ $msg->message }}
                                </div>
                                <div class="text-[8px] text-slate-400 font-semibold {{ $isMe ? 'text-right' : 'text-left' }}">
                                    {{ $msg->sender->name }} • {{ $msg->created_at->format('H:i') }}
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>

                <!-- Footer Textfield Form -->
                <div class="p-4 border-t border-slate-100 bg-white">
                    <form action="/chat/send" method="POST" class="flex items-center gap-2">
                        @csrf
                        <input type="hidden" name="chat_id" value="{{ $activeChat->id }}">
                        <input type="text" name="message" required placeholder="Type your reply here..." 
                               class="flex-1 px-4 py-3 bg-slate-50 border border-slate-100 rounded-xl text-slate-800 focus:outline-none focus:border-steelAzure focus:bg-white transition text-xs">
                        <button type="submit" class="px-5 py-3 bg-steelAzure hover:bg-steelAzure/95 text-white font-bold rounded-xl shadow-md shadow-steelAzure/10 transition duration-150 text-xs flex items-center gap-1">
                            Send
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-3.5 w-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 19l9-2-9-18-9 18 9-2zm0 0v-8" /></svg>
                        </button>
                    </form>
                </div>

            @else
                <!-- Empty State -->
                <div class="flex flex-col items-center justify-center h-full text-center p-8">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-16 w-16 text-slate-200 mb-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z" />
                    </svg>
                    <h3 class="font-extrabold text-slate-700 text-base">Your Inbox is Empty</h3>
                    <p class="text-xs text-slate-400 mt-1 max-w-sm">Select an active query from the sidebar tabs or ask a question directly on any property listing page.</p>
                </div>
            @endif
        </div>

    </div>
</div>

<script>
    // Tab switching logic
    function switchTab(tabId) {
        const myQueries = document.getElementById('tab-my-queries');
        const othersQueries = document.getElementById('tab-others-queries');
        
        const btnMy = document.getElementById('btn-my-queries');
        const btnOthers = document.getElementById('btn-others-queries');

        if (tabId === 'my-queries') {
            myQueries.classList.remove('hidden');
            othersQueries.classList.add('hidden');

            btnMy.classList.add('bg-white', 'text-slate-800', 'shadow-sm');
            btnMy.classList.remove('text-slate-500');

            btnOthers.classList.remove('bg-white', 'text-slate-800', 'shadow-sm');
            btnOthers.classList.add('text-slate-500');
            localStorage.setItem('active_chat_tab', 'my-queries');
        } else {
            myQueries.classList.add('hidden');
            othersQueries.classList.remove('hidden');

            btnOthers.classList.add('bg-white', 'text-slate-800', 'shadow-sm');
            btnOthers.classList.remove('text-slate-500');

            btnMy.classList.remove('bg-white', 'text-slate-800', 'shadow-sm');
            btnMy.classList.add('text-slate-500');
            localStorage.setItem('active_chat_tab', 'others-queries');
        }
    }

    // Restore tab state or select active tab automatically
    document.addEventListener('DOMContentLoaded', () => {
        // Auto scroll messages to bottom
        const container = document.getElementById('messages-container');
        if (container) {
            container.scrollTop = container.scrollHeight;
        }

        // Determine if we should open others queries based on query parameters or active chat relationship
        const hasOthersChat = @json($activeChat && $activeChat->user_two_id === Auth::id());
        const savedTab = localStorage.getItem('active_chat_tab');

        if (hasOthersChat || (savedTab === 'others-queries' && !@json($activeChat && $activeChat->user_one_id === Auth::id()))) {
            switchTab('others-queries');
        } else {
            switchTab('my-queries');
        }
    });
</script>
@endsection
