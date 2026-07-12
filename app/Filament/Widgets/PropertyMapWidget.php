<?php

namespace App\Filament\Widgets;

use Filament\Widgets\Widget;
use App\Models\Property;

class PropertyMapWidget extends Widget
{
    protected static string $view = 'filament.widgets.property-map-widget';
    protected int | string | array $columnSpan = 'full';
    protected static ?int $sort = 4;

    protected function getViewData(): array
    {
        return [
            'properties' => Property::whereNotNull('latitude')
                ->whereNotNull('longitude')
                ->get(['title', 'latitude', 'longitude', 'price', 'id'])
        ];
    }
}
