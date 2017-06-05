<?php

namespace Webaccess\WineSupervisorLaravel\Http\Controllers\Technician;

use Illuminate\Http\Request;
use Webaccess\WineSupervisorLaravel\Http\Controllers\BaseController;
use Webaccess\WineSupervisorLaravel\Services\TechnicianManager;

class SignupController extends BaseController
{
    public function signup(Request $request)
    {
        parent::__construct($request);

        return view('wine-supervisor::pages.technician.signup', [
            'error' => ($request->session()->has('error')) ? $request->session()->get('error') : null,
            'confirmation' => ($request->session()->has('confirmation')) ? $request->session()->get('confirmation') : null,
        ]);
    }

    public function signup_handler(Request $request)
    {
        parent::__construct($request);

        TechnicianManager::create(
            $request->get('company'),
            $request->get('registration'),
            $request->get('phone'),
            $request->get('email'),
            $request->get('login'),
            $request->get('password'),
            $request->get('address'),
            $request->get('zipcode'),
            $request->get('city')
        );

        return redirect()->route('user_login');
    }
}
