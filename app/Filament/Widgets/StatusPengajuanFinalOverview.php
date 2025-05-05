<?php
namespace App\Filament\Widgets;

use App\Models\PengajuanFinalModel;
use Filament\Widgets\Widget;

class StatusPengajuanFinalOverview extends Widget
{
    protected static string $view = 'filament.widgets.status-pengajuan-final-overview';

    protected int|string|array $columnSpan = 'full';

    protected static bool $isLazy = true;

    public static function canView(): bool
    {
        return ! request()->routeIs('filament.admin.pages.dashboard');
    }

    public function getData(): array
    {
        return [
            'baru'     => PengajuanFinalModel::where('status', 'Baru')->count(),
            'diproses' => PengajuanFinalModel::where('status', 'Diproses')->count(),
            'revisi'   => PengajuanFinalModel::where('status', 'Revisi')->count(),
            'selesai'  => PengajuanFinalModel::where('status', 'Selesai')->count(),
        ];
    }
}
