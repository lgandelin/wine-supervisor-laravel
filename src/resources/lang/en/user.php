<?php

return [
    'id_not_found' => 'User not found',
    'database_error' => 'An error occurred during the operation. We apologize for the inconvenience.',
    'user_update_success' => 'Your information have been updated successfully.',
    'user_admin_update_success' => 'User successfully modified.',
    'user_update_error' => 'An error occurred while updating your information.',
    'user_delete_error' => 'An error occurred while deleting the user.',
    'user_delete_success' => 'User successfully deleted!',
    'user_delete_error_active_cellars' => 'Can not delete this user, he still have active cellars.',

    'update_account' => [
        'meta_title' => 'My Account | WineSupervisor',
        'banner_title' => 'My Account',
        'receive_club_newsletter' => 'Get the Club Newsletter by email',

        'my_cellars' => [
            'page_title' => 'My cellars',
            'page_header' => 'Below is a list of your connected cellars. For each one, you have the possibility to complete or modify the information.',
            'table' => [
                'cellar' => 'Cellar',
                'subscription_status' => 'Subscription status',
                'expiration_date' => 'Expiration date',
                'subscription_type' => 'Type of subscription',
            ]
        ],

        'my_account' => [
            'page_title' => 'My account',
            'page_header' => [
                '1' => 'Find all the information of your account.',
                '2' => 'You can change them whenever necessary.',
            ]
        ]
    ]
];