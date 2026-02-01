<?php

namespace App\Filament\Resources\RegionStatResource\Pages;

use App\Filament\Resources\RegionStatResource;

use Filament\Resources\Pages\ListRecords;

class ListRegionStats extends ListRecords
{
    protected static string $resource = RegionStatResource::class;

    protected function getHeaderActions(): array
    {
        return [
            \Filament\Actions\CreateAction::make(),
        ];
    }
}
