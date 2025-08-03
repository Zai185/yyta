<?php

namespace App\Filament\Resources\TransactionResource\Pages;

use App\Filament\Resources\TransactionResource;
use App\Mail\TransactionCreated;
use Exception;
use Filament\Actions;
use Filament\Forms\Form;
use Filament\Resources\Pages\EditRecord;
use Illuminate\Support\Facades\Mail;

class EditTransaction extends EditRecord
{
    protected static string $resource = TransactionResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }

    protected function afterSave(): void
    {
        try {

            $transaction = $this->record;

            if (
                $transaction->status === 'completed' &&
                $transaction->student->status === 'inactive'
            ) {
                $transaction->student->update(['status' => 'active']);
            }
            Mail::to($transaction->student->email)->send(new TransactionCreated(
                $transaction->student,
                $transaction
            ));
        } catch (Exception $e) {
            logger()->error($e->getMessage());
        }
    }
}
