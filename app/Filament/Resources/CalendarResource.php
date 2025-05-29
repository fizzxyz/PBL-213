<?php

namespace App\Filament\Resources;

use Filament\Forms;
use Filament\Tables;
use App\Models\Calendar;
use Filament\Forms\Form;
use Filament\Tables\Table;
use Filament\Resources\Resource;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\DatePicker;
use Illuminate\Database\Eloquent\Builder;
use App\Filament\Resources\CalendarResource\Pages;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use App\Filament\Resources\CalendarResource\RelationManagers;
use Filament\Forms\Components\Select;
use Filament\Tables\Columns\TextColumn;

class CalendarResource extends Resource
{
    protected static ?string $model = Calendar::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    protected static ?string $navigationGroup = 'Content Management System';

    protected static ?string $pluralModelLabel = 'Calendar';
    protected static ?string $modelLabel = 'Calendar';
    protected static ?string $navigationLabel = 'Calendar';
    protected static ?string $slug = 'calendar';

    public static function canViewAny(): bool
    {
        return auth()->user()->can('view_calendar');
    }
    public static function canCreate(): bool
    {
        return auth()->user()->can('create_calendar');
    }
    public static function canEdit($record): bool
    {
        return auth()->user()->can('edit_calendar');
    }
    public static function canDelete($record): bool
    {
        return auth()->user()->can('delete_calendar');
    }

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                TextInput::make('title')
                    ->required()
                    ->maxLength(255),
                TextInput::make('description')
                    ->required()
                    ->maxLength(255),
                DatePicker::make('start_date')
                    ->required()
                    ->placeholder('YYYY-MM-DD HH:MM:SS'),
                DatePicker::make('end_date')
                    ->required()
                    ->placeholder('YYYY-MM-DD HH:MM:SS'),
                Select::make('unit_pendidikan_id')
                    ->label('Unit Pendidikan')
                    ->relationship('unitPendidikan', 'nama')
                    ->required()
                    ->searchable()
                    ->preload()
                    ->placeholder('Pilih Unit Pendidikan'),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('title')
                    ->sortable()
                    ->searchable()
                    ->label('Judul'),
                TextColumn::make('description')
                    ->sortable()
                    ->searchable()
                    ->label('Deskripsi'),
                TextColumn::make('start_date')
                    ->sortable()
                    ->date()
                    ->label('Tanggal Mulai'),
                TextColumn::make('end_date')
                    ->sortable()
                    ->date()
                    ->label('Tanggal Selesai'),
                TextColumn::make('unitPendidikan.nama')
                    ->sortable()
                    ->searchable()
                    ->label('Unit Pendidikan'),
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
            'index' => Pages\ListCalendars::route('/'),
            'create' => Pages\CreateCalendar::route('/create'),
            'edit' => Pages\EditCalendar::route('/{record}/edit'),
        ];
    }
}
