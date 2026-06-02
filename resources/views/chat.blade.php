@extends('layouts.app')

@section('content')
<script src="https://js.pusher.com/8.3.0/pusher.min.js"></script>
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
        <div class="lg:col-span-4 border-r border-slate-100 flex flex-col h-full bg-slate-50/50 min-h-0">
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
        <div class="lg:col-span-8 flex flex-col h-full bg-white relative min-h-0">
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
                            <p class="text-[10px] text-slate-400 mt-1 leading-none flex items-center gap-1.5">
                                @if ($activeChat->user_one_id === Auth::id())
                                    Chatting with Owner: <strong>{{ $activeChat->userTwo->name }}</strong>
                                @else
                                    Query from Seeker: <strong>{{ $activeChat->userOne->name }}</strong>
                                @endif
                                
                                @php
                                    $otherUser = ($activeChat->user_one_id === Auth::id()) ? $activeChat->userTwo : $activeChat->userOne;
                                    $isOnline = $otherUser->last_seen_at && $otherUser->last_seen_at->gt(now()->subMinutes(5));
                                @endphp
                                
                                <span class="flex items-center gap-1 ml-1">
                                    <span id="presence-dot" class="h-1.5 w-1.5 rounded-full {{ $isOnline ? 'bg-emerald-500 animate-pulse' : 'bg-slate-400' }}"></span>
                                    <span id="presence-text" class="text-[9px] font-bold {{ $isOnline ? 'text-emerald-600' : 'text-slate-400' }}">
                                        {{ $isOnline ? 'Online' : 'Offline' }}
                                    </span>
                                </span>
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
                                <div class="px-4 py-2.5 rounded-2xl text-xs leading-relaxed shadow-sm break-words
                                    {{ $isMe 
                                        ? 'bg-steelAzure text-white rounded-tr-none' 
                                        : 'bg-slate-100 text-slate-700 rounded-tl-none border border-slate-200/40' }}">
                                    @if ($msg->type === 'image' && $msg->attachment_url)
                                        <div class="flex items-center gap-2 bg-black/10 px-3 py-2 rounded-xl mb-1 border border-white/10">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-emerald-500 flex-shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                                <path stroke-linecap="round" stroke-linejoin="round" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                            </svg>
                                            <a href="{{ $msg->attachment_url }}" download class="text-xs underline font-semibold truncate {{ $isMe ? 'text-white' : 'text-steelAzure' }}">
                                                Download Image
                                            </a>
                                        </div>
                                    @elseif ($msg->type === 'pdf' && $msg->attachment_url)
                                        <div class="flex items-center gap-2 bg-black/10 px-3 py-2 rounded-xl mb-1 border border-white/10">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-rose-500 flex-shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                                <path stroke-linecap="round" stroke-linejoin="round" d="M7 21h10a2 2 0 002-2V9.414a1 1 0 00-.293-.707l-5.414-5.414A1 1 0 0012.586 3H7a2 2 0 00-2 2v14a2 2 0 002 2z" />
                                            </svg>
                                            <a href="{{ $msg->attachment_url }}" download class="text-xs underline font-semibold truncate {{ $isMe ? 'text-white' : 'text-steelAzure' }}">
                                                Download PDF
                                            </a>
                                        </div>
                                    @endif
                                    @if ($msg->message)
                                        <p>{{ $msg->message }}</p>
                                    @endif
                                </div>
                                <div class="text-[8px] text-slate-400 font-semibold {{ $isMe ? 'text-right flex items-center justify-end gap-1' : 'text-left' }}">
                                    {{ $msg->sender->name }} • <span class="chat-time-formatted" data-time="{{ $msg->created_at->toIso8601String() }}">{{ $msg->created_at->format('h:i A') }}</span>
                                    @if ($isMe)
                                        <span class="inline-flex items-center">
                                            @if ($msg->is_read)
                                                <!-- Double blue ticks -->
                                                <svg xmlns="http://www.w3.org/2000/svg" class="h-3 w-3 text-blue-500" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                                                    <path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7M11 17l4 4L22 10" />
                                                </svg>
                                            @else
                                                <!-- Double gray ticks -->
                                                <svg xmlns="http://www.w3.org/2000/svg" class="h-3 w-3 text-slate-400" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                                                    <path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7M11 17l4 4L22 10" />
                                                </svg>
                                            @endif
                                        </span>
                                    @endif
                                </div>
                            </div>
                        </div>
                    @endforeach

                    <!-- Typing Indicator -->
                    <div id="typing-indicator" class="hidden flex items-center gap-1.5 px-4.5 py-1 text-[10px] text-slate-400 font-semibold italic">
                        <span class="flex gap-0.5">
                            <span class="h-1 w-1 bg-slate-400 rounded-full animate-bounce"></span>
                            <span class="h-1 w-1 bg-slate-400 rounded-full animate-bounce [animation-delay:0.2s]"></span>
                            <span class="h-1 w-1 bg-slate-400 rounded-full animate-bounce [animation-delay:0.4s]"></span>
                        </span>
                        <span id="typing-user-text">Someone is typing...</span>
                    </div>
                </div>

                <!-- Footer Textfield Form -->
                <div class="p-4 border-t border-slate-100 bg-white">
                    <!-- File Preview Indicator -->
                    <div id="file-preview-container" class="hidden mb-2 p-2 bg-slate-50 border border-slate-100 rounded-xl flex items-center justify-between">
                        <div class="flex items-center gap-2">
                            <span id="file-icon" class="text-slate-500"></span>
                            <span id="file-name" class="text-xs font-bold text-slate-700 truncate max-w-xs"></span>
                        </div>
                        <button type="button" id="remove-file-btn" class="p-1 hover:bg-slate-200 rounded-full transition text-slate-400 hover:text-slate-600">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" /></svg>
                        </button>
                    </div>

                    <form action="/chat/send" method="POST" enctype="multipart/form-data" class="flex items-center gap-2">
                        @csrf
                        <input type="hidden" name="chat_id" value="{{ $activeChat->id }}">
                        
                        <!-- File Upload Button -->
                        <button type="button" onclick="document.getElementById('file-input').click()" class="p-3 bg-slate-50 border border-slate-100 hover:bg-slate-100 text-slate-500 rounded-xl transition flex items-center justify-center">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M15.172 7l-6.586 6.586a2 2 0 102.828 2.828l6.414-6.586a4 4 0 00-5.656-5.656l-6.415 6.585a6 6 0 108.486 8.486L20.5 13" />
                            </svg>
                        </button>
                        <input type="file" id="file-input" name="attachment" accept=".jpg,.jpeg,.png,.gif,.webp,.pdf" class="hidden">

                        <input type="text" id="message-input" name="message" placeholder="Type your reply here..." 
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

    function convertTimesToLocal() {
        document.querySelectorAll('.chat-time-formatted').forEach(el => {
            const timeStr = el.getAttribute('data-time');
            if (timeStr) {
                const date = new Date(timeStr);
                let hours = date.getHours();
                const minutes = date.getMinutes().toString().padStart(2, '0');
                const ampm = hours >= 12 ? 'PM' : 'AM';
                hours = hours % 12;
                hours = hours ? hours : 12;
                el.innerText = `${hours}:${minutes} ${ampm}`;
            }
        });
    }

    // Restore tab state or select active tab automatically
    document.addEventListener('DOMContentLoaded', () => {
        // Auto scroll messages to bottom
        const container = document.getElementById('messages-container');
        if (container) {
            container.scrollTop = container.scrollHeight;
        }

        // Convert message times to local browser timezone
        convertTimesToLocal();

        // Determine if we should open others queries based on query parameters or active chat relationship
        const hasOthersChat = @json($activeChat && $activeChat->user_two_id === Auth::id());
        const savedTab = localStorage.getItem('active_chat_tab');

        if (hasOthersChat || (savedTab === 'others-queries' && !@json($activeChat && $activeChat->user_one_id === Auth::id()))) {
            switchTab('others-queries');
        } else {
            switchTab('my-queries');
        }

        // Connect to Pusher Channels
        const activeChatId = "{{ $activeChat ? $activeChat->id : '' }}";
        const pusherKey = "{{ env('PUSHER_APP_KEY') }}";
        const pusherCluster = "{{ env('PUSHER_APP_CLUSTER') }}";
        
        let pusher = null;
        let channel = null;

        if (pusherKey && activeChatId) {
            pusher = new Pusher(pusherKey, {
                cluster: pusherCluster,
                forceTLS: true
            });

            channel = pusher.subscribe(`chat.${activeChatId}`);

            // Listen for incoming messages
            channel.bind('message_received', (msg) => {
                if (msg.sender_id != {{ Auth::id() }}) {
                    appendIncomingMessage(msg);
                }
            });

            // Listen for typing events
            channel.bind('typing', (data) => {
                const indicator = document.getElementById('typing-indicator');
                const indicatorText = document.getElementById('typing-user-text');
                if (indicator && indicatorText) {
                    if (data.isTyping) {
                        indicatorText.innerText = `${data.userName} is typing...`;
                        indicator.classList.remove('hidden');
                    } else {
                        indicator.classList.add('hidden');
                    }
                }
            });

            // Listen for presence events
            const otherUserId = {{ ($activeChat && $activeChat->user_one_id === Auth::id()) ? $activeChat->user_two_id : ($activeChat ? $activeChat->user_one_id : 'null') }};
            
            channel.bind('user_presence', (data) => {
                const presenceDot = document.getElementById('presence-dot');
                const presenceText = document.getElementById('presence-text');
                if (presenceDot && presenceText && data.userId == otherUserId) {
                    if (data.isOnline) {
                        presenceDot.className = 'h-1.5 w-1.5 rounded-full bg-emerald-500 animate-pulse';
                        presenceText.className = 'text-[9px] font-bold text-emerald-600';
                        presenceText.innerText = 'Online';
                    } else {
                        presenceDot.className = 'h-1.5 w-1.5 rounded-full bg-slate-400';
                        presenceText.className = 'text-[9px] font-bold text-slate-400';
                        presenceText.innerText = 'Offline';
                    }
                }
            });

            // Send presence check request on unload to set Offline
            window.addEventListener('beforeunload', () => {
                navigator.sendBeacon(`/chat/${activeChatId}/presence`, JSON.stringify({
                    is_online: false,
                    _token: '{{ csrf_token() }}'
                }));
            });
        }

        function formatTime12h(dateStr) {
            const date = new Date(dateStr);
            let hours = date.getHours();
            const minutes = date.getMinutes().toString().padStart(2, '0');
            const ampm = hours >= 12 ? 'PM' : 'AM';
            hours = hours % 12;
            hours = hours ? hours : 12;
            return `${hours}:${minutes} ${ampm}`;
        }

        function appendIncomingMessage(msg) {
            const container = document.getElementById('messages-container');
            if (!container) return;

            const divRow = document.createElement('div');
            divRow.className = 'flex justify-start';

            const divBubbleWrap = document.createElement('div');
            divBubbleWrap.className = 'max-w-[70%] space-y-1';

            const divBubble = document.createElement('div');
            divBubble.className = 'px-4 py-2.5 rounded-2xl text-xs leading-relaxed shadow-sm break-words bg-slate-100 text-slate-700 rounded-tl-none border border-slate-200/40';
            
            let bubbleHtml = '';
            if (msg.type === 'image' && msg.attachment_url) {
                bubbleHtml += `<div class="flex items-center gap-2 bg-black/10 px-3 py-2 rounded-xl mb-1 border border-white/10">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-emerald-500 flex-shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                    </svg>
                    <a href="${msg.attachment_url}" download class="text-xs underline font-semibold truncate text-steelAzure">
                        Download Image
                    </a>
                </div>`;
            } else if (msg.type === 'pdf' && msg.attachment_url) {
                bubbleHtml += `<div class="flex items-center gap-2 bg-black/10 px-3 py-2 rounded-xl mb-1 border border-white/10">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-rose-500 flex-shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M7 21h10a2 2 0 002-2V9.414a1 1 0 00-.293-.707l-5.414-5.414A1 1 0 0012.586 3H7a2 2 0 00-2 2v14a2 2 0 002 2z" />
                    </svg>
                    <a href="${msg.attachment_url}" download class="text-xs underline font-semibold truncate text-steelAzure">
                        Download PDF
                    </a>
                </div>`;
            }
            if (msg.message) {
                bubbleHtml += `<p>${msg.message}</p>`;
            }
            divBubble.innerHTML = bubbleHtml;

            const divMeta = document.createElement('div');
            divMeta.className = 'text-[8px] text-slate-400 font-semibold text-left';
            
            const isoTime = new Date().toISOString();
            divMeta.innerHTML = `${msg.sender_name || 'Someone'} • <span class="chat-time-formatted" data-time="${isoTime}">${formatTime12h(isoTime)}</span>`;

            divBubbleWrap.appendChild(divBubble);
            divBubbleWrap.appendChild(divMeta);
            divRow.appendChild(divBubbleWrap);

            const indicator = document.getElementById('typing-indicator');
            if (indicator) {
                container.insertBefore(divRow, indicator);
            } else {
                container.appendChild(divRow);
            }

            container.scrollTop = container.scrollHeight;
            convertTimesToLocal();
        }

        function appendOutgoingMessage(msg) {
            const container = document.getElementById('messages-container');
            if (!container) return;

            const divRow = document.createElement('div');
            divRow.className = 'flex justify-end';

            const divBubbleWrap = document.createElement('div');
            divBubbleWrap.className = 'max-w-[70%] space-y-1';

            const divBubble = document.createElement('div');
            divBubble.className = 'px-4 py-2.5 rounded-2xl text-xs leading-relaxed shadow-sm break-words bg-steelAzure text-white rounded-tr-none';
            
            let bubbleHtml = '';
            if (msg.type === 'image' && msg.attachment_url) {
                bubbleHtml += `<div class="flex items-center gap-2 bg-black/10 px-3 py-2 rounded-xl mb-1 border border-white/10">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-emerald-300 flex-shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                    </svg>
                    <a href="${msg.attachment_url}" download class="text-xs underline font-semibold truncate text-white">
                        Download Image
                    </a>
                </div>`;
            } else if (msg.type === 'pdf' && msg.attachment_url) {
                bubbleHtml += `<div class="flex items-center gap-2 bg-black/10 px-3 py-2 rounded-xl mb-1 border border-white/10">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-rose-300 flex-shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M7 21h10a2 2 0 002-2V9.414a1 1 0 00-.293-.707l-5.414-5.414A1 1 0 0012.586 3H7a2 2 0 00-2 2v14a2 2 0 002 2z" />
                    </svg>
                    <a href="${msg.attachment_url}" download class="text-xs underline font-semibold truncate text-white">
                        Download PDF
                    </a>
                </div>`;
            }
            if (msg.message) {
                bubbleHtml += `<p>${msg.message}</p>`;
            }
            divBubble.innerHTML = bubbleHtml;

            const divMeta = document.createElement('div');
            divMeta.className = 'text-[8px] text-slate-400 font-semibold text-right flex items-center justify-end gap-1';
            
            const isoTime = new Date().toISOString();
            divMeta.innerHTML = `{{ Auth::user()->name }} • <span class="chat-time-formatted" data-time="${isoTime}">${formatTime12h(isoTime)}</span>
                <span class="inline-flex items-center">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-3 w-3 text-slate-400" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7M11 17l4 4L22 10" />
                    </svg>
                </span>`;

            divBubbleWrap.appendChild(divBubble);
            divBubbleWrap.appendChild(divMeta);
            divRow.appendChild(divBubbleWrap);

            const indicator = document.getElementById('typing-indicator');
            if (indicator) {
                container.insertBefore(divRow, indicator);
            } else {
                container.appendChild(divRow);
            }

            container.scrollTop = container.scrollHeight;
            convertTimesToLocal();
        }

        // Poll sidebar updates only every 5 seconds
        if (activeChatId) {
            setInterval(async () => {
                try {
                    const response = await fetch(`/chat?chat_id=${activeChatId}`);
                    if (response.ok) {
                        const html = await response.text();
                        const parser = new DOMParser();
                        const doc = parser.parseFromString(html, 'text/html');

                        // Update side list previews only
                        const newMyQueries = doc.getElementById('tab-my-queries');
                        const currentMyQueries = document.getElementById('tab-my-queries');
                        if (newMyQueries && currentMyQueries) {
                            currentMyQueries.innerHTML = newMyQueries.innerHTML;
                        }

                        const newOthersQueries = doc.getElementById('tab-others-queries');
                        const currentOthersQueries = document.getElementById('tab-others-queries');
                        if (newOthersQueries && currentOthersQueries) {
                            currentOthersQueries.innerHTML = newOthersQueries.innerHTML;
                        }
                    }
                } catch (e) {
                    console.error('Error polling chat sidebar:', e);
                }
            }, 5000);
        }

        // File selection preview logic
        const fileInput = document.getElementById('file-input');
        const filePreviewContainer = document.getElementById('file-preview-container');
        const fileIcon = document.getElementById('file-icon');
        const fileName = document.getElementById('file-name');
        const removeFileBtn = document.getElementById('remove-file-btn');

        if (fileInput && filePreviewContainer) {
            fileInput.addEventListener('change', () => {
                const file = fileInput.files[0];
                if (file) {
                    // Size validation: 10MB limit
                    if (file.size > 10 * 1024 * 1024) {
                        alert('Error: File size exceeds the 10MB limit.');
                        fileInput.value = '';
                        filePreviewContainer.classList.add('hidden');
                        return;
                    }

                    // Type validation: only image and PDF
                    const allowedTypes = ['image/jpeg', 'image/png', 'image/gif', 'image/webp', 'application/pdf'];
                    if (!allowedTypes.includes(file.type)) {
                        alert('Error: Only image files and PDF documents are allowed.');
                        fileInput.value = '';
                        filePreviewContainer.classList.add('hidden');
                        return;
                    }

                    fileName.innerText = file.name;
                    if (file.type === 'application/pdf') {
                        fileIcon.innerHTML = `<svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-rose-500" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M7 21h10a2 2 0 002-2V9.414a1 1 0 00-.293-.707l-5.414-5.414A1 1 0 0012.586 3H7a2 2 0 00-2 2v14a2 2 0 002 2z" /></svg>`;
                    } else {
                        fileIcon.innerHTML = `<svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-emerald-500" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" /></svg>`;
                    }
                    filePreviewContainer.classList.remove('hidden');
                } else {
                    filePreviewContainer.classList.add('hidden');
                }
            });

            removeFileBtn.addEventListener('click', () => {
                fileInput.value = '';
                filePreviewContainer.classList.add('hidden');
            });
        }

        // Intercept message form send to perform AJAX post
        const form = document.querySelector('form');
        const messageInput = document.getElementById('message-input');
        
        if (form && activeChatId && messageInput) {
            form.addEventListener('submit', async (e) => {
                e.preventDefault();
                const message = messageInput.value.trim();
                const file = fileInput.files[0];
                if (!message && !file) return;

                const formData = new FormData();
                formData.append('chat_id', activeChatId);
                if (message) formData.append('message', message);
                if (file) formData.append('attachment', file);

                messageInput.value = '';
                fileInput.value = '';
                if (filePreviewContainer) filePreviewContainer.classList.add('hidden');

                try {
                    const response = await fetch('/chat/send', {
                        method: 'POST',
                        headers: {
                            'X-CSRF-TOKEN': '{{ csrf_token() }}'
                        },
                        body: formData
                    });
                    
                    if (response.ok) {
                        const savedMsg = await response.json();
                        appendOutgoingMessage(savedMsg);
                    }
                } catch (e) {
                    console.error('Failed to send message via AJAX:', e);
                }
            });
        }

        // Report my typing status via API
        let typingTimeout;
        if (messageInput && activeChatId) {
            messageInput.addEventListener('input', () => {
                if (!typingTimeout) {
                    fetch(`/chat/${activeChatId}/typing`, {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': '{{ csrf_token() }}'
                        },
                        body: JSON.stringify({ is_typing: true })
                    });
                }

                clearTimeout(typingTimeout);
                typingTimeout = setTimeout(() => {
                    fetch(`/chat/${activeChatId}/typing`, {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': '{{ csrf_token() }}'
                        },
                        body: JSON.stringify({ is_typing: false })
                    });
                    typingTimeout = null;
                }, 3000);
            });
        }
    });
</script>
@endsection
