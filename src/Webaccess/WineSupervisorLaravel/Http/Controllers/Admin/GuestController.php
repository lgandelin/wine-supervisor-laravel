<?php

namespace Webaccess\WineSupervisorLaravel\Http\Controllers\Admin;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Ramsey\Uuid\Uuid;
use Webaccess\WineSupervisorLaravel\Repositories\GuestRepository;

class GuestController extends AdminController
{
    public function index(Request $request)
    {
        parent::__construct($request);

        return view('wine-supervisor::pages.admin.guest.index', [
            'guests' => GuestRepository::getAll(),

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

        $requestID = Uuid::uuid4()->toString();

        Log::info('ADMIN_CREATE_GUEST_REQUEST', [
            'id' => $requestID,
            'admin_id' => $this->getAdministratorID(),
            'first_name' => $request->get('first_name'),
            'last_name' => $request->get('last_name'),
            'access_start_date' => \DateTime::createFromformat('d/m/Y', $request->get('access_start_date'))->format('Y-m-d'),
            'access_end_date' => \DateTime::createFromformat('d/m/Y', $request->get('access_end_date'))->format('Y-m-d'),
            'login' => $request->get('login'),
            'email' => $request->get('email'),
            'phone' => $request->get('phone'),
            'address' => $request->get('address'),
            'zipcode' => $request->get('zipcode'),
            'city' => $request->get('city')
        ]);

        list($success, $error) = GuestRepository::create(
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

        if (!$success) {
            $request->session()->flash('error', trans('wine-supervisor::admin.guest_create_error'));

            Log::info('ADMIN_CREATE_GUEST_RESPONSE', [
                'id' => $requestID,
                'error' => $error,
                'success' => false
            ]);

            return redirect()->back()->withInput();
        }

        $request->session()->flash('confirmation', trans('wine-supervisor::admin.guest_create_success'));

        Log::info('ADMIN_CREATE_GUEST_RESPONSE', [
            'id' => $requestID,
            'success' => true
        ]);

        return redirect()->route('admin_guest_list');
    }

    public function update(Request $request, $guestID) {

        parent::__construct($request);

        return view('wine-supervisor::pages.admin.guest.update', [
            'guest' => GuestRepository::getByID($guestID),

            'error' => ($request->session()->has('error')) ? $request->session()->get('error') : null,
            'confirmation' => ($request->session()->has('confirmation')) ? $request->session()->get('confirmation') : null,
        ]);
    }

    public function update_handler(Request $request)
    {
        parent::__construct($request);

        $requestID = Uuid::uuid4()->toString();

        Log::info('ADMIN_UPDATE_GUEST_REQUEST', [
            'id' => $requestID,
            'guest_id' => $request->get('guest_id'),
            'admin_id' => $this->getAdministratorID(),
            'first_name' => $request->get('first_name'),
            'last_name' => $request->get('last_name'),
            'access_start_date' => \DateTime::createFromformat('d/m/Y', $request->get('access_start_date'))->format('Y-m-d'),
            'access_end_date' => \DateTime::createFromformat('d/m/Y', $request->get('access_end_date'))->format('Y-m-d'),
            'login' => $request->get('login'),
            'email' => $request->get('email'),
            'phone' => $request->get('phone'),
            'address' => $request->get('address'),
            'zipcode' => $request->get('zipcode'),
            'city' => $request->get('city')
        ]);

        list($success, $error) = GuestRepository::update(
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

        if (!$success) {
            $request->session()->flash('error', trans('wine-supervisor::admin.guest_update_error'));

            Log::info('ADMIN_UPDATE_GUEST_RESPONSE', [
                'id' => $requestID,
                'error' => $error,
                'success' => false
            ]);

            return redirect()->back()->withInput();
        }

        $request->session()->flash('confirmation', trans('wine-supervisor::admin.guest_update_success'));

        Log::info('ADMIN_UPDATE_GUEST_RESPONSE', [
            'id' => $requestID,
            'success' => true
        ]);

        return redirect()->route('admin_guest_list');
    }

    public function delete_handler(Request $request, $guestID)
    {
        parent::__construct($request);

        $requestID = Uuid::uuid4()->toString();

        Log::info('ADMIN_DELETE_GUEST_REQUEST', [
            'id' => $requestID,
            'guest_id' => $request->get('guest_id'),
            'admin_id' => $this->getAdministratorID(),
        ]);

        list ($success, $error) = GuestRepository::delete($guestID);

        if (!$success) {
            $request->session()->flash('error', trans('wine-supervisor::admin.guest_delete_error'));

            Log::info('ADMIN_DELETE_GUEST_RESPONSE', [
                'id' => $requestID,
                'error' => $error,
                'success' => false
            ]);

            return redirect()->back()->withInput();
        }

        $request->session()->flash('confirmation', trans('wine-supervisor::admin.guest_delete_success'));

        Log::info('ADMIN_DELETE_GUEST_RESPONSE', [
            'id' => $requestID,
            'success' => true
        ]);

        return redirect()->route('admin_guest_list');
    }
}