<?php

namespace App\Filament\Widgets;

use App\Models\ExamResult;
use Filament\Widgets\BarChartWidget;

class GradeDistribution extends BarChartWidget
{
    protected static ?string $heading = 'Grade Distribution';

    protected function getData(): array
    {
        // Group scores into ranges 0-10, 11-20, ..., 91-100
        $buckets = array_fill(0, 10, 0);

        $results = ExamResult::all();

        foreach ($results as $result) {
            $bucket = min(floor($result->score / 10), 9);
            $buckets[$bucket]++;
        }

        $labels = [];
        for ($i = 0; $i < 10; $i++) {
            $labels[] = ($i * 10) . '-' . ($i * 10 + 9);
        }

        return [
            'datasets' => [
                [
                    'label' => 'Number of Students',
                    'data' => $buckets,
                    'backgroundColor' => 'rgba(75, 192, 192, 0.7)',
                ],
            ],
            'labels' => $labels,
        ];
    }
}
