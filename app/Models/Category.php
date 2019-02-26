<?php

namespace App\Models;

use App\Supports\Models\Model;

class Category extends Model
{
    const LEVEL_TOP = 1;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'parent_id',
        'level',            // 数字越小，分类越细
    ];
}
