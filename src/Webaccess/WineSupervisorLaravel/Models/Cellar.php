<?php

namespace Webaccess\WineSupervisorLaravel\Models;

class Cellar
{
    protected $table = 'cellars';
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
        'id_ws',
        'name',
        'user_id',
        'technician_id',
        'first_activation_date',
        'subscription_start_date',
        'subscription_end_date',
        'serial_number',
        'subscription_type',
        'address',
        'zipcode',
        'city',
        'latitude',
        'longitude'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];
}
