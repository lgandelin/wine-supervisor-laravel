<?php

namespace Webaccess\WineSupervisorLaravel\Http\Controllers\Admin;

use DateTime;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
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

        if ($request->get('password') != $request->get('password_confirm')) {
            $request->session()->flash('error', trans('wine-supervisor::signup.user_password_confirmation'));
            return redirect()->back()->withInput();
        }

        $startDate = DateTime::createFromformat('d/m/Y', $request->get('access_start_date'));
        $endDate = DateTime::createFromformat('d/m/Y', $request->get('access_end_date'));

        Log::info('ADMIN_CREATE_GUEST_REQUEST', [
            'id' => $requestID,
            'admin_id' => $this->getAdministratorID(),
            'first_name' => $request->get('first_name'),
            'last_name' => $request->get('last_name'),
            'access_start_date' => $request->get('access_start_date') ? $startDate->format('Y-m-d') : null,
            'access_end_date' => $request->get('access_end_date') ? $endDate->format('Y-m-d') : null,
            'login' => $request->get('login'),
            'email' => $request->get('email'),
            'phone' => $request->get('phone'),
            'company' => $request->get('company'),
            'address' => $request->get('address'),
            'address2' => $request->get('address2'),
            'zipcode' => $request->get('zipcode'),
            'city' => $request->get('city'),
            'country' => $request->get('country')
        ]);

        list($success, $error) = GuestRepository::create(
            $request->get('first_name'),
            $request->get('last_name'),
            $request->get('access_start_date') ? $startDate->format('Y-m-d') : null,
            $request->get('access_end_date') ? $endDate->format('Y-m-d') : null,
            $request->get('login'),
            $request->get('password'),
            $request->get('email'),
            $request->get('phone'),
            $request->get('company'),
            $request->get('address'),
            $request->get('address2'),
            $request->get('zipcode'),
            $request->get('city'),
            $request->get('country')
        );

        if (!$success) {
            $request->session()->flash('error', trans('wine-supervisor::guest.guest_create_error'));

            Log::info('ADMIN_CREATE_GUEST_RESPONSE', [
                'id' => $requestID,
                'error' => $error,
                'success' => false
            ]);

            return redirect()->back()->withInput();
        }

        Log::info('ADMIN_CREATE_GUEST_RESPONSE', [
            'id' => $requestID,
            'success' => true
        ]);

        $guestEmail = $request->get('email');
        $login = $request->get('login');
        $password = $request->get('password');
        $urlClubPremium = route('club_premium');

        try {
            Mail::send('wine-supervisor::emails.guest_account', array(
                'login' => $login,
                'password' => $password,
                'urlClubPremium' => $urlClubPremium,
                'startDate' => $startDate,
                'endDate' => $endDate
            ), function ($message) use ($guestEmail) {
                $message->to($guestEmail)
                    ->subject('[WineSupervisor] Votre accès au Club Avantage');
            });
            $request->session()->flash('confirmation', trans('wine-supervisor::guest.guest_create_success'));

            Log::info('ADMIN_CREATE_GUEST_EMAIL_SEND_RESPONSE', [
                'id' => $requestID,
                'guest_email' => $guestEmail,
                'success' => true
            ]);
        } catch (\Exception $e) {
            $request->session()->flash('error', trans('wine-supervisor::guest.guest_create_email_error'));

            Log::info('ADMIN_CREATE_GUEST_EMAIL_SEND_RESPONSE', [
                'id' => $requestID,
                'guest_email' => $guestEmail,
                'error' => $e->getMessage(),
                'success' => false
            ]);
        }

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

        if ($request->get('password') != $request->get('password_confirm')) {
            $request->session()->flash('error', trans('wine-supervisor::signup.user_password_confirmation'));
            return redirect()->back()->withInput();
        }

        $startDate = DateTime::createFromformat('d/m/Y', $request->get('access_start_date'));
        $endDate = DateTime::createFromformat('d/m/Y', $request->get('access_end_date'));

        Log::info('ADMIN_UPDATE_GUEST_REQUEST', [
            'id' => $requestID,
            'guest_id' => $request->get('guest_id'),
            'admin_id' => $this->getAdministratorID(),
            'first_name' => $request->get('first_name'),
            'last_name' => $request->get('last_name'),
            'access_start_date' => $request->get('access_start_date') ? $startDate->format('Y-m-d') : null,
            'access_end_date' => $request->get('access_end_date') ? $endDate->format('Y-m-d') : null,
            'login' => $request->get('login'),
            'email' => $request->get('email'),
            'phone' => $request->get('phone'),
            'company' => $request->get('company'),
            'address' => $request->get('address'),
            'address' => $request->get('address2'),
            'zipcode' => $request->get('zipcode'),
            'city' => $request->get('city'),
            'country' => $request->get('country')
        ]);

        //Fetch the old login and password
        $emailNeeded = false;
        $loginUpdated = false;
        $passwordUpdated = false;
        if ($guest = GuestRepository::getByID($request->get('guest_id'))) {
            if ($guest->login != $request->get('login')) {
                $loginUpdated = true;
                $emailNeeded = true;
            }

            if ($request->get('password') != "********" && $guest->password != Hash::make($request->get('password'))) {
                $passwordUpdated = true;
                $emailNeeded = true;
            }
        }

        list($success, $error) = GuestRepository::update(
            $request->get('guest_id'),
            $request->get('first_name'),
            $request->get('last_name'),
            $request->get('access_start_date') ? $startDate->format('Y-m-d') : null,
            $request->get('access_end_date') ? $endDate->format('Y-m-d') : null,
            $request->get('login'),
            $request->get('password') != "********" ? $request->get('password') : null,
            $request->get('email'),
            $request->get('phone'),
            $request->get('company'),
            $request->get('address'),
            $request->get('address2'),
            $request->get('zipcode'),
            $request->get('city'),
            $request->get('country')
        );

        if (!$success) {
            $request->session()->flash('error', trans('wine-supervisor::guest.guest_update_error'));

            Log::info('ADMIN_UPDATE_GUEST_RESPONSE', [
                'id' => $requestID,
                'error' => $error,
                'success' => false
            ]);

            return redirect()->back()->withInput();
        }

        $request->session()->flash('confirmation', trans('wine-supervisor::guest.guest_update_success'));

        Log::info('ADMIN_UPDATE_GUEST_RESPONSE', [
            'id' => $requestID,
            'success' => true
        ]);

        if ($emailNeeded) {
            $guestEmail = $request->get('email');
            $login = $request->get('login');
            $password = $request->get('password');
            $urlClubPremium = route('club_premium');

            try {
                Mail::send('wine-supervisor::emails.guest_account_updated', array(
                    'login' => $login,
                    'password' => $password,
                    'urlClubPremium' => $urlClubPremium,
                    'startDate' => $startDate,
                    'endDate' => $endDate,
                    'loginUpdated' => $loginUpdated,
                    'passwordUpdated' => $passwordUpdated
                ), function ($message) use ($guestEmail) {
                    $message->to($guestEmail)
                        ->subject('[WineSupervisor] Votre accès au Club Avantage a été modifié');
                });
                $request->session()->flash('confirmation', trans('wine-supervisor::guest.guest_create_success'));

                Log::info('ADMIN_UPDATE_GUEST_EMAIL_SEND_RESPONSE', [
                    'id' => $requestID,
                    'guest_email' => $guestEmail,
                    'success' => true
                ]);
            } catch (\Exception $e) {
                $request->session()->flash('error', trans('wine-supervisor::guest.guest_create_email_error'));

                Log::info('ADMIN_UPDATE_GUEST_EMAIL_SEND_RESPONSE', [
                    'id' => $requestID,
                    'guest_email' => $guestEmail,
                    'error' => $e->getMessage(),
                    'success' => false
                ]);
            }
        }

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
            $request->session()->flash('error', trans('wine-supervisor::guest.guest_delete_error'));

            Log::info('ADMIN_DELETE_GUEST_RESPONSE', [
                'id' => $requestID,
                'error' => $error,
                'success' => false
            ]);

            return redirect()->back()->withInput();
        }

        $request->session()->flash('confirmation', trans('wine-supervisor::guest.guest_delete_success'));

        Log::info('ADMIN_DELETE_GUEST_RESPONSE', [
            'id' => $requestID,
            'success' => true
        ]);

        return redirect()->route('admin_guest_list');
    }
}