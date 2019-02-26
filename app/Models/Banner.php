<?php

namespace App\Models;

use App\Supports\Models\Model;

class Banner extends Model
{
    const STATUS_ACTIVE = 1;
    const STATUS_DEACTIVE = -1;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'image_url',
        'begin_time',
        'end_time',
        'status',
    ];

    /**
     * The attributes that should be mutated to dates.
     *
     * @var array
     */
    protected $dates = ['begin_time', 'end_time'];
}
