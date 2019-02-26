<?php

namespace App\Models;

use App\Supports\Models\Model;

class Sku extends Model
{
    const STATUS_UNSHELVE = -1;
    const STATUS_SHELVE = 1;

    static public $statusMap = [
        self::STATUS_UNSHELVE => '已下架',
        self::STATUS_SHELVE => '已上架',
    ];

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'brand_id',
        'category_id',
        'brief_description',
        'thumbnail_url',
        'status',
    ];

    static public function isStatusValid(int $status) : bool {
        return array_key_exists($status, self::$statusMap);
    }

    public function statusDesc() : string {
        return array_get($statusMap, $this->status, '未知状态');
    }
}
