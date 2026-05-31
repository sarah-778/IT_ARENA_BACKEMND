<?php

namespace App\Filament\Resources\Repairs\Schemas;

use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\Select;

class RepairForm
{
    public static function getComponents(): array
    {
        return [
                Select::make('type')
                    ->label('Request Type')
                    ->options([
                        'user' => 'User Request',
                        'sample' => 'Portfolio Sample',
                    ])
                    ->required()
                    ->default('user'),

                TextInput::make('tracking_code')
                    ->label('Tracking Code')
                    ->unique(ignoreRecord: true),

                TextInput::make('name')
                    ->label('Customer Name'),

                TextInput::make('phone')
                    ->label('Phone')
                    ->tel(),

                TextInput::make('email')
                    ->label('Email')
                    ->email(),

                TextInput::make('device')
                    ->label('Device')
                    ->required(),

                Textarea::make('issue')
                    ->label('Issue/Description')
                    ->required()
                    ->columnSpanFull(),

                Select::make('status')
                    ->label('Status')
                    ->options([
                        'pending' => 'Received',
                        'diagnosing' => 'Diagnosis',
                        'repairing' => 'Repairing',
                        'completed' => 'Ready for Pickup',
                    ])
                    ->required()
                    ->default('pending'),

                DatePicker::make('date')
                    ->label('Date'),

                FileUpload::make('image')
                    ->label('Evidence/Photo')
                    ->image()
                    ->disk('public')
                    ->directory('repairs')
                    ->nullable(),
            ];
    }
}
