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

    Route::get('/', array('as' => 'index', 'uses' => 'IndexController@index'));

    Route::get('/club-avantages', array('as' => 'club_premium', 'uses' => 'ClubPremium\IndexController@index'));
    Route::get('/club-avantages/comite', array('as' => 'club_premium_comity', 'uses' => 'ClubPremium\IndexController@comity'));
    Route::get('/club-avantages/ventes-en-cours', array('as' => 'club_premium_current_sales', 'uses' => 'ClubPremium\IndexController@current_sales'));
    Route::get('/club-avantages/historique-des-ventes', array('as' => 'club_premium_sales_history', 'uses' => 'ClubPremium\IndexController@sales_history'));

    Route::get('/supervision', function() {
        return redirect('http://supervision.fr');
    });

    Route::group(['middleware' => ['guest']], function () {
        Route::get('/invite', array('as' => 'guest_index', 'uses' => 'Guest\IndexController@index'));
    });

    Route::group(['middleware' => ['user']], function () {
        Route::get('/utilisateur/mes-caves', array('as' => 'user_cellar_list', 'uses' => 'User\CellarController@index'));
        Route::get('/utilisateur/ajouter-cave', array('as' => 'user_cellar_create', 'uses' => 'User\CellarController@create'));
        Route::post('/utilisateur/ajouter-cave', array('as' => 'user_cellar_create_handler', 'uses' => 'User\CellarController@create_handler'));
        Route::get('/utilisateur/modifier-cave/{uuid}', array('as' => 'user_cellar_update', 'uses' => 'User\CellarController@update'));
        Route::post('/utilisateur/modifier-cave', array('as' => 'user_cellar_update_handler', 'uses' => 'User\CellarController@update_handler'));
        Route::post('/utilisateur/sav-cave', array('as' => 'user_cellar_sav_handler', 'uses' => 'User\CellarController@sav_handler'));
        Route::post('/utilisateur/supprimer-cave', array('as' => 'user_cellar_delete_handler', 'uses' => 'User\CellarController@delete_handler'));

        Route::get('/utilisateur/mon-compte', array('as' => 'user_update_account', 'uses' => 'User\AccountController@update'));
        Route::post('/utilisateur/mon-compte', array('as' => 'user_update_account_handler', 'uses' => 'User\AccountController@update_handler'));
    });

    Route::get('/admin/login', array('as' => 'admin_login', 'uses' => 'Admin\LoginController@login'));
    Route::post('/admin/login', array('as' => 'admin_login_handler', 'uses' => 'Admin\LoginController@authenticate'));
    Route::get('/admin/logout', array('as' => 'admin_logout', 'uses' => 'Admin\LoginController@logout'));

    Route::group(['middleware' => ['admin']], function () {
        Route::get('/admin', array('as' => 'admin_index', 'uses' => 'Admin\IndexController@index'));

        Route::get('/admin/professionnels', array('as' => 'admin_technician_list', 'uses' => 'Admin\TechnicianController@index'));
        Route::get('/admin/modifier-professionnel/{uuid}', array('as' => 'admin_technician_update', 'uses' => 'Admin\TechnicianController@update'));
        Route::post('/admin/modifier-professionnel/', array('as' => 'admin_technician_update_handler', 'uses' => 'Admin\TechnicianController@update_handler'));

        Route::get('/admin/ws', array('as' => 'admin_ws_list', 'uses' => 'Admin\WSController@index'));
        Route::get('/admin/modifier-ws/{uuid}', array('as' => 'admin_ws_update', 'uses' => 'Admin\WSController@update'));
        Route::post('/admin/modifier-ws', array('as' => 'admin_ws_update_handler', 'uses' => 'Admin\WSController@update_handler'));

        Route::get('/admin/invites', array('as' => 'admin_guest_list', 'uses' => 'Admin\GuestController@index'));
        Route::get('/admin/creer-invite', array('as' => 'admin_guest_create', 'uses' => 'Admin\GuestController@create'));
        Route::post('/admin/creer-invite', array('as' => 'admin_guest_create_handler', 'uses' => 'Admin\GuestController@create_handler'));
        Route::get('/admin/modifier-invite/{uuid}', array('as' => 'admin_guest_update', 'uses' => 'Admin\GuestController@update'));
        Route::post('/admin/modifier-invite', array('as' => 'admin_guest_update_handler', 'uses' => 'Admin\GuestController@update_handler'));
        Route::get('/admin/supprimer-invite/{uuid}', array('as' => 'admin_guest_delete_handler', 'uses' => 'Admin\GuestController@delete_handler'));

        Route::get('/admin/caves', array('as' => 'admin_cellar_list', 'uses' => 'Admin\CellarController@index'));
        Route::get('/admin/modifier-cave/{uuid}', array('as' => 'admin_cellar_update', 'uses' => 'Admin\CellarController@update'));
        Route::post('/admin/modifier-cave', array('as' => 'admin_cellar_update_handler', 'uses' => 'Admin\CellarController@update_handler'));

        Route::get('/admin/ventes', array('as' => 'admin_sale_list', 'uses' => 'Admin\SaleController@index'));
        Route::get('/admin/creer-vente', array('as' => 'admin_sale_create', 'uses' => 'Admin\SaleController@create'));
        Route::post('/admin/creer-vente', array('as' => 'admin_sale_create_handler', 'uses' => 'Admin\SaleController@create_handler'));
        Route::get('/admin/modifier-vente/{uuid}', array('as' => 'admin_sale_update', 'uses' => 'Admin\SaleController@update'));
        Route::post('/admin/modifier-vente', array('as' => 'admin_sale_update_handler', 'uses' => 'Admin\SaleController@update_handler'));
        Route::get('/admin/supprimer-vente/{uuid}', array('as' => 'admin_sale_delete_handler', 'uses' => 'Admin\SaleController@delete_handler'));

        Route::get('/admin/actualites', array('as' => 'admin_content_list', 'uses' => 'Admin\ContentController@index'));
        Route::get('/admin/creer-actualite', array('as' => 'admin_content_create', 'uses' => 'Admin\ContentController@create'));
        Route::post('/admin/creer-actualite', array('as' => 'admin_content_create_handler', 'uses' => 'Admin\ContentController@create_handler'));
        Route::get('/admin/modifier-actualite/{uuid}', array('as' => 'admin_content_update', 'uses' => 'Admin\ContentController@update'));
        Route::post('/admin/modifier-actualite', array('as' => 'admin_content_update_handler', 'uses' => 'Admin\ContentController@update_handler'));
        Route::get('/admin/supprimer-actualite/{uuid}', array('as' => 'admin_content_delete_handler', 'uses' => 'Admin\ContentController@delete_handler'));
    });
});
