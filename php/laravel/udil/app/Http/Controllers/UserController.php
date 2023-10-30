<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DataTables;
use App\User;
use App\mdcSelection;
use Webpatser\Uuid\Uuid;
use Illuminate\Support\Facades\Hash;

class UserController extends CommonController
{
    function __construct() {
        parent::__construct('users', '\App\User', [], [
            'add_permission' => 'add_user',
            'edit_permission' => 'edit_user',
            'delete_permission' => 'delete_user',
            'list_permission' => 'users_list',
        ]);
    }

    public function dataTable()
    {
        $user = User::with(['role']);

        if(\Auth::user()->is_super_admin != 1)
        {
            $user = $user->whereHas('role', function($role) {
                return $role->whereNotNull('level')
                ->where('level', '<=', \Auth::user()->role->level);
            });

            // dd($user->toSql(), \Auth::user()->role->level);
        }

        return DataTables::eloquent($user)
            ->addColumn('action', function($row){
                $edit_button = $this->generateEditButton($row);
                $delete_button = $this->generateDeleteButton($row);

                return $edit_button . $delete_button;
            })
            ->editColumn('is_super_admin', function($user){
                return $user->is_super_admin == 1 ? '<label class="label label-success">Yes</label>' :
                    '<label class="label label-danger">No</label>';
            })
            ->editColumn('status', function($user){
                return $user->status == 1 ? '<label class="label label-success">Activated</label>' :
                    '<label class="label label-danger">Deactivated</label>';
            })
            ->rawColumns(['is_super_admin', 'action', 'status'])
            ->toJson();
    }

    public function additionalDataForCreate()
    {
        return $this->additionalData();
    }

    public function additionalDataForEdit($id)
    {
        return $this->additionalDataEdit($id);
    }

    public function additionalData()
    {
        $roles = \Auth::user()->allowedRoles();
        return compact('roles');
    }

    public function additionalDataEdit($id)
    {
        $mdc_selection_id_array=[];
        $roles = \Auth::user()->allowedRoles();
        $mdc_selection_id = \App\mdcSelection::where('role_id',$id)->get()->toArray();
        foreach($mdc_selection_id as $mdc)
        {
            foreach($mdc as $key=>$value)
            {
                if($key=='mdc_id'){
                    $mdc_selection_id_array[]=$value;
                }

            }

        }
        return compact('roles','mdc_selection_id_array');
    }

    public function storeData()
    {
        return $this->saveData(null);
    }

    public function updateData($id)
    {
        return $this->saveData($id);
    }

    public function validateRequest($id)
    {
        if($id == null){
            request()->validate([
                'name' => 'required',
                'password' => 'required|confirmed'
            ]);
        }else{
            request()->validate([
                'name' => 'required',
            ]);
        }

    }

    public function saveData($id)
    {
        $user = $id == null ? new User() : User::findOrFail($id);
        $user->name = request()->name;
        $user->email = request()->email;
        $user->is_super_admin = request()->is_super_admin == null ? 0 : request()->is_super_admin;

        if($user->is_super_admin == 0 && (request()->role == '' || request()->role == null))
        {
            throw new \Exception("Please specify Role", 1);
        }

        $user->role_id = $user->is_super_admin == 1 ? null : request()->role;
        $user->status = request()->status;

        if(request()->password != '') {
            $user->password = Hash::make(request()->password);
        }
        $user->save();

        if(request()->mdc_session_id){
            foreach(request()->mdc_session_id as $mdc)
            {
                $mdc_select = new mdcSelection();
                $mdc_select->id = Uuid::generate();
                $mdc_select->role_id =$user->id;
                $mdc_select->mdc_id = $mdc;
                $mdc_select->save();
            }
        }
        return $user->id;
    }
}
