<?php

Route::group(['middleware' => ['web']], function () {

    Route::pattern('uuid', '[0-9a-f]{8}-[0-9a-f]{4}-[0-9a-f]{4}-[0-9a-f]{4}-[0-9a-f]{12}');

    Route::get('/login', array('as' => 'user_login', 'uses' => 'LoginController@login'));
    Route::post('/login', array('as' => 'user_login_handler', 'uses' => 'LoginController@authenticate'));
    Route::get('/se-deconnecter', array('as' => 'user_logout', 'uses' => 'LoginController@logout'));
    Route::get('/mot-de-passe-oublie', array('as' => 'forgotten_password', 'uses' => 'LoginController@forgotten_password'));
    Route::post('/mot-de-passe-oublie', array('as' => 'forgotten_password_handler', 'uses' => 'LoginController@forgotten_password_handler'));

    Route::get('/inscription', array('as' => 'user_signup', 'uses' => 'User\SignupController@signup'));
    Route::post('/inscription', array('as' => 'user_signup_handler', 'uses' => 'User\SignupController@signup_handler'));

    Route::get('/inscription/cave', array('as' => 'user_signup_cellar', 'uses' => 'User\SignupController@signup_cellar'));
    Route::post('/inscription/cave', array('as' => 'user_signup_cellar_handler', 'uses' => 'User\SignupController@signup_cellar_handler'));

    Route::get('/admin/login', array('as' => 'admin_login', 'uses' => 'LoginController@admin_login'));
    Route::post('/admin/login', array('as' => 'admin_login_handler', 'uses' => 'LoginController@admin_authenticate'));
    Route::get('/admin/logout', array('as' => 'admin_logout', 'uses' => 'LoginController@admin_logout'));

    Route::get('/', array('as' => 'index', 'uses' => 'IndexController@index'));

    Route::group(['middleware' => ['user']], function () {
        Route::get('/utilisateur', array('as' => 'user_index', 'uses' => 'User\IndexController@index'));
        Route::get('/utilisateur/ajouter-cave', array('as' => 'user_cellar_create', 'uses' => 'User\CellarController@create'));
        Route::post('/utilisateur/ajouter-cave', array('as' => 'user_cellar_create_handler', 'uses' => 'User\CellarController@create_handler'));
        Route::get('/utilisateur/supprimer-cave/{uuid}', array('as' => 'user_cellar_delete_handler', 'uses' => 'User\CellarController@delete_handler'));
    });

    Route::group(['middleware' => ['admin']], function () {
        Route::get('/admin', array('as' => 'admin_index', 'uses' => 'Admin\IndexController@index'));
    });
});
