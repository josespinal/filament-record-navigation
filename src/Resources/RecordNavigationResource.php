<?php

namespace JoseEspinal\RecordNavigation\Resources;

use Filament\Resources\Resource;
use JoseEspinal\RecordNavigation\Traits\HasRecordNavigation;

class RecordNavigationResource extends Resource
{
    use HasRecordNavigation;

    public static function getLabel(): string
    {
        return 'Record';
    }

    public static function getNavigationIcon(): string
    {
        return 'heroicon-o-collection';
    }
}
