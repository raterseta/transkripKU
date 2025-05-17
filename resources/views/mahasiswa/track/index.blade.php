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
    <main class="flex justify-center items-center px-4 sm:px-6 lg:px-8 mt-10 h-[90dvh]">
      <div class="flex flex-col w-full max-w-3xl pb-48">

        <!-- Navigasi dan judul -->
        <div class="flex flex-row items-center pb-16">
          <a href="{{ url('/') }}" class="flex items-center space-x-2 transition">
            <span class="text-4xl font-semibold">&larr;</span>
          </a>
            <p class="text-xl font-poppins text-center flex-1 pr-8">Track Pengajuanmu</p>
        </div>

        <!-- Form Box -->
         <img src="/images/truck.svg" alt="" class="h-20 w-20">
        <div class="w-full bg-white shadow-xl shadow-black/50 rounded-2xl px-6 py-8 space-y-4">
          <!-- Input Group -->
          <form method="GET" action="{{ route('track.show') }}">
            <div class="space-y-2 text-left font-poppins">
              <label for="tracking" class="font-semibold">Masukkan Nomor Tracking Kamu</label>
              <input
                id="tracking"
                name="id"
                type="text"
                placeholder="Nomor Tracking"
                class="text-sm w-full px-3 py-2 rounded-md border border-gray-300 focus:outline-none focus:ring-2 focus:ring-orange-300"
              />
            </div>

            <div class="pt-6 flex justify-center">
              <button type="submit" class="w-1/6 bg-orange-500 hover:bg-orange-600 text-white py-2 rounded-md transition font-semibold">
                Lacak
              </button>
            </div>
          </form>
        </div>
      </div>
    </main>
    <x-navbar-footer></x-navbar-footer>

  </div>
</body>
</html>
