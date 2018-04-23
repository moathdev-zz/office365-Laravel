<?php

return [
    'appId'              => env('OFFICE365_APP_ID'),

    'secret'             => env('OFFICE365_SECRET_APP_KEY'),

    'redirect_url'       => env('OFFICE365_REDIRECT_URI'),

    'scopes'             => env('OFFICE365_SCOPES'),

    'authority'          => 'https://login.microsoftonline.com/common',

    'authority_endpoint' => '/oauth2/v2.0/authorize',

    'authority_token'    => '/oauth2/v2.0/token',
];

