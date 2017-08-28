<?php

namespace Webaccess\WineSupervisorLaravel\Tools;

class PasswordTool
{
    /**
     * @param int $length
     * @return string
     */
    public static function generatePassword($length = 8)
    {
        $chars = 'abcdefghkmnpqrstuvwxyz23456789';
        $count = mb_strlen($chars);

        for ($i = 0, $result = ''; $i < $length; ++$i) {
            $index = rand(0, $count - 1);
            $result .= mb_substr($chars, $index, 1);
        }

        return $result;
    }
}