<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class StatusPengajuanFinalChanged extends Mailable
{
    use Queueable, SerializesModels;

    public $pengajuanfinal;

    public function __construct($pengajuanfinal)
    {
        $this->pengajuanfinal = $pengajuanfinal;
    }

    public function build()
    {
        return $this->subject('Status Pengajuan final Anda Telah Diperbarui')
            ->view('emails.status-pengajuan-final'); // Buat blade ini
    }
}
