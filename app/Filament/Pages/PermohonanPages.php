<?php
namespace App\Filament\Pages;

use App\Models\AcademicTranscriptRequest;
use App\Models\ThesisTranscriptRequest;
use Filament\Pages\Page;
use Filament\Tables;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Concerns\InteractsWithTable;
use Filament\Tables\Contracts\HasTable;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;
use Illuminate\Support\Facades\DB;

class PermohonanPages extends Page implements HasTable
{
    use InteractsWithTable;

    protected static ?string $navigationIcon  = 'heroicon-o-document';
    protected static ?string $navigationLabel = 'Daftar Permohonan';
    protected static ?string $navigationGroup = 'Permohonan';
    protected static ?string $slug            = 'daftar-permohonan';
    protected static ?string $label           = 'Daftar Permohonan';

    public static function getNavigationBadge(): ?string
    {
        $academicCount = AcademicTranscriptRequest::where('status', 'diproses_operator')->count();
        $thesisCount   = ThesisTranscriptRequest::where('status', 'diproses_operator')->count();

        return $academicCount + $thesisCount;
    }

    protected static ?string $navigationBadgeTooltip = 'Total Pengajuan Baru';

    public function getTitle(): string
    {
        return 'Daftar Permohonan';
    }

    protected static string $view = 'filament.pages.permohonan';

    public function getBreadcrumbs(): array
    {
        return [
            '/daftar-permohonan' => 'Daftar Permohonan',
            ''                   => 'Daftar',
        ];
    }

    protected static function getWidgets(): array
    {
        return [
            \App\Filament\Widgets\StatusPermohonanOverview::class,
        ];
    }

    public function table(Table $table): Table
    {
        return $table
            ->query(function () {
                // Get academic transcript requests
                $academicQuery = AcademicTranscriptRequest::query()
                    ->select([
                        'id',
                        'student_name',
                        'student_nim',
                        'student_email',
                        'status',
                        DB::raw("'academic' as source_table"),
                        'created_at',
                    ]);

                // Get thesis transcript requests
                $thesisQuery = ThesisTranscriptRequest::query()
                    ->select([
                        'id',
                        'student_name',
                        'student_nim',
                        'student_email',
                        'status',
                        DB::raw("'thesis' as source_table"),
                        'created_at',
                    ]);

                // Union the queries to get combined results
                return $academicQuery->union($thesisQuery);
            })
            ->columns([
                TextColumn::make('student_name')
                    ->label('Nama')
                    ->searchable()
                    ->sortable(),

                TextColumn::make('student_nim')
                    ->label('Nim')
                    ->searchable()
                    ->sortable(),

                TextColumn::make('source_table')
                    ->label('Jenis Transkrip')
                    ->formatStateUsing(function (string $state): string {
                        return match ($state) {
                            'academic' => 'Akademik',
                            'thesis'   => 'Final',
                            default    => $state,
                        };
                    }),

                TextColumn::make('status')
                    ->label("Status")
                    ->badge()
                    ->color(fn($record) => $record->status->getColor()),

                TextColumn::make('created_at')
                    ->label('Tanggal Pengajuan')
                    ->dateTime('d M Y')
                    ->sortable(),
            ])
            ->actions([
                Tables\Actions\Action::make('view')
                    ->label('Lihat')
                    ->url(fn($record) =>
                        $record->source_table === 'thesis'
                        ? url("/admin/transkrip-final/{$record->id}/edit")
                        : url("/admin/transkrip-akademik/{$record->id}/edit")
                    )
                    ->openUrlInNewTab()
                    ->icon('heroicon-o-eye'),
            ])
            ->filters([
                SelectFilter::make('status')
                    ->options([
                        'diproses_operator'        => 'Diproses Operator',
                        'diproses_kaprodi'         => 'Diproses Kaprodi',
                        'dikembalikan_ke_operator' => 'Dikembalikan Ke Operator',
                        'dikembalikan_ke_kaprodi'  => 'Dikembalikan ke Kaprodi',
                        'ditolak'                  => 'Ditolak',
                        'selesai'                  => 'Selesai',
                    ])
                    ->attribute('status'),
            ])
            ->defaultSort('created_at', 'desc');
    }
}
