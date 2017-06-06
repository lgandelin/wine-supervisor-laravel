<?php

Route::group(['middleware' => ['web']], function () {

    Route::pattern('uuid', '[0-9a-f]{8}-[0-9a-f]{4}-[0-9a-f]{4}-[0-9a-f]{4}-[0-9a-f]{12}');

    Route::get('/login', array('as' => 'user_login', 'uses' => 'LoginController@login'));
    Route::post('/login', array('as' => 'user_login_handler', 'uses' => 'LoginController@authenticate'));
    Route::get('/se-deconnecter', array('as' => 'user_logout', 'uses' => 'LoginController@logout'));
    Route::get('/mot-de-passe-oublie', array('as' => 'forgotten_password', 'uses' => 'LoginController@forgotten_password'));
    Route::post('/mot-de-passe-oublie', array('as' => 'forgotten_password_handler', 'uses' => 'LoginController@forgotten_password_handler'));

    Route::get('/utilisateur/inscription', array('as' => 'user_signup', 'uses' => 'User\SignupController@signup'));
    Route::post('/utilisateur/inscription', array('as' => 'user_signup_handler', 'uses' => 'User\SignupController@signup_handler'));
    Route::get('/utilisateur/inscription/cave', array('as' => 'user_signup_cellar', 'uses' => 'User\SignupController@signup_cellar'));
    Route::post('/utilisateur/inscription/cave', array('as' => 'user_signup_cellar_handler', 'uses' => 'User\SignupController@signup_cellar_handler'));

    Route::get('professionnel/inscription', array('as' => 'technician_signup', 'uses' => 'Technician\SignupController@signup'));
    Route::post('/professionnel/inscription', array('as' => 'technician_signup_handler', 'uses' => 'Technician\SignupController@signup_handler'));

    Route::get('/admin/login', array('as' => 'admin_login', 'uses' => 'LoginController@admin_login'));
    Route::post('/admin/login', array('as' => 'admin_login_handler', 'uses' => 'LoginController@admin_authenticate'));
    Route::get('/admin/logout', array('as' => 'admin_logout', 'uses' => 'LoginController@admin_logout'));

    Route::get('/', array('as' => 'index', 'uses' => 'IndexController@index'));

    Route::group(['middleware' => ['guest']], function () {
        Route::get('/invite', array('as' => 'guest_index', 'uses' => 'Guest\IndexController@index'));
    });

    Route::group(['middleware' => ['user']], function () {
        Route::get('/utilisateur', array('as' => 'user_index', 'uses' => 'User\IndexController@index'));
        Route::get('/utilisateur/ajouter-cave', array('as' => 'user_cellar_create', 'uses' => 'User\CellarController@create'));
        Route::post('/utilisateur/ajouter-cave', array('as' => 'user_cellar_create_handler', 'uses' => 'User\CellarController@create_handler'));
        Route::get('/utilisateur/modifier-cave/{uuid}', array('as' => 'user_cellar_update', 'uses' => 'User\CellarController@update'));
        Route::post('/utilisateur/modifier-cave', array('as' => 'user_cellar_update_handler', 'uses' => 'User\CellarController@update_handler'));
        Route::get('/utilisateur/supprimer-cave/{uuid}', array('as' => 'user_cellar_delete_handler', 'uses' => 'User\CellarController@delete_handler'));
    });

    Route::group(['middleware' => ['admin']], function () {
        Route::get('/admin', array('as' => 'admin_index', 'uses' => 'Admin\IndexController@index'));

        Route::get('/admin/professionnels', array('as' => 'admin_technician_list', 'uses' => 'Admin\TechnicianController@index'));
        Route::get('/admin/modifier-professionnel/{uuid}', array('as' => 'admin_technician_update', 'uses' => 'Admin\TechnicianController@update'));
        Route::post('/admin/modifier-professionnel/', array('as' => 'admin_technician_update_handler', 'uses' => 'Admin\TechnicianController@update_handler'));

        Route::get('/admin/ws', array('as' => 'admin_ws_list', 'uses' => 'Admin\WSController@index'));
        Route::get('/admin/modifier-ws/{uuid}', array('as' => 'admin_ws_update', 'uses' => 'Admin\WSController@update'));
        Route::post('/admin/modifier-ws/', array('as' => 'admin_ws_update_handler', 'uses' => 'Admin\WSController@update_handler'));

        Route::get('/admin/invites', array('as' => 'admin_guest_list', 'uses' => 'Admin\GuestController@index'));
        Route::get('/admin/creer-invite', array('as' => 'admin_guest_create', 'uses' => 'Admin\GuestController@create'));
        Route::post('/admin/creer-invite', array('as' => 'admin_guest_create_handler', 'uses' => 'Admin\GuestController@create_handler'));
        Route::get('/admin/modifier-invite/{uuid}', array('as' => 'admin_guest_update', 'uses' => 'Admin\GuestController@update'));
        Route::post('/admin/modifier-invite/', array('as' => 'admin_guest_update_handler', 'uses' => 'Admin\GuestController@update_handler'));

        Route::get('/admin/caves', array('as' => 'admin_cellar_list', 'uses' => 'Admin\CellarController@index'));
        Route::get('/admin/modifier-cave/{uuid}', array('as' => 'admin_cellar_update', 'uses' => 'Admin\CellarController@update'));
        Route::post('/admin/modifier-cave/', array('as' => 'admin_cellar_update_handler', 'uses' => 'Admin\CellarController@update_handler'));
    });
});
