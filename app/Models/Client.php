<?php

namespace App\Models;

use App\Supports\Models\Model;

class Client extends Model
{
    const STATUS_INIT = 1;
    const STATUS_ACTIVE = 2;

    static public $statusMap = [
        self::STATUS_INIT   => '待激活',
        self::STATUS_ACTIVE => '已激活',
    ];

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'serial_no',        // client software serial_no, eg: F001
        'client_name',      // edited by admin
        'mac_address',      // mac address of pc on which client running
        'disk_serial_no',   // disk serial no
        'auth_begin_date',
        'auth_end_date',
        'status',
    ];

    /**
     * The attributes that should be mutated to dates.
     *
     * @var array
     */
    protected $dates = ['auth_begin_date', 'auth_end_date'];

    public function statusDesc()
    {
        return array_get(self::$statusMap, $this->status, '未知');
    }

    /**
     * Indicate whether client aready activated or not
     *
     * @return bool
     */
    public function isActivate() : bool
    {
        return $this->status == self::STATUS_ACTIVE;
    }

    /**
     * Activate client
     */
    public function activate() : Client
    {
        $this->status = self::STATUS_ACTIVE;
        return $this;
    }
}
