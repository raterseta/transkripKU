<?php
namespace App\Mail;

use App\Models\AcademicTranscriptRequest;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class AcademicRequestMail extends Mailable
{
    use Queueable, SerializesModels;

    public $request;

    public function __construct(AcademicTranscriptRequest $request)
    {
        $this->request = $request;
    }

    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Permintaan Transkrip Akademik Berhasil - TranskripKU',
        );
    }

    public function content(): Content
    {
        return new Content(
            view: 'emails.academic-request',
        );
    }

    public function attachments(): array
    {
        return [];
    }
}
