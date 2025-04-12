<?php

namespace JoseEspinal\RecordNavigation;

use Filament\Support\Assets\Js;
use Filament\Support\Facades\FilamentAsset;
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

    public function packageBooted(): void
    {
        // Register as a Filament asset
        FilamentAsset::register([
            Js::make('filament-record-navigation', __DIR__ . '/../resources/dist/js/filament-record-navigation.js'),
        ], 'joseespinal/filament-record-navigation');
    }
}
