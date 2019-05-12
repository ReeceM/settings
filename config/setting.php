<?php

return [
    /***********************************************
    |       settings ADMIN USERS
    |   Deny all users until they are actually setup
     */
    'admins' => env('SETTING_ADMINS', ''),

    /*
    |   storage settings for now only has the db table name
    |   
    */
    'storage' => [
        'table' => 'app_settings',
        'disk'  => env('SETTINGS_DISK', 'local'),
    ],

    /*
    |   add your custom types to this definition and the methods will be auto-detected
    */
    'types' => [
        
    ],
    /* 
    |   Applications middleware for the settings channels
    |
    */
    'middleware' => [
        'web', 'auth', 'can:settings.admin'
    ],
    /*
    |  The setting for the path of the settings routes
    |   you can change this, no forward slashes.
    */
    'path' => 'system'
];
