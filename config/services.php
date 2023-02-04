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
        'domain' => env('MAILGUN_DOMAIN', $_ENV['MAILGUN_DOMAIN'] ?? null),
        'secret' => env('MAILGUN_SECRET', $_ENV['MAILGUN_SECRET'] ?? null),
        'endpoint' => env('MAILGUN_ENDPOINT', $_ENV['MAILGUN_ENDPOINT'] ?? 'api.mailgun.net'),
        'scheme' => 'https',
    ],

    'postmark' => [
        'token' => env('POSTMARK_TOKEN', $_ENV['POSTMARK_TOKEN'] ?? null),
    ],

    'ses' => [
        'key' => env('AWS_ACCESS_KEY_ID', $_ENV['AWS_ACCESS_KEY_ID'] ?? null),
        'secret' => env('AWS_SECRET_ACCESS_KEY', $_ENV['AWS_SECRET_ACCESS_KEY'] ?? null),
        'region' => env('AWS_DEFAULT_REGION', $_ENV['AWS_DEFAULT_REGION'] ?? 'eu-central-1'),
    ],

    'musicbrainz' => [
        'user_agent' => env('MUSICBRAINZ_USER_AGENT', $_ENV['MUSICBRAINZ_USER_AGENT'] ?? null),
    ],

    'spotify' => [
        'api' => [
            'client_id' => env('SPOTIFY_API_CLIENT_ID', $_ENV['SPOTIFY_API_CLIENT_ID'] ?? null),
            'client_secret' => env('SPOTIFY_API_CLIENT_SECRET', $_ENV['SPOTIFY_API_CLIENT_SECRET'] ?? null),
        ],
    ],

    'youtube' => [
        'api' => [
            'key' => env('YOUTUBE_API_KEY', $_ENV['YOUTUBE_API_KEY'] ?? NULL),
        ],
    ],

];
