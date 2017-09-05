<?php

namespace Webaccess\WineSupervisorLaravel\Repositories;

use DateTime;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Ramsey\Uuid\Uuid;
use Webaccess\WineSupervisorLaravel\Models\Administrator;
use Webaccess\WineSupervisorLaravel\Models\User;
use Webaccess\WineSupervisorLaravel\Services\CellierDomesticusAPI;

class UserRepository extends BaseRepository
{
    /**
     * @param $userID
     */
    public static function getByID($userID)
    {
        return User::find($userID);
    }

    /**
     * @return mixed
     */
    public static function getAll($sort_column = null, $sort_order = null)
    {
        return User::orderBy($sort_column ? $sort_column : 'created_at', $sort_order ? $sort_order : 'DESC')->get();
    }

    /**
     * @param $firstName
     * @param $lastName
     * @param $email
     * @param $phone
     * @param $password
     * @param $opt_in
     * @param $address
     * @param $address2
     * @param $city
     * @param $zipcode
     * @param $country
     * @return User
     */
    public static function create($firstName, $lastName, $email, $phone, $password, $opt_in, $address, $address2, $city, $zipcode, $country)
    {
        if (!self::checkEmail(null, $email)) {
            return self::error(trans('wine-supervisor::signup.user_existing_email_error'));
        }

        $user = new User();
        $user->id = Uuid::uuid4()->toString();
        $user->first_name = $firstName;
        $user->last_name = $lastName;
        $user->email = $email;
        $user->phone = $phone;
        $user->password = Hash::make($password);
        $user->opt_in = $opt_in;
        $user->address = $address;
        $user->address2 = $address2;
        $user->city = $city;
        $user->zipcode = $zipcode;
        $user->country = $country;
        $user->last_connection_date = new DateTime();

        if (!$user->save()) {
            return self::error(trans('wine-supervisor::signup.create_user_error'));
        }

        //Call API
        try {
            (new CellierDomesticusAPI())->create_user($user);
        } catch (\Exception $e) {
            Log::info('API_CREATE_USER_ERROR', [
                'user_id' => $user->id,
                'error' => $e->getMessage(),
            ]);

            return self::error(trans('wine-supervisor::generic.api_error'));
        }

        return self::success(['user_id' => $user->id, 'cd_user_id' => $user->cd_user_id]);
    }

    /**
     * @param $firstName
     * @param $lastName
     * @param $email
     * @param $password
     * @return User
     */
    public static function createAdministrator($firstName, $lastName, $email, $password)
    {
        $administrator = new Administrator();
        $administrator->id = Uuid::uuid4()->toString();
        $administrator->first_name = $firstName;
        $administrator->last_name = $lastName;
        $administrator->email = $email;
        $administrator->password = Hash::make($password);

        $administrator->save();

        return $administrator->id;
    }

    /**
     * @param $userID
     * @param $firstName
     * @param $lastName
     * @param $phone
     * @param $email
     * @param $password
     * @param $opt_in
     * @param $address
     * @param $address2
     * @param $city
     * @param $zipcode
     * @param $country
     * @param bool $read_only
     * @return User
     */
    public static function update($userID, $firstName, $lastName, $phone, $email, $password, $opt_in, $address, $address2, $city, $zipcode, $country, $read_only = false)
    {
        if ($user = User::find($userID)) {
            $user->first_name = $firstName;
            $user->last_name = $lastName;
            $user->phone = $phone;
            $user->email = $email;
            if ($password !== null) $user->password = Hash::make($password);
            $user->opt_in = $opt_in;
            $user->address = $address;
            $user->address2 = $address2;
            $user->city = $city;
            $user->zipcode = $zipcode;
            $user->country = $country;
            $user->read_only = $read_only;

            if (!$user->save())
                return self::error(trans('wine-supervisor::user.database_error'));
        } else {
            return self::error(trans('wine-supervisor::user.user_not_found'));
        }

        //Call API
        try {
            (new CellierDomesticusAPI())->update_user($user);
        } catch (\Exception $e) {
            Log::info('API_UPDATE_USER_ERROR', [
                'user_id' => $userID,
                'error' => $e->getMessage(),
            ]);

            return self::error(trans('wine-supervisor::generic.api_error'));
        }

        return self::success();
    }

    /**
     * @param $userID
     * @param $email
     * @return bool
     */
    public static function checkEmail($userID, $email)
    {
        $existingUser = User::where('email', '=', $email);

        if ($userID) {
            $existingUser->where('id', '!=', $userID);
        }

        if ($existingUser->first()) {
            return false;
        }

        return true;
    }

    /**
     * @param $password
     * @return bool
     */
    public static function checkPassword($password)
    {
        return strlen($password) >= 7;
    }

    /**
     * @param $userID
     * @return bool
     */
    public static function delete($userID)
    {
        if ($user = User::find($userID)) {

            //On bloque la suppression si l'utilisateur a des caves associées
            if ($cellars = CellarRepository::getByUser($user->id)) {
                if (sizeof($cellars) > 0) {
                    return self::error(trans('wine-supervisor::user.user_delete_error_active_cellars'));
                }
            }

            if (!$user->delete()) {
                return self::error(trans('wine-supervisor::user.database_error'));
            }
        } else {
            return self::error(trans('wine-supervisor::user.id_not_found'));
        }

        try {
            (new CellierDomesticusAPI())->disable_user($user);
        } catch (\Exception $e) {
            Log::info('API_DISABLE_USER_ERROR', [
                'user_id' => $userID,
                'cd_user_id' => $user->cd_user_id,
                'error' => $e->getMessage(),
            ]);

            return self::error(trans('wine-supervisor::generic.api_error'));
        }

        return self::success();
    }
}