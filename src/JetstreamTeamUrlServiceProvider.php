<?php

namespace DanPalmieri\JetstreamTeamUrl;

use Illuminate\Support\Facades\Route;
use Spatie\LaravelPackageTools\Package;
use Spatie\LaravelPackageTools\PackageServiceProvider;

class JetstreamTeamUrlServiceProvider extends PackageServiceProvider
{
    public function bootingPackage(): void
    {
        Route::macro('useTeamInUrl', function (callable $routes) {
            Route::middleware(config('jetstream-team-url.middleware'))
                ->prefix(config('jetstream-team-url.url.prefix').'/{currentTeam}')
                ->group($routes);
        });

        Route::macro('currentTeamRedirect', function ($route) {

            Route::prefix($route)->group(function () use ($route) {
                Route::get('{any}', function () use ($route) {
                    ! session()->has(config('jetstream-team-url.on_denied.with.key')) ?: session()->flash(config('jetstream-team-url.on_denied.with.key'), session(config('jetstream-team-url.on_denied.with.key')));

                    $attribute = config('jetstream-team-url.url.team_attribute');

                    $redirect = str(config('jetstream-team-url.url.prefix').'/'.auth()->user()->currentTeam->{$attribute}.'/')->start('/');

                    $url = str()->replace('/'.$route.'/', $redirect, request()->fullUrl());

                    return redirect($url);
                })->where('any', '.*');
            });

        });
    }

    public function registeringPackage(): void
    {
        config()->set('fortify.middleware', array_merge(config('fortify.middleware'), [config('jetstream-team-url.middleware')]));
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
            ->hasViews();
    }
}
