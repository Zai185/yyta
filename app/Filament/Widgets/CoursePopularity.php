<?php

namespace App\Filament\Widgets;

use App\Models\Course;
use App\Models\Student;
use App\Models\Module;
use App\Models\BatchLecturer;
use Filament\Widgets\BarChartWidget;
use Filament\Widgets\Concerns\InteractsWithPageFilters;

class CoursePopularity extends BarChartWidget
{
    use InteractsWithPageFilters;
    protected static ?string $heading = 'Course Popularity';

    protected function getData(): array
    {
        $courses = Course::all();
        $labels = [];
        $data = [];

        foreach ($courses as $course) {
            $moduleIds = Module::where('course_id', $course->id)->pluck('id');

            // Use BatchLecturer model to get batch_ids linked to those modules
            $batchIds = BatchLecturer::whereIn('module_id', $moduleIds)
                ->pluck('batch_id')
                ->unique();
                

            // Count students in these batches
            $studentCount = Student::whereIn('batch_id', $batchIds)->count();

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
}
