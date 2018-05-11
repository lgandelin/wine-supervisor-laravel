<?php

namespace Webaccess\WineSupervisorLaravel\Models;

use Illuminate\Database\Eloquent\Model;

class SaleAccessory extends Model
{
    protected $table = 'sales_accessories';
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
        'title_en',
        'accessories',
        'accessories_en',
        'link',
        'link_history',
        'comments',
        'comments_en',
        'image',
        'start_date',
        'end_date'
    ];
}