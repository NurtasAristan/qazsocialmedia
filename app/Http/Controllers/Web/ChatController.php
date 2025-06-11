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

    public function store() 
    {
        $newChat = new Chat();
        $newChat->save();
        $newChat->users()->attach(Auth::id());
        return to_route('chat');
    }

    public function messages(Chat $chat)
    {
        return $chat->messages()->with('sender')->get();
    }

    public function sendMessage(Request $request, Chat $chat)
    {
        $message = $chat->messages()->create([
            'sender_id' => Auth::id(),
            'content' => $request->input('content'),
        ]);

        $message->load('sender');

        broadcast(new MessageSent($chat, $message))->toOthers();

        return response()->json($message);
    }
}