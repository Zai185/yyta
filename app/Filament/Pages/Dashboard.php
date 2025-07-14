<?php

namespace App\Filament\Pages;

use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Pages\Dashboard\Concerns\HasFiltersForm;
use Filament\Widgets\Concerns\InteractsWithPageFilters;

class Dashboard extends \Filament\Pages\Dashboard
{
    use HasFiltersForm;
    
    public function filtersForm(Form $form): Form
    {
        return $form->schema([
            DatePicker::make('dateFrom')->label('From')->default(now()->startOfMonth())->reactive(),
            DatePicker::make('dateTo')->label('To')->default(now())->reactive(),
        ]);
    }
}
