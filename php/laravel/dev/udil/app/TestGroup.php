<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class TestGroup extends CommonUuidModel
{
    public function tests()
    {
        return $this->hasMany('\App\Test')->orderBy('order','asc');
    }
}
