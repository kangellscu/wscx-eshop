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
        'logo_path',
        'story',
    ];

    /**
     * Set the name_capital, make sure the value be capitalized
     *
     * @param string    $value
     *
     * @return void
     */
    public function setNameCapitalAttribute($value) {
        $this->attributes['name_capital'] = strtoupper($value);
    }
}
