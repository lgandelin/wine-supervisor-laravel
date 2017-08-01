<?php

namespace Webaccess\WineSupervisorLaravel\Models;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;

class Technician extends Authenticatable
{
    use Notifiable;

    const STATUS_DISABLED = 0;
    const STATUS_ENABLED = 1;

    protected $table = 'technicians';
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
        'first_name',
        'last_name',
        'company',
        'registration',
        'email',
        'phone',
        'address',
        'address2',
        'zipcode',
        'city',
        'country',
        'status',
        'last_connection_date',
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
