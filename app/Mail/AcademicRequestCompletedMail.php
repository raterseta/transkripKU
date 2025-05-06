<?php
namespace App\Mail;

use App\Models\AcademicTranscriptRequest;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class AcademicRequestCompletedMail extends Mailable
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
            subject: 'Permintaan Transkrip Akademik Selesai - TranskripKU',
        );
    }

    public function content(): Content
    {
        return new Content(
            view: 'emails.academic-request-completed',
        );
    }

    public function attachments(): array
    {
        $attachments = [];

        if (! empty($this->request->transcript_url)) {
            $attachments[] = \Illuminate\Mail\Mailables\Attachment::fromPath(
                storage_path('app/public/' . $this->request->transcript_url)
            )->withMime('application/pdf');
        }

        return $attachments;
    }
}
