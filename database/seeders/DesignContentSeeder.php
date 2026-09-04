<?php

namespace Database\Seeders;

use App\Models\Branch;
use App\Models\InterestRateScheme;
use App\Models\JobOpening;
use App\Models\MenuItem;
use App\Models\NewsItem;
use App\Models\Page;
use App\Models\Policy;
use App\Models\Post;
use App\Models\Setting;
use App\Support\Settings;
use Illuminate\Database\Seeder;
use Illuminate\Support\Carbon;

/**
 * Seeds the editable content that mirrors the original static design:
 * every menu page, the navigation tree, site settings, and a handful of
 * sample collection records. Idempotent — safe to re-run.
 */
class DesignContentSeeder extends Seeder
{
    public function run(): void
    {
        $this->seedSettings();
        $this->seedPages();
        $this->seedMenu();
        $this->seedCollections();

        Settings::flush();
    }

    /* ---------------------------------------------------------------- settings */

    protected function seedSettings(): void
    {
        $flat = [
            'site' => [
                'site.company'    => config('site.company'),
                'site.short_name' => config('site.short_name'),
                'site.tagline'    => config('site.tagline'),
                'site.website'    => config('site.website'),
                'site.footer_about' => config('site.footer_about'),
                'site.footer_legal_line' => config('site.footer_legal_line'),
                'site.footer_address_heading' => config('site.footer_address_heading'),
                'site.phone_primary'       => config('site.phone_primary'),
                'site.phone_primary_tel'   => config('site.phone_primary_tel'),
                'site.phone_secondary'     => config('site.phone_secondary'),
                'site.phone_secondary_tel' => config('site.phone_secondary_tel'),
                'site.email'    => config('site.email'),
                'site.whatsapp' => config('site.whatsapp'),
                'site.address_full' => config('site.address_full'),
                'site.hours'    => config('site.hours'),
                'site.loan_disclaimer' => config('site.loan_disclaimer'),
            ],
            'social' => [
                'site.social.facebook'  => config('site.social.facebook'),
                'site.social.instagram' => config('site.social.instagram'),
                'site.social.youtube'   => config('site.social.youtube'),
                'site.social.linkedin'  => config('site.social.linkedin'),
                'site.social.x'         => config('site.social.x'),
            ],
            'app' => [
                'site.app.play_store'  => config('site.app.play_store'),
                'site.app.apple_store' => config('site.app.apple_store'),
            ],
            'calculator' => [
                'site.calculator.gold_rate_per_gram'    => config('site.calculator.gold_rate_per_gram'),
                'site.calculator.max_ltv_percent'       => config('site.calculator.max_ltv_percent'),
                'site.calculator.default_interest_pa'   => config('site.calculator.default_interest_pa'),
                'site.calculator.default_tenure_months' => config('site.calculator.default_tenure_months'),
                'site.calculator.personal_loan_rate'    => config('site.calculator.personal_loan_rate'),
                'site.calculator.mahila_loan_rate'      => config('site.calculator.mahila_loan_rate'),
                'site.calculator.consumer_loan_rate'    => config('site.calculator.consumer_loan_rate'),
            ],
        ];

        // firstOrCreate, not updateOrCreate: seed the default only when the key is
        // missing, so re-running this seeder never wipes a value an admin has set
        // in Site Settings (social links, address, phone, calculator rates, …).
        foreach ($flat as $group => $pairs) {
            foreach ($pairs as $key => $value) {
                Setting::firstOrCreate(
                    ['key' => $key],
                    ['group' => $group, 'value' => ['v' => $value]],
                );
            }
        }
    }

    /* ------------------------------------------------------------------- pages */

    protected function seedPages(): void
    {
        $defs = $this->pageDefinitions();

        // Drop pages that were seeded by an earlier version and are no longer
        // defined here (e.g. the old standalone /calculator page).
        Page::whereIn('slug', ['calculator'])->delete();

        foreach ($defs as $def) {
            Page::updateOrCreate(['slug' => $def['slug']], $def);
        }
    }

