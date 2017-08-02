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
}