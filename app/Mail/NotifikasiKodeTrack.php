<?php
namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class NotifikasiKodeTrack extends Mailable
{
    use Queueable, SerializesModels;

    public $record; // ini untuk passing data

    public function __construct($record)
    {
        $this->record = $record;
    }

    public function build()
    {
        return $this->subject('Konfirmasi Pengajuan Anda')
            ->view('emails.notifikasi-pengajuan')
            ->with([
                'nama'      => $this->record->student_name,
                'nim'       => $this->record->student_nim,
                'custom_id' => $this->record->tracking_number,
            ]);
    }
}
