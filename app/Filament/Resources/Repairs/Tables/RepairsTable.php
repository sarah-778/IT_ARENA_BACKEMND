<?php

namespace App\Filament\Resources\Repairs\Tables;

use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Actions\DeleteAction;
use Filament\Tables\Columns\ImageColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class RepairsTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                ImageColumn::make('image')
                    ->label('Photo')
                    ->disk('public')
                    ->height('40')
                    ->width('40'),

                TextColumn::make('device')
                    ->label('Device')
                    ->searchable()
                    ->sortable(),

                TextColumn::make('issue')
                    ->label('Issue')
                    ->searchable()
                    ->limit(50),

                TextColumn::make('tracking_code')
                    ->label('Tracking Code')
                    ->searchable()
                    ->sortable(),

                TextColumn::make('name')
                    ->label('Customer')
                    ->searchable()
                    ->sortable(),

                TextColumn::make('phone')
                    ->label('Phone')
                    ->searchable(),

                TextColumn::make('status')
                    ->label('Status')
                    ->sortable()
                    ->formatStateUsing(fn ($state) => ucfirst($state))
                    ->color(fn ($state) => match($state) {
                        'completed' => 'success',
                        'repairing' => 'warning',
                        'diagnosing' => 'info',
                        default => 'secondary',
                    }),

                TextColumn::make('type')
                    ->label('Type')
                    ->sortable(),
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
