<?php

namespace Webaccess\WineSupervisorLaravel\Http\Controllers\Technician;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Ramsey\Uuid\Uuid;
use Webaccess\WineSupervisorLaravel\Repositories\TechnicianRepository;
use Webaccess\WineSupervisorLaravel\Repositories\UserRepository;
use Webaccess\WineSupervisorLaravel\Services\AccountService;

class AccountController
{
    public function __construct()
    {
        view()->share('is_technician', true);
    }

    public function getTechnicianID()
    {
        return Auth::guard('technicians')->getUser()->id;
    }

    public function update(Request $request)
    {
        return view('wine-supervisor::pages.technician.account.update', [
            'technician' => TechnicianRepository::getByID($this->getTechnicianID()),
            'is_eligible_to_supervision' => AccountService::isUserEligibleToSupervision(),
            'error' => ($request->session()->has('error')) ? $request->session()->get('error') : null,
            'confirmation' => ($request->session()->has('confirmation')) ? $request->session()->get('confirmation') : null,
        ]);
    }

    public function update_handler(Request $request)
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

        Log::info('TECHNICIAN_UPDATE_ACCOUNT_REQUEST', [
            'id' => $requestID,
            'technician_id' => $this->getTechnicianID(),
            'first_name' => $request->get('first_name'),
            'last_name' => $request->get('last_name'),
            'company' => $request->get('company'),
            'registration' => $request->get('registration'),
            'phone' => $request->get('phone'),
            'email' => $request->get('email'),
            'address' => $request->get('address'),
            'address2' => $request->get('address2'),
            'zipcode' => $request->get('zipcode'),
            'city' => $request->get('city'),
            'country' => $request->get('country'),
            'opt_in' => $request->get('opt_in'),
            'locale' => $request->get('locale'),
        ]);

        list($success, $error) = TechnicianRepository::update(
            $this->getTechnicianID(),
            $request->get('first_name'),
            $request->get('last_name'),
            $request->get('company'),
            $request->get('registration'),
            $request->get('phone'),
            $request->get('email'),
            $request->get('password') != "********" ? $request->get('password') : null,
            $request->get('address'),
            $request->get('address2'),
            $request->get('zipcode'),
            $request->get('city'),
            $request->get('country'),
            $request->get('opt_in') == '1' ? true : false,
            $request->get('locale')
        );

        if (!$success) {
            $request->session()->flash('error', trans('wine-supervisor::technician.technician_update_error'));

            Log::info('TECHNICIAN_UPDATE_ACCOUNT_RESPONSE', [
                'id' => $requestID,
                'error' => $error,
                'success' => false
            ]);

            return redirect()->back()->withInput();
        }

        $request->session()->flash('confirmation', trans('wine-supervisor::technician.technician_update_success'));

        Log::info('TECHNICIAN_UPDATE_ACCOUNT_RESPONSE', [
            'id' => $requestID,
            'success' => true
        ]);

        return redirect()->route('technician_update_account');
    }
}