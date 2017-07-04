<?php

namespace Webaccess\WineSupervisorLaravel\Http\Controllers\User;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Ramsey\Uuid\Uuid;
use Webaccess\WineSupervisorLaravel\Models\Subscription;
use Webaccess\WineSupervisorLaravel\Repositories\CellarRepository;
use Webaccess\WineSupervisorLaravel\Repositories\UserRepository;

class SignupController
{
    public function signup(Request $request)
    {
        if ($session_user = $request->session()->get('user_signup')) {
            $session_user = json_decode($session_user);
        }

        return view('wine-supervisor::pages.user.signup.user', [
            'last_name' => isset($session_user) ? $session_user->last_name : null,
            'first_name' => isset($session_user) ? $session_user->first_name : null,
            'email' => isset($session_user) ? $session_user->email : null,
            'phone' => isset($session_user) ? $session_user->phone : null,
            'login' => isset($session_user) ? $session_user->login : null,
            'opt_in' => isset($session_user) ? $session_user->opt_in : null,
            'route' => $request->route()->getName(),

            'error' => ($request->session()->has('error')) ? $request->session()->get('error') : null,
            'confirmation' => ($request->session()->has('confirmation')) ? $request->session()->get('confirmation') : null,
        ]);
    }

    public function signup_handler(Request $request)
    {
        if (!UserRepository::checkLogin(null, $request->get('login'))) {
            $request->session()->flash('error', trans('wine-supervisor::signup.user_existing_login_error'));
            return redirect()->back()->withInput();
        }

        $request->session()->put('user_signup', json_encode([
            'last_name' => $request->get('last_name'),
            'first_name' => $request->get('first_name'),
            'email' => $request->get('email'),
            'phone' => $request->get('phone'),
            'login' => $request->get('login'),
            'password' => $request->get('password'),
            'opt_in' => $request->get('opt_in') === 'on' ? true : false,
        ]));

        return redirect()->route('user_signup_cellar');
    }

    public function signup_cellar(Request $request)
    {
        return view('wine-supervisor::pages.user.signup.cellar', [
            'error' => ($request->session()->has('error')) ? $request->session()->get('error') : null,
            'confirmation' => ($request->session()->has('confirmation')) ? $request->session()->get('confirmation') : null,
        ]);
    }

    public function signup_cellar_handler(Request $request)
    {
        $requestID = Uuid::uuid4()->toString();

        if ($session_user = $request->session()->get('user_signup')) {
            $user_data = json_decode($session_user);

            Log::info('USER_SIGNUP_CREATE_USER_REQUEST', [
                'id' => $requestID,
                'first_name' => $user_data->first_name,
                'last_name' => $user_data->last_name,
                'email' => $user_data->email,
                'phone' => $user_data->phone,
                'login' => $user_data->login,
                'opt_in' => $user_data->opt_in,
            ]);

            list($success, $error, $result) = UserRepository::create(
                $user_data->first_name,
                $user_data->last_name,
                $user_data->email,
                $user_data->phone,
                $user_data->login,
                $user_data->password,
                $user_data->opt_in
            );

            if (!$success) {
                $request->session()->flash('error', $error);

                Log::info('USER_SIGNUP_CREATE_USER_RESPONSE', [
                    'id' => $requestID,
                    'error' => $error,
                    'success' => false
                ]);

                return redirect()->back()->withInput();
            } else {
                Log::info('USER_SIGNUP_CREATE_USER_RESPONSE', [
                    'id' => $requestID,
                    'success' => true
                ]);

                $userID = $result;

                Log::info('USER_SIGNUP_CREATE_CELLAR_REQUEST', [
                    'id' => $requestID,
                    'user_id' => $userID,
                    'id_ws' => $request->get('id_ws'),
                    'technician_id' => $request->get('technician_id'),
                    'name' => $request->get('name'),
                    'subscription_type' => Subscription::DEFAULT_SUBSCRIPTION, //TODO : HANDLE DIFFERENT SUBSCRIPTION TYPES
                    'serial_number' => $request->get('serial_number'),
                    'address' => $request->get('address'),
                    'zipcode' => $request->get('zipcode'),
                    'city' => $request->get('city')
                ]);

                list($success, $error) = CellarRepository::create(
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

                if (!$success) {
                    $request->session()->flash('error', $error);

                    Log::info('USER_SIGNUP_CREATE_CELLAR_RESPONSE', [
                        'id' => $requestID,
                        'error' => $error,
                        'success' => false
                    ]);

                    return redirect()->back()->withInput();
                } else {
                    Log::info('USER_SIGNUP_CREATE_CELLAR_RESPONSE', [
                        'id' => $requestID,
                        'success' => true
                    ]);

                    //Log user in and redirect
                    if (Auth::attempt(['email' => $user_data->email, 'password' => $user_data->password])) {
                        return redirect()->route('user_cellar_list');
                    }
                }
            }
        } else {
            $request->session()->flash('error', trans('wine-supervisor::signup.session_error'));
        }

        return redirect()->route('user_signup');
    }
}