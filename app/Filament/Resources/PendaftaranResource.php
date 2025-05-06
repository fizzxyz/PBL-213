<?php

namespace App\Filament\Resources;

use Filament\Forms;
use Filament\Tables;
use Filament\Forms\Form;
use Filament\Tables\Table;
use App\Models\Pendaftaran;
use Illuminate\Support\Str;
use Filament\Resources\Resource;
use Filament\Forms\Components\Select;
use Filament\Tables\Columns\TextColumn;
use Illuminate\Support\Facades\Storage;
use Filament\Forms\Components\TextInput;
use Filament\Tables\Columns\ImageColumn;
use Filament\Forms\Components\FileUpload;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use App\Filament\Resources\PendaftaranResource\Pages;
use App\Filament\Resources\PendaftaranResource\RelationManagers;

class PendaftaranResource extends Resource
{
    protected static ?string $model = Pendaftaran::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    protected static ?string $navigationGroup = 'PPDB Section';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Select::make('user_id')
                    ->relationship('user', 'name')
                    ->required()
                    ->label('Nama Pendaftar'),
                Select::make('penerimaan_id')
                    ->relationship('penerimaan', 'nama')
                    ->required()
                    ->label('Penerimaan'),
                TextInput::make('nomor_pendaftaran')
                    ->label('Nomor Pendaftaran')
                    ->default(function () {
                        return 'PD-' . now()->format('Ymd') . '-' . Str::random(6);
                    })
                    ->disabled()
                    ->maxLength(255),
                TextInput::make('nama_lengkap')
                    ->label('Nama Lengkap')
                    ->required()
                    ->maxLength(255),
                TextInput::make('usia')
                    ->label('Usia')
                    ->required()
                    ->maxLength(255),
                TextInput::make('alamat')
                    ->label('Alamat')
                    ->required()
                    ->maxLength(255),
                FileUpload::make('path_foto')
                    ->label('Foto')
                    ->image()
                    ->directory('pendaftaran/foto')
                    ->required(),
                FileUpload::make('path_ijazah')
                    ->label('Ijazah')
                    ->acceptedFileTypes(['application/pdf'])
                    ->directory('pendaftaran/ijazah')
                    ->required(),
                FileUpload::make('path_skhu')
                    ->label('SKHU')
                    ->acceptedFileTypes(['application/pdf'])
                    ->directory('pendaftaran/skhu')
                    ->required(),
                Select::make('status_pendaftaran')
                    ->label('Status Pendaftaran')
                    ->options([
                        'pending' => 'Pending',
                        'diterima' => 'Diterima',
                        'ditolak' => 'Ditolak',
                    ])
                    ->required()
                    ->default('pending'),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('nomor_pendaftaran')
                    ->label('Nomor Pendaftaran')
                    ->searchable()
                    ->sortable(),
                TextColumn::make('status_pendaftaran')
                    ->label('Status Pendaftaran'),
                TextColumn::make('user.name')
                    ->label('Nama Pendaftar')
                    ->searchable()
                    ->sortable(),
                TextColumn::make('nama_lengkap')
                    ->label('Nama Lengkap')
                    ->searchable()
                    ->sortable(),
                TextColumn::make('usia')
                    ->label('Usia'),
                TextColumn::make('alamat')
                    ->label('Alamat'),
                ImageColumn::make('path_foto')
                    ->label('Foto')
                    ->size(20)
                    ->width(80)
                    ->height(80),
                TextColumn::make('path_ijazah')
                    ->label('Ijazah')
                    ->url(fn ($record) => Storage::url($record->path_ijazah))
                    ->openUrlInNewTab(),
                TextColumn::make('path_skhu')
                    ->label('SKHU')
                    ->url(fn ($record) => Storage::url($record->path_skhu))
                    ->openUrlInNewTab(),
                TextColumn::make('penerimaan.nama')
                    ->label('Penerimaan')
                    ->searchable()
                    ->sortable(),
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
            'index' => Pages\ListPendaftarans::route('/'),
            'create' => Pages\CreatePendaftaran::route('/create'),
            'edit' => Pages\EditPendaftaran::route('/{record}/edit'),
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
