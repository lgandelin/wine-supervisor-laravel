<?php

namespace Webaccess\WineSupervisorLaravel\Http\Controllers\Admin;

use DateTime;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Webaccess\WineSupervisorLaravel\Jobs\SendMailingJob;
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
        $emails['fr'] = [];
        $emails['en'] = [];
        
        $filters = $request->filters;

        if ($filters['user_filter_standard'] === 'true') {
            foreach (UserRepository::getAll() as $user) {
                if ($cellars = CellarRepository::getByUser($user->id)) {
                    foreach ($cellars as $cellar) {
                        if ($cellar->subscription_type == Subscription::DEFAULT_SUBSCRIPTION) {
                            if ($user->opt_in == true) {
                                $emails[UserRepository::getLangForMailing($user)][]= $user->email;
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
                                $emails[UserRepository::getLangForMailing($user)][]= $user->email;
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
                                $emails[UserRepository::getLangForMailing($user)][]= $user->email;
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
                    $emails[UserRepository::getLangForMailing($technician)][]= $technician->email;
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
                    $emails[UserRepository::getLangForMailing($technician)][]= $technician->email;
                }
            }
        }

        if ($filters['technician_filter_status_yes'] === 'true') {
            foreach (TechnicianRepository::getAll() as $technician) {
                if ($technician->status == Technician::STATUS_ENABLED) {
                    if ($technician->opt_in == true) {
                        $emails[UserRepository::getLangForMailing($technician)][]= $technician->email;
                    }
                }
            }
        }

        if ($filters['technician_filter_status_no'] === 'true') {
            foreach (TechnicianRepository::getAll() as $technician) {
                if ($technician->status == Technician::STATUS_DISABLED) {
                    if ($technician->opt_in == true) {
                        $emails[UserRepository::getLangForMailing($technician)][]= $technician->email;
                    }
                }
            }
        }

        if ($filters['guest_filter_access_yes'] == 'true') {
            foreach (GuestRepository::getAll() as $guest) {
                $now = (new DateTime())->setTime(0, 0, 0);
                if ($now >= new DateTime($guest->access_start_date) && $now <= new DateTime($guest->access_end_date) && $guest->opt_in == true) {
                    $emails[UserRepository::getLangForMailing($guest)][]= $guest->email;
                }
            }
        }

        if ($filters['guest_filter_access_no'] == 'true') {
            foreach (GuestRepository::getAll() as $guest) {
                $now = (new DateTime())->setTime(0, 0, 0);
                if (($now < new DateTime($guest->access_start_date) || $now > new DateTime($guest->access_end_date)) && $guest->opt_in == true) {
                    $emails[UserRepository::getLangForMailing($guest)][]= $guest->email;
                }
            }
        }

        $emails_fr = array_unique($emails['fr']);
        $emails_en = array_unique($emails['en']);

        return response()->json([
            'emails_fr' => $emails_fr,
            'emails_en' => $emails_en,
        ]);
    }

    public function send_test_email(Request $request) {
        $email = $request->email;
        $title = $request->title;
        $title_en = $request->title_en;

        Mail::send('wine-supervisor::emails.mailing', array(
            'text' => $request->text,
            'title' => $request->title,
            'image' => $request->image,
            'lang' => 'fr'
        ), function ($message) use ($email, $title) {
            $message->to($email)
                ->subject($title);
        });

        Mail::send('wine-supervisor::emails.mailing', array(
            'text' => $request->text_en,
            'title' => $request->title_en,
            'image' => $request->image,
            'lang' => 'en'
        ), function ($message) use ($email, $title_en) {
            $message->to($email)
                ->subject($title_en);
        });
    }

    public function upload_image(Request $request) {
        $image = time().'.'.$request->file->getClientOriginalExtension();
        $request->file->move(public_path('/newsletter'), $image);

        return asset('newsletter') . '/' . $image;
    }

    public function get_html_preview(Request $request) {
        return view('wine-supervisor::emails.mailing', array(
            'text' => $request->text,
            'title' => $request->title,
            'image' => $request->image,
            'lang' => $request->lang
        ));
    }

    public function send_emails(Request $request)
    {
        $emails_fr = explode("\n", $request->emails_fr);
        $emails_en = explode("\n", $request->emails_en);

        $emails['fr'] = $emails_fr;
        $emails['en'] = $emails_en;

        foreach ($emails as $lang => $email_addresses) {
            if (is_array($email_addresses) && sizeof($email_addresses) > 0) {
                foreach ($email_addresses as $email) {
                    $data = new \StdClass();
                    $data->email = $email;
                    $data->lang = $lang;
                    $data->image = $request->image;

                    if ($lang == 'fr') {
                        $data->title = $request->title;
                        $data->text = $request->text;
                    } else {
                        $data->title = $request->title_en;
                        $data->text = $request->text_en;
                    }

                    dispatch(new SendMailingJob($data));
                }
            }
        }
    }
}