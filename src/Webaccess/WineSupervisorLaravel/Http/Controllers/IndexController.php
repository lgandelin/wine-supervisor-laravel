<?php

namespace Webaccess\WineSupervisorLaravel\Http\Controllers;

use Illuminate\Http\Request;

class IndexController
{
    public function index(Request $request)
    {
        return view('wine-supervisor::pages.index');
    }
}