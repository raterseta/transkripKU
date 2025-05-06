<!DOCTYPE html>
<html lang="en" class="h-full bg-gray-100">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  @vite('resources/css/app.css')
  <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
  <title>TranskripKU</title>
</head>
<body class="h-full">
  <div>
    @auth
      <x-navbar-admin-notrack />
    @endauth

    @guest
       <x-navbar-notrack />
    @endguest
    <div class="flex justify-center items-start px-4 sm:px-6 lg:px-8 mt-10 pb-20 min-h-[80vh]">
        <div class="flex flex-col w-full max-w-3xl">
            <div class="flex flex-row items-center pb-8">
                <a href="{{ route('track.index') }}" class="flex items-center space-x-2">
                    <span class="text-4xl font-semibold">&larr;</span>
                </a>
                <h1 class="text-2xl font-poppins font-semibold text-center flex-1 pr-8">Track Pengajuanmu</h1>
            </div>

            @if(session('error') || $tracks->isEmpty())
                <div class="bg-red-100 border-l-4 border-red-500 text-red-700 p-4 mb-6" role="alert">
                    <p class="font-semibold">Data tidak ditemukan</p>
                    <p>Nomor tracking {{ $trackingNumber }} tidak ditemukan dalam sistem.</p>
                </div>
                <div class="flex justify-center mt-4">
                    <a href="{{ route('track.index') }}" class="bg-gray-700 hover:bg-gray-800 text-white font-semibold py-2 px-6 rounded-lg transition duration-300">
                        Kembali
                    </a>
                </div>
            @else
                <h2 class="text-3xl font-semibold font-poppins mb-8 text-center">Halo {{ $requestData->student_name }}</h2>

                <div class="bg-white shadow-lg rounded-2xl p-6">
                    <div class="flex justify-between items-center mb-8">
                        <h2 class="text-2xl font-semibold">Status</h2>
                        <div class="text-right">
                            <p class="text-lg font-medium">Estimasi: 3 hari</p>
                        </div>
                    </div>

                    <div class="relative">
                        @foreach($tracks as $index => $track)
                            <div class="flex mb-8 relative">
                                <div class="mr-4 relative z-10">
                                    <div class="bg-white p-2 rounded-lg border border-gray-200 shadow-sm">
                                        @switch($track->status)
                                            @case(\App\Enums\RequestStatus::SELESAI)
                                                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-green-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                                                </svg>
                                                @break

                                            @case(\App\Enums\RequestStatus::DITOLAK)
                                                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-red-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 14l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2m7-2a9 9 0 11-18 0 9 9 0 0118 0z" />
                                                </svg>
                                                @break

                                            @case(\App\Enums\RequestStatus::DIKEMBALIKANKEOPERATOR)

                                            @case(\App\Enums\RequestStatus::DIKEMBALIKANKEKAPRODI)
                                                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-yellow-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
                                                </svg>
                                                @break

                                            @case(\App\Enums\RequestStatus::PROSESOPERATOR)
                                            @case(\App\Enums\RequestStatus::PROSESKAPRODI)
                                                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-blue-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15" />
                                                </svg>
                                                @break

                                            @case(\App\Enums\RequestStatus::DITERUSKANKEOPERATOR)
                                                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-blue-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 5l7 7-7 7M5 5l7 7-7 7" />
                                                </svg>
                                                @break

                                            @default
                                                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-blue-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                                                </svg>
                                        @endswitch
                                    </div>

                                    <!-- Vertical line -->
                                    @if($index < count($tracks) - 1)
                                        <div class="absolute left-1/2 top-10 bottom-0 w-0.5 bg-gray-300 -ml-0.5 h-full"></div>
                                    @endif
                                </div>

                                <div class="flex-1">
                                    <p class="text-sm text-gray-500 mb-1">
                                        {{ \Carbon\Carbon::parse($track->created_at)->format('d M Y - H:i') }} WIB
                                    </p>

                                    <p class="text-base">{{ $track->action_desc }}</p>
                                </div>
                            </div>
                        @endforeach
                    </div>

                    <div class="flex items-center mt-6 pt-6 border-t border-gray-200">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2 text-gray-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" />
                        </svg>
                        <p>Nomor Tracking: <span class="font-medium">{{ $trackingNumber }}</span></p>
                    </div>
                </div>
            @endif
        </div>
    </div>
  </div>
  <x-navbar-footer />
</body>
</html>
