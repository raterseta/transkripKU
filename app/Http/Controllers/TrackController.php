<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\TrackModel;

class TrackController extends Controller
{
    public function index(Request $request)
    {
        $customId = $request->query('id'); // Ambil dari URL query string

        if ($customId) {
            // Jika ada 'id' di URL, ambil data
            $tracks = TrackModel::where('custom_id', $customId)->orderBy('updated_at', 'desc')->get();

            return view('mahasiswa.tracking.datatrack', [
                'tracks' => $tracks,
                'customId' => $customId,
            ]);
        } else {
            // Kalau belum ada 'id', munculin form input
            return view('mahasiswa.tracking.track');
        }
    }
}
