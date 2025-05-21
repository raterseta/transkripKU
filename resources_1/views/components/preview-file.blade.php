@php
    $url = $getState(); // $getState() itu otomatis ambil value dari field yang diset di ViewField
@endphp

<div class="flex flex-col space-y-5">
    <label for="" class="font-poppins">Dokumen Pendukung</label>
    <div class="flex justify-center items-center">
        @if ($url)
            @if (Str::endsWith($url, ['jpg', 'jpeg', 'png']))
                <img src="http://127.0.0.1:8000/storage/{{ $url }}" alt="Preview" class="max-w-xs rounded-lg shadow-lg">
            @elseif (Str::endsWith($url, ['pdf']))
                <a href="http://127.0.0.1:8000/storage/{{ $url }}" target="_blank" class="text-blue-600 underline">Lihat PDF</a>
            @else
                <span class="text-gray-500">File tidak dapat dipreview.</span>
            @endif
        @else
            <span class="text-gray-400 italic">Belum ada file.</span>
        @endif
    </div>

</div>