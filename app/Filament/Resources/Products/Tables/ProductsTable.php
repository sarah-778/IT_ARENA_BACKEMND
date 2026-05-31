<?php

namespace App\Filament\Resources\Products\Tables;

use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Actions\DeleteAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Columns\ImageColumn;
use Filament\Tables\Table;

class ProductsTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                ImageColumn::make('image')
                    ->label('Image')
                    ->disk('public')
                    ->height('40')
                    ->width('40'),
                
                TextColumn::make('name')
                    ->label('Product')
                    ->searchable()
                    ->sortable(),
                
                TextColumn::make('brand')
                    ->label('Brand')
                    ->sortable(),
                
                TextColumn::make('stock')
                    ->label('Stock')
                    ->sortable()
                    ->color(fn ($state) => $state < 5 ? 'danger' : 'info'),
                
                TextColumn::make('price')
                    ->label('Price (UGX)')
                    ->sortable()
                    ->formatStateUsing(fn ($state) => number_format($state)),
            ])
            ->filters([
                //
            ])
            ->recordActions([
                EditAction::make(),
                DeleteAction::make(),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ]);
    }
}
