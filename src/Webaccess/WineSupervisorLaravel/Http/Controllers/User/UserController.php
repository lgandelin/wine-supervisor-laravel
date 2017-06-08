<?php

namespace Webaccess\WineSupervisorLaravel\Http\Controllers\User;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UserController
{
    public function __construct(Request $request)
    {

    }

    public function getUserID()
    {
        return Auth::guard('users')->getUser()->id;
    }
}