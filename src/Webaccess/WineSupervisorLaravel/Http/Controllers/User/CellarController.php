<?php

namespace Webaccess\WineSupervisorLaravel\Http\Controllers\User;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Webaccess\WineSupervisorLaravel\Models\Subscription;
use Webaccess\WineSupervisorLaravel\Models\WS;
use Webaccess\WineSupervisorLaravel\Repositories\CellarRepository;

class CellarController extends UserController
{
    public function index(Request $request)
    {
        parent::__construct($request);

        return view('wine-supervisor::pages.user.cellar.index', [
            'cellars' => CellarRepository::getByUser($this->getUserID()),

            'error' => ($request->session()->has('error')) ? $request->session()->get('error') : null,
            'confirmation' => ($request->session()->has('confirmation')) ? $request->session()->get('confirmation') : null,
        ]);
    }

    public function create(Request $request)
    {
        parent::__construct($request);

        return view('wine-supervisor::pages.user.cellar.create', [
            'error' => ($request->session()->has('error')) ? $request->session()->get('error') : null,
            'confirmation' => ($request->session()->has('confirmation')) ? $request->session()->get('confirmation') : null,
        ]);
    }

    public function create_handler(Request $request)
    {
        parent::__construct($request);

        if (!CellarRepository::checkIDWS($request->get('id_ws'))) {
            $request->session()->flash('error', trans('wine-supervisor::user_signup.id_ws_error'));
            return redirect()->back()->withInput();
        }

        if ($request->get('technician_id') && !CellarRepository::checkTechnicianID($request->get('technician_id'))) {
            $request->session()->flash('error', trans('wine-supervisor::user_signup.technician_id_error'));
            return redirect()->back()->withInput();
        }

        if (CellarRepository::create(
            $this->getUserID(),
            $request->get('id_ws'),
            $request->get('technician_id'),
            $request->get('name'),
            Subscription::DEFAULT_SUBSCRIPTION,
            $request->get('serial_number'),
            $request->get('address'),
            $request->get('zipcode'),
            $request->get('city')
        )) {
            $request->session()->flash('confirmation', trans('wine-supervisor::cellar.cellar_creation_success'));
        } else {
            $request->session()->flash('error', trans('wine-supervisor::cellar.cellar_creation_error'));
        }

        return redirect()->route('user_cellar_list');
    }

    public function update(Request $request, $cellarID)
    {
        parent::__construct($request);

        return view('wine-supervisor::pages.user.cellar.update', [
            'cellar' => CellarRepository::getByID($cellarID),

            'error' => ($request->session()->has('error')) ? $request->session()->get('error') : null,
            'confirmation' => ($request->session()->has('confirmation')) ? $request->session()->get('confirmation') : null,
        ]);
    }

    public function update_handler(Request $request)
    {
        parent::__construct($request);

        if ($request->get('technician_id') && !CellarRepository::checkTechnicianID($request->get('technician_id'))) {
            $request->session()->flash('error', trans('wine-supervisor::user_signup.technician_id_error'));
            return redirect()->back()->withInput();
        }

        if (CellarRepository::update(
            $request->get('cellar_id'),
            $this->getUserID(),
            null,
            $request->get('technician_id'),
            $request->get('name'),
            $request->get('subscription_type'),
            $request->get('serial_number'),
            $request->get('address'),
            $request->get('zipcode'),
            $request->get('city')
        )) {
            $request->session()->flash('confirmation', trans('wine-supervisor::cellar.cellar_update_success'));
        } else {
            $request->session()->flash('error', trans('wine-supervisor::cellar.cellar_update_error'));
        }

        return redirect()->route('user_cellar_list');
    }

    public function sav_handler(Request $request)
    {
        parent::__construct($request);

        if (!CellarRepository::checkIDWS($request->get('id_ws'))) {
            $request->session()->flash('error', trans('wine-supervisor::user_signup.id_ws_error'));
            return redirect()->back()->withInput();
        }

        if (CellarRepository::sav(
            $request->get('cellar_id'),
            $this->getUserID(),
            $request->get('id_ws')
        )) {
            $request->session()->flash('confirmation', trans('wine-supervisor::cellar.cellar_sav_success'));
        } else {
            $request->session()->flash('error', trans('wine-supervisor::cellar.cellar_sav_error'));
        }

        return redirect()->route('user_cellar_list');
    }

    public function delete_handler(Request $request, $cellarID)
    {
        parent::__construct($request);

        $boardType = ($request->get('reason') == 'board_out_of_order') ? WS::OUT_OF_ORDER_BOARD : WS::OTHER_BOARD;

        if (CellarRepository::delete($cellarID, $boardType)) {
            $request->session()->flash('confirmation', trans('wine-supervisor::cellar.cellar_deletion_success'));
        } else {
            $request->session()->flash('error', trans('wine-supervisor::cellar.cellar_deletion_error'));
        }

        return redirect()->route('user_cellar_list');
    }
}