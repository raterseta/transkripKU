<x-filament::widget>
        <div class="grid grid-cols-1 gap-4 md:grid-cols-4 font-poppins">
            <div class="p-4 bg-white shadow rounded-xl">
                <div class="text-sm text-gray-500">Baru</div>
                <div class="text-2xl font-bold">{{ $this->getData()['baru'] }}</div>
            </div>
            <div class="p-4 bg-white shadow rounded-xl">
                <div class="text-sm text-gray-500">Diproses</div>
                <div class="text-2xl font-bold">{{ $this->getData()['diproses'] }}</div>
            </div>
            <div class="p-4 bg-white shadow rounded-xl">
                <div class="text-sm text-gray-500">Revisi</div>
                <div class="text-2xl font-bold">{{ $this->getData()['revisi'] }}</div>
            </div>
            <div class="p-4 bg-white shadow rounded-xl">
                <div class="text-sm text-gray-500">Selesai</div>
                <div class="text-2xl font-bold">{{ $this->getData()['selesai'] }}</div>
            </div>
        </div>
</x-filament::widget>
