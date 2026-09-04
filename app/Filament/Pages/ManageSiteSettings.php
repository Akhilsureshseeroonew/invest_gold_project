<?php

namespace App\Filament\Pages;

use App\Support\Settings;
use BackedEnum;
use Filament\Actions\Action;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Forms\Contracts\HasForms;
use Filament\Notifications\Notification;
use Filament\Pages\Page;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Components\Tabs;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use UnitEnum;

class ManageSiteSettings extends Page implements HasForms
{
    use InteractsWithForms;

    protected string $view = 'filament.pages.manage-site-settings';

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedCog6Tooth;

    protected static string|UnitEnum|null $navigationGroup = 'Settings';

    protected static ?int $navigationSort = 90;

    protected static ?string $title = 'Site Settings';

    /**
     * form field key => config() path it maps onto (also the settings row key).
     */
    protected const FIELDS = [
        'company'             => 'site.company',
        'short_name'          => 'site.short_name',
        'tagline'             => 'site.tagline',
        'website'             => 'site.website',
        'footer_about'        => 'site.footer_about',
        'footer_legal_line'   => 'site.footer_legal_line',
        'footer_address_heading' => 'site.footer_address_heading',
        'phone_primary'       => 'site.phone_primary',
        'phone_primary_tel'   => 'site.phone_primary_tel',
        'phone_secondary'     => 'site.phone_secondary',
        'phone_secondary_tel' => 'site.phone_secondary_tel',
        'email'               => 'site.email',
        'whatsapp'            => 'site.whatsapp',
        'address_full'        => 'site.address_full',
        'hours'               => 'site.hours',
        'loan_disclaimer'     => 'site.loan_disclaimer',
        'social_facebook'     => 'site.social.facebook',
        'social_instagram'    => 'site.social.instagram',
        'social_youtube'      => 'site.social.youtube',
        'social_linkedin'     => 'site.social.linkedin',
        'social_x'            => 'site.social.x',
        'app_play_store'      => 'site.app.play_store',
        'app_apple_store'     => 'site.app.apple_store',
        'calc_gold_rate'      => 'site.calculator.gold_rate_per_gram',
        'calc_max_ltv'        => 'site.calculator.max_ltv_percent',
        'calc_interest'       => 'site.calculator.default_interest_pa',
        'calc_tenure'         => 'site.calculator.default_tenure_months',
        'calc_personal_rate'  => 'site.calculator.personal_loan_rate',
        'calc_mahila_rate'    => 'site.calculator.mahila_loan_rate',
        'calc_consumer_rate'  => 'site.calculator.consumer_loan_rate',
    ];

    public ?array $data = [];

    public function mount(): void
    {
        $state = [];
        foreach (self::FIELDS as $key => $path) {
            $state[$key] = Settings::get($path, config($path));
        }
        $this->form->fill($state);
    }

