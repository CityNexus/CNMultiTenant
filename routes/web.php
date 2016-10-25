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

Route::get('/', 'HomeController@index');

Auth::routes();


Route::group(['middleware' => ['app']], function () {

    // Import Routes
    Route::group(['prefix' => 'import'], function (){
        Route::get('/create', 'ImportController@create');

    });

    // Admin Routes
    Route::group(['prefix' => 'admin'], function(){
        Route::get('/', 'AdminController@index');
        Route::get('/refresh-migration', 'AdminController@refreshMigrations');
    });

});

