<?php

return [

    /*
    |-----------------------------------------------------------------
    | Generator Settings
    |-----------------------------------------------------------------
    |
    | The following options allow you to adjust the behavior of
    | tool generation in your application.
    |
    */

    'generator' => [
        'namespace' => 'App\\Scribble',
        'views' => 'scribble-tools',
    ],

    'globals' => [
        'heading_levels' => [1, 2, 3],
    ],

    /*
    |-----------------------------------------------------------------
    | Media Settings
    |-----------------------------------------------------------------
    |
    | The following options allow you to adjust the behavior of
    | media uploads handled by Scribble.
    |
    */

    'media' => [
        'accepted_file_types' => ['image/jpeg', 'image/png', 'image/webp', 'image/svg+xml', 'application/pdf'],
        'disk' => env('FILAMENT_FILESYSTEM_DISK', 'public'),
        'directory' => 'media',
        'visibility' => 'public',
        'preserve_file_names' => false,
        'max_file_size' => 2042,
        'image_resize_mode' => null,
        'image_crop_aspect_ratio' => null,
        'image_resize_target_width' => null,
        'image_resize_target_height' => null,
        'use_relative_paths' => true,
    ],

];
