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
        <nav class="bg-blue-950" x-data="{ isMobileOpen: false, isLaptopOpen: false }">
            <div class="mx-auto px-2 sm:px-6 lg:px-8">
                <div class="relative flex h-16 items-center justify-between">
                <!-- <div class="absolute inset-y-0 left-0 flex items-center sm:hidden">

                </div> -->
                <!--Tab Nav 1-->
                <div class="flex flex-1 items-center sm:items-stretch">
                    <!--Tab ikon-->
                    <a href="{{ url('/') }}" class="flex shrink-0 items-center">
                        <img src="{{ asset('images/ubub.png') }}" alt="ubub" class="w-auto h-9" />
                    </a>
                </div>
                <div class="absolute inset-y-0 right-0 flex items-center pr-2 sm:static sm:inset-auto sm:ml-6 sm:pr-0">
                    <!-- Profile dropdown -->
                    <div class="relative ml-3 flex flex-row">
                        <!-- <div class="pr-6 lg:pr-16">
                            <a href="{{ url('/track') }}">
                                <button class="bg-orange-500 rounded-2xl px-3 py-1 text-sm">Track Pengajuan</button>
                            </a>
                        </div> -->
                        <div>
                            <button class="inline-flex border border-transparent text-sm leading-4 font-medium rounded-md text-white hover:text-gray-700 dark:hover:text-gray-300 focus:outline-none transition ease-in-out duration-150" id="user-menu-button" aria-expanded="false" aria-haspopup="true">
                                <a href="{{ url('/login') }}">
                                    <img src="{{ asset('images/user.svg') }}" alt="My SVG" class="w-6 h-6" />
                                </a>
                            </button>
                        </div>

                    </div>
                </div>
                </div>
            </div>
        </nav>
        <main class="justify-center flex items-center">
            <div class="flex flex-col items-center text-center py-36 space-y-3">
                <!-- Text Halaman -->
                <p class="font-poppins text-xl">Selamat Datang di Website</p>
                <h1 class="font-poppins font-bold text-4xl">TranskripKU</h1>

                <!-- Group Track dan Pengajuan -->
                <div class="flex flex-row space-x-20 py-16">
                    <a href="{{ url('/pengajuan-final') }}" class="shadow-md shadow-black/50 mx-auto box-content bg-orange-500 h-10 rounded-2xl flex items-center justify-center">
                        <button class="px-2">Lakukan Pengajuan Final</button>
                    </a>
                    <a href="{{ url('/pengajuan') }}" class="text-lg mx-auto box-content bg-orange-500 h-10 flex rounded-2xl flex items-center justify-center shadow-md shadow-black/50">
                        <button class="px-5">Lakukan Pengajuan</button>
                    </a>
                </div>
            </div>
        </main>
    </div>
</body>
</html>
