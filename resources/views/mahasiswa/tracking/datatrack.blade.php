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
    <main class="flex justify-center items-start px-4 sm:px-6 lg:px-8 mt-10">
      <div class="flex flex-col w-full max-w-3xl pb-48">

        <!-- Navigasi -->
        <div class="flex flex-row items-center pb-16">
          <a href="{{ url('/') }}" class="flex items-center space-x-2 transition">
            <span class="text-4xl font-semibold">&larr;</span>
          </a>
          <p class="text-xl font-poppins text-center flex-1 pr-8">Track Pengajuanmu</p>
        </div>

        <!-- Nama -->
        <div class="text-left mb-6">
          @if($tracks->isNotEmpty())
            <p class="text-lg font-semibold font-poppins">Halo {{ $tracks->first()->nama }}</p>
            <p class="text-sm text-gray-600">NIM: {{ $tracks->first()->nim }}</p>
          @else
            <p class="text-lg font-semibold font-poppins">Data tidak ditemukan</p>
          @endif
        </div>

        <!-- Form Box -->
        <div class="w-full bg-white shadow-xl shadow-black/50 rounded-2xl px-6 py-8 space-y-6">
          <!-- Status Tracking -->
          <div class="space-y-4 text-left">
            <p class="text-2xl font-bold font-poppins text-gray-700">Riwayat Status</p>

            <!-- Looping Riwayat Status -->
            @forelse($tracks as $r)
              <div class="border rounded-xl p-4 bg-gray-50">
                <p class="text-lg font-semibold text-green-700">{{ ucfirst($r->status) }}</p>
                <p class="text-sm text-gray-500">
                  Diperbarui pada: {{ \Carbon\Carbon::parse($r->updated_at)->format('d M Y, H:i') }}
                </p>
              </div>
            @empty
              <div class="border rounded-xl p-4 bg-gray-50">
                <p class="text-lg font-semibold text-gray-400">Belum ada riwayat status.</p>
              </div>
            @endforelse

            <!-- Nomor Tracking -->
            <div class="flex flex-row space-x-2 pt-6 pl-1">
              <img src="/images/file.svg" alt="icon file" class="w-4 h-6">
              <p>Nomor Tracking: {{ $customId }}</p>
            </div>
          </div>

        </div>

      </div>
    </main>
  </div>
  <x-navbar-footer />
</body>
</html>
