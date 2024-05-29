<?php

namespace Jose Espinal\FilamentRecordNavigation\Facades;

use Illuminate\Support\Facades\Facade;

/**
 * @see \Jose Espinal\FilamentRecordNavigation\FilamentRecordNavigation
 */
class FilamentRecordNavigation extends Facade
{
    protected static function getFacadeAccessor(): string
    {
        return \Jose Espinal\FilamentRecordNavigation\FilamentRecordNavigation::class;
    }
}
