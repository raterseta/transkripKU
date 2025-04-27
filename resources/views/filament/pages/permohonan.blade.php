<x-filament::page>
    <div class="grid grid-cols-1 gap-4 md:grid-cols-4 font-poppins mb-6 w-full">
        @livewire(\App\Filament\Widgets\StatusPermohonanOverview::class)
    </div>

    {{ $this->table }}
</x-filament::page>
