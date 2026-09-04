<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use PHPUnit\Framework\Attributes\DataProvider;
use Tests\TestCase;

/**
 * Every admin list/create page + the settings page renders for a logged-in
 * admin. Runs on the in-memory sqlite test DB (see phpunit.xml).
 */
class AdminPanelSmokeTest extends TestCase
{
    use RefreshDatabase;

    public static function adminRoutes(): array
    {
        return array_map(fn ($p) => [$p], [
            '/admin',
            '/admin/pages',
            '/admin/pages/create',
            '/admin/menu-items',
            '/admin/menu-items/create',
            '/admin/posts',
            '/admin/posts/create',
            '/admin/news-items',
            '/admin/news-items/create',
            '/admin/job-openings',
            '/admin/job-openings/create',
            '/admin/branches',
            '/admin/branches/create',
            '/admin/policies',
            '/admin/policies/create',
            '/admin/interest-rate-schemes',
            '/admin/interest-rate-schemes/create',
            '/admin/testimonials',
            '/admin/testimonials/create',
            '/admin/faqs',
            '/admin/faqs/create',
            '/admin/enquiries',
            '/admin/job-applications',
            '/admin/manage-site-settings',
            '/admin/manage-homepage',
        ]);
    }

    #[DataProvider('adminRoutes')]
    public function test_admin_page_renders(string $path): void
    {
        $admin = User::factory()->create(['is_admin' => true]);

        $this->actingAs($admin)
            ->get($path)
            ->assertSuccessful();
    }

    /**
     * The seeded content must open in its edit/view form without error — this
     * is where a bad Repeater / RichEditor / relation config actually surfaces.
     */
    public function test_seeded_records_open_in_edit_forms(): void
    {
        $this->seed(\Database\Seeders\DesignContentSeeder::class);
        $admin = User::factory()->create(['is_admin' => true]);

        \App\Models\Enquiry::create([
            'name' => 'Test Lead', 'phone' => '9847000000', 'email' => 'lead@example.com',
            'service' => 'Gold Loan', 'status' => 'new',
        ]);
        \App\Models\JobApplication::create([
            'job_opening_id' => \App\Models\JobOpening::value('id'),
            'job_title' => 'Branch Manager',
            'name' => 'Test Applicant', 'email' => 'test@example.com', 'phone' => '9847000000',
            'cv_path' => 'cvs/test.pdf', 'cv_name' => 'test.pdf', 'status' => 'new',
        ]);

        $targets = [
            '/admin/pages/%d/edit'                  => \App\Models\Page::class,
            '/admin/menu-items/%d/edit'             => \App\Models\MenuItem::class,
            '/admin/posts/%d/edit'                  => \App\Models\Post::class,
            '/admin/news-items/%d/edit'             => \App\Models\NewsItem::class,
            '/admin/job-openings/%d/edit'           => \App\Models\JobOpening::class,
            '/admin/branches/%d/edit'               => \App\Models\Branch::class,
            '/admin/policies/%d/edit'               => \App\Models\Policy::class,
            '/admin/interest-rate-schemes/%d/edit'  => \App\Models\InterestRateScheme::class,
            '/admin/testimonials/%d/edit'           => \App\Models\Testimonial::class,
            '/admin/faqs/%d/edit'                   => \App\Models\Faq::class,
            '/admin/enquiries/%d'                   => \App\Models\Enquiry::class,
            '/admin/job-applications/%d'            => \App\Models\JobApplication::class,
        ];

        foreach ($targets as $pattern => $model) {
            $id = $model::query()->value('id');
            $this->assertNotNull($id, "No seeded row for {$model}");

            $this->actingAs($admin)
                ->get(sprintf($pattern, $id))
                ->assertSuccessful();
        }
    }
}
