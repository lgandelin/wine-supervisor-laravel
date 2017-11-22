<?php

namespace Webaccess\WineSupervisorLaravel\Repositories;

use Illuminate\Support\Facades\Log;
use Ramsey\Uuid\Uuid;
use Webaccess\WineSupervisorLaravel\Models\Cellar;
use Webaccess\WineSupervisorLaravel\Models\WS;
use Webaccess\WineSupervisorLaravel\Services\CellierDomesticusAPI;

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
        $oldBoardType = null;
        if ($ws = WS::find($wsID)) {
            $ws->board_type = $boardType;

            if (!$ws->save()) {
                return self::error(trans('wine-supervisor::ws.database_create_error'));
            }
        } else {
            return self::error(trans('wine-supervisor::ws.id_not_found'));
        }

        if ($boardType != $oldBoardType) {
            if ($boardType == WS::OUT_OF_ORDER_BOARD) {

                //Delete board
                try {
                    (new CellierDomesticusAPI())->delete_cellar($ws->cd_ws_id);
                } catch (\Exception $e) {
                    Log::info('API_DELETE_WS_ERROR', [
                        'cellar_cd_id' => $ws->cd_ws_id,
                        'error' => $e->getMessage(),
                    ]);

                    return self::error(trans('wine-supervisor::generic.api_error'));
                }
            }

            if ($boardType == WS::DEUXIO_BOARD) {

                //Equivalent to resell board
                try {
                    (new CellierDomesticusAPI())->resell_cellar($ws->cd_ws_id);
                } catch (\Exception $e) {
                    Log::info('API_RESELL_WS_ERROR', [
                        'cellar_cd_id' => $ws->cd_ws_id,
                        'error' => $e->getMessage(),
                    ]);

                    return self::error(trans('wine-supervisor::generic.api_error'));
                }
            }
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
