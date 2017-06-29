<?php

namespace Webaccess\WineSupervisorLaravel\Http\Controllers\User;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Ramsey\Uuid\Uuid;
use Webaccess\WineSupervisorLaravel\Repositories\UserRepository;

class AccountController extends UserController
{
    public function update(Request $request)
    {
        parent::__construct($request);

        return view('wine-supervisor::pages.user.account.update', [
            'user' => UserRepository::getByID($this->getUserID()),

            'error' => ($request->session()->has('error')) ? $request->session()->get('error') : null,
            'confirmation' => ($request->session()->has('confirmation')) ? $request->session()->get('confirmation') : null,
        ]);
    }

    public function update_handler(Request $request)
    {
        parent::__construct($request);

        $requestID = Uuid::uuid4()->toString();

        Log::info('USER_UPDATE_ACCOUNT_REQUEST', [
            'id' => $requestID,
            'user_id' => $this->getUserID(),
            'first_name' => $request->get('first_name'),
            'last_name' => $request->get('last_name'),
            'email' => $request->get('email'),
            'login' => $request->get('login'),
            'opt_in' => $request->get('opt_in'),
        ]);

        list($success, $error) = UserRepository::update(
            $this->getUserID(),
            $request->get('first_name'),
            $request->get('last_name'),
            $request->get('email'),
            $request->get('login'),
            $request->get('password') ? $request->get('password') : null,
            $request->get('opt_in') == '1' ? true : false
        );

        if (!$success) {
            $request->session()->flash('error', trans('wine-supervisor::user.user_update_error'));

            Log::info('USER_UPDATE_ACCOUNT_RESPONSE', [
                'id' => $requestID,
                'error' => $error,
                'success' => false
            ]);

            return redirect()->back()->withInput();
        }

        $request->session()->flash('confirmation', trans('wine-supervisor::user.user_update_success'));

        Log::info('USER_UPDATE_ACCOUNT_RESPONSE', [
            'id' => $requestID,
            'success' => true
        ]);

        return redirect()->route('user_update_account');
    }
}