<?php

namespace Webaccess\WineSupervisorLaravel\Services;

use DateTime;
use Illuminate\Support\Facades\Hash;
use Ramsey\Uuid\Uuid;
use Webaccess\WineSupervisorLaravel\Models\Administrator;
use Webaccess\WineSupervisorLaravel\Models\Technician;
use Webaccess\WineSupervisorLaravel\Models\User;

class UserManager
{
    /**
     * @param $firstName
     * @param $lastName
     * @param $email
     * @param $login
     * @param $password
     * @param $opt_in
     * @return User
     */
    public static function create($firstName, $lastName, $email, $login, $password, $opt_in)
    {
        $user = new User();
        $user->id = Uuid::uuid4()->toString();
        $user->first_name = $firstName;
        $user->last_name = $lastName;
        $user->email = $email;
        $user->login = $login;
        $user->password = Hash::make($password);
        $user->opt_in = $opt_in;
        $user->last_connection_date = new DateTime();

        $user->save();

        return $user->id;
    }

    /**
     * @param $firstName
     * @param $lastName
     * @param $email
     * @param $password
     * @return User
     */
    public static function createAdministrator($firstName, $lastName, $email, $password)
    {
        $administrator = new Administrator();
        $administrator->id = Uuid::uuid4()->toString();
        $administrator->first_name = $firstName;
        $administrator->last_name = $lastName;
        $administrator->email = $email;
        $administrator->password = Hash::make($password);

        $administrator->save();

        return $administrator->id;
    }
}
