<?php

namespace Webaccess\WineSupervisorLaravel\Commands;

use DateInterval;
use DateTime;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Log;
use Webaccess\WineSupervisorLaravel\Models\Subscription;
use Webaccess\WineSupervisorLaravel\Models\User;
use Webaccess\WineSupervisorLaravel\Repositories\CellarRepository;

class DeleteInactiveUsersCommand extends Command
{
    protected $signature = 'wine-supervisor:delete-inactive-users';

    protected $description = 'Supprime les comptes utilisateurs qui ne se sont pas connectés depuis longtemps';

    public function handle()
    {
        try {
            $oneYearAgo = (new DateTime())->sub(new DateInterval('P12M'));

            //Récupération de tous les utilisateurs s'étant connecté il y a plus d'1 an
            if ($inactiveUsers = User::where('last_connection_date', '<', $oneYearAgo)->get()) {
                foreach ($inactiveUsers as $user) {

                    $userHasOneSubscription = false;

                    //Récupération des caves de l'utilisateur
                    if ($cellars = CellarRepository::getByUser($user->id)) {
                        foreach ($cellars as $cellar) {
                            if ($cellar->subscription_type !== Subscription::NO_SUBSCRIPTION) {
                                $userHasOneSubscription = true;
                            }
                        }
                    }

                    //Si l'utilisateur n'a pas ou plus d'abonnement sur sa ou ses caves
                    if (!$userHasOneSubscription) {

                        //On le supprime
                        if ($user->delete()) {
                            Log::info('Utilisateur inactif supprimé avec succès : ' . $user->id . ' (' . $user->last_name . ' ' . $user->first_name . ')');
                        }
                    }
                }
            }
        } catch (\Exception $e) {
            $this->error('Une erreur est survenue lors de la suppression d\'un utilisateur inactif : ' . $e->getMessage());
        }
    }
}
