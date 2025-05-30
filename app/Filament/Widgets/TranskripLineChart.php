<?php
namespace App\Filament\Widgets;

use App\Models\AcademicTranscriptRequest;
use App\Models\ThesisTranscriptRequest;
use Filament\Widgets\LineChartWidget;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;

class TranskripLineChart extends LineChartWidget
{
        protected int|string|array $columnSpan = 'full';

//     public function getColumnSpan(): int|string|array
// {
//     return 2; // bisa 6, 8, 12, dsb sesuai kebutuhan
// }
    protected static ?int $sort = 0;

    protected static ?string $heading = 'Tren Jumlah Transkrip per Bulan';

    public static function canView(): bool
    {
        return ! request()->routeIs('filament.admin.pages.dashboard');
    }

    public function filters(): ?array
    {
        return [
            'all' => 'Semua Status',
            'diproses_operator' => 'Diproses Operator',
            'diproses_kaprodi' => 'Diproses Kaprodi',
            'selesai' => 'Selesai',
            'ditolak' => 'Ditolak',
        ];
    }

    protected function getData(): array
    {
        $filter = $this->filter; // status yang dipilih

        // Ambil range 6 bulan terakhir
        $months = collect(range(0, 5))
            ->map(fn ($i) => Carbon::now()->subMonths($i)->format('Y-m'))
            ->reverse()
            ->values();

        $labels = $months->map(fn ($month) => Carbon::createFromFormat('Y-m', $month)->format('F Y'))->toArray();

        $academicData = $this->getMonthlySums(AcademicTranscriptRequest::query(), $months, $filter);
        $thesisData = $this->getMonthlySums(ThesisTranscriptRequest::query(), $months, $filter);

        return [
            'datasets' => [
                [
                    'label' => 'Akademik - Jumlah Transkrip',
                    'data' => $academicData['jumlah_transkrip'],
                    'borderColor' => '#3b82f6',
                    'backgroundColor' => 'transparent',
                ],
                [
                    'label' => 'Akademik - Final',
                    'data' => $academicData['jumlah_transkrip_final'],
                    'borderColor' => '#60a5fa',
                    'backgroundColor' => 'transparent',
                ],
                [
                    'label' => 'Skripsi - Jumlah Transkrip',
                    'data' => $thesisData['jumlah_transkrip'],
                    'borderColor' => '#f59e0b',
                    'backgroundColor' => 'transparent',
                ],
                [
                    'label' => 'Skripsi - Final',
                    'data' => $thesisData['jumlah_transkrip_final'],
                    'borderColor' => '#fcd34d',
                    'backgroundColor' => 'transparent',
                ],
            ],
            'labels' => $labels,
        ];
    }

    private function getMonthlySums($query, $months, $statusFilter): array
{
    $baseQuery = $query
        ->when($statusFilter && $statusFilter !== 'all', fn ($q) => $q->where('status', $statusFilter))
        ->selectRaw("DATE_FORMAT(created_at, '%Y-%m') as bulan, COUNT(*) as total")
        ->whereBetween('created_at', [now()->subMonths(5)->startOfMonth(), now()->endOfMonth()])
        ->groupBy('bulan')
        ->pluck('total', 'bulan')
        ->toArray();

    return [
        'jumlah_transkrip' => collect($months)->map(fn ($m) => $baseQuery[$m] ?? 0)->toArray(),
        'jumlah_transkrip_final' => collect($months)->map(fn ($m) => 0)->toArray(), // default 0 jika tidak ada field
    ];
}

}

