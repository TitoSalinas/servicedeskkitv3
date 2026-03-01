<?php

namespace App\Filament\Admin\Resources\Admins;

use App\Filament\Admin\Resources\Admins\Pages\CreateAdmin;
use App\Filament\Admin\Resources\Admins\Pages\EditAdmin;
use App\Filament\Admin\Resources\Admins\Pages\ListAdmins;
use App\Filament\Admin\Resources\Admins\Pages\ViewAdmin;
use App\Filament\Admin\Resources\Admins\Schemas\AdminForm;
use App\Filament\Admin\Resources\Admins\Schemas\AdminInfolist;
use App\Filament\Admin\Resources\Admins\Tables\AdminsTable;
use App\Models\Admin;
use Filament\Forms\Form;
use Filament\Infolists\Infolist;
use Filament\Resources\Resource;
use Filament\Tables\Table;
use Illuminate\Support\Facades\Cache;

use function __;

class AdminResource extends Resource
{
    protected static ?string $model = Admin::class;

    protected static ?string $navigationIcon = 'heroicon-o-user-circle';

    protected static bool $isGloballySearchable = true;

    protected static ?string $recordTitleAttribute = 'name';

    public static function getGloballySearchableAttributes(): array
    {
        return ['name', 'email'];
    }

    public static function getGlobalSearchResultUrl($record): string
    {
        return self::getUrl('view', ['record' => $record]);
    }

    public static function getModelLabel(): string
    {
        return __('Admin');
    }

    public static function getPluralModelLabel(): string
    {
        return __('Admins');
    }

    public static function getNavigationLabel(): string
    {
        return __('Admins');
    }

    public static function getNavigationGroup(): ?string
    {
        return __('Management');
    }

    public static function getNavigationBadge(): ?string
    {
        return (string) Cache::rememberForever('admins_count', fn () => Admin::query()->count());
    }

    public static function form(Form $form): Form
    {
        return AdminForm::configure($form);
    }

    public static function infolist(Infolist $infolist): Infolist
    {
        return AdminInfolist::configure($infolist);
    }

    public static function table(Table $table): Table
    {
        return AdminsTable::configure($table);
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
            'index' => ListAdmins::route('/'),
            'create' => CreateAdmin::route('/create'),
            'view' => ViewAdmin::route('/{record}'),
            'edit' => EditAdmin::route('/{record}/edit'),
        ];
    }
}
