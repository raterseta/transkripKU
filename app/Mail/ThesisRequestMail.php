<?php
namespace App\Mail;

use App\Models\ThesisTranscriptRequest;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class ThesisRequestMail extends Mailable
{
    use Queueable, SerializesModels;

    public $request;

    public function __construct(ThesisTranscriptRequest $request)
    {
        $this->request = $request;
    }

    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Permintaan Transkrip Final Berhasil - TranskripKU',
        );
    }

    public function content(): Content
    {
        return new Content(
            view: 'emails.thesis-request',
        );
    }

    public function attachments(): array
    {
        return [];
    }
}
