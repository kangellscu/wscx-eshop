<?php

namespace App\Models;

use App\Supports\Models\Model;

class UserComment extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'phone',
        'email',
        'comment',
    ];
}
