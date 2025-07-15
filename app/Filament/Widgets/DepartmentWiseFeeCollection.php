<?php

namespace App\Filament\Widgets;

use App\Models\Department;
use App\Models\Staff;
use App\Models\Transaction;
use App\Models\Student;
use Carbon\Carbon;
use Filament\Widgets\BarChartWidget;
use Filament\Widgets\Concerns\InteractsWithPageFilters;

class DepartmentWiseFeeCollection extends BarChartWidget
{
    use InteractsWithPageFilters;
    protected static ?string $heading = 'Department-wise Fee Collection';

    protected function getData(): array
    {
        $start = $this->filters['from'] ?? Carbon::now()->startOfYear();
        $end = $this->filters['to'] ?? Carbon::now()->endOfYear();

        $departments = Department::all();
        $labels = [];
        $data = [];

        foreach ($departments as $department) {
            $studentsInDept = Student::whereIn('batch_id', function ($query) use ($department) {
                $query->select('batch_id')
                    ->from('batch_lecturers')
                    ->whereIn('lecturer_id', function ($q) use ($department) {
                        $q->select('id')->from('lecturers')->where('department_id', $department->id);
                    });
            })->pluck('id');

            $amount = Transaction::whereIn('student_id', $studentsInDept)
                ->whereBetween('created_at', [$start, $end])
                ->sum('amount');

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
