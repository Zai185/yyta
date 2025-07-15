<x-filament::page>
    <div style="display: flex; flex-direction: column; gap: 10px;">
        {{-- Chat Messages --}}
        @foreach ($this->messages as $msg)
            @if ($msg->session_id === 'admin')
                <div style="background: #e5e5ea; color: black; padding: 10px 15px; border-radius: 15px; max-width: 70%; text-align: left;">
                    {{ $msg->message }}
                    <div style="font-size: 0.75rem; color: #666;">{{ $msg->created_at->format('Y-m-d H:i') }}</div>
                </div>
            @else
                <div style="background: #d03b3b; color: white; padding: 10px 15px; border-radius: 15px; max-width: 70%; text-align: right; margin-left: auto;">
                    {{ $msg->message }}
                    <div style="font-size: 0.75rem; color: #eee;">{{ $msg->created_at->format('Y-m-d H:i') }}</div>
                </div>
            @endif
        @endforeach

        {{-- Admin Reply Form --}}
        <form wire:submit.prevent="sendReply" style="margin-top: 20px; display: flex; flex-direction: column; gap: 10px;">
            <textarea wire:model.defer="replyMessage" rows="3" placeholder="Type your reply..." class="bg-white border p-2 rounded"></textarea>

            @error('replyMessage')
                <div style="color:red;">{{ $message }}</div>
            @enderror

            <button type="submit">Send Reply</button>
        </form>
    </div>
</x-filament::page>