    public function form(Schema $schema): Schema
    {
        return $schema
            ->statePath('data')
            ->components([
                Tabs::make()->tabs([
                    Tabs\Tab::make('General')->schema([
                        TextInput::make('company')->label('Legal company name')->required(),
                        TextInput::make('short_name')->required(),
                        TextInput::make('tagline'),
                        TextInput::make('website')->url(),
                        Textarea::make('footer_about')->label('Footer blurb')->rows(2),
                        TextInput::make('footer_legal_line')
                            ->label('Footer bottom line')
                            ->helperText('Small print beside the copyright, e.g. RBI registration note. Leave blank to hide.'),
                    ]),
                    Tabs\Tab::make('Contact')->schema([
                        TextInput::make('phone_primary')->label('Phone (display)'),
                        TextInput::make('phone_primary_tel')->label('Phone (tel: link)')->helperText('Digits only, with country code — e.g. 917034000444'),
                        TextInput::make('phone_secondary')->label('Second phone (display)'),
                        TextInput::make('phone_secondary_tel')->label('Second phone (tel: link)'),
                        TextInput::make('email')->email(),
                        TextInput::make('whatsapp')->label('WhatsApp number')->helperText('Digits only, with country code.'),
                        TextInput::make('footer_address_heading')
                            ->label('Address heading')
                            ->helperText('Heading above the address in the footer and contact card — e.g. "Head Office".'),
                        Textarea::make('address_full')
                            ->label('Address')
                            ->rows(3)
                            ->helperText('One line per row. The footer and contact card break the address on these lines.'),
                        TextInput::make('hours')->label('Working hours'),
                    ]),
                    Tabs\Tab::make('Legal')->schema([
                        Textarea::make('loan_disclaimer')
                            ->label('Loan-page disclaimer')
                            ->rows(8)
                            ->helperText('Shown in the "Disclaimer" section at the foot of every product / loan page. Separate paragraphs with a blank line.'),
                    ]),
                    Tabs\Tab::make('Social')->schema([
                        TextInput::make('social_facebook')->label('Facebook URL')
                            ->placeholder('https://facebook.com/yourpage')
                            ->helperText('Paste the full profile link for each network. Leave a field blank to hide that icon on the site — "https://" is added automatically if you omit it.'),
                        TextInput::make('social_instagram')->label('Instagram URL')->placeholder('https://instagram.com/yourhandle'),
                        TextInput::make('social_youtube')->label('YouTube URL')->placeholder('https://youtube.com/@yourchannel'),
                        TextInput::make('social_linkedin')->label('LinkedIn URL')->placeholder('https://linkedin.com/company/…'),
                        TextInput::make('social_x')->label('X / Twitter URL')->placeholder('https://x.com/yourhandle'),
                    ]),
                    Tabs\Tab::make('Mobile App')->schema([
                        TextInput::make('app_play_store')->label('Google Play URL')
                            ->placeholder('https://play.google.com/store/apps/details?id=…')
                            ->helperText('Store listing links for the "Invest Gold Mobile App" section on the home page. Leave blank to hide that store button. "https://" is added automatically if you omit it.'),
                        TextInput::make('app_apple_store')->label('App Store URL')
                            ->placeholder('https://apps.apple.com/app/id…'),
                    ]),
                    Tabs\Tab::make('Calculator defaults')->schema([
                        Section::make('Gold Loan calculator')->columns(2)->schema([
                            TextInput::make('calc_gold_rate')->label('Gold rate per gram (22K, ₹)')->numeric(),
                            TextInput::make('calc_max_ltv')->label('Max loan-to-value (%)')->numeric(),
                            TextInput::make('calc_interest')->label('Interest p.a. (%)')->numeric(),
                            TextInput::make('calc_tenure')->label('Default tenure (months)')->numeric(),
                        ]),
                        Section::make('EMI calculator — interest p.a. (%)')
                            ->description('Starting rate on the EMI calculator for each unsecured loan. Visitors can still move the slider.')
                            ->columns(3)
                            ->schema([
                                TextInput::make('calc_personal_rate')->label('Personal Loan')->numeric()->suffix('%'),
                                TextInput::make('calc_mahila_rate')->label('Mahila Loan')->numeric()->suffix('%'),
                                TextInput::make('calc_consumer_rate')->label('Consumer Loan')->numeric()->suffix('%'),
                            ]),
                    ]),
                ]),
            ]);
    }

    public function save(): void
    {
        $state = $this->form->getState();

        foreach (self::FIELDS as $key => $path) {
            $isUrl = str_starts_with($path, 'site.social.') || str_starts_with($path, 'site.app.');
            $group = str_starts_with($path, 'site.calculator.') ? 'calculator'
                : (str_starts_with($path, 'site.social.') ? 'social'
                : (str_starts_with($path, 'site.app.') ? 'app' : 'site'));

            $value = $state[$key] ?? null;
            if ($isUrl) {
                $value = \App\Support\Site::normalizeUrl($value);
            }

            Settings::put($group, $path, $value);
        }

        Notification::make()->title('Settings saved')->success()->send();
    }

    protected function getFormActions(): array
    {
        return [
            Action::make('save')->label('Save changes')->submit('save'),
        ];
    }
}
