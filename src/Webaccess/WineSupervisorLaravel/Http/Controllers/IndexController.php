<?php

namespace Webaccess\WineSupervisorLaravel\Http\Controllers;

use Illuminate\Http\Request;
use Webaccess\WineSupervisorLaravel\Services\AccountService;

class IndexController
{
    public function index(Request $request)
    {
        return view('wine-supervisor::pages.index', [
            'is_eligible_to_club_premium' => AccountService::isUserEligibleToClubPremium(),
            'is_eligible_to_supervision' => AccountService::isUserEligibleToSupervision(),
            'is_user' => AccountService::isUser(),
            'is_technician' => AccountService::isTechnician(),
            'is_guest' => AccountService::isGuest(),
            'first_name' => AccountService::getFirstName(),
        ]);
    }

    public function supervision(Request $request)
    {
        if (AccountService::isUserEligibleToSupervision()) {
            //TODO : CALL CDO
        }
    }
}