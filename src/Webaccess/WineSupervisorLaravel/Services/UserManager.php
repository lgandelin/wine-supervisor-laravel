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
     * @param $password
     * @return User
     */
    public static function create($firstName, $lastName, $email, $password)
    {
        $user = new User();
        $user->id = Uuid::uuid4()->toString();
        $user->first_name = $firstName;
        $user->last_name = $lastName;
        $user->email = $email;
        $user->password = Hash::make($password);
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

    /**
     * @param $company
     * @param $registration
     * @param $phone
     * @param $email
     * @param $password
     * @param $address
     * @param $zipcode
     * @param $city
     */
    public static function createTechnician($company, $registration, $phone, $email, $password, $address, $zipcode, $city)
    {
        $technician = new Technician();
        $technician->id = Uuid::uuid4()->toString();
        $technician->company = $company;
        $technician->registration = $registration;
        $technician->phone = $phone;
        $technician->email = $email;
        $technician->password = Hash::make($password);
        $technician->address = $address;
        $technician->zipcode = $zipcode;
        $technician->city = $city;
        $technician->status = Technician::STATUS_DISABLED;

        $technician->save();
    }
}
