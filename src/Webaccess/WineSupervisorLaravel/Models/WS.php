<?php

namespace Webaccess\WineSupervisorLaravel\Models;

use Illuminate\Database\Eloquent\Model;

class WS extends Model
{
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
        'first_activation_date',
        'deactivation_date',
    ];
}