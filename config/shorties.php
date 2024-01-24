<?php

return [
    'config' => [
        'short_url_length' => env('SHORT_URL_CODE_LENGTH', 6),
        'short_url_prefix' => env('SHORT_URL_PREFIX', 'http://localhost'),
    ],
];
