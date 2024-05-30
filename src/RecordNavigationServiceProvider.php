<?php

namespace JoseEspinal\RecordNavigation;

use JoseEspinal\RecordNavigation\Resources\RecordNavigationResource;
use Spatie\LaravelPackageTools\Package;
use Spatie\LaravelPackageTools\PackageServiceProvider;

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
