<?php

namespace Webaccess\WineSupervisorLaravel\Http\Controllers\Admin;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Ramsey\Uuid\Uuid;
use Webaccess\WineSupervisorLaravel\Repositories\WSRepository;

class WSController extends AdminController
{
    public function index(Request $request)
    {
        parent::__construct($request);

        return view('wine-supervisor::pages.admin.ws.index', [
            'wss' => WSRepository::getAll(),

            'error' => ($request->session()->has('error')) ? $request->session()->get('error') : null,
            'confirmation' => ($request->session()->has('confirmation')) ? $request->session()->get('confirmation') : null,
        ]);
    }

    public function update(Request $request, $wsID) {

        parent::__construct($request);

        return view('wine-supervisor::pages.admin.ws.update', [
            'ws' => WSRepository::getByID($wsID),

            'error' => ($request->session()->has('error')) ? $request->session()->get('error') : null,
            'confirmation' => ($request->session()->has('confirmation')) ? $request->session()->get('confirmation') : null,
        ]);
    }

    public function update_handler(Request $request)
    {
        parent::__construct($request);

        $requestID = Uuid::uuid4()->toString();

        Log::info('ADMIN_UPDATE_WS_REQUEST', [
            'id' => $requestID,
            'admin_id' => $this->getAdministratorID(),
            'ws_id' => $request->get('ws_id'),
            'board_type' => $request->get('board_type'),
        ]);

        list($success, $error) = WSRepository::update(
            $request->get('ws_id'),
            $request->get('board_type')
        );

        if (!$success) {
            $request->session()->flash('error', trans('wine-supervisor::admin.ws_update_error'));

            Log::info('ADMIN_UPDATE_WS_RESPONSE', [
                'id' => $requestID,
                'error' => $error,
                'success' => false
            ]);

            return redirect()->back()->withInput();
        }

        $request->session()->flash('confirmation', trans('wine-supervisor::admin.ws_update_success'));

        Log::info('ADMIN_UPDATE_WS_RESPONSE', [
            'id' => $requestID,
            'success' => true
        ]);

        return redirect()->route('admin_ws_list');
    }
}