    protected function pageDefinitions(): array
    {
        $loan = fn (array $o) => [
            'slug'        => 'products/'.$o['key'],
            'template'    => 'product',
            'icon'        => $o['icon'],
            'card_tag'    => $o['tag'] ?? null,
            'card_cta'    => $o['cta'] ?? null,
            'title'       => $o['h1'],
            'menu_label'  => $o['h1'],
            'seo_title'   => $o['seo'],
            'seo_description' => $o['desc'],
            'hero_eyebrow'  => $o['tagline'],
            'hero_heading'  => $o['h1'],
            'hero_lead'     => $o['lead'],
            'hero_ctas'     => [
                ['label' => 'Enquire Now', 'url' => '/contact?service='.rawurlencode($o['h1']), 'style' => 'btn--gold', 'icon' => 'arrow-right'],
                // the calculator lives only on the homepage now
                ['label' => 'Loan Calculator', 'url' => '/#calculator', 'style' => 'btn--ghost', 'icon' => 'calc'],
            ],
            'features'   => $o['why'],
            'steps'      => $o['steps'],
            'is_published' => true,
            'sort_order' => $o['sort'],
        ];

        return [
            [
                'slug' => 'home', 'template' => 'home', 'title' => 'Home', 'menu_label' => 'Home',
                'seo_title' => "Invest Gold General Finance | Kerala's Trusted NBFC Since 1996",
                'seo_description' => "Kerala's trusted, RBI-registered NBFC since 1996. Instant gold, personal, Mahila & consumer loans - trusted by 10,000+ customers.",
                'hero_eyebrow' => 'RBI-Registered NBFC · Since 1996',
                'hero_heading' => 'Trusted Finance for <span class="gold-text">Every Kerala Family</span>',
                'hero_lead' => 'Gold loans, personal loans and fixed-return investments — clear terms, quick disbursal and three decades of trust.',
                'sort_order' => 0,
            ],
            [
                'slug' => 'about', 'template' => 'standard', 'icon' => 'building', 'title' => 'About Us', 'menu_label' => 'About',
                'seo_title' => 'About Invest Gold Finance | Kerala NBFC Since 1996',
                'seo_description' => 'How Invest Gold & General Finance grew from a single Thrissur office in 1996 into a trusted, RBI-registered NBFC serving families across Kerala.',
                'hero_eyebrow' => 'Who We Are',
                'hero_heading' => 'Empowering Financial Futures <span class="gold-text">Since 1996</span>',
                'hero_lead' => 'From a single office in Urakam, Thrissur to a trusted network of branches across Kerala — three decades of lending built on clear terms and strict compliance.',
                'body' => '<p>Invest Gold &amp; General Finance Pvt. Ltd. began in 1996 in Urakam, Thrissur, founded by a group of entrepreneurs with roots in Kerala\'s lending and chit fund sectors. Originally established as Invest Chit &amp; General Finance, the company received its NBFC certification from the Reserve Bank of India in 2001 — a turning point that shifted our focus entirely to lending and set the foundation for the organisation we are today.</p><p>What started as a single office serving the Thrissur community has grown into a trusted financial partner for families across Kerala, offering gold loans, personal loans, Mahila loans, consumer loans, and fixed-return investment options like NCDs and Subordinated Debts.</p>',
                'highlights' => [
                    ['icon' => 'trend', 'title' => 'Our Vision', 'text' => 'A future where financial empowerment transforms lives and communities.'],
                    ['icon' => 'female', 'title' => 'Our Mission', 'text' => 'To empower women and farmers with innovative financial solutions that promote independence and sustainable growth.'],
                ],
                'stats' => [
                    ['value' => '10,000+', 'label' => 'Customers Served'],
                    ['value' => '30+',     'label' => 'Years Serving Kerala'],
                    ['value' => '2001',    'label' => 'RBI Certified'],
                ],
                'extra_html' => '<h2>Lending That Starts With Listening</h2>'
                    .'<p>Every customer\'s financial situation is different, and we approach lending accordingly. Rather than offering one-size-fits-all products, we take the time to understand what each customer actually needs — whether that\'s urgent cash against gold, a personal loan for a life event, or long-term support for a business or education goal — before guiding them through a simple, transparent process from application to disbursal.</p>'
                    .'<p>We operate with a few non-negotiables: clear terms with no hidden charges, decisions grounded in strict RBI compliance, and a commitment to keeping paperwork and approval times as low as possible. As Kerala\'s financial needs evolve, we continue adapting our products and services to stay relevant to the people we serve.</p>',
                'features' => [
                    '<b>RBI Registered NBFC</b> — a fully regulated, RBI-registered non-banking finance company; every product follows strict compliance and fair-practice norms.',
                    '<b>Serving Kerala Since 1996</b> — what began as a single office in Thrissur has grown into a trusted network of branches reaching families statewide.',
                    '<b>One Team, Every Need</b> — gold, personal, Mahila and consumer loans plus NCD and Subordinated Debt investments, from one partner.',
                    '<b>Transparent Terms, Always</b> — no hidden charges or fine-print surprises, and an online live passbook in the mobile app to track everything.',
                ],
                'cta_heading' => 'Talk to our team',
                'cta_text' => 'Tell us what you need and we will point you to the right product — no obligation.',
                'sort_order' => 1,
            ],
            [
                'slug' => 'products', 'template' => 'products-index', 'icon' => 'coin', 'title' => 'Products', 'menu_label' => 'Products',
                'seo_title' => 'Loan Products | Invest Gold & General Finance, Kerala',
                'seo_description' => 'Gold loans, personal loans, Mahila loans and consumer loans from an RBI-registered NBFC serving Kerala since 1996.',
                'hero_eyebrow' => 'What We Offer',
                'hero_heading' => 'Products Built Around <span class="gold-text">Real Life</span>',
                'hero_lead' => 'Four lending products, one trusted partner — each with flexible eligibility, minimal paperwork and competitive rates.',
                'cta_heading' => 'Not sure which product fits?',
                'cta_text' => 'Send us a note describing what you need — we will recommend the right option and the documents to bring.',
                'sort_order' => 2,
            ],
            $loan(['key' => 'gold-loan', 'h1' => 'Gold Loan', 'sort' => 3, 'icon' => 'coin', 'tag' => 'Popular', 'tagline' => 'Get Instant Cash Against Your Gold — Safe, Fast, Transparent',
                'seo' => 'Gold Loan in Kerala | RBI-Registered NBFC Since 1996',
                'desc' => 'Unlock the value of your gold jewellery with a secure, hassle-free gold loan. Attractive interest rates, same-day disbursal and flexible repayment options.',
                'lead' => 'Unlock the value of your gold jewellery with a secure gold loan from Invest Gold &amp; General Finance, a name Kerala has trusted for gold-backed lending. Get quick approval, minimal paperwork and same-day disbursal.',
                'why' => [
                    'Attractive interest rates — no hidden charges, ever',
                    "Maximum loan value on your gold's current market rate",
                    'Same-day disbursal with minimal documentation',
                    '100% insured vault storage with 24/7 monitoring',
                    'Flexible repayment options to suit your finances',
                ],
                'steps' => [
                    'Visit your nearest branch or request a call for service',
                    'Get your gold appraised by our trained evaluators',
                    'Receive your loan offer based on current gold value',
                    'Get instant disbursal directly to your account',
                    'Repay flexibly and reclaim your gold anytime',
                ],
            ]),
            $loan(['key' => 'personal-loan', 'h1' => 'Personal Loan', 'sort' => 4, 'icon' => 'wallet', 'tagline' => 'Fast, Flexible Personal Loans for Every Life Goal',
                'seo' => 'Personal Loan in Kerala | RBI-Registered NBFC Since 1996',
                'desc' => 'A medical emergency, a wedding or a home renovation — quick approval, minimal documentation and repayment plans that fit your budget, for salaried and self-employed alike.',
                'lead' => "Whether it's a medical emergency, a wedding or a home renovation, Invest Gold &amp; General Finance has been a trusted lending partner in Kerala since 1996. Quick approval, minimal paperwork and flexible repayment.",
                'why' => [
                    'Attractive interest rates — no hidden charges, ever',
                    'Loan amounts to suit a wide range of needs, from small expenses to major life goals',
                    'Flexible tenure options to match your repayment comfort',
                    'Fast processing with minimal documentation',
                    'Open to salaried employees and self-employed professionals',
                ],
                'steps' => [
                    'Visit your nearest branch or enquire with our team',
                    'Submit the required documents — ID, address and income proof',
                    'Get your loan offer based on your repayment capacity',
                    'Get instant disbursal directly to your account',
                    'Repay via flexible daily, weekly or monthly EMI options',
                ],
            ]),
            $loan(['key' => 'mahila-loan', 'h1' => 'Mahila Loan', 'sort' => 5, 'icon' => 'female', 'cta' => 'Start Your Mahila Loan', 'tagline' => 'Empowering Women Entrepreneurs Across Kerala',
                'seo' => 'Mahila Loan in Kerala | Loans for Women | Invest Gold NBFC',
                'desc' => 'Designed to help women start or grow a business, pursue education or achieve financial independence — with easy eligibility and supportive, subsidised terms.',
                'lead' => 'A Mahila Loan from Invest Gold &amp; General Finance is designed to help women start or grow a business, pursue education, or build financial independence — with easy eligibility and terms that genuinely support women\'s goals.',
                'why' => [
                    'Subsidised interest rates designed for women borrowers',
                    'Quick loan processing with expert guidance at every step',
                    'Flexible repayment that adapts to business or personal cash flow',
                    'Support for both first-time entrepreneurs and established women-led businesses',
                ],
                'steps' => [
                    'Visit your nearest branch or enquire about the Mahila Loan scheme',
                    'Share your business idea, education plan or purpose for the loan',
                    'Our team guides you through eligibility and documentation',
                    'Get your loan offer at subsidised, woman-focused rates',
                    'Repay on your terms: daily, weekly or monthly, aligned with your cash flow',
                ],
            ]),
            $loan(['key' => 'consumer-loan', 'h1' => 'Consumer Loan', 'sort' => 6, 'icon' => 'tv', 'tagline' => 'Buy What You Need, Pay at Your Own Pace',
                'seo' => 'Consumer Loan in Kerala | RBI-Registered NBFC Since 1996',
                'desc' => 'From appliances to electronics and more, finance your purchases with simple eligibility, competitive rates and convenient EMI options.',
                'lead' => 'From appliances to electronics and more, finance your next purchase with a consumer loan from Invest Gold &amp; General Finance. Easy eligibility, competitive rates and convenient EMI options.',
                'why' => [
                    'Attractive interest rates — no hidden charges, ever',
                    'Easy eligibility, even for those new to credit',
                    'Flexible EMI options to match your repayment comfort',
                    'Finance a wide range of consumer durables and purchases',
                    'Open to salaried, self-employed and business individuals',
                ],
                'steps' => [
                    'Visit your nearest branch or enquire with our team to check your eligibility',
                    'Share details of the product or purchase you want to finance',
                    'Submit the required documents — ID, address and income proof',
                    'Get your loan offer and approved EMI plan',
                    'Complete your purchase and repay via flexible EMI options',
                ],
            ]),
            [
                'slug' => 'investment', 'template' => 'investment-index', 'icon' => 'trend', 'title' => 'Investment', 'menu_label' => 'Investment',
                'seo_title' => 'Fixed-Return Investments | NCDs & Subordinated Debt | Invest Gold',
                'seo_description' => 'Fixed-return investment options from an RBI-registered NBFC — Non-Convertible Debentures, Subordinated Debt and the Doubling Sub-Debt Scheme.',
                'hero_eyebrow' => 'Investments',
                'hero_heading' => 'Fixed-Return Options That <span class="gold-text">Show the Numbers</span>',
                'hero_lead' => 'Predictable instruments for investors who want steady income without market volatility. Available to investors who have received a private offer from the company.',
                'hero_ctas' => [
                    ['label' => 'Enquire About Investing', 'url' => '/contact?service=NCD%20Investment', 'style' => 'btn--gold', 'icon' => 'arrow-right'],
                    ['label' => 'Interest Rates', 'url' => '/investment/interest-rates', 'style' => 'btn--ghost'],
                ],
                'body' => '<div class="section-head"><span class="eyebrow">Good to Know</span><h2>Before You <span class="gold-text">Invest</span></h2></div>'
                    .'<p>All three schemes are offered only to investors who have received a private offer from the company. Investments are accepted by cheque or account transfer only — cash is not accepted — and a duly filled application with photograph, valid KYC and PAN is required. TDS is deducted as per applicable Income Tax rules.</p>'
                    .'<blockquote>Non-Convertible Debentures are secured against company assets. Subordinated Debt and the Doubling Sub-Debt Scheme are unsecured instruments subordinated to the claims of other creditors, and carry the credit risk of the issuer. None of these instruments are government-guaranteed.</blockquote>',
                'cta_heading' => 'Request a private offer',
                'cta_text' => 'Investment schemes are offered privately. Send an enquiry and our team will walk you through eligibility, tenure options and payout modes.',
                'sort_order' => 7,
            ],
            [
                'slug' => 'investment/ncd', 'template' => 'investment-scheme', 'card_cta' => 'Explore NCD Investment', 'icon' => 'lock', 'card_tag' => 'Secured',
                'title' => 'Non-Convertible Debentures', 'menu_label' => 'Non-Convertible Debentures',
                'seo_title' => 'Non-Convertible Debentures (NCD) | Invest Gold Finance',
                'seo_description' => 'Fixed interest income with monthly or quarterly payouts, secured against company assets — a predictable way to grow savings without market risk.',
                'hero_eyebrow' => 'A Fixed-Income Investment for Steady, Predictable Growth',
                'hero_heading' => 'Non-Convertible Debentures <span class="gold-text">(NCD)</span>',
                'hero_lead' => 'Non-Convertible Debentures are secured, fixed-income instruments that offer a predictable rate of interest over a defined tenure — a stable way to grow your savings without exposure to market volatility. Unlike equity, NCDs cannot be converted into company shares. We offer NCDs as a secured redeemable debenture scheme with monthly or quarterly interest payout options.',
                'hero_ctas' => [
                    ['label' => 'Enquire Now', 'url' => '/contact?service=NCD%20Investment', 'style' => 'btn--gold', 'icon' => 'arrow-right'],
                    ['label' => 'Interest Rates', 'url' => '/investment/interest-rates', 'style' => 'btn--ghost'],
                ],
                'highlights' => [
                    ['icon' => 'lock',     'title' => 'Secured',        'text' => 'Secured against company assets'],
                    ['icon' => 'calendar', 'title' => 'Fixed Tenure',   'text' => 'Choose from defined tenure options'],
                    ['icon' => 'rupee',    'title' => 'Regular Payout', 'text' => 'Monthly or quarterly payout'],
                    ['icon' => 'users',    'title' => 'Transferable',   'text' => 'Transferable with company approval'],
                ],
                'body' => '<div class="section-head"><span class="eyebrow">NCD vs Fixed Deposit</span><h2>What Makes an NCD Different from a Fixed Deposit?</h2></div>'
                    .'<p>Both are fixed-return instruments, but NCDs are typically structured with defined interest slabs by tenure and are transferable to a third party with company approval — an option not usually available with a bank FD.</p>'
                    .'<p>NCDs are secured against company assets, offering a defined recourse structure, though — like any fixed-income instrument — they carry the credit risk of the issuer and are not government-guaranteed.</p>',
                'steps' => [
                    'Available only to investors who have received a private offer from the company',
                    'Investment can be made only via cheque or account transfer — cash is not accepted',
                    'A duly filled application with photo, valid KYC and PAN is required',
                    'Interest is paid out monthly or quarterly, as per your chosen option',
                    'On maturity, your principal is refunded by cheque or account transfer',
                    'TDS is deducted as per applicable IT rules',
                ],
                'cta_heading' => 'Interested in an NCD?',
                'cta_text' => 'Send an enquiry and our investment desk will share the current tenure and payout options available to you.',
                'sort_order' => 8,
            ],
            [
                'slug' => 'investment/subordinated-debt', 'template' => 'investment-scheme', 'card_cta' => 'Explore Subordinated Debt', 'icon' => 'calendar', 'card_tag' => '5-Year Term',
                'title' => 'Subordinated Debt', 'menu_label' => 'Subordinated Debt',
                'seo_title' => 'Subordinated Debt Investment | Invest Gold Finance',
                'seo_description' => 'Fixed monthly interest payout over a 5-year term — built for long-term investors seeking reliable, predictable income from a proven lender.',
                'hero_eyebrow' => 'A Long-Term Investment for Steady, Fixed Monthly Income',
                'hero_heading' => 'Subordinated <span class="gold-text">Debt</span>',
                'hero_lead' => 'Subordinated Debt offers a fixed monthly interest payout over a 5-year term, making it a reliable way to grow your savings with predictable, regular income. Funds raised through this scheme support the company\'s long-term growth and lending activities, including gold loans and other secured and unsecured lending across Kerala. It is issued as a non-marketable certificate and, being an unsecured instrument, is subordinated to the claims of other creditors.',
                'hero_ctas' => [
                    ['label' => 'Enquire Now', 'url' => '/contact?service=SD%20Investment', 'style' => 'btn--gold', 'icon' => 'arrow-right'],
                ],
                'highlights' => [
                    ['icon' => 'calendar', 'title' => 'Fixed Tenure',              'text' => 'Fixed tenure — 60 or 72 months'],
                    ['icon' => 'rupee',    'title' => 'Regular Payout',            'text' => 'Monthly, quarterly, yearly or on maturity'],
                    ['icon' => 'doc',      'title' => 'Non-Marketable Certificate','text' => 'Non-marketable certificate'],
                    ['icon' => 'shield',   'title' => 'Banking Channel Only',      'text' => 'Cheque or account transfer only'],
                ],
                'features' => [
                    '<b>Security:</b> Subordinated Debt is unsecured; NCDs are secured against company assets',
                    '<b>Repayment priority:</b> In a claims scenario, Subordinated Debt is repaid after other creditors, including NCD holders',
                    '<b>Tenure:</b> Fixed at 60 months, with no option for early redemption',
                    '<b>Interest:</b> Monthly, quarterly, yearly or on maturity — your choice at the time of investment',
                ],
                'steps' => [
                    'Investment can be made only via cheque or account transfer — cash is not accepted',
                    'A duly filled application with photo, valid KYC and PAN is required',
                    'On maturity, your principal is refunded by cheque or account transfer',
                    'TDS is deducted as per applicable IT rules',
                    'The investment cannot be redeemed before the end of the 60-month term',
                ],
                'cta_heading' => 'Planning a 5-year income stream?',
                'cta_text' => 'Our investment desk will explain payout modes, documentation and the certificate you receive.',
                'sort_order' => 9,
            ],
            [
                'slug' => 'investment/doubling-scheme', 'template' => 'investment-scheme', 'card_cta' => 'Explore the Doubling Scheme', 'icon' => 'trend', 'card_tag' => '2x Target', 'featured' => true,
                'title' => 'Doubling Sub-Debt Scheme', 'menu_label' => 'Doubling Sub-Debt Scheme',
                'seo_title' => 'Doubling Sub-Debt Scheme | Invest Gold Finance',
                'seo_description' => 'A 72-month plan that states your target maturity benefit — 2x your investment — right on your certificate from day one.',
                'hero_eyebrow' => 'Double Your Investment in 72 Months',
                'hero_heading' => 'Doubling <span class="gold-text">Sub-Debt Scheme</span>',
                'hero_lead' => 'A 72-month subordinated debt investment designed for investors who want a clear, long-horizon target rather than short-term market tracking. Your certificate states your investment amount, tenure and target maturity benefit in writing — so you know exactly what you are working toward from day one.',
                'hero_ctas' => [
                    ['label' => 'Enquire Now', 'url' => '/contact?service=Doubling%20Investment', 'style' => 'btn--gold', 'icon' => 'arrow-right'],
                    ['label' => 'About Subordinated Debt', 'url' => '/investment/subordinated-debt', 'style' => 'btn--ghost'],
                ],
                'highlights' => [
                    ['icon' => 'calendar', 'title' => '72-Month Tenure',    'text' => '72-month tenure, 60-month lock-in'],
                    ['icon' => 'rupee',    'title' => 'Investment Range',   'text' => 'Invest ₹10,000 – ₹1 Crore'],
                    ['icon' => 'trend',    'title' => '2x Maturity Benefit','text' => 'Target benefit stated in writing'],
                    ['icon' => 'doc',      'title' => 'Taxation',           'text' => 'TDS as per applicable IT rules'],
                ],
                'steps' => [
                    'Invest any amount between ₹10,000 and ₹1 Crore through an approved banking channel — cheque or account transfer only; cash is not accepted',
                    'A duly filled application with photo, valid KYC and PAN is required',
                    'Your certificate confirms your investment amount, tenure and target maturity benefit',
                    'The 60-month lock-in period applies from the date of investment',
                    'After 60 months, premature exit is permitted as per prevailing policy — benefit may vary from the full-term target',
                    'At 72 months the scheme matures and your principal plus target benefit is paid by cheque or account transfer',
                    'TDS is deducted as per applicable IT rules',
                ],
                'cta_heading' => 'See the numbers before you commit',
                'cta_text' => 'Your certificate states the target maturity benefit in writing from day one. Enquire to receive the current offer document.',
                'sort_order' => 10,
            ],
            [
                'slug' => 'investment/interest-rates', 'template' => 'interest-rates', 'icon' => 'chart',
                'title' => 'Interest Rates', 'menu_label' => 'Interest Rates',
                'seo_title' => 'Interest Rates | Loans & Investments | Invest Gold Finance',
                'seo_description' => 'Rate card for gold, personal, Mahila and consumer loans and for NCD, Subordinated Debt and the Doubling Sub-Debt Scheme.',
                'hero_eyebrow' => 'Rate Card',
                'hero_heading' => 'Interest Rates for <span class="gold-text">Every Scheme</span>',
                'hero_lead' => 'Select a scheme to see its detailed rate structure. Rates are reviewed periodically — the figures published at your branch on the day of transaction are final.',
                'hero_ctas' => [
                    ['label' => 'Open the Calculator', 'url' => '/#calculator', 'style' => 'btn--gold', 'icon' => 'calc'],
                    ['label' => 'Confirm at a Branch', 'url' => '/branches', 'style' => 'btn--ghost'],
                ],
                'body' => 'Rates shown are indicative and subject to periodic revision. Interest rate slabs may be applied '
                    .'retrospectively from the pledge date or the last up-to-date interest payment date. Please confirm the '
                    .'applicable rate at your nearest branch before transacting.',
                'cta_heading' => 'Want an exact figure?',
                'cta_text' => 'Our branch team will confirm today\'s applicable rate for your scheme, tenure and amount.',
                'sort_order' => 11,
            ],
            [
                'slug' => 'news', 'template' => 'news-index', 'icon' => 'building', 'title' => 'News & Media', 'menu_label' => 'News & Media',
                'seo_title' => 'News & Media | Invest Gold & General Finance',
                'seo_description' => 'Branch launches, community initiatives, customer awareness drives and company milestones from across Kerala.',
                'hero_eyebrow' => "What's Happening at Invest Gold",
                'hero_heading' => 'News, Events &amp; <span class="gold-text">Media</span>',
                'hero_lead' => 'Branch launches, community initiatives, customer awareness drives and company milestones from across Kerala.',
                'cta_heading' => 'Covering Invest Gold?',
                'cta_text' => 'For press kits, spokesperson availability or event photography, get in touch with our communications desk.',
                'sort_order' => 13,
            ],
            [
                'slug' => 'blog', 'template' => 'blog-index', 'icon' => 'doc', 'title' => 'Blog', 'menu_label' => 'Blog',
                'seo_title' => 'Blog | Invest Gold & General Finance',
                'seo_description' => 'Practical articles on gold loans, investment schemes and everyday personal finance from Kerala\'s trusted NBFC.',
                'hero_eyebrow' => 'From the Invest Gold Desk',
                'hero_heading' => 'Finance Tips &amp; <span class="gold-text">Insights</span>',
                'hero_lead' => 'Practical articles on gold loans, investment schemes and everyday personal finance — written by the people who handle these questions at our branches daily.',
                'cta_heading' => 'Have a question we should answer?',
                'cta_text' => 'Tell us what you would like explained and we will cover it in an upcoming article.',
                'sort_order' => 14,
            ],
            [
                'slug' => 'careers', 'template' => 'careers-index', 'icon' => 'briefcase', 'title' => 'Careers', 'menu_label' => 'Careers',
                'seo_title' => 'Careers | Invest Gold & General Finance',
                'seo_description' => 'Join a growing, RBI-registered NBFC in Kerala. Current openings across branches and head office.',
                'hero_eyebrow' => 'Where Your Career Finds Purpose',
                'hero_heading' => 'Build Your Career <span class="gold-text">With Us</span>',
                'hero_lead' => 'At Invest Gold &amp; General Finance, every role plays a part in a legacy of trust that spans three decades. Come build a career that grows as you do.',
                'hero_ctas' => [
                    ['label' => 'See Open Roles', 'url' => '#openings', 'style' => 'btn--gold', 'icon' => 'arrow-right'],
                    ['label' => 'About the Company', 'url' => '/about', 'style' => 'btn--ghost'],
                ],
                'highlights' => [
                    ['icon' => 'award',    'title' => 'A 30-Year Name',       'text' => 'Work for an RBI-registered NBFC that families across Kerala already know and trust.'],
                    ['icon' => 'trend',    'title' => 'Room to Grow',         'text' => 'Branch teams are promoted from within — appraisers and executives regularly grow into management roles.'],
                    ['icon' => 'users',    'title' => 'Real Customer Impact', 'text' => "Every approval you handle funds a business, an education or a family's urgent need."],
                    ['icon' => 'building', 'title' => 'Close to Home',        'text' => 'A growing branch network across Kerala means opportunities near where you live.'],
                ],
                'cta_heading' => "Don't see your role?",
                'cta_text' => 'Send us your CV anyway — we keep strong applications on file and reach out when a matching position opens.',
                'sort_order' => 15,
            ],
            [
                'slug' => 'policies', 'template' => 'policies', 'icon' => 'doc', 'title' => 'Policies & Disclosures', 'menu_label' => 'Downloads',
                'seo_title' => 'Policies & Regulatory Disclosures | Invest Gold Finance',
                'seo_description' => 'Fair Practice Code, grievance redressal, KYC/AML, interest-rate policy and other regulatory disclosures.',
                'hero_eyebrow' => 'Transparency',
                'hero_heading' => 'Policies & <span class="gold-text">Disclosures</span>',
                'hero_lead' => 'Our regulatory policies and customer-facing disclosures, available to download or view.',
                'body' => '<p>Invest Gold &amp; General Finance is a non-banking financial company registered with the Reserve Bank of India. That registration carries obligations — about how we price a loan, how we treat a pledged ornament, what we tell you before you sign, and how quickly we must answer a complaint. The policies on this page are how we meet them.</p>'
                    .'<p>Each one is approved by our Board and reviewed periodically against current RBI directions. Where a policy changes, the revised document replaces the old one here and at every branch.</p>'
                    .'<h3>What our policies cover</h3><ul>'
                    .'<li><b>Fair Practice Code</b> — how we advertise, appraise, sanction and recover, in plain language: the application process, the terms we disclose up front, and the conduct expected of every branch.</li>'
                    .'<li><b>Grievance Redressal</b> — a defined path for complaints, from the branch to our Nodal Officer, and on to the RBI Ombudsman if you are not satisfied within 30 days.</li>'
                    .'<li><b>KYC &amp; Anti-Money Laundering</b> — the identity and address documents we are required to collect, how long we retain them, and the safeguards applied to customer records under the PML Act.</li>'
                    .'<li><b>Interest Rate Policy</b> — the factors that set the rate on your loan, including tenure, loan-to-value, repayment record and cost of funds, along with our approach to penal charges and rate revisions.</li>'
                    .'<li><b>Auction of Pledged Gold</b> — the notice period, publication and reserve-price rules we follow before any ornament is auctioned, and how surplus proceeds are returned to the borrower.</li>'
                    .'<li><b>Privacy &amp; Data Protection</b> — what personal data we collect, why we hold it, who we may share it with, and your rights to access or correct your records.</li></ul>'
                    .'<h3>What you can expect from us</h3><p>These commitments apply at every branch, on every product, regardless of loan size.</p><ul>'
                    .'<li>Written terms before disbursal, with all charges stated up front and nothing added later.</li>'
                    .'<li>Your pledged gold stored in insured, tamper-evident packaging and returned in the same condition.</li>'
                    .'<li>Clear advance notice before any auction, with the reserve price and date published.</li>'
                    .'<li>An acknowledged complaint reference and a named person responsible for closing it.</li>'
                    .'<li>No canvassing, no coercive recovery practice, and no contact outside reasonable hours.</li></ul>',
                'extra_html' => '<p>Documents shown are the current Board-approved versions. Where a policy is revised, the updated file replaces the old one here and at every branch. For a certified copy, contact our compliance team.</p>',
                'cta_heading' => 'Need a document that is not listed?',
                'cta_text' => 'Write to us and our compliance team will share the relevant policy or certificate.',
                'sort_order' => 16,
            ],
            [
                'slug' => 'contact', 'template' => 'contact', 'icon' => 'mail', 'title' => 'Contact Us', 'menu_label' => 'Contact Us',
                'seo_title' => 'Contact Invest Gold & General Finance | Thrissur, Kerala',
                'seo_description' => 'Reach our head office in Urakam, Thrissur, or send an enquiry — our team will get in touch.',
                'hero_eyebrow' => 'Get in Touch',
                'hero_heading' => 'Reach Out — <span class="gold-text">We\'re Ready to Help</span>',
                'hero_lead' => 'Have a question or need assistance? Call us, message us on WhatsApp, fill out the form below, or find your nearest branch across Kerala.',
                'hero_ctas' => [
                    ['label' => '+91 7034 000 444', 'url' => 'tel:+917034000444', 'style' => 'btn--gold', 'icon' => 'phone'],
                    ['label' => 'WhatsApp Us', 'url' => 'https://wa.me/919074523723', 'style' => 'btn--ghost'],
                    ['label' => 'Find a Branch', 'url' => '#branches', 'style' => 'btn--ghost'],
                ],
                'cta_heading' => 'Prefer to speak to someone?',
                'cta_text' => 'Our team is available Monday to Saturday, 9:30 AM to 5:30 PM.',
                'sort_order' => 17,
            ],
            [
                'slug' => 'branches', 'template' => 'branch', 'icon' => 'pin', 'title' => 'Branch Locator', 'menu_label' => 'Branch',
                'seo_title' => 'Branch Locator | Invest Gold & General Finance, Kerala',
                'seo_description' => 'Find your nearest Invest Gold branch across Kerala — addresses, phone numbers and working hours.',
                'hero_eyebrow' => 'Branch Network',
                'hero_heading' => 'Find a Branch <span class="gold-text">Near You</span>',
                'hero_lead' => 'Invest Gold has a growing presence across Kerala. Search by branch name or city — the list filters as you type.',
                'cta_heading' => 'Have a question or need assistance?',
                'cta_text' => 'Send an enquiry and our team will get back to you the same working day.',
                'sort_order' => 18,
            ],
        ];
    }

