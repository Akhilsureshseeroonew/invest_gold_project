<?php

namespace App\Filament\Resources\JobApplications\Tables;

use App\Models\JobApplication;
use Filament\Actions\Action;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\ViewAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;
use Illuminate\Support\Facades\Storage;

class JobApplicationsTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->defaultSort('created_at', 'desc')
            ->columns([
                TextColumn::make('created_at')->label('Received')->dateTime('d M Y, H:i')->sortable(),
                TextColumn::make('name')->searchable()->weight('bold'),
                TextColumn::make('job_title')->label('Applied for')->badge()->searchable()->sortable(),
                TextColumn::make('phone')->searchable()->copyable(),
                TextColumn::make('email')->searchable()->copyable()->toggleable(),
                TextColumn::make('status')
                    ->badge()
                    ->color(fn ($state) => match ($state) {
                        'new' => 'warning',
                        'reviewing' => 'info',
                        'shortlisted' => 'success',
                        'hired' => 'success',
                        'rejected' => 'danger',
                        default => 'gray',
                    })
                    ->sortable(),
            ])
            ->filters([
                SelectFilter::make('status')
                    ->options(array_combine(JobApplication::STATUSES, array_map('ucfirst', JobApplication::STATUSES))),
                SelectFilter::make('job_opening_id')
                    ->label('Role')
                    ->relationship('jobOpening', 'title'),
            ])
            ->recordActions([
                Action::make('downloadCv')
                    ->label('Download CV')
                    ->icon('heroicon-o-arrow-down-tray')
                    ->visible(fn (JobApplication $record) => filled($record->cv_path) && Storage::disk('local')->exists($record->cv_path))
                    ->action(fn (JobApplication $record) => Storage::disk('local')->download($record->cv_path, $record->cv_name ?: 'cv')),
                ViewAction::make(),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ]);
    }
}
