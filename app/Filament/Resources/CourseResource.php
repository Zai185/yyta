<?php

namespace App\Filament\Resources;

use App\Filament\Resources\CourseResource\Pages;
use App\Models\Course;
use Filament\Forms;
use Filament\Forms\Components\Grid;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Support\Str;


class CourseResource extends Resource
{
    protected static ?string $model = Course::class;

    protected static ?string $navigationGroup = 'Academic Structure';

    protected static ?int $navigationSort = 1;

    protected static ?string $navigationIcon = 'heroicon-o-book-open';

    public static function form(Form $form): Form
    {

        return $form
            ->schema([
                Grid::make(3)->schema([
                    Forms\Components\TextInput::make('name')
                        ->required()
                        ->label('Course Name'),

                    Forms\Components\TextInput::make('duration')
                        ->required()
                        ->numeric()
                        ->label('Duration'),

                    Forms\Components\TextInput::make('fee')
                        ->required()
                        ->label('Fee'),
                ]),

                Grid::make(2)->schema([
                    Forms\Components\RichEditor::make('description')
                        ->label('Description')
                        ->required(),

                    Forms\Components\FileUpload::make('img_url')
                        ->label('Course Image')
                        ->disk('public')
                        ->directory('courses')
                        ->image()
                        ->required(),
                ]),

                Forms\Components\Toggle::make('is_online')
                    ->label('Is Online?'),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('id')->sortable(),
                Tables\Columns\TextColumn::make('name')->sortable(),
                Tables\Columns\TextColumn::make('duration')->sortable(),
                Tables\Columns\TextColumn::make('fee')->sortable(),
                Tables\Columns\BooleanColumn::make('is_online')->label('Online'),
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListCourses::route('/'),
            'create' => Pages\CreateCourse::route('/create'),
            'edit' => Pages\EditCourse::route('/{record}/edit'),
        ];
    }
}
