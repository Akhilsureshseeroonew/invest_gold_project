<?php

namespace App\Filament\Resources\Pages\Schemas;

use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Repeater;
use Filament\Forms\Components\RichEditor;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Components\Grid;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Components\Tabs;
use Filament\Schemas\Schema;
use Illuminate\Support\Str;

class PageForm
{
    public const TEMPLATES = [
        'home'             => 'Home (one-page)',
        'standard'         => 'Standard content page',
        'products-index'   => 'Products — overview (auto-lists child pages)',
        'product'          => 'Product / loan page',
        'investment-index' => 'Investment — overview (auto-lists child pages)',
        'investment-scheme' => 'Investment — single scheme (glance + steps)',
        'blog-index'       => 'Blog — listing',
        'news-index'       => 'News & Media — listing',
        'careers-index'    => 'Careers — listing',
        'branch'           => 'Branch locator',
        'calculator'       => 'Calculator',
        'policies'         => 'Policies & disclosures',
        'interest-rates'   => 'Interest rates',
        'contact'          => 'Contact',
    ];

    public static function configure(Schema $schema): Schema
    {
        return $schema->components([
            Tabs::make()->columnSpanFull()->tabs([

                Tabs\Tab::make('Content')->schema([
                    Grid::make(2)->schema([
                        TextInput::make('title')
                            ->required()
                            ->live(onBlur: true)
                            ->afterStateUpdated(function ($state, $get, $set) {
                                if (blank($get('slug'))) {
                                    $set('slug', Str::slug($state));
                                }
                            }),
                        TextInput::make('slug')
                            ->required()
                            ->helperText('URL path. Use "home" for the front page; slashes allowed, e.g. products/gold-loan.')
                            ->rule('regex:/^[a-z0-9\-\/]+$/'),
                    ]),
                    Grid::make(3)->schema([
                        Select::make('template')
                            ->options(self::TEMPLATES)
                            ->required()
                            ->default('standard')
                            ->native(false),
                        TextInput::make('menu_label')
                            ->helperText('Short label for menus; defaults to the title.'),
                        TextInput::make('icon')
                            ->helperText('Sprite id (e.g. coin, wallet, lock) — used on overview cards.'),
                    ]),
                    Grid::make(3)->schema([
                        TextInput::make('card_tag')
                            ->label('Card badge')
                            ->helperText('Short badge on the parent overview card, e.g. "Secured", "Popular".'),
                        TextInput::make('card_cta')
                            ->label('Card link text')
                            ->helperText('Link label on the parent overview card. Defaults to "Explore <title>".'),
                        Toggle::make('featured')
                            ->helperText('Highlights this card on the parent overview page.'),
                    ]),
                    RichEditor::make('body')
                        ->columnSpanFull()
                        ->toolbarButtons([
                            'bold', 'italic', 'underline', 'strike', 'link',
                            'h2', 'h3', 'bulletList', 'orderedList', 'blockquote', 'undo', 'redo',
                        ]),
                ]),

                Tabs\Tab::make('Hero')->schema([
                    TextInput::make('hero_eyebrow'),
                    TextInput::make('hero_heading')
                        ->helperText('May contain <span class="gold-text">…</span> for the gold accent.'),
                    Textarea::make('hero_lead')->rows(3),
                    Repeater::make('hero_ctas')
                        ->label('Call-to-action buttons')
                        ->schema([
                            Grid::make(3)->schema([
                                TextInput::make('label')->required(),
                                TextInput::make('url')->required(),
                                Select::make('style')->options([
                                    'btn--gold'  => 'Gold (primary)',
                                    'btn--ghost' => 'Ghost (outline)',
                                ])->default('btn--gold')->native(false),
                            ]),
                        ])
                        ->addActionLabel('Add button')
                        ->reorderable()
                        ->collapsible()
                        ->defaultItems(0),
                ]),

                Tabs\Tab::make('Blocks')->schema([
                    Section::make('“Why choose us” checklist')->schema([
                        Repeater::make('features')
                            ->hiddenLabel()
                            ->simple(TextInput::make('item')->required())
                            ->addActionLabel('Add point')
                            ->reorderable()
                            ->defaultItems(0),
                    ])->collapsible(),
                    Section::make('“How it works” steps')->schema([
                        Repeater::make('steps')
                            ->hiddenLabel()
                            ->simple(TextInput::make('item')->required())
                            ->addActionLabel('Add step')
                            ->reorderable()
                            ->defaultItems(0),
                    ])->collapsible(),
                    Section::make('Highlight cards')->schema([
                        Repeater::make('highlights')
                            ->hiddenLabel()
                            ->schema([
                                Grid::make(3)->schema([
                                    TextInput::make('icon')->helperText('Sprite id, e.g. shield, trend, clock'),
                                    TextInput::make('title')->required(),
                                    TextInput::make('text')->required(),
                                ]),
                            ])
                            ->addActionLabel('Add card')
                            ->reorderable()
                            ->defaultItems(0),
                    ])->collapsible(),
                    Section::make('Stat strip')->schema([
                        Repeater::make('stats')
                            ->hiddenLabel()
                            ->schema([
                                Grid::make(2)->schema([
                                    TextInput::make('value')->required()->helperText('e.g. 10,000+  ·  30+  ·  2001'),
                                    TextInput::make('label')->required()->helperText('e.g. Customers Served'),
                                ]),
                            ])
                            ->addActionLabel('Add stat')
                            ->reorderable()
                            ->defaultItems(0),
                    ])->collapsible(),
                    RichEditor::make('extra_html')
                        ->label('Extra section (free-form)')
                        ->columnSpanFull(),
                    Section::make('Closing call-to-action')->schema([
                        TextInput::make('cta_heading')->helperText('Overrides the default band heading.'),
                        Textarea::make('cta_text')->rows(2),
                    ])->collapsible(),
                ]),

                Tabs\Tab::make('SEO')->schema([
                    TextInput::make('seo_title')
                        ->helperText('Defaults to the page title if left blank.'),
                    Textarea::make('seo_description')->rows(3),
                    FileUpload::make('og_image')
                        ->image()
                        ->disk('public')->directory('pages/og')->visibility('public')
                        ->helperText('Social share image.'),
                ]),

                Tabs\Tab::make('Settings')->schema([
                    Toggle::make('is_published')->default(true),
                    TextInput::make('sort_order')->numeric()->default(0),
                ]),
            ]),
        ]);
    }
}
