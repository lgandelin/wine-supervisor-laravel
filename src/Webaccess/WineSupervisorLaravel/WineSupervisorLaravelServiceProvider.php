<?php

namespace Webaccess\WineSupervisorLaravel;

use Illuminate\Contracts\Debug\ExceptionHandler;
use Illuminate\Routing\Router;
use Illuminate\Support\Facades\App;
use Illuminate\Support\ServiceProvider;
use Webaccess\WineSupervisorLaravel\Exceptions\WineSupervisorLaravelExceptionHandler;
use Webaccess\WineSupervisorLaravel\Commands\CreateAdministratorCommand;
use Illuminate\Support\Facades\Route;
use Webaccess\WineSupervisorLaravel\Commands\CreateUserCommand;
use Webaccess\WineSupervisorLaravel\Commands\DeleteInactiveUsersCommand;
use Webaccess\WineSupervisorLaravel\Http\Middlewares\AdminMiddleware;
use Webaccess\WineSupervisorLaravel\Http\Middlewares\ClubPremiumMiddleware;
use Webaccess\WineSupervisorLaravel\Http\Middlewares\GuestMiddleware;
use Webaccess\WineSupervisorLaravel\Http\Middlewares\TechnicianMiddleware;
use Webaccess\WineSupervisorLaravel\Http\Middlewares\UserMiddleware;

class WineSupervisorLaravelServiceProvider extends ServiceProvider
{
    protected $defer = false;

    public function boot(Router $router)
    {
        $basePath = __DIR__.'/../../';

        $this->loadViewsFrom($basePath.'resources/views/', 'wine-supervisor');
        $this->loadTranslationsFrom($basePath.'resources/lang/', 'wine-supervisor');

        $this->publishes([
            $basePath.'resources/assets/css' => base_path('public/css'),
            $basePath.'resources/assets/js' => base_path('public/js'),
            $basePath.'resources/assets/fonts' => base_path('public/fonts'),
            $basePath.'resources/assets/img' => base_path('public/img'),
        ], 'assets');

        $this->publishes([
            $basePath.'database/migrations' => database_path('migrations'),
        ], 'migrations');

        $router->aliasMiddleware('user', UserMiddleware::class);
        $router->aliasMiddleware('admin', AdminMiddleware::class);
        $router->aliasMiddleware('technician', TechnicianMiddleware::class);
        $router->aliasMiddleware('guest', GuestMiddleware::class);
        $router->aliasMiddleware('club-premium', ClubPremiumMiddleware::class);

        Route::middleware('web')
            ->namespace('Webaccess\WineSupervisorLaravel\Http\Controllers')
            ->group($basePath . 'routes/web.php');

        App::singleton(
            ExceptionHandler::class,
            WineSupervisorLaravelExceptionHandler::class
        );
    }

    public function register()
    {
        $this->commands([
            CreateUserCommand::class,
            CreateAdministratorCommand::class,
            DeleteInactiveUsersCommand::class
        ]);

        $this->app->register(
            'Webaccess\WineSupervisorLaravel\AuthServiceProvider'
        );
    }
}
