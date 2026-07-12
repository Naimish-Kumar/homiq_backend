<?php

namespace App\Filament\Widgets;

use Filament\Widgets\ChartWidget;
use App\Models\Property;

use Filament\Widgets\Concerns\InteractsWithPageFilters;

class ListingVolumeChart extends ChartWidget
{
    use InteractsWithPageFilters;

    protected static ?string $heading = 'Listing Volume';
    
    protected static ?int $sort = 2;
    protected int | string | array $columnSpan = 1;

    protected function getData(): array
    {
        $startDate = $this->filters['startDate'] ?? null;
        $endDate = $this->filters['endDate'] ?? null;
        
        $start = $startDate ? \Carbon\Carbon::parse($startDate)->startOfDay() : now()->subDays(6)->startOfDay();
        $end = $endDate ? \Carbon\Carbon::parse($endDate)->endOfDay() : now()->endOfDay();

        $data = [];
        $labels = [];
        
        $properties = Property::whereBetween('created_at', [$start, $end])->get();
        $grouped = $properties->groupBy(function($item) {
            return $item->created_at->format('Y-m-d');
        });

        for ($date = $start->copy(); $date->lte($end); $date->addDay()) {
            $dateString = $date->format('Y-m-d');
            $labels[] = $date->format('M d');
            $data[] = $grouped->has($dateString) ? $grouped->get($dateString)->count() : 0;
        }

        return [
            'datasets' => [
                [
                    'label' => 'New Listings',
                    'data' => $data,
                    'backgroundColor' => '#10b981',
                    'borderRadius' => 4,
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
