<?php

namespace Webaccess\WineSupervisorLaravel\Http\Controllers\Admin;

use Illuminate\Http\Request;
use Webaccess\WineSupervisorLaravel\Services\GuestManager;

class GuestController extends AdminController
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

        if (!GuestManager::checkLogin(null, $request->get('login'))) {
            $request->session()->flash('error', trans('wine-supervisor::admin.guest_existing_login_error'));
            return redirect()->back()->withInput();
        }

        if (GuestManager::create(
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
        )) {
            $request->session()->flash('confirmation', trans('wine-supervisor::admin.guest_create_success'));
        } else {
            $request->session()->flash('error', trans('wine-supervisor::admin.guest_create_error'));
        }

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

        if (!GuestManager::checkLogin($request->get('guest_id'), $request->get('login'))) {
            $request->session()->flash('error', trans('wine-supervisor::admin.guest_existing_login_error'));
            return redirect()->back()->withInput();
        }

        if (GuestManager::update(
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
        )) {
            $request->session()->flash('confirmation', trans('wine-supervisor::admin.guest_update_success'));
        } else {
            $request->session()->flash('error', trans('wine-supervisor::admin.guest_update_error'));
        }

        return redirect()->route('admin_guest_list');
    }

    public function delete_handler(Request $request, $guestID)
    {
        parent::__construct($request);

        if (GuestManager::delete($guestID)) {
            $request->session()->flash('confirmation', trans('wine-supervisor::admin.guest_delete_success'));
        } else {
            $request->session()->flash('error', trans('wine-supervisor::admin.guest_delete_error'));
        }

        return redirect()->route('admin_guest_list');
    }
}