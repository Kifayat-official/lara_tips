<?php

namespace App\Http\Controllers;

use App\Permission;
use App\Role;
use DataTables;
use Illuminate\Http\Request;

class RoleController extends CommonController
{
    public function __construct()
    {
        parent::__construct('roles', '\App\Role', [], [
            'add_permission' => 'add_role',
            'edit_permission' => 'edit_role',
            'delete_permission' => 'delete_role',
            'list_permission' => 'roles_list',
        ]);
    }

    public function dataTable()
    {
        $role = Role::query();

        if (\Auth::user()->is_super_admin != 1) {
            $role = $role->whereNotNull('level')
                ->where('level', '<=', \Auth::user()->role->level);

            // dd($user->toSql(), \Auth::user()->role->level);
        }

        return DataTables::eloquent($role)
            ->addColumn('action', function ($row) {
                $edit_button = $this->generateEditButton($row);
                $delete_button = $this->generateDeleteButton($row);

                return $edit_button . $delete_button;
            })
            ->toJson();
    }

    public function additionalDataForCreate()
    {
        return $this->additionalData();
    }

    public function additionalDataForEdit($id)
    {
        return $this->additionalData();
    }

    public function additionalData()
    {
        $permissions = \App\Permission::orderBy('order', 'asc')->get();
        return compact('permissions');
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
        request()->validate([
            'name' => 'required|unique:roles,name,' . $id,
            'level' => 'required',
        ]);
    }

    public function saveData($id)
    {

        if(\Auth::user()->is_super_admin != 1 && \Auth::user()->role->level < request()->level) 
        {
            abort(403, 'Higher level cannot be assigned to role');
        }

        $role = $id == null ? new Role() : Role::findOrFail($id);

        $role->name = request()->name;
        $role->level = request()->level;

        $role->save();

        $new_permissions_ids = [];
        if (request()->permission_id) {
            foreach (request()->permission_id as $permission_id) {
                $new_permissions_ids[] = $permission_id;

                $permission = \App\Permission::find($permission_id);
                \Auth::user()->abortIfDontHavePermission($permission->idt);
            }
        }

        
        $role->permissions()->sync($new_permissions_ids);

        // also assign parent permissions of assigned permissions
        if ($role->permissions != null) {
            foreach ($role->permissions->groupBy('parent_idt') as $parent_idt => $role_permission) {
                $parent_permission = Permission::where('idt', $parent_idt)->first();
                if ($parent_permission != null) {
                    $new_permissions_ids[] = $parent_permission->id;
                }
            }
        }
        $role->permissions()->sync($new_permissions_ids);

        return $role->id;
    }
}
