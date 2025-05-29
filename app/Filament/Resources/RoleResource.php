<?php

namespace App\Filament\Resources;

use Filament\Forms;
use Filament\Tables;
use Filament\Forms\Form;
use Filament\Tables\Table;
use Filament\Resources\Resource;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\CheckboxList;
use Filament\Forms\Components\Section;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Actions\EditAction;
use Filament\Tables\Actions\DeleteAction;
use Filament\Tables\Actions\ViewAction;
use Illuminate\Database\Eloquent\Builder;
use App\Filament\Resources\RoleResource\Pages;

class RoleResource extends Resource
{
    protected static ?string $model = Role::class;
    protected static ?string $navigationIcon = 'heroicon-o-shield-check';
    protected static ?string $navigationGroup = 'User Management';
    protected static ?string $navigationLabel = 'Roles';
    protected static ?int $navigationSort = 2;

    public static function canViewAny(): bool
    {
        return auth()->user()->can('view_role');
    }

    public static function canCreate(): bool
    {
        return auth()->user()->can('create_role');
    }

    public static function canEdit($record): bool
    {
        return auth()->user()->can('edit_role');
    }

    public static function canDelete($record): bool
    {
        return auth()->user()->can('delete_role') && $record->name !== 'super_admin';
    }

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Section::make('Role Information')
                    ->schema([
                        TextInput::make('name')
                            ->label('Role Name')
                            ->required()
                            ->unique(ignoreRecord: true)
                            ->placeholder('Enter the role name')
                            ->helperText('Use lowercase with underscores (e.g., content_manager)'),
                    ]),

                Section::make('General Permissions')
                    ->schema([
                        CheckboxList::make('permissions')
                            ->label('System Access')
                            ->relationship('permissions', 'name')
                            ->options(function () {
                                return Permission::whereIn('name', [
                                    'access_admin_panel',
                                    'view_dashboard',
                                    'manage_settings',
                                ])->pluck('name', 'id')->mapWithKeys(function ($name, $id) {
                                    $label = match($name) {
                                        'access_admin_panel' => 'Access Admin Panel',
                                        default => ucwords(str_replace('_', ' ', $name))
                                    };
                                    return [$id => $label];
                                });
                            })
                            ->columns(3),
                    ]),

                Section::make('Content Management Permissions')
                    ->schema([
                        CheckboxList::make('permissions')
                            ->label('Articles')
                            ->relationship('permissions', 'name')
                            ->getOptionLabelFromRecordUsing(fn (Permission $record) => match($record->name) {
                                'view_artikel' => 'View Articles',
                                'create_artikel' => 'Create Articles',
                                'edit_artikel' => 'Edit Articles',
                                'delete_artikel' => 'Delete Articles',
                                default => ucwords(str_replace('_', ' ', $record->name))
                            })
                            ->options(function () {
                                return Permission::whereIn('name', [
                                    'view_artikel',
                                    'create_artikel',
                                    'edit_artikel',
                                    'delete_artikel',
                                ])->pluck('name', 'id');
                            })
                            ->columns(4),

                        CheckboxList::make('permissions')
                            ->label('Categories')
                            ->relationship('permissions', 'name')
                            ->getOptionLabelFromRecordUsing(fn (Permission $record) => match($record->name) {
                                'view_category' => 'View Categories',
                                'create_category' => 'Create Categories',
                                'edit_category' => 'Edit Categories',
                                'delete_category' => 'Delete Categories',
                                default => ucwords(str_replace('_', ' ', $record->name))
                            })
                            ->options(function () {
                                return Permission::whereIn('name', [
                                    'view_category',
                                    'create_category',
                                    'edit_category',
                                    'delete_category',
                                ])->pluck('name', 'id');
                            })
                            ->columns(4),

                        CheckboxList::make('permissions')
                            ->label('Gallery')
                            ->relationship('permissions', 'name')
                            ->getOptionLabelFromRecordUsing(fn (Permission $record) => match($record->name) {
                                'view_galeri' => 'View Gallery',
                                'create_galeri' => 'Create Gallery',
                                'edit_galeri' => 'Edit Gallery',
                                'delete_galeri' => 'Delete Gallery',
                                default => ucwords(str_replace('_', ' ', $record->name))
                            })
                            ->options(function () {
                                return Permission::whereIn('name', [
                                    'view_galeri',
                                    'create_galeri',
                                    'edit_galeri',
                                    'delete_galeri',
                                ])->pluck('name', 'id');
                            })
                            ->columns(4),

                        CheckboxList::make('permissions')
                            ->label('Videos')
                            ->relationship('permissions', 'name')
                            ->getOptionLabelFromRecordUsing(fn (Permission $record) => match($record->name) {
                                'view_video' => 'View Videos',
                                'create_video' => 'Create Videos',
                                'edit_video' => 'Edit Videos',
                                'delete_video' => 'Delete Videos',
                                default => ucwords(str_replace('_', ' ', $record->name))
                            })
                            ->options(function () {
                                return Permission::whereIn('name', [
                                    'view_video',
                                    'create_video',
                                    'edit_video',
                                    'delete_video',
                                ])->pluck('name', 'id');
                            })
                            ->columns(4),

                        CheckboxList::make('permissions')
                            ->label('Home Content')
                            ->relationship('permissions', 'name')
                            ->getOptionLabelFromRecordUsing(fn (Permission $record) => match($record->name) {
                                'view_home_content' => 'View Home Content',
                                'create_home_content' => 'Create Home Content',
                                'edit_home_content' => 'Edit Home Content',
                                'delete_home_content' => 'Delete Home Content',
                                default => ucwords(str_replace('_', ' ', $record->name))
                            })
                            ->options(function () {
                                return Permission::whereIn('name', [
                                    'view_home_content',
                                    'create_home_content',
                                    'edit_home_content',
                                    'delete_home_content',
                                ])->pluck('name', 'id');
                            })
                            ->columns(4),
                    ]),

