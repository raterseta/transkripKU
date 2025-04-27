<?php

namespace App\Http\Controllers;

use App\Mail\NotifikasiKodeTrack;
use Illuminate\Support\Facades\Mail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use App\Models\PengajuanFinalModel;

class PengajuanFinalController extends Controller
{
    public function store(Request $request)
    {
        // Validasi input
        $validated = $request->validate([
            'jenis_pengajuan' => 'nullable|string',
            'nama' => 'required|string',
            'nim' => 'required|numeric',
            'email' => 'required|email',
            'keterangan' => 'nullable|string',
            'file_pendukung' => 'nullable|file|mimes:pdf,jpg,jpeg,png|max:10240',
            'status' => 'nullable|string',
            'file_transkrip' => 'nullable|file|mimes:pdf,jpg,jpeg,png|max:10240',
            'notes' => 'nullable|string',
        ]);

        // Handle file pendukung
        if ($request->hasFile('file_pendukung')) {
            $path = $request->file('file_pendukung')->store('file_pendukung', 'public');
            $validated['file_pendukung'] = $path;
        }

        // Handle file transkrip
        if ($request->hasFile('file_transkrip')) {
            $pathTranskrip = $request->file('file_transkrip')->store('file_transkrip', 'public');
            $validated['file_transkrip'] = $pathTranskrip;
        }

        // Generate custom_id
        $lastPengajuanFinal = PengajuanFinalModel::orderBy('id', 'desc')->first();
        $lastIdNumber = 0;
        if ($lastPengajuanFinal && $lastPengajuanFinal->custom_id) {
            $lastIdNumber = (int) filter_var($lastPengajuanFinal->custom_id, FILTER_SANITIZE_NUMBER_INT);
        }
        $newCustomId = 'PF' . ($lastIdNumber + 1); // Misal PAF1, PAF2, dst (PAF = Pengajuan Akhir Final)

        // Buat instance baru
        $pengajuanFinal = new PengajuanFinalModel();
        $pengajuanFinal->custom_id = $newCustomId;

        // Isi semua data validated
        foreach ($validated as $key => $value) {
            $pengajuanFinal->$key = $value;
        }

        // Save
        $pengajuanFinal->save();

        Mail::to($validated['email'])->send(new NotifikasiKodeTrack($pengajuanFinal));

        // Redirect
        return redirect('/')->with('success', 'Pengajuan Final berhasil dikirim');
    }
}
