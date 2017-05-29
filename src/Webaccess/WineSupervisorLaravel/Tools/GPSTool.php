<?php

namespace Webaccess\WineSupervisorLaravel\Tools;

class GPSTool
{
    public static function getGPSCoordinates($complete_address)
    {
        $address = str_replace(" ", "+", $complete_address);
        $url = "http://maps.google.com/maps/api/geocode/json?sensor=false&address=$address";
        $response = file_get_contents($url);
        $json = json_decode($response, TRUE);

        return array($json['results'][0]['geometry']['location']['lat'], $json['results'][0]['geometry']['location']['lng']);
    }
}