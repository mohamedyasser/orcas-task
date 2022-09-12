<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Third Party Services
    |--------------------------------------------------------------------------
    |
    | This file is for storing the credentials for third party services such
    | as Mailgun, Postmark, AWS and more. This file provides the de facto
    | location for this type of information, allowing packages to have
    | a conventional file to locate the various service credentials.
    |
    */

    'mailgun' => [
        'domain' => env('MAILGUN_DOMAIN'),
        'secret' => env('MAILGUN_SECRET'),
        'endpoint' => env('MAILGUN_ENDPOINT', 'api.mailgun.net'),
        'scheme' => 'https',
    ],

    'postmark' => [
        'token' => env('POSTMARK_TOKEN'),
    ],

    'ses' => [
        'key' => env('AWS_ACCESS_KEY_ID'),
        'secret' => env('AWS_SECRET_ACCESS_KEY'),
        'region' => env('AWS_DEFAULT_REGION', 'us-east-1'),
    ],
    'users' => [
        'v1' => [
            'url' => env('USERS_V1_URL'),
            'schema' => [
                'email' => 'email',
                'first_name' => 'firstName',
                'last_name' => 'lastName',
                'avatar' => 'avatar'
            ],
        ],
        'v2' => [
            'url' => env('USERS_V2_URL'),
            'schema' => [
                'email' => 'email',
                'first_name' => 'fName',
                'last_name' => 'lName',
                'avatar' => 'picture'
            ],
        ],
    ],
];
