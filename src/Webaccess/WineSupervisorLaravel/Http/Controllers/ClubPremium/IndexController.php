<?php

namespace Webaccess\WineSupervisorLaravel\Http\Controllers\ClubPremium;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Webaccess\WineSupervisorLaravel\Repositories\SaleRepository;
use Webaccess\WineSupervisorLaravel\Services\AccountService;

class IndexController
{
    public function __construct(Request $request)
    {
        view()->share('route', $request->route() ? $request->route()->getName() : null);
    }

    public function index(Request $request)
    {
        view()->share('is_eligible_to_club_premium', AccountService::isUserEligibleToClubPremium()); //TODO
        view()->share('is_eligible_to_supervision', AccountService::isUserEligibleToSupervision());

        return view('wine-supervisor::pages.club-premium.index', [
            'is_user' => Auth::user(),
            'is_guest' => Auth::guard('guests')->user(),
            'first_name' => AccountService::getFirstName(),
        ]);
    }

    public function comity(Request $request)
    {
        view()->share('is_eligible_to_club_premium', AccountService::isUserEligibleToClubPremium()); //TODO
        view()->share('is_eligible_to_supervision', AccountService::isUserEligibleToSupervision());

        return view('wine-supervisor::pages.club-premium.comity', [
            'is_user' => Auth::user(),
            'is_guest' => Auth::guard('guests')->user(),
            'first_name' => AccountService::getFirstName(),
            'sales' => SaleRepository::getSalesHistory()
        ]);
    }

    public function current_sales(Request $request)
    {
        view()->share('is_eligible_to_club_premium', AccountService::isUserEligibleToClubPremium()); //TODO
        view()->share('is_eligible_to_supervision', AccountService::isUserEligibleToSupervision());

        return view('wine-supervisor::pages.club-premium.current_sales', [
            'is_user' => Auth::user(),
            'is_guest' => Auth::guard('guests')->user(),
            'first_name' => AccountService::getFirstName(),
            'sales' => SaleRepository::getCurrentSales()
        ]);
    }

    public function sales_history(Request $request)
    {
        view()->share('is_eligible_to_club_premium', AccountService::isUserEligibleToClubPremium()); //TODO
        view()->share('is_eligible_to_supervision', AccountService::isUserEligibleToSupervision());

        return view('wine-supervisor::pages.club-premium.sales_history', [
            'is_user' => Auth::user(),
            'is_guest' => Auth::guard('guests')->user(),
            'first_name' => AccountService::getFirstName(),
            'sales' => SaleRepository::getSalesHistory()
        ]);
    }
}