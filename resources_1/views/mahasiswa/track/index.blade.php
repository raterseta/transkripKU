<!DOCTYPE html>
<html lang="en" class="h-full">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  @vite('resources/css/app.css')
  <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
  <title>TranskripKU</title>
</head>
<body class="h-full bg-gray-100">
  <div>
      @auth
        <x-navbar-admin-notrack />
      @endauth

      @guest
        <x-navbar-notrack />
      @endguest
    <main class="flex justify-center items-center px-4 sm:px-6 lg:px-8 mt-10">
      <div class="flex flex-col w-full max-w-3xl pb-48">

        <!-- Navigasi dan judul -->
        <div class="flex flex-col">
          <div class="pb-6">
            <nav class="text-gray-500 text-sm font-medium" aria-label="Breadcrumb">
              <ol class="inline-flex items-center space-x-1 md:space-x-3">
                <li class="inline-flex items-center">
                  <a href="/" class="inline-flex items-center text-gray-500 hover:text-gray-700">
                    Home
                  </a>
                </li>
                <li>
                  <div class="flex items-center">
                    <svg class="w-4 h-4 mx-2 text-gray-400 mt-1" fill="currentColor" viewBox="0 0 20 20">
                      <path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L11.586 9 7.293 4.707a1 1 0 011.414-1.414l5 5a1 1 0 010 1.414l-5 5a1 1 0 01-1.414 0z" clip-rule="evenodd" />
                    </svg>
                    <span class="text-gray-500">Track Pengajuan</span>
                  </div>
                </li>
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
