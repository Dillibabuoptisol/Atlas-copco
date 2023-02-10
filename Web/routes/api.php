<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the controller to call when that URI is requested.
|
*/
 Route::post('forgotpassword','UserApiController@postForgotpassword');
 Route::post('forgotpasswordlink','UserApiController@sendForgotPasswordLink');
 Route::post('resetPassword','UserApiController@resetPassword');
 Route::post('updaterv','RVFormApiController@updateRV');
 Route::resource('userrole', 'RoleApiController');
 Route::resource('admin','AdminApiController');
 Route::resource('users','UserApiController');
 Route::get('rvdelete/{rVId}','RVFormApiController@deleteRVRecord');
 Route::resource('collector','CollectorApiController');
 Route::resource('receiptvoucher','RVFormApiController');
 Route::get('receiptimages/{id}','RVFormApiController@rVImages');
 Route::resource('settingcategory', 'SettingCategoryApiController');
 Route::resource('setting', 'SettingApiController');
 Route::resource('emailtemplate','EmailTemplateApiController');
 Route::post('login','UserApiController@postLogin');
 Route::resource('admingroup','AdminGroupApiController');
 Route::resource('settingcategory', 'SettingCategoryApiController');
 Route::group ( [ 'prefix' => 'api' ], function () {
 Route::post ('registration', 'UserApiController@logininfo' );
 });
 Route::post('test', 'LoginApiController@register');
 Route::group ( [ 'prefix' => 'v1',['middleware' => ['api','cors']]], function () {
   		Route::post('auth/register', 'LoginApiController@register');
       	Route::post('auth/login', 'LoginApiController@authLogin');
       	Route::post('auth/forgotpassword','LoginApiController@forgotPassword');
       	Route::group(['middleware' => 'jwt-auth'], function () {
	        Route::post('updatepassword', 'LoginApiController@updatePassword');
	        Route::post('updateprofile', 'LoginApiController@updateProfile');
	        Route::post('getprofile', 'LoginApiController@getProfile');
	        Route::post('changepassword', 'LoginApiController@changePassword');
        Route::post('rvform','RVFormApiController@addRVForm');
        Route::post('rvdetail','RVFormApiController@getRVDetail');
        Route::get('rvoptions','RVFormApiController@getRVOptions');
        Route::post('getrvlist','RVFormApiController@getRVlist');
        Route::post('search','RVFormApiController@rVSearch');

    });
 } );
