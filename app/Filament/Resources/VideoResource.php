<?php

namespace App\Filament\Resources;

use Filament\Forms;
use Filament\Tables;
use App\Models\Video;
use Filament\Forms\Form;
use Filament\Tables\Table;
use Filament\Resources\Resource;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\FileUpload;
use Illuminate\Database\Eloquent\Builder;
use App\Filament\Resources\VideoResource\Pages;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use App\Filament\Resources\VideoResource\RelationManagers;
use Filament\Tables\Columns\ImageColumn;
use Filament\Tables\Columns\TextColumn;

class VideoResource extends Resource
{
    protected static ?string $model = Video::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                TextInput::make('title')
                    ->label('Title')
                    ->required(),
                FileUpload::make('path_video_file')
                    ->label('Upload Video')
                    ->acceptedFileTypes(['video/mp4', 'video/avi', 'video/mov'])
                    ->directory('video')
                    ->maxSize(102400)
                    ->helperText('Atau isi URL di bawah jika tidak ingin upload video.'),
                TextInput::make('path_video_url')
                    ->label('Video URL')
                    ->url()
                    ->helperText('Kosongkan jika upload video.'),
                TextInput::make('text')
                    ->label('Description')
                    ->required()
                    ->maxLength(255),
                Select::make('unit_pendidikan_id')
                    ->relationship('unitPendidikan', 'nama')
                    ->label('Unit Pendidikan')
                    ->required(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('id')
                    ->label('ID')
                    ->sortable()
                    ->searchable(),
                TextColumn::make('title')
                    ->label('Title')
                    ->sortable()
                    ->searchable(),
                ImageColumn::make('path_video')
                    ->label('Video')
                    ->disk('video')
                    ->size(100),
                TextColumn::make('unitPendidikan.nama')
                    ->label('Unit Pendidikan')
                    ->sortable()
                    ->searchable(),
                TextColumn::make('text')
                    ->label('Description')
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
            'index' => Pages\ListVideos::route('/'),
            'create' => Pages\CreateVideo::route('/create'),
            'edit' => Pages\EditVideo::route('/{record}/edit'),
        ];
    }
}
