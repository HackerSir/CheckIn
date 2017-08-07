<?php

return [
    /*
     * Public client id provided by Imgur
     */
    'client_id'     => env('IMGUR_CLIENT_ID'),

    /**
     * Client secret provided by Imgur
     */
    'client_secret' => env('IMGUR_CLIENT_SECRET'),

    /**
     * The storage facility to be used to store a user's token.
     * Should be a name of a class implementing the
     *   Redeman\Imgur\TokenStorage\Storage
     * interface.
     */
    'token_storage' => 'Redeman\Imgur\TokenStorage\SessionStorage',
];
