<?php

namespace App\Filament\Resources\JobApplications\Schemas;

use App\Models\JobApplication;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;

class JobApplicationForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema->components([
            Section::make('Applicant')
                ->description('Submitted from the website — read only.')
                ->columns(2)
                ->schema([
                    TextInput::make('job_title')->label('Applied for')->disabled(),
                    TextInput::make('name')->disabled(),
                    TextInput::make('email')->disabled(),
                    TextInput::make('phone')->disabled(),
                    TextInput::make('cv_name')->label('CV file')->disabled()
                        ->helperText('Use the “Download CV” button on the list to open it.'),
                    TextInput::make('source_url')->label('Submitted from')->disabled(),
                ]),

            Section::make('Handling')->columns(1)->schema([
                Select::make('status')
                    ->options(array_combine(JobApplication::STATUSES, array_map('ucfirst', JobApplication::STATUSES)))
                    ->default('new')
                    ->required()
                    ->native(false),
                Textarea::make('admin_notes')->rows(4),
            ]),
        ]);
    }
}
