# Jetstream Team URL

[![Latest Version on Packagist](https://img.shields.io/packagist/v/danpalmieri/jetstream-team-url.svg?style=flat-square)](https://packagist.org/packages/danpalmieri/jetstream-team-url)
[![GitHub Code Style Action Status](https://img.shields.io/github/actions/workflow/status/danpalmieri/jetstream-team-url/fix-php-code-style-issues.yml?branch=main&label=code%20style&style=flat-square)](https://github.com/danpalmieri/jetstream-team-url/actions?query=workflow%3A"Fix+PHP+code+style+issues"+branch%3Amain)

A package to show the user's current team in the url. You must install Laravel Jetstream with the Team feature enabled.

## Installation

You can install the package via composer:

```bash
composer require danpalmieri/jetstream-team-url
```

You can publish the config file with:

```bash
php artisan vendor:publish --tag="jetstream-team-url-config"
```

This is the contents of the published config file:

```php
return [
    'url' => [
        'prefix' => 'teams', // the prefix for the team routes
        'team_attribute' => 'id', // the attribute to use for the team route
    ],

    'middleware' => \DanPalmieri\JetstreamTeamUrl\Middleware\VerifyOrSetCurrentTeamInRoute::class,

    'on_denied' => [
        'strategy' => 'redirect', // abort|redirect
        'redirect' => [
            'to' => '/',
            'with' => ['error' => 'You are not allowed to access this team.'],
        ],
        'abort' => [403, 'You are not allowed to access this team.'],
    ],

    'on_different_team' => [
        'strategy' => 'switch', // abort|switch
        'abort' => [403, 'You are not working on the right team.'],
    ],
];
```

## Usage

Just add the method useTeamInUrl() method to your routes group.

```php
Route::useTeamInUrl(function () {
    Route::get('/dashboard', fn () => view('dashboard'));
});

Route::currentTeamRedirect('_');
```

## Testing

```bash
composer test
```

## Changelog

Please see [CHANGELOG](CHANGELOG.md) for more information on what has changed recently.

## Contributing

Please see [CONTRIBUTING](CONTRIBUTING.md) for details.

## Security Vulnerabilities

Please review [our security policy](../../security/policy) on how to report security vulnerabilities.

## Credits

- [Dan Palmieri](https://github.com/danpalmieri)
- [All Contributors](../../contributors)

## License

The MIT License (MIT). Please see [License File](LICENSE.md) for more information.
