<?php

namespace Webaccess\WineSupervisorLaravel\Services;

use Ramsey\Uuid\Uuid;
use Webaccess\WineSupervisorLaravel\Models\Client;

class   ClientManager
{
    public static function getAll($paginate = false, $orderBy = null, $order = null)
    {
        $clients = Client::orderBy($orderBy ? $orderBy : 'created_at', $order ? $order : 'asc');

        return ($paginate) ? $clients->paginate($paginate) : $clients->get();
    }

    public static function getByID($clientID)
    {
        return Client::find($clientID);
    }

    /**
     * @param $name
     * @param $accessLimitDate
     * @param null $usersLimit
     * @return Client
     */
    public static function createClient($name, $accessLimitDate = null, $usersLimit = null)
    {
        $client = new Client();
        $client->id = Uuid::uuid4()->toString();
        $client->name = $name;
        $client->access_limit_date = $accessLimitDate;
        $client->users_limit = $usersLimit;

        $client->save();

        return $client->id;
    }

    /**
     * @param $clientID
     * @param $name
     * @param $accessLimitDate
     * @param $usersLimit
     * @return bool
     */
    public static function udpateClient($clientID, $name, $accessLimitDate = null, $usersLimit = null)
    {
        if ($client = Client::find($clientID)) {
            $client->name = $name;
            $client->access_limit_date = $accessLimitDate;
            $client->users_limit = $usersLimit;
            $client->save();

            return true;
        }

        return false;
    }

    /**
     * @param $clientID
     * @return bool
     */
    public static function deleteClient($clientID)
    {
        if ($client = Client::find($clientID)) {
            $client->delete();

            return true;
        }

        return false;
    }
}
