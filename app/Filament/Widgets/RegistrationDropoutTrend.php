<?php

namespace App\Filament\Widgets;

use App\Models\Student;
use Filament\Widgets\LineChartWidget;
use Filament\Widgets\Concerns\InteractsWithPageFilters;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;

class RegistrationDropoutTrend extends LineChartWidget
{
    use InteractsWithPageFilters;

    protected static ?string $heading = 'Registration vs Dropout Trend';

    protected function getData(): array
    {
        // 1. Date range
        $start = isset($this->filters['dateFrom'])
            ? Carbon::parse($this->filters['dateFrom'])->startOfDay()
            : now()->startOfYear();

        $end = isset($this->filters['dateTo'])
            ? Carbon::parse($this->filters['dateTo'])->endOfDay()
            : now()->endOfYear();

        $diffInDays = $start->diffInDays($end);
        $diffInMonths = $start->diffInMonths($end);

        // 2. Grouping
        if ($diffInDays <= 60) {
            $groupBy = 'week';
            $labelFormat = 'W Y';
            $sqlFormat = '%x-%v';  // e.g., 2024-27
            $phpFormat = 'o-W';
            $addMethod = 'addWeek';
        } elseif ($diffInMonths <= 12) {
            $groupBy = 'month';
            $labelFormat = 'M Y';
            $sqlFormat = '%Y-%m'; // e.g., 2024-01
            $phpFormat = 'Y-m';
            $addMethod = 'addMonth';
        } else {
            $groupBy = 'year';
            $labelFormat = 'Y';
            $sqlFormat = '%Y';
            $phpFormat = 'Y';
            $addMethod = 'addYear';
        }

        // 3. Buckets
        $labels = [];
        $keys = [];
        $period = $start->copy();

        while ($period <= $end) {
            $key = $period->format($phpFormat);       // for DB pluck match
            $label = $period->format($labelFormat);   // for chart display
            $labels[] = $label;
            $keys[] = $key;
            $period->{$addMethod}();
        }

        // 4. DB Queries
        $registrations = Student::selectRaw("DATE_FORMAT(created_at, '{$sqlFormat}') as grp, COUNT(*) as total")
            ->whereBetween('created_at', [$start, $end])
            ->where('status', 'active')
            ->groupBy('grp')
            ->pluck('total', 'grp');

        $dropouts = Student::selectRaw("DATE_FORMAT(updated_at, '{$sqlFormat}') as grp, COUNT(*) as total")
            ->whereBetween('updated_at', [$start, $end])
            ->where('status', 'dropped')
            ->groupBy('grp')
            ->pluck('total', 'grp');

        // 5. Match to labels
        $registrationData = collect($keys)->map(fn($key) => $registrations->get($key, 0))->toArray();
        $dropoutData = collect($keys)->map(fn($key) => $dropouts->get($key, 0))->toArray();

        return [
            'datasets' => [
                [
                    'label' => 'Registrations',
                    'data' => $registrationData,
                    'borderColor' => 'rgba(54, 162, 235, 1)',
                    'backgroundColor' => 'rgba(54, 162, 235, 0.2)',
                    'fill' => true,
                    'tension' => 0.4,
                ],
                [
                    'label' => 'Dropouts',
                    'data' => $dropoutData,
                    'borderColor' => 'rgba(255, 99, 132, 1)',
                    'backgroundColor' => 'rgba(255, 99, 132, 0.2)',
                    'fill' => true,
                    'tension' => 0.4,
                ],
            ],
            'labels' => $labels,
        ];
    }
}
