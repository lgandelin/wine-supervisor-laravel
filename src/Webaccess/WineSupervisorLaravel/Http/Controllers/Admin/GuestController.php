<?php

namespace Webaccess\WineSupervisorLaravel\Http\Controllers\Admin;

use Illuminate\Http\Request;
use Webaccess\WineSupervisorLaravel\Http\Controllers\BaseController;
use Webaccess\WineSupervisorLaravel\Services\GuestManager;

class GuestController extends BaseController
{
    public function index(Request $request)
    {
        parent::__construct($request);

        return view('wine-supervisor::pages.admin.guest.index', [
            'guests' => GuestManager::getAll(),

            'error' => ($request->session()->has('error')) ? $request->session()->get('error') : null,
            'confirmation' => ($request->session()->has('confirmation')) ? $request->session()->get('confirmation') : null,
        ]);
    }

    public function create(Request $request) {

        parent::__construct($request);

        return view('wine-supervisor::pages.admin.guest.create', [
            'error' => ($request->session()->has('error')) ? $request->session()->get('error') : null,
            'confirmation' => ($request->session()->has('confirmation')) ? $request->session()->get('confirmation') : null,
        ]);
    }

    public function create_handler(Request $request)
    {
        parent::__construct($request);

        GuestManager::create(
            $request->get('first_name'),
            $request->get('last_name'),
            \DateTime::createFromformat('d/m/Y', $request->get('access_start_date'))->format('Y-m-d'),
            \DateTime::createFromformat('d/m/Y', $request->get('access_end_date'))->format('Y-m-d'),
            $request->get('login'),
            $request->get('password'),
            $request->get('email'),
            $request->get('phone'),
            $request->get('address'),
            $request->get('zipcode'),
            $request->get('city')
        );

        $request->session()->flash('confirmation', trans('wine-supervisor::admin.guest_create_success'));

        return redirect()->route('admin_guest_list');
    }

    public function update(Request $request, $guestID) {

        parent::__construct($request);

        return view('wine-supervisor::pages.admin.guest.update', [
            'guest' => GuestManager::getByID($guestID),

            'error' => ($request->session()->has('error')) ? $request->session()->get('error') : null,
            'confirmation' => ($request->session()->has('confirmation')) ? $request->session()->get('confirmation') : null,
        ]);
    }

    public function update_handler(Request $request)
    {
        parent::__construct($request);

        GuestManager::update(
            $request->get('guest_id'),
            $request->get('first_name'),
            $request->get('last_name'),
            \DateTime::createFromformat('d/m/Y', $request->get('access_start_date'))->format('Y-m-d'),
            \DateTime::createFromformat('d/m/Y', $request->get('access_end_date'))->format('Y-m-d'),
            $request->get('login'),
            $request->get('password') ? $request->get('password') : null,
            $request->get('email'),
            $request->get('phone'),
            $request->get('address'),
            $request->get('zipcode'),
            $request->get('city')
        );

        $request->session()->flash('confirmation', trans('wine-supervisor::admin.guest_update_success'));

        return redirect()->route('admin_guest_list');
    }
}