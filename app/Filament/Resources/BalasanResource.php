<?php

namespace App\Filament\Resources;

use Filament\Forms;
use Filament\Tables;
use App\Models\Balasan;
use Filament\Forms\Form;
use Filament\Tables\Table;
use Filament\Resources\Resource;
use Filament\Tables\Columns\TextColumn;
use Illuminate\Database\Eloquent\Builder;
use App\Filament\Resources\BalasanResource\Pages;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use App\Filament\Resources\BalasanResource\RelationManagers;

class BalasanResource extends Resource
{
    protected static ?string $model = Balasan::class;

    protected static ?string $navigationIcon = 'heroicon-o-chat-bubble-left-right';

    protected static ?string $navigationGroup = 'Content Management System';

    protected static ?string $pluralModelLabel = 'Balasan';
    protected static ?string $modelLabel = 'Balasan';
    protected static ?string $navigationLabel = 'Balasan';
    protected static ?string $slug = 'balasan';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Select::make('user_id')
                    ->relationship('user', 'name')
                    ->required()
                    ->label('Nama Pengguna'),
                Forms\Components\Select::make('komentar_id')
                    ->relationship('komentar', 'isi')
                    ->required()
                    ->label('Komentar'),
                Forms\Components\TextInput::make('isi')
                    ->required()
                    ->label('Balasan')
                    ->maxLength(255),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('id')
                    ->label('Id')
                    ->sortable()
                    ->searchable()
                    ->limit(50),
                TextColumn::make('user.name')
                    ->label('Nama Pengguna')
                    ->sortable()
                    ->searchable()
                    ->limit(50),
                TextColumn::make('komentar.isi')
                    ->label('Komentar')
                    ->sortable()
                    ->searchable()
                    ->limit(50),
                TextColumn::make('isi')
                    ->label('Balasan')
                    ->sortable()
                    ->searchable()
                    ->limit(50),
                TextColumn::make('created_at')
                    ->label('Tanggal Dibuat')
                    ->dateTime()
                    ->sortable(),
                TextColumn::make('updated_at')
                    ->label('Tanggal Diperbarui')
                    ->dateTime()
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
            'index' => Pages\ListBalasans::route('/'),
            'create' => Pages\CreateBalasan::route('/create'),
            'edit' => Pages\EditBalasan::route('/{record}/edit'),
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
