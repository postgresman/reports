<?php

namespace App\Filament\Resources\Users\Schemas;

use Filament\Forms\Components\DateTimePicker;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Schema;
use Filament\Forms\Components\Select;
use Illuminate\Support\Facades\Hash;
use Filament\Facades\Filament;

class UserForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema->components([
            TextInput::make('name')
                ->required(),
            TextInput::make('email')
                ->label('Email address')
                ->email()
                ->required(),
            DateTimePicker::make('email_verified_at'),
            TextInput::make('password')
                ->password()
                ->dehydrateStateUsing(fn ($state) => Hash::make($state))
                ->dehydrated(fn ($state) => filled($state))
                ->required(fn (string $context) => $context === 'create'),
            Select::make('role_id')
                ->relationship('role', 'name')
                ->required(),
            Select::make('markets')
                ->label('Assigned Markets')
                ->hidden(function ($record) {
                    return $record && $record->role->name === 'admin';
                })
                ->multiple()
                ->preload()
                ->relationship('markets', 'name'),
        ]);
    }
}
