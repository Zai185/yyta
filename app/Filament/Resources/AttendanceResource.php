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
use Filament\Tables\Filters\SelectFilter;
use Illuminate\Database\Eloquent\Builder;

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
                // Schedule Filter
                SelectFilter::make('schedule_id')
                    ->label('Schedule')
                    ->options(
                        Schedule::with('module')
                            ->get()
                            ->mapWithKeys(fn($s) => [
                                $s->id => $s->module->name . ' (' . \Carbon\Carbon::parse($s->start_at)->format('Y-m-d H:i') . ')'
                            ])
                    )
                    ->default(fn() => Schedule::first()?->id),

                // Batch Filter — connected to selected schedule
                SelectFilter::make('batch_id')
                    ->label('Batch')
                    ->options(function () {
                        $scheduleId = request()->input('tableFilters.schedule_id');

                        if (!$scheduleId) {
                            return Batch::pluck('name', 'id')->toArray();
                        }

                        // ✅ Returns a single Schedule instance, not a collection
                        $schedule = Schedule::with('module.course.batches')->find($scheduleId)[0];


                        if (!$schedule || !$schedule->module || !$schedule->module->course) {
                            return [];
                        }

                        return $schedule->module->course->batches->pluck('name', 'id')->toArray();
                    })

                    ->query(function (Builder $query, $state) {
                        if ($state) {
                            $query->whereHas('student.batch', fn($q) => $q->where('batch_id', $state));
                        }
                    })
                    ->default(fn() => dd($this)),
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
