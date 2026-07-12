<?php

namespace App\Filament\Widgets;

use Filament\Widgets\ChartWidget;
use App\Models\Booking;

use Filament\Widgets\Concerns\InteractsWithPageFilters;

class RevenueChart extends ChartWidget
{
    use InteractsWithPageFilters;

    protected static ?string $heading = 'Revenue';
    protected static ?int $sort = 3;
    protected int | string | array $columnSpan = 1;

    protected function getData(): array
    {
        $startDate = $this->filters['startDate'] ?? null;
        $endDate = $this->filters['endDate'] ?? null;
        
        $start = $startDate ? \Carbon\Carbon::parse($startDate)->startOfDay() : now()->subDays(6)->startOfDay();
        $end = $endDate ? \Carbon\Carbon::parse($endDate)->endOfDay() : now()->endOfDay();

        $data = [];
        $labels = [];

        $bookings = Booking::whereBetween('created_at', [$start, $end])->get();
        $grouped = $bookings->groupBy(function($item) {
            return $item->created_at->format('Y-m-d');
        });

        for ($date = $start->copy(); $date->lte($end); $date->addDay()) {
            $dateString = $date->format('Y-m-d');
            $labels[] = $date->format('M d');
            $data[] = $grouped->has($dateString) ? $grouped->get($dateString)->sum('platform_fee') : 0;
        }

        return [
            'datasets' => [
                [
                    'label' => 'Platform Revenue (INR)',
                    'data' => $data,
                    'backgroundColor' => '#1A447C',
                    'borderColor' => '#1A447C',
                ],
            ],
            'labels' => $labels,
        ];
    }

    protected function getType(): string
    {
        return 'line';
    }
}
