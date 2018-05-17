<?php

namespace Webaccess\WineSupervisorLaravel\Http\Controllers\Admin;

use DateTime;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Webaccess\WineSupervisorLaravel\Models\Subscription;
use Webaccess\WineSupervisorLaravel\Models\Technician;
use Webaccess\WineSupervisorLaravel\Models\User;
use Webaccess\WineSupervisorLaravel\Repositories\CellarRepository;
use Webaccess\WineSupervisorLaravel\Repositories\ContentRepository;
use Webaccess\WineSupervisorLaravel\Repositories\GuestRepository;
use Webaccess\WineSupervisorLaravel\Repositories\TechnicianRepository;
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

        if ($filters['user_filter_standard'] === 'true') {
            foreach (UserRepository::getAll() as $user) {
                if ($cellars = CellarRepository::getByUser($user->id)) {
                    foreach ($cellars as $cellar) {
                        if ($cellar->subscription_type == Subscription::DEFAULT_SUBSCRIPTION) {
                            if ($user->opt_in == true) {
                                $emails[]= $user->email;
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
                            }
                        }
                    }
                }
            }
        }

        if ($filters['technician_filter_cellar_yes'] === 'true') {
            foreach (TechnicianRepository::getAll() as $technician) {
                $hasCellarAttached = false;
                if ($cellars = CellarRepository::getByTechnician($technician->id)) {
                    foreach ($cellars as $cellar) {
                        if ($cellar->subscription_type != Subscription::NO_SUBSCRIPTION) {
                            if (new DateTime() >= new DateTime($cellar->subscription_start_date) && new DateTime() <= new DateTime($cellar->subscription_end_date)) {
                                $hasCellarAttached = true;
                            }
                        }
                    }
                }

                if ($hasCellarAttached && $technician->opt_in == true) {
                    $emails[]= $technician->email;
                }
            }
        }

        if ($filters['technician_filter_cellar_no'] === 'true') {
            foreach (TechnicianRepository::getAll() as $technician) {
                $hasCellarAttached = false;
                if ($cellars = CellarRepository::getByTechnician($technician->id)) {
                    foreach ($cellars as $cellar) {
                        if ($cellar->subscription_type != Subscription::NO_SUBSCRIPTION) {
                            if (new DateTime() >= new DateTime($cellar->subscription_start_date) && new DateTime() <= new DateTime($cellar->subscription_end_date)) {
                                $hasCellarAttached = true;
                            }
                        }
                    }
                }

                if (!$hasCellarAttached && $technician->opt_in == true) {
                    $emails[]= $technician->email;
                }
            }
        }

        if ($filters['technician_filter_status_yes'] === 'true') {
            foreach (TechnicianRepository::getAll() as $technician) {
                if ($technician->status == Technician::STATUS_ENABLED) {
                    if ($technician->opt_in == true) {
                        $emails[]= $technician->email;
                    }
                }
            }
        }

        if ($filters['technician_filter_status_no'] === 'true') {
            foreach (TechnicianRepository::getAll() as $technician) {
                if ($technician->status == Technician::STATUS_DISABLED) {
                    if ($technician->opt_in == true) {
                        $emails[]= $technician->email;
                    }
                }
            }
        }

        if ($filters['guest_filter_access_yes'] == 'true') {
            foreach (GuestRepository::getAll() as $guest) {
                $now = (new DateTime())->setTime(0, 0, 0);
                if ($now >= new DateTime($guest->access_start_date) && $now <= new DateTime($guest->access_end_date) && $guest->opt_in == true) {
                    $emails[]= $guest->email;
                }
            }
        }

        if ($filters['guest_filter_access_no'] == 'true') {
            foreach (GuestRepository::getAll() as $guest) {
                $now = (new DateTime())->setTime(0, 0, 0);
                if (($now < new DateTime($guest->access_start_date) || $now > new DateTime($guest->access_end_date)) && $guest->opt_in == true) {
                    $emails[]= $guest->email;
                }
            }
        }

        $emails = array_unique($emails);

        return response()->json([
            'emails' => $emails,
        ]);
    }

    public function send_test_email(Request $request) {
        $email = $request->email;

        Mail::send('wine-supervisor::emails.mailing_test', array('text' => $request->text, 'text_en' => $request->text_en), function ($message) use ($email) {
            $message->to($email)
                ->subject('[WineSupervisor] Test de mailing');
        });
    }
}