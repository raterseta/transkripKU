<?php

use App\Http\Controllers\AcademicRequestController;
use App\Http\Controllers\RequestTrackController;
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

// Tampilkan data track setelah pilih custom_id
Route::get('/track?id={customId}', [TrackController::class, 'show'])->name('mahasiswa.tracking.datatrack');

// CLEAN
Route::post('/academic-request', [AcademicRequestController::class, 'store']);
Route::post('/thesis-request', [ThesisRequestController::class, 'store']);

Route::get('/track', [RequestTrackController::class, 'index'])->name('track.index');
Route::get('/track/show', [RequestTrackController::class, 'show'])->name('track.show');
