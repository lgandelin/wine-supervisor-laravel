<?php

namespace Webaccess\WineSupervisorLaravel\Repositories;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Ramsey\Uuid\Uuid;
use Webaccess\WineSupervisorLaravel\Models\Guest;

class GuestRepository extends BaseRepository
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
     * @param null $sort_column
     * @param null $sort_order
     * @return mixed
     */
    public static function getAll($sort_column = null, $sort_order = null)
    {
        $guests = Guest::orderBy($sort_column ? $sort_column : 'access_start_date', $sort_order ? $sort_order : 'DESC');

        if ($sort_column == 'last_name') {
            $guests = Guest::orderBy(DB::raw("CASE WHEN last_name IS NOT NULL THEN last_name ELSE first_name END"), $sort_order ? $sort_order : 'DESC');
        }
        return $guests->get();
    }

    /**
     * @param $firstName
     * @param $lastName
     * @param $accessStartDate
     * @param $accessEndDate
     * @param $readOnly
     * @param $login
     * @param $password
     * @param $email
     * @param $phone
     * @param $company
     * @param $address
     * @param $address2
     * @param $zipcode
     * @param $city
     * @param $country
     * @return bool
     * @internal param $idGuest
     */
    public static function create($firstName, $lastName, $accessStartDate, $accessEndDate, $readOnly, $login, $password, $email, $phone, $company, $address, $address2, $zipcode, $city, $country)
    {
        if (!GuestRepository::checkLogin(null, $login)) {
            return self::error(trans('wine-supervisor::guest.existing_login_error'));
        }

        $guest = new Guest();
        $guest->id = Uuid::uuid4()->toString();
        $guest->first_name = $firstName;
        $guest->last_name = $lastName;
        $guest->access_start_date = $accessStartDate;
        $guest->access_end_date = $accessEndDate;
        $guest->read_only = $readOnly;
        $guest->login = $login;
        $guest->password = Hash::make($password);
        $guest->email = $email;
        $guest->phone = $phone;
        $guest->company = $company;
        $guest->address = $address;
        $guest->address2 = $address2;
        $guest->zipcode = $zipcode;
        $guest->city = $city;
        $guest->country = $country;

        if (!$guest->save()) {
            return self::error(trans('wine-supervisor::guest.database_create_error'));
        }

        return self::success();
    }

    /**
     * @param $guestID
     * @param $firstName
     * @param $lastName
     * @param $accessStartDate
     * @param $accessEndDate
     * @param $readOnly
     * @param $login
     * @param $password
     * @param $email
     * @param $phone
     * @param $company
     * @param $address
     * @param $address2
     * @param $zipcode
     * @param $city
     * @param $country
     * @return bool
     */
    public static function update($guestID, $firstName, $lastName, $accessStartDate, $accessEndDate, $readOnly, $login, $password, $email, $phone, $company, $address, $address2, $zipcode, $city, $country)
    {
        if (!GuestRepository::checkLogin($guestID, $login)) {
            return self::error(trans('wine-supervisor::guest.existing_login_error'));
        }

        if ($guest = Guest::find($guestID)) {
            $guest->first_name = $firstName;
            $guest->last_name = $lastName;
            $guest->access_start_date = $accessStartDate;
            $guest->access_end_date = $accessEndDate;
            $guest->read_only = $readOnly;
            $guest->login = $login;
            if ($password) $guest->password = Hash::make($password);
            $guest->email = $email;
            $guest->phone = $phone;
            $guest->company = $company;
            $guest->address = $address;
            $guest->address2 = $address2;
            $guest->zipcode = $zipcode;
            $guest->city = $city;
            $guest->country = $country;

            if (!$guest->save()) {
                return self::error(trans('wine-supervisor::guest.database_update_error'));
            }
        } else {
            return self::error(trans('wine-supervisor::guest.id_not_found'));
        }

        return self::success();
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
            if (!$guest->delete()) {
                return self::error(trans('wine-supervisor::guest.database_error'));
            }
        } else {
            return self::error(trans('wine-supervisor::guest.id_not_found'));
        }

        return self::success();
    }
}
