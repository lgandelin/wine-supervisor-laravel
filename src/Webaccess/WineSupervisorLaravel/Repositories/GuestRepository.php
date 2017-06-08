<?php

namespace Webaccess\WineSupervisorLaravel\Repositories;

use Illuminate\Support\Facades\Hash;
use Ramsey\Uuid\Uuid;
use Webaccess\WineSupervisorLaravel\Models\Guest;

class GuestRepository
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
     * @internal param $idGuest
     * @return bool
     */
    public static function create($firstName, $lastName, $accessStartDate, $accessEndDate, $login, $password, $email, $phone, $address, $zipcode, $city)
    {
        $guest = new Guest();
        $guest->id = Uuid::uuid4()->toString();
        $guest->first_name = $firstName;
        $guest->last_name = $lastName;
        $guest->access_start_date = $accessStartDate;
        $guest->access_end_date = $accessEndDate;
        $guest->login = $login;
        $guest->password = Hash::make($password);
        $guest->email = $email;
        $guest->phone = $phone;
        $guest->address = $address;
        $guest->zipcode = $zipcode;
        $guest->city = $city;

        return $guest->save();
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
     * @return bool
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

            return $guest->save();
        }

        return false;
    }

    /**
     * @param $guestID
     * @param $login
     * @return bool
     */
    public static function checkLogin($guestID, $login)
    {
        $existingGuest = Guest::where('login', '=', $login);

        if ($guestID) {
            $existingGuest->where('id', '!=', $guestID);
        }

        if ($existingGuest->first()) {
            return false;
        }

        return true;
    }

    /**
     * @param $guestID
     * @return bool
     */
    public static function delete($guestID)
    {
        if ($guest = Guest::find($guestID)) {
            return $guest->delete();
        }

        return false;
    }
}
