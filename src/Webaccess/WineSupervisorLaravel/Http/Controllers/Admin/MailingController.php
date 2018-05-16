<?php

namespace Webaccess\WineSupervisorLaravel\Http\Controllers\Admin;

use Illuminate\Http\Request;
use Webaccess\WineSupervisorLaravel\Models\Subscription;
use Webaccess\WineSupervisorLaravel\Models\User;
use Webaccess\WineSupervisorLaravel\Repositories\CellarRepository;
use Webaccess\WineSupervisorLaravel\Repositories\ContentRepository;
use Webaccess\WineSupervisorLaravel\Repositories\UserRepository;

class MailingController extends AdminController
{
    public function index(Request $request)
    {
        parent::__construct($request);

        return view('wine-supervisor::pages.admin.mailing.index', [
            'news_list' => ContentRepository::getAll(10),
            'error' => ($request->session()->has('error')) ? $request->session()->get('error') : null,
            'confirmation' => ($request->session()->has('confirmation')) ? $request->session()->get('confirmation') : null,
        ]);
    }

    public function get_emails(Request $request) {
        $emails = [];
        $filters = $request->filters;

        if ($filters['users_filter'] === 'true') {
            if ($filters['user_filter_standard'] === 'true') {
                foreach (UserRepository::getAll() as $user) {
                    if ($cellars = CellarRepository::getByUser($user->id)) {
                        foreach ($cellars as $cellar) {
                            if ($cellar->subscription_type == Subscription::DEFAULT_SUBSCRIPTION) {
                                if ($user->opt_in == true) {
                                    $emails[]= $user->email;
                                    break;
                                }
                            }
                        }
                    }
                }
            }

            if ($filters['user_filter_premium'] === 'true') {
                foreach (UserRepository::getAll() as $user) {
                    if ($cellars = CellarRepository::getByUser($user->id)) {
                        foreach ($cellars as $cellar) {
                            if ($cellar->subscription_type == Subscription::PREMIUM_SUBSCRIPTION) {
                                if ($user->opt_in == true) {
                                    $emails[]= $user->email;
                                    break;
                                }
                            }
                        }
                    }
                }
            }

            if ($filters['user_filter_free'] === 'true') {
                foreach (UserRepository::getAll() as $user) {
                    if ($cellars = CellarRepository::getByUser($user->id)) {
                        foreach ($cellars as $cellar) {
                            if ($cellar->subscription_type == Subscription::FREE_SUBSCRIPTION) {
                                if ($user->opt_in == true) {
                                    $emails[]= $user->email;
                                    break;
                                }
                            }
                        }
                    }
                }
            }

            if ($filters['user_filter_standard'] === 'false' && $filters['user_filter_premium'] === 'false' && $filters['user_filter_free'] === 'false' ) {
                $emails[] = User::where('opt_in', '=', true)->pluck('email');
            }
        }

        if ($filters['technicians_filter'] == 1) {

        }

        if ($filters['guests_filter'] == 1) {

        }

        dd($emails);

        return response()->json([
            'emails' => array_unique($emails),
        ]);
    }
}