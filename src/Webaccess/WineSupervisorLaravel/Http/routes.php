<?php

//WEB
Route::group(['middleware' => ['web']], function () {

    Route::get('/login', array('as' => 'login', 'uses' => 'Webaccess\WineSupervisorLaravel\Http\Controllers\LoginController@login'));
    Route::post('/login', array('as' => 'login_handler', 'uses' => 'Webaccess\WineSupervisorLaravel\Http\Controllers\LoginController@authenticate'));
    Route::get('/logout', array('as' => 'logout', 'uses' => 'Webaccess\WineSupervisorLaravel\Http\Controllers\LoginController@logout'));
    Route::get('/forgotten_password', array('as' => 'forgotten_password', 'uses' => 'Webaccess\WineSupervisorLaravel\Http\Controllers\LoginController@forgotten_password'));
    Route::post('/forgotten_password_handler', array('as' => 'forgotten_password_handler', 'uses' => 'Webaccess\WineSupervisorLaravel\Http\Controllers\LoginController@forgotten_password_handler'));

    //AUTH
    Route::group(['middleware' => ['auth']], function () {
        Route::get('/dashboard', array('as' => 'dashboard', 'uses' => 'Webaccess\WineSupervisorLaravel\Http\Controllers\DashboardController@index'));
    });
});
