<?php

return [

    'url' => env('CHECKER_URL', 'https://www.google.com'),

    'timeout' => env('CHECKER_TIMEOUT', 100),

    'types' => [
        'SOCKS5',
        'HTTP',
        'HTTPS',
    ],
];
