<?php
namespace App\Services;

use App\Mail\NewTranscriptRequestNotificationMail;
use App\Models\AcademicTranscriptRequest;
use App\Models\ThesisTranscriptRequest;
use App\Models\User;
use Illuminate\Support\Facades\Mail;

class TranscriptRequestNotificationService
{
    public function notifyOperatorsAboutNewAcademicRequest(AcademicTranscriptRequest $request): void
    {
        $operatorUsers = User::whereHas('roles', function ($query) {
            $query->where('name', 'super_admin');
        })->get();

        foreach ($operatorUsers as $operator) {

            if ($operator->email === 'operator@example.com') {
                continue;
            }

            Mail::to($operator->email)->send(
                new NewTranscriptRequestNotificationMail(
                    $request->tracking_number,
                    $request->student_name,
                    $request->student_nim,
                    $request->student_email,
                    $request->needs,
                    $request->language ?? null,
                    $request->signature_type->value ?? null,
                    $request->created_at,
                    'academic',
                    $request->id
                )
            );
        }
    }

    public function notifyOperatorsAboutNewThesisRequest(ThesisTranscriptRequest $request): void
    {
        $operatorUsers = User::whereHas('roles', function ($query) {
            $query->where('name', 'super_admin');
        })->get();

        foreach ($operatorUsers as $operator) {

            if ($operator->email === 'operator@example.com') {
                continue;
            }

            Mail::to($operator->email)->send(
                new NewTranscriptRequestNotificationMail(
                    $request->tracking_number,
                    $request->student_name,
                    $request->student_nim,
                    $request->student_email,
                    null,
                    null,
                    null,
                    $request->created_at,
                    'thesis',
                    $request->id
                )
            );
        }
    }
}
