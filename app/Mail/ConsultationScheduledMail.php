<?php
namespace App\Mail;

use App\Models\ThesisTranscriptRequest;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class ConsultationScheduledMail extends Mailable
{
    use SerializesModels;

    public $request;
    public $oldStatus;
    public $newStatus;
    public $notes;
    public $recipientRole;

    public function __construct(
        ThesisTranscriptRequest $request,
        string $oldStatus,
        string $newStatus,
        ?string $notes = null,
        string $recipientRole = 'student'
    ) {
        $this->request       = $request;
        $this->oldStatus     = $oldStatus;
        $this->newStatus     = $newStatus;
        $this->notes         = $notes;
        $this->recipientRole = $recipientRole;
    }

    public function envelope(): Envelope
    {
        $subject = 'Jadwal Konsultasi Transkrip Final - ' . $this->request->tracking_number;

        return new Envelope(subject: $subject);
    }

    public function content(): Content
    {
        return new Content(
            view: 'emails.consultation-scheduled-notification',
        );
    }

    public function attachments(): array
    {
        return [];
    }
}
