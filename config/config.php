<?php

return [
    "cookie" => [
        'key' => env('JWT_AUTH_COOKIE_KEY', 'auth-token')
    ],
    "auth-header" => [
        'enabled' => env('JWT_AUTH_AUTH_HEADER_ENABLED', false)
    ]
];
