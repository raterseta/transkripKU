<?php
namespace App\Mail;

use App\Models\ThesisTranscriptRequest;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Attachment;
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
    public $googleCalendarUrl;
    public $outlookCalendarUrl;
    public $calendarIcs;

    public function __construct(
        ThesisTranscriptRequest $request,
        string $oldStatus,
        string $newStatus,
        ?string $notes = null,
        string $recipientRole = 'student',
        ?string $googleCalendarUrl = null,
        ?string $outlookCalendarUrl = null,
        ?string $calendarIcs = null
    ) {
        $this->request            = $request;
        $this->oldStatus          = $oldStatus;
        $this->newStatus          = $newStatus;
        $this->notes              = $notes;
        $this->recipientRole      = $recipientRole;
        $this->googleCalendarUrl  = $googleCalendarUrl;
        $this->outlookCalendarUrl = $outlookCalendarUrl;
        $this->calendarIcs        = $calendarIcs;
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
        $attachments = [];

        if ($this->calendarIcs) {
            $attachments[] = Attachment::fromData(fn() => $this->calendarIcs, 'konsultasi-transkrip.ics')
                ->withMime('text/calendar; method=REQUEST; charset=UTF-8');
        }

        return $attachments;
    }
}
