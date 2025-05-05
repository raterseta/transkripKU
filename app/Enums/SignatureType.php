<?php
namespace App\Enums;

use Filament\Support\Contracts\HasLabel;

enum SignatureType: string implements HasLabel {

    case DIGITAL = 'digital';
    case WET     = 'basah';

    public function getLabel(): string
    {
        return match ($this) {
            self::DIGITAL => 'Digital',
            self::WET => 'Basah'
        };
    }
}
