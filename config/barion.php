<?php

declare(strict_types=1);

// config for LovaszCC/Barion
return [
    'live_env' => env('BARION_LIVE_ENV', false),
    'pos_key' => env('BARION_POS_KEY'),
    'callback_url' => env('BARION_CALLBACK_URL'),
    'redirect_url' => env('BARION_REDIRECT_URL'),
    'payee' => env('BARION_PAYEE'),
];
