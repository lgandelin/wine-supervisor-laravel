<?php

namespace Webaccess\WineSupervisorLaravel\Services;

use Illuminate\Support\Facades\Hash;
use Ramsey\Uuid\Uuid;
use Webaccess\WineSupervisorLaravel\Models\Guest;

class GuestManager
{
    /**
     * @param $guestID
     * @return mixed
     */
    public static function getByID($guestID)
    {
        return Guest::find($guestID);
    }

    /**
     * @return mixed
     */
    public static function getAll()
    {
        return Guest::all();
    }

    /**
     * @param $idGuest
     * @param $boardType
     */
    public static function create($idGuest, $boardType)
    {
        $guest = new Guest();
        $guest->id = $idGuest ? $idGuest : Uuid::uuid4()->toString();
        $guest->board_type = $boardType;

        $guest->save();
    }

    /**
     * @param $guestID
     * @param $firstName
     * @param $lastName
     * @param $accessStartDate
     * @param $accessEndDate
     * @param $login
     * @param $password
     * @param $email
     * @param $phone
     * @param $address
     * @param $zipcode
     * @param $city
     */
    public static function update($guestID, $firstName, $lastName, $accessStartDate, $accessEndDate, $login, $password, $email, $phone, $address, $zipcode, $city)
    {
        if ($guest = Guest::find($guestID)) {
            $guest->first_name = $firstName;
            $guest->last_name = $lastName;
            $guest->access_start_date = $accessStartDate;
            $guest->access_end_date = $accessEndDate;
            $guest->login = $login;
            if ($password) $guest->password = Hash::make($password);
            $guest->email = $email;
            $guest->phone = $phone;
            $guest->address = $address;
            $guest->zipcode = $zipcode;
            $guest->city = $city;
            $guest->save();
        }
    }
}
