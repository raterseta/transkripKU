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

        $userRole = auth()->user()->roles->pluck('name')->first();

        $actions = [];

        if ($userRole === 'super_admin') {
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
                            'action_desc'                    => "Pengajuan ditolak oleh: {$user->name} ({$user->roles->pluck('name')->first()})",
                            'action_notes'                   => $data['action_notes'],
                            'request_transcript_url'         => $this->record->transcript_url,
                            'request_notes'                  => $this->record->notes,
                        ]);

                        $this->notify('success', 'Pengajuan berhasil ditolak');
                        $this->redirect(PengajuanResource::getUrl('index'));
                    });
                });
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
            $oldStatus = $record->status;
            $record->update($data);

            if ($oldStatus !== $record->status) {
                $user = auth()->user();
                RequestTrack::create([
                    'tracking_number'                => $record->tracking_number,
                    'academic_transcript_request_id' => $record->id,
                    'status'                         => $record->status,
                    'action_desc'                    => "Status diperbarui ke: " . $record->status->getLabel(),
                    'action_notes'                   => "Diperbarui oleh: {$user->name} ({$user->roles->pluck('name')->first()})",
                    'request_transcript_url'         => $record->transcript_url,
                    'request_notes'                  => $record->notes,
                ]);
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
