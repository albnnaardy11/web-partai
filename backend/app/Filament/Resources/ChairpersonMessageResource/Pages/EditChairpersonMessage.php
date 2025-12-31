<?php

namespace App\Filament\Resources\ChairpersonMessageResource\Pages;

use App\Filament\Resources\ChairpersonMessageResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditChairpersonMessage extends EditRecord
{
    protected static string $resource = ChairpersonMessageResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
