<?php

namespace App\Filament\Resources\Products\Schemas;

use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\FileUpload;

class ProductForm
{
    public static function getComponents(): array
    {
        return [
                TextInput::make('name')
                    ->label('Product Name')
                    ->required()
                    ->maxLength(255),

                Select::make('category')
                    ->label('Category')
                    ->options([
                        'smartphones' => 'Smartphones',
                        'phone-spares' => 'Phone Spares',
                        'phone-chargers' => 'Phone Chargers',
                        'laptops' => 'Laptops',
                        'desktops' => 'Desktops',
                        'laptop-chargers' => 'Laptop Chargers',
                        'pc-spares' => 'PC Spares',
                    ])
                    ->required(),

                Select::make('brand')
                    ->label('Brand')
                    ->options(self::getBrandOptions())
                    ->required(),

                TextInput::make('price')
                    ->label('Unit Price (UGX)')
                    ->numeric()
                    ->required(),

                TextInput::make('stock')
                    ->label('Initial Stock')
                    ->numeric()
                    ->required(),

                FileUpload::make('image')
                    ->label('Product Image')
                    ->image()
                    ->disk('public')
                    ->directory('products')
                    ->nullable(),
            ];
    }

    private static function getBrandOptions(): array
    {
        return [
            'Apple iPhone' => 'Apple iPhone',
            'Samsung Galaxy' => 'Samsung Galaxy',
            'Google Pixel' => 'Google Pixel',
            'Huawei' => 'Huawei',
            'Xiaomi' => 'Xiaomi',
            'Oppo' => 'Oppo',
            'Tecno & Infinix' => 'Tecno & Infinix',
            'Original Screens' => 'Original Screens',
            'Charging Ports' => 'Charging Ports',
            'Batteries' => 'Batteries',
            'Back Covers' => 'Back Covers',
            'Camera Modules' => 'Camera Modules',
            'Apple' => 'Apple',
            'Samsung' => 'Samsung',
            'Oraimo' => 'Oraimo',
            'Anker' => 'Anker',
            'Baseus' => 'Baseus',
            'MacBook' => 'MacBook',
            'HP' => 'HP',
            'Dell' => 'Dell',
            'Lenovo' => 'Lenovo',
            'Asus' => 'Asus',
            'Acer' => 'Acer',
            'Microsoft Surface' => 'Microsoft Surface',
            'iMac' => 'iMac',
            'HP Pavilion' => 'HP Pavilion',
            'Dell OptiPlex' => 'Dell OptiPlex',
            'Lenovo ThinkCentre' => 'Lenovo ThinkCentre',
            'Custom Build' => 'Custom Build',
            'Workstations' => 'Workstations',
            'Universal' => 'Universal',
            'Apple MagSafe' => 'Apple MagSafe',
            'HP Smart AC' => 'HP Smart AC',
            'Dell Type-C' => 'Dell Type-C',
            'Screens' => 'Screens',
            'Keyboards' => 'Keyboards',
            'Internal Batteries' => 'Internal Batteries',
            'SSD Storage' => 'SSD Storage',
            'RAM' => 'RAM',
        ];
    }
}
