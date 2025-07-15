<?php

namespace App\Filament\Resources\TimetableResource\Pages;

use App\Filament\Resources\TimetableResource;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;

class CreateTimetable extends CreateRecord
{
    protected static string $resource = TimetableResource::class;

    protected function afterCreate(): void
    {
        $this->record->load('slots'); // ensure slots are loaded
        $this->record->generateSchedules();
    }
}
