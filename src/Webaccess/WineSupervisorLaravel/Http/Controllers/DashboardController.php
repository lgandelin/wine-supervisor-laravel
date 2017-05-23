<?php

namespace Webaccess\WineSupervisorLaravel\Http\Controllers;

class DashboardController extends BaseController
{
    public function index()
    {
        parent::__construct($this->request);

        return view('wine-supervisor::pages.dashboard', [
            'error' => ($this->request->session()->has('error')) ? $this->request->session()->get('error') : null,
            'confirmation' => ($this->request->session()->has('confirmation')) ? $this->request->session()->get('confirmation') : null,
        ]);
    }
}