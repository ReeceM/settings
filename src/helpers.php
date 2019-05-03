<?php

if(! function_exists('setting'))
{
    /**
     * Gets Global settings method
     * @return \ReeceM\Settings\SettingService
     */
    function setting($key = null, $default = null)
    {
        if(is_null($key)) {
            return app('reecem.settings');
        }

        return app('reecem.settings')->get($key, $default);
    }
}
