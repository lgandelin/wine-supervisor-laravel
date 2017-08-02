<?php

namespace Webaccess\WineSupervisorLaravel\Repositories;

use Ramsey\Uuid\Uuid;
use Webaccess\WineSupervisorLaravel\Models\WS;

class WSRepository extends BaseRepository
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
        return WS::orderBy('first_activation_date', 'DESC')->get();
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

        if (!$ws->save()) {
            return self::error(trans('wine-supervisor::ws.database_create_error'));
        }

        return self::success();
    }

    /**
     * @param $wsID
     * @param $boardType
     * @return bool
     */
    public static function update($wsID, $boardType)
    {
        //TODO : CALL CDO

        if ($ws = WS::find($wsID)) {
            $ws->board_type = $boardType;

            if (!$ws->save()) {
                return self::error(trans('wine-supervisor::ws.database_create_error'));
            }
        } else {
            return self::error(trans('wine-supervisor::ws.id_not_found'));
        }

        return self::success();
    }
}
