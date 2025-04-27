<?php

namespace App\Http\Controllers;

use App\Mail\NotifikasiKodeTrack;
use Illuminate\Support\Facades\Mail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use App\Models\PengajuanModel;

class PengajuanController extends Controller
{
    public function store(Request $request)
    {
        // Validasi input
        $validated = $request->validate([
            'jenis_pengajuan' => 'nullable|string',
            'nama' => 'required|string',
            'nim' => 'required|numeric',
            'email' => 'required|email',
            'keperluan' => 'required|string',
            'bahasa' => 'required|string',
            'ttd' => 'required|string',
            'catatan_tambahan' => 'nullable|string',
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
        $lastPengajuan = PengajuanModel::orderBy('id', 'desc')->first();
        $lastIdNumber = 0;
        if ($lastPengajuan && $lastPengajuan->custom_id) {
            $lastIdNumber = (int) filter_var($lastPengajuan->custom_id, FILTER_SANITIZE_NUMBER_INT);
        }
        $newCustomId = 'PA' . ($lastIdNumber + 1);

        // Buat instance baru
        $pengajuan = new PengajuanModel();
        $pengajuan->custom_id = $newCustomId;

        // Isi semua data validated
        foreach ($validated as $key => $value) {
            $pengajuan->$key = $value;
        }

        // Save
        $pengajuan->save();

        Mail::to($validated['email'])->send(new NotifikasiKodeTrack($pengajuan));

        return redirect('/')->with('success', 'Pengajuan berhasil dikirim');
    

    }
}
