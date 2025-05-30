<?php
namespace App\Filament\Widgets;

use Filament\Widgets\BarChartWidget;
use App\Models\AcademicTranscriptRequest;
use App\Models\ThesisTranscriptRequest;

class StatusPermohonanBarChart extends BarChartWidget
{
    protected static ?int $sort = 0;
    
    protected int|string|array $columnSpan = 'full';

    protected static ?string $heading = 'Statistik Permohonan Transkrip';

    public static function canView(): bool
    {
        return  request()->routeIs('filament.admin.pages.dashboard');
    }

    public function filters(): ?array
    {
        return [
            'status_permohonan' => 'Status Permohonan',
            'jumlah_transkrip' => 'Jumlah Transkrip',
        ];
    }

    protected function getData(): array
    {
        $filter = $this->filter;

        if ($filter === 'jumlah_transkrip') {
            // Perbandingan jumlah transkrip dan jumlah transkrip final
            $labels = ['Jumlah Transkrip', 'Jumlah Transkrip Final'];

            $academic = [
                AcademicTranscriptRequest::sum('jumlah_transkrip'),
                AcademicTranscriptRequest::sum('jumlah_transkrip_final'),
            ];

            $thesis = [
                ThesisTranscriptRequest::sum('jumlah_transkrip'),
                ThesisTranscriptRequest::sum('jumlah_transkrip_final'),
            ];

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

        // Default: status permohonan
        $labels = ['Pengajuan Baru', 'Sedang Diproses', 'Selesai', 'Ditolak'];

        $academic = [
            AcademicTranscriptRequest::where('status', 'diproses_operator')->count(),
            AcademicTranscriptRequest::where('status', 'diproses_kaprodi')->count(),
            AcademicTranscriptRequest::where('status', 'selesai')->count(),
            AcademicTranscriptRequest::where('status', 'ditolak')->count(),
        ];

        $thesis = [
            ThesisTranscriptRequest::where('status', 'diproses_operator')->count(),
            ThesisTranscriptRequest::where('status', 'diproses_kaprodi')->count(),
            ThesisTranscriptRequest::where('status', 'selesai')->count(),
            ThesisTranscriptRequest::where('status', 'ditolak')->count(),
        ];

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
}

