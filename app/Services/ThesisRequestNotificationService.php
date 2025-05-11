<?php
namespace App\Services;

use App\Enums\RequestStatus;
use App\Mail\ConsultationScheduledMail;
use App\Mail\ThesisRequestCompletedMail;
use App\Mail\ThesisRequestRejectedMail;
use App\Mail\ThesisRequestStaffNotificationMail;
use App\Models\ThesisTranscriptRequest;
use App\Models\User;
use Illuminate\Support\Facades\Mail;

class ThesisRequestNotificationService
{
    protected $calendarEventService;

    public function __construct(CalendarEventService $calendarEventService)
    {
        $this->calendarEventService = $calendarEventService;
    }

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
            case RequestStatus::MENUNGGUKONSULTASI->value:
                $this->notifyConsultationScheduled($request, $oldStatus, $newStatus, $notes);
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

    protected function notifyConsultationScheduled(
        ThesisTranscriptRequest $request,
        string $oldStatus,
        string $newStatus,
        ?string $notes = null
    ): void {
        $googleCalendarUrl  = $this->calendarEventService->generateGoogleCalendarUrl($request);
        $outlookCalendarUrl = $this->calendarEventService->generateOutlookCalendarUrl($request);
        $calendarIcs        = $this->calendarEventService->generateCalendarInvite($request);

        Mail::to($request->student_email)->send(
            new ConsultationScheduledMail(
                $request,
                $oldStatus,
                $newStatus,
                $notes,
                'student',
                $googleCalendarUrl,
                $outlookCalendarUrl,
                $calendarIcs
            )
        );

        $kaprodiUsers = User::whereHas('roles', function ($query) {
            $query->where('name', 'kaprod');
        })->get();

        foreach ($kaprodiUsers as $kaprodi) {
            if ($kaprodi->email === 'kaprod@example.com') {
                continue;
            }

            Mail::to($kaprodi->email)->send(
                new ConsultationScheduledMail(
                    $request,
                    $oldStatus,
                    $newStatus,
                    $notes,
                    'kaprodi',
                    $googleCalendarUrl,
                    $outlookCalendarUrl,
                    $calendarIcs
                )
            );
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
            if ($kaprodi->email === 'kaprod@example.com') {
                continue;
            }
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
            if ($operator->email === 'operator@example.com') {
                continue;
            }
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
