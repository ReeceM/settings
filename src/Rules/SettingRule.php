<?php

namespace ReeceM\Settings\Rules;

use Illuminate\Contracts\Validation\Rule;

class SettingRule implements Rule
{
    /**
     * Create a new rule instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Determine if the validation rule passes.
     *
     * @param  string  $attribute
     * @param  mixed  $value
     * @return bool
     */
    public function passes($attribute, $value)
    {
        $matches = array();
        preg_match('/(JSON)|(STRING)|(BOOL)/', $value, $matches);
        
        if (count($matches) <= 0)  {
            return false;
        }

        return true;
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return ':attribute needs more cowbell!';
    }
}
