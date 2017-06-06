<?php

namespace Webaccess\WineSupervisorLaravel\Models;

use Illuminate\Database\Eloquent\Model;

class CellarHistory extends Model
{
    protected $table = 'cellar_history';
    public $incrementing = false;
    public $casts = [
        'id' => 'string'
    ];

    protected $fillable = [
        'column',
        'old_value',
        'new_value',
        'admin_id',
        'user_id',
        'cellar_id',
    ];

    public function admin()
    {
        return $this->belongsTo('Webaccess\WineSupervisorLaravel\Models\Administrator');
    }

    public function user()
    {
        return $this->belongsTo('Webaccess\WineSupervisorLaravel\Models\User');
    }

    public function cellar()
    {
        return $this->belongsTo('Webaccess\WineSupervisorLaravel\Models\Cellar');
    }
}