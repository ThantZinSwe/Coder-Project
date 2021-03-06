<?php

return array(

    /*
    |--------------------------------------------------------------------------
    | Default Filesystem Disk
    |--------------------------------------------------------------------------
    |
    | Here you may specify the default filesystem disk that should be used
    | by the framework. The "local" disk, as well as a variety of cloud
    | based disks are available to your application. Just store away!
    |
     */

    'default' => env( 'FILESYSTEM_DRIVER', 'local' ),

    /*
    |--------------------------------------------------------------------------
    | Filesystem Disks
    |--------------------------------------------------------------------------
    |
    | Here you may configure as many filesystem "disks" as you wish, and you
    | may even configure multiple disks of the same driver. Defaults have
    | been setup for each driver as an example of the required options.
    |
    | Supported Drivers: "local", "ftp", "sftp", "s3"
    |
     */

    'disks'   => array(

        'local'        => array(
            'driver' => 'local',
            'root'   => storage_path( 'app' ),
        ),

        'public'       => array(
            'driver'     => 'local',
            'root'       => storage_path( 'app/public' ),
            'url'        => env( 'APP_URL' ) . '/storage',
            'visibility' => 'public',
        ),

        'image'        => array(
            'driver'     => 'local',
            'root'       => storage_path( 'app/image' ),
            'url'        => env( 'APP_URL' ) . '/image',
            'visibility' => 'public',
        ),

        'courseImage'  => array(
            'driver'     => 'local',
            'root'       => storage_path( 'app/courseImage' ),
            'url'        => env( 'APP_URL' ) . '/courseImage',
            'visibility' => 'public',
        ),

        'paymentImage' => array(
            'driver'     => 'local',
            'root'       => storage_path( 'app/paymentImage' ),
            'url'        => env( 'APP_URL' ) . '/paymentImage',
            'visibility' => 'public',
        ),

        's3'           => array(
            'driver'                  => 's3',
            'key'                     => env( 'AWS_ACCESS_KEY_ID' ),
            'secret'                  => env( 'AWS_SECRET_ACCESS_KEY' ),
            'region'                  => env( 'AWS_DEFAULT_REGION' ),
            'bucket'                  => env( 'AWS_BUCKET' ),
            'url'                     => env( 'AWS_URL' ),
            'endpoint'                => env( 'AWS_ENDPOINT' ),
            'use_path_style_endpoint' => env( 'AWS_USE_PATH_STYLE_ENDPOINT', false ),
        ),

    ),

    /*
    |--------------------------------------------------------------------------
    | Symbolic Links
    |--------------------------------------------------------------------------
    |
    | Here you may configure the symbolic links that will be created when the
    | `storage:link` Artisan command is executed. The array keys should be
    | the locations of the links and the values should be their targets.
    |
     */

    'links'   => array(
        public_path( 'storage' )      => storage_path( 'app/public' ),
        public_path( 'image' )        => storage_path( 'app/image' ),
        public_path( 'courseImage' )  => storage_path( 'app/courseImage' ),
        public_path( 'paymentImage' ) => storage_path( 'app/paymentImage' ),
    ),

);
