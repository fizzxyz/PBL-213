<?php

namespace App\Filament\Resources;

use App\Filament\Resources\PenerimaanResource\Pages;
use App\Filament\Resources\PenerimaanResource\RelationManagers;
use App\Models\Penerimaan;
use Filament\Forms;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class PenerimaanResource extends Resource
{
    protected static ?string $model = Penerimaan::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    protected static ?string $navigationGroup = 'PPDB Section';

    protected static ?string $pluralModelLabel = 'Penerimaan';
    protected static ?string $modelLabel = 'Penerimaan';
    protected static ?string $navigationLabel = 'Penerimaan';
    protected static ?string $slug = 'penerimaan';

    public static function canViewAny(): bool
    {
        return auth()->user()->can('view_penerimaan');
    }
    public static function canCreate(): bool
    {
        return auth()->user()->can('create_penerimaan');
    }
    public static function canEdit($record): bool
    {
        return auth()->user()->can('edit_penerimaan');
    }
    public static function canDelete($record): bool
    {
        return auth()->user()->can('delete_penerimaan');
    }
    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                TextInput::make('nama')
                    ->required()
                    ->label('Nama Penerimaan'),
                Select::make('unit_pendidikan_id')
                    ->relationship('unitPendidikan', 'nama')
                    ->required()
                    ->label('Unit Pendidikan')
                    ->placeholder('Pilih unit pendidikan'),
                DatePicker::make('dibuka_pada')
                    ->required()
                    ->label('Dibuka Pada')
                    ->placeholder('Tanggal dibuka'),
                DatePicker::make('ditutup_pada')
                    ->required()
                    ->label('Ditutup Pada')
                    ->placeholder('Tanggal ditutup')
                    ->rules(function ($get) {
                        return [
                            function ($attribute, $value, $fail) use ($get) {
                                $dibukaPada = $get('dibuka_pada');
                                if ($value && $dibukaPada && $value < $dibukaPada) {
                                    $fail('Tanggal penutupan tidak bisa lebih kecil dari tanggal pembukaan');
                                }
                            },
                        ];
                    }),
                TextInput::make('deskripsi')
                    ->required()
                    ->label('Deskripsi')
                    ->placeholder('Deskripsi penerimaan'),
                TextInput::make('biaya')
                    ->required()
                    ->label('Biaya')
                    ->placeholder('Biaya pendaftaran')
                    ->numeric()
                    ->minValue(0)
                    ->maxValue(10000000)
                    ->prefix('Rp')
                    ->step(1000),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('nama')
                    ->label('Nama Penerimaan')
                    ->searchable()
                    ->sortable(),
                TextColumn::make('unitPendidikan.nama')
                    ->label('Unit Pendidikan')
                    ->searchable()
                    ->sortable(),
                TextColumn::make('dibuka_pada')
                    ->label('Dibuka Pada')
                    ->date()
                    ->sortable(),
                TextColumn::make('ditutup_pada')
                    ->label('Ditutup Pada')
                    ->date()
                    ->sortable(),
                TextColumn::make('deskripsi')
                    ->label('Deskripsi')
                    ->limit(50)
                    ->sortable(),
                TextColumn::make('biaya')
                    ->label('Biaya')
                    ->money('IDR')
                    ->sortable()
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
            'index' => Pages\ListPenerimaans::route('/'),
            'create' => Pages\CreatePenerimaan::route('/create'),
            'edit' => Pages\EditPenerimaan::route('/{record}/edit'),
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
