<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login Admin</title>
    @vite(['resources/css/app.css']) {{-- atau link ke Tailwind CSS --}}
    @livewireStyles
</head>
<body class="bg-white min-h-screen flex items-center justify-center bg-gray-100 px-4 text-black w-full">
    <div class="bg-white rounded-2xl shadow-xl w-[1000px] max-w-md p-6 sm:p-8 text-black">
        <div class="text-center mb-6">
            <a href="/">
                <img src="/images/login.png" alt="Logo Fakultas" class="h-6 mx-auto mb-4">
            </a>
            <h1 class="text-2xl font-semibold">Sign in</h1>
        </div>

        <form wire:submit.prevent="authenticate" class="space-y-8">
            <div class="space-y-4 text-black">
                {{ $this->form }}

                <x-filament::button 
                    type="submit" 
                    class="w-full bg-orange-600 hover:bg-orange-700 text-white font-semibold flex items-center justify-center gap-2">
                        <p class="text-white" wire:loading.remove wire:target="authenticate">Login</p>
                        <p class="text-white" wire:loading wire:target="authenticate">Loading...</p>
                </x-filament::button>
                <p class="font-poppins text-sm font-medium">Back to <a href="/" class="text-blue-500">Home</a>?</p>
            </div>
        </form>
    </div>

    @livewireScripts
</body>
</html>
