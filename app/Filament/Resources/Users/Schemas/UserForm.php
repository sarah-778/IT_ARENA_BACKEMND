<?php

namespace App\Filament\Resources\Users\Schemas;

use Filament\Forms\Components\TextInput;

class UserForm
{
    public static function getComponents(): array
    {
        return [
                TextInput::make('name')
                    ->label('Full Name')
                    ->required(),

                TextInput::make('email')
                    ->label('Email Address')
                    ->email()
                    ->required()
                    ->unique(ignoreRecord: true),

                TextInput::make('password')
                    ->label('Password')
                    ->password()
                    ->required(fn ($livewire) => $livewire instanceof \Filament\Resources\Pages\CreateRecord)
                    ->nullable(),
            ];
    }
}
