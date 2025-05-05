<?php
namespace App\Models;

use App\Enums\RequestStatus;
use App\Enums\SignatureType;
use App\Models\RequestNote;
use App\Models\RequestTrack;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AcademicTranscriptRequest extends Model
{
    use HasFactory, HasUuids;

    protected $fillable = [
        'tracking_number',
        'status',
        'student_nim',
        'student_name',
        'student_email',
        'needs',
        'language',
        'signature_type',
        'transcript_url',
        'retrieval_notes',
        'student_notes',
        'supporting_document_url',
    ];

    protected $casts = [
        'status'         => RequestStatus::class,
        'signature_type' => SignatureType::class,
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
