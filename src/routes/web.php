<?php
/**
 * System settings 
 */
Route::group(['middleware' => ['can:settings.admin', config('settings.middleware')]], function () {

	Route::get(config('setting.path') . '/settings/refresh',	'SettingController@refresh')->name('settings.refresh');
	Route::resources(config('setting.path') . '/settings', 		'SettingController');

});
