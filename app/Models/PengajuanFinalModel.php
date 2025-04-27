<?php

namespace App\Models;

use Illuminate\Support\Facades\Mail;
use App\Mail\StatusPengajuanFinalChanged;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;

class PengajuanFinalModel extends Model implements HasMedia
{
    use HasFactory, InteractsWithMedia;

    protected $table = 'pengajuan_final';

    protected $guarded = [];

    protected $fillable = [
        'nama',
        'nim',
        'email',
        'keterangan',
        'file_pendukung',
        'status',
        'file_transkrip',
        'notes',

    ];

    protected static function booted(): void
    {
        static::updating(function ($model) {
            if ($model->isDirty('status')) {
                // Status berubah
                Mail::to($model->email)->send(new \App\Mail\StatusPengajuanFinalChanged($model));
                TrackModel::create([
                    'custom_id' => $model->custom_id, // atau custom_id kalau kamu ada field custom
                    'nama' => $model->nama,
                    'nim' => $model->nim,
                    'status' => $model->status,
                    'updated_at' => $model->updated_at,
                    'sumber' => 'pengajuan',
                ]);
            }
        });
    }
}
