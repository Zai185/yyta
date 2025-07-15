<?php

namespace App\Filament\Widgets;

use App\Models\Course;
use App\Models\Student;
use App\Models\Module;
use App\Models\BatchLecturer;
use Carbon\Carbon;
use Filament\Widgets\BarChartWidget;
use Filament\Widgets\Concerns\InteractsWithPageFilters;

class CoursePopularity extends BarChartWidget
{
    use InteractsWithPageFilters;
    protected static ?string $heading = 'Course Popularity';

    protected function getData(): array
    {
        $start = $this->filters['dateFrom'] ?? now()->startOfYear()->toDateString();
        $end = $this->filters['dateTo'] ?? now()->endOfYear()->toDateString();

        $courses = Course::all();
        $labels = [];
        $data = [];

        foreach ($courses as $course) {
            $moduleIds = Module::where('course_id', $course->id)->pluck('id');

            $batchIds = BatchLecturer::whereIn('module_id', $moduleIds)
                ->pluck('batch_id')
                ->unique();

            $studentCount = Student::whereIn('batch_id', $batchIds)
                ->whereBetween('created_at', [$start, $end])
                ->count();

            $labels[] = $course->name;
            $data[] = $studentCount;
        }

        return [
            'datasets' => [
                [
                    'label' => 'Students Enrolled',
                    'data' => $data,
                    'backgroundColor' => 'rgba(54, 162, 235, 0.7)',
                ],
            ],
            'labels' => $labels,
        ];
    }

    protected function getOptions(): array
    {
        return [
            'indexAxis' => 'y', // makes the bar chart horizontal
        ];
    }
}
