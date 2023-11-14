<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Test;
use Webpatser\Uuid\Uuid;

class TestProfile extends CommonUuidModel
{
    protected $table = 'test_profiles';

    public function tests()
    {
        return $this->belongsToMany('App\Test', 'test_profile_tests', 'test_profile_id', 'test_id')->withPivot('id');
    }
}
