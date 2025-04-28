<?php

namespace App\Http\Controllers\Web;

use App\Models\Chat;
use App\Models\Message;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Inertia\Inertia;

class ChatController extends Controller
{
    public function index()
    {
        $chats = Auth::user()->chats()->with('users', 'messages.sender')->get();

        return Inertia::render('Chat/Index', [
            'chats' => $chats,
        ]);
    }

    public function show(Chat $chat)
    {
        $chat->load('users', 'messages.sender');

        return Inertia::render('Chat/Show', [
            'chat' => $chat,
        ]);
    }

    public function sendMessage(Request $request, Chat $chat)
    {
        $message = $chat->messages()->create([
            'sender_id' => Auth::id(),
            'content' => $request->input('content'),
        ]);

        // Broadcast event here (Pusher)
        broadcast(new \App\Events\MessageSent($chat, $message))->toOthers();

        return response()->json($message);
    }
}