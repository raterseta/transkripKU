<?php
namespace App\Filament\Widgets;

use App\Models\ThesisTranscriptRequest;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class StatusPengajuanFinalOverview extends BaseWidget
{

    protected int|string|array $columnSpan = 'full';

    protected static bool $isLazy = true;

    public static function canView(): bool
    {
        return ! request()->routeIs('filament.admin.pages.dashboard');
    }

    protected function getStats(): array
    {
        $thesisNew        = ThesisTranscriptRequest::where('status', 'diproses_operator')->count();
        $thesisProcessing = ThesisTranscriptRequest::whereIn('status', ['diproses_kaprodi', 'menunggu_konsultasi', 'dikembalikan_ke_operator', 'dikembalikan_ke_kaprodi', 'diteruskan_ke_operator'])->count();
        $thesisCompleted  = ThesisTranscriptRequest::where('status', 'selesai')->count();
        $thesisRejected   = ThesisTranscriptRequest::where('status', 'ditolak')->count();

        return [
            Stat::make('Pengajuan Baru', $thesisNew)
                ->color('primary'),

            Stat::make('Sedang Diproses', $thesisProcessing)
                ->color('warning'),

            Stat::make('Selesai', $thesisCompleted)
                ->color('success'),

            Stat::make('Ditolak', $thesisRejected),
        ];
    }
}
