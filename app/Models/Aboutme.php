<?php

namespace App;

use App\Supports\Models\Model;

class Aboutme extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'image_path',
    ];
}
