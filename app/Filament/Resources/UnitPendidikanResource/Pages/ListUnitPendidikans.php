<?php

namespace App\Filament\Resources\UnitPendidikanResource\Pages;

use App\Filament\Resources\UnitPendidikanResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListUnitPendidikans extends ListRecords
{
    protected static string $resource = UnitPendidikanResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
