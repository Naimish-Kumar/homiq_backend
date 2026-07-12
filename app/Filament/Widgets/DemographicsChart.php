<?php

namespace App\Filament\Widgets;

use Filament\Widgets\ChartWidget;
use App\Models\User;
use Filament\Widgets\Concerns\InteractsWithPageFilters;
use Illuminate\Support\Facades\DB;

class DemographicsChart extends ChartWidget
{
    use InteractsWithPageFilters;

    protected static ?string $heading = 'User Demographics';
    protected static ?int $sort = 4;
    protected int | string | array $columnSpan = 1;

    protected function getData(): array
    {
        $startDate = $this->filters['startDate'] ?? null;
        $endDate = $this->filters['endDate'] ?? null;
        
        $start = $startDate ? \Carbon\Carbon::parse($startDate)->startOfDay() : now()->subYears(10)->startOfDay();
        $end = $endDate ? \Carbon\Carbon::parse($endDate)->endOfDay() : now()->endOfDay();

        $users = User::whereBetween('created_at', [$start, $end])
            ->select('country', DB::raw('count(*) as total'))
            ->groupBy('country')
            ->pluck('total', 'country')
            ->toArray();

        $colors = ['#1A447C', '#10b981', '#f59e0b', '#ef4444', '#8b5cf6', '#ec4899'];
        $bgColors = [];
        for ($i=0; $i < count($users); $i++) {
            $bgColors[] = $colors[$i % count($colors)];
        }

        return [
            'datasets' => [
                [
                    'label' => 'Users',
                    'data' => array_values($users),
                    'backgroundColor' => $bgColors,
                ],
            ],
            'labels' => array_map(function($country) { return $country ?: 'Unknown'; }, array_keys($users)),
        ];
    }

    protected function getType(): string
    {
        return 'doughnut';
    }
}
