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

Route::group(['middleware' => 'web'], function () {
    Route::get('/', ['as' => 'homepage', function () {
        return view('content.home');
    }]);

    Route::get('/welcome', function () {
        return view('welcome');
    });

    Route::group(['as' => 'admin::', 'namespace' => 'Backend', 'prefix' => 'admin'], function () {
        Route::get('/', ['as' => 'login', 'uses' => 'AdminController@login']);
        Route::get('/login/callback', ['as' => 'loginCallback', 'uses' => 'AdminController@loginCallback']);

        Route::group(['middleware' => 'facebook'], function () {
            Route::get('/dashboard', ['as' => 'dashboard', 'uses' => 'AdminController@index']);

            Route::group(['as' => 'item::', 'prefix' => 'item'], function() {
                Route::get('/', ['as' => 'index', 'uses' => 'ItemController@index']);
                Route::get('/add', ['as' => 'add', 'uses' => 'ItemController@add']);
                Route::get('/edit/{id}', ['as' => 'edit', 'uses' => 'ItemController@edit']);
                Route::post('/save/{id?}', ['as' => 'save', 'uses' => 'ItemController@save']);
                Route::post('/delete/{id}', ['as' => 'delete', 'uses' => 'ItemController@delete']);

                Route::get('/category', ['as' => 'category', 'uses' => 'CategoryController@item']);

            });

            Route::group(['as' => 'category::', 'prefix' => 'category'], function() {
                Route::get('/edit/{id}', ['as' => 'edit', 'uses' => 'CategoryController@edit']);
                Route::post('/save/{id?}', ['as' => 'save', 'uses' => 'CategoryController@save']);
                Route::post('/delete/{id}', ['as' => 'delete', 'uses' => 'CategoryController@delete']);
            });

            Route::group(['as' => 'blog::', 'prefix' => 'blog'], function() {
                Route::get('/', ['as' => 'index', 'uses' => 'BlogController@index']);
                Route::get('/add', ['as' => 'add', 'uses' => 'BlogController@add']);
                Route::get('/edit/{id}', ['as' => 'edit', 'uses' => 'BlogController@edit']);
                Route::post('/save/{id?}', ['as' => 'save', 'uses' => 'BlogController@save']);
                Route::post('/delete/{id}', ['as' => 'delete', 'uses' => 'BlogController@delete']);

                Route::get('/category', ['as' => 'category', 'uses' => 'CategoryController@blog']);

            });
        });
    });
});

