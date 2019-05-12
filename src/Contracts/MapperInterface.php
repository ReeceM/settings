<?php

namespace ReeceM\Settings\Contracts;

interface MapperInterface {
    /**
     * The interface for mapper transformations for the settings that are stored in the db
     */
    
    /**
     * transform the setting to a string
     * @return string
     */
    public function transformString($value = null) : string;
    
    /**
     * transforms the setting to a json type array
     * @return array
     */
    public function transformJson($value = null) : array;

    /**
     * transforms the setting from a string to a proper bool
     * @return bool
     */
    public function transformBool($value = null) : bool;
}