    protected function infoPage(string $slug, string $template, string $title, string $eyebrow, int $sort, string $seoTitle, string $seoDesc, string $lead): array
    {
        return [
            'slug' => $slug, 'template' => $template, 'icon' => 'chart', 'title' => $title, 'menu_label' => $title,
            'seo_title' => $seoTitle, 'seo_description' => $seoDesc,
            'hero_eyebrow' => $eyebrow, 'hero_heading' => $title, 'hero_lead' => $lead,
            'sort_order' => $sort,
        ];
    }

    /* -------------------------------------------------------------------- menu */

    protected function seedMenu(): void
    {
        $tree = [
            ['label' => 'Home', 'slug' => 'home'],
            ['label' => 'About', 'slug' => 'about'],
            ['label' => 'Products', 'slug' => 'products', 'children' => [
                ['label' => 'Gold Loan', 'slug' => 'products/gold-loan'],
                ['label' => 'Personal Loan', 'slug' => 'products/personal-loan'],
                ['label' => 'Mahila Loan', 'slug' => 'products/mahila-loan'],
                ['label' => 'Consumer Loan', 'slug' => 'products/consumer-loan'],
            ]],
            ['label' => 'Investment', 'slug' => 'investment', 'children' => [
                ['label' => 'Non-Convertible Debentures', 'slug' => 'investment/ncd'],
                ['label' => 'Subordinated Debt', 'slug' => 'investment/subordinated-debt'],
                ['label' => 'Doubling Sub-Debt Scheme', 'slug' => 'investment/doubling-scheme'],
                ['label' => 'Interest Rates', 'slug' => 'investment/interest-rates'],
            ]],
            ['label' => 'News & Media', 'slug' => 'news'],
            ['label' => 'Blog', 'slug' => 'blog'],
            ['label' => 'Careers', 'slug' => 'careers'],
            ['label' => 'Downloads', 'slug' => 'policies'],
            ['label' => 'Contact Us', 'slug' => 'contact'],
        ];

        $footer = [
            ['label' => 'Products', 'children' => [
                ['label' => 'Gold Loan', 'slug' => 'products/gold-loan'],
                ['label' => 'Personal Loan', 'slug' => 'products/personal-loan'],
                ['label' => 'Mahila Loan', 'slug' => 'products/mahila-loan'],
                ['label' => 'Consumer Loan', 'slug' => 'products/consumer-loan'],
                ['label' => 'Loan Calculator', 'url' => '/#calculator'],
            ]],
            ['label' => 'Company', 'children' => [
                ['label' => 'About Us', 'slug' => 'about'],
                ['label' => 'Investments', 'slug' => 'investment'],
                ['label' => 'News & Media', 'slug' => 'news'],
                ['label' => 'Blog', 'slug' => 'blog'],
                ['label' => 'Careers', 'slug' => 'careers'],
                ['label' => 'Branch Locator', 'slug' => 'branches'],
                ['label' => 'Downloads', 'slug' => 'policies'],
            ]],
        ];

        foreach (['header' => $tree, 'footer' => $footer] as $menu => $nodes) {
            $order = 0;
            foreach ($nodes as $node) {
                $parent = MenuItem::updateOrCreate(
                    ['menu' => $menu, 'label' => $node['label'], 'parent_id' => null],
                    [
                        'page_id'    => isset($node['slug']) ? Page::where('slug', $node['slug'])->value('id') : null,
                        'url'        => $node['url'] ?? null,
                        'sort_order' => $order++,
                        'is_active'  => true,
                    ],
                );

                $childOrder = 0;
                foreach ($node['children'] ?? [] as $child) {
                    MenuItem::updateOrCreate(
                        ['menu' => $menu, 'label' => $child['label'], 'parent_id' => $parent->id],
                        [
                            'page_id'    => isset($child['slug']) ? Page::where('slug', $child['slug'])->value('id') : null,
                            'url'        => $child['url'] ?? null,
                            'sort_order' => $childOrder++,
                            'is_active'  => true,
                        ],
                    );
                }
            }
        }
    }

