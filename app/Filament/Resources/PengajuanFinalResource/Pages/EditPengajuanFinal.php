<?php

namespace App\Filament\Resources\PengajuanFinalResource\Pages;

use App\Filament\Resources\PengajuanFinalResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditPengajuanFinal extends EditRecord
{
    protected static string $resource = PengajuanFinalResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
