<?php
namespace App\Filament\Resources;

use App\Filament\Resources\PengajuanFinalResource\Pages;
use App\Models\ThesisTranscriptRequest;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Grid;
use Filament\Forms\Components\Placeholder;
use Filament\Forms\Components\RichEditor;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\ViewField;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;

class PengajuanFinalResource extends Resource
{
    protected static ?string $model = ThesisTranscriptRequest::class;

    protected static ?string $navigationIcon = 'heroicon-o-document';

    protected static ?string $navigationLabel = 'Transkrip Final';
    protected static ?int $navigationSort     = 3;

    protected static ?string $navigationGroup = 'Permohonan';

    protected static ?string $slug = 'transkrip-final';

    protected static ?string $label = 'Transkrip Final';

    public static function getNavigationBadge(): ?string
    {
        return static::getModel()::where('status', 'diproses_operator')->count();
    }

    protected static ?string $navigationBadgeTooltip = 'PengajuanFinal Baru';

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
                        Section::make('Detail Pengajuan Final')
                            ->schema([
                                TextInput::make('student_name')
                                    ->label('Nama')
                                    ->required()
                                    ->disabled(),

                                TextInput::make('student_email')
                                    ->label('Email')
                                    ->email()
                                    ->required()
                                    ->disabled(),

                                TextInput::make('student_nim')
                                    ->label('NIM')
                                    ->required()
                                    ->disabled()
                                    ->columnSpanFull(),

                                RichEditor::make('keterangan')
                                    ->label('Keterangan Konsultasi')
                                    ->disabled()
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
                                // TextInput::make('file_transkrip'),
                                // ViewField::make('file_transkrip')
                                //     ->label('Upload Transkrip')
                                //     ->view('components.custom-upload')  // Ini merujuk ke file Blade yang sudah kamu buat
                                //     ->columnSpan(2),
                                FileUpload::make('file_transkrip'),
                                //                 PdfUpload::make('file_transkrip')
                                // ->label('Upload Dokumen (PDF)')
                                // ->helperText('Upload PDF baru untuk menggantikan file lama otomatis.')

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
                    ->options([
                        'Baru'     => 'Baru',
                        'Diproses' => 'Diproses',
                        'Revisi'   => 'Revisi',
                        'Selesai'  => 'Selesai',
                    ])
                    ->attribute('status'),
            ])
            ->actions([
                // Tables\Actions\ViewAction::make(),
                Tables\Actions\EditAction::make(),
                // Tables\Actions\DeleteAction::make(),
                Tables\Actions\Action::make('kirimEmail')
                    ->label('Kirim Email')
                    ->icon('heroicon-o-paper-airplane')
                    ->action(function ($record) {
                        \Mail::to($record->email)->send(new \App\Mail\PengajuanFinalNotificationMail($record));
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
            'index'  => Pages\ListPengajuanFinals::route('/'),
            'create' => Pages\CreatePengajuanFinal::route('/create'),
            'edit'   => Pages\EditPengajuanFinal::route('/{record}/edit'),
        ];
    }
}
