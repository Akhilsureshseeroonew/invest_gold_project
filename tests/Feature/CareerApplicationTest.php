<?php

namespace Tests\Feature;

use App\Mail\JobApplicationReceived;
use App\Models\JobApplication;
use App\Models\JobOpening;
use Database\Seeders\DesignContentSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class CareerApplicationTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();
        $this->seed(DesignContentSeeder::class);
    }

    public function test_every_open_vacancy_shows_the_apply_modal_and_form(): void
    {
        foreach (JobOpening::open()->get() as $job) {
            $this->get(route('careers.show', $job))
                ->assertOk()
                ->assertSee('id="applyModal"', false)
                ->assertSee('data-modal-open="applyModal"', false)
                ->assertSee('action="'.route('careers.apply', $job).'"', false);
        }
    }

    public function test_a_valid_application_is_stored_with_the_cv(): void
    {
        Storage::fake('local');
        Mail::fake();
        $job = JobOpening::open()->first();

        $response = $this->post(route('careers.apply', $job), [
            'name'       => 'Asha Menon',
            'email'      => 'asha@example.com',
            'phone'      => '+91 9847012345',
            'cv'         => UploadedFile::fake()->create('asha-resume.pdf', 200, 'application/pdf'),
            'source_url' => route('careers.show', $job),
        ]);

        $response->assertRedirect();
        $response->assertSessionHas('application_sent', true);

        $application = JobApplication::first();
        $this->assertNotNull($application);
        $this->assertSame($job->id, $application->job_opening_id);
        $this->assertSame($job->title, $application->job_title);
        $this->assertSame('9847012345', $application->phone);
        $this->assertSame('asha-resume.pdf', $application->cv_name);
        Storage::disk('local')->assertExists($application->cv_path);
        Mail::assertSent(JobApplicationReceived::class);
    }

    public function test_ajax_application_returns_json_ok(): void
    {
        Storage::fake('local');
        Mail::fake();
        $job = JobOpening::open()->first();

        $this->postJson(route('careers.apply', $job), [
            'name'  => 'Ravi Nair',
            'email' => 'ravi@example.com',
            'phone' => '9847011111',
            'cv'    => UploadedFile::fake()->create('ravi.docx', 100),
        ])->assertOk()->assertJson(['ok' => true]);
    }

    public function test_application_validation_rejects_bad_input(): void
    {
        Storage::fake('local');
        $job = JobOpening::open()->first();

        $this->postJson(route('careers.apply', $job), [
            'name'  => 'A',
            'email' => 'not-an-email',
            'phone' => '12345',
            'cv'    => UploadedFile::fake()->create('malware.exe', 10),
        ])->assertStatus(422)
            ->assertJsonValidationErrors(['name', 'email', 'phone_normalised', 'cv']);

        $this->assertDatabaseCount('job_applications', 0);
    }

    public function test_a_5mb_plus_cv_is_rejected(): void
    {
        Storage::fake('local');
        $job = JobOpening::open()->first();

        $this->postJson(route('careers.apply', $job), [
            'name'  => 'Big File',
            'email' => 'big@example.com',
            'phone' => '9847022222',
            'cv'    => UploadedFile::fake()->create('huge.pdf', 6000, 'application/pdf'),
        ])->assertStatus(422)->assertJsonValidationErrors(['cv']);
    }

    public function test_closed_vacancy_cannot_receive_applications(): void
    {
        Storage::fake('local');
        $job = JobOpening::open()->first();
        $job->update(['is_open' => false]);

        $this->post(route('careers.apply', $job), [
            'name'  => 'Late Applicant',
            'email' => 'late@example.com',
            'phone' => '9847033333',
            'cv'    => UploadedFile::fake()->create('late.pdf', 100, 'application/pdf'),
        ])->assertNotFound();
    }
}
