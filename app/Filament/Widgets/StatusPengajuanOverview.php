<?php
namespace App\Filament\Widgets;

use App\Models\AcademicTranscriptRequest;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class StatusPengajuanOverview extends BaseWidget
{

    protected int|string|array $columnSpan = 'full';

    public static function canView(): bool
    {
        return ! request()->routeIs('filament.admin.pages.dashboard');
    }

    protected function getStats(): array
    {
        $academicNew        = AcademicTranscriptRequest::where('status', 'diproses_operator')->count();
        $academicProcessing = AcademicTranscriptRequest::whereIn('status', ['diproses_kaprodi', 'dikembalikan_ke_operator', 'dikembalikan_ke_kaprodi', 'diteruskan_ke_operator'])->count();
        $academicCompleted  = AcademicTranscriptRequest::where('status', 'selesai')->count();
        $academicRejected   = AcademicTranscriptRequest::where('status', 'ditolak')->count();

        return [
            Stat::make('Pengajuan Baru', $academicNew)
                ->color('primary'),

            Stat::make('Sedang Diproses', $academicProcessing)
                ->color('warning'),

            Stat::make('Selesai', $academicCompleted)
                ->color('success'),

            Stat::make('Ditolak', $academicRejected),
        ];
    }
}
