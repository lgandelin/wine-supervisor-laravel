<?php

namespace Webaccess\WineSupervisorLaravel\Http\Controllers\Admin;

use Illuminate\Http\Request;
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

        if (WSRepository::update(
            $request->get('ws_id'),
            $request->get('board_type')
        )) {
            $request->session()->flash('confirmation', trans('wine-supervisor::admin.ws_update_success'));
        } else {
            $request->session()->flash('error', trans('wine-supervisor::admin.ws_update_error'));
        }

        return redirect()->route('admin_ws_list');
    }
}