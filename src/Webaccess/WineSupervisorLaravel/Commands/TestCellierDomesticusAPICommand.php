<?php

namespace Webaccess\WineSupervisorLaravel\Commands;

use Illuminate\Console\Command;
use Webaccess\WineSupervisorLaravel\Models\Cellar;
use Webaccess\WineSupervisorLaravel\Models\Technician;
use Webaccess\WineSupervisorLaravel\Models\User;
use Webaccess\WineSupervisorLaravel\Repositories\CellarRepository;
use Webaccess\WineSupervisorLaravel\Repositories\TechnicianRepository;
use Webaccess\WineSupervisorLaravel\Repositories\UserRepository;
use Webaccess\WineSupervisorLaravel\Services\CellierDomesticusAPI;

class TestCellierDomesticusAPICommand extends Command
{
    protected $signature = 'wine-supervisor-dev:api';

    protected $description = 'API Cellier Domesticus';

    public function handle()
    {
        $api = new CellierDomesticusAPI();
        //$api->create_user(User::find('6b50eb1e-e419-436c-bab3-2bb7bc743f08'));
        //$api->create_technician(Technician::find('10ca6bcd-ea68-4189-af93-a71930f24eb3'));
        //$api->activate_cellar(Cellar::find('fdb3364e-4da7-4fa2-be80-86e3583d76f1'));
        //$api->login_user(User::find('b1d5d675-38ad-475a-b3f2-cb7e01380781'));
        //$api->update_user(User::find('6b50eb1e-e419-436c-bab3-2bb7bc743f08'));
        /*$api->update_cellar(
            UserRepository::getByID('3da66073-6248-431f-bcf5-fe00fc4440a4'),
            CellarRepository::getByID('407b0986-381e-476c-baed-b31a439b796e')
        );*/
        //$api->affect_cellar(CellarRepository::getByID('49a142e5-dcc0-4ba9-84e5-313147fcd370'), TechnicianRepository::getByID('10ca6bcd-ea68-4189-af93-a71930f24eb3'));
        //$api->unaffect_cellar(CellarRepository::getByID('49a142e5-dcc0-4ba9-84e5-313147fcd370'), TechnicianRepository::getByID('10ca6bcd-ea68-4189-af93-a71930f24eb3'));
        //$api->list_users();
        //$api->list_cellars();
        $api->delete_cellar(CellarRepository::getByID('a4496661-55c9-4d38-abd4-1bc347dab743'));
    }
}