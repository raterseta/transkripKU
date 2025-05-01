<?php
namespace App\Models;

use App\Enums\RequestStatus;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class RequestTrack extends Model
{
    use HasFactory, HasUuids;

    protected $fillable = [
        'academic_request_id',
        'thesis_request_id',
        'action_notes',
        'action_desc',
        'status',
    ];

    protected $casts = [
        'status' => 'RequestStatus::class',
    ];

    public function academicRequest(): BelongsTo
    {
        return $this->belongsTo(AcademicTranscriptRequest::class, 'academic_request_id');
    }

    public function thesisRequest(): BelongsTo
    {
        return $this->belongsTo(ThesisTranscriptRequest::class, 'thesis_request_id');
    }

    public function getStatusLabelAttribute(): string
    {
        $status = RequestStatus::from($this->status);
        return $status->getLabel();
    }

    public function getStatusColorAttribute(): string
    {
        $status = RequestStatus::from($this->status);
        return $status->getColor();
    }

    public function isAcademicRequest(): bool
    {
        return ! is_null($this->academic_request_id);
    }

    public function isThesisRequest(): bool
    {
        return ! is_null($this->thesis_request_id);
    }

    public function getRequest()
    {
        if ($this->isAcademicRequest()) {
            return $this->academicRequest;
        } elseif ($this->isThesisRequest()) {
            return $this->thesisRequest;
        }

        return null;
    }
}