                Section::make('Academic Management Permissions')
                    ->schema([
                        CheckboxList::make('permissions')
                            ->label('Calendar')
                            ->relationship('permissions', 'name')
                            ->getOptionLabelFromRecordUsing(fn (Permission $record) => match($record->name) {
                                'view_calendar' => 'View Calendar',
                                'create_calendar' => 'Create Calendar',
                                'edit_calendar' => 'Edit Calendar',
                                'delete_calendar' => 'Delete Calendar',
                                default => ucwords(str_replace('_', ' ', $record->name))
                            })
                            ->options(function () {
                                return Permission::whereIn('name', [
                                    'view_calendar',
                                    'create_calendar',
                                    'edit_calendar',
                                    'delete_calendar',
                                ])->pluck('name', 'id');
                            })
                            ->columns(4),

                        CheckboxList::make('permissions')
                            ->label('Unit Pendidikan')
                            ->relationship('permissions', 'name')
                            ->getOptionLabelFromRecordUsing(fn (Permission $record) => match($record->name) {
                                'view_unit_pendidikan' => 'View Unit Pendidikan',
                                'create_unit_pendidikan' => 'Create Unit Pendidikan',
                                'edit_unit_pendidikan' => 'Edit Unit Pendidikan',
                                'delete_unit_pendidikan' => 'Delete Unit Pendidikan',
                                default => ucwords(str_replace('_', ' ', $record->name))
                            })
                            ->options(function () {
                                return Permission::whereIn('name', [
                                    'view_unit_pendidikan',
                                    'create_unit_pendidikan',
                                    'edit_unit_pendidikan',
                                    'delete_unit_pendidikan',
                                ])->pluck('name', 'id');
                            })
                            ->columns(4),

                        CheckboxList::make('permissions')
                            ->label('Pendaftaran')
                            ->relationship('permissions', 'name')
                            ->getOptionLabelFromRecordUsing(fn (Permission $record) => match($record->name) {
                                'view_pendaftaran' => 'View Pendaftaran',
                                'create_pendaftaran' => 'Create Pendaftaran',
                                'edit_pendaftaran' => 'Edit Pendaftaran',
                                'delete_pendaftaran' => 'Delete Pendaftaran',
                                default => ucwords(str_replace('_', ' ', $record->name))
                            })
                            ->options(function () {
                                return Permission::whereIn('name', [
                                    'view_pendaftaran',
                                    'create_pendaftaran',
                                    'edit_pendaftaran',
                                    'delete_pendaftaran',
                                ])->pluck('name', 'id');
                            })
                            ->columns(4),

                        CheckboxList::make('permissions')
                            ->label('Penerimaan')
                            ->relationship('permissions', 'name')
                            ->getOptionLabelFromRecordUsing(fn (Permission $record) => match($record->name) {
                                'view_penerimaan' => 'View Penerimaan',
                                'create_penerimaan' => 'Create Penerimaan',
                                'edit_penerimaan' => 'Edit Penerimaan',
                                'delete_penerimaan' => 'Delete Penerimaan',
                                default => ucwords(str_replace('_', ' ', $record->name))
                            })
                            ->options(function () {
                                return Permission::whereIn('name', [
                                    'view_penerimaan',
                                    'create_penerimaan',
                                    'edit_penerimaan',
                                    'delete_penerimaan',
                                ])->pluck('name', 'id');
                            })
                            ->columns(4),

                        CheckboxList::make('permissions')
                            ->label('Yayasan')
                            ->relationship('permissions', 'name')
                            ->getOptionLabelFromRecordUsing(fn (Permission $record) => match($record->name) {
                                'view_yayasan' => 'View Yayasan',
                                'create_yayasan' => 'Create Yayasan',
                                'edit_yayasan' => 'Edit Yayasan',
                                'delete_yayasan' => 'Delete Yayasan',
                                default => ucwords(str_replace('_', ' ', $record->name))
                            })
                            ->options(function () {
                                return Permission::whereIn('name', [
                                    'view_yayasan',
                                    'create_yayasan',
                                    'edit_yayasan',
                                    'delete_yayasan',
                                ])->pluck('name', 'id');
                            })
                            ->columns(4),
                    ]),

