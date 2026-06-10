@extends('layouts.app-new')

@section('content')
<div class="bg-ju-offwhite min-h-screen py-12">
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
        
        <!-- Header -->
        <div class="flex justify-between items-center mb-6 flex-wrap gap-4">
            <div class="flex items-center gap-4">
                <a href="{{ route('messages.index') }}" class="text-ju-navy hover:text-ju-gold transition">
                    <i class="fas fa-arrow-left text-xl"></i>
                </a>
                <div class="flex items-center gap-3">
                    <div class="w-12 h-12 bg-ju-navy rounded-full flex items-center justify-center text-white font-bold text-lg">
                        {{ substr($conversation->buyer_id === auth()->id() ? $conversation->seller->name : $conversation->buyer->name, 0, 1) }}
                    </div>
                    <div>
                        <h2 class="text-xl font-bold text-ju-navy-dark">
                            {{ $conversation->buyer_id === auth()->id() ? $conversation->seller->name : $conversation->buyer->name }}
                        </h2>
                        <p class="text-sm text-ju-muted">
                            <i class="fas fa-tag mr-1 text-ju-gold text-xs"></i>
                            {{ Str::limit($conversation->listing->title, 40) }}
                        </p>
                    </div>
                </div>
            </div>
            <a href="{{ route('listings.show', $conversation->listing) }}" class="text-ju-navy hover:text-ju-gold text-sm font-medium transition">
                View Item <i class="fas fa-external-link-alt ml-1 text-xs"></i>
            </a>
        </div>
        
        <!-- Chat Container -->
        <div class="bg-white rounded-xl shadow-md border border-ju-border/50 flex flex-col h-[550px] overflow-hidden">
            
            <!-- Messages Area -->
            <div class="flex-1 overflow-y-auto p-6 space-y-4" id="chatMessages" style="background-color: #f4f6fb;">
                @foreach($messages as $message)
                    <div class="flex {{ $message->sender_id === auth()->id() ? 'justify-end' : 'justify-start' }}">
                        <div class="max-w-[75%]">
                            <div class="rounded-2xl px-4 py-2.5 {{ $message->sender_id === auth()->id() ? 'bg-ju-navy text-white' : 'bg-ju-surface text-ju-navy-dark' }}">
                                <p class="break-words text-sm">{{ $message->message }}</p>
                            </div>
                            <p class="text-xs text-ju-muted mt-1 px-2">
                                {{ $message->created_at->format('g:i A, M d') }}
                                @if($message->sender_id === auth()->id() && $message->is_read)
                                    <span class="ml-2 text-ju-gold">✓✓ Read</span>
                                @endif
                            </p>
                        </div>
                    </div>
                @endforeach
            </div>
            
            <!-- Typing Indicator -->
            <div id="typingIndicator" class="hidden px-6 py-2 text-sm text-ju-muted italic">
                <i class="fas fa-ellipsis-h animate-pulse mr-1"></i> Someone is typing...
            </div>
            
            <!-- Message Input -->
            <div class="border-t border-ju-border p-4 bg-white">
                <form method="POST" action="{{ route('messages.send', $conversation) }}" id="messageForm">
                    @csrf
                    <div class="flex gap-3">
                        <textarea name="message" 
                                  rows="2" 
                                  required
                                  placeholder="Type your message here... (Max 1000 characters)"
                                  class="flex-1 bg-ju-offwhite border border-ju-border rounded-xl focus:border-ju-navy focus:ring-2 focus:ring-ju-navy/20 text-ju-text placeholder-ju-muted/50 px-4 py-2.5 resize-none transition text-sm"
                                  maxlength="1000"
                                  id="messageInput"></textarea>
                        <button type="submit" class="bg-ju-navy hover:bg-ju-navy-dark text-white px-6 py-2.5 rounded-xl font-semibold transition flex items-center gap-2 shadow-sm">
                            <i class="fas fa-paper-plane"></i> Send
                        </button>
                    </div>
                    <p class="text-xs text-ju-muted mt-2">Maximum 10 messages per minute</p>
                </form>
            </div>
        </div>
    </div>
