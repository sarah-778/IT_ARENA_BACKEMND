<?php

namespace App\Filament\Resources\Orders\Schemas;

use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;

class OrderForm
{
    public static function getComponents(): array
    {
        return [
                TextInput::make('order_number')
                    ->label('Order Number')
                    ->required()
                    ->unique(ignoreRecord: true),

                TextInput::make('customer_name')
                    ->label('Customer Name')
                    ->required(),

                TextInput::make('phone')
                    ->label('Phone')
                    ->tel()
                    ->required(),

                TextInput::make('email')
                    ->label('Email')
                    ->email()
                    ->required(),

                TextInput::make('district')
                    ->label('District')
                    ->required(),

                Textarea::make('address')
                    ->label('Delivery Address')
                    ->required(),

                TextInput::make('subtotal')
                    ->label('Subtotal (UGX)')
                    ->numeric()
                    ->required(),

                TextInput::make('delivery_fee')
                    ->label('Delivery Fee (UGX)')
                    ->numeric()
                    ->required(),

                TextInput::make('total')
                    ->label('Total (UGX)')
                    ->numeric()
                    ->required(),

                Select::make('status')
                    ->label('Status')
                    ->options([
                        'pending' => 'Pending Receipt',
                        'processing' => 'Processing Order',
                        'delivered' => 'Completed/Delivered',
                        'cancelled' => 'Cancelled',
                    ])
                    ->required(),
            ];
    }
}
