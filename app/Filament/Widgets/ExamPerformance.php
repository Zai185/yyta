<?php

namespace App\Filament\Widgets;

use App\Models\Module;
use App\Models\ExamResult;
use Filament\Widgets\BarChartWidget;
use Filament\Widgets\Concerns\InteractsWithPageFilters;
use Illuminate\Support\Facades\DB;

class ExamPerformance extends BarChartWidget
{
    use InteractsWithPageFilters;

    protected static ?string $heading = 'Exam Performance';

    protected function getData(): array
    {

        $start = $this->filters['dateFrom'] ?? now()->startOfYear()->toDateString();
        $end = $this->filters['dateTo'] ?? now()->endOfYear()->toDateString();

        $modules = Module::all();
        $labels = [];
        $data = [];

        foreach ($modules as $module) {
            // Get exam IDs related to batches that have this module via batch_lecturers
            $batchIds = DB::table('batch_lecturers')->where('module_id', $module->id)->pluck('batch_id');
            $examIds = DB::table('exams')->whereIn('batch_id', $batchIds)->pluck('id');

            $avgScore = ExamResult::whereIn('exam_id', $examIds)
                ->whereBetween('created_at', [$start, $end])
                ->avg('score') ?? 0;

            $labels[] = $module->name;
            $data[] = round($avgScore, 2);
        }

        return [
            'datasets' => [
                [
                    'label' => 'Average Exam Score',
                    'data' => $data,
                    'backgroundColor' => 'rgba(255, 159, 64, 0.7)',
                ],
            ],
            'labels' => $labels,
        ];
    }
}
