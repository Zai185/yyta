<?php

namespace App\Filament\Resources;

use App\Filament\Resources\TransactionResource\Pages;
use App\Models\Transaction;
use App\Models\Student;
use App\Models\Course;
use App\Models\User;
use Filament\Forms;
use Filament\Tables;
use Filament\Resources\Resource;
use Filament\Forms\Form;
use Filament\Tables\Table;
use Filament\Tables\Columns\TextColumn;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Select;

class TransactionResource extends Resource
{
    protected static ?string $model = Transaction::class;

    protected static ?string $navigationIcon = 'heroicon-o-currency-dollar';
    protected static ?string $navigationGroup = 'Finance';
    protected static ?string $navigationLabel = 'Transactions';

    public static function form(Form $form): Form
    {
        return $form->schema([
            Select::make('student_id')
                ->relationship('student', 'name')
                ->searchable()
                ->preload()
                ->required(),

            Select::make('course_id')
                ->relationship('course', 'name')
                ->searchable()
                ->preload()
                ->required(),

            TextInput::make('amount')
                ->numeric()
                ->required()
                ->prefix('$'),

            Select::make('payment_method')
                ->options([
                    'cash' => 'Cash',
                    'bank_transfer' => 'Bank Transfer',
                    'paypal' => 'PayPal',
                    'other' => 'Other',
                ])
                ->required(),

            Select::make('status')
                ->options([
                    'pending' => 'Pending',
                    'completed' => 'Completed',
                    'failed' => 'Failed',
                ])
                ->required(),

            Select::make('updated_by')
                ->label('Updated By')
                ->relationship('updatedBy', 'name')
                ->searchable()
                ->default(auth('web')->id()),
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('student.name')->label('Student')->sortable()->searchable(),
                TextColumn::make('course.name')->label('Course')->sortable()->searchable(),
                TextColumn::make('amount'),
                TextColumn::make('payment_method')->label('Payment Method')->sortable(),
                TextColumn::make('status')->badge(),
                TextColumn::make('updatedBy.name')->label('Updated By'),
                TextColumn::make('updated_at')->dateTime('Y-m-d H:i')->sortable(),
            ])
            ->filters([
                Tables\Filters\SelectFilter::make('status')
                    ->options([
                        'pending' => 'Pending',
                        'paid' => 'Completed',
                        'failed' => 'Failed',
                    ]),
            ]);
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListTransactions::route('/'),
            'create' => Pages\CreateTransaction::route('/create'),
            'edit' => Pages\EditTransaction::route('/{record}/edit'),
        ];
    }
}
