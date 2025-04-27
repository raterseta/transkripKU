<?php

namespace App\Filament\Pages;

use Filament\Tables\Filters\SelectFilter;
use App\Models\PermohonanModel; // Tambahkan ini atas
use Filament\Pages\Page;
use Filament\Tables\Contracts\HasTable;
use Filament\Tables\Concerns\InteractsWithTable;
use Filament\Tables\Table;
use Illuminate\Support\Facades\DB;
use Filament\Tables;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Columns\BadgeColumn;

class PermohonanPages extends Page implements HasTable
{
    use InteractsWithTable;

    protected static ?string $navigationIcon = 'heroicon-o-document';
    protected static ?string $navigationLabel = 'Daftar Permohonan';

    protected static ?string $navigationGroup = 'Permohonan';

    protected static ?string $slug = 'daftar-permohonan';

    protected static ?string $label = 'Daftar Permohonan';


    public static function getNavigationBadge(): ?string
    {
        return PermohonanModel::where('status', 'Baru')->count();
    }

    protected static ?string $navigationBadgeTooltip = 'Total Pengajuan Baru';

    public static function getNavigationBadgeColor(): ?string
    {
        return PermohonanModel::where('status', 'Baru')->count() > 1 ? 'warning' : 'warning';
    }
    
    public function getTitle(): string
{
    return 'Daftar Permohonan'; // bebas mau diganti apa
}


    protected static string $view = 'filament.pages.permohonan'; // View kosong

    public function getBreadcrumbs(): array
{
    return [
        '/daftar-permohonan' => 'Daftar Permohonan',
        '' => 'Daftar',
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
        ->query(PermohonanModel::query())
        ->columns([
            TextColumn::make('nama')->label('Nama')->sortable()->searchable(),
            TextColumn::make('nim')->label('NIM')->sortable()->searchable(),
            BadgeColumn::make('sumber')
                ->label('Jenis Transkrip')
                ->colors([
                    'primary' => 'pengajuan',
                    'success' => 'pengajuan_final',
                ])
                ->formatStateUsing(function (string $state): string {
                    return match ($state) {
                        'pengajuan' => 'Akademik',
                        'pengajuan_final' => 'Final',
                        default => $state,
                    };
                }),
            BadgeColumn::make('status')
                ->label('Status')
                ->colors([
                    'primary' => 'Baru',
                    'success' => 'Diproses',
                    'primary' => 'Revisi',
                    'primary' => 'Selesai',
                ]),
        ])
        ->actions([
            Tables\Actions\Action::make('view')
                ->label('Lihat')
                ->url(fn ($record) => 
                    $record->sumber === 'pengajuan_final'
                        ? url("/admin/transkrip-final/{$record->id}/edit")
                        : url("/admin/transkrip-akademik/{$record->id}/edit")
                )
                ->openUrlInNewTab()
                ->icon('heroicon-o-eye'),
        ])
        ->filters([
            SelectFilter::make('status')
                ->options([
                    'Baru' => 'Baru',
                    'Diproses' => 'Diproses',
                    'Revisi' => 'Revisi',
                    'Selesai' => 'Selesai',
                ])
                ->attribute('status'),
            SelectFilter::make('sumber')
                ->options([
                    'pengajuan' => 'Akademik',
                    'pengajuan_final' => 'FInal',
                ])
                ->label('Jenis Pengajuan')
                ->attribute('sumber'),
        ]);
        
        
        
        
}
}
