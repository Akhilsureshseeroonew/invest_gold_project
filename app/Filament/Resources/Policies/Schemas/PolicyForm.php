<?php

namespace App\Filament\Resources\Policies\Schemas;

use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Components\Grid;
use Filament\Schemas\Schema;

class PolicyForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema->components([
            TextInput::make('title')->required(),
            Textarea::make('description')->rows(2),
            Grid::make(3)->schema([
                TextInput::make('category')->placeholder('Policies'),
                Select::make('access')
                    ->label('Buttons shown')
                    ->options([
                        'download'  => 'Download row',
                        'view_only' => 'View-only row',
                    ])
                    ->default('download')
                    ->required()
                    ->native(false)
                    ->helperText('“View-only” opens the PDF in the on-page viewer and shows no download button.'),
                TextInput::make('icon')
                    ->placeholder('doc')
                    ->helperText('Sprite id for the row icon on view-only rows (e.g. shield, doc, users, chart, award). Download rows always use the download icon.'),
            ]),
            FileUpload::make('file_path')
                ->label('PDF file')
                ->disk('public')->directory('policies')->visibility('public')
                ->acceptedFileTypes(['application/pdf'])
                ->downloadable()
                // Seeded policies point at files under public/assets/docs/, which
                // this widget's disk can't see. Only overwrite file_path when a
                // new file is actually chosen, so saving the form never blanks it.
                ->dehydrated(fn ($state) => filled($state))
                ->helperText('Leave empty to keep the current file. Upload a PDF to replace it.')
                ->columnSpanFull(),
            Grid::make(3)->schema([
                TextInput::make('file_size_label')->label('Size label')->placeholder('PDF · 240 KB'),
                TextInput::make('sort_order')->numeric()->default(0),
                Toggle::make('is_active')->default(true),
            ]),
        ]);
    }
}
