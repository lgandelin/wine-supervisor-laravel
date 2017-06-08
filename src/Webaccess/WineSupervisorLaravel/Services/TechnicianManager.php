<?php

namespace Webaccess\WineSupervisorLaravel\Services;

use Illuminate\Support\Facades\Hash;
use Ramsey\Uuid\Uuid;
use Webaccess\WineSupervisorLaravel\Models\Technician;

class TechnicianManager
{
    /**
     * @param $technicianID
     * @return mixed
     */
    public static function getByID($technicianID)
    {
        return Technician::find($technicianID);
    }

    /**
     * @return mixed
     */
    public static function getAll()
    {
        return Technician::all();
    }

    /**
     * @param $company
     * @param $registration
     * @param $phone
     * @param $email
     * @param $login
     * @param $password
     * @param $address
     * @param $zipcode
     * @param $city
     * @return bool
     */
    public static function create($company, $registration, $phone, $email, $login, $password, $address, $zipcode, $city)
    {
        $technician = new Technician();
        $technician->id = Uuid::uuid4()->toString();
        $technician->company = $company;
        $technician->registration = $registration;
        $technician->phone = $phone;
        $technician->login = $login;
        $technician->email = $email;
        $technician->password = Hash::make($password);
        $technician->address = $address;
        $technician->zipcode = $zipcode;
        $technician->city = $city;
        $technician->status = Technician::STATUS_DISABLED;

        return $technician->save();
    }

    /**
     * @param $technicianID
     * @param $status
     * @return bool
     */
    public static function update($technicianID, $status)
    {
        if ($technician = Technician::find($technicianID)) {
            $technician->status = $status;

            return $technician->save();
        }

        return false;
    }
}
