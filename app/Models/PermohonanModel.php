<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\DB;

class PermohonanModel extends Model
{
    public $timestamps = false;

    // protected $table = 'pengajuan'; // Kita bohongin aja, nanti query kita timpa manual

    public function getTable()
    {
        return 'permohonans'; // Alias dari subquery
    }
    protected $guarded = [];

    protected static function booted()
    {
        static::addGlobalScope('gabungan', function (Builder $builder) {
            $query1 = DB::table('pengajuan')
                ->select('id', 'custom_id', 'nama', 'nim', 'status', DB::raw('"pengajuan" as sumber'));

            $query2 = DB::table('pengajuan_final')
                ->select('id', 'custom_id', 'nama', 'nim', 'status', DB::raw('"pengajuan_final" as sumber'));

            $gabungan = $query1->unionAll($query2);

            $builder->fromSub($gabungan, 'permohonans');
        });
    }
}
