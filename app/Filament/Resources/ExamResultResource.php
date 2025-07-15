<?php

namespace App\Filament\Resources;

use App\Models\ExamResult;
use App\Models\Exam;
use Filament\Resources\Resource;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Columns\TextColumn;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Select;
use App\Filament\Resources\ExamResultResource\Pages;
use Filament\Forms\Form;
use Filament\Tables\Table;

class ExamResultResource extends Resource
{
    protected static ?string $model = ExamResult::class;

    protected static ?string $navigationIcon = 'heroicon-o-academic-cap';
    protected static ?string $navigationGroup = 'Exam Management';

    public static function form(Form $form): Form
    {
        return $form->schema([
            Select::make('exam_id')
                ->label('Exam ID')
                ->relationship('exam', 'id')
                ->required(),

            Select::make('student_id')
                ->relationship('student', 'name')
                ->searchable()
                ->required(),

            TextInput::make('score')
                ->numeric()
                ->minValue(0)
                ->maxValue(100)
                ->required(),
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('student.name')
                    ->label('Student'),
                TextColumn::make('score')->label('Score')->sortable(),
            ])
            ->filters([
                SelectFilter::make('exam_id')
                    ->label('Exam')
                    ->preload()
                    ->relationship('exam', 'id')
                    ->searchable(),
                SelectFilter::make('batch_id')
                    ->label('Batch')
                    ->preload()
                    ->relationship('exam.batch', 'name')
                    ->searchable(),
            ]);
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListExamResults::route('/'),
            'create' => Pages\CreateExamResult::route('/create'),
            'edit' => Pages\EditExamResult::route('/{record}/edit'),
        ];
    }
}
