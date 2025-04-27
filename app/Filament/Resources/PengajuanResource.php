<?php

namespace App\Filament\Resources;

use Filament\Tables\Filters\SelectFilter;
use Filament\Forms\Components\ViewField;
use Filament\Forms\Components\TextInput;
use App\Filament\Resources\PengajuanResource\Pages;
use App\Filament\Resources\PengajuanResource\RelationManagers;
use App\Models\PengajuanModel;
use Filament\Forms;
use Filament\Forms\Components\RichEditor;
use Filament\Forms\Components\Placeholder;
use Filament\Forms\Components\Grid;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Select;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\SelectColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\Group;

class PengajuanResource extends Resource
{
    protected static ?string $model = PengajuanModel::class;

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
                            TextInput::make('jenis_pengajuan'),
                            TextInput::make('nama')
                                ->label('Nama')
                                ->required(),

                            TextInput::make('nim')
                                ->label('NIM')
                                ->numeric()
                                ->required(),

                            TextInput::make('email')
                                ->label('Email')
                                ->email()
                                ->required(),

                            Select::make('keperluan')
                                ->label('Keperluan Pengajuan')
                                ->options([
                                    'Aktif Kuliah' => 'Aktif Kuliah',
                                    'Beasiswa' => 'Beasiswa',
                                    'Skripsi' => 'Skripsi',
                                ])
                                ->default('Skripsi')
                                ->selectablePlaceholder(false),

                            Select::make('bahasa')
                                ->label('Bahasa')
                                ->options([
                                    'Inggris' => 'Inggris',
                                    'Indonesia' => 'Indonesia',
                                ])
                                ->default('Inggris')
                                ->selectablePlaceholder(false),

                            Select::make('ttd')
                                ->label('Tanda Tangan')
                                ->options([
                                    'Basah' => 'Basah',
                                    'Digital' => 'Digital',
                                ])
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
                        ->columnSpan(2)
                        ->maxWidth('xl'),

                    Section::make('Informasi')
                        ->schema([
                            Placeholder::make('created_at')
                                ->label('Created at')
                                ->content(fn ($record) => $record->created_at?->format('d M Y H:i')),

                            Placeholder::make('updated_at')
                                ->label('Last modified at')
                                ->content(fn ($record) => $record->updated_at?->format('d M Y H:i')),
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
                TextColumn::make('nama')
                    ->label('Nama')
                    ->searchable()
                    ->sortable(),
                TextColumn::make('nim')
                    ->label('Nim')
                    ->searchable()
                    ->sortable(),
                TextColumn::make('jenis_pengajuan')
                    ->label("Jenis Pengajuan"),
                SelectColumn::make('status')
                    ->label('Status')
                    ->options(collect([
                        'Baru' => 'Baru',
                        'Diproses' => 'Diproses',
                        'Revisi' => 'Revisi',
                        'Selesai' => 'Selesai',
                    ])->sortKeys()->toArray())
                    ->selectablePlaceholder(false),

            ])
            ->filters([
                SelectFilter::make('status')
                    ->options([
                        'Baru' => 'Baru',
                        'Diproses' => 'Diproses',
                        'Revisi' => 'Revisi',
                        'Selesai' => 'Selesai',
                    ])
                    ->attribute('status')
            ])
            ->actions([
                // Tables\Actions\ViewAction::make(),
                Tables\Actions\EditAction::make(),
                // Tables\Actions\DeleteAction::make(),
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
            'index' => Pages\ListPengajuans::route('/'),
            'create' => Pages\CreatePengajuan::route('/create'),
            'edit' => Pages\EditPengajuan::route('/{record}/edit'),
        ];
    }
}