                Section::make('Financial Management Permissions')
                    ->schema([
                        CheckboxList::make('permissions')
                            ->label('Transaksi')
                            ->relationship('permissions', 'name')
                            ->getOptionLabelFromRecordUsing(fn (Permission $record) => match($record->name) {
                                'view_transaksi' => 'View Transaksi',
                                'create_transaksi' => 'Create Transaksi',
                                'edit_transaksi' => 'Edit Transaksi',
                                'delete_transaksi' => 'Delete Transaksi',
                                default => ucwords(str_replace('_', ' ', $record->name))
                            })
                            ->options(function () {
                                return Permission::whereIn('name', [
                                    'view_transaksi',
                                    'create_transaksi',
                                    'edit_transaksi',
                                    'delete_transaksi',
                                ])->pluck('name', 'id');
                            })
                            ->columns(4),
                    ]),

                Section::make('Communication Management Permissions')
                    ->schema([
                        CheckboxList::make('permissions')
                            ->label('Comments')
                            ->relationship('permissions', 'name')
                            ->getOptionLabelFromRecordUsing(fn (Permission $record) => match($record->name) {
                                'view_komentar' => 'View Komentar',
                                'create_komentar' => 'Create Komentar',
                                'edit_komentar' => 'Edit Komentar',
                                'delete_komentar' => 'Delete Komentar',
                                default => ucwords(str_replace('_', ' ', $record->name))
                            })
                            ->options(function () {
                                return Permission::whereIn('name', [
                                    'view_komentar',
                                    'create_komentar',
                                    'edit_komentar',
                                    'delete_komentar',
                                ])->pluck('name', 'id');
                            })
                            ->columns(4),

                        CheckboxList::make('permissions')
                            ->label('Replies')
                            ->relationship('permissions', 'name')
                            ->getOptionLabelFromRecordUsing(fn (Permission $record) => match($record->name) {
                                'view_balasan' => 'View Balasan',
                                'create_balasan' => 'Create Balasan',
                                'edit_balasan' => 'Edit Balasan',
                                'delete_balasan' => 'Delete Balasan',
                                default => ucwords(str_replace('_', ' ', $record->name))
                            })
                            ->options(function () {
                                return Permission::whereIn('name', [
                                    'view_balasan',
                                    'create_balasan',
                                    'edit_balasan',
                                    'delete_balasan',
                                ])->pluck('name', 'id');
                            })
                            ->columns(4),

                        CheckboxList::make('permissions')
                            ->label('Social Media')
                            ->relationship('permissions', 'name')
                            ->getOptionLabelFromRecordUsing(fn (Permission $record) => match($record->name) {
                                'view_media_sosial' => 'View Media Sosial',
                                'create_media_sosial' => 'Create Media Sosial',
                                'edit_media_sosial' => 'Edit Media Sosial',
                                'delete_media_sosial' => 'Delete Media Sosial',
                                default => ucwords(str_replace('_', ' ', $record->name))
                            })
                            ->options(function () {
                                return Permission::whereIn('name', [
                                    'view_media_sosial',
                                    'create_media_sosial',
                                    'edit_media_sosial',
                                    'delete_media_sosial',
                                ])->pluck('name', 'id');
                            })
                            ->columns(4),
                    ]),

