<?php

/*
|--------------------------------------------------------------------------
| Home-page content (defaults)
|--------------------------------------------------------------------------
| Every value here is editable in admin (Content → Home Page). Settings rows
| keyed "home.<dot.path>" override these; App\Support\Homepage merges them.
| Headings may contain <span class="gold-text">…</span> for the gold accent.
*/

return [

    'hero' => [
        'eyebrow'    => 'RBI Registered NBFC · Since 1996',
        'heading'    => 'Kerala\'s Trusted <span class="gold-text">Gold Loan</span> &amp; Finance Partner Since 1996',
        'lead'       => 'Instant gold, personal, consumer &amp; Mahila loans at attractive rates, minimal paperwork — trusted by 10,000+ customers across Kerala.',
        'cta1_label' => 'Apply Now',
        'cta1_url'   => '/contact',
        'cta2_label' => 'Explore Services',
        'cta2_url'   => '/products',
    ],

    'about' => [
        'heading'     => 'Empowering Financial Futures <span class="gold-text">Since 1996</span>',
        'body'        => '<p>Invest Gold &amp; General Finance Pvt. Ltd. began in 1996 in Urakam, Thrissur, founded by a group of entrepreneurs with roots in Kerala\'s lending and chit fund sectors. Originally established as Invest Chit &amp; General Finance, the company received its NBFC certification from the Reserve Bank of India in 2001 — a turning point that shifted our focus entirely to lending.</p>'
            .'<p>What started as a single office serving the Thrissur community has grown into a trusted financial partner for families across Kerala — offering gold loans, personal loans, Mahila loans, consumer loans, and fixed-return investment options like NCDs and Subordinated Debts.</p>',
        'cta_label'   => 'Talk to Our Team',
        'cards'       => [
            ['icon' => 'trend',  'title' => 'Our Vision',  'text' => 'A future where financial empowerment transforms lives and communities.'],
            ['icon' => 'female', 'title' => 'Our Mission', 'text' => 'To empower women and farmers with innovative financial solutions that promote independence and sustainable growth.'],
            ['icon' => 'award',  'title' => 'How We Work', 'text' => 'No one-size-fits-all products. We take time to understand what each customer actually needs before guiding them through a simple, transparent process — clear terms, no hidden charges, strict RBI compliance.'],
        ],
        'stats' => [
            ['value' => '10000', 'suffix' => '+', 'label' => 'Customers Served'],
            ['value' => '30',    'suffix' => '+', 'label' => 'Years in Kerala'],
            ['value' => '2001',  'suffix' => '',  'label' => 'RBI Certified'],
        ],
    ],

    'products' => [
        'eyebrow' => 'What We Offer',
        'heading' => 'Products Built Around <span class="gold-text">Real Life</span>',
        'sub'     => 'Four lending products, one trusted partner — each with flexible eligibility, minimal paperwork and competitive rates.',
    ],

    'investments' => [
        'eyebrow' => 'Investments',
        'heading' => 'Fixed-Return Options That <span class="gold-text">Show the Numbers</span>',
        'sub'     => 'Secured, predictable instruments for investors who want steady income without market volatility. Available through private offer.',
    ],

    'calculator' => [
        'eyebrow' => 'Instant Estimate',
        'heading' => 'Loan &amp; Investment <span class="gold-text">Calculator</span>',
        'sub'     => 'Pick a product and get an instant estimate — gold loan eligibility, the EMI on a personal, Mahila or consumer loan, or the maturity value of an NCD, Subordinated Debt or Doubling Sub-Debt investment.',
    ],

    'why' => [
        'eyebrow' => 'Why Choose Us',
        'heading' => 'What Makes Invest Gold <span class="gold-text">Kerala\'s Preferred NBFC</span>',
        'sub'     => 'From a single branch started in 1996 to a name families trust across Kerala today — here\'s what backs every loan and investment we offer.',
        'cards'   => [
            ['num' => '01', 'icon' => 'shield',   'title' => 'RBI Registered NBFC',       'text' => 'A fully regulated, RBI-registered non-banking finance company — every product follows strict compliance and fair-practice norms, so you\'re protected by more than just our word.'],
            ['num' => '02', 'icon' => 'building', 'title' => 'Serving Kerala Since 1996',  'text' => 'What began as a single office in Thrissur has grown into a trusted network of branches reaching families statewide — the same values, now closer to you.'],
            ['num' => '03', 'icon' => 'users',    'title' => 'One Team, Every Need',       'text' => 'From gold and personal loans to Mahila loans, NCDs and Subordinated Debt — a single trusted partner for both your borrowing and your savings goals.'],
            ['num' => '04', 'icon' => 'doc',      'title' => 'Transparent Terms, Always',  'text' => 'No hidden charges, no fine-print surprises. Every rate, term and repayment schedule is laid out clearly — track it all with our online live passbook on the mobile app.'],
        ],
        'badges' => [
            ['icon' => 'shield',   'value' => 'RBI',     'label' => 'Registered NBFC'],
            ['icon' => 'users',    'value' => '10,000+',  'label' => 'Happy Customers'],
            ['icon' => 'building', 'value' => 'Kerala',  'label' => 'Branches Statewide'],
        ],
    ],

    'testimonials' => [
        'eyebrow' => 'Customer Stories',
        'heading' => 'Trusted by <span class="gold-text">10,000+ Families</span>',
        'sub'     => '',
    ],

    'app' => [
        'eyebrow'          => 'Invest Gold Mobile App',
        'heading'          => 'Manage Your Loans <span class="gold-text">Anytime, Anywhere</span>',
        'lead'             => 'The Invest Gold Mobile App brings all your financial services together in one secure, easy-to-use platform. Apply for loans, manage your accounts, pay interest, track transactions and access our services from anywhere.',
        'download_heading' => 'Download Now',
        'features'         => [
            'Apply for gold, personal, Mahila &amp; consumer loans',
            'Online live passbook with real-time balances',
            'Pay interest and EMIs securely in a few taps',
            'Branch locator, gold calculator and instant support',
        ],
    ],

    'news' => [
        'eyebrow' => 'News &amp; Events',
        'heading' => 'What\'s Happening at <span class="gold-text">Invest Gold</span>',
        'sub'     => 'Branch launches, community initiatives and company milestones from across Kerala.',
    ],

    'faq' => [
        'eyebrow' => 'FAQ',
        'heading' => 'Questions, <span class="gold-text">Answered</span>',
    ],

    'contact' => [
        'eyebrow' => 'Get in Touch',
        'heading' => 'Reach Out — <span class="gold-text">We\'re Ready to Help</span>',
        'sub'     => 'Have a question or need assistance? Fill out the form and our team will get back to you shortly.',
    ],
];
