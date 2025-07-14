<?php

namespace App\Filament\Widgets;

use App\Models\Transaction;
use Filament\Forms\Components\DatePicker;
use Filament\Widgets\Concerns\InteractsWithPageFilters;
use Filament\Widgets\PieChartWidget;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;

class FeePaymentTrends extends PieChartWidget
{
    use InteractsWithPageFilters;

    protected static ?string $heading = 'Fee Payment Trends';

    protected function getData(): array
    {
        $start = isset($this->filters['dateFrom'])
            ? Carbon::parse($this->filters['dateFrom'])->startOfDay()
            : now()->startOfMonth();

        $end = isset($this->filters['dateTo'])
            ? Carbon::parse($this->filters['dateTo'])->endOfDay()
            : now()->endOfDay();

        // Group payments by method
        $paymentGroups = Transaction::select('payment_method', DB::raw('count(*) as total'))
            ->whereBetween('created_at', [$start, $end])
            ->groupBy('payment_method')
            ->get();

        $labels = $paymentGroups->pluck('payment_method')->map(fn($m) => ucfirst($m))->toArray();
        $data = $paymentGroups->pluck('total')->toArray();

        $colors = [
            'rgba(54, 162, 235, 0.7)',
            'rgba(255, 206, 86, 0.7)',
            'rgba(75, 192, 192, 0.7)',
            'rgba(153, 102, 255, 0.7)',
            'rgba(255, 159, 64, 0.7)',
        ];

        $backgroundColors = [];
        foreach ($labels as $i => $_) {
            $backgroundColors[] = $colors[$i % count($colors)];
        }

        return [
            'datasets' => [
                [
                    'label' => 'Payments by Method',
                    'data' => $data,
                    'backgroundColor' => $backgroundColors,
                ],
            ],
            'labels' => $labels,
        ];
    }
}
