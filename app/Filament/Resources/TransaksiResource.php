<?php

namespace App\Filament\Resources;

use Filament\Forms;
use Filament\Tables;
use Filament\Forms\Form;
use App\Models\Transaksi;
use Filament\Tables\Table;
use Filament\Resources\Resource;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\TextColumn;
use Illuminate\Database\Eloquent\Builder;
use App\Filament\Resources\TransaksiResource\Pages;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use App\Filament\Resources\TransaksiResource\RelationManagers;

class TransaksiResource extends Resource
{
    protected static ?string $model = Transaksi::class;

    protected static ?string $navigationIcon = 'heroicon-o-banknotes';

    protected static ?string $navigationGroup = 'PPDB Section';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                //
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('kode_transaksi')
                    ->label('Kode Transaksi')
                    ->sortable()
                    ->searchable(),
                TextColumn::make('user.name')
                    ->label('Nama User')
                    ->sortable()
                    ->searchable(),
                TextColumn::make('pendaftaran.nama')
                    ->label('Nama Pendaftaran')
                    ->sortable()
                    ->searchable(),
                TextColumn::make('total')
                    ->label('Total')
                    ->sortable()
                    ->searchable()
                    ->money('IDR'),
                TextColumn::make('metode_pembayaran')
                    ->label('Metode Pembayaran')
                    ->sortable()
                    ->searchable(),
                IconColumn::make('is_paid')
                    ->label('Status Pembayaran')
                    ->sortable()
                    ->boolean()
                    ->trueIcon('heroicon-o-check-circle')
                    ->falseIcon('heroicon-o-x-circle'),
                TextColumn::make('bukti_pembayaran')
                    ->label('Bukti Pembayaran')
                    ->sortable()
                    ->url(fn (Transaksi $record): ?string => $record->bukti_pembayaran),
                TextColumn::make('created_at')
                    ->label('Tanggal Dibuat')
                    ->sortable()
                    ->dateTime('d/m/Y H:i'),
            ])
            ->filters([
                Tables\Filters\TrashedFilter::make(),
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                    Tables\Actions\ForceDeleteBulkAction::make(),
                    Tables\Actions\RestoreBulkAction::make(),
                ]),
            ]);
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListTransaksis::route('/'),
            'create' => Pages\CreateTransaksi::route('/create'),
            'edit' => Pages\EditTransaksi::route('/{record}/edit'),
        ];
    }

    public static function getEloquentQuery(): Builder
    {
        return parent::getEloquentQuery()
            ->withoutGlobalScopes([
                SoftDeletingScope::class,
            ]);
    }
}
