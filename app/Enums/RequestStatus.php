<?php
namespace App\Enums;

use Filament\Support\Contracts\HasLabel;

enum RequestStatus: string implements HasLabel {

    case PROSESOPERATOR         = 'diproses_operator';
    case PROSESKAPRODI          = 'diproses_kaprodi';
    case DIKEMBALIKANKEOPERATOR = 'dikembalikan_ke_operator';
    case DIKEMBALIKANKEKAPRODI  = 'dikembalikan_ke_kaprodi';
    case DITOLAK                = 'ditolak';
    case SELESAI                = 'selesai';

    public function getColor(): string
    {
        return match ($this) {
            self::PROSESOPERATOR => 'yellow',
            self::PROSESKAPRODI => 'yellow',
            self::DIKEMBALIKANKEKAPRODI => 'warning',
            self::DIKEMBALIKANKEOPERATOR => 'warning',
            self::DITOLAK => 'danger',
            self::SELESAI => 'success'
        };
    }

    public function getLabel(): string
    {
        return match ($this) {
            self::PROSESOPERATOR => 'Diproses Operator',
            self::PROSESKAPRODI => 'Diproses Kaprodi',
            self::DIKEMBALIKANKEOPERATOR => 'Dikembalikan Ke Operator',
            self::DIKEMBALIKANKEKAPRODI => 'Dikembalikan ke Kaprodi',
            self::DITOLAK => 'Ditolak',
            self::SELESAI => 'Selesai'
        };
    }
}
