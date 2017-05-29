<?php

Route::group(['middleware' => ['web']], function () {

    Route::pattern('uuid', '[0-9a-f]{8}-[0-9a-f]{4}-[0-9a-f]{4}-[0-9a-f]{4}-[0-9a-f]{12}');

    Route::get('/login', array('as' => 'user_login', 'uses' => 'LoginController@login'));
    Route::post('/login', array('as' => 'user_login_handler', 'uses' => 'LoginController@authenticate'));
    Route::get('/logout', array('as' => 'user_logout', 'uses' => 'LoginController@logout'));
    Route::get('/forgotten_password', array('as' => 'forgotten_password', 'uses' => 'LoginController@forgotten_password'));
    Route::post('/forgotten_password_handler', array('as' => 'forgotten_password_handler', 'uses' => 'LoginController@forgotten_password_handler'));

    Route::get('/signup', array('as' => 'user_signup', 'uses' => 'User\SignupController@signup'));
    Route::post('/signup', array('as' => 'user_signup_handler', 'uses' => 'User\SignupController@signup_handler'));

    Route::get('/signup_2', array('as' => 'user_signup_2', 'uses' => 'User\SignupController@signup_2'));
    Route::post('/signup_2', array('as' => 'user_signup_2_handler', 'uses' => 'User\SignupController@signup_2_handler'));

    Route::get('/admin/login', array('as' => 'admin_login', 'uses' => 'LoginController@admin_login'));
    Route::post('/admin/login', array('as' => 'admin_login_handler', 'uses' => 'LoginController@admin_authenticate'));
    Route::get('/admin/logout', array('as' => 'admin_logout', 'uses' => 'LoginController@admin_logout'));

    Route::get('/', array('as' => 'index', 'uses' => 'IndexController@index'));

    Route::group(['middleware' => ['user']], function () {
        Route::get('/user', array('as' => 'user_index', 'uses' => 'User\IndexController@index'));
    });

    Route::group(['middleware' => ['admin']], function () {
        Route::get('/admin', array('as' => 'admin_index', 'uses' => 'Admin\IndexController@index'));
    });
});
