<?php
namespace App\Mail;

use App\Enums\RequestStatus;
use App\Models\ThesisTranscriptRequest;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class ThesisRequestStaffNotificationMail extends Mailable
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
        string $recipientRole = 'kaprodi'
    ) {
        $this->request       = $request;
        $this->oldStatus     = $oldStatus;
        $this->newStatus     = $newStatus;
        $this->notes         = $notes;
        $this->recipientRole = $recipientRole;
    }

    public function envelope(): Envelope
    {
        $subject = match ($this->newStatus) {
            RequestStatus::PROSESKAPRODI->value => 'Pengajuan Transkrip Final Memerlukan Tanda Tangan',
            RequestStatus::DITERUSKANKEOPERATOR->value => 'Transkrip Final Telah Ditandatangani',
            RequestStatus::DIKEMBALIKANKEOPERATOR->value => 'Pengajuan Transkrip Final Dikembalikan',
            RequestStatus::DIKEMBALIKANKEKAPRODI->value => 'Pengajuan Transkrip Final Perlu Direvisi',
            RequestStatus::SELESAI->value => 'Transkrip Final Telah Dikirim ke Mahasiswa',
            RequestStatus::DITOLAK->value => 'Pengajuan Transkrip Final Ditolak',
            default => 'Update Status Pengajuan Transkrip Final',
        };

        return new Envelope(
            subject: $subject . ' - ' . $this->request->tracking_number,
        );
    }

    public function content(): Content
    {
        return new Content(
            view: 'emails.thesis-request-staff-notification',
        );
    }

    public function attachments(): array
    {
        return [];
    }
}
