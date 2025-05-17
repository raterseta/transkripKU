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

        $user          = auth()->user();
        $academicCount = null;
        $thesisCount   = null;

        if ($user->hasRole('super_admin')) {
            $academicCount = AcademicTranscriptRequest::whereIn('status', [
                'diproses_operator',
                'dikembalikan_ke_operator',
                'diteruskan_ke_operator'])->count();
            $thesisCount = ThesisTranscriptRequest::whereIn('status', [
                'diproses_operator',
                'dikembalikan_ke_operator',
                'diteruskan_ke_operator'])->count();
            return $academicCount + $thesisCount;
        }
        if ($user->hasRole('kaprod')) {
            $academicCount = AcademicTranscriptRequest::whereIn('status', [
                'diproses_kaprodi',
                'dikembalikan_ke_kaprodi'])->count();
            $thesisCount = ThesisTranscriptRequest::whereIn('status', [
                'diproses_kaprodi',
                'menunggu_konsultasi',
                'dikembalikan_ke_kaprodi'])->count();
            return $academicCount + $thesisCount;
        }

        return null;
    }

    protected static ?string $navigationBadgeTooltip = 'Total Pengajuan Baru';

    public function getTitle(): string
    {
        return 'Dashboard';
    }
}