    /* ------------------------------------------------------------- collections */

    protected function seedCollections(): void
    {
        // Six articles mirroring the design's blog.html grid.
        $posts = [
            ['How Gold Loan Interest Slabs Actually Work', 'how-gold-loan-interest-slabs-work', 'Gold Loans',
                'Understanding pledge dates, interest servicing and why paying on time keeps you at the base slab of your scheme.'],
            ["NCD vs Fixed Deposit: What's the Difference?", 'ncd-vs-fixed-deposit', 'Investing',
                'Both are fixed-return instruments — here is how security, tenure slabs, transferability and risk compare.'],
            ['Five Steps to Funding Your First Business', 'five-steps-to-funding-your-first-business', 'Women & Business',
                'From documenting your idea to choosing a repayment rhythm that matches your cash flow.'],
            ['What Happens to Your Gold After You Pledge It', 'what-happens-to-your-gold-after-you-pledge-it', 'Gold Loans',
                'Appraisal, sealed packeting, insured vault storage and exactly how ornaments are returned.'],
            ['Choosing Between a Gold Loan and a Personal Loan', 'gold-loan-vs-personal-loan', 'Personal Finance',
                'Speed, documentation, cost and collateral — a practical comparison for an urgent requirement.'],
            ['Using the Live Passbook in the Invest Gold App', 'using-the-live-passbook', 'Digital',
                'Track balances, check interest due and pay from home instead of travelling to a branch.'],
        ];
        $bodies = $this->blogBodies();
        Post::whereNotIn('slug', array_column($posts, 1))->delete();
        foreach ($posts as $i => [$title, $slug, $cat, $excerpt]) {
            Post::updateOrCreate(['slug' => $slug], [
                'title' => $title, 'category' => $cat, 'excerpt' => $excerpt,
                'body' => $bodies[$slug] ?? "<p>{$excerpt}</p>",
                'author' => 'Invest Gold Team', 'read_time' => (4 + $i).' min read',
                'cover_image' => null, 'banner_image' => null,
                'is_published' => true, 'published_at' => Carbon::now()->subDays(14 * ($i + 1)),
            ]);
        }

        // Six items mirroring the design's news.html grid.
        $news = [
            ['news', 'New Branch Opens in Kunnamkulam', 'new-branch-kunnamkulam',
                'Our newest branch brings gold loans, Mahila loans and investment services closer to families in the Kunnamkulam region.'],
            ['event', 'Mahila Entrepreneurship Meet, Thrissur', 'mahila-entrepreneurship-meet-thrissur',
                'Over 200 women entrepreneurs joined our annual meet for sessions on business planning, credit readiness and growth funding.'],
            ['news', 'Three Decades of Trusted Lending', 'three-decades-of-trusted-lending',
                'From a single Urakam office in 1996 to a statewide network — a look back at the milestones that shaped Invest Gold.'],
            ['media', 'Invest Gold Mobile App Crosses 25,000 Downloads', 'mobile-app-25000-downloads',
                'The live passbook and in-app interest payment have quickly become the most used features across our customer base.'],
            ['news', 'Customer Awareness Drive on Safe Gold Lending', 'customer-awareness-drive-safe-gold-lending',
                'Branch teams across Thrissur district ran sessions on appraisal transparency, interest servicing and reclaiming pledged ornaments.'],
            ['news', 'Vault Security Upgrade Completed', 'vault-security-upgrade-completed',
                'All branches now operate upgraded, fully insured vaults with 24/7 monitoring for pledged ornaments.'],
        ];
        NewsItem::whereNotIn('slug', array_column($news, 2))->delete();
        foreach ($news as $i => [$kind, $title, $slug, $summary]) {
            NewsItem::updateOrCreate(['slug' => $slug], [
                'kind' => $kind, 'title' => $title, 'summary' => $summary,
                'body' => "<p>{$summary}</p><p>The full write-up can be edited from the admin panel.</p>",
                'cover_image' => null, 'banner_image' => null,
                'is_published' => true, 'published_at' => Carbon::now()->subDays(21 * ($i + 1)),
            ]);
        }

        // The event item gets the full detail-page treatment (metarow + gallery + CTA).
        NewsItem::where('slug', 'mahila-entrepreneurship-meet-thrissur')->update([
            'event_date' => '2026-01-28',
            'event_time' => '10:00 AM – 4:00 PM',
            'location'   => 'Invest Complex, Urakam, Thrissur',
            'organizer'  => 'Invest Gold & General Finance',
            'body' => '<p>More than 200 women entrepreneurs from across Thrissur district joined the 2026 edition of our Mahila '
                .'Entrepreneurship Meet — a full-day programme built around one question we hear constantly at our branches: '
                .'what does it actually take to fund a small business and keep it funded?</p>'
                .'<p>The morning sessions covered business planning fundamentals, how lenders read a repayment case, and the '
                .'documentation that speeds up a Mahila Loan application. In the afternoon, existing customers who have grown '
                .'tailoring units, food-processing ventures and retail shops shared what worked and what they would do differently, '
                .'followed by an open desk where our branch managers reviewed individual proposals.</p>'
                .'<h2>What the day covered</h2><ul>'
                .'<li>Building a simple, credible business plan for a first loan application</li>'
                .'<li>Understanding eligibility, documentation and subsidised Mahila Loan terms</li>'
                .'<li>Matching repayment rhythm — daily, weekly or monthly — to real business cash flow</li>'
                .'<li>Digital tools: tracking your loan and paying interest through the Invest Gold app</li>'
                .'<li>One-to-one proposal reviews with branch managers</li></ul>'
                .'<blockquote>“The mentorship and business support helped me confidently grow my dream into reality — and the '
                .'repayment schedule was built around how my shop actually earns.”</blockquote>',
            'gallery' => [
                ['image' => null, 'caption' => 'Opening session'],
                ['image' => null, 'caption' => 'Panel discussion'],
                ['image' => null, 'caption' => 'Customer stories'],
                ['image' => null, 'caption' => 'Event highlights video'],
                ['image' => null, 'caption' => 'Felicitation ceremony'],
            ],
            'cta_label' => 'Enquire About Mahila Loans',
            'cta_url'   => '/contact?service=Mahila%20Loan',
        ]);

        // Six roles mirroring the design's careers.html grid.
        $jobs = [
            ['Branch Manager', 'branch-manager', 'Operations', 'Thrissur', 'Full-time', '5+ years experience', '₹4.2 – ₹6.5 LPA'],
            ['Gold Appraiser', 'gold-appraiser', 'Valuation', 'Guruvayur', 'Full-time', '2+ years experience', '₹2.4 – ₹3.6 LPA'],
            ['Relationship Executive', 'relationship-executive', 'Sales', 'Kunnamkulam', 'Full-time', '1+ year experience', '₹2.0 – ₹3.0 LPA'],
            ['Accounts Officer', 'accounts-officer', 'Finance', 'Head Office, Urakam', 'Full-time', '3+ years experience', '₹3.0 – ₹4.5 LPA'],
            ['Field Officer — Mahila Loans', 'field-officer-mahila-loans', 'Sales', 'Thrissur district', 'Full-time', 'Freshers welcome', '₹1.8 – ₹2.6 LPA'],
            ['Customer Support Executive', 'customer-support-executive', 'Customer Service', 'Head Office, Urakam', 'Full-time', '1+ year experience', '₹1.8 – ₹2.8 LPA'],
        ];
        $jobDetails = $this->jobDetails();
        $offer = [
            'Competitive salary with performance incentives',
            'Clear promotion path within a growing statewide branch network',
            'Structured training on products, compliance and conduct',
        ];
        JobOpening::whereNotIn('slug', array_column($jobs, 1))->delete();
        foreach ($jobs as $i => [$title, $slug, $dept, $loc, $type, $exp, $salary]) {
            $d = $jobDetails[$slug] ?? [];
            JobOpening::updateOrCreate(['slug' => $slug], [
                'title' => $title, 'department' => $dept, 'location' => $loc,
                'employment_type' => $type, 'experience' => $exp, 'salary_range' => $salary,
                'summary' => $d['summary'] ?? "We are hiring a {$title} for our {$loc} operations.",
                'description' => $d['description'] ?? null,
                'responsibilities' => $d['responsibilities'] ?? null,
                'requirements' => $d['requirements'] ?? null,
                'benefits' => $d['benefits'] ?? $offer,
                'is_open' => true, 'posted_at' => Carbon::now()->subDays(10 * ($i + 1)),
            ]);
        }

        $branches = [
            ['Urakam (Head Office)', 'Invest Complex, Urakam PO', 'Thrissur', 'Thrissur', '680562', '+91 7034 000 444'],
            ['Thrissur Town', 'Near Swaraj Round', 'Thrissur', 'Thrissur', '680001', '+91 90745 23723'],
            ['Irinjalakuda', 'Main Road, Irinjalakuda', 'Irinjalakuda', 'Thrissur', '680121', '+91 90745 23724'],
            ['Guruvayur', 'East Nada, Guruvayur', 'Guruvayur', 'Thrissur', '680101', '+91 90745 23725'],
            ['Kunnamkulam', 'Wadakkanchery Road', 'Kunnamkulam', 'Thrissur', '680503', '+91 90745 23726'],
            ['Chavakkad', 'Beach Road, Chavakkad', 'Chavakkad', 'Thrissur', '680506', '+91 90745 23727'],
        ];
        Branch::whereNotIn('name', array_column($branches, 0))->delete();
        foreach ($branches as $i => [$name, $addr, $city, $district, $pin, $phone]) {
            Branch::updateOrCreate(['name' => $name], [
                'address' => $addr, 'city' => $city, 'district' => $district, 'state' => 'Kerala',
                'pincode' => $pin, 'phone' => $phone, 'hours' => 'Mon–Sat · 9:30 AM – 5:30 PM',
                'is_active' => true, 'sort_order' => $i,
            ]);
        }

        // Full document list from the design's policies.html #downloads list,
        // in the same interleaved download / view-only order.
        // [title, file (under assets/docs/), access, icon (view rows), size label]
        $policies = [
            ['Fair Practice Code', 'fair-practice-code.pdf', 'download', 'download', 'PDF · 220 KB'],
            ['Certificate of Registration &mdash; RBI', 'view/rbi-certificate-of-registration.pdf', 'view_only', 'shield', null],
            ['Grievance Redressal Policy', 'grievance-redressal-policy.pdf', 'download', 'download', 'PDF · 190 KB'],
            ['Most Important Terms &amp; Conditions (MITC)', 'view/most-important-terms-and-conditions.pdf', 'view_only', 'doc', null],
            ['Interest Rate Policy', 'interest-rate-policy.pdf', 'download', 'download', 'PDF · 165 KB'],
            ['RBI Ombudsman Scheme &mdash; Branch Notice', 'view/ombudsman-scheme-notice.pdf', 'view_only', 'users', null],
            ['KYC &amp; Anti-Money Laundering Policy', 'kyc-aml-policy.pdf', 'download', 'download', 'PDF · 240 KB'],
            ['Customer Grievance Escalation Matrix', 'view/grievance-escalation-matrix.pdf', 'view_only', 'chart', null],
            ['Policy on Auction of Pledged Gold Ornaments', 'gold-auction-policy.pdf', 'download', 'download', 'PDF · 205 KB'],
            ['Statutory Auditor Declaration', 'view/statutory-auditor-declaration.pdf', 'view_only', 'award', null],
            ['Privacy &amp; Data Protection Policy', 'privacy-policy.pdf', 'download', 'download', 'PDF · 155 KB'],
            ['KYC Document Checklist', 'kyc-document-checklist.pdf', 'download', 'download', 'PDF · 145 KB'],
        ];
        Policy::whereNotIn('title', array_column($policies, 0))->delete();
        foreach ($policies as $i => [$title, $file, $access, $icon, $size]) {
            $relPath = 'assets/docs/'.$file;
            $full = public_path($relPath);
            $label = $access === 'view_only'
                ? null
                : ($size ?? (is_file($full) ? 'PDF · '.max(1, (int) ceil(filesize($full) / 1024)).' KB' : 'PDF'));

            Policy::updateOrCreate(['title' => $title], [
                'description' => null, 'category' => 'Policies',
                'file_path' => $relPath, 'access' => $access, 'icon' => $icon,
                'file_size_label' => $label, 'sort_order' => $i, 'is_active' => true,
            ]);
        }

        // Structure mirrors the design's interest-rates.html. Rate cells are "X"
        // placeholders — the design carries a developer note to replace each
        // table with the official published rate card before launch.
        $schemes = [
            [
                'title' => 'Gold Loan', 'icon' => 'coin',
                'columns' => ['Scheme', 'Loan per gram', 'Interest p.a.', 'Tenure'],
                'rows' => [
                    ['IG Classic',   'Up to ₹X per gram', 'X% p.a.', '12 months'],
                    ['IG Express',   'Up to ₹X per gram', 'X% p.a.', '6 months'],
                    ['IG Long Term', 'Up to ₹X per gram', 'X% p.a.', '24 months'],
                ],
                'note' => 'Slabs apply retrospectively from the pledge date; monthly interest servicing keeps you at the base slab.',
            ],
            [
                'title' => 'Personal Loan', 'icon' => 'wallet',
                'columns' => ['Category', 'Loan amount', 'Interest p.a.', 'Repayment'],
                'rows' => [
                    ['Salaried',      '₹X – ₹X', 'X% p.a.', 'Daily / weekly / monthly'],
                    ['Self-employed', '₹X – ₹X', 'X% p.a.', 'Daily / weekly / monthly'],
                ],
                'note' => 'Final rate depends on assessed repayment capacity and documentation.',
            ],
            [
                'title' => 'Mahila Loan', 'icon' => 'female',
                'columns' => ['Purpose', 'Loan amount', 'Interest p.a.', 'Repayment'],
                'rows' => [
                    ['Business start-up',  '₹X – ₹X', 'X% p.a.', 'Aligned to cash flow'],
                    ['Business expansion', '₹X – ₹X', 'X% p.a.', 'Aligned to cash flow'],
                    ['Education',          '₹X – ₹X', 'X% p.a.', 'Monthly'],
                ],
                'note' => 'Subsidised rates for women borrowers; guidance provided at every step.',
            ],
            [
                'title' => 'Consumer Loan', 'icon' => 'tv',
                'columns' => ['Product type', 'Finance up to', 'Interest p.a.', 'EMI tenure'],
                'rows' => [
                    ['Home appliances', 'X% of invoice', 'X% p.a.', '6 – 24 months'],
                    ['Electronics',     'X% of invoice', 'X% p.a.', '6 – 24 months'],
                ],
                'note' => 'Open to salaried, self-employed and business individuals — including those new to credit.',
            ],
            [
                'title' => 'Non-Convertible Debentures', 'icon' => 'lock',
                'columns' => ['Tenure', 'Payout', 'Interest p.a.', 'Minimum'],
                'rows' => [
                    ['X months', 'Monthly',   'X% p.a.', '₹X'],
                    ['X months', 'Quarterly', 'X% p.a.', '₹X'],
                ],
                'note' => 'Offered only to investors holding a private offer. Secured against company assets.',
            ],
            [
                'title' => 'Subordinated Debt', 'icon' => 'calendar',
                'columns' => ['Tenure', 'Payout', 'Interest p.a.', 'Minimum'],
                'rows' => [
                    ['60 months', 'Monthly / quarterly / yearly / maturity', 'X% p.a.', '₹25,000'],
                    ['72 months', 'Monthly / quarterly / yearly / maturity', 'X% p.a.', '₹25,000'],
                ],
                'note' => 'Unsecured instrument, subordinated to other creditors. No early redemption before 60 months.',
            ],
            [
                'title' => 'Doubling Sub-Debt Scheme', 'icon' => 'trend',
                'columns' => ['Tenure', 'Investment range', 'Target benefit', 'Lock-in'],
                'rows' => [
                    ['72 months', '₹10,000 – ₹1 Crore', '2x investment', '60 months'],
                ],
                'note' => '2x target maturity benefit stated on the certificate. 60-month lock-in.',
            ],
        ];

        // Drop the earlier placeholder rows that used made-up numbers.
        InterestRateScheme::whereIn('title', ['Gold Loan — interest slabs', 'Investments — indicative returns'])->delete();

        foreach ($schemes as $i => $s) {
            InterestRateScheme::updateOrCreate(
                ['title' => $s['title']],
                $s + ['subtitle' => null, 'is_active' => true, 'sort_order' => $i],
            );
        }
    }

