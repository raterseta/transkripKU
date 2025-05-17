<?php
namespace App\Filament\Resources;

use App\Enums\RequestStatus;
use App\Enums\SignatureType;
use App\Filament\Resources\PengajuanResource\Pages;
use App\Models\AcademicTranscriptRequest;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Grid;
use Filament\Forms\Components\Placeholder;
use Filament\Forms\Components\RichEditor;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;

class PengajuanResource extends Resource
{
    protected static ?string $model           = AcademicTranscriptRequest::class;
    protected static ?string $navigationIcon  = 'heroicon-o-document';
    protected static ?string $navigationLabel = 'Transkrip Akademik';
    protected static ?string $navigationGroup = 'Permohonan';
    protected static ?string $slug            = 'transkrip-akademik';
    protected static ?string $label           = 'Transkrip Akademik';
    public static function getNavigationBadge(): ?string
    {
        $user = auth()->user();

        if ($user->hasRole('super_admin')) {
            return static::getModel()::whereIn('status', [
                'diproses_operator',
                'dikembalikan_ke_operator',
                'diteruskan_ke_operator',
            ])->count();
        }

        if ($user->hasRole('kaprod')) {
            return static::getModel()::whereIn('status', [
                'diproses_kaprodi',
                'dikembalikan_ke_kaprodi',
            ])->count();
        }

        return null;
    }
    protected static ?string $navigationBadgeTooltip = 'Pengajuan Baru';
    public static function getNavigationBadgeColor(): ?string
    {
        return static::getModel()::count() > 1 ? 'warning' : 'warning';
    }
    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Grid::make(3)
                    ->schema([
                        Section::make('Detail Pengajuan')
                            ->schema([
                                TextInput::make('student_name')
                                    ->label('Nama')
                                    ->disabled()
                                    ->required(),
                                TextInput::make('student_email')
                                    ->label('Email')
                                    ->disabled()
                                    ->email()
                                    ->required(),
                                TextInput::make('student_nim')
                                    ->label('NIM')
                                    ->disabled()
                                    ->required(),
                                Select::make('keperluan')
                                    ->label('Keperluan Pengajuan')
                                    ->options([
                                        'Aktif Kuliah' => 'Aktif Kuliah',
                                        'Beasiswa'     => 'Beasiswa',
                                        'Skripsi'      => 'Skripsi',
                                    ])
                                    ->disabled()
                                    ->selectablePlaceholder(false),
                                Select::make('language')
                                    ->label('Bahasa')
                                    ->options([
                                        'inggris'   => 'Inggris',
                                        'indonesia' => 'Indonesia',
                                    ])
                                    ->disabled()
                                    ->selectablePlaceholder(false),
                                Select::make('signature_type')
                                    ->label('Tanda Tangan')
                                    ->options(SignatureType::class)
                                    ->disabled()
                                    ->selectablePlaceholder(false),
                                RichEditor::make('student_notes')
                                    ->label('Catatan Tambahan')
                                    ->disabled()
                                    ->columnSpanFull(),
                                FileUpload::make('supporting_document_url')
                                    ->label('File Pendukung')
                                    ->disk('public')
                                    ->directory('academic_supporting_documents')
                                    ->preserveFilenames()
                                    ->openable()
                                    ->disabled()
                                    ->downloadable()
                                    ->previewable(true)
                                    ->columnSpanFull(),
                            ])
                            ->columns(2)
                            ->columnSpan(2),
                        Grid::make(1)
                            ->schema([
                                Section::make('Informasi')
                                    ->schema([
                                        Placeholder::make('created_at')
                                            ->label('Created at')
                                            ->content(fn($record) => $record->created_at?->format('d M Y H:i')),
                                        Placeholder::make('updated_at')
                                            ->label('Last modified at')
                                            ->content(fn($record) => $record->updated_at?->format('d M Y H:i')),
                                    ])
                                    ->columnSpan(1),
                                Section::make()
                                    ->schema([
                                        RichEditor::make('request_notes')
                                            ->label(function ($record) {

                                                if ($record && $record->status === RequestStatus::PROSESKAPRODI || $record && $record->status === RequestStatus::DIKEMBALIKANKEKAPRODI) {
                                                    return 'Catatan Operator';
                                                } elseif ($record && ($record->status === RequestStatus::DIKEMBALIKANKEOPERATOR ||

                                                    $record->status === RequestStatus::DITERUSKANKEOPERATOR)) {

                                                    return 'Catatan Kaprodi';
                                                }
                                                return 'Catatan';
                                            })
                                            ->disabled()
                                            ->afterStateHydrated(function (RichEditor $component, ?AcademicTranscriptRequest $record) {
                                                $notes = null;

                                                if ($record && method_exists($record, 'track')) {
                                                    $notes = $record->track()->latest()->first()?->action_notes;
                                                }

                                                $component->state($notes);
                                            })
                                            ->dehydrated(false)
                                            ->columnSpanFull(),
                                        FileUpload::make('request_transcript_url')
                                            ->label('Transkrip Mahasiswa')
                                            ->disk('public')
                                            ->directory('academic_transcript')
                                            ->preserveFilenames()
                                            ->openable()
                                            ->disabled()
                                            ->downloadable()
                                            ->afterStateHydrated(function (FileUpload $component, ?AcademicTranscriptRequest $record) {
                                                $url = null;

                                                if ($record && method_exists($record, 'track')) {
                                                    $url = $record->track()->latest()->first()?->request_transcript_url;
                                                }

                                                if ($url) {
                                                    $component->state([$url]);
                                                }
                                            })
                                            ->dehydrated(false)
                                            ->previewable(true)
                                            ->columnSpanFull(),
                                    ])
                                    ->columnSpan(1)
                                    ->hidden(function ($record) {
                                        if (! $record) {
                                            return true;
                                        }

                                        $trackCount = $record->track()->count();
                                        return $trackCount <= 1;
                                    }),
                            ])
                            ->extraAttributes(['class' => 'sticky top-24'])
                            ->columnSpan(1),
                        Section::make('Upload Transkrip')
                            ->schema([
                                FileUpload::make('transcript_url')
                                    ->label('')
                                    ->directory('academic_transcript')
                                    ->preserveFilenames()
                                    ->acceptedFileTypes(['application/pdf'])
                                    ->maxSize(2048),
                            ])
                            ->columnSpan(2)
                            ->collapsible(),
                        Section::make('Notes')
                            ->schema([
                                RichEditor::make('notes')
                                    ->label(''),
                            ])
                            ->columnSpan(2)
                            ->collapsible(),
                    ]),
            ]);
    }
    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('student_name')
                    ->label('Nama')
                    ->searchable()
                    ->sortable(),
                TextColumn::make('student_nim')
                    ->label('Nim')
                    ->searchable()
                    ->sortable(),
                TextColumn::make('status')
                    ->label("Status")
                    ->badge()
                    ->color(fn($record) => $record->status->getColor()),
            ])
            ->filters([
                SelectFilter::make('status')
                    ->multiple()
                    ->options(RequestStatus::class)
                    ->attribute('status'),
            ])
            ->actions([
                Tables\Actions\EditAction::make()
                    ->visible(function ($record) {
                        return static::hasAccess($record);
                    }),
            ])
            ->recordUrl(function ($record) {
                if (static::hasAccess($record)) {
                    return static::getUrl('edit', ['record' => $record]);
                } else {
                    return;
                }
            });
    }
    public static function hasAccess($record): bool
    {
        $userRole = auth()->user()->roles->pluck('name')->first();
        if ($userRole === 'super_admin') {
            return in_array($record->status->value, [
                RequestStatus::PROSESOPERATOR->value,
                RequestStatus::DITERUSKANKEOPERATOR->value,
                RequestStatus::DIKEMBALIKANKEOPERATOR->value,
            ]);
        } elseif ($userRole === 'kaprod') {
            return $record->status->value === RequestStatus::PROSESKAPRODI->value || $record->status->value === RequestStatus::DIKEMBALIKANKEKAPRODI->value;
        }
        return false;
    }
    public static function isOperator($record): bool
    {
        $userRole = auth()->user()->roles->pluck('name')->first();
        if ($userRole === 'super_admin') {
            return in_array($record->status->value, [
                RequestStatus::PROSESOPERATOR->value,
                RequestStatus::DITERUSKANKEOPERATOR->value,
            ]);
        }
        return false;
    }
    public static function getRelations(): array
    {
        return [
            //
        ];
    }
    public static function getPages(): array
    {
        return [
            'index'  => Pages\ListPengajuans::route('/'),
            'create' => Pages\CreatePengajuan::route('/create'),
            'edit'   => Pages\EditPengajuan::route('/{record}/edit'),
        ];
    }
}
