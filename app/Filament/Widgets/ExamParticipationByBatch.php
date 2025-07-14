<?php

namespace App\Filament\Widgets;

use App\Models\Batch;
use Filament\Widgets\BarChartWidget;

class ExamParticipationByBatch extends BarChartWidget
{
    protected static ?string $heading = 'Exam Participation Rate by Batch';
    protected static ?int $sort = 4;

    protected function getData(): array
    {
        $batches = Batch::withCount('students')->get();

        $labels = [];
        $participationRates = [];

        foreach ($batches as $batch) {
            $total = $batch->students_count;

            // Count students in this batch who have exam results
            $examTakers = $batch->students()
                ->whereHas('examResults') // assumes relationship exists
                ->count();

            $labels[] = $batch->name ?? "Batch {$batch->id}";
            $participationRates[] = $total > 0 ? round(($examTakers / $total) * 100, 1) : 0;
        }

        return [
            'datasets' => [
                [
                    'label' => 'Participation %',
                    'data' => $participationRates,
                    'backgroundColor' => 'rgba(75, 192, 192, 0.6)',
                ],
            ],
            'labels' => $labels,
        ];
    }
}
