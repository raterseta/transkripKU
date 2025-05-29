<?php
namespace App\Http\Controllers;

use App\Models\RequestTrack;
use App\Utils\RequestEstimationUtils;
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

        $createdAt    = $firstTrack->created_at;
        $now          = now();
        $duration     = $createdAt->diff($now);
        $durationDays = $duration->d;

        $deadline = str_starts_with($tracking_number, 'ATR') ? 3 : 10;

        $estimation  = RequestEstimationUtils::getEstimatedCompletion($requestData, $deadline);
        $processTime = RequestEstimationUtils::calculateProcessingTime($requestData);

        return view('mahasiswa.track.result', [
            'tracks'         => $tracks,
            'trackingNumber' => $tracking_number,
            'requestData'    => $requestData,
            'estimation'     => $estimation,
            'deadline'       => $deadline,
            'processTime'    => $processTime,
            'durationDays'   => $durationDays,
        ]);
    }

    public function index(): View
    {
        return view('mahasiswa.track.index');
    }
}
