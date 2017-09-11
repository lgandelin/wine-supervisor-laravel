<?php

namespace Webaccess\WineSupervisorLaravel\Http\Controllers\Admin;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Ramsey\Uuid\Uuid;
use Webaccess\WineSupervisorLaravel\Repositories\CellarRepository;

class CellarController extends AdminController
{
    public function index(Request $request)
    {
        parent::__construct($request);

        return view('wine-supervisor::pages.admin.cellar.index', [
            'cellars' => CellarRepository::getAll($request->get('sc'), $request->get('so')),
            'sort_column' => $request->get('sc'),
            'sort_order' => ($request->get('so') == 'asc') ? 'desc' : 'asc',

            'error' => ($request->session()->has('error')) ? $request->session()->get('error') : null,
            'confirmation' => ($request->session()->has('confirmation')) ? $request->session()->get('confirmation') : null,
        ]);
    }

    public function update(Request $request, $cellarID) {

        parent::__construct($request);

        return view('wine-supervisor::pages.admin.cellar.update', [
            'cellar' => CellarRepository::getByID($cellarID),

            'error' => ($request->session()->has('error')) ? $request->session()->get('error') : null,
            'confirmation' => ($request->session()->has('confirmation')) ? $request->session()->get('confirmation') : null,
        ]);
    }

    public function update_handler(Request $request)
    {
        parent::__construct($request);

        $requestID = Uuid::uuid4()->toString();

        Log::info('ADMIN_UPDATE_CELLAR_REQUEST', [
            'id' => $requestID,
            'admin_id' => $this->getAdministratorID(),
            'technician_id' => $request->get('technician_id'),
            'name' => $request->get('name'),
            'subscription_type' => $request->get('subscription_type'),
            'serial_number' => $request->get('serial_number'),
            'address' => $request->get('address'),
            'address2' => $request->get('address2'),
            'zipcode' => $request->get('zipcode'),
            'city' => $request->get('city'),
            'country' => $request->get('country'),
        ]);

        list ($success, $error) = CellarRepository::update(
            $request->get('cellar_id'),
            null,
            $this->getAdministratorID(),
            $request->get('technician_id'),
            $request->get('name'),
            $request->get('subscription_type'),
            $request->get('serial_number'),
            $request->get('address'),
            $request->get('address2'),
            $request->get('zipcode'),
            $request->get('city'),
            $request->get('country')
        );

        if (!$success) {
            Log::info('ADMIN_UPDATE_CELLAR_RESPONSE', [
                'id' => $requestID,
                'error' => $error,
                'success' => false
            ]);

            $request->session()->flash('error', trans('wine-supervisor::cellar.cellar_update_error'));

            return redirect()->back()->withInput();
        }

        Log::info('ADMIN_UPDATE_CELLAR_RESPONSE', [
            'id' => $requestID,
            'success' => true
        ]);

        $request->session()->flash('confirmation', trans('wine-supervisor::cellar.cellar_update_success'));

        return redirect()->route('admin_cellar_list');
    }

    public function delete_handler(Request $request, $cellarID)
    {
        parent::__construct($request);

        $requestID = Uuid::uuid4()->toString();

        Log::info('ADMIN_DELETE_CELLAR_REQUEST', [
            'id' => $requestID,
            'cellar_id' => $request->get('cellar_id'),
            'admin_id' => $this->getAdministratorID(),
        ]);

        list ($success, $error) = CellarRepository::delete($cellarID, null);

        if (!$success) {
            $request->session()->flash('error', trans('wine-supervisor::cellar.cellar_delete_error'));

            Log::info('ADMIN_DELETE_CELLAR_RESPONSE', [
                'id' => $requestID,
                'error' => $error,
                'success' => false
            ]);

            return redirect()->back()->withInput();
        }

        $request->session()->flash('confirmation', trans('wine-supervisor::cellar.cellar_delete_success'));

        Log::info('ADMIN_DELETE_CELLAR_RESPONSE', [
            'id' => $requestID,
            'success' => true
        ]);

        return redirect()->route('admin_cellar_list');
    }
}