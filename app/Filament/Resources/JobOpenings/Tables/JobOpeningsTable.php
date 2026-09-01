<?php

namespace App\Filament\Resources\JobOpenings\Tables;

use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class JobOpeningsTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('slug')
                    ->searchable(),
                TextColumn::make('title')
                    ->searchable(),
                TextColumn::make('department')
                    ->searchable(),
                TextColumn::make('location')
                    ->searchable(),
                TextColumn::make('employment_type')
                    ->searchable(),
                TextColumn::make('experience')
                    ->searchable(),
                IconColumn::make('is_open')
                    ->boolean(),
                TextColumn::make('applications_count')
                    ->label('Applicants')
                    ->counts('applications')
                    ->badge()
                    ->url(fn ($record) => \App\Filament\Resources\JobApplications\JobApplicationResource::getUrl('index', [
                        'tableFilters[job_opening_id][value]' => $record->id,
                    ])),
                TextColumn::make('posted_at')
                    ->date()
                    ->sortable(),
                TextColumn::make('closing_at')
                    ->date()
                    ->sortable(),
                TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                TextColumn::make('updated_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                //
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
