<?php

namespace App\Filament\Resources\BalasanResource\Pages;

use App\Filament\Resources\BalasanResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditBalasan extends EditRecord
{
    protected static string $resource = BalasanResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
            Actions\ForceDeleteAction::make(),
            Actions\RestoreAction::make(),
        ];
    }
}
