<?php

return [
    // set "Access-Control-Allow-Credentials" 👉 string "false" or "true".
    'allow-credentials' => env('CORS_ALLOW_CREDENTIALS', false),
    // eg: Content-Type, Accept, X-Requested-With
    'allow-headers' => ['*'],
    'expose-headers' => ['Authorization'],
    // eg: http://localhost
    'origins' => ['*'],
    // eg: GET, POST, PUT, PATCH, DELETE
    'methods' => ['*'],
    'max-age' => env('CORS_ACCESS_CONTROL_MAX_AGE', 0),
    'laravel' => [
        // The prefix is using \Illumante\Http\Request::is method. 👉
        'allow-route-prefix' => env('CORS_LARAVEL_ALLOW_ROUTE_PREFIX', '*'),
        'route-group-mode' => env('CORS_LARAVEL_ROUTE_GROUP_MODE', false),
    ],
];
