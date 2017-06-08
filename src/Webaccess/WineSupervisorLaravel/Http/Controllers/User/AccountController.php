<?php

namespace Webaccess\WineSupervisorLaravel\Http\Controllers\User;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Webaccess\WineSupervisorLaravel\Repositories\UserRepository;

class AccountController extends UserController
{
    public function update(Request $request)
    {
        parent::__construct($request);

        return view('wine-supervisor::pages.user.account.update', [
            'user' => UserRepository::getByID($this->getUserID()),

            'error' => ($request->session()->has('error')) ? $request->session()->get('error') : null,
            'confirmation' => ($request->session()->has('confirmation')) ? $request->session()->get('confirmation') : null,
        ]);
    }

    public function update_handler(Request $request)
    {
        parent::__construct($request);

        if (!UserRepository::checkLogin($this->getUserID(), $request->get('login'))) {
            $request->session()->flash('error', trans('wine-supervisor::user_account.existing_login_error'));
            return redirect()->back()->withInput();
        }

        if (UserRepository::update(
            $this->getUserID(),
            $request->get('first_name'),
            $request->get('last_name'),
            $request->get('email'),
            $request->get('login'),
            $request->get('password') ? $request->get('password') : null,
            $request->get('opt_in') === 'on' ? true : false
        )) {
            //Call CDO webservice
            //TODO : CALL CDO

            $request->session()->flash('confirmation', trans('wine-supervisor::user.user_update_success'));
        } else {
            $request->session()->flash('error', trans('wine-supervisor::user.user_update_error'));
        }

        return redirect()->route('user_update_account');
    }
}