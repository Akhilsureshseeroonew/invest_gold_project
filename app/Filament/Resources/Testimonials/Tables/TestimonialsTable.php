<?php

namespace App\Filament\Resources\Testimonials\Tables;

use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class TestimonialsTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->defaultSort('sort_order')
            ->reorderable('sort_order')
            ->columns([
                TextColumn::make('name')->weight('bold')->searchable(),
                TextColumn::make('location')->searchable(),
                TextColumn::make('rating')->formatStateUsing(fn ($state) => str_repeat('★', (int) $state)),
                TextColumn::make('quote')->limit(60)->wrap(),
                IconColumn::make('is_published')->label('Published')->boolean(),
            ])
            ->recordActions([EditAction::make()])
            ->toolbarActions([BulkActionGroup::make([DeleteBulkAction::make()])]);
    }
}
