<?php

namespace App\Filament\Resources\UnitPendidikanResource\Pages;

use App\Filament\Resources\UnitPendidikanResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditUnitPendidikan extends EditRecord
{
    protected static string $resource = UnitPendidikanResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
            Actions\ForceDeleteAction::make(),
            Actions\RestoreAction::make(),
        ];
    }
}
