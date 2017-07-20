<?php

namespace Webaccess\WineSupervisorLaravel\Http\Controllers\Admin;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    public function __construct(Request $request)
    {
        $this->request = $request;
    }

    public function login()
    {
        view()->share('is_admin', Auth::guard('administrators')->user());

        return view('wine-supervisor::pages.admin.auth.login', [
            'error' => ($this->request->session()->has('error')) ? $this->request->session()->get('error') : null,
        ]);
    }

    /**
     * @param
     * @return mixed
     */
    public function authenticate()
    {
        if (Auth::guard('administrators')->attempt([
            'email' => $this->request->input('email'),
            'password' => $this->request->input('password'),
        ])) {
            return redirect()->route('admin_index');
        }

        return redirect()->route('admin_login')->with([
            'error' => trans('wine-supervisor::login.login_or_password_error'),
        ]);
    }

    /**
     * @return mixed
     */
    public function logout()
    {
        Auth::guard('administrators')->logout();

        return redirect()->route('admin_login');
    }
}