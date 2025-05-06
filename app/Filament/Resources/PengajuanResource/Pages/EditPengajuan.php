<?php
namespace App\Filament\Resources\PengajuanResource\Pages;

use App\Enums\RequestStatus;
use App\Filament\Resources\PengajuanResource;
use App\Models\RequestTrack;
use Filament\Actions;
use Filament\Forms\Components\Textarea;
use Filament\Resources\Pages\EditRecord;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class EditPengajuan extends EditRecord
{
    protected static string $resource = PengajuanResource::class;

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

                        $this->notify('success', 'Pengajuan berhasil ditolak');
                        $this->redirect(PengajuanResource::getUrl('index'));
                    });
                });
        }

        if ($userRole === 'kaprod') {
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
                } else if ($newStatus === RequestStatus::PROSESKAPRODI->value) {
                    RequestTrack::create([
                        'tracking_number'                => $record->tracking_number,
                        'academic_transcript_request_id' => $record->id,
                        'status'                         => $newStatus,
                        'action_desc'                    => "Pengajuan dikirim kepada kaprodi untuk tanda tangan",
                        'action_notes'                   => $notesContent,
                        'request_transcript_url'         => $record->transcript_url,
                    ]);
                } else if ($newStatus === RequestStatus::DITERUSKANKEOPERATOR->value) {
                    RequestTrack::create([
                        'tracking_number'                => $record->tracking_number,
                        'academic_transcript_request_id' => $record->id,
                        'status'                         => $newStatus,
                        'action_desc'                    => "Pengajuan selesai ditanda tangani dan diteruskan kepada operator akademik",
                        'action_notes'                   => $notesContent,
                        'request_transcript_url'         => $record->transcript_url,
                    ]);
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
