<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Gate;

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
        $this->loadRoutesFrom(__DIR__.'/routes.php');

        $this->publishes([
            __DIR__.'/../public' => public_path('vendor/settings'),
        ], 'public');

        // load the settings Class
        $this->app->singleton('reecem.settings', function(){
            return new \ReeceM\Settings\Services\SettingService();
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
        $this->loadViewsFrom(__DIR__.'../resources/views', 'settings');

        $this->publishes([
            __DIR__.'/../resources/views' => resource_path('views/vendor/settings'),
        ], 'views');
    }

    protected function registerConfig()
    {
        $this->publishes([
            __DIR__.'/../config/setting.php' => config_path('setting.php')
        ], 'config');
    }

    public function registerMigration()
    {
        $this->publishes([
            __DIR__.'/../database/migrations/' => database_path('migrations')
        ], 'migrations');
    }
}
