<?php

namespace Webaccess\WineSupervisorLaravel\Http\Controllers\User;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use Ramsey\Uuid\Uuid;
use Webaccess\WineSupervisorLaravel\Models\Subscription;
use Webaccess\WineSupervisorLaravel\Repositories\CellarRepository;
use Webaccess\WineSupervisorLaravel\Repositories\TechnicianRepository;
use Webaccess\WineSupervisorLaravel\Repositories\UserRepository;

class SignupController
{
    public function signup(Request $request)
    {
        if ($session_user = $request->session()->get('user_signup')) {
            $session_user = json_decode($session_user);
        }

        $old_opt_in = old('opt_in') ? old('opt_in') : 1;

        return view('wine-supervisor::pages.user.signup.user', [
            'last_name' => isset($session_user) && $session_user->last_name ? $session_user->last_name : old('last_name'),
            'first_name' => isset($session_user) && $session_user->first_name ? $session_user->first_name : old('first_name'),
            'email' => isset($session_user) && $session_user->email ? $session_user->email : old('email'),
            'phone' => isset($session_user) && $session_user->phone ? $session_user->phone : old('phone'),
            'opt_in' => isset($session_user) ? $session_user->opt_in : $old_opt_in,
            'address' => isset($session_user) && $session_user->address ? $session_user->address : old('address'),
            'address2' => isset($session_user) && $session_user->address2 ? $session_user->address2 : old('address2'),
            'zipcode' => isset($session_user) && $session_user->zipcode ? $session_user->zipcode : old('zipcode'),
            'city' => isset($session_user) && $session_user->city ? $session_user->city : old('city'),
            'country' => isset($session_user) && $session_user->country ? $session_user->country : old('country'),
            'route' => $request->route()->getName(),

            'error' => ($request->session()->has('error')) ? $request->session()->get('error') : null,
            'confirmation' => ($request->session()->has('confirmation')) ? $request->session()->get('confirmation') : null,
        ]);
    }

