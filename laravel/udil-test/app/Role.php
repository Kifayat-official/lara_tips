<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Webpatser\Uuid\Uuid;

class Role extends CommonUuidModel
{
    protected $table = 'roles';

    public function permissions()
    {
        return $this->belongsToMany('App\Permission', 'perm_role', 'role_id', 'perm_id');
    }
}
