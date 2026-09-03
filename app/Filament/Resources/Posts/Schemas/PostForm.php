<?php

namespace App\Filament\Resources\Posts\Schemas;

use Filament\Forms\Components\DateTimePicker;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\RichEditor;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Components\Grid;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;
use Illuminate\Support\Str;

class PostForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema->components([
            Section::make()->columns(2)->schema([
                TextInput::make('title')
                    ->required()
                    ->live(onBlur: true)
                    ->afterStateUpdated(fn ($state, $get, $set) => blank($get('slug')) ? $set('slug', Str::slug($state)) : null),
                TextInput::make('slug')->required()->rule('alpha_dash'),
                TextInput::make('category'),
                TextInput::make('author'),
                TextInput::make('read_time')->placeholder('5 min read'),
            ]),
            Textarea::make('excerpt')->rows(2)->columnSpanFull(),
            FileUpload::make('banner_image')
                ->label('Image')
                ->helperText('Used as the banner at the top of the article and as the thumbnail on the blog listing card. Optional — a category icon shows if left empty.')
                ->image()->imageEditor()->imageEditorAspectRatios(['16:9', '3:1', '4:3'])
                ->disk('public')->directory('blog/banners')->visibility('public')
                ->columnSpanFull(),
            RichEditor::make('body')
                ->fileAttachmentsDisk('public')
                ->fileAttachmentsDirectory('blog/inline')
                ->fileAttachmentsVisibility('public')
                ->columnSpanFull(),
            Section::make('Bottom call-to-action')->columns(2)->schema([
                TextInput::make('cta_label')->helperText('Defaults to "Estimate Your Loan".'),
                TextInput::make('cta_url')->helperText('Defaults to /calculator.'),
            ])->collapsible(),
            Section::make('Publishing')->columns(3)->schema([
                Toggle::make('is_published')->default(true),
                DateTimePicker::make('published_at')->default(now()),
            ]),
            Section::make('SEO')->columns(1)->collapsed()->schema([
                TextInput::make('seo_title'),
                Textarea::make('seo_description')->rows(2),
            ]),
        ]);
    }
}
