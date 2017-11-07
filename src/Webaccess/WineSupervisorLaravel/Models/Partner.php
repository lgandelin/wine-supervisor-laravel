<?php

namespace Webaccess\WineSupervisorLaravel\Models;

use Illuminate\Database\Eloquent\Model;

class Partner extends Model
{
    protected $table = 'partners';
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
        'name',
        'image',
        'url',
        'is_active',
        'display_start_date',
        'display_end_date',
    ];
}