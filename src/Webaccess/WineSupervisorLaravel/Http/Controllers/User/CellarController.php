<?php

namespace Webaccess\WineSupervisorLaravel\Http\Controllers\User;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Webaccess\WineSupervisorLaravel\Http\Controllers\BaseController;
use Webaccess\WineSupervisorLaravel\Models\Subscription;
use Webaccess\WineSupervisorLaravel\Models\WS;
use Webaccess\WineSupervisorLaravel\Services\CellarManager;

class CellarController extends BaseController
{
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

        if (!CellarManager::checkIDWS($request->get('id_ws'))) {
            $request->session()->flash('error', trans('wine-supervisor::user_signup.id_ws_error'));
            return redirect()->back()->withInput();
        }

        if ($request->get('technician_id') && !CellarManager::checkTechnicianID($request->get('technician_id'))) {
            $request->session()->flash('error', trans('wine-supervisor::user_signup.technician_id_error'));
            return redirect()->back()->withInput();
        }

        CellarManager::create(
            Auth::guards('users')->getUser()->id,
            $request->get('id_ws'),
            $request->get('technician_id'),
            $request->get('name'),
            Subscription::DEFAULT_SUBSCRIPTION, //TODO : HANDLE DIFFERENT SUBSCRIPTION TYPES
            $request->get('serial_number'),
            $request->get('address'),
            $request->get('zipcode'),
            $request->get('city')
        );

        //Call CDO webservice
        //TODO : CALL CDO

        $request->session()->flash('confirmation', trans('wine-supervisor::cellar.cellar_creation_success'));
        return redirect()->route('user_index');
    }

    public function update(Request $request, $cellarID)
    {
        parent::__construct($request);

        return view('wine-supervisor::pages.user.cellar.update', [
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

        CellarManager::update(
            $request->get('cellar_id'),
            Auth::guard('users')->getUser()->id,
            null,
            $request->get('technician_id'),
            $request->get('name'),
            Subscription::DEFAULT_SUBSCRIPTION, //TODO : HANDLE DIFFERENT SUBSCRIPTION TYPES
            $request->get('serial_number'),
            $request->get('address'),
            $request->get('zipcode'),
            $request->get('city')
        );

        //Call CDO webservice
        //TODO : CALL CDO

        $request->session()->flash('confirmation', trans('wine-supervisor::cellar.cellar_update_success'));
        return redirect()->route('user_index');
    }

    public function sav_handler(Request $request)
    {
        parent::__construct($request);

        if (!CellarManager::checkIDWS($request->get('id_ws'))) {
            $request->session()->flash('error', trans('wine-supervisor::user_signup.id_ws_error'));
            return redirect()->back()->withInput();
        }

        CellarManager::sav(
            $request->get('cellar_id'),
            Auth::guard('users')->getUser()->id,
            $request->get('id_ws')
        );

        //Call CDO webservice
        //TODO : CALL CDO

        $request->session()->flash('confirmation', trans('wine-supervisor::cellar.cellar_sav_success'));

        return redirect()->route('user_index');
    }

    public function delete_handler(Request $request, $cellarID)
    {
        parent::__construct($request);

        $boardType = ($request->get('reason') == 'board_out_of_order') ? WS::OUT_OF_ORDER_BOARD : WS::OTHER_BOARD;

        CellarManager::delete($cellarID, $boardType);

        //Call CDO webservice
        //TODO : CALL CDO ?

        $request->session()->flash('confirmation', trans('wine-supervisor::cellar.cellar_deletion_success'));
        return redirect()->route('user_index');
    }
}