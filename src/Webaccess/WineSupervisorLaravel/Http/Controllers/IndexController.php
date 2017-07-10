<?php

namespace Webaccess\WineSupervisorLaravel\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Webaccess\WineSupervisorLaravel\Services\AccountService;
use Webaccess\WineSupervisorLaravel\Services\CellierDomesticusAPI;

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
            if (AccountService::isUser()) {
                $user = Auth::guard('users')->getUser();
                $result = (new CellierDomesticusAPI())->login_user($user);
                if ($result->status == 'success') {
                    return Redirect::to(sprintf('%s/manager?authToken=%s', env('CD_API_URL'), $result->authToken));
                }
            }

            if (AccountService::isTechnician()) {
                $technician= Auth::guard('technicians')->getUser();
                $result = (new CellierDomesticusAPI())->login_user($technician);
                if ($result->status == 'success') {
                    return Redirect::to(sprintf('%s/manager?authToken=%s', env('CD_API_URL'), $result->authToken));
                }
            }
        }

        return redirect()->back();
    }
}