<?php

namespace ReeceM\Settings;

use Illuminate\Database\Eloquent\Model;

class Setting extends Model
{
    //
    protected $fillable = [
        'key', 'value', 'type'
    ];
    
    static $types = [
        'STRING'    => 'transformString',
        'JSON'      => 'transformJson',
        'BOOL'      => 'transformBool'
    ];
    
    public function __construct(array $attributes = [])
    {
        $this->table = config('setting.storage.table');
        parent::__construct($attributes);
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
