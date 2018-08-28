<?php

namespace Webaccess\WineSupervisorLaravel\Repositories;

use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Ramsey\Uuid\Uuid;
use Webaccess\WineSupervisorLaravel\Models\Technician;
use Webaccess\WineSupervisorLaravel\Services\CellierDomesticusAPI;
use Webaccess\WineSupervisorLaravel\Tools\PasswordTool;

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

    public static function getByCode($technicianCode)
    {
        return Technician::where('technician_code', '=', $technicianCode)->first();
    }

    /**
     * @param null $sort_column
     * @param null $sort_order
     * @return mixed
     */
    public static function getAll($sort_column = null, $sort_order = null)
    {
        return Technician::orderBy($sort_column ? $sort_column : 'created_at', $sort_order ? $sort_order : 'DESC')->get();
    }

    /**
     * @param $firstName
     * @param $lastName
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
     * @param $opt_in
     * @param $locale
     * @return bool
     */
    public static function create($firstName, $lastName, $company, $registration, $phone, $email, $password, $address, $address2, $zipcode, $city, $country, $opt_in, $locale)
    {
        $technician = new Technician();
        $technician->id = Uuid::uuid4()->toString();
        $technician->first_name = $firstName;
        $technician->last_name = $lastName;
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
        $technician->opt_in = $opt_in;
        $technician->technician_code = PasswordTool::generatePassword(8);
        $technician->status = Technician::STATUS_DISABLED;
        $technician->locale = $locale;

        if (!$technician->save()) {
            return self::error(trans('wine-supervisor::technician.create_database_error'));
        }

        return self::success($technician->id);
    }

    /**
     * @param $technicianID
     * @param $readOnly
     * @param $status
     * @return bool
     */
    public static function update_status($technicianID, $readOnly, $status)
    {
        $oldStatus = 0;
        if ($technician = Technician::find($technicianID)) {
            $oldStatus = $technician->status;
            $technician->status = $status;
            $technician->read_only = $readOnly;

            if (!$technician->save()) {
                return self::error(trans('wine-supervisor::technician.update_database_error'));
            }
        } else {
            return self::error(trans('wine-supervisor::technician.id_not_found'));
        }

        if (!$oldStatus && $status) {
            try {
                (new CellierDomesticusAPI())->create_technician($technician);

                sleep(2);

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
     * @param $firstName
     * @param $lastName
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
     * @param $opt_in
     * @param $locale
     * @return bool
     */
    public static function update($technicianID, $firstName, $lastName, $company, $registration, $phone, $email, $password, $address, $address2, $zipcode, $city, $country, $opt_in, $locale)
    {
        if ($technician = Technician::find($technicianID)) {
            $technician->first_name = $firstName;
            $technician->last_name = $lastName;
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
            $technician->opt_in = $opt_in;
            $technician->locale = $locale;

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
    
    /**
     * @param $technicianID
     * @return bool
     */
    public static function delete($technicianID)
    {
        if ($technician = Technician::find($technicianID)) {

            if (!$technician->delete()) {
                return self::error(trans('wine-supervisor::technician.database_error'));
            }
        } else {
            return self::error(trans('wine-supervisor::technician.id_not_found'));
        }

        try {
            (new CellierDomesticusAPI())->disable_technician($technician);
        } catch (\Exception $e) {
            Log::info('API_DISABLE_TECHNICIAN_ERROR', [
                'technician_id' => $technicianID,
                'cd_technician_id' => $technician->cd_technician_id,
                'error' => $e->getMessage(),
            ]);

            return self::error(trans('wine-supervisor::generic.api_error'));
        }

        return self::success();
    }
}
