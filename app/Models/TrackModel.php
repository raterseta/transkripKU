<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TrackModel extends Model
{
    use HasFactory;

    protected $table = 'track'; // pastikan nama tabelnya bener
    protected $guarded = [];


    protected $fillable = [
        'custom_id',
        'nama',
        'nim',
        'status',
        'updated_at',
        'sumber',
    ];
}
