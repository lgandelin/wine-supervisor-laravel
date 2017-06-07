<?php

namespace Webaccess\WineSupervisorLaravel\Http\Controllers\ClubPremium;

use Illuminate\Http\Request;
use Webaccess\WineSupervisorLaravel\Http\Controllers\BaseController;
use Webaccess\WineSupervisorLaravel\Services\SaleManager;

class IndexController extends BaseController
{
    public function index(Request $request)
    {
        parent::__construct($request);

        return view('wine-supervisor::pages.club-premium.index', [
            'sales' => SaleManager::getCurrentSales()
        ]);
    }
}