<?php
namespace App\Services;

use App\Enums\RequestStatus;
use App\Mail\ThesisRequestCompletedMail;
use App\Mail\ThesisRequestRejectedMail;
use App\Mail\ThesisRequestStaffNotificationMail;
use App\Models\ThesisTranscriptRequest;
use App\Models\User;
use Illuminate\Support\Facades\Mail;

class ThesisRequestNotificationService
{
    public function sendStatusChangeNotification(
        ThesisTranscriptRequest $request,
        string $oldStatus,
        string $newStatus,
        ?string $notes = null
    ): void {
        switch ($newStatus) {
            case RequestStatus::PROSESKAPRODI->value:
                $this->notifyKaprodi($request, $oldStatus, $newStatus, $notes);
                break;

            case RequestStatus::DITERUSKANKEOPERATOR->value:
                $this->notifyOperator($request, $oldStatus, $newStatus, $notes);
                break;

            case RequestStatus::DIKEMBALIKANKEOPERATOR->value:
                $this->notifyOperator($request, $oldStatus, $newStatus, $notes);
                break;

            case RequestStatus::DIKEMBALIKANKEKAPRODI->value:
                $this->notifyKaprodi($request, $oldStatus, $newStatus, $notes);
                break;

            case RequestStatus::SELESAI->value:
                $this->notifyStudent($request, $newStatus);
                break;

            case RequestStatus::DITOLAK->value:
                $this->notifyStudent($request, $newStatus, $notes);
                break;
        }
    }

    protected function notifyKaprodi(
        ThesisTranscriptRequest $request,
        string $oldStatus,
        string $newStatus,
        ?string $notes = null
    ): void {
        $kaprodiUsers = User::whereHas('roles', function ($query) {
            $query->where('name', 'kaprod');
        })->get();

        foreach ($kaprodiUsers as $kaprodi) {
            Mail::to($kaprodi->email)->send(
                new ThesisRequestStaffNotificationMail(
                    $request,
                    $oldStatus,
                    $newStatus,
                    $notes,
                    'kaprodi'
                )
            );
        }
    }

    protected function notifyOperator(
        ThesisTranscriptRequest $request,
        string $oldStatus,
        string $newStatus,
        ?string $notes = null
    ): void {
        $operatorUsers = User::whereHas('roles', function ($query) {
            $query->where('name', 'super_admin');
        })->get();

        foreach ($operatorUsers as $operator) {
            Mail::to($operator->email)->send(
                new ThesisRequestStaffNotificationMail(
                    $request,
                    $oldStatus,
                    $newStatus,
                    $notes,
                    'operator'
                )
            );
        }
    }

    protected function notifyStudent(ThesisTranscriptRequest $request, string $status, ?string $notes = null): void
    {
        switch ($status) {
            case RequestStatus::SELESAI->value:
                Mail::to($request->student_email)->send(new ThesisRequestCompletedMail($request));
                break;

            case RequestStatus::DITOLAK->value:
                Mail::to($request->student_email)->send(new ThesisRequestRejectedMail($request, $notes));
                break;
        }
    }
}
