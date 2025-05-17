<?php
namespace App\Filament\Resources;

use Z3d0X\FilamentLogger\Resources\ActivityResource as BaseActivityResource;

class ActivityResource extends BaseActivityResource
{
    public static function shouldRegisterNavigation(): bool
    {
        return auth()->user()->can('view_any_activity');
    }

    public static function getNavigationGroup(): ?string
    {
        return 'Settings';
    }

    public static function getNavigationSort(): ?int
    {
        return 100;
    }
}
