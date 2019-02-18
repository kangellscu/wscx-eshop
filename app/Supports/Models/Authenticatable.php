<?php

namespace App\Supports\Models;

use Ramsey\Uuid\Uuid;
use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as BaseAuthenticatable;

class Authenticatable extends BaseAuthenticatable
{
    use Notifiable;

   /**  
    * Indicates if the IDs are auto-incrementing.  
    * 
    * @var bool  
    */    
    public $incrementing = false;  

    protected static function boot()
    {
        parent::boot();

        // auto generate uuid for pk: id when create new model
        self::creating(function ($model) {
            $model->id = self::genUuid();
        });
    }

    protected static function genUuid()
    {
        return Uuid::uuid4()->toString();
    }
}
