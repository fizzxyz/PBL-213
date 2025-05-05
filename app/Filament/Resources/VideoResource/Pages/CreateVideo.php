<?php

namespace App\Filament\Resources\VideoResource\Pages;

use App\Filament\Resources\VideoResource;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;

class CreateVideo extends CreateRecord
{
    protected static string $resource = VideoResource::class;

    protected function mutateFormDataBeforeCreate(array $data): array
    {
        // Simpan salah satu: file atau URL
        $data['path_video'] = $data['path_video_file'] ?? $data['path_video_url'];

        // Optional: hapus kolom tambahan agar tidak error jika tidak ada di DB
        unset($data['path_video_file'], $data['path_video_url']);

        return $data;
    }
}


