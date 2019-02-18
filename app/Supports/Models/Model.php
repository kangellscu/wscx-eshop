<?php

namespace App\Supports\Models;

use Ramsey\Uuid\Uuid;
use Illuminate\Database\Eloquent\Model as BaseModel;

class Model extends BaseModel
{
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
