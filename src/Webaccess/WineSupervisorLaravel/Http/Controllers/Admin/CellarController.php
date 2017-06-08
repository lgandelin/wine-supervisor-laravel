<?php

namespace Webaccess\WineSupervisorLaravel\Http\Controllers\Admin;

use Illuminate\Http\Request;
use Webaccess\WineSupervisorLaravel\Services\CellarManager;

class CellarController extends AdminController
{
    public function index(Request $request)
    {
        parent::__construct($request);

        return view('wine-supervisor::pages.admin.cellar.index', [
            'cellars' => CellarManager::getAll(),

            'error' => ($request->session()->has('error')) ? $request->session()->get('error') : null,
            'confirmation' => ($request->session()->has('confirmation')) ? $request->session()->get('confirmation') : null,
        ]);
    }

    public function update(Request $request, $cellarID) {

        parent::__construct($request);

        return view('wine-supervisor::pages.admin.cellar.update', [
            'cellar' => CellarManager::getByID($cellarID),

            'error' => ($request->session()->has('error')) ? $request->session()->get('error') : null,
            'confirmation' => ($request->session()->has('confirmation')) ? $request->session()->get('confirmation') : null,
        ]);
    }

    public function update_handler(Request $request)
    {
        parent::__construct($request);

        if ($request->get('technician_id') && !CellarManager::checkTechnicianID($request->get('technician_id'))) {
            $request->session()->flash('error', trans('wine-supervisor::user_signup.technician_id_error'));
            return redirect()->back()->withInput();
        }

        if (CellarManager::update(
            $request->get('cellar_id'),
            null,
            $this->getAdministratorID(),
            $request->get('technician_id'),
            $request->get('name'),
            $request->get('subscription_type'),
            $request->get('serial_number'),
            $request->get('address'),
            $request->get('zipcode'),
            $request->get('city')
        )) {

            //Call CDO webservice
            //TODO : CALL CDO

            $request->session()->flash('confirmation', trans('wine-supervisor::admin.cellar_update_success'));
        } else {
            $request->session()->flash('error', trans('wine-supervisor::admin.cellar_update_error'));
        }

        return redirect()->route('admin_cellar_list');
    }
}