<?php

namespace Webaccess\WineSupervisorLaravel\Services;

use Webaccess\WineSupervisorLaravel\Models\WS;

class WSService
{
    public static function getBoardTypeLabel($boardType) {
        $label = 'DEFAULT';
        switch ($boardType) {
            case WS::PRIMO_BOARD: $label = 'Primo'; break;
            case WS::SAV_BOARD: $label = 'SAV'; break;
            case WS::OUT_OF_ORDER_BOARD: $label = 'HS'; break;
            case WS::OTHER_BOARD: $label = 'Autre'; break;
        }

        return $label;
    }
}