<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class PengajuanFinalNotificationMail extends Mailable
{
    use Queueable, SerializesModels;

    public $record;

    public function __construct($record)
    {
        $this->record = $record;
    }

    public function build()
    {
        return $this->subject('Informasi Pengajuan Final Anda')
                    ->markdown('emails.Pengajuan-final')
                    ->with([
                        'nama' => $this->record->nama,
                        'keterangan' => $this->record->keterangan,
                        'file_transkrip' => $this->record->file_transkrip,
                    ])
                    ->attach(public_path('storage/' . $this->record->file_transkrip), [
                        'as' => 'Transkrip-Akhir.pdf', // nama file di email
                        'mime' => 'application/pdf',
                    ]);
    }
}
