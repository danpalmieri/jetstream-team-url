<?php

namespace DanPalmieri\JetstreamTeamUrl\Tests;

use DanPalmieri\JetstreamTeamUrl\JetstreamTeamUrlServiceProvider;
use Illuminate\Database\Eloquent\Factories\Factory;
use Orchestra\Testbench\TestCase as Orchestra;

class TestCase extends Orchestra
{
    protected function setUp(): void
    {
        parent::setUp();

        Factory::guessFactoryNamesUsing(
            fn (string $modelName) => 'DanPalmieri\\JetstreamTeamUrl\\Database\\Factories\\'.class_basename($modelName).'Factory'
        );
    }

    protected function getPackageProviders($app)
    {
        return [
            JetstreamTeamUrlServiceProvider::class,
        ];
    }

    public function getEnvironmentSetUp($app)
    {
        config()->set('database.default', 'testing');

        /*
        $migration = include __DIR__.'/../database/migrations/create_jetstream-team-url_table.php.stub';
        $migration->up();
        */
    }
}
