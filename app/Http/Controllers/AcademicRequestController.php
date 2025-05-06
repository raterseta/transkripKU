<?php
namespace App\Http\Controllers;

use App\Enums\RequestStatus;
use App\Mail\AcademicRequestMail;
use App\Models\AcademicTranscriptRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class AcademicRequestController extends Controller
{
    public function store(Request $request)
    {
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

        if ($request->hasFile('supporting_document_url')) {
            $path                                 = $request->file('supporting_document_url')->store('academic_supporting_documents', 'public');
            $validated['supporting_document_url'] = $path;
        }

        $lastRequest = AcademicTranscriptRequest::orderBy('created_at', 'desc')->first();
        $lastNumber  = 0;

        if ($lastRequest && $lastRequest->tracking_number) {
            $matches = [];
            if (preg_match('/TR-(\d+)/', $lastRequest->tracking_number, $matches)) {
                $lastNumber = (int) $matches[1];
            }
        }

        $newTrackingNumber = 'TR-' . str_pad($lastNumber + 1, 4, '0', STR_PAD_LEFT);

        $validated['status']          = RequestStatus::PROSESOPERATOR->value;
        $validated['tracking_number'] = $newTrackingNumber;

        $transcriptRequest = AcademicTranscriptRequest::create($validated);

        $transcriptRequest->track()->create([
            'status'                         => RequestStatus::PROSESOPERATOR,
            'tracking_number'                => $newTrackingNumber,
            'academic_transcript_request_id' => $transcriptRequest->id,
            'action_notes'                   => 'Pengajuan baru',
            'action_desc'                    => 'Pengajuan transkrip akademik diterima dan sedang diproses oleh operator',
        ]);

        Mail::to($validated['student_email'])->send(new AcademicRequestMail($transcriptRequest));

        return redirect('/')->with('success', 'Pengajuan Final berhasil dikirim. Mohon cek email Anda untuk informasi tracking number.');
    }
}
