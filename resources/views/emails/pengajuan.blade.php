@component('mail::message')
# Informasi Pengajuan Final

Halo, **{{ $nama }}**!

Berikut ini adalah informasi terkait pengajuan final Anda:

**Keterangan:**
{{ $keterangan }}

@if (!empty($file_transkrip))
@component('mail::button', ['url' => url('storage/' . $file_transkrip)])
Lihat Transkrip
@endcomponent
@endif

Terima kasih,<br>
{{ config('app.name') }}
@endcomponent
