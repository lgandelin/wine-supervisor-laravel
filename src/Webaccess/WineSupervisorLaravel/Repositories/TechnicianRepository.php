<?php

namespace Webaccess\WineSupervisorLaravel\Repositories;

use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
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
     * @param $password
     * @param $address
     * @param $address2
     * @param $zipcode
     * @param $city
     * @param $country
     * @return bool
     */
    public static function create($company, $registration, $phone, $email, $password, $address, $address2, $zipcode, $city, $country)
    {
        $technician = new Technician();
        $technician->id = Uuid::uuid4()->toString();
        $technician->company = $company;
        $technician->registration = $registration;
        $technician->phone = $phone;
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

        return self::success($technician->id);
    }

    /**
     * @param $technicianID
     * @param $status
     * @return bool
     */
    public static function update_status($technicianID, $status)
    {
        $oldStatus = 0;
        if ($technician = Technician::find($technicianID)) {
            $oldStatus = $technician->status;
            $technician->status = $status;

            if (!$technician->save()) {
                return self::error(trans('wine-supervisor::technician.update_database_error'));
            }
        } else {
            return self::error(trans('wine-supervisor::technician.id_not_found'));
        }

        if (!$oldStatus && $status) {
            try {
                (new CellierDomesticusAPI())->create_technician($technician);
            } catch (\Exception $e) {
                Log::info('API_CREATE_TECHNICIAN_ERROR', [
                    'technician_id' => $technician->id,
                    'error' => $e->getMessage(),
                ]);

                return self::error(trans('wine-supervisor::generic.api_error'));
            }
        }

        return self::success();
    }

    /**
     * @param $technicianID
     * @param $company
     * @param $registration
     * @param $phone
     * @param $email
     * @param $password
     * @param $address
     * @param $address2
     * @param $zipcode
     * @param $city
     * @param $country
     * @return bool
     */
    public static function update($technicianID, $company, $registration, $phone, $email, $password, $address, $address2, $zipcode, $city, $country)
    {
        if ($technician = Technician::find($technicianID)) {
            $technician->company = $company;
            $technician->registration = $registration;
            $technician->phone = $phone;
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

        try {
            (new CellierDomesticusAPI())->update_technician($technician);
        } catch (\Exception $e) {
            Log::info('API_UPDATE_TECHNICIAN_ERROR', [
                'technician_id' => $technician->id,
                'error' => $e->getMessage(),
            ]);

            return self::error(trans('wine-supervisor::generic.api_error'));
        }

        return self::success();
    }

    /**
     * @param $technicianID
     * @param $email
     * @return bool
     */
    public static function checkEmail($technicianID, $email)
    {
        $existingTechnician = Technician::where('email', '=', $email);

        if ($technicianID) {
            $existingTechnician->where('id', '!=', $technicianID);
        }

        if ($existingTechnician->first()) {
            return false;
        }

        return true;
    }
}
