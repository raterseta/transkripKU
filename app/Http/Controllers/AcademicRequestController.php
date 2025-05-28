<?php
namespace App\Http\Controllers;

use App\Enums\RequestStatus;
use App\Helpers\TrackingNumberGenerator;
use App\Mail\AcademicRequestMail;
use App\Models\AcademicTranscriptRequest;
use App\Services\EmailValidationService;
use App\Services\TranscriptRequestNotificationService;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Storage;

class AcademicRequestController extends Controller
{
    private EmailValidationService $emailValidator;

    public function __construct(EmailValidationService $emailValidator)
    {
        $this->emailValidator = $emailValidator;
    }

    public function store(Request $request)
    {
        // Basic validation first
        $validated = $request->validate([
            'student_nim'             => 'required|string',
            'student_name'            => 'required|string',
            'student_email'           => 'required|email',
            'student_notes'           => 'required|string',
            'needs'                   => 'required|string',
            'language'                => 'required|string',
            'signature_type'          => 'required|string|in:digital,basah',
            'supporting_document_url' => 'nullable|file|mimes:pdf,jpg,jpeg,png|max:10240',
            'transcript_url'          => 'nullable|file|mimes:pdf,jpg,jpeg,png|max:10240',
            'retrieval_notes'         => 'nullable|string',
        ]);

        // Advanced email validation
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
            $tempFilePath = $request->file('supporting_document_url')->store('temp_academic_supporting_documents', 'public');
        }

        $newTrackingNumber            = TrackingNumberGenerator::generate('TR', 'tracking_number', AcademicTranscriptRequest::class);
        $validated['status']          = RequestStatus::PROSESOPERATOR->value;
        $validated['tracking_number'] = $newTrackingNumber;

        $tempRequest                  = new AcademicTranscriptRequest($validated);
        $tempRequest->id              = 'temp-' . time();
        $tempRequest->tracking_number = $newTrackingNumber;
        $tempRequest->created_at      = now();

        DB::beginTransaction();

        try {
            // Send email (pre-validated, so high confidence of delivery)
            Mail::to($validated['student_email'])->send(new AcademicRequestMail($tempRequest));

            Log::info('Student email sent successfully', [
                'student_email'    => $validated['student_email'],
                'tracking_number'  => $newTrackingNumber,
                'email_validation' => $emailValidationResult,
            ]);

            // Send operator notifications
            $notificationService = new TranscriptRequestNotificationService();
            $notificationService->notifyOperatorsAboutNewAcademicRequest($tempRequest);

            Log::info('Operator notifications sent successfully', [
                'tracking_number' => $newTrackingNumber,
            ]);

            // Move uploaded file to permanent location
            if ($tempFilePath) {
                $finalPath = str_replace('temp_academic_supporting_documents', 'academic_supporting_documents', $tempFilePath);
                Storage::disk('public')->move($tempFilePath, $finalPath);
                $validated['supporting_document_url'] = $finalPath;
            }

            // Create the transcript request record
            $transcriptRequest = AcademicTranscriptRequest::create($validated);
            $transcriptRequest->track()->create([
                'status'                         => RequestStatus::PROSESOPERATOR,
                'tracking_number'                => $newTrackingNumber,
                'academic_transcript_request_id' => $transcriptRequest->id,
                'action_notes'                   => 'Pengajuan baru',
                'action_desc'                    => 'Pengajuan transkrip akademik diterima dan sedang diproses oleh operator',
            ]);

            DB::commit();

            return redirect('/')->with('success', 'Pengajuan berhasil dikirim. Mohon cek email Anda untuk informasi tracking number.');

        } catch (Exception $e) {
            DB::rollBack();

            // Clean up temporary file if exists
            if ($tempFilePath && Storage::disk('public')->exists($tempFilePath)) {
                Storage::disk('public')->delete($tempFilePath);
            }

            Log::error('Failed to process academic request: ' . $e->getMessage(), [
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
