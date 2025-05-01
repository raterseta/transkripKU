<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Model;

class StudyProgram extends Model
{
    use HasUuids;
    //

    public function user()
    {
        return $this->hasMany(User::class);
    }
}
