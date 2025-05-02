<?php

use Illuminate\Support\Facades\Route;
use Symfony\Component\Routing\Exception\RouteNotFoundException;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/
Route::post('login', 'AuthController@login')->name('login');
Route::namespace('Admin')->group(function () {
Route::post('line/push', 'UserController@handleLineLogin')->name('handleLineLogin');
});
Route::prefix('auth')->namespace('Auth')->group(function () {
    Route::post('forgot', 'ForgotPasswordController@forgot');
    Route::post('reset', 'ResetPasswordController@reset');
    Route::post('login', 'AuthController@login');
    Route::post('register', 'AuthController@register');
});
Route::prefix('auth')->namespace('Auth')->middleware(['auth:api','role:admin|superadmin'])->group(function () {
    Route::post('user/device/tokens','AuthController@saveUserDeviceTokens');
});  

Route::prefix('admin')->namespace('Admin')->middleware(['auth:api','role:admin|superadmin|business'])->group(function () {
    Route::resource('actions', 'ActionController');
    Route::resource('roles', 'RoleController');
    // push notification
    Route::post('notifications/store', 'NotificationController@store');
    
    Route::get('users', 'UserController@index')->middleware('permission:list user');
    Route::get('users/{id}', 'UserController@show')->middleware('permission:show user');
    Route::put('users/update/{id}', 'UserController@update')->middleware('permission:update user');
    Route::delete('users/delete/{id}', 'UserController@destroy')->middleware('permission:destroy user');
    Route::get('fetchmessage', 'MessageController@index');
    Route::post('addmessage', 'MessageController@sendMessage');
    Route::get('/private-messages/{user}', 'MessageController@privateMessages');
    Route::post('/private-messages/{user}', 'MessageController@sendPrivateMessage');
    Route::put('/update-message-status/{id}', 'MessageController@update');
    Route::get('/file-message-download/{id}', 'MessageController@download');
    Route::get('/pusher-channel-list/{id}', 'MessageController@channelList');
    Route::get('/pusher-channel-info/{id}', 'MessageController@channelInfo');

});

Route::prefix('business')->namespace('Business')->middleware(['auth:api','business'])->group(function () {
});

Route::fallback(function () {
    throw new RouteNotFoundException();
});