    public function signup_handler(Request $request)
    {
        if ($request->get('password') != $request->get('password_confirm')) {
            $request->session()->flash('error', trans('wine-supervisor::signup.user_password_confirmation'));
            return redirect()->back()->withInput();
        }

        if (!UserRepository::checkPassword($request->get('password'))) {
            $request->session()->flash('error', trans('wine-supervisor::generic.password_not_secured'));
            return redirect()->back()->withInput();
        }

        if (!UserRepository::checkEmail(null, $request->get('email')) || !TechnicianRepository::checkEmail(null, $request->get('email'))) {
            $request->session()->flash('error', trans('wine-supervisor::signup.user_existing_email_error'));
            return redirect()->back()->withInput();
        }

        $request->session()->put('user_signup', json_encode([
            'last_name' => $request->get('last_name'),
            'first_name' => $request->get('first_name'),
            'email' => $request->get('email'),
            'phone' => $request->get('phone'),
            'password' => $request->get('password'),
            'opt_in' => $request->get('opt_in') == '1' ? true : false,
            'address' => $request->get('address'),
            'address2' => $request->get('address2'),
            'zipcode' => $request->get('zipcode'),
            'city' => $request->get('city'),
            'country' => $request->get('country')
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

        $idWS = '';
        for ($i = 1; $i <= 6; $i++) {
            $idWS .= strtoupper($request->get('id_ws_' . $i));
            if ($i < 6) $idWS .= ':';
        }

        list($checkSuccess, $checkError) = CellarRepository::doPreliminaryChecks($idWS, $request->get('technician_id'), $request->get('activation_code'));

        if (!$checkSuccess) {
            $request->session()->flash('error', $checkError);
            return redirect()->back()->withInput();
        }

        if ($session_user = $request->session()->get('user_signup')) {
            $user_data = json_decode($session_user);

            if (!$request->session()->has('user_signed_up_' . $user_data->email)) {

                //CREATE USER
                Log::info('USER_SIGNUP_CREATE_USER_REQUEST', [
                    'id' => $requestID,
                    'first_name' => $user_data->first_name,
                    'last_name' => $user_data->last_name,
                    'email' => $user_data->email,
                    'phone' => $user_data->phone,
                    'opt_in' => $user_data->opt_in,
                    'address' => $user_data->address,
                    'address2' => $user_data->address2,
                    'zipcode' => $user_data->zipcode,
                    'city' => $user_data->city,
                    'country' => $user_data->country
                ]);

                list($success, $error, $result) = UserRepository::create(
                    $user_data->first_name,
                    $user_data->last_name,
                    $user_data->email,
                    $user_data->phone,
                    $user_data->password,
                    $user_data->opt_in,
                    $user_data->address,
                    $user_data->address2,
                    $user_data->zipcode,
                    $user_data->city,
                    $user_data->country
                );

                if (!$success) {
                    $request->session()->flash('error', $error);

                    Log::info('USER_SIGNUP_CREATE_USER_RESPONSE', [
                        'id' => $requestID,
                        'error' => $error,
                        'success' => false
                    ]);

                    return redirect()->back()->withInput();
                }

                Log::info('USER_SIGNUP_CREATE_USER_RESPONSE', [
                    'id' => $requestID,
                    'success' => true
                ]);

                $request->session()->put('user_signed_up_' . $user_data->email, isset($result['user_id']) ? $result['user_id'] : false);
            }

            $userID = $request->session()->get('user_signed_up_' . $user_data->email);

            //CREATE CELLAR
            Log::info('USER_SIGNUP_CREATE_CELLAR_REQUEST', [
                'id' => $requestID,
                'user_id' => $userID,
                'id_ws' => $idWS,
                'technician_id' => $request->get('technician_id'),
                'name' => $request->get('name'),
                'subscription_type' => Subscription::DEFAULT_SUBSCRIPTION,
                'serial_number' => $request->get('serial_number'),
                'address' => $request->get('address'),
                'address2' => $request->get('address2'),
                'zipcode' => $request->get('zipcode'),
                'city' => $request->get('city'),
                'country' => $request->get('country')
            ]);

            list($success, $error) = CellarRepository::create(
                $userID,
                $idWS,
                $request->get('technician_id'),
                $request->get('name'),
                Subscription::DEFAULT_SUBSCRIPTION,
                $request->get('serial_number'),
                $request->get('address'),
                $request->get('address2'),
                $request->get('zipcode'),
                $request->get('city'),
                $request->get('country')
            );

            if (!$success) {
                $request->session()->flash('error', $error);

                Log::info('USER_SIGNUP_CREATE_CELLAR_RESPONSE', [
                    'id' => $requestID,
                    'error' => $error,
                    'success' => false
                ]);

                return redirect()->back()->withInput();
            }

            Log::info('USER_SIGNUP_CREATE_CELLAR_RESPONSE', [
                'id' => $requestID,
                'success' => true
            ]);

            //Log user in and redirect
            if (Auth::attempt(['email' => $user_data->email, 'password' => $user_data->password])) {
                return redirect()->route('user_update_account');
            }
        } else {
            $request->session()->flash('error', trans('wine-supervisor::signup.session_error'));
        }

        return redirect()->route('user_signup');
    }

    public function technician_signup_handler(Request $request)
    {
        $requestID = Uuid::uuid4()->toString();

        if ($request->get('password') != $request->get('password_confirm')) {
            $request->session()->flash('error', trans('wine-supervisor::signup.user_password_confirmation'));
            return redirect()->back()->withInput();
        }

        if (!UserRepository::checkPassword($request->get('password'))) {
            $request->session()->flash('error', trans('wine-supervisor::generic.password_not_secured'));
            return redirect()->back()->withInput();
        }

        if (!UserRepository::checkEmail(null, $request->get('email')) || !TechnicianRepository::checkEmail(null, $request->get('email'))) {
            $request->session()->flash('error', trans('wine-supervisor::signup.user_existing_email_error'));
            return redirect()->back()->withInput();
        }

        Log::info('TECHNICIAN_SIGNUP_REQUEST', [
            'id' => $requestID,
            'first_name' => $request->get('last_name'),
            'last_name' => $request->get('last_name'),
            'company' => $request->get('company'),
            'registration' => $request->get('registration'),
            'phone' => $request->get('phone'),
            'email' => $request->get('email'),
            'address' => $request->get('address'),
            'address2' => $request->get('address2'),
            'zipcode' => $request->get('zipcode'),
            'city' => $request->get('city'),
            'country' => $request->get('country')
        ]);

        list($success, $error, $technicianID) = TechnicianRepository::create(
            $request->get('first_name'),
            $request->get('last_name'),
            $request->get('company'),
            $request->get('registration'),
            $request->get('phone'),
            $request->get('email'),
            $request->get('password'),
            $request->get('address'),
            $request->get('address2'),
            $request->get('zipcode'),
            $request->get('city'),
            $request->get('country')
        );

        if (!$success) {
            $request->session()->flash('error', trans('wine-supervisor::technician.technician_create_error'));

            Log::info('TECHNICIAN_SIGNUP_RESPONSE', [
                'id' => $requestID,
                'error' => $error,
                'success' => false
            ]);

            return redirect()->back()->withInput();
        }

        $request->session()->flash('confirmation', trans('wine-supervisor::technician.technician_create_success'));

        Log::info('TECHNICIAN_SIGNUP_RESPONSE', [
            'id' => $requestID,
            'success' => true
        ]);

        if ($techician = TechnicianRepository::getByID($technicianID)) {

            try {
                Mail::send('wine-supervisor::emails.technician_signup_admin', array('technician' => $techician), function ($message) {
                    $message->to(env('WS_ADMIN_EMAIL'))
                        ->subject('[WineSupervisor] Un nouvel installateur s\'est inscrit sur le site');
                });

                Log::info('TECHNICIAN_SIGNUP_ADMIN_EMAIL', [
                    'id' => $requestID,
                    'success' => true
                ]);
            } catch (\Exception $e) {
                Log::info('TECHNICIAN_SIGNUP_ADMIN_EMAIL', [
                    'id' => $requestID,
                    'error' => $e->getMessage(),
                    'success' => false
                ]);
            }
        }

        return redirect()->route('technician_signup_success');
    }

    public function technician_signup_success(Request $request) {
        return view('wine-supervisor::pages.user.signup.technician');
    }
}