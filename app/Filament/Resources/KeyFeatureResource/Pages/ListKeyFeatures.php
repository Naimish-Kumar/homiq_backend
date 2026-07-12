<?php

namespace App\Filament\Resources\KeyFeatureResource\Pages;

use App\Filament\Resources\KeyFeatureResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListKeyFeatures extends ListRecords
{
    protected static string $resource = KeyFeatureResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
