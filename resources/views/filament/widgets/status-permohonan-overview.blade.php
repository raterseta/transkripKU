<x-filament::widget>
    
    <div class="grid gap-4 grid-cols-1 sm:grid-cols-2 md:grid-cols-4 font-poppins flex flex-row justify-center lg:w-[870px] md:w-[740px]">
        <div class="p-4 bg-white shadow rounded-xl transition transform ">
            <div class="text-sm text-gray-500">Baru</div>
            <div class="text-3xl font-bold">{{ $this->getData()['baru'] }}</div>
        </div>

        <div class="p-4 bg-white shadow rounded-xl transition transform ">
            <div class="text-sm text-gray-500">Diproses</div>
            <div class="text-3xl font-bold">{{ $this->getData()['diproses'] }}</div>
        </div>

        <div class="p-4 bg-white shadow rounded-xl transition transform ">
            <div class="text-sm text-gray-500">Revisi</div>
            <div class="text-3xl font-bold">{{ $this->getData()['revisi'] }}</div>
        </div>

        <div class="p-4 bg-white shadow rounded-xl transition transform ">
            <div class="text-sm text-gray-500">Selesai</div>
            <div class="text-3xl font-bold">{{ $this->getData()['selesai'] }}</div>
        </div>
    </div>
</x-filament::widget>

