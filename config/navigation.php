<?php

/*
|--------------------------------------------------------------------------
| Primary navigation (fallback tree)
|--------------------------------------------------------------------------
|
| Mirrors the header nav of the original design. Once the admin "Navigation"
| manager (menu_items table) is in place, a view composer supplies $menu from
| the DB and the header partial prefers that; this array is the seed/fallback.
|
| Each item: label, url, optional 'children' (one level deep).
|
*/

return [
    ['label' => 'Home',          'url' => '/'],
    ['label' => 'About',         'url' => '/about'],
    ['label' => 'Products',      'url' => '/products', 'children' => [
        ['label' => 'Gold Loan',      'url' => '/products/gold-loan'],
        ['label' => 'Personal Loan',  'url' => '/products/personal-loan'],
        ['label' => 'Mahila Loan',    'url' => '/products/mahila-loan'],
        ['label' => 'Consumer Loan',  'url' => '/products/consumer-loan'],
    ]],
    ['label' => 'Investment',     'url' => '/investment', 'children' => [
        ['label' => 'Non-Convertible Debentures', 'url' => '/investment/ncd'],
        ['label' => 'Subordinated Debt',          'url' => '/investment/subordinated-debt'],
        ['label' => 'Doubling Sub-Debt Scheme',   'url' => '/investment/doubling-scheme'],
        ['label' => 'Interest Rates',             'url' => '/investment/interest-rates'],
    ]],
    ['label' => 'News & Media',   'url' => '/news'],
    ['label' => 'Blog',          'url' => '/blog'],
    ['label' => 'Careers',       'url' => '/careers'],
    ['label' => 'Downloads',     'url' => '/policies'],
    ['label' => 'Contact Us',    'url' => '/contact'],
];
