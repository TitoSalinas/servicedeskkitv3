<?php

namespace App\Filament\Admin\Resources\Operators\Schemas;

use Filament\Forms\Components\Section;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Forms\Form;

use function filled;

class OperatorForm
{
    public static function configure(Form $form): Form
    {
        return $form
            ->columns(1)
            ->schema([
                Section::make()
                    ->columns()
                    ->schema([
                        Toggle::make('status')
                            ->required()
                            ->autofocus(),
                        TextInput::make('name')
                            ->required()
                            ->string()
                            ->autofocus(),
                        TextInput::make('email')
                            ->required()
                            ->string()
                            ->unique('operators', 'email', ignoreRecord: true)
                            ->email(),
                        TextInput::make('password')
                            ->password()
                            ->required(fn (string $context): bool => $context === 'create')
                            ->dehydrated(fn ($state) => filled($state))
                            ->minLength(6),
                    ]),
            ]);
    }
}
