<?php

namespace App\Models;


use App\Models\TrackModel;
use Illuminate\Support\Facades\Mail;
use App\Mail\StatusPengajuanChanged;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PengajuanModel extends Model
{
    use HasFactory;

    protected $table = 'pengajuan';

    protected $guarded = [];

    protected $fillable = [
        'nama',
        'nim',
        'email',
        'keperluan',
        'bahasa',
        'ttd',
        'catatan_tambahan',
        'file_pendukung',
        'status',
        'file_transkrip',
        'notes',
    ];

    // Event saat updating
    protected static function booted(): void
    {
        static::updating(function ($model) {
            if ($model->isDirty('status')) {
                // 1. Kirim Email
                Mail::to($model->email)->send(new StatusPengajuanChanged($model));

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
