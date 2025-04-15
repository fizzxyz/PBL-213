<?php

namespace App\Filament\Resources\MediaSosialResource\Pages;

use App\Filament\Resources\MediaSosialResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditMediaSosial extends EditRecord
{
    protected static string $resource = MediaSosialResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
            Actions\ForceDeleteAction::make(),
            Actions\RestoreAction::make(),
        ];
    }
}
