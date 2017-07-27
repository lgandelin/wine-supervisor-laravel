<?php

namespace Webaccess\WineSupervisorLaravel\Http\Controllers;

use DateTime;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use Webaccess\WineSupervisorLaravel\Models\Guest;
use Webaccess\WineSupervisorLaravel\Models\Technician;
use Webaccess\WineSupervisorLaravel\Models\User;
use Webaccess\WineSupervisorLaravel\Services\AccountService;

class LoginController extends Controller
{
    public function __construct(Request $request)
    {
        $this->request = $request;
        view()->share('route', $request->route()->getName());
    }

    public function login()
    {
        return view('wine-supervisor::pages.user.auth.login', [
            'is_technician' => AccountService::isTechnician(),
            'next_route' => $this->request->input('route'),
            'error' => ($this->request->session()->has('error')) ? $this->request->session()->get('error') : null,
        ]);
    }

    /**
     * @param
     * @return mixed
     */
    public function authenticate()
    {
        //User authentication
        if (Auth::guard('users')->attempt([
            'login' => $this->request->input('login'),
            'password' => $this->request->input('password'),
        ])) {
            //Update last connection date
            Auth::user()->last_connection_date = new DateTime();
            Auth::user()->save();

            $route = $this->request->input('route') ? $this->request->input('route') : 'user_update_account';

            return redirect()->route($route);
        }

        //Technician authentication
        if (Auth::guard('technicians')->attempt([
            'login' => $this->request->input('login'),
            'password' => $this->request->input('password'),
        ])) {
            if (!AccountService::hasAValidTechnicianAccount()) {
                return redirect()->route('user_login')->with([
                    'error' => trans('wine-supervisor::login.technician_access_error'),
                ]);
            }

            return redirect()->route('technician_update_account');
        }

        //Guest authentication
        if (Auth::guard('guests')->attempt([
            'login' => $this->request->input('login'),
            'password' => $this->request->input('password'),
        ])) {
            if (!AccountService::hasAValidGuestAccount()) {
                return redirect()->route('user_login')->with([
                    'error' => trans('wine-supervisor::login.guest_access_dates_error'),
                ]);
            }

            $route = $this->request->input('route') ? $this->request->input('route') : 'club_premium';

            return redirect()->route($route);
        }

        return redirect()->route('user_login')->with([
            'error' => trans('wine-supervisor::login.login_or_password_error'),
        ]);
    }

    /**
     * @return mixed
     */
    public function logout()
    {
        Auth::guard('users')->logout();
        Auth::guard('technicians')->logout();
        Auth::guard('guests')->logout();

        return redirect()->route('index');
    }

    /**
     * @param 
     * @return mixed
     */
    public function forgotten_password()
    {
        return view('wine-supervisor::pages.user.auth.forgotten_password', [
            'error' => ($this->request->session()->has('error')) ? $this->request->session()->get('error') : null,
            'message' => ($this->request->session()->has('message')) ? $this->request->session()->get('message') : null,
        ]);
    }

    /**
     * @param
     * @return mixed
     */
    public function forgotten_password_handler()
    {
        $email = $this->request->input('email');

        try {
            $user = User::where('email', '=', $email)->first();
            if (!$user) {
                $user = Technician::where('email', '=', $email)->first();
            }

            if (!$user) {
                $user = Guest::where('email', '=', $email)->first();
            }

            if ($user) {
                $newPassword = self::generate(8);
                $user->password = bcrypt($newPassword);
                $user->save();
                $this->sendNewPasswordToUser($newPassword, $user->login, $user->email);

                $this->request->session()->flash('message', trans('wine-supervisor::login.forgotten_password_email_success'));
            } else {
                $this->request->session()->flash('error', trans('wine-supervisor::login.forgotten_password_email_not_found_error'));
            }
        } catch (\Exception $e) {
            $this->request->session()->flash('error', trans('wine-supervisor::login.forgotten_password_email_error'));
        }

        return redirect()->route('forgotten_password');
    }

    /**
     * @param $newPassword
     * @param $userLogin
     * @param $userEmail
     */
    private function sendNewPasswordToUser($newPassword, $userLogin, $userEmail)
    {
        Mail::send('wine-supervisor::emails.password', array('login' => $userLogin, 'password' => $newPassword), function ($message) use ($userEmail) {
            $message->to($userEmail)
                ->subject('[WineSupervisor] Votre nouveau mot de passe pour accéder à votre compte');
        });
    }

    /**
     * @param int $length
     * @return string
     */
    private static function generate($length = 8)
    {
        $chars = 'abcdefghkmnpqrstuvwxyz23456789';
        $count = mb_strlen($chars);

        for ($i = 0, $result = ''; $i < $length; ++$i) {
            $index = rand(0, $count - 1);
            $result .= mb_substr($chars, $index, 1);
        }

        return $result;
    }
}