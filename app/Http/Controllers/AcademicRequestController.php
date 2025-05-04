<?php
namespace App\Http\Controllers;

use App\Enums\RequestStatus;
use App\Mail\NotifikasiKodeTrack;
use App\Models\AcademicTranscriptRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class AcademicRequestController extends Controller
{
    public function store(Request $request)
    {
        $validated = $request->validate([
            'student_nim'     => 'required|string',
            'student_name'    => 'required|string',
            'student_email'   => 'required|email',
            'needs'           => 'required|string',
            'language'        => 'required|string',
            'signature_type'  => 'required|string|in:digital,basah',
            'transcript_url'  => 'nullable|file|mimes:pdf,jpg,jpeg,png|max:10240',
            'retrieval_notes' => 'nullable|string',
        ]);

        if ($request->hasFile('transcript_url')) {
            $path                        = $request->file('transcript_url')->store('transcripts', 'public');
            $validated['transcript_url'] = $path;
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
            'status'          => RequestStatus::PROSESOPERATOR,
            'tracking_number' => $newTrackingNumber,
            'action_notes'    => 'Pengajuan baru',
            'action_desc'     => 'Pengajuan transkrip akademik diterima dan sedang diproses oleh operator',
        ]);

        Mail::to($validated['student_email'])->send(
            new NotifikasiKodeTrack($transcriptRequest)
        );

        return redirect('/')->with('success', 'Pengajuan Final berhasil dikirim');
    }
}
