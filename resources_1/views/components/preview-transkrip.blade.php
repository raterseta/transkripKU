<h1>Halo Url:</h1>
@if ($fileTranskrip)
    <div class="mt-2">
        @php
            $fileUrl = \Storage::url($fileTranskrip);
            $mimeType = mime_content_type(storage_path('app/public/'.$fileTranskrip));
            $isImage = str_starts_with($mimeType, 'image/');
        @endphp

        @if ($isImage)
            <img src="{{ $fileUrl }}" alt="Preview" class="max-h-64 rounded shadow">
        @else
            <a href="{{ $fileUrl }}" target="_blank" class="text-primary-600 hover:underline">
                📄 Lihat File
            </a>
        @endif
    </div>
@endif
