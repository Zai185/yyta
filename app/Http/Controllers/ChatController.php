<?php

namespace App\Http\Controllers;

use App\Models\ChatMessage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;

class ChatController extends Controller
{
    public function send(Request $request)
    {
        $request->validate([
            'message' => 'required|string|max:1000',
        ]);

        $message = ChatMessage::create([
            'session_id' => $request->session()->getId(),
            'message' => $request->input('message'),
        ]);

        // Optional: store in cache if you want both

        return response()->json(['success' => true]);
    }

    public function history()
    {
        $messages = ChatMessage::where('session_id', session()->getId())
            ->orderBy('created_at')
            ->get();

        return response()->json($messages);
    }
}
