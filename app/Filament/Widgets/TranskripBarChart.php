<?php

namespace App\Filament\Widgets;

use App\Models\AcademicTranscriptRequest;
use App\Models\ThesisTranscriptRequest;
use Filament\Widgets\BarChartWidget;
use Illuminate\Support\Carbon;

class TranskripBarChart extends BarChartWidget
{
    protected static ?string $heading = 'Statistik Transkrip per Bulan';

    protected int|string|array $columnSpan = 'full';

    protected static ?int $sort = 0;

    public static function canView(): bool
    {
        return ! request()->routeIs('filament.admin.pages.dashboard');
    }

    public function filters(): ?array
    {
        return [
            
            'status' => [
                'all' => 'Semua Status',
                'diproses_operator' => 'Diproses Operator',
                'diproses_kaprodi' => 'Diproses Kaprodi',
                'selesai' => 'Selesai',
                'ditolak' => 'Ditolak',
            ]
        ];
    }

    protected function getData(): array
    {
        $tipe = $this->filters['tipe_transkrip'] ?? 'transkrip';
        $status = $this->filters['status'] ?? 'all';

        // Ambil 6 bulan terakhir
        $months = collect(range(0, 5))
            ->map(fn ($i) => Carbon::now()->subMonths($i)->format('Y-m'))
            ->reverse();

        $labels = $months->map(fn ($m) => Carbon::createFromFormat('Y-m', $m)->format('F Y'))->toArray();

        $academic = $this->getMonthlyCounts(AcademicTranscriptRequest::query(), $months, $status, $tipe);
        $thesis   = $this->getMonthlyCounts(ThesisTranscriptRequest::query(), $months, $status, $tipe);

        return [
            'datasets' => [
                [
                    'label' => 'Transkrip Akademik',
                    'data' => $academic,
                    'backgroundColor' => '#3b82f6',
                ],
                [
                    'label' => 'Transkrip Skripsi',
                    'data' => $thesis,
                    'backgroundColor' => '#f59e0b',
                ],
            ],
            'labels' => $labels,
        ];
    }

    private function getMonthlyCounts($query, $months, $status, $tipe): array
    {
        $baseQuery = $query
            ->when($status !== 'all', fn ($q) => $q->where('status', $status))
            ->whereBetween('created_at', [now()->subMonths(5)->startOfMonth(), now()->endOfMonth()])
            ->selectRaw("DATE_FORMAT(created_at, '%Y-%m') as bulan, COUNT(*) as total")
            ->groupBy('bulan')
            ->pluck('total', 'bulan')
            ->toArray();

        return $months->map(fn ($m) => $baseQuery[$m] ?? 0)->toArray();
    }
}
