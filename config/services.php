<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Third Party Services
    |--------------------------------------------------------------------------
    |
    | This file is for storing the credentials for third party services such
    | as Stripe, Mailgun, SparkPost and others. This file provides a sane
    | default location for this type of information, allowing packages
    | to have a conventional place to find your various credentials.
    |
    */

    'mailgun' => [
        'domain' => env('MAILGUN_DOMAIN'),
        'secret' => env('MAILGUN_SECRET'),
    ],

    'ses' => [
        'key'    => env('SES_KEY'),
        'secret' => env('SES_SECRET'),
        'region' => 'us-east-1',
    ],

    'sparkpost' => [
        'secret' => env('SPARKPOST_SECRET'),
    ],

    'stripe' => [
        'model'  => App\Models\User::class,
        'key'    => env('STRIPE_KEY'),
        'secret' => env('STRIPE_SECRET'),
    ],

    'fcu-api' => [
        'url-oauth'          => env('FCU_API_URL_OAUTH'),
        'url-get-stu-info'   => env('FCU_API_URL_GET_STU_INFO'),
        'url-get-login-user' => env('FCU_API_URL_GET_LOGIN_USER'),
        'url-get-user-info'  => env('FCU_API_URL_GET_USER_INFO'),
        'client-id'          => env('FCU_API_CLIENT_ID'),
        'client-url'         => env('FCU_API_CLIENT_URL'),
    ],

    'google' => [
        'map'      => [
            'embed_key' => env('GOOGLE_MAP_EMBED_KEY'),
        ],
        'analysis' => [
            'id' => env('GOOGLE_ANALYSIS'),
        ],
    ],

];
