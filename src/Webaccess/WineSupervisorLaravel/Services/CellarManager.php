<?php

namespace Webaccess\WineSupervisorLaravel\Services;

use DateInterval;
use DateTime;
use Ramsey\Uuid\Uuid;
use Webaccess\WineSupervisorLaravel\Models\Cellar;
use Webaccess\WineSupervisorLaravel\Models\CellarHistory;
use Webaccess\WineSupervisorLaravel\Models\Technician;
use Webaccess\WineSupervisorLaravel\Models\WS;
use Webaccess\WineSupervisorLaravel\Tools\GPSTool;

class CellarManager
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
     * @param $zipcode
     * @param $city
     * @return bool
     */
    public static function create($userID, $idWS, $technicianID, $name, $subscriptionType, $serialNumber, $address, $zipcode, $city)
    {
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
        $cellar->zipcode = $zipcode;
        $cellar->city = $city;
        $cellar->latitude = $latitude;
        $cellar->longitude = $longitude;

        if ($cellar->save()) {

            //Update WS table
            if ($ws->first_activation_date == null) {
                $ws->first_activation_date = new DateTime();
                $ws->save();
            }
        }

        return true;
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
     * @param $zipcode
     * @param $city
     * @return bool
     */
    public static function update($cellarID, $userID, $adminID, $technicianID, $name, $subscriptionType, $serialNumber, $address, $zipcode, $city)
    {
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
            if ($zipcode != $cellar->zipcode) { $updates[]= ['column' => 'zipcode', 'old_value' => $cellar->zipcode, 'new_value' => $zipcode]; }
            if ($city != $cellar->city) { $updates[]= ['column' => 'city', 'old_value' => $cellar->city, 'new_value' => $city]; }
            if ($latitude && $latitude != $cellar->latitude) { $updates[]= ['column' => 'latitude', 'old_value' => $cellar->latitude, 'new_value' => $latitude]; }
            if ($longitude && $longitude != $cellar->longitude) { $updates[]= ['column' => 'longitude', 'old_value' => $cellar->longitude, 'new_value' => $longitude]; }

            $cellar->technician_id = $technicianID;
            $cellar->name = $name;
            $cellar->serial_number = $serialNumber;
            $cellar->subscription_type = $subscriptionType;
            $cellar->address = $address;
            $cellar->zipcode = $zipcode;
            $cellar->city = $city;
            if ($latitude) $cellar->latitude = $latitude;
            if ($longitude) $cellar->longitude = $longitude;
            $result = $cellar->save();

            foreach ($updates as $update) {
                self::updateCellarHistory($cellarID, $userID, $adminID, $update['column'], $update['old_value'], $update['new_value']);
            }

            return $result;
        }

        return false;
    }

    /**
     * @param $cellarID
     * @param $userID
     * @param $idWS
     */
    public static function sav($cellarID, $userID, $idWS)
    {
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
            $cellar->save();

            //Update cellar history
            self::updateCellarHistory($cellarID, $userID, null, 'id_ws', $oldIDWS, $idWS);
        }
    }

    /**
     * @param $cellarID
     * @param $boardType
     */
    public static function delete($cellarID, $boardType)
    {
        if ($cellar = Cellar::find($cellarID)) {

            //Update WS table
            if ($ws = WS::find($cellar->id_ws)->first()) {
                $ws->deactivation_date = new DateTime();
                $ws->board_type = $boardType;
                $ws->save();
            }

            //Delete cellar in database
            Cellar::find($cellar->id)->delete();
        }
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
     * @return mixed
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
        $history->save();
    }
}