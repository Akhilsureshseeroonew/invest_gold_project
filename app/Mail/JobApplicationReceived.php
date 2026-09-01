<?php

namespace App\Mail;

use App\Models\JobApplication;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Attachment;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class JobApplicationReceived extends Mailable
{
    use Queueable, SerializesModels;

    public function __construct(public JobApplication $application) {}

    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'New job application — '.$this->application->job_title,
            replyTo: array_filter([$this->application->email]),
        );
    }

    public function content(): Content
    {
        return new Content(text: 'mail.job-application-received');
    }

    public function attachments(): array
    {
        if (! $this->application->cv_path) {
            return [];
        }

        return [
            Attachment::fromStorageDisk('local', $this->application->cv_path)
                ->as($this->application->cv_name ?: 'cv'),
        ];
    }
}
