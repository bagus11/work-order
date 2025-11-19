<?php

return [

   'credentials' => [
        'file' => base_path(env('FIREBASE_CREDENTIALS', 'storage/app/firebase-service-account.json')),
    ],

    'database' => [
        'url' => env('FIREBASE_DATABASE_URL'),
    ],

];
