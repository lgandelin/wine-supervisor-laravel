<?php

namespace Webaccess\WineSupervisorLaravel\Tools;

class GPSTool
{
    public static function getGPSCoordinates($complete_address)
    {
        $address = str_replace(" ", "+", $complete_address);
        $url = "https://maps.google.com/maps/api/geocode/json?sensor=false&address=$address&key=" . env('GOOGLE_MAPS_GEOCODING_API_KEY');
        $response = file_get_contents($url);
        $json = json_decode($response, TRUE);

        if (isset($json['results']) && isset($json['results'][0])) {
            return array($json['results'][0]['geometry']['location']['lat'], $json['results'][0]['geometry']['location']['lng']);
        }

        return array(null, null);
    }
}