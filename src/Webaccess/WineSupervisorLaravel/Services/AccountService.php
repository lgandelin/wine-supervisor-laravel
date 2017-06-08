<?php

namespace Webaccess\WineSupervisorLaravel\Services;

use DateTime;
use Illuminate\Support\Facades\Auth;
use Webaccess\WineSupervisorLaravel\Models\Subscription;
use Webaccess\WineSupervisorLaravel\Repositories\CellarRepository;

class AccountService
{
    public static function isUserEligibleToClubPremium()
    {
        return
            (self::isAdministrator()) ||
            (self::isUser() && self::hasAValidUserAccount()) ||
            (self::isGuest() && self::hasAValidGuestAccount());
    }

    public static function isAdministrator()
    {
        return Auth::guard('administrators')->check();
    }

    public static function isUser()
    {
        return Auth::guard('users')->check();
    }

    public static function hasAValidUserAccount()
    {
        if ($user = Auth::guard('users')->user()) {
            $userHasOneSubscription = false;

            //Récupération des caves de l'utilisateur
            if ($cellars = CellarRepository::getByUser($user->id)) {
                foreach ($cellars as $cellar) {
                    if ($cellar->subscription_type !== Subscription::NO_SUBSCRIPTION && $cellar->subscription_type !== Subscription::FREE_SUBSCRIPTION) {
                        if (new DateTime() >= new DateTime($cellar->subscription_start_date) && new DateTime() <= new DateTime($cellar->subscription_end_date)) {
                            $userHasOneSubscription = true;
                        }
                    }
                }
            }

            return $userHasOneSubscription;
        }

        return false;
    }

    public static function isGuest()
    {
        return Auth::guard('guests')->check();
    }

    public static function hasAValidGuestAccount()
    {
        if ($guest = Auth::guard('guests')->user()) {
            return new DateTime() >= new DateTime($guest->access_start_date) && new DateTime() < new DateTime($guest->access_end_date);
        }

        return false;
    }
}