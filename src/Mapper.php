<?php

namespace ReeceM\Settings;

use ReeceM\Settings\Contracts\MapperInterface;

class Mapper implements MapperInterface {

    static $types = [
        'STRING'    => 'transformString',
        'JSON'      => 'transformJson',
        'BOOL'      => 'transformBool'
    ];

    public function __construct()
    {
        static::$types[] = parent::$types;
    }
    
    public function transformString($value = null) : string
    {
        if (is_null($value)) return '';
        return (string) $value;
    }

    public function transformJson($value = null) : array
    {
        if(is_null($value)) return [];

        return json_decode($value, JSON_OBJECT_AS_ARRAY);
    }

    public function transformBool($value = null) : bool
    {
        return filter_var($value, FILTER_VALIDATE_BOOLEAN);
    }
}