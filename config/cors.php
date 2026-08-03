<?php

return [
    'paths' => ['api/*', 'sanctum/csrf-cookie'], // ← adicione sanctum/csrf-cookie

    'allowed_methods' => ['*'],

    'allowed_origins' => ['http://localhost:5173', 'http://localhost:4173',  'https://front-endschengers-tccmain-production.up.railway.app'], 

    'allowed_origins_patterns' => [],

    'allowed_headers' => ['*'],

    'exposed_headers' => [],

    'max_age' => 0,

    'supports_credentials' => true, // ← precisa ser true para cookie funcionar
];
