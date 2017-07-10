<?php

namespace Webaccess\WineSupervisorLaravel\Http\Middlewares;

use Closure;
use Illuminate\Contracts\Auth\Guard;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TechnicianMiddleware
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
        $this->auth = Auth::guard('technicians');
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
        if (!$this->auth->user())
        {
            if ($request->ajax()) {
                return response('Forbbiden.', 403);
            } else {
                return redirect()->route('user_login');
            }
        }

        return $next($request);
    }
}