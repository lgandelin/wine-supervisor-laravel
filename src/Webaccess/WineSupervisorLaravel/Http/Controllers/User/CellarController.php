<?php

namespace Webaccess\WineSupervisorLaravel\Http\Controllers\User;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Ramsey\Uuid\Uuid;
use Webaccess\WineSupervisorLaravel\Models\Subscription;
use Webaccess\WineSupervisorLaravel\Models\WS;
use Webaccess\WineSupervisorLaravel\Repositories\CellarRepository;
use Webaccess\WineSupervisorLaravel\Repositories\WSRepository;

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

        $requestID = Uuid::uuid4()->toString();

        $idWS = WSRepository::getWSIDFromCDWSID($request->get('cd_ws_id'));

        list($checkSuccess, $checkError) = CellarRepository::doPreliminaryChecks($idWS, $request->get('technician_id'), $request->get('activation_code'));

        if (!$checkSuccess) {
            $request->session()->flash('error', $checkError);
            return redirect()->back()->withInput();
        }

        Log::info('USER_CREATE_CELLAR_REQUEST', [
            'id' => $requestID,
            'user_id' => $this->getUserID(),
            'id_ws' => $idWS,
            'cd_ws_id' => $request->get('cd_ws_id'),
            'technician_id' => $request->get('technician_id'),
            'name' => $request->get('name'),
            'serial_number' => $request->get('serial_number'),
            'address' => $request->get('address'),
            'address2' => $request->get('address2'),
            'zipcode' => $request->get('zipcode'),
            'city' => $request->get('city'),
            'country' => $request->get('country')
        ]);

        list($success, $error) = CellarRepository::create(
            $this->getUserID(),
            $idWS,
            $request->get('technician_id'),
            $request->get('name'),
            Subscription::DEFAULT_SUBSCRIPTION,
            $request->get('serial_number'),
            $request->get('address'),
            $request->get('address2'),
            $request->get('zipcode'),
            $request->get('city'),
            $request->get('country')
        );

        if (!$success) {
            $request->session()->flash('error', $error);

            Log::info('USER_CREATE_CELLAR_RESPONSE', [
                'id' => $requestID,
                'error' => $error,
                'success' => false
            ]);

            return redirect()->back()->withInput();
        }

        Log::info('USER_CREATE_CELLAR_RESPONSE', [
            'id' => $requestID,
            'success' => true
        ]);

        $request->session()->flash('confirmation', trans('wine-supervisor::cellar.cellar_creation_success'));

        return redirect()->route('user_update_account');
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

        $requestID = Uuid::uuid4()->toString();

        Log::info('USER_UPDATE_CELLAR_REQUEST', [
            'id' => $requestID,
            'cellar_id' => $request->get('cellar_id'),
            'user_id' => $this->getUserID(),
            'technician_id' => $request->get('technician_id'),
            'name' => $request->get('name'),
            'subscription_type' => $request->get('subscription_type'),
            'serial_number' => $request->get('serial_number'),
            'address' => $request->get('address'),
            'address2' => $request->get('address2'),
            'zipcode' => $request->get('zipcode'),
            'city' => $request->get('city'),
            'country' => $request->get('country')
        ]);

        list($success, $error) = CellarRepository::update(
            $request->get('cellar_id'),
            $this->getUserID(),
            null,
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
            $request->session()->flash('error', $error);

            Log::info('USER_UPDATE_CELLAR_RESPONSE', [
                'id' => $requestID,
                'error' => $error,
                'success' => false
            ]);

            return redirect()->back()->withInput();
        }

        $request->session()->flash('confirmation', trans('wine-supervisor::cellar.cellar_update_success'));

        Log::info('USER_UPDATE_CELLAR_RESPONSE', [
            'id' => $requestID,
            'success' => true
        ]);

        return redirect()->route('user_update_account');
    }

    public function sav_handler(Request $request)
    {
        parent::__construct($request);

        $requestID = Uuid::uuid4()->toString();

        Log::info('USER_SAV_CELLAR_REQUEST', [
            'id' => $requestID,
            'cellar_id' => $request->get('cellar_id'),
            'user_id' => $this->getUserID(),
            'cd_ws_id' => $request->get('cd_ws_id')
        ]);

        list($success, $error) = CellarRepository::sav(
            $request->get('cellar_id'),
            $this->getUserID(),
            $request->get('cd_ws_id')
        );

        if (!$success) {
            $request->session()->flash('error', $error);

            Log::info('USER_SAV_CELLAR_RESPONSE', [
                'id' => $requestID,
                'error' => $error,
                'success' => false
            ]);

            return redirect()->back()->withInput();
        }

        $request->session()->flash('confirmation', trans('wine-supervisor::cellar.cellar_sav_success'));

        Log::info('USER_SAV_CELLAR_RESPONSE', [
            'id' => $requestID,
            'success' => true
        ]);

        return redirect()->route('user_update_account');
    }

    public function delete_handler(Request $request)
    {
        parent::__construct($request);

        $boardType = null;
        switch($request->get('reason')) {
            case 'board_out_of_order':
                $boardType = WS::OUT_OF_ORDER_BOARD;
            break;
            case 'resell':
                $boardType = WS::DEUXIO_BOARD;
            break;
            default:
                $boardType = WS::RESELL_BOARD;
            break;
        }

        $requestID = Uuid::uuid4()->toString();

        $cellarID = $request->get('cellar_id');

        Log::info('USER_DELETE_CELLAR_REQUEST', [
            'id' => $requestID,
            'cellar_id' => $cellarID,
            'board_type' => $boardType,
        ]);

        list($success, $error) = CellarRepository::delete($cellarID, $boardType);

        if (!$success) {
            $request->session()->flash('error', trans('wine-supervisor::cellar.cellar_delete_error'));

            Log::info('USER_SAV_CELLAR_RESPONSE', [
                'id' => $requestID,
                'error' => $error,
                'success' => false
            ]);
        }

        $request->session()->flash('confirmation', trans('wine-supervisor::cellar.cellar_delete_success'));

        Log::info('USER_DELETE_CELLAR_RESPONSE', [
            'id' => $requestID,
            'success' => true
        ]);

        return redirect()->route('user_update_account');
    }
}