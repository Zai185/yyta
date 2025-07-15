<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class ContactThankYouMail extends Mailable
{
    use Queueable, SerializesModels;

    public string $name;
    public string $messageText;
    public string $content;

    public function __construct(string $name, string $messageText, string $content)
    {
        $this->name = $name;
        $this->messageText = $messageText;
        $this->content = $content;
    }

    public function build(): self
    {
        return $this->subject('Thank you for contacting us, topic:' . $this->content)
                    ->view('emails.contact-thank-you');
    }
}
