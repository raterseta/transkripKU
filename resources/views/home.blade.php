<!DOCTYPE html>
<html lang="en" class="h-full bg-gray-100">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    @vite('resources/css/app.css')
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
    <title>TranskripKU</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600;700&display=swap" rel="stylesheet">

</head>
<body class="h-full">
    <div>
        @auth
            <x-navbar-admin />
        @endauth

        @guest
            <x-navbar />
        @endguest
        
        <main class="justify-center flex items-center bg-[url('/public/images/filkom-50.png')] bg-[center_30%] h-full">
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
    <x-navbar-footer></x-navbar-footer>
</body>
</html>

