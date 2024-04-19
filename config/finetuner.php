<?php

// config for HalilCosdu/FineTuner
return [
    'api_key' => env('OPENAI_API_KEY'),
    'organization' => env('OPENAI_ORGANIZATION'),
    'request_timeout' => env('OPENAI_TIMEOUT'),
    'use_storage' => env('FINE_TUNER_USE_STORAGE', false),
    'storage' => [
        'disk' => env('FINE_TUNER_STORAGE', 'public'),
    ],
];
