<?php
/**
 * System settings 
 */
use Illuminate\Support\Facades\Route;

Route::get('/settings/refresh',	'SettingController@refresh')->name('settings.refresh');
Route::resource('/settings', 		'SettingController');
