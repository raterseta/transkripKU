@extends('layouts.app')

@section('content')
<div x-data="{ showPopup: false }">
    <!-- Section Utama -->
    <main class="flex items-center justify-center bg-[url('/public/images/filkom-50.png')] bg-cover bg-center min-h-screen px-4">
        <div class="text-center max-w-2xl w-full py-20 sm:py-32 space-y-6 rounded-xl">
            <!-- Judul dan Subjudul -->
            <p class="text-base sm:text-lg text-gray-700">Selamat Datang di Website</p>
            <h1 class="text-3xl sm:text-5xl font-bold text-gray-900">TranskripKU</h1>

            <!-- Tombol Aksi -->
            <div class="flex flex-col sm:flex-row items-center justify-center gap-4 sm:gap-8 pt-10">
                <a href="{{ url('/pengajuan-final') }}" class="w-full sm:w-auto">
                    <button class="w-1/2 sm:w-full max-w-3/4 sm:min-w-[200px] px-4 py-2 bg-orange-500 hover:bg-orange-600 text-white font-semibold rounded-xl shadow shadow-black/30 transition">
                        Lakukan Pengajuan Final
                    </button>
                </a>
                <a href="{{ url('/pengajuan') }}" class="w-full sm:w-auto">
                    <button class="w-1/2 sm:w-full max-w-3/4 sm:min-w-[200px] px-4 py-2 bg-orange-500 hover:bg-orange-600 text-white font-semibold rounded-xl shadow shadow-black/30 transition">
                        Lakukan Pengajuan
                    </button>
                </a>
            </div>
        </div>
    </main>
</div>
@endsection
