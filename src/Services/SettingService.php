<?php

namespace ReeceM\Settings\Services;

use ReeceM\Settings\Setting;
use Illuminate\Filesystem\Filesystem;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Log;

/**
 * Class SettingsService
 */
class SettingService
{
    /**
     * The Setting model internal
     * @var \ReeceM\Settings\Setting $model
     */
    protected $model;
    /**
     * The Settings File
     * @var array $settings
     */
    protected $settings;

    protected $files;

    /**
     * Filesystem reader
     * @var 
     */
    protected $_configs;

    public static $configName = 'chex_settings.php';

    public function __construct(Setting $setting = null, Filesystem $filesystem = null)
    {
        $this->model = $setting ?: new Setting();
        $this->files = $filesystem ?: new Filesystem();
        $this->load();
    }

    /**
     * Get the setting in dot notation
     * 
     * @param string $key 
     * @param mixed $default
     * @return mixed
     */
    public function get($key, $default = null)
    {
        if ( !is_string($key) ) return $default;

        return Arr::get($this->settings, $key, $default);
    }
    /**
     * Gets all the settings at once
     */
    public function all()
    {
        return $this->settings;
    }
    /**
     * Caches the settings to storage
     */
    public function cache()
    {
        $configPath = base_path('bootstrap/cache/' . static::$configName);
        
        $this->settings = $this->getFresh();
        
        $this->files->put(
            $configPath, '<?php return '.var_export($this->settings, true).';'.PHP_EOL
        );
    }
    /**
     * Reads the settings file into memory
     */
    public function load()
    {
        try {
            $this->settings = $this->files->getRequire(base_path('bootstrap/cache/' . static::$configName));
        } catch (\Exception $e) {
            Log::critical('Failed to load system settings with error: ' . $e);
            throw $e;
        }
    }
    /**
     * Create a new entry in the setting models Entry
     * @param array $data the ney key|value
     */
    public function create($data)
    {
        /**
         * exit if there is no key
         */
        if (is_null(Arr::get($data, 'key'))) {
            return false;
        }
        $this->model->create($data);
        $this->cache();

        return $this->model;
    }
    /**
     * Update the setting models Entry
     * @param array $data the ney key|value
     */
    public function update($data = null)
    {
        /**
         * exit if there is no key
         */
        if (is_null(Arr::get($data, 'key'))) {
            return false;
        }
    
        Arr::set($this->settings, $data['key'], $data['value']);
        
        $this->model->where('key', $data['key'])->update([
            'value' => $data['value'],
            'type'  => $data['type']
        ]);
        $this->cache();
        return $this;
    }
    /**
     * convert the settings from database to array
     */
    public function getFresh()
    {
        $values = $this->model->all()
                                ->keyBy('key')
                                ->transform(function ($setting) {
                                    $function   = array($setting, $setting::$types[$setting->type]);
                                    $value      = array($setting->value);
                                    return call_user_func_array($function, $value);
                                })->toArray();
        $array  =  array();

        foreach($values as $key => $value)
        {
            Arr::set($array, $key, $value);
        }

        return $array;
    }
    /**
     * transform all settings to JSON
     */
    public function toJson()
    {
        return collect($this->settings)->toJson();
    }
    /**
     * transforms this all to array
     */
    public function toArray()
    {
        return collect($this->settings)->toArray();
    }

    public function __toString()
    {
        return $this->toJson();
    }
}
