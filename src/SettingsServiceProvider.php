<?php

namespace ReeceM\Settings;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Route;
use ReeceM\Settings\Console\SettingsInstall;

class SettingsServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        //
        $this->gate();
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        /**
         * Register all of the applications
         */
        $this->registerCommands();
        $this->registerConfig();
        $this->loadRoutes();
        $this->handlePublishing();
        $this->registerViews();

        // load the settings Class
        $this->app->singleton('reecem.settings', function () {

            $mapper = '\ReeceM\Settings\Mapper';

            if (class_exists('\App\Settings\SettingMapper'))
            {
                $mapper = '\App\Settings\SettingMapper';
            }   

            return new \ReeceM\Settings\Services\SettingService(new $mapper());
        });
    }

    /**
     * Register the settings gate.
     *
     * This gate determines who can access reecem.settings 
     *
     * @return void
     */
    protected function gate()
    {
        Gate::define('settings.admin', function ($user) {
            $ids = config('setting.admins', '');
            $ids = explode(',', $ids);
            return in_array($user->id, $ids);
        });
    }

    /**
     * register the settings page views
     */
    protected function registerViews()
    {
        $this->loadViewsFrom(__DIR__ . '/../resources/views', 'settings');

        // $this->publishes([
        //     __DIR__ . '/../resources/views' => resource_path('views/vendor/settings'),
        // ], 'settings_views');
    }

    /**
     * Registers the applications config file and/or exports it
     */
    protected function registerConfig()
    {
        $this->mergeConfigFrom(
            __DIR__ . '/../config/setting.php',
            'setting'
        );

        // $this->publishes([
        //     __DIR__ . '/../config/setting.php' => config_path('setting.php')
        // ], 'settings_config');
    }

    /**
     * Load the routes for the settings
     */
    protected function loadRoutes()
    {
        $routeConfig = [
            'namespace'     => '\ReeceM\Settings\Http\Controllers',
            'middleware'    => config('setting.middleware', ['web']),
            'prefix'        => config('setting.path')
        ];

        Route::group($routeConfig, function () {
            $this->loadRoutesFrom(__DIR__ . '/../routes/web.php');
        });
    }

    protected function registerCommands()
    {
        if ($this->app->runningInConsole()) {
            $this->commands([
                SettingsInstall::class,
                // other commands for cleaning and such ??
            ]);
        }
    }

    /**
     * Register the package's publishable resources.
     *
     * @return void
     */
    private function handlePublishing()
    {
        if ($this->app->runningInConsole()) {
            $this->publishes([
                __DIR__ . '/../public' => public_path('vendor/settings'),
            ], 'settings_assets');

            $this->publishes([
                __DIR__ . '/../config/setting.php' => config_path('setting.php'),
            ], 'settings_config');

            $this->publishes([
                __DIR__ . '/../migrations/' => database_path('migrations')
            ], 'settings_migrations');

            // $this->publishes([
            //     __DIR__ . '/../stubs/providers/SettingsServiceProvider.stub' => app_path(
            //         'Providers/SettingsServiceProvider.php'
            //     ),
            // ], 'settings_provider');

            $this->publishes([
                __DIR__ . '/../stubs/SettingMapper.stub' => app_path(
                    'Settings/SettingMapper.php'
                ),
            ], 'settings_mapper');
        }
    }
}
