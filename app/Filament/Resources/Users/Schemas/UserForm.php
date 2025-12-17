<?php

declare(strict_types=1);

namespace App\Filament\Resources\Users\Schemas;

use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;
use Illuminate\Support\Facades\Hash;

final class UserForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make('User Information')
                    ->schema([
                        TextInput::make('name')
                            ->required()
                            ->maxLength(255)
                            ->autofocus(),

                        TextInput::make('email')
                            ->label('Email Address')
                            ->email()
                            ->required()
                            ->unique(ignoreRecord: true)
                            ->maxLength(255),

                        TextInput::make('password')
                            ->password()
                            ->dehydrateStateUsing(fn ($state) => filled($state) ? Hash::make($state) : null)
                            ->dehydrated(fn ($state) => filled($state))
                            ->required(fn (string $context): bool => $context === 'create')
                            ->maxLength(255)
                            ->confirmed()
                            ->revealable()
                            ->helperText('Leave blank to keep current password'),

                        TextInput::make('password_confirmation')
                            ->password()
                            ->dehydrated(false)
                            ->required(fn (string $context): bool => $context === 'create')
                            ->maxLength(255)
                            ->revealable(),

                        Toggle::make('is_active')
                            ->label('Active Status')
                            ->default(true)
                            ->helperText('Inactive users cannot login')
                            ->inline(false),
                    ])
                    ->columns(2),

                Section::make('Roles & Permissions')
                    ->schema([
                        Select::make('roles')
                            ->relationship('roles', 'name')
                            ->multiple()
                            ->preload()
                            ->searchable()
                            ->helperText('Assign roles to this user'),
                    ]),

                Section::make('Team Membership')
                    ->schema([
                        Select::make('teams')
                            ->relationship('teams', 'name')
                            ->multiple()
                            ->preload()
                            ->searchable()
                            ->helperText('Teams this user belongs to'),
                    ]),

                Section::make('Two-Factor Authentication')
                    ->schema([
                        Toggle::make('two_factor_enabled')
                            ->label('Two-Factor Authentication')
                            ->disabled()
                            ->dehydrated(false)
                            ->helperText('Managed by the user in their account settings'),
                    ])
                    ->collapsible()
                    ->collapsed(),
            ]);
    }
}
