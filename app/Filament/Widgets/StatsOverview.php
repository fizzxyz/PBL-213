<?php

namespace App\Filament\Widgets;

use App\Models\User;
use App\Models\Artikel;
use App\Models\Komentar;
use Flowframe\Trend\Trend;
use App\Models\Pendaftaran;
use Filament\Widgets\StatsOverviewWidget\Stat;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;

class StatsOverview extends BaseWidget
{
    protected function getStats(): array
    {
        return [
        Stat::make('Total Users', User::count())
        ->description('Jumlah pengguna terdaftar')
        ->icon('heroicon-o-user-group')
        ->chart(
            Trend::model(User::class)
                ->between(now()->subDays(365), now()) // Data 1 tahun terakhir
                ->perMonth()
                ->count()
                ->map(fn ($data) => $data->aggregate)
                ->toArray()
        ),

        Stat::make('Total Pendaftaran', Pendaftaran::count())
        ->description('Jumlah pendaftaran')
        ->icon('heroicon-o-academic-cap')
        ->chart(
            Trend::model(Pendaftaran::class)
                ->between(now()->subDays(365), now()) // Data 1 tahun terakhir
                ->perMonth()
                ->count()
                ->map(fn ($data) => $data->aggregate)
                ->toArray()
        ),

        Stat::make('Total Pendaftar Diterima', Pendaftaran::where('status_pendaftaran', 'diterima')->count())
        ->description('Total pendaftar diterima')
        ->color('success')
        ->icon('heroicon-o-check-circle'),

        Stat::make('Total Pendaftar Ditolak', Pendaftaran::where('status_pendaftaran', 'ditolak')->count())
        ->description('Total pendaftar ditolak')
        ->color('danger')
        ->icon('heroicon-o-x-circle'),

        Stat::make('Total Artikel', Artikel::count())
        ->description('Artikel yang telah dipublikasikan')
        ->icon('heroicon-o-document-text'),

        Stat::make('Total Komentar', Komentar::count())
            ->description('Komentar yang masuk')
            ->icon('heroicon-o-chat-bubble-bottom-center-text'),
        ];
    }
}
