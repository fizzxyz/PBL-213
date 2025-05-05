<?php

namespace App\Filament\Resources;

use Filament\Forms;
use Filament\Tables;
use Filament\Forms\Form;
use Filament\Tables\Table;
use App\Models\UnitPendidikan;
use Filament\Resources\Resource;
use Filament\Tables\Columns\TextColumn;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\RichEditor;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use App\Filament\Resources\UnitPendidikanResource\Pages;
use App\Filament\Resources\UnitPendidikanResource\RelationManagers;

class UnitPendidikanResource extends Resource
{
    protected static ?string $model = UnitPendidikan::class;

    protected static ?string $navigationIcon = 'heroicon-o-academic-cap';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                TextInput::make('nama')
                    ->required()
                    ->label('Nama Unit Pendidikan')
                    ->maxLength(255)
                    ->placeholder('Masukkan nama unit pendidikan'),
                TextInput::make('alamat')
                    ->required()
                    ->label('Alamat Unit Pendidikan')
                    ->maxLength(255)
                    ->placeholder('Masukkan alamat unit pendidikan'),
                RichEditor::make('about')
                    ->required()
                    ->label('Tentang Unit Pendidikan')
                    ->columnSpanFull(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('nama')
                    ->label('Nama Unit Pendidikan')
                    ->searchable()
                    ->sortable()
                    ->limit(50),
                TextColumn::make('alamat')
                    ->label('Alamat Unit Pendidikan')
                    ->limit(50),
                TextColumn::make('about')
                    ->label('Tentang Unit Pendidikan')
                    ->limit(50),
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
            'index' => Pages\ListUnitPendidikans::route('/'),
            'create' => Pages\CreateUnitPendidikan::route('/create'),
            'edit' => Pages\EditUnitPendidikan::route('/{record}/edit'),
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
