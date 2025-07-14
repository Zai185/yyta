<?php

namespace App\Filament\Widgets;

use App\Models\Department;
use App\Models\Staff;
use App\Models\Transaction;
use App\Models\Student;
use Filament\Widgets\BarChartWidget;

class DepartmentWiseFeeCollection extends BarChartWidget
{
    protected static ?string $heading = 'Department-wise Fee Collection';

    protected function getData(): array
    {
        $departments = Department::all();

        $labels = [];
        $data = [];

        foreach ($departments as $department) {
            // Get staff or lecturers by department (you can adjust logic as needed)
            // Here we get students via batches linked to this department through lecturers or staff if applicable.

            $studentsInDept = Student::whereIn('batch_id', function ($query) use ($department) {
                $query->select('batch_id')
                    ->from('batch_lecturers')
                    ->whereIn('lecturer_id', function ($q) use ($department) {
                        $q->select('id')->from('lecturers')->where('department_id', $department->id);
                    });
            })->pluck('id');

            $amount = Transaction::whereIn('student_id', $studentsInDept)->sum('amount');

            $labels[] = $department->name;
            $data[] = $amount;
        }

        return [
            'datasets' => [
                [
                    'label' => 'Fee Collected',
                    'data' => $data,
                    'backgroundColor' => 'rgba(255, 159, 64, 0.7)',
                ],
            ],
            'labels' => $labels,
        ];
    }
}
