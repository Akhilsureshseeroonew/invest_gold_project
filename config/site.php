<?php

/*
|--------------------------------------------------------------------------
| Site content defaults
|--------------------------------------------------------------------------
|
| These values feed the header, footer, contact card and SEO tags. They are
| the fallback set; once the admin "Settings" panel (settings table) is in
| place, a service provider overrides these keys at runtime from the DB so
| views can keep reading config('site.*') unchanged.
|
*/

return [
    'company'    => 'Invest Gold & General Finance (P) Limited',
    'short_name' => 'Invest Gold Finance',
    'tagline'    => "Kerala's Trusted NBFC Since 1996",

    'phone_primary'       => '+91 7034 000 444',
    'phone_primary_tel'   => '+917034000444',
    'phone_secondary'     => '+91 90745 23723',
    'phone_secondary_tel' => '+919074523723',

    'email'    => 'info@investgoldfinance.com',
    'whatsapp' => '919074523723',
    'website'  => 'https://www.investgoldfinance.com',

    'address_lines' => [
        'Invest Complex, Urakam PO,',
        'Thrissur, Kerala – 680562',
    ],
    'address_full' => "Invest Complex, Urakam PO,\nThrissur, Kerala, India – 680562",
    'hours'        => 'Monday – Saturday · 9:30 AM to 5:30 PM',

    'footer_address_heading' => 'Head Office',
    'footer_legal_line'      => 'RBI-Registered NBFC · CIN & registration details available on request',

    'social' => [
        'facebook'  => '#',
        'instagram' => '#',
        'youtube'   => '#',
        'linkedin'  => '#',
        'x'         => '#',
    ],

    'footer_about' => 'An RBI-registered NBFC serving Kerala since 1996 — gold loans, '
        .'personal loans, Mahila loans, consumer loans and fixed-return investments.',

    // Regulatory disclaimer shown at the foot of every product / loan page.
    // Paragraphs are separated by a blank line.
    'loan_disclaimer' => '*"D" stands for number of days from last up-to-date payment of interest or pledge date '
        .'as the case may be; interest rate slabs will be applicable retrospectively from the pledge date or from '
        .'the last up-to-date interest payment date as the case may be.'
        ."\n\n"
        .'Also, loans will be shifted back to the original interest rate at which the loan was availed once the '
        .'borrower remits the interest accrued in full. In general, monthly servicing of interest accrued by '
        .'borrowers is required to maintain the applicable interest rate at the base slab of the scheme.',

    // Calculator defaults (calculator.html / home calculator panel)
    'calculator' => [
        'gold_rate_per_gram'    => 9200,
        'max_ltv_percent'       => 75,
        'default_interest_pa'   => 12,   // gold loan calculator
        'default_tenure_months' => 12,

        // EMI calculator — default interest p.a. per unsecured product
        'personal_loan_rate' => 16,
        'mahila_loan_rate'   => 14,
        'consumer_loan_rate' => 18,
    ],
];
