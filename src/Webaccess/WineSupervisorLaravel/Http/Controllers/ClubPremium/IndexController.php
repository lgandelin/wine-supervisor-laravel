<?php

namespace Webaccess\WineSupervisorLaravel\Http\Controllers\ClubPremium;

use Illuminate\Http\Request;
use Webaccess\WineSupervisorLaravel\Repositories\SaleRepository;
use Webaccess\WineSupervisorLaravel\Services\AccountService;

class IndexController
{
    public function index(Request $request)
    {
        view()->share('is_eligible_to_club_premium', AccountService::isUserEligibleToClubPremium());
        view()->share('is_user', true);
        view()->share('route', $request->route()->getName());

        return view('wine-supervisor::pages.club-premium.index', [
            'sales' => SaleRepository::getCurrentSales(),
        ]);
    }

    public function sales_history(Request $request)
    {
        return view('wine-supervisor::pages.club-premium.sales_history', [
            'sales' => SaleRepository::getSalesHistory()
        ]);
    }
}