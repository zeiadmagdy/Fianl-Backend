<?php

use CloudinaryLabs\CloudinaryLaravel\Facades\Cloudinary;

return [

    /*
    |--------------------------------------------------------------------------
    | Cloudinary Configuration
    |--------------------------------------------------------------------------
    |
    | This file is used to configure Cloudinary API credentials.
    |
    */

    'cloud_name' => env('CLOUDINARY_CLOUD_NAME', ''),
    'api_key' => env('CLOUDINARY_API_KEY', ''),
    'api_secret' => env('CLOUDINARY_API_SECRET', ''),

    /*
    |--------------------------------------------------------------------------
    | Upload Preset
    |--------------------------------------------------------------------------
    |
    | This is the upload preset you can configure in your Cloudinary account.
    | Leave it empty if you don't have a preset.
    |
    */

    'upload_preset' => env('CLOUDINARY_UPLOAD_PRESET', null),

    /*
    |--------------------------------------------------------------------------
    | Secure URL
    |--------------------------------------------------------------------------
    |
    | This option enables or disables secure URLs for your uploads.
    |
    */

    'secure' => true,

    /*
    |--------------------------------------------------------------------------
    | Default Options
    |--------------------------------------------------------------------------
    |
    | You can add default options for image and video transformations.
    |
    */

    'default' => [
        'image' => [
            'width' => 800,
            'height' => 600,
            'crop' => 'fill',
            'quality' => 'auto',
        ],

        'video' => [
            'quality' => 'auto',
        ],
    ],

];
