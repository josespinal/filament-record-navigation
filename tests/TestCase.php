<?php

namespace JoseEspinal\FilamentRecordNavigation\Tests;

use Illuminate\Database\Eloquent\Factories\Factory;
use JoseEspinal\FilamentRecordNavigation\FilamentRecordNavigationServiceProvider;
use Orchestra\Testbench\TestCase as Orchestra;

class TestCase extends Orchestra
{
    protected function setUp(): void
    {
        parent::setUp();

        Factory::guessFactoryNamesUsing(
            fn (string $modelName) => 'Jose Espinal\\FilamentRecordNavigation\\Database\\Factories\\'.class_basename($modelName).'Factory'
        );
    }

    protected function getPackageProviders($app)
    {
        return [
            FilamentRecordNavigationServiceProvider::class,
        ];
    }

    public function getEnvironmentSetUp($app)
    {
        config()->set('database.default', 'testing');

        /*
        $migration = include __DIR__.'/../database/migrations/create_filament-record-navigation_table.php.stub';
        $migration->up();
        */
    }
}
