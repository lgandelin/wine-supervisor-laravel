<?php

namespace Webaccess\WineSupervisorLaravel\Http\Controllers\User;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Webaccess\WineSupervisorLaravel\Models\Subscription;
use Webaccess\WineSupervisorLaravel\Services\CellarManager;
use Webaccess\WineSupervisorLaravel\Services\UserManager;

class SignupController extends UserController
{
    public function signup(Request $request)
    {
        parent::__construct($request);

        if ($session_user = $request->session()->get('user_signup')) {
            $session_user = json_decode($session_user);
        }

        return view('wine-supervisor::pages.user.signup.user', [
            'last_name' => isset($session_user) ? $session_user->last_name : null,
            'first_name' => isset($session_user) ? $session_user->first_name : null,
            'email' => isset($session_user) ? $session_user->email : null,
            'login' => isset($session_user) ? $session_user->login : null,
            'opt_in' => isset($session_user) ? $session_user->opt_in : null,

            'error' => ($request->session()->has('error')) ? $request->session()->get('error') : null,
            'confirmation' => ($request->session()->has('confirmation')) ? $request->session()->get('confirmation') : null,
        ]);
    }

    public function signup_handler(Request $request)
    {
        parent::__construct($request);

        if (!UserManager::checkLogin(null, $request->get('login'))) {
            $request->session()->flash('error', trans('wine-supervisor::user_signup.user_existing_login_error'));
            return redirect()->back()->withInput();
        }

        $request->session()->put('user_signup', json_encode([
            'last_name' => $request->get('last_name'),
            'first_name' => $request->get('first_name'),
            'email' => $request->get('email'),
            'login' => $request->get('login'),
            'password' => $request->get('password'),
            'opt_in' => $request->get('opt_in') === 'on' ? true : false,
        ]));

        return redirect()->route('user_signup_cellar');
    }

    public function signup_cellar(Request $request)
    {
        parent::__construct($request);

        return view('wine-supervisor::pages.user.signup.cellar', [
            'error' => ($request->session()->has('error')) ? $request->session()->get('error') : null,
            'confirmation' => ($request->session()->has('confirmation')) ? $request->session()->get('confirmation') : null,
        ]);
    }

    public function signup_cellar_handler(Request $request)
    {
        parent::__construct($request);

        if ($session_user = $request->session()->get('user_signup')) {
            $user_data = json_decode($session_user);

            if (!UserManager::checkLogin(null, $user_data->login)) {
                $request->session()->flash('error', trans('wine-supervisor::user_signup.user_existing_login_error'));
                return redirect()->route('user_signup')->withInput();
            }

            if ($userID = UserManager::create($user_data->first_name, $user_data->last_name, $user_data->email, $user_data->login, $user_data->password, $user_data->opt_in)) {

                if (!CellarManager::checkIDWS($request->get('id_ws'))) {
                    $request->session()->flash('error', trans('wine-supervisor::user_signup.id_ws_error'));
                    return redirect()->route('user_signup_cellar');
                }

                if ($request->get('technician_id') && !CellarManager::checkTechnicianID($request->get('technician_id'))) {
                    $request->session()->flash('error', trans('wine-supervisor::user_signup.technician_id_error'));
                    return redirect()->back()->withInput();
                }

                CellarManager::create(
                    $userID,
                    $request->get('id_ws'),
                    $request->get('technician_id'),
                    $request->get('name'),
                    Subscription::DEFAULT_SUBSCRIPTION, //TODO : HANDLE DIFFERENT SUBSCRIPTION TYPES
                    $request->get('serial_number'),
                    $request->get('address'),
                    $request->get('zipcode'),
                    $request->get('city')
                );

                //Call CDO webservice
                //TODO : CALL CDO

                //Log user in and redirect
                if (Auth::attempt(['email' => $user_data->email, 'password' => $user_data->password])) {
                    return redirect()->route('user_cellar_list');
                }
            } else {
                $request->session()->flash('error', trans('wine-supervisor::user_signup.create_user_error'));
            }
        } else {
            $request->session()->flash('error', trans('wine-supervisor::user_signup.session_error'));
        }

        return redirect()->route('user_signup');
    }

}