<?php

namespace App\Filament\Widgets;

use App\Models\Transaction;
use Filament\Widgets\LineChartWidget;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class TotalIncomeTrend extends LineChartWidget
{
    protected static ?string $heading = 'Monthly Income Trends';

    protected function getData(): array
    {
        $startOfYear = Carbon::now()->startOfYear();
        $endOfYear = Carbon::now()->endOfYear();

        // Group income by month (January–December)
        $incomeByMonth = Transaction::selectRaw('MONTH(created_at) as month, SUM(amount) as total')
            ->whereBetween('created_at', [$startOfYear, $endOfYear])
            ->groupBy(DB::raw('MONTH(created_at)'))
            ->orderBy('month')
            ->pluck('total', 'month');

        // Prepare all 12 months
        $months = collect(range(1, 12))->mapWithKeys(function ($month) use ($incomeByMonth) {
            return [Carbon::create()->month($month)->format('F') => $incomeByMonth->get($month, 0)];
        });

        return [
            'datasets' => [
                [
                    'label' => 'Total Income (Baht)',
                    'data' => $months->values()->toArray(),
                    'backgroundColor' => 'rgba(75, 192, 192, 0.5)',
                    'borderColor' => 'rgba(75, 192, 192, 1)',
                    'fill' => true,
                ],
            ],
            'labels' => $months->keys()->toArray(),
        ];
    }
}
