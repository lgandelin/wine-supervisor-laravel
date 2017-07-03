<?php

namespace Webaccess\WineSupervisorLaravel\Commands;

use Illuminate\Console\Command;
use Webaccess\WineSupervisorLaravel\Services\CellierDomesticusAPI;

class TestCellierDomesticusAPICommand extends Command
{
    protected $signature = 'wine-supervisor-dev:api';

    protected $description = 'API Cellier Domesticus';

    public function handle()
    {
        $api = new CellierDomesticusAPI();
        //$api->create_user();
        $api->activate_cellar();
    }
}