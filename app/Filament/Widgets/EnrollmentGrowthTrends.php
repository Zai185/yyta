<?php

namespace App\Filament\Widgets;

use App\Models\Student;
use App\Models\Batch;
use Filament\Forms\Components\DatePicker;
use Filament\Widgets\LineChartWidget;
use Illuminate\Support\Carbon;

class EnrollmentGrowthTrends extends LineChartWidget
{
    protected static ?string $heading = 'Enrollment Growth Trends';

    // Default filter value
    public ?string $filter = 'yearly';

    // Define available filters for the widget
    protected function getFilters(): array
    {
        return [
            'weekly' => 'Weekly',
            'monthly' => 'Monthly',
            'yearly' => 'Yearly',
        ];
    }

    protected function getFormSchema(): array
    {
        return [
            DatePicker::make('startDate')
                ->label('From')
                ->default(now()->startOfMonth())
                ->reactive(),

            DatePicker::make('endDate')
                ->label('To')
                ->default(now())
                ->reactive(),
        ];
    }

    // This method will receive the selected filter key
    protected function getData(): array
    {
        // Get current selected filter or fallback to yearly
        $filter = $this->filter ?? 'yearly';

        if ($filter === 'weekly') {
            return $this->getWeeklyData();
        }

        if ($filter === 'monthly') {
            return $this->getMonthlyData();
        }

        return $this->getYearlyData();
    }

    protected function getYearlyData(): array
    {
        $batchNames = Batch::pluck('name')->toArray();

        $years = collect($batchNames)
            ->map(fn($name) => preg_match('/\d{4}/', $name, $matches) ? (int)$matches[0] : null)
            ->filter()
            ->unique()
            ->sort()
            ->values()
            ->toArray();

        $data = [];

        foreach ($years as $year) {
            $batchIds = Batch::where('name', 'like', "%{$year}%")->pluck('id');
            $count = Student::whereIn('batch_id', $batchIds)->count();
            $data[] = $count;
        }

        return [
            'datasets' => [
                [
                    'label' => 'Students Enrolled',
                    'data' => $data,
                    'backgroundColor' => 'rgba(255, 206, 86, 0.7)',
                    'borderColor' => 'rgba(255, 206, 86, 1)',
                    'fill' => true,
                ],
            ],
            'labels' => array_map(fn($y) => (string)$y, $years),
        ];
    }

    protected function getMonthlyData(): array
    {
        $labels = collect(range(0, 11))
            ->map(fn($i) => Carbon::now()->subMonths(11 - $i)->format('Y-m'))
            ->toArray();

        $data = [];

        foreach ($labels as $month) {
            $start = Carbon::createFromFormat('Y-m', $month)->startOfMonth();
            $end = (clone $start)->endOfMonth();

            $count = Student::whereBetween('created_at', [$start, $end])->count();

            $data[] = $count;
        }

        return [
            'datasets' => [
                [
                    'label' => 'Students Enrolled',
                    'data' => $data,
                    'backgroundColor' => 'rgba(54, 162, 235, 0.7)',
                    'borderColor' => 'rgba(54, 162, 235, 1)',
                    'fill' => true,
                ],
            ],
            'labels' => $labels,
        ];
    }

    protected function getWeeklyData(): array
    {
        $labels = collect(range(0, 11))
            ->map(fn($i) => Carbon::now()->subWeeks(11 - $i)->format('o-\WW'))
            ->toArray();

        $data = [];

        foreach ($labels as $weekLabel) {
            [$year, $week] = explode('-W', $weekLabel);
            $start = Carbon::now()->setISODate((int)$year, (int)$week)->startOfWeek();
            $end = (clone $start)->endOfWeek();

            $count = Student::whereBetween('created_at', [$start, $end])->count();

            $data[] = $count;
        }

        return [
            'datasets' => [
                [
                    'label' => 'Students Enrolled',
                    'data' => $data,
                    'backgroundColor' => 'rgba(75, 192, 192, 0.7)',
                    'borderColor' => 'rgba(75, 192, 192, 1)',
                    'fill' => true,
                ],
            ],
            'labels' => $labels,
        ];
    }
}
