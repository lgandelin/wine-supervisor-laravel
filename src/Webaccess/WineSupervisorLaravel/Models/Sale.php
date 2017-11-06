<?php

namespace Webaccess\WineSupervisorLaravel\Models;

use Illuminate\Database\Eloquent\Model;

class Sale extends Model
{
    protected $table = 'sales';
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
        'is_active',
        'title',
        'jury_note',
        'jury_opinion',
        'description',
        'image',
        'start_date',
        'end_date'
    ];
}