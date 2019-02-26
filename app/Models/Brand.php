<?php

namespace App\Models;

use Illuminate\Database\Eloquent\SoftDeletes;
use App\Supports\Models\Model;

class Brand extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'name_capital',
        'logo_url',
        'story',
    ];
}
