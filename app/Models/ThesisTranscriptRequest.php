<?php
namespace App\Models;

use App\Enums\RequestStatus;
use App\Models\RequestNote;
use App\Models\RequestTrack;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ThesisTranscriptRequest extends Model
{
    use HasFactory, HasUuids;

    protected $fillable = [
        'tracking_number',
        'status',
        'student_nim',
        'student_name',
        'student_email',
        'student_notes',
        'transcript_url',
        'consultation_notes',
        'supporting_document_url',
    ];

    protected $casts = [
        'status' => RequestStatus::class,
    ];

    public function track()
    {
        return $this->hasMany(RequestTrack::class);
    }

    public function notes()
    {
        return $this->hasMany(RequestNote::class);
    }
}