    /** @return array<string,string> full article HTML keyed by slug. Only the first is the design's copy; the rest are placeholder write-ups. */
    protected function blogBodies(): array
    {
        return [
        'how-gold-loan-interest-slabs-work' =>
            '<p>A gold loan looks simple from the outside: you pledge ornaments, you receive cash, you repay and take '
                .'the ornaments back. The part that surprises borrowers most often is not the headline rate — it is how the '
                .'applicable rate is decided at the end, and why two customers who borrowed the same amount can repay different totals.</p>'
                .'<h2>Slabs are decided by time, not just by scheme</h2>'
                .'<p>Most gold loan schemes publish an interest rate against a slab, and the slab you land in depends on how many '
                .'days have passed since the pledge date — or since your last up-to-date interest payment, whichever is later. In '
                .'scheme documents this is the figure written as “D”. The longer interest goes unserviced, the higher the slab your loan moves into.</p>'
                .'<h2>The retrospective bit</h2>'
                .'<p>Here is the detail worth understanding before you borrow: when a loan moves into a higher slab, that higher rate '
                .'is generally applied retrospectively — from the pledge date or from your last up-to-date interest payment date, not '
                .'just from the day the slab changed. This is why a loan left untouched for many months can settle at a noticeably '
                .'higher figure than the base rate suggested.</p>'
                .'<blockquote>Servicing interest monthly is the single most effective thing you can do to keep a gold loan at the base slab of its scheme.</blockquote>'
                .'<h2>Coming back down</h2>'
                .'<p>The relationship is not one-way. In general, once the borrower remits the interest accrued in full, the loan is '
                .'shifted back to the original interest rate at which it was availed. Regular monthly servicing keeps the applicable '
                .'rate at the base slab of the scheme throughout the tenure.</p>'
                .'<h2>Three practical habits</h2><ul>'
                .'<li><b>Pay interest monthly.</b> Use the live passbook in the Invest Gold app so you never have to guess what is due.</li>'
                .'<li><b>Note your pledge date.</b> Every slab calculation counts from it, so keep it visible.</li>'
                .'<li><b>Ask for the full slab table.</b> Any branch will show you the applicable rate for each slab before you sign.</li></ul>'
                .'<p>If you would like the exact figures for your loan, our branch team can print your current position — pledge date, '
                .'interest accrued and the slab you are in — in a couple of minutes.</p>',

        'ncd-vs-fixed-deposit' =>
            '<p>Both a Non-Convertible Debenture and a bank fixed deposit promise a fixed return over a set term. For an '
                .'investor who wants steady income without market swings, either can do the job — but the structure around '
                .'them differs in ways worth knowing before you commit.</p>'
                .'<h2>Security and recourse</h2>'
                .'<p>Our NCDs are issued as secured redeemable debentures, backed by company assets, which gives holders a '
                .'defined recourse structure. A bank FD is covered by deposit insurance up to the prescribed limit. In both '
                .'cases you are lending to an institution and taking its credit risk; neither is government-guaranteed beyond '
                .'those specific protections.</p>'
                .'<h2>Tenure, payout and transfer</h2>'
                .'<p>NCDs are typically structured with defined interest slabs by tenure and pay out monthly or quarterly. '
                .'Unlike a bank FD, an NCD can usually be transferred to a third party with company approval — useful if your '
                .'plans change before maturity.</p>'
                .'<blockquote>An NCD suits an investor who wants a fixed, regular payout and values the option to transfer the '
                .'holding; an FD suits someone who prizes the simplicity and insurance cover of a bank product.</blockquote>'
                .'<h2>Before you invest</h2>'
                .'<p>Our investment schemes are offered only to investors who have received a private offer from the company. '
                .'Investments are accepted by cheque or account transfer, a completed application with photo, valid KYC and PAN '
                .'is required, and TDS is deducted as per applicable Income Tax rules. Speak to our investment desk for the '
                .'current tenure and rate options.</p>',

        'five-steps-to-funding-your-first-business' =>
            '<p>Funding a first business is less about a single big loan and more about being ready — with a plan a lender can '
                .'read, the right documents, and a repayment rhythm that matches how the business actually earns. Here is the '
                .'path our branch teams walk new borrowers through.</p>'
                .'<h2>1. Put the idea on paper</h2>'
                .'<p>A short, credible business plan — what you sell, to whom, what it costs to run, and what you expect to '
                .'earn — is what turns a conversation into an application. It does not need to be long; it needs to be honest.</p>'
                .'<h2>2. Get the paperwork together</h2>'
                .'<p>ID and address proof, and evidence of income or business activity, are the basics. For a Mahila Loan, our '
                .'team guides you through eligibility and the subsidised terms available to women borrowers.</p>'
                .'<h2>3. Match repayment to cash flow</h2>'
                .'<p>Retail and food businesses often earn daily; a tailoring unit may earn in bursts around seasons. Choose a '
                .'daily, weekly or monthly instalment that fits the pattern rather than fighting it.</p>'
                .'<h2>4. Use the digital tools</h2>'
                .'<p>Track your loan and pay interest through the Invest Gold app, so servicing never depends on a branch visit.</p>'
                .'<h2>5. Review and grow</h2>'
                .'<p>Once the first loan is running cleanly, a top-up or a larger facility for expansion is a much shorter '
                .'conversation. Bring your proposal to any branch and our managers will review it with you.</p>',

        'what-happens-to-your-gold-after-you-pledge-it' =>
            '<p>When you pledge ornaments for a gold loan, they leave your hands for the length of the loan — so it is fair '
                .'to want to know exactly what happens to them, and how they come back.</p>'
                .'<h2>Appraisal</h2>'
                .'<p>Trained evaluators assess the net gold weight after deducting stones and non-gold parts, and the purity — '
                .'22K, 21K, 18K or 24K equivalent. The loan you are eligible for is based on that appraised value and the '
                .'prevailing rate per gram on the day of pledge, capped in line with RBI norms.</p>'
                .'<h2>Storage</h2>'
                .'<p>Once the loan is disbursed, your ornaments are sealed in tamper-evident packaging and held in 100% insured '
                .'vaults with 24/7 monitoring. They are not worn, tested destructively or separated from your packet.</p>'
                .'<blockquote>Your pledged gold is returned in the same condition it was received, against settlement of the '
                .'loan — you can reclaim it at any time within the tenure.</blockquote>'
                .'<h2>Getting it back</h2>'
                .'<p>Clear the outstanding principal and interest and the sealed packet is returned to you at the branch, '
                .'checked against the original appraisal record in front of you.</p>',

        'gold-loan-vs-personal-loan' =>
            '<p>When money is needed quickly, the choice often comes down to a gold loan or a personal loan. Both are '
                .'available from Invest Gold; which fits depends on speed, paperwork, cost and whether you have gold to pledge.</p>'
                .'<h2>Speed and paperwork</h2>'
                .'<p>A gold loan is typically the faster route: the ornament is the security, appraisal takes minutes and '
                .'disbursal is often same-day with minimal documentation. A personal loan needs ID, address and income proof, '
                .'and the offer is based on an assessment of your repayment capacity.</p>'
                .'<h2>Cost and collateral</h2>'
                .'<p>Because it is secured, a gold loan usually carries a lower rate — but you must have gold to pledge, and '
                .'the applicable rate can move with repayment timing. A personal loan needs no collateral and suits salaried '
                .'and self-employed borrowers alike, with flexible tenure options.</p>'
                .'<h2>A simple rule of thumb</h2>'
                .'<ul><li>Have gold and want the lowest cost and fastest cash? A gold loan.</li>'
                .'<li>No gold to pledge, or want to keep ornaments untouched? A personal loan.</li></ul>'
                .'<p>Our branch team can run both options for your amount and tenure so you can compare the EMI side by side.</p>',

        'using-the-live-passbook' =>
            '<p>The live passbook in the Invest Gold app is built around one idea: you should be able to see where your loan '
                .'stands, and act on it, without travelling to a branch.</p>'
                .'<h2>See your position</h2>'
                .'<p>Outstanding principal, interest accrued to date and the next amount due are all on one screen, updated in '
                .'real time — no guessing what is payable this month.</p>'
                .'<h2>Pay from home</h2>'
                .'<p>Service your interest directly from the app. Regular monthly servicing is also what keeps a gold loan at '
                .'the base slab of its scheme, so paying on time protects your rate as well as your schedule.</p>'
                .'<h2>Keep records</h2>'
                .'<p>Every payment is receipted in the app, so your history is always to hand if you need it at a branch.</p>'
                .'<p>Download the app, log in with your registered mobile number, and your active loans appear automatically.</p>',
        ];
    }

