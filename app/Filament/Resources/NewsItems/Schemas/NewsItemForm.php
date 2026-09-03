<?php

namespace App\Filament\Resources\NewsItems\Schemas;

use Filament\Forms\Components\DateTimePicker;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Repeater;
use Filament\Forms\Components\RichEditor;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Components\Grid;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;
use Illuminate\Support\Str;

class NewsItemForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema->components([
            Section::make()->columns(2)->schema([
                Select::make('kind')
                    ->options(['news' => 'News', 'event' => 'Event', 'media' => 'Media coverage'])
                    ->default('news')
                    ->required()
                    ->native(false)
                    ->live(),
                TextInput::make('title')
                    ->required()
                    ->live(onBlur: true)
                    ->afterStateUpdated(fn ($state, $get, $set) => blank($get('slug')) ? $set('slug', Str::slug($state)) : null),
                TextInput::make('slug')->required()->rule('alpha_dash')->columnSpanFull(),
            ]),
            Textarea::make('summary')->rows(2)->columnSpanFull(),
            FileUpload::make('banner_image')
                ->label('Image')
                ->helperText('Used as the banner at the top of the article and as the thumbnail on the News listing card. Optional — a themed icon shows if left empty.')
                ->image()->imageEditor()->imageEditorAspectRatios(['16:9', '3:1', '4:3'])
                ->disk('public')->directory('news/banners')->visibility('public')
                ->columnSpanFull(),
            RichEditor::make('body')
                ->fileAttachmentsDisk('public')
                ->fileAttachmentsDirectory('news/inline')
                ->fileAttachmentsVisibility('public')
                ->columnSpanFull(),

            Section::make('Event details')
                ->visible(fn ($get) => $get('kind') === 'event')
                ->columns(2)
                ->schema([
                    DatePicker::make('event_date'),
                    TextInput::make('event_time')->placeholder('10:00 AM – 4:00 PM'),
                    TextInput::make('location')->label('Venue'),
                    TextInput::make('organizer'),
                ]),

            Section::make('Media coverage')
                ->visible(fn ($get) => $get('kind') === 'media')
                ->columns(2)
                ->schema([
                    TextInput::make('source')->label('Publication'),
                    TextInput::make('source_url')->label('Article URL')->url(),
                ]),

            Section::make('Gallery')
                ->description('Optional photo/video strip on the detail page. Leave the image empty to show an icon placeholder.')
                ->schema([
                    Repeater::make('gallery')
                        ->hiddenLabel()
                        ->schema([
                            Grid::make(3)->schema([
                                FileUpload::make('image')->image()->imageEditor()
                                    ->disk('public')->directory('news/gallery')->visibility('public')
                                    ->columnSpan(2),
                                TextInput::make('caption'),
                            ]),
                        ])
                        ->addActionLabel('Add gallery item')
                        ->reorderable()
                        ->collapsed()
                        ->defaultItems(0),
                ])->collapsible(),

            Section::make('Bottom call-to-action')->columns(2)->schema([
                TextInput::make('cta_label')->helperText('e.g. "Enquire About Mahila Loans". Leave blank to hide.'),
                TextInput::make('cta_url')->helperText('e.g. /contact?service=Mahila Loan'),
            ])->collapsible(),

            Section::make('Publishing')->columns(3)->schema([
                Toggle::make('is_published')->default(true),
                DateTimePicker::make('published_at')->default(now()),
            ]),
        ]);
    }
}
