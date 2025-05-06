<?php
namespace App\Mail;

use App\Enums\RequestStatus;
use App\Models\AcademicTranscriptRequest;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class AcademicRequestStaffNotificationMail extends Mailable
{
    use Queueable, SerializesModels;

    public $request;

    public $oldStatus;

    public $newStatus;

    public $notes;

    public $recipientRole;

    public function __construct(
        AcademicTranscriptRequest $request,
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
            RequestStatus::PROSESKAPRODI->value          => 'Pengajuan Transkrip Akademik Memerlukan Tanda Tangan',
            RequestStatus::DITERUSKANKEOPERATOR->value   => 'Transkrip Akademik Telah Ditandatangani',
            RequestStatus::DIKEMBALIKANKEOPERATOR->value => 'Pengajuan Transkrip Akademik Dikembalikan',
            RequestStatus::DIKEMBALIKANKEKAPRODI->value  => 'Pengajuan Transkrip Akademik Perlu Direvisi',
            RequestStatus::SELESAI->value                => 'Transkrip Akademik Telah Dikirim ke Mahasiswa',
            RequestStatus::DITOLAK->value                => 'Pengajuan Transkrip Akademik Ditolak',
            default                                      => 'Update Status Pengajuan Transkrip Akademik',
        };

        return new Envelope(
            subject: $subject . ' - ' . $this->request->tracking_number,
        );
    }

    public function content(): Content
    {
        return new Content(
            view: 'emails.academic-request-staff-notification',
        );
    }

    public function attachments(): array
    {
        return [];
    }
}