    /**
     * Full role descriptions, keyed by job slug. The Branch Manager copy is
     * taken verbatim from the design's job-detail.html; the rest are written in
     * the same voice so every opening has a complete detail page.
     */
    protected function jobDetails(): array
    {
        return [
            'branch-manager' => [
                'summary' => 'Own the loan book, the team, the customer experience and the compliance record for your branch.',
                'description' => '<p>As Branch Manager you own everything that happens at your branch — the loan book, the team, '
                    .'the customer experience and the compliance record. You will lead a small team of appraisers and '
                    .'relationship executives, approve gold and personal loan proposals within your authority, and be the person '
                    .'customers ask for when something needs a decision.</p>',
                'responsibilities' => [
                    'Lead daily branch operations, cash management and vault procedures',
                    'Review and approve loan proposals within delegated authority, maintaining portfolio quality',
                    'Coach appraisers and executives on valuation accuracy, documentation and customer handling',
                    "Grow the branch's gold, personal, Mahila and consumer loan book against monthly targets",
                    'Ensure strict adherence to RBI norms, KYC requirements and internal audit standards',
                    'Resolve escalated customer queries and maintain relationships with key local customers',
                ],
                'requirements' => [
                    '5+ years in NBFC, banking or gold loan operations, with at least 2 in a supervisory role',
                    'Sound understanding of gold appraisal, loan documentation and recovery practice',
                    'Graduate in any discipline; a finance or commerce background is an advantage',
                    'Fluency in Malayalam and working English',
                    'A clean compliance record and strong local customer orientation',
                ],
            ],
            'gold-appraiser' => [
                'summary' => 'Value pledged ornaments accurately and fairly, and keep every gold loan disbursal audit-ready.',
                'description' => '<p>The Gold Appraiser is the technical heart of the branch. You assess the purity and net weight of '
                    .'ornaments customers bring in, arrive at a fair loan value, and make sure every packet is sealed, '
                    .'photographed and recorded correctly before it goes into the vault.</p>',
                'responsibilities' => [
                    'Test purity by touchstone and acid, and record net weight after deductions',
                    'Calculate eligible loan value using the current rate card and LTV limits',
                    'Seal, label and photograph each pledged packet and log it into the system',
                    'Support the Branch Manager during periodic vault audits and surprise checks',
                ],
                'requirements' => [
                    '2+ years appraising gold in an NBFC, bank or jewellery setting',
                    'Confident with touchstone testing and weight-deduction practice',
                    'Careful, honest and comfortable explaining a valuation to a customer',
                ],
            ],
            'relationship-executive' => [
                'summary' => 'Be the first face customers meet — explain the products, complete the paperwork, and follow up.',
                'description' => '<p>As a Relationship Executive you own the customer conversation from walk-in to disbursal. You '
                    .'explain which loan fits, collect and check KYC, complete the documentation, and stay in touch through the '
                    .'life of the loan so renewals and repayments happen on time.</p>',
                'responsibilities' => [
                    'Greet walk-in customers and explain gold, personal, Mahila and consumer loan options',
                    'Collect and verify KYC and complete loan documentation accurately',
                    'Follow up on interest servicing, renewals and gentle recovery calls',
                    'Support local outreach activity to bring in new customers',
                ],
                'requirements' => [
                    '1+ year in sales, collections or front-desk work, ideally in financial services',
                    'Clear spoken Malayalam and a friendly, patient manner',
                    'Plus two or graduate; basic computer comfort',
                ],
            ],
            'accounts-officer' => [
                'summary' => 'Keep the books clean, the reconciliations current and the statutory filings on schedule.',
                'description' => '<p>The Accounts Officer keeps Head Office finance running. You handle daily branch reconciliations, '
                    .'maintain ledgers, prepare data for GST and TDS filings, and support the annual audit.</p>',
                'responsibilities' => [
                    'Reconcile branch cash, bank and loan ledgers daily',
                    'Maintain books of account and prepare monthly MIS for management',
                    'Compile working data for GST, TDS and other statutory returns',
                    'Assist statutory and internal auditors with schedules and explanations',
                ],
                'requirements' => [
                    '3+ years in an accounts role, preferably in an NBFC or finance company',
                    'B.Com or M.Com; working knowledge of Tally and Excel',
                    'Familiarity with GST and TDS compliance',
                ],
            ],
            'field-officer-mahila-loans' => [
                'summary' => 'Take the Mahila loan programme to women entrepreneurs across Thrissur district.',
                'description' => '<p>This is a field role focused on our Mahila loan programme. You will meet women running small '
                    .'businesses and self-help groups, explain how the loan works, help them apply, and stay connected through '
                    .'repayment. Freshers with the right attitude are welcome — we train you on the product and the process.</p>',
                'responsibilities' => [
                    'Visit local markets, SHGs and women-run businesses to introduce the Mahila loan',
                    'Help applicants complete KYC and documentation on the spot',
                    'Track repayments in your area and make courtesy follow-up visits',
                    'Report field feedback so we can improve the product',
                ],
                'requirements' => [
                    'Freshers welcome; any field or sales exposure is a plus',
                    'Two-wheeler and licence, and willingness to travel within the district',
                    'Fluent Malayalam and genuine comfort working with women customers',
                ],
            ],
            'customer-support-executive' => [
                'summary' => 'Answer calls, app queries and branch escalations with accurate, patient help.',
                'description' => '<p>The Customer Support Executive is the voice of Invest Gold between branches and customers. You '
                    .'handle phone and app queries about balances, due dates, renewals and the passbook feature, and route '
                    .'anything that needs a branch to the right person.</p>',
                'responsibilities' => [
                    'Respond to phone and in-app queries about loans, payments and the app',
                    'Log every interaction and follow up until the customer has an answer',
                    'Coordinate with branches on escalations and pending documentation',
                    'Share recurring issues with the team so we can fix root causes',
                ],
                'requirements' => [
                    '1+ year in a call centre, help desk or branch support role',
                    'Clear Malayalam and English, and a calm phone manner',
                    'Comfortable using a computer and a ticketing or CRM system',
                ],
            ],
        ];
    }
}
