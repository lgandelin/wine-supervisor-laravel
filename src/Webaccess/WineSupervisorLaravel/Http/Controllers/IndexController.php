<?php

namespace Webaccess\WineSupervisorLaravel\Http\Controllers;

use DateTime;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Redirect;
use Webaccess\WineSupervisorLaravel\Repositories\ContentRepository;
use Webaccess\WineSupervisorLaravel\Repositories\PartnerRepository;
use Webaccess\WineSupervisorLaravel\Repositories\SaleRepository;
use Webaccess\WineSupervisorLaravel\Services\AccountService;
use Webaccess\WineSupervisorLaravel\Services\CellierDomesticusAPI;

class IndexController extends Controller
{
    public function index(Request $request)
    {
        $sales = SaleRepository::getSalesHistory();
        $sales = $sales->merge(SaleRepository::getCurrentSales());
        $sales = $sales->merge(SaleRepository::getUpcomingSales());

        $current_sale = 1;

        foreach ($sales as $i => $sale) {
            if (new DateTime() <= DateTime::createFromFormat('Y-m-d', $sale->end_date) && new DateTime() >= DateTime::createFromFormat('Y-m-d', $sale->start_date)) {
                $current_sale = $i + 1;
                break;
            }
        }

        return view('wine-supervisor::pages.index', [
            'is_eligible_to_club_premium' => AccountService::isUserEligibleToClubPremium(),
            'is_eligible_to_supervision' => AccountService::isUserEligibleToSupervision(),
            'is_user' => AccountService::isUser(),
            'is_technician' => AccountService::isTechnician(),
            'is_guest' => AccountService::isGuest(),
            'first_name' => AccountService::getFirstName(),
            'contents' => ContentRepository::getAll(5),
            'sales' => $sales,
            'current_sale' => $current_sale,
            'partners' => PartnerRepository::getAll(),
            'route' => $request->route() ? $request->route()->getName() : null,
        ]);
    }

    public function preview(Request $request)
    {
        $sales = SaleRepository::getSalesHistory();
        $sales = $sales->merge(SaleRepository::getCurrentSales());
        $sales = $sales->merge(SaleRepository::getUpcomingSales());
        $sales = $sales->merge([SaleRepository::getByID($request->uuid)]);

        $current_sale = 1;

        foreach ($sales as $i => $sale) {
            if (new DateTime() <= DateTime::createFromFormat('Y-m-d', $sale->end_date) && new DateTime() >= DateTime::createFromFormat('Y-m-d', $sale->start_date)) {
                $current_sale = $i + 1;
                break;
            }
        }

        return view('wine-supervisor::pages.index', [
            'is_eligible_to_club_premium' => AccountService::isUserEligibleToClubPremium(),
            'is_eligible_to_supervision' => AccountService::isUserEligibleToSupervision(),
            'is_user' => AccountService::isUser(),
            'is_technician' => AccountService::isTechnician(),
            'is_guest' => AccountService::isGuest(),
            'first_name' => AccountService::getFirstName(),
            'contents' => ContentRepository::getAll(5),
            'sales' => $sales,
            'current_sale' => $current_sale,
            'partners' => PartnerRepository::getAll(),
            'route' => $request->route() ? $request->route()->getName() : null,
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
        $contactEmail = env('WS_CONTACT_EMAIL');
        $clientEmail = $request->get('email');
        $subject = $request->get('subject') ? $request->get('subject') : 'Aucun objet';
        $text = nl2br($request->get('message'));

        try {
            Mail::send('wine-supervisor::emails.contact', array('subject' => $subject, 'email' => $clientEmail, 'text' => $text), function ($message) use ($contactEmail) {
                $message->to($contactEmail)
                    ->subject('[WineSupervisor] Une nouvelle demande vient d\'être envoyée depuis le formulaire du site');
            });

            Mail::send('wine-supervisor::emails.contact_confirmation', array('subject' => $subject, 'email' => $clientEmail, 'text' => $text), function ($message) use ($clientEmail) {
                $message->to($clientEmail)
                    ->subject('[WineSupervisor] Votre demande de contact a bien été envoyée');
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
                try {
                    $result = (new CellierDomesticusAPI())->login_user($user);
                    if ($result->status == 'success') {
                        return Redirect::to(sprintf('%s/manager?authToken=%s', env('CD_API_URL'), $result->authToken));
                    }
                } catch (\Exception $e) {
                    Log::info('API_USER_LOGIN_ERROR', [
                        'user' => $user->id,
                        'error' => $e->getMessage(),
                    ]);
                }
            }

            if (AccountService::isTechnician()) {
                $technician = Auth::guard('technicians')->getUser();

                try {
                    $result = (new CellierDomesticusAPI())->login_user($technician);
                    if ($result->status == 'success') {
                        return Redirect::to(sprintf('%s/manager?authToken=%s', env('CD_API_URL'), $result->authToken));
                    }
                } catch (\Exception $e) {
                    Log::info('API_TECHNICIAN_LOGIN_ERROR', [
                        'user' => $technician->id,
                        'error' => $e->getMessage(),
                    ]);
                }
            }
        }

        return redirect()->back();
    }

    public function legal_notices(Request $request)
    {
        return view('wine-supervisor::pages.legal-notices');
    }

}