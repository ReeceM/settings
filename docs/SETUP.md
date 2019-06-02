# Setup

The settings package when using the default install is quite simple, requiring at least two interactions with the terminal.

When you have installed the settings package you can the customise the settings by means of the `config/setting.php` file. 

The settings package by default has all security turned on. This is by means of the default laravel auth middleware for all requests. It also has a custom Gate defined, which can be used to override the default settings and also in conjunction with the middleware change the auth levels. See ["Changing the Methods of Auth"](#changing-the-methods-of-auth)

## Install
To setup or install the settings package you can use

```bash
composer require reecem/settings
```

Then install through the artisan command

```bash
php artisan settings:install
```

## updates 

when there is a new release please run `settings:update` just to refresh the published assets
```bash
php artisan settings:update
```

## config file

The default config file looks as follows:

```php
return [
    /**
     *     settings ADMIN USERS
     *  Deny all users until they are actually setup
     */
    'admins' => env('SETTING_ADMINS', ''),

    /*
     *   storage settings for now only has the db table name
     *   
     */
    'storage' => [
        'table' => 'app_settings',
        'disk'  => env('SETTINGS_DISK', 'local'),
        'method' => env('SETTING_STORAGE_METHOD', 'serialize')
    ],

    /**
     * Set this to encrypt the settings file as a whole
     * set to false default for sanity sake and testing
     */
    'encrypt_file' => false,
    /*
     *   add your custom types to this definition and the methods will be auto-detected
     */
    'types' => [
        
    ],
    /* 
     *   Applications middleware for the settings channels
     *
     */
    'middleware' => [
        'web', 'auth', 'can:settings.admin'
    ],
    /*
     *  The setting for the path of the settings routes
     *   you can change this, no forward slashes.
     */
    'path' => 'system'
];
```

## Securing by means of Gate

The default Gate guard looks like this for the settings package: 

```php
Gate::define('settings.admin', function ($user) {
    $ids = config('setting.admins', '');
    $ids = explode(',', $ids);
    return in_array($user->id, $ids);
});
```

It uses the id from the user and then the id from a csv list in `.env` or config file.


## Changing the Methods of Auth

You can remove the auth requirements by changing the middleware config in the `config/settings.php` file as this is used in the Service Provider to set all the routes middleware, `[ 'middleware'    => config('setting.middleware', ['web']) ]`

You can then change the definition of the `settings.admin` gate in AppServiceProvider. (the exported service provider needs work done on it...)

> ***a note of caution.***
> the `web` middleware is always applied to get the routebinding data.
> if you have setup some odd auth schemes here, 
> then please note that this would naturally be your settings
