<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class TransactionCreated extends Mailable
{
    use Queueable, SerializesModels;

    public $student;
    public $transaction;
    public $bankAccountNumber;

    /**
     * Create a new message instance.
     */
    public function __construct($student, $transaction, $bankAccountNumber = null)
    {
        $this->student = $student;
        $this->transaction = $transaction;
        $this->bankAccountNumber = $bankAccountNumber;
    }

    /**
     * Build the message.
     */
    public function build()
    {
        return $this->subject('Transaction Details')
            ->view('emails.transaction_created');
    }
}
