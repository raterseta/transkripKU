<?php
namespace App\Filament\Widgets;

use App\Models\AcademicTranscriptRequest;
use App\Models\ThesisTranscriptRequest;
use Filament\Tables;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;
use Filament\Widgets\TableWidget as BaseWidget;
use Illuminate\Support\Facades\DB;

class PermohonanTable extends BaseWidget
{
    protected static ?string $heading = 'Daftar Permohonan';

    protected int|string|array $columnSpan = 'full';

    protected static ?int $sort = 2;

    public static function canView(): bool
    {
        return request()->routeIs('filament.admin.pages.dashboard');
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
