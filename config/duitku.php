<?php

return [
    'merchant_code' => env('DUITKU_MERCHANT_CODE', 'DS23372'),
    'api_key' => env('DUITKU_API_KEY', 'e4dcf04a963be54aea6913089c1e3085'),
    'base_url' => env('DUITKU_BASE_URL', 'https://sandbox.duitku.com'),
    'callback_url' => env('DUITKU_CALLBACK_URL', 'https://03c4-114-10-147-232.ngrok-free.app/deposit/callback'),
    'return_url' => env('DUITKU_RETURN_URL', 'https://03c4-114-10-147-232.ngrok-free.app/deposit/return'),
];