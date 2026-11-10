<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Cloudinary Configuration
    |--------------------------------------------------------------------------
    |
    | Centralized Cloudinary configuration using a single CLOUDINARY_URL
    | environment variable format: cloudinary://API_KEY:API_SECRET@CLOUD_NAME
    |
    */

    'url' => env('CLOUDINARY_URL'),

    'defaults' => [
        'folder' => env('CLOUDINARY_FOLDER', 'hero_banners'),
    ],

];
