<?php

namespace Webaccess\WineSupervisorLaravel\Http\Controllers\Guest;

use Illuminate\Http\Request;
use Webaccess\WineSupervisorLaravel\Http\Controllers\BaseController;

class IndexController extends BaseController
{
    public function index(Request $request)
    {
        parent::__construct($request);

        return view('wine-supervisor::pages.guest.index', [
            'error' => ($request->session()->has('error')) ? $request->session()->get('error') : null,
            'confirmation' => ($request->session()->has('confirmation')) ? $request->session()->get('confirmation') : null,
        ]);
    }
}