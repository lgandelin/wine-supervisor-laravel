<?php

namespace Webaccess\WineSupervisorLaravel\Services;

use DateTime;
use Ramsey\Uuid\Uuid;
use Webaccess\WineSupervisorLaravel\Models\Board;
use Webaccess\WineSupervisorLaravel\Models\Cellar;
use Webaccess\WineSupervisorLaravel\Models\WS;
use Webaccess\WineSupervisorLaravel\Tools\GPSTool;

class CellarManager
{
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
     * @param $serialNumber
     * @param $address
     * @param $zipcode
     * @param $city
     */
    public static function create($userID, $idWS, $technicianID, $name, $serialNumber, $address, $zipcode, $city)
    {
        //Fetch GPS coordinates from address
        $complete_address = implode(' ', [$address, $zipcode, $city]);
        list($latitude, $longitude) = GPSTool::getGPSCoordinates($complete_address);

        //Create cellar
        $cellar = new Cellar();
        $cellar->id = Uuid::uuid4()->toString();
        $cellar->user_id = $userID;
        $cellar->id_ws = $idWS;
        $cellar->technician_id = $technicianID;
        $cellar->name = $name;
        $cellar->serial_number = $serialNumber;
        $cellar->address = $address;
        $cellar->zipcode = $zipcode;
        $cellar->city = $city;
        $cellar->latitude = $latitude;
        $cellar->longitude = $longitude;
        $cellar->first_activation_date = new DateTime();
        $cellar->save();

        //Update WS table
        $ws = WS::find($cellar->id_ws);
        $ws->first_activation_date = new DateTime();
        $ws->save();
    }

    /**
     * @param $cellarID
     * @param $boardType
     */
    public static function delete($cellarID, $boardType)
    {
        $cellar = Cellar::find($cellarID);

        //Update WS table
        $ws = WS::find($cellar->id_ws)->first();
        $ws->deactivation_date = new DateTime();
        $ws->board_type = $boardType;
        $ws->save();

        //Delete cellar in database
        Cellar::find($cellar->id)->delete();
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
        if ($ws->board_type != Board::PRIMO_BOARD && $ws->board_type != Board::OTHER_BOARD)
            return false;

        return true;
    }
}