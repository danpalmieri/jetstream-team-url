<?php

return [
    'url' => [
        'prefix' => 'teams', // the prefix for the team routes
        'team_attribute' => 'id', // the attribute to use for the team route
    ],

    'on_denied' => [
        'strategy' => 'redirect', // abort|redirect
        'redirect' => [
            'to' => '/',
            'with' => ['error' => 'You are not allowed to access this team.'],
        ],
        'abort' => [
            'code' => 403,
            'message' => 'You are not allowed to access this team.',
        ],
    ],

    'on_different_team' => [
        'strategy' => 'switch', // abort|switch
        'abort' => [
            'code' => 403,
            'message' => 'You are not working on the right team.',
        ],
    ],
];
