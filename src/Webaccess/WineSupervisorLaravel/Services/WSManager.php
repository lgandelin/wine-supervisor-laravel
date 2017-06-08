<?php

namespace Webaccess\WineSupervisorLaravel\Services;

use Illuminate\Support\Facades\Hash;
use Ramsey\Uuid\Uuid;
use Webaccess\WineSupervisorLaravel\Models\WS;

class WSManager
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

    public static function getBoardTypeLabel($boardType) {
        $label = 'DEFAULT';
        switch ($boardType) {
            case WS::PRIMO_BOARD: $label = 'Primo'; break;
            case WS::SAV_BOARD: $label = 'SAV'; break;
            case WS::OUT_OF_ORDER_BOARD: $label = 'HS'; break;
            case WS::OTHER_BOARD: $label = 'Autre'; break;
        }

        return $label;
    }

    /**
     * @param $idWS
     * @param $boardType
     * @return bool
     */
    public static function create($idWS, $boardType)
    {
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
