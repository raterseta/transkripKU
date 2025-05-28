<?php
namespace App\Http\Controllers;

use App\Models\RequestTrack;
use Illuminate\Http\Request;
use Illuminate\View\View;

class RequestTrackController extends Controller
{
    public function show(Request $request): View
    {
        $tracking_number = $request->input('id');

        if (! $tracking_number) {
            return view('track.index');
        }

        $tracks = RequestTrack::where('tracking_number', $tracking_number)
            ->orderBy('created_at', 'desc')
            ->get();

        if ($tracks->isEmpty()) {
            return view('mahasiswa.track.result', [
                'tracks'         => collect(),
                'trackingNumber' => $tracking_number,
                'requestData'    => null,
            ])->with('error', 'Nomor tracking tidak ditemukan');
        }

        $firstTrack  = $tracks->first();
        $requestData = $firstTrack->getRequest();

        $createdAt       = $firstTrack->created_at;
        $now             = now();
        $duration        = $createdAt->diff($now);
        $durationInDays  = $duration->days;
        $durationInHours = $duration->h;

        return view('mahasiswa.track.result', [
            'tracks'         => $tracks,
            'trackingNumber' => $tracking_number,
            'requestData'    => $requestData,
            'durationDays'   => $durationInDays,
            'durationHours'  => $durationInHours,
        ]);
    }

    public function index(): View
    {
        return view('mahasiswa.track.index');
    }
}
