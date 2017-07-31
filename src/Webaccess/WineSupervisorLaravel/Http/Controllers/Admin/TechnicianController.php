<?php

namespace Webaccess\WineSupervisorLaravel\Http\Controllers\Admin;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use Ramsey\Uuid\Uuid;
use Webaccess\WineSupervisorLaravel\Models\Technician;
use Webaccess\WineSupervisorLaravel\Repositories\TechnicianRepository;

class TechnicianController extends AdminController
{
    public function index(Request $request)
    {
        parent::__construct($request);

        return view('wine-supervisor::pages.admin.technician.index', [
            'technicians' => TechnicianRepository::getAll(),

            'error' => ($request->session()->has('error')) ? $request->session()->get('error') : null,
            'confirmation' => ($request->session()->has('confirmation')) ? $request->session()->get('confirmation') : null,
        ]);
    }

    public function update(Request $request, $technicianID) {

        parent::__construct($request);

        return view('wine-supervisor::pages.admin.technician.update', [
            'technician' => TechnicianRepository::getByID($technicianID),

            'error' => ($request->session()->has('error')) ? $request->session()->get('error') : null,
            'confirmation' => ($request->session()->has('confirmation')) ? $request->session()->get('confirmation') : null,
        ]);
    }

    public function update_handler(Request $request)
    {
        parent::__construct($request);

        $requestID = Uuid::uuid4()->toString();

        $technician = TechnicianRepository::getByID($request->get('technician_id'));
        $oldStatus = $technician->status;

        Log::info('ADMIN_UPDATE_TECHNICIAN_REQUEST', [
            'id' => $requestID,
            'admin_id' => $this->getAdministratorID(),
            'technician_id' => $request->get('technician_id'),
            'status' => $request->get('status'),
        ]);

        list($success, $error) = TechnicianRepository::update_status(
            $request->get('technician_id'),
            $request->get('status') === 'on' ? Technician::STATUS_ENABLED : Technician::STATUS_DISABLED
        );

        if (!$success) {
            $request->session()->flash('error', trans('wine-supervisor::technician.technician_update_error'));

            Log::info('ADMIN_UPDATE_TECHNICIAN_RESPONSE', [
                'id' => $requestID,
                'error' => $error,
                'success' => false
            ]);

            return redirect()->back()->withInput();
        }

        Log::info('ADMIN_UPDATE_TECHNICIAN_RESPONSE', [
            'id' => $requestID,
            'success' => true
        ]);

        $technicianEmail = $technician->email;

        if (!$oldStatus && $request->get('status')) {
            try {
                Mail::send('wine-supervisor::emails.technician_account', array('login' => $technician->email, 'url' => route('index')), function ($message) use ($technicianEmail) {
                    $message->to($technicianEmail)
                        ->subject('[WineSupervisor] Votre compte installateur a été validé');
                });

                $request->session()->flash('confirmation', trans('wine-supervisor::technician.technician_update_success'));

                Log::info('ADMIN_CREATE_TECHNICIAN_EMAIL_SEND_RESPONSE', [
                    'id' => $requestID,
                    'technician_email' => $technicianEmail,
                    'success' => true
                ]);
            } catch (\Exception $e) {
                $request->session()->flash('error', trans('wine-supervisor::technician.technician_update_email_error'));

                Log::info('ADMIN_CREATE_TECHNICIAN_EMAIL_SEND_RESPONSE', [
                    'id' => $requestID,
                    'technician_email' => $technicianEmail,
                    'error' => $e->getMessage(),
                    'success' => false
                ]);
            }
        }

        return redirect()->route('admin_technician_list');
    }
}