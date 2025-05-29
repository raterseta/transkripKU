@extends('layouts.app')

@section('content')
    <div class="flex justify-center items-start px-4 sm:px-6 lg:px-8 mt-10 pb-20">
        <div class="flex flex-col w-full max-w-3xl">

            <div class="flex flex-col">
                <div class="pb-6">
                    <nav class="text-gray-500 text-sm font-medium" aria-label="Breadcrumb">
                    <ol class="inline-flex items-center space-x-1 md:space-x-3">
                        <li class="inline-flex items-center">
                        <a href="/" class="inline-flex items-center text-gray-500 hover:text-gray-700">
                            Home
                        </a>
                        </li>
                        @if(isset($trackingNumber))
                        <li>
                        <div class="flex items-center">
                            <svg class="w-4 h-4 mx-2 text-gray-400 mt-1" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L11.586 9 7.293 4.707a1 1 0 011.414-1.414l5 5a1 1 0 010 1.414l-5 5a1 1 0 01-1.414 0z" clip-rule="evenodd" />
                            </svg>
                            <a href="/track" class="inline-flex items-center text-gray-500 hover:text-gray-700">
                            Track Pengajuan
                        </a>
                        </div>
                        </li>
                        <li>
                        <div class="flex items-center">
                            <svg class="w-4 h-4 mx-2 text-gray-400 mt-1" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L11.586 9 7.293 4.707a1 1 0 011.414-1.414l5 5a1 1 0 010 1.414l-5 5a1 1 0 01-1.414 0z" clip-rule="evenodd" />
                            </svg>
                            <span class="text-gray-500">Cek Pengajuan</span>
                        </div>
                        </li>
                        @else
                        <li>
                        <div class="flex items-center">
                            <svg class="w-4 h-4 mx-2 text-gray-400 mt-1" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L11.586 9 7.293 4.707a1 1 0 011.414-1.414l5 5a1 1 0 010 1.414l-5 5a1 1 0 01-1.414 0z" clip-rule="evenodd" />
                            </svg>
                            <span class="text-gray-500">Track Pengajuan</span>
                        </div>
                        </li>
                        @endif
                    </ol>
                    </nav>
                </div>
                <div class="flex flex-row items-center pb-16">
                    <a href="{{ url('/') }}" class="flex items-center space-x-2 transition">
                    <span class="text-4xl font-semibold">&larr;</span>
                    </a>
                    <p class="text-xl font-poppins text-center flex-1 pr-8">Track Pengajuan</p>
                </div>
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
                            <p class="text-sm {{ $durationDays > 3 ? 'text-red-600' : 'text-gray-600' }} mt-1 font-medium">
                                Diajukan: @if($durationDays > 0){{ $durationDays }} hari @endif @if($durationHours > 0){{ $durationHours }} jam @endif yang lalu
                            </p>
                        </div>
                    </div>

                    <div class="relative">
                        @foreach($tracks as $index => $track)
                            <div class="flex mb-8 relative">
                                <div class="mr-4 relative z-10">
                                    <div class="bg-gray-300 p-2 rounded-lg border border-gray-200 shadow-sm">
                                        @switch($track->status)
                                            @case(\App\Enums\RequestStatus::SELESAI)
                                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6 text-white">
                                                    <path stroke-linecap="round" stroke-linejoin="round" d="M11.35 3.836c-.065.21-.1.433-.1.664 0 .414.336.75.75.75h4.5a.75.75 0 0 0 .75-.75 2.25 2.25 0 0 0-.1-.664m-5.8 0A2.251 2.251 0 0 1 13.5 2.25H15c1.012 0 1.867.668 2.15 1.586m-5.8 0c-.376.023-.75.05-1.124.08C9.095 4.01 8.25 4.973 8.25 6.108V8.25m8.9-4.414c.376.023.75.05 1.124.08 1.131.094 1.976 1.057 1.976 2.192V16.5A2.25 2.25 0 0 1 18 18.75h-2.25m-7.5-10.5H4.875c-.621 0-1.125.504-1.125 1.125v11.25c0 .621.504 1.125 1.125 1.125h9.75c.621 0 1.125-.504 1.125-1.125V18.75m-7.5-10.5h6.375c.621 0 1.125.504 1.125 1.125v9.375m-8.25-3 1.5 1.5 3-3.75" />
                                                </svg>
                                                @break

                                            @case(\App\Enums\RequestStatus::DITOLAK)
                                                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-red-500" fill="none" viewBox="0 0 24 24" stroke="currentColor" class="size-6 text-white">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 14l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2m7-2a9 9 0 11-18 0 9 9 0 0118 0z" />
                                                </svg>
                                                @break

                                            @case(\App\Enums\RequestStatus::DIKEMBALIKANKEOPERATOR)


                                            @case(\App\Enums\RequestStatus::DIKEMBALIKANKEKAPRODI)
                                                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-yellow-500" fill="none" viewBox="0 0 24 24" stroke="currentColor" class="size-6 text-white">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
                                                </svg>
                                                @break

                                            @case(\App\Enums\RequestStatus::PROSESOPERATOR)
                                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6 text-white">
                                                    <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 14.25v-2.625a3.375 3.375 0 0 0-3.375-3.375h-1.5A1.125 1.125 0 0 1 13.5 7.125v-1.5a3.375 3.375 0 0 0-3.375-3.375H8.25m0 12.75h7.5m-7.5 3H12M10.5 2.25H5.625c-.621 0-1.125.504-1.125 1.125v17.25c0 .621.504 1.125 1.125 1.125h12.75c.621 0 1.125-.504 1.125-1.125V11.25a9 9 0 0 0-9-9Z" />
                                                </svg>
                                                @break

                                            @case(\App\Enums\RequestStatus::PROSESKAPRODI)
                                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6 text-white">
                                                    <path stroke-linecap="round" stroke-linejoin="round" d="m16.862 4.487 1.687-1.688a1.875 1.875 0 1 1 2.652 2.652L10.582 16.07a4.5 4.5 0 0 1-1.897 1.13L6 18l.8-2.685a4.5 4.5 0 0 1 1.13-1.897l8.932-8.931Zm0 0L19.5 7.125M18 14v4.75A2.25 2.25 0 0 1 15.75 21H5.25A2.25 2.25 0 0 1 3 18.75V8.25A2.25 2.25 0 0 1 5.25 6H10" />
                                                </svg>
                                                @break

                                            @case(\App\Enums\RequestStatus::DITERUSKANKEOPERATOR)
                                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6 text-white">
                                                    <path stroke-linecap="round" stroke-linejoin="round" d="M9.53 16.122a3 3 0 0 0-5.78 1.128 2.25 2.25 0 0 1-2.4 2.245 4.5 4.5 0 0 0 8.4-2.245c0-.399-.078-.78-.22-1.128Zm0 0a15.998 15.998 0 0 0 3.388-1.62m-5.043-.025a15.994 15.994 0 0 1 1.622-3.395m3.42 3.42a15.995 15.995 0 0 0 4.764-4.648l3.876-5.814a1.151 1.151 0 0 0-1.597-1.597L14.146 6.32a15.996 15.996 0 0 0-4.649 4.763m3.42 3.42a6.776 6.776 0 0 0-3.42-3.42" />
                                                </svg>
                                                @break

                                            @default
                                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6 text-white">
                                                    <path stroke-linecap="round" stroke-linejoin="round" d="M4.26 10.147a60.438 60.438 0 0 0-.491 6.347A48.62 48.62 0 0 1 12 20.904a48.62 48.62 0 0 1 8.232-4.41 60.46 60.46 0 0 0-.491-6.347m-15.482 0a50.636 50.636 0 0 0-2.658-.813A59.906 59.906 0 0 1 12 3.493a59.903 59.903 0 0 1 10.399 5.84c-.896.248-1.783.52-2.658.814m-15.482 0A50.717 50.717 0 0 1 12 13.489a50.702 50.702 0 0 1 7.74-3.342M6.75 15a.75.75 0 1 0 0-1.5.75.75 0 0 0 0 1.5Zm0 0v-3.675A55.378 55.378 0 0 1 12 8.443m-7.007 11.55A5.981 5.981 0 0 0 6.75 15.75v-1.5" />
                                                </svg>
                                        @endswitch
                                    </div>

                                    <!-- Vertical line -->
                                    @if($index < count($tracks) - 1)
                                        <div class="absolute left-1/2 top-10 bottom-0 w-0.5 bg-gray-300 -ml-0.5 h-full"></div>
                                    @endif
                                </div>

                                <div class="flex-1">


                                    @switch($track->status)
                                    @case(\App\Enums\RequestStatus::SELESAI)
                                    <p class="text-sm text-orange-600 mb-1">
                                        {{ \Carbon\Carbon::parse($track->created_at)->format('d M Y - H:i') }} WIB
                                    </p>
                                    <p class="text-base text-orange-600">{{ $track->action_desc }}</p>
                                    @break

                                    @case(\App\Enums\RequestStatus::DITOLAK)
                                    <p class="text-sm text-red-600 mb-1">
                                        {{ \Carbon\Carbon::parse($track->created_at)->format('d M Y - H:i') }} WIB
                                    </p>
                                    <p class="text-base text-red-600">{{ $track->action_desc }}</p>
                                    @break

                                    @default
                                    <p class="text-sm text-gray-400 mb-1">
                                        {{ \Carbon\Carbon::parse($track->created_at)->format('d M Y - H:i') }} WIB
                                    </p>
                                    <p class="text-base text-gray-400">{{ $track->action_desc }}</p>
                                    @endswitch
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
@endsection
