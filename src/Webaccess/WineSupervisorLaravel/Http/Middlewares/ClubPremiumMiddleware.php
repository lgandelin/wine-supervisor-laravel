<?php

namespace Webaccess\WineSupervisorLaravel\Http\Middlewares;

use Closure;
use Illuminate\Contracts\Auth\Guard;
use Illuminate\Http\Request;
use Webaccess\WineSupervisorLaravel\Services\AccountService;

class ClubPremiumMiddleware
{
    /**
     * The Guard implementation.
     *
     * @var Guard
     */
    protected $auth;

    /**
     * Create a new filter instance.
     *
     */
    public function __construct()
    {

    }

    /**
     * Handle an incoming request.
     *
     * @param  Request  $request
     * @param  Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        if (!AccountService::isUserEligibleToClubPremium()) {
            if ($request->ajax()) {
                return response('Forbbiden.', 403);
            } else {
                return redirect()->route('user_login');
            }
        }

        return $next($request);
    }
}