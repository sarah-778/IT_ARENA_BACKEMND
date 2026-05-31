<?php

namespace App\Filament\Resources\Messages\Schemas;

use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\Toggle;

class MessageForm
{
    public static function getComponents(): array
    {
        return [
                TextInput::make('name')
                    ->label('Sender Name')
                    ->required(),

                TextInput::make('email')
                    ->label('Email Address')
                    ->email()
                    ->required(),

                TextInput::make('phone')
                    ->label('Phone')
                    ->tel(),

                Textarea::make('message')
                    ->label('Message')
                    ->required()
                    ->columnSpanFull(),

                Toggle::make('is_read')
                    ->label('Mark as Read')
                    ->default(false),
            ];
    }
}
