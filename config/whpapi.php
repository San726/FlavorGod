<?php

return [

    'apiurl' => env('WHP_API_URL', 'https://api.wehandlepay.com'),
    'apikey' => env('WHP_API_KEY', 'devgru'),
    'secret' => env('WHP_API_SECRET', 'terces'),
    'creds'  => [
        'direct'  => env('WHP_API_DIRECT_CRED_ID', 10),    // Direct Payments
        'capture' => env('WHP_API_CAPTURE_CRED_ID', 11)    // Express Checkout
    ]
];
