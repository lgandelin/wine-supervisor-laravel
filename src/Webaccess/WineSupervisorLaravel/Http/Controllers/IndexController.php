<?php

namespace Webaccess\WineSupervisorLaravel\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Redirect;
use Webaccess\WineSupervisorLaravel\Repositories\ContentRepository;
use Webaccess\WineSupervisorLaravel\Repositories\SaleRepository;
use Webaccess\WineSupervisorLaravel\Services\AccountService;
use Webaccess\WineSupervisorLaravel\Services\CellierDomesticusAPI;

class IndexController
{
    public function index(Request $request)
    {
        return view('wine-supervisor::pages.index', [
            'is_eligible_to_club_premium' => AccountService::isUserEligibleToClubPremium(),
            'is_eligible_to_supervision' => AccountService::isUserEligibleToSupervision(),
            'is_user' => AccountService::isUser(),
            'is_technician' => AccountService::isTechnician(),
            'is_guest' => AccountService::isGuest(),
            'first_name' => AccountService::getFirstName(),
            'contents' => ContentRepository::getAll(3),
            'sales' => SaleRepository::getAll(),
        ]);
    }

    public function contact(Request $request)
    {
        return view('wine-supervisor::pages.contact', [
            'is_eligible_to_club_premium' => AccountService::isUserEligibleToClubPremium(),
            'is_eligible_to_supervision' => AccountService::isUserEligibleToSupervision(),
            'is_user' => AccountService::isUser(),
            'is_technician' => AccountService::isTechnician(),
            'is_guest' => AccountService::isGuest(),
            'first_name' => AccountService::getFirstName(),
            'route' => $request->route()->getName(),

            'error' => ($request->session()->has('error')) ? $request->session()->get('error') : null,
            'confirmation' => ($request->session()->has('confirmation')) ? $request->session()->get('confirmation') : null,
        ]);
    }

    public function contact_handler(Request $request)
    {
        $contactEmail = env('WINE_SUPERVISOR_CONTACT_EMAIL');
        $subject = $request->get('subject') ? $request->get('subject') : 'Aucun objet';
        $text = nl2br($request->get('message'));

        try {
            Mail::send('wine-supervisor::emails.contact', array('subject' => $subject, 'email' => $request->get('email'), 'text' => $text), function ($message) use ($contactEmail) {
                $message->to($contactEmail)
                    ->from('no-reply@winesupervisor.fr')
                    ->subject('[WineSupervisor] Une nouvelle demande vient d\'être envoyée depuis le formulaire du site');
            });

            $request->session()->flash('confirmation', trans('wine-supervisor::contact.contact_form_success'));
        } catch (\Exception $e) {
            $request->session()->flash('error', trans('wine-supervisor::contact.contact_form_error'));
        }

        return redirect()->route('contact');
    }

    public function supervision(Request $request)
    {
        if (AccountService::isUserEligibleToSupervision()) {
            if (AccountService::isUser()) {
                $user = Auth::guard('users')->getUser();
                $result = (new CellierDomesticusAPI())->login_user($user);
                if ($result->status == 'success') {
                    return Redirect::to(sprintf('%s/manager?authToken=%s', env('CD_API_URL'), $result->authToken));
                }
            }

            if (AccountService::isTechnician()) {
                $technician= Auth::guard('technicians')->getUser();
                $result = (new CellierDomesticusAPI())->login_user($technician);
                if ($result->status == 'success') {
                    return Redirect::to(sprintf('%s/manager?authToken=%s', env('CD_API_URL'), $result->authToken));
                }
            }
        }

        return redirect()->back();
    }
}