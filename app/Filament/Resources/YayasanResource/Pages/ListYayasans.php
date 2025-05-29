<?php

namespace App\Filament\Resources\YayasanResource\Pages;

use Filament\Actions;
use Filament\Actions\Action;
use Filament\Resources\Pages\ListRecords;
use App\Filament\Resources\YayasanResource;

class ListYayasans extends ListRecords
{
    protected static string $resource = YayasanResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Action::make('Edit Yayasan')
                ->label('Edit Yayasan')
                ->icon('heroicon-o-pencil')
                ->url(fn () => static::getResource()::getUrl('edit', ['record' => 1]))
                ->color('primary'),
        ];
    }
}
