<?php

return [
    "cookie" => [
        'key' => env('JWT_AUTH_COOKIE_KEY', 'auth-token'),
        'allow-sub-domain' => env('JWT_AUTH_ALLOW_SUB_DOMAIN', true)
    ],
    "auth-header" => [
        'enabled' => env('JWT_AUTH_AUTH_HEADER_ENABLED', false)
    ]
];
