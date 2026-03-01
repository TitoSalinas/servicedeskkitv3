<?php

namespace App\Filament\Admin\Resources\Users;

use App\Filament\Admin\Resources\Users\Pages\CreateUser;
use App\Filament\Admin\Resources\Users\Pages\EditUser;
use App\Filament\Admin\Resources\Users\Pages\ListUsers;
use App\Filament\Admin\Resources\Users\Pages\ViewUser;
use App\Filament\Admin\Resources\Users\Schemas\UserForm;
use App\Filament\Admin\Resources\Users\Schemas\UserInfolist;
use App\Filament\Admin\Resources\Users\Tables\UsersTable;
use App\Models\User;
use Filament\Forms\Form;
use Filament\Infolists\Infolist;
use Filament\Resources\Resource;
use Filament\Tables\Table;
use Illuminate\Support\Facades\Cache;

use function __;

class UserResource extends Resource
{
    protected static ?string $model = User::class;

    protected static ?string $navigationIcon = 'heroicon-o-user';

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
        return __('User');
    }

    public static function getPluralModelLabel(): string
    {
        return __('Users');
    }

    public static function getNavigationLabel(): string
    {
        return __('Users');
    }

    public static function getNavigationGroup(): ?string
    {
        return __('User');
    }

    public static function getNavigationBadge(): ?string
    {
        return (string) Cache::rememberForever('users_count', fn () => User::query()->count());
    }

    public static function form(Form $form): Form
    {
        return UserForm::configure($form);
    }

    public static function infolist(Infolist $infolist): Infolist
    {
        return UserInfolist::configure($infolist);
    }

    public static function table(Table $table): Table
    {
        return UsersTable::configure($table);
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
            'index' => ListUsers::route('/'),
            'create' => CreateUser::route('/create'),
            'view' => ViewUser::route('/{record}'),
            'edit' => EditUser::route('/{record}/edit'),
        ];
    }
}
