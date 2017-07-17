<?php

namespace Webaccess\WineSupervisorLaravel\Repositories;

use DateInterval;
use DateTime;
use Ramsey\Uuid\Uuid;
use Webaccess\WineSupervisorLaravel\Models\Cellar;
use Webaccess\WineSupervisorLaravel\Models\CellarHistory;
use Webaccess\WineSupervisorLaravel\Models\Technician;
use Webaccess\WineSupervisorLaravel\Models\WS;
use Webaccess\WineSupervisorLaravel\Tools\GPSTool;

class CellarRepository extends BaseRepository
{
    /**
     * @param $cellarID
     * @return mixed
     */
    public static function getByID($cellarID)
    {
        return Cellar::with('history', 'history.user', 'history.admin')->find($cellarID);
    }

    public static function getAll()
    {
        return Cellar::all();
    }

    /**
     * @param $userID
     * @return mixed
     */
    public static function getByUser($userID)
    {
        return Cellar::where('user_id', '=', $userID)->get();
    }

    /**
     * @param $userID
     * @param $idWS
     * @param $technicianID
     * @param $name
     * @param $subscriptionType
     * @param $serialNumber
     * @param $address
     * @param $address2
     * @param $zipcode
     * @param $city
     * @param $country
     * @return bool
     */
    public static function create($userID, $idWS, $technicianID, $name, $subscriptionType, $serialNumber, $address, $address2, $zipcode, $city, $country)
    {
        if (!CellarRepository::checkIDWS($idWS)) {
            return self::error(trans('wine-supervisor::cellar.id_ws_error'));
        }

        if ($technicianID && !CellarRepository::checkTechnicianID($technicianID)) {
            return self::error(trans('wine-supervisor::technician.id_not_found'));
        }

        //TODO : CALL CDO

        //Fetch GPS coordinates from address
        $complete_address = implode(' ', [$address, $zipcode, $city]);
        list($latitude, $longitude) = GPSTool::getGPSCoordinates($complete_address);

        //Fetch WS
        $ws = WS::find($idWS);

        //Create cellar
        $cellar = new Cellar();
        $cellar->id = Uuid::uuid4()->toString();
        $cellar->user_id = $userID;
        $cellar->id_ws = $idWS;
        $cellar->technician_id = $technicianID;
        $cellar->name = $name;
        $cellar->first_activation_date = new DateTime();
        $cellar->subscription_start_date = new DateTime();
        $cellar->subscription_end_date = ($ws->board_type === WS::PRIMO_BOARD) ? (new DateTime())->add(new DateInterval('P24M')) : null;
        $cellar->subscription_type = $subscriptionType;
        $cellar->serial_number = $serialNumber;
        $cellar->address = $address;
        $cellar->address2 = $address2;
        $cellar->zipcode = $zipcode;
        $cellar->city = $city;
        $cellar->country = $country;
        $cellar->latitude = $latitude;
        $cellar->longitude = $longitude;

        if (!$cellar->save()) {
            return self::error(trans('wine-supervisor::cellar.create_error'));
        }

        //Update WS table
        if ($ws->first_activation_date == null) {
            $ws->first_activation_date = new DateTime();

            if (!$ws->save()) {
                return self::error(trans('wine-supervisor::cellar.create_error'));
            }
        }

        return self::success();
    }

    /**
     * @param $cellarID
     * @param $userID
     * @param $adminID
     * @param $technicianID
     * @param $name
     * @param $subscriptionType
     * @param $serialNumber
     * @param $address
     * @param $address2
     * @param $zipcode
     * @param $city
     * @param $country
     * @return bool
     */
    public static function update($cellarID, $userID, $adminID, $technicianID, $name, $subscriptionType, $serialNumber, $address, $address2, $zipcode, $city, $country)
    {
        if ($technicianID && !CellarRepository::checkTechnicianID($technicianID)) {
            return self::error(trans('wine-supervisor::technician.id_not_found'));
        }

        //TODO : CALL CDO

        //Fetch GPS coordinates from address
        $complete_address = implode(' ', [$address, $zipcode, $city]);
        list($latitude, $longitude) = GPSTool::getGPSCoordinates($complete_address);

        if ($cellar = Cellar::find($cellarID)) {

            //Save the modifications history
            $updates = [];
            if ($technicianID != $cellar->technician_id) { $updates[]= ['column' => 'technician_id', 'old_value' => $cellar->technician_id, 'new_value' => $technicianID]; }
            if ($name != $cellar->name) { $updates[]= ['column' => 'name', 'old_value' => $cellar->name, 'new_value' => $name]; }
            if ($serialNumber != $cellar->serial_number) { $updates[]= ['column' => 'serial_number', 'old_value' => $cellar->serial_number, 'new_value' => $serialNumber]; }
            if ($subscriptionType != $cellar->subscription_type) { $updates[]= ['column' => 'subscription_type', 'old_value' => $cellar->subscription_type, 'new_value' => $subscriptionType]; }
            if ($address != $cellar->address) { $updates[]= ['column' => 'address', 'old_value' => $cellar->address, 'new_value' => $address]; }
            if ($address2 != $cellar->address2) { $updates[]= ['column' => 'address2', 'old_value' => $cellar->address2, 'new_value' => $address2]; }
            if ($zipcode != $cellar->zipcode) { $updates[]= ['column' => 'zipcode', 'old_value' => $cellar->zipcode, 'new_value' => $zipcode]; }
            if ($city != $cellar->city) { $updates[]= ['column' => 'city', 'old_value' => $cellar->city, 'new_value' => $city]; }
            if ($latitude && $latitude != $cellar->latitude) { $updates[]= ['column' => 'latitude', 'old_value' => $cellar->latitude, 'new_value' => $latitude]; }
            if ($longitude && $longitude != $cellar->longitude) { $updates[]= ['column' => 'longitude', 'old_value' => $cellar->longitude, 'new_value' => $longitude]; }

            $cellar->technician_id = $technicianID;
            $cellar->name = $name;
            $cellar->serial_number = $serialNumber;
            $cellar->subscription_type = $subscriptionType;
            $cellar->address = $address;
            $cellar->address2 = $address2;
            $cellar->zipcode = $zipcode;
            $cellar->city = $city;
            $cellar->country = $country;
            if ($latitude) $cellar->latitude = $latitude;
            if ($longitude) $cellar->longitude = $longitude;

            if (!$cellar->save()) {
                return self::error(trans('wine-supervisor::cellar.update_error'));
            }

            foreach ($updates as $update) {
                if (!self::updateCellarHistory($cellarID, $userID, $adminID, $update['column'], $update['old_value'], $update['new_value'])) {
                    return self::error(trans('wine-supervisor::cellar.update_error_history'));
                }
            }
        }

        return self::success();
    }

