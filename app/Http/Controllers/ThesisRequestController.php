<?php
namespace App\Http\Controllers;

use App\Enums\RequestStatus;
use App\Mail\NotifikasiKodeTrack;
use App\Models\ThesisTranscriptRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class ThesisRequestController extends Controller
{
    public function store(Request $request)
    {
        $validated = $request->validate([
            'student_nim'        => 'required|string',
            'student_name'       => 'required|string',
            'student_email'      => 'required|email',
            'consultation_notes' => 'nullable|string',
            'transcript_url'     => 'nullable|file|mimes:pdf,jpg,jpeg,png|max:10240',
        ]);

        if ($request->hasFile('transcript_url')) {
            $path                        = $request->file('transcript_url')->store('thesis_transcripts', 'public');
            $validated['transcript_url'] = $path;
        }

        $lastRequest = ThesisTranscriptRequest::orderBy('created_at', 'desc')->first();
        $lastNumber  = 0;
        if ($lastRequest && $lastRequest->tracking_number) {
            $matches = [];
            if (preg_match('/TH-(\d+)/', $lastRequest->tracking_number, $matches)) {
                $lastNumber = (int) $matches[1];
            }
        }
        $newTrackingNumber = 'TH-' . str_pad($lastNumber + 1, 4, '0', STR_PAD_LEFT);

        $validated['status']          = RequestStatus::PROSESOPERATOR->value;
        $validated['tracking_number'] = $newTrackingNumber;

        $thesisRequest = ThesisTranscriptRequest::create($validated);

        $thesisRequest->track()->create([
            'status'                       => RequestStatus::PROSESOPERATOR,
            'tracking_number'              => $newTrackingNumber,
            'action_notes'                 => 'Pengajuan baru',
            'action_desc'                  => 'Pengajuan transkrip skripsi diterima dan sedang diproses oleh operator',
            'thesis_transcript_request_id' => $thesisRequest->id,
        ]);

        Mail::to($validated['student_email'])->send(
            new NotifikasiKodeTrack($thesisRequest)
        );

        return redirect('/')->with('success', 'Pengajuan transkrip skripsi berhasil dikirim');
    }
}
