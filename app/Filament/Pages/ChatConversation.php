<?php

namespace App\Filament\Pages;

use Filament\Pages\Page;
use App\Models\ChatMessage;

class ChatConversation extends Page
{
    protected static ?string $title = 'Chat Conversation';
    protected static string $view = 'filament.pages.chat-conversation';

    public $replyMessage = '';

    // ✅ Use a computed property instead of storing a Collection as a public property
    public function getMessagesProperty()
    {
        return ChatMessage::orderBy('created_at')
            ->get();
    }

    public function sendReply()
    {
        $this->validate([
            'replyMessage' => 'required|string|max:1000',
        ]);

        ChatMessage::create([
            'message' => $this->replyMessage,
            'sender' => 'Admin', // Set sender explicitly
            'session_id' => 'admin',
        ]);

        $this->replyMessage = '';
        // ✅ No need to manually reload messages; the computed property will reflect new data
    }
}
