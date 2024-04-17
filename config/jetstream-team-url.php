<?php

return [
    'url' => [
        'prefix' => 'teams', // string|null (the prefix for the team routes)
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
