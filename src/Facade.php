<?php

namespace ReeceM\Settings;

use Illuminate\Support\Facades\Facade as BaseFacade;

/**
 * @method public function __construct($mapper = null, Storage $storage = null)
 * @method public function get($key, $default = null)
 * @method public function all()
 * @method public function cache()
 * @method public function load()
 * @method public function create($data)
 * @method public function update($data = null)
 * @method public function getFresh()
 * @method public function toJson()
 * @method public function toArray()
 * @method public function __toString()
 */

class Facade extends BaseFacade {
    /**
     * Get the registered name of the component.
     *
     * @return string
     */
    protected static function getFacadeAccessor() { 
        return 'reecem.settings'; 
    }
}