<?php

namespace Webaccess\WineSupervisorLaravel\Repositories;

use Ramsey\Uuid\Uuid;
use Webaccess\WineSupervisorLaravel\Models\WS;

class WSRepository
{
    /**
     * @param $wsID
     * @return mixed
     */
    public static function getByID($wsID)
    {
        return WS::find($wsID);
    }

    /**
     * @return mixed
     */
    public static function getAll()
    {
        return WS::all();
    }

    /**
     * @param $idWS
     * @param $boardType
     * @return bool
     */
    public static function create($idWS, $boardType)
    {
        //TODO : CALL CDO

        $ws = new WS();
        $ws->id = $idWS ? $idWS : Uuid::uuid4()->toString();
        $ws->board_type = $boardType;

        return $ws->save();
    }

    /**
     * @param $wsID
     * @param $boardType
     * @return bool
     */
    public static function update($wsID, $boardType)
    {
        if ($ws = WS::find($wsID)) {
            $ws->board_type = $boardType;

            return $ws->save();
        }

        return false;
    }
}
