<?php
namespace App\Mail;

use App\Models\ThesisTranscriptRequest;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class ThesisRequestRejectedMail extends Mailable
{
    use Queueable, SerializesModels;

    public $request;

    public $notes;

    public function __construct(ThesisTranscriptRequest $request, ?string $notes = null)
    {
        $this->request = $request;
        $this->notes   = $notes;
    }

    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Permintaan Transkrip FInal Ditolak - TranskripKU',
        );
    }

    public function content(): Content
    {
        return new Content(
            view: 'emails.thesis-request-rejected',
        );
    }

    public function attachments(): array
    {
        return [];
    }
}
