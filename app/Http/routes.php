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

Route::group(['middleware' => 'web'], function() {
    Route::get('/', ['as' => 'homepage', function () {
        return view('content.home');
    }]);

    Route::get('/welcome', function() {
        return view('welcome');
    });

    Route::group(['as' => 'admin::', 'namespace' => 'Backend', 'prefix' => 'admin', 'middleware' => 'facebook'], function () {
        Route::get('/', ['as' => 'dashboard', 'uses' => 'AdminController@index']);
    });
});

