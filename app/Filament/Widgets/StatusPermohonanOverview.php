<?php

namespace App\Filament\Widgets;

use Filament\Widgets\Widget;
use App\Models\PengajuanModel;
use App\Models\PengajuanFinalModel;

class StatusPermohonanOverview extends Widget
{
    protected static string $view = 'filament.widgets.status-permohonan-overview';

    protected function getData(): array
    {
        $countPengajuanBaru = PengajuanModel::where('status', 'Baru')->count() + PengajuanFinalModel::where('status', 'Baru')->count();
        $countPengajuanDiproses = PengajuanModel::where('status', 'Diproses')->count() + PengajuanFinalModel::where('status', 'Diproses')->count();
        $countPengajuanRevisi = PengajuanModel::where('status', 'Revisi')->count() + PengajuanFinalModel::where('status', 'Revisi')->count();
        $countPengajuanSelesai = PengajuanModel::where('status', 'Selesai')->count() + PengajuanFinalModel::where('status', 'Selesai')->count();

        return [
            'baru' => $countPengajuanBaru,
            'diproses' => $countPengajuanDiproses,
            'revisi' => $countPengajuanRevisi,
            'selesai' => $countPengajuanSelesai,
        ];
    }
}
