<?php

namespace JoseEspinal\RecordNavigation\Tests;

use Illuminate\Database\Eloquent\Factories\Factory;
use JoseEspinal\RecordNavigation\RecordNavigationServiceProvider;
use Orchestra\Testbench\TestCase as Orchestra;

class TestCase extends Orchestra
{
    protected function setUp(): void
    {
        parent::setUp();

        Factory::guessFactoryNamesUsing(
            fn (string $modelName) => 'Jose Espinal\\RecordNavigation\\Database\\Factories\\'.class_basename($modelName).'Factory'
        );
    }

    protected function getPackageProviders($app)
    {
        return [
            RecordNavigationServiceProvider::class,
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
