<?php

namespace Webaccess\WineSupervisorLaravel\Http\Controllers\ClubPremium;

use Illuminate\Http\Request;
use Webaccess\WineSupervisorLaravel\Repositories\SaleRepository;
use Webaccess\WineSupervisorLaravel\Services\AccountService;

class IndexController
{
    public function __construct(Request $request)
    {
        view()->share('is_user', true);
        view()->share('route', $request->route()->getName());
    }

    public function index(Request $request)
    {
        view()->share('is_eligible_to_club_premium', AccountService::isUserEligibleToClubPremium()); //TODO

        return view('wine-supervisor::pages.club-premium.index', [
            'sales' => SaleRepository::getCurrentSales(),
        ]);
    }

    public function comity(Request $request)
    {
        view()->share('is_eligible_to_club_premium', AccountService::isUserEligibleToClubPremium()); //TODO

        return view('wine-supervisor::pages.club-premium.comity', [
            'sales' => SaleRepository::getSalesHistory()
        ]);
    }

    public function current_sales(Request $request)
    {
        view()->share('is_eligible_to_club_premium', AccountService::isUserEligibleToClubPremium()); //TODO

        return view('wine-supervisor::pages.club-premium.current_sales', [
            'sales' => SaleRepository::getSalesHistory()
        ]);
    }

    public function sales_history(Request $request)
    {
        view()->share('is_eligible_to_club_premium', AccountService::isUserEligibleToClubPremium()); //TODO

        return view('wine-supervisor::pages.club-premium.sales_history', [
            'sales' => SaleRepository::getSalesHistory()
        ]);
    }
}