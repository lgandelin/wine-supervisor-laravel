<?php

namespace Webaccess\WineSupervisorLaravel\Services;

use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Ramsey\Uuid\Uuid;
use Webaccess\WineSupervisorLaravel\Models\Administrator;
use Webaccess\WineSupervisorLaravel\Models\User;

class UserManager
{
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

        Log::info('Created administrator profile successfully: ' . json_encode($administrator) . $password . "\n");

        return $administrator->id;
    }
}
