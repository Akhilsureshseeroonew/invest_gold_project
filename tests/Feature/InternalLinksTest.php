<?php

namespace Tests\Feature;

use Database\Seeders\DesignContentSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Mail;
use Tests\TestCase;

/**
 * Guards against "button points at the wrong page" mistakes:
 *  - every internal link on every page resolves (no 404s / wrong routes)
 *  - each product page's "EMI Calculator" button targets its own calculator
 *  - each investment scheme's enquiry links carry that scheme's ?service=
 */
class InternalLinksTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();
        Mail::fake();
        $this->seed(DesignContentSeeder::class);
    }

    private const PAGES = [
        '/', '/about', '/products', '/products/gold-loan', '/products/personal-loan',
        '/products/mahila-loan', '/products/consumer-loan',
        '/investment', '/investment/ncd', '/investment/subordinated-debt',
        '/investment/doubling-scheme', '/investment/interest-rates',
        '/calculator', '/blog', '/news', '/careers', '/branches', '/policies', '/contact',
    ];

    public function test_every_internal_link_resolves(): void
    {
        $checked = [];

        foreach (self::PAGES as $page) {
            $html = $this->get($page)->assertOk()->getContent();

            preg_match_all('/href="(\/[^"#?]*)/', $html, $m);
            foreach (array_unique($m[1]) as $link) {
                if (preg_match('#^/(assets|storage|admin|build)#', $link) || isset($checked[$link])) {
                    continue;
                }
                $checked[$link] = true;
                $this->get($link)->assertOk(); // fails loudly with the offending URL
            }
        }

        $this->assertNotEmpty($checked);
    }

    public function test_product_emi_calculator_button_targets_same_page_calculator(): void
    {
        foreach (['gold-loan', 'personal-loan', 'mahila-loan', 'consumer-loan'] as $slug) {
            $html = $this->get("/products/{$slug}")->assertOk()->getContent();

            $this->assertMatchesRegularExpression(
                '/href="#calculator"[^>]*>\s*EMI Calculator/s',
                $html,
                "{$slug}: EMI Calculator button should scroll to its own #calculator section",
            );
            $this->assertStringContainsString('id="calculator"', $html);
        }
    }

    public function test_investment_scheme_enquiry_links_use_correct_service(): void
    {
        $map = [
            'ncd'                => 'service=NCD%20Investment',
            'subordinated-debt'  => 'service=SD%20Investment',
            'doubling-scheme'    => 'service=Doubling%20Investment',
        ];

        foreach ($map as $slug => $expected) {
            $html = $this->get("/investment/{$slug}")->assertOk()->getContent();
            $this->assertStringContainsString($expected, $html, "{$slug} enquiry link");

            foreach (array_diff(array_values($map), [$expected]) as $wrong) {
                $this->assertStringNotContainsString($wrong, $html, "{$slug} must not link {$wrong}");
            }
        }
    }
}
