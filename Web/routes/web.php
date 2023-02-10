<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| This file is where you may define all of the routes that are handled
| by your application. Just tell Laravel the URIs it should respond
| to using a Closure or controller method. Build something great!
|
*/
Route::get('/', function(){
 return redirect('login');
});

Route::get('forgotpassword',function(){
	return view('auth/forgotpassword');
});

Route::get('updatepassword/{id}',function(){
	return view('auth/updatepassword');
});

Auth::routes();

Route::group(['middleware' => ['auth']], function () {
 Route::get('exportrvform','ExportXLController@downloadFile');
 Route::get('changepassword','PasswordController@getchangePassword');
 Route::post('changepassword','PasswordController@changePassword');
 Route::get('settings', 'SettingsController@getIndex');
 Route::post('settings/update','SettingsController@postUpdate');
 Route::get('{module}', 'TemplateController@getModuleTemplate');
 Route::get('grid/{module}', 'TemplateController@getModuleGrid');
 Route::get('{module}/{action}/{id?}', 'TemplateController@getActionTemplate');
});

