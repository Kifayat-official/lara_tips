<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Webpatser\Uuid\Uuid;

class CommonUuidModel extends Model
{
    protected $primaryKey = 'id';
    protected $keyType = 'string';
    public $incrementing = false;
    protected static $setCreatedBy = true;
    protected static $setUpdatedBy = true;
    
    public static function boot()
    {
        parent::boot();
        self::creating(function ($model) {
            $model->id = (string) Uuid::generate(4);

            if(self::$setCreatedBy)
            {
                $model->created_by = \Auth::user()->id;
            }
        });

        self::updating(function($model) {
            if(self::$setUpdatedBy)
            {
                $model->updated_by = \Auth::user()->id;
            }
        });
    }
}
