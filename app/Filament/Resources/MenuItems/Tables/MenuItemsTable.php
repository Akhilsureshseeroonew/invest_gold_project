<?php

namespace App\Filament\Resources\MenuItems\Tables;

use App\Models\MenuItem;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;

class MenuItemsTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->defaultSort('sort_order')
            ->reorderable('sort_order')
            ->groups(['menu'])
            ->defaultGroup('menu')
            ->columns([
                TextColumn::make('menu')->badge()->sortable(),
                TextColumn::make('label')
                    ->weight('bold')
                    ->description(fn ($record) => $record->parent?->label ? '↳ under '.$record->parent->label : 'Top level'),
                TextColumn::make('resolved_url')
                    ->label('Links to')
                    ->state(fn ($record) => $record->resolvedUrl()),
                IconColumn::make('is_active')->label('Active')->boolean(),
                TextColumn::make('sort_order')->label('Order')->sortable(),
            ])
            ->filters([
                SelectFilter::make('menu')->options(MenuItem::MENUS),
            ])
            ->recordActions([
                EditAction::make(),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ]);
    }
}
