<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Webpatser\Uuid\Uuid;

class Test extends CommonUuidModel
{
    public function defaultColumns()
    {
        return $this->hasMany('\App\DefaultColumn', 'table_name', 'table_name');
    }

    public function testGroup()
    {
        return $this->belongsTo('\App\TestGroup');
    }

    public function testType()
    {
        return $this->belongsTo('\App\TestType');
    }
}
