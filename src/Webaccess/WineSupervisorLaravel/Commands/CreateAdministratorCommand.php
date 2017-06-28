<?php

namespace Webaccess\WineSupervisorLaravel\Commands;

use Illuminate\Console\Command;
use Webaccess\WineSupervisorLaravel\Repositories\UserRepository;

class CreateAdministratorCommand extends Command
{
    protected $signature = 'wine-supervisor-dev:create-administrator';

    protected $description = 'Créer un profil administrateur';

    public function handle()
    {
        $firstName = $this->ask('Entrez le prénom de l\'administrateur');
        $lastName = $this->ask('Entrez le nom de l\'administrateur');
        $email = $this->ask('Entrez l\'email de l\'administrateur');
        $password = $this->secret('Entrez le mot de passe de l\'administrateur');

        try {
            if (UserRepository::createAdministrator($firstName, $lastName, $email, $password))
                $this->info('Le profil administrateur a été créé avec succès');
        } catch (\Exception $e) {
            $this->error('Une erreur est survenue lors de l\'ajout du profil administrateur : ' . $e->getMessage());
        }
    }
}
