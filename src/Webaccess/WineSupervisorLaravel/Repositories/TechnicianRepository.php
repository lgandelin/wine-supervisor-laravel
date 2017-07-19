<?php

namespace Webaccess\WineSupervisorLaravel\Repositories;

use Illuminate\Support\Facades\Hash;
use Ramsey\Uuid\Uuid;
use Webaccess\WineSupervisorLaravel\Models\Technician;
use Webaccess\WineSupervisorLaravel\Services\CellierDomesticusAPI;

class TechnicianRepository extends BaseRepository
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
     * @param $address2
     * @param $zipcode
     * @param $city
     * @param $country
     * @return bool
     */
    public static function create($company, $registration, $phone, $email, $login, $password, $address, $address2, $zipcode, $city, $country)
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
        $technician->address2 = $address2;
        $technician->zipcode = $zipcode;
        $technician->city = $city;
        $technician->country = $country;
        $technician->status = Technician::STATUS_DISABLED;

        if (!$technician->save()) {
            return self::error(trans('wine-supervisor::technician.create_database_error'));
        }

        return self::success();
    }

    /**
     * @param $technicianID
     * @param $status
     * @return bool
     */
    public static function update_status($technicianID, $status)
    {
        if ($technician = Technician::find($technicianID)) {
            $technician->status = $status;

            if (!$technician->save()) {
                return self::error(trans('wine-supervisor::technician.update_database_error'));
            }
        } else {
            return self::error(trans('wine-supervisor::technician.id_not_found'));
        }

        if ($status) {
            (new CellierDomesticusAPI())->create_technician($technician);
        }

        return self::success();
    }

    /**
     * @param $technicianID
     * @param $company
     * @param $registration
     * @param $phone
     * @param $email
     * @param $login
     * @param $password
     * @param $address
     * @param $address2
     * @param $zipcode
     * @param $city
     * @param $country
     * @return bool
     */
    public static function update($technicianID, $company, $registration, $phone, $email, $login, $password, $address, $address2, $zipcode, $city, $country)
    {
        //TODO : CALL CDO

        if ($technician = Technician::find($technicianID)) {
            $technician->company = $company;
            $technician->registration = $registration;
            $technician->phone = $phone;
            $technician->login = $login;
            $technician->email = $email;
            if ($password !== null) $technician->password = Hash::make($password);
            $technician->address = $address;
            $technician->address2 = $address2;
            $technician->zipcode = $zipcode;
            $technician->city = $city;
            $technician->country = $country;

            if (!$technician->save()) {
                return self::error(trans('wine-supervisor::technician.update_database_error'));
            }
        } else {
            return self::error(trans('wine-supervisor::technician.id_not_found'));
        }

        return self::success();
    }
}
