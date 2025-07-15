<?php

namespace App\Filament\Widgets;

use Saade\FilamentFullCalendar\Widgets\FullCalendarWidget;
use App\Models\Schedule;
use Filament\Forms\Components\DateTimePicker;
use Filament\Forms\Components\Select;
use Illuminate\Database\Eloquent\Model;
// use Filament\Forms\Components\Actions\Action;
use Filament\Actions\Action;
use Filament\Actions\DeleteAction;
use Filament\Actions\EditAction;
use Filament\Notifications\Notification;

class MyCalendarWidget extends FullCalendarWidget
{

    public Model | string | null $model = Schedule::class;

    public ?string $selectedSchedule = null;

    public function fetchEvents(array $fetchInfo): array
    {
        $schedules =  Schedule::query()
            ->where('start_at', '>=', $fetchInfo['start'])
            ->where('end_at', '<=', $fetchInfo['end'])
            ->get()
            ->map(fn(Schedule $schedule) => [
                'id' => $schedule->id,
                'title' => $schedule->module->name,
                'start' => $schedule->start_at,
                'end' => $schedule->end_at,
            ])
            ->toArray();

        return $schedules;
    }

    public function getFormSchema(): array
    {
        return [
            Select::make('module_id')
                ->relationship('module', 'name')
                ->required(),

            DateTimePicker::make('start_at')
                ->required(),

            DateTimePicker::make('end_at')
                ->required(),
        ];
    }

    protected function modalActions(): array
    {
        return [
            EditAction::make(),
            DeleteAction::make(),

            Action::make('viewAttendance')
                ->label('View Attendance')
                ->url(fn($record) => route('filament.admin.resources.attendances.index', [
                    'tableFilters[schedule_id][value]' => $record->id,
                ]))
                ->openUrlInNewTab()
                ->color('success'),
        ];
    }

    public function getEventRecord($id): ?Schedule
    {
        return Schedule::find($id); // used when clicking on event
    }

    public function config(): array
    {
        return [
            'initialView' => 'dayGridMonth',
            'headerToolbar' => [
                'left' => 'prev,next today',
                'center' => 'title',
                'right' => 'dayGridMonth,timeGridWeek,timeGridDay',
            ],
        ];
    }
}
