<?php

namespace App\Filament\Pages;

use App\Support\Homepage;
use App\Support\Settings;
use BackedEnum;
use Filament\Actions\Action;
use Filament\Forms\Components\Repeater;
use Filament\Forms\Components\RichEditor;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Forms\Contracts\HasForms;
use Filament\Notifications\Notification;
use Filament\Pages\Page;
use Filament\Schemas\Components\Grid;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Components\Tabs;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use UnitEnum;

class ManageHomepage extends Page implements HasForms
{
    use InteractsWithForms;

    protected string $view = 'filament.pages.manage-site-settings';

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedHome;
    protected static string|UnitEnum|null $navigationGroup = 'Content';
    protected static ?int $navigationSort = 3;
    protected static ?string $title = 'Home Page';

    /** form field name (`section__key`)  =>  dot path under config/home.php */
    protected const FIELDS = [
        'hero__eyebrow' => 'hero.eyebrow',
        'hero__heading' => 'hero.heading',
        'hero__lead' => 'hero.lead',
        'hero__cta1_label' => 'hero.cta1_label',
        'hero__cta1_url' => 'hero.cta1_url',
        'hero__cta2_label' => 'hero.cta2_label',
        'hero__cta2_url' => 'hero.cta2_url',

        'about__heading' => 'about.heading',
        'about__body' => 'about.body',
        'about__cta_label' => 'about.cta_label',
        'about__cards' => 'about.cards',
        'about__stats' => 'about.stats',

        'products__eyebrow' => 'products.eyebrow',
        'products__heading' => 'products.heading',
        'products__sub' => 'products.sub',
        'investments__eyebrow' => 'investments.eyebrow',
        'investments__heading' => 'investments.heading',
        'investments__sub' => 'investments.sub',
        'calculator__eyebrow' => 'calculator.eyebrow',
        'calculator__heading' => 'calculator.heading',
        'calculator__sub' => 'calculator.sub',
        'news__eyebrow' => 'news.eyebrow',
        'news__heading' => 'news.heading',
        'news__sub' => 'news.sub',
        'contact__eyebrow' => 'contact.eyebrow',
        'contact__heading' => 'contact.heading',
        'contact__sub' => 'contact.sub',
        'testimonials__eyebrow' => 'testimonials.eyebrow',
        'testimonials__heading' => 'testimonials.heading',
        'testimonials__sub' => 'testimonials.sub',
        'faq__eyebrow' => 'faq.eyebrow',
        'faq__heading' => 'faq.heading',

        'why__eyebrow' => 'why.eyebrow',
        'why__heading' => 'why.heading',
        'why__sub' => 'why.sub',
        'why__cards' => 'why.cards',
        'why__badges' => 'why.badges',

        'app__eyebrow' => 'app.eyebrow',
        'app__heading' => 'app.heading',
        'app__lead' => 'app.lead',
        'app__download_heading' => 'app.download_heading',
        'app__features' => 'app.features',
    ];

    public ?array $data = [];

    public function mount(): void
    {
        $home = Homepage::all();
        $state = [];
        foreach (self::FIELDS as $key => $path) {
            $state[$key] = data_get($home, $path);
        }
        $this->form->fill($state);
    }

    protected function iconTitleText(): array
    {
        return [
            TextInput::make('icon')->helperText('Sprite id, e.g. shield, users, building, trend, award, doc'),
            TextInput::make('title')->required(),
            TextInput::make('text')->required(),
        ];
    }

