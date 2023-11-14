<?php

namespace App;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Webpatser\Uuid\Uuid;

class User extends Authenticatable
{
    use Notifiable;

    protected $primaryKey = 'id';
    protected $keyType = 'string';
    public $incrementing = false;
    
    public static function boot()
    {
        parent::boot();
        self::creating(function ($model) {
            $model->id = (string) Uuid::generate(4);
        });
    }

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];
    
    public function hasPermission($permission) {
        if($this->is_super_admin == 1) {
            return true;
        } else {
            // TODO: IMPLEMENT NON ADMIN USER FUNCTIONALITY
            //abort(403, 'You do not have permission to perform this operation');

            $matched_permission = $this->role->permissions->first(function($user_permission) use ($permission){
                return $user_permission->idt == $permission;
            });
            
            if($matched_permission != null) {
                return true;
            } else {
                return false;
            }
        }
    }

    public function abortIfDontHavePermission($permission)
    {
        if(!$this->hasPermission($permission))
        {
            abort(403, 'You do not have permission to perform this operation');
        }
    }

    public function allowedRoles()
    {
        if($this->is_super_admin == 1) {
            return \App\Role::all();
        } else {
            return \App\Role::where('level', '<=', $this->role->level)->get();
        }
    }

    public function role()
    {
        return $this->belongsTo('\App\Role', 'role_id');
    }
}
