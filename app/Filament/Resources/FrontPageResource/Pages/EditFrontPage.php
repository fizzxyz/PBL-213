<?php

namespace App\Filament\Resources\FrontPageResource\Pages;

use App\Filament\Resources\FrontPageResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditFrontPage extends EditRecord
{
    protected static string $resource = FrontPageResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
            Actions\ForceDeleteAction::make(),
            Actions\RestoreAction::make(),
        ];
    }
}