                Section::make('User & System Management Permissions')
                    ->schema([
                        CheckboxList::make('permissions')
                            ->label('Users')
                            ->relationship('permissions', 'name')
                            ->getOptionLabelFromRecordUsing(fn (Permission $record) => match($record->name) {
                                'view_user' => 'View Users',
                                'create_user' => 'Create Users',
                                'edit_user' => 'Edit Users',
                                'delete_user' => 'Delete Users',
                                default => ucwords(str_replace('_', ' ', $record->name))
                            })
                            ->options(function () {
                                return Permission::whereIn('name', [
                                    'view_user',
                                    'create_user',
                                    'edit_user',
                                    'delete_user',
                                ])->pluck('name', 'id');
                            })
                            ->columns(4),

                        CheckboxList::make('permissions')
                            ->label('Roles')
                            ->relationship('permissions', 'name')
                            ->getOptionLabelFromRecordUsing(fn (Permission $record) => match($record->name) {
                                'view_role' => 'View Roles',
                                'create_role' => 'Create Roles',
                                'edit_role' => 'Edit Roles',
                                'delete_role' => 'Delete Roles',
                                default => ucwords(str_replace('_', ' ', $record->name))
                            })
                            ->options(function () {
                                return Permission::whereIn('name', [
                                    'view_role',
                                    'create_role',
                                    'edit_role',
                                    'delete_role',
                                ])->pluck('name', 'id');
                            })
                            ->columns(4),

                        CheckboxList::make('permissions')
                            ->label('Navigation')
                            ->relationship('permissions', 'name')
                            ->getOptionLabelFromRecordUsing(fn (Permission $record) => match($record->name) {
                                'view_navbar' => 'View Navbar',
                                'create_navbar' => 'Create Navbar',
                                'edit_navbar' => 'Edit Navbar',
                                'delete_navbar' => 'Delete Navbar',
                                default => ucwords(str_replace('_', ' ', $record->name))
                            })
                            ->options(function () {
                                return Permission::whereIn('name', [
                                    'view_navbar',
                                    'create_navbar',
                                    'edit_navbar',
                                    'delete_navbar',
                                ])->pluck('name', 'id');
                            })
                            ->columns(4),
                    ]),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('id')
                    ->label('ID')
                    ->sortable(),

                TextColumn::make('name')
                    ->label('Role Name')
                    ->sortable()
                    ->searchable()
                    ->formatStateUsing(fn (string $state): string => ucwords(str_replace('_', ' ', $state))),

                TextColumn::make('permissions_count')
                    ->label('Permissions')
                    ->counts('permissions')
                    ->sortable()
                    ->badge()
                    ->color('success'),

                TextColumn::make('users_count')
                    ->label('Users')
                    ->counts('users')
                    ->sortable()
                    ->badge()
                    ->color('info'),

                TextColumn::make('created_at')
                    ->label('Created At')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                //
            ])
            ->actions([
                ViewAction::make(),
                EditAction::make(),
                DeleteAction::make()
                    ->before(function ($record) {
                        if ($record->name === 'super_admin') {
                            throw new \Exception('Cannot delete Super Admin role.');
                        }
                        if ($record->users()->count() > 0) {
                            throw new \Exception('Cannot delete role that has assigned users.');
                        }
                    }),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make()
                        ->before(function ($records) {
                            foreach ($records as $record) {
                                if ($record->name === 'super_admin') {
                                    throw new \Exception('Cannot delete Super Admin role.');
                                }
                                if ($record->users()->count() > 0) {
                                    throw new \Exception('Cannot delete role that has assigned users.');
                                }
                            }
                        }),
                ]),
            ]);
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListRoles::route('/'),
            'create' => Pages\CreateRole::route('/create'),
            'edit' => Pages\EditRole::route('/{record}/edit'),
        ];
    }
}