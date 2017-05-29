<?php

namespace Webaccess\WineSupervisorLaravel\Http\Controllers\User;

use Illuminate\Http\Request;
use Webaccess\WineSupervisorLaravel\Http\Controllers\BaseController;
use Webaccess\WineSupervisorLaravel\Models\Board;
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
            return redirect()->route('user_signup_cellar');
        }

        CellarManager::create(
            $this->getUser()->id,
            $request->get('id_ws'),
            $request->get('technician_id'),
            $request->get('name'),
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

    public function delete_handler(Request $request, $cellarID)
    {
        parent::__construct($request);

        //TODO : GET BOARD TYPE
        $boardType = Board::OUT_OF_ORDER_BOARD;

        CellarManager::delete($cellarID, $boardType);

        $request->session()->flash('confirmation', trans('wine-supervisor::cellar.cellar_deletion_success'));
        return redirect()->route('user_index');
    }
}