<?php

namespace Webaccess\WineSupervisorLaravel\Services;

use DateTime;
use Illuminate\Support\Facades\Hash;
use Ramsey\Uuid\Uuid;
use Webaccess\WineSupervisorLaravel\Models\Cellar;
use Webaccess\WineSupervisorLaravel\Models\WS;

class SignupManager
{
    /**
     * @param $user
     * @return string
     */
    public static function createUser($user)
    {
        $user->id = Uuid::uuid4()->toString();
        $user->password = Hash::make($user->password);
        $user->last_connection_date = new DateTime();
        $user->save();

        return $user->id;
    }

    /**
     * @param $userID
     * @param $request
     * @return string
     */
    public static function createCellar($userID, $request)
    {
        $cellar = new Cellar();
        $cellar->id = Uuid::uuid4()->toString();
        $cellar->user_id = $userID;
        $cellar->id_ws = $request->get('id_ws');
        $cellar->technician_id = $request->get('technician_id');
        $cellar->name = $request->get('name');
        $cellar->serial_number = $request->get('serial_number');
        $cellar->address = $request->get('address');
        $cellar->zipcode = $request->get('zipcode');
        $cellar->city = $request->get('city');
        $cellar->first_activation_date = new DateTime();
        $cellar->save();

        return $cellar->id;
    }

    /**
     * @param $request
     * @return bool
     */
    public static function checkIDWS($request)
    {
        return WS::find($request->get('id_ws'));
    }

    /**
     * @param $request
     */
    public static function updateWSTable($request)
    {
        $ws = WS::find($request->get('id_ws'));
        $ws->first_activation_date = new DateTime();
        $ws->save();
    }
}