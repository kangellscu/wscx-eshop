<?php

namespace App\Models;

use App\Supports\Models\Model;

class Sku extends Model
{
    const STATUS_UNSHELVE = -1;
    const STATUS_SHELVE = 1;

    static private $statusMap = [
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
        'thumbnail_path',
        'doc_specification_path',       // 说明书
        'doc_path',
        'doc_instruction_path',   // 品牌介绍
        'doc_other_path',
        'status',
        'url',
    ];

    static public function isStatusValid(int $status) : bool {
        return array_key_exists($status, self::$statusMap);
    }

    static public function statusMap() {
        return self::$statusMap;
    }

    public function statusDesc() : string {
        return array_get(self::$statusMap, $this->status, '未知状态');
    }

    //===========================
    //  Relations
    //===========================
    
    /**
     * Get the category the owns the product
     */
    public function category()
    {
        return $this->belongsTo(Category::class);
    }
}
