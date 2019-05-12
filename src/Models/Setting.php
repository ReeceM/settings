<?php

namespace ReeceM\Settings;

use Illuminate\Database\Eloquent\Model;

class Setting extends Model
{
    //
    protected $fillable = [
        'key', 'value', 'type'
    ];
    
    public function __construct(array $attributes = [])
    {
        $this->table = config('setting.storage.table');
        parent::__construct($attributes);
    }
}
