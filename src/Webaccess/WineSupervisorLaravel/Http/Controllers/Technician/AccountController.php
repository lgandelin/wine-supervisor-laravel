<?php

namespace Webaccess\WineSupervisorLaravel\Http\Controllers\Technician;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Ramsey\Uuid\Uuid;
use Webaccess\WineSupervisorLaravel\Repositories\TechnicianRepository;
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

        Log::info('TECHNICIAN_UPDATE_ACCOUNT_REQUEST', [
            'id' => $requestID,
            'technician_id' => $this->getTechnicianID(),
            'company' => $request->get('company'),
            'registration' => $request->get('registration'),
            'phone' => $request->get('phone'),
            'email' => $request->get('email'),
            'login' => $request->get('login'),
            'address' => $request->get('address'),
            'zipcode' => $request->get('zipcode'),
            'city' => $request->get('city'),
        ]);

        list($success, $error) = TechnicianRepository::update(
            $this->getTechnicianID(),
            $request->get('company'),
            $request->get('registration'),
            $request->get('phone'),
            $request->get('email'),
            $request->get('login'),
            $request->get('password') ? $request->get('password') : null,
            $request->get('address'),
            $request->get('zipcode'),
            $request->get('city')
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