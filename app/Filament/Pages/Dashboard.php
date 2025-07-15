<?php

namespace App\Filament\Pages;

use App\Filament\Widgets\AverageGradesPerCourse;
use App\Filament\Widgets\CoursePopularity;
use App\Filament\Widgets\DepartmentWiseFeeCollection;
use App\Filament\Widgets\EnrollmentGrowthTrends;
use App\Filament\Widgets\ExamPerformance;
use App\Filament\Widgets\FeePaymentTrends;
use App\Filament\Widgets\GradeDistribution;
use App\Filament\Widgets\PassFailRates;
use App\Filament\Widgets\ProfessorWorkload;
use App\Filament\Widgets\RegistrationDropoutTrend;
use App\Filament\Widgets\StudentAverageScoreTable;
use App\Filament\Widgets\TotalIncomeTrend;
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

    public function getWidgets(): array
    {
        return [
            CoursePopularity::class,
            ExamPerformance::class,
            ProfessorWorkload::class,
            TotalIncomeTrend::class,
            RegistrationDropoutTrend::class,
            GradeDistribution::class,
            PassFailRates::class,
            EnrollmentGrowthTrends::class,
            AverageGradesPerCourse::class,
            DepartmentWiseFeeCollection::class,
            FeePaymentTrends::class,
            StudentAverageScoreTable::class,

        ];
    }
}
