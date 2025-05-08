<?php
namespace App\Helpers;

use Illuminate\Support\Str;

class TrackingNumberGenerator
{
    public static function generate(string $prefix, string $column, string $modelClass): string
    {
        do {
            $trackingNumber = $prefix . '-' . strtoupper(Str::random(8));
        } while ($modelClass::where($column, $trackingNumber)->exists());

        return $trackingNumber;
    }
}
