<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Gate;
use ReeceM\Settings\Rules\SettingRule;

class SettingsRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        abort_unless(Gate::check('settings.admin', request()->user()), 403);
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            //
            'key'   => 'string|required:key,' . request()->key,
            'type'  => new SettingRule
        ];
    }

    public function toArray()
    {
        $all = request()->all();

        $all['key'] = strtolower($all['key']);
        
        $all['type'] = strtoupper($all['type']);

        return $all;
    }
}