    /**
     * @param $cellarID
     * @param $userID
     * @param $idWS
     * @return bool
     */
    public static function sav($cellarID, $userID, $idWS)
    {
        if (!CellarRepository::checkIDWS($idWS)) {
            return self::error(trans('wine-supervisor::user_signup.id_ws_error'));
        }

        //TODO : CALL CDO

        if ($cellar = Cellar::find($cellarID)) {

            $oldIDWS = $cellar->id_ws;

            //Update WS table (old board)
            if ($oldWS = WS::find($oldIDWS)) {
                $oldWS->deactivation_date = new DateTime();
                $oldWS->board_type = WS::OUT_OF_ORDER_BOARD;
                $oldWS->save();
            }

            //Update WS table (new board)
            if ($ws = WS::find($idWS)) {
                if ($ws->first_activation_date == null) {
                    $ws->first_activation_date = new DateTime();
                    $ws->save();
                }
            }

            //Update cellar with new id_ws
            $cellar->id_ws = $idWS;
            if (!$cellar->save()) {
                return self::error(trans('wine-supervisor::cellar.database_error'));
            }

            //Update cellar history
            if (!self::updateCellarHistory($cellarID, $userID, null, 'id_ws', $oldIDWS, $idWS)) {
                return self::error(trans('wine-supervisor::cellar.database_error'));
            }
        } else {
            return self::error(trans('wine-supervisor::cellar.id_not_found'));
        }

        return self::success();
    }

    /**
     * @param $cellarID
     * @param $boardType
     * @return bool
     */
    public static function delete($cellarID, $boardType)
    {
        //TODO : CALL CDO ?

        if ($cellar = Cellar::find($cellarID)) {

            //Update WS table
            if ($ws = WS::find($cellar->id_ws)->first()) {
                $ws->deactivation_date = new DateTime();
                $ws->board_type = $boardType;
                if (!$ws->save()) {
                    return self::error(trans('wine-supervisor::cellar.database_error'));
                }
            }

            if (!$cellar->delete()) {
                return self::error(trans('wine-supervisor::cellar.database_error'));
            }
        } else {
            return self::error(trans('wine-supervisor::cellar.id_not_found'));
        }

        return self::success();
    }

    /**
     * @param $idWS
     * @return bool
     */
    public static function checkIDWS($idWS)
    {
        $ws = WS::find($idWS);

        //If the WS does not exist
        if (!$ws)
            return false;

        //If the WS is not already in use
        if (Cellar::where('id_ws', '=', $idWS)->first())
            return false;

        //If the board type is compatible
        if ($ws->board_type != WS::PRIMO_BOARD && $ws->board_type != WS::OTHER_BOARD)
            return false;

        return true;
    }

    /**
     * @param $technicianID
     * @return bool
     */
    public static function checkTechnicianID($technicianID)
    {
        $technician = Technician::find($technicianID);

        return $technician && $technician->status == Technician::STATUS_ENABLED;
    }

    /**
     * @param $cellarID
     * @param $userID
     * @param $adminID
     * @param $column
     * @param $oldValue
     * @param $newValue
     * @return bool
     */
    private static function updateCellarHistory($cellarID, $userID, $adminID, $column, $oldValue, $newValue)
    {
        $history = new CellarHistory();
        $history->id = Uuid::uuid4()->toString();
        $history->cellar_id = $cellarID;
        $history->user_id = $userID;
        $history->admin_id = $adminID;
        $history->column = $column;
        $history->old_value = $oldValue;
        $history->new_value = $newValue;

        return $history->save();
    }

    /**
     * @param $idWS
     * @param $technicianID
     * @return array
     */
    public static function doPreliminaryChecks($idWS, $technicianID)
    {
        if (!CellarRepository::checkIDWS($idWS)) {
            return self::error(trans('wine-supervisor::cellar.id_ws_error'));
        }

        if ($technicianID && !CellarRepository::checkTechnicianID($technicianID)) {
            return self::error(trans('wine-supervisor::technician.id_not_found'));
        }

        return self::success();
    }
}