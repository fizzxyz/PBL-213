<?php

namespace App\Filament\Resources;

use Filament\Forms;
use Filament\Tables;
use Filament\Forms\Form;
use Filament\Tables\Table;
use App\Models\MediaSosial;
use Filament\Resources\Resource;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\FileUpload;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use App\Filament\Resources\MediaSosialResource\Pages;
use App\Filament\Resources\MediaSosialResource\RelationManagers;
use Filament\Tables\Columns\ImageColumn;
use Filament\Tables\Columns\TextColumn;

class MediaSosialResource extends Resource
{
    protected static ?string $model = MediaSosial::class;

    protected static ?string $navigationIcon = 'heroicon-o-globe-alt';

    protected static ?string $navigationGroup = 'Content Management System';

    protected static ?string $pluralModelLabel = 'Media Sosial';
    protected static ?string $modelLabel = 'Media Sosial';
    protected static ?string $navigationLabel = 'Media Sosial';
    protected static ?string $slug = 'media-sosial';

    public static function canViewAny(): bool
    {
        return auth()->user()->can('view_media_sosial');
    }
    public static function canCreate(): bool
    {
        return auth()->user()->can('create_media_sosial');
    }
    public static function canEdit($record): bool
    {
        return auth()->user()->can('edit_media_sosial');
    }
    public static function canDelete($record): bool
    {
        return auth()->user()->can('delete_media_sosial');
    }
    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                TextInput::make('name')
                    ->required()
                    ->label('Nama Media Sosial')
                    ->maxLength(255),
                TextInput::make('url')
                    ->required()
                    ->label('URL')
                    ->url(),
                TextInput::make('username')
                    ->label('Username')
                    ->maxLength(255),
                FileUpload::make('image')
                    ->label('Logo')
                    ->image()
                    ->directory('media-sosial')
                    ->required(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                ImageColumn::make('image')
                    ->label('Logo')
                    ->size('20'),
                TextColumn::make('name')
                    ->label('Media Sosial')
                    ->searchable()
                    ->sortable(),
                TextColumn::make('url')
                    ->label('URL')
                    ->searchable()
                    ->sortable(),
                TextColumn::make('username')
                    ->label('Username')
                    ->searchable()
                    ->sortable(),
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
            'index' => Pages\ListMediaSosials::route('/'),
            'create' => Pages\CreateMediaSosial::route('/create'),
            'edit' => Pages\EditMediaSosial::route('/{record}/edit'),
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
