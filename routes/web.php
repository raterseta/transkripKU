<?php

use App\Http\Controllers\AcademicRequestController;
use App\Http\Controllers\ThesisRequestController;
use App\Http\Controllers\TrackController;
use Illuminate\Support\Facades\Route;

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

Route::get('/pengajuan-final', function () {
    return view('mahasiswa.pengajuan.pengajuan-final');
});

// Tampilkan halaman input custom_id
Route::get('/track', [TrackController::class, 'index'])->name('mahasiswa.tracking.track');

// Submit custom_id
Route::post('/track', [TrackController::class, 'store'])->name('mahasiswa.tracking.track.store');

// Tampilkan data track setelah pilih custom_id
Route::get('/track?id={customId}', [TrackController::class, 'show'])->name('mahasiswa.tracking.datatrack');

// CLEAN
Route::post('/academic-request', [AcademicRequestController::class, 'store']);
Route::post('/thesis-request', [ThesisRequestController::class, 'store']);
