<?php

namespace App\Filament\Resources\HomeContentResource\Pages;

use Filament\Actions;
use Filament\Actions\Action;
use Filament\Resources\Pages\ListRecords;
use App\Filament\Resources\HomeContentResource;

class ListHomeContents extends ListRecords
{
    protected static string $resource = HomeContentResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Action::make('Edit Row 1')
                ->label('Edit Home Content')
                ->icon('heroicon-o-pencil')
                ->url(fn () => static::getResource()::getUrl('edit', ['record' => 1]))
                ->color('primary'),
        ];
    }
}
