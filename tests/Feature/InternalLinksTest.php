<?php

namespace Tests\Feature;

use Database\Seeders\DesignContentSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Mail;
use Tests\TestCase;

/**
 * Guards against "button points at the wrong page" mistakes:
 *  - every internal link on every page resolves (no 404s / wrong routes)
 *  - each product page's "Loan Calculator" button points at the homepage calculator
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
        '/blog', '/news', '/careers', '/branches', '/policies', '/contact',
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

    public function test_calculator_lives_only_on_the_homepage(): void
    {
        // homepage has the single calculator with a loan-type selector
        $home = $this->get('/')->assertOk();
        $home->assertSee('id="calculator"', false);
        $home->assertSee('id="calcLoanType"', false);
        $home->assertSee('id="calcGold"', false);
        $home->assertSee('id="calcEmi"', false);

        // product pages no longer carry a calculator; their CTA points at the homepage one
        foreach (['gold-loan', 'personal-loan', 'mahila-loan', 'consumer-loan'] as $slug) {
            $html = $this->get("/products/{$slug}")->assertOk()->getContent();
            $this->assertStringNotContainsString('id="calculator"', $html);
            $this->assertStringNotContainsString('data-loan-calc', $html);
            $this->assertMatchesRegularExpression('~href="/#calculator"[^>]*>\s*Loan Calculator~s', $html);
        }

        // the old /calculator URL redirects to the homepage section
        $this->get('/calculator')->assertRedirect('/#calculator');
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
