<?php

namespace Webaccess\WineSupervisorLaravel\Http\Controllers\User;

use Illuminate\Http\Request;
use Illuminate\Routing\Route;
use Illuminate\Support\Facades\Auth;
use Webaccess\WineSupervisorLaravel\Services\AccountService;

class UserController
{
    public function __construct(Request $request)
    {
        view()->share('is_eligible_to_club_premium', AccountService::isUserEligibleToClubPremium());
        view()->share('is_eligible_to_supervision', AccountService::isUserEligibleToSupervision());
        view()->share('is_user', true);
        view()->share('first_name', AccountService::getFirstName());
        view()->share('route', $request->route()->getName());
    }

    public function getUserID()
    {
        return Auth::guard('users')->getUser()->id;
    }
}