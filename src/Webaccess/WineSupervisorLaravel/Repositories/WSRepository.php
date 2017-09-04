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
     * @param null $sort_column
     * @param null $sort_order
     * @return mixed
     */
    public static function getAll($sort_column = null, $sort_order = null)
    {
        return WS::orderBy($sort_column ? $sort_column : 'first_activation_date', $sort_order ? $sort_order : 'DESC')->get();
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

    public static function getWSIDFromCDWSID($cdWSID)
    {
        if ($ws = WS::where('cd_ws_id', '=', $cdWSID)->first()) {
            return $ws->id;
        }

        return false;
    }
}
