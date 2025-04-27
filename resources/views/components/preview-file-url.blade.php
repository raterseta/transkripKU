@if ($record?->file_transkrip)
    <a href="{{ Storage::url($record->file_transkrip) }}" target="_blank" class="text-primary underline">
        Lihat Transkrip
    </a>
@else
    <p>Belum ada file.</p>
@endif
