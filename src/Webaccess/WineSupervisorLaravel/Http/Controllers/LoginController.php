<?php

namespace Webaccess\WineSupervisorLaravel\Http\Controllers;

use DateTime;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use Webaccess\WineSupervisorLaravel\Models\User;
use Webaccess\WineSupervisorLaravel\Services\AccountService;

class LoginController extends Controller
{
    public function __construct(Request $request)
    {
        $this->request = $request;
    }

    public function login()
    {
        return view('wine-supervisor::pages.user.auth.login', [
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

            return redirect()->route('user_update_account');
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

            return redirect()->route('guest_index');
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
        Auth::guard('guests')->logout();

        return redirect()->route('user_login');
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
        $login = $this->request->input('login');

        try {
            if ($user = User::where('login', '=', $login)->first()) {
                $newPassword = self::generate(8);
                $user->password = bcrypt($newPassword);
                $user->save();
                $this->sendNewPasswordToUser($newPassword, $user->email);
                $this->request->session()->flash('message', trans('wine-supervisor::login.forgotten_password_email_success'));
            } else {
                $this->request->session()->flash('error', trans('wine-supervisor::login.forgotten_password_email_not_found_error'));
            }
        } catch (\Exception $e) {
            $this->request->session()->flash('error', trans('wine-supervisor::login.forgotten_password_generic_error'));
        }

        return redirect()->route('forgotten_password');
    }

    /**
     * @param $newPassword
     * @param $userEmail
     */
    private function sendNewPasswordToUser($newPassword, $userEmail)
    {
        Mail::send('wine-supervisor::emails.password', array('password' => $newPassword), function ($message) use ($userEmail) {

            $message->to($userEmail)
                ->from('no-reply@winesupervisor.com')
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