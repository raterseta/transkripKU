<?php
namespace App\Filament\Resources\PengajuanResource\Pages;

use Filament\Notifications\Notification;
use Filament\Forms\Components\Radio;
use Illuminate\Support\Facades\Storage;
use Filament\Actions;
use setasign\Fpdi\Fpdi;
use App\Enums\RequestStatus;
use App\Filament\Resources\PengajuanResource;
use App\Models\RequestTrack;
use App\Services\AcademicRequestNotificationService;
use Filament\Forms\Components\Textarea;
use Filament\Resources\Pages\EditRecord;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class EditPengajuan extends EditRecord
{
    protected static string $resource = PengajuanResource::class;

    protected $notificationService;

    protected function getNotificationService()
    {
        if ($this->notificationService === null) {
            $this->notificationService = new AcademicRequestNotificationService();
        }
        return $this->notificationService;
    }
    protected function getHeaderActions(): array
    {

        $userRole = auth()->user()->roles->pluck('name')->first();
        $actions  = [];

        if ($userRole === 'super_admin') {
            if ($this->record->status === RequestStatus::DITERUSKANKEOPERATOR) {
                $actions[] = Actions\Action::make('kembalikan_ke_kaprodi')
                    ->label('Ke6mbalikan ke Kaprodi')
                    ->color('warning')
                    ->icon('heroicon-o-arrow-uturn-left')
                    ->requiresConfirmation()
                    ->modalHeading('Kembalikan Pengajuan ke Kaprodi')
                    ->modalDescription('Pengajuan akan dikembalikan ke Kaprodi. Masukkan alasan pengembalian.')
                    ->form([
                        Textarea::make('action_notes')
                            ->label('Alasan')
                            ->required()
                            ->minLength(5)
                            ->maxLength(255),
                    ])
                    ->action(function (array $data): void {
                        DB::transaction(function () use ($data) {
                            $oldStatus = $this->record->status;

                            $this->record->update([
                                'status' => RequestStatus::DIKEMBALIKANKEKAPRODI,
                            ]);

                            $user = auth()->user();
                            RequestTrack::create([
                                'tracking_number'                => $this->record->tracking_number,
                                'academic_transcript_request_id' => $this->record->id,
                                'status'                         => RequestStatus::DIKEMBALIKANKEKAPRODI,
                                'action_desc'                    => "Pengajuan dikembalikan ke Kaprodi oleh Operator",
                                'action_notes'                   => $data['action_notes'],
                                'request_transcript_url'         => $this->record->transcript_url,
                            ]);

                            $this->getNotificationService()->sendStatusChangeNotification(
                                $this->record,
                                $oldStatus->value,
                                RequestStatus::DIKEMBALIKANKEKAPRODI->value,
                                $data['action_notes']
                            );

                            $this->redirect(PengajuanResource::getUrl('index'));
                        });
                    });
            }

            $actions[] = Actions\Action::make('tolak')
                ->label('Tolak')
                ->color('danger')
                ->icon('heroicon-o-x-circle')
                ->requiresConfirmation()
                ->modalHeading('Tolak Pengajuan')
                ->modalDescription('Pengajuan akan ditolak. Masukkan alasan penolakan.')
                ->form([
                    Textarea::make('action_notes')
                        ->label('Alasan')
                        ->required()
                        ->minLength(5)
                        ->maxLength(255),
                ])
                ->action(function (array $data): void {
                    DB::transaction(function () use ($data) {
                        $oldStatus = $this->record->status;

                        $this->record->update([
                            'status' => RequestStatus::DITOLAK,
                        ]);

                        $user = auth()->user();
                        RequestTrack::create([
                            'tracking_number'                => $this->record->tracking_number,
                            'academic_transcript_request_id' => $this->record->id,
                            'status'                         => RequestStatus::DITOLAK,
                            'action_desc'                    => "Pengajuan ditolak oleh Operator Akademik, alasan: {$data['action_notes']}",
                            'action_notes'                   => $data['action_notes'],
                            'request_transcript_url'         => $this->record->transcript_url,
                            'request_notes'                  => $this->record->notes,
                        ]);

                        $this->getNotificationService()->sendStatusChangeNotification(
                            $this->record,
                            $oldStatus->value,
                            RequestStatus::DITOLAK->value,
                            $data['action_notes']
                        );

                        $this->redirect(PengajuanResource::getUrl('index'));
                    });
                });
        }

        if ($userRole === 'kaprod') {
            $actions[] = Actions\Action::make('tempel_ttd')
                ->label('Tempel TTD ke Transkrip')
                ->icon('heroicon-o-pencil')
                ->requiresConfirmation()
                ->color('primary')
                ->modalHeading('Tempelkan TTD?')
                ->modalDescription('Tanda tangan akan ditempel ke halaman terakhir file PDF.')
                ->form([
                    Radio::make('ttd_jenis')
                        ->label('Pilih Jenis TTD')
                        ->options([
                            'basah' => 'Tanda Tangan Basah',
                            'digital' => 'Tanda Tangan Digital',
                        ])
                        ->default('basah')
                        ->required(),
                ])
                ->action(function (array $data) {
                    $record = $this->record;

                    if (! $record->transcript_url || ! Storage::disk('public')->exists($record->transcript_url)) {
                        Notification::make()
                            ->title('Gagal')
                            ->body('File PDF belum diupload atau tidak ditemukan.')
                            ->danger()
                            ->send();
                        return;
                    }

                    // Tentukan path tanda tangan sesuai pilihan user
                    $signatureFile = $data['ttd_jenis'] === 'digital'
                        ? 'signature/signature_digital.png'
                        : 'signature/signature_basah.png';

                        $imagePath = public_path("images/signature/{$signatureFile}");

                    if (! Storage::disk('public')->exists($signatureFile)) {
                        Notification::make()
                            ->title('Gagal')
                            ->body('File tanda tangan tidak ditemukan di: ' . $imagePath)
                            ->danger()
                            ->send();
                        return;
                    }

                    // Load PDF asli
                    $pdf = new Fpdi();
                    $pdfPath = Storage::disk('public')->path($record->transcript_url);
                    $imagePath = Storage::disk('public')->path($signatureFile);

                    $pageCount = $pdf->setSourceFile($pdfPath);

                    for ($pageNo = 1; $pageNo <= $pageCount; $pageNo++) {
                        $templateId = $pdf->importPage($pageNo);
                        $pdf->addPage();
                        $pdf->useTemplate($templateId);

                        // Tempel TTD hanya di halaman terakhir
                        if ($pageNo === $pageCount) {
                            if ($data['ttd_jenis'] === 'digital') {
                                $x = 124;
                                $y = 170;
                                $width = 16;
                            } else {
                                $x = 124;
                                $y = 170;
                                $width = 24;
                            }
                            $pdf->Image($imagePath, $x, $y, $width);
                        }
                    }

                    // Generate file baru

                    $signedName = 'signed_' . uniqid() . '.pdf';
                    $signedPath = storage_path("app/public/tmp/{$signedName}");

                    if (! Storage::disk('public')->exists('tmp')) {
                        Storage::disk('public')->makeDirectory('tmp');
                    }

                    $pdf->Output('F', $signedPath);

                    session()->flash('signed_pdf_path', "tmp/{$signedName}");

                    Notification::make()
                        ->title('Berhasil')
                        ->body('TTD berhasil ditempel. File telah didownload.')
                        ->success()
                        ->send();

                    $this->redirect(route('download.signed.pdf'));
            });
            if ($this->record->status === RequestStatus::PROSESKAPRODI) {
                $actions[] = Actions\Action::make('kembalikan_ke_operator')
                    ->label('Kembalikan ke Operator')
                    ->color('warning')
                    ->icon('heroicon-o-arrow-uturn-left')
                    ->requiresConfirmation()
                    ->modalHeading('Kembalikan Pengajuan ke Operator')
                    ->modalDescription('Pengajuan akan dikembalikan ke Operator. Masukkan alasan pengembalian.')
                    ->form([
                        Textarea::make('action_notes')
                            ->label('Alasan')
                            ->required()
                            ->minLength(5)
                            ->maxLength(255),
                    ])
                    ->action(function (array $data): void {
                        DB::transaction(function () use ($data) {
                            $oldStatus = $this->record->status;

                            $this->record->update([
                                'status' => RequestStatus::DIKEMBALIKANKEOPERATOR,
                            ]);

                            $user = auth()->user();
                            RequestTrack::create([
                                'tracking_number'                => $this->record->tracking_number,
                                'academic_transcript_request_id' => $this->record->id,
                                'status'                         => RequestStatus::DIKEMBALIKANKEOPERATOR,
                                'action_desc'                    => "Pengajuan dikembalikan ke Operator Akademik oleh Kaprodi",
                                'action_notes'                   => $data['action_notes'],
                                'request_transcript_url'         => $this->record->transcript_url,
                            ]);

                            $this->getNotificationService()->sendStatusChangeNotification(
                                $this->record,
                                $oldStatus->value,
                                RequestStatus::DIKEMBALIKANKEOPERATOR->value,
                                $data['action_notes']
                            );

                            $this->redirect(PengajuanResource::getUrl('index'));
                        });
                    });
            }

            if ($this->record->status === RequestStatus::DIKEMBALIKANKEKAPRODI) {
                $actions[] = Actions\Action::make('kembalikan_ke_operator_from_returned')
                    ->label('Kembalikan ke Operator')
                    ->color('warning')
                    ->icon('heroicon-o-arrow-uturn-left')
                    ->requiresConfirmation()
                    ->modalHeading('Kembalikan Pengajuan ke Operator')
                    ->modalDescription('Pengajuan akan dikembalikan ke Operator. Masukkan alasan pengembalian.')
                    ->form([
                        Textarea::make('action_notes')
                            ->label('Alasan')
                            ->required()
                            ->minLength(5)
                            ->maxLength(255),
                    ])
                    ->action(function (array $data): void {
                        DB::transaction(function () use ($data) {
                            $oldStatus = $this->record->status;

                            $this->record->update([
                                'status' => RequestStatus::DIKEMBALIKANKEOPERATOR,
                            ]);

                            $user = auth()->user();
                            RequestTrack::create([
                                'tracking_number'                => $this->record->tracking_number,
                                'academic_transcript_request_id' => $this->record->id,
                                'status'                         => RequestStatus::DIKEMBALIKANKEOPERATOR,
                                'action_desc'                    => "Pengajuan dikembalikan ke Operator Akademik oleh Kaprodi",
                                'action_notes'                   => $data['action_notes'],
                                'request_transcript_url'         => $this->record->transcript_url,
                            ]);

                            $this->getNotificationService()->sendStatusChangeNotification(
                                $this->record,
                                $oldStatus->value,
                                RequestStatus::DIKEMBALIKANKEOPERATOR->value,
                                $data['action_notes']
                            );

                            $this->redirect(PengajuanResource::getUrl('index'));
                        });
                    });
            }
        }

        return $actions;
    }

    protected function mutateFormDataBeforeFill(array $data): array
    {
        if ($data['status'] !== RequestStatus::DITERUSKANKEOPERATOR->value) {
            $data['transcript_url'] = null;
        }

        return $data;
    }

    protected function mutateFormDataBeforeSave(array $data): array
    {
        $userRole = auth()->user()->roles->pluck('name')->first();

        if ($userRole === 'super_admin') {
            if (! isset($data['status'])) {
                $record        = $this->getRecord();
                $currentStatus = $record->status;

                if ($currentStatus === RequestStatus::DITERUSKANKEOPERATOR) {
                    $data['status'] = RequestStatus::SELESAI;
                } else {
                    $data['status'] = RequestStatus::PROSESKAPRODI;
                }
            } else {
                $data['status'] = $data['status'] === RequestStatus::DITERUSKANKEOPERATOR ? RequestStatus::SELESAI : RequestStatus::PROSESKAPRODI;
            }
        } elseif ($userRole === 'kaprod') {
            $data['status'] = RequestStatus::DITERUSKANKEOPERATOR->value;
        }

        return $data;
    }

    protected function handleRecordUpdate(Model $record, array $data): Model
    {
        return DB::transaction(function () use ($record, $data) {
            $oldStatus = $record->status instanceof RequestStatus ? $record->status->value : $record->status;

            $notesContent = $data['notes'] ?? null;

            $record->update($data);

            $newStatus = $record->status instanceof RequestStatus ? $record->status->value : $record->status;

            if ($oldStatus != $newStatus) {
                \Log::info("Status changed from {$oldStatus} to {$newStatus}");

                if ($newStatus === RequestStatus::SELESAI->value) {
                    RequestTrack::create([
                        'tracking_number'                => $record->tracking_number,
                        'academic_transcript_request_id' => $record->id,
                        'status'                         => $newStatus,
                        'action_desc'                    => "Transkrip akademik selesai diproses dan dikirim kepada {$record->student_email}",
                        'action_notes'                   => $notesContent,
                        'request_transcript_url'         => $record->transcript_url,
                    ]);

                    $this->getNotificationService()->sendStatusChangeNotification(
                        $this->record,
                        $oldStatus,
                        RequestStatus::SELESAI->value,
                    );

                } else if ($newStatus === RequestStatus::PROSESKAPRODI->value) {
                    RequestTrack::create([
                        'tracking_number'                => $record->tracking_number,
                        'academic_transcript_request_id' => $record->id,
                        'status'                         => $newStatus,
                        'action_desc'                    => "Pengajuan dikirim kepada kaprodi untuk tanda tangan",
                        'action_notes'                   => $notesContent,
                        'request_transcript_url'         => $record->transcript_url,
                    ]);

                    $this->getNotificationService()->sendStatusChangeNotification(
                        $this->record,
                        $oldStatus,
                        RequestStatus::PROSESKAPRODI->value,
                    );

                } else if ($newStatus === RequestStatus::DITERUSKANKEOPERATOR->value) {
                    RequestTrack::create([
                        'tracking_number'                => $record->tracking_number,
                        'academic_transcript_request_id' => $record->id,
                        'status'                         => $newStatus,
                        'action_desc'                    => "Pengajuan selesai ditanda tangani dan diteruskan kepada operator akademik",
                        'action_notes'                   => $notesContent,
                        'request_transcript_url'         => $record->transcript_url,
                    ]);

                    $this->getNotificationService()->sendStatusChangeNotification(
                        $this->record,
                        $oldStatus,
                        RequestStatus::DITERUSKANKEOPERATOR->value,
                    );

                }
            }

            return $record;
        });
    }

    protected function getSaveFormAction(): Actions\Action
    {
        $userRole = auth()->user()->roles->pluck('name')->first();
        $label    = 'Create';

        $record = $this->getRecord();

        if ($userRole === 'super_admin') {
            $label = $record->status === RequestStatus::DITERUSKANKEOPERATOR ? 'Kirim ke mahasiswa' : 'Kirim ke kaprodi';
        } elseif ($userRole === 'kaprod') {
            $label = 'Selesai tanda tangan';
        }

        return parent::getSaveFormAction()
            ->label($label)
            ->requiresConfirmation();
    }
}
