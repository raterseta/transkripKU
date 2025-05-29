<?php
namespace App\Http\Controllers;

use App\Enums\RequestStatus;
use App\Helpers\TrackingNumberGenerator;
use App\Mail\ThesisRequestMail;
use App\Models\ThesisTranscriptRequest;
use App\Services\EmailValidationService;
use App\Services\TranscriptRequestNotificationService;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Storage;

class ThesisRequestController extends Controller
{

    private EmailValidationService $emailValidator;

    public function __construct(EmailValidationService $emailValidator)
    {
        $this->emailValidator = $emailValidator;
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'student_nim'             => 'required|string',
            'student_name'            => 'required|string',
            'student_email'           => 'required|email',
            'student_notes'           => 'nullable|string',
            'consultation_notes'      => 'nullable|string',
            'supporting_document_url' => 'nullable|file|mimes:pdf,jpg,jpeg,png|max:10240',
            'transcript_url'          => 'nullable|file|mimes:pdf,jpg,jpeg,png|max:10240',
        ]);

        $emailValidationResult = $this->emailValidator->validateEmail($validated['student_email']);

        if (! $emailValidationResult['is_valid']) {
            Log::warning('Email validation failed', [
                'email'   => $validated['student_email'],
                'reason'  => $emailValidationResult['reason'],
                'details' => $emailValidationResult['details'],
            ]);

            return back()->withErrors([
                'student_email' => $this->getEmailErrorMessage($emailValidationResult['reason']),
            ])->withInput();
        }

        $tempFilePath = null;
        if ($request->hasFile('supporting_document_url')) {
            $tempFilePath = $request->file('supporting_document_url')->store('temp_thesis_supporting_documents', 'public');
        }

        $newTrackingNumber            = TrackingNumberGenerator::generate('TTR', 'tracking_number', ThesisTranscriptRequest::class);
        $validated['status']          = RequestStatus::PROSESOPERATOR->value;
        $validated['tracking_number'] = $newTrackingNumber;

        $tempRequest                  = new ThesisTranscriptRequest($validated);
        $tempRequest->id              = 'temp-' . time();
        $tempRequest->tracking_number = $newTrackingNumber;
        $tempRequest->created_at      = now();

        DB::beginTransaction();

        try {
            Mail::to($validated['student_email'])->send(new ThesisRequestMail($tempRequest));

            Log::info('Student email sent successfully', [
                'student_email'    => $validated['student_email'],
                'tracking_number'  => $newTrackingNumber,
                'email_validation' => $emailValidationResult,
            ]);

            $notificationService = new TranscriptRequestNotificationService();
            $notificationService->notifyOperatorsAboutNewThesisRequest($tempRequest);

            Log::info('Operator notifications sent successfully', [
                'tracking_number' => $newTrackingNumber,
            ]);

            if ($tempFilePath) {
                $finalPath = str_replace('temp_thesis_supporting_documents', 'thesis_supporting_documents', $tempFilePath);
                Storage::disk('public')->move($tempFilePath, $finalPath);
                $validated['supporting_document_url'] = $finalPath;
            }

            $transcriptRequest = ThesisTranscriptRequest::create($validated);
            $transcriptRequest->track()->create([
                'status'                       => RequestStatus::PROSESOPERATOR,
                'tracking_number'              => $newTrackingNumber,
                'thesis_transcript_request_id' => $transcriptRequest->id,
                'action_notes'                 => 'Pengajuan baru',
                'action_desc'                  => 'Pengajuan transkrip final diterima dan sedang diproses oleh operator',
            ]);

            DB::commit();

            return redirect('/')->with('success', 'Pengajuan berhasil dikirim. Mohon cek email Anda untuk informasi tracking number.');

        } catch (Exception $e) {
            DB::rollBack();

            if ($tempFilePath && Storage::disk('public')->exists($tempFilePath)) {
                Storage::disk('public')->delete($tempFilePath);
            }

            Log::error('Failed to process thesis request: ' . $e->getMessage(), [
                'student_email'   => $validated['student_email'],
                'tracking_number' => $newTrackingNumber,
                'error'           => $e->getMessage(),
                'trace'           => $e->getTraceAsString(),
            ]);

            return back()->withErrors([
                'email_error' => 'Terjadi kesalahan dalam memproses pengajuan. Silakan coba lagi.',
            ])->withInput();
        }
    }

    private function getEmailErrorMessage(string $reason): string
    {
        return match ($reason) {
            'invalid_syntax' => 'Format alamat email tidak valid. Periksa kembali penulisan email Anda.',
            'disposable_email' => 'Email sementara/disposable tidak diperbolehkan. Gunakan alamat email aktif Anda.',
            'no_mx_record' => 'Domain email tidak valid atau tidak dapat menerima email.',
            'risky_domain' => 'Domain email terdeteksi berisiko. Gunakan email dari penyedia terpercaya.',
            'role_based' => 'Email berbasis peran (seperti admin@, info@) tidak diperbolehkan. Gunakan email personal Anda.',
            'catch_all_risky' => 'Domain email ini memiliki konfigurasi yang tidak disarankan.',
            default => 'Alamat email tidak valid. Pastikan email Anda benar dan aktif.',
        };
    }

}
