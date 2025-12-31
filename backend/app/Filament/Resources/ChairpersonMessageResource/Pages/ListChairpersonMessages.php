<?php

namespace App\Filament\Resources\ChairpersonMessageResource\Pages;

use App\Filament\Resources\ChairpersonMessageResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListChairpersonMessages extends ListRecords
{
    protected static string $resource = ChairpersonMessageResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
