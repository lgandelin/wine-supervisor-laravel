<?php

namespace Webaccess\WineSupervisorLaravel\Http\Middlewares;

use Closure;
use Illuminate\Contracts\Auth\Guard;
use Illuminate\Http\Request;
use Webaccess\WineSupervisorLaravel\Models\User;

class AdminMiddleware
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
     * @param  Guard $auth
     */
    public function __construct(Guard $auth)
    {
        $this->auth = $auth;
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
        if ($this->auth->user()->profile_id !== User::PROFILE_ID_AROL_ENERGY_ADMINISTRATOR)
        {
            if ($request->ajax())
            {
                return response('Forbbiden.', 403);
            }
            else
            {
                return redirect()->route('login');
            }
        }

        return $next($request);
    }
}