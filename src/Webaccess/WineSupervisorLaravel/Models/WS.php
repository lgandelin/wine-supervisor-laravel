<?php

namespace Webaccess\WineSupervisorLaravel\Models;

use Illuminate\Database\Eloquent\Model;

class WS extends Model
{
    const PRIMO_BOARD = 1;
    const SAV_BOARD = 2;
    const OUT_OF_ORDER_BOARD = 3;
    const DEUXIO_BOARD = 5;

    protected $table = 'ws';
    public $incrementing = false;
    public $casts = [
        'id' => 'string'
    ];

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'board_type',
        'activation_code',
        'first_activation_date',
        'deactivation_date',
    ];
}