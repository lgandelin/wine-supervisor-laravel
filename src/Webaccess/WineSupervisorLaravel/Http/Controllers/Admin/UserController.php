<?php

namespace Webaccess\WineSupervisorLaravel\Http\Controllers\Admin;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use Ramsey\Uuid\Uuid;
use Webaccess\WineSupervisorLaravel\Repositories\CellarRepository;
use Webaccess\WineSupervisorLaravel\Repositories\UserRepository;

class UserController extends AdminController
{
    public function index(Request $request)
    {
        parent::__construct($request);

        return view('wine-supervisor::pages.admin.user.index', [
            'users' => UserRepository::getAll($request->get('sc'), $request->get('so')),
            'sort_column' => $request->get('sc'),
            'sort_order' => ($request->get('so') == 'asc') ? 'desc' : 'asc',

            'error' => ($request->session()->has('error')) ? $request->session()->get('error') : null,
            'confirmation' => ($request->session()->has('confirmation')) ? $request->session()->get('confirmation') : null,
        ]);
    }

    public function update(Request $request, $userID) {

        parent::__construct($request);

        return view('wine-supervisor::pages.admin.user.update', [
            'user' => UserRepository::getByID($userID),
            'cellars' => CellarRepository::getByUser($userID),

            'error' => ($request->session()->has('error')) ? $request->session()->get('error') : null,
            'confirmation' => ($request->session()->has('confirmation')) ? $request->session()->get('confirmation') : null,
        ]);
    }

    public function delete_handler(Request $request, $userID)
    {
        parent::__construct($request);

        $requestID = Uuid::uuid4()->toString();

        Log::info('ADMIN_DELETE_USER_REQUEST', [
            'id' => $requestID,
            'user_id' => $request->get('user_id'),
            'admin_id' => $this->getAdministratorID(),
        ]);

        list ($success, $error) = UserRepository::delete($userID, null);

        if (!$success) {
            $request->session()->flash('error', trans('wine-supervisor::user.user_delete_error'));

            Log::info('ADMIN_DELETE_USER_RESPONSE', [
                'id' => $requestID,
                'error' => $error,
                'success' => false
            ]);

            return redirect()->back()->withInput();
        }

        $request->session()->flash('confirmation', trans('wine-supervisor::user.user_delete_success'));

        Log::info('ADMIN_DELETE_USER_RESPONSE', [
            'id' => $requestID,
            'success' => true
        ]);

        return redirect()->route('admin_user_list');
    }
}