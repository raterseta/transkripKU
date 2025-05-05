<?php
namespace App\Filament\Widgets;

use App\Models\AcademicTranscriptRequest;
use App\Models\ThesisTranscriptRequest;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class StatusPermohonanOverview extends BaseWidget
{
    protected static ?int $sort = 1;

    public static function canView(): bool
    {
        return request()->routeIs('filament.admin.pages.dashboard');
    }

    protected function getStats(): array
    {
        $academicNew = AcademicTranscriptRequest::where('status', 'diproses_operator')->count();
        $thesisNew   = ThesisTranscriptRequest::where('status', 'diproses_operator')->count();

        $academicProcessing = AcademicTranscriptRequest::where('status', 'diproses_kaprodi')->count();
        $thesisProcessing   = ThesisTranscriptRequest::where('status', 'diproses_kaprodi')->count();

        $academicCompleted = AcademicTranscriptRequest::where('status', 'selesai')->count();
        $thesisCompleted   = ThesisTranscriptRequest::where('status', 'selesai')->count();

        $academicRejected = AcademicTranscriptRequest::where('status', 'ditolak')->count();
        $thesisRejected   = ThesisTranscriptRequest::where('status', 'ditolak')->count();

        return [
            Stat::make('Pengajuan Baru', $academicNew + $thesisNew)
                ->color('primary'),

            Stat::make('Sedang Diproses', $academicProcessing + $thesisProcessing)
                ->color('warning'),

            Stat::make('Selesai', $academicCompleted + $thesisCompleted)
                ->color('success'),

            Stat::make('Ditolak', $academicRejected + $thesisRejected),
        ];
    }
}
