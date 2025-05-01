<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Model;

class RequestNote extends Model
{
    use HasUuids;

    public function academicRequest()
    {
        return $this->belongsTo(AcademicTranscriptRequest::class, 'academic_request_id');
    }

    public function thesisRequest()
    {
        return $this->belongsTo(ThesisTranscriptRequest::class, 'thesis_request_id');
    }
}
