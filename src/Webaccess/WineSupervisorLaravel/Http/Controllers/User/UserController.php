<?php

namespace Webaccess\WineSupervisorLaravel\Http\Controllers\User;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Webaccess\WineSupervisorLaravel\Services\AccountService;

class UserController
{
    public function __construct(Request $request)
    {
        view()->share('is_eligible_to_club_premium', AccountService::isUserEligibleToClubPremium());
    }

    public function getUserID()
    {
        return Auth::guard('users')->getUser()->id;
    }
}