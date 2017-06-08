<?php

namespace Webaccess\WineSupervisorLaravel\Http\Controllers\ClubPremium;

use Illuminate\Http\Request;
use Webaccess\WineSupervisorLaravel\Services\SaleManager;

class IndexController
{
    public function index(Request $request)
    {
        return view('wine-supervisor::pages.club-premium.index', [
            'sales' => SaleManager::getCurrentSales()
        ]);
    }
}