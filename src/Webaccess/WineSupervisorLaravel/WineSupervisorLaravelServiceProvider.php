<?php

namespace Webaccess\WineSupervisorLaravel;

use Illuminate\Routing\Router;
use Illuminate\Support\ServiceProvider;
use Webaccess\WineSupervisorLaravel\Commands\CreateAdministratorCommand;
use Webaccess\WineSupervisorLaravel\Commands\CreateUserCommand;
use Webaccess\WineSupervisorLaravel\Commands\GenerateDataFromExcelCommand;
use Webaccess\WineSupervisorLaravel\Commands\GenerateRandomDatabaseDataCommand;
use Webaccess\WineSupervisorLaravel\Commands\GenerateRandomJSONDataCommand;
use Webaccess\WineSupervisorLaravel\Commands\GenerateSampleExcelDataCommand;
use Webaccess\WineSupervisorLaravel\Commands\HandleExcelCommand;
use Webaccess\WineSupervisorLaravel\Commands\StoreExcelDataToCloudCommand;
use Webaccess\WineSupervisorLaravel\Http\Middlewares\AdminClientsMiddleware;
use Webaccess\WineSupervisorLaravel\Http\Middlewares\AdminMiddleware;

class WineSupervisorLaravelServiceProvider extends ServiceProvider
{
    protected $defer = false;

    public function boot(Router $router)
    {
        $basePath = __DIR__.'/../../';

        include __DIR__.'/Http/routes.php';

        $this->loadViewsFrom($basePath.'resources/views/', 'wine-supervisor');
        $this->loadTranslationsFrom($basePath.'resources/lang/', 'wine-supervisor');
        $router->middleware('admin', AdminMiddleware::class);

        $this->publishes([
            $basePath.'resources/assets/css' => base_path('public/css'),
            $basePath.'resources/assets/js' => base_path('public/js'),
            $basePath.'resources/assets/fonts' => base_path('public/fonts'),
            $basePath.'resources/assets/img' => base_path('public/img'),
        ], 'assets');

        $this->publishes([
            $basePath.'database/migrations' => database_path('migrations'),
        ], 'migrations');
    }

    public function register()
    {
        $this->commands([
            CreateAdministratorCommand::class
        ]);

        $this->app->register(
            'Webaccess\WineSupervisorLaravel\AuthServiceProvider'
        );
    }
}
