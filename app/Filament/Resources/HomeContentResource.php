<?php

namespace App\Filament\Resources;

use Filament\Forms;
use Filament\Tables;
use Filament\Forms\Form;
use Filament\Tables\Table;
use App\Models\HomeContent;
use Filament\Resources\Resource;
use Filament\Forms\Components\Section;
use Filament\Tables\Columns\TextColumn;
use Filament\Forms\Components\TextInput;
use Filament\Tables\Columns\ImageColumn;
use Filament\Forms\Components\FileUpload;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use App\Filament\Resources\HomeContentResource\Pages;
use App\Filament\Resources\HomeContentResource\RelationManagers;
use Filament\Forms\Components\RichEditor;

class HomeContentResource extends Resource
{
    protected static ?string $model = HomeContent::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    protected static ?string $navigationGroup = 'Content Management System';

    public static function canViewAny(): bool
    {
        return auth()->user()->can('view_home_content');
    }
    public static function canEdit($record): bool
    {
        return auth()->user()->can('edit_home_content');
    }
    public static function canDelete($record): bool
    {
        return auth()->user()->can('delete_home_content');
    }

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Section::make('Hero')
                    ->schema([
                        TextInput::make('hero_title')
                            ->label('Hero Title')
                            ->required(),
                        TextInput::make('hero_text')
                            ->label('Hero Text')
                            ->required(),
                        TextInput::make('hero_sm_title')
                            ->label('Hero Small Title')
                            ->required(),
                        FileUpload::make('hero_image')
                            ->label('Hero Image')
                            ->image()
                            ->directory('home/hero')
                            ->required(),
                    ]),
                Section::make('Card')
                    ->schema([
                        TextInput::make('card_title')
                            ->label('Card Title')
                            ->required(),
                        TextInput::make('card_text')
                            ->label('Card Text')
                            ->required(),
                    ]),
                Section::make('Galeri')
                    ->schema([
                        TextInput::make('galeri_title')
                            ->label('Galeri Title')
                            ->required(),
                        TextInput::make('galeri_sm_title')
                            ->label('Galeri Small Title')
                            ->required(),
                    ]),
                Section::make('Video')
                    ->schema([
                        TextInput::make('video_title')
                            ->label('Video Title')
                            ->required(),
                        TextInput::make('video_sm_title')
                            ->label('Video Small Title')
                            ->required(),
                    ]),
                Section::make('Pengantar')
                    ->schema([
                        TextInput::make('pengantar_title')
                            ->label('Pengantar Title')
                            ->required(),
                        TextInput::make('pengantar_sm_title')
                            ->label('Pengantar Small Title')
                            ->required(),
                        RichEditor::make('pengantar_text')
                            ->label('Pengantar Text')
                            ->required(),
                        FileUpload::make('pengantar_image')
                            ->label('Pengantar Image')
                            ->image()
                            ->directory('home/pengantar')
                            ->required(),
                        TextInput::make('pengantar_sm_text1')
                            ->label('Pengantar Small Text 1')
                            ->required(),
                        TextInput::make('pengantar_sm_text2')
                            ->label('Pengantar Small Text 2')
                            ->required(),
                    ]),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                // Hero Section Columns
                TextColumn::make('hero_title')
                    ->label('Hero Title')
                    ->sortable()
                    ->searchable(),

                TextColumn::make('hero_text')
                    ->label('Hero Text')
                    ->limit(50)
                    ->searchable(),

                ImageColumn::make('hero_image')
                    ->label('Hero Image'),

                // Card Section Columns
                TextColumn::make('card_title')
                    ->label('Card Title')
                    ->sortable()
                    ->searchable(),

                TextColumn::make('card_text')
                    ->label('Card Text')
                    ->limit(50)
                    ->searchable(),

                // Galeri Section Columns
                TextColumn::make('galeri_title')
                    ->label('Galeri Title')
                    ->sortable()
                    ->searchable(),

                TextColumn::make('galeri_sm_title')
                    ->label('Galeri Small Title')
                    ->limit(50)
                    ->searchable(),

                // Video Section Columns
                TextColumn::make('video_title')
                    ->label('Video Title')
                    ->sortable()
                    ->searchable(),

                TextColumn::make('video_sm_title')
                    ->label('Video Small Title')
                    ->limit(50)
                    ->searchable(),

                // Pengantar Section Columns
                TextColumn::make('pengantar_title')
                    ->label('Pengantar Title')
                    ->sortable()
                    ->searchable(),

                TextColumn::make('pengantar_sm_title')
                    ->label('Pengantar Small Title')
                    ->limit(50)
                    ->searchable(),

                TextColumn::make('pengantar_text')
                    ->label('Pengantar Text')
                    ->limit(50)
                    ->searchable(),

                ImageColumn::make('pengantar_image')
                    ->label('Pengantar Image'),
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

    public static function canCreate(): bool
    {
        return false;
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
            'index' => Pages\ListHomeContents::route('/'),
            'create' => Pages\CreateHomeContent::route('/create'),
            'edit' => Pages\EditHomeContent::route('/{record}/edit'),
        ];
    }
}
