<?php

namespace App\Filament\Resources;

use Filament\Forms;
use Filament\Tables;
use App\Models\Yayasan;
use Filament\Forms\Form;
use Filament\Tables\Table;
use Filament\Resources\Resource;
use Filament\Tables\Columns\TextColumn;
use Filament\Forms\Components\TextInput;
use Filament\Tables\Columns\ImageColumn;
use Filament\Forms\Components\FileUpload;
use Illuminate\Database\Eloquent\Builder;
use App\Filament\Resources\YayasanResource\Pages;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use App\Filament\Resources\YayasanResource\RelationManagers;

class YayasanResource extends Resource
{
    protected static ?string $model = Yayasan::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                TextInput::make('name')
                    ->required()
                    ->label('Company Name')
                    ->placeholder('Enter company name'),
                TextInput::make('address')
                    ->required()
                    ->label('Address')
                    ->placeholder('Enter address'),
                TextInput::make('phone')
                    ->required()
                    ->label('Phone')
                    ->placeholder('Enter phone number'),
                TextInput::make('email')
                    ->required()
                    ->label('Email')
                    ->placeholder('Enter email address'),
                FileUpload::make('logo')
                    ->label('Logo')
                    ->image()
                    ->required()
                    ->placeholder('Upload logo'),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('name')
                    ->label('Company Name'),
                TextColumn::make('address')
                    ->label('Address'),
                TextColumn::make('phone')
                    ->label('Phone'),
                TextColumn::make('email')
                    ->label('Email'),
                ImageColumn::make('logo')
                    ->label('Logo'),
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
            'index' => Pages\ListYayasans::route('/'),
            'create' => Pages\CreateYayasan::route('/create'),
            'edit' => Pages\EditYayasan::route('/{record}/edit'),
        ];
    }
}
