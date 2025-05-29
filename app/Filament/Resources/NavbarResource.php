<?php

namespace App\Filament\Resources;

use Filament\Forms;
use Filament\Tables;
use App\Models\Navbar;
use Filament\Forms\Form;
use Filament\Tables\Table;
use Filament\Resources\Resource;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Illuminate\Database\Eloquent\Builder;
use App\Filament\Resources\NavbarResource\Pages;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use App\Filament\Resources\NavbarResource\RelationManagers;
use Filament\Tables\Columns\TextColumn;

class NavbarResource extends Resource
{
    protected static ?string $model = Navbar::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Select::make('unit_pendidikan_id')
                    ->relationship('unitPendidikan', 'nama')
                    ->required()
                    ->searchable()
                    ->preload()
                    ->placeholder('Pilih Unit Pendidikan'),
                TextInput::make('cta_text')
                    ->label('CTA Text')
                    ->required()
                    ->placeholder('Masukkan Text'),
                TextInput::make('cta_link')
                    ->label('Slug Artikel')
                    ->required()
                    ->prefix('artikel/')
                    ->placeholder('Contoh: ratusan-peserta-mengikuti-...')
                    ->helperText('Link akan otomatis menjadi /artikel/{slug}'),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('unitPendidikan.nama')
                    ->label('Unit Pendidikan')
                    ->sortable()
                    ->searchable(),
                TextColumn::make('cta_text')
                    ->label('CTA Text')
                    ->sortable()
                    ->searchable(),
                TextColumn::make('cta_link')
                    ->label('Slug Artikel')
                    ->sortable()
                    ->searchable(),
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
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
            'index' => Pages\ListNavbars::route('/'),
            'create' => Pages\CreateNavbar::route('/create'),
            'edit' => Pages\EditNavbar::route('/{record}/edit'),
        ];
    }
}
