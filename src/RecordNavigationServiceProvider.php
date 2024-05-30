<?php

namespace JoseEspinal\RecordNavigation;

use Spatie\LaravelPackageTools\Package;
use Spatie\LaravelPackageTools\PackageServiceProvider;
use JoseEspinal\RecordNavigation\Resources\RecordNavigationResource;

class RecordNavigationServiceProvider extends PackageServiceProvider
{
    public function configurePackage(Package $package): void
    {
        /*
         * This class is a Package Service Provider
         *
         * More info: https://github.com/spatie/laravel-package-tools
         */
        $package
            ->name('filament-record-navigation')
            ->hasConfigFile()
            ->hasViews();
    }

    protected function getResources(): array
    {
        return [
            RecordNavigationResource::class,
        ];
    }
}
