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
        <x-navbar-home></x-navbar-home>

        <main class="justify-center flex items-center bg-[url('/public/images/filkom-50.png')] bg-cover">
            <div class="flex flex-col items-center text-center py-36 space-y-3">
                <!-- Text Halaman -->
                <p class="font-poppins text-xl">Selamat Datang di Website</p>
                <h1 class="font-poppins font-bold text-4xl">TranskripKU</h1>

                <!-- Group Track dan Pengajuan -->
                <div class="flex flex-row space-x-20 py-16">
                    <a href="{{ url('/pengajuan-final') }}" class="shadow-sm shadow-black/50 mx-auto box-content bg-orange-500 h-10 rounded-xl flex items-center justify-center text-white">
                        <button class="px-4 py-2 min-w-[200px]">Lakukan Pengajuan Final</button>
                    </a>
                    <a href="{{ url('/pengajuan') }}" class="text-lg mx-auto box-content bg-orange-500 h-10 flex rounded-xl items-center justify-center shadow-sm shadow-black/50 text-white">
                        <button class="px-5 min-w-[200px]">Lakukan Pengajuan</button>
                    </a>
                </div>
            </div>
        </main>
    </div>
    <x-navbar-footer></x-navbar-footer>
</body>
</html>
