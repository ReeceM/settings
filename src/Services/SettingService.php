<?php

namespace ReeceM\Settings\Services;

use ReeceM\Settings\Setting;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Log;
use Illuminate\Contracts\Filesystem\FileNotFoundException;
use ReeceM\Settings\Mapper;

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

    /**
     * Filesystem reader
     * @var 
     */
    protected $storage;

    /**
     * Mapper manager class
     */
    public $mapper;

    protected $_configs;

    public static $configName = 'settings.php';
    
    public static $defaultStorageMethod = 'serialize';

    /**
     * transformation for setting types
     */
    public static $types = [];

    public function __construct($mapper = null, $storage = null)
    {
        $this->model    = new Setting();
        $this->mapper   = $mapper ?: new Mapper();

        $disk = config('setting.storage.disk');        
        $this->path     = 'cache/' . static::$configName;
        
        if ($disk === 's3') {
            $this->path = config('services.settings.disk.dir') . '/' . static::$configName;
        }
        
        $this->storage  = $storage ?: Storage::disk($disk);

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
        $this->settings = $this->getFresh();
        return $this->pack($this->settings);
    }
    /**
     * Reads the settings file into memory
     */
    public function load()
    {
        try {
            $this->settings = $this->unPack();

        } catch (FileNotFoundException $e) {
            $this->cache();
            
            $this->settings = $this->unPack();

        } catch (\Exception $e) {
            
            if(! $this->cache()) {
                Log::critical('Failed to load system settings with error: ' . $e);
                session()->flash('setting.flash.danger', 'Failed to load system settings file from storage');
            }
            // throw $e;
        }
        
        return $this->settings;
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
     * destroys a setting from the ORM and cache
     */
    // public function forget($key = null) 
    // {
    //     $this->model->where('key', $key)->delete();
    //     Arr::forget($this->settings, $key);
    //     return $this->cache();
    // }
    /**
     * convert the settings from database to array
     */
    public function getFresh()
    {
        
        $values = $this->model->all()
                                ->keyBy('key')
                                ->transform(\Closure::fromCallable([$this, 'callMapping']))
                                ->toArray();
        $array  =  array();
        
        foreach($values as $key => $value)
        {
            Arr::set($array, $key, $value);
        }

        return $array;
    }

    /**
     * calls the mapping function for the setting type
     */
    public function callMapping(Setting $setting)
    {
        $function   = array($this->mapper, $this->mapper::$types[$setting->type]);
        $value      = array($setting->value);
        return call_user_func_array($function, $value);
    }

    /**
     * this handles storing the cached settings
     * @param array $packable the array to commit to memory
     * @return array
     */
    private function pack($packable = [])
    {
        $serialise = config('setting.storage.method', 'serialize') === static::$defaultStorageMethod;
        $encrypt = config('setting.encrypt_file', false);
        
        if ($serialise || $encrypt)
        {
            return $this->storage->put($this->path, serialize($packable));
        }

        return $this->storage->put($this->path, '<?php return '.var_export($packable, true).';'.PHP_EOL);
        
    }

    /**
     * un-packs the settings from the storage disk, either serialised or not
     * @return array
     */
    private function unPack() : array
    {
        $serialise = config('setting.storage.method', 'serialize') === static::$defaultStorageMethod;
        $encrypt = config('setting.encrypt_file', false);
        
        $file = $this->storage->get($this->path);

        if ($serialise || $encrypt)
        {
            $cached = unserialize($file);

            if ($encrypt) $cached = decrypt($cached);

            return $cached;
        }

        return eval(preg_replace('<?php ', '', $file));
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
