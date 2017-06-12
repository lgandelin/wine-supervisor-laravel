<?php

namespace Webaccess\WineSupervisorLaravel\Http\Controllers\Technician;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Ramsey\Uuid\Uuid;
use Webaccess\WineSupervisorLaravel\Repositories\TechnicianRepository;

class SignupController
{
    public function signup(Request $request)
    {
        return view('wine-supervisor::pages.technician.signup', [
            'error' => ($request->session()->has('error')) ? $request->session()->get('error') : null,
            'confirmation' => ($request->session()->has('confirmation')) ? $request->session()->get('confirmation') : null,
        ]);
    }

    public function signup_handler(Request $request)
    {
        $requestID = Uuid::uuid4()->toString();

        Log::info('TECHNICIAN_SIGNUP_REQUEST', [
            'id' => $requestID,
            'company' => $request->get('company'),
            'registration' => $request->get('registration'),
            'phone' => $request->get('phone'),
            'email' => $request->get('email'),
            'login' => $request->get('login'),
            'address' => $request->get('address'),
            'zipcode' => $request->get('zipcode'),
            'city' => $request->get('city')
        ]);

        list($success, $error) = TechnicianRepository::create(
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

        return redirect()->route('user_login');
    }
}
