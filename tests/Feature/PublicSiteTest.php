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
            '/calculator', '/blog', '/news', '/careers', '/branches', '/policies', '/contact',
        ]);
    }

    #[DataProvider('pages')]
    public function test_page_renders(string $path): void
    {
        $this->get($path)->assertOk();
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
