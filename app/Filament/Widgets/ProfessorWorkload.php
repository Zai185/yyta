<?php

namespace App\Filament\Widgets;

use App\Models\Lecturer;
use App\Models\BatchLecturer;
use Filament\Widgets\BarChartWidget;

class ProfessorWorkload extends BarChartWidget
{
    protected static ?string $heading = 'Professor Workload';

    public ?string $filter = 'desc'; // default sorting direction

    protected function getFilters(): array
    {
        return [
            'asc' => 'Least Workload',
            'desc' => 'Most Workload',
        ];
    }

    protected function getData(): array
    {
        $direction = $this->filter ?? 'desc';

        $workloads = Lecturer::all()->map(function ($lecturer) {
            return [
                'name' => $lecturer->name,
                'workload' => BatchLecturer::where('lecturer_id', $lecturer->id)->count(),
            ];
        });

        $workloads = $direction === 'asc'
            ? $workloads->sortBy('workload')
            : $workloads->sortByDesc('workload');

        $workloads = $workloads->take(12)->values();

        return [
            'datasets' => [
                [
                    'label' => 'Assigned Modules',
                    'data' => $workloads->pluck('workload'),
                    'backgroundColor' => 'rgba(54, 162, 235, 0.7)',
                ],
            ],
            'labels' => $workloads->pluck('name'),
        ];
    }
}
