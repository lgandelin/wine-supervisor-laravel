<?php

namespace Webaccess\WineSupervisorLaravel\Repositories;

class BaseRepository
{
    /**
     * @param null $result
     * @return array
     */
    public static function success($result = null) {
        return array(true, null, $result);
    }

    /**
     * @param $message
     * @return array
     */
    public static function error($message) {
        return array(false, $message);
    }
}