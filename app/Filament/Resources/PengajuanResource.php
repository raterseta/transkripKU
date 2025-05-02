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
use Filament\Forms\Components\ViewField;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;

class PengajuanResource extends Resource
{
    protected static ?string $model = AcademicTranscriptRequest::class;

    protected static ?string $navigationIcon = 'heroicon-o-document';

    protected static ?string $navigationLabel = 'Transkrip Akademik';

    protected static ?string $navigationGroup = 'Permohonan';

    protected static ?string $slug = 'transkrip-akademik';

    protected static ?string $label = 'Transkrip Akademik';

    public static function getNavigationBadge(): ?string
    {
        return static::getModel()::where('status', 'Baru')->count();
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
                                    ->required(),

                                TextInput::make('student_email')
                                    ->label('Email')
                                    ->email()
                                    ->required(),

                                TextInput::make('student_nim')
                                    ->label('NIM')
                                    ->required(),

                                Select::make('keperluan')
                                    ->label('Keperluan Pengajuan')
                                    ->options([
                                        'Aktif Kuliah' => 'Aktif Kuliah',
                                        'Beasiswa'     => 'Beasiswa',
                                        'Skripsi'      => 'Skripsi',
                                    ])
                                    ->default('Skripsi')
                                    ->selectablePlaceholder(false),

                                Select::make('language')
                                    ->label('Bahasa')
                                    ->options([
                                        'inggris'   => 'Inggris',
                                        'indonesia' => 'Indonesia',
                                    ])
                                    ->default('Inggris')
                                    ->selectablePlaceholder(false),

                                Select::make('signature_type')
                                    ->label('Tanda Tangan')
                                    ->options(SignatureType::class)
                                    ->default('Basah')
                                    ->selectablePlaceholder(false),

                                RichEditor::make('catatan_tambahan')
                                    ->label('Catatan Tambahan')
                                    ->columnSpanFull(),

                                ViewField::make('file_pendukung')
                                    ->label('Preview File')
                                    ->view('components.preview-file')
                                    ->columnSpanFull(),
                            ])
                            ->columns(2)
                            ->columnSpan(2),

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

                        Section::make('Upload Transkrip')
                            ->schema([
                                FileUpload::make('file_transkrip')
                                    ->label('')
                                    ->directory('transkrip-akademik')
                                    ->preserveFilenames()
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
                Tables\Actions\EditAction::make(),
                Tables\Actions\Action::make('kirimEmail')
                    ->label('Kirim Email')
                    ->icon('heroicon-o-paper-airplane')
                    ->action(function ($record) {
                        \Mail::to($record->email)->send(new \App\Mail\PengajuanNotificationMail($record));
                    })
                    ->requiresConfirmation()
                    ->color('success'),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
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
