<?php

namespace Webaccess\WineSupervisorLaravel\Commands;

use Illuminate\Console\Command;
use Webaccess\WineSupervisorLaravel\Services\UserManager;

class CreateUserCommand extends Command
{
    protected $signature = 'wine-supervisor-dev:create-user';

    protected $description = 'Créer un profil utilisateur';

    public function handle()
    {
        $firstName = $this->ask('Entrez le prénom de l\'utilisateur');
        $lastName = $this->ask('Entrez le nom de l\'utilisateur');
        $email = $this->ask('Entrez l\'email de l\'utilisateur');
        $password = $this->secret('Entrez le mot de passe de l\'utilisateur');

        try {
            if (UserManager::create($firstName, $lastName, $email, $password))
                $this->info('Le profil utilisateur a été créé avec succès');
        } catch (\Exception $e) {
            $this->error('Une erreur est survenue lors de l\'ajout du profil utilisateur : ' . $e->getMessage());
        }
    }
}
