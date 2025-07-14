<?php

namespace App\Filament\Widgets;

use App\Models\ExamResult;
use Filament\Widgets\BarChartWidget;
use Filament\Widgets\Concerns\InteractsWithPageFilters;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;

class PassFailRates extends BarChartWidget
{
    use InteractsWithPageFilters;

    protected static ?string $heading = 'Pass/Fail Rates Over Time';

    protected function getData(): array
    {
        $passingScore = 50;

        // Get global page filters (dateFrom, dateTo)
        $start = isset($this->filters['dateFrom'])
            ? Carbon::parse($this->filters['dateFrom'])->startOfDay()
            : now()->startOfMonth();

        $end = isset($this->filters['dateTo'])
            ? Carbon::parse($this->filters['dateTo'])->endOfDay()
            : now()->endOfDay();

        $totalMonths = $start->diffInMonths($end) + 1;
        $groupBy = $totalMonths > 12 ? 'YEAR' : 'MONTH';

        // Base query scoped by exam's date range
        $results = ExamResult::selectRaw("
                {$groupBy}(exams.start_date) as period,
                SUM(CASE WHEN exam_results.score >= ? THEN 1 ELSE 0 END) as pass_count,
                SUM(CASE WHEN exam_results.score < ? THEN 1 ELSE 0 END) as fail_count
            ", [$passingScore, $passingScore])
            ->join('exams', 'exams.id', '=', 'exam_results.exam_id')
            ->whereBetween('exams.start_date', [$start, $end])
            ->groupBy(DB::raw("{$groupBy}(exams.start_date)"))
            ->orderBy('period')
            ->get();

        // Prepare labels and data
        $labels = $this->generateLabels($start, $end, $groupBy);
        $passData = [];
        $failData = [];

        // Index results by period
        $resultMap = $results->keyBy('period');

        foreach ($labels as $key => $label) {
            $period = $groupBy === 'MONTH' ? $key + 1 : $label;
            $passData[] = $resultMap[$period]->pass_count ?? 0;
            $failData[] = $resultMap[$period]->fail_count ?? 0;
        }

        return [
            'datasets' => [
                [
                    'label' => 'Pass',
                    'data' => $passData,
                    'backgroundColor' => 'rgba(75, 192, 192, 0.7)',
                ],
                [
                    'label' => 'Fail',
                    'data' => $failData,
                    'backgroundColor' => 'rgba(255, 99, 132, 0.7)',
                ],
            ],
            'labels' => array_values($labels),
        ];
    }

    private function generateLabels($start, $end, $groupBy): array
    {
        if ($groupBy === 'YEAR') {
            return range($start->year, $end->year);
        }

        $labels = [];
        $current = $start->copy();

        while ($current <= $end) {
            $labels[] = $current->format('F');
            $current->addMonth();
        }

        return $labels;
    }
}
