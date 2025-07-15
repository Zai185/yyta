<?php

namespace App\Filament\Resources;

use App\Filament\Resources\ExamResource\Pages;
use App\Models\Exam;
use Filament\Resources\Resource;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\TimePicker;
use Filament\Tables\Columns\TextColumn;

class ExamResource extends Resource
{
    protected static ?string $model = Exam::class;

    protected static ?string $navigationIcon = 'heroicon-o-document-text';
    protected static ?string $navigationGroup = 'Exam Management';

    public static function form(Form $form): Form
    {
        return $form->schema([
            Select::make('batch_id')
                ->relationship('batch', 'name')
                ->required()
                ->preload()
                ->searchable(),
                
                Select::make('module_id')
                ->relationship('module', 'name')
                ->required()
                ->preload()
                ->searchable(),

            DatePicker::make('start_date')
                ->required(),

            TimePicker::make('start_at')
                ->required(),

            TimePicker::make('end_at')
                ->required(),
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('batch.name')->label('Batch'),
                TextColumn::make('module.name')->label('Module'),
                TextColumn::make('start_date')->date(),
                TextColumn::make('start_at')->time(),
                TextColumn::make('end_at')->time(),
            ])
            ->defaultSort('start_date', 'desc');
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListExams::route('/'),
            'create' => Pages\CreateExam::route('/create'),
            'edit' => Pages\EditExam::route('/{record}/edit'),
        ];
    }
}
