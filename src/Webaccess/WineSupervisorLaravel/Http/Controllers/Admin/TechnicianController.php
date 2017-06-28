<?php

namespace Webaccess\WineSupervisorLaravel\Http\Controllers\Admin;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
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

        Log::info('ADMIN_UPDATE_TECHNICIAN_REQUEST', [
            'id' => $requestID,
            'admin_id' => $this->getAdministratorID(),
            'technician_id' => $request->get('technician_id'),
            'status' => $request->get('status'),
        ]);

        list($success, $error) = TechnicianRepository::update(
            $request->get('technician_id'),
            $request->get('status') === 'on' ? Technician::STATUS_ENABLED : Technician::STATUS_DISABLED
        );

        if (!$success) {
            $request->session()->flash('error', trans('wine-supervisor::admin.technician_update_error'));

            Log::info('ADMIN_UPDATE_TECHNICIAN_RESPONSE', [
                'id' => $requestID,
                'error' => $error,
                'success' => false
            ]);

            return redirect()->back()->withInput();
        }

        $request->session()->flash('confirmation', trans('wine-supervisor::admin.technician_update_success'));

        Log::info('ADMIN_UPDATE_TECHNICIAN_RESPONSE', [
            'id' => $requestID,
            'success' => true
        ]);

        return redirect()->route('admin_technician_list');
    }
}