<?php

namespace App\Filament\Resources\FrontPageResource\Pages;

use App\Filament\Resources\FrontPageResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListFrontPages extends ListRecords
{
    protected static string $resource = FrontPageResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
