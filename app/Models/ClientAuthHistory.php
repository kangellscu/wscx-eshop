<?php

namespace App\Models;

use App\Supports\Models\Model;

class ClientAuthHistory extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'client_id',        // client id
        'comment',          // auth comment
        'auth_begin_date',
        'auth_end_date',
    ];

    /**
     * The attributes that should be mutated to dates.
     *
     * @var array
     */
    protected $dates = ['auth_begin_date', 'auth_end_date'];
}
