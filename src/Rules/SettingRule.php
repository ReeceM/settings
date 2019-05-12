<?php

namespace ReeceM\Settings\Rules;

use Illuminate\Contracts\Validation\Rule;

class SettingRule implements Rule
{
    private $defaultRegex = '(JSON)|(STRING)|(BOOL)';
    /**
     * Create a new rule instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
        /**
         * Add in the users types to the rules regex for checking
         */
        $this->defaultRegex .= '|(' . implode(')|(', config('setting.types')) . ')';
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
        preg_match('/' . $this->defaultRegex . '/', $value, $matches);
        
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
