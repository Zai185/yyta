<?php

namespace App\Filament\Pages;

use App\Models\Schedule;
use Filament\Pages\Page;

class Calendar extends Page
{
    protected static ?string $navigationIcon = 'heroicon-o-calendar';

    protected static string $view = 'filament.page.calendar';

    public array $schedules;

    public ?string $selectedSchedule = null;

    public function mount()
    {
        $this->schedules = Schedule::with('module')->get()->mapWithKeys(function ($schedule) {
            return [$schedule->id => $schedule->module?->name];
        })->toArray();

        $this->selectedSchedule = array_key_first($this->schedules);
    }
}