    public function form(Schema $schema): Schema
    {
        return $schema
            ->statePath('data')
            ->components([
                Tabs::make()->columnSpanFull()->tabs([

                    Tabs\Tab::make('Hero')->schema([
                        TextInput::make('hero__eyebrow'),
                        TextInput::make('hero__heading')->helperText('May contain <span class="gold-text">…</span>.'),
                        Textarea::make('hero__lead')->rows(3),
                        Grid::make(4)->schema([
                            TextInput::make('hero__cta1_label')->label('Button 1 label'),
                            TextInput::make('hero__cta1_url')->label('Button 1 link'),
                            TextInput::make('hero__cta2_label')->label('Button 2 label'),
                            TextInput::make('hero__cta2_url')->label('Button 2 link'),
                        ]),
                    ]),

                    Tabs\Tab::make('About')->schema([
                        TextInput::make('about__heading'),
                        RichEditor::make('about__body')
                            ->toolbarButtons(['bold', 'italic', 'link', 'bulletList', 'undo', 'redo']),
                        TextInput::make('about__cta_label')->label('"Talk to our team" button label'),
                        Section::make('Vision / Mission / How-we-work cards')->schema([
                            Repeater::make('about__cards')->hiddenLabel()->schema([
                                Grid::make(3)->schema($this->iconTitleText()),
                            ])->reorderable()->addActionLabel('Add card')->defaultItems(0),
                        ])->collapsible(),
                        Section::make('Counter strip')->schema([
                            Repeater::make('about__stats')->hiddenLabel()->schema([
                                Grid::make(3)->schema([
                                    TextInput::make('value')->numeric()->required()->helperText('The number the counter animates to'),
                                    TextInput::make('suffix')->placeholder('+'),
                                    TextInput::make('label')->required(),
                                ]),
                            ])->reorderable()->addActionLabel('Add counter')->defaultItems(0),
                        ])->collapsible(),
                    ]),

                    Tabs\Tab::make('Section headings')
                        ->schema(collect([
                            'products' => 'Products',
                            'investments' => 'Investments',
                            'calculator' => 'Calculator',
                            'testimonials' => 'Testimonials',
                            'news' => 'News & Events',
                            'contact' => 'Get in Touch',
                        ])->map(fn ($label, $k) => Section::make($label)->columns(1)->schema([
                            Grid::make(2)->schema([
                                TextInput::make("{$k}__eyebrow")->label('Eyebrow'),
                                TextInput::make("{$k}__heading")->label('Heading'),
                            ]),
                            Textarea::make("{$k}__sub")->label('Sub-text')->rows(2),
                        ]))->values()->push(
                            Section::make('FAQ')->columns(2)->schema([
                                TextInput::make('faq__eyebrow')->label('Eyebrow'),
                                TextInput::make('faq__heading')->label('Heading'),
                            ])
                        )->all()),

                    Tabs\Tab::make('Why Choose Us')->schema([
                        TextInput::make('why__eyebrow'),
                        TextInput::make('why__heading'),
                        Textarea::make('why__sub')->rows(2),
                        Section::make('Numbered cards')->schema([
                            Repeater::make('why__cards')->hiddenLabel()->schema([
                                Grid::make(4)->schema(array_merge(
                                    [TextInput::make('num')->placeholder('01')],
                                    $this->iconTitleText(),
                                )),
                            ])->reorderable()->addActionLabel('Add card')->defaultItems(0),
                        ])->collapsible(),
                        Section::make('Trust badges')->schema([
                            Repeater::make('why__badges')->hiddenLabel()->schema([
                                Grid::make(3)->schema([
                                    TextInput::make('icon')->helperText('Sprite id'),
                                    TextInput::make('value')->required(),
                                    TextInput::make('label')->required(),
                                ]),
                            ])->reorderable()->addActionLabel('Add badge')->defaultItems(0),
                        ])->collapsible(),
                    ]),

                    Tabs\Tab::make('Mobile App')->schema([
                        TextInput::make('app__eyebrow'),
                        TextInput::make('app__heading'),
                        Textarea::make('app__lead')->rows(3),
                        TextInput::make('app__download_heading')->label('"Download now" heading'),
                        Section::make('Feature checklist')->schema([
                            Repeater::make('app__features')->hiddenLabel()
                                ->simple(TextInput::make('item')->required())
                                ->reorderable()->addActionLabel('Add point')->defaultItems(0),
                        ])->collapsible(),
                    ]),
                ]),
            ]);
    }

    public function save(): void
    {
        $state = $this->form->getState();

        foreach (self::FIELDS as $key => $path) {
            Settings::put('home', 'home.'.$path, $state[$key] ?? null);
        }

        Notification::make()->title('Home page saved')->success()->send();
    }

    protected function getFormActions(): array
    {
        return [
            Action::make('save')->label('Save changes')->submit('save'),
        ];
    }
}
