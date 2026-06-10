@extends('layouts.app-new')

@section('content')
<div class="bg-ju-offwhite min-h-screen py-12">
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
        
        <!-- Header -->
        <div class="text-center mb-10">
            <div class="inline-flex items-center justify-center w-20 h-20 bg-ju-navy/10 rounded-full mb-4">
                <i class="fas fa-envelope text-ju-navy text-3xl"></i>
            </div>
            <h1 class="text-3xl font-bold text-ju-navy-dark">Messages</h1>
            <p class="text-ju-muted mt-2">Communicate with buyers and sellers</p>
            @php $unreadCount = auth()->user()->unreadMessagesCount(); @endphp
            @if($unreadCount > 0)
                <div class="inline-block mt-3 px-4 py-1 bg-ju-gold/20 text-ju-navy-dark rounded-full text-sm font-semibold">
                    <i class="fas fa-circle text-[6px] text-ju-gold mr-1"></i> {{ $unreadCount }} unread messages
                </div>
            @else
                <p class="text-ju-muted mt-2">All caught up! No new messages</p>
            @endif
        </div>
        
        <!-- Messages List -->
        <div class="bg-white rounded-xl shadow-md border border-ju-border/50 overflow-hidden">
            <div class="divide-y divide-ju-border">
                @forelse($conversations as $conversation)
                    @php
                        $otherUser = $conversation->buyer_id === auth()->id() ? $conversation->seller : $conversation->buyer;
                        $unreadCount = $conversation->unreadMessagesFor(auth()->id());
                    @endphp
                    
                    <a href="{{ route('messages.show', $conversation) }}" 
                       class="block p-5 hover:bg-ju-surface transition-all {{ $unreadCount > 0 ? 'bg-ju-gold/5 border-l-4 border-ju-gold' : '' }}">
                        <div class="flex items-start gap-4">
                            <!-- Avatar -->
                            <div class="w-12 h-12 bg-ju-navy rounded-full flex items-center justify-center text-white font-bold text-lg flex-shrink-0">
                                {{ substr($otherUser->name, 0, 1) }}
                            </div>
                            
                            <!-- Content -->
                            <div class="flex-1 min-w-0">
                                <div class="flex justify-between items-start">
                                    <div>
                                        <h3 class="font-semibold text-ju-navy-dark text-lg">
                                            {{ $otherUser->name }}
                                            @if($unreadCount > 0)
                                                <span class="ml-2 px-2 py-0.5 bg-ju-gold text-white text-xs rounded-full">{{ $unreadCount }}</span>
                                            @endif
                                        </h3>
                                        <p class="text-sm text-ju-muted mt-0.5">
                                            <i class="fas fa-tag mr-1 text-ju-gold text-xs"></i>
                                            {{ Str::limit($conversation->listing->title, 40) }}
                                        </p>
                                    </div>
                                    @if($conversation->lastMessage)
                                        <p class="text-xs text-ju-muted whitespace-nowrap ml-4">{{ $conversation->lastMessage->created_at->diffForHumans() }}</p>
                                    @endif
                                </div>
                                
                                @if($conversation->lastMessage)
                                    <p class="text-ju-text text-sm mt-2 line-clamp-2">
                                        {{ Str::limit($conversation->lastMessage->message, 80) }}
                                    </p>
                                @endif
                            </div>
                            
                            <i class="fas fa-chevron-right text-ju-muted text-sm mt-3 flex-shrink-0"></i>
                        </div>
                    </a>
                @empty
                    <div class="text-center py-16">
                        <i class="fas fa-inbox text-ju-muted text-5xl mb-4 block"></i>
                        <p class="text-ju-muted text-lg mb-4">No messages yet.</p>
                        <a href="{{ route('listings.index') }}" class="inline-block bg-ju-navy hover:bg-ju-navy-dark text-white px-6 py-3 rounded-lg font-semibold transition shadow-sm">
                            Browse Items to Start a Conversation
                        </a>
                    </div>
                @endforelse
            </div>
        </div>
    </div>
</div>

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
    
    .line-clamp-2 {
        display: -webkit-box;
        -webkit-line-clamp: 2;
        -webkit-box-orient: vertical;
        overflow: hidden;
    }
</style>
@endsection