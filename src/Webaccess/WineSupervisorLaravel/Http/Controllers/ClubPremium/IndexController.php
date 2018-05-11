<?php

namespace Webaccess\WineSupervisorLaravel\Http\Controllers\ClubPremium;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Webaccess\WineSupervisorLaravel\Repositories\PageContentRepository;
use Webaccess\WineSupervisorLaravel\Repositories\SaleAccessoryRepository;
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
            'programme_des_ventes' => PageContentRepository::getByID(env('PROGRAMME_DES_VENTES_CONTENT_ID'))
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
        ]);
    }

    public function current_sales(Request $request)
    {
        view()->share('is_eligible_to_club_premium', AccountService::isUserEligibleToClubPremium()); //TODO
        view()->share('is_eligible_to_supervision', AccountService::isUserEligibleToSupervision());

        $sales = SaleRepository::getCurrentSales();
        $sales_accessories = SaleAccessoryRepository::getCurrentSales();

        $all_sales = collect();
        foreach ($sales as $sale) $all_sales->push($sale);
        foreach ($sales_accessories as $sale_accessory) $all_sales->push($sale_accessory);

        return view('wine-supervisor::pages.club-premium.current_sales', [
            'is_user' => Auth::user(),
            'is_guest' => Auth::guard('guests')->user(),
            'first_name' => AccountService::getFirstName(),
            'sales' => $sales,
            'sales_accessories' => $sales_accessories,
            'all_sales' => $all_sales,
        ]);
    }

    public function sales_history(Request $request)
    {
        view()->share('is_eligible_to_club_premium', AccountService::isUserEligibleToClubPremium()); //TODO
        view()->share('is_eligible_to_supervision', AccountService::isUserEligibleToSupervision());

        $sales = SaleRepository::getSalesHistory();
        $sales_accessories = SaleAccessoryRepository::getSalesHistory();

        $all_sales = collect();
        foreach ($sales as $sale) $all_sales->push($sale);
        foreach ($sales_accessories as $sale_accessory) $all_sales->push($sale_accessory);

        return view('wine-supervisor::pages.club-premium.sales_history', [
            'is_user' => Auth::user(),
            'is_guest' => Auth::guard('guests')->user(),
            'first_name' => AccountService::getFirstName(),
            'sales' => $sales,
            'sales_accessories' => $sales_accessories,
            'all_sales' => $all_sales,
        ]);
    }
}