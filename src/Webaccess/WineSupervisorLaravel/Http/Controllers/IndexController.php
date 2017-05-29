<?php

namespace Webaccess\WineSupervisorLaravel\Http\Controllers;

use Illuminate\Http\Request;

class IndexController extends BaseController
{
    public function index(Request $request)
    {
        parent::__construct($request);

        return view('wine-supervisor::pages.index');
    }
}