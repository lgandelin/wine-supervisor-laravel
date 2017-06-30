<?php

namespace Webaccess\WineSupervisorLaravel\Repositories;

use DateTime;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Ramsey\Uuid\Uuid;
use Webaccess\WineSupervisorLaravel\Models\Administrator;
use Webaccess\WineSupervisorLaravel\Models\User;

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
     * @param $firstName
     * @param $lastName
     * @param $email
     * @param $phone
     * @param $login
     * @param $password
     * @param $opt_in
     * @return User
     */
    public static function create($firstName, $lastName, $email, $phone, $login, $password, $opt_in)
    {
        if (!self::checkLogin(null, $login)) {
            return self::error(trans('wine-supervisor::signup.user_existing_login_error'));
        }

        $user = new User();
        $user->id = Uuid::uuid4()->toString();
        $user->first_name = $firstName;
        $user->last_name = $lastName;
        $user->email = $email;
        $user->phone = $phone;
        $user->login = $login;
        $user->password = Hash::make($password);
        $user->opt_in = $opt_in;
        $user->last_connection_date = new DateTime();

        if (!$user->save()) {
            return self::error(trans('wine-supervisor::signup.create_user_error'));
        }

        return self::success($user->id);
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
     * @param $email
     * @param $login
     * @param $password
     * @param $opt_in
     * @return User
     */
    public static function update($userID, $firstName, $lastName, $email, $login, $password, $opt_in)
    {
        if (!self::checkLogin($userID, $login)) {
            return self::error(trans('wine-supervisor::signup.user_existing_login_error'));
        }

        //TODO : CALL CDO

        if ($user = User::find($userID)) {
            $user->first_name = $firstName;
            $user->last_name = $lastName;
            $user->email = $email;
            $user->login = $login;
            if ($password !== null) $user->password = Hash::make($password);
            $user->opt_in = $opt_in;

            if (!$user->save())
                return self::error(trans('wine-supervisor::user.database_error'));
        } else {
            return self::error(trans('wine-supervisor::user.user_not_found'));
        }

        return self::success();
    }

    /**
     * @param $userID
     * @param $login
     * @return bool
     */
    public static function checkLogin($userID, $login)
    {
        $existingUser = User::where('login', '=', $login);

        if ($userID) {
            $existingUser->where('id', '!=', $userID);
        }

        if ($existingUser->first()) {
            return false;
        }

        return true;
    }
}