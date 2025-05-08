<?php

    return [
        'environment' => env('CASHFREE_ENV', 'TEST'), // TEST or PRODUCTION
        'app_id' => env('CASHFREE_APP_ID'),
        'secret_key' => env('CASHFREE_SECRET_KEY'),
        'return_url' => env('CASHFREE_RETURN_URL'),
    ];  
?>