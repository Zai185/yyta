<?php

namespace App\Filament\Widgets;

use App\Models\Student;
use Filament\Widgets\TableWidget as BaseWidget;
use Illuminate\Database\Eloquent\Builder;
use Filament\Tables;

class StudentAverageScoreTable extends BaseWidget
{
    protected static ?string $heading = 'Top Students by Average Score';

    protected function getTableQuery(): Builder
    {
        return Student::select('students.id', 'students.name')
            ->join('exam_results', 'students.id', '=', 'exam_results.student_id')
            ->selectRaw('AVG(exam_results.score) as avg_score')
            ->groupBy('students.id', 'students.name')
            ->orderByDesc('avg_score');
    }

    protected function getTableColumns(): array
    {
        return [    
            Tables\Columns\TextColumn::make('name')->label('Student Name'),
            Tables\Columns\TextColumn::make('avg_score')
                ->label('Average Score')
                ->numeric(2)
                ->sortable(),
        ];
    }
}
