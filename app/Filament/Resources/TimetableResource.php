<?php

namespace App\Filament\Resources;

use App\Filament\Resources\TimetableResource\Pages;
use App\Filament\Resources\TimetableResource\RelationManagers;
use App\Models\Module;
use App\Models\Timetable;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Filament\Forms\Components\Repeater;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\TimePicker;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\HasManyRepeater;

class TimetableResource extends Resource
{
    protected static ?string $model = Timetable::class;

    protected static ?string $navigationGroup = 'Scheduling & Grouping';

    protected static ?int $navigationSort = 1;

    protected static ?string $navigationIcon = 'heroicon-o-clock';

    public static function form(Form $form): Form
    {
        return $form->schema([
            TextInput::make('name')
                ->required()
                ->label('Timetable Name'),

            DatePicker::make('start_date')
                ->required()
                ->label('Start Date'),

            DatePicker::make('end_date')
                ->required()
                ->label('End Date'),

            Repeater::make('slots')
                ->relationship('slots')
                ->label('Time Slots')
                ->schema([
                    Select::make('day_of_week')
                        ->options([
                            'Monday' => 'Monday',
                            'Tuesday' => 'Tuesday',
                            'Wednesday' => 'Wednesday',
                            'Thursday' => 'Thursday',
                            'Friday' => 'Friday',
                        ])
                        ->required(),

                    TimePicker::make('start_time')->required(),
                    TimePicker::make('end_time')->required(),

                    Select::make('module_id')
                        ->relationship('module', 'name')
                        ->required()
                        ->label('Module'),
                ])
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('name')->searchable()->sortable(),
                TextColumn::make('slots_count')
                    ->label('Slot Count')
                    ->counts('slots'),
                TextColumn::make('created_at')->dateTime()->label('Created'),
            ]);
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListTimetables::route('/'),
            'create' => Pages\CreateTimetable::route('/create'),
            'edit' => Pages\EditTimetable::route('/{record}/edit'),
        ];
    }
}
