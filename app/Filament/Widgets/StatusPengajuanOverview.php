<?php
namespace App\Filament\Widgets;

use App\Models\PengajuanModel;
use Filament\Widgets\Widget;

class StatusPengajuanOverview extends Widget
{
    protected static string $view = 'filament.widgets.status-pengajuan-overview';

    protected int|string|array $columnSpan = 'full';

    public static function canView(): bool
    {
        return ! request()->routeIs('filament.admin.pages.dashboard');
    }

    public function getData(): array
    {
        return [
            'baru'     => PengajuanModel::where('status', 'Baru')->count(),
            'diproses' => PengajuanModel::where('status', 'Diproses')->count(),
            'revisi'   => PengajuanModel::where('status', 'Revisi')->count(),
            'selesai'  => PengajuanModel::where('status', 'Selesai')->count(),
        ];
    }
}
