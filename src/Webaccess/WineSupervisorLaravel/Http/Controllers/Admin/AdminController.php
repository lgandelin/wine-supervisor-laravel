<?php

namespace Webaccess\WineSupervisorLaravel\Http\Controllers\Admin;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AdminController
{
    public function __construct(Request $request)
    {
        view()->share('route', $request->route()->getName());
        view()->share('is_admin', true);
    }

    public function getAdministratorID()
    {
        return Auth::guard('administrators')->getUser()->id;
    }
}