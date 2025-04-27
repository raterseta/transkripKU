<?php

use App\Http\Controllers\PengajuanController;
use App\Http\Controllers\PengajuanFinalController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\TrackController;


// Route::get('/', function () {
//     return view('welcome');
// });

// Route::get('/app', function () {
//     return view('app');
// });

Route::get('/', function () {
    return view('home', ['title' => 'Home Page']);
});

Route::get('/pengajuan', function () {
    return view('mahasiswa.pengajuan.pengajuan');
});

Route::post('/pengajuan', [PengajuanController::class, 'store']);

Route::get('/pengajuan-final', function () {
    return view('mahasiswa.pengajuan.pengajuan-final');
});

Route::post('/pengajuan-final', [PengajuanFinalController::class, 'store']);


// Tampilkan halaman input custom_id
Route::get('/track', [TrackController::class, 'index'])->name('mahasiswa.tracking.track');

// Submit custom_id
Route::post('/track', [TrackController::class, 'store'])->name('mahasiswa.tracking.track.store');

// Tampilkan data track setelah pilih custom_id
Route::get('/track?id={customId}', [TrackController::class, 'show'])->name('mahasiswa.tracking.datatrack');
