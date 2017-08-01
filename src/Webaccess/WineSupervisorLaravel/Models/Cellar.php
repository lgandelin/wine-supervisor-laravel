<?php

namespace Webaccess\WineSupervisorLaravel\Models;

use Illuminate\Database\Eloquent\Model;

class Cellar extends Model
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
        'longitude',
        'cd_cellar_id',
    ];

    public function user()
    {
        return $this->belongsTo('Webaccess\WineSupervisorLaravel\Models\User');
    }

    public function technician()
    {
        return $this->belongsTo('Webaccess\WineSupervisorLaravel\Models\Technician');
    }

    public function history()
    {
        return $this->hasMany('Webaccess\WineSupervisorLaravel\Models\CellarHistory')->orderBy('created_at', 'desc');
    }
}
