<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class PengajuanNotificationMail extends Mailable
{
    use Queueable, SerializesModels;

    public $record;

    public function __construct($record)
    {
        $this->record = $record;
    }

    public function build()
    {
        return $this->subject('Informasi Pengajuan Anda')
                    ->markdown('emails.Pengajuan')
                    ->with([
                        'nama' => $this->record->nama,
                        'nim' => $this->pengajuan->nim,
                        'custom_id' => $this->pengajuan->custom_id,
                    ]);
    }
}
