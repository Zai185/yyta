<?php

namespace App\Filament\Widgets;

use App\Models\Course;
use App\Models\ExamResult;
use App\Models\Module;
use Filament\Widgets\ChartWidget;

class AverageGradesPerCourse extends ChartWidget
{
    protected static ?string $heading = 'Average Grade Per Course';

    protected function getData(): array
    {
        $courses = Course::all();
        $labels = [];
        $data = [];

        foreach ($courses as $course) {
            $modules = Module::where('course_id', $course->id)->pluck('id');
            $examResults = ExamResult::whereIn('exam_id', function ($query) use ($modules) {
                $query->select('id')->from('exams')->whereIn('batch_id', function ($q) use ($modules) {
                    $q->select('batch_id')->from('batch_lecturers')->whereIn('module_id', $modules);
                });
            })->get();

            $avgScore = $examResults->avg('score') ?? 0;

            $labels[] = $course->name;
            $data[] = round($avgScore, 2);
        }

        return [
            'datasets' => [
                [
                    'label' => 'Average Score',
                    'data' => $data,
                    'backgroundColor' => 'rgba(153, 102, 255, 0.7)',
                ],
            ],
            'labels' => $labels,
        ];
    }

    protected function getType(): string
    {
        return 'bar';
    }
}
