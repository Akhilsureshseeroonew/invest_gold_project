<?php

namespace App\Filament\Resources\Enquiries\Schemas;

use App\Models\Enquiry;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;

class EnquiryForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema->components([
            Section::make('Submission')
                ->description('Captured from the website — read only.')
                ->columns(2)
                ->schema([
                    TextInput::make('name')->disabled(),
                    TextInput::make('phone')->disabled(),
                    TextInput::make('email')->disabled(),
                    TextInput::make('service')->disabled(),
                    Textarea::make('message')->disabled()->columnSpanFull()->rows(4),
                    TextInput::make('page_context')->label('Prefilled service')->disabled(),
                    TextInput::make('source_url')->label('Submitted from')->disabled(),
                ]),

            Section::make('Handling')->columns(1)->schema([
                Select::make('status')
                    ->options(array_combine(Enquiry::STATUSES, array_map('ucfirst', Enquiry::STATUSES)))
                    ->default('new')
                    ->required()
                    ->native(false),
                Textarea::make('admin_notes')->rows(4),
            ]),
        ]);
    }
}
