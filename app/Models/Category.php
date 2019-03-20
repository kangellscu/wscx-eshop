<?php

namespace App\Models;

use App\Supports\Models\Model;

class Category extends Model
{
    const DISPLAY_ORDER_STEP = 10;
    const TOP_CATEGORY_LEVEL = 1;
    const SUB_CATEGORY_LEVEL = 11;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'parent_id',
        'display_order',
        'level',
    ];

    static public function nextLevel(int $level) {
        return $level + self::DISPLAY_ORDER_STEP;
    }

    /**
     * =============================
     *      Relation
     * =============================
     */
    public function products() {
        return $this->hasMany(Sku::class, 'category_id', 'id');
    }
}
