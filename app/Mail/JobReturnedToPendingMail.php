<?php

namespace App\Mail;

use App\Models\Job;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class JobReturnedToPendingMail extends Mailable
{
    use Queueable, SerializesModels;

    public function __construct(
        public Job $job,
        public bool $toAdmin,
    ) {}

    public function envelope(): Envelope
    {
        return new Envelope(
            subject: $this->toAdmin
                ? 'Review needed: job listing returned to pending'
                : 'Your job listing is pending approval again',
        );
    }

    public function content(): Content
    {
        return new Content(
            view: 'mail.job-returned-to-pending',
        );
    }
}
