<?php

return [
    'session_error' => 'Une erreur est survenue lors de votre inscription. Veuillez retenter l\'opération',
    'id_ws_error' => 'ID Wine Supervisor non trouvé ou déjà utilisé. Veuillez vérifier que vous avez bien saisi le champ Identifiant WineSupervisor.',
    'technician_id_error' => 'L\'ID du professionnel entré n\'a pas été trouvé. Veuillez vérifier que vous avez bien saisi ce champ.',
    'user_existing_email_error' => 'L\'email entré existe déjà dans notre base de données. Veuillez en choisir un autre.',
    'user_email_confirmation' => 'Les 2 champs adresses email ne correspondent pas. Veuillez vous vérifier que vous avez bien saisi ces champs.',
    'user_password_confirmation' => 'Les 2 champs mot de passe saisis ne correspondent pas. Veuillez vous vérifier que vous avez bien saisi ces champs.',

    'meta_title' => 'Créer une cave | WineSupervisor',
    'steps' => [
        'account' => 'Compte',
        'cellar' => 'Cave',
    ],
    'page_title' => 'Création d\'une cave',
    'page_header' => [
        '1' => 'Vous connectez votre cave, inscrivez vos informations dans le formulaire.',
        '2' => 'L’identifiant WineSupervisor et le code d’activation sont inscrits sur votre boitier WineSupervisor II. Ils permettent de connecter votre cave au superviseur.',
        '3' => 'L’ID Professionnel vous est remis par l’installateur en charge du suivi de l’installation. Cette information peut être renseignée ultérieurement.',
    ],
    'create_account' => 'Créer un compte',
    'you_are' => 'Vous êtes',
    'user_account' => 'Utilisateur',
    'technician_account' => 'Installateur',

    'technician_confirmation' => [
        'meta_title' => 'Création de votre compte installateur effectuée | WineSupervisor',
        'page_title' => 'Créer un compte',
        'page_header' => 'Compte installateur créé avec succès',
        'confirmation' => [
            'title' => 'Confirmation',
            'text_1' => 'Votre compte installateur a été créé avec succès. Nous vous avertirons par mail une fois votre compte validé.',
            'text_2' => 'Cordialement,',
            'text_3' => 'L\'équipe de WineSupervisor',
        ]
    ],

    'user' => [
        'meta_title' => 'Créer un compte | WineSupervisor',
        'page_header' => [
            '1' => 'Vous venez d’acquérir un WineSupervisor II et désirez le connecter. Rien de plus simple.',
            '2' => 'Remplissez le formulaire en cochant la case utilisateur. Indiquez les codes fournis avec votre produit. Validez, vous êtes connectés sur le superviseur.',
            '3' => 'Si vous avez déjà un compte et que vous désirez ajouter une nouvelle cave alors connectez-vous et créez votre nouvelle cave dans ce compte.',
        ],
        'club_newsletter_updatable_in_account' => '(modifiable dans votre espace utilisateur)',
    ],

    'technician' => [
        'page_header' => 'Vous êtes installateurs de systèmes WineSupervisor II. Cochez la case installateur et remplissez le formulaire. Après validation par notre équipe vous obtiendrez un identifiant que vous communiquerez aux utilisateurs dont vous avez le suivi des caves. Vous pourrez ainsi suivre le bon fonctionnement de l’ensemble des installations réalisées chez vos clients.',
    ],
];