<?php

$locale = Request::segment(1);

if (in_array($locale, Config::get('app.available_locales'))) {
    \App::setLocale($locale);
} else {
    $locale = null;
}

Route::group(['middleware' => ['web']], function () use ($locale) {

    Route::pattern('uuid', '[0-9a-f]{8}-[0-9a-f]{4}-[0-9a-f]{4}-[0-9a-f]{4}-[0-9a-f]{12}');
    Route::pattern('id_ws', '[0-9A-F]{2}:[0-9A-F]{2}:[0-9A-F]{2}:[0-9A-F]{2}:[0-9A-F]{2}:[0-9A-F]{2}');

    Route::group(['prefix' => $locale], function () {

        //AUTH ROUTES
        Route::get('/login', array('as' => 'user_login', 'uses' => 'LoginController@login'));
        Route::post('/login', array('as' => 'user_login_handler', 'uses' => 'LoginController@authenticate'));
        Route::get('/disconnect', array('as' => 'user_logout', 'uses' => 'LoginController@logout'));
        Route::get(trans('wine-supervisor::routes.forgotten_password'), array('as' => 'forgotten_password', 'uses' => 'LoginController@forgotten_password'));
        Route::post(trans('wine-supervisor::routes.forgotten_password'), array('as' => 'forgotten_password_handler', 'uses' => 'LoginController@forgotten_password_handler'));

        //PUBLIC ROUTES
        Route::get('/', array('as' => 'index', 'uses' => 'IndexController@index'));

        Route::get(trans('wine-supervisor::routes.club_premium'), array('as' => 'club_premium', 'uses' => 'ClubPremium\IndexController@index'));
        Route::get(trans('wine-supervisor::routes.club_premium_comity'), array('as' => 'club_premium_comity', 'uses' => 'ClubPremium\IndexController@comity'));
        Route::get(trans('wine-supervisor::routes.club_premium_current_sales'), array('as' => 'club_premium_current_sales', 'uses' => 'ClubPremium\IndexController@current_sales'));
        Route::get(trans('wine-supervisor::routes.club_premium_sales_history'), array('as' => 'club_premium_sales_history', 'uses' => 'ClubPremium\IndexController@sales_history'));

        Route::get(trans('wine-supervisor::routes.legal_notices'), array('as' => 'legal_notices', 'uses' => 'IndexController@legal_notices'));


        //SIGNUP ROUTES
        Route::get(trans('wine-supervisor::routes.user_signup'), array('as' => 'user_signup', 'uses' => 'User\SignupController@signup'));
        Route::post(trans('wine-supervisor::routes.user_signup'), array('as' => 'user_signup_handler', 'uses' => 'User\SignupController@signup_handler'));

        Route::get(trans('wine-supervisor::routes.user_signup_cellar'), array('as' => 'user_signup_cellar', 'uses' => 'User\SignupController@signup_cellar'));
        Route::post(trans('wine-supervisor::routes.user_signup_cellar'), array('as' => 'user_signup_cellar_handler', 'uses' => 'User\SignupController@signup_cellar_handler'));

        Route::get(trans('wine-supervisor::routes.technician_signup'), array('as' => 'technician_signup_success', 'uses' => 'User\SignupController@technician_signup_success'));
        Route::post(trans('wine-supervisor::routes.technician_signup'), array('as' => 'technician_signup_handler', 'uses' => 'User\SignupController@technician_signup_handler'));

        Route::get('/contact', array('as' => 'contact', 'uses' => 'IndexController@contact'));
        Route::post('/contact', array('as' => 'contact_handler', 'uses' => 'IndexController@contact_handler'));

        //USER ROUTES
        Route::group(['middleware' => ['user']], function () {
            Route::get(trans('wine-supervisor::routes.my_cellars'), array('as' => 'user_cellar_list', 'uses' => 'User\CellarController@index'));
            Route::get(trans('wine-supervisor::routes.create_cellar'), array('as' => 'user_cellar_create', 'uses' => 'User\CellarController@create'));
            Route::post(trans('wine-supervisor::routes.create_cellar'), array('as' => 'user_cellar_create_handler', 'uses' => 'User\CellarController@create_handler'));
            Route::get(trans('wine-supervisor::routes.update_cellar') . '/{uuid}', array('as' => 'user_cellar_update', 'uses' => 'User\CellarController@update'));
            Route::post(trans('wine-supervisor::routes.update_cellar'), array('as' => 'user_cellar_update_handler', 'uses' => 'User\CellarController@update_handler'));
            Route::post(trans('wine-supervisor::routes.sav_cellar'), array('as' => 'user_cellar_sav_handler', 'uses' => 'User\CellarController@sav_handler'));
            Route::post(trans('wine-supervisor::routes.delete_cellar'), array('as' => 'user_cellar_delete_handler', 'uses' => 'User\CellarController@delete_handler'));

            Route::get(trans('wine-supervisor::routes.my_account'), array('as' => 'user_update_account', 'uses' => 'User\AccountController@update'));
            Route::post(trans('wine-supervisor::routes.my_account'), array('as' => 'user_update_account_handler', 'uses' => 'User\AccountController@update_handler'));
        });

        //TECHNICIAN ROUTES
        Route::group(['middleware' => ['technician']], function () {
            Route::get(trans('wine-supervisor::routes.technician_my_account'), array('as' => 'technician_update_account', 'uses' => 'Technician\AccountController@update'));
            Route::post(trans('wine-supervisor::routes.technician_my_account'), array('as' => 'technician_update_account_handler', 'uses' => 'Technician\AccountController@update_handler'));
        });
    });

    Route::get('/supervision', array('as' => 'supervision', 'uses' => 'IndexController@supervision'));

    //ADMIN ROUTES
    Route::get('/admin/login', array('as' => 'admin_login', 'uses' => 'Admin\LoginController@login'));
    Route::post('/admin/login', array('as' => 'admin_login_handler', 'uses' => 'Admin\LoginController@authenticate'));
    Route::get('/admin/logout', array('as' => 'admin_logout', 'uses' => 'Admin\LoginController@logout'));

    Route::group(['middleware' => ['admin']], function () {
        Route::get('/preview/{uuid}', array('as' => 'sale_preview', 'uses' => 'IndexController@preview'));
        Route::get('/admin', array('as' => 'admin_index', 'uses' => 'Admin\IndexController@index'));

        Route::get('/admin/utilisateurs', array('as' => 'admin_user_list', 'uses' => 'Admin\UserController@index'));
        Route::get('/admin/modifier-utilisateur/{uuid}', array('as' => 'admin_user_update', 'uses' => 'Admin\UserController@update'));
        Route::post('/admin/modifier-utilisateur/', array('as' => 'admin_user_update_handler', 'uses' => 'Admin\UserController@update_handler'));
        Route::get('/admin/supprimer-utilisateur/{uuid}', array('as' => 'admin_user_delete_handler', 'uses' => 'Admin\UserController@delete_handler'));

        Route::get('/admin/professionnels', array('as' => 'admin_technician_list', 'uses' => 'Admin\TechnicianController@index'));
        Route::get('/admin/modifier-professionnel/{uuid}', array('as' => 'admin_technician_update', 'uses' => 'Admin\TechnicianController@update'));
        Route::post('/admin/modifier-professionnel/', array('as' => 'admin_technician_update_handler', 'uses' => 'Admin\TechnicianController@update_handler'));
        Route::get('/admin/supprimer-professionnel/{uuid}', array('as' => 'admin_technician_delete_handler', 'uses' => 'Admin\TechnicianController@delete_handler'));

        Route::get('/admin/ws', array('as' => 'admin_ws_list', 'uses' => 'Admin\WSController@index'));
        Route::get('/admin/modifier-ws/{id_ws}', array('as' => 'admin_ws_update', 'uses' => 'Admin\WSController@update'));
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
        Route::get('/admin/supprimer-cave/{uuid}', array('as' => 'admin_cellar_delete_handler', 'uses' => 'Admin\CellarController@delete_handler'));

        Route::get('/admin/ventes', array('as' => 'admin_sale_list', 'uses' => 'Admin\SaleController@index'));
        Route::get('/admin/creer-vente', array('as' => 'admin_sale_create', 'uses' => 'Admin\SaleController@create'));
        Route::post('/admin/creer-vente', array('as' => 'admin_sale_create_handler', 'uses' => 'Admin\SaleController@create_handler'));
        Route::get('/admin/modifier-vente/{uuid}', array('as' => 'admin_sale_update', 'uses' => 'Admin\SaleController@update'));
        Route::post('/admin/modifier-vente', array('as' => 'admin_sale_update_handler', 'uses' => 'Admin\SaleController@update_handler'));
        Route::get('/admin/supprimer-vente/{uuid}', array('as' => 'admin_sale_delete_handler', 'uses' => 'Admin\SaleController@delete_handler'));

        Route::get('/admin/ventes-accessoires', array('as' => 'admin_accessories_sale_list', 'uses' => 'Admin\SaleAccessoriesController@index'));
        Route::get('/admin/creer-vente-accessoires', array('as' => 'admin_accessories_sale_create', 'uses' => 'Admin\SaleAccessoriesController@create'));
        Route::post('/admin/creer-vente-accessoires', array('as' => 'admin_accessories_sale_create_handler', 'uses' => 'Admin\SaleAccessoriesController@create_handler'));
        Route::get('/admin/modifier-vente-accessoires/{uuid}', array('as' => 'admin_accessories_sale_update', 'uses' => 'Admin\SaleAccessoriesController@update'));
        Route::post('/admin/modifier-vente-accessoires', array('as' => 'admin_accessories_sale_update_handler', 'uses' => 'Admin\SaleAccessoriesController@update_handler'));
        Route::get('/admin/supprimer-vente-accessoires/{uuid}', array('as' => 'admin_accessories_sale_delete_handler', 'uses' => 'Admin\SaleAccessoriesController@delete_handler'));

        Route::get('/admin/actualites', array('as' => 'admin_content_list', 'uses' => 'Admin\ContentController@index'));
        Route::get('/admin/creer-actualite', array('as' => 'admin_content_create', 'uses' => 'Admin\ContentController@create'));
        Route::post('/admin/creer-actualite', array('as' => 'admin_content_create_handler', 'uses' => 'Admin\ContentController@create_handler'));
        Route::get('/admin/modifier-actualite/{uuid}', array('as' => 'admin_content_update', 'uses' => 'Admin\ContentController@update'));
        Route::post('/admin/modifier-actualite', array('as' => 'admin_content_update_handler', 'uses' => 'Admin\ContentController@update_handler'));
        Route::get('/admin/supprimer-actualite/{uuid}', array('as' => 'admin_content_delete_handler', 'uses' => 'Admin\ContentController@delete_handler'));
        Route::get('/admin/actualite/{uuid}', array('as' => 'admin_content_get', 'uses' => 'Admin\ContentController@get'));

        Route::get('/admin/partenaires', array('as' => 'admin_partner_list', 'uses' => 'Admin\PartnerController@index'));
        Route::get('/admin/creer-partenaire', array('as' => 'admin_partner_create', 'uses' => 'Admin\PartnerController@create'));
        Route::post('/admin/creer-partenaire', array('as' => 'admin_partner_create_handler', 'uses' => 'Admin\PartnerController@create_handler'));
        Route::get('/admin/modifier-partenaire/{uuid}', array('as' => 'admin_partner_update', 'uses' => 'Admin\PartnerController@update'));
        Route::post('/admin/modifier-partenaire', array('as' => 'admin_partner_update_handler', 'uses' => 'Admin\PartnerController@update_handler'));
        Route::get('/admin/supprimer-partenaire/{uuid}', array('as' => 'admin_partner_delete_handler', 'uses' => 'Admin\PartnerController@delete_handler'));

        Route::get('/admin/contenus', array('as' => 'admin_page_content_list', 'uses' => 'Admin\PageContentController@index'));
        Route::get('/admin/modifier-contenu/{uuid}', array('as' => 'admin_page_content_update', 'uses' => 'Admin\PageContentController@update'));
        Route::post('/admin/modifier-contenu', array('as' => 'admin_page_content_update_handler', 'uses' => 'Admin\PageContentController@update_handler'));

        Route::get('/admin/mailing', array('as' => 'admin_mailing', 'uses' => 'Admin\MailingController@index'));
        Route::post('/admin/admin_mailing_get_emails', array('as' => 'admin_mailing_get_emails', 'uses' => 'Admin\MailingController@get_emails'));
        Route::post('/admin/admin_mailing_send_test_email', array('as' => 'admin_mailing_send_test_email', 'uses' => 'Admin\MailingController@send_test_email'));
        Route::post('/admin/admin_mailing_upload_image', array('as' => 'admin_mailing_upload_image', 'uses' => 'Admin\MailingController@upload_image'));
        Route::post('/admin/admin_mailing_get_html_preview', array('as' => 'admin_mailing_get_html_preview', 'uses' => 'Admin\MailingController@get_html_preview'));

    });
});
