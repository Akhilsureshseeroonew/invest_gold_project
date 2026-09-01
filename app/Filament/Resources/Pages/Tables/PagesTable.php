<?php

namespace App\Filament\Resources\Pages\Tables;

use App\Filament\Resources\Pages\Schemas\PageForm;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Filters\TernaryFilter;
use Filament\Tables\Table;

class PagesTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->defaultSort('sort_order')
            ->reorderable('sort_order')
            ->columns([
                TextColumn::make('title')
                    ->searchable()
                    ->sortable()
                    ->weight('bold')
                    ->description(fn ($record) => '/'.ltrim($record->slug, '/')),
                TextColumn::make('template')
                    ->badge()
                    ->formatStateUsing(fn ($state) => PageForm::TEMPLATES[$state] ?? $state)
                    ->sortable(),
                IconColumn::make('is_published')
                    ->label('Live')
                    ->boolean()
                    ->sortable(),
                TextColumn::make('updated_at')
                    ->since()
                    ->sortable()
                    ->label('Updated'),
            ])
            ->filters([
                SelectFilter::make('template')->options(PageForm::TEMPLATES),
                TernaryFilter::make('is_published')->label('Published'),
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
