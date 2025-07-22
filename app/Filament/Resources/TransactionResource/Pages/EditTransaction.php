<?php

namespace App\Filament\Resources\TransactionResource\Pages;

use App\Filament\Resources\TransactionResource;
use Filament\Actions;
use Filament\Forms\Form;
use Filament\Resources\Pages\EditRecord;

class EditTransaction extends EditRecord
{
    protected static string $resource = TransactionResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }

    public static function afterSave(Form $form): void
    {
        $transaction = $form->getRecord();

        if (
            $transaction->status === 'completed' &&
            $transaction->student->status === 'inactive'
        ) {
            $transaction->student->update(['status' => 'active']);
        }
    }
}
