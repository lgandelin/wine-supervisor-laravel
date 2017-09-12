<?php

return [
    'id_not_found' => 'Utilisateur non trouvé',
    'database_error' => 'Une erreur est survenue lors de l\'opération. Veuillez nous excuser pour la gêne occasionnée.',
    'user_update_success' => 'Mise à jour de vos informations effectuée avec succès.',
    'user_admin_update_success' => 'Utilisateur modifié avec succès.',
    'user_update_error' => 'Une erreur est survenue lors de la mise à jour de vos informations.',
    'user_delete_error' => 'Une erreur est survenue lors de la suppression de l\'utilisateur.',
    'user_delete_success' => 'Utilisateur supprimé avec succès !',
    'user_delete_error_active_cellars' => 'Impossible de supprimer cet utilisateur, il a toujours des caves actives.',

    'update_account' => [
        'meta_title' => 'Mon compte | WineSupervisor',
        'banner_title' => 'Mon compte',
        'receive_club_newsletter' => 'Recevoir la Newsletter du Club',

        'my_cellars' => [
            'page_title' => 'Mes caves',
            'page_header' => 'Voici ci-dessous la liste de vos caves connectées. Pour chacune, vous avez la possibilité d’en compléter ou d’en modifier les informations.',
            'table' => [
                'cellar' => 'Cave',
                'subscription_status' => 'Statut abonnement',
                'expiration_date' => 'Date d\'expiration',
                'subscription_type' => 'Type d\'abonnement',
            ]
        ],

        'my_account' => [
            'page_title' => 'Mon compte',
            'page_header' => [
                '1' => 'Retrouvez les informations sur votre compte.',
                '2' => 'Vous pouvez les modifier chaque fois que c’est nécessaire.',
            ]
        ]
    ]
];