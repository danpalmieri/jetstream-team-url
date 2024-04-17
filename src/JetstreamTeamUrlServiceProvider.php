<?php

namespace DanPalmieri\JetstreamTeamUrl;

use Spatie\LaravelPackageTools\Package;
use Spatie\LaravelPackageTools\PackageServiceProvider;
use DanPalmieri\JetstreamTeamUrl\Commands\JetstreamTeamUrlCommand;

class JetstreamTeamUrlServiceProvider extends PackageServiceProvider
{
    public function configurePackage(Package $package): void
    {
        /*
         * This class is a Package Service Provider
         *
         * More info: https://github.com/spatie/laravel-package-tools
         */
        $package
            ->name('jetstream-team-url')
            ->hasConfigFile()
            ->hasViews();
    }
}
