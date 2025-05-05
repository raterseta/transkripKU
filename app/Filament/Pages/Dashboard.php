<?php
namespace App\Filament\Pages;

use App\Models\AcademicTranscriptRequest;
use App\Models\ThesisTranscriptRequest;
use Filament\Pages\Dashboard as BaseDashboard;

class Dashboard extends BaseDashboard
{
    protected static ?string $navigationIcon  = 'heroicon-o-home';
    protected static ?string $navigationLabel = 'Dashboard';
    protected static ?string $title           = 'Dashboard';

    public static function getNavigationBadge(): ?string
    {
        $academicCount = AcademicTranscriptRequest::where('status', 'diproses_operator')->count();
        $thesisCount   = ThesisTranscriptRequest::where('status', 'diproses_operator')->count();

        return $academicCount + $thesisCount;
    }

    protected static ?string $navigationBadgeTooltip = 'Total Pengajuan Baru';

    public function getTitle(): string
    {
        return 'Dashboard';
    }
}
