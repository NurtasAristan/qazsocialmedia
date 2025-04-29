<?php

namespace App\Http\Controllers\Web;

use App\Events\MessageSent;
use App\Models\Chat;
use App\Models\Message;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Inertia\Inertia;

class ChatController extends Controller
{
    public function index()
    {
        $chats = Auth::user()->chats()->with('users')->get();

        return Inertia::render('Chat', [
            'chats' => $chats,
        ]);
    }

    public function messages(Chat $chat)
    {
        return $chat->messages()->with('sender')->get();
    }
    
    /*public function index()
    {
        $chats = Auth::user()->chats()->with('users', 'messages.sender')->get();
        Log::info($chats);

        return Inertia::render('Chat/Index', [
            'chats' => $chats,
        ]);
    }

    public function show(Chat $chat)
    {
        $chat->load('users', 'messages.sender');
        Log::info($chat);

        return Inertia::render('Chat/Show', [
            'chat' => $chat,
        ]);
    }*/

    public function sendMessage(Request $request, Chat $chat)
    {
        $message = $chat->messages()->create([
            'sender_id' => Auth::id(),
            'content' => $request->input('content'),
        ]);

        $message->load('sender');
        Log::info($message);

        // Broadcast event here (Pusher)
        broadcast(new MessageSent($chat, $message))->toOthers();

        return response()->json($message);
    }
}