<?php
namespace App\Mail;

use App\Models\AcademicTranscriptRequest;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class AcademicRequestRejectedMail extends Mailable
{
    use Queueable, SerializesModels;

    public $request;

    public $notes;

    public function __construct(AcademicTranscriptRequest $request, ?string $notes = null)
    {
        $this->request = $request;
        $this->notes   = $notes;
    }

    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Permintaan Transkrip Akademik Ditolak - TranskripKU',
        );
    }

    public function content(): Content
    {
        return new Content(
            view: 'emails.academic-request-rejected',
        );
    }

    public function attachments(): array
    {
        return [];
    }
}
