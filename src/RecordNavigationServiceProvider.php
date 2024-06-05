<?php

namespace JoseEspinal\RecordNavigation;

use Spatie\LaravelPackageTools\Package;
use Spatie\LaravelPackageTools\PackageServiceProvider;

class RecordNavigationServiceProvider extends PackageServiceProvider
{
    public function configurePackage(Package $package): void
    {
        /*
         * More info: https://github.com/spatie/laravel-package-tools
         */
        $package
            ->name('filament-record-navigation')
            ->hasViews();
    }
}
