<?php

namespace Tests\Feature;

use App\Models\Enquiry;
use App\Models\JobOpening;
use App\Models\NewsItem;
use App\Models\Post;
use Database\Seeders\DesignContentSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Mail;
use PHPUnit\Framework\Attributes\DataProvider;
use Tests\TestCase;

class PublicSiteTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();
        Mail::fake();
        $this->seed(DesignContentSeeder::class);
    }

    public static function pages(): array
    {
        return array_map(fn ($p) => [$p], [
            '/', '/about', '/products', '/products/gold-loan', '/products/personal-loan',
            '/products/mahila-loan', '/products/consumer-loan',
            '/investment', '/investment/ncd', '/investment/subordinated-debt',
            '/investment/doubling-scheme', '/investment/interest-rates',
            '/blog', '/news', '/careers', '/branches', '/policies', '/contact',
        ]);
    }

    #[DataProvider('pages')]
    public function test_page_renders(string $path): void
    {
        $this->get($path)->assertOk();
    }

    public function test_calculator_url_redirects_to_the_homepage_section(): void
    {
        $this->get('/calculator')->assertRedirect('/#calculator');
    }

    public function test_unknown_page_is_404(): void
    {
        $this->get('/no-such-page')->assertNotFound();
    }

    public function test_detail_pages_render(): void
    {
        $this->get('/blog/'.Post::first()->slug)->assertOk()->assertSee(Post::first()->title);
        $this->get('/news/'.NewsItem::first()->slug)->assertOk();
        $this->get('/careers/'.JobOpening::first()->slug)->assertOk();
    }

    public function test_footer_link_columns_come_from_the_navigation_menu(): void
    {
        \App\Models\MenuItem::query()->menu('footer')->delete();
        $col = \App\Models\MenuItem::create(['menu' => 'footer', 'label' => 'Explore', 'sort_order' => 0]);
        \App\Models\MenuItem::create([
            'menu' => 'footer', 'parent_id' => $col->id, 'label' => 'Custom Footer Link',
            'url' => '/about', 'sort_order' => 0,
        ]);

        $html = $this->get('/')->assertOk()->getContent();

        $this->assertStringContainsString('<h4>Explore</h4>', $html);
        $this->assertStringContainsString('Custom Footer Link', $html);
        $this->assertStringNotContainsString('<h4>Company</h4>', $html); // hardcoded fallback replaced
    }

    public function test_footer_address_block_is_driven_by_config(): void
    {
        config([
            'site.footer_address_heading' => 'Registered Office',
            'site.footer_legal_line'      => 'NBFC Registration No. B-99.99999',
            'site.address_lines'          => ['New Tower, MG Road,', 'Kochi, Kerala – 682000'],
        ]);

        $html = $this->get('/')->assertOk()->getContent();

        $this->assertStringContainsString('<h4>Registered Office</h4>', $html);
        $this->assertStringContainsString('New Tower, MG Road,', $html);
        $this->assertStringContainsString('Kochi, Kerala – 682000', $html);
        $this->assertStringContainsString('NBFC Registration No. B-99.99999', $html);
        $this->assertStringNotContainsString('<h4>Head Office</h4>', $html);
    }

    public function test_admin_settings_save_flows_a_multiline_address_into_config(): void
    {
        \App\Support\Settings::put('site', 'site.address_full', "New Tower, MG Road,\nKochi – 682000");

        // AppServiceProvider replays settings + splits address_full at boot;
        // re-run that step to mimic the next request.
        (new \App\Providers\AppServiceProvider($this->app))->boot();

        $this->assertSame(['New Tower, MG Road,', 'Kochi – 682000'], config('site.address_lines'));
    }

    public function test_downloads_section_renders_the_dl_list_with_view_on_every_row(): void
    {
        $html = $this->get('/policies')->assertOk()->getContent();

        $this->assertStringContainsString('<div class="dl">', $html);
        $this->assertStringContainsString('id="docModal"', $html);

        $active = \App\Models\Policy::active()->whereNotNull('file_path')->count();
        $downloads = \App\Models\Policy::active()->whereNotNull('file_path')->where('access', 'download')->count();

        // every row exposes a View action…
        $this->assertSame($active, substr_count($html, '>View</button>'));
        // …and download rows additionally expose a Download link
        $this->assertSame($downloads, substr_count($html, 'class="dl__tag dl__tag--dl" href'));
        $this->assertSame($downloads, substr_count($html, '>Download</a>'));

        foreach (\App\Models\Policy::whereNotNull('file_path')->pluck('file_path') as $rel) {
            $this->assertFileExists(public_path($rel), "Missing policy PDF: {$rel}");
        }
    }

    public function test_a_single_uploaded_image_serves_both_the_listing_card_and_the_inner_banner(): void
    {
        // News item with ONLY a banner image (no separate card thumbnail)
        $news = NewsItem::first();
        $news->update(['cover_image' => null, 'banner_image' => 'news/banners/only-image.jpg']);
        $this->get('/news')->assertOk()
            ->assertSee('news/banners/only-image.jpg');            // shows on the listing card
        $this->get('/news/'.$news->slug)->assertOk()
            ->assertSee('news/banners/only-image.jpg');            // and on the inner banner

        // Blog post with ONLY a banner image
        $post = Post::first();
        $post->update(['cover_image' => null, 'banner_image' => 'blog/banners/only-image.jpg']);
        $this->get('/blog')->assertOk()
            ->assertSee('blog/banners/only-image.jpg');
        $this->get('/blog/'.$post->slug)->assertOk()
            ->assertSee('blog/banners/only-image.jpg');
    }

    public function test_social_links_added_in_admin_render_as_working_links_everywhere(): void
    {
        // what a saved Site Settings form leaves in config() for the next request:
        // one full URL, one without a scheme, one placeholder, one blank
        config([
            'site.social.facebook'  => 'https://facebook.com/investgold',
            'site.social.instagram' => 'instagram.com/investgold',
            'site.social.youtube'   => '#',
            'site.social.linkedin'  => null,
        ]);

        $html = $this->get('/')->assertOk()->getContent();

        // only the two platforms with a link set show an icon — 2 spots each
        // (header nav + footer nav); Instagram had https:// prepended
        $this->assertSame(2, substr_count($html, 'href="https://facebook.com/investgold"'));
        $this->assertSame(2, substr_count($html, 'href="https://instagram.com/investgold"'));

        // the platforms with no link ("#" youtube, blank linkedin, unset x) show no icon at all
        $this->assertStringNotContainsString('#i-youtube', $html);
        $this->assertStringNotContainsString('#i-linkedin', $html);
        $this->assertStringNotContainsString('#i-x"', $html);
        $this->assertStringNotContainsString('aria-label="YouTube"', $html);
    }

    public function test_no_social_links_hides_the_nav_icons(): void
    {
        config([
            'site.social.facebook' => null, 'site.social.instagram' => null,
            'site.social.youtube' => null, 'site.social.linkedin' => null, 'site.social.x' => null,
        ]);

        $html = $this->get('/')->assertOk()->getContent();

        $this->assertStringNotContainsString('#i-facebook', $html);
        // the corner mascot's quick actions are unrelated to social links
        $this->assertStringContainsString('data-label="Calculator"', $html);
    }

    public function test_corner_mascot_shows_quick_actions(): void
    {
        $html = $this->get('/')->assertOk()->getContent();

        $this->assertStringContainsString('id="fab"', $html);
        $this->assertStringContainsString('href="https://wa.me/', $html);
        $this->assertStringContainsString('data-label="Contact"', $html);
        $this->assertStringContainsString('data-label="Branches"', $html);
        $this->assertStringContainsString('data-label="Calculator"', $html);
        $this->assertStringContainsString('href="'.url('/#calculator').'"', $html);
    }

    public function test_normalize_url_helper(): void
    {
        $n = fn ($v) => \App\Support\Site::normalizeUrl($v);
        $this->assertSame('https://facebook.com/x', $n('facebook.com/x'));
        $this->assertSame('https://x.com/y', $n('  https://x.com/y  '));
        $this->assertSame('https://www.youtube.com/@z', $n('www.youtube.com/@z'));
        $this->assertNull($n('#'));
        $this->assertNull($n(''));
        $this->assertNull($n(null));
        $this->assertSame('/contact', $n('/contact'));
    }

    public function test_homepage_app_store_links_come_from_site_settings(): void
    {
        // nothing set -> no store buttons, no dead "#" links
        $this->get('/')->assertOk()
            ->assertDontSee('aria-label="Get it on Google Play"', false);

        // scheme-less URL entered in admin -> real link, https:// prepended, opens in new tab
        config(['site.app.play_store' => 'play.google.com/store/apps/details?id=com.investgold']);
        config(['site.app.apple_store' => 'https://apps.apple.com/app/id123']);

        $html = $this->get('/')->assertOk()->getContent();
        $this->assertStringContainsString('href="https://play.google.com/store/apps/details?id=com.investgold" target="_blank"', $html);
        $this->assertStringContainsString('href="https://apps.apple.com/app/id123" target="_blank"', $html);
        $this->assertStringContainsString('Download Now', $html);
    }

    public function test_homepage_get_in_touch_section_uses_the_contact_site_settings(): void
    {
        \App\Support\Settings::put('site', 'site.phone_primary', '+91 99999 00000');
        \App\Support\Settings::put('site', 'site.phone_primary_tel', '919999900000');
        \App\Support\Settings::put('site', 'site.email', 'reception@example.test');
        \App\Support\Settings::put('site', 'site.hours', 'Weekdays 10 to 4');
        (new \App\Providers\AppServiceProvider($this->app))->boot();   // replay settings into config

        $home = $this->get('/')->assertOk();
        $home->assertSee('+91 99999 00000');
        $home->assertSee('tel:919999900000', false);
        $home->assertSee('reception@example.test');
        $home->assertSee('Weekdays 10 to 4');
        $home->assertSee('action="'.route('enquiry.store').'"', false);   // real, wired-up form

        // same values on the dedicated Contact page — one source of truth
        $this->get('/contact')->assertOk()->assertSee('reception@example.test');
    }

    public function test_homepage_content_is_admin_driven(): void
    {
        // section text via the Home Page settings
        \App\Support\Settings::put('home', 'home.about.heading', 'A Very Custom About Heading');
        \App\Support\Settings::put('home', 'home.why.cards', [
            ['num' => '09', 'icon' => 'star', 'title' => 'Custom Why Card', 'text' => 'body text here'],
        ]);

        // testimonials + faqs come from their own tables
        \App\Models\Testimonial::query()->delete();
        \App\Models\Testimonial::create(['name' => 'Zoya Test', 'location' => 'Kochi', 'quote' => 'A custom testimonial quote.', 'rating' => 4]);
        \App\Models\Faq::query()->delete();
        \App\Models\Faq::create(['question' => 'A custom question?', 'answer' => '<p>A custom answer.</p>']);

        $html = $this->get('/')->assertOk()->getContent();

        $this->assertStringContainsString('A Very Custom About Heading', $html);
        $this->assertStringContainsString('Custom Why Card', $html);
        $this->assertStringContainsString('Zoya Test', $html);
        $this->assertStringContainsString('A custom testimonial quote.', $html);
        $this->assertSame(1, substr_count($html, 'class="tslide"'));   // only the one testimonial
        $this->assertStringContainsString('A custom question?', $html);
        $this->assertSame(1, substr_count($html, 'class="acc"'));      // only the one faq
    }

    public function test_homepage_product_and_investment_cards_auto_sync_from_pages(): void
    {
        $products = \App\Models\Page::published()->childrenOf('products')->get();
        $html = $this->get('/')->assertOk()->getContent();

        $this->assertSame($products->count(), substr_count($html, 'card product'));
        foreach ($products as $p) {
            $this->assertStringContainsString('>'.e($p->title).'</h3>', $html);
        }
        // unpublishing a product page drops its homepage card
        $products->first()->update(['is_published' => false]);
        $this->assertSame($products->count() - 1, substr_count($this->get('/')->getContent(), 'card product'));
    }

    public function test_homepage_news_section_is_driven_by_news_items(): void
    {
        $latest = NewsItem::published()->orderByDesc('published_at')->take(3)->get();
        $this->assertGreaterThan(0, $latest->count());

        $html = $this->get('/')->assertOk()->getContent();

        // the homepage #news section shows the 3 most-recent news items, linked to their article
        foreach ($latest as $item) {
            $this->assertStringContainsString(e($item->title), $html);
            $this->assertStringContainsString(route('news.show', $item), $html);
        }

        // editing a news item flows straight through to the homepage
        $first = $latest->first();
        $first->update(['title' => 'Homepage Sync Check News']);
        $this->get('/')->assertOk()->assertSee('Homepage Sync Check News');

        // unpublishing removes it from the homepage
        $first->update(['is_published' => false]);
        $this->get('/')->assertOk()->assertDontSee('Homepage Sync Check News');
    }

    public function test_unpublished_post_is_404(): void
    {
        $post = Post::first();
        $post->update(['is_published' => false]);

        $this->get('/blog/'.$post->slug)->assertNotFound();
    }

    public function test_enquiry_submits_and_is_stored(): void
    {
        $response = $this->post('/enquiry', [
            'name' => 'Anil Kumar',
            'phone' => '9847012345',
            'email' => 'anil@example.com',
            'service' => 'Gold Loan',
            'message' => 'Please call me back.',
            'source_url' => 'http://localhost/products/gold-loan',
        ]);

        $response->assertRedirect();
        $response->assertSessionHas('enquiry_sent', true);

        $this->assertDatabaseHas('enquiries', [
            'name' => 'Anil Kumar',
            'phone' => '9847012345',
            'service' => 'Gold Loan',
            'status' => 'new',
        ]);

        Mail::assertSent(\App\Mail\EnquiryReceived::class);
    }

    public function test_enquiry_ajax_returns_json(): void
    {
        $this->postJson('/enquiry', [
            'name' => 'Meera R',
            'phone' => '+91 90745 23723',
            'email' => 'meera@example.com',
            'service' => 'Personal Loan',
        ])->assertOk()->assertJson(['ok' => true]);

        $this->assertDatabaseHas('enquiries', ['phone' => '9074523723', 'service' => 'Personal Loan']);
    }

    public function test_enquiry_validation_rejects_bad_phone(): void
    {
        $this->from('/contact')->post('/enquiry', [
            'name' => 'X',
            'phone' => '12345',
            'email' => 'not-an-email',
            'service' => '',
        ])->assertRedirect('/contact')->assertSessionHasErrors(['name', 'phone_normalised', 'email', 'service']);

        $this->assertDatabaseCount('enquiries', 0);
    }
}
