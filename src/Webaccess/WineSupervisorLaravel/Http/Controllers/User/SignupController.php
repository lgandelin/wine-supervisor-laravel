<?php

namespace Webaccess\WineSupervisorLaravel\Http\Controllers\User;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Webaccess\WineSupervisorLaravel\Http\Controllers\BaseController;
use Webaccess\WineSupervisorLaravel\Models\Subscription;
use Webaccess\WineSupervisorLaravel\Models\User;
use Webaccess\WineSupervisorLaravel\Services\SignupManager;

class SignupController extends BaseController
{
    public function signup(Request $request)
    {
        parent::__construct($request);

        if ($session_user = $this->request->session()->get('user_signup')) {
            $session_user = json_decode($session_user);
        }

        return view('wine-supervisor::pages.user.signup.1', [
            'last_name' => isset($session_user) ? $session_user->last_name : null,
            'first_name' => isset($session_user) ? $session_user->first_name : null,
            'email' => isset($session_user) ? $session_user->email : null,
            'opt_in' => isset($session_user) ? $session_user->opt_in : null,

            'error' => ($request->session()->has('error')) ? $request->session()->get('error') : null,
            'confirmation' => ($request->session()->has('confirmation')) ? $request->session()->get('confirmation') : null,
        ]);
    }

    public function signup_handler(Request $request)
    {
        parent::__construct($request);

        $user = new User();
        $user->last_name = $request->get('last_name');
        $user->first_name = $request->get('first_name');
        $user->email = $request->get('email');
        $user->password = $request->get('password');
        $user->subscription_type = Subscription::DEFAULT_SUBSCRIPTION;
        $user->opt_in = $request->get('opt_in') === 'on' ? true : false;

        $request->session()->put('user_signup', json_encode($user));

        return redirect()->route('user_signup_2');
    }

    public function signup_2(Request $request)
    {
        parent::__construct($request);

        return view('wine-supervisor::pages.user.signup.2', [
            'error' => ($request->session()->has('error')) ? $request->session()->get('error') : null,
            'confirmation' => ($request->session()->has('confirmation')) ? $request->session()->get('confirmation') : null,
        ]);
    }

    public function signup_2_handler(Request $request)
    {
        parent::__construct($request);

        //TODO : REFACTORING

        if ($session_user = $this->request->session()->get('user_signup')) {
            $user = new User(get_object_vars(json_decode($session_user)));
            $unhashed_password = $user->password;

            if ($userID = SignupManager::createUser($user)) {

                if (!SignupManager::checkIDWS($request)) {
                    $request->session()->flash('error', trans('wine-supervisor::user_signup.id_ws_error'));
                    return redirect()->route('user_signup_2');
                }

                SignupManager::createCellar($userID, $request);
                SignupManager::updateWSTable($request);

                //Call CDO webservice
                //TODO : CALL CDO

                //Log user in and redirect
                if (Auth::attempt(['email' => $user->email, 'password' => $unhashed_password])) {
                    return redirect()->route('user_index');
                }
            }
        }

        $request->session()->flash('error', trans('wine-supervisor::user_signup.session_error'));

        return redirect()->route('user_signup');
    }

}