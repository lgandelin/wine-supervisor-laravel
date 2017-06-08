<?php

namespace Webaccess\WineSupervisorLaravel\Http\Controllers\Admin;

use Illuminate\Http\Request;
use Webaccess\WineSupervisorLaravel\Models\Technician;
use Webaccess\WineSupervisorLaravel\Services\TechnicianManager;

class TechnicianController extends AdminController
{
    public function index(Request $request)
    {
        parent::__construct($request);

        return view('wine-supervisor::pages.admin.technician.index', [
            'technicians' => TechnicianManager::getAll(),

            'error' => ($request->session()->has('error')) ? $request->session()->get('error') : null,
            'confirmation' => ($request->session()->has('confirmation')) ? $request->session()->get('confirmation') : null,
        ]);
    }

    public function update(Request $request, $technicianID) {

        parent::__construct($request);

        return view('wine-supervisor::pages.admin.technician.update', [
            'technician' => TechnicianManager::getByID($technicianID),

            'error' => ($request->session()->has('error')) ? $request->session()->get('error') : null,
            'confirmation' => ($request->session()->has('confirmation')) ? $request->session()->get('confirmation') : null,
        ]);
    }

    public function update_handler(Request $request)
    {
        parent::__construct($request);

        if (TechnicianManager::update(
            $request->get('technician_id'),
            $request->get('status') === 'on' ? Technician::STATUS_ENABLED : Technician::STATUS_DISABLED
        )) {
            //Call CDO webservice
            //TODO : CALL CDO

            $request->session()->flash('confirmation', trans('wine-supervisor::admin.technician_update_success'));
        } else {
            $request->session()->flash('error', trans('wine-supervisor::admin.technician_update_error'));
        }

        return redirect()->route('admin_technician_list');
    }
}