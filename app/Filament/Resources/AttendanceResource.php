<?php

namespace App\Filament\Resources;

use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Columns\CheckboxColumn;
use Filament\Tables\Columns\TextColumn;
use App\Models\Attendance;
use App\Models\Batch;
use App\Models\Schedule;
use Carbon\Carbon;

class AttendanceResource extends Resource
{
    protected static ?string $model = Attendance::class;
    protected static ?string $navigationGroup = 'Attendance';
    protected static ?string $navigationLabel = 'Mark Attendance';
    protected static ?string $navigationIcon = 'heroicon-o-check-badge';

    public static function table(Tables\Table $table): Tables\Table
    {
        return $table
            ->columns([
                TextColumn::make('student.name')->label('Student'),
                CheckboxColumn::make('is_present')
                    ->label('Present')
                    ->afterStateUpdated(function ($record, $state) {
                        $record->update(['is_present' => $state]);
                    }),
            ])
            ->filters([
                Tables\Filters\SelectFilter::make('schedule_id')
                    ->label('Schedule')
                    ->options(
                        Schedule::with('module')
                            ->get()
                            ->mapWithKeys(fn($s) => [
                                $s->id => $s->module->name . ' (' . Carbon::parse($s->start_at)->format('Y-m-d H:i') . ')'
                            ])
                    )
                    ->default(fn() => Schedule::first()?->id),

                Tables\Filters\SelectFilter::make('batch_id')
                    ->label('Batch')
                    ->options(
                        Batch::pluck('name', 'id')->toArray()
                    )
                    ->query(function ($query, $state) {
                        $query->whereHas('student.batch', function ($q) use ($state) {
                            $q->where('batch_id', $state);
                        });
                    }),

            ]);
    }

    public static function canCreate(): bool
   {
      return false;
   }
    public static function getPages(): array
    {
        return [
            'index' => \App\Filament\Resources\AttendanceResource\Pages\ListAttendances::route('/'),
        ];
    }
}
