<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Chat;

class ChatController extends Controller
{
    public function index()
    {
        return view('chat');
    }

    
    public function fetchMessages(Request $request)
    {
        $userId = auth()->id();
        $messages = Chat::where(function ($query) use ($userId) {
            $query->where('sender_id', $userId)->orWhere('receiver_id', $userId);
        })
            ->orderBy('created_at', 'asc')
            ->get();

        return response()->json($messages);
    }

    public function sendMessage(Request $request)
    {
        $request->validate([
            'receiver_id' => 'required|exists:users,id',
            'message' => 'required|string|max:1000',
        ]);

        $message = Chat::create([
            'sender_id' => auth()->id(),
            'receiver_id' => $request->receiver_id,
            'message' => $request->message,
        ]);

        return response()->json($message);
    }
}
