<?php
/**
 * System settings 
 */
use Illuminate\Support\Facades\Route;

Route::get(config('setting.path') . '/settings/refresh',	'SettingController@refresh')->name('refresh');
Route::resource(config('setting.path') . '/settings', 		'SettingController');
