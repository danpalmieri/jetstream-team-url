<?php

namespace DanPalmieri\JetstreamTeamUrl;

use Spatie\LaravelPackageTools\Package;
use Spatie\LaravelPackageTools\PackageServiceProvider;
use Illuminate\Routing\Route;

class JetstreamTeamUrlServiceProvider extends PackageServiceProvider
{
    public function boot(): void
    {
        Route::macro('useTeamInUrl', function () {
            $this->middleware(config('jetstream-team-url.middleware'));

            return $this;
        });
    }

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
            ->hasViews()
        ;
    }
}
