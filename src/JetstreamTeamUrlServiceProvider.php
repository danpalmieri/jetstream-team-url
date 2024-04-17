<?php

namespace DanPalmieri\JetstreamTeamUrl;

use Illuminate\Routing\Route;
use Illuminate\Support\Str;
use Spatie\LaravelPackageTools\Package;
use Spatie\LaravelPackageTools\PackageServiceProvider;

class JetstreamTeamUrlServiceProvider extends PackageServiceProvider
{
    public function boot(): void
    {
        Route::macro('useTeamInUrl', function () {
            $this->middleware(config('jetstream-team-url.middleware'));
            $this->prefix(config('jetstream-team-url.url.prefix'));

            return $this;
        });

        Route::macro('currentTeamRedirect', function ($route) {
            Route::get($route, function ($request, $route) {
                ! session()->has('error') ?: session()->flash('error', session('error'));

                $route = trim($route, '/');
                $redirect = str(config('jetstream-team-url.url.prefix', null).'/'.auth()->user()->currentTeam->{config('jetsream-team-url.url_team_attribute')}.'/', $request->fullUrl())->start('/');

                return redirect(Str::replace('/'.$route.'/', $redirect));
            });

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
            ->hasViews();
    }
}