</div>

<script>
    // Auto-scroll to bottom on page load
    const chatMessages = document.getElementById('chatMessages');
    if (chatMessages) {
        chatMessages.scrollTop = chatMessages.scrollHeight;
    }
    
    // Track last message ID for AJAX polling
    let lastMessageId = {{ $messages->last()->id ?? 0 }};
    
    function fetchNewMessages() {
        fetch(window.location.href + '?ajax=1&last_id=' + lastMessageId, {
            headers: {
                'X-Requested-With': 'XMLHttpRequest'
            }
        })
        .then(response => response.json())
        .then(data => {
            if (data.messages && data.messages.length > 0) {
                data.messages.forEach(message => {
                    appendMessage(message);
                    if (message.id > lastMessageId) {
                        lastMessageId = message.id;
                    }
                });
                // Scroll to bottom only if user was already at bottom
                const isScrolledToBottom = chatMessages.scrollHeight - chatMessages.scrollTop <= chatMessages.clientHeight + 100;
                if (isScrolledToBottom) {
                    chatMessages.scrollTop = chatMessages.scrollHeight;
                }
            }
        })
        .catch(error => console.error('Error fetching messages:', error));
    }
    
    function appendMessage(message) {
        const isOwnMessage = message.sender_id === {{ auth()->id() }};
        const messageDiv = document.createElement('div');
        messageDiv.className = `flex ${isOwnMessage ? 'justify-end' : 'justify-start'} fade-in`;
        messageDiv.innerHTML = `
            <div class="max-w-[75%]">
                <div class="rounded-2xl px-4 py-2.5 ${isOwnMessage ? 'bg-ju-navy text-white' : 'bg-ju-surface text-ju-navy-dark'}">
                    <p class="break-words text-sm">${escapeHtml(message.message)}</p>
                </div>
                <p class="text-xs text-ju-muted mt-1 px-2">
                    ${new Date(message.created_at).toLocaleTimeString([], {hour: '2-digit', minute:'2-digit'})}
                    ${isOwnMessage && message.is_read ? '<span class="ml-2 text-ju-gold">✓✓ Read</span>' : ''}
                </p>
            </div>
        `;
        chatMessages.appendChild(messageDiv);
    }
    
    function escapeHtml(text) {
        const div = document.createElement('div');
        div.textContent = text;
        return div.innerHTML;
    }
    
    // Fetch new messages every 5 seconds (NO PAGE RELOAD)
    setInterval(fetchNewMessages, 5000);
    
    // Prevent form resubmission on page refresh
    if (window.history.replaceState) {
        window.history.replaceState(null, null, window.location.href);
    }
    
    // Clear textarea after successful submission
    const messageForm = document.getElementById('messageForm');
    const messageInput = document.getElementById('messageInput');
    
    if (messageForm) {
        messageForm.addEventListener('submit', function() {
            if (messageInput.value.trim() !== '') {
                setTimeout(() => {
                    messageInput.value = '';
                }, 100);
            }
        });
    }
</script>

<style>
    .bg-ju-offwhite { background-color: #f4f6fb; }
    .bg-ju-navy { background-color: #003087; }
    .bg-ju-navy-dark { background-color: #001f5e; }
    .bg-ju-gold { background-color: #C8960C; }
    .bg-ju-surface { background-color: #eef1f8; }
    .text-ju-navy { color: #003087; }
    .text-ju-navy-dark { color: #001f5e; }
    .text-ju-gold { color: #C8960C; }
    .text-ju-muted { color: #5a6480; }
    .text-ju-text { color: #1a1f36; }
    .border-ju-border { border-color: #c8d2e8; }
    
    .fade-in {
        animation: fadeIn 0.3s ease-in;
    }
    @keyframes fadeIn {
        from { opacity: 0; transform: translateY(10px); }
        to { opacity: 1; transform: translateY(0); }
    }
</style>
@endsection