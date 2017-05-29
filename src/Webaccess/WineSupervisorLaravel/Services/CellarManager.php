<?php

namespace Webaccess\WineSupervisorLaravel\Services;

use DateTime;
use Webaccess\WineSupervisorLaravel\Models\Cellar;
use Webaccess\WineSupervisorLaravel\Models\WS;

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
        return WS::find($idWS);
    }
}