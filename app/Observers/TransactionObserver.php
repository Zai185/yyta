<?php

namespace App\Observers;

use App\Models\Transaction;

class TransactionObserver
{
    public function updated(Transaction $transaction)
    {
        if (
            $transaction->isDirty('status') &&
            $transaction->status === 'completed' &&
            $transaction->student->status === 'inactive'
        ) {
            $transaction->student->update(['status' => 'active']);
        }
    }
}
