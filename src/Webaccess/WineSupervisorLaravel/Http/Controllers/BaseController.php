<?php

namespace Webaccess\WineSupervisorLaravel\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Webaccess\WineSupervisorLaravel\Models\User;
use Webaccess\WineSupervisorLaravel\Services\FacilityManager;

class BaseController extends Controller
{
    public function __construct(Request $request)
    {
        $this->request = $request;
    }

    protected function getUser()
    {
        return auth()->check() ? auth()->user() : false;
    }
}