<?php
namespace App\Mail;

use Carbon\Carbon;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class NewTranscriptRequestNotificationMail extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * The number of times the job may be attempted.
     *
     * @var int
     */
    public $tries = 3;

    /**
     * The number of seconds the job can run before timing out.
     *
     * @var int
     */
    public $timeout = 60;

    public $trackingNumber;
    public $studentName;
    public $studentNim;
    public $studentEmail;
    public $needs;
    public $language;
    public $signatureType;
    public $createdAt;
    public $requestType;
    public $requestId;

    /**
     * Create a new message instance.
     *
     * @param string $trackingNumber
     * @param string $studentName
     * @param string $studentNim
     * @param string $studentEmail
     * @param string|null $needs
     * @param string|null $language
     * @param string|null $signatureType
     * @param Carbon $createdAt
     * @param string $requestType 'academic' or 'thesis'
     * @param string $requestId
     * @return void
     */
    public function __construct(
        string $trackingNumber,
        string $studentName,
        string $studentNim,
        string $studentEmail,
        ?string $needs,
        ?string $language,
        ?string $signatureType,
        $createdAt,
        string $requestType,
        string $requestId
    ) {
        $this->trackingNumber = $trackingNumber;
        $this->studentName    = $studentName;
        $this->studentNim     = $studentNim;
        $this->studentEmail   = $studentEmail;
        $this->needs          = $needs;
        $this->language       = $language;
        $this->signatureType  = $signatureType;
        $this->createdAt      = $createdAt;
        $this->requestType    = $requestType;
        $this->requestId      = $requestId;
    }

    /**
     * Get the message envelope.
     *
     * @return \Illuminate\Mail\Mailables\Envelope
     */
    public function envelope(): Envelope
    {
        $transcriptType = $this->requestType === 'academic' ? 'Akademik' : 'Final';

        return new Envelope(
            subject: "Pengajuan Transkrip {$transcriptType} Baru - {$this->trackingNumber}",
        );
    }

    /**
     * Get the message content definition.
     *
     * @return \Illuminate\Mail\Mailables\Content
     */
    public function content(): Content
    {
        return new Content(
            view: 'emails.new-transcript-request-notification',
        );
    }

    /**
     * Get the attachments for the message.
     *
     * @return array
     */
    public function attachments(): array
    {
        return [];
    }
}
