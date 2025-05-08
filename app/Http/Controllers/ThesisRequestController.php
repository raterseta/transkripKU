<?php
namespace App\Http\Controllers;

use App\Enums\RequestStatus;
use App\Helpers\TrackingNumberGenerator;
use App\Mail\ThesisRequestMail;
use App\Models\ThesisTranscriptRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class ThesisRequestController extends Controller
{
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

        if ($request->hasFile('supporting_document_url')) {
            $path                                 = $request->file('supporting_document_url')->store('thesis_supporting_documents', 'public');
            $validated['supporting_document_url'] = $path;
        }

        $newTrackingNumber = TrackingNumberGenerator::generate('TH', 'tracking_number', ThesisTranscriptRequest::class);

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

        Mail::to($validated['student_email'])->send(new ThesisRequestMail($thesisRequest));

        return redirect('/')->with('success', 'Pengajuan transkrip skripsi berhasil dikirim');
    }
}
