<?php

namespace App\Http\Controllers;

use App\Mail\NewMessageNotification;
use App\Models\Conversation;
use App\Models\Listing;
use App\Models\Message;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class MessageController extends Controller
{
    // Show all conversations for logged-in user
    public function index()
    {
        $userId = auth()->id();

        $conversations = Conversation::where('buyer_id', $userId)
            ->orWhere('seller_id', $userId)
            ->with(['listing', 'buyer', 'seller', 'lastMessage'])
            ->orderBy('last_message_at', 'desc')
            ->get();

        return view('messages.index', compact('conversations'));
    }

    // Show specific conversation
    public function show(Conversation $conversation)
    {
        if ($conversation->buyer_id !== auth()->id() && $conversation->seller_id !== auth()->id()) {
            abort(403);
        }

        Message::where('conversation_id', $conversation->id)
            ->where('receiver_id', auth()->id())
            ->where('is_read', false)
            ->update(['is_read' => true, 'read_at' => now()]);

        $messages = $conversation->messages()
            ->with(['sender', 'receiver'])
            ->orderBy('created_at', 'asc')
            ->get();

        return view('messages.show', compact('conversation', 'messages'));
    }

    // Start or get existing conversation
    public function start(Request $request, Listing $listing)
    {
        if ($listing->user_id === auth()->id()) {
            return back()->with('error', 'You cannot message yourself.');
        }

        $conversation = Conversation::where('listing_id', $listing->id)
            ->where('buyer_id', auth()->id())
            ->where('seller_id', $listing->user_id)
            ->first();

        if (! $conversation) {
            $conversation = Conversation::create([
                'listing_id' => $listing->id,
                'buyer_id' => auth()->id(),
                'seller_id' => $listing->user_id,
            ]);
        }

        return redirect()->route('messages.show', $conversation);
    }

    // Send message
    public function sendMessage(Request $request, Conversation $conversation)
    {
        $recentMessages = Message::where('sender_id', auth()->id())
            ->where('created_at', '>=', now()->subMinute())
            ->count();

        if ($recentMessages >= 10) {
            return back()->with('error', 'You can only send 10 messages per minute. Please wait.');
        }

        $request->validate([
            'message' => 'required|string|max:1000',
        ]);

        if ($conversation->buyer_id !== auth()->id() && $conversation->seller_id !== auth()->id()) {
            abort(403);
        }

        $receiverId = auth()->id() === $conversation->buyer_id
            ? $conversation->seller_id
            : $conversation->buyer_id;

        $message = Message::create([
            'conversation_id' => $conversation->id,
            'sender_id' => auth()->id(),
            'receiver_id' => $receiverId,
            'message' => $request->message,
        ]);

        $conversation->update(['last_message_at' => now()]);

        // ========== SEND EMAIL NOTIFICATION ==========
        try {
            // Send email to receiver (only if not read yet)
            if (! $message->is_read) {
                Mail::to($message->receiver->email)->queue(new NewMessageNotification($message, $message->sender, $message->receiver, $conversation));
            }
        } catch (\Exception $e) {
            \Log::error('Failed to send new message email: '.$e->getMessage());
        }
        // =============================================

        return redirect()->route('messages.show', $conversation)
            ->with('success', 'Message sent!');
    }

    // Get unread count (for AJAX)
    public function unreadCount()
    {
        $count = auth()->user()->unreadMessagesCount();

        return response()->json(['count' => $count]);
    }
